-- =====================================================
-- AUTOMATED CHART OF ACCOUNTS SETUP SCRIPT (CORRECTED)
-- Complete Reset and Configuration for Dual Entry Accounting
-- =====================================================
-- WARNING: This script will DELETE all existing accounts and recreate them
-- Make sure to BACKUP your database before running this script!
-- =====================================================

-- Step 1: Backup existing accounts (optional - create backup table)
DROP TABLE IF EXISTS geopos_accounts_backup;
CREATE TABLE geopos_accounts_backup AS SELECT * FROM geopos_accounts;

-- Step 2: Clear existing accounts
DELETE FROM geopos_accounts WHERE id > 0;

-- Step 3: Reset auto-increment
ALTER TABLE geopos_accounts AUTO_INCREMENT = 1;

-- =====================================================
-- CHART OF ACCOUNTS STRUCTURE
-- Columns: id, acn, holder, adate, lastbal, code, loc, account_type
-- =====================================================

-- ASSETS
-- -------
INSERT INTO geopos_accounts (acn, holder, adate, lastbal, code, loc, account_type) VALUES
('CASH-001', 'Cash in Hand', NOW(), 0.00, 'Main cash account', 0, 'Asset'),
('BANK-001', 'Bank Account - Commercial Bank', NOW(), 0.00, 'Commercial Bank current account', 0, 'Asset'),
('BANK-002', 'Bank Account - People\'s Bank', NOW(), 0.00, 'People\'s Bank savings account', 0, 'Asset'),
('CASH-002', 'Petty Cash', NOW(), 0.00, 'Small daily expenses', 0, 'Asset'),
('AR-001', 'Accounts Receivable', NOW(), 0.00, 'Customer credit balances', 0, 'Asset'),
('INV-001', 'Inventory / Stock', NOW(), 0.00, 'Main stock/inventory account', 0, 'Asset'),
('FA-001', 'Equipment & Machinery', NOW(), 0.00, 'Fixed assets - Equipment', 0, 'Asset'),
('FA-002', 'Furniture & Fixtures', NOW(), 0.00, 'Fixed assets - Furniture', 0, 'Asset'),
('FA-003', 'Vehicles', NOW(), 0.00, 'Fixed assets - Vehicles', 0, 'Asset');

-- LIABILITIES
-- -----------
INSERT INTO geopos_accounts (acn, holder, adate, lastbal, code, loc, account_type) VALUES
('AP-001', 'Accounts Payable', NOW(), 0.00, 'Supplier credit balances', 0, 'Liability'),
('EPF-EMP', 'EPF Payable (Employee 8%)', NOW(), 0.00, 'Employee EPF deduction payable', 0, 'Liability'),
('EPF-ER', 'EPF Payable (Employer 12%)', NOW(), 0.00, 'Employer EPF contribution payable', 0, 'Liability'),
('ETF-ER', 'ETF Payable (Employer 3%)', NOW(), 0.00, 'Employer ETF contribution payable', 0, 'Liability'),
('SAL-PAY', 'Salary Payable', NOW(), 0.00, 'Net salary payable to employees', 0, 'Liability'),
('VAT-001', 'VAT Payable', NOW(), 0.00, 'Value Added Tax payable', 0, 'Liability'),
('LOAN-001', 'Loans Payable', NOW(), 0.00, 'Business loans payable', 0, 'Liability');

-- EQUITY
-- ------
INSERT INTO geopos_accounts (acn, holder, adate, lastbal, code, loc, account_type) VALUES
('EQ-001', 'Owner\'s Equity', NOW(), 0.00, 'Owner capital investment', 0, 'Equity'),
('EQ-002', 'Retained Earnings', NOW(), 0.00, 'Accumulated profits', 0, 'Equity');

