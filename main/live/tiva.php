<?php
	include_once("./include/header.php");

	// conference_book_en_path 주소
	$sql_info_live =	"SELECT
							CONCAT(fi_cb_en.path, '/', fi_cb_en.save_name) AS conference_book_en_path
						FROM info_live AS il
						LEFT JOIN `file` AS fi_cb_en
							ON fi_cb_en.idx = il.conference_book_en_img";
	$info_live = sql_fetch($sql_info_live);

	// 카테고리 데이터
	$sql_category =	"SELECT
						idx, 
						title_en,
						LOWER(REPLACE(title_en, ' ', '_')) AS class_name,
						(
							CASE idx
								WHEN  1 THEN '#BDFFBA'
								WHEN  2 THEN '#D9ECEE'
								WHEN  3 THEN '#E3FF9D'
								WHEN  4 THEN '#DDDAEE'
								WHEN  5 THEN '#DDDAEE'
								WHEN  6 THEN '#DDDAEE'
								WHEN  7 THEN '#E3FF9D'
								WHEN  8 THEN '#D3DCE4'
								WHEN  9 THEN '#E2ECD8'
								WHEN 10 THEN '#E3FF9D'
								WHEN 11 THEN '#E3FF9D'
								WHEN 12 THEN '#E3FF9D'
								WHEN 14 THEN '#D9ECEE'
								WHEN 15 THEN '#F4F4F4'
								WHEN 16 THEN '#D9ECEE'
								ELSE '#FFFFFF'
							END
						) AS color_hex
					FROM lecture_category
					WHERE is_deleted = 'N'";
	$categories = get_data($sql_category);

	$categories_style_text = "";
	foreach($categories as $ct){
		$categories_style_text .= " .fc-v-event.".$ct['class_name']."{ background-color: ".$ct['color_hex']."}";
	}

	// 전체 스케줄
	$sql_schedule =	"SELECT
						lc_pl.idx AS placeIdx,
						LOWER(lc_pl.title_en) AS resourceId,
						lc_pl_u_group.concat_name AS placeName,
						lc.idx AS lectureIdx,
						DATE_FORMAT(lc.period_time_start, '%Y-%m-%dT%H:%i') AS startDate,
						DATE_FORMAT(lc.period_time_end, '%Y-%m-%dT%H:%i') AS endDate,
						CONCAT(TIME(lc.period_time_start), '-', TIME(lc.period_time_end)) AS timeText,
						lc.agenda_title_en AS title,
						LOWER(REPLACE(lc_ct.title_en, ' ', '_')) AS className,
						lc.theme_en AS sessionTheme,
						IFNULL(lc_sp.name_en, '') AS chairpersonName,
						IFNULL(lc_sp.affiliation_en, '') AS chairpersonAffiliation,
						lc.panel_name_en AS panelName,
						lc.panel_affiliation_en AS panelAffiliation,
						lc.speaker_period_en AS speakerTime,
						lc.speaker_subject_en AS speakerTitle,
						lc.speaker_name_en AS speakerName,
						lc.speaker_affiliation_en AS speakerAffiliation,
						lc_pl_u_group.cnt AS roomCount
					FROM lecture_place_use AS lc_pl_u
					INNER JOIN lecture_place AS lc_pl
						ON lc_pl.idx = lc_pl_u.place_idx
					INNER JOIN (
						SELECT
							*
						FROM lecture
						WHERE is_deleted = 'N'
					) AS lc
						ON lc.idx = lc_pl_u.lecture_idx
					LEFT JOIN (
						SELECT
							p_u.lecture_idx, 
							MIN(p_u.place_idx) AS main_room_idx, 
							COUNT(p_u.idx) AS cnt,
							GROUP_CONCAT(p.title_en ORDER BY p.title_en) AS concat_name
						FROM lecture_place_use AS p_u
						INNER JOIN lecture_place AS p
							ON p.idx = p_u.place_idx
						GROUP BY p_u.lecture_idx
					) AS lc_pl_u_group
						ON lc_pl_u_group.lecture_idx = lc.idx
					LEFT JOIN lecture_category AS lc_ct
						ON lc_ct.idx = lc.category_idx
					LEFT JOIN (
						SELECT
							lecture_idx,
							GROUP_CONCAT(ls.name_en ORDER BY lsj.idx SEPARATOR '|') AS name_en,
							GROUP_CONCAT(ls.affiliation_en ORDER BY lsj.idx SEPARATOR '|') AS affiliation_en
						FROM lecture_speaker_join AS lsj
						INNER JOIN (
							SELECT
								idx, name_en, affiliation_en
							FROM lecture_speaker
							WHERE is_deleted = 'N'
						) AS ls
							ON ls.idx = lsj.speaker_idx
						GROUP BY lecture_idx
					) AS lc_sp
						ON lc_sp.lecture_idx = lc_pl_u.lecture_idx
					WHERE lc.period_time_start >= '".$_PERIOD[0]." 00:00:00'
					AND lc.period_time_end <= '".end($_PERIOD)." 23:59:59'
					AND lc_pl_u_group.main_room_idx = lc_pl_u.place_idx";
	$schedules = get_data($sql_schedule);
	for($i=0;$i<count($schedules);$i++){
		foreach($schedules[$i] as $key=>$value){
			if ($key == "title") {
				//$schedules[$i]["titleDecode"] = addslashes(htmlspecialchars_decode($value, ENT_QUOTES));
			}
		}
	}
