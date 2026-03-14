<?php
include 'index.php';
$CI =& get_instance();
$CI->load->database();
$query = $CI->db->get('geopos_roles');
foreach($query->result() as $row) {
    echo $row->id . ': ' . $row->name . "\n";
}
?>
