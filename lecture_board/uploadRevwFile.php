<?
	include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/fileUpload.php');		//이미지 업로드 파일 추가함


	$send_data = array('result'=>false, 'originName'=>null, 'fileName'=>null, 'filePath'=>null, 'fileSize'=>null, 'message'=>$message);


	if($uploadLecOK===1){
		$send_data['result'] = true;
		$send_data['originName'] = $path;
		$send_data['fileName'] = $target_name;
		$send_data['filePath'] = $target_path;
		$send_data['fileSize'] = $_FILES['fileAttachment']['size'];
	}
	echo json_encode($send_data);
?>