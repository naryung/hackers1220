<?
	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	if($_POST['revwWriterID'] !== $_SESSION['userIDSession']){
		$message=0;
	}

	$sql = "delete from revw_tbl where revwNum='".$_POST['revwNum']."';";
	
	$result = mysql_query($sql);

	if(!$result){
		$message=0;
	}

	if(mysql_affected_rows()>0){
		$message=2;

		$sql_file = "delete from revw_file_tbl where revwNum='".$_POST['revwNum']."';";

		$result_file = mysql_query($sql_file);

		if(!$result_file){
			$message=0;
		}
	}
	
	mysql_close($connect);
	
	echo $message;
	
	exit;
?>