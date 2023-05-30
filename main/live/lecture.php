<?php
	include_once ("./include/header.php");

	// Rooms
	$sql_place =	"SELECT
						*
					FROM (
						SELECT
							lp.idx AS place_idx,
							lp.title_en AS place_title_en,
							IFNULL(cur_lc.idx, 0) AS lecture_idx,
							IFNULL(cur_lc.agenda_title_en, '') AS lecture_title_en,
							IFNULL(cur_lc.theme_en, '') AS lecture_theme_en,
							lsj.name_en_text AS lecture_chairperson_name_en,
							cur_lc.period_time_start, cur_lc.period_time_end, 
							IFNULL(
								CONCAT(
									DATE_FORMAT(cur_lc.period_time_start, '%H:%i'), 
									' ~ ', 
									DATE_FORMAT(cur_lc.period_time_end, '%H:%i')
								), '24:00 ~ 24:00'
							) AS period_time_text,
							IFNULL(cur_lc.panel_name_en, '') AS lecture_panel_name_en,
							IFNULL(cur_lc.panel_affiliation_en, '') AS lecture_panel_affiliation_en,
							IFNULL(cur_lc.speaker_period_en, '') AS lecture_speaker_period_en,
							IFNULL(cur_lc.speaker_subject_en, '') AS lecture_speaker_subject_en,
							IFNULL(cur_lc.speaker_name_en, '') AS lecture_speaker_name_en,
							IFNULL(cur_lc.speaker_affiliation_en, '') AS lecture_speaker_affiliation_en
						FROM lecture_place AS lp
						LEFT JOIN (
							SELECT
								pu.place_idx,
								lc.*
							FROM lecture_place_use AS pu
							INNER JOIN (
								SELECT
									*
								FROM lecture
								WHERE is_deleted = 'N'
							) AS lc
								ON lc.idx = pu.lecture_idx
							WHERE (pu.place_idx, lc.period_time_start) IN (
								SELECT
									pu.place_idx,
									MIN(lc.period_time_start)
								FROM lecture_place_use AS pu
								INNER JOIN (
									SELECT
										idx, period_time_start
									FROM lecture
									WHERE is_deleted = 'N'
									AND (
										NOW() <= period_time_start
										OR (
											NOW() BETWEEN period_time_start AND period_time_end
										)
									)
									AND DATE(NOW()) = DATE(period_time_start)
								) AS lc
									ON lc.idx = pu.lecture_idx
								GROUP BY pu.place_idx
							)
						) AS cur_lc
							ON cur_lc.place_idx = lp.idx
						LEFT JOIN (
							SELECT
								lsj.lecture_idx,
								GROUP_CONCAT(CONCAT(ls.name_en, ' (', ls.affiliation_en, ')') ORDER BY lsj.idx) AS name_en_text
							FROM lecture_speaker_join AS lsj
							INNER JOIN lecture_speaker AS ls
								ON ls.idx = lsj.speaker_idx
							GROUP BY lsj.lecture_idx
						) AS lsj
							ON lsj.lecture_idx = cur_lc.idx
						WHERE lp.is_deleted = 'N'
					) AS res
					ORDER BY res.place_title_en, res.period_time_text";
	$places = get_data($sql_place);
	$places_count = count($places);
