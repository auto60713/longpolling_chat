<?php session_start();

include_once('mysql_connect.php');

	$user = trim(mysql_real_escape_string($_POST['uid']));

	if($user=='') {
		echo 'error1';
		exit();
	}

    //查看使用者是否存在
	$sql = "select name from user where name='".$user."'";
    $result = mysql_query($sql) or die('error2');
    $row = mysql_fetch_array($result);

    if($row[0]==$user){

    	$_SESSION['user'] = $user;
    	echo "success";
    }
    else{  

    //新增使用者

    $time = date("Y-m-d H:i:s");

    $sql = "insert into user(name) values('".$user."')";
    $sql2 = "insert into notify(name,time) values('".$user."','".$time."')";

    $result = mysql_query($sql) or die('error3');
    $result = mysql_query($sql2) or die('error4');

	$_SESSION['user'] = $user;
	echo "success";
    }

?>