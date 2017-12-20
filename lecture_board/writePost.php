<?php
	include($_SERVER['DOCUMENT_ROOT'].'/member/connectDB.php');

	include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/selectCtgName.php');

	include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/selectAttachments.php');

	if($_SESSION['userIDSession']==null){
		echo "<script>
				alert('로그인 후 수강후기를 작성하실 수 있습니다!');
				location.href='/member/login.html';
			</script>";
		exit;
	}

	if($_GET['mode']==='modify'){
		include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/selectRevwByNum.php');

		if($_SESSION['userIDSession']!==$row_content['revwWriterID']){
			echo "<script>
				alert('수정 권한이 없습니다!');
				history.back();
			</script>";

			mysql_close($connect);
			exit;
		}
	}
	else{
		mysql_close($connect);
	}

/*
	$target_dir = "{$_SERVER['DOCUMENT_ROOT']}/tmp_image/".$_SESSION[userIDSession];			//경로 설정

	if(is_dir($target_dir)){
		rmdir($target_dir);
	}

	if(!mkdir($target_dir, 0777)){
		echo "<script>
				alert('예상치 못한 에러가 발생하였습니다! (no tmp file)');
				history.back();
			</script>";
	}

	*/
	
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

<!--다음 에디터 css 및 javascript -->
<link rel="stylesheet" href="css/editor.css" type="text/css" charset="utf-8"/>
<script src="js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>


<script type="text/javascript">

	$(function(){
		
		//mysql_fetch_assoc($result_attch))

		<?php
			//수정 모드일 경우 강의분류, 강의명, 강의만족도, 리뷰내용 데이터 채워주기
			if($_GET['mode']==='modify'){

				//강의분류
				echo '$("#ctg'.$row_lec['lecCategory'].'").attr("selected","selected");';
				echo 'bringLecListFunc("selected");';
		
				//강의만족도
				echo '$("#saf-radio'.$row_content['revwSatisfaction'].'").attr("checked","checked");';

				//리뷰내용
				echo "Editor.modify({
					content:'".$row_content['revwContent']."'";
					if(mysql_num_rows($result_attch)>0){
						echo ", attachments: [";
						while($row_attch = mysql_fetch_assoc($result_attch)){
							if($tmp_first!=null) { echo ",";}
							$tmp_first="not first";
							echo "{
							attacher: '".$row_attch['fileAttacher']."', 
								data: {
									thumburl: 'http://test.hackers.com/image/".$row_attch['fileName']."',
									imageurl: 'http://test.hackers.com/image/".$row_attch['fileName']."',
									originalurl: 'http://test.hackers.com/image/".$row_attch['fileName']."',
									exifurl: 'http://test.hackers.com/image/".$row_attch['fileName']."',
									attachurl: 'http://test.hackers.com/image/".$row_attch['fileName']."',
									filename: '".$row_attch['realName']."',
									filesize: ".$row_attch['fileSize']."
								}
							}";
						}
						echo "]";
					}
				echo "});";
			}
		?>


		$("#ctg-sel").change(function(){

			bringLecListFunc(null);

		});

		function bringLecListFunc(selected){
			$("#lec-sel option").remove();

			var s = {
				"ctgCode": $("#ctg-sel").val()
			}

			$.ajax({
				type: "POST",
				url: "/lecture_board/selectLecTitle.php",
				data: s,
				dataType: "json",
				success: function(data){
					if(data != 'empty'){s
						$.each(data, function(key, val){
							$("#lec-sel").append("<option id='lec"+val.lecNum+"' value='"+val.lecNum+"'>"+val.lecTitle+"</option>");
						});

						if(selected=="selected"){
							//강의명
							<?php echo '$("#lec'.$row_lec['lecNum'].'").attr("selected","selected");'; ?>
						}
					}
					else{
						$("#lec-sel").append("<option value=''>해당 강의가 존재하지 않습니다</option>");
					}
				},
				error: function(request, status, error){
					alert("error : "+status);
				}
			});
		}

	});

</script>

</head><body>
<!-- skip nav -->
<div id="skip-nav">
<a href="#content">본문 바로가기</a>
</div>
<!-- //skip nav -->

