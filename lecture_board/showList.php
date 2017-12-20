<?php

	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	include($_SERVER['DOCUMENT_ROOT']."/lecture_board/selectRevwAll.php");

	include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/selectCtgName.php');

	mysql_close($connect);


	//이거 쓴 이유는 아래에서 fetch 두 번하려고 하니까 날라가서..
	//근데 패치시킨 후
	//mysql_data_seek(변수) 쓰면 데이터를 다시 불러온다고 함!!

	while($row_ctg = mysql_fetch_assoc($result_ctg)){

		$tmp = new stdClass();

		$tmp->ctgCode = $row_ctg['ctgCode'];
		$tmp->ctgName = $row_ctg['ctgName'];

		$ctg_data[] = $tmp;

		unset($tmp);
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

		//선택된 카테고리를 색칠되도록 수정
		$(".tab-list.tab5 li").attr("class", "");
		$(".tab-list.tab5 li:eq(<?= $category ?>)").attr("class", "on");
		
	});


	//로그인 확인 체크 함수
	function checkLoginFunc(){

		<?php
			session_start();
			echo "var loginFlag='".$_SESSION['userIDSession']."';";
		?>

		if(loginFlag == ""){
			alert("로그인을 해야 후기 작성이 가능합니다!");
			return false;
		}

		return true;
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
<?include($_SERVER['DOCUMENT_ROOT']."/html/header.html"); ?>

<div id="container" class="container">

	<?php include($_SERVER['DOCUMENT_ROOT']."/lecture_board/navJobTraning.html"); ?>

	<div id="content" class="content">
		<div class="tit-box-h3">
			<h3 class="tit-h3">수강후기</h3>
			<div class="sub-depth">
				<span><i class="icon-home"><span>홈</span></i></span>
				<span>직무교육 안내</span>
				<strong>수강후기</strong>
			</div>
		</div>

		<ul class="tab-list tab5">
			<li class="on"><a href="/lecture_board/index.php?mode=list">전체</a></li>
			<?php
				foreach($ctg_data as $value){
					echo '<li><a href="/lecture_board/index.php?mode=list&c='.$value->ctgCode.'">'.$value->ctgName.'</a></li>';
				}
			?>
		</ul>

		<?php include($_SERVER['DOCUMENT_ROOT']."/lecture_board/revwBoard.php"); ?>

		<div class="box-btn t-r">
			<a href="/lecture_board/index.php?mode=write" class="btn-m" onclick="return checkLoginFunc();">후기 작성</a>
		</div>
	</div>
</div>

<!-- include footer  -->
<?include($_SERVER['DOCUMENT_ROOT']."/html/footer.html"); ?>

</div>
</body>
</html>
