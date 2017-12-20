<?
	$sql_attch = "select r.fileName, realName, fileAttacher, fileSize from revw_file_tbl r, file_tbl f where r.fileName=f.fileName and  revwNum='".$_GET['revwnum']."';";

	$result_attch = mysql_query($sql_attch);

	if(!$result_attch){
		echo "<script>
			alert('예상치 못한 에러가 발생하였습니다!');
			history.back();
		</script>";
		exit;
	}

?>