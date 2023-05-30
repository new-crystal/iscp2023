<?php
include_once('./include/head.php');
include_once('./include/header.php');
//++++++++++++++++++++++++++++++++++++++++
$sql_during = "SELECT
						IF(NOW() BETWEEN '2022-08-18 17:00:00' AND '2022-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//할인 가격 끝 여부
$sql_during =	"SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

if ($_SESSION['USER']['idx'] == 336) {
	$during_yn = 'Y';
}

if ($during_yn !== "Y") {
?>

	<section class="container submit_application registration_closed">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Scientific Program</h2>
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
	//++++++++++++++++++++++++++++++++++++++
	$member_idx = $_SESSION["USER"]["idx"];

	$sql_fave_list = "
		SELECT
			table_idx
		FROM lecture_fave AS lf
		WHERE member_idx = '" . $member_idx . "'
	";
	$fave_list = get_data($sql_fave_list);
?>

	<?php

	$type = $_GET['type'];
	$e = $_GET['e'];
	$e_num = $e[-1];
	$d_num = $day[-1];
	$name = $_GET['name'];

	//echo 'asdasd', $d_num

	/*echo '<script type="text/javascript">
				  $(document).ready(function(){
					  //탭 활성화
					  if ("'.$e_num.'" = "") {
							$(".room_tab li:first-child").addClass("on");
  					  $(".room_tab").siblings(".tab_wrap").children(".tab_cont:first-child").addClass("on");
					  }
					  //작은탭
					  $(".room_tab li").removeClass("on");
					  $(".room_tab + .tab_wrap .tab_cont2").removeClass("on");
					  $(".room_tab li:nth-child('.$e_num.')").addClass("on");
					  $(".room_tab + .tab_wrap .tab_cont2:nth-child('.$e_num.')").addClass("on");

					  window.onkeydown = function() {
					  	var kcode = event.keyCode;
						if(kcode == 116) {
							history.replaceState({}, null, location.pathname);
							window.scrollTo({top:0, left:0, behavior:"auto"});
						}
					  }

					  //스크롤 위치 & 액션
					  $("table").each(function(){
						  var window_height = $(window).height();
						  var div_height = $(this).parent("div").height();
						  var top = window_height - div_height

						  console.log(top, "top")
						  if ($(window).width() > 1024) {
							if("'.$name.'" === $(this).attr("name")) {
								var this_top = $(this).offset().top;
								$("html, body").scrollTop(this_top - top/2);
								//$("html, body").animate({scrollTop: this_top - 150}, 1000);
								//console.log(this_top)
							}
						  }else {
							  if("'.$name.'_mb" === $(this).attr("name")) {
								var this_top = $(this).offset().top;
								$("html, body").scrollTop(this_top - top/2);
								//$("html, body").animate({scrollTop: this_top - 150}, 1000);
								//console.log(this_top)
							}
						  }
						
					  });

				  });
		</script>';*/

	?>

	<section class="container scientific_program sub_page">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Scientific Program</h2>
					<ul>
						<li>Home</li>
						<li>Program</li>
						<li>Scientific Program</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="inner">
			<ul class="scientific_tab_pager">
				<li class="on"><a href="/main/scientific_program1.php">September 15 <i></i>(Thu)</a></li>
				<li><a href="/main/scientific_program2.php">September 16 <i></i>(Fri)</a></li>
				<li><a href="/main/scientific_program3.php">September 17 <i></i>(Sat)</a></li>
			</ul>
			<ul class="program_color_txt">
				<li><i></i>&nbsp;:&nbsp;Korean</li>
				<li><i></i>&nbsp;:&nbsp;English</li>
			</ul>
			<p class="rightT lecture_alert">※Some lectures will be pre-recorded.</p>
			<div class="tab_wrap">
				<!----- Day 01 ----->
				<div>
					<ul class="room_tab">
						<li class="on"><a href="javascript:;">Room 1</a></li>
						<li><a href="javascript:;">Room 2</a></li>
						<li><a href="javascript:;">Room 3</a></li>
						<li><a href="javascript:;">Room 4</a></li>
						<!-- <li><a href="javascript:;">Meeting Room</a></li> -->
					</ul>
					<div class="tab_wrap">
						<!-- Room 1-->
						<div class="tab_cont2 on">
							<!-- Symposium 1  Optimal risk factor control in patients with DM -->
							<div>
								<table class="table color_table" name="optimal_risk_factor_control_in_patients_with_dm">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />12:50 - 14:20</th>
											<td class="pink_bg">Symposium 1 <br />Optimal risk factor control in patients
												with DM
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="optimal_risk_factor_control_in_patients_with_dm_mb">
									<tbody>
										<tr class="gray_bg">
											<th class="gray_bg">September 15(Thu) 12:50 - 14:20</th>
										</tr>
										<tr class="pink_bg">
											<td>Symposium 1 <br />Optimal risk factor control in patients with DM
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairpersons</p>
											</th>
											<td>
												<p>우정택 (경희의대), 홍영준 (전남의대)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>강신애 (연세의대), 최익준 (가톨릭의대)</p>
											</td>
										</tr>
										<tr>
											<th>12:50 - 13:10</th>
											<td>
												<p class="s_bold">How much treatable residual risk do we really have?</p>
												<p>구보경 (서울의대)</p>
											</td>
										</tr>
										<tr>
											<th>13:10 - 13:30</th>
											<td>
												<p class="s_bold">Concept of multiple risk factor control in DM</p>
												<p>김현민 (중앙의대)</p>
											</td>
										</tr>
										<tr>
											<th>13:30 - 13:50</th>
											<td>
												<p class="s_bold">Is there special tool for control of diabetic
													dyslipidemia?</p>
												<p>김남훈 (고려의대)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>13:50 - 14:15</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- Symposium 4  Update on coronary CT: risk marker, monitoring tool & future perspective -->
							<div>
								<table class="table color_table" name="symposium_4">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />15:30 - 17:00</th>
											<td class="pink_bg">Symposium 4 <br />Update on coronary CT: risk marker,
												monitoring tool & future perspective

												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="symposium_4_mb">
									<tbody>
										<tr class="gray_bg">
											<th class="gray_bg">September 15(Thu) 15:30 - 17:00</th>
										</tr>
										<tr class="pink_bg">
											<td>Symposium 4 <br />Update on coronary CT: risk marker, monitoring tool &
												future perspective
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairpersons</p>
											</th>
											<td>
												<p>서일(연세의대), 박철영 (성균관의대)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>전은주 (서울의대), 최철웅 (고려의대)</p>
											</td>
										</tr>
										<tr>
											<th>15:30 - 15:50</th>
											<td>
												<p class="s_bold">Coronary artery calcium score to predict future CV event
												</p>
												<p>이은정 (성균관의대)</p>
											</td>
										</tr>
										<tr>
											<th>15:50 - 16:10</th>
											<td>
												<p class="s_bold">What are unsolved issues in the coronary CT research?</p>
												<p>조익성 (연세의대)</p>
											</td>
										</tr>
										<tr>
											<th>16:10 - 16:30</th>
											<td>
												<p class="s_bold">New markers of coronary CT for future CV event</p>
												<p>차민재 (중앙의대)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>16:30 - 16:55</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
							<!-- Luncheon Symposium 1 (K) [Daewoong]  -->
							<div>
								<table class="table color_table" name="luncheon_symposium_1">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />12:00 - 12:50</th>
											<td class="pink_bg">Luncheon Symposium 1 [Daewoong]
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="luncheon_symposium_1_mb">
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu) 12:00 - 12:50</th>
										</tr>
										<tr>
											<td class="pink_bg">Luncheon Symposium 1 [Daewoong]</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairperson</p>
											</th>
											<td>
												<p>최동훈 (연세의대)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>문재연 (차의대), 문준성 (영남의대)</p>
											</td>
										</tr>
										<tr>
											<th>12:00 - 12:20</th>
											<td>
												<p class="s_bold">Atorvastatin with ezetimibe combination therapy for very
													high/high risk groups</p>
												<p>이승표 (서울의대)</p>
											</td>
										</tr>
										<tr>
											<th>12:20 - 12:30</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Room 2-->
						<div class="tab_cont2">
							<!-- Basic Research Workshop 1 Lipid metabolism & metabolic disorders -->
							<div>
								<table class="table color_table" name="lipid_metabolism_metabolic_disorders">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />12:50 - 14:20</th>
											<td class="green_bg">
												Basic Research Workshop 1<br />Lipid metabolism & metabolic disorders
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="lipid_metabolism_metabolic_disorders_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 10:00 - 10:50</th>
										</tr>
										<tr class="green_bg">
											<td>Basic Research Workshop 1 Lipid metabolism & metabolic disorders
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairperson</p>
											</th>
											<td>
												<p>Young Mi Park (Ewha Womans University, Korea)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>Hyun Duk Jang (Seoul National University, Korea), Kyung-Sun Heo (Chungnam
													National University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>12:50 - 13:10</th>
											<td>
												<p class="s_bold">Cellular lipid trafficking & cholesterol homeostasis</p>
												<p>Young Mi Park (Ewha Womans University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>13:10 - 13:30</th>
											<td>
												<p class="s_bold">Novel lipid droplet factors in macrophage foam cells <img class="recording_icon" src="./img/icons/icon_recording.svg" alt="">
												</p>
												<p>Mireille Ouimet (University of Ottawa, Canada)</p>
											</td>
										</tr>
										<tr>
											<th>13:30 - 13:50</th>
											<td>
												<p class="s_bold">Regulation of Hippo signaling by Wnt co-receptor LRP6 (LRL
													receptor-related protein)</p>
												<p>Eek-hoon Jho (University of Seoul, Korea)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>13:50 - 14:15</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- Oral Presentation 1 (APSAVD Young Investigator Session) -->
							<div>
								<table class="table color_table" name="oral_presentation_1">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />14:30 - 15:30</th>
											<td class="green_bg">
												Oral Presentation 1 (APSAVD Young Investigator Session)
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="oral_presentation_1_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 14:30 - 15:30</th>
										</tr>
										<tr class="green_bg">
											<td>Oral Presentation 1 (APSAVD Young Investigator Session)</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairpersons</p>
											</th>
											<td>
												<p>Chul-Ung Choi (Korea University, Korea), Edward Janus (University of
													Melbourne, Australia)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>Jun Sung Moon (Yeungnam University, Korea), Sangmo Hong (Hanyang
													University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>14:30 - 14:37</th>
											<td>
												<p class="s_bold">A novel molecular diagnostic prototype for detection of
													pathogenic familial hypercholesterolaemia variants in an Asian
													population</p>
												<p>Norhidayah Rosman (AIMST University, Malaysia)</p>
											</td>
										</tr>
										<tr>
											<th>14:37 - 14:44</th>
											<td>
												<p class="s_bold">Apolipoprotein CIII deficiency exacerbates diet-induced
													fatty liver & insulin resistance in knock-out rabbits <img class="recording_icon" src="./img/icons/icon_recording.svg" alt="">
												</p>
												<p>Xiangming Tang (University of Yamanashi, Japan)</p>
											</td>
										</tr>
										<tr>
											<th>14:44 - 14:51</th>
											<td>
												<p class="s_bold">PCSK9 inhibitors exhibit attenuation of biomarkers of
													endothelial activation & oxidative stress in human coronary artery
													endothelial cells</p>
												<p>Rahayu Zulkapli (Universiti Teknologi MARA, Malaysia)</p>
											</td>
										</tr>
										<tr>
											<th>14:51 - 14:58</th>
											<td>
												<p class="s_bold">Comparison of on-statin lipid & lipoprotein levels for
													residual cardiovascular risk prediction in type 2 diabetes</p>
												<p>Ji Yoon Kim (Korea University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>14:58 - 15:23</th>
											<td>
												<p class="s_bold">Q&A</p>
											</td>
										</tr>
										<!--
									<tr class="discussion">
										<th>15:05 - 15:20</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
									-->
									</tbody>
								</table>
							</div>
							<!-- Basic Research Workshop 2 SMC plasticity in plaque stability -->
							<div>
								<table class="table color_table" name="basic_research_workshop_2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />15:30 - 17:00</th>
											<td class="pink_bg">
												Basic Research Workshop 2<br />SMC plasticity in plaque stability
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="basic_research_workshop_2_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 15:30 - 17:00</th>
										</tr>
										<tr class="pink_bg">
											<td>Basic Research Workshop 2 SMC plasticity in plaque stability
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairperson</p>
											</th>
											<td>
												<p>김재룡 (영남대)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>김용숙 (전남의대),임소연 (가톨릭관동대)</p>
											</td>
										</tr>
										<tr>
											<th>15:30 - 15:50</th>
											<td>
												<p class="s_bold">Dissecting SMC phenotype modulation through the lens of
													atherosclerosis-associated transcription factors</p>
												<p>Juyong Brian Kim (Stanford University, USA)</p>
											</td>
										</tr>
										<tr>
											<th>15:50 - 16:10</th>
											<td>
												<p class="s_bold">Targeting SMC phenotypic switching in vascular disease</p>
												<p>명창선 (충남대)</p>
											</td>
										</tr>
										<tr>
											<th>16:10 - 16:30</th>
											<td>
												<p class="s_bold">Regulation of phenotypic plasticity of vascular smooth
													muscle cells</p>
												<p>배순식 (부산대)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>16:30 - 16:55</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
							<!-- Luncheon Symposium 2 [Chong Kun Dang] -->
							<div>
								<table class="table color_table" name="luncheon_symposium_2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />12:00 - 12:50</th>
											<td class="green_bg">
												Luncheon Symposium 2 [Chong Kun Dang]
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="luncheon_symposium_2_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 12:00 - 12:50</th>
										</tr>
										<tr>
											<td class="green_bg">Luncheon Symposium 2 [Chong Kun Dang]</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairperson</p>
											</th>
											<td>
												<p>Jaetaek Kim (Chung-Ang University, Korea)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>Ji Woong Roh (Yonsei University, Korea), Sangmo Hong (Hanyang University,
													Korea)</p>
											</td>
										</tr>
										<tr>
											<th>12:00 - 12:20</th>
											<td>
												<p class="s_bold">How to manage cardiovascular health with atorvastatin in
													patients</p>
												<p>Hyungdon Kook (Hanyang University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>12:20 - 12:30</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Room 3-->
						<div class="tab_cont2">
							<!-- Symposium 2 Novel risk factors & intervention targets in atherosclerosis -->
							<div>
								<table class="table color_table" name="symposium_2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />12:50 - 14:20</th>
											<td class="green_bg">
												Symposium 2<br />Novel risk factors & intervention targets in
												atherosclerosis

												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="symposium_2_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 12:50 - 14:20</th>
										</tr>
										<tr class="green_bg">
											<td>Symposium 2 Novel risk factors & intervention targets in atherosclerosis
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairpersons</p>
											</th>
											<td>
												<p>Moon-Kyu Lee (Eulji University, Korea)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>Yoo-wook Kwon (Seoul National University, Korea), Jong-Chan Youn (The
													Catholic University of Korea, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>12:50 - 13:10</th>
											<td>
												<p class="s_bold">Biological & clinical influence of air pollution on
													metabolism & vasculature</p>
												<p>Seung-Pyo Lee (Seoul National University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>13:10 - 13:30</th>
											<td>
												<p class="s_bold">Role of T cell cholesterol efflux pathways in aging and
													atherosclerosis <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
												<p>Marit Westerterp (University of Groningen, Netherlands)</p>
											</td>
										</tr>
										<tr>
											<th>13:30 - 13:50</th>
											<td>
												<p class="s_bold">Circadian rhythm as risk & treatment target in ASCVD <img class="recording_icon" src="./img/icons/icon_recording.svg" alt="">
												</p>
												<p>Mahmood Hussain (New York University, USA)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>13:50 - 14:15</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Room 4-->
						<div class="tab_cont2">
							<!-- Symposium 3 NAFLD, metabolic dysfunction & ASCVD -->
							<div>
								<table class="table color_table" name="symposium_3">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />12:50 - 14:20</th>
											<td class="green_bg">
												Symposium 3<br />NAFLD, metabolic dysfunction & ASCVD
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="symposium_3_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 12:50 - 14:20</th>
										</tr>
										<tr class="green_bg">
											<td>
												Symposium 3 NAFLD, metabolic dysfunction & ASCVD
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairpersons</p>
											</th>
											<td>
												<p>Youngmi Kim (Kyung Hee University, Korea), Byung Wan Lee (Yonsei
													University, Korea)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>Chang-Yeon Kim (Daegu Catholic University, Korea), Hyewon Lee (Yonsei
													University, Korea), Eugene Han (Keimyung University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>12:50 - 13:10</th>
											<td>
												<p class="s_bold">MAFLD & risk of cardiovascular disease</p>
												<p>Yong-ho Lee (Yonsei University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>13:10 - 13:30</th>
											<td>
												<p class="s_bold">The role of mitochondrial enzyme PDK in the pathogenesis
													of NAFLD & ASCVD</p>
												<p>Jae-Han Jeon (Kyungpook National University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>13:30 - 13:50</th>
											<td>
												<p class="s_bold">Recent evidence between CVD & NAFLD/NASH in Japan <img class="recording_icon" src="./img/icons/icon_recording.svg" alt="">
												</p>
												<p>Masahiro Koseki (Osaka University, Japan)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>13:50 - 14:15</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- Symposium 5 Lipid as risk & target in cerebrovascular disease -->
							<div>
								<table class="table color_table" name="symposium_5">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr>
											<th class="gray_bg">September 15(Thu)<br />15:30 - 17:00</th>
											<td class="green_bg">
												Symposium 5<br />Lipid as risk & target in cerebrovascular disease
												<button type="button" class="favorite_btn centerT">My Favorite</button>
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table color_table mobile" name="symposium_5_mb">
									<tbody>
										<tr class="gray_bg">
											<th>September 15(Thu) 15:30 - 17:00</th>
										</tr>
										<tr class="green_bg">
											<td>
												Symposium 5 Lipid as risk & target in cerebrovascular disease
											</td>
										</tr>
										<tr>
											<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
										</tr>
									</tbody>
								</table>
								<table class="table detail_table2">
									<colgroup>
										<col class="col_th">
										<col width="*">
									</colgroup>
									<tbody>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Chairpersons</p>
											</th>
											<td>
												<p>Sun U. Kwon (University of Ulsan, Korea), Sang-Ho Jo (Hallym University,
													Korea)</p>
											</td>
										</tr>
										<tr class="panel_tr">
											<th class="leftT">
												<p>Panels</p>
											</th>
											<td>
												<p>Jeong-Min Kim (Seoul National University, Korea), Hoyoun Won (Chung-Ang
													University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>15:30 - 15:50</th>
											<td>
												<p class="s_bold">Lipid management for patients with non-atherosclerotic
													stroke</p>
												<p>Woo-Keun Seo (Sungkyunkwan University, Korea)</p>
											</td>
										</tr>
										<tr>
											<th>15:50 - 16:10</th>
											<td>
												<p class="s_bold">Target LDL-C level for patients with cerebrovascular
													disease <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
												<p>Kazuo Kitagawa (Tokyo women's medical hospital, Japan)</p>
											</td>
										</tr>
										<tr>
											<th>16:10 - 16:30</th>
											<td>
												<p class="s_bold">The next step in stroke prevention: beyond lowering LDL
													cholesterol</p>
												<p>Yong-Jae Kim (The Catholic University of Korea, Korea)</p>
											</td>
										</tr>
										<tr class="discussion">
											<th>16:30 - 16:55</th>
											<td>
												<p class="s_bold">Discussion</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
<input type="hidden" value="<?= $type ?>" name="type">
<input type="hidden" value="<?= $e ?>" name="e">
<input type="hidden" value="<?= $e_num ?>" name="e_num">
<input type="hidden" value="<?= $d_num ?>" name="d_num">
<input type="hidden" value="<?= $name ?>" name="name">

<?php
if (!empty($e_num)) {
?>
	<script src="./js/script/client/scientific_program.js?v=0.1"></script>
<?php
}
?>
<script>
	$(document).ready(function() {
		$(".room_tab li").click(function() {
			// style toggle
			$(this).parents(".room_tab").children("li").removeClass("on");
			$(this).addClass("on");
			// pager toggle
			var x = $(this).index();
			$(this).parents(".room_tab").next(".tab_wrap").children(".tab_cont2").removeClass("on");
			$(this).parents(".room_tab").next(".tab_wrap").children(".tab_cont2").eq(x).addClass("on");
		});

		$(".table.detail_table2").each(function() {
			var tr_length = $(this).find(".panel_tr").length;
			if (tr_length === 1) {
				$(this).find("tr").addClass("one");
			}
		});

		$(".color_table td").each(function() {
			if ($(this).hasClass("green_bg")) {
				$(this).parents(".color_table").siblings(".detail_table2").find(".panel_tr th p").css(
					"color", "#00666B")
			}
		});

	});
</script>
<?php
if ($member_idx == "") {
?>
	<script>
		$(".favorite_btn").click(function() {
			alert(locale(language.value)('need_login'));
		});
	</script>
<?php
} else {
?>
	<script>
		//console.log(fave_list);
		$(document).ready(function() {
			var fave_list = JSON.parse('<?= json_encode($fave_list) ?>');
			var temp_idx;
			fave_list.forEach(function(el) {
				temp_idx = el.table_idx - 1;
				$(".tab_cont2>div").eq(temp_idx).find(".favorite_btn").addClass('on');
			});
		});

		$(".favorite_btn").click(function() {
			var _this = $(this);

			var index = $(".tab_cont2>div").index((_this.parents('table').parent())) + 1;
			var date = _this.parent().siblings('th').text().replace(")", ") ");
			var title = _this.parent().html().replace("<br>", " ").replace(/\t/ig, "").split('<button')[0];
			var room = $('.room_tab li.on>a').eq(0).text();
			/*console.log('index', index);
			console.log('date', date);
			console.log('title', title);
			console.log('room', room);*/

			$.ajax({
				url: PATH + "ajax/client/ajax_lecture.php",
				type: "POST",
				data: {
					flag: 'fave',
					idx: index,
					date: date,
					title: title,
					room: room
				},
				dataType: "JSON",
				success: function(res) {
					//console.log(res);
					if (res.code == 200) {
						if (res.type == "ins") {
							_this.addClass("on");
						} else {
							_this.removeClass("on");
						}
						//alert(locale(language.value)("send_mail_success"));
						//location.href = './abstract_submission3.php?idx=' + submission_idx
					}
				},
				complete: function() {
					$(".loading").hide();
					$("body").css("overflow-y", "auto");

					//alreadyProcess = false;
				}
			});
		});
	</script>
<?php
}

include_once('./include/footer.php');
?>