?>
		<p class="mb_pg_title">Lecture</p>
		<section class="container auto">
			<h2 class="title">
				<img src="./images/icon/icon_lectuer.png" alt=""> Lecture 
			</h2>
			<ul class="card_list clearfix">
				<?php
					if ($places_count <= 0) {
				?>
				<li class="no_data">No data available</li>
				<?php
					} else {
						$color_arr = ['lime', 'light_blue', 'blue', 'purple', 'light_purple'];
						for($i=0;$i<$places_count;$i++){
							$pl = $places[$i];
							foreach($pl as $key=>$value){
								$pl[$key] = htmlspecialchars_decode($value);
							}
				?>
				<li class="<?=$color_arr[((5 + $i)%5)]?> show_detail" data-index="<?=$i?>">
					<p><?=$pl['place_title_en']?></p>
					<div>
						<?php
							if ($pl['lecture_idx'] == 0) {
						?>
						<div class="no_data centerT">There are currently no courses in progress.</div>
						<?php
							} else {
						?>
						<div>
							<p class="color_change tit_height"><?=$pl['lecture_title_en']?></p>
							<p><span>KST (Korea Standard Time)</span><?=$pl['period_time_text']?></p>
						</div>
						<div class="dashed"></div>
						<div>
							<p class="color_change height"><?=$pl['lecture_theme_en']?></p>
							<button type="button" class="btn move_open" data-start="<?=date_format(date_create($pl['period_time_start']), "Y/m/d H:i:s")?>" data-end="<?=date_format(date_create($pl['period_time_end']), "Y/m/d H:i:s")?>">Entrance<img class="arrow_img" src="./images/icon/icon_arrow_r.png" alt=""></button>
						</div>
						<?php
							}
						?>
					</div>
				</li>
				<?php
						}
					}
				?>
			</ul>
			<?php
				if ($places_count > 0) {
			?>
			<div class="lecture_information">
				<div>
					<h2>When you move mouse over each classroom area,<br>you can find out more details about the ongoing lectures.</h2>
					<!-- <p>blah blah blah~~~ blah blah blah blah~~~<br/>blah blah blah~~~ blah blah blah blah~~~</p> -->
				</div>
				<div class="lecture_info_white">
					<div class="top clearfix">
						Lecture Information
						<ul class="lecture_box floatR pc_only">
							<li name="title">
								<span>Agenda Title</span>Keynote Lecture 1
							</li>
							<li name="place">
								<span>Place</span>Room 1
							</li>
							<li name="time">
								<span>Time</span>09:00~10:30
							</li>
						</ul>
					</div>
					<div class="bottom scroll_plugin">
						<ul class="mb_lecture_box mb_only">
							<li name="title">
								<span>Agenda Title</span>Keynote Lecture 1
							</li>
							<li name="place">
								<span>Place</span>Room 1
							</li>
							<li name="time">
								<span>Time</span>09:00~10:30
							</li>
						</ul>
						<ul>
							<li>
								<span class="letter_spacing">THEME</span>
								<span name="theme">Efficacy and Safety of  Semaglutide in Japanese and Korean: STEP6 Study</span>
							</li>
							<li>
								<span>CHAIRPERSON</span>
								<span name="chairperson">Takashi Kadowaki (Toranomon Hospital, Japan)</span>
							</li>
							<li>
								<span class="letter_spacing">PANEL</span>
								<span name="panel">Takashi Kadowaki (Toranomon Hospital, Japan)</span>
							</li>
						</ul>
						<ul name="speaker">
							<li>
								<span>09:00 ~ 09:30 </span>
								<span>lecture01. Kartell of Death: Visceral Obesity and Cardiovascular Disease</span>
								<span>Jean-Pierre Despres <span class="thin">(Laval University, Canada)</span></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
				}
			?>
		</section>
		<style>
			section {overflow-x:hidden;}
		</style>
		<?php include_once("./include/popup.php") ?>
	</body>
	<script src="./js/enter_video.js?v=<?=time()?>"></script>
	<script>
		var places = JSON.parse('<?=addslashes(json_encode($places))?>');	// lecture 정보
		var index = 0;	// entrance place idx(전역)

		// 상세 진입 변수값이 다르게 들어가는 부분
		function get_detail_lecture_idx(){
			return places[index].lecture_idx;
		}
		function get_detail_place_idx(){
			return places[index].place_idx;
		}

		// lecture 정보 업데이트
		$(".lecture_info_white").hide();
		$(".card_list li").mouseover(function(){
			var place_info = places[$(this).data('index')];
			if (place_info.lecture_idx > 0) {
				$('.lecture_info_white [name=title]').html('<span>Agenda Title</span>' + place_info.lecture_title_en.replace(/\\/gi, ''));
				$('.lecture_info_white [name=place]').html('<span>Place</span>' + place_info.place_title_en.replace(/\\/gi, ''));
				$('.lecture_info_white [name=time]').html('<span>Time</span>' + place_info.period_time_text);

				$('.lecture_info_white [name=theme]').html(place_info.lecture_theme_en.replace(/\\/gi, ''));
				$('.lecture_info_white [name=chairperson]').html(place_info.lecture_chairperson_name_en.replace(/\\/gi, '').replace(/,/gi, ', '));

				var panels = {
					names : place_info.lecture_panel_name_en.split('|'),
					affiliation : place_info.lecture_panel_affiliation_en.split('|'),
					length : 0
				}
				if (panels.names == "") {
					$('.lecture_info_white [name=panel]').parents('li').hide();
				} else {
					panels.length = panels.names.length;
					var inner = '';
					for (var i=0; i<panels.length; i++) {
						if (i > 0) {
							inner += ', ';
						}

						inner += panels.names[i];
						if (panels.affiliation[i] != '') {
							inner += ' (' + panels.affiliation[i] + ')';
						}
					}
					$('.lecture_info_white [name=panel]').html(inner);
					$('.lecture_info_white [name=panel]').parents('li').show();
				}

				var speakers = {
					periods : place_info.lecture_speaker_period_en.split('|'),
					subjects : place_info.lecture_speaker_subject_en.split('|'),
					names : place_info.lecture_speaker_name_en.split('|'),
					affiliation : place_info.lecture_speaker_affiliation_en.split('|'),
					length : 0
				}
				if (speakers.subjects == "") {
					$('.lecture_info_white [name=speaker]').hide();
				} else {
					speakers.length = speakers.subjects.length;
					var inner = '';
					for (var i=0; i<speakers.length; i++) {
						inner +=	'<li>';
						inner +=		'<span>' + speakers.periods[i] + '</span>';
						inner +=		'<span>' + speakers.subjects[i] + '</span>';
						inner +=		'<span>' + speakers.names[i];
						if (speakers.affiliation[i] != '') {
							inner +=		' <span class="thin">(' + speakers.affiliation[i] + ')</span>';
						}
						inner +=		'</span>';
						inner +=	'</li>';
					}
					$('.lecture_info_white [name=speaker]').html(inner).show();
				}

				$(".lecture_info_white").show();
				$(".lecture_information > div:first-child").hide();
				$(".lecture_information .scroll_plugin").mCustomScrollbar('update')
			} else {
				$(".lecture_info_white").hide();
				$(".lecture_information > div:first-child").show();
			}
		});
	</script>
</html>