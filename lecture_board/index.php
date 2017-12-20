<?php
	$mode = $_GET[mode];

	$urlRoot = $_SERVER['DOCUMENT_ROOT'];

	switch($mode){
		case 'list' :
			include $urlRoot."/lecture_board/showList.php";
			break;

		case 'write' :
			include $urlRoot."/lecture_board/writePost.php";
			break;

		case 'view' :
			include $urlRoot."/lecture_board/showPost.php";
			break;

		case 'modify' :
			include $urlRoot."/lecture_board/writePost.php";
			break;
		
		case 'delete' :
			include $urlRoot."/lecture_board/deletePost.php";
			break;

		default :
			Header("Location:/lecture_board/index.php?mode=list");
			break;
	}
?>