<?php
	include_once("./include/popup_mypage.php");
?>

<!-- 강의안내 팝업 -->
<div class="popup lecture_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Lecture</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont">
			<ul class="lecture_info">
				<li class="under_line">
					<div>
						<span>Agenda Title</span>
					</div>
					<div name="title">Satellite Symposium 2 (베링거인겔하임)</div>
				</li>
				<li class="under_line">
					<div>
						<span>Session Theme</span>
					</div>
					<div name="session_theme">How to Approach Patients with Type 2 Diabetes<br/>in Perspective of Cardio-Renal Metabolism and Current<br/>Treatment Algorithm</div>
				</li>
				<li class="under_line">
					<div>
						<span>Time</span>
					</div>
					<div name="time">19:00~20:00</div>
				</li>
				<li class="under_line">
					<div>
						<span>Place</span>
					</div>
					<div name="place">Room 2</div>
				</li>
				<li class="under_line">
					<div>
						<span>Chairperson</span>
					</div>
					<div name="chairperson" class="chairperson">Min-Seon Kim <span class="light">(University of Ulsan, Korea)</span></div>
				</li>
				<li class="under_line">
					<div>
						<span>Panel</span>
					</div>
					<div name="panel" class="panel">TBD <span class="light">(TBD)</span></div>
				</li>
				<li class="under_line">
					<div>
						<span>Speaker</span>
					</div>
					<ul name="speaker" class="speaker">
						<li>
							<p>09:00-09:30</p>
							<p>Control of Feeding Behavior and Body Weight by Hypothalamic Cereblon (CRBN)</p>
							<p class="medium">Jae Min Lee (DGIST, Korea)</p>
						</li>
						<li>
							<p>09:30-10:30</p>
							<p>Long-term Increase of AgRP Neuron Activity Causes Body Weight Gain without Affecting Food Intake</p>
							<p class="medium">Jong-Woo Sohn (KAIST, Korea)</p>
						</li>
						<li>
							<p>10:00-10:30</p>
							<p>TBD</p>
							<p class="medium">Scott Sternson (UCSD, USA)</p>
						</li>
					</ul>
					<!--<div name="speaker">Speaker<br/>Speaker<br/>Speaker</div>-->
				</li>
			</ul>
		</div>
		<button type="button" class="btn yellow_btn black move_open">Lecture Enter</button>
	</div>
</div>

<!-- 세션이동안내 팝업 -->
<div class="popup list_pop move_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">세션 이동 안내</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont">
			<p>Do you want to move to a different classroom?<br>If you would like to move, please click the<br>Moving classrooms button below.</p>
			<ul class="mT10">
				<li><strong>If you do not want to move, click the [X] button in the upper right corner</strong></li>	
			</ul>
			<ul>
			    <li class="point_txt">For Korean Participant Only</li>
				<li>다른 강의실로 이동 시 현재 시청중인 세션은 퇴장 처리 됩니다.<br>추후 시청(체류) 시간은 이동 전 시청 시간까지 취합되며,<br>이동한 세션의 시청(체류) 시간이 자동 계산 됩니다.</li>
			</ul>
		</div>
		<button type="button" class="btn yellow_btn black enter pc_only">Moving classrooms</button>
		<button type="button" class="btn yellow_btn black enter mb_only">Moving classrooms</button>
	</div>
</div>

