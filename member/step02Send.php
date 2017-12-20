<?
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	$_SESSION['numCheck'] = '123456';

	$data = array('result'=>false);

	if($_SESSION['numCheck']!=null){

		$data['result']=true;
	
	}

	echo json_encode($data);
?>