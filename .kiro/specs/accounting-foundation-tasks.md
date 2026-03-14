# Accounting Foundation & Auto-Provisioning System - Implementation Tasks
**Spec ID:** ACC-FND-001  
**Version:** 1.0  
**Status:** Planning Phase  
**Created:** March 14, 2026  
**Based on:** Requirements v1.0, Design v1.0

## Task Overview
Total Estimated Effort: 4-6 weeks  
Priority: High  
Dependencies: Existing TimberPro system, MySQL database

## Phase 1: Database Schema & Migration (Week 1)

### Task 1.1: Database Schema Enhancement
- [ ] **1.1.1**: Add new columns to `geopos_accounts` table
  - `is_private` BOOLEAN DEFAULT TRUE
  - `offset_account_id` INT DEFAULT NULL  
  - `created_by` INT DEFAULT NULL
  - `updated_at` TIMESTAMP
- [ ] **1.1.2**: Create foreign key constraint for offset accounts
- [ ] **1.1.3**: Add performance indexes
  - `idx_accounts_loc_type` (loc, account_type, is_private)
  - `idx_accounts_created_by` (created_by)

### Task 1.2: Create New Ledger Table
- [ ] **1.2.1**: Create `tp_general_ledger` table with all defined columns
- [ ] **1.2.2**: Add foreign key constraints to `geopos_accounts` and `geopos_users`
- [ ] **1.2.3**: Create comprehensive indexes for performance
  - `idx_transaction_id` (transaction_id)
  - `idx_account_loc` (account_id, loc)
  - `idx_created_at` (created_at)
  - `idx_reference` (reference_type, reference_id)
  - `idx_user_loc` (user_id, loc)

### Task 1.3: Data Migration Scripts
- [ ] **1.3.1**: Create backup script for existing accounts and transactions
- [ ] **1.3.2**: Develop migration script to populate `tp_general_ledger` from `geopos_transactions`
- [ ] **1.3.3**: Create validation script to verify migration accuracy
- [ ] **1.3.4**: Develop rollback script for emergency situations

## Phase 2: Core Models & Business Logic (Week 2-3)

### Task 2.1: Enhanced Accounts Model
- [ ] **2.1.1**: Extend `Accounts_model.php` with new methods
  - `create_account_with_offset()` - Auto-provisioning logic
  - `get_offset_account_type()` - Account type mapping
  - `apply_account_visibility_filter()` - Enhanced security filtering
- [ ] **2.1.2**: Update existing methods for backward compatibility
  - `addnew()` - Integrate auto-provisioning
  - `accountslist()` - Apply visibility filters
  - `details()` - Include offset account information

### Task 2.2: New Ledger Model
- [ ] **2.2.1**: Create `General_ledger_model.php` with core methods
  - `record_double_entry()` - Zero-leakage transaction recording
  - `get_account_balance()` - Real-time balance calculation
  - `generate_transaction_id()` - Unique ID generation
  - `validate_transaction_parameters()` - Business rule validation
- [ ] **2.2.2**: Implement caching layer for performance
  - `get_cached_account_balance()` - 5-minute cache implementation
  - Cache invalidation on transaction write

### Task 2.3: Enhanced Transactions Model
- [ ] **2.3.1**: Update `Transactions_model.php` for dual-system support
  - Modify `addtrans()` to also write to `tp_general_ledger`
  - Update `add_double_entry()` to use new ledger system
  - Add `record_legacy_transaction()` for backward compatibility
- [ ] **2.3.2**: Implement transaction validation rules
  - Account access validation
  - Account type compatibility checking
  - Amount validation

## Phase 3: Security & Access Control (Week 3)

### Task 3.1: Location-Based Access Control
- [ ] **3.1.1**: Enhance all model base classes with location filtering
  - `apply_location_filter()` - Standard location filtering
  - `apply_account_visibility_filter()` - Privacy-based filtering
- [ ] **3.1.2**: Update all existing queries to use new filters
- [ ] **3.1.3**: Create access validation helper functions
  - `has_account_access()` - Permission checking
  - `validate_account_access()` - Pre-transaction validation

