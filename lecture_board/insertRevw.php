<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	$today_date = Date("y-m-d");

	/*

	$checkCopyDir = false;

	$oldDir = "{$_SERVER['DOCUMENT_ROOT']}/tmp_image".$_SESSION['userIDSession'];
	$newDir = "{$_SERVER['DOCUMENT_ROOT']}/image";

	if(copy($oldDir, $newDir)){
		$checkCopyDir = true;
	}

	

	if($checkCopyDir){

		rmdir($oldDir);
		*/

		$sql = "insert into revw_tbl set revwTitle='".$_POST['revwTitle']."', revwWriterID='".$_SESSION['userIDSession']."', revwSatisfaction='".$_POST['revwSatisfaction']."', revwContent='".$_POST['revwContent']."', revwDate='".$today_date."', revwModifyDate='".$today_date."', lecNum='".$_POST['lecNum']."'";

		$result = mysql_query($sql);

		$message = array('success'=>false, 'idValue'=>null, 'filesuccess'=>true, 'fileinfo'=>$_POST['fileInfo']);

		if($result){
			if(mysql_insert_id()>0){
				$message = array('success'=>true, 'idValue'=>mysql_insert_id(), 'filesuccess'=>true);
			}
		}

		if($_POST['fileInfo'] !=null && $message['idValue'] != null){

			foreach($_POST['fileInfo'] as $value){

				$file_value = explode("...", $value);

				$sql_revwfile = "insert into revw_file_tbl set revwNum='".$message['idValue']."', fileName='".basename($file_value[0])."', realName='".$file_value[1]."', fileAttacher='".$file_value[2]."';";
				$result_revwfile = mysql_query($sql_revwfile);

				if(!$result_revwfile){
					$message = array('success'=>true, 'idValue'=>mysql_insert_id(), 'filesuccess'=>false);
				}
			}
		}
		/*
	}
	else{
		$message =  array('success'=>false);
	}
	*/
	
	echo json_encode($message);

	mysql_close($connect);
	exit;

?>