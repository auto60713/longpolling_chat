<?php session_start();
header('Content-Type: text/html; charset=utf8');

//此php為刪除舊訊息 以維持資料庫整潔 減輕負擔
session_write_close();
include_once('mysql_connect.php');

//一個月前的話應該也沒啥時效性了吧
$time = date("Y-m-d H:i:s",strtotime("-30 days"));
$sql = "DELETE FROM msg WHERE time < '".$time."'";
$result = mysql_query($sql) or die('error');

if($result){

    echo '已刪除一個月之前的舊訊息';
}

?>