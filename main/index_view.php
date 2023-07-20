<?php
// main
$img_col_name = check_device() ? "mo_" : "pc_";
$img_col_name .= $language . "_img";
$banner_query =    "SELECT
						b.idx,
						CONCAT(fi_img.path, '/', fi_img.save_name) AS fi_img_url
					FROM banner AS b
					LEFT JOIN `file` AS fi_img
						ON fi_img.idx = b." . $img_col_name . "
					WHERE b." . $img_col_name . " > 0";
$banner = get_data($banner_query);
$banner_cnt = count($banner);

// event
$info_query =    "SELECT
						ie.title AS event_title,
						ie.period_event_start,
						ie.period_event_end,
						igv.name_" . $language . " AS venue_name
					FROM info_event AS ie
					,info_general_venue igv";
$info = sql_fetch($info_query);

//key date
$key_date_query =    "SELECT
							`key_date`,
							contents_" . $language . " AS contents
						FROM key_date
						WHERE `type` = 'poster'
						#AND DATE(`key_date`) >= DATE(NOW())
						AND DATE(`key_date`) <> '0000-00-00'
						ORDER BY `key_date`
						LIMIT 4";
$key_date = get_data($key_date_query);
$key_date_cnt = count($key_date);

//2021_06_23 HUBDNC_KMJ NOTICE 쿼리
$notice_list_query = "SELECT
							idx,
							title_en,
							title_ko,
							DATE_FORMAT(register_date, '%Y-%m-%d') AS date_ymd
						FROM board
						WHERE `type` = 1
						AND is_deleted = 'N'
						ORDER BY register_date DESC
						LIMIT 3";
$notice_list = get_data($notice_list_query);

//$notice_cnt = count($notice_list);
?>

<style>
    .index_sponsor_wrap {
        display: block;
    }
</style>

<section class="main_section icola_main">
    <!-- 배경이미지
	<div class="bg_wrap">
		<div class="dim"></div>
		<div class="main_bg_slider">
			<div class="video_wrap">
				<video src="https://player.vimeo.com/external/595050190.hd.mp4?s=f5a9471e806bff619dc115c9dfc5db80d5df87fb&profile_id=174" autoplay="autoplay" muted="muted" playsinline id="main_video_bg" loop></video>
			</div>
			<?php
            foreach ($banner as $bn) {
            ?>
			<div class="main_img_wrap"><img src="<?= $bn['fi_img_url'] ?>"></div>
			<?php
            }
            ?>
			<?php

            //오늘 날짜 구하기 d_day 구하기
            $today = date("Y. m. d");
            $d_day = new DateTime("2023-11-23");

            $current_date = new DateTime();
            $current_date->format('Y-m-d');

            $intvl = $current_date->diff($d_day);
            $d_days = $intvl->days + 1;
            ?>
		</div>
	</div>
	-->
    <div class="section_bg">
        <div class="container">
            <!-- 상단 타이틀 -->
            <div class="dday_wrap">
                <div class="dday_bot">Today is <span><?= $today; ?></span></div>
                <div class="dday_top"><span>D-<?= number_format($d_days); ?></span></div>
            </div>
            <div class="txt_wrap">
                <div class="title_wrap">
                    <h1>
                        <!--<?= $info['event_title'] ?>-->ISCP 2023<br /><span class="green_t"><span class="light">with</span> KSCVP <span class="light">&</span> KSCP
                    </h1></span>
                </div>
                <p class="event_name">

                    28<sup class="event_name_sup" style="color:#6a1515;font-weight:500">th</sup> International Society
                    <br />of Cardiovascular Pharmacotherapy
                    <br />Annual Scientific Meeting

                    <!--<b>T</b>he <b>c</b>onference <b>f</b>ormat (Face-to-face or online) <b>w</b>ill <b>b</b>e <b>a</b>nnounced <b>b</b>efore <b>l</b>ong <b>i</b>n<br class="responsive_br"/><b>c</b>onsideration <b>o</b>f <b>t</b>he <b>C</b>OVID 19 <b>s</b>ituation. <b>P</b>lease <b>c</b>heck <b>o</b>ur <b>w</b>ebsite <b>r</b>egularly.-->
                </p>
                <p class="event_hold">
                    <?php
                    $date_start = date_create($info['period_event_start']);
                    $date_end = date_create($info['period_event_end']);

                    $format_start = "M d(D)";
                    $format_end = "d(D), Y";

                    if (date_format($date_start, 'Y') != date_format($date_end, 'Y')) {
                        $format_start = "M d(D), Y";
                        $format_end = "M d(D), Y";
                    } else if (date_format($date_start, 'F') != date_format($date_end, 'F')) {
                        $format_end = "M d(D), Y";
                    }

                    $date_text = date_format($date_start, $format_start) . "~" . date_format($date_end, $format_end);
                    $venue_text = $info['venue_name'];
                    ?>
                    <!-- <?= $date_text ?>&nbsp;/&nbsp;<?= $venue_text ?> -->
                    <span class="event_date">CONRAD Seoul, Korea <br />
                        <span class="event_place">23-25<sup class="event_name_sup" style="color:#003250;font-weight:500">th</sup> November
                            2023</span>

                </p>
                <!-- <p class="event_msg">* This congress will be an on-site event in Seoul, Republic of Korea.</p> -->
                <!-- 
				<p class="sub_section_title main_theme"><?= $locale("theme_txt") ?></p>
				<div class="clearfix2">
					<div class="live_btn">
						<p class="live_tit">Connecting to Live Platform</p>
						<p class="onair_btn w1024"> ON-AIR <span>Technical Support - Tel. +82-2-2039-7802,  +82-2-6959-4868, +82-2-3275-3028</span></p>
						<p class="sub_section_title main_theme liveenter_btn">Enter</p>
					</div>
				</div>
				-->
                <div class="main_btn_wrap">
                    <!-- <button type="button" class="btn_register_now" onClick="javascript:alert('Coming soon.');">Register Now</button> -->
                    <button type="button" class="btn_circle_arrow"></button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Plenary Speakers -->
