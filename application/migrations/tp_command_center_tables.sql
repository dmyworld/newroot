-- TimberPro Project Command Center Tables

-- 1. Project Basic Details
CREATE TABLE IF NOT EXISTS tp_projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT, -- FK to geopos_locations
    customer_id INT, -- FK to geopos_customers
    project_name VARCHAR(255),
    status ENUM('Planning', 'In-Progress', 'On-Hold', 'Completed') DEFAULT 'Planning',
    total_budget DECIMAL(15,2),
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Project Tasks
CREATE TABLE IF NOT EXISTS tp_project_tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    task_name VARCHAR(255),
    assigned_to INT, -- FK to geopos_employees
    estimated_hours DECIMAL(10,2),
    status ENUM('To-Do', 'Working', 'Done') DEFAULT 'To-Do',
    FOREIGN KEY (project_id) REFERENCES tp_projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Time Tracking (Timesheets)
CREATE TABLE IF NOT EXISTS tp_project_timesheets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    task_id INT,
    worker_id INT, -- FK to geopos_employees
    start_time DATETIME,
    end_time DATETIME,
    duration_minutes INT, -- Automated calculation
    FOREIGN KEY (task_id) REFERENCES tp_project_tasks(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Project Finance Logs
CREATE TABLE IF NOT EXISTS tp_project_finances (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    transaction_type ENUM('Material', 'Labor', 'Overhead'),
    ledger_entry_id INT, -- Link to geopos_transactions or geopos_accounts
    amount DECIMAL(15,2),
    description TEXT,
    FOREIGN KEY (project_id) REFERENCES tp_projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5. Inventory Reservations (Pending Issue)
CREATE TABLE IF NOT EXISTS tp_inventory_reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    product_id INT, -- FK to geopos_products
    qty DECIMAL(15,2),
    status ENUM('Pending', 'Issued', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES tp_projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

