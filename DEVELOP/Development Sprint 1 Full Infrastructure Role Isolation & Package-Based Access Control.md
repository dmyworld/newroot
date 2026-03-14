# Development Sprint 1: Full Infrastructure, Role Isolation & Package-Based Access Control

## 1. Unified Database Structure (No-Delete System)
- [x] Create/Update schema for `users`, [roles](file:///c:/Users/user/Documents/GitHub/www/newroot/application/controllers/Employee.php#555-567), `business_locations`, `packages`, `user_location_mapping`, `staff_profiles`
- [x] Implement [status](file:///c:/Users/user/Documents/GitHub/www/newroot/application/controllers/Locations.php#211-220) column for soft deletes (Pending Delete, Inactive, Active, Removed)
- [x] Staff request delete functionality
- [x] Owner approve delete functionality (moves to Inactive/Review)
- [x] Super Admin final review (Restore/Hard Delete)

## 2. Package-Based Subscription Logic
- [x] Create Packages table with constraints (locations limit, commission, AI ads)
- [x] Starter Package config (1 Loc, 3% commission)
- [x] Standard Package config (1 Loc, 0% commission, 2 AI ads)
- [x] Professional Package config (5 Loc, 0% commission, 4 AI ads)
- [x] Implement Package Validator to block creating locations beyond limit

## 3. Staffing, Verification & Insurance Logic
- [x] Multi-Location Assignment (Assign branch on creation)
- [x] Super Admin Verification Workflow
- [x] Dynamic Profile logic based on experience
- [x] Insurance Trigger logic for top tiers

## 4. Advanced Dashboard Logic
- [x] Location Switcher dropdown in header
- [x] Global Overview Dashboard (Total Revenue, Stock for all locations)
- [x] Dynamic Sidebar Menu based on role & location
- [x] Red alerts for pending deletions in sidebar

## 5. System Setup
- [x] Database Migration Runner (Splitting large ALTER statements)
- [x] Initial Package seeding (Starter, Standard, Professional)
- [x] Infrastructure and logic verification
- [x] 4. Advanced Dashboard Logic: Dynamic, Role-Based Sidebar Menus.
- [x] 5. System Setup: Light Red UI alerts for 'Pending Delete' items, Guided Tour scaffold (Sinhala, Tamil, English).
