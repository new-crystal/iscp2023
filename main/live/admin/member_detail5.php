<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../common/lib/calc_score.lib.php');
	include_once("../live/include/set_event_period.php");

	$member_idx = $_GET["idx"];
	if(!$member_idx) {
		echo"<script>alert('비정상적인 접근 방법입니다.'); window.location.replace('./member_list.php');</script>";
		exit;
	}
	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$scores = calc_score($_PERIOD, $member_idx);

	$lecture_logs = array();
	foreach($scores['daily'] as $ymd=>$data){
		foreach($data as $ll){
			array_push($lecture_logs, $ll);
		}
	}
	$lecture_logs_count = count($lecture_logs);
?>
	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">일반회원</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<?php include_once("./include/member_nav.php");?>
				<!-- <p class="total_num">총 <?=number_format($lecture_logs_count)?>개</p> -->
				<table  class="list_table">
					<colgroup>
						<col width="20%">
						<col width="*">
						<col width="20%">
					</colgroup>
					<thead>
						<tr class="tr_center">
							<th colspan="3">
								이수 평점<br>
								<?php
									for($i=0;$i<count($scores['score']);$i++){
										$data = $scores['score'][$i];
										if ($i > 0) {
											echo " / ";
										}
										echo str_replace('<br>', '', $data['name'])." : ".number_format($data['total'])." 점";
									}
								?>
							</th>
						</tr>
						<tr class="tr_center">
							<th>수강일자</th>
							<th>협회/학회</th>
							<th>평점</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($_PERIOD_COUNT <= 0) {
						?>
						<tr class="tr_center">
							<td colspan="4">No Data</td>
						</tr>
						<?php
							} else {
								foreach($_PERIOD as $ymd){
									for($i=0;$i<count($scores['score']);$i++){
										$data = $scores['score'][$i];
						?>
						<tr class="tr_center">
						<?php
										if ($i == 0) {
						?>
							<td rowspan="4" style="border-right:1px solid #ccc;"><?=$ymd?></td>
						<?php
										}
						?>
							<td><?=$data['name']?></td>
							<td><?=$data[$ymd]?></td>
						</tr>
						<?php
									}
								}
							}
						?>
					</tbody>
				</table>
				<?php
					if ($_PERIOD_COUNT > 0) {
						foreach($_PERIOD as $ymd){
				?>
				<table id="" class="list_table" style="margin-top:60px !important;">
					<colgroup>
						<col width="*">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr class="tr_center">
							<th colspan="4">Total Watch Time <?=$scores['total_watch_time'][$ymd]?> h</th>
						</tr>
						<tr class="tr_center">
							<th>Agenda Title</th>
							<th>Entrance Time</th>
							<th>Exit Time</th>
							<th>Watch Time</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if (count($scores['daily'][$ymd]) <= 0) {
						?>
						<tr class="tr_center">
							<td colspan="4">No Data</td>
						</tr>
						<?php
							} else {
								foreach($scores['daily'][$ymd] as $ll){
						?>
						<tr class="tr_center">
							<td><?=$ll['agenda_title_en']?></td>
							<td><?=$ll['entrance_date']?></td>
							<td><?=$ll['exit_date']?></td>
							<td><?=$ll['watch_time']?> h</td>
						</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
				<?php
						}
					}
				?>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./member_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
<script>
$(document).ready(function(){
	$(".tab_wrap").children("li").eq(4).addClass("active");
});
</script>
<?php include_once('./include/footer.php');?>