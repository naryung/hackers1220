<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");
?>

<?php

	include($_SERVER['DOCUMENT_ROOT'].'/member/selectUserTbl.php');

	if($_SESSION['userIDSession']==null){
		echo "asdf";
		Header('Location:/index.html');
		exit;
	}
	
	if($message=="0" || $message=="1"){
		Header('Location:/index.html');
		exit;
	}

	if($row['userSMS']=="y"){
		$ySMS="checked='checked'";
	}else{
		$nSMS="checked='checked'";
	}

	if($row['userMail']=="y"){
		$yMail="checked='checked'";
	}else{
		$nMail="checked='checked'";
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

<script tyep="text/javascript">

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
		<?php echo "var originID = '".$_SESSION['userIDSession']."'";?>

		if($userID.length<4 || !$userID[0].match(/[a-z]/) || !$userID.match(/[a-z]*[0-9]/) || $userID.match(/[A-Z]/)){

			alert("아이디는 영문자로 시작하는 4~15자의 영문소문자, 숫자로 설정해야 합니다!");
			$("#checkIDFlag").val('n');
			return false;
		}
		else if(originID == $userID){

			alert("사용 가능한 아이디입니다!");
			$("#checkIDFlag").val('y');		

		}else if($userID){

			$formData="userID="+$userID;

			$.ajax({
				type : "POST",
				url : "../member/checkIDUnique.php",
				data : $formData,
				dataType: "text",
				success : function(data){
					if(data==1){
						alert("이미 존재하는 아이디입니다! 다른 아이디를 입력해주세요!");
						$("#checkIDFlag").val('n');
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

	function modifyCheckFunc(){
		
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
		
		$dataIdArray = array('userID', 'userPasswd1', 'userPasswd2', 'userEmail1', 'userEmail2', 'userTel1', 'userTel2', 'userTel3', 'userAddress1', 'userAddress2', 'userAddress3', 'userSMS', 'userMail');

			foreach($dataIdArray as $value){
				echo "var ".$value." = document.getElementById('".$value."');";
			}
			
			foreach($dataIdArray as $value){
				echo "if(!".$value.".value){";
				echo	"alert('필수 사항을 입력해주세요!');";
				echo	$value.".focus();";
				echo	"return false;";
				echo "}";
			}
		?>

			
		if($("#userPasswd1").val() !== $("#userPasswd2").val()){
			alert("비밀번호가 일치하지 않습니다. 다시 입력해주세요!");
			return false;
		}

		//데이터 보내는 부분 시작!

		var rcvsms = document.getElementsByName('radio1');
		var rcvSMSValue = "y";

		if(rcvsms[1].checked==true){
			rcvSMSValue="n";
		}

		var rcvmail = document.getElementsByName('radio1');
		var rcvMailValue = "y";

		if(rcvmail[1].checked==true){
			rcvMailValue="n";
		}

		var s = {
			"userID": $("#userID").val(),
			"userPasswd": $("#userPasswd1").val(),
			"userEmail1": $("#userEmail1").val(),
			"userEmail2": $("#userEmail2").val(),
			"userTel1": $("#userTel1").val(),
			"userTel2": $("#userTel2").val(),
			"userTel3": $("#userTel3").val(),
			"userAddress1": $("#userAddress1").val(),
			"userAddress2": $("#userAddress2").val(),
			"userAddress3": $("#userAddress3").val(),
			"userSMS" : rcvSMSValue,
			"userMail" : rcvMailValue,
		}

		$.ajax({
			type : "POST",
			url : "/member/index.php?mode=modify_update",
			data : s,
			success : function(data){
				if(data==2){
					alert("개인정보가 수정되었습니다!");
					location.href="http://test.hackers.com/index.html";
					return true;
				}
				else{
					alert('예상치못한 오류가 발생하였습니다. 다시 시도해주세요!');
				}
			},
			error: function(request, status, error){
				alert("error : "+status);
			}
		});


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

<!-- include header  -->
<?include("header.html"); ?>


<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">
			<div class="tit-box-h3">
				<h3 class="tit-h3">내정보수정</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>내정보수정</strong>
				</div>
			</div>

			<div class="section-content">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">강의정보</caption>
					<colgroup>
						<col style="width:15%"/>
						<col style="*"/>
					</colgroup>

					<tbody>
						<tr>
							<th scope="col"><span class="icons">*</span>이름</th>
							<td><?=$row['userName']?></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>아이디</th>
							<td><input type="text" class="input-text" id="userID" value="<?=$row['userID']?>" style="width:302px" placeholder="영문자로 시작하는 4~15자의 영문소문자, 숫자" maxlength="15"/><a href="javascript:void(0);" class="btn-s-tin ml10" onclick="return checkID();">중복확인</a><input type="hidden" id="checkIDFlag" value="y"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>비밀번호</th>
							<td><input type="password" class="input-text" id="userPasswd1" style="width:302px" placeholder="8-15자의 영문자/숫자 혼합" maxlength="15"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>비밀번호 확인</th>
							<td><input type="password" class="input-text" id="userPasswd2" style="width:302px" maxlength="15"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>이메일주소</th>
							<td>
								<?php $userEmail = explode('@', $row['userEmail']); ?>
								<input type="text" class="input-text" id="userEmail1" value="<?=$userEmail[0]?>" style="width:138px" maxlength="20"/> @ <input type="text" value="<?=$userEmail[1]?>" class="input-text" id="userEmail2" style="width:138px" maxlength="20"/>
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
							<td><?=$row['userPhone']?></td>
						</tr>
						<tr>
							<?php $userTel = explode('-', $row['userTel']); ?>
							<th scope="col"><span class="icons"></span>일반전화 번호</th>
							<td><input type="text" class="input-text" id="userTel1" value="<?=$userTel[0]?>" style="width:88px" maxlength="3"/> - <input type="text" class="input-text" id="userTel2" value="<?=$userTel[1]?>" style="width:88px" maxlength="4"/> - <input type="text" class="input-text" id="userTel3" value="<?=$userTel[2]?>" style="width:88px" maxlength="4"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>주소</th>
							<td>
								<p >
									<label>우편번호 <input type="text" class="input-text ml5" id="userAddress1" value="<?=$row['userAddress1']?>" style="width:242px" disabled /></label><a href="javascript:void(0);" onclick="return execDaumPostcode();" class="btn-s-tin ml10">주소찾기</a>
								</p>
								<p class="mt10">
									<label>기본주소 <input type="text" class="input-text ml5" id="userAddress2" value="<?=$row['userAddress2']?>" style="width:719px" maxlength="50"/></label>
								</p>
								<p class="mt10">
									<label>상세주소 <input type="text" class="input-text ml5" id="userAddress3" value="<?=$row['userAddress3']?>" style="width:719px" maxlength="50"/></label>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>SMS수신</th>
							<td>
								<div class="box-input">
									<label class="input-sp">
										<input type="radio" name="radio1" id="userSMS" <?=$ySMS?>/>
										<span class="input-txt">수신함</span>
									</label>
									<label class="input-sp">
										<input type="radio" name="radio1" id="userSMS" <?=$nSMS?>/>
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
										<input type="radio" name="radio2" id="userMail" <?=$yMail?>/>
										<span class="input-txt">수신함</span>
									</label>
									<label class="input-sp">
										<input type="radio" name="radio2" id="userMail" <?=$nMail?>/>
										<span class="input-txt">미수신</span>
									</label>
								</div>
								<p>메일수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="box-btn">
					<a href="javascript:void(0);" class="btn-l" onclick="return modifyCheckFunc();">정보수정</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- include footer -->
<?include("footer.html"); ?>

</div>
</body>
</html>
