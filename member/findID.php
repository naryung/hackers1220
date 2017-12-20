<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	unset($_SESSION['userIDTmp']);

	$message="0";

	if($_POST['radio']=='phone'){

		$userPhone = $_POST['userPhone1']."-".$_POST['userPhone2']."-".$_POST['userPhone3'];

		$sql = "select userID from user_tbl where userName='".$_POST['userName']."' and userPhone='".$userPhone."';";
	
	}
	else{
		
		$userEmail = $_POST['userEmail1']."@".$_POST['userEmail2'];
		
		$sql = "select userID from user_tbl where userName='".$_POST['userName']."' and userEmail='".$userEmail."';";
	}

	$result = mysql_query($sql);

	if(!$result){

		$message="0";
		die("Error : ".mysqli_error($connect));
	
	}

	if(mysql_num_rows($result)==0){
	
		$message="1";
	
	}else{
		session_start();
		$row = mysql_fetch_assoc($result);
		$message="2";
		$_SESSION['userUserTmp'] = $_POST['userName'];
		$_SESSION['userIDTmp'] = $row['userID'];
		$_SESSION['numCheckID']="123456";
	
	}
	echo $message;

	mysql_close($connect);
	exit;
?>