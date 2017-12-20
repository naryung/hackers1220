<?php

	//$get_page가 없을경우(1페이지임)
	if($get_page==null){
		$get_page=1;
	}

	//버튼 중 active 줄 순서 초기화
	$color = $get_page%$limit+1;

	if($get_page%$limit==0){
		$color = 6;
	}
	

	//검색 옵션에 따라 url 변경
	if($_GET['searchCtg']!=null && $_GET['searchOption']!=null && $_GET['searchKeyword']!=null){
		$searchOptions = "&searchCtg=".$_GET['searchCtg']."&searchOption=".$_GET['searchOption']."&searchKeyword=".$_GET['searchKeyword'];
	}

	//버튼 누를시 카테고리도 넘어가게!!!
	if($_GET['c']!=null){
		$url_category = '&c='.$_GET['c'];
	}

?>



<div class="search-info">
	<div class="search-form f-r">
		<select class="input-sel" id="search-ctg" style="width:158px">
			<option value="">분류</option>
			<option id="ctg-allCtg" value="allCtg">전체</option>
		<?php 
			foreach($ctg_data as $value){
				echo '<option id="ctg-'.$value->ctgCode.'" value="'.$value->ctgCode.'">'.$value->ctgName.'</option>';
			}
		?>
		</select>
		<select class="input-sel" id="search-option" style="width:158px">
			<option id="schopt-lecture" value="lecture">강의명</option>
			<option id="schopt-writer" value="writer">작성자</option>
		</select>
		<input type="text" class="input-text" id="search-keyword" value="<?= $_GET['searchKeyword'] ?>" placeholder="강의명을 입력하세요." style="width:158px"/>
		<button type="button" class="btn-s-dark" onclick="return searchFunc();">검색</button>
	</div>
</div>

<table border="0" cellpadding="0" cellspacing="0" class="tbl-bbs">
	<caption class="hidden">수강후기</caption>
	<colgroup>
		<col style="width:5%"/>
		<col style="width:14%"/>
		<col style="*"/>
		<col style="width:13%"/>
		<col style="width:8%"/>
		<col style="width:6%"/>
		<col style="width:10%"/>
	</colgroup>

	<thead>
		<tr>
			<th scope="col">번호</th>
			<th scope="col">분류</th>
			<th scope="col">제목</th>
			<th scope="col">강좌만족도</th>
			<th scope="col">작성자</th>
			<th scope="col">조회수</th>
			<th scope="col">작성일</th>
		</tr>
	</thead>

	<tbody>
	<?php

		if($get_page===1){
			while($row_best = mysql_fetch_assoc($result_best)){

				$star_best = $row_best['revwSatisfaction']*20;

				echo '
				<!-- set -->
				<tr class="bbs-sbj">
					<td><span class="txt-icon-line"><em>BEST</em></span></td>
					<td>'.$row_best['ctgName'].'</td>
					<td>
						<a href="/lecture_board/index.php?mode=view&revwnum='.$row_best['revwNum'].'">
							<span class="tc-gray ellipsis_line">수강 강의명 : '.$row_best['lecTitle'].'</span>
							<strong class="ellipsis_line">'.$row_best['revwTitle'].'</strong>
						</a>
					</td>
					<td>
						<span class="star-rating">
							<span class="star-inner" style="width:'.$star_best.'%"></span>
						</span>
					</td>
					<td>'.$row_best['revwWriterID'].'</td>
					<td>'.$row_best['revwViews'].'</td>
					<td class="last">'.$row_best['revwDate'].'</td>
				</tr>
				<!-- //set -->
				';
			}
		}

		
	?>

	<?php

		//게시글 번호를 총 게시글 수와 페이지에 맞춰 생성하기!
		$get_revw_num = $total - $limit*($get_page-1);

		if($get_revwlist == null){
			echo '
			<tr class="bbs-sbj" style="height:100px;">
				<td colspan="7">검색 결과가 존재하지 않습니다!</td>
			</tr>
			';
			
		
		}
		else{
		
			foreach($get_revwlist as $value_revwlist){

				$star = $value_revwlist['revwSatisfaction']*20;

				echo '
				<!-- set -->
				<tr class="bbs-sbj">
					<td>'.$get_revw_num.'</td>
					<td>'.$value_revwlist['ctgName'].'</td>
					<td>
						<a href="/lecture_board/index.php?mode=view&revwnum='.$value_revwlist['revwNum'].$searchOptions.'">
							<span class="tc-gray ellipsis_line">수강 강의명 : '.$value_revwlist['lecTitle'].'</span>
							<strong class="ellipsis_line">'.$value_revwlist['revwTitle'].'</strong>
						</a>
					</td>
					<td>
						<span class="star-rating">
							<span class="star-inner" style="width:'.$star.'%"></span>
						</span>
					</td>
					<td>'.$value_revwlist['revwWriterID'].'</td>
					<td>'.$value_revwlist['revwViews'].'</td>
					<td class="last">'.$value_revwlist['revwDate'].'</td>
				</tr>
				<!-- //set -->
				';
				$get_revw_num--;
			}

		}
		

		
	?>
	</tbody>
