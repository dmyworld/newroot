<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'dummy');
include 'application/config/database.php';
$db_config = $db['default'];
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function query($conn, $sql) {
    $res = $conn->query($sql);
    if ($res === false) {
        die("Query failed: " . $conn->error . "\nSQL: " . $sql);
    }
    return $res;
}

function get_role_id($conn, $name) {
    $res = query($conn, "SELECT id FROM geopos_roles WHERE name = '$name' LIMIT 1");
    if ($row = $res->fetch_assoc()) return $row['id'];
    query($conn, "INSERT INTO geopos_roles (name) VALUES ('$name')");
    return $conn->insert_id;
}

function hash_password($pass) {
    return password_hash($pass, PASSWORD_BCRYPT);
}

// 1. Ensure Roles
$admin_role = get_role_id($conn, 'Super Admin'); // Existing might be 'Admin', let's stick to user request
$owner_role = get_role_id($conn, 'Business Owner');
$staff_role = get_role_id($conn, 'Branch Staff');
$provider_role = get_role_id($conn, 'Service Provider');
$customer_role = get_role_id($conn, 'Customer');

// Update Role IDs if they were already there but with different names (optional, but safer to use what's there)
query($conn, "UPDATE geopos_roles SET name = 'Super Admin', all_access = 1 WHERE id = 1");
query($conn, "UPDATE geopos_roles SET name = 'Business Owner' WHERE id = 5");

// 1.1 Grant full module-level permissions to Super Admin (Role 1)
for ($i = 1; $i <= 10; $i++) {
    $res = query($conn, "SELECT id FROM geopos_role_permissions WHERE role_id = 1 AND module_id = $i LIMIT 1");
    if (!$res->fetch_assoc()) {
        query($conn, "INSERT INTO geopos_role_permissions (role_id, module_id, can_view, can_add, can_edit, can_delete, can_demo) VALUES (1, $i, 1, 1, 1, 1, 0)");
    } else {
        query($conn, "UPDATE geopos_role_permissions SET can_view=1, can_add=1, can_edit=1, can_delete=1, can_demo=0 WHERE role_id = 1 AND module_id = $i");
    }
}

// 2. Ensure Professions (Type 200)
$professions = [
    ['name' => 'Mason', 'val1' => '5'],
    ['name' => 'Caregiver', 'val1' => '5'],
    ['name' => 'Carpenter', 'val1' => '5']
];

foreach ($professions as $p) {
    $name = $p['name'];
    $val = $p['val1'];
    $res = query($conn, "SELECT id FROM geopos_config WHERE type = 200 AND val2 = '$name' LIMIT 1");
    if (!$res->fetch_assoc()) {
        query($conn, "INSERT INTO geopos_config (type, val1, val2) VALUES (200, '$val', '$name')");
    } else {
        query($conn, "UPDATE geopos_config SET val1 = '$val' WHERE type = 200 AND val2 = '$name'");
    }
}

// 3. Ensure Locations
// Colombo (ID 1), Kandy (ID 2), Galle (new)
query($conn, "INSERT IGNORE INTO geopos_locations (id, cname, address, city, region, country, postbox, phone, email, taxid, logo, ext, cur, ware) VALUES (1, 'Colombo', 'Colombo', 'Colombo', 'Western', 'Sri Lanka', '00000', '000', 'colombo@timberpro.com', '0', 'logo.png', 0, 1, 0)");
query($conn, "INSERT IGNORE INTO geopos_locations (id, cname, address, city, region, country, postbox, phone, email, taxid, logo, ext, cur, ware) VALUES (2, 'Kandy', 'Kandy', 'Kandy', 'Central', 'Sri Lanka', '00000', '000', 'kandy@timberpro.com', '0', 'logo.png', 0, 1, 0)");
query($conn, "INSERT IGNORE INTO geopos_locations (id, cname, address, city, region, country, postbox, phone, email, taxid, logo, ext, cur, ware) VALUES (3, 'Galle', 'Galle', 'Galle', 'Southern', 'Sri Lanka', '00000', '000', 'galle@timberpro.com', '0', 'logo.png', 0, 1, 0)");

