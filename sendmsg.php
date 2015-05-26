<?php session_start();

session_write_close();
include_once('mysql_connect.php');

$c = trim(mysql_real_escape_string($_POST['content']));
	if($c=='') {echo"error1"; exit();}


$time = date("Y-m-d H:i:s");
$sql = "insert into msg(send,content,time) values('".$_SESSION['user']."','".$c."','".$time."')";
$result = mysql_query($sql) or die('error2');

if($result){

//更新大家的歷史紀錄
	$sql = "update notify set isnews=1 where isnews <> 1";
	$result2 = mysql_query($sql) or die('error3');

	if($result2) echo "success";
}

?>