<!-- 평점안내 팝업 -->
<div class="popup list_pop grade_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">평점 안내 (For Korean Participant Only)</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont">
			<p>각 협회 및 기관 평점 인정 기준에 따라,<br/>각 세션마다 출결 시간 기록이 필요합니다.</p>
			<ul>
				<li><span class="bold_txt">강의실 입장 시 자동 시간 카운트 됩니다.</span><br>- 사전 접속자 경우 평점 계산 시 아젠다 타임테이블 시간에 맞추어 자동 계산됩니다.</li>
			</ul>
			<ul>
				<li><span class="point_txt">강의실 퇴장 시 "Exit" 버튼을 반드시 클릭 해 주시기 바랍니다.</span><br><span class="txt_red">- PC상단 뒤로가기 버튼 클릭 / Home 버튼 / 상단 ICOMES 로고 클릭으로 인한 이동은<br>평점인정이 되지 않으니 주의바랍니다.</span><br></li>
			</ul>
			<ul>
				<li><span class="bold_txt">동 시간 대 진행되는 다른 강의실 입장 시 [강의실 이동] 처리 안내 후 이동합니다.</span></li>
			</ul>
			<ul>
				<li><span class="bold_txt">My page에서 이수 시간 및 평점 확인이 가능 하며, 해당 기록은 온라인에 한하여 기록됩니다.</span><br>- 오프라인 출결확인은 현장 QR태그를 통해 확인 가능하며, 행사 종료 이후 My Page에서 확인 가능합니다.<br>- 최종 이수 시간 및 평점은 브레이크 시간이 자동 제외 되어 계산 되며 현장 상황에 따라 상이 할 수 있습니다.</li>
			</ul>
			<input type="checkbox" id="stop_see_grade" class="pc_only">
			<label for="stop_see_grade" class="label pc_only"><i></i>Stop seeing today</label>
		</div>
		<button type="button" class="btn yellow_btn black enter pc_only">Enter</button>
		<button type="button" class="btn yellow_btn black enter mb_only">Enter/입장</button>
	</div>
</div>

<!-- Event : Lucky Draw (보물상자 열기 전) -->
<div class="popup luckyDraw_before_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Lucky Draw</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont centerT">
			<img src="./images/icon/treasureBox_closed.png" alt="보물상자" class="trasure">
		</div>
		<button class="btn yellow_btn black">Open a treasure chest</button>
	</div>
</div>

<!-- Event : Lucky Draw (보물상자 열기 후)
<div class="popup luckyDraw_after_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Lucky Draw</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont centerT">
			<img src="./images/icon/treasureBox_opened.png" alt="보물상자_열기후">
		</div>
		<button class="btn gray_btn pop_close black">보물상자 열기!</button>
	</div>
</div> -->

<!-- Event : Lucky Draw (보물상자 - 성공) -->
<div class="popup luckyDraw_good_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Lucky Draw</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<!--
		<div class="pop_cont centerT">
			<img src="./images/icon/treasureBox_good.gif" alt="보물상자_열기후">
		</div>
		<p class="centerT msg">Congratulations!</p>
		-->
		<p class="centerT msg2">You won the lucky hero.</p>
		<p class="centerT">After the end of the conference, Amazon gift cards will be sent out via e-mail</p>
		<p class="centerT">
			<span class="txt_red">For more information, please refer to the event winning<br>information page after the end of the conference.</span>
		</p>
		<p class="centerT mT20"><img src="/main/live/images/amazon_card.png"></p>
		<div class="pop_cont centerT mT20">
			<img src="./images/icon/treasureBox_good.gif" alt="보물상자_열기후">
		</div>
		<p class="centerT msg">Congratulations!</p>
	</div>
</div>

<!-- Event : Lucky Draw (보물상자 - 꽝) -->
<div class="popup luckyDraw_bad_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Lucky Draw</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<!--
		<div class="pop_cont centerT">
			<img src="./images/icon/treasureBox_opened.gif" alt="보물상자_열기후">
		</div>
		<p class="centerT msg">Unfortunately.</p>
		-->
		<p class="centerT msg2">Unfortunately, you didn’t win.</p>
		<p class="centerT">Thank you for participating in ICOMES2021 for 3 days.<br>Next year, we will see you with more beneficial academic<br>topics and a variety of events.<br>Thank you!</p>
		<div class="pop_cont centerT mT20">
			<img src="./images/icon/treasureBox_opened.gif" alt="보물상자_열기후">
		</div>
		<p class="centerT msg">Unfortunately.</p>
	</div>
</div>

<!-- Event : 같은 카드 찾기 게임 Info -->
<div class="popup cardGame_info_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Memory matching game</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont centerT">
			<table>
				<thead>
					<tr>
						<td>Game Ranking</td>	
					</tr>
				</thead>
				<tbody>
					<tr>
						<td name="rank_list_h5">
							<h5>1등 : Ruud van Nistelrooy [Nigagarahawaii,Nigagarahawaii]</h5>
							<h5>2등 : Zlatan Ibrahimovic [Nigagarahawaii,Nigagarahawaii]</h5>
							<h5>3등 : 홍길동 [Nigagarahawaii]</h5>
						</td>
					</tr>
				</tbody>
			</table>
			<h2>Turn the cards over as fast as you can to find the same card!</h2>
			<p>The top 1-3 rankings are recorded in real time, and prizes are awarded by rank.<br>(The event is available everyday on a daily basis.)</p>
			<p class="userGame_count">Number of games I’ve participated in <span name="complete_count">1</span> / 3<p>
			<div class="game_info">
				<button class="btn yellow_btn pop_close black btn_gameStart">GAME START!</button>
			</div>
		</div>
	</div>
