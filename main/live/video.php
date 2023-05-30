<?php
	include_once ("./include/header.php");

	$place_idx = $_GET['idx'];
	$member_idx = $_GET['mb'];

	$sql_lecture =	"SELECT
						lp.url AS player_url,
						IFNULL(cur_lc.idx, 0) AS idx,
						IFNULL(cur_lc.agenda_title_en, '') AS lecture_title_en,
						IFNULL(cur_lc.theme_en, '') AS lecture_theme_en,
						IFNULL(cur_lc.speaker_period_en, '') AS lecture_speaker_period_en,
						IFNULL(cur_lc.speaker_subject_en, '') AS lecture_speaker_subject_en,
						IFNULL(cur_lc.speaker_name_en, '') AS lecture_speaker_name_en,
						IFNULL(cur_lc.speaker_affiliation_en, '') AS lecture_speaker_affiliation_en,
						IFNULL(cur_lc.speaker_img_path, '') AS lecture_speaker_img_path,
						IFNULL(cur_lc.speaker_pdf_path, '') AS lecture_speaker_pdf_path
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
							) AS lc
								ON lc.idx = pu.lecture_idx
							GROUP BY pu.place_idx
						)
					) AS cur_lc
						ON cur_lc.place_idx = lp.idx
					WHERE lp.is_deleted = 'N'
					AND lp.idx = '".$place_idx."'";
	$lecture = sql_fetch($sql_lecture);
	foreach($lecture as $key=>$value){
		$lecture[$key] = addslashes(htmlspecialchars_decode($value, ENT_QUOTES));
	}

	// qna 등록용 place idx는 따로 빼기로 했음
	$sql_qna_place =	"SELECT
							MIN(place_idx) AS min_place_idx
						FROM lecture_place_use
						WHERE lecture_idx = ".$lecture['idx']."";
	$qna_place_idx = sql_fetch($sql_qna_place)['min_place_idx'];

	// sponser
	$sponsor_arr = [];
	switch($place_idx){
		case 1:
			$sponsor_arr = [1,2,3,4,5,6];
			break;
		case 2:
			$sponsor_arr = [7,8,9,10,11,12];
			break;
		case 3:
			$sponsor_arr = [13,14,15,16];
			break;
		case 4:
			$sponsor_arr = [17,18,19,20,21];
			break;
		case 5:
			$sponsor_arr = [22,23,24,25,26,27,28];
			break;
	}
