<?php
ob_start();

set_time_limit(0);
define('CURRENT_DIR', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
$root_dir_ar = explode(DIRECTORY_SEPARATOR, CURRENT_DIR);
unset($root_dir_ar[count($root_dir_ar) - 2]);
define('BOOTSTRAP_DIR',implode(DIRECTORY_SEPARATOR, $root_dir_ar));
unset($root_dir_ar[count($root_dir_ar) - 2]);
define('ROOT_DIR',implode(DIRECTORY_SEPARATOR, $root_dir_ar) . 'httpdocs/');
include BOOTSTRAP_DIR . 'bootStrap.php';

(new \classes\Encoder() )->Run();
?>