<div class="speakers_wrap">
    <div class="container">
        <div class="noti_wrap">
            <!-- <div class="container"> -->
            <div class="dates_area">
                <h1 class="noti_wrap_title">ISCP 2023</h1>
                <!-- <img class="iscp-main-img" src="./img/home_05.png"> -->
                <div class="main-home-img">
                    <a href="/main/registration_guidelines.php">
                        <img src="/main/img/home_05_01.png" />

                    </a>
                    <a href="/main/submission_guideline.php">

                        <img src="/main/img/home_05_02.png" />
                    </a>
                    <a href="/main/presentation_guidelines.php">

                        <img src="/main/img/home_05_03.png" />
                    </a>
                    <a href="/main/program_glance.php">

                        <img src="/main/img/home_05_04.png" />
                    </a>
                </div>
            </div>
            <div class="dates_area">
                <h1 class="noti_wrap_title">Plenary Speakers</h1>
                <div class="speakers_slick" style="background-color: #043858;">
                    <ul class="main_speaker2 slick-slider">
                        <li class="index_speaker1" style="background-color: #043858; width:100px;">
                            <div class="profile_circle">
                                <div class="profile_wrap"></div>
                            </div>
                            <h5 class="title" style="font-weight:500">Haluzik_Martin</h5>
                            <!-- <div class="career">Verve therapeutics,<br>USA</div> -->
                        </li>
                        <li class="index_speaker2" style="background-color: #043858; width:100px;">
                            <div class="profile_circle">
                                <div class="profile_wrap"></div>
                            </div>
                            <h5 class="title" style="font-weight:500; font-size:14px;">Thomas-Kahan</h5>
                            <!-- <div class="career">Macau University of Science &<br>Technology, China</div> -->
                        </li>
                        <li class="index_speaker3" style="background-color: #043858; width:100px;">
                            <div class="profile_circle">
                                <div class="profile_wrap"></div>
                            </div>
                            <h5 class="title" style="font-weight:500">TBD</h5>
                            <!-- <div class="career">University of Cambridge,<br>UK</div> -->
                        </li>
                        <li class="index_speaker4" style="background-color: #043858; width:100px;">
                            <div class="profile_circle">
                                <div class="profile_wrap"></div>
                            </div>
                            <h5 class="title" style="font-weight:500;">TBD</h5>
                            <!-- <div class="career">Regeneron Pharmaceuticals,<br>USA</div> -->
                        </li>
                        <!-- <li class="index_speaker5">
                            <div class="profile_circle">
                                <div class="profile_wrap"></div>
                            </div>
                            <h5 class="title" style="font-weight:500">TBD</h5> -->
                        <!-- <div class="career">National Center for Geriatrics<br>and Gerontology, Japan</div> -->
                        <!-- </li>
                        <li class="index_speaker6">
                            <div class="profile_circle">
                                <div class="profile_wrap"></div>
                            </div>
                            <h5 class="title" style="font-weight:500">TBD</h5> -->
                        <!-- <div class="career">University of the Philippines,<br>Philippines</div> -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Key dates & News,Notice -->
    <section>
        <div class="container">
            <div class="noti_wrap">
                <div class="dates_area">
                    <h1 class="noti_wrap_title">Important Period</h1>
                    <ul class="main_noti_period">
                        <li class="noti_li">
                            <a href="/main/submission_guideline.php">
                                <p>Early Bird<br />Registration</p>
                                <h2>OCT 27<sup style="color:#fff;font-weight: bold;">Fri</sup></h2>
                                <!-- <i><img src="/main/img/icons/icon_report.svg" alt=""></i> -->
                            </a>
                        </li>
                        <li class="noti_li">
                            <a href="/main/submission_guideline.php">
                                <p>Abstract<br />Submission</p>
                                <h2>SEP 05<sup style="color:#fff;font-weight: bold;">Tue</sup></h2>
                                <!-- <i><img src="/main/img/icons/icon_letter.svg" alt=""></i> -->
                            </a>
                        </li>
                        <li class="noti_li">
                            <a href="/main/registration_guidelines.php">
                                <p>Notification<br />of acceptance</p>
                                <h2>OCT 06<sup style="color:#fff;font-weight: bold;">Fri</sup></h2>
                                <!-- <i><img src="/main/img/icons/icon_calendar.svg" alt=""></i> -->
                            </a>
                        </li>
                        <!-- <li>
                        <a href="/main/registration_guidelines.php">
                            <h2>26 August</h2>
                            <i><img src="/main/img/icons/icon_paper.svg" alt=""></i>
                            <p>Pre-Registration<br />Deadline</p>
                        </a>
                    </li> -->
                    </ul>
                </div>
                <div class="noti_area">
                    <h1 class="noti_wrap_title">News & Notice</h1>
                    <ul>
                        <!-- <li class="nodata">ISCP 2023 with APSAVD Website is Open!!</li> -->

                        <?php
                        $num = 1;
                        foreach ($notice_list as $list) {
                            echo '<li><a href="/main/board_notice_detail.php?num=' . $num . '&no=' . $list['idx'] . '&p=1"><p>' . $list['title_en'] . '</p><span>' . $list['date_ymd'] . '</span></a></li>';
                            $num++;
                        }
                        ?>

                        <!-- <li><a href="javascript:;"><p>[Vol. 3] ISCP 2023 with APSAVD Demo page Open</p><span>2022.02.18</span></a></li> -->
                        <!-- <li><a href="javascript:;"><p>[Vol. 3] ISCP 2023 with APSAVD Demo page Open</p><span>2022.02.18</span></a></li> -->
                        <!-- <li><a href="javascript:;"><p>[Vol. 3] ISCP 2023 with APSAVD Demo page Open</p><span>2022.02.18</span></a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- <div class="footer-msg-box">
    <div class="footer-text-box">
        <h1>28th ISCP Annual Scientific Meeting, Seoul, S. Korea<br>
            Conjunction with KSCP and KSCVP meeting
        </h1>
    </div>
    <div class="footer-text-box">
        <p>
            It is our great privilege and pleasure to cordially invite all of you to our upcoming 28th
            ISCP 2023 Seoul.<br>
            This ISCP 2023 Seoul will be held in Conrad Seoul, S. Korea, from 23 November to 25 November 2023.<br>
            The great event is jointly organized by ISCP (International Society of Cardiovascular Pharmacotherapy),
            KSCVP (Korean Society of Cardiovascular Pharmacotherapy),<br>
            and KSCP (Korean Society of Cardiovascular Disease Prevention) When we look back on the past, we have
            faced the toughest challenges in the moment<br>
            of COVID19 since 2020. However, while we fight against the COVID19, we are not only becoming stronger
            but more resilient<br>
            The organizing committee has decided to hold ISCP 2023 Seoul in a hybrid format both in-person and
            online meetings.<br>
            ISCP 2023 Seoul will provide key insight, practice-changing updates, and cutting-edge educational
            content with outstanding world-class professionals. <br>
            It brings together key stakeholders in all areas of cardiovascular pharmacotherapies, cardiovascular
            disease prevention, and better patient care. It is our pride,<br>
            privilege, and pleasure to keep highly educational communications transpiring through ISCP 2023 Seoul.
        </p>
        <p>
            As the hosting co-president of ISCP 2023 Seoul, we eagerly anticipate this meeting to be the greatest
            academic experience you’ve ever had the pleasure to take part in.<br>
            We would like to express my sincerest gratitude to all of your attendance and continued support. We look
            forward to seeing you all at ISCP 2023 Seoul in November 2023.<br>
            Thank you all very much.

        </p>
    </div>
    <div class="footer-img-box">
        <div>
            <div class="footer-first-img">
            </div>
            <div>
                <p>Sang Hong Baek, MD, PhD<br>
                    President-elect, ISCP</p>
            </div>
        </div>
        <div>
            <div class="footer-second-img"></div>
            <div>
                <p>Young Keun On, MD, PhD<br>
                    Governor, ISCP<br>
                    President, Korean Society of<br>
                    Cardiovascular Pharmacotherapy</p>
            </div>
        </div>
        <div>
            <div class="footer-third-img"></div>
            <div>
                <p>Won-Young Lee, MD, PhD<br>
                    President, Korean Society of<br>
                    Cardiovascular Disease Prevention</p>
            </div>
        </div>
    </div>

