<?php
	include_once("../common/common.php");

	include_once("./include/login_interceptor.php");

	include_once("./include/set_event_period.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ICOMES LIVE</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
		<!-- custom scrollbar stylesheet -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.css">
		<link href="./fullcalendar/main.css" rel="stylesheet" />
		<link rel="stylesheet" href="./css/common.css?ver=2.3">
		<link rel="stylesheet" href="./css/live_style.css?ver=2.3">
		<link rel="stylesheet" href="./css/icomes_style.css?ver=2.3">
		<link href="./assets/style/live_style.css?ver=2.3" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="./css/style.css?ver=2.3">
		<link rel="stylesheet" href="./css/style1.css?ver=2.3">
<!-- 		<link href="./assets/style/style.css" rel="stylesheet" type="text/css" /> -->
		<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<!-- <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
		<!-- custom scrollbar plugin -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<script src="./fullcalendar/main.js"></script>
		<script src="./js/style.js"></script>
	</head>
	<body>
		<header>
			<div class="clearfix pc_only">
				<h1 class="logo floatL"><a href="./home.php" class="go_home"><img src="./images/icon/icon_logo.png" alt=""></a></h1>
				<ul class="sub_info floatR">
					<li><a href="./home.php" class="go_home">Home</a></li>
					<?php
						if ($_SESSION["USER"]["idx"] != "") {
					?>
					<li><a href="javascript:;"><i><img src="./images/icon/icon_login.png" alt=""></i><span><?=$_SESSION["USER"]["first_name"]." ".$_SESSION["USER"]["last_name"]?></span> 님</a></li>
					<li class="table_open"><a href="javascript:;"><i><img src="./images/icon/icon_mypage.png" alt=""></i>My Page</a></li>
					<?php
						}
					?>
					<li><a href="javascript:;" class="logout_btn"><i><img src="./images/icon/icon_logout.png" alt=""></i>Log Out</a></li>
				</ul>
			</div>
			<div class="mb_only mb_header clearfix">
				<a href="./home.php" class="mb_icon_home go_home"><img src="./images/icon/mb_icon_home.png" alt="" ></a>
				<i class="mb_icon_menu "><img src="./images/icon/mb_icon_menu.png" alt=""></i>
				<p class="mb_pg_name"></p>
			</div>

		</header>
		<nav class="mb_nav "><!--mb_only-->
			<ul class="mb_nav_top">
				<!-- 상단 프로필 -->
				<li class="clearfix">
					<div class="floatL nav_profile">
						<a href="">
							<i class="mb_icon_profile"><img src="./images/icon/mb_icon_profile.png" alt=""></i>
							<span><span><?=$_SESSION["USER"]["first_name"]." ".$_SESSION["USER"]["last_name"]?></span>님</span>
						</a>
					</div>
					<div class="floatR">
						<i class="close_btn"><img src="./images/icon/mb_icon_x_g.png" alt=""></i>
					</div>
				</li>
				<!-- 이수평점확인 btn -->
				<li>
					<button type="button" class="chk_point_btn table_open">나의 이수평점 확인</button>
				</li>
			</ul>
			<!-- 메뉴바 -->
			<ul class="mb_nav_mid">
				<li><a href="./tiva.php">
					<i><img src="./images/icon/mb_icon_schedule.png" alt=""></i>
					<span>Program at a Glance</span>
				</a></li>
				<li><a href="./lecture.php">
					<i><img src="./images/icon/mb_icon_lecture.png" alt=""></i>
					<span>Lecture Room</span>
				</a></li>
<!-- 행사 종료 포스터 입장 제한
				<li><a href="./eposter_list.php">
					<i><img src="./images/icon/mb_icon_poster.png" alt=""></i>
					<span>Poster</span>
				</a></li>
-->
				<li><a href="void(0);" onclick="alert('Please understand that ICOMES 2021 has ended and admission is not possible.');return false;">
					<i><img src="./images/icon/mb_icon_poster.png" alt=""></i>
					<span>Poster</span>
				</a></li>
				<li><a href="./platinum.php">
					<i><img src="./images/icon/mb_icon_booth.png" alt=""></i>
					<span>Online-booth</span>
				</a></li>
				<li><a href="./event_intro.php">
					<i><img src="./images/icon/mb_icon_event.png" alt=""></i>
					<span>Event Zone</span>
				</a></li>
			</ul>
			<!-- 로그아웃 -->
			<div class="mb_nav_bot">
				<a href="javascript:;" class="logout_btn"><i class="mb_icon_logout"><img src="./images/icon/mb_icon_logout.png" alt=""></i><span>Log out</span></a>
			</div>
		</nav>
<script>
$(document).ready(function(){
	$(".logout_btn").on("click", function(){
		if (!$(this).hasClass("off")) {
			logout();
		}
	});
	function logout(){
		$.ajax({
			url : "/main/ajax/client/ajax_member.php",
			type : "GET",
			data : {
				flag : "logout"
			},
			dataType : "JSON",
			success : function(){
				window.parent.location.replace("/main");
			},
			error : function(){
				alert("일시적으로 로그아웃 요청이 거절되었습니다.");
			}
		});
	}

	// 모바일 내비게이션 on/off
	$(".mb_icon_menu").click(function(){
		//$("html, body").addClass("h100");
		$(".mb_nav").addClass("on");
	});
	$(".mb_nav .close_btn").click(function(){
		//$("html, body").removeClass("h100");
		$(".mb_nav").removeClass("on");
	});
		
	/*$(".scroll_plugin").mCustomScrollbar({
		theme:"dark"
	});

	$(".scroll_plugin1").mCustomScrollbar({
		theme:"light"
	});*/
	
	/*$(window).resize(function(){
		if ($(window).width() < 480){
			$(".scroll_plugin").mCustomScrollbar('destroy');
			$(".scroll_plugin1").mCustomScrollbar('destroy');
		}
	});
	$(window).trigger("resize");*/
});
</script>