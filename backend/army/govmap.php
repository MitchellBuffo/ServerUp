<?php
    require_once('./connectdb.php');
    echo selectJson("SELECT * FROM `gov_map_room` WHERE `name_room` = 'LVA' AND `ip` = '91.215.86'")[0]['uId'];
    if (isset($_GET['room']) && isset($_GET['token']) && isset($_GET['data'])) {
        $room = $_GET['room'];
        $token = $_GET['token'];
        $data = json_decode($_GET['data'])->response;
        $date = date("Y-m-d H:i:s");
        $mysql->query("DELETE FROM `gov_map` WHERE date < now() - interval 30 second");
        $mysql->query("REPLACE INTO gov_map VALUES ('$token', '$data->name', '$data->id', '$data->x', '$data->y', '$data->heading', '$data->room', '$data->int', '$data->car', '$date')");
        echo selectDB("SELECT * FROM `gov_map` WHERE `room` = '$room'");
    } elseif (isset($_GET['room_create'])) {
        $echo = [];
        $data = json_decode(base64_decode(file_get_contents('php://input')));
        $uId = $data->response->uId;
        $ip = $data->response->ip;
        $name_room = $data->response->name_room;
        $name_creater = $data->response->name;
        $password = $data->response->password;
        if (selectJson("SELECT * FROM `gov_map_room` WHERE `uId` = '$uId'")[0]['uId'] > 0) {
            $echo['response'] = "Вы можете создать только одну комнату.";
        } elseif (1 == 1) {
            $echo['response'] = "Имя комнаты занято.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $mysql->query("INSERT INTO gov_map_room (uId, ip, name, name_room, pass) VALUES ('$uId', '$ip', '$name_creater', '$name_room', '$password_hash')"); 
            $echo['response'] = "Комната успешно создана.";
        }
        echo json_encode($echo, JSON_UNESCAPED_UNICODE);
    } elseif (isset($_GET['room_insert_player'])) {
        $data = json_decode(base64_decode(file_get_contents('php://input')))->response;
        $id = $data->id;
        $password = $data->password;
        $my_uId = $data->uId;
        $my_name = $data->name;
        $data_table = selectJson("SELECT * FROM `gov_map_room` WHERE `id` = '$id'")[0];
        if (password_verify($password, $data_table['pass']))
            $mysql->query("INSERT INTO gov_map_players (id, name, room) VALUE ('$my_uId', '$my_name', '$id')");
    } elseif (isset($_GET['room_select'])) {
        echo selectDB("SELECT id, name, name_room FROM `gov_map_room`");
    }
    // {"response":{"uId":121212,"name_room":"LVA","name":"Chase_Pixel","password":"cthutq1221"}} -- Создание комнаты с паролем
    // {"response":{"id":11, "password":"cthutq1221", "uId":121312, "name":"Postors"}} -- Авторизация в комнату
    // [{"_id":112,"name":"Chase_Pixel","frack":"Army SF","interior":1,"car":0,"pos":{"x":100,"y":200,"heading":10},"date":"2023-03-06 12:32:06"}]