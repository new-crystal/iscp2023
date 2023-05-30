<?php
	$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
	$locale = locale($language);

	$_page_config = array(
		"m1" => [
			"welcome",
			"organizing_committee",
			"overview",
			"venue",
			"photo"
		],
		"m2" => [
			"program_glance",
			"program_detail",
			"invited_speaker"
		],
		"m3" => [
			"poster_abstract_submission",
			"abstract_submission",
			"abstract_submission2",
			"abstract_submission3",
			"eposter",
			"lecture_note_submission",
			"lecture_submission",
			"lecture_submission2",
			"lecture_submission3",
			"oral_presenters",
			"eposter_presenters"
		],
		"m4" => [
			"registration_guidelines",
			"registration",
			"registration2",
			"registration3"
		],
		"m5" => [
			"sponsor_information",
			"application",
			"application_complete"
		],
		"m6" => [
			"accommodation",
			"attraction_historic",
			"useful_information"
		]
	);

	$_page = str_replace(".php","",end(explode("/",$_SERVER["REQUEST_URI"])));
?>

<!-- 기존 header -->
<header class="" style="display: none;">
	<div class="container">
		<div class="top clearfix2">
			<h1 class="logo"><a href="./index.php"><img src="./img/logo_w.png"><img src="./img/logo.png"></a></h1>
			<div class="right_wrap clearfix2">
				<div class="clearfix">
					<div>
					<?php
						if($_SESSION["USER"]["idx"] == "") {
					?>
						<a class="btn white_border" href="./login.php"><?=$locale("login")?></a> 
						<a class="btn white_border" href="./signup.php"><?=$locale("signup")?></a> 
					<?php
						} else {	
					?>
						<a class="btn white_border" href="./mypage.php"><?=$locale("mypage")?></a> 
						<a class="btn white_border logout_btn" href="javascript:;"><?=$locale("logout_btn")?></a>
					<?php
						}	
					?>
					</div>
					<div class="has_left_bar toggle_wrap clearfix <?=$language == "en" ? "" : "left" ?>">
						<input type="hidden" id="language" value="<?=$language?>">
						<input type="radio" value="kor" name="language" id="kor" <?=($language == "ko" ? "checked" : "")?>>
						<label for="kor"><?=$locale("korean")?></label>
						<div class="toggle">
							<div class="toggle__pointer"></div>
						</div>
						<input type="radio" value="eng" name="language" id="eng" <?=($language != "ko" ? "checked" : "")?>>
						<label for="eng"><?=$locale("english")?></label>
					</div>
				</div>
				<div class="tablet_show">
					<button type="button" class="m_nav_btn"><img src="./img/icons/m_nav.png"></button>
				</div>
			</div>
		</div>
		<div class="nav_wrap pc_only">
			<div class="bar"></div>
			<ul class="depth01">
				<li class="<?=(in_array($_page, $_page_config["m1"]) ? "active" : "")?>">
					<a href="javascript:;"><span>General Information</span><!--<img src="./img/icons/nav_arrow.png">--></a>
					<ul class="sub_nav">
						<li><a href="./welcome.php">Welcome Message</a></li>
						<li><a href="./organizing_committee.php">Organizing Committee</a></li>
						<li><a href="./overview.php">Overview</a></li>
						<li><a href="./venue.php">Venue</a></li>
						<li><a href="./photo.php">Photo Gallery</a></li>
					</ul>
				</li>
				<li class="<?=(in_array($_page, $_page_config["m2"]) ? "active" : "")?>">
					<a href="javascript:;"><span>Program</span><!--<img src="./img/icons/nav_arrow.png">--></a>
					<ul class="sub_nav">
						<li><a href="./program_glance.php">Program at a glance</a></li>
						<li><a href="./program_detail.php">Program in Detail</a></li>
						<li><a href="./invited_speaker.php">Invited Speakers</a></li>
					</ul>
				</li>
				<li class="<?=(in_array($_page, $_page_config["m3"]) ? "active" : "")?>">
					<a href="javascript:;"><span>Call for Abstracts</span><!--<img src="./img/icons/nav_arrow.png">--></a>
					<ul class="sub_nav">
						<li><a href="poster_abstract_submission.php">Submission Guideline</a></li>
						<li><a href="lecture_note_submission.php">Lecture Abstract Guideline</a></li>
					</ul>
				</li>
				<li class="<?=(in_array($_page, $_page_config["m4"]) ? "active" : "")?>">
					<a href="javascript:;"><span>Registration</span><!--<img src="./img/icons/nav_arrow.png">--></a>
					<ul class="sub_nav">
						<li><a href="registration_guidelines.php">Guidelines</a></li>
						<li><a href="./registration.php">Online Registration</a></li>
					</ul>
				</li>
				<li class="<?=(in_array($_page, $_page_config["m5"]) ? "active" : "")?>">
					<a href="javascript:;"><span>Sponsorship & Exhibition</span><!--<img src="./img/icons/nav_arrow.png">--></a>
					<ul class="sub_nav">
						<li><a href="sponsor_information.php">Sponsor Information</a></li>
						<li><a href="application.php">Application</a></li>
					</ul>
				</li>
				<li class="<?=(in_array($_page, $_page_config["m6"]) ? "active" : "")?>">
					<a href="javascript:;"><span>Accommodations & Tour</span><!--<img src="./img/icons/nav_arrow.png">--></a>
					<ul class="sub_nav">
						<li><a href="accommodation.php">Hotel Accommodations</a></li>
						<li><a href="attraction_historic.php">Attractions in Seoul</a></li>
						<li><a href="useful_information.php">Useful Information</a></li>
					</ul>
				</li>
			</ul>
			
		</div>
	</div>
