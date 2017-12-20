<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	//선택한 강의 데이터 데이터 가져오기!
	$sql = "select * from lecture_tbl where lecNum='".$_GET['lecture_num']."';";

	$result = mysql_query($sql);

	if(!$result){
		$message = 0;
	}

	if(mysql_num_rows($result)==0){
		$message = 0;
	}
	else{
		$row = mysql_fetch_assoc($result);
	}
	
?>