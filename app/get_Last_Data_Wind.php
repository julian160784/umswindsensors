<?php
    error_reporting(-1);
    ini_set('display_errors', 'On');
    date_default_timezone_set('Asia/Jakarta');

    require_once 'DbHandler.php';
    
	//$id    = $_POST[];
    
    $db = new DbHandler();
    $db->get_All_last_Wind();
?>