-- REVENUE / INCOME
-- ----------------
INSERT INTO geopos_accounts (acn, holder, adate, lastbal, code, loc, account_type) VALUES
('REV-001', 'Sales Revenue', NOW(), 0.00, 'Revenue from sales', 0, 'Income'),
('REV-002', 'Service Revenue', NOW(), 0.00, 'Revenue from services', 0, 'Income'),
('REV-003', 'Rental Income', NOW(), 0.00, 'Revenue from rentals', 0, 'Income'),
('REV-004', 'Commission Income', NOW(), 0.00, 'Commission earned', 0, 'Income'),
('REV-005', 'Stock Gain / Surplus', NOW(), 0.00, 'Gain from stock surplus', 0, 'Income'),
('REV-006', 'Interest Income', NOW(), 0.00, 'Interest earned', 0, 'Income');

-- EXPENSES
-- --------
INSERT INTO geopos_accounts (acn, holder, adate, lastbal, code, loc, account_type) VALUES
('EXP-001', 'Cost of Goods Sold (COGS)', NOW(), 0.00, 'Direct cost of goods sold', 0, 'Expense'),
('EXP-002', 'Salaries & Wages', NOW(), 0.00, 'Employee salaries and wages', 0, 'Expense'),
('EXP-003', 'EPF Employer Contribution (12%)', NOW(), 0.00, 'Employer EPF contribution', 0, 'Expense'),
('EXP-004', 'ETF Employer Contribution (3%)', NOW(), 0.00, 'Employer ETF contribution', 0, 'Expense'),
('EXP-005', 'Rent Expense', NOW(), 0.00, 'Building and premises rent', 0, 'Expense'),
('EXP-006', 'Utilities Expense', NOW(), 0.00, 'Electricity, water, gas', 0, 'Expense'),
('EXP-007', 'Office & Administrative Expenses', NOW(), 0.00, 'Office supplies and admin costs', 0, 'Expense'),
('EXP-008', 'Transportation Expense', NOW(), 0.00, 'Vehicle fuel and transport', 0, 'Expense'),
('EXP-009', 'Marketing & Advertising', NOW(), 0.00, 'Marketing and advertising costs', 0, 'Expense'),
('EXP-010', 'Repairs & Maintenance', NOW(), 0.00, 'Repairs and maintenance', 0, 'Expense'),
('EXP-011', 'Bank Charges & Fees', NOW(), 0.00, 'Banking fees and charges', 0, 'Expense'),
('EXP-012', 'Stock Loss Expense', NOW(), 0.00, 'Loss from stock shortage/damage', 0, 'Expense'),
('EXP-013', 'Depreciation Expense', NOW(), 0.00, 'Asset depreciation', 0, 'Expense'),
('EXP-014', 'Insurance Expense', NOW(), 0.00, 'Business insurance premiums', 0, 'Expense'),
('EXP-015', 'Professional Fees', NOW(), 0.00, 'Legal, accounting, consulting fees', 0, 'Expense'),
('EXP-016', 'Telephone & Internet', NOW(), 0.00, 'Communication expenses', 0, 'Expense');

-- =====================================================
-- TRANSACTION CATEGORY MAPPINGS
-- =====================================================

