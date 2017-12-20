<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php
	$mode = $_GET[mode];

	$urlRoot = $_SERVER['DOCUMENT_ROOT'];

	switch($mode){
		case 'regist' :
			include $urlRoot."/admin/register.html";
			break;

		case 'regist_lecture' :
			include $urlRoot."/admin/registLecture.php";
			break;

		case 'modify' :
			include $urlRoot."/admin/modify.html";
			break;

		case 'modify_lecture' :
			include $urlRoot."/admin/modifyLecture.php";
			break;

		case 'remove_lecture' :
			include $urlRoot."/admin/removeLecture.php";
			break;

		default :
			//Header("Location:/admin/index.html");
			echo "<script>location.href='/admin/index.html';</script>";
			break;
	}

?>