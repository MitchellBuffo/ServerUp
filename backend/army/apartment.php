<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('./connectdb.php');

if (isset($_GET['n'])) {
	$num = $_GET['n'];
	$array = array();
	$data = selectJson("SELECT `pos_x`, `pos_y` FROM `apartment` WHERE `number` = '{$num}'");
	if (!empty($data)) {
		$array['have'] = True;
		$array['pos_x'] = $data[0]['pos_x'];
		$array['pos_y'] = $data[0]['pos_y'];
	} else {
		$array['have'] = False;
	}
	echo json_encode($array);
	// $data['response']['pos_x']
}
