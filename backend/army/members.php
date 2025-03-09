<?php 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once('./connectdb.php');
	


if (isset($_GET['give'])) {
	$response = json_decode(file_get_contents('php://input'));

	$mysql->query("UPDATE `members` SET `data` = NULL WHERE date < now() - interval 1 hour;");

	if (!empty($response)) {
		$name_update = $response->name;
		$frack = $response->frack;
		$server = $response->server;
		$data = base64_decode($response->data);
		$date = date("Y-m-d H:i:s");
		$res = selectJson("SELECT members.id, members.date FROM `members` WHERE members.frack = '{$frack}' AND members.server = '{$server}'");
		if (count($res) == 1) {
			$mysql->query("UPDATE `members` SET `name_update` = '{$name_update}', `data` = '{$data}', `date` = '{$date}' WHERE `members`.`frack` = '{$frack}' AND `members`.`server` = '{$server}'");
		} else {
			$mysql->query("INSERT INTO members (name_update, frack, server, data) VALUES ('{$name_update}', '{$frack}', '{$server}', '{$data}')");
		}
	}
}

		// if ($frack != "") 
		// {
		// 	$mysql->query("DELETE FROM `members` WHERE data < now() - interval 1 day");
		// 	$jsonObject = json_decode(base64_decode(file_get_contents('php://input')));
		// 	$mysql->query('DELETE FROM `members` WHERE `frack` = \'' . $frack . '\'');
		// 	$msg = "INSERT INTO `members` (`id`, `name`, `rank`, `rank_id`, `afk`, `sleep`, `jobs`, `frack`, `data`) VALUES ";
		// 	foreach ($jsonObject as $k => $v) 
		// 	{
		// 		$data = date("Y-m-d H:i:s");
		// 		if ($k != count($jsonObject) - 1) 
		// 		{
		// 			$msg .= "('" . $v[0] . "', '" . $v[1] . "', '" . $v[2] . "', '" . $v[6] . "', '" . $v[3] . "', '" . $v[4] . "', '" . $v[5] . "', '$frack', '$data'), ";
		// 		} 
		// 		else 
		// 		{
		// 			$msg .= "('" . $v[0] . "', '" . $v[1] . "', '" . $v[2] . "', '" . $v[6] . "', '" . $v[3] . "', '" . $v[4] . "', '" . $v[5] . "', '$frack', '$data')";
		// 		}
		// 	}
		// 	$mysql->query($msg);
		// }