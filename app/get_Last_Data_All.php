<?php
    error_reporting(-1);
    ini_set('display_errors', 'On');
    date_default_timezone_set('Asia/Jakarta');

    require_once 'DbHandler2.php';
    
	//$id    = $_POST[];
    
    $db = new DbHandler2();
    $db->get_All_last_Data();
?>