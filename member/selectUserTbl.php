<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php

	if($_SESSION['userIDSession']==null){
		echo "<script>history.back();</script>";
	}
?>

<?php

	$message = "0";
	
	$sql = "select * from user_tbl where userID='".$_SESSION['userIDSession']."';";

	$result = mysql_query($sql);

	if(!$result){

		$message="0";
		die("Error : ".mysqli_error($connect));
	
	}

	if(mysql_num_rows($result)==0){
	
		$message="1";
	
	}else{
		$row = mysql_fetch_assoc($result);
		$message="2";
	}

	mysql_close($connect);
?>