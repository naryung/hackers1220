<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");


	unset($_SESSION['userPassTmp']);

	$message = "0";

	if($_POST['radio']=='phone'){

		$userPhone = $_POST['userPhone1']."-".$_POST['userPhone2']."-".$_POST['userPhone3'];
		
		$sql = "select userPasswd from user_tbl where userName='".$_POST['userName']."' and userID='".$_POST['userID']."' and userPhone='".$userPhone."';";
	
	}
	else{
		
		$userEmail = $_POST['userEmail1']."@".$_POST['userEmail2'];
		
		$sql = "select userPasswd from user_tbl where userName='".$_POST['userName']."' and userID='".$_POST['userID']."' and userEmail='".$userEmail."';";
	}

	$result = mysql_query($sql);

	if(!$result){

		$message="0";
		die("Error : ".mysqli_error($connect));
	
	}

	if(mysql_num_rows($result)==0){
	
		$message="1";
	
	}else{
		$message="2";
		$_SESSION['userPassTmp'] = "tmp";
		$_SESSION['numCheckPass']="123456";
		$_SESSION['userIDTmp'] = $_POST['userID'];
	}

	echo $message;

	mysql_close($connect);
	exit;

?>