<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	//���� ��� ���̺� ������ ��������!

	$sql_count = "select count(*) from lecture_tbl;";
	$sql_count = mysql_query($sql_count);

	if(!$sql_count){

		$message = 0;
	
	}
	else{
		$row_count = mysql_fetch_row($sql_count);
		$total= $row_count[0];
		
		$limit = 5;

		if($_GET['page']==null){	//�� ó�� ���� ���
			$start = 0;
		}
		else{						//������ ��ư�� ���� ���
			
			$get_page = (int)$_GET['page'];

			$start = ($get_page-1)*$limit;
		}

		$sql = "select * from lecture_category_tbl, lecture_tbl where ctgCode=lecCategory order by lecNum desc limit ".$start.",".$limit.";";

		$result = mysql_query($sql);

		if(!$result){
			$message = 0;
		}
	}

	mysql_close($connect);

?>