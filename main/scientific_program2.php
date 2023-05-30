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
			<li class="on"><a href="/main/scientific_program2.php">September 16 <i></i>(Fri)</a></li>
			<li><a href="/main/scientific_program3.php">September 17 <i></i>(Sat)</a></li>
		</ul>
		<ul class="program_color_txt">
			<li><i></i>&nbsp;:&nbsp;Korean</li>
			<li><i></i>&nbsp;:&nbsp;English</li>
		</ul>
		<p class="rightT lecture_alert">※Some lectures will be pre-recorded.</p>
		<div class="tab_wrap">
			<!----- Day 02 ----->
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
											<p class="s_bold">From reading the genome for risk to rewriting it for cardiovascular health <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Novel mechanisms for lipogenesis <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Sex-dependent NAD+ metabolism in the liver & adipose tissue <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Recent developments in the treatment of familial hypercholesterolaemia &amp; other familial lipid disorders <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Senescence & vascular smooth muscle cell plasticity <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">From reading the genome for risk to rewriting it for cardiovascular health <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p>Eun Hee Koh (University of Ulsan, Korea)</p>
										</td>
									</tr>
									<tr>
										<th>09:45 - 10:05</th>
										<td>
											<p class="s_bold">Validation of metabolic targets in adipose tissue for ASCVD: focus on the KLF14 locus</p>
											<p>Mete Civelek (University of Virginia, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Deficiency of myeloid PHD proteins aggravates atherogenesis via macrophage apoptosis & paracrine fibrotic signalling <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Recent developments in the treatment of familial hypercholesterolaemia &amp; other familial lipid disorders <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Senescence & vascular smooth muscle cell plasticity <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Dyslipidemia & type 2 diabetes among Filipino adults <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Metabolism & health impacts of dietary sugars <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">From reading the genome for risk to rewriting it for cardiovascular health</p>
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
											<p class="s_bold">What is the role of a polygenic risk score in CV risk assessment? <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Amit Khera (Verve Therapeutics, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">Refinement of CV risk in current very high & high risk groups</p>
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
											<p class="s_bold">Recent developments in the treatment of familial hypercholesterolaemia &amp; other familial lipid disorders <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Senescence & vascular smooth muscle cell plasticity <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p>Young-Kook Kim (Chonnam National University, Korea), Chang Hee Jung (University of Ulsan), Korea)</p>
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
											<p class="s_bold">Inflammation & hematopoiesis in atherosclerosis <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">TG lowering: hope vs. hype?</p>
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
											<p class="s_bold">Targeting senescent cells as a novel therapeutic strategy for lifestyle-related disease <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Tohru Minamino (Juntendo University, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>16:55 - 17:15</th>
										<td>
											<p class="s_bold">What effect do cardiovascular medications & diet have on vascular aging? <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Cardiovascular disease & the bone marrow <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Matthias Nahrendorf (Harvard Medical School, USA)</p>
										</td>
									</tr>
									<tr>
										<th>10:05 - 10:25</th>
										<td>
											<p class="s_bold">The dietary pattern approach to prevent cardiovascular disease. Dietary effects on HDL subspecies may contribute benefits <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
						<!-- Symposium 12 (EAS/APSAVD/JAS Joint Symposium) TBD -->
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
											Symposium 12 (EAS/APSAVD/JAS Joint Symposium)<br/>Dyslipidaemia
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
											Symposium 12 (EAS/APSAVD/JAS Joint Symposium)<br/>Dyslipidaemia
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
											<p class="s_bold">Dyslipidaemia - new treatments for ApoC3 & ANGPTL3 <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Brian Tomlinson (Macau University of Science & Technology, China)</p>
										</td>
									</tr>
									<tr>
										<th>13:55 - 14:15</th>
										<td>
											<p class="s_bold">Novel selective PPARa modulator pemafibrate for dyslipidemia & nonalcoholic fatty liver disease (NAFLD) <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Shizuya Yamashita (Rinku General Medical Center, Japan)</p>
										</td>
									</tr>
									<tr>
										<th>14:15 - 14:45</th>
										<td>
											<p class="s_bold">New treatment targets beyond LDL-C in dyslipidaemias <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
											<p>Alberico L. Catapano (University of Milan, Italy)</p>
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
											<p class="s_bold">Benefit & harm of COVID-19 vaccines in ASCVD <img class="recording_icon" src="./img/icons/icon_recording.svg" alt=""></p>
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
											<p class="s_bold">Fenofibrate lowers cardiac lipid accumulation & attenuates diabetic cardiomyopathy in db/db mice</p>
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
