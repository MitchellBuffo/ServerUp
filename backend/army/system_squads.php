<?php 
    require_once('./connectdb.php');

    if (isset($_GET['s']) && isset($_GET['f'])) 
    {
        $frack = $_GET['f'];
        echo selectDB('SELECT * FROM `system_squads` WHERE `frack` LIKE \'%' . $frack . '%\'');
        
    }