<?php

	$get_revwnum = $_GET['revwnum'];

	$sql_content = "select * from revw_tbl where revwNum='".$get_revwnum."';";

	$result_content = mysql_query($sql_content);

	if(!$result_content){
		$message_lec='error';
	}
	else{
		
		if(mysql_num_rows($result_content)>0){
			
			$row_content = mysql_fetch_assoc($result_content);

			$sql_lec = "select * from lecture_tbl where lecNum='".$row_content['lecNum']."';";

			$result_lec = mysql_query($sql_lec);

			if(!$result_lec){
				$message_lec='error';
			}
			else{
				if(mysql_num_rows($result_lec)>0){
					$row_lec = mysql_fetch_assoc($result_lec);
				}
				else{
					$message_lec='empty';
				}

			}

		}
		else{
			$message_lec='error';
		}
	}

	if($message_lec==='error'){
		echo '<script>
				alert("예상치 못한 에러가 발생하였습니다!");
				location.href="/lecture_board/index.php?mode=list";
			</script>';
		exit;
	}

?>