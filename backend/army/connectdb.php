<?php 
    $mysql = new PDO(
        'mysql:host=127.0.0.1;dbname=army_sp', 
        'moretz', 
        'SVr-w4s-cJu-VvM'
    );
    $mysql->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    function selectDB($value) 
    {
        global $mysql;
        $query = $mysql->prepare($value);
        $query->execute();
        $res = $query->fetchAll();
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    function selectJson($value) 
    {
        global $mysql;
        $query = $mysql->prepare($value);
        $query->execute();
        $res = $query->fetchAll();
        return $res;
    }