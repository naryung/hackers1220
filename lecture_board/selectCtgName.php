<?php

	$sql_ctg = "select ctgCode, ctgName from lecture_category_tbl";

	$result_ctg = mysql_query($sql_ctg);

	if(!result){
		echo "<script>
			alert('예상치 못한 에러가 발생하였습니다!');
			location.href='/lecture_board/index.php?mode=list';
		</script>";
		mysql_close($connect);
		exit;
	}
	
?>