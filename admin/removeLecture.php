<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	$sql = "delete from lecture_tbl where lecNum='".$_POST['lecNum']."';";

	$result = mysql_query($sql);

	if(!$result){
		$message=0;
	}
	if(mysql_affected_rows()==0){
		$message=1;
	}
	else{
		$message=2;
	}

	echo $message;

	mysql_close($connect);
	exit;

?>