# Accounting Foundation & Auto-Provisioning System - Design Document
**Spec ID:** ACC-FND-001  
**Version:** 1.0  
**Status:** Design Phase  
**Created:** March 14, 2026  
**Based on:** Requirements v1.0

## 1. System Architecture Overview

### 1.1 High-Level Architecture
```
┌─────────────────────────────────────────────────────────────┐
│                    TimberPro Application                     │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐         │
│  │   Accounts  │  │ Transactions│  │   Reports   │         │
│  │   Module    │  │   Module    │  │   Module    │         │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘         │
│         │                │                 │                │
├─────────┼────────────────┼─────────────────┼────────────────┤
│         │                │                 │                │
│  ┌──────▼──────┐  ┌──────▼──────┐  ┌──────▼──────┐         │
│  │ Accounts    │  │ Transactions│  │ Financial   │         │
│  │ Controller  │  │ Controller  │  │ Controller  │         │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘         │
│         │                │                 │                │
├─────────┼────────────────┼─────────────────┼────────────────┤
│         │                │                 │                │
│  ┌──────▼──────┐  ┌──────▼──────┐  ┌──────▼──────┐         │
│  │ Accounts    │  │ Transactions│  │ Reports     │         │
│  │ Model       │  │ Model       │  │ Model       │         │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘         │
│         │                │                 │                │
└─────────┼────────────────┼─────────────────┼────────────────┘
          │                │                 │
          ▼                ▼                 ▼
┌─────────────────────────────────────────────────────────────┐
│                    Database Layer                           │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  geopos_accounts (enhanced)                         │   │
│  │  tp_general_ledger (new)                            │   │
│  │  geopos_transactions (existing)                     │   │
│  └─────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

### 1.2 Component Relationships
- **Accounts Module**: Handles account creation, auto-provisioning, and management
- **Transactions Module**: Manages double-entry recording and ledger updates
- **Reports Module**: Generates financial statements using new ledger structure
- **Database Layer**: Enhanced schema with new tables and relationships

## 2. Database Schema Design

### 2.1 Enhanced `geopos_accounts` Table
```sql
-- Current structure with enhancements
ALTER TABLE geopos_accounts 
ADD COLUMN is_private BOOLEAN DEFAULT TRUE AFTER account_type,
ADD COLUMN offset_account_id INT DEFAULT NULL AFTER is_private,
ADD COLUMN created_by INT DEFAULT NULL AFTER offset_account_id,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER adate;

-- Add foreign key constraint for offset accounts
ALTER TABLE geopos_accounts 
ADD CONSTRAINT fk_offset_account 
FOREIGN KEY (offset_account_id) REFERENCES geopos_accounts(id) 
ON DELETE SET NULL;

