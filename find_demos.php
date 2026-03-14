<?php
include 'index.php';
$CI =& get_instance();
$CI->load->database();
$roles = ['Business Owner', 'Service Provider', 'Customer'];
$query = $CI->db->select('u.id, u.username, u.email, r.name as role')
    ->from('geopos_users u')
    ->join('geopos_employees e', 'e.id = u.id')
    ->join('geopos_roles r', 'r.id = e.roleid')
    ->where_in('r.name', $roles)
    ->get();

foreach($query->result() as $row) {
    echo $row->id . ': ' . $row->username . ' (' . $row->role . ') [' . $row->email . "]\n";
}
?>
