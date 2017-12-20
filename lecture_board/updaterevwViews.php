<?php

	$sql_views = "update revw_tbl set revwViews = revwViews + 1 where revwNum='".$_GET['revwnum']."'";

	$result_views = mysql_query($sql_views);

	if(!$result_views){
		echo '<script>alert("조회수 반영 실패..");</script>';
		exit;
	}

?>