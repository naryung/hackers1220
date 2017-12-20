<?php
	include($_SERVER['DOCUMENT_ROOT']."/member/connectDB.php");

	include($_SERVER['DOCUMENT_ROOT']."/lecture_board/selectRevwByNum.php");

	include($_SERVER['DOCUMENT_ROOT']."/lecture_board/updaterevwViews.php");

	include($_SERVER['DOCUMENT_ROOT']."/lecture_board/selectRevwAll.php");

	include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/selectCtgName.php');

	include($_SERVER['DOCUMENT_ROOT'].'/lecture_board/selectRevwFile.php');

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

	function deletePostFunc(){

		if(confirm("정말 삭제하시겠습니까?") == true){
			var datas = {
				"revwWriterID" : "<?= $row_content['revwWriterID'] ?>",
				"revwNum" : "<?= $_GET['revwnum'] ?>"
			}

			$.ajax({
				url : "/lecture_board/index.php?mode=delete",
				type : "POST",
				data : datas,
				success : function(data){
					if(data==2){
						alert("삭제되었습니다!");
						location.href="/lecture_board/index.php?mode=list";
					}
					else{
						alert("예상치못한 에러가 발생하였습니다!");
						history.back();
					}
				},
				error : function(request, error, status){
					alert("error : "+error);
				}
			
			});
		}

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

		<table border="0" cellpadding="0" cellspacing="0" class="tbl-bbs-view">
			<caption class="hidden">수강후기</caption>
			<colgroup>
				<col style="*"/>
				<col style="width:20%"/>
			</colgroup>
			<tbody>
				 <tr>
					<th scope="col"><?= $row_content['revwTitle'] ?></th>
					<th scope="col" class="user-id">작성자 | <?= $row_content['revwWriterID'] ?></th>
				 </tr>
				<tr>
					<td colspan="2">
						<div align="right">
							<span class="tc-gray mt20">등록일 <?= $row_content['revwDate'] ?>&nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;조회수 <?= $row_content['revwViews'] ?></span>
						</div>
						<div class="box-rating">
							<span class="tit_rating">강의만족도</span>
							<span class="star-rating">
								<span class="star-inner" style="width:<?php echo $row_content['revwSatisfaction']*20;?>%"></span>
							</span>
						</div>
						<div style="margin-top:30px;">
							<?= $row_content['revwContent'] ?>
						</div>
						<br>
					</td>
				</tr>
				<?php

					if(mysql_num_rows($result_revwfile)>0){

						echo '
							<tr>
								<td colspan="2">
								<p><span class="tc-gray mt20">[첨부파일]</span></p><br>
						';
						while($row_revw_file = mysql_fetch_assoc($result_revwfile)){
							echo'
								<img src="images/icon/editor/p_etc_s.gif" />&nbsp;
								<a href="/image/'.$row_revw_file['fileName'].'" download="'.$row_revw_file['realName'].'">'.$row_revw_file['realName'].'</a><br>
							';
						}

						echo '</td>
							</tr>';
					}
				?>
			</tbody>
		</table>
		<br><br><br><br>
		
		
		<p class="mb15"><strong class="tc-brand fs16"><?= $row_content['revwWriterID'] ?>님의 수강하신 강의 정보</strong></p>

		<?php

		if($message_lec === 'empty'){
			echo '
				<div align="center">
					<span class="tc-gray mt20">본 강의는 삭제된 강의입니다.</span>
				</div>        
			';
		}
		else{
			echo '
			
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-lecture-list">
					<caption class="hidden">강의정보</caption>
					<colgroup>
						<col style="width:166px"/>
						<col style="*"/>
						<col style="width:110px"/>
					</colgroup>
					<tbody>
						<tr>
							<td>
								<a href="#" class="sample-lecture">
									<img src="/image/'.$row_lec["lecThumbnail"].'" alt="" width="144" height="101" />
									<span class="tc-brand">샘플강의 ▶</span>
								</a>
							</td>
							<td class="lecture-txt">
								<em class="tit mt10">'.$row_lec["lecTitle"].'</em>
								<p class="tc-gray mt20">강사: '.$row_lec["lecTeacher"].' | 학습난이도 : '.$row_lec["lecLevel"].' | 교육시간: '.$row_lec["lecTime"].'시간 ('.$row_lec["lecTotal"].'강)</p>
							</td>
							<td class="t-r"><a href="#" class="btn-square-line">강의<br />상세</a></td>
						</tr>
					</tbody>
				</table>
				';
		}

		
		?>


		<div class="box-btn t-r">
			<a href="/lecture_board/index.php?mode=list" class="btn-m-gray">목록</a>
			<?php
				if($_SESSION['userIDSession'] === $row_content['revwWriterID']){
					echo '<a href="/lecture_board/index.php?mode=modify&revwnum='.$get_revwnum.'" class="btn-m ml5">수정</a>
					<a href="javascript:void(0);" class="btn-m-dark" onclick="return deletePostFunc();">삭제</a>';
				}
			?>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT']."/lecture_board/revwBoard.php"); ?>
	</div>
</div>

<!-- include footer  -->
<?include($_SERVER['DOCUMENT_ROOT']."/html/footer.html"); ?>

</div>
</body>
</html>
