<?
	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	$path = $_FILES['fileAttachment']['name'];

	$message = "no file";	//ajax 요청에 대한 응답 메시지 변수(echo로 반환 시, message가 1일 경우 모두 성공)

	/*
	$target_dir = "{$_SERVER['DOCUMENT_ROOT']}/tmp_image/".$_SESSION[userIDSession];			//경로 설정


	if(is_dir($target_dir)){
		$message = "making directory success";
	}
	else{
		$message = "making directory failed";
		$path = null;
	}
*/
	
	//파일이 있을 경우만 실행
	if($path){
		$target_dir = $_SERVER['DOCUMENT_ROOT']."/image/";			//경로 설정
		$target_name= time().$_SESSION['userIDSession'];			//파일 이름 새로 만들기
		$target_path = $target_dir.$target_name;					//경로 + 파일이름
		$target_extention = pathinfo($path, PATHINFO_EXTENSION);	//확장자

		$uploadLecOK = 0;		//파일 업로드 및 파일 테이블에 insert 성공 여부 변수

		$check_extention = array("jpg", "png", "jpeg", "gif");

		if($_POST['fileAttacher']=="file"){
			//$check_extention = array("php", "html", "htm");
		}

		$message = "파일 크기가 제한보다 큽니다!";

		if($_FILES['fileAttachment']['size'] < 1024*1024){
			
			$message = "이미지 파일만 업로드가 가능합니다!";

			if(in_array($target_extention, $check_extention)){

				$message = "예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!";

				if(move_uploaded_file($_FILES['fileAttachment']['tmp_name'], $target_path)){
					$uploadLecOK=1;
					$message="이미지 업로드를 성공적으로 마쳤습니다!";
				}
			}
		}

		//파일 목록 테이블에 insert 하기

		if($uploadLecOK===1){
			$sql_file = "insert into file_tbl set fileName = '".$target_name."', fileSize = '".$_FILES['fileAttachment']['size']."', filePath = '".$target_path."', upldDate = '".date("Y-m-d")."';";

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