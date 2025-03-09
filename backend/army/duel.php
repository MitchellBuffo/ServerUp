<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'connectdb.php';
header("Content-type: application/json");

if (isset($_GET['id'])) {
	$uid = $_GET['id'];

	echo selectDB("SELECT winner, loser, date FROM `settings` WHERE `account` = '{$uid}'");
}
