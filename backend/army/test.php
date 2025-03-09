<?php

// header('Content-type: json/application');

require_once("./connectdb.php");

echo selectDB("SELECT * FROM `accounts`, `update` WHERE `guId` = '3064703860', `_id` = '1'");
