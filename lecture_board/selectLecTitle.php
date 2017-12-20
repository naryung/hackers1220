<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	$sql = "select lecNum, lecTitle from lecture_tbl where lecCategory='".$_POST['ctgCode']."';";

	$result = mysql_query($sql);

	$send_data = array( 0 =>'empty');

	if($result){
		if(mysql_num_rows($result)>0){

			$send_data = null;

			while($row = mysql_fetch_assoc($result)){

				$tmp = new stdClass();

				$tmp->lecNum = $row['lecNum'];
				$tmp->lecTitle = $row['lecTitle'];

				$send_data[] = $tmp;

				unset($tmp);
			}
		}
	}

	print_R(json_encode($send_data));

	mysql_close($connect);
	exit;
?>