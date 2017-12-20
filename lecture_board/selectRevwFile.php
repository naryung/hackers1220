<?
	$sql_revwfile = "select * from revw_file_tbl where revwNum = '".$_GET['revwnum']."'";

	$result_revwfile = mysql_query($sql_revwfile);

	if(!$result_revwfile){
		echo '<script>
				alert("예상치 못한 에러가 발생하였습니다!'.mysql_error().'");
				location.href="/lecture_board/index.php?mode=list";
			</script>';
		exit;
	}
?>