</div> -->
<!-- fixed_btn : register > 실제 등록 가능기간이기 전까지 주석처리 ()
<button type="button" class="btn_fixed_triangle"><span>Register<br>Now</span></button>-->
<!-- page loading bar 주석-->
<div class="page_loading">
    <video id="vid_auto" preload="auto" muted="muted" volume="0" playsinline autoplay onended="myFunction()"></video>
</div>
<!--
<div class="popup notification_pop" style="display:block;">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<div class="title_box">
			Notification of Acceptance
		</div>
		<div class="inner">
			<p>Please check the Notification of Acceptance for Oral Presentations,<br/>Moderated Poster Presentations and Poster Exhibitions.</p>
			<ul>
				<li><button type="button" onClick="javascript:window.open('/main/download/ICoLA2022_main_Oral_0907.pdf');">Oral Presentation List<img src="/main/img/icons/transparent_arrow.png" alt=""></button></li>
				<li><button type="button" onClick="javascript:window.open('/main/download/ICoLA2022_main_Moderated_0907.pdf');">Moderated Poster Presentation List<img src="/main/img/icons/transparent_arrow.png" alt=""></button></button></li>
				<li><button type="button" onClick="javascript:window.open('/main/download/ICoLA2022_main_poster_exhibition_0908.pdf');">Poster Exhibition List<img src="/main/img/icons/transparent_arrow.png" alt=""></button></button></li>
			</ul>
		</div>
		<div class="close_area clearfix2">
			<div>
				<input type="checkbox" id="today_check1" class="checkbox input required">
				<label for="today_check1">Do not open this window for 24 hours.</label>
			</div>
			<a href="javascript:;" class="pop_close">Close <img src="/main/img/main_pop_close.png" alt=""></a>
		</div>	
	</div>
