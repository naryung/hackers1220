<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php

	if($_SESSION['userIDSession']!=null){
		echo "<script>history.back();</script>";
	}
?>

<?php

	$message="0";

	$pss = hash('sha256', $_POST['userPasswdM']);

	$sql = "update user_tbl set userPasswd='".$pss."' where userID='".$_POST['userID']."';";

	$result = mysql_query($sql);

	if(!$result){
		$message="0";
		die("Error : ".mysqli_error($connect));
	}
	//if(mysql_affected_rows()==0){
	//	$message="1";
	//}
	else{
		$message="2";
	}

	echo $message;

	mysql_close($connect);
	exit;
?>