?>
		<style>
			<?=$categories_style_text?>
			html, body {height:100% !important;}
			::-webkit-scrollbar{ display:none; }
			@media screen and (max-width: 450px) {
				::-webkit-scrollbar {
					/*display: none;*/
				}
			}
		</style>
		<p class="mb_pg_title">Program at a Glance</p>
		<section class="container time_page">
			<div>
				<div class="timetable_box clearfix">
					<div class="floatL">
						<a href="<?=$info_live['conference_book_en_path']?>" target="_blank" class="program_detail">Program Detail</a>
						<a href="/main/download/program_glance.pdf" target="_blank" class="program_detail">Program Glance</a>
						<ul class="tab_pager mb_only">
							<?php
								for($i=0;$i<$_PERIOD_COUNT;$i++){
									//$class_on = $i==0 ? "yellow_txt" : "";
									$date = date_create($_PERIOD[$i]);
							?>
							<li><a href="javascript:;" class="pick_date" data-date="<?=date_format($date, "Y-m-d")?>"><?=date_format($date, "M. j(D)")."<br>".date_format($date, "Y")?></a></li>
							<?php
								}
							?>
						</ul>
						<ul class="timetable_list scroll_plugin">
							<li class="on"><a href="javascript:;" class="filter_class" data-class-name="all">All</a></li>
							<?php
								foreach($categories as $ct){
							?>
							<li><a href="javascript:;" class="filter_class not_all" data-class-name="<?=$ct['class_name']?>"><?=$ct['title_en']?></a></li>
							<?php
								}
							?>
						</ul>
					</div>
					<div class="floatR">
						<ul class="tab_pager pc_only">
							<?php
								for($i=0;$i<$_PERIOD_COUNT;$i++){
									//$class_on = $i==0 ? "yellow_txt" : "";
									$date = date_create($_PERIOD[$i]);
							?>
							<!----- 모바일의 경우에 예외처리가 필요합니다(연도 앞에 br 추가하여 줄바꿈이 될 수 있도록) ----->
							<li><a href="javascript:;" class="pick_date" data-date="<?=date_format($date, "Y-m-d")?>"><?=date_format($date, "M. j(D) Y")?></a></li>
							<?php
								}
							?>
						</ul>
						<div class="time_table">
							<div class="table_inner"><div id="calendar"></div></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include_once("./include/popup.php") ?>
		<script src="./js/enter_video.js?v=<?=time()?>"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// object push
				var evts = new Array();
				var schedules = JSON.parse('<?=(json_encode($schedules))?>');
				schedules.forEach(function(el){
					// chair person
					var chairPersonObj = {
						names			: el.chairpersonName.split('|'),
						affiliations	: el.chairpersonAffiliation.split('|'),
						data_length		: 0,
						text			: ""
					};
					chairPersonObj.data_length = chairPersonObj.names.length;
					if (el.chairpersonName != "") {
						for (var i=0; i<chairPersonObj.data_length; i++) {
							chairPersonObj.text += ', ' + chairPersonObj.names[i] + ' <span class="light">(' + chairPersonObj.affiliations[i] + ')</span>';
						}
						chairPersonObj.text = chairPersonObj.text.substr(2);
					}

					// panel
					var panelObj = {
						names			: el.panelName.split('|'),
						affiliations	: el.panelAffiliation.split('|'),
						data_length		: 0,
						text			: ""
					};
					panelObj.data_length = panelObj.names.length;
					if (el.panelName != "") {
						for (var i=0; i<panelObj.data_length; i++) {
							panelObj.text += ', ' + panelObj.names[i] + ' <span class="light">(' + panelObj.affiliations[i] + ')</span>';
						}
						panelObj.text = panelObj.text.substr(2);
					}

					// speaker
					var speakerObj = {
						times			: el.speakerTime.split('|'),
						titles			: el.speakerTitle.split('|'),
						names			: el.speakerName.split('|'),
						affiliations	: el.speakerAffiliation.split('|'),
						data_length		: 0,
						text			: ""
					};
					speakerObj.data_length = speakerObj.titles.length;
					if (speakerObj.titles != "") {
						var reSplitName, reSplitAffiliation;
						for (var i=0; i<speakerObj.data_length; i++) {
							speakerObj.text +=	'<li>';
							if (speakerObj.times[i]) {
								speakerObj.text +=	'<p>' + speakerObj.times[i] + '</p>';
							}
							speakerObj.text +=		'<p>' + speakerObj.titles[i] + '</p>';
							if (speakerObj.names[i]) {
								
								reSplitName			= speakerObj.names[i].split('^&');
								reSplitAffiliation	= speakerObj.affiliations[i].split('^&');

								for (var j=0; j<reSplitName.length; j++) {
									speakerObj.text +=	'<p class="medium">' + reSplitName[j] + ' (' + reSplitAffiliation[j] + ')</p>';
								}
							}
							speakerObj.text +=	'</li>';
						}
					}

					var obj = {
						id				: (evts.length+1),
						resourceId		: el.resourceId,
						lectureIdx		: el.lectureIdx,
						start			: el.startDate,
						end				: el.endDate,
						timeText		: el.timeText,
						title			: el.title.replace(/&quot;/gi, '\"').replace(/&#039;/gi, "\'"),
						className		: (el.className + " time_td" + el.roomCount),
						sessionTheme	: el.sessionTheme,
						placeIdx		: el.placeIdx,
						place			: el.placeName,
						chairPerson		: chairPersonObj.text,
						panel			: panelObj.text,
						speaker			: speakerObj.text
					}

					evts.push(obj);
				});

				// calendar set
				var calendarEl = document.getElementById('calendar');
				var calendar = new FullCalendar.Calendar(calendarEl, {
					timeZone: 'UTC',
					slotMinTime: "07:00",
					slotMaxTime: "21:00",
					slotLabelFormat: {
						hour: '2-digit',
						minute: '2-digit',
						hour12: false
					},
					schedulerLicenseKey: '0774238361-fcs-1629340647',
					initialView: 'resourceTimeGridDay',
					resources: [
						{id: 'room1', title: 'Room 1'},
						{id: 'room2', title: 'Room 2'},
						{id: 'room3', title: 'Room 3'},
						{id: 'room4', title: 'Room 4'},
						{id: 'room5', title: 'Room 5'}
					],
					events: evts,
					eventTimeFormat: {
						hour: '2-digit',
						minute: '2-digit',
						hour12: false
					},
					eventClick: function(info) {
						$(".lecture_pop .lecture_info [name=title]").html(info.event.title);

						if (info.event.extendedProps.sessionTheme == "") {
							$(".lecture_pop .lecture_info [name=session_theme]").parents('li').hide();
						} else {
							$(".lecture_pop .lecture_info [name=session_theme]").parents('li').show();
							$(".lecture_pop .lecture_info [name=session_theme]").html(info.event.extendedProps.sessionTheme);
						}

						$(".lecture_pop .lecture_info [name=time]").html(info.event.extendedProps.timeText);
						$(".lecture_pop .lecture_info [name=place]").html(info.event.extendedProps.place);

						if (info.event.extendedProps.chairPerson == "") {
							$(".lecture_pop .lecture_info [name=chairperson]").parents('li').hide();
						} else {
							$(".lecture_pop .lecture_info [name=chairperson]").parents('li').show();
							$(".lecture_pop .lecture_info [name=chairperson]").html(info.event.extendedProps.chairPerson);
						}

						if (info.event.extendedProps.panel == "") {
							$(".lecture_pop .lecture_info [name=panel]").parents('li').hide();
						} else {
							$(".lecture_pop .lecture_info [name=panel]").parents('li').show();
							$(".lecture_pop .lecture_info [name=panel]").html(info.event.extendedProps.panel);
						}

						if (info.event.extendedProps.speaker == "") {
							$(".lecture_pop .lecture_info [name=speaker]").parents('li').hide();
						} else {
							$(".lecture_pop .lecture_info [name=speaker]").parents('li').show();
							$(".lecture_pop .lecture_info [name=speaker]").html(info.event.extendedProps.speaker);
						}

						var srt = new Date(info.event._instance.range.start);
						srt.setHours(srt.getHours()-9);
						var end = new Date(info.event._instance.range.end);
						end.setHours(end.getHours()-9);
						$(".lecture_pop button.move_open").addClass("move_open").data("start", srt).data("end", end).data("lecture", info.event.extendedProps.lectureIdx).data("place", info.event.extendedProps.placeIdx);

						$(".lecture_pop").addClass("on");
					}
				});
				calendar.render();

				// 날짜 변경 이벤트
				//var wrap = "<?=check_device() ? 'mb' : 'pc'?>";
				var wrap = window.innerWidth <= 450 ? 'mb' : 'pc';
				var pick_date = document.querySelectorAll('.' + wrap + '_only .pick_date');
				pick_date.forEach(function(el){
					el.addEventListener('click', function(e){
						var _this = $(this).parent();

						var _targets = _this.parent().children('li');
						var i = 0;
						_targets.each(function(index){
							if ($(this).children('a').text() == _this.children('a').text()) {
								i = index;
								return false;
							}
						});
						_targets.removeClass("on");
						_this.addClass("on");

						pickDateClickListener(e);
					});
				});
				function pickDateClickListener(e){
					calendar.gotoDate(e.target.dataset.date);

					var class_name = "";
					if ($('li.on a.filter_class.not_all').length == 0) {
						class_name = "all";
						$('.filter_class[data-class-name="all"]').parent().addClass("on");
					}
					filtering(class_name);
				}

				// 날짜 초기세팅
				var today		= new Date();
				today.setHours(0);
				today.setMinutes(0);
				today.setSeconds(0);
				var start_day	= new Date('<?=$_PERIOD[0]?>');
				var end_day		= new Date('<?=end($_PERIOD)?>');

				var pick_date_idx, pick_day;
				if (today <= start_day) {
					pick_day = start_day;
					pick_date_idx = 0;
				} else if (today >= end_day) {
					pick_day = end_day;
					pick_date_idx = pick_date.length - 1;
				} else {
					var temp_day;
					pick_date.forEach(function(el, index){
						temp_day = new Date(el.dataset.date);
						temp_day.setHours(0);

						if (today.toString() == temp_day.toString()) {
							pick_day = temp_day;
							pick_date_idx = index;
							return;
						}
					});
				}
				pick_date[pick_date_idx].parentNode.classList.add('on');
				pick_date[pick_date_idx].click();

				// 일정 필터링
				$('.filter_class').click(function(){
					var _this = $(this);

					var class_name = _this.data('className');

					// 일단 on처리 해줌
					_this.parent().toggleClass('on');

					if ($('li.on a.filter_class.not_all').length == ($('.filter_class').length-1)) {
						class_name = "all";
					}

					filtering(class_name);
				});
			});

			// 상세 진입 변수값이 다르게 들어가는 부분
			function get_detail_lecture_idx(){
				return $(".lecture_pop button.move_open").data("lecture");
			}
			function get_detail_place_idx(){
				return $(".lecture_pop button.move_open").data("place");
			}

			// 일정 필터링
			function filtering(class_name){
				if (class_name == "all") {
					$('.filter_class').each(function(index){
						if (index == 0) {
							$(this).parent().addClass('on');
						} else {
							$(this).parent().removeClass('on');
						}
					});
					$('.fc-v-event').show();
				} else {
					$('.filter_class').eq(0).parent().removeClass('on');

					var on_classes = new Array();
					$('.fc-v-event').hide();
					$('li.on a.filter_class.not_all').each(function(index){
						$('.fc-v-event.'+$(this).data('className')).show();
					});
				}
			}
		</script>
	</body>
</html>