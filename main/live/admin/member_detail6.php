<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once("../live/include/set_event_period.php");

	$member_idx = $_GET["idx"];
	if(!$member_idx) {
		echo"<script>alert('비정상적인 접근 방법입니다.');window.location.replace('./member_list.php');</script>";
		exit;
	}
	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$sql_lucky_draw =	"SELECT
							IF(win_yn = 'Y', 'O', 'X') AS win_ox
						FROM event_luckydraw
						WHERE member_idx = ".$member_idx;
	$win_ox = sql_fetch($sql_lucky_draw)['win_ox'];
?>
	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">일반회원</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<?php include_once("./include/member_nav.php");?>
				<table class="list_table">
					<thead>
						<tr class="tr_center">
							<th>일자</th>
							<th>출석일시</th>
							<th>E-Booth 방문 스탬프</th>
							<th>같은 카드 찾기 시간/전체순위</th>
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
									$sql_daily_check =	"SELECT
															DATE_FORMAT(register_date, '%Y-%m-%d %H:%i') AS register_date
														FROM event_daily_check
														WHERE member_idx = ".$member_idx."
														AND DATE(register_date) = '".$ymd."'";

									$sql_stamp =	"SELECT
														COUNT(idx) AS cnt
													FROM e_booth_log
													WHERE member_idx = ".$member_idx."
													AND DATE(register_date) = '".$ymd."'";
									$stamp = sql_fetch($sql_stamp);

									$sql_sameimg =	"SELECT
														ranking.rank, ranking.min_score
													FROM (
														SELECT
															( @rank := @rank + 1 ) AS rank, 
															score_group.*
														FROM (
															SELECT
																es.min_score,
																es.member_idx,
																mb.first_name, mb.last_name,
																mb.affiliation
															FROM (
																SELECT
																	member_idx, MIN(score) AS min_score
																FROM event_sameimg
																WHERE (DATE(register_date) BETWEEN '".$_PERIOD[0]."' AND '".$ymd."')
																GROUP BY member_idx
															) AS es
															LEFT JOIN member AS mb
																ON mb.idx = es.member_idx
														) AS score_group
														, ( SELECT @rank := 0 ) AS b
														ORDER BY score_group.min_score ASC
													) AS ranking
													WHERE member_idx = ".$member_idx."";
									$sameimg = sql_fetch($sql_sameimg);
						?>
						<tr class="tr_center">
							<td><?=$ymd?></td>
							<td><?=sql_fetch($sql_daily_check)['register_date']?></td>
							<td><?=$stamp['cnt']?></td>
							<td>
								<?php
									echo $stamp['cnt'] >= 25 ? ($sameimg['min_score']." / ".$sameimg['rank']) : "-";
								?>
							</td>
						</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
				<table class="list_table" style="width: 25%;min-width: auto;">
					<colgroup>
					</colgroup>
					<tbody>
						<tr class="tr_center">
							<th>Lucky Draw 당첨여부</th>
							<td><?=($win_ox == "O") ? "O" : "X"?></td>
						</tr>
					</tbody>
				</table>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./member_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
<script>
$(document).ready(function(){
	$(".tab_wrap").children("li").eq(5).addClass("active");
});
</script>
<?php include_once('./include/footer.php');?>