</table>

<?php

	//round() : 반올림
	//ceil() : 올림

	//마지막 페이지 번호 계산하기
	$end_page = ceil($total/$limit);

	//페이지 나열 중 가장 먼저 나타낼 번호 계산하기
	$get_page_start = floor($get_page/$limit)*$limit+1;

	if(floor($get_page/$limit)==($get_page/$limit)){
		$get_page_start = $get_page_start - $limit;
	}

	//이전 페이지 버튼 눌렀을 때 갈 페이지 번호 계산하기
	$pre_page = $get_page_start-1;

	if($pre_page<=0){
		$pre_page = $get_page_start;
	}
	

	//다음 페이지 버튼 눌렀을 때 갈 페이지 번호 계산하기
	$next_page = $get_page_start+$limit;

	if($next_page>$end_page){
		$next_page = $get_page_start;
	}

/*
	print_r("get_page : ".$get_page."<br>");
	print_r("end_page : ".$end_page."<br><br>");
	print_r("get_page_start : ".$get_page_start."<br><br>");
	print_r("pre_page : ".$pre_page."<br>");
	print_r("next_page : ".$next_page."<br>");

*/
?>

<div class="box-paging">
		<a href="/lecture_board/index.php?mode=list&page=1<?=$searchOptions?><?=$url_category?>" onclick="return checkPageFunc(1, <?=$get_page?>);"><i class="icon-first"><span class="hidden">첫페이지</span></i></a>
		<a href="/lecture_board/index.php?mode=list&page=<?=$pre_page?><?=$url_category?><?=$searchOptions?>" onclick="return checkPageFunc(<?=$get_page_start?>, <?=$pre_page?>);"><i class="icon-prev"><span class="hidden">이전페이지</span></i></a>

		<?php

			$tmp = $get_page_start;
				
			//페이지 찍어주기
			for($i=0; $i<$limit; $i++){

				if($tmp <= $end_page){

					echo "<a href='/lecture_board/index.php?mode=list&page=".$tmp.$url_category.$searchOptions."'>".$tmp."</a>";	

				}

				$tmp = $tmp+1;
			}
			
		?>
		
		<a href="/lecture_board/index.php?mode=list&page=<?=$next_page?><?=$url_category?><?=$searchOptions?>" onclick="return checkPageFunc(<?=$get_page_start?>, <?=$next_page?>);"><i class="icon-next"><span class="hidden">다음페이지</span></i></a>
		<a href="/lecture_board/index.php?mode=list&page=<?=$end_page?><?=$url_category?><?=$searchOptions?>" onclick="return checkPageFunc(<?=$get_page?>, <?=$end_page?>);"><i class="icon-last"><span class="hidden">마지막페이지</span></i></a>
	</div>


<script type="text/javascript">

	$(function(){

		//검색한 결과일 경우 그 값 유지해주기 - input select
		<?php
			if($_GET['searchKeyword']!=null){
				echo '$("#ctg-'.$_GET['searchCtg'].'").attr("selected","selected");';
				echo '$("#schopt-'.$_GET['searchOption'].'").attr("selected","selected");';
			}
		
		?>


		
		//검색어 안에 있는 placeholder를 선택에 따라 바꿔주기
		$("#search-option").change(function(){
			if($(this).val()=="searchLecture"){
				$("#search-keyword").attr("placeholder","강의명을 입력하세요.");
			}
			else{
				$("#search-keyword").attr("placeholder","작성자명을 입력하세요.");
			}
		});


		//페이징 박스 색 넣기
		$(".box-paging a").attr("active","");
		$(".box-paging a:eq(<?= $color ?>)").attr("class","active");
	});

	//강의명 또는 작성자명 검색 함수
	function searchFunc(){

		var searchCtg = $("#search-ctg").val();
		var searchOption = $("#search-option").val();
		var searchKeyword = $("#search-keyword").val();
		
		if(!searchCtg){
			alert("분류를 선택해주세요!");
			return false;
		}

		if(!$("#search-option").val()){
			alert("옵션을 선택해주세요!");
			return false;
		}

		if(!searchKeyword){
			alert("검색어를 입력해주세요!");
			$("#search-keyword").focus();
			return false;
		}
		
		location.href="/lecture_board/index.php?mode=list&searchCtg="+searchCtg+"&searchOption="+searchOption+"&searchKeyword="+searchKeyword;
		return true;

	}


	function checkPageFunc(num1, num2){

		if(num1 == num2){
			return false;
		}
		
		return true;
	
	}

</script>