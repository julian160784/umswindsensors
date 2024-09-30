<?php

    error_reporting(-1);
    ini_set('display_errors', 'On');
    date_default_timezone_set('Asia/Jakarta');
    $fileku = $_SERVER['DOCUMENT_ROOT'] . "/umswindsensor/storage/app/datasensor/ws3sec.txt";
    $myfile = fopen($fileku, "r") or die("Unable to open file!");
    $isi_file = fread($myfile,filesize($fileku));
    echo '{"results":['.$isi_file .']}';
    fclose($myfile);

?>