</header>
<div class="nav_dim" style="display: none;"></div>
<!-- 기존 header : 끝 -->


<!-- 모바일 메뉴박스 -->
<div class="m_nav_wrap">
	<!--
	<div class="toggle_wrap clearfix <?=$language == "en" ? "" : "left" ?>">
		<input type="radio" value="kor" name="m_language" id="m_kor" <?=($language == "ko" ? "checked" : "")?>>
		<label for="m_kor"><?=$locale("korean")?></label>
		<div class="toggle">
			<div class="toggle__pointer"></div>
		</div>
		<input type="radio" value="eng" name="m_language" id="m_eng" <?=($language != "ko" ? "checked" : "")?>>
		<label for="m_eng"><?=$locale("english")?></label>
	</div>
	-->
	<ul class="g_h_tool">
		<li><a href="./index.php">Home</a></li>
		<li><a href="./login.php">Login</a></li>
		<li><a href="./signup.php">Sign up</a></li>
	</ul>
	<button type="button" class="n_nav_close"><img src="./img/icons/m_nav_close.png"></button>
	<div class="m_nav">
		<ul class="m_nav_ul">
			<li class="m_nav_li">
				<a href="javascript:;" class="<?=(in_array($_page, $_page_config["m1"]) ? "show" : "")?>"><span>ISCP 2023</span> <img src="./img/icons/nav_arrow.png"></a>
				<ul class="m_sub_nav" style="display:<?=(in_array($_page, $_page_config["m1"]) ? "block" : "none")?>">
                    <li><a href="./welcome.php" class="page_complete">Welcome Message</a></li>
                    <li><a href="javascript:;">Organization</a></li><!--./organizing_committee.php-->
					<li><a href="javascript:;">Venue</a></li><!--./venue.php-->
                    <!-- 
					<li><a href="./overview.php">Overview</a></li> 
					<li><a href="./photo.php">Photo Gallery</a></li>
					-->
					<li><a href="javascript:;">Accomodation</a></li><!--./accommodation.php-->
					<li><a href="javascript:;">News & Notice</a></li>
				</ul>
			</li>
			<li class="m_nav_li">
				<a href="javascript:;" class="<?=(in_array($_page, $_page_config["m2"]) ? "show" : "")?>"><span>Program</span> <img src="./img/icons/nav_arrow.png"></a>
				<ul class="m_sub_nav" style="display:<?=(in_array($_page, $_page_config["m2"]) ? "block" : "none")?>">
					<li><a href="./program_glance.php" class="page_complete">Program at a glance</a></li>
					<!-- <li><a href="./program_detail.php">Program in Detail</a></li> -->
					<li><a href="./scientific_program.php" class="page_complete">Scientific Program</a></li>
					<li><a href="javascript:;">Invited Speakers</a></li><!--./invited_speaker.php-->
				</ul>
			</li>
			<li class="m_nav_li">
				<a href="javascript:;" class="<?=(in_array($_page, $_page_config["m3"]) ? "show" : "")?>"><span>Call for Abstracts</span> <img src="./img/icons/nav_arrow.png"></a>
				<ul class="m_sub_nav" style="display:<?=(in_array($_page, $_page_config["m3"]) ? "block" : "none")?>">
					<!--
					<li><a href="poster_abstract_submission.php">Submission Guideline</a></li>
					<li><a href="lecture_note_submission.php">Lecture Abstract Guideline</a></li>
					-->
					<li><a href="javascript:;">Abstract Submission</a></li>
					<li><a href="./lecture_note_submission.php" class="page_complete">Lecture Note Submission<br/>(Invited Speaker)</a></a></li>
					<li><a href="javascript:;">Presentation Guidelines</a></li>
				</ul>
			</li>
			<li class="m_nav_li" class="<?=(in_array($_page, $_page_config["m4"]) ? "show" : "")?>">
				<a href="javascript:;"><span>Registration</span> <img src="./img/icons/nav_arrow.png"></a>
				<ul class="m_sub_nav" style="display:<?=(in_array($_page, $_page_config["m4"]) ? "block" : "none")?>">
					<li><a href="javascript:;">Guidelines</a></li><!--./registration_guidelines.php-->
					<li><a href="./registration.php" class="page_complete">Online Registration</a></li>
				</ul>
			</li>
			<li class="m_nav_li" class="<?=(in_array($_page, $_page_config["m5"]) ? "show" : "")?>">
				<a href="javascript:;"><span>Sponsorship</span> <img src="./img/icons/nav_arrow.png"></a>
				<ul class="m_sub_nav" style="display:<?=(in_array($_page, $_page_config["m5"]) ? "block" : "none")?>">
					<li><a href="javascript:;">Sponsor Information</a></li><!--./sponsor_information.php-->
					<!-- <li><a href="application.php">Application</a></li> -->
				</ul>
			</li>
			<li class="m_nav_li" class="<?=(in_array($_page, $_page_config["m6"]) ? "show" : "")?>">
				<a href="javascript:;"><span>General Information</span> <img src="./img/icons/nav_arrow.png"></a>
				<ul class="m_sub_nav" style="display:<?=(in_array($_page, $_page_config["m6"]) ? "block" : "none")?>">
					<!-- <li><a href="accommodation.php">Hotel Accommodations</a></li> -->
					<li><a href="javascript:;">COVID 19 FAQs</a></li>
					<li><a href="javascript:;">About Korea</a></li>
					<li><a href="javascript:;">About Seoul</a></li><!--./attraction_historic.php-->
					<li><a href="javascript:;">Transportation</a></li>
					<li><a href="javascript:;">Useful Information</a></li><!--./useful_information.php-->
					<li><a href="javascript:;">Visa</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- 모바일 메뉴박스 : 끝 -->


