# Section 3: Universal Service Engine, Real-time Dispatch & Flexible Economy

This document outlines the architectural changes and implementation steps for transforming the system into a "Gig Economy" module with smart dispatching and strict hierarchy/location isolation.

## User Review Required
> [!IMPORTANT]
> **Real-time Ringing Logic (Socket.io) vs AJAX Polling**: Are we using a dedicated Node.js/Socket.io service for this project, or should we simulate real-time ringing via AJAX polling (or another WebSocket integration like Pusher)?
> **GPS Tracking**: Does the system already have a framework for capturing and updating live GPS coordinates (e.g. a React Native/Flutter mobile app component), or are we implementing a web-based Geolocation API solution?
> **Payment Gateway Escrow**: For "Timber Pro Vault", do we need to integrate a third-party gateway (like Stripe Connect) that holds funds, or are we building an internal ledger system for escrow?

## Proposed Changes

### 1. Unified Provider Schema
**Objective**: Differentiate independent professionals from company employees while maintaining hierarchy.
- **Database (`geopos_worker_profiles`)**:
  - `[MODIFY]` Add enum column `provider_type` (`independent`, `company`).
  - `[MODIFY]` Add integer column `owner_id` (If `provider_type` is company, this links to the business owner/tenant ID, loc ID, or specific user ID).
- **Files**:
  #### [application\models\Worker_model.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php)
  - Update [create_profile](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php#38-82) and [update_profile](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php#83-124) to accept and handle `provider_type` and `owner_id`.
  - Update [get_active_workers](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php#125-148) to filter based on provider type if needed.

---

### 2. Universal Category Manager
**Objective**: Super Admin UI to add professions and set specific commission rates.
- **Database (`geopos_hrm`)**:
  - The table currently stores categories when `typ = 3`.
  - `[MODIFY]` Add column `commission_rate` (DECIMAL 5,2) to store the percentage.
- **Files**:
  #### [application\models\Employee_model.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Employee_model.php) or [Settings_model.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Settings_model.php)
  - Add methods to update `commission_rate` for `typ = 3` records.
  #### [application\controllers\Employee.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/controllers/Employee.php) or `Settings.php` (Category Endpoint)
  - Controller methods to handle the CRUD for categories including commission.
  #### Views
  - Create or modify the view for managing categories (Department/Profession).

---

### 3. Real-Time "Smart Ring" Dispatcher
**Objective**: Send 30s ringing alerts to the nearest online workers.
- **Database (`geopos_worker_profiles` / `geopos_users`)**:
  - Ensure `latitude` and `longitude` fields exist and are frequently updated.
- **Logic**:
  - Create a new method `find_nearest_workers($lat, $lng, $radius_km, $category)`.
  - Implement a Dispatcher routine that triggers a Socket.io event `ring_worker` to the selected worker's channel.
  - Implement a fallback logic if the first worker declines or times out (30s).
- **Files**:
  #### `application\controllers\Dispatch.php` `[NEW]`
  - Handles incoming job requests, runs the proximity algorithm, and pushes events to Socket.io.
  #### Dashboard JS (`views/...`)
  - Add a listening script for `ring_worker` events to display the 30s popup.
  - If it's a company employee, the same event is also sent to an `owner_live_alerts` channel.

---

### 4. Proof of Work & GPS Clock-In
**Objective**: Guarantee workers are on-site and verify work with photos.
- **Database (`geopos_attendance`)**:
  - `[MODIFY]` Add columns `clock_in_lat`, `clock_in_lng`, `clock_out_lat`, `clock_out_lng`.
- **Database (`geopos_job_requests` or Jobs table)**:
  - `[MODIFY]` Add `before_photo`, `after_photo`, `billing_type` (`labor`, `task`), `task_qty`.
- **Files**:
  #### [application\models\Worker_model.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php)
  - Update [log_attendance()](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php#351-377) to accept GPS coordinates and validate against job location.
  #### Worker App UI
  - Add 'Start Work' button that triggers navigator.geolocation.
  - Add camera upload inputs for Before and After photos.

---

### 5. Flexible Payment & Multi-Level Escrow
**Objective**: Route payments securely, deducting commissions appropriately.
- **Files**:
  #### [application\models\Transactions_model.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Transactions_model.php) & [Marketplace_model.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Marketplace_model.php)
  - When payment mode is "Escrow", place funds in an internal ledger (status `held`).
  - Upon Mutual Consent (job completed by worker + approved by customer), route:
    - Independent: Gross -> Worker Wallet, deduct Commission -> Super Admin Wallet/Account.
    - Company: Gross -> Owner Wallet, deduct Commission -> Owner Wallet -> Super Admin.

---

### 6. Safety & Quality Control (SOS & Portfolios)
**Objective**: Add SOS buttons and allow portfolio uploads.
- **Database (`geopos_sos_alerts`) `[NEW]`**:
  - Columns: [id](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Marketplace_model.php#210-234), `user_id`, `job_id`, [lat](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Marketplace_model.php#235-242), `lng`, [status](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php#378-388), `created_at`.
- **Files**:
  #### [application\controllers\Worker.php](file:///c:/Users/user/Documents/GitHub/www/newroot/application/controllers/Worker.php)
  - Endpoint `trigger_sos()`: inserts to DB, broadcasts Socket.io alert to Admin/Owner.
  - Endpoint `upload_portfolio()`: handles Before/After specific tags in the existing `portfolio` JSON column.
  #### Worker Profile UI
  - Modify UI to dynamically render portfolio photos.

## Verification Plan

### Automated/Unit Tests
- CI/CD checks (if available) for syntax and database migration integrity.
- Postman API Tests for new endpoints (`trigger_sos`, [log_attendance](file:///c:/Users/user/Documents/GitHub/www/newroot/application/models/Worker_model.php#351-377) with GPS).

### Manual Verification
1. **Providers**: Register a user as an Independent Freelancer and another as a Company Employee. Validate DB entries.
2. **Categories**: Super Admin adds a "Carpenter" category with a 15% commission rate.
3. **Dispatch**: Simulate a customer requesting a Carpenter at coordinates X, Y. Verify the closest worker receives a simulated 30s popup alert.
4. **GPS Clock-In**: Worker tries to Clock-In far from the job site (should fail). Moves to the job site coordinates and successfully Clocks-In.
5. **Payment**: Process an Escrow job. Finish the job. Verify internal ledger balances correctly route the 15% commission to the Super Admin and the remainder to the respective Owner or Worker.
6. **SOS**: Press the SOS button as a worker. Verify an alert arrives on the Owner's dashboard.
