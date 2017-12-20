<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>


<?php
	if($_SESSION['userIDSession']==null){
		echo "<script>history.back();</script>";
	}
?>

<?

	$userPasswd = hash('sha256', $_POST['userPasswd']);
	$userEmail = $_POST['userEmail1']."@".$_POST['userEmail2'];
	$userTel = $_POST['userTel1']."-".$_POST['userTel2']."-".$_POST['userTel3'];
	$modDate = date("Y-m-d");

	$sql = "update user_tbl set userID='".$_POST['userID']."', userPasswd='".$userPasswd."', userEmail='".$userEmail."', userTel='".$userTel."', userAddress1='".$_POST['userAddress1']."', userAddress2='".$_POST['userAddress2']."', userAddress3='".$_POST['userAddress3']."', userSMS='".$_POST['userSMS']."', userMail='".$_POST['userMail']."', modifyDate='".$modDate."' where userID='".$_SESSION['userIDSession']."';";

	$result = mysql_query($sql);

	if(!$result){
		$message="0";
		die("Error : ".mysqli_error($connect));
	}
	//if(mysql_affected_rows()==0){
	//	$message="1";
	//}
	else{
		$_SESSION['userIDSession'] = $_POST['userID'];
		$message="2";
	}

	echo $message;

	mysql_close($connect);
	exit;
?>