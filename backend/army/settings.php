<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('./connectdb.php');

if (isset($_GET['settings_give']) && isset($_GET['WuId']) && isset($_GET['np'])) 
{
	$name_pr = $_GET['np'];
	$WuId = $_GET['WuId'];
	$settings = file_get_contents('php://input');
	$data = date("Y-m-d H:i:s");
	$mysql->query("REPLACE INTO `transfer_settings` (`whom_id`, `name_profile`, `settings`, `date`) VALUES ('$WuId', '$name_pr', '$settings', '$data')");
}
elseif (isset($_GET['settings_accept']) && isset($_GET['name'])) 
{
	$name = $_GET['name'];
	echo selectDB('SELECT * FROM `transfer_settings` WHERE `whom_id` LIKE \'%' . $name . '%\'');
	$mysql->query("DELETE FROM `transfer_settings` WHERE date < now() - interval 3 minute");
}
elseif (isset($_GET['del_set']) && isset($_GET['name'])) 
{
	$name = $_GET['name'];
	$mysql->query('DELETE FROM `transfer_settings` WHERE `whom_id` = \'' . $name . '\'');
}
