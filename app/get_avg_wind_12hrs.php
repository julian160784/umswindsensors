<?php
    error_reporting(-1);
    ini_set('display_errors', 'On');
    date_default_timezone_set('Asia/Jakarta');

    require_once 'DbHandler3.php';
    
	//$time    = $_POST["time"];
    
    $db = new DbHandler3();
    $db->get_average_wind_12hrs();
?>