-- Get the account IDs that were just created
SET @sales_revenue = (SELECT id FROM geopos_accounts WHERE holder = 'Sales Revenue' LIMIT 1);
SET @service_revenue = (SELECT id FROM geopos_accounts WHERE holder = 'Service Revenue' LIMIT 1);
SET @rental_income = (SELECT id FROM geopos_accounts WHERE holder = 'Rental Income' LIMIT 1);
SET @commission_income = (SELECT id FROM geopos_accounts WHERE holder = 'Commission Income' LIMIT 1);
SET @inventory = (SELECT id FROM geopos_accounts WHERE holder = 'Inventory / Stock' LIMIT 1);
SET @cogs = (SELECT id FROM geopos_accounts WHERE holder = 'Cost of Goods Sold (COGS)' LIMIT 1);
SET @salaries = (SELECT id FROM geopos_accounts WHERE holder = 'Salaries & Wages' LIMIT 1);
SET @epf_employer = (SELECT id FROM geopos_accounts WHERE holder = 'EPF Employer Contribution (12%)' LIMIT 1);
SET @etf_employer = (SELECT id FROM geopos_accounts WHERE holder = 'ETF Employer Contribution (3%)' LIMIT 1);
SET @rent = (SELECT id FROM geopos_accounts WHERE holder = 'Rent Expense' LIMIT 1);
SET @utilities = (SELECT id FROM geopos_accounts WHERE holder = 'Utilities Expense' LIMIT 1);
SET @office = (SELECT id FROM geopos_accounts WHERE holder = 'Office & Administrative Expenses' LIMIT 1);
SET @transport = (SELECT id FROM geopos_accounts WHERE holder = 'Transportation Expense' LIMIT 1);
SET @marketing = (SELECT id FROM geopos_accounts WHERE holder = 'Marketing & Advertising' LIMIT 1);
SET @repairs = (SELECT id FROM geopos_accounts WHERE holder = 'Repairs & Maintenance' LIMIT 1);
SET @bank_charges = (SELECT id FROM geopos_accounts WHERE holder = 'Bank Charges & Fees' LIMIT 1);
SET @stock_loss = (SELECT id FROM geopos_accounts WHERE holder = 'Stock Loss Expense' LIMIT 1);
SET @stock_gain = (SELECT id FROM geopos_accounts WHERE holder = 'Stock Gain / Surplus' LIMIT 1);
SET @insurance = (SELECT id FROM geopos_accounts WHERE holder = 'Insurance Expense' LIMIT 1);
SET @professional = (SELECT id FROM geopos_accounts WHERE holder = 'Professional Fees' LIMIT 1);
SET @telephone = (SELECT id FROM geopos_accounts WHERE holder = 'Telephone & Internet' LIMIT 1);
SET @equipment = (SELECT id FROM geopos_accounts WHERE holder = 'Equipment & Machinery' LIMIT 1);
SET @furniture = (SELECT id FROM geopos_accounts WHERE holder = 'Furniture & Fixtures' LIMIT 1);
SET @vehicles = (SELECT id FROM geopos_accounts WHERE holder = 'Vehicles' LIMIT 1);

-- Map categories to accounts
UPDATE geopos_trans_cat SET dual_acid = @sales_revenue WHERE name LIKE '%Sales%' OR name LIKE '%sale%';
UPDATE geopos_trans_cat SET dual_acid = @service_revenue WHERE name LIKE '%Service%';
UPDATE geopos_trans_cat SET dual_acid = @rental_income WHERE name LIKE '%Rental%' OR name LIKE '%Rent Income%';
UPDATE geopos_trans_cat SET dual_acid = @commission_income WHERE name LIKE '%Commission%';
UPDATE geopos_trans_cat SET dual_acid = @inventory WHERE name LIKE '%Purchase%' AND name NOT LIKE '%Equipment%';
UPDATE geopos_trans_cat SET dual_acid = @cogs WHERE name LIKE '%COGS%' OR name LIKE '%Cost of Goods%';
UPDATE geopos_trans_cat SET dual_acid = @salaries WHERE name LIKE '%Salary%' OR name LIKE '%Salaries%' OR name LIKE '%Wages%';
UPDATE geopos_trans_cat SET dual_acid = @epf_employer WHERE name LIKE '%EPF%' AND name LIKE '%12%';
UPDATE geopos_trans_cat SET dual_acid = @etf_employer WHERE name LIKE '%ETF%';
UPDATE geopos_trans_cat SET dual_acid = @rent WHERE name LIKE '%Rent%' AND name NOT LIKE '%Rental Income%';
UPDATE geopos_trans_cat SET dual_acid = @utilities WHERE name LIKE '%Utilities%' OR name LIKE '%Electricity%' OR name LIKE '%Water%';
UPDATE geopos_trans_cat SET dual_acid = @office WHERE name LIKE '%Office%' OR name LIKE '%Stationery%';
UPDATE geopos_trans_cat SET dual_acid = @transport WHERE name LIKE '%Transport%' OR name LIKE '%Fuel%' OR name LIKE '%Vehicle%';
UPDATE geopos_trans_cat SET dual_acid = @marketing WHERE name LIKE '%Marketing%' OR name LIKE '%Advertising%';
UPDATE geopos_trans_cat SET dual_acid = @repairs WHERE name LIKE '%Repair%' OR name LIKE '%Maintenance%';
UPDATE geopos_trans_cat SET dual_acid = @bank_charges WHERE name LIKE '%Bank%' AND name LIKE '%Charge%';
UPDATE geopos_trans_cat SET dual_acid = @stock_loss WHERE name LIKE '%Stock Loss%' OR name LIKE '%Shortage%';
UPDATE geopos_trans_cat SET dual_acid = @stock_gain WHERE name LIKE '%Stock Gain%' OR name LIKE '%Surplus%';
UPDATE geopos_trans_cat SET dual_acid = @insurance WHERE name LIKE '%Insurance%';
UPDATE geopos_trans_cat SET dual_acid = @professional WHERE name LIKE '%Professional%' OR name LIKE '%Legal%' OR name LIKE '%Accounting%';
UPDATE geopos_trans_cat SET dual_acid = @telephone WHERE name LIKE '%Telephone%' OR name LIKE '%Internet%' OR name LIKE '%Mobile%';
UPDATE geopos_trans_cat SET dual_acid = @equipment WHERE name LIKE '%Equipment%';
UPDATE geopos_trans_cat SET dual_acid = @furniture WHERE name LIKE '%Furniture%';
UPDATE geopos_trans_cat SET dual_acid = @vehicles WHERE name LIKE '%Vehicle Purchase%';

