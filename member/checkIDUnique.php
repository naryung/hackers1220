<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	$userID = $_POST["userID"];

	$sql = "select count(*) from user_tbl where userID='".$userID."'";

	$row =	mysql_query($sql);

	while ($db = mysql_fetch_array($row)){
		$sendResult = $db;
	}

	echo $sendResult[0];

	mysql_close($connect);
?>