</div>
-->
<!--
<div class="popup travel_grant_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<div class="travel_title">
			Travel Grant for Korean
		</div>
		<div>
			<p>We are pleased to announce that the ISCP 2023 organizing<br/>Committee will oﬀer travel grants to domestic participants.</p>
			<h1><img src="./img/travel_icon.svg" alt=""><span>Who can apply?</span></h1>
			<p class="travel_p">MD</p>
			<ul>
				<li>Medical Doctors</li>
				<li>Presenters who submit abstract(s) to ISCP 2023</li>
				<li>Participants outside of Seoul / Incheon / Gyeonggi</li>
				<li>KSoLA Member</li>
			</ul>
			<p class="travel_p">Non MD</p>
			<ul>
				<li>Nurse, Dietitian/Nutritionist, Pharmacist, Others</li>
				<li>Presenters who submit abstract(s) to ISCP 2023</li>
				<li>Participants outside of Seoul/Incheon/Gyeonggi</li>
				<li>KSoLA Member & Associate Member </li>
			</ul>
			<button type="button" class="main_pop_btn" onClick="javascript:window.open('https://iscp2023.org/main/board_notice_detail.php?num=4&no=21&p=1')">See more Travel Grant for Korean<img src="/main/img/travel_pointer.png" alt=""></button>
		</div>
		<div class="close_area clearfix2">
			<div>
				<input type="checkbox" id="today_check" class="checkbox input required">
				<label for="today_check">Do not open this window for 24 hours.</label>
			</div>
			<a href="javascript:;" class="pop_close">(X) Close</a>
		</div>	
	</div>
