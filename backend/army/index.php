<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('./connectdb.php');

if (isset($_GET['updates'])) {
	echo selectDB("SELECT `vers` FROM `update` WHERE `_id` = '1'");

} elseif (isset($_GET['update'])) {
	$script = $_GET['update'];
	echo selectDB("SELECT * FROM `update_list` WHERE `script` = `{$script}`");
}
