<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
	
	$sql = "select userID, userPasswd, userName, userLevel from user_tbl where userID='".$_POST['userID']."'";

	$result = mysql_query($sql);

	if(!$result){
		$message = "예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!";
	}

	if(mysql_num_rows($result)==0){
		$message = "존재하지 않는 아이디입니다. 다시 시도해주세요!";
	}

	else{

		$row = mysql_fetch_assoc($result);

		$passwd = hash('sha256', $_POST['userPasswd']);

		if(strcmp($row['userPasswd'], $passwd)==0){

			$_SESSION['userIDSession'] = $row['userID'];
			$_SESSION['userNameSession'] = $row['userName'];
			
			if($row['userLevel']!=null){

				$_SESSION['adminSession']="m";
			
			}

			$message = "2";

		}
		else{

			$message = "아이디와 비밀번호가 일치하지 않습니다. 다시 시도해주세요!";

		}
	
	}

	echo $message;

	mysql_close($connect);

?>