### Task 3.2: User Role Integration
- [ ] **3.2.1**: Implement role-based access rules
  - Super Admin (roleid=1): Global access
  - Business Owner: Location-restricted access
  - Service Provider: Private account access only
- [ ] **3.2.2**: Update UI to reflect access restrictions
- [ ] **3.2.3**: Create audit logging for access violations

## Phase 4: API & Integration Layer (Week 4)

### Task 4.1: REST API Endpoints
- [ ] **4.1.1**: Create `/api/v1/accounts/create` endpoint
  - Input validation with form_validation library
  - Auto-provisioning integration
  - Proper error responses
- [ ] **4.1.2**: Create `/api/v1/ledger/entry` endpoint
  - Double-entry transaction recording
  - Transaction validation
  - Balance updates
- [ ] **4.1.3**: Create `/api/v1/ledger/balance/{account_id}` endpoint
  - Cached balance retrieval
  - Access control validation
- [ ] **4.1.4**: Create `/api/v1/ledger/trial-balance` endpoint
  - Trial balance calculation
  - Date range filtering

### Task 4.2: Backward Compatibility Layer
- [ ] **4.2.1**: Implement dual-write system
  - Write to both `geopos_transactions` and `tp_general_ledger`
  - Transaction integrity across both systems
- [ ] **4.2.2**: Create synchronization utilities
  - Detect and fix inconsistencies
  - Migration status monitoring
- [ ] **4.2.3**: Update existing controllers for compatibility
  - `Accounts.php` controller updates
  - `Financial.php` controller updates

## Phase 5: User Interface Updates (Week 4-5)

### Task 5.1: Account Management UI
- [ ] **5.1.1**: Update account creation form
  - Add account type selection
  - Show auto-provisioning information
  - Display offset account details
- [ ] **5.1.2**: Enhance account listing page
  - Show privacy status (public/private)
  - Display offset account relationships
  - Apply visibility filters
- [ ] **5.1.3**: Create account detail view
  - Show ledger entries
  - Display running balance
  - Show transaction history

### Task 5.2: Transaction Interface
- [ ] **5.2.1**: Update transaction entry forms
  - Dual account selection (debit/credit)
  - Real-time balance validation
  - Transaction ID display
- [ ] **5.2.2**: Create ledger view interface
  - Filter by account, date, location
  - Export functionality
  - Audit trail display

### Task 5.3: Financial Reports
- [ ] **5.3.1**: Update profit & loss report to use new ledger
- [ ] **5.3.2**: Update balance sheet report
- [ ] **5.3.3**: Create trial balance report
- [ ] **5.3.4**: Add new financial statements
  - Cash flow statement
  - General ledger report

## Phase 6: Testing & Quality Assurance (Week 5)

### Task 6.1: Unit Testing
- [ ] **6.1.1**: Create tests for `create_account_with_offset()`
  - Test all account type mappings
  - Test offset account creation
  - Test opening balance handling
- [ ] **6.1.2**: Create tests for `record_double_entry()`
  - Test balance calculations
  - Test transaction validation
  - Test error conditions
- [ ] **6.1.3**: Create tests for security filters
  - Test location-based filtering
  - Test privacy-based filtering
  - Test access validation

### Task 6.2: Integration Testing
- [ ] **6.2.1**: Test API endpoints
  - Success scenarios
  - Error scenarios
  - Authentication/authorization
- [ ] **6.2.2**: Test backward compatibility
  - Dual-write consistency
  - Migration accuracy
  - Rollback functionality
- [ ] **6.2.3**: Test performance
  - Response time under load
  - Cache effectiveness
  - Database query performance

### Task 6.3: Property-Based Testing
- [ ] **6.3.1**: Create accounting equation tests
  - All transactions must balance (debits = credits)
  - Account balances must be consistent
  - Trial balance must always be zero
- [ ] **6.3.2**: Create audit trail tests
  - All transactions must have complete audit trail
  - No transactions can be modified or deleted
  - All changes must be logged

## Phase 7: Deployment & Monitoring (Week 6)

### Task 7.1: Deployment Preparation
- [ ] **7.1.1**: Create deployment checklist
- [ ] **7.1.2**: Develop rollback procedures
- [ ] **7.1.3**: Create backup strategies
- [ ] **7.1.4**: Prepare migration scripts

