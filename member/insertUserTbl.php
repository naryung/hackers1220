<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");


	$userName = $_POST['userName'];
	$userID = $_POST['userID'];
	$userPasswd = hash('sha256', $_POST['userPasswd1']);
	$userEmail = $_POST['userEmail1']."@".$_POST['userEmail2'];
	$userPhone = $_POST['userPhone1']."-".$_POST['userPhone2']."-".$_POST['userPhone3'];
	$userTel = $_POST['userTel1']."-".$_POST['userTel2']."-".$_POST['userTel3'];
	$userAddress1 = $_POST['userAddress1'];
	$userAddress2 = $_POST['userAddress2'];
	$userAddress3 = $_POST['userAddress3'];
	$userSMS = $_POST['userSMS'];
	$userMail = $_POST['userMail'];
	$joinDate = date("Y-m-d");
	$modifyDate = date("Y-m-d");


	$sql = "insert into user_tbl set
			userName ='".$userName."',
			userID = '".$userID."',
			userPasswd = '".$userPasswd."',
			userEmail = '".$userEmail."',
			userPhone = '".$userPhone."',
			userTel = '".$userTel."',
			userAddress1 = '".$userAddress1."',
			userAddress2 = '".$userAddress2."',
			userAddress3 = '".$userAddress3."',
			userSMS = '".$userSMS."',
			userMail = '".$userMail."',
			joinDate = '".$joinDate."',
			modifyDate = '".$modifyDate."';";

	$data = array('result'=>false, 'error'=>null);

	if(!mysql_query($sql)){
		$data['result'] = false;
		$data['error'] = mysql_error($connect);
	}
	else{
		$_SESSION['completeTmp']="tmp";
		$data['result'] = true;
	}

	echo json_encode($data);
	
	mysql_close($connect);
	exit;
//끝나따