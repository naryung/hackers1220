<?php

	include('uploadImage.php');		//�̹��� ���ε� ���� �߰���

	if(!$path){			//�̹��� ������ �������� ���� ���

		$sql = "update lecture_tbl set lecCategory='".$_POST['lecCategory']."', lecTitle='".$_POST['lecTitle']."', lecTeacher='".$_POST['lecTeacher']."', lecLevel='".$_POST['lecLevel']."', lecTime='".$_POST['lecTime']."', lecTotal='".$_POST['lecTotal']."' where lecNum='".$_POST['lecNum']."';";
	
	}
	else{				//�̹��� ���ϵ� �����ؾ� �� ���

		$sql = "update lecture_tbl set lecCategory='".$_POST['lecCategory']."', lecTitle='".$_POST['lecTitle']."', lecTeacher='".$_POST['lecTeacher']."', lecLevel='".$_POST['lecLevel']."', lecTime='".$_POST['lecTime']."', lecTotal='".$_POST['lecTotal']."', lecThumbnail='".$_FILES['lecThumbnail']['name']."' where lecNum='".$_POST['lecNum']."';";

	}
	
	$result = mysql_query($sql);

	if(!$result){
		$message=0;
	}
	else{
		$message=2;
	}

	echo $message;

	mysql_close($connect);
	exit;

?>