</div>

<!-- Event : 같은 카드 찾기 게임 Time out -->
<div class="popup cardGame_timeOut_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Memory matching game</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont centerT timeBox" style="padding: 77.5px 0; margin-top: 67px;">
			<img src="./images/icon/icon_clock.png" alt="아이콘_시계" class="imgBottom">
			TIME
			<span class='success-time'>00:00:00</span>
		</div>
		<p class="centerT msg">Congratulations. Your record was ranked in top 3</p>
	</div>
</div>

<!-- Event : 같은 카드 찾기 게임 Play -->
<div class="popup cardGame_setting_popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato">Memory matching game</span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont centerT">
			<div class="timeBox">
				<img src="./images/icon/icon_clock.png" alt="아이콘_시계" class="imgBottom">
				TIME
				<span class='timer'>00:00:00</span>
			</div>
			<ul class="cardGame_set clearfix">
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_alvogen.png" alt="카드_앞면_alvogen" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_msd.png" alt="카드_앞면_msd" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_nordisk.png" alt="카드_앞면_nordisk" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_daewoong.png" alt="카드_앞면_daewoong" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_yuhan.png" alt="카드_앞면_yuhan" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_ckd.png" alt="카드_앞면_ckd" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_hanbok.png" alt="카드_앞면_hanbok" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_dongA.png" alt="카드_앞면_dongA" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_hanmi.png" alt="카드_앞면_hanmi" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_cellTrion.png" alt="카드_앞면_cellTrion" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_astraZeneca.png" alt="카드_앞면_astraZeneca" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_lg.png" alt="카드_앞면_lg" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_sanofi.png" alt="카드_앞면_sanofi" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_kwangdong.png" alt="카드_앞면_kwangdong" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_boehringer.png" alt="카드_앞면_boehringer" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_boRyung.png" alt="카드_앞면_boRyung" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_jw.png" alt="카드_앞면_jw" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_innoN.png" alt="카드_앞면_innoN" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_daiichi.png" alt="카드_앞면_daiichi" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_aju.png" alt="카드_앞면_aju" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_dalim.png" alt="카드_앞면_dalim" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_alvogen.png" alt="카드_앞면_alvogen" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_msd.png" alt="카드_앞면_msd" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_nordisk.png" alt="카드_앞면_nordisk" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_daewoong.png" alt="카드_앞면_daewoong" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_yuhan.png" alt="카드_앞면_yuhan" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_ckd.png" alt="카드_앞면_ckd" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_hanbok.png" alt="카드_앞면_hanbok" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_dongA.png" alt="카드_앞면_dongA" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_hanmi.png" alt="카드_앞면_hanmi" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_cellTrion.png" alt="카드_앞면_cellTrion" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_astraZeneca.png" alt="카드_앞면_astraZeneca" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_lg.png" alt="카드_앞면_lg" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_sanofi.png" alt="카드_앞면_sanofi" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_kwangdong.png" alt="카드_앞면_kwangdong" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_boehringer.png" alt="카드_앞면_boehringer" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_boRyung.png" alt="카드_앞면_boRyung" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_jw.png" alt="카드_앞면_jw" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_innoN.png" alt="카드_앞면_innoN" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_daiichi.png" alt="카드_앞면_daiichi" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_aju.png" alt="카드_앞면_aju" class="imgBottom"></div>
					</div>
				</li>
				<li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_dalim.png" alt="카드_앞면_dalim" class="imgBottom"></div>
					</div>
				</li>
				<!-- <li class="card">
					<div class="card-inner">
						<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
						<div class="card-back"><img src="./images/icon/card_msd.png" alt="카드_앞면_msd" class="imgBottom"></div>
					</div>
				</li> -->
				<!-- 1 -->
				<!--
				<tr>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_alvogen.png" alt="카드_앞면_alvogen" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_msd.png" alt="카드_앞면_msd" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_nordisk.png" alt="카드_앞면_nordisk" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_daewoong.png" alt="카드_앞면_daewoong" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_yuhan.png" alt="카드_앞면_yuhan" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_ckd.png" alt="카드_앞면_ckd" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_hanbok.png" alt="카드_앞면_hanbok" class="imgBottom"></div>
						</div>
					</td>
				</tr>-->
				<!-- 2 -->
				<!--
				<tr>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_dongA.png" alt="카드_앞면_dongA" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_hanmi.png" alt="카드_앞면_hanmi" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_cellTrion.png" alt="카드_앞면_cellTrion" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_astraZeneca.png" alt="카드_앞면_astraZeneca" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_lg.png" alt="카드_앞면_lg" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_sanofi.png" alt="카드_앞면_sanofi" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_kwangdong.png" alt="카드_앞면_kwangdong" class="imgBottom"></div>
						</div>
					</td>
				</tr>-->
				<!-- 3 -->
				<!--
				<tr>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_boehringer.png" alt="카드_앞면_boehringer" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_boRyung.png" alt="카드_앞면_boRyung" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_jw.png" alt="카드_앞면_jw" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_innoN.png" alt="카드_앞면_innoN" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_daiichi.png" alt="카드_앞면_daiichi" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_aju.png" alt="카드_앞면_aju" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_dalim.png" alt="카드_앞면_dalim" class="imgBottom"></div>
						</div>
					</td>
				</tr>-->
				<!-- 1 -->
				<!--
				<tr>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_alvogen.png" alt="카드_앞면_alvogen" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_msd.png" alt="카드_앞면_msd" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_nordisk.png" alt="카드_앞면_nordisk" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_daewoong.png" alt="카드_앞면_daewoong" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_yuhan.png" alt="카드_앞면_yuhan" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_ckd.png" alt="카드_앞면_ckd" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_hanbok.png" alt="카드_앞면_hanbok" class="imgBottom"></div>
						</div>
					</td>
				</tr>-->
				<!-- 2 -->
				<!--
				<tr>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_dongA.png" alt="카드_앞면_dongA" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_hanmi.png" alt="카드_앞면_hanmi" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_cellTrion.png" alt="카드_앞면_cellTrion" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_astraZeneca.png" alt="카드_앞면_astraZeneca" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_lg.png" alt="카드_앞면_lg" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_sanofi.png" alt="카드_앞면_sanofi" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_kwangdong.png" alt="카드_앞면_kwangdong" class="imgBottom"></div>
						</div>
					</td>
				</tr>-->
				<!-- 3 -->
				<!--
				<tr>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_boehringer.png" alt="카드_앞면_boehringer" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_boRyung.png" alt="카드_앞면_boRyung" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_jw.png" alt="카드_앞면_jw" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_innoN.png" alt="카드_앞면_innoN" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_daiichi.png" alt="카드_앞면_daiichi" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_aju.png" alt="카드_앞면_aju" class="imgBottom"></div>
						</div>
					</td>
					<td class="card">
						<div class="card-inner">
							<div class="card-front"><img src="./images/icon/cardGame_back.png" alt="카드_뒷면" class="imgBottom"></div>
							<div class="card-back"><img src="./images/icon/card_dalim.png" alt="카드_앞면_dalim" class="imgBottom"></div>
						</div>
					</td>
				</tr>-->
			</ul>
		</div>
		<button class="btn yellow_btn black btn_gamePlay">GAME START!</button>
	</div>
</div>

<!--인덱스 비디오 팝업
<div class="index_pop popup">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<div class="pop_cont">
			<iframe width="895" height="500" src="https://image.webeon.net/icomes/video/main_pop_vid.mp4" allowfullscreen></iframe>
		</div>
		<div class="black_bar clearfix">
			<input type="checkbox" id="stop">
			<label for="stop">
				<i></i> Stop seeing today
			</label>
			<img src="/main/img/icons/pop_close_w.png" alt="" class="pop_close">
		</div>
	</div>
</div>-->

<!-- 테이블 팝업
<div class="popup full_vdo_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<div class="iframe_box">
			<iframe src="https://www.youtube.com/embed/nzDO6tAB6ng"></iframe>
		</div>
	</div>
</div> -->