<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<!-- //++++++++++++++++++++++++++ -->
<?php

$sql_during = "SELECT
						IF(NOW() BETWEEN '2022-08-18 17:00:00' AND '2022-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//할인 가격 끝 여부
$sql_during =	"SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

//특정 회원 가격 변동 이후 삭제
//if($registration_idx == 512) {
//	$r_during_yn = 'N';
//}

if ($_SESSION['USER']['idx'] == 336) {
	$during_yn = 'Y';
}

if ($during_yn !== "Y") {
?>

	<section class="container submit_application registration_closed">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Transportation</h2>
					<!-- <ul class="clearfix">
					<li>Home</li>
					<li>Registration</li>
				</ul> -->
				</div>
			</div>
		</div>
		<div class="inner coming">
			<div class="sub_banner">
				<h5>coming soon...</h5>
			</div>
		</div>
	</section>


<?php
} else {
?>
	<!-- //++++++++++++++++++++++++++ -->
	<section class="container transportation">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Transportation</h2>
					<ul class="clearfix">
						<li>Home</li>
						<li>General Information</li>
						<li>Transportation</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="inner">
			<!--
		<div>
			<div class="circle_title">
				By Bus
			</div>
			<div class="x_scroll">
				<table class="table leftT">
					<colgroup>
						<col class="title_td">
						<col/>
					</colgroup>
					<thead>
						<tr>
							<th colspan="2">No. 6030 (Airport Bus)</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Board</th>
							<td>Terminal 1: 1st Floor (Arrival) Gate 6B  /  Terminal 2: B1 Floor(Arrival) Gate 32</td>
						</tr>
						<tr>
							<th>Travel Time</th>
							<td>- Approx. 75 mins (15mins from  Terminal 1 to 2)<br/>- Time: 6:30 am - 10:40 pm  /  Allocation: every 20-30 mins</td>
						</tr>
						<tr>
							<th>Fare</th>
							<td>KRW 15,000 (one-way) /  KRW 14,000 (at airport ticket booth)</td>
						</tr>
						<tr>
							<th>Bus Stop</th>
							<td>IFC Seoul Conrad Hotel</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		-->
			<div>
				<div class="circle_title">
					By Subway
					<p>Airport Railroad Express operates between Incheon International Airport and Gimpo Airport. At Gimpo
						Airport, you can transfer to subway line 9. You can take AREX at the Airport Transportation Center
						(B1) at Incheon International Airport.</p>
				</div>
				<div class="x_scroll">
					<table class="table left_border_table">
						<colgroup>
							<col>
							<col class="trans_td">
							<col class="trans_td">
							<col>
						</colgroup>
						<thead>
							<tr>
								<th>Route</th>
								<th>Traveling Time</th>
								<th>Fare</th>
								<th>Remarks</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><img src="./img/img_transportation01.jpg" alt=""></td>
								<td class="centerT">Approx. T2: 78 min<br />Approx. T1: 70 min</td>
								<td class="centerT">T2: KRW 4,750<br />T1: KRW 4,150</td>
								<td>Take Airport Railroad (AREX) from Incheon airport Terminal 1 or 2(bound for Gongdeok
									Station) then Transfer to subway Line #5 at Gongdeok Station (bound for Banghwa station)
									→ take off at Yeouido Station</td>
							</tr>
							<tr>
								<td><img src="./img/img_transportation02.jpg" alt=""></td>
								<td class="centerT">Approx. T2: 78 min<br />Approx. T1: 70 min</td>
								<td class="centerT">T2: KRW 4,550<br />T1: KRW 4,050</td>
								<td>From Gimpo Airport (approximately 18 min) : Take the Subway express line #9 at Gimpo
									International Airport station Get off at Yeouido station which provides direct access to
									Conrad Seoul</td>
							</tr>
							<tr>
								<td><img src="./img/img_transportation03.jpg" alt=""></td>
								<td class="centerT">19 min (6line Express)<br />T1: 26 min(5line)</td>
								<td class="centerT">KRW 1,350</td>
								<td>Yeouido Stn. (exit #3) is 10 min. walking distance away from Hotel</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div>
				<div class="circle_title">
					By Taxi
				</div>
				<div class="x_scroll">
					<table class="table leftT">
						<colgroup>
							<col class="title_td">
							<col />
						</colgroup>
						<thead>
							<tr>
								<th colspan="2">Taxi (Incheon Airport → Conrad Seoul Hotel)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>Conrad Seoul Hotel</th>
								<td>10 Gukjegeumyung-ro (Yeouido) Yeongdeungpo-gu, Seoul, 07326, South Korea</td>
							</tr>
							<tr>
								<th>Travel Time</th>
								<td>50 min ~ 1hr</td>
							</tr>
							<tr>
								<th>Fare</th>
								<td>KRW 60,000 (R) / KRW 75,000 (D) *Toll fee inclusive</td>
							</tr>
							<tr>
								<th>Classifications</th>
								<td>R: Regular taxi (Yellow, White) / D: Deluxe taxi (Black)</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
<?php
}
?>

<?php include_once('./include/footer.php'); ?>