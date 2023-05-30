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
					<h2>Program at glance</h2>
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
	<section class="container program_glance sub_page">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Program at a glance</h2>
					<ul>
						<li>Home</li>
						<li>Program</li>
						<li>Program at a glance</li>
					</ul>
					<!--
				<button onclick="javascript:window.location.href='./download/2022_program_glance2.pdf'" class="btn" target="_blank">Program at a Glance Download</button>-->
					<a href="./download/ICoLA2022_Program at a Glance.pdf" target="_blank" class="btn" download>Program at a
						Glance Download</a>
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
			<div class="tab_wrap">
				<div class="tab_cont on">
					<table class="table program_glance_table" name="1">
						<colgroup>
							<col class="grogram_time">
							<col />
							<col />
							<col />
							<col />
							<col width="150px" />
						</colgroup>
						<thead>
							<tr>
								<th>Floor</th>
								<th colspan="3">3F</th>
								<th>5F</th>
								<th>6F</th>
							</tr>
							<tr>
								<th>Room</th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
								<th>Poster Hall</th>
							</tr>
						</thead>
						<tbody name="day" class="day_1">
							<!-- <tr> -->
							<!-- 	<td class="pointer">10:00~12:00</td> -->
							<!-- 	<td class="pointer"></td> -->
							<!-- 	<td class="pointer"></td> -->
							<!-- 	<td class="pointer"></td> -->
							<!-- 	<td class="pointer"></td> -->
							<!-- </tr> -->
							<tr>
								<td class="">11:00~</td>
								<td colspan="5">Registration</td>
							</tr>
							<tr>
								<td class="">12:00~12:50</td>
								<td class="pink_bg pointer" name="luncheon_symposium_1">
									Luncheon Symposium 1<br />[Daewoong]
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="luncheon_symposium_2">
									Luncheon Symposium 2<br />[Chong Kun Dang]
									<input type="hidden" name="e" value="room2">
								</td>
								<td class=""></td>
								<td class=""></td>
								<td rowspan="5">Poster Viewing</td>
							</tr>
							<tr>
								<td class="">12:50~14:20</td>
								<td class="pink_bg pointer" name="optimal_risk_factor_control_in_patients_with_dm">
									Symposium 1
									<p>Optimal risk factor control in<br />patients with DM</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="lipid_metabolism_metabolic_disorders">
									Basic Research Workshop 1
									<p>Lipid metabolism & metabolic<br />disorders</p>
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="symposium_2">
									Symposium 2
									<p>Novel risk factors &<br />intervention targets in<br />atherosclerosis</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="symposium_3">
									Symposium 3
									<p>NAFLD, metabolic dysfunction<br />&amp; ASCVD</p>
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<tr>
								<td class="">14:20~14:30</td>
								<td colspan="4">Coffee Break</td>
							</tr>
							<tr>
								<td class="">14:30~15:30</td>
								<!-- <td class="pink_bg">Oral Presentation 1</td> -->
								<td class="pointer"></td>
								<td class="green_bg pointer" name="oral_presentation_1">
									Oral Presentation 1<br>(APSAVD Young Investigator Session)
									<input type="hidden" name="e" value="room2">
								</td>
								<td class=""></td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="">15:30~17:00</td>
								<td class="pink_bg pointer" name="symposium_4">
									Symposium 4
									<p>Update on coronary CT:<br>risk marker, monitoring tool <br> & future perspective</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="pink_bg pointer" name="basic_research_workshop_2">
									Basic Research Workshop 2
									<p>SMC plasticity in plaque stability</p>
									<input type="hidden" name="e" value="room2">
								</td>
								<td class=""></td>
								<td class="green_bg pointer" name="symposium_5">
									Symposium 5
									<p>Lipid as risk & target in<br />cerebrovascular disease</p>
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<!--
						<tr>
							<td class="pointer">17:10~</td>
							<td colspan="4">Welcome Reception</td>
						</tr>
						-->
						</tbody>
					</table>
				</div>
				<div class="tab_cont">
					<table class="table program_glance_table" name="2">
						<colgroup>
							<col class="grogram_time">
							<col />
							<col />
							<col />
							<col />
							<col width="150px" />
						</colgroup>
						<thead>
							<tr>
								<th>Floor</th>
								<th colspan="3">3F</th>
								<th>5F</th>
								<th>6F</th>
							</tr>
							<tr>
								<th>Room</th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
								<th>Poster Hall</th>
							</tr>
						</thead>
						<tbody name="day" class="day_2">
							<tr>
								<td class="">07:00~07:30</td>
								<td colspan="5">Registration</td>
							</tr>
							<tr>
								<td class="">08:00~09:00</td>
								<td class="pink_bg pointer" name="breakfast_symposium_1">
									Breakfast Symposium 1<br />[Celltrionpharm]
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="breakfast_symposium_2">
									Breakfast Symposium 2<br />[Organon]
									<input type="hidden" name="e" value="room2">
								</td>
								<td class=""></td>
								<td class=""></td>
								<td rowspan="12">Poster Viewing</td>
							</tr>
							<tr>
								<td class="">09:00~09:40</td>
								<td class="green_bg pointer" colspan="3" name="plenary_lecture_1">
									Plenary Lecture 1
									<p>From reading the genome for risk to rewriting it for cardiovascular health</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="">09:40~09:45</td>
								<td colspan="4">Break</td>
							</tr>
							<tr>
								<td class="">09:45~11:15</td>
								<td class="pink_bg pointer" name="symposium_6">
									Symposium 6
									<p>Adipose tissue & atherosclerosis</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="symposium_7">
									Symposium 7
									<p>New regulators of dyslipidemia &amp;<br />atherosclerosis</p>
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="symposium_8">
									Symposium 8
									<p>High CV risk group: is it<br />properly defined?</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="symposium_9">
									Symposium 9
									<p>Update on non-<br />pharmacological control of<br />ASCVD risk</p>
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<tr>
								<td class="">11:15~11:25</td>
								<td colspan="4">Coffee Break</td>
							</tr>
							<tr>
								<td class="">11:25~11:30</td>
								<td colspan="4">Opening Address</td>
							</tr>
							<tr>
								<td class="">11:30~12:00</td>
								<td class="green_bg pointer" colspan="3" name="plenary_lecture_2">
									Plenary Lecture 2 (APSAVD:Ding Lecture)
									<p>Recent developments in the treatment of familial hypercholesterolaemia <br>& other
										familial lipid disorders</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="pointer">12:00~12:50</td>
								<td class="pink_bg pointer" name="luncheon_symposium_3">
									Luncheon Symposium 3<br />[Organon]
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="luncheon_symposium_4">
									Luncheon Symposium 4<br />[JW Pharmaceutical]
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="luncheon_symposium_5">
									Luncheon Symposium 5<br />[Viatris]
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="luncheon_symposium_6">
									Luncheon Symposium 6<br />[Boehringer Ingelheim/Lilly]
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<tr>
								<td class="">12:50~12:55</td>
								<td colspan="4">Break</td>
							</tr>
							<tr>
								<td class="">12:55~13:35</td>
								<td class="green_bg pointer" colspan="3" name="plenary_lecture_3">
									Plenary Lecture 3
									<p>Senescence & vascular smooth muscle cell plasticity</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="">13:35~15:05</td>
								<td class="pink_bg pointer" name="symposium_10">
									Symposium 10
									<p>Debate on developing risk<br />grouping in Korea: current<br />status, comparison
										with foreign,<br />&amp; solution</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="pink_bg pointer" name="food_nutrition_workshop">
									Food & Nutrition Workshop
									<p>Cardiometabolic disease &amp;<br />customized nutrition management</p>
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="symposium_11">
									Symposium 11
									<p>Inflammation in progression &amp;<br />inhibition of atherosclerosis</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="symposium_12">
									Symposium 12<br />(EAS/APSAVD/JAS<br />Joint Symposium)
									<p>Dyslipidaemia</p>
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<tr>
								<td class="">15:05~15:15</td>
								<td colspan="4">Coffee Break</td>
							</tr>
							<tr>
								<td class="">15:15~16:15</td>
								<td class="pink_bg pointer" name="oral_presentation_2">
									Oral Presentation 2
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="oral_presentation_3">
									Oral Presentation 3
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="2022_KSoLA_Awards_for_Scientific_Excellence_Young_Investigator">
									2022 KSoLA Awards for Scientific Excellence & Young Investigator
									<p>Scientific Excellence Award Lecture</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class=""></td>
								<td class="gray_bg">Moderated<br />Poster 1,2,5<br />(Kor / Eng)</td>
							</tr>
							<tr>
								<td class="">16:15~17:45</td>
								<td class="pink_bg pointer" name="symposium_13">
									Symposium 13
									<p>Debate on new Korean guidelines on dyslipidemia: treatment</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="pink_bg pointer" name="publication_committee_session">
									Publication Committee Session
									<input type="hidden" name="e" value="room2">
								</td><!-- class="orange_bg"-->
								<td class="green_bg pointer" name="symposium_14">
									Symposium 14<br />(JAS/KSoLA Joint Symposium)
									<p>Impact of aging of vascular cells on atherosclerosis & its protection</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="symposium_15">
									Symposium 15<br />(APSAVD Joint Symposium)
									<p>COVID-19 & cardiovascular risk</p>
									<input type="hidden" name="e" value="room4">
								</td>
								<td>Poster Viewing</td>
							</tr>
							<!-- <tr> -->
							<!-- 	<td class="pointer">17:55~</td> -->
							<!-- 	<td colspan="4">Congress Dinner</td> -->
							<!-- </tr> -->
						</tbody>
					</table>
				</div>
				<div class="tab_cont">
					<table class="table program_glance_table" name="3">
						<colgroup>
							<col class="grogram_time">
							<col />
							<col />
							<col />
							<col />
							<col width="150px" />
						</colgroup>
						<thead>
							<tr>
								<th>Floor</th>
								<th colspan="3">3F</th>
								<th>5F</th>
								<th>6F</th>
							</tr>
							<tr>
								<th>Room</th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
								<th>Poster Hall</th>
							</tr>
						</thead>
						<tbody name="day" class="day_3">
							<tr>
								<td class="">07:00~07:30</td>
								<td colspan="5">Registration</td>
							</tr>
							<tr>
								<td class="">08:00~09:00</td>
								<td class="pink_bg pointer" name="breakfast_symposium_3">
									Breakfast Symposium 3<br />[Yuhan]
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="breakfast_symposium_4">
									Breakfast Symposium 4<br />[JW Pharmaceutical]
									<input type="hidden" name="e" value="room2">
								</td>
								<td class=""></td>
								<td class=""></td>
								<td rowspan="10">Poster Viewing</td>
							</tr>
							<tr>
								<td class="">09:00~09:40</td>
								<td class="green_bg pointer" colspan="3" name="plenary_lecture_4">
									Plenary Lecture 4
									<p>Effect of alirocumab in subjects with likely familial hypercholesterolemia or type
										III hyperlipidemia: analyses from the ODYSSEY outcomes study</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="">09:40~09:45</td>
								<td colspan="4">Break</td>
							</tr>
							<tr>
								<td class="pointer">09:45~11:15</td>
								<td class="pink_bg pointer" name="symposium_16">
									Symposium 16
									<p>Current issues in severe<br />dyslipidemia</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="symposium_17">
									Symposium 17
									<p>Emerging targets &amp; drug<br />platforms in dyslipidemia &<br />atherosclerosis</p>
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="symposium_18">
									Symposium 18
									<p>Role &amp; unsolved issues of novel<br />lipid-modifying agents</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="symposium_19">
									Symposium 19
									<p>Current nutritional knowledge<br />in cardiometabolic health</p>
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<tr>
								<td class="">11:15~11:25</td>
								<td colspan="4">Coffee Break</td>
							</tr>
							<tr>
								<td class="">11:25~12:05</td>
								<td colspan="3" class="green_bg pointer" name="plenary_lecture_5">
									Plenary Lecture 5
									<p>Best approach to cardio & cerebrovascular health in older people</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="">12:05~12:55</td>
								<td class="pink_bg pointer" name="luncheon_symposium_7">
									Luncheon Symposium 7<br />[Inno.N]
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="pink_bg pointer" name="luncheon_symposium_8">
									Luncheon Symposium 8<br />[Hanmi]
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="luncheon_symposium_9">
									Luncheon Symposium 9<br />[Amgen]
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="luncheon_symposium_10">
									Luncheon Symposium 10<br />[Sanofi]
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<tr>
								<td class="">12:55~13:00</td>
								<td colspan="4">Break</td>
							</tr>
							<tr>
								<td class="">13:00~13:30</td>
								<td class="green_bg pointer" colspan="3" name="plenary_lecture_6">
									Plenary Lecture 6 (APSAVD:Yamamoto Lecture)
									<p>Up close & personal with vascular diseases: the role of precision medicine</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class=""></td>
							</tr>
							<tr>
								<td class="">13:30~13:35</td>
								<td colspan="4">Break</td>
							</tr>
							<tr>
								<td class="">13:35~14:35</td>
								<td class="pink_bg pointer" name="oral_presentation_5">
									Oral Presentation 4
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="green_bg pointer" name="oral_presentation_6">
									Oral Presentation 5
									<input type="hidden" name="e" value="room2">
								</td>
								<td class=""></td>
								<td class=""></td>
								<td class="gray_bg">Moderated<br />Poster 3,4<br />(Kor / Eng)</td>
							</tr>
							<tr>
								<td class="">14:35~14:45</td>
								<td colspan="4">Coffee Break</td>
								<td rowspan="2">Poster viewing</td>
							</tr>
							<tr>
								<td class="">14:45~16:15</td>
								<td class="pink_bg pointer" name="symposium_20">
									Symposium 20
									<p>How will new technologies<br />change our research &amp; patient<br />care in ASCVD?
									</p>
									<input type="hidden" name="e" value="room1">
								</td>
								<td class="pink_bg pointer" name="symposium_21">
									Symposium 21
									<p>New concepts in vascular biology</p>
									<input type="hidden" name="e" value="room2">
								</td>
								<td class="green_bg pointer" name="symposium_22">
									Symposium 22<br />(TSLA/KSoLA Joint Symposium)
									<p>Sex difference in dyslipidemia & atherosclerosis</p>
									<input type="hidden" name="e" value="room3">
								</td>
								<td class="green_bg pointer" name="symposium_23">
									Symposium 23<br />(APSAVD Joint Symposium)
									<p>Update on antibodies & siRNA against PCSK9</p>
									<input type="hidden" name="e" value="room4">
								</td>
							</tr>
							<!--
						<tr>
							<td class="pointer">16:15~16:20</td>
							<td colspan="4">Break</td>
						</tr>
						<tr>
							<td class="pointer">16:20~</td>
							<td colspan="4">Closing Remark</td>
						</tr>
						-->
							<tr>
								<td class="">16:15~</td>
								<td colspan="4">
									Closing Ceremony
									<input type="hidden" name="e" value="room1">
								</td>
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
<script>
	$(document).ready(function() {
		$('.program_table').each(function() {
			var parents_div = $(this).parents('.program_table_wrap');
			$(this).clone(true).appendTo(parents_div).addClass('clone');
		});
		var i = 1;
		$('.program_table td').each(function() {
			if (!$(this).is(':empty')) {
				var td = $(this).attr('colspan');
				if (!$(this).hasClass("dark_bg") && !(td == 5)) {
					var tabId = $(this).closest('.program_table_wrap').attr('id');
					var lectureId = "lId_" + i;
					var lectureSrc = "./program_detail.php#" + tabId + "&#" + lectureId;
					$(this).attr('id', lectureId);
					$(this).wrapInner('<a target="_blank" href="' + lectureSrc + '"></a>');
					//               $('<a target="_blank" href="'+lectureSrc+'"></a>').prependTo($(this));
					i = i + 1;
				}
			}
		});
	});
</script>

<script>
	$(document).ready(function() {
		$("td.pointer").click(function() {
			var e = $(this).find("input[name=e]").val();
			var day = $(this).parents("tbody[name=day]").attr("class");
			var target = $(this)
			var this_name = $(this).attr("name");
			var table_num = $(this).parents("table").attr("name")

			table_location(event, target, e, day, this_name, table_num);
		});
	});

	function table_location(event, _this, e, day, this_name, table_num) {
		window.location.href = "./scientific_program" + table_num + ".php?&e=" + e + "&name=" + this_name;

	}
</script>

<?php include_once('./include/footer.php'); ?>