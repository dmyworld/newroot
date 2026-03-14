# Accounting Foundation & Auto-Provisioning System
**Spec ID:** ACC-FND-001  
**Version:** 1.0  
**Status:** Requirements Phase  
**Created:** March 14, 2026  
**Priority:** High  

## 1. Executive Summary

Enhance the existing TimberPro accounting system with a robust double-entry foundation featuring automatic account provisioning, zero-leakage transaction recording, and enhanced security controls. This phase establishes the core accounting infrastructure for future financial modules.

## 2. Business Context

### 2.1 Current State Analysis
- Existing `geopos_transactions` table serves as general ledger but lacks proper double-entry structure
- `geopos_accounts` table has basic account_type field but needs enhanced classification
- Location-based access control (`loc` field) exists but needs extension for private/public accounts
- Manual account creation requires users to understand accounting principles

### 2.2 Problem Statement
1. **Manual Account Pairing**: Users must manually create offset accounts for proper double-entry
2. **Transaction Leakage**: Single-sided entries can create unbalanced ledgers
3. **Security Gaps**: No distinction between private (user-owned) and public (shared) accounts
4. **Opening Balance Complexity**: Initial balances require manual ledger entries

## 3. Functional Requirements

### 3.1 Database Structure Enhancement (FR-ACC-001)

#### 3.1.1 New Table: `tp_general_ledger`
```sql
CREATE TABLE tp_general_ledger (
    id INT PRIMARY KEY AUTO_INCREMENT,
    transaction_id VARCHAR(50) NOT NULL,  -- Unique transaction identifier
    account_id INT NOT NULL,              -- References geopos_accounts.id
    debit DECIMAL(16,2) DEFAULT 0.00,
    credit DECIMAL(16,2) DEFAULT 0.00,
    balance DECIMAL(16,2) DEFAULT 0.00,   -- Running balance for this account
    loc INT NOT NULL,                     -- Location ID for access control
    user_id INT NOT NULL,                 -- User who created the entry
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES geopos_accounts(id),
    INDEX idx_transaction (transaction_id),
    INDEX idx_account_loc (account_id, loc),
    INDEX idx_created (created_at)
);
```

#### 3.1.2 Enhanced Table: `geopos_accounts`
- **Current**: Has `account_type` (Asset/Liability/Equity/Income/Expense/Basic)
- **Enhancement**: Add `is_private` BOOLEAN DEFAULT TRUE field
- **Validation**: Ensure `loc` field exists and is properly indexed

### 3.2 Automatic Account Provisioning (FR-ACC-002)

#### 3.2.1 Account Creation Logic
When a user creates a new account:
1. **Input**: User provides account details (holder, type, initial balance)
2. **System Action**: Automatically creates opposite offset account
3. **Ownership**: Both accounts tagged with creator's `loc` as "Private"
4. **Naming Convention**: 
   - Primary account: User-provided name
   - Offset account: "[Primary Name] - Offset"

#### 3.2.2 Account Type Mapping
| Primary Account Type | Opposite Offset Type |
|---------------------|---------------------|
| Asset               | Equity              |
| Liability           | Equity              |
| Income              | Equity              |
| Expense             | Equity              |
| Equity              | Asset               |

