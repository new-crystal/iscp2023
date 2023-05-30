<?php
	include_once ("./include/header.php");

	// 참여 가능한지 체크
	$sql_member_info =	"SELECT
							mb.idx AS member_idx,
							IFNULL(group_dc.cnt, 0) AS daily_check_count,
							IF(ld.idx IS NULL, 'N', 'Y') AS attend_yn,
							IFNULL(ld.win_yn, 'N') AS win_yn
						FROM member AS mb
						LEFT JOIN (
							SELECT
								member_idx, COUNT(idx) AS cnt
							FROM event_daily_check AS dc
							WHERE (
								DATE(dc.register_date) BETWEEN '".$_PERIOD[0]."' AND '".end($_PERIOD)."'
							)
							GROUP BY member_idx
						) AS group_dc
							ON group_dc.member_idx = mb.idx
						LEFT JOIN event_luckydraw AS ld
							ON ld.member_idx = mb.idx
						WHERE mb.idx = '".$_SESSION['USER']['idx']."'";
	$member_info = sql_fetch($sql_member_info);

	// e-booth 배열
	$sql_ebooth =	"SELECT
						GROUP_CONCAT(path) AS concat_str
					FROM (
						SELECT
							CONCAT('/main/upload/img/e_booth/', logo_card_name) AS path
						FROM e_booth
						ORDER BY RAND()
						LIMIT 21
					) AS res";
	$ebooths = explode(',', sql_fetch($sql_ebooth)['concat_str']);

	shuffle($ebooths);
	$shuffled = $ebooths;

	shuffle($ebooths);

	$image_urls = array_merge($ebooths, $shuffled);
