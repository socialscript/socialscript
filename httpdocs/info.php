<?php
define('ROOT_DIR', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
$root_dir_ar = explode(DIRECTORY_SEPARATOR, ROOT_DIR);
unset($root_dir_ar[count($root_dir_ar) - 2]);
define('APPLICATION_DIR', implode(DIRECTORY_SEPARATOR, $root_dir_ar) . 'application/');
include APPLICATION_DIR . '/lib' . DIRECTORY_SEPARATOR . 'linfo' . DIRECTORY_SEPARATOR . 'index.php';
?>