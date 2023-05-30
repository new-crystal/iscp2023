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
			<li><a href="/main/scientific_program1.php">September 15 <i></i>(Thu)</a></li>
			<li><a href="/main/scientific_program2.php">September 16 <i></i>(Fri)</a></li>
			<li class="on"><a href="/main/scientific_program3.php">September 17 <i></i>(Sat)</a></li>
		</ul>
		<ul class="program_color_txt">
			<li><i></i>&nbsp;:&nbsp;Korean</li>
			<li><i></i>&nbsp;:&nbsp;English</li>
		</ul>
		<p class="rightT lecture_alert">※Some lectures will be pre-recorded.</p>
		<div class="tab_wrap">
			<!----- Day 03 ----->
			<div>
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
											<p class="s_bold">Effect of alirocumab in subjects with likely familial hypercholesterolemia or type III hyperlipidemia: analyses from the ODYSSEY outcomes study</p>
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
											<p class="s_bold">Update on familial vs multifactorial chylomicronemia syndrome (CS)</p>
											<p>진흥용 (전북의대)</p>
										</td>
									</tr>
									<tr>
										<th>10:25 - 10:45</th>
										<td>
											<p class="s_bold">Understanding role of ANGPTL3 & neighbor molecules <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Best approach to cardio & cerebrovascular health in older people <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Up close & personal with vascular diseases: the role of precision medicine <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Comparison of cerebro-cardiovascular prognosis between cholesterol exposure estimate & cholesterol variability </p>
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
											<p>이준원(연세의대), 주형준(고려의대)</p>
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
											<p class="s_bold">Novel electrocardiogram generating technique using artificial intelligence: from 2-lead to 12-lead <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Effect of alirocumab in subjects with likely familial hypercholesterolemia or type III hyperlipidemia: analyses from the ODYSSEY outcomes study</p>
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
											<p class="s_bold">Development of a GalNAc-asiRNA for treatment of NASH with fibrosis</p>
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
											<p class="s_bold">Best approach to cardio & cerebrovascular health in older people <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Up close & personal with vascular diseases: the role of precision medicine <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p>Yong-ho Lee (Yonsei University, Korea)</p>
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
											<p class="s_bold">Lipoprotein(a) & cardiovascular & all-cause mortality in Korean adults </p>
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
											<p class="s_bold">What’s the role of mitochondrial dysfunction in pathogenesis of vascular calcification?</p>
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
											<p class="s_bold">Extracellular vesicles in endothelial cells: from inter-cellular communication to cargo delivery tools</p>
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
											<p>Yong-ho Lee (Yonsei University, Korea)</p>
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
											<p class="s_bold">Why should we consider rosuvastatin-ezetimibe fixed dose combination?: strategies for reaching LDL goals in cardiovascular disease patients</p>
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
											<p class="s_bold">Effect of alirocumab in subjects with likely familial hypercholesterolemia or type III hyperlipidemia: analyses from the ODYSSEY outcomes study</p>
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
											<p class="s_bold">Challenges & perspective of drugs for Lp(a) <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Gisette Reyes-Soffer (Columbia University, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">For whom & how much will bempedoic acid work? <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Best approach to cardio & cerebrovascular health in older people <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Up close & personal with vascular diseases: the role of precision medicine <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Gender difference in cardiovascular disease: focus on antiplatelet therapy <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Ping-Yen Liu (National Cheng Kung University, Taiwan)</p>
										</td>
									</tr>
									<tr>
										<th>15:25 - 15:45</th>
										<td>
											<p class="s_bold">Is there difference of response to lipid-lowering therapy in women? <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p>Kee Ho Song (Konkuk University, Korea)</p>
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
											<p class="s_bold">Organ crosstalk under atherogenic diet <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">The time for intensive lipid lowering therapy in very high-risk patients based on the updated Korean guideline</p>
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
<input type="hidden" value="<?= $type ?>" name="type">
<input type="hidden" value="<?= $e ?>" name="e">
<input type="hidden" value="<?= $e_num ?>" name="e_num">
<input type="hidden" value="<?= $d_num ?>" name="d_num">
<input type="hidden" value="<?= $name ?>" name="name">
<?php
	if(!empty($e_num)) {
?>
<script src="./js/script/client/scientific_program.js?v=0.1"></script>
<?php
	}
?>
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