</div>

초록 접수마감
<div class="popup deadline_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<img src="/main/img/deadline_logo.png" alt="">
		<div class="inner">
			<div>
				<h1>Abstract Submission<br/>Deadline Extended to</h1>
				<p>30 June (Thu), 2022</p>
				<button type="button" class="main_pop_btn" onClick="javascript:window.open('/main/submission_guideline.php')">Abstract Submission<img src="/main/img/travel_pointer.png" alt=""></button>
			</div>
		</div>
		<div class="close_area clearfix2">
			<div>
				<input type="checkbox" id="today_check" class="checkbox input required">
				<label for="today_check">Do not open this window for 24 hours.</label>
			</div>
			<a href="javascript:;" class="pop_close">Close <img src="/main/img/main_pop_close.png" alt=""></a>
		</div>	
	</div>
</div>
-->
<!-- 등록 연장 팝업
<div class="popup deadline_pop extension">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<img src="./img/deadline_logo.png" alt="">
		<div class="inner">
			<div>
				<h1>The deadline for pre-registration<br/>has been extended to</h1>
				<p>August 26(Fri)</p>
				<button type="button" class="main_pop_btn" onClick="javascript:window.open('/main/registration_guidelines.php')">Register Now<img src="./img/travel_pointer.png" alt=""></button>			
			</div>
		</div>
		<div class="close_area clearfix2">
			<div>
				<input type="checkbox" id="today_check" class="checkbox input required">
				<label for="today_check">Do not open this window for 24 hours.</label>
			</div>
			<a href="javascript:;" class="pop_close">Close <img src="./img/main_pop_close.png" alt=""></a>
		</div>	
	</div>