#### 3.2.3 Business Rules
- **BR-ACC-001**: Offset accounts are created with zero initial balance
- **BR-ACC-002**: Both accounts share the same `loc` (creator's location)
- **BR-ACC-003**: Offset accounts are hidden from normal account lists
- **BR-ACC-004**: System maintains referential integrity between paired accounts

### 3.3 Zero-Leakage Double Entry Logic (FR-ACC-003)

#### 3.3.1 Transaction Recording Triggers
System must intercept and convert single entries to double entries:

1. **Invoice Payment** → Debit: Cash/Bank, Credit: Accounts Receivable
2. **Expense Payment** → Debit: Expense Account, Credit: Cash/Bank
3. **Manual Journal Entry** → User specifies both debit and credit accounts
4. **Opening Balance** → Automatic ledger entry on account creation

#### 3.3.2 Opening Balance Automation
- **Rule**: When account created with initial balance > 0
- **Action**: System creates corresponding ledger entry in `tp_general_ledger`
- **Logic**: 
  - Asset/Expense: Debit entry
  - Liability/Equity/Income: Credit entry

#### 3.3.3 Transaction Validation
- **BR-ACC-005**: Total debits MUST equal total credits per transaction
- **BR-ACC-006**: Transaction rejected if unbalanced
- **BR-ACC-007**: System generates unique `transaction_id` for audit trail

### 3.4 Security & Access Rules (FR-ACC-004)

#### 3.4.1 User Roles & Permissions
| Role | Access Level | Description |
|------|-------------|-------------|
| Super Admin (roleid=1) | Global | All locations, all accounts (public + private) |
| Business Owner | Location-Restricted | Only accounts with matching `loc` |
| Service Provider | Private Only | Only accounts they created (`user_id` match) |

#### 3.4.2 Query Filtering Rules
All database queries MUST include:
```php
// For non-admin users
if ($this->aauth->get_user()->roleid != 1) {
    if ($this->aauth->get_user()->loc) {
        $this->db->where('loc', $this->aauth->get_user()->loc);
    }
}
```

#### 3.4.3 Account Visibility
- **Public Accounts**: `loc = 0` (shared across locations)
- **Private Accounts**: `loc = user_location` AND `is_private = TRUE`
- **Business Rule**: Users can only see accounts they own or public accounts

### 3.5 Integration Points

#### 3.5.1 Existing System Integration
- **geopos_transactions**: Maintain for backward compatibility
- **geopos_accounts**: Enhanced with new fields
- **Reports_model.php**: Update to use `tp_general_ledger`
- **Transactions_model.php**: Modify `addtrans()` to create double entries

#### 3.5.2 API Endpoints
1. `POST /api/accounts/create` - With auto-provisioning
2. `POST /api/ledger/entry` - Double-entry transaction
3. `GET /api/ledger/balance/{account_id}` - Account balance
4. `GET /api/ledger/trial-balance` - Trial balance report

## 4. Non-Functional Requirements

### 4.1 Performance
- **NFR-ACC-001**: Ledger queries under 100ms for 1M records
- **NFR-ACC-002**: Account creation under 500ms with auto-provisioning
- **NFR-ACC-003**: Balance calculations cached for 5 minutes

### 4.2 Security
- **NFR-ACC-004**: All financial data encrypted at rest
- **NFR-ACC-005**: Audit trail for all ledger modifications
- **NFR-ACC-006**: SQL injection prevention via Query Builder

### 4.3 Data Integrity
- **NFR-ACC-007**: Database constraints for referential integrity
- **NFR-ACC-008**: Transaction rollback on failure
- **NFR-ACC-009**: Daily balance validation job

### 4.4 Usability
- **NFR-ACC-010**: Account creation wizard with auto-suggestions
- **NFR-ACC-011**: Clear error messages for unbalanced entries
- **NFR-ACC-012**: Real-time balance updates

## 5. Technical Constraints

### 5.1 Development Standards
- **TC-ACC-001**: Use CodeIgniter Query Builder (no raw SQL)
- **TC-ACC-002**: Follow existing TimberPro coding conventions
- **TC-ACC-003**: Maintain backward compatibility with existing data

### 5.2 Database Constraints
- **TC-ACC-004**: MySQL 8.0+ compatibility
- **TC-ACC-005**: UTF8MB4 character set
- **TC-ACC-006**: InnoDB storage engine

### 5.3 Deployment Constraints
- **TC-ACC-007**: Zero-downtime migration
- **TC-ACC-008**: Rollback capability
- **TC-ACC-009**: Data migration scripts for existing transactions

## 6. Success Metrics

### 6.1 Quantitative Metrics
1. **Double-Entry Compliance**: 100% of transactions recorded in both debit/credit
2. **Account Pairing**: 100% automatic offset account creation
3. **Balance Accuracy**: Trial balance difference = 0.00
4. **Performance**: < 1s response time for all ledger operations

### 6.2 Qualitative Metrics
1. **User Satisfaction**: > 4.5/5 rating for accounting module
2. **Error Reduction**: 90% reduction in manual correction requests
3. **Training Time**: 50% reduction in accounting training time

## 7. Risks & Mitigations

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Data migration failure | High | Medium | Comprehensive backup, staged migration |
| Performance degradation | Medium | Low | Index optimization, query caching |
| Security breach | High | Low | Penetration testing, access logging |
| User resistance | Medium | High | Training, phased rollout, support |

## 8. Dependencies

### 8.1 Internal Dependencies
1. Existing `geopos_accounts` table structure
2. Current location-based access control system
3. CodeIgniter framework and Aauth library

### 8.2 External Dependencies
1. MySQL database server
2. PHP 7.4+ environment
3. Web server (Apache/Nginx)

## 9. Assumptions

1. **A-ACC-001**: Users have basic understanding of double-entry accounting
2. **A-ACC-002**: Existing transaction data can be migrated to new structure
3. **A-ACC-003**: Location-based access control is working correctly
4. **A-ACC-004**: System has sufficient storage for ledger duplication

## 10. Open Questions

1. **Q1**: Should offset accounts be editable by users?
2. **Q2**: How to handle historical transaction migration?
3. **Q3**: What reporting requirements exist for the new ledger?
4. **Q4**: Should there be limits on private account creation?

## 11. Next Steps

1. **Phase 1.1**: Database schema design and migration scripts
2. **Phase 1.2**: Core auto-provisioning logic implementation
3. **Phase 1.3**: Double-entry transaction recording
4. **Phase 1.4**: Security and access control enhancements
5. **Phase 1.5**: Testing and validation
6. **Phase 1.6**: Deployment and training

---
**Approval Signatures:**
- [ ] Product Owner
- [ ] Technical Lead
- [ ] QA Manager
- [ ] Security Officer

**Revision History:**
- v1.0 (2026-03-14): Initial requirements specification