<div id="wrap">

<!-- include header  -->
<?include($_SERVER['DOCUMENT_ROOT']."/html/header.html"); ?>

<div id="container" class="container">
	<div id="nav-left" class="nav-left">
		<div class="nav-left-tit"> 
			<span>직무교육 안내</span>
		</div>
		<ul class="nav-left-lst">
			<li><a href="#">해커스 HRD 소개</a></li>
			<li><a href="#">사업주훈련</a></li>
			<li><a href="#">근로자카드</a></li>
			<li><a href="#">학습안내</a></li>
			<li class="on"><a href="#">수강후기</a></li>
		</ul>
	</div>

	<div id="content" class="content">
		<div class="tit-box-h3">
			<h3 class="tit-h3">수강후기</h3>
			<div class="sub-depth">
				<span><i class="icon-home"><span>홈</span></i></span>
				<span>직무교육 안내</span>
				<strong>수강후기</strong>
			</div>
		</div>

		<div class="user-notice">
			<strong class="fs16">유의사항 안내</strong>
			<ul class="list-guide mt15">
				<li class="tc-brand">수강후기는 신청하신 강의의 학습진도율 25%이상 달성시 작성가능합니다. </li>
				<li>욕설(욕설을 표현하는 자음어/기호표현 포함) 및 명예훼손, 비방,도배글, 상업적 목적의 홍보성 게시글 등 사회상규에 반하는 게시글 및 강의내용과 상관없는 서비스에 대해 작성한 글들은 삭제 될 수 있으며, 법적 책임을 질 수 있습니다.</li>
			</ul>
		</div>

		<table border="0" cellpadding="0" cellspacing="0" class="tbl-col">
			<caption class="hidden">강의정보</caption>
			<colgroup>
				<col style="width:15%"/>
				<col style="*"/>
			</colgroup>

			<tbody>
				<tr>
					<th scope="col">강의</th>
					<td>
						<select class="input-sel" id="ctg-sel" style="width:160px">
							<option value="">분류</option>
							<?php
								while($row_ctg = mysql_fetch_assoc($result_ctg)){
									echo '<option id="ctg'.$row_ctg['ctgCode'].'" value="'.$row_ctg['ctgCode'].'">'.$row_ctg['ctgName'].'</option>';
								}
							?>
						</select>
						<select class="input-sel ml5" id="lec-sel" style="width:454px">
							<option value="">강의명</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="col">제목</th>
					<td><input type="text" class="input-text" id="revw-title" maxlength="50" style="width:611px" value="<?= $row_content['revwTitle'] ?>"/></td>
				</tr>
				<tr>
					<th scope="col">강의만족도</th>
					<td>
						<ul class="list-rating-choice">
							<li>
								<label class="input-sp ico">
									<input type="radio" name="radio" id="saf-radio5" value="5" checked="checked"/>
									<span class="input-txt">만점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:100%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="radio" id="saf-radio4" value="4"/>
									<span class="input-txt">4점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:80%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="radio" id="saf-radio3" value="3"/>
									<span class="input-txt">3점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:60%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="radio" id="saf-radio2" value="2"/>
									<span class="input-txt">2점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:40%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="radio" id="saf-radio1" value="1"/>
									<span class="input-txt">1점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:20%"></span>
								</span>
							</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="editor-wrap">
			<? include('editor.html'); ?>
		</div>

		<div class="box-btn t-r">
			<a href="/lecture_board/index.php?mode=list" class="btn-m-gray">목록</a>
			<?php
				if($_GET['mode']==='modify'){
					echo '<a href="javascript:void(0);" class="btn-m ml5" onclick="return modifyContent();">수정</a>';
				}
				else{
					echo '<a href="javascript:void(0);" class="btn-m ml5" onclick="return saveContent();">저장</a>';
				}
			?>
		</div>

		<div class="hidden" id="real-content"></div>

		<a href="javascript:void(0);" class="btn-m ml5" onclick="return testFunc();">테스트</a>

	</div>
</div>

<!-- include footer  -->
<?include($_SERVER['DOCUMENT_ROOT']."/html/footer.html"); ?>

