<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php

	if($_POST['agreement']==null){
		//Header("Location:/member/index.php?mode=step_01");
		echo "<script>location.href='/member/index.php?mode=step_01';</script>";
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<!--[if (IE 7)]><html class="no-js ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->
<!--[if (IE 8)]><html class="no-js ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" id="X-UA-Compatible" content="IE=EmulateIE8" />
<title>해커스 HRD</title>
<meta name="description" content="해커스 HRD" />
<meta name="keywords" content="해커스, HRD" />

<!-- 파비콘설정 -->
<link rel="shortcut icon" type="image/x-icon" href="http://img.hackershrd.com/common/favicon.ico" />

<!-- xhtml property속성 벨리데이션 오류/확인필요 -->
<meta property="og:title" content="해커스 HRD" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.hackershrd.com/" />
<meta property="og:image" content="http://img.hackershrd.com/common/og_logo.png" />

<link type="text/css" rel="stylesheet" href="http://q.hackershrd.com/worksheet/css/common.css" />
<link type="text/css" rel="stylesheet" href="http://q.hackershrd.com/worksheet/css/bxslider.css" />
<link type="text/css" rel="stylesheet" href="http://q.hackershrd.com/worksheet/css/main.css" /><!-- main페이지에만 호출 -->
<link type="text/css" rel="stylesheet" href="http://q.hackershrd.com/worksheet/css/sub.css" /><!-- sub페이지에만 호출 -->
<link type="text/css" rel="stylesheet" href="http://q.hackershrd.com/worksheet/css/login.css" /><!-- login페이지에만 호출 -->

<script type="text/javascript" src="http://q.hackershrd.com/worksheet/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="http://q.hackershrd.com/worksheet/js/plugins/bxslider/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="http://q.hackershrd.com/worksheet/js/plugins/bxslider/bxslider.js"></script>
<script type="text/javascript" src="http://q.hackershrd.com/worksheet/js/ui.js"></script>
<!--[if lte IE 9]> <script src="/js/common/place_holder.js"></script> <![endif]-->

<script>
$(function(){
	$(".input-text").change(function(){
		$(this).val($(this).val().replace(/[^0-9:\-]/gi, ""));
	});

	$(".input-text.input-tel").change(function(){
		$("#checkFlag").val('n');
	});
});

</script>



<script type="text/javascript">
	
	function CheckPhoneFunc(){

		if(!$("#num1").val() || !$("#num2").val() || !$("#num3").val()){

			
			alert("휴대폰 번호를 입력하십시오.");

			return false;
			
		}

		$userPhone = $("#num1").val()+"-"+$("#num2").val()+"-"+$("#num3").val();
		$data = "userPhone="+$userPhone;

		$.post("/member/index.php?mode=step_02_send", function(data){

			if(data.result==false){
				alert("알 수 없는 오류가 발생하였습니다. 다시 시도해주세요!");
				$('#checkFlag').val('n');

				return false;
			}

			alert("인증번호를 전송하였습니다. 인증번호를 입력해주세요!");
			$('#checkFlag').val('y');

		}, "json");

	}

	function CheckNumFunc(){
		if($('#checkFlag').val()!='y'){
			alert('먼저 인증번호를 받아주시기 바랍니다!');
			return false;
		}

		$.post("/member/index.php?mode=step_02_check",{ numCheckValue:$('#numCheckValue').val()}, function(data){

			if(data.result==false){

				alert('일치하지 않습니다. 다시 시도해주시기 바랍니다!');
				$('#numCheckValue').focus();
				return false;

			}

			alert('인증에 성공하였습니다!\n(인증으로 사용된 휴대폰 번호 정보는 수정하실 수 없습니다.)');
			document.getElementById('checkNumForm').submit();
			return true;

		}, "json");
	}

</script>

</head><body>
<!-- skip nav -->
<div id="skip-nav">
<a href="#content">본문 바로가기</a>
</div>
<!-- //skip nav -->

<div id="wrap">

<!-- include header -->
<?include("../html/header.html"); ?>

<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">
			<div class="tit-box-h3">
				<h3 class="tit-h3">회원가입</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>회원가입 완료</strong>
				</div>
			</div>

			<div class="join-step-bar">
				<ul>
					<li><i class="icon-join-agree"></i> 약관동의</li>
					<li class="on"><i class="icon-join-chk"></i> 본인확인</li>
					<li class="last"><i class="icon-join-inp"></i> 정보입력</li>
				</ul>
			</div>

			<div class="tit-box-h4">
				<h3 class="tit-h4">본인인증</h3>
			</div>

			<div class="section-content after">
				<form id="checkNumForm" action="/member/index.php?mode=step_03" method="POST">
					<div class="identify-box" style="width:100%;height:190px;">
						<div class="identify-inner">
							<strong>휴대폰 인증</strong>
							<p>주민번호 없이 메시지 수신가능한 휴대폰으로 1개 아이디만 회원가입이 가능합니다. </p>

							<br />
							<input type="text" class="input-text input-tel" style="width:50px" maxlength="3" id="num1" name="phone1"/> - 
							<input type="text" class="input-text input-tel" style="width:50px" maxlength="4"id="num2" name="phone2"/> - 
							<input type="text" class="input-text input-tel" style="width:50px" maxlength="4" id="num3" name="phone3"/>
							<input type="hidden" id="checkFlag" value="n"/>
							<a href="javascript:void(0);" class="btn-s-line" onclick="CheckPhoneFunc();">인증번호 받기</a>

							<br /><br />
							<input type="text" class="input-text" style="width:200px" id="numCheckValue"/>
							<a href="javascript:void(0);" class="btn-s-line" onclick="return CheckNumFunc();">인증번호 확인</a>
						</div>
						<i class="graphic-phon"><span>휴대폰 인증</span></i>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

	<!-- include footer  -->
	<?include("../html/footer.html"); ?>
</div>
</body>
</html>
