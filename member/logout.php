<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php
	unset($_SESSION['userIDSession']);
	unset($_SESSION['userNameSession']);
	unset($_SESSION['adminSession']);
	if($_SESSION['userIDSession']==null){
		echo "<script>alert('로그아웃 되었습니다!'); window.location.href='http://test.hackers.com/index.html';</script>";
		exit;
	}
?>