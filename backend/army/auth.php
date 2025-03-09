<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'connectdb.php';
header("Content-type: application/json");

if (isset($_GET['guId']) && isset($_GET['n'])) {
	$array = array();
	$uId = $_GET['guId'];
	$name = $_GET['n'];
	// $script = $_GET['s'];
	// $vers_script = $_GET['vs'];

	$res = selectJson("SELECT `id`, `blacklist` FROM `accounts` WHERE `guId` = '{$uId}'");
	if (!empty($uId) && count($res) == 1) {
		$mysql->query("UPDATE `accounts` SET `other_name`='{$name}' WHERE `guId` = '{$uId}'");
		if ($res[0]['blacklist'] == "") {
			$array = array([
				'access' => "received",
				'uId' => $res[0]['id'],
				'vers_update' => 41,
				'date_update' => "2025-01-09"
			]);
			// $response = selectJson("SELECT * FROM `update_list` WHERE `script` = '{$script}' AND `vers` > '{$vers_script}' ORDER BY `vers` DESC");
			// if (count($response) == 1) {
			// 	 array_push($array['update'],
			// 		'vers_text' => $response[0]['vers_text'],
			// 		'text' => $response[0]['text'],
			// 		'patches' => $response[0]['patches'],
			// 		'beta' => $response[0]['beta'],
			// 		'date' => $response[0]['date']
			// 	);
			// }
		} else {
			$array[0]['access'] = "black_list";
			$array[0]['text'] = $res[0]['blacklist'];
		}
	} else {
		$mysql->query("INSERT INTO accounts (guId, name, other_name, blacklist) VALUES ('{$uId}', '{$name}', '{$name}', '')");
		$array[0]['access'] = "createUser";
	}
	echo json_encode($array);
} elseif (isset($_GET['activity'])) {
	$data = json_decode(base64_decode(file_get_contents('php://input')));
	if (!empty($data)) {
		$name = $data->response->name;
		$frack = $data->response->frack;
		$server = $data->response->server;
		$script_name = $data->response->script->name;
		$script_vers = $data->response->script->vers;

		$mysql->query("INSERT INTO `activity` (`name`, `frack`, `server`, `script`, `script_vers`) VALUES ('{$name}', '{$frack}', '{$server}', '{$script_name}', '{$script_vers}')");
		$mysql->query("DELETE FROM `activity` WHERE date < now() - interval 1 day");
	}
}
