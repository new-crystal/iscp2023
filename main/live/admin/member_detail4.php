<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$member_idx = $_GET["idx"];
	if(!$member_idx) {
		echo"<script>alert('비정상적인 접근 방법입니다.'); window.location.replace('./member_list.php');</script>";
		exit;
	}
	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$member_registration_query =	"
										SELECT
											rr.idx, rr.member_type, rr.attendance_type, DATE_FORMAT(rr.register_date, '%y-%m-%d') AS regist_date,
											p.total_price_us, p.total_price_kr, 
											(CASE
													WHEN rr.status = '0'
													THEN '등록취소'
													WHEN rr.status = '1'
													THEN '결제대기'
													WHEN rr.status = '2'
													THEN '결제완료'
													WHEN rr.status = '3'
													THEN '환불대기'
													WHEN rr.status = '4'
													THEN '환불완료'
													ELSE '-'
											END) AS registration_status,
											(CASE
												WHEN rr.attendance_type = '0'
												THEN 'Offline'
												WHEN rr.attendance_type = '1'
												THEN 'Online'
												WHEN rr.attendance_type = '2'
												THEN 'Online + Offline'
												ELSE '-'
											END) AS attendance_type,
											ksola_member_status
										FROM request_registration rr
										LEFT JOIN payment p
										ON rr.payment_no = p.idx
										LEFT JOIN(
											SELECT
												idx,
												ksola_member_status
											FROM member
										) AS mem
										ON mem.idx = rr.register
										WHERE rr.is_deleted = 'N'
										AND rr.register = {$member_idx}
										ORDER BY idx DESC
									";
	$member_registration = sql_fetch($member_registration_query);

	$registration_idx = isset($member_registration["idx"]) ? $member_registration["idx"] : "";
	$member_type = isset($member_registration["member_type"]) ? $member_registration["member_type"] : "";
	
	$register_date = isset($member_registration["regist_date"]) ? $member_registration["regist_date"] : "";
	$attendance_type = isset($member_registration["attendance_type"]) ? $member_registration["attendance_type"] : "";
	$registration_status = isset($member_registration["registration_status"]) ? $member_registration["registration_status"] : "";

	$ksola_member_status = isset($member_registration["ksola_member_status"]) ? $member_registration["ksola_member_status"] : "";

	$sql_during =	"SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
	$r_during_yn = sql_fetch($sql_during)['yn'];

	$us_price = $member_registration["total_price_us"];
	$ko_price = $member_registration["total_price_kr"];


	//특정 회원 가격 변동 이후 삭제
	if($registration_idx == 512) {
		$r_during_yn = 'N';
	}

	if($r_during_yn == 'Y' && $registration_status == "결제대기") {
		if($us_price == 250) {
			$us_price = 300;
		} else if($us_price == 100) {
			$us_price = 150;
		} 
		
		if($ko_price == 80000) {
			$ko_price = 100000;
		} else if($ko_price == 100000 && $ksola_member_status == 0) {
			$ko_price = 120000;
		} else if($ko_price == 50000) {
			$ko_price = 60000;
		}
	}

	if(isset($member_registration["total_price_us"])) {
		$payment_price = "$ ".number_format($us_price);
	} else {
		$payment_price = "￦ ".number_format($ko_price);
	}

	//$payment_price = isset($member_registration["total_price_us"]) ? "$ ".number_format($member_registration["total_price_us"]) : (isset($member_registration["total_price_kr"]) ? "￦ ".number_format($member_registration["total_price_kr"]) : "-");
	
?>
<style>
	.no_data {font-size: 18px; text-align: center;}
</style>
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
							<th>Status</th>
							<th>Category</th>
							<th>Online/Offline</th>
							<th>Registration Fee</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!$member_registration) {
							echo "<tr><td class='no_data' colspan='5'>No Data</td></tr>";
						} else {
					?>
						<tr class="tr_center">
							<td><a href="./registration_detail.php?idx=<?=$registration_idx?>"><?=$registration_status?></a></td>
							<td><?=$member_type?></td>
							<td><?=$attendance_type?></td>
							<td><?=$payment_price?></td>
							<td><?=$register_date?></td>
						</tr>
					<?php
						}
					?>
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
	$(".tab_wrap").children("li").eq(3).addClass("active");
});
</script>
<?php include_once('./include/footer.php');?>