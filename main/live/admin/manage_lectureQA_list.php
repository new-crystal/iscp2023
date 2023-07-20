<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_lecture_qna"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// lecture list
	$where = "";
	$add = "";

	// 제목
	if ($_GET['title'] != "") {
		$where .= " AND lp.title_en LIKE '%".$_GET['title']."%'";
		$add .= "&title=".$_GET['title'];
	}

	// 등록일 (시작일)
	if ($_GET["str"] && $_GET["str"] != "") {
		$where .= (($_GET["str"] <= 0) ? "" : " AND DATE(lp.register_date) >= '{$_GET['str']}'");
		$add .= "&str=".$_GET['str'];
	}
	// 등록일 (종료일)
	if ($_GET["end"] && $_GET["end"] != "") {
		$where .= " AND DATE(lp.register_date) < DATE_ADD('{$_GET['end']}', INTERVAL +1 day)";
		$add .= "&end=".$_GET['end'];
	}

	$sql_list =	"SELECT
					lp.idx,
					lp.title_en,
					IFNULL(group_qna.cnt, 0) AS qna_cnt
				FROM lecture_place AS lp
				LEFT JOIN (
					SELECT
						place_idx, COUNT(idx) AS cnt
					FROM lecture_qna
					WHERE is_deleted = 'N'
					GROUP BY place_idx
				) AS group_qna
					ON group_qna.place_idx = lp.idx
				WHERE lp.is_deleted = 'N'
				".$where."
				ORDER BY lp.title_en";
	$list = get_data($sql_list);
	$total_count = count($list);
	//echo "<pre>{$sql_list}</pre>";
?>

<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">Lecture Q&A 관리</h1>
		</div>
		<!----- 검색조건박스 ----->
		<div class="contwrap centerT has_fixed_title">
			<form>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>제목</th>
							<td>
								<input type="text" name="title" value="<?=$_GET['title']?>">
							</td>
							<th>등록일</th>
							<td class="input_wrap">
								<input type="text" class="datepicker-here" data-date-format="yyyy-mm-dd" data-type="date" data-language="en" name="str">
								<span>~</span>
								<input type="text" class="datepicker-here" data-date-format="yyyy-mm-dd" data-type="date" data-language="en" name="end">
							</td>
						</tr>
					</tbody>
				</table>
				<button class="btn search_btn">검색</button>
			</form>
		</div>
		<!----- 컨텐츠 ----->
		<div class="contwrap has_fixed_title">
			<p class="total_num">총 <?=number_format($total_count)?>개</p>
			<table>
				<thead>
					<tr class="tr_center">
						<th>Place</th>
						<th>Q&A 개수</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($total_count > 0) {
							foreach($list as $lp){
								foreach($lp as $key=>$value){
									$lp[$key] = htmlspecialchars_decode($value);
								}
					?>
					<tr class="tr_center">
						<td><a href="./manage_lectureQA_detail.php?idx=<?=$lp['idx']?>"><?=$lp['title_en']?></a></td>
						<td><?=number_format($lp['qna_cnt'])?></td>
					</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<script>
	// ** DOCUMENT ** //
	$(document).ready(function() {
		// 자동완성 안됨
		$('input').attr('autocomplete', 'off');

		// datepicker 데이터 세팅
		var pt_start = "<?=$_GET['str']?>";
		if (pt_start) {
			$('[name=str]').datepicker().data('datepicker').selectDate(new Date(pt_start));
		}
		var pt_end = "<?=$_GET['end']?>";
		if (pt_end) {
			$('[name=end]').datepicker().data('datepicker').selectDate(new Date(pt_end));
		}
	});
</script>
<?php include_once('./include/footer.php');?>