</div>
-->
<!-- 2023 팝업 -->
<div class="popup pop_2023" style="display:none;">
    <div class="pop_bg"></div>
    <div class="pop_contents">
        <img src="/main/img/pop_2023_bg.png" class="bg" alt="">
        <img src="/main/img/pop_2023_line.png" class="line" alt="">
        <div class="pop_text_box">
            <h1>
                <p>See you on the next</p>
                <!-- <p>ICoLA 2023</p> -->
                <p>Seoul, Korea</p>
            </h1>
            <div class="btns" style="padding-top: 20px;">
                <button>September 14(Thu) - 16(Sat), 2023</button>
            </div>
        </div>
        <div class="close_area clearfix2">
            <div>
                <input type="checkbox" id="today_check" class="checkbox input required">
                <label for="today_check">Do not open this window for 24 hours.</label>
            </div>
            <a href="javascript:;" class="">Close <img src="/main/img/main_pop_close.png" alt=""></a>
        </div>
    </div>
</div>

<script>
    // 오늘 하루만 보기

    // 쿠키 가져오기
    function getCookie(name) {
        var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return value ? value[2] : null;
    }

    console.log(getCookie("pop"))

    //쿠키가 존재하지 않으면 팝업창을 연다.
    if (getCookie("pop") == null) {
        //		$('.pop_2023').show();
        $('.travel_grant_pop').show();
        $('.deadline_pop').show();
        $('.notification_pop').show();
    } else {
        //		$('.pop_2023').hide();
        $('.travel_grant_pop').hide();
        $('.deadline_pop').hide();
        $('.notification_pop').hide();
    }

    $('.pop_2023 .close_area a, .travel_grant_pop .pop_close, .deadline_pop .pop_close, .notification_pop .pop_close')
        .click(function() {
            if ($("#today_check, #today_check1").is(":checked")) {
                var toDate = new Date();
                setHeaderCookie("pop", "done", 1);

                console.log($("#today_check, #today_check1").is(":checked"))
            }
            $(this).parents(".popup").hide();
            //$('.travel_grant_pop, .deadline_pop, .notification_pop').hide();
        });
</script>

<script>
    $('document').ready(function() {
        $('.close_area a').click(function() {
            $(this).parents('.popup').hide();
        });
        $('body').addClass('main');

        $('.main_speaker2').slick({
            dots: false,
            navigation: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 6000,
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 850,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 0,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]

        });

        //bg slider
        var bg_slider = $('.main_bg_slider').slick({
            dots: false,
            infinite: true,
            slidesToShow: 1,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 10000
        });


        var vid = document.getElementById("main_video_bg");
        //vid.onended = function() {
        //	bg_slider.slick('slickNext');
        //};
        //on-air 버튼 깜빡이기
        //setInterval(function () {
        //$('.onair_btn').toggleClass('changed');
        //}, 700);

        // circle_arrow click이벤트
        var header_top = $("header.green_header").outerHeight();
        var speakers_top = $(".speakers_wrap").offset().top;
        var want_position = speakers_top - header_top;
        $(".btn_circle_arrow").click(function() {
            $("html, body").animate({
                scrollTop: want_position + "px"
            }, 500);
        });

    });

    $(function() {
        function load() {
            console.log('x')
        }
    })

    // 쿠키 헤더 생성
    function setHeaderCookie(name, value, hours, minute) {
        var todayDate = new Date();
        //var set_date = 24 - today.getHours();
        todayDate.setHours(todayDate.getHours() + (hours + 9));
        todayDate.setMinutes(todayDate.getMinutes() + minute);
        todayDate.setSeconds(0);

        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
    }

    // 쿠키 가져오기
    function getCookie(name) {
        var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return value ? value[2] : null;
    }


    //page loading bar 주석
    $('.live_btn, .live_btn2').click(function() {
        $('#vid_auto').html(
            '<source src="https://player.vimeo.com/external/595045789.hd.mp4?s=53cc26f55fa424c019f24192b49b06a165528174&profile_id=174">'
        );
        $('.page_loading').addClass('active');
    })

    function myFunction() {
        $('.page_loading').removeClass('active');
        window.location.href = '/main/live';
    }

    $(document).ready(function() {
        $(window).resize(function() {
            $(".main_bg_slider").slick("resize");
            $(".main_bg_slider").slick("refresh");
        })
        $(window).trigger("resize")
    });
</script>