<!-- 변경된 header (22.03.15 HUBDNC LJH2) -->
<header class="green_header">
	<div class="g_h_top">
		<div class="container">
			<div class="dday_wrap">
				<div class="dday_top"><span>D-200</span></div>
				<div class="dday_bot">Today is <span>2022. 03. 03</span></div>
			</div>
			<div class="text_center g_h_logo"><img src="./img/footer_logo.png" alt="" class="pointer" onClick="javascript:location.href='./index.php'"></div>
			<ul class="g_h_tool">
				<li><a href="./index.php">Home</a></li>
				<li><a href="./login.php">Login</a></li>
				<li><a href="./signup.php">Sign up</a></li>
				<li><a href="javascript:;">Go to KSoLA</a></li>
			</ul>
			<div class="tablet_show">
				<button type="button" class="m_nav_btn"><img src="./img/icons/m_nav.png"></button>
			</div>
		</div>
	</div>
	<div class="g_h_bottom">
		<div class="container">
			<div class="nav_wrap pc_only">
				<ul class="depth01">
					<li class="<?=(in_array($_page, $_page_config["m1"]) ? "active" : "")?>">
						<a href="javascript:;"><span>ISCP 2023</span><!--<img src="./img/icons/nav_arrow.png">--></a>
						<ul class="sub_nav">
							<li><a href="./welcome.php" class="page_complete">Welcome Message</a></li><!--  -->
							<li><a href="javascript:;">Organization</a></li><!-- ./organizing_committee.php -->
							<li><a href="javascript:;">Venue</a></li><!-- ./venue.php -->
							<!--
							<li><a href="./overview.php">Overview</a></li> 
							<li><a href="./photo.php">Photo Gallery</a></li>
							-->
							<li><a href="javascript:;">Accomodation</a></li><!-- ./accommodation.php -->
							<li><a href="javascript:;">News & Notice</a></li>
						</ul>
					</li>
					<li class="<?=(in_array($_page, $_page_config["m2"]) ? "active" : "")?>">
						<a href="javascript:;"><span>Program</span><!--<img src="./img/icons/nav_arrow.png">--></a>
						<ul class="sub_nav">
							<li><a href="./program_glance.php" class="page_complete">Program at a glance</a></li><!--  -->
							<!-- <li><a href="./program_detail.php">Program in Detail</a></li> -->
							<li><a href="./scientific_program.php" class="page_complete">Scientific Program</a></li>
							<li><a href="javascript:;">Invited Speakers</a></li><!-- ./invited_speaker.php -->
						</ul>
					</li>
					<li class="<?=(in_array($_page, $_page_config["m3"]) ? "active" : "")?>">
						<a href="javascript:;"><span>Call for Abstracts</span><!--<img src="./img/icons/nav_arrow.png">--></a>
						<ul class="sub_nav">
							<!--
							<li><a href="poster_abstract_submission.php">Submission Guideline</a></li>
							<li><a href="lecture_note_submission.php">Lecture Abstract Guideline</a></li>
							-->
							<li><a href="javascript:;">Abstract Submission</a></li>
							<li><a href="./lecture_note_submission.php" class="page_complete">Lecture Note Submission<br/>(Invited Speaker)</a></li>
							<li><a href="javascript:;">Presentation Guidelines</a></li>
						</ul>
					</li>
					<li class="<?=(in_array($_page, $_page_config["m4"]) ? "active" : "")?>">
						<a href="javascript:;"><span>Registration</span><!--<img src="./img/icons/nav_arrow.png">--></a>
						<ul class="sub_nav">
							<li><a href="javascript:;">Guidelines</a></li><!-- registration_guidelines.php -->
							<li><a href="./registration.php" class="page_complete">Online Registration</a></li>
						</ul>
					</li>
					<li class="<?=(in_array($_page, $_page_config["m5"]) ? "active" : "")?>">
						<a href="javascript:;"><span>Sponsorship</span><!--<img src="./img/icons/nav_arrow.png">--></a>
						<ul class="sub_nav">
							<li><a href="javascript:;">Sponsor Information</a></li> <!-- sponsor_information.php -->
							<!-- <li><a href="application.php">Application</a></li> -->
						</ul>
					</li>
					<li class="<?=(in_array($_page, $_page_config["m6"]) ? "active" : "")?>">
						<a href="javascript:;"><span>General Information</span><!--<img src="./img/icons/nav_arrow.png">--></a>
						<ul class="sub_nav">
							<!-- <li><a href="accommodation.php">Hotel Accommodations</a></li> -->
							<li><a href="javascript:;">COVID 19 FAQs</a></li>
							<li><a href="javascript:;">About Korea</a></li>
							<li><a href="javascript:;">About Seoul</a></li><!-- attraction_historic.php -->
							<li><a href="javascript:;">Transportation</a></li>
							<li><a href="javascript:;">Useful Information</a></li><!-- useful_information.php -->
							<li><a href="javascript:;">Visa</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--
	<div class="top clearfix2">
		<h1 class="logo"><a href="./index.php"><img src="./img/logo_w.png"><img src="./img/logo.png"></a></h1>
		<div class="right_wrap clearfix2">
			<div class="clearfix">
				<div>
				<?php
					if($_SESSION["USER"]["idx"] == "") {
				?>
					<a class="btn white_border" href="./login.php"><?=$locale("login")?></a> 
					<a class="btn white_border" href="./signup.php"><?=$locale("signup")?></a> 
				<?php
					} else {	
				?>
					<a class="btn white_border" href="./mypage.php"><?=$locale("mypage")?></a> 
					<a class="btn white_border logout_btn" href="javascript:;"><?=$locale("logout_btn")?></a>
				<?php
					}	
				?>
				</div>
				<div class="has_left_bar toggle_wrap clearfix <?=$language == "en" ? "" : "left" ?>">
					<input type="hidden" id="language" value="<?=$language?>">
					<input type="radio" value="kor" name="language" id="kor" <?=($language == "ko" ? "checked" : "")?>>
					<label for="kor"><?=$locale("korean")?></label>
					<div class="toggle">
						<div class="toggle__pointer"></div>
					</div>
					<input type="radio" value="eng" name="language" id="eng" <?=($language != "ko" ? "checked" : "")?>>
					<label for="eng"><?=$locale("english")?></label>
				</div>
			</div>
			<div class="tablet_show">
				<button type="button" class="m_nav_btn"><img src="./img/icons/m_nav.png"></button>
			</div>
		</div>
	</div>
	-->
</header>
<!-- 변경된 header : 끝 -->


<script>
$(document).ready(function(){
	$("header .depth01 li ul li a, .m_sub_nav li a").click(function(){
		if (!$(this).hasClass("page_complete")){
			alert("Comming Soon.")
		}
	});
	$(".logout_btn").on("click", function(){
		$.ajax({
			url : PATH+"ajax/client/ajax_member.php",
			type : "GET",
			data : {
				flag : "logout"
			},
			dataType : "JSON",
			success : function(){
				window.location.replace(PATH);
			},
			error : function(){
				alert("일시적으로 로그아웃 요청이 거절되었습니다.");
			}
		});
	});
});
</script>