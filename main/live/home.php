<?php
	include_once("../common/common.php");

	include_once("./include/login_interceptor.php");

	include_once("./include/set_event_period.php");

	// 팝업 영상 주소
	$sql_info_live =	"SELECT
							il.popup_video_url
						FROM info_live AS il
						LEFT JOIN `file` AS fi_cb_en
							ON fi_cb_en.idx = il.conference_book_en_img";
	$info_live = sql_fetch($sql_info_live);
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1.0, user-scalable=yes">
	<title>ICOMES</title>
	<link href="./assets/style/style.css" rel="stylesheet" type="text/css" />
	<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!--    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">-->
<!--    <script src="https://unpkg.com/video.js/dist/video.js"></script>-->
	<!-- <script src="./assets/js/jquery.min.js"></script>
	<script src="./assets/js/jquery-ui.min.js"></script> 
	<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
	<script src="./assets/js/script.js"></script>
	<!-- slick slider -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

	<!-- hubdnc 작업분 -->
	<link rel="stylesheet" href="./css/common.css?ver=0.1">
	<link rel="stylesheet" href="./css/style.css?ver=0.1">
	<link rel="stylesheet" href="./css/style1.css?ver=0.1">
	<script src="./js/style.js"></script>
</head>
	<body style="margin:0px" id="main">
	<div class="main-body">
		<div id="container">
			<div id="main_content">
				<div id="booth-content">
					<img class="real" src="./assets/image/3840_cont.png" style="opacity:0;">
					<a href="./lecture.php">
						<div class="ic1_on iccl_on"></div>
						<div class="ic1 iccl obj_delay"></div>
					</a>
					<a href="./eposter_list.php">
						<div class="ic2_on iccl_on obj_delay"></div>
						<div class="ic2 iccl obj_delay"></div>
					</a>
					<a href="./platinum.php" target="_BLANK">
						<div class="ic3_on iccl_on obj_delay"></div>
						<div class="ic3 iccl obj_delay"></div>
					</a>
					<a href="./event_intro.php">
						<div class="ic4_on iccl_on obj_delay"></div>
						<div class="ic4 iccl obj_delay"></div>
					</a>
					<a href="./tiva.php">
						<div class="ic5_on iccl_on obj_delay"></div>
						<div class="ic5 iccl obj_delay"></div>
					</a>
					<a href="javascript:;" class="table_open">
						<div class="ic6_on iccl_on obj_delay"></div>
						<div class="ic6 iccl obj_delay"></div>
					</a>
					<a href="https://intoon.xcache.kinxcdn.com/ICOMES2021.pdf" target="_blank">
						<div class="ic7_on iccl_on obj_delay"></div>
						<div class="ic7 iccl obj_delay"></div>
					</a>
					<a href="https://ibooth.webeon.net/home/ibooth22" target="_blank">
						<div class="ic8_on iccl_on obj_delay"></div>
						<div class="ic8 iccl obj_delay"></div>
					</a>
					<div class="ic9">
						<div class="marquee">
							<div class="client-brands">
								<div class="client-brands-items">
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo1.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo2.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo3.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo4.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo5.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo6.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo7.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo8.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo9.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo10.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo11.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo12.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo13.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo14.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo15.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo16.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo17.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo18.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo19.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo20.png"></div>
									<div class="client-brands-item vertical-middle"><img src="./assets/image/s_logo/s_logo21.png"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="video_con">
						<div id="video_01" class="obj_delay"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="bg_cl">
		<div class="clouds">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>

	<?php
		// 평점 팝업 include
		include_once("./include/popup_mypage.php");

		/* 메인페이지 팝업 관련 코드 */
		if ($info_live['popup_video_url']) {
	?>
	<div class="index_pop popup">
		<div class="pop_bg index_pop_close"></div>
		<div class="pop_contents">
			<div class="pop_cont">
				<iframe width="895" height="500" src="<?=$info_live['popup_video_url']?>" allowfullscreen></iframe>
			</div>
			<div class="black_bar clearfix">
				<input type="checkbox" id="today_pop_check">
				<label for="today_pop_check"><i></i> Stop seeing today</label>
				<img src="/main/img/icons/pop_close_w.png" alt="" class="pop_close index_pop_close">
				<!-- ./images/icon/icon_x.png -->
			</div>
		</div>
	</div>
	<script>
		//쿠키가 존재하지 않으면 팝업창을 연다.
		var index_pop_value = document.cookie.match('(^|;) ?live_index_pop=([^;]*)(;|$)');
		index_pop_value = index_pop_value ? index_pop_value[2] : null;
		if(index_pop_value == null) {
			$('.index_pop').addClass("on");
		}
		//팝업닫기
		$(document).on('click', '.index_pop_close', function(){
			if($("#today_pop_check").is(":checked")){
				var toDate = new Date();
				toDate.setHours(toDate.getHours() + ((23-toDate.getHours()) + 9));
				toDate.setMinutes(toDate.getMinutes() + (60-toDate.getMinutes()));
				toDate.setSeconds(0);
				document.cookie = "live_index_pop=" + escape("done") + "; path=/; expires=" + toDate.toGMTString() + ";";
			}
			$('.index_pop').remove();
		});
	</script>
	<?php
		}
	?>
	<script src="https://vjs.zencdn.net/7.8.3/video.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery.marquee@1.5.0/jquery.marquee.min.js"></script>
	<script>
		$(document).ready(function(){
		//footer s_logo_list
			$('.s_logo_list').slick({
				dots: false,
				infinite: true,
				slidesToShow: 4,
				arrows : false,
				autoplay: true,
				autoplaySpeed: 1500,
			});
			$('.marquee').marquee({
				//speed in milliseconds of the marquee
				duration: 20000,
				//gap in pixels between the tickers
				//time in milliseconds before the marquee will start animating
				delayBeforeStart: 0,
				//'left' or 'right'
				//true or false - should the marquee be duplicated to show an effect of continues flow
				duplicated: true
			});
		})
	</script>
</body>
</html>
