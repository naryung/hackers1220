<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	//������ ���� ������ ������ ��������!
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