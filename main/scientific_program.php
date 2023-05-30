<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$member_idx = $_SESSION["USER"]["idx"];

	$sql_fave_list = "
		SELECT
			table_idx
		FROM lecture_fave AS lf
		WHERE member_idx = '".$member_idx."'
	";
	$fave_list = get_data($sql_fave_list);
?>

<?php

	$type = $_GET['type'];
	$e = $_GET['e'];
	$day = $_GET['day'];
	$e_num = $e[-1];
	$d_num = $day[-1];

	$name = $_GET['name'];

	//echo 'asdasd', $d_num
	
	echo '<script type="text/javascript">
				  $(document).ready(function(){
					  //탭 활성화
					  //큰탭
					  $(".tab_pager li").removeClass("on");
					  if ("'.$day.'" === "") {
						$(".tab_pager li:first-child").addClass("on");
  					    $(".tab_pager").siblings(".tab_wrap").children(".tab_cont:first-child").addClass("on");
					  }
					  $(".tab_pager li:nth-child('.$d_num.')").addClass("on");
					  $(".tab_pager").siblings(".tab_wrap").children(".tab_cont").removeClass("on");
					  $(".tab_pager").siblings(".tab_wrap").children(".tab_cont:nth-child('.$d_num.')").addClass("on");
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
		</script>';


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
		<ul class="tab_pager">
			<li class="on"><a href="javascript:;">September 15 <i></i>(Thu)</a></li>
			<li><a href="javascript:;">September 16 <i></i>(Fri)</a></li>
			<li><a href="javascript:;">September 17 <i></i>(Sat)</a></li>
		</ul>
		<ul class="program_color_txt">
			<li><i></i>&nbsp;:&nbsp;Korean</li>
			<li><i></i>&nbsp;:&nbsp;English</li>
		</ul>
		<p class="rightT lecture_alert">※Some lectures will be pre-recorded.</p>
		<div class="tab_wrap">
			<!----- Day 01 ----->
			<div class="tab_cont on">
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
										<th class="gray_bg">September 15(Thu)<br/>12:50 - 14:20</th>
										<td class="pink_bg">Symposium 1 <br/>Optimal risk factor control in patients with DM
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
										<td>Symposium 1 <br/>Optimal risk factor control in patients with DM
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
											<p class="s_bold">Is there special tool for control of diabetic dyslipidemia?</p>
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
										<th class="gray_bg">September 15(Thu)<br/>15:30 - 17:00</th>
										<td class="pink_bg">Symposium 4 <br/>Update on coronary CT: risk marker, monitoring tool & future perspective
											
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
										<td>Symposium 4 <br/>Update on coronary CT: risk marker, monitoring tool & future perspective
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
											<p>박철영 (성균관의대)</p>
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
											<p class="s_bold">Calcium score to predict future CV event</p>
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
										<th class="gray_bg">September 15(Thu)<br/>12:00 - 12:50</th>
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
											<p class="s_bold">Atorvastatin with ezetimibe combination therapy for very high/high risk groups</p>
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
										<th class="gray_bg">September 15(Thu)<br/>12:50 - 14:20</th>
										<td class="green_bg">
											Basic Research Workshop 1<br/>Lipid metabolism & metabolic disorders
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
											<p>Hyun Duk Jang (Seoul National University, Korea), Kyung-Sun Heo (Chungnam National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:50 - 13:10</th>
										<td>
											<p class="s_bold">Cellular lipid trafficking & cholesterol homeostasis</p>
											<p>Young Mi Park  (Ewha Womans University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:10 - 13:30</th>
										<td>
											<p class="s_bold">Identification of novel lipid droplet factors in macrophage foam cells</p>
											<p>Mireille Ouimet (University of Ottawa, Canada)</p>
										</td>
									</tr>
									<tr>
										<th>13:30 - 13:50</th>
										<td>
											<p class="s_bold">Nutrient sensing mechanism for LDLR related protein LRP6</p>
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
										<th class="gray_bg">September 15(Thu)<br/>14:30 - 15:30</th>
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
											<p>Chul-Ung Choi (Korea University, Korea), Edward Janus (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Jun Sung Moon (Yeungnam University, Korea), Sangmo Hong (Hanyang University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>14:30 - 14:37</th>
										<td>
											<p class="s_bold">A novel molecular diagnostic prototype for detection of pathogenic familial hypercholesterolaemia variants in an Asian population</p>
											<p>Norhidayah Rosman (AIMST University, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>14:37 - 14:44</th>
										<td>
											<p class="s_bold">Apolipoprotein CIII deficiency exacerbates diet-induced fatty liver & insulin resistance in knock-out rabbits</p>
											<p>Xiangming Tang (University of Yamanashi, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>14:44 - 14:51</th>
										<td>
											<p class="s_bold">PCSK9 inhibitors exhibit attenuation of biomarkers of endothelial activation & oxidative stress in human coronary artery endothelial cells</p>
											<p>Rahayu Zulkapli (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>14:51 - 14:58</th>
										<td>
											<p class="s_bold">Comparison of on-statin lipid & lipoprotein levels for residual cardiovascular risk prediction in type 2 diabetes</p>
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
										<th class="gray_bg">September 15(Thu)<br/>15:30 - 17:00</th>
										<td class="pink_bg">
											Basic Research Workshop 2<br/>SMC plasticity in plaque stability
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
											<p class="s_bold">Role of TCF21 disease gene in SMC phenotype modulation</p>
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
											<p class="s_bold">Regulation of phenotypic plasticity of vascular smooth muscle cells</p>
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
										<th class="gray_bg">September 15(Thu)<br/>12:00 - 12:50</th>
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
											<p>Ji Woong Roh (Yonsei University, Korea), Sangmo Hong (Hanyang University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:00 - 12:20</th>
										<td>
											<p class="s_bold">How to manage cardiovascular health with atorvastation in patients</p>
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
										<th class="gray_bg">September 15(Thu)<br/>12:50 - 14:20</th>
										<td class="green_bg">
											Symposium 2<br/>Novel risk factors & intervention targets in atherosclerosis
											
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
											<p>Moon-Kyu Lee (Eulji University, Korea), Mahmood Hussain (New York University, USA)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Yoo-wook Kwon (Seoul National University, Korea), Jong-Chan Youn (The Catholic University of Korea, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:50 - 13:10</th>
										<td>
											<p class="s_bold">Biological & clinical influence of air pollution on metabolism & vasculature</p>
											<p>Seung-Pyo Lee (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:10 - 13:30</th>
										<td>
											<p class="s_bold">Role of T-cell cholesterol efflux pathways in aging, inflammation, & atherosclerosis</p>
											<p>Marit Westerterp (University of Groningen, Netherlands)</p>
										</td>
									</tr>
									<tr>
										<th>13:30 - 13:50</th>
										<td>
											<p class="s_bold">Circadian rhythm as risk & treatment target in ASCVD</p>
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
										<th class="gray_bg">September 15(Thu)<br/>12:50 - 14:20</th>
										<td class="green_bg">
											Symposium 3<br/>NAFLD, metabolic dysfunction & ASCVD
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
											<p>Youngmi Kim (Kyung Hee University, Korea), Byung Wan Lee (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Chang-Yeon Kim (Daegu Catholic University, Korea), Hye-Jin Yoo (Korea University, Korea)</p>
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
											<p class="s_bold">The role of mitochondrial enzyme PDK in the pathogenesis of NAFLD & ASCVD</p>
											<p>Jae-Han Jeon (Kyungpook National University, Korea)</p>
										</td>
									</tr>						    
									<tr>						    
										<th>13:30 - 13:50</th>
										<td>
											<p class="s_bold">Recent evidence between CVD & NAFLD/NASH in Japan</p>
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
										<th class="gray_bg">September 15(Thu)<br/>15:30 - 17:00</th>
										<td class="green_bg">
											Symposium 5<br/>Lipid as risk & target in cerebrovascular disease
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
											<p>Sun U. Kwon (University of Ulsan, Korea), Sang-Ho Jo (Hallym University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Jeong-Min Kim (Seoul National University, Korea), Hoyoun Won (Chung-Ang University, Korea)</p>
										</td>
									</tr>
									<tr>						    
										<th>15:30 - 15:50</th>
										<td>
											<p class="s_bold">Lipid management for patients with non-atherosclerotic stroke</p>
											<p>Woo-Keun Seo (Sungkyunkwan University, Korea)</p>
										</td>
									</tr>						    
									<tr>						    
										<th>15:50 - 16:10</th>
										<td>
											<p class="s_bold">Target LDL-C level for patients with cerebrovascular disease</p>
											<p>Kazuo Kitagawa (Tokyo women's medical hospital, Japan)</p>
										</td>
									</tr>					
									<tr>
										<th>16:10 - 16:30</th>
										<td>
											<p class="s_bold">The next step in stroke prevention: beyond lowering LDL cholesterol</p>
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
			<!----- Day 02 ----->
			<div class="tab_cont">
				<ul class="room_tab add_poster">
					<li class="on"><a href="javascript:;">Room 1</a></li>
					<li><a href="javascript:;">Room 2</a></li>
					<li><a href="javascript:;">Room 3</a></li>
					<li><a href="javascript:;">Room 4</a></li>
					<li><a href="javascript:;">Poster Hall</a></li>
				</ul>
				<div class="tab_wrap">
					<!-- Room 1-->
					<div class="tab_cont2 on">
						<!-- Plenary Lecture 1 -->
						<div>
							<table class="table color_table" name="plenary_lecture_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:00 - 09:40</th>
										<td class="green_bg">
											Plenary Lecture 1 
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:00 - 09:40</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 1 
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
											<p>Donghoon Choi (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:00 - 09:40</th>
										<td>
											<p class="s_bold">Target discovery & drug development for atherosclerosis in 2020's</p>
											<p>Sekar Kathiresan (Verve therapeutics, USA)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 6  Adipose tissue & atherosclerosis -->
						<div>
							<table class="table color_table" name="symposium_6">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:45 - 11:15</th>
										<td class="pink_bg">
											Symposium 6 <br/>Adipose tissue & atherosclerosis
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_6_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:45 - 11:15</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Symposium 6  Adipose tissue & atherosclerosis
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
											<p>한진 (인제의대), 노정현 (인제의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김남훈 (고려의대), 전성완 (순천향의대)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Novel mechanisms for lipogenesis regulation</p>
											<p>Gina Lee (University of California Irvine, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Local & systemic effect of organ fat deposition</p>
											<p>최성희 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Sex-dependent NAD+ metabolism in the liver & adipose tissue</p>
											<p>Ji-Young Lee (University of Connecticut, USA)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 2 (APSAVD:Ding Lecture) -->
						<div>
							<table class="table color_table" name="plenary_lecture_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>11:30 - 12:00</th>
										<td class="green_bg">
											Plenary Lecture 2 (APSAVD:Ding Lecture)
											
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 11:30 - 12:00</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 2 (APSAVD:Ding Lecture)
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
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>11:30 - 12:00</th>
										<td>
											<p class="s_bold">Recent developments in the treatment of familial hypercholesterolaemia &amp; other familial lipid disorders </p>
											<p>Brian Tomlinson (Macau University of Science & Technology, China)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 3 -->
						<div>
							<table class="table color_table" name="plenary_lecture_3">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:55 - 13:35</th>
										<td class="green_bg">
											Plenary Lecture 3
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_3_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 12:55 - 13:35</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 3
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
											<p>Goo Taeg Oh (Ewha Womans University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:55 - 13:35</th>
										<td>
											<p class="s_bold">Senescence & vascular smooth muscle cell plasticity</p>
											<p>Martin Bennett (University of Cambridge, UK)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 10  Debate on developing risk grouping in Korea: current status, comparison with foreign, & solution -->
						<div>
							<table class="table color_table" name="symposium_10">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>13:35 - 15:05</th>
										<td class="pink_bg">
											Symposium 10 <br/>Debate on developing risk grouping in Korea: current status, comparison with foreign, & solution
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_10_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 13:35 - 15:05</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Symposium 10  Debate on developing risk grouping in Korea: current status, comparison with foreign, & solution
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
											<p>정명호 (전남의대), 김성래 (가톨릭의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김경수 (차의대), 박재형 (고려의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:55</th>
										<td>
											<p class="s_bold">Current evidence on risk stratifying factors in Koreans</p>
											<p>허지혜 (한림의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:55 - 14:15</th>
										<td>
											<p class="s_bold">How much different event risk do Koreans have compared to European descendants? </p>
											<p>안성복 (이화의대)</p>
										</td>
									</tr>
									<tr>
										<th>14:15 - 14:35</th>
										<td>
											<p class="s_bold">How to select of low risk individuals to avoid pharmacotherapy?</p>
											<p>김학령 (서울의대)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>14:35 - 15:00</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Oral Presentation 2  -->
						<div>
							<table class="table color_table" name="oral_presentation_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>15:15 - 16:15</th>
										<td class="pink_bg">
											Oral Presentation 2
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="oral_presentation_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 15:15 - 16:15</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Oral Presentation 2 
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
											<p>권유욱 (서울대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>조아현 (가톨릭의대), 홍준화 (을지의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:15 - 15:22</th>
										<td>
											<p class="s_bold">Prediction of future vascular events from thrombus analysis of Ischemic myopathy (TAOISM)</p>
											<p>김정민 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:22 - 15:29</th>
										<td>
											<p class="s_bold">Comparison of single-pill combination of moderate-intensity rosuvastatin & ezetimibe versus high-intensity rosuvastatin in atherosclerotic cardiovascular disease patients with type 2 diabetes</p>
											<p>최효인 (성균관의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:29 - 15:36</th>
										<td>
											<p class="s_bold">Protocatechuic acid prevents heart failure in isoproterenol-infused mice by downregulating Kmo</p>
											<p>기해진 (전남의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:36 - 15:43</th>
										<td>
											<p class="s_bold">Rh1 ginsenoside suppressed lipopolysaccharide-induced endothelial cell inflammation & apoptosis by inhibiting endoplasmic reticulum stress & TLR4-mediated STAT3/NF-kB pathway</p>
											<p>진유진 (충남대)</p>
										</td>
									</tr>
									<tr>
										<th>15:43 - 16:08</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 13 Debate on new Korean guidelines on dyslipidemia: treatment -->
						<div>
							<table class="table color_table" name="symposium_13">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>16:15 - 17:45</th>
										<td class="pink_bg">
											Symposium 13 <br/>Debate on new Korean guidelines on dyslipidemia: treatment
											
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_13_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 16:15 - 17:45</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Symposium 13 Debate on new Korean guidelines on dyslipidemia: treatment								
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
											<p>김치정 (중앙의대), 장학철 (서울의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김병진 (성균관의대), 정인경 (경희의대)</p>
										</td>
									</tr>
									<tr>
										<th>16:15 - 16:35</th>
										<td>
											<p class="s_bold">Korean evidence on target LDL-C levels</p>
											<p>문민경 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>16:35 - 16:55</th>
										<td>
											<p class="s_bold">Are current Western LDL-C targets for each risk groups cost-effective in Koreans?</p>
											<p>김상현 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>16:55 - 17:15</th>
										<td>
											<p class="s_bold">When is clinically appropriate to start anti-PCSK9 Abs?</p>
											<p>남창욱 (계명대)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>17:15 - 17:40</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Breakfast Symposium 1 [Celltrionpharm]  -->
						<div>
							<table class="table color_table" name="breakfast_symposium_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>08:00 - 09:00</th>
										<td class="pink_bg">
											Breakfast Symposium 1 [Celltrionpharm]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="breakfast_symposium_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 08:00 - 09:00</th>
									</tr>
									<tr>
										<td class="pink_bg">
											Breakfast Symposium 1 [Celltrionpharm]
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
											<p>이우제 (울산의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>서지아 (고려의대), 장지용 (연세의대)</p>
										</td>
									</tr>
									<tr>
										<th>08:00 - 08:20</th>
										<td>
											<p class="s_bold">Pioglitazone & Cardiovascular Risk Reduction</p>
											<p>노정현 (인제의대)</p>
										</td>
									</tr>
									<tr>
										<th>08:20 - 08:30</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Luncheon Symposium 3 [Organon]  -->
						<div>
							<table class="table color_table" name="luncheon_symposium_3">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:00 - 12:50</th>
										<td class="pink_bg">
											Luncheon Symposium 3 [Organon]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_3_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 12:00 - 12:50</th>
									</tr>
									<tr>
										<td class="pink_bg">
											Luncheon Symposium 3 [Organon]
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
											<p>이홍규 (서울의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>윤혁준 (계명의대), 한승진 (아주의대)</p>
										</td>
									</tr>
									<tr>
										<th>12:00 - 12:20</th>
										<td>
											<p class="s_bold">Recent Update on Combination Therapy for High risk ASCVD patients</p>
											<p>윤종찬 (가톨릭의대)</p>
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
						<!-- Plenary Lecture 1 -->
						<div>
							<table class="table color_table" name="plenary_lecture_1_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:00 - 09:40</th>
										<td class="green_bg">
											Plenary Lecture 1 
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_1_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:00 - 09:40</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 1 
											
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
											<p>Donghoon Choi (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:00 - 09:40</th>
										<td>
											<p class="s_bold">Target discovery & drug development for atherosclerosis in 2020's</p>
											<p>Sekar Kathiresan (Verve therapeutics, USA)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 7 New regulators of dyslipidemia & atherosclerosis -->
						<div>
							<table class="table color_table" name="symposium_7">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:45 - 11:15</th>
										<td class="green_bg">
											Symposium 7<br/>New regulators of dyslipidemia & atherosclerosis
											
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_7_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:45 - 11:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 7 New regulators of dyslipidemia & atherosclerosis
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
											<p>In Kyeom Kim (Kyungpook National University, Korea), Soon Jun Hong (Korea University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Eun Hee Koh (University of Ulsan, Korea), Pilhan Kim (KAIST, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Validation of metabolic targets in adipose tissue for ASCVD</p>
											<p>Mete Civelek (University of Virginia, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Deficiency of myeloid PHD proteins aggravates atherogenesis via macrophage apoptosis & paracrine fibrotic signalling</p>
											<p>Judith Sluimer (Maastricht University, Netherlands)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Understanding the phenotypic changes of vascular smooth muscle cells during atherosclerosis</p>
											<p>Jae-Hoon Choi (Hanyang University, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 2 (APSAVD:Ding Lecture) -->
						<div>
							<table class="table color_table" name="plenary_lecture_2_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>11:30 - 12:00</th>
										<td class="green_bg">
											Plenary Lecture 2 (APSAVD:Ding Lecture)
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_2_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 11:30 - 12:00</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 2 (APSAVD:Ding Lecture)
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
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>11:30 - 12:00</th>
										<td>
											<p class="s_bold">Recent developments in the treatment of familial hypercholesterolaemia &amp; other familial lipid disorders </p>
											<p>Brian Tomlinson (Macau University of Science & Technology, China)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 3 -->
						<div>
							<table class="table color_table" name="plenary_lecture_3_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:55 - 13:35</th>
										<td class="green_bg">
											Plenary Lecture 3
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_3_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 12:55 - 13:35</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 3
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
											<p>Goo Taeg Oh (Ewha Womans University, Korea) </p>
										</td>
									</tr>
									<tr>
										<th>12:55 - 13:35</th>
										<td>
											<p class="s_bold">Senescence & vascular smooth muscle cell plasticity</p>
											<p>Martin Bennett (University of Cambridge, UK)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Food & Nutrition Workshop Cardiometabolic disease & customized nutrition management -->
						<div>
							<table class="table color_table" name="food_nutrition_workshop">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>13:35 - 15:05</th>
										<td class="pink_bg">
											Food & Nutrition Workshop<br/>Cardiometabolic disease & customized nutrition management										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="food_nutrition_workshop_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 13:35 - 15:05</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Food & Nutrition Workshop Cardiometabolic disease & customized nutrition management										
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
											<p>이명숙 (성신여대), 정효지 (서울대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>서존 (순천향의대), 임현정 (경희대)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:55</th>
										<td>
											<p class="s_bold">Customized functional food based on big data</p>
											<p>김지영 (서울대)</p>
										</td>
									</tr>
									<tr>
										<th>13:55 - 14:15</th>
										<td>
											<p class="s_bold">Customized prevention of metabolic disease in Koreans using omics technology</p>
											<p>김민주 (한남대)</p>
										</td>
									</tr>
									<tr>
										<th>14:15 - 14:35</th>
										<td>
											<p class="s_bold">Healthcare program using digital health device</p>
											<p>김영인 (주식회사 가지랩)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>14:35 - 15:00</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Oral Presentation 3 -->
						<div>
							<table class="table color_table" name="oral_presentation_3">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>15:15 - 16:15</th>
										<td class="green_bg">
											Oral Presentation 3									
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="oral_presentation_3_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 15:15 - 16:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Oral Presentation 3										
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
											<p>Hyuk-Sang Kwon (The Catholic University of Korea, Korea), Sungha Park (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Hyun Min Kim (Chung-Ang University, Korea), Su Jin Jeong (Sejong General Hospital, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:15 - 15:22</th>
										<td>
											<p class="s_bold">Cardiovascular risk factor profiles of familial hypercholesterolaemia patients with & without pathogenic FH candidate gene variants in the Malaysian community</p>
											<p>Aimi Zafira Razman (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>15:22 - 15:29</th>
										<td>
											<p class="s_bold">Impact of genetic testing on low-density lipoprotein cholesterol in patients with familial hypercholesterolemia (GenTLe-FH): a randomized waiting list controlled open-label trial</p>
											<p>Akihiro Nomura (Kanazawa University, Japen)</p>
										</td>
									</tr>
									<tr>
										<th>15:29 - 15:36</th>
										<td>
											<p class="s_bold">Dyslipidemia & type 2 diabetes among Filipino adults</p>
											<p>Cherry Ann Durante (Emilio Aguinaldo College Manila, Philippines)</p>
										</td>
									</tr>
									<tr>
										<th>15:36 - 15:43</th>
										<td>
											<p class="s_bold">The relationship between total cholesterol level & oxidative stress in the liver tissue of the hyperlipidemic rat model after the intervention with synbiotic beverage</p>
											<p>Rafik Prabowo (Universitas Islam Indonesia, Indonesia)</p>
										</td>
									</tr>
									<tr>
										<th>15:43 - 15:50</th>
										<td>
											<p class="s_bold">Determination of pathogenicity in ABCG5 & ABCG8 gene among Japanese dyslipidemic patients</p>
											<p>Nobuko Kojima (Kanazawa University, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>15:50 - 16:15</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Publication Committee Symposium -->
						<div>
							<table class="table color_table" name="publication_committee_session">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>16:15 - 17:45</th>
										<td class="pink_bg">
											Publication Committee Symposium
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="publication_committee_session_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 16:15 - 17:45</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Publication Committee Symposium
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
											<p>박용식 (경희대), 김정민 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>16:15 - 16:20</th>
										<td>
											<p class="s_bold">JLA Award Ceremony</p>
											<!-- <p>Jiyoung Kim (Seoul National University, Korea)</p> -->
										</td>
									</tr>
									<tr>
										<th>16:20 - 16:35</th>
										<td>
											<p class="s_bold">Regulation of macrophage activation & differentiation in atherosclerosis</p>
											<p>박성호 (유니스트)</p>
										</td>
									</tr>
									<tr>
										<th>16:35 - 16:50</th>
										<td>
											<p class="s_bold">Prospect of artificial intelligence based on electronic medical records</p>
											<p>김헌성 (가톨릭의대)</p>
										</td>
									</tr>
									<tr>
										<th>16:50 - 17:05</th>
										<td>
											<p class="s_bold">Intravital two-photon imaging of dynamic alteration of lipid droplet in a live animal model</p>
											<p>김필한 (카이스트)</p>
										</td>
									</tr>
									<tr>
										<th>17:05 - 17:20</th>
										<td>
											<p class="s_bold">Statin therapy & the risk of osteoporotic fractures in patients with metabolic syndrome: a nested case-control study</p>
											<p>김경진 (고려의대)</p>
										</td>
									</tr>
									<tr>
										<th>17:20 - 17:35</th>
										<td>
											<p class="s_bold">Metabolism & health impacts of dietary sugars</p>
											<p>Cholsoon Jang (University of California Irvine, USA)</p>
										</td>
									</tr>
									<tr>
										<th>17:35 - 17:45</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Breakfast Symposium 2 [Organon] -->
						<div>
							<table class="table color_table" name="breakfast_symposium_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>08:00 - 09:00</th>
										<td class="green_bg">
											Breakfast Symposium 2 [Organon]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="breakfast_symposium_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 08:00 - 09:00</th>
									</tr>
									<tr>
										<td class="green_bg">
											Breakfast Symposium 2 [Organon]
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
											<p>Seonghoon Choi (Hallym University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Bo Kyung Koo (Seoul National University, Korea), Hyemoon Chung (Kyung Hee University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>08:00 - 08:20</th>
										<td>
											<p class="s_bold">Management of uric acid in hypertensive patients: role of losartan</p>
											<p>Hack-Lyoung Kim (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>08:20 - 08:30</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Luncheon Symposium 4 [JW Pharmaceutical] -->
						<div>
							<table class="table color_table" name="luncheon_symposium_4">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:00 - 12:50</th>
										<td class="green_bg">
											Luncheon Symposium 4 [JW Pharmaceutical] 
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_4_mb">
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri) 12:00 - 12:50</th>
									</tr>
									<tr>
										<td class="green_bg">
											Luncheon Symposium 4 [JW Pharmaceutical] 
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
											<p>Jeong Euy Park (Sungkyunkwan University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Bong-Ki Lee (Kangwon National University, Korea), Suk Chon (Kyung Hee University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:00 - 12:20</th>
										<td>
											<p class="s_bold">Cutting edge care of Pitavastatin with Ezetimibe combination therapy</p>
											<p>Jun Hwa Hong (Eulji University, Korea)</p>
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
						<!-- Plenary Lecture 1 -->
						<div>
							<table class="table color_table" name="plenary_lecture_1_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:00 - 09:40</th>
										<td class="green_bg">
											Plenary Lecture 1 
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_1_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:00 - 09:40</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 1 
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
											<p>Donghoon Choi (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:00 - 09:40</th>
										<td>
											<p class="s_bold">Target discovery & drug development for atherosclerosis in 2020's</p>
											<p>Sekar Kathiresan (Verve therapeutics, USA)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 8 High CV risk group: is it properly defined? -->
						<div>
							<table class="table color_table" name="symposium_8">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:45 - 11:15</th>
										<td class="green_bg">
											Symposium 8<br/>High CV risk group: is it properly defined?
											
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_8_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:45 - 11:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 8 High CV risk group: is it properly defined?
											
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
											<p>Myung-A Kim (Seoul National University, Korea), Woo Je Lee (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Hack-Lyoung Kim (Seoul National University, Korea), Jung-Joon Cha (Korea University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">What is the role of a polygenic risk score in CV risk assessment?</p>
											<p>Amit Khera (Verve Therapeutics, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Refinement of CV risk in current "very high" & "high" risk groups</p>
											<p>Hyeon Chang Kim (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Risk stratification according to age groups in new prevention guidelines</p>
											<p>Kwang-il Kim (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 2 (APSAVD:Ding Lecture) -->
						<div>
							<table class="table color_table" name="plenary_lecture_2_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>11:30 - 12:00</th>
										<td class="green_bg">
											Plenary Lecture 2 (APSAVD:Ding Lecture)
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_2_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 11:30 - 12:00</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 2 (APSAVD:Ding Lecture)
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
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>11:30 - 12:00</th>
										<td>
											<p class="s_bold">Recent developments in the treatment of familial hypercholesterolaemia &amp; other familial lipid disorders </p>
											<p>Brian Tomlinson (Macau University of Science & Technology, China)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 3 -->
						<div>
							<table class="table color_table" name="plenary_lecture_3_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:55 - 13:35</th>
										<td class="green_bg">
											Plenary Lecture 3
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_3_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 12:55 - 13:35</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 3
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
											<p>Goo Taeg Oh (Ewha Womans University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:55 - 13:35</th>
										<td>
											<p class="s_bold">Senescence & vascular smooth muscle cell plasticity</p>
											<p>Martin Bennett (University of Cambridge, UK)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 11 Inflammation in progression & inhibition of atherosclerosis -->
						<div>
							<table class="table color_table" name="symposium_11">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>13:35 - 15:05</th>
										<td class="green_bg">
											Symposium 11<br/>Inflammation in progression & inhibition of atherosclerosis
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_11_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 13:35 - 15:05</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 11 Inflammation in progression & inhibition of atherosclerosis
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
											<p>Hyo-Soo Kim (Seoul National University, Korea), Young-Guen Kwon (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Young-Kook Kim (Chonnam National University, Korea), Chang Hee Jung (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:55</th>
										<td>
											<p class="s_bold">Macrophage diversity in inflammation & homeostasis</p>
											<p>Ichiro Manabe (Chiba University, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>13:55 - 14:15</th>
										<td>
											<p class="s_bold">Inflammation & hematopoiesis in atherosclerosis</p>
											<p>Katey Rayner (University of Ottawa, Canada)</p>
										</td>
									</tr>
									<tr>
										<th>14:15 - 14:35</th>
										<td>
											<p class="s_bold">Immune cell repertoire & novel therapeutic target of aortic aneurysm</p>
											<p>Seung-Jun Lee (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>14:35 - 15:00</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- 2022 KSoLA Awards for Scientific Excellence & Young Investigator Scientific Excellence Award Lecture -->
						<div>
							<table class="table color_table" name="2022_KSoLA_Awards_for_Scientific_Excellence_Young_Investigator">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>15:15 - 16:15</th>
										<td class="green_bg">
											2022 KSoLA Awards for Scientific Excellence & Young Investigator<br/>Scientific Excellence Award Lecture
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="2022_KSoLA_Awards_for_Scientific_Excellence_Young_Investigator_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 15:15 - 16:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											2022 KSoLA Awards for Scientific Excellence & Young Investigator<br/>Scientific Excellence Award Lecture
											
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
									<col>
								</colgroup>
								<tbody>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Chairpersons</p>
										</th>
										<td>
											<p>Myung A Kim (Seoul National University, Korea), Donghoon Choi (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:15 - 15:20</th>
										<td>
											<p class="s_bold">2022 KSoLA Awards Ceremony for Scientific Excellence & Young Investigator</p>
										</td>
									</tr>
									<tr>
										<th>15:20 - 15:40</th>
										<td>
											<p class="s_bold">TG lowering: Hope vs. Hype? </p>
											<p>Sang-Ho Jo (Hallym University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:40 - 15:45</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 14 (JAS/KSoLA Joint Symposium)<br/>Impact of aging of vascular cells on atherosclerosis & its protection -->
						<div>
							<table class="table color_table" name="symposium_14">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>16:15 - 17:45</th>
										<td class="green_bg">
											Symposium 14 (JAS/KSoLA Joint Symposium)<br/>Impact of aging of vascular cells on atherosclerosis & its protection
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_14_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 16:15 - 17:45</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 14 (JAS/KSoLA Joint Symposium) Impact of aging of vascular cells on atherosclerosis & its protection
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
											<p>Sang Hong Baek (The Catholic University of Korea, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Kwang-il Kim (Seoul National University, Korea), Kyu-Tae Kim (Ajou University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>16:15 - 16:35</th>
										<td>
											<p class="s_bold">Aging as risk factor & therapeutic target in atherosclerosis</p>
											<p>Sungha Park (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>16:35 - 16:55</th>
										<td>
											<p class="s_bold">New target genes & molecules for vascular aging </p>
											<p>Tohru Minamino (Juntendo University, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>16:55 - 17:15</th>
										<td>
											<p class="s_bold">What effect do cardiovascular medications & diet have on vascular aging?</p>
											<p>Kenichi Tsujita (Kumamoto University, Japan)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>17:15 - 17:40</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Luncheon Symposium 5 [Viatris] -->
						<div>
							<table class="table color_table" name="luncheon_symposium_5">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:00 - 12:50</th>
										<td class="green_bg">
											Luncheon Symposium 5 [Viatris]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_5_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 12:00 - 12:50</th>
									</tr>
									<tr>
										<td class="green_bg">
											Luncheon Symposium 5 [Viatris]
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
											<p>Hyun Ho Shin (Asan Chungmu Hospital, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Jae-seung Yun (The Catholic University of Korea, Korea), Jun Won Lee (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:00 - 12:20</th>
										<td>
											<p class="s_bold">What are the optimal treatment options of dyslipidemia management for your <br/>patients? based on LDL-C lowering continuum</p>
											<p>So-Yeon Choi (Ajou University, Korea)</p>
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
					<!-- Room 4-->
					<div class="tab_cont2">
						<!-- Symposium 9 Update on non-pharmacological control of ASCVD risk -->
						<div>
							<table class="table color_table" name="symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>09:45 - 11:15</th>
										<td class="green_bg">
											Symposium 9<br/>Update on non-pharmacological control of ASCVD risk
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 09:45 - 11:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 9<br/>Update on non-pharmacological control of ASCVD risk
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
											<p>Ick Mo Chung (Ewha Womans University , Korea), Sung Nim Han (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Oh Yoen Kim (Dong-A University, Korea), Yeon-Kyung Choi (Kyungpook National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Exercise & inflammation in atherosclerosis</p>
											<p>Matthias Nahrendorf (Harvard Medical School, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Effect of different diets on circulating lipoproteins</p>
											<p>Frank Sacks (Harvard Medical School, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Trends in dietary quality & cardiometabolic risks among Korean adults</p>
											<p>Min-Jeong Shin (Korea University, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 12 (IAS/APSAVD/JAS Joint Symposium) TBD -->
						<div>
							<table class="table color_table" name="symposium_12">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>13:35 - 15:05</th>
										<td class="green_bg">
											Symposium 12 (IAS/APSAVD/JAS Joint Symposium)<br/>Dyslipidaemia
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_12_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 13:35 - 15:05</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 12 (IAS/APSAVD/JAS Joint Symposium)<br/>Dyslipidaemia
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
											<p>Jaetaek Kim (Chung-Ang University, Korea), Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Jae Hyuk Lee (Myongji Hospital, Korea), Seung Jin Han (Ajou University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:55</th>
										<td>
											<p class="s_bold">Dyslipidaemia - new treatments for ApoC3 & ANGPTL3</p>
											<p>Brian Tomlinson (Macau University of Science & Technology, China)</p>
										</td>
									</tr>
									<tr>
										<th>13:55 - 14:15</th>
										<td>
											<p class="s_bold">Novel selective PPARa modulator pemafibrate for dyslipidemia & nonalcoholic fatty liver disease (NAFLD)</p>
											<p>Shizuya Yamashita (Rinku General Medical Center, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>14:15 - 14:45</th>
										<td>
											<p class="s_bold">New treatment targets beyond LDL-C in dyslipidaemias</p>
											<p>Alberico Catapano (University of Milan, Italy)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>14:45 - 15:05</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 15 (APSAVD/KSoLA Joint Symposium) COVID19 & cardiovascular risk -->
						<div>
							<table class="table color_table" name="symposium_15">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>16:15 - 17:45</th>
										<td class="green_bg">
											Symposium 15 (APSAVD/KSoLA Joint Symposium)<br/>COVID-19 & cardiovascular risk
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_15_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 16:15 - 17:45</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 15 (APSAVD/KSoLA Joint Symposium)<br/>COVID-19 & cardiovascular risk
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
											<p>Young-Bae Park (Seoul National University, Korea), Edward Janus (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Hong Nyun Kim (Kyungpook National University, Korea), Jung Ho Heo (Kosin University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>16:15 - 16:35</th>
										<td>
											<p class="s_bold">Impact of risk factors & medications on COVID-19 outcomes</p>
											<p>In Sook Kang (Ewha Womans University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>16:35 - 16:55</th>
										<td>
											<p class="s_bold">Effect of COVID-19 on dyslipidemia & vascular disease</p>
											<p>Edward Janus (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>16:55 - 17:15</th>
										<td>
											<p class="s_bold">Benefit & harm of COVID-19 vaccines in ASCVD</p>
											<p>Ta-Chen Su (National Taiwan University, Taiwan)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>17:15 - 17:40</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Luncheon Symposium 6 [Boehringer Ingelheim/Lilly] -->
						<div>
							<table class="table color_table" name="luncheon_symposium_6">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>12:00 - 12:50</th>
										<td class="green_bg">
											Luncheon Symposium 6 [Boehringer Ingelheim/Lilly]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_6_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 12:00 - 12:50</th>
									</tr>
									<tr>
										<td class="green_bg">
											Luncheon Symposium 6 [Boehringer Ingelheim/Lilly]
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
											<p>Shung Chull Chae (Kyungpook National University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Hye-Mi Kim (Chung-Ang University, Korea), Yeoree Yang  (The Catholic University of Korea, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:00 - 12:20</th>
										<td>
											<p class="s_bold">How does empagliflozin connect to CRM : HF underappreciated complication of T2D</p>
											<p>Sang-Hun Shin (Ewha Womans University, Korea)</p>
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
					<!-- Poster Hall-->
					<div class="tab_cont2">
						<!-- Moderated Poster Presentation 1 -->
						<div>
							<table class="table color_table" name="symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>15:15 - 15:55</th>
										<td class="pink_bg">
											Moderated Poster Presentation 1
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 15:15 - 15:55</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Moderated Poster Presentation 1
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
											<p>김소헌(인하의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김성애(한림의대), 이재혁(명지병원)</p>
										</td>
									</tr>
									<tr>
										<th>15:15 - 15:23</th>
										<td>
											<p class="s_bold">Oasl1 deficiency promotes eNOS mRNA degradation, accelerating endothelial dysfunction & atherogenesis</p>
											<p>김태경 (이화여대)</p>
										</td>
									</tr>
									<tr>
										<th>15:23 - 15:31</th>
										<td>
											<p class="s_bold">Loss of myeloid-PCSK9 improves cardio-protection against acute myocardial infarction</p>
											<p>문신혜 (이화여대)</p>
										</td>
									</tr>
									<tr>
										<th>15:31 - 15:39</th>
										<td>
											<p class="s_bold">Peroxiredoxin 3 preserves cardiac function by regulating mitochondrial quality control </p>
											<p>손성근 (이화여대)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>15:39 - 15:47</th>
										<td>
											<p class="s_bold">HMGB1 mediates MCP-1 expression in mechanically stressed vascular smooth muscle cells</p>
											<p>김지원 (부산대)</p>
										</td>
									</tr>
									<!--
									<tr class="discussion">
										<th>15:43 - 16:08</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
									-->
								</tbody>
							</table>
						</div>
						<!-- Moderated Poster Presentation 2 -->
						<div>
							<table class="table color_table" name="symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>15:15 - 15:55</th>
										<td class="green_bg">
											Moderated Poster Presentation 2
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 15:15 - 15:55</th>
									</tr>
									<tr class="green_bg">
										<td>
											Moderated Poster Presentation 2
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
											<p>Ung Kim (Yeungnam University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Yong Sook Kim (Chonnam National University, Korea), Heung Yong Jin (Jeonbuk National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:15 - 15:23</th>
										<td>
											<p class="s_bold">Cr6 interacting factor 1 deficiency increases homocysteine production in vascular endothelial cells</p>
											<p>Cuk Seong Kim (Chungnam National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:23 - 15:31</th>
										<td>
											<p class="s_bold">17 β-Estradiol Increases APE1/Ref-1 Secretion in vascular endothelial cells : involvement of calcium-dependent exosome pathway</p>
											<p>Yuran Lee (Chungnam National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:31 - 15:39</th>
										<td>
											<p class="s_bold">PFKFB3 & its role on ECM dependent vascular inflammation</p>
											<p>Jenita Immanuel (Inje University, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>15:39 - 15:47</th>
										<td>
											<p class="s_bold">PCSK9 deficient heart-derived ANP promotes cardiac survival after myocardial infarction</p>
											<p>Na Hyeon Yoon (Ewha Womans University, Korea)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Moderated Poster Presentation 5 (APSAVD Young Investigator) -->
						<div>
							<table class="table color_table" name="symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>15:05 - 15:55</th>
										<td class="green_bg">
											Moderated Poster Presentation 5 (APSAVD Young Investigator)
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 15:05 - 15:55</th>
									</tr>
									<tr class="green_bg">
										<td>
											Moderated Poster Presentation 5 (APSAVD Young Investigator)
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
								<!--
									<tr class="panel_tr">
										<th class="leftT">
											<p>Chairperson</p>
										</th>
										<td>
											<p>Ung Kim (Yeungnam University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Yong Sook Kim (Chonnam National University, Korea), Heung Yong Jin (Jeonbuk National University, Korea)</p>
										</td>
									</tr>
								-->
									<tr>
										<th>MP5-01</th>
										<td>
											<p class="s_bold">Fenofibrate lowers cardiac lipid accumulation & attenuates diabetic cardiomyopathy in dbdb mice</p>
											<p>Jiwon Park (GIST, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-02</th>
										<td>
											<p class="s_bold">In vitro & in silico inhibition of IL-6 & NF-κB by Nigella sativa oil & thymoquinone as potential anti atherogenic agent</p>
											<p>Al aina Yuhainis Firus Khan (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-03</th>
										<td>
											<p class="s_bold">Coronary risk factor profile amongst premature coronary artery disease patients according to different age categories</p>
											<p>Sukma Azureen Nazli (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-04</th>
										<td>
											<p class="s_bold">Genetic variations of ABCG5 & ABCG8 genes among clinically diagnosed fh patients attending primary care clinics in Malaysia</p>
											<p>Yung An Chua (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-05</th>
										<td>
											<p class="s_bold">Genetic landscape of pathogenic variants in familial hypercholesterolaemia candidate genes among patients attending primary care clinics in Malaysia</p>
											<p>Nur Syahirah Shahuri (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-06</th>
										<td>
											<p class="s_bold">Prediction rate of pathogenic variants diagnosed by various diagnostic criteria among familial hypercholesterolaemic patients attending primary care clinics</p>
											<p>Sukma Azureen Nazli (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-07</th>
										<td>
											<p class="s_bold">Pharmacologic activation of angiotensin-converting enzyme II alleviates diabetic cardiomyopathy in db/db mice by reducing reactive oxidative stress</p>
											<p>Woo ju Jeong (GIST, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-08</th>
										<td>
											<p class="s_bold">Body type parameters predict cerebral small vessel disease</p>
											<p>Ki-Woong Nam (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>MP5-09</th>
										<td>
											<p class="s_bold">A comparison of statin treatment algorithms for primary prevention in statin-naive Filipino patients</p>
											<p>Bayani Pocholo Maglinte (Cebu Velez General Hospital, the Philippines)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!----- Day 03 ----->
			<div class="tab_cont">
				<ul class="room_tab add_poster">
					<li class="on"><a href="javascript:;">Room 1</a></li>
					<li><a href="javascript:;">Room 2</a></li>
					<li><a href="javascript:;">Room 3</a></li>
					<li><a href="javascript:;">Room 4</a></li>
					<li><a href="javascript:;">Poster Hall</a></li>
				</ul>
				<div class="tab_wrap">
					<!-- Room 1-->
					<div class="tab_cont2 on">
						<!-- Plenary Lecture 4 -->
						<div>
							<table class="table color_table" name="plenary_lecture_4">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:00 - 09:40</th>
										<td class="green_bg">
											Plenary Lecture 4
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_4_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:00 - 09:40</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 4
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
											<p>Joong-Yeol Park (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:00 - 09:40</th>
										<td>
											<p class="s_bold">New look at PCSK9 metabolism & its clinical implication</p>
											<p>Sergio Fazio (Regeneron Pharmaceuticals, USA)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 16. Current issues in severe dyslipidemia -->
						<div>
							<table class="table color_table" name="symposium_16">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:45 - 11:15</th>
										<td class="pink_bg">
											Symposium 16 <br/>Current issues in severe dyslipidemia										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_16_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:45 - 11:15</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Symposium 16 Current issues in severe dyslipidemia
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
											<p>최경묵 (고려의대), 강현재 (서울의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>곽수헌 (서울의대), 변영섭 (인제의대)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">What is currently best & changing in treatment of adults with FH?</p>
											<p>이원재 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Update on familial vs multifactorial chylomicronemia syndrome</p>
											<p>진흥용 (전북의대)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Understanding role of ANGPTL3 & neighbor molecules</p>
											<p>박훈준 (가톨릭의대)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 5 -->
						<div>
							<table class="table color_table" name="plenary_lecture_5">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>11:25 - 12:05</th>
										<td class="green_bg">
											Plenary Lecture 5
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_5_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 11:25 - 12:05</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 5
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
											<p>Ki Hoon Han (University of Ulsan, Korea) </p>
										</td>
									</tr>
									<tr>
										<th>11:25 - 12:05</th>
										<td>
											<p class="s_bold">Best approach to cardio & cerebrovascular health in the elderly</p>
											<p>Hidenori Arai (National Center for Geriatrics and Gerontology, Japan)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 6 (APSAVD:Yamamoto Lecture) -->
						<div>
							<table class="table color_table" name="plenary_lecture_6">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>13:00 - 13:30</th>
										<td class="green_bg">
											Plenary Lecture 6 (APSAVD:Yamamoto Lecture)
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_6_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 13:00 - 13:30</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 6 (APSAVD:Yamamoto Lecture)
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
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>13:00 - 13:30</th>
										<td>
											<p class="s_bold">Up close & personal with vascular diseases: the role of precision medicine</p>
											<p>Maria Teresa Abola (University of Philippines, Philippines)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Oral Presentation 4  -->
						<div>
							<table class="table color_table" name="oral_presentation_4">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>13:35 - 14:35</th>
										<td class="pink_bg">
											Oral Presentation 4									
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="oral_presentation_4_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 13:35 - 14:35</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Oral Presentation 4 										
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
											<p>허경선 (충남대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>박세은(성균관의대), 서미혜(순천향의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:42</th>
										<td>
											<p class="s_bold">Evaluation of the paradoxical association between lipid levels & incident atrial fibrillation according to statin usage: a nationwide cohort study </p>
											<p>안효정 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:42 - 13:49</th>
										<td>
											<p class="s_bold">Comparison of cerebro-cardiovascular prognosis between cholesterol exposure estimate & cholesterol variability</p>
											<p>주형준 (고려의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:49 - 13:56</th>
										<td>
											<p class="s_bold">Early change in glucose level & risk of new-onset diabetes in patients initiating statin treatment</p>
											<p>김충기 (이화의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:56 - 14:03</th>
										<td>
											<p class="s_bold">Low-density lipoprotein cholesterol level, statin use & myocardial infarction risk in young adults</p>
											<p>김미경 (가톨릭의대)</p>
										</td>
									</tr>
									<tr>
										<th>14:03 - 14:28</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 20 How will new technologies change our research & patient care in ASCVD? -->
						<div>
							<table class="table color_table" name="symposium_20">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>14:45 - 16:15</th>
										<td class="pink_bg">
											Symposium 20<br/>How will new technologies change our research & patient care in ASCVD?										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_20_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 14:45 - 16:15</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Symposium 20<br/>How will new technologies change our research & patient care in ASCVD?										
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
											<p>한승환 (가천의대), 김대중 (아주의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>서용성 (명지병원), 황지원(인제의대)</p>
										</td>
									</tr>
									<tr>
										<th>14:45 - 15:05</th>
										<td>
											<p class="s_bold">Tips for performing nationwide big cohort studies</p>
											<p>양필성 (차의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:05 - 15:25</th>
										<td>
											<p class="s_bold">Advance of AI utility in past 5 years in ASCVD care: overview</p>
											<p>조준환 (중앙의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:25 - 15:45</th>
										<td>
											<p class="s_bold">Device-based care for CV risk factors</p>
											<p>이학승 (메디컬에이아이)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>15:45 - 16:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Breakfast Symposium 3 (K) [Yuhan]  -->
						<div>
							<table class="table color_table" name="breakfast_symposium_3">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>08:00 - 09:00</th>
										<td class="pink_bg">
											Breakfast Symposium 3 [Yuhan]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="breakfast_symposium_3_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 08:00 - 09:00</th>
									</tr>
									<tr>
										<td class="pink_bg">
											Breakfast Symposium 3 [Yuhan]
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
											<p>손태서 (가톨릭의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김정수 (부산의대), 전성완 (순천향의대)</p>
										</td>
									</tr>
									<tr>
										<th>08:00 - 08:20</th>
										<td>
											<p class="s_bold">A new paradigm of combination therapy in hypercholesterolemia treatment: rosuvastatin & ezetimibe</p>
											<p>김병진 (성균관의대)</p>
										</td>
									</tr>
									<tr>
										<th>08:20 - 08:30</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Luncheon Symposium 7 (K) [Inno.N]  -->
						<div>
							<table class="table color_table" name="luncheon_symposium_7">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>12:05 - 12:55</th>
										<td class="pink_bg">
											Luncheon Symposium 7 [Inno.N]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_7_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 12:05 - 12:55</th>
									</tr>
									<tr>
										<td class="pink_bg">
											Luncheon Symposium 7 [Inno.N]
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
											<p>이현철 (연세이현철내과)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>박형복 (가톨릭관동대), 서미혜 (순천향의대)</p>
										</td>
									</tr>
									<tr>
										<th>12:05 - 12:25</th>
										<td>
											<p class="s_bold">Treatment of dyslipidemia with rosuvastatin & ezetimibe</p>
											<p>김상현 (서울의대)</p>
										</td>
									</tr>
									<tr>
										<th>12:25 - 12:35</th>
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
						<!-- Plenary Lecture 4 -->
						<div>
							<table class="table color_table" name="plenary_lecture_4_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:00 - 09:40</th>
										<td class="green_bg">
											Plenary Lecture 4
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_4_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:00 - 09:40</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 4
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
											<p>Joong-Yeol Park (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:00 - 09:40</th>
										<td>
											<p class="s_bold">New look at PCSK9 metabolism & its clinical implication</p>
											<p>Sergio Fazio (Regeneron Pharmaceuticals, USA)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 17 Emerging targets & drug platforms in dyslipidemia & atherosclerosis -->
						<div>
							<table class="table color_table" name="symposium_17">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:45 - 11:15</th>
										<td class="green_bg">
											Symposium 17<br/>Emerging targets & drug platforms in dyslipidemia & atherosclerosis										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_17_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:45 - 11:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 17 Emerging targets & drug platforms in dyslipidemia & atherosclerosis										
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
											<p>Kyong Soo Park (Seoul National University, Korea), Alan Remaley (National Institute of Health, USA)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Gyuri Kim (Sunkyunkwan University, Korea), Chang-Hoon Woo (Yeungnam University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Impact of lipases on human dyslipidemia & atherosclerosis</p>
											<p>Hayato Tada (Kanazawa University, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Discover of new genes involved in low-density lipoprotein metabolism by genome-wide CRISPR-Cas9 screens</p>
											<p>Alan Remaley (National Institutes of Health, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Understanding strength & limitation of platforms in drug development</p>
											<p>Dong Ki Lee (OliX Pharmaceuticals, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 5 -->
						<div>
							<table class="table color_table" name="plenary_lecture_5_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>11:25 - 12:05</th>
										<td class="green_bg">
											Plenary Lecture 5
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_5_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 11:25 - 12:05</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 5
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
											<p>Ki Hoon Han (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>11:25 - 12:05</th>
										<td>
											<p class="s_bold">Best approach to cardio & cerebrovascular health in the elderly</p>
											<p>Hidenori Arai (National Center for Geriatrics and Gerontology, Japan)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 6 (APSAVD:Yamamoto Lecture) -->
						<div>
							<table class="table color_table" name="plenary_lecture_6_1">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>13:00 - 13:30</th>
										<td class="green_bg">
											Plenary Lecture 6 (APSAVD:Yamamoto Lecture)										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_6_1_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 13:00 - 13:30</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 6 (APSAVD:Yamamoto Lecture)
											
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
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>13:00 - 13:30</th>
										<td>
											<p class="s_bold">Up close & personal with vascular diseases: the role of precision medicine</p>
											<p>Maria Teresa Abola (University of Philippines, Philippines)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Oral Presentation 5 -->
						<div>
							<table class="table color_table" name="oral_presentation_5">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>13:35 - 14:35</th>
										<td class="green_bg">
											Oral Presentation 5
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="oral_presentation_5_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 13:35 - 14:35</th>
									</tr>
									<tr class="green_bg">
										<td>
											Oral Presentation 5										
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
											<p>Eun Seok Kang (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Yong-ho Lee (Yonsei University, Korea), Ji-won Hwang (Inje University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:42</th>
										<td>
											<p class="s_bold">Ginsenoside Rh1 abolishes ROS-dependent KLF4 signaling pathway to inhibit proliferation & migration of vascular smooth muscle cells</p>
											<p>Diem Thi Ngoc Huynh (Chungnam National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:42 - 13:49</th>
										<td>
											<p class="s_bold">PCSK9 inhibitors inhibit monocyte adherence to stimulated human coronary artery endothelial cells</p>
											<p>Rahayu Zulkapli (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>13:49 - 13:56</th>
										<td>
											<p class="s_bold">Lipoprotein(a) & cardiovascular & all-cause mortality in Korean adults</p>
											<p>Byung Jin Kim (Sungkyunkwan University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:56 - 14:03</th>
										<td>
											<p class="s_bold">Saffron: a potential natural alternative remedy for statin intolerance</p>
											<p>Iman Nabilah Abd Rahim (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr>
										<th>14:03 - 14:28</th>
										<td>
											<p class="s_bold">Q&A</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 21 New concepts in vascular biology -->
						<div>
							<table class="table color_table" name="symposium_21">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>14:45 - 16:15</th>
										<td class="pink_bg">
											Symposium 21 <br/>New concepts in vascular biology										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_21_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 14:45 - 16:15</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Symposium 21  New concepts in vascular biology										
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
											<p>김치대 (부산대), 국현 (전남대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>진은선 (경희의대), 허진 (부산대)</p>
										</td>
									</tr>
									<tr>
										<th>14:45 - 15:05</th>
										<td>
											<p class="s_bold">What's new in vascular calcification in atherosclerosis?</p>
											<p>이인규 (경북의대)</p>
										</td>
									</tr>
									<tr>
										<th>15:05 - 15:25</th>
										<td>
											<p class="s_bold">Senotherapeutics; a novel strategy for atherosclerosis</p>
											<p>김재룡 (영남대)</p>
										</td>
									</tr>
									<tr>
										<th>15:25 - 15:45</th>
										<td>
											<p class="s_bold">Extracellular vesicles & endothelial cells</p>
											<p>권기환 (이화의대)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>15:45 - 16:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Breakfast Symposium 4 [JW Pharmaceutical] -->
						<div>
							<table class="table color_table" name="breakfast_symposium_4">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>08:00 - 09:00</th>
										<td class="green_bg">
											Breakfast Symposium 4 [JW Pharmaceutical]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="breakfast_symposium_4_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 08:00 - 09:00</th>
									</tr>
									<tr>
										<td class="green_bg">
											Breakfast Symposium 4 [JW Pharmaceutical]
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
											<p>Ung Kim (Yeungnam University, Korea) </p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panel</p>
										</th>
										<td>
											<p>Kyung-Soo Kim (CHA University, Korea), Jae Hyuk Choi (Hallym University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>08:00 - 08:20</th>
										<td>
											<p class="s_bold">Management of poorly controlled patients with diabetes mellitus</p>
											<p>Yongho Lee (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>08:20 - 08:30</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Luncheon Symposium 8 (K) [Hanmi] -->
						<div>
							<table class="table color_table" name="luncheon_symposium_8">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>12:05 - 12:55</th>
										<td class="pink_bg">
											Luncheon Symposium 8 [Hanmi]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_8_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 12:05 - 12:55</th>
									</tr>
									<tr>
										<td class="pink_bg">
											Luncheon Symposium 8 [Hanmi]
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
											<p>서홍석 (고려의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김병규 (인제의대), 조윤경 (울산의대)</p>
										</td>
									</tr>
									<tr>
										<th>12:05 - 12:25</th>
										<td>
											<p class="s_bold">Paradigm shift in dyslipidemia treatment (feat. RACING trial)</p>
											<p>나승운 (고려의대)</p>
										</td>
									</tr>
									<tr>
										<th>12:25 - 12:35</th>
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
						<!-- Plenary Lecture 4 -->
						<div>
							<table class="table color_table" name="plenary_lecture_4_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:00 - 09:40</th>
										<td class="green_bg">
											Plenary Lecture 4
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_4_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:00 - 09:40</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 4
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
											<p>Joong-Yeol Park (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:00 - 09:40</th>
										<td>
											<p class="s_bold">New look at PCSK9 metabolism & its clinical implication</p>
											<p>Sergio Fazio (Regeneron Pharmaceuticals, USA)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 18 Role & unsolved issues of novel lipid-modifying agents -->
						<div>
							<table class="table color_table" name="symposium_18">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:45 - 11:15</th>
										<td class="green_bg">
											Symposium 18<br/>Role & unsolved issues of novel lipid-modifying agents										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_18_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:45 - 11:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 18 Role & unsolved issues of novel lipid-modifying agents										
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
											<p>Byung Jin Kim (Sungkyunkwan University, Korea), Soo Lim (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Min Kyong Moon (Seoul National University, Korea), Jang Hoon Lee (Kyungpook National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Challenges & perspective of drugs for Lp(a)</p>
											<p>Gisette Reyes-Soffer (Columbia University, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">For whom & how much will bempedoic acid work?</p>
											<p>Raul Santos (University of São Paulo, Brazil)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Recent trial results of new drugs targeting TG rich lipoprotein</p>
											<p>Eun Ho Choo (The Catholic University of Korea, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 5 -->
						<div>
							<table class="table color_table" name="plenary_lecture_5_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>11:25 - 12:05</th>
										<td class="green_bg">
											Plenary Lecture 5
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_5_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 11:25 - 12:05</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 5
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
											<p>Ki Hoon Han (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>11:25 - 12:05</th>
										<td>
											<p class="s_bold">Best approach to cardio & cerebrovascular health in the elderly</p>
											<p>Hidenori Arai (National Center for Geriatrics and Gerontology, Japan)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Plenary Lecture 6 (APSAVD:Yamamoto Lecture) -->
						<div>
							<table class="table color_table" name="plenary_lecture_6_2">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>13:00 - 13:30</th>
										<td class="green_bg">
											Plenary Lecture 6 (APSAVD:Yamamoto Lecture)										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="plenary_lecture_6_2_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 13:00 - 13:30</th>
									</tr>
									<tr class="green_bg">
										<td>
											Plenary Lecture 6 (APSAVD:Yamamoto Lecture)										
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
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>13:00 - 13:30</th>
										<td>
											<p class="s_bold">Up close & personal with vascular diseases: the role of precision medicine</p>
											<p>Maria Teresa Abola (University of Philippines, Philippines)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 22 (TSLA/KSoLA Joint Symposium) Sex difference in dyslipidemia & atherosclerosis -->
						<div>
							<table class="table color_table" name="symposium_22">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>14:45 - 16:15</th>
										<td class="green_bg">
											Symposium 22 (TSLA/KSoLA Joint Symposium)<br/>Sex difference in dyslipidemia & atherosclerosis										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_22_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 14:45 - 16:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 22 (TSLA/KSoLA Joint Symposium) Sex difference in dyslipidemia & atherosclerosis										
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
											<p>Sang-Hyun Kim (Seoul National University, Korea), Chul Sik Kim (Yonsei University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Sung-Eun Kim (Hallym University, Korea), Sang Min Park (Eulji University, Korea)</p> 
										</td>
									</tr>
									<tr>
										<th>14:45 - 15:05</th>
										<td>
											<p class="s_bold">Characteristics of dyslipidemia & ASCVD of women</p>
											<p>Mi-Na Kim (Korea University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:05 - 15:25</th>
										<td>
											<p class="s_bold">Sex difference in diagnosis & treatment of ASCVD: what do we need to improve in women?</p>
											<p>Ping-Yen Liu (National Cheng Kung University, Taiwan)</p>
										</td>
									</tr>
									<tr>
										<th>15:25 - 15:45</th>
										<td>
											<p class="s_bold">Is there difference of response to lipid-lowering therapy in women?</p>
											<p>Chih-Fan Yeh  (National Taiwan University, Taiwan)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>15:45 - 16:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Breakfast Symposium 5 -->
						<!--
						<div>
							<table class="table color_table">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>08:00 - 09:00</th>
										<td>
											Breakfast Symposium 5
											
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 08:00 - 09:00</th>
									</tr>
									<tr>
										<td>
											Breakfast Symposium 5
											
										</td>
									</tr>
									<tr>
										<td><button type="button" class="favorite_btn centerT">My Favorite</button></td>
									</tr>
								</tbody>
							</table>
							<div class="after_box purple">
								<ul>
									<li><span>Chairperson</span>Chairperson</li>
									<li><span>Panels</span>Panels</li>
								</ul>
							</div>
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
											<p></p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p></p>
										</td>
									</tr>
									<tr>
										<th>08:00 - 08:20</th>
										<td>
											<p class="s_bold"></p>
											<p></p>
										</td>
									</tr>
									<tr>
										<th>08:20 - 08:30</th>
										<td>
											<p class="s_bold"></p>
											<p></p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>-->
						<!-- Luncheon Symposium 9 [Amgen] -->
						<div>
							<table class="table color_table" name="luncheon_symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>12:05 - 12:55</th>
										<td class="green_bg">
											Luncheon Symposium 9 [Amgen]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 12:05 - 12:55</th>
									</tr>
									<tr>
										<td class="green_bg">
											Luncheon Symposium 9 [Amgen]
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
											<p>Kyong Soo Park (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Eu Jeong Ku (Chungbuk National University, Korea), Choongki Kim (Ewha Womans University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:05 - 12:25</th>
										<td>
											<p class="s_bold">Key updates in the recent guidelines – identifying patients for evolocumab therapy</p>
											<p>Wonjae Lee (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:25 - 12:35</th>
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
						<!-- Symposium 19 Current nutritional knowledge in cardiometabolic health -->
						<div>
							<table class="table color_table" name="symposium_19">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>09:45 - 11:15</th>
										<td class="green_bg">
											Symposium 19<br/>Current nutritional knowledge in cardiometabolic health										
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_19_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 09:45 - 11:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 19 Current nutritional knowledge in cardiometabolic health										
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
											<p>Ji-Young Lee (University of Connecticut, USA), Kee Ho Song (Konkuk University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>In-Jeong Cho (Ewha Womans University, Korea), Jeong-Hwa Choi (Keimyung University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Organ crosstalk under atherogenic diet</p>
											<p>Cholsoon Jang (University of California Irvine, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Emerging role of epigenetic regulation by nutrients in inflammation & atherosclerosis</p>
											<p>Hyunju Kang (Keimyung University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Transition to metabolically unhealthy status & cardiometabolic risks</p>
											<p>Clara Yongjoo Park (Chonnam National University, Korea)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>10:45 - 11:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Symposium 23 (APSAVD Joint Symposium) Update on antibodies & siRNA against PCSK9 -->
						<div>
							<table class="table color_table" name="symposium_23">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>14:45 - 16:15</th>
										<td class="green_bg">
											Symposium 23 (APSAVD Joint Symposium)<br/>Update on antibodies & siRNA against PCSK9
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_23_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 14:45 - 16:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Symposium 23 (APSAVD Joint Symposium)<br/>Update on antibodies & siRNA against PCSK9
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
											<p>In-Kyung Jeong (Kyung Hee University, Korea), Hapizah Mohd Nawawi (Universiti Teknologi MARA, Malaysia)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Hyun Jae Kang (Seoul National University, Korea), Jong-Young Lee (Sungkyunkwan University, Korea) </p>
										</td>
									</tr>
									<tr>
										<th>14:45 - 15:05</th>
										<td>
											<p class="s_bold">Practical approach of PCSK9 Ab use in primary & secondary prevention</p>
											<p>Young Joon Hong (Chonnam National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>15:05 - 15:25</th>
										<td>
											<p class="s_bold">Comparison of two drug platforms for PCSK9 inhibition (Monoclonal antibodies & siRNA)</p>
											<p>Richard O’Brien (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr>
										<th>15:25 - 15:45</th>
										<td>
											<p class="s_bold">Patients who are resistant to or hypo-respond to PCSK9 inhibitors – a therapeutic challenge</p>
											<p>Edward Janus (University of Melbourne, Australia)</p>
										</td>
									</tr>
									<tr class="discussion">
										<th>15:45 - 16:10</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="circle_title">Breakfast &amp; Luncheon Symposium</div>
						<!-- Luncheon Symposium 10 [Sanofi] -->
						<div>
							<table class="table color_table" name="luncheon_symposium_10">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 17(Sat)<br/>12:05 - 12:55</th>
										<td class="green_bg">
											Luncheon Symposium 10 [Sanofi]
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="luncheon_symposium_10_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 17(Sat) 12:05 - 12:55</th>
									</tr>
									<tr>
										<td class="green_bg">
											Luncheon Symposium 10 [Sanofi]
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
											<p>In-Kyu Lee (Kyungpook National University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Jae Hyun Bae (Korea University, Korea), Sang-Hun Shin (Ewha Womans University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:05 - 12:25</th>
										<td>
											<p class="s_bold">The time for intensive LLT in very high-risk patients based on the updated Korean guideline</p>
											<p>Hoyoun Won (Chung-Ang University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>12:25 - 12:35</th>
										<td>
											<p class="s_bold">Discussion</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Poster Hall-->
					<div class="tab_cont2">
						<!-- Moderated Poster Presentation 3 -->
						<div>
							<table class="table color_table" name="symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>13:35 - 14:15</th>
										<td class="pink_bg">
											Moderated Poster Presentation 3
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 13:35 - 14:15</th>
									</tr>
									<tr class="pink_bg">
										<td>
											Moderated Poster Presentation 3
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
											<p>전성완(순천향의대)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>김경수(차의대), 최한석(동국의대)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:43</th>
										<td>
											<p class="s_bold">Autocrine regulation of cellular migration by secreted molecules from mechanically stressed vascular smooth muscle cells </p>
											<p>김주연 (부산대)</p>
										</td>
									</tr>
									<tr>
										<th>13:43 - 13:51</th>
										<td>
											<p class="s_bold">Depression & subclinical coronary atherosclerosis in adults without clinical coronary artery disease</p>
											<p>박경민 (울산대)</p>
										</td>
									</tr>
									<tr>
										<th>13:51 - 13:59</th>
										<td>
											<p class="s_bold">Effect of lifestyle modification on the improvement of obesity, metabolic parameters & adipo-myokine related risk in overweight/obese adults</p>
											<p>하미리 (동아대)</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- Moderated Poster Presentation 4 -->
						<div>
							<table class="table color_table" name="symposium_9">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th class="gray_bg">September 16(Fri)<br/>13:35 - 14:15</th>
										<td class="green_bg">
											Moderated Poster Presentation 4
											<button type="button" class="favorite_btn centerT">My Favorite</button>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="table color_table mobile" name="symposium_9_mb">
								<tbody>
									<tr class="gray_bg">
										<th>September 16(Fri) 13:35 - 14:15</th>
									</tr>
									<tr class="green_bg">
										<td>
											Moderated Poster Presentation 4
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
											<p>Su Yeon Choi (Seoul National University, Korea)</p>
										</td>
									</tr>
									<tr class="panel_tr">
										<th class="leftT">
											<p>Panels</p>
										</th>
										<td>
											<p>Hoyoun Won (Chung-Ang University, Korea), Kae Won Cho (Soonchunhyang University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:35 - 13:43</th>
										<td>
											<p class="s_bold">Mutation in CytB gene associated with macrophage intracellular lipid metabolism</p>
											<p>Vasily Sukhorukov (Institute for Atherosclerosis Research, Russia)</p>
										</td>
									</tr>
									<tr>
										<th>13:43 - 13:51</th>
										<td>
											<p class="s_bold">Human milk oligosaccharides attenuate lipopolysaccharide-induced endothelial hyper-permeability & migration</p>
											<p>Dung Van Nguyen (Chungnam National University, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>13:51 - 13:59</th>
										<td>
											<p class="s_bold">Modeling of low-density lipoprotein desialylation processes in mice</p>
											<p>Dmitry Kashirskikh (Petrovsky National Research Centre of Surgery, Russia)</p>
										</td>
									</tr>
									<tr>
										<th>13:59 - 14:07</th>
										<td>
											<p class="s_bold">Tyrosine Residues of mitochondrial creatine kinase mitigate hypoxia/reoxygenation injury in the heart through phosphorylation</p>
											<p>Maria Victoria Faith Garcia (Cardiovascular and Metabolic Disease Center, Korea)</p>
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
<script>
	$(document).ready(function() {
		$(".room_tab li").click(function(){
			// style toggle
			$(this).parents(".room_tab").children("li").removeClass("on");
			$(this).addClass("on");
			// pager toggle
			var x = $(this).index();
			$(this).parents(".room_tab").next(".tab_wrap").children(".tab_cont2").removeClass("on");
			$(this).parents(".room_tab").next(".tab_wrap").children(".tab_cont2").eq(x).addClass("on");
		});

		$(".table.detail_table2").each(function(){
			var tr_length = $(this).find(".panel_tr").length;
			if (tr_length === 1){
				$(this).find("tr").addClass("one");
			}
		});

		$(".color_table td").each(function(){
			if ($(this).hasClass("green_bg")){
				$(this).parents(".color_table").siblings(".detail_table2").find(".panel_tr th p").css("color","#00666B")
			}
		});
		
	});
</script>
<?php
	if($member_idx == "") {
?>
<script>
	$(".favorite_btn").click(function(){
		alert(locale(language.value)('need_login'));
	});
</script>
<?php
	} else {
?>
<script>
	//console.log(fave_list);
	$(document).ready(function() {
		var fave_list = JSON.parse('<?=json_encode($fave_list)?>');
		var temp_idx;
		fave_list.forEach(function(el){
			temp_idx = el.table_idx-1;
			$(".tab_cont2>div").eq(temp_idx).find(".favorite_btn").addClass('on');
		});
	});

	$(".favorite_btn").click(function(){
		var _this = $(this);

		var index = $(".tab_cont2>div").index((_this.parents('table').parent())) + 1;
		var date = _this.parent().siblings('th').text().replace(")", ") ");
		var title =  _this.parent().html().replace("<br>", " ").replace(/\t/ig, "").split('<button')[0];
		var room = $('.room_tab li.on>a').eq(0).text();
		/*console.log('index', index);
		console.log('date', date);
		console.log('title', title);
		console.log('room', room);*/

		$.ajax({
			url : PATH+"ajax/client/ajax_lecture.php",
			type : "POST",
			data : {
				flag: 'fave',
				idx: index,
				date: date,
				title: title,
				room: room
			},
			dataType : "JSON",
			success : function(res){
				//console.log(res);
				if(res.code == 200) {
					if (res.type == "ins") {
						_this.addClass("on");
					} else {
						_this.removeClass("on");
					}
					//alert(locale(language.value)("send_mail_success"));
					//location.href = './abstract_submission3.php?idx=' + submission_idx
				}
			},
			complete:function(){
				$(".loading").hide();
				$("body").css("overflow-y","auto");

				//alreadyProcess = false;
			}
		});
	});
</script>
<?php
	}

	include_once('./include/footer.php');
?>
