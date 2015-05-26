<?php session_start();

include_once('mysql_connect.php');

$user = $_SESSION['user'];

// 釋放session 給別之程式用
session_write_close();

//long polling的重點就是用for迴圈卡住 不過server有限制最大連線時間30秒
for($i=0;$i<14;$i++){

	// 0 or 1
	if( isnew($user)=='1' ){

		//時間最新的30筆 防止長久未登入而被灌爆 不過如果流量太大可能會被吃訊息
		//只查詢別人的 自己的對話直接前端增加 製造對話很即時的假象
		$sql = "select send,content from msg where time >(select time from notify where name='".$user."') and send <> '".$user."'order by time desc LIMIT 30";
		$result = mysql_query($sql) or die('error1');

		if($result){

			while($row = mysql_fetch_array($result)){
	          	echo "<p>".$row[0]."：".$row[1]."</p>";
	       	}

			$time = date("Y-m-d H:i:s");
			$sql2 = "update notify set isnews=0 , time ='".$time."' where name='".$user."'";
			$result2 = mysql_query($sql2) or die('error2');
	      
			if($result2) exit();
	       	
		}
	}

//更新速率
	sleep(2);
}



// 判斷是否有新資料
// 封閉區域
function isnew($user){

	$sql = "select isnews from notify where name='".$user."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	return $row[0];
}




?>