<?
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	$data = array('result'=>false);

	if($_POST['numCheckValue'] == $_SESSION['numCheck']){
		$data['result']=true;
	}
	
	echo json_encode($data);
?>