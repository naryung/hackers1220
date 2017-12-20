<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	$path = $_FILES['lecThumbnail']['name'];

	$message = "shit";

	//파일이 있을 경우만 실행
	if($path){
	
		$target_dir = $_SERVER['DOCUMENT_ROOT']."/image/";

		$target_name= time().$_SESSION['userIDSession'];

		$target_path = $target_dir.$target_name;

		$target_extention = pathinfo($path, PATHINFO_EXTENSION);

		//echo "올릴 파일은 ".$target_path."이고 확장자는 ".$target_extention;

		$uploadLecOK = 0;		//파일 업로드 및 파일 테이블에 insert 성공 여부 변수

		$message = "예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!";			//ajax 요청에 대한 응답 메시지 변수(echo로 반환 시, message가 1일 경우 모두 성공)

		$check_extention = array("jpg", "png", "jpeg", "gif");


		if($_FILES['lecThumbnail']['size'] < 1024*1024){
			if(in_array($target_extention, $check_extention)){
				if(move_uploaded_file($_FILES['lecThumbnail']['tmp_name'], $target_path)){
					$uploadLecOK=1;
				}
				else{
					$message = "예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!";
				}
			}
			else{
				$message = "이미지 파일만 업로드가 가능합니다!";
			}
		}
		else{
			$message = "파일 크기가 제한보다 큽니다!";
		}

		//파일 목록 테이블에 insert 하기

		if($uploadLecOK===1){
			$sql_file = "insert into file_tbl set fileName = '".$target_name."', fileSize = '".$_FILES['lecThumbnail']['size']."', filePath = '".$target_path."', upldDate = '".date("Y-m-d")."';";

			if(!mysql_query($sql_file)){
				$message = "예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!";
				die('Error: '.mysqli_error($connect));
			}
			else{
				$uploadLecOK=1;
			}
		}
	}

?>