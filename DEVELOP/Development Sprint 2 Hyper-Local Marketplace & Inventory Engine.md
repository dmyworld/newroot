# Development Sprint 2: Hyper-Local Marketplace & Inventory Engine

## 1. Super Admin Control & Master Data
- [x] Master List CRUD: Implementation for Master Products, Labor Categories, and Commission Rates <!-- id: 0 -->
- [ ] Approval System: Module for approving/rejecting new business categories <!-- id: 1 -->

## 2. Business Owner: Advanced Inventory & AI Engine
- [x] Dashboard Isolation: Middleware and logic for `business_id` and `location_id` isolation <!-- id: 2 -->
- [x] 1-Click Import & Triple-Mode: Sale, Rent, Installment pricing from Master List <!-- id: 3 -->
    - [x] Update `geopos_products` schema (Rent/Installment prices) <!-- id: 17 -->
    - [x] Implement "Select from Master List" Modal in [product-add.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/products/product-add.php) <!-- id: 18 -->
    - [x] Add Triple-Mode toggles and dynamic pricing fields in UI
    - [x] Update `Products_model.addnew` to handle new pricing modes <!-- id: 19 -->
- [x] Stock Traffic Lights UI: Visual stock level indicators (Green, Amber, Red) <!-- id: 4 -->
- [x] Stock Traffic Lights UI: Visual stock level indicators (Green, Amber, Red) <!-- id: 4 -->
- [x] Barcode/QR Scanner Integration: Camera-based scanner for Inventory & POS <!-- id: 5 -->
    - [x] Create reusable [scanner_modal.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/fixed/scanner_modal.php) component
    - [x] Integrate Scan button in [product-add.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/products/product-add.php) and [product-edit.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/products/product-edit.php)
    - [x] Integrate Scan button in POS [newinvoice.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/pos/newinvoice.php)
    - [x] Verify scanner functionality and auto-search in POS
- [x] AI Ads via Revid API: 1-Click AI Video generation integration <!-- id: 6 -->
    - [x] Run database migration [AI_Ads_Migration.sql](file:///c:/Users/user/Documents/GitHub/www/newroot/application/sql/AI_Ads_Migration.sql)
    - [x] Implement [Marketing_model](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Marketing_model.php#4-391) revid methods
    - [x] Update [Marketing](file:///c:/Users/user/Documents/GitHub/www/newroot/application/controllers/Marketing.php#4-80) controller with revid endpoints
    - [x] Update [marketing.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/timber/marketing.php) View with Revid UI
    - [x] Verify 1-Click Video generation workflow

## 3. Customer Dual-Marketplace
- [x] Dual-Tab UI: "Products" and "Services" tabs on Shop Page <!-- id: 7 -->
- [x] Smart Filters: Advanced filtering by Location, Price, Category, and Barcode <!-- id: 8 -->
- [x] Installment Calculator Widget: Monthly installment calculation on Product Page <!-- id: 9 -->
- [x] AI Smart Bundling: Suggested services based on Cart contents <!-- id: 10 -->

## 4. Labor & Service Provider Module
- [x] Provider Profiles: Profiles with hourly/daily rates, portfolio, and ratings <!-- id: 11 -->
    - [x] Update `geopos_worker_profiles` schema (Portfolio field) <!-- id: 20 -->
    - [x] Implement Portfolio Gallery in Profile View <!-- id: 21 -->
- [x] Online/Offline Toggle: Uber-style real-time availability status switch <!-- id: 12 -->
    - [x] Implement AJAX toggle in Worker Dashboard <!-- id: 22 -->
    - [x] Add Pulse indicator for "Live" status in marketplace <!-- id: 23 -->
- [x] Service Catalog: CRUD for labor services (carpentry, plumbing, etc.) with icons <!-- id: 13 -->
- [x] WhatsApp Integration: Direct "Book Now" button on provider profiles <!-- id: 14 -->
- [x] Marketplace Display: Updated [shop/index.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/views/shop/index.php) to show worker cards with icons and status <!-- id: 15 -->
- [x] Real-time Availability: Profile owners can toggle status via AJAX <!-- id: 16 -->

## 5. Geo-Fenced Quotations & Negotiation
- [x] Location-Based Broadcast: GPS/Radius logic for Quotation Requests <!-- id: 13 -->
- [x] Kanban Board Dashboard: Drag-and-drop UI for Quote management (Requested, Received, Accepted) <!-- id: 14 -->
- [ ] Mini-Negotiation Chat: Real-time chat using Socket.io for price bargaining <!-- id: 15 -->

## 6. Automated Commission Engine
- [x] Auto-Split Logic: Automated commission calculation and splitting (e.g., 3%) <!-- id: 16 -->
