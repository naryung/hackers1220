<?php
	session_start();
	$message = 0;

	if($_SESSION['numCheckID'] == $_POST['idenNum']){
		$message="1";
		unset($_SESSION['numCheckID']);
	}

	echo $message;
	
?>