?>
		<p class="mb_pg_title">Event Zone</p>
		<section class="container auto event_myAttendance">
			<article class="contents_bg">
				<!----- tab menu ----->
				<div class="centerT btn_atted_wrap">
					<ul class="tab_pager clearfix">
						<li class="on floatL"><a href="javascript:;">Attendance Check</a></li>
						<li class="floatR"><a href="javascript:;">Online-Booth Stamp</a></li>
					</ul>
				</div>
				<!----- title ----->
				<h1 class="menu_title">Event Zone</h1>
				<div class="tab_wrap">
					<!---------- tab(1) myAttendance - start ---------->
					<div class="myAttendance tab_cont on">
						<p class="outlines_g">My Attendance<br>Status</p>
						<!----- contents ----->
						<div class="centerT">
							<?php
								for($i=0;$i<$_PERIOD_COUNT;$i++){
									$date = date_create($_PERIOD[$i]);

									$sql_daily_check =	"SELECT 
															idx 
														FROM event_daily_check 
														WHERE member_idx = '".$_SESSION['USER']['idx']."' 
														AND DATE(register_date) = '".$_PERIOD[$i]."'";
									$key_color = (sql_fetch($sql_daily_check)['idx'] > 0) ? "color" : "gray";
							?>
							<div class="attend_gift centerT">
								<div class="attend_num">Day <?=($i+1)?>.</div>
								<p class="attend_date"><?=date_format($date, "M. j(D) Y")?></p>
								<img src="./images/icon/key_<?=$key_color?>.png" alt="아이콘_열쇠<?=($i+1)?>">
							</div>
							<?php
								}
							?>
						</div>
						<!----- btn ----->
						<div class="centerT">
							<?php
								$btn_class = "btnClicked";
								if ($member_info['daily_check_count'] < $_PERIOD_COUNT) {
									$btn_class = "disable_lack";
								} else if ($member_info['attend_yn'] == "Y") {
									$btn_class = "disable_already";
								}
							?>
							<button type="button" class="transparent_btn btn_lucky pointer <?=$btn_class?>">Check Lucky Draw</button>
						</div>
					</div>
					<!---------- tab(1) myAttendance - end ---------->

					<!---------- tab(2) visitStamp - start ---------->
					<div class="visitStamp tab_cont">
						<!----- contents (1) ----->
						<div class="centerT eventDate">
							<?php
								for($i=0;$i<$_PERIOD_COUNT;$i++){
									//$class_on = $i==0 ? "yellow_txt" : "";
									$date = date_create($_PERIOD[$i]);
							?>
							<!----- 모바일의 경우에 예외처리가 필요합니다(연도 앞에 br 추가하여 줄바꿈이 될 수 있도록) ----->
							<span>
								<a href="javascript:;" class="" data-date="<?=date_format($date, "Y-m-d")?>">
									<?php
										echo check_device() ? date_format($date, "M. j(D)")."<br>".date_format($date, "Y") : date_format($date, "M. j(D) Y");
									?>
								</a>
							</span>
							<?php
								}
							?>
						</div>
						<!----- contents (2) ----->
						<div class="centerT">
							<div class="clearfix gameRanking">
								<div class="floatL gameRanking_title">Game Ranking</div>
								<div class="floatR leftT gameRanking_name" name="rank_list_p">
									<!-- ranking -->
								</div>
							</div>
						</div>
						<!----- contents (3) ----->
						<p class="centerT userStamp">My Stamp Status <span name="stamp_count"></span> / <span name="max_stamp_count"></span></p>
						<div class="centerT stamp_wrap">
							<img src="./images/icon/stamp.png" alt="스탬프">
						</div>
						<!----- btn ----->
						<div class="centerT">
							<button type="button" class="transparent_btn btn_gameIn pointer btnClicked">GAME START!</button>
						</div>
					</div>
					<!---------- tab(2) visitStamp - end ---------->
				</div>
			</article>
		</section>
		<?php include_once ("./include/popup.php") ?>
		<script>
			const max_stamp_count = 25;
			$('span[name=max_stamp_count]').text(max_stamp_count);

			//탭
			$(".btn_atted_wrap .tab_pager li").click(function () {
				var _this = $(this);

				var _targets = $(".btn_atted_wrap .tab_pager li");
				var i = 0;
				_targets.each(function(index){
					if ($(this).children('a').text() == _this.children('a').text()) {
						i = index;
						return false;
					}
				});
				_targets.removeClass("on");
				_this.addClass("on");

				var _conts = _this.parents('ul').parent().siblings('.tab_wrap').children('.tab_cont');
				_conts.removeClass("on");
				_conts.eq(i).addClass("on");
			});

			var draw_alert_msg = "";
			$(".btn_lucky").click(function () {
				var _this = $(this);
				if (_this.hasClass("btnClicked")) {
					$(".luckyDraw_before_popup").addClass("on");
				} else {
					if (_this.hasClass("disable_lack")) {
						draw_alert_msg = "You need to present in all 3 days to participate in the event.";
					} else if (_this.hasClass("disable_already")) {
						draw_alert_msg = "you have already participated.";
					} else {
						draw_alert_msg = "Error during checking whether draw is possible.\nContact your administrator. [02-2039-7802]";
					}
					alert(draw_alert_msg);
				}
			});

			$(".luckyDraw_before_popup button").click(function () {
				var _this = $(this);

				if (_this.hasClass('yellow_btn')) {
					_this.addClass('gray_btn').removeClass('yellow_btn');
					draw_alert_msg = "The lottery is in the process.\n Please wait.";

					$.ajax({
						url : "../ajax/client/ajax_event.php",
						type : "POST",
						data : {
							flag : 'lotto'
						},
						dataType : "JSON",
						success : function(res) {
							// console.log(res);
							if(res.code == 200) {
								/*$(".luckyDraw_before_popup img.trasure").attr('src', './images/icon/treasureBox_opened.png');
								setTimeout(function(){
									$(".luckyDraw_before_popup").removeClass("on");
									var pop_class_name = (res.win_yn == "Y") ? "good" : "bad";
									$(".luckyDraw_"+pop_class_name+"_popup").addClass("on");
								}, 2000);*/
								$(".luckyDraw_before_popup").removeClass("on");
								var pop_class_name = (res.win_yn == "Y") ? "good" : "bad";
								$(".luckyDraw_"+pop_class_name+"_popup").addClass("on");
							} else {
								// 이 후에는 동일한 오류 메시지 나올 수 있도록 함
								draw_alert_msg = res.msg;
								alert(draw_alert_msg);
							}
						}
					});
				} else {
					alert(draw_alert_msg);
				}
				//$(".luckyDraw_after_popup").addClass("on");
			});
			/*$(".luckyDraw_good_popup .pop_cont").click(function () {
				$(".luckyDraw_good_popup").removeClass("on");
				$(".luckyDraw_bad_popup").addClass("on");
			});*/

			// 날짜 초기세팅
			var today		= new Date();
			today.setHours(0);
			today.setMinutes(0);
			today.setSeconds(0);
			var start_day	= new Date('<?=$_PERIOD[0]?>');
			var end_day		= new Date('<?=end($_PERIOD)?>');

			var pick_date_idx;
			var pick_date = $(".eventDate span a");
			if (today <= start_day) {
				pick_date_idx = 0;
			} else if (today >= end_day) {
				pick_date_idx = pick_date.length - 1;
			} else {
				var temp_day;
				pick_date.each(function(index){
					temp_day = new Date($(this).data('date'));
					temp_day.setHours(0);

					if (today.toString() == temp_day.toString()) {
						pick_date_idx = index;
						return;
					}
				});
			}
			pick_date.eq(pick_date_idx).addClass('yellow_txt');

			$(function(){
				// 스탬프 리스트
				get_stamp_list();

				// 랭킹 리스트
				set_top3();
			});
			// e-Booth 방문스탬프 날짜 onClick event
			$(".eventDate span a").on("click", function(){
				$(".eventDate span a").removeClass("yellow_txt");
				$(this).addClass("yellow_txt");
				get_stamp_list();
			});
			function get_stamp_list(){
				var date = $(".eventDate span a.yellow_txt").data('date');
				$.ajax({
					url : "../ajax/client/ajax_event.php",
					type : "POST",
					data : {
						flag : 'get_stamp_list',
						date : date
					},
					dataType : "JSON",
					success : function(res) {
						// console.log(res);
						if(res.code == 200) {
							var list_length = res.list.length;

							var temp;
							var inner = '';
							for (var i=0; i<max_stamp_count; i++) {
								if (i < list_length) {
									temp = res.list[i];
									inner +=	'<img src="/main/upload/img/e_booth/' + temp.logo_stamp_name + '" alt="스탬프_' + temp.company_name + '">';
								} else {
									inner +=	'<img src="./images/icon/stamp.png" alt="스탬프">';
								}
							}
							$('span[name=stamp_count]').text(res.total_count);
							$('.stamp_wrap').html(inner);

							// 스탬프 갯수로 버튼 클릭 가능여부 체크
							var data_date = new Date(date);
							data_date.setHours(0);
							if ((today.toString() == data_date.toString()) && (res.total_count >= max_stamp_count)) {
								$(".btn_gameIn").addClass('btnClicked');
							} else {
								$(".btn_gameIn").removeClass('btnClicked');
							}
						} else {
							alert(res.msg);
						}
					}
				});
			}

			//같은 카드 찾기 게임 관련 popup
			$(".btn_gameIn").click(function () {

				// 오늘 아니면 버튼 안뜸
				var data_date = new Date($(".eventDate span a.yellow_txt").data('date'));
				data_date.setHours(0);
				if (today.toString() != data_date.toString()) {
					alert(' You can participate only on that same day.');

				} else if (Number($('span[name=stamp_count]').text()) < max_stamp_count) {
					alert('You must collect '+ max_stamp_count +' stamps to participate.');

				} else {
					$.ajax({
						url : "../ajax/client/ajax_event.php",
						type : "POST",
						data : {
							flag : 'get_card_game_count'
						},
						dataType : "JSON",
						success : function(res) {
							// console.log(res);
							if(res.code == 200) {
								if (res.count >= 3) {
									alert('You can participate up to 3 times a day.');
								} else {
									$('.cardGame_info_popup [name=complete_count]').text(res.count);
									$(this).addClass("btnClicked");
									$(".cardGame_info_popup").addClass("on");
								}
							} else {
								alert(res.msg);
							}
						}
					});
				}
			});
			$(".btn_gameStart").click(function () {
				$(".cardGame_setting_popup").addClass("on");
			});

			// 랭킹 업데이트하기
			function set_top3(){
				$.ajax({
					url : "../ajax/client/ajax_event.php",
					type : "POST",
					data : {
						flag : 'get_rank_list'
					},
					dataType : "JSON",
					success : function(res) {
						// console.log(res);
						if(res.code == 200) {
							var list_length = res.list.length;

							var temp;
							var inner = '';
							for (var i=0; i<list_length; i++) {
								temp = res.list[i];
								inner +=	'<tag_name>Ranking ' + temp.rank + ' : ' + (temp.first_name + ' ' + temp.last_name);
								if (temp.affiliation != '') {
									inner +=	' [' + temp.affiliation + ']';
								}
								inner +=	'</tag_name>';
							}
							$('[name=rank_list_p]').html(inner.replace(/tag_name>/gi, "p>"));
							$('[name=rank_list_h5]').html(inner.replace(/tag_name>/gi, "h5>"));
						} else {
							alert(res.msg);
						}
					}
				});
			}

			/* 카드 뒤집기 게임 */
			var util = {
				random : function (min, max) {
					return Math.floor(Math.random() * (max - min + 1)) + min
				},
				filter : function (array, index) {
					var return_array = []

					for ( var x = 0; x < array.length; x++ ) {
						if ( x !== index ) {
							return_array.push(array[x])
						}
					}

					return return_array
				},
				numberFormat: function(e) {
					return ( e >= 10 ) ? e : '0' + e;
				},
				getHMS : function (second) {
					// 시간
					var hour = util.numberFormat(Math.floor(second / 3600))
					second -= (hour * 3600)

					// 분
					var minute = util.numberFormat(Math.floor(second / 60))
					second -= (minute * 60)

					var temp_second = second.toFixed(2).split('.');

					// 초
					return minute + ':' + util.numberFormat(temp_second[0]) + ':' + temp_second[1]
				}
			}

			// 타이머 시간
			var time_second = 0

			// 타이머 함수
			var tickTock = null

			// 뒤집은 카드
			var flipped = []

			// 카드 내 이미지 경로 querySelector
			var image_selector = '.card-back img'

			var success = 0;

			// 카드 이미지 섞기
			var imageSuffle = function () {
				// 카드 불러오기
				var cards = document.querySelectorAll(".cardGame_set li.card");

				// 이미지 경로 재할당
				var image_urls = JSON.parse('<?=json_encode($image_urls)?>');
				for (var x = 0; x < cards.length; x++) {
					var image_index = util.random(0,image_urls.length - 1)
					var image = image_urls[image_index]
					cards[x].querySelector(image_selector).src = image

					image_urls = util.filter(image_urls , image_index)
				}
			};

			// 시간 출력하기
			var viewTime = function () {
				document.querySelector('.timer').innerText = util.getHMS(time_second)
			}

			// 타이머 함수 할당
			var timerRegist = function () {
				tickTock = setInterval(function() {
					time_second += 0.01;
					viewTime();
				},10)
			}

			// 타이머 제거
			var timerClear = function () {
				clearInterval(tickTock);
				time_second = 0;
				viewTime();
			}

			// 게임 종료
			var onSuccess = function () {
				var success_time = util.getHMS(time_second);
				$.ajax({
					url : "../ajax/client/ajax_event.php",
					type : "POST",
					data : {
						flag : 'success_card_game',
						idx : $('.cardGame_timeOut_popup').data('idx'),
						time : success_time
					},
					dataType : "JSON",
					success : function(res) {
						if(res.code == 200) {
							$('.cardGame_setting_popup').removeClass('on');

							$('.cardGame_timeOut_popup .success-time').text(success_time);
							$('.cardGame_timeOut_popup .msg').text(((res.rank <= 3) ? "Congratulations. You’re in the top 3!" : "Unfortunately, I couldn’t make it to the top 3."));
							$('.cardGame_timeOut_popup').data('idx', '').addClass('on');

							onExit();
						} else {
							alert(res.msg);
						}
					}
				});
			}

			// 카드 클릭 이벤트
			var onClickCard = function (e) {
				var target = e.currentTarget

				// 같은 카드 두 번 연속 클릭 방지
				if ( target.classList.value.indexOf('flipped') !== -1) {
					return;
				}

				target.classList.add('flipped');
				target.classList.add('checking');

				flipped.push(target.querySelector(image_selector).src)

				// 카드 2개 뒤집힌 경우
				if (flipped.length === 2) {
					cardRemoveEvent();

					// 두 카드가 일치하지 않는 경우
					if (flipped[0] !== flipped[1]) {
						setTimeout(() => {
						$('.flipped.checking').removeClass('checking flipped')
						cardAddEvent()
						},800);
					} else {
						// 두 카드가 일치하는 경우
						success += 1
						setTimeout(() => {
							var cards = document.querySelectorAll(".cardGame_set li.card");
							$('.flipped.checking').removeClass('checking')
							if (success === cards.length / 2) {
								onSuccess();
							} else {
								cardAddEvent();
							}
						},800);
					}
					flipped = []
				}
			}

			// 카드 이벤트 등록
			var cardAddEvent = function () {
				// 카드 불러오기
				var cards = document.querySelectorAll(".cardGame_set li.card");
				for ( var x = 0; x < cards.length; x++ ) {
					cards[x].addEventListener('click' , onClickCard)
				} 
			}

			// 카드 이벤트 해제
			var cardRemoveEvent = function () {
				// 카드 불러오기
				var cards = document.querySelectorAll(".cardGame_set li.card");
				for ( var x = 0; x < cards.length; x++ ) {
					cards[x].removeEventListener('click' , onClickCard)
				} 
			}

			// 게임 종료 공통 이벤트
			var onExit = () => {
				timerClear();
				cardRemoveEvent();
				flipped = [];
				success = 0;
			}

			// 게임 시작 버튼 클릭 이벤트
			$(".btn_gamePlay").click(function () {
				$.ajax({
					url : "../ajax/client/ajax_event.php",
					type : "POST",
					data : {
						flag : 'start_card_game'
					},
					dataType : "JSON",
					success : function(res) {
						if(res.code == 200) {
							$('.cardGame_timeOut_popup').data('idx', res.idx);

							$(".btn_gamePlay").css("display", "none");
							$(".cardGame_setting_popup .pop_cont").css("padding-bottom", "82px");

							imageSuffle();
							timerRegist();
							cardAddEvent();
						} else {
							alert(res.msg);
						}
					}
				});
			});

			// 탈출 시 타이머 초기화
			$(".cardGame_setting_popup .pop_bg, .cardGame_setting_popup .pop_close").click(function () {
				onExit();
			});
			/* //카드 뒤집기 게임 */
		</script>
		<style>
			::-webkit-scrollbar {display:none;}
		</style>
	</body>
</html>