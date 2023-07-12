<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_abstract"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	// list
	$where = "";
	$add = "";

	// 제목
	if ($_GET['title'] != "") {
		$where .= " AND ab.title LIKE '%".$_GET['title']."%'";
		$add .= "&title=".$_GET['title'];
	}

	// 등록일 (시작일)
	if ($_GET["str"] && $_GET["str"] != "") {
		$where .= (($_GET["str"] <= 0) ? "" : " AND DATE(ab.register_date) >= '{$_GET['str']}'");
		$add .= "&str=".$_GET['str'];
	}
	// 등록일 (종료일)
	if ($_GET["end"] && $_GET["end"] != "") {
		$where .= " AND DATE(ab.register_date) < DATE_ADD('{$_GET['end']}', INTERVAL +1 day)";
		$add .= "&end=".$_GET['end'];
	}

	$sql_list =	"SELECT
					ab.idx,
					ab.`code`, 
					ab_ct.title_en AS category_text_en,
					ab.title,
					IFNULL(fv.cnt, 0) AS fave_count,
					IFNULL(rp.cnt, 0) AS reply_count,
					DATE_FORMAT(ab.register_date, '%y-%m-%d') AS register_date
				FROM abstract AS ab
				LEFT JOIN info_poster_abstract_category AS ab_ct
					ON ab_ct.idx = ab.category_idx
				LEFT JOIN (
					SELECT
						abstract_idx, COUNT(idx) AS cnt
					FROM abstract_fave
					GROUP BY abstract_idx
				) AS fv
					ON fv.abstract_idx = ab.idx
				LEFT JOIN (
					SELECT
						abstract_idx, COUNT(idx) AS cnt
					FROM abstract_reply
					WHERE is_deleted = 'N'
					GROUP BY abstract_idx
				) AS rp
					ON rp.abstract_idx = ab.idx
				WHERE ab.is_deleted = 'N'
				".$where."
				ORDER BY ab.register_date";
	$list = get_data($sql_list);
	$total_count = count($list);
	//echo "<pre>{$sql_list}</pre>";
?>

	<section class="">
		<div class="container">
			<!-- 타이틀 -->
			<div class="title clearfix2">
				<h1 class="font_title">Abstract 관리</h1>
				<?php
					if($admin_permission["auth_live_abstract"] > 1){
				?>
				<button type="button" class="btn" onclick="location.href='./manage_abstract_basic.php'">Abstract 등록</button>
				<?php
					}
				?>
			</div>
			<!-- 조건바 -->
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
			<!-- 리스트 -->
			<div class="contwrap">
				<p class="total_num">총 <?=number_format($total_count)?>개</p>
				<table id="datatable">
					<thead>
						<tr class="tr_center">
							<th>논문번호</th>
							<th>Abstract Category</th>
							<!-- <th>Abstract 주제</th> -->
							<th>Abstract Title</th>
							<th>좋아요수</th>
							<th>댓글수</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($total_count > 0) {
								foreach($list as $oc){
						?>
						<tr class="tr_center">
							<td><a href="./manage_abstract_basic.php?idx=<?=$oc['idx']?>"><?=$oc['code']?></a></td>
							<td><?=$oc['category_text_en']?></td>
							<!-- <td><a href="./manage_abstract_basic.php">Abstract 주제</a></td> -->
							<td><?=$oc['title']?></td>
							<td><?=number_format($oc['fave_count'])?></td>
							<td><?=number_format($oc['reply_count'])?></td>
							<td><?=$oc['register_date']?></td>
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