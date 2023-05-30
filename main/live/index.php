<?php
	include_once("../common/common.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ICOMES LIVE</title>
		<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>
		<link rel="stylesheet" href="./css/common.css">
	</head>
	<style>
		/*===========================================================================
			RESET
		============================================================================*/
		html, body, div, span, applet, object, iframe,
		h1, h2, h3, h4, h5, h6, p, blockquote, pre,
		a, abbr, acronym, address, big, cite, code,
		del, dfn, em, img, ins, kbd, q, s, samp,
		small, strike, sub, sup, tt, var,
		u, i, center,
		dl, dt, dd, ol, ul, li,
		fieldset, form, label, legend,
		table, caption, tbody, tfoot, thead, tr, th, td,
		article, aside, canvas, details, embed,
		figure, figcaption, footer, header, hgroup,
		menu, nav, output, ruby, section, summary,
		time, mark, audio, video, button, input, br ,textarea { -ms-overflow-style: none; /* IE and Edge */ scrollbar-width: none; /* Firefox */margin:0;padding:0;border:0;box-sizing:border-box; color:#444; line-height:1.2; letter-spacing:-0.36px; box-sizing:border-box; color:#fff; font-family:"Noto Sans KR", sans-serif;}
		/* HTML5 display-role reset for older browsers */
		article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display:block}
		a {display: inline-block;text-decoration:none;color:inherit;}
		a:link, a:visited {text-decoration:none;}
		a:hover, a:active {text-decoration:none;}
		img {border:none;vertical-align:middle;}
		ol, ul, li {list-style:none;}
		area {cursor:pointer;}
		/*reset end*/
		::-webkit-scrollbar {
			display: none; /* Chrome, Safari, Opera*/
		}
		html,body{height: 100%;}
/*		.page_iframe {position:absolute; width: 100%;height: 100%;}*/
		.page_iframe {position:fixed; width: 100%;height: 100%;}
		#sub_iframe{display: none;}

		#common_small_player {position:fixed; top:10px; left:10px; width:600px; height:300px; display: none;}
		/*hubdnc*/
		#common_small_player .big_player {width: 30px;height: 30px;background-color: red;position: absolute;top: 0;z-index: 10000;}

		/*intoon*/
		#common_small_player .big_player{background-image: url(/main/live/images/player_icon1.png);background-color: transparent;background-size: contain;top: 10px;right: 10px !important;cursor: pointer;}

		.iframe_box {position:relative; width:100%; height: 100%;}/*padding-bottom:56.25%;*/
		.iframe_box #player-Container {position:absolute;}
		
		@media screen and (max-width: 450px) {
			/*메인 스몰플레이어*/
			#common_small_player {width:320px; height:240px;}
		}

		#landscape{display: none;}
		#landscape .pop_contents {width:400px;}
		#landscape .pop_cont {color:#000; padding:40px 0; text-align:center; background-color:transparent;font-size: 25px;}
		/* 가로 모드일때 경고창 */
		@media screen and (max-width: 1023px) and (max-height: 767px) and (orientation: landscape){
			#landscape{display:block;position:fixed;top:0;left:0;z-index:999;width:100%;height:100%;background:#000;color:#fff}
		}
	</style>
	<body>
		<!-- <div id="landscape">
			<div class="pop_wrap">
				<div class="pop_contents">
					<div class="pop_cont">Please use in portrait mode.</div>
				</div>
			</div>
		</div> -->
		<iframe src="./home.php" class="page_iframe" id="sub_iframe"></iframe>
		<iframe src="./home.php" class="page_iframe" id="main_iframe"></iframe>
		<div id="common_small_player"><i class='big_player'></i><div id='player_small' class='iframe_box'></div></div>
	</body>
	<script>
		$(".big_player").click(function () {
			var _window = window;
			_window.frames[0].location.href = './home.php';
			_window.document.querySelector('#sub_iframe').style.display = 'none';

			_window.document.querySelector('#common_small_player').style.display = 'none';
			WowzaPlayer.get('player_small').destroy();
			document.getElementById("main_iframe").contentWindow.postMessage({
				functionName : 'unlock_mute'
			}, '*');

			_window.document.querySelector('#main_iframe').style.display = 'block';
		});

		var need_first = true;
		window.addEventListener('message', (e) => {
			switch(e.data.functionName){
				case "open_small_player" :	// 자식창 요청으로 작은 플레이어 킴
					WowzaPlayer.create('player_small', e.data.obj);
					break;
				case "need_login" :			// 화면진입 유효성 - 미로그인
				case "need_payment" :		// 화면진입 유효성 - 미결제 또는 오프라인만 참석인 경우
					var msg = e.data.functionName == "need_login" ? "Need to login." : "Pre-registration has been closed.\nAttendees who have not registered in advance are not accessible.";
					if (need_first) {
						alert(msg);
						window.location.replace('/main/login.php?from=live');
						need_first = !need_first;
					}
					break;
			}
		});
	</script>
	<?php
		if ($_SESSION["ADMIN"]["idx"] == "") {
	?>
	<script>
		$(function(){
			var member_idx = document.cookie.match('(^|;) ?member_idx=([^;]*)(;|$)');
			member_idx = member_idx ? member_idx[2] : null;
			if(member_idx == null) {
				alert("Need to login.");
				window.location.replace('/main/login.php?from=live');
			}
		})
	</script>
	<?php
		}
	?>
</html>