</div>

<script type="text/javascript">

	//각 입력 내용이 비어있는지 체크!
	function checkInput(lecCategory, lecNum, revwTitle, revwContent, revwSatisfaction){

		if(!lecCategory){
			alert("강의 분류를 선택해주세요!");
			$("#ctg-sel").focus();
			return false;
		}

		if(!lecNum){
			alert("강의명을 선택해주세요!");
			$("#lec-sel").focus();
			return false;
		}

		if(!revwTitle){
			alert("제목을 입력해주세요!");
			$("#revw-title").focus();
			return false;
		}

		if(!revwContent || revwContent=="<p><br></p><p><br></p>" || revwContent=="<p><br></p>"){
			alert("내용을 입력해주세요!");
			return false;
		}

		if(!revwSatisfaction){
			alert("강의만족도를 선택해주세요!");
			return false;
		}

		return true;
	
	}

	//저장 버튼 클릭 시 발생 함수
	function saveContent(){

		var attachmentList = Editor.getSidebar().getAttachments('image');

		var fileInfo = [];

		for(var i=0; i<attachmentList.length; i++){
			var entry = attachmentList[i];
			fileInfo.push(entry.data.imageurl+"..."+entry.data.filename+"...image");
		}

		var lecCategory = $("#ctg-sel").val();
		var lecNum = $("#lec-sel").val();
		var revwTitle = $("#revw-title").val();
		var revwContent = Editor.getContent();
		var revwSatisfaction = $('input:radio[name="radio"]:checked').val();

		var check = checkInput(lecCategory, lecNum, revwTitle, revwContent, revwSatisfaction);

		if(check == false){
			return false;
		}

		var s = {
			"lecNum" : lecNum,
			"revwTitle" : revwTitle,
			"revwContent" : revwContent,
			"revwSatisfaction" : revwSatisfaction,
			"fileInfo" : fileInfo
		}

		$.ajax({
			type: "POST",
			url: "/lecture_board/insertRevw.php",
			data: s,
			dataType: "json",
			success: function(data){

				if(data.success==true){

					alert("수강후기가 등록되었습니다!");
					if(data.filesuccess==false){
						alert("첨부파일을 저장하지 못하였습니다..");
					}
					location.href="/lecture_board/index.php?mode=list";
				}
				else{
					alert("예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!");
				}

			},
			error: function(request, status, error){
				alert("error : "+error);
			}
		});
	}

	function modifyContent(){

		<?php echo 'var revwNum="'.$_GET['revwnum'].'";'; ?>

		var attachmentList = Editor.getSidebar().getAttachments('image');

		var fileInfo = [];

		for(var i=0; i<attachmentList.length; i++){
			var entry = attachmentList[i];
			if(!entry.deletedMark){
				fileInfo.push(entry.data.imageurl+"..."+entry.data.filename+"...image");
			}
		}

		var lecCategory = $("#ctg-sel").val();
		var lecNum = $("#lec-sel").val();
		var revwTitle = $("#revw-title").val();
		var revwContent = Editor.getContent();
		var revwSatisfaction = $('input:radio[name="radio"]:checked').val();

		var check = checkInput(lecCategory, lecNum, revwTitle, revwContent, revwSatisfaction);

		if(check == false){
			return false;
		}

		var s = {
			"lecNum" : lecNum,
			"revwTitle" : revwTitle,
			"revwContent" : revwContent,
			"revwSatisfaction" : revwSatisfaction,
			"revwNum" : revwNum,
			"fileInfo" : fileInfo
		}

		$.ajax({
			type: "POST",
			url: "/lecture_board/modifyRevw.php",
			data: s,
			dataType: "json",
			success: function(data){
				if(data.result==true){
					alert("수강후기가 수정되었습니다!");
					location.href="/lecture_board/index.php?mode=view&revwnum="+revwNum;
				}
				else{
					alert("예상치 못한 에러가 발생하였습니다. 다시 시도해주세요!\n("+data.message+")");
				}

			},
			error: function(request, status, error){
				alert("error : "+error);
			}
		});
	}

	function testFunc(){
		//Editor.save();
	}

</script>

</body>
</html>