-- =====================================================
-- DUAL ENTRY SETTINGS (API CONFIG)
-- =====================================================

-- Configure dual entry settings in univarsal_api table (ID 65)
UPDATE univarsal_api SET 
    key1 = 1,                     -- Enable Dual Entry
    key2 = @sales_revenue,        -- Default Invoice Account (Sales Revenue)
    url = @inventory              -- Default Purchase Account (Inventory)
WHERE id = 65;

-- If record doesn't exist, insert it
INSERT INTO univarsal_api (id, name, key1, key2, url, other) 
SELECT 65, 'Dual Entry Settings', 1, @sales_revenue, @inventory, ''
WHERE NOT EXISTS (SELECT 1 FROM univarsal_api WHERE id = 65);

-- =====================================================
-- STOCK/INVENTORY ACCOUNT SETTINGS (API CONFIG)
-- =====================================================

-- API ID 70: Stock/Inventory Account
UPDATE univarsal_api SET key1 = @inventory WHERE id = 70;
INSERT INTO univarsal_api (id, name, key1, other) 
SELECT 70, 'Inventory Account', @inventory, ''
WHERE NOT EXISTS (SELECT 1 FROM univarsal_api WHERE id = 70);

-- API ID 71: Stock Loss Expense Account
UPDATE univarsal_api SET key1 = @stock_loss WHERE id = 71;
INSERT INTO univarsal_api (id, name, key1, other) 
SELECT 71, 'Stock Loss Expense', @stock_loss, ''
WHERE NOT EXISTS (SELECT 1 FROM univarsal_api WHERE id = 71);

-- API ID 72: Stock Gain/Surplus Account
UPDATE univarsal_api SET key1 = @stock_gain WHERE id = 72;
INSERT INTO univarsal_api (id, name, key1, other) 
SELECT 72, 'Stock Gain Account', @stock_gain, ''
WHERE NOT EXISTS (SELECT 1 FROM univarsal_api WHERE id = 72);

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

SELECT 'Chart of Accounts setup completed successfully!' as Status,
       (SELECT COUNT(*) FROM geopos_accounts) as Total_Accounts,
       (SELECT COUNT(*) FROM geopos_trans_cat WHERE dual_acid > 0) as Mapped_Categories;

-- =====================================================
-- END OF SCRIPT
-- =====================================================