-- Add index for performance
CREATE INDEX idx_accounts_loc_type ON geopos_accounts(loc, account_type, is_private);
CREATE INDEX idx_accounts_created_by ON geopos_accounts(created_by);
```

### 2.2 New `tp_general_ledger` Table
```sql
CREATE TABLE tp_general_ledger (
    id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_id VARCHAR(50) NOT NULL COMMENT 'Unique transaction identifier (e.g., TRX-2026-0001)',
    account_id INT NOT NULL COMMENT 'References geopos_accounts.id',
    debit DECIMAL(16,2) DEFAULT 0.00,
    credit DECIMAL(16,2) DEFAULT 0.00,
    balance DECIMAL(16,2) DEFAULT 0.00 COMMENT 'Running balance for this account after this entry',
    loc INT NOT NULL COMMENT 'Location ID for access control',
    user_id INT NOT NULL COMMENT 'User who created the entry',
    reference_type ENUM('invoice', 'expense', 'transfer', 'journal', 'opening') DEFAULT 'journal',
    reference_id INT DEFAULT NULL COMMENT 'ID of source document',
    note TEXT COMMENT 'Transaction description',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Foreign keys
    FOREIGN KEY (account_id) REFERENCES geopos_accounts(id),
    FOREIGN KEY (user_id) REFERENCES geopos_users(id),
    
    -- Indexes for performance
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_account_loc (account_id, loc),
    INDEX idx_created_at (created_at),
    INDEX idx_reference (reference_type, reference_id),
    INDEX idx_user_loc (user_id, loc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2.3 Data Migration Strategy
```sql
-- Migration script to create initial ledger entries from existing transactions
INSERT INTO tp_general_ledger (
    transaction_id, account_id, debit, credit, balance, loc, user_id, 
    reference_type, reference_id, note, created_at
)
SELECT 
    CONCAT('MIG-', t.id) as transaction_id,
    t.acid as account_id,
    t.debit,
    t.credit,
    -- Calculate running balance per account
    (SELECT SUM(t2.credit - t2.debit) 
     FROM geopos_transactions t2 
     WHERE t2.acid = t.acid AND t2.id <= t.id) as balance,
    t.loc,
    t.eid as user_id,
    CASE 
        WHEN t.type = 'Income' THEN 'invoice'
        WHEN t.type = 'Expense' THEN 'expense'
        WHEN t.type = 'Transfer' THEN 'transfer'
        ELSE 'journal'
    END as reference_type,
    t.id as reference_id,
    t.note,
    t.date
FROM geopos_transactions t
ORDER BY t.acid, t.date, t.id;
```

## 3. Core Algorithm Design

### 3.1 Automatic Account Provisioning Algorithm
```php
/**
 * Algorithm: create_account_with_offset
 * Input: $holder, $account_type, $initial_balance, $acode, $user_id, $loc
 * Output: Array with primary_account_id and offset_account_id
 */
function create_account_with_offset($holder, $account_type, $initial_balance, $acode, $user_id, $loc) {
    // Step 1: Generate unique account numbers
    $primary_acn = generate_account_number($account_type, $loc);
    $offset_acn = $primary_acn . '-OFFSET';
    
    // Step 2: Determine offset account type
    $offset_type = get_offset_account_type($account_type);
    
    // Step 3: Create primary account
    $primary_data = [
        'acn' => $primary_acn,
        'holder' => $holder,
        'adate' => date('Y-m-d H:i:s'),
        'lastbal' => $initial_balance,
        'code' => $acode,
        'loc' => $loc,
        'account_type' => $account_type,
        'is_private' => true,
        'created_by' => $user_id
    ];
    
    $this->db->insert('geopos_accounts', $primary_data);
    $primary_id = $this->db->insert_id();
    
    // Step 4: Create offset account
    $offset_data = [
        'acn' => $offset_acn,
        'holder' => $holder . ' - Offset',
        'adate' => date('Y-m-d H:i:s'),
        'lastbal' => 0.00,
        'code' => 'Offset for ' . $acode,
        'loc' => $loc,
        'account_type' => $offset_type,
        'is_private' => true,
        'created_by' => $user_id,
        'offset_account_id' => $primary_id
    ];
    
    $this->db->insert('geopos_accounts', $offset_data);
    $offset_id = $this->db->insert_id();
    
    // Step 5: Update primary account with offset reference
    $this->db->where('id', $primary_id);
    $this->db->update('geopos_accounts', ['offset_account_id' => $offset_id]);
    
    // Step 6: Create opening balance ledger entry if initial_balance > 0
    if ($initial_balance > 0) {
        create_opening_balance_entry($primary_id, $initial_balance, $user_id, $loc);
    }
    
    return ['primary_id' => $primary_id, 'offset_id' => $offset_id];
}

/**
 * Helper: get_offset_account_type
 * Maps primary account type to appropriate offset type
 */
function get_offset_account_type($primary_type) {
    $mapping = [
        'Asset' => 'Equity',
        'Liability' => 'Equity',
        'Income' => 'Equity',
        'Expense' => 'Equity',
        'Equity' => 'Asset',
        'Basic' => 'Equity'
    ];
    return $mapping[$primary_type] ?? 'Equity';
}
```

### 3.2 Zero-Leakage Double Entry Algorithm
```php
/**
 * Algorithm: record_double_entry
 * Ensures every transaction has balanced debit and credit entries
 */
function record_double_entry($debit_account_id, $credit_account_id, $amount, $note, $user_id, $loc, $reference_type = 'journal', $reference_id = 0) {
    // Step 1: Validate accounts exist and user has access
    if (!validate_account_access($debit_account_id, $user_id, $loc) || 
        !validate_account_access($credit_account_id, $user_id, $loc)) {
        throw new Exception('Account access denied');
    }
    
    // Step 2: Generate unique transaction ID
    $transaction_id = generate_transaction_id();
    
    // Step 3: Start database transaction
    $this->db->trans_start();
    
    try {
        // Step 4: Record debit entry
        $debit_balance = get_account_balance($debit_account_id) + $amount;
        $debit_entry = [
            'transaction_id' => $transaction_id,
            'account_id' => $debit_account_id,
            'debit' => $amount,
            'credit' => 0.00,
            'balance' => $debit_balance,
            'loc' => $loc,
            'user_id' => $user_id,
            'reference_type' => $reference_type,
            'reference_id' => $reference_id,
            'note' => $note
        ];
        $this->db->insert('tp_general_ledger', $debit_entry);
        
        // Step 5: Record credit entry
        $credit_balance = get_account_balance($credit_account_id) - $amount;
        $credit_entry = [
            'transaction_id' => $transaction_id,
            'account_id' => $credit_account_id,
            'debit' => 0.00,
            'credit' => $amount,
            'balance' => $credit_balance,
            'loc' => $loc,
            'user_id' => $user_id,
            'reference_type' => $reference_type,
            'reference_id' => $reference_id,
            'note' => $note
        ];
        $this->db->insert('tp_general_ledger', $credit_entry);
        
        // Step 6: Update account balances
        $this->db->set('lastbal', "lastbal + $amount", false);
        $this->db->where('id', $debit_account_id);
        $this->db->update('geopos_accounts');
        
        $this->db->set('lastbal', "lastbal - $amount", false);
        $this->db->where('id', $credit_account_id);
        $this->db->update('geopos_accounts');
        
        // Step 7: Maintain backward compatibility with existing transactions table
        $this->record_legacy_transaction($debit_account_id, $credit_account_id, $amount, $note, $user_id, $loc, $transaction_id);
        
        $this->db->trans_complete();
        
        return $transaction_id;
        
    } catch (Exception $e) {
        $this->db->trans_rollback();
        throw $e;
    }
}
```

## 4. Security & Access Control Design

### 4.1 Location-Based Access Control
```php
/**
 * Security: apply_location_filter
 * Applies location-based filtering to all accounting queries
 */
class Accounting_model extends CI_Model {
    
    protected function apply_location_filter($field = 'loc') {
        $user = $this->aauth->get_user();
        
        // Super admin sees all
        if ($user->roleid == 1) {
            return;
        }
        
        // Business owners see their location + public (loc=0)
        if ($user->loc) {
            $this->db->group_start();
            $this->db->where($field, $user->loc);
            $this->db->or_where($field, 0);
            $this->db->group_end();
        } else {
            // Service providers see only public accounts
            $this->db->where($field, 0);
        }
    }
    
    /**
     * Enhanced: apply_account_visibility_filter
     * Filters accounts based on privacy settings
     */
    protected function apply_account_visibility_filter() {
        $user = $this->aauth->get_user();
        
        $this->apply_location_filter('loc');
        
        // Non-admin users cannot see private accounts they didn't create
        if ($user->roleid != 1) {
            $this->db->group_start();
            $this->db->where('is_private', false);  // Public accounts
            $this->db->or_where('created_by', $user->id);  // Their own private accounts
            $this->db->group_end();
        }
    }
}
```

### 4.2 Transaction Validation Rules
```php
/**
 * Validation: validate_transaction_parameters
 * Ensures all transactions meet business rules
 */
function validate_transaction_parameters($debit_account_id, $credit_account_id, $amount, $user_id, $loc) {
    $errors = [];
    
    // Rule 1: Amount must be positive
    if ($amount <= 0) {
        $errors[] = 'Transaction amount must be greater than zero';
    }
    
    // Rule 2: Debit and credit accounts must be different
    if ($debit_account_id == $credit_account_id) {
        $errors[] = 'Debit and credit accounts cannot be the same';
    }
    
    // Rule 3: Accounts must exist and be active
    $debit_account = $this->get_account_details($debit_account_id);
    $credit_account = $this->get_account_details($credit_account_id);
    
    if (!$debit_account || !$credit_account) {
        $errors[] = 'One or more accounts do not exist';
    }
    
    // Rule 4: User must have access to both accounts
    if (!has_account_access($user_id, $debit_account_id, $loc) || 
        !has_account_access($user_id, $credit_account_id, $loc)) {
        $errors[] = 'Insufficient permissions for one or more accounts';
    }
    
    // Rule 5: Account types must be compatible
    if (!are_account_types_compatible($debit_account['account_type'], $credit_account['account_type'])) {
        $errors[] = 'Account types are not compatible for this transaction';
    }
    
    return $errors;
}
```

## 5. Integration Design

### 5.1 Backward Compatibility Layer
```php
/**
 * Integration: record_legacy_transaction
 * Maintains compatibility with existing system
 */
function record_legacy_transaction($debit_account_id, $credit_account_id, $amount, $note, $user_id, $loc, $transaction_id) {
    // Get account details for legacy system
    $debit_account = $this->get_account_details($debit_account_id);
    $credit_account = $this->get_account_details($credit_account_id);
    
    // Record debit in legacy transactions table
    $debit_legacy = [
        'payerid' => 0,
        'payer' => 'System',
        'acid' => $debit_account_id,
        'account' => $debit_account['holder'],
        'date' => date('Y-m-d'),
        'debit' => $amount,
        'credit' => 0,
        'type' => 'Expense',
        'cat' => 'Journal Entry',
        'method' => 'Journal',
        'eid' => $user_id,
        'note' => $transaction_id . ' - ' . $note,
        'ext' => 0,
        'loc' => $loc,
        'link_id' => 0
    ];
    $this->db->insert('geopos_transactions', $debit_legacy);
    
    // Record credit in legacy transactions table
    $credit_legacy = [
        'payerid' => 0,
        'payer' => 'System',
        'acid' => $credit_account_id,
        'account' => $credit_account['holder'],
        'date' => date('Y-m-d'),
        'debit' => 0,
        'credit' => $amount,
        'type' => 'Income',
        'cat' => 'Journal Entry',
        'method' => 'Journal',
        'eid' => $user_id,
        'note' => $transaction_id . ' - ' . $note,
        'ext' => 0,
        'loc' => $loc,
        'link_id' => 0
    ];
    $this->db->insert('geopos_transactions', $credit_legacy);
}
```

### 5.2 API Endpoint Design
```php
/**
 * API: /api/v1/accounts/create
 * Creates account with auto-provisioning
 */
public function create_account() {
    $this->load->library('form_validation');
    
    // Validate input
    $this->form_validation->set_rules('holder', 'Account Holder', 'required|max_length[100]');
    $this->form_validation->set_rules('account_type', 'Account Type', 'required|in_list[Asset,Liability,Equity,Income,Expense,Basic]');
    $this->form_validation->set_rules('initial_balance', 'Initial Balance', 'numeric');
    $this->form_validation->set_rules('code', 'Account Code', 'max_length[30]');
    
    if ($this->form_validation->run() == FALSE) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(['errors' => $this->form_validation->error_array()]));
    }
    
    try {
        $user_id = $this->aauth->get_user()->id;
        $loc = $this->aauth->get_user()->loc ?: 0;
        
        $result = $this->accounts_model->create_account_with_offset(
            $this->input->post('holder'),
            $this->input->post('account_type'),
            $this->input->post('initial_balance', 0),
            $this->input->post('code', ''),
            $user_id,
            $loc
        );
        
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(201)
            ->set_output(json_encode([
                'success' => true,
                'message' => 'Account created successfully with offset account',
                'data' => $result
            ]));
            
    } catch (Exception $e) {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(500)
            ->set_output(json_encode([
                'success' => false,
                'message' => 'Account creation failed: ' . $e->getMessage()
            ]));
    }
}
```

## 6. Performance Optimization

### 6.1 Database Indexing Strategy
```sql
-- Critical indexes for performance
CREATE INDEX idx_ledger_account_date ON tp_general_ledger(account_id, created_at);
CREATE INDEX idx_ledger_loc_date ON tp_general_ledger(loc, created_at);
CREATE INDEX idx_ledger_transaction ON tp_general_ledger(transaction_id, account_id);

-- Materialized view for frequent balance queries
CREATE VIEW account_balances AS
SELECT 
    a.id as account_id,
    a.holder,
    a.account_type,
    a.loc,
    a.is_private,
    COALESCE(l.balance, 0) as current_balance,
    l.created_at as last_transaction_date
FROM geopos_accounts a
LEFT JOIN (
    SELECT account_id, balance, created_at,
           ROW_NUMBER() OVER (PARTITION BY account_id ORDER BY created_at DESC) as rn
    FROM tp_general_ledger
) l ON a.id = l.account_id AND l.rn = 1;
```

### 6.2 Caching Strategy
```php
/**
 * Performance: cached_account_balance
 * Implements 5-minute cache for frequently accessed balances
 */
function get_cached_account_balance($account_id) {
    $cache_key = 'account_balance_' . $account_id;
    
    // Try to get from cache first
    $cached_balance = $this->cache->get($cache_key);
    if ($cached_balance !== false) {
        return $cached_balance;
    }
    
    // Calculate fresh balance
    $this->db->select('balance');
    $this->db->from('tp_general_ledger');
    $this->db->where('account_id', $account_id);
    $this->db->order_by('created_at', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();
    
    $balance = $query->row() ? $query->row()->balance : 0;
    
    // Cache for 5 minutes
    $this->cache->save($cache_key, $balance, 300);
    
    return $balance;
}
```

## 7. Error Handling & Logging

### 7.1 Comprehensive Error Handling
```php
/**
 * Error Handling: transaction_error_handler
 * Centralized error handling for accounting operations
 */
class Accounting_error_handler {
    
    public static function handle_transaction_error($exception, $transaction_data) {
        // Log error with context
        log_message('error', 'Accounting transaction failed: ' . $exception->getMessage());
        log_message('debug', 'Transaction data: ' . json_encode($transaction_data));
        
        // Determine error type and response
        if ($exception instanceof Database_exception) {
            return [
                'type' => 'database_error',
                'message' => 'Database operation failed. Please try again.',
                'user_message' => 'System error. Please contact support.',
                'retryable' => true
            ];
        } elseif ($exception instanceof Validation_exception) {
            return [
                'type' => 'validation_error',
                'message' => $exception->getMessage(),
                'user_message' => $exception->getMessage(),
                'retryable' => false
            ];
        } elseif ($exception instanceof Access_denied_exception) {
            return [
                'type' => 'access_denied',
                'message' => 'User does not have permission for this operation',
                'user_message' => 'You do not have permission to perform this action.',
                'retryable' => false
            ];
        } else {
            return [
                'type' => 'unknown_error',
                'message' => 'An unexpected error occurred',
                'user_message' => 'An unexpected error occurred. Please try again.',
                'retryable' => true
            ];
        }
    }
}
```

## 8. Deployment Strategy

### 8.1 Phased Rollout Plan
1. **Phase 1**: Database schema changes (non-breaking)
2. **Phase 2**: Core algorithms in shadow mode (log only, no writes)
3. **Phase 3**: Dual-write mode (write to both old and new systems)
4. **Phase 4**: Read from new system, verify consistency
5. **Phase 5**: Full cutover to new system
6. **Phase 6**: Decommission legacy code paths

### 8.2 Rollback Procedures
```sql
-- Rollback script for emergency situations
-- Step 1: Disable new features
UPDATE univarsal_api SET key1 = 0 WHERE id = 65; -- Disable dual entry

-- Step 2: Remove new table (if empty)
DROP TABLE IF EXISTS tp_general_ledger_backup;
CREATE TABLE tp_general_ledger_backup AS SELECT * FROM tp_general_ledger;
DROP TABLE IF EXISTS tp_general_ledger;

-- Step 3: Remove new columns from accounts table
ALTER TABLE geopos_accounts 
DROP COLUMN is_private,
DROP COLUMN offset_account_id,
DROP COLUMN created_by,
DROP COLUMN updated_at;

-- Step 4: Restore from backup if needed
-- (Backup created during migration)
```

## 9. Testing Strategy

### 9.1 Property-Based Testing
```php
/**
 * Property Test: double_entry_balance_property
 * Ensures all transactions maintain accounting equation
 */
class DoubleEntryPropertyTest extends TestCase {
    
    public function test_all_transactions_balance() {
        // Generate random test data
        $test_cases = $this->generate_random_transactions(1000);
        
        foreach ($test_cases as $transaction) {
            $result = $this->accounting_model->record_double_entry(
                $transaction['debit_account'],
                $transaction['credit_account'],
                $transaction['amount'],
                $transaction['note'],
                $transaction['user_id'],
                $transaction['loc']
            );
            
            // Property: Total debits must equal total credits
            $this->assertTrue($this->validate_transaction_balance($result));
            
            // Property: Account balances must update correctly
            $this->assertTrue($this->validate_account_balances($result));
            
            // Property: Audit trail must be complete
            $this->assertTrue($this->validate_audit_trail($result));
        }
    }
}
```

## 10. Monitoring & Alerting

### 10.1 Key Metrics to Monitor
1. **Transaction success rate**: > 99.9%
2. **Average response time**: < 500ms
3. **Balance discrepancy alerts**: Immediate notification if trial balance ≠ 0
4. **Failed transaction rate**: Alert if > 1% of transactions fail
5. **Cache hit rate**: > 90% for balance queries

### 10.2 Health Check Endpoints
```php
/**
 * Health Check: /api/v1/accounting/health
 * Returns system health status
 */
public function health_check() {
    $checks = [
        'database_connection' => $this->check_database_connection(),
        'ledger_consistency' => $this->check_ledger_consistency(),
        'account_balances' => $this->validate_all_account_balances(),
        'cache_status' => $this->check_cache_status(),
        'migration_status' => $this->check_migration_status()
    ];
    
    $all_healthy = !in_array(false, $checks, true);
    
    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => $all_healthy ? 'healthy' : 'degraded',
            'timestamp' => date('Y-m-d H:i:s'),
            'checks' => $checks
        ]));
}
```

---
**Design Approval:**
- [ ] Architecture Review
- [ ] Database Design Review  
- [ ] Security Review
- [ ] Performance Review
- [ ] Integration Review

**Next Phase:** Implementation Tasks & Timeline