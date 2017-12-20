<?php

	include('uploadImage.php');		//이미지 업로드 파일 추가함

	if(!$path){			//이미지 파일은 수정해지 않을 경우

		$sql = "update lecture_tbl set lecCategory='".$_POST['lecCategory']."', lecTitle='".$_POST['lecTitle']."', lecTeacher='".$_POST['lecTeacher']."', lecLevel='".$_POST['lecLevel']."', lecTime='".$_POST['lecTime']."', lecTotal='".$_POST['lecTotal']."' where lecNum='".$_POST['lecNum']."';";
	
	}
	else{				//이미지 파일도 수정해야 할 경우

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