// 4. Create Users and Employees
$users = [
    ['username' => 'admin', 'email' => 'admin@admin.com', 'password' => 'unchanged', 'role' => 1, 'loc' => 0, 'name' => 'Admin'],
    ['username' => 'winth', 'email' => 'winth@timberpro.com', 'password' => '123456*', 'role' => 1, 'loc' => 0, 'name' => 'Super Admin'],
    ['username' => 'timberpro_owner', 'email' => 'owner@timberpro.com', 'password' => '123456*', 'role' => 5, 'loc' => 0, 'name' => 'Timber Pro Builders'],
    ['username' => 'Kamal_Mason', 'email' => 'kamal@timberpro.com', 'password' => '123456*', 'role' => $staff_role, 'loc' => 1, 'name' => 'Kamal Perera (Mason)'],
    ['username' => 'Nimal_Carpenter', 'email' => 'nimal@timberpro.com', 'password' => '123456*', 'role' => $staff_role, 'loc' => 2, 'name' => 'Nimal Silva (Carpenter)'],
    ['username' => 'Sunil_Caregiver', 'email' => 'sunil@timberpro.com', 'password' => '123456*', 'role' => $provider_role, 'loc' => 0, 'name' => 'Sunil Fernando (Caregiver)'],
    ['username' => 'ruwan_jay', 'email' => 'ruwan@timberpro.com', 'password' => '123456*', 'role' => $customer_role, 'loc' => 3, 'name' => 'Ruwan Jayawardena']
];

foreach ($users as $u) {
    if ($u['password'] === 'unchanged') continue;
    
    $username = $u['username'];
    $email = $u['email'];
    $raw_pass = $u['password'];
    $role = $u['role'];
    $loc = $u['loc'];
    $name = $u['name'];

    $res = query($conn, "SELECT id FROM geopos_users WHERE username = '$username' OR email = '$email' LIMIT 1");
    if ($row = $res->fetch_assoc()) {
        $uid = $row['id'];
        $salt = md5($uid);
        $pass = hash('sha256', $salt . $raw_pass);
        query($conn, "UPDATE geopos_users SET pass = '$pass', roleid = $role, loc = $loc WHERE id = $uid");
    } else {
        // Insert first with temporary password to get the ID for the salt
        query($conn, "INSERT INTO geopos_users (username, email, pass, roleid, loc) VALUES ('$username', '$email', '', $role, $loc)");
        $uid = $conn->insert_id;
        
        // Now hash and update
        $salt = md5($uid);
        $pass = hash('sha256', $salt . $raw_pass);
        query($conn, "UPDATE geopos_users SET pass = '$pass' WHERE id = $uid");
    }

    // Ensure Employee record
    $res = query($conn, "SELECT id FROM geopos_employees WHERE id = $uid LIMIT 1");
    if (!$res->fetch_assoc()) {
        query($conn, "INSERT INTO geopos_employees (id, username, name, address, city, region, country, postbox, phone, dept, salary, verified)
                      VALUES ($uid, '$username', '$name', 'Private', 'Private', 'Private', 'Sri Lanka', '00000', '000', 0, 0, 1)");
    } else {
        query($conn, $q = "UPDATE geopos_employees SET name = '$name' WHERE id = $uid");
    }
}

// 5. Create Project for Ruwan
$res = query($conn, "SELECT id FROM geopos_users WHERE username = 'ruwan_jay' LIMIT 1");
if ($row = $res->fetch_assoc()) {
    $ruwan_id = $row['id'];
    $project_name = 'House Build 2026';
    // Check if geopos_projects table exists
    $tbl_check = $conn->query("SHOW TABLES LIKE 'geopos_projects'");
    if ($tbl_check && $tbl_check->num_rows > 0) {
        $res_p = $conn->query("SELECT id FROM geopos_projects WHERE name = '$project_name' LIMIT 1");
        if ($res_p && !$res_p->fetch_assoc()) {
            $conn->query("INSERT INTO geopos_projects (name, status, priority, cid, sdate, edate, tag)
                          VALUES ('$project_name', 'Progress', 'Medium', $ruwan_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR), 'Build')");
        }
        echo "Project seeded.\n";
    } else {
        echo "geopos_projects table not found - skipping project creation.\n";
    }
}

echo "Seeding completed successfully.";
?>
