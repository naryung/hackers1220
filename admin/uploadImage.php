<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	$path = $_FILES['lecThumbnail']['name'];

	$message = "shit";

	//������ ���� ��츸 ����
	if($path){
	
		$target_dir = $_SERVER['DOCUMENT_ROOT']."/image/";

		$target_name= time().$_SESSION['userIDSession'];

		$target_path = $target_dir.$target_name;

		$target_extention = pathinfo($path, PATHINFO_EXTENSION);

		//echo "�ø� ������ ".$target_path."�̰� Ȯ���ڴ� ".$target_extention;

		$uploadLecOK = 0;		//���� ���ε� �� ���� ���̺� insert ���� ���� ����

		$message = "����ġ ���� ������ �߻��Ͽ����ϴ�. �ٽ� �õ����ּ���!";			//ajax ��û�� ���� ���� �޽��� ����(echo�� ��ȯ ��, message�� 1�� ��� ��� ����)

		$check_extention = array("jpg", "png", "jpeg", "gif");


		if($_FILES['lecThumbnail']['size'] < 1024*1024){
			if(in_array($target_extention, $check_extention)){
				if(move_uploaded_file($_FILES['lecThumbnail']['tmp_name'], $target_path)){
					$uploadLecOK=1;
				}
				else{
					$message = "����ġ ���� ������ �߻��Ͽ����ϴ�. �ٽ� �õ����ּ���!";
				}
			}
			else{
				$message = "�̹��� ���ϸ� ���ε尡 �����մϴ�!";
			}
		}
		else{
			$message = "���� ũ�Ⱑ ���Ѻ��� Ů�ϴ�!";
		}

		//���� ��� ���̺� insert �ϱ�

		if($uploadLecOK===1){
			$sql_file = "insert into file_tbl set fileName = '".$target_name."', fileSize = '".$_FILES['lecThumbnail']['size']."', filePath = '".$target_path."', upldDate = '".date("Y-m-d")."';";

			if(!mysql_query($sql_file)){
				$message = "����ġ ���� ������ �߻��Ͽ����ϴ�. �ٽ� �õ����ּ���!";
				die('Error: '.mysqli_error($connect));
			}
			else{
				$uploadLecOK=1;
			}
		}
	}

?>