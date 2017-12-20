<?php
 
	include('uploadImage.php');		//이미지 업로드 파일 추가함

	//강의 목록 테이블에 insert 하기

	if($uploadLecOK===1){
		$sql_lecture = "insert into lecture_tbl set	lecCategory = '".$_POST['lecCategory']."', lecTitle = '".$_POST['lecTitle']."', lecTeacher = '".$_POST['lecTeacher']."', lecLevel = '".$_POST['lecLevel']."', lecTime = '".$_POST['lecTime']."', lecTotal = '".$_POST['lecTotal']."', lecThumbnail = '".$target_name."';";

		if(!mysql_query($sql_lecture)){
			$message = "예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!";
			die('Error: '.mysqli_error($connect));
		}
		else{
			$message=1;
		}
	}

	echo $message;

	mysql_close($connect);
	exit;
?>