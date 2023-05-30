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
					<h2>Presentation Guidelines</h2>
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
	$sql_info =	"SELECT
					welcome_msg_" . $language . " AS welcome_msg,
					important_dates_" . $language . " AS important_dates,
					how_to_apply_" . $language . " AS how_to_apply,
					procedure_" . $language . " AS `procedure`,
					contact_info_" . $language . " AS contact_info,
					isp.contact_for_sponsorship, 
					CONCAT(fi_sod.path, '/', fi_sod.save_name) AS fi_sod_url,
					CONCAT(fi_bl.path, '/', fi_bl.save_name) AS fi_bl_url,
					CONCAT(fi_cob.path, '/', fi_cob.save_name) AS fi_cob_url
				FROM info_sponsorship AS isp
				LEFT JOIN `file` AS fi_sod
					ON fi_sod.idx = isp.sponsorship_official_docs
				LEFT JOIN `file` AS fi_bl
					ON fi_bl.idx = isp.business_license
				LEFT JOIN `file` AS fi_cob
					ON fi_cob.idx = isp.copy_of_bankbook";
	$info = sql_fetch($sql_info);
?>
	<section class="container presentation_guidelines sub_page">
		<div class="sub_background_box">
			<div class="sub_inner">
				<div>
					<h2>Presentation Guidelines</h2>
					<ul>
						<li>Home</li>
						<li>Call for Abstracts</li>
						<li>Abstract Submission</li>
						<li>Presentation Guidelines</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="inner">
			<div class="clearfix2 presentation_title">
				<span>Types of Presentations</span>
				<div>
					<button type="button" class="btn green_btn" onClick="javascript:window.open('./download/ICoLA2022_main_Oral_0907.pdf')">Oral</button>
					<button type="button" class="btn green_btn" onClick="javascript:window.open('./download/ICoLA2022_main_Moderated_0907.pdf')">MP</button>
					<button type="button" class="btn green_btn" onClick="javascript:window.open('./download/ICoLA2022_main_poster_exhibition_0908.pdf')">Poster</button>
				</div>
			</div>
			<ul class="tab_pager tab_pager_small">
				<li class="on"><a href="javascript:;">Oral Presentation</a></li>
				<li><a href="javascript:;">Moderated Poster<br />Presentation</a></li>
				<li><a href="javascript:;">Poster Exhibition</a></li>
			</ul>
			<div class="tab_wrap">
				<div class="tab_cont on">
					<div>
						<div class="circle_title">Presentation Length</div>
						Each presenter will be given 10 minutes.<br />When the 7-minute presentation ends, a Question and
						Answer session for participants with the panel and the presenter will follow for 3 minutes.<br />
						<span class="red_txt">※ Each individual presenter should take no more than 10 minutes to present.
							The slide show will end after passing the designated time.</span>
					</div>
					<div>
						<div class="circle_title">Language</div>
						The presentation should be in English, which is the official language of the ISCP 2023 with APASVD.
					</div>
					<div>
						<div class="circle_title">Preview Room</div>
						All speakers must visit the Preview Room to check and upload their presentation files ahead of their
						session.
						<div class="text_box centerT">
							<p><span class="bold">Place:</span> Park studio 5F, Conrad Seoul Hotel</p>
							<p class="bold">Operation Date & Time</p>
							<p>September 15th (Thursday) : 11:30 ~ 17:00</p>
							<p>September 16th (Friday) - September 17th (Saturday) : 07:30 ~ 18:00</p>
						</div>
					</div>
					<div>
						<div class="circle_title">Presentation File</div>
						<ul>
							<li>Authors should bring the presentation file in a USB memory stick to the preview room to
								upload onto the common storage device.</li>
							<li>Lectures should prepare the presentation file in MS PowerPoint in English. And please use
								only basic fonts for your presentation (e.g. Arial, Times New Roman), as usage of unusual
								fonts may not be displayed properly. If you must have special fonts on your slide files,
								please bring the font file as well. </li>
							<li>Technical staff will be available to assist you in uploading and testing your presentation
								file. No one other than the presenters will have access to the presentation file once it is
								loaded into the preview system.</li>
							<li>If you do not visit the preview room before your presentation for any urgent reason, you
								will be responsible for loading your file onto the PC in the session room directly.</li>
							<!-- <li>You will be able to find the room sign(s) on-site.</li> -->
						</ul>
					</div>
					<div>
						<div class="circle_title">Audio/Visual Guidelines</div>
						Each session room will be equipped with an LCD projector, and a computer running Windows 10 and
						PowerPoint 2016 for your presentation. We recommend you to prepare the presentation slide with 16:9
						aspect of ratio. If you must inevitably use your own laptop, you should bring it to the session room
						at least 60 minutes before the session begins and notify the secretariat by August 31, 2022<br />
						<span class="red_txt">* If you have any questions about your session or speakers, please ask the
							room assistant or visit the Preview Room.</span>
					</div>
				</div>
				<div class="tab_cont">
					<div>
						<div class="circle_title">Poster Presentation</div>
						Each presenter will be given 8 minutes. Presenters will share their perspectives and recent
						advancements with the displayed posters for 5 minutes. When the presentation ends, a Q&A session for
						participants with panels and presenters will follow for 3 minutes. The presentation will be reviewed
						by a chairperson and 2 panels.
					</div>
					<div>
						<div class="circle_title">Language</div>
						The presentation should be in English, which is the official language of the ISCP 2023 with APSAVD.
					</div>
					<div>
						<div class="circle_title">Poster Panel</div>
						<div class="clearfix">
							<ul>
								<li><span class="bold">Poster Panel Size :</span> W250 x H100 cm</li>
								<li><span class="bold">Paper Size :</span> A0 (W84.1 x H118.9 cm)</li>
								<!-- <li>Poster Panels are 250cm height, 100cm width.</li> -->
								<!-- <li>Paper Size should be A0 (W 84.1 cm x H 118.9 cm).</li> -->
							</ul>
							<div><img src="./img/a0.png" alt=""></div>
						</div>
					</div>
					<div>
						<div class="circle_title">Schedule for Moderated Poster Presentation</div>
						<div class="details table_wrap">
							<table class="table wide_table">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th>Date</th>
										<td>September 16th (Friday) - September 17th (Saturday)</td>
									</tr>
									<tr>
										<th>Place</th>
										<td>Poster Hall 6F, Conrad Hotel Seoul</td>
									</tr>
									<tr>
										<th>Date & Time</th>
										<td>September 16th (Friday) - 15:15 ~ 16:15<br />September 17th (Saturday) - 13:35 ~
											14:35</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div>
						<div class="circle_title">Schedule for Affixation & Removal</div>
						<div class="details table_wrap">
							<table class="table wide_table">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th>Date</th>
										<td>September 15th (Thursday) - September 17th (Saturday)</td>
									</tr>
									<tr>
										<th>Place</th>
										<td>Poster Hall 6F, Conrad Hotel Seoul</td>
									</tr>
									<tr>
										<th>Affixation</th>
										<td>September 15th (Thursday) - 10:00 ~
											<!--<br/>September 16th (Friday) - 08:00 ~ 10:00-->
										</td>
									</tr>
									<tr>
										<th>Removal</th>
										<td>September 17th (Saturday) - 17:00 ~ 18:00</td>
									</tr>
								</tbody>
							</table>
							<ul>
								<li>All presenters are requested to affix and remove posters on the appropriate dates and
									time as indicated.</li>
								<li>Each poster will be provided with 1 panel.</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab_cont">
					<div>
						<div class="circle_title">Poster Panel</div>
						<div class="clearfix">
							<ul>
								<li><span class="bold">Poster Panel Size :</span> W250 x H100 cm</li>
								<li><span class="bold">Paper Size :</span> A0 (W84.1 x H118.9 cm)</li>
							</ul>
							<div><img src="./img/a0.png" alt=""></div>
						</div>
					</div>
					<div>
						<div class="circle_title">Schedule for Affixation & Removal</div>
						<div class="details table_wrap">
							<table class="table wide_table">
								<colgroup>
									<col class="col_th">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th>Date</th>
										<td>September 15th (Thursday) - September 17th (Saturday)</td>
									</tr>
									<tr>
										<th>Place</th>
										<td>Poster Hall 6F, Conrad Hotel Seoul</td>
									</tr>
									<tr>
										<th>Affixation</th>
										<td>September 15th (Thursday) - 10:00 ~
											<!--<br/>September 16th (Friday) - 08:00 ~ 10:00-->
										</td>
									</tr>
									<tr>
										<th>Removal</th>
										<td>September 17th (Saturday) - 17:00 ~ 18:00</td>
									</tr>
								</tbody>
							</table>
							<ul>
								<li>All presenters are requested to affix and remove posters on the appropriate dates and
									time as indicated.</li>
								<li>Each poster will be provided with 1 panel.</li>
							</ul>
						</div>
					</div>
					<div>
						<div class="circle_title">Regulations</div>
						<ul>
							<li>Posters should be readable by viewers from 1.5 meters away. The poster title, author(s)'s
								name(s) and affiliation(s) should appear on the top. The message should be clear and
								understandable without oral explanation.</li>
							<li>Posters should be able to show the main content or the main results of the research.</li>
							<li>3M Double-sided tapes and adhesive tapes will be available to attach your poster to the
								panel. (The tapes will be provided on the site.)</li>
							<li>All presenters should remove posters at the removal time. Otherwise, the remaining posters
								will be removed by staff without notice and the organizing committee will not take
								responsibilities for any damages or losses of the posters.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- <button type="button" class="fixed_btn" onclick="javascript:window.location.href='./application.php';"><?= $locale("apply_btn") ?></button> -->
	</section>
<?php
}
?>

<?php include_once('./include/footer.php'); ?>