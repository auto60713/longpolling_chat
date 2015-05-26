<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Chat room</title>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Originally code by CJCU Zap Improve by AUTOPLAY-->
</head>
<style type="text/css">
*{
	margin: 0px;
	padding: 0px;
}
.logout{
	margin-left: 20px;
	float: right;
	text-decoration: none;
color: #363535;
}
.login-box{
	width: 400px;
	padding: 40px;
	margin: 10% auto 0 auto;
	background-color: #7CADD6;
	color: #FFFFFF;
    text-align: center;
}
#login{
	cursor: pointer;
}
.chat-box{
	padding: 10px;
	height: 600px;
	overflow-y:scroll;
	
}
#msg{
	margin-left: 5px;
}
#msgbox{
	margin-top: 5px;
}
</style>
<body>

<!-- 登入畫面 -->
<div class="login-box">
	<span class="name">暱稱 </span><input type="text" id="uid"><span id="login"> 登入</span>
	<!--h2 id='login_echo'></h2-->
</div>


<!-- 聊天畫面 -->
<div class="chat-box">
	<span id="myname"></span><input type="text" id="msg">
	    <a href="logout.php" class="logout"> 登出</a>
	    <a href="delete_old_msg.php" class="logout"> 清除對話</a>
	<div id="msgbox"></div>
</div>


</body>


<script>
	$(function(){

//未登入前先隱藏聊天室
		$('.chat-box').hide();

		var username = '';

//登入畫面
//如果點擊登入
		$('#login').click(function(event) {
			
			//如果暱稱不為空
			if($('#uid').val()!=''){

				name_input = $('#uid').val();
			
				$.ajax({
					url: 'signin.php',
					type: 'post',
					data: {uid:name_input},
					beforeSend:function(){

						$('.login-box').html($('<h2>').addClass('login_echo').text('登入中，請稍後...'));
					}
				})
				.done(function(data) {

					console.log(data);
                    logined(name_input);
				})
			}
			else alert("暱稱不可為空白");
		});

		//如果抓到_SESSION user
		<?php 

		    if(isset($_SESSION['user'])) echo "logined('".$_SESSION['user']."');"; 

		?>

        //已登入狀態
		function logined(name_input){

            //全域變數
            username = name_input;

            $('#myname').text(username);
            $('.login-box').remove();
            $('.chat-box').fadeIn(200);

            //開始輪詢
			lonpolling();
		}


		function lonpolling(){
		var polling = $.ajax({
				url: 'longpolling.php',
				type: 'post',
				dataType: 'html',
				data: {},
			})
			.done(function(data) {
				console.log(data);
				if(data!="") {

					$('#msgbox').append(data);
				}
			})
			.fail(function(){
				polling.abort();
			})
			.always(function(){
				lonpolling();
			});
		}

		//送出訊息
		$('#msg').keypress(function(e) {
		    if(e.which == 13 && $('#msg').val()!=""){

		    	var msgg = $('#msg').val();
		    	$('#msg').attr('disabled', '').val("");
		    	$('#msgbox').append($('<p>').text(username+"："+msgg));	

			$.ajax({
				url: 'sendmsg.php',
				type: 'post',
				data: {content:msgg},
			})
			.done(function(data) {
				console.log(data);		
				if($.trim(data)=='success'){

					$('#msg').removeAttr('disabled').val("").focus();
				}
					
			})

		    }
		});
	});
</script>
</html>