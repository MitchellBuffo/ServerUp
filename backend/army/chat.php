<?php 
	try {
	  	$mysql = new PDO('mysql:host=127.0.0.1;dbname=army_sp', 'moretz', 'cthutq1221');
	} catch (PDOException $e) {
	  	print "Error!: " . $e->getMessage();
	  	die();
	}
	$mysql->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	function selectDB($value) {
		global $mysql;
		$query = $mysql->prepare($value);
		$query->execute();
		$res = $query->fetchAll();
		return $res;
	}
	if (isset($_GET['give'])) {
		$data = json_decode(base64_decode(file_get_contents('php://input')));
		$uId = $data->uId;
		$nick = $data->nick;
		$id = $data->id;
		$date = date("Y-m-d H:i:s");
		$mysql->query("REPLACE INTO `chat_users` (`id_table`, `nick`, `id`, `date`) VALUES ('$uId', '$nick', '$id', '$date')");


		$mysql->query("DELETE FROM `chat_users` WHERE date < now() - interval 30 second");
		$mysql->query("DELETE FROM `chat_message` WHERE date < now() - interval 1 day");
		$array = array();
		$response = selectDB("SELECT * FROM `chat_message` ORDER BY id ASC");
		foreach ($response as $key => $v) {
			$array["message"][$key][0] = $v['nick']; 
			$array["message"][$key][1] = $v['text'];
			$array["message"][$key][2] = $v['server'];
			$array["message"][$key][3] = $v['prefix'];
			$array["message"][$key][4] = $v['date_chat'];
		}
		$response = selectDB("SELECT * FROM `chat_users`");
		foreach ($response as $key => $v) {
			$array["users"][$key][0] = $v['nick'];
			$array["users"][$key][1] = $v['id'];
			$array["users"][$key][2] = $v['mute'];
			$array["users"][$key][3] = $v['ban'];
		}
		echo json_encode($array);
	} elseif (isset($_GET['add_message'])) {
		$data = json_decode(base64_decode(file_get_contents('php://input')));
		$nick = $data->nick;
		$text = $data->text;
		$server = $data->server;
		$prefix = $data->prefix;
		$date = date("Y-m-d H:i:s");
		$date_chat = date("H:i:s");
		$mysql->query("INSERT INTO `chat_message` (`nick`, `text`, `server`, `prefix`, `date_chat`, `date`) VALUES ('$nick', '$text', '$server', '$prefix', '$date_chat', '$date')");
	}
?>