### Task 7.2: Phased Deployment
- [ ] **7.2.1**: Phase 1: Database changes (non-breaking)
- [ ] **7.2.2**: Phase 2: Core logic in shadow mode
- [ ] **7.2.3**: Phase 3: Dual-write mode
- [ ] **7.2.4**: Phase 4: Read from new system
- [ ] **7.2.5**: Phase 5: Full cutover
- [ ] **7.2.6**: Phase 6: Legacy code cleanup

### Task 7.3: Monitoring & Alerting
- [ ] **7.3.1**: Implement health check endpoints
- [ ] **7.3.2**: Set up monitoring for key metrics
  - Transaction success rate
  - Response times
  - Balance discrepancies
  - Cache performance
- [ ] **7.3.3**: Create alerting rules
  - Immediate alert for balance discrepancies
  - Warning for performance degradation
  - Notification for system errors

## Phase 8: Documentation & Training (Ongoing)

### Task 8.1: Technical Documentation
- [ ] **8.1.1**: API documentation
- [ ] **8.1.2**: Database schema documentation
- [ ] **8.1.3**: Deployment guide
- [ ] **8.1.4**: Troubleshooting guide

### Task 8.2: User Documentation
- [ ] **8.2.1**: User guide for new features
- [ ] **8.2.2**: Training materials
- [ ] **8.2.3**: FAQ document

### Task 8.3: Operational Documentation
- [ ] **8.3.1**: Runbook for common operations
- [ ] **8.3.2**: Maintenance procedures
- [ ] **8.3.3**: Backup and recovery procedures

## Success Criteria

### Quantitative Metrics
- [ ] **100%** of transactions recorded in both debit and credit
- [ ] **100%** automatic offset account creation
- [ ] **0.00** trial balance difference
- [ ] **< 1 second** response time for all ledger operations
- [ ] **> 99.9%** transaction success rate

### Qualitative Metrics
- [ ] **> 4.5/5** user satisfaction rating
- [ ] **90% reduction** in manual correction requests
- [ ] **50% reduction** in accounting training time
- [ ] **Zero** security breaches or access violations

## Risk Mitigation

### High Risk Items
1. **Data migration failure**
   - Mitigation: Comprehensive backups, staged migration
   - Owner: Database Administrator
   
2. **Performance degradation**
   - Mitigation: Index optimization, query caching
   - Owner: Performance Engineer
   
3. **Security breaches**
   - Mitigation: Penetration testing, access logging
   - Owner: Security Officer
   
4. **User resistance**
   - Mitigation: Training, phased rollout, support
   - Owner: Product Owner

## Dependencies

### Internal Dependencies
- Existing `geopos_accounts` table structure
- Current location-based access control system  
- CodeIgniter framework and Aauth library
- Existing financial reporting system

### External Dependencies
- MySQL 8.0+ database server
- PHP 7.4+ environment
- Web server (Apache/Nginx)
- Sufficient server resources for caching

## Resource Requirements

### Development Team
- **Backend Developer** (2): Database, models, APIs
- **Frontend Developer** (1): UI updates
- **QA Engineer** (1): Testing and validation
- **DevOps Engineer** (1): Deployment and monitoring

### Infrastructure
- **Development Environment**: Staging server with production-like data
- **Testing Environment**: Isolated environment for performance testing
- **Monitoring Tools**: Application performance monitoring
- **Backup Systems**: Database backup and recovery

## Timeline Summary

- **Week 1**: Database schema & migration
- **Week 2-3**: Core models & business logic
- **Week 3**: Security & access control
- **Week 4**: API & integration layer
- **Week 4-5**: User interface updates
- **Week 5**: Testing & quality assurance
- **Week 6**: Deployment & monitoring
- **Ongoing**: Documentation & training

---
**Task Assignment:**
- [ ] Project Manager
- [ ] Technical Lead
- [ ] Development Team
- [ ] QA Team
- [ ] Operations Team

**Approval:**
- [ ] All tasks reviewed and approved
- [ ] Resource allocation confirmed
- [ ] Timeline agreed
- [ ] Risk mitigation plans in place