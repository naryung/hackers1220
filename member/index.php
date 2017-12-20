<?php
	$mode = $_GET[mode];

	$urlRoot = $_SERVER['DOCUMENT_ROOT'];

	switch($mode){
		case 'step_01' :
			include $urlRoot."/register/step_01.html";
			break;
		
		case 'step_02' :
			include $urlRoot."/register/step_02.php";
			break;

		case 'step_02_send' :
			include $urlRoot."/member/step02Send.php";
			break;

		case 'step_02_check' :
			include $urlRoot."/member/step02Check.php";
			break;
		
		case 'step_03' :
			include $urlRoot."/register/step_03.php";
			break;

		case 'regist' :
			include $urlRoot."/member/insertUserTbl.php";
			break;

		case 'complete' :
			include $urlRoot."/register/complete.php";
			break;

		case 'login_check' : 
			include $urlRoot."/member/checkLogin.php";
			break;

		case 'find_id' :
			include $urlRoot."/html/find_id.html";
			break;

		case 'finding_id' :
			include $urlRoot."/member/findID.php";
			break;

		case 'find_id_session_check' :
			include $urlRoot."/member/findIDSessionCheck.php";
			break;

		case 'found_id' :
			include $urlRoot."/html/found_id.html";
			break;

		case 'find_pass' :
			include $urlRoot."/html/find_pass.html";
			break;

		case 'finding_pass' :
			include $urlRoot."/member/findPass.php";
			break;

		case 'find_pass_session_check' :
			include $urlRoot."/member/findPassSessionCheck.php";
			break;

		case 'found_pass' :
			include $urlRoot."/html/found_pass.html";
			break;
		
		case 'found_pass_modify' :
			include $urlRoot."/member/modifyPass.php";
			break;

		case 'modify' :
			include $urlRoot."/html/modify.php";
			break;

		case 'modify_update' :
			include $urlRoot."/member/modifyAll.php";
			break;

		default :
			Header("Location:/index.html");
			break;
	}
?>