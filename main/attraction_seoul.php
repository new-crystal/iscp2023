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
					<h2>Attractions in Seoul</h2>
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
	<section class="container attractions_seoul">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Attractions in Seoul</h2>
					<ul>
						<li>Home</li>
						<li>General Information</li>
						<li>Attractions in Seoul</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="inner">
			<!--
		<div>
			<div class="circle_title">
				Seoul, the Capital of Korea
			</div>
			<iframe src="https://www.youtube.com/embed/fe7Qu01Y4kg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<p>Seoul is a fast-moving modern metropolis and one of the largest cities in the world. Home to over 10 million citizens, it is a friendly city that is easy to get around. Here are some tips to make your trip to Seoul more convenient and comfortable.</p>
		</div>
		-->
			<div>
				<div class="circle_title">About Seoul</div>
				<table class="table">
					<colgroup>
						<col class="col_th">
						<col width="*">
					</colgroup>
					<tbody>
						<tr>
							<th>Population</th>
							<td>Seoul 10,282,821(2016 est.) Seoul city government<br />South Korea 49,115,196 (July 2015
								est.) CIA The World Factbook<br />(About one-fifth of South Korea’s population in Seoul)
							</td>
						</tr>
						<tr>
							<th>Size</th>
							<td>30.3 km from north to south and 36.78 from east to west</td>
						</tr>
						<tr>
							<th>Time Zone</th>
							<td>GMT + 9 (Korea Standard Time KST or Japanese Standard Time JST)</td>
						</tr>
						<tr>
							<th>Electricity</th>
							<td>220v, 60 hz throughout the country (same type used in France, Germany, Austria, Greece,
								Turkey)</td>
						</tr>
						<tr>
							<th>Country Dialing Code</th>
							<td>+82</td>
						</tr>
						<tr>
							<th>Area Code</th>
							<td>Seoul 02 (when dialing from overseas remove the zero)</td>
						</tr>
						<tr>
							<th>Religion</th>
							<td>25% Buddhist, 25% Christian</td>
						</tr>
						<tr>
							<th>Language</th>
							<td>Korean</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<div class="circle_title">Getting Around</div>
				<p>
					Seoul is a city full of joy. It will not allow you to get bored. Insa-dong is where you can see
					traditional Korean artisans, Itaewon is a little community where people from outside Korea hang out,
					stores downtown open till late so that you can shop till you drop, N Seoul tower and 63 city will show
					you an awesome view of Seoul at a glance, and amusement parks will give you a thrill while you stay in
					Korea.
				</p>
			</div>
			<div>
				<div class="circle_title">Seoul City Tour</div>
				<p>
					City Tours are the most convenient and comfortable way to explore cities. The major sights and
					attractions of a city are presented on a single tour. Now City Tours are available in Seoul, Incheon,
					Suwon, Deajeon, Jeonju, Gwangju, Daegu, and Ulsan.<br />Nestled around the Hangang River is the Korean
					capital Seoul, a city of old and new. With thousands of years of history, Seoul has both well preserved
					royal palaces, historical relics, and cultural treasures as well as state-of-the-art facilities and
					infrastructures. The Seoul City Tour bus runs a course that covers major points of interest in the
					capital.
				</p>
				<ul class="img_list">
					<li><img src="./img/img_seoul04.jpg" alt=""></li>
					<li><img src="./img/img_seoul05.jpg" alt=""></li>
					<li><img src="./img/img_seoul06.jpg" alt=""></li>
				</ul>
			</div>
			<div>
				<div class="circle_title">Long History</div>
				<ul class="img_list">
					<li><img src="./img/img_seoul01.jpg" alt=""></li>
					<li><img src="./img/img_seoul02.jpg" alt=""></li>
					<li><img src="./img/img_seoul03.jpg" alt=""></li>
				</ul>
				<br>
				<p>
					Seoul has been the capital of Korea for about 600 years since the time of the Joseon Dynasty
					(1392-1910). Seoul was referred to as “Han Yang” during the Joseon Dynasty, but after the liberation
					from Japan in 1945, the newly founded Republic of Korea officially changed its capital city’s name to
					Seoul. Seoul has developed into a bustling metropolis, acting as the hub for political, economic, social
					and cultural matters. The Hangang River runs through the heart of the city. The river divides the city
					in two; the northern part of the city is a focal point for culture and history, while the southern part
					is well known for its business district.<br />Seoul has hosted many international events including: 1986
					Asian Games, 1988 Olympic Games and 2002 Korea/Japan FIFA World Cup. The success of these events has
					shown people that Korea is truly an international city.
				</p>
			</div>
		</div>
	</section>
<?php
}
?>

<?php include_once('./include/footer.php'); ?>