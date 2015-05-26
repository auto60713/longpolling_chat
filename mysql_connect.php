<?php

$db_server = "localhost";
$db_name   = "test_chat";
$db_user   = "root";
$db_passwd = "1234";

//對資料庫連線
if(!@mysql_connect($db_server, $db_user, $db_passwd))
        die("Unable to connect database");

//資料庫連線採UTF8
mysql_query("SET NAMES utf8");

//選擇資料庫
if(!@mysql_select_db($db_name))
        die("can not use database");
?>  