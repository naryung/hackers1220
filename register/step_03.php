<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php

	if($_POST['phone1']==null || $_POST['phone2']==null || $_POST['phone3']==null){
		//Header("Location:/member/index.php?mode=step_02");
		echo "<script>location.href='/member/index.php?mode=step_02';</script>";
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

<script type="text/javascript">

	$(function(){
		$("#userID").change(function(){
			$("#checkIDFlag").val('n');
		});

		$(".input-text.num-text").change(function(){
			$(this).val($(this).val().replace(/[^0-9:\-]/gi, ""));
		});

		$("#selectEmailType").change(function(){
			$("#userEmail2").val($(this).val());
		});
	});

	function checkID(){

		$userID = $("#userID").val();

		if($userID.length<4 || !$userID[0].match(/[a-z]/) || !$userID.match(/[a-z]*[0-9]/) || $userID.match(/[A-Z]/)){
			alert("아이디는 영문자로 시작하는 4~15자의 영문소문자, 숫자로 설정해야 합니다!");
		}
		else if($userID){
			$formData="userID="+$userID;

			$.ajax({
				type : "POST",
				url : "../member/checkIDUnique.php",
				data : $formData,
				dataType: "text",
				success : function(data){
					if(data=="1"){
						alert("이미 존재하는 아이디입니다! 다른 아이디를 입력해주세요!");
					}
					else{
						alert("사용 가능한 아이디입니다!");
						$("#checkIDFlag").val('y');
					}
				},
				error: function(request, status, error){
					alert("error : "+status);
					
				}
			});
		}
	}

	function RegisterFunc(){

		if($("#checkIDFlag").val()=='n'){
			alert("아이디 중복확인을 해야 합니다!");
			return false;
		}

		$userPswd = $("#userPasswd1").val();

		if($userPswd.length<8 || !$userPswd.match(/[a-z]*[0-9]/) || $userPswd.match(/[A-Z]/)){
			alert("비밀번호는 8-15자의 영문자/숫자 혼합으로 설정해야 합니다!");
			$("#userPasswd1").focus();
			return false;
		}

		<?php
		
		$dataIdArray = array('userName', 'userID', 'userPasswd1', 'userPasswd2', 'userEmail1', 'userEmail2', 'userTel1', 'userTel2', 'userTel3', 'userAddress1', 'userAddress2', 'userAddress3', 'userSMS', 'userMail');

			foreach($dataIdArray as $value){
				echo "var ".$value." = document.getElementById('".$value."');";
			}

			foreach($dataIdArray as $value){
				echo "if(!".$value.".value){";
				echo	"alert('필수 사항을 입력해주세요!');";
				echo	$value.".focus();";
				echo	"return false; }";
			}
		?>

			
		if($("#userPasswd1").val() !== $("#userPasswd2").val()){
			alert("비밀번호가 일치하지 않습니다. 다시 입력해주세요!");
			return false;
		}

		
		//예외 상황이 없을 경우 데이터를 등록
		$.post("/member/index.php?mode=regist", $("#registerForm").serialize(), function(data){
			if(data.result==false){
				alert("예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!\n("+data.error+")");
				return false;
			}

			location.href = "/member/index.php?mode=complete";
		}, "json");

		//document.getElementById("registerForm").submit();
	}

</script>



<!-- http://postcode.map.daum.net/guide 참고 -->
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
    function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = ''; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;

                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                if(data.userSelectedType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('userAddress1').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('userAddress2').value = fullAddr;

                // 커서를 상세주소 필드로 이동한다.
                document.getElementById('userAddress3').focus();
            }
        }).open();
    }
</script>

</head><body>
<!-- skip nav -->
<div id="skip-nav">
<a href="#content">본문 바로가기</a>
</div>
<!-- //skip nav -->

<div id="wrap">

<?include("../html/header.html"); ?>