?>
		<p class="mb_pg_title">KST (Korea Standard Time) <span class="now_time"><?=date('H:i')?></span></p>
		<!-- <iframe src="./lecture.php" class="page_iframe"></iframe> -->
		<section class="container iframe video auto">
			<div class="clock_box rightT pc_only">
				<img src="./images/icon/icon_clock_g.png" alt="">KST (Korea Standard Time) <span class="now_time"><?=date('H:i')?></span>
			</div>
			<div class="video_container clearfix">
				<div class="vedio_area" style="overflow: hidden;">
					<div>
						<!-- <iframe src="<?=$lecture['lecture_speaker_period_en']?>"></iframe> -->
						<div id="player" class="iframe_box"></div>
						<div class="small_player" style="display: none;"></div>
					</div>
					<div class="pc_only">
						<div class="chat_input">
							<p>Q&amp;A</p>
							<input type="text" placeholder="Please enter your questions during the lecture.(300 characters)" name="qna" maxlength="300">
							<button type="button" class="btn yellow_btn question">Send</button>
						</div>
						<div class="scroll_chat scroll_plugin1">
							<div>
								<ul name="qnas">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="pc_only">
					<p class="exit_title exit_lecture">EXIT</p>
					<!-- <form action=""> -->
					<div class="form_div">
						<ul class="tab_pager clearfix">
							<li class="on"><a href="javascript:;">Chatting</a></li>
							<li class=""><a href="javascript:;">More Details</a></li>
						</ul>
						<div class="tab_wrap">
							<div class="tab_cont on">
								<div class="tab_scroll scroll_plugin">
									<ul class="chatting_list"></ul>
								</div>
							</div>
							<div class="tab_cont">
								<div class="tab_scroll">
									<ul class="detail_list">
										<?php
											$speakers = array(
												'periods' => explode('|', $lecture['lecture_speaker_period_en']),
												'subjects' => explode('|', $lecture['lecture_speaker_subject_en']),
												'names' => explode('|', $lecture['lecture_speaker_name_en']),
												'affiliations' => explode('|', $lecture['lecture_speaker_affiliation_en']),
												'imgs' => explode('|', $lecture['lecture_speaker_img_path']),
												'pdfs' => explode('|', $lecture['lecture_speaker_pdf_path']),
												'length' => 0
											);
											$speakers['length'] = count($speakers['names']);
											if ($speakers['length'] <= 0) {
										?>
										<li class="clearfix">
											No data
										</li>
										<?php
											} else {
												for($i=0;$i<$speakers['length'];$i++){
													$profile_path = ($speakers['imgs'][$i]) ? "/main/img/live_lecture_speaker/".$speakers['imgs'][$i] : "../img/icons/icon_noProfile.png";
										?>
										<li class="clearfix">
											<div class="people_img floatL">
												<div class="img" style="background-image: url(<?=$profile_path?>);"></div>
												<p class="speaker">Speaker</p>
											</div>
											<div class="floatR">
												<ul>
													<li>
														KST (Korea Standard Time) <span class="bold"><?=$speakers['periods'][$i]?></span>
													</li>
													<?php
														$speakers_names = explode('^&', $speakers['names'][$i]);
														$speakers_affiliations = explode('^&', $speakers['affiliations'][$i]);
														for($j=0;$j<count($speakers_names);$j++){
													?>
													<li>
														<span class="bold"><?=$speakers_names[$j]?></span>
														<?php
															if ($speakers_affiliations[$j]) {
														?>
														<br/><?=$speakers_affiliations[$j]?>
														<?php
															}
														?>
													</li>
													<?php
														}
													?>
													<li>
														<span class="bold"><?=$speakers['subjects'][$i]?></span>
													</li>
													<?php
														if ($speakers['pdfs'][$i]) {
													?>
													<li>
														<button type="button" class="btn yellow_btn cv_abstract">CV, Abstract</button>
														<a href="/main/pdf_library/viewer.html?file=/main/img/live_lecture_speaker/<?=$speakers['pdfs'][$i]?>" style="display: none;" target="_blank">CV, Abstract</a>
													</li>
													<?php
														}
													?>
												</ul>
											</div>
										</li>
										<?php
												}
											}
										?>
									</ul>
								</div>
							</div>
						</div>
						<div class="chat_input chat">
							<input type="text" placeholder="Please enter your questions during the lecture.(200 characters)" name="chat" maxlength="200">
							<button type="button" class="btn yellow_btn chat">Send</button>
						</div>
					</div>
					<!-- </form> -->
				</div>
				<div class="mb_only">
					<div class="form_div">
					<!-- <form action=""> -->
						<ul class="tab_pager clearfix">
							<li class="on"><a href="javascript:;">Chatting</a></li>
							<li class=""><a href="javascript:;">More Details</a></li>
							<li class=""><a href="javascript:;">Q&A</a></li>
						</ul>
						<div class="tab_wrap">
							<div class="tab_cont on">
								<div class="tab_scroll scroll_plugin">
									<ul class="chatting_list"></ul>
								</div>
							</div>
							<div class="tab_cont">
								<div class="tab_scroll scroll_plugin">
									<ul class="detail_list">
										<?php
											$speakers = array(
												'periods' => explode('|', $lecture['lecture_speaker_period_en']),
												'subjects' => explode('|', $lecture['lecture_speaker_subject_en']),
												'names' => explode('|', $lecture['lecture_speaker_name_en']),
												'affiliations' => explode('|', $lecture['lecture_speaker_affiliation_en']),
												'imgs' => explode('|', $lecture['lecture_speaker_img_path']),
												'pdfs' => explode('|', $lecture['lecture_speaker_pdf_path']),
												'length' => 0
											);
											$speakers['length'] = count($speakers['names']);
											if ($speakers['length'] <= 0) {
										?>
										<li class="clearfix">
											No data
										</li>
										<?php
											} else {
												for($i=0;$i<$speakers['length'];$i++){
													$profile_path = ($speakers['imgs'][$i]) ? "/main/img/live_lecture_speaker/".$speakers['imgs'][$i] : "../img/icons/icon_noProfile.png";
										?>
										<li class="clearfix">
											<div class="people_img floatL">
												<div class="img" style="background-image: url(<?=$profile_path?>);"></div>
												<p class="speaker">Speaker</p>
											</div>
											<div class="floatR">
												<ul>
													<li>
														KST (Korea Standard Time) <span class="bold"><?=$speakers['periods'][$i]?></span>
													</li>
													<?php
														$speakers_names = explode('^&', $speakers['names'][$i]);
														$speakers_affiliations = explode('^&', $speakers['affiliations'][$i]);
														for($j=0;$j<count($speakers_names);$j++){
													?>
													<li>
														<span class="bold"><?=$speakers_names[$j]?></span>
														<?php
															if ($speakers_affiliations[$j]) {
														?>
														<br/><?=$speakers_affiliations[$j]?>
														<?php
															}
														?>
													</li>
													<?php
														}
													?>
													<li>
														<span class="bold"><?=$speakers['subjects'][$i]?></span>
													</li>
													<?php
														if ($speakers['pdfs'][$i]) {
													?>
													<li>
														<button type="button" class="btn yellow_btn cv_abstract">CV, Abstract</button>
														<a href="/main/pdf_library/viewer.html?file=/main/img/live_lecture_speaker/<?=$speakers['pdfs'][$i]?>" style="display: none;" target="_blank">CV, Abstract</a>
													</li>
													<?php
														}
													?>
												</ul>
											</div>
										</li>
										<?php
												}
											}
										?>
									</ul>
								</div>
							</div>
							<div class="tab_cont">
								<div class="scroll_chat">
									<div>
										<ul name="qnas">
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!--<div class="chat_input">
							<input type="text" placeholder="Hi ~ : )">
							<button type="button" class="btn yellow_btn">Send</button>
						</div>-->
					</div>
					<!-- </form> -->
					<div class="chat_input first">
						<input type="text" placeholder="Please enter your questions during the lecture.(200 characters)" name="chat" maxlength="200">
						<button type="button" class="btn yellow_btn chat">Send</button>
					</div>
					<div class="chat_input last">
						<input type="text" placeholder="Please enter your questions during the lecture.(300 characters)" name="qna" maxlength="300">
						<button type="button" class="btn yellow_btn question">Send</button>
					</div>
				</div>

			</div>
			<?php
				if (count($sponsor_arr) > 0) {
			?>
			<div class="partner_slick">
				<ul>
			<?php
					foreach ($sponsor_arr as $i) {
			?>
					<li><img src="/main/upload/img/e_booth/video_partner<?=sprintf('%02d', $i)?>.png" alt="<?=$i?>"></li>
			<?php
					}
			?>
				</ul>
			</div>
			<?php
				}
			?>
		</section>
		<?php include_once("./include/popup.php")?>
	<style>
		html, body {min-height:100% !important;}
		@media screen and (max-width:1024) {
			html, body {height:auto !important;}
		}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
	<script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>
	<script>
		const PLACE_IDX		= '<?=$place_idx?>';
		const LECTURE_IDX	= '<?=$lecture["idx"]?>';
		const MEMBER_IDX	= '<?=$member_idx?>';
		const QNA_PLACE_IDX	= '<?=$qna_place_idx?>';

		// 소켓 설정
		var socket = io.connect("<?=SOCKET_LIVE_CHAT_DOMAIN?>");
		var soc_id = "";
		var set_place_data = new Object();

		socket.on('connection_complete',function(data){
			soc_id = data;
			set_place_data = {place_idx : PLACE_IDX, socket_id : soc_id};
			socket.emit('set_place',set_place_data);
		});

		var check_unload = true;
		$(window).on("beforeunload", function() {
			if(check_unload) return true;
		});

		$(document).ready(function(){
			// 페이지 나가는 링크 클릭 시 퇴장시간 업데이트
			$('.go_home').attr('href', 'javascript:update_exit(2);');
			$('.logout_btn').addClass('off').attr('href', 'javascript:update_exit(3);');

			// 별도 액션 없어도 {check_min}분에 한번은 퇴장시간 업데이트
			var check_min = 5;
			var temp_min = 0;
			var setinterval = setInterval(function () {
				var time_txt = null;
				var d = new Date();
				var h = d.getHours();
				var m = d.getMinutes();
				time_txt = (h<10 ? "0"+h : h) + ":" + (m<10 ? "0"+m : m);
				$(".now_time").text(time_txt);

				temp_min += 0.5;
				if (temp_min == check_min) {
					update_exit(0);
					temp_min = 0;
				}
			}, 30000);

			get_qna_list();
			get_chat_list();

			$(window).resize(function () {
				var vdo_area = $(".vedio_area").height();
				$(".vedio_area").next("div").height(vdo_area);
			});
			$(window).trigger("resize");

			// pip 기능 모바일에서 히든
			if ('ontouchstart' in document.documentElement === false) {
				$('.small_player').show();
			}
		});

		// ios click 대응
		var click_event = (function() {
			var evt = '';
			if ('ontouchstart' in document.documentElement === true) {
				evt = 'touchstart';
			} else {
				evt = 'click';
			}
			return evt;
		})();

		// PC 탭 이벤트
		$(".pc_only .tab_pager li").on(click_event, function(){
			var _this = $(this);

			var _targets = $(".pc_only .tab_pager li");
			var i = 0;
			_targets.each(function(index){
				if ($(this).children('a').text() == _this.children('a').text()) {
					i = index;
					return false;
				}
			});
			_targets.removeClass("on");
			_this.addClass("on");

			var _conts = _this.parents('ul').siblings('.tab_wrap').children('.tab_cont');
			_conts.removeClass("on");
			_conts.eq(i).addClass("on");

			switch(i){
				case 0 :
					$('.pc_only .chat_input.chat').show();
					$(".video_container .tab_wrap").css("height","calc(100% - 130px)");
					break;
				case 1 :
					$('.pc_only .chat_input.chat').hide();
					$(".video_container .tab_wrap").css("height","calc(100% - 50px)");
					break;
			}
		});

		// 모바일 탭 이벤트
		$(".mb_only .tab_pager li").on(click_event, function(){
			var _this = $(this);

			var _targets = $(".mb_only .tab_pager li");
			var i = 0;
			_targets.each(function(index){
				if ($(this).children('a').text() == _this.children('a').text()) {
					i = index;
					return false;
				}
			});
			_targets.removeClass("on");
			_this.addClass("on");

			var _conts = _this.parents('ul').siblings('.tab_wrap').children('.tab_cont');
			_conts.removeClass("on");
			_conts.eq(i).addClass("on");

			switch(i){
				case 0 :
					$(".chat_input.first").show();
					$(".chat_input.last").hide();
					$(".video_container form").css("height","calc(100% - 71px)");
					break;
				case 1 :
					$(".chat_input").hide();
					$(".video_container form").css("height","100%");
					break;
				case 2 :
					$(".chat_input.first").hide();
					$(".chat_input.last").show();
					$(".video_container form").css("height","calc(100% - 71px)");
					break;
			}
		});

		//퇴장 confirm
		$(document).on(click_event, ".exit_lecture", function () {
			update_exit(2);
		});

		// 퇴장 시간 업데이트
		function update_exit(leave_flag){
			//console.log('update_exit', new Date());
			$.ajax({
				url : "../ajax/client/ajax_lecture.php",
				type : "POST",
				data : {
					flag : 'exit',
					place_idx : PLACE_IDX,
					member_idx : MEMBER_IDX,
					time_diff : "+5 minutes" // 퇴장시간 보정 (php strtotime에서 사용하는 방식으로 작성하여 사용)
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						switch(leave_flag){
							case 0 :
								break;
							case 1 :
								if (confirm("Do you want to exit?")) {
									check_unload = false;
									location.href = "./lecture.php";
								}
								break;
							case 2 :
								if (confirm("페이지를 이동하시면 퇴장처리 됩니다.\n이동하시겠습니까?")) {
									check_unload = false;
									location.href = "./home.php";
								}
								break;
							case 3 :
								if (confirm("로그아웃하시면 퇴장처리 됩니다.\n처리하시겠습니까?")) {
									check_unload = false;
									$(".logout_btn.off").removeClass("off");
									$(".logout_btn").trigger("click");
								}
						}
					} else {
						alert(res.msg);
					}
				}
			});
		}

		// speaker abstract
		$('.cv_abstract').on(click_event, function(){
			update_exit(0);
			$(this).siblings('a')[0].click();
		});

		// qna
		$('[name=qna]').keyup(function(e){
			if (e.keyCode == 13) {
				$(this).siblings('button.question').trigger(click_event);
			} else {
				var val = $(this).val();
				$(this).val(val.substr(0,300));
			}
		});

		// qna 등록
		$('button.question').on(click_event, function(){
			if (!$(this).siblings('[name=qna]').val()) {
				alert('질문 내용을 입력해주세요.');
			} else {// if (confirm('발표자에게 질의하시겠습니까?\n관리자 확인 및 승인 처리 후 답변 받을 수 있습니다.'))
				update_exit(0);
				$.ajax({
					url : "../ajax/client/ajax_lecture.php",
					type : "POST",
					data : {
						flag : 'add_qna',
						lecture_idx : LECTURE_IDX,
						place_idx : QNA_PLACE_IDX,
						question : $(this).siblings('[name=qna]').val(),
						member_idx : MEMBER_IDX
					},
					dataType : "JSON",
					success : function(res) {
						if(res.code == 200) {
							$('[name=qna]').val("");
							get_qna_list();
						} else {
							alert(res.msg);
						}
					}
				});
			}
		});

		// qna 리스트
		function get_qna_list(){
			$.ajax({
				url : "../ajax/client/ajax_lecture.php",
				type : "POST",
				data : {
					flag : 'get_qna_list',
					lecture_idx : LECTURE_IDX,
					place_idx : QNA_PLACE_IDX,
					member_idx : MEMBER_IDX
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						var inner = "";
						if (res.total_count <= 0) {
							inner = '<li>No data</li>';
						} else {
							res.list.forEach(function(el){
								inner += '<li>' + el.question + '</li>';
							});
						}
						$('ul[name=qnas]').html(inner);
					} else {
						alert(res.msg);
					}
				}
			});
		}

		// chat
		$('[name=chat]').keyup(function(e){
			if (e.keyCode == 13) {
				$(this).siblings('button.chat').trigger(click_event);
			} else {
				var val = $(this).val();
				$(this).val(val.substr(0,200));
			}
		});

		// chat 등록
		var chat_before = "";
		var chat_before_time = new Date();
		$('button.chat').on(click_event, function(){
			var ajax_data = {
				flag : 'send_chat',
				lecture_idx : LECTURE_IDX,
				place_idx : QNA_PLACE_IDX,
				contents : $(this).siblings('[name=chat]').val(),
				member_idx : MEMBER_IDX
			}

			if (!$(this).siblings('[name=chat]').val()) {
				alert('채팅 내용을 입력해주세요.');
			} else if (ajax_data.contents === chat_before && (new Date()) - chat_before_time <= 30000) {
				alert('30초 이내에 동일한 채팅을 입력하였습니다.');
			} else {
				update_exit(0);

				$.ajax({
					url : "../ajax/client/ajax_lecture.php",
					type : "POST",
					data : ajax_data,
					dataType : "JSON",
					success : function(res) {
						if(res.code == 200) {
							$('[name=chat]').val("");
							get_chat_list();

							socket.emit('alert_chat', set_place_data);

							chat_before = ajax_data.contents;
							chat_before_time = new Date();
						} else {
							alert(res.msg);
						}
					}
				});
			}
		});

		// chat 리스트
		var wrap = $('.<?=check_device() ? "mb" : "pc"?>_only ul.chatting_list');
		function get_chat_list(){
			$.ajax({
				url : "../ajax/client/ajax_lecture.php",
				type : "POST",
				data : {
					flag : 'get_chat_list',
					lecture_idx : LECTURE_IDX,
					place_idx : QNA_PLACE_IDX,
					member_idx : MEMBER_IDX
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						var inner = "";
						if (res.total_count <= 0) {
							inner = '<li>No data</li>';
						} else {
							res.list.forEach(function(el){
								inner += '<li><span>' + el.member_name + ' :</span> ' + el.contents + '</li>';
							});
						}

						wrap.html(inner);
						wrap.parent().scrollTop(wrap[0].scrollHeight);
					} else {
						alert(res.msg);
					}
				}
			});
		}

		socket.on('get_chat_list',function(){
			get_chat_list();
		});

		//small_player
		//$(".page_iframe").hide();
		$(".small_player").on(click_event, function () {
			update_exit(0);

			WowzaPlayer.get('player').pause();

			var parent = window.parent.document;

			parent.querySelector('#sub_iframe').style.display = 'block';

			parent.querySelector('#common_small_player').style.display = 'block';
			window.parent.postMessage({
				functionName : 'open_small_player',
				obj : player_obj
			}, '*');

			parent.querySelector('#main_iframe').style.display = 'none';
		});

		var player_obj = {
			"license":"PLAY2-dY6Ka-P6Wnp-XQekr-ppnaW-uhxJ6",
			"sources":[
				{ "sourceURL":"<?=$lecture['player_url']?>" }
			],
			"title":"<?=$lecture['lecture_title_en']?>",
			"description":"<?=$lecture['lecture_theme_en']?>",
			"autoPlay":true,
			"mute":true,
			"volume":"75"
		};
		WowzaPlayer.create('player', player_obj);
		WowzaPlayer.get('player').mute(false);

		window.addEventListener('message', (e) => {
			switch(e.data.functionName){
				case "unlock_mute" :
					update_exit(0);
					var _player = WowzaPlayer.get('player');
					_player.play();
					_player.seek();
					break;
			}
		});
	</script>
	</body>
</html>