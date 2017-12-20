<?php
	session_start();
	$message = 0;

	if($_SESSION['numCheckPass'] == $_POST['idenNum']){
		$message="1";
		unset($_SESSION['numCheckPass']);
	}

	echo $message;
	
?>