<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">
			<div class="tit-box-h3">
				<h3 class="tit-h3">회원가입</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>회원가입</strong>
				</div>
			</div>

			<div class="join-step-bar">
				<ul>
					<li><i class="icon-join-agree"></i> 약관동의</li>
					<li><i class="icon-join-chk"></i> 본인확인</li>
					<li class="last on"><i class="icon-join-inp"></i> 정보입력</li>
				</ul>
			</div>

			<div class="section-content">
				<form id="registerForm">
					<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
						<caption class="hidden">강의정보</caption>
						<colgroup>
							<col style="width:15%"/>
							<col style="*"/>
						</colgroup>

						<tbody>
							<tr>
								<th scope="col"><span class="icons">*</span>이름</th>
								<td><input type="text" class="input-text" style="width:302px" name="userName" id="userName" maxlength="5"/></td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>아이디</th>
								<td><input type="text" class="input-text" style="width:302px" placeholder="영문자로 시작하는 4~15자의 영문소문자, 숫자" name="userID" id="userID" maxlength="15"/><a href="javascript:void(0);" onclick="return checkID();" class="btn-s-tin ml10">중복확인</a></td>
								<input type="hidden" id="checkIDFlag" value="n"/>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>비밀번호</th>
								<td><input type="password" class="input-text" style="width:302px" placeholder="8-15자의 영문자/숫자 혼합" name="userPasswd1" id="userPasswd1" maxlength="15"/></td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>비밀번호 확인</th>
								<td><input type="password" class="input-text" style="width:302px" name="userPasswd2" id="userPasswd2" maxlength="15"/></td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>이메일주소</th>
								<td>
									<input type="text" class="input-text" style="width:138px" name="userEmail1" id="userEmail1" maxlength="20"/> @ <input type="text" class="input-text" style="width:138px"  name="userEmail2" id="userEmail2" maxlength="20"/>
									<select class="input-sel" style="width:160px" id="selectEmailType">
										<option value="">직접입력</option>
										<option value="naver.com">naver.com</option>
										<option value="gmail.com">gmail.com</option>
										<option value="hanmail.com">hanmail.com</option>
										<option value="nate.com">nate.com</option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>휴대폰 번호</th>
								<td>
									<input type="text" class="input-text num-text" style="width:50px" name="userPhone1" id="userPhone1" value="<?=$_POST['phone1']?>" readonly/> - 
									<input type="text" class="input-text num-text" style="width:50px" name="userPhone2" id="userPhone2" value="<?=$_POST['phone2'];?>" readonly/> - 
									<input type="text" class="input-text num-text" style="width:50px" name="userPhone3" id="userPhone3" value="<?=$_POST['phone3'];?>" readonly/>
								</td>
							</tr>
							<tr>
								<th scope="col"><span class="icons"></span>일반전화 번호</th>
								<td><input type="text" class="input-text num-text" style="width:88px" name="userTel1" id="userTel1" maxlength="3"/> - <input type="text" class="input-text num-text" style="width:88px" name="userTel2" id="userTel2" maxlength="4"/> - <input type="text" class="input-text num-text" style="width:88px" name="userTel3" id="userTel3" maxlength="4"/></td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>주소</th>
								<td>
									<p >
										<label>우편번호 <input type="text" class="input-text ml5" style="width:242px" name="userAddress1" id="userAddress1" readonly /></label><a href="javascript:void(0);" class="btn-s-tin ml10" onclick="return execDaumPostcode();">주소찾기</a>
									</p>
									<p class="mt10">
										<label>기본주소 <input type="text" class="input-text ml5" style="width:719px" name="userAddress2" id="userAddress2" maxlength="50"/></label>
									</p>
									<p class="mt10">
										<label>상세주소 <input type="text" class="input-text ml5" style="width:719px" name="userAddress3" id="userAddress3" maxlength="50"/></label>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>SMS수신</th>
								<td>
									<div class="box-input">
										<label class="input-sp">
											<input type="radio" name="userSMS" id="userSMS" value="y" checked="checked"/>
											<span class="input-txt">수신함</span>
										</label>
										<label class="input-sp">
											<input type="radio" name="userSMS"  id="userSMS" value="n"/>
											<span class="input-txt">미수신</span>
										</label>
									</div>
									<p>SMS수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
								</td>
							</tr>
							<tr>
								<th scope="col"><span class="icons">*</span>메일수신</th>
								<td>
									<div class="box-input">
										<label class="input-sp">
											<input type="radio" name="userMail" id="userMail" value="y" checked="checked"/>
											<span class="input-txt">수신함</span>
										</label>
										<label class="input-sp">
											<input type="radio" name="userMail" id="userMail" value="n"/>
											<span class="input-txt">미수신</span>
										</label>
									</div>
									<p>메일수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
								</td>
							</tr>
						</tbody>
					</table>

				</form>

				<div class="box-btn">
					<a href="javascript:void(0);" class="btn-l" onclick="return RegisterFunc();">회원가입</a>
				</div>
			</div>
		</div>
	</div>
</div>

	<?include("../html/footer.html"); ?>

</div>
</body>
</html>
