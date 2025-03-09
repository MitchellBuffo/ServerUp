<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'connectdb.php';
header("Content-type: application/json");
// ! «апрещено получать дату слета домов
if (isset($_GET['gathering'])) { 
	$array = array();
	$array['status'] = "denied";
	$data = json_decode(base64_decode(file_get_contents('php://input')));

	if (!empty($data)) {
		$uId = $data->response->gUId;
		$name = $data->response->name;
		$server = $data->response->server;
		$date = $data->response->house->date;
		$time = $data->response->house->time;
		$res = selectJson("SELECT `name`, `date`, `time` FROM `house` WHERE `uId` = '{$uId}'");
		if (!empty($uId) && count($res) == 1) {
			$mysql->query("UPDATE `house` SET `date`='{$date}', `time`='{$time}' WHERE `uId` = '{$uId}'");
			$array['status'] = "successfully";
		} else {
			$mysql->query("INSERT INTO `house` (`uId`, `name`, `server`, `date`, `time`) VALUES ('{$uId}', '{$name}', '{$server}', '{$date}', '{$time}')");
			$array['status'] = "successfully";
		}
		
	}
	echo json_encode($array);
	// {"response":{"server":"135.125.189.168","house":{"date":"2025\/01\/01","time":"02:00"},"gUId":2292562178,"name":"Major_Sersic"}}
	// echo json_encode(value: $data);
}