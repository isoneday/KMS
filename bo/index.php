<?php
// Script start
//$rustart = getrusage();
error_reporting(0);
// Code ...
/*
 * Jangan Menambah apapun disini.
 * 
 */
$gtfw_base_dir = @file_get_contents('config/gtfw_base_dir.def');
$gtfw_base_dir = str_replace('\\', '/', trim($gtfw_base_dir));
$gtfw_base_dir = preg_replace('/[\/]+$/', '', $gtfw_base_dir);
if (file_exists($gtfw_base_dir)) {
    define('GTFW_BASE_DIR', $gtfw_base_dir . '/');
    define('GTFW_APP_DIR', str_replace('\\', '/', dirname(__FILE__)) . '/');

    require_once GTFW_BASE_DIR.'index.php';

} else {
    echo 'Fatal Error: Cannot find GTFW base!';
}

// Script end
// function rutime($ru, $rus, $index) {
//     return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
//      -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
// }

// $ru = getrusage();
// echo "This process used " . rutime($ru, $rustart, "utime") .
//     " ms for its computations\n";
// echo "It spent " . rutime($ru, $rustart, "stime") .
//     " ms in system calls\n";
?>
