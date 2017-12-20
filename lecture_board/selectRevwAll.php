<?php

	$limit = 20;

	if($_GET['page']==null){	//맨 처음 들어온 경우
		$start = 0;
	}
	else{						//페이지 버튼을 누른 경우
		
		$get_page = (int)$_GET['page'];

		$start = ($get_page-1)*$limit;
	}
	
	$category = $_GET['c'];
	$searchCtg = $_GET['searchCtg'];
	$searchOption = $_GET['searchOption'];
	$searchKeyword = $_GET['searchKeyword'];

	//sql where절 부분 필요 시 추가

	//카테고리 선택(분류)
	if($category){
		$cate_code="and (lecCategory='".$category."')";
	}

	//검색(분류) - 위와 동일하므로 같은 변수 사용
	if($searchCtg){
		if($searchCtg==="allCtg"){
			$cate_code = null;
		}
		else{
			$cate_code = "and (lecCategory='".$searchCtg."')";
		}
	}

	//검색(강의명 또는 작성자)
	if($searchOption){
		if($searchOption === "lecture"){
			$searchOption_code = "and (lecTitle like '".$searchKeyword."%')";
		}
		if($searchOption === "writer"){
			$searchOption_code = "and (revwWriterID like '".$searchKeyword."%')";
		}
	}

	$sql_revw = "SELECT revwNum, ctgName, lecTitle, revwTitle, revwSatisfaction, revwWriterID, revwViews, revwDate FROM lecture_category_tbl c, revw_tbl r, lecture_tbl l WHERE (c.ctgCode = l.lecCategory) and (r.lecNum = l.lecNum) ".$cate_code.$searchOption_code." order by revwNum desc limit ".$start.",".$limit.";";

	$sql_best = "select revwNum, ctgName, lecTitle, revwTitle, revwSatisfaction, revwWriterID, revwViews, revwDate FROM lecture_category_tbl c, revw_tbl r, lecture_tbl l WHERE (c.ctgCode = l.lecCategory) and (r.lecNum = l.lecNum) ".$cate_code.$searchOption_code." order by revwViews desc limit 3;";

	$result_revw = mysql_query($sql_revw);

	if(!$result_revw){
		echo "<script>
			alert('예상치 못한 에러가 발생하였습니다!');
			location.href='/index.html';
		</script>";
		exit;
	}

	$result_best = mysql_query($sql_best);

	if(!$result_best){
		echo "<script>
			alert('예상치 못한 에러가 발생하였습니다!');
			location.href='/index.html';
		</script>";
		exit;
	}

	while($row_revwlist = mysql_fetch_assoc($result_revw)){
	
		$get_revwlist[] = $row_revwlist;
	}

	//게시글 총 개수 구하기
	$sql_get_count = "SELECT count(*) FROM lecture_category_tbl c, revw_tbl r, lecture_tbl l WHERE (c.ctgCode = l.lecCategory) and (r.lecNum = l.lecNum) ".$cate_code.$searchOption_code.";";

	$result_get_count = mysql_query($sql_get_count);

	if(!$result_get_count){
		echo "<script>
			alert('예상치 못한 에러가 발생하였습니다!');
			location.href='/index.html';
		</script>";
		exit;
	}

	$row_get_count = mysql_fetch_row($result_get_count);

	$total= $row_get_count[0];

?>