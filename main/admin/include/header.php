<header class="header clearfix hidden-print">
	<div class="login clearfix2">
		<ul class="clearfix ">
			<li class="logo"><a href="./member_list.php" ></a></li>
		</ul>
		<!-- 홍유진 수정 작업본 -->
		<ul class="clearfix menu ">
			<!-- <li><a href="https://ibooth.webeon.net/access"><img src="./img/icon_qr.png" alt=""></a></li> -->
			<li>
				<a href="javascript:;" class="setting_open"><img src="./img/icon_settings.png" alt=""></a>
				<div class="setting_toggle">
					<a href="./mypage.php"><img src="./img/icon_mypage.png" alt=""> 마이페이지</a>
					<a href="javascript:;" class="logout_btn"><img src="./img/icon_logout.png" alt=""> 로그아웃</a>
				</div>
			</li>
			<!-- 수정 전 작업본 -->
			<!-- <li><a href="./admin_detail.php?idx=<?=$admin_idx?>"><strong><?=$_SESSION["ADMIN"]["name"]?></strong>님</a></li>
			<li><a href="javascript:;" class="logout_btn">로그아웃</a></li> -->
		</ul>
	</div>
</header>
<nav class="nav">
	<ul>
		<li class="main_nav"><a href="javascript:;"><i class="la la-user"></i>회원관리<i class="la la-angle-down"></i></a>
			<ul class="sub_nav">
				<li class="member"><a href="./member_list.php">일반 회원</a></li>
				<li class="admin"><a href="./admin_list.php">관리자 회원</a></li>
			</ul>
		</li>
		<li class="main_nav"><a href="javascript:;"><i class="la la-list"></i>신청서관리<i class="la la-angle-down"></i></a>
			<ul class="sub_nav">
				<li class="apply_poster"><a href="./abstract_application_list.php">Poster Abstract Submission</a></li>
				<li class="apply_poster"><a href="./abstract_application_list2.php">Poster Abstract Submission 2</a></li>
				<!-- <li class="apply_lecture"><a href="./lecture_note_list.php">Lecture Note Submission</a></li> -->
				<li class="apply_registration"><a href="./registration_list.php">Registration</a></li>
				<li class="apply_sponsorship"><a href="./sponsorship_list.php">Sponsorship & Exhibition</a></li>
			</ul>
		</li>
		<!--<li class="main_nav"><a href="javascript:;"><i class="la la-file"></i>페이지관리<i class="la la-angle-down"></i></a>
			<ul class="sub_nav">
				<li class="page_event"><a href="./set_event.php">행사정보 관리</a></li>-->
				<!-- <li class="page_main"><a href="./set_main.php">메인페이지 관리</a></li> -->
				<!--<li class="page_general"><a href="./set_general.php">General Information 관리</a></li>
				<li class="page_poster"><a href="./set_poster.php">Poster Abstract Submission 관리</a></li>
				<li class="page_lecture"><a href="./set_lecture.php">Lecture Note Submission 관리</a></li>
				<li class="page_registration"><a href="./set_registration.php">Registration 관리</a></li>
				<li class="page_sponsorship"><a href="./sponsorship_overview.php">Sponsorship & Exhibition 관리</a></li>
			</ul>
		</li>-->
		<!--
		<li class="main_nav"><a href="javascript:;"><i class="la la-play"></i>라이브플랫폼관리<i class="la la-angle-down"></i></a>
			<ul class="sub_nav">
				<li class="live_popup"><a href="./manage_popup.php">팝업관리</a></li>
				<li class="live_lecture"><a href="./manage_lecture.php">Lecture 관리</a></li>
				<li class="live_lecture_qna"><a href="./manage_lectureQA_list.php">Lecture Q&A 관리</a></li>
				<li class="live_abstract"><a href="./manage_abstract_list.php">Abstract 관리</a></li>
				<li class="live_conference"><a href="./manage_conference.php">Conference Program Book 관리</a></li>
				<li class="live_ebooth"><a href="./manage_eBooth.php">E-Booth 관리</a></li> 
				<li class="live_event"><a href="./manage_event_luckyDraw.php">이벤트 관리</a></li>
			</ul>
		</li>
		-->
		<li class="main_nav"><a href="javascript:;"><i class="la la-clipboard"></i>게시판관리<i class="la la-angle-down"></i></a>
			<ul class="sub_nav">
				<!-- <li class="news"><a href="./board_list.php?t=0">News</a></li> -->
				<li class="notice"><a href="./board_list.php?t=1">News & Notice</a></li>
				<!-- <li class="faq"><a href="./board_category_list.php">FAQ</a></li> -->
			</ul>
		</li>
	</ul>
</nav>
<input type="hidden" name="auth_account_member" value="<?=$admin_permission["auth_account_member"]?>">
<input type="hidden" name="auth_account_admin" value="<?=$admin_permission["auth_account_admin"]?>">
<input type="hidden" name="auth_apply_poster" value="<?=$admin_permission["auth_apply_poster"]?>">
<input type="hidden" name="auth_apply_lecture" value="<?=$admin_permission["auth_apply_lecture"]?>">
<input type="hidden" name="auth_apply_registration" value="<?=$admin_permission["auth_apply_registration"]?>">
<input type="hidden" name="auth_apply_sponsorship" value="<?=$admin_permission["auth_apply_sponsorship"]?>">
<input type="hidden" name="auth_page_event" value="<?=$admin_permission["auth_page_event"]?>">
<input type="hidden" name="auth_page_main" value="<?=$admin_permission["auth_page_main"]?>">
<input type="hidden" name="auth_page_general" value="<?=$admin_permission["auth_page_general"]?>">
<input type="hidden" name="auth_page_poster" value="<?=$admin_permission["auth_page_poster"]?>">
<input type="hidden" name="auth_page_registration" value="<?=$admin_permission["auth_page_registration"]?>">
<input type="hidden" name="auth_page_sponsorship" value="<?=$admin_permission["auth_page_sponsorship"]?>">
<input type="hidden" name="auth_live_popup" value="<?=$admin_permission["auth_live_popup"]?>">
<input type="hidden" name="auth_live_lecture_qna" value="<?=$admin_permission["auth_live_lecture_qna"]?>">
<input type="hidden" name="auth_live_abstract" value="<?=$admin_permission["auth_live_abstract"]?>">
<input type="hidden" name="auth_live_conference" value="<?=$admin_permission["auth_live_conference"]?>">
<input type="hidden" name="auth_board_news" value="<?=$admin_permission["auth_board_news"]?>">
<input type="hidden" name="auth_board_notice" value="<?=$admin_permission["auth_board_notice"]?>">
<input type="hidden" name="auth_board_faq" value="<?=$admin_permission["auth_board_faq"]?>">

<script>
	$(".logout_btn").on("click", function(){
		$.ajax({
			url : "../ajax/admin/ajax_admin.php",
			type : "POST",
			data : {
				flag : "logout"
			},
			dataType : "JSON",
			success : function() {
					location.replace("./");
			},
			error : function() {
				alert("일시적으로 로그아웃 요청이 거절되었습니다.");
				return false;
			}
		});
	});

	$(document).ready(function(){
		var auth_account_member = $("input[name=auth_account_member]").val();
		var auth_account_admin = $("input[name=auth_account_admin]").val();
		var auth_apply_poster = $("input[name=auth_apply_poster]").val();
		var auth_apply_lecture = $("input[name=auth_apply_lecture]").val();
		var auth_apply_registration = $("input[name=auth_apply_registration]").val();
		var auth_apply_sponsorship = $("input[name=auth_apply_sponsorship]").val();
		var auth_page_event = $("input[name=auth_page_event]").val();
		var auth_page_main = $("input[name=auth_page_main]").val();
		var auth_page_general = $("input[name=auth_page_general]").val();
		var auth_page_poster = $("input[name=auth_page_poster]").val();
		var auth_page_lecture = $("input[name=auth_page_lecture]").val();
		var auth_page_registration = $("input[name=auth_page_registration]").val();
		var auth_page_sponsorship = $("input[name=auth_page_sponsorship]").val();
		var auth_live_popup = $("input[name=auth_live_popup]").val();
		var auth_live_lecture = $("input[name=auth_live_lecture]").val();
		var auth_live_lecture_qna = $("input[name=auth_live_lecture_qna]").val();
		var auth_live_abstract = $("input[name=auth_live_abstract]").val();
		var auth_live_conference = $("input[name=auth_live_conference]").val();
		var auth_live_event = $("input[name=auth_live_event]").val();
		var auth_board_news = $("input[name=auth_board_news]").val();
		var auth_board_notice = $("input[name=auth_board_notice]").val();
		var auth_board_faq = $("input[name=auth_board_faq]").val();
		
		if(auth_account_member == 0){
			$('nav li.member').hide();
		}
		if(auth_account_admin == 0){
			$('nav li.admin').hide();
		}

		if(auth_apply_poster == 0){
			$('nav li.apply_poster').hide();
		}
		if(auth_apply_lecture == 0){
			$('nav li.apply_lecture').hide();
		}
		if(auth_apply_registration == 0){
			$('nav li.apply_registration').hide();
		}
		if(auth_apply_sponsorship == 0){
			$('nav li.apply_sponsorship').hide();
		}

		if(auth_page_event == 0){
			$('nav li.page_event').hide();
		}
		if(auth_page_main == 0){
			$('nav li.page_main').hide();
		}
		if(auth_page_general == 0){
			$('nav li.page_general').hide();
		}
		if(auth_page_poster == 0){
			$('nav li.page_poster').hide();
		}
		if(auth_page_lecture == 0){
			$('nav li.page_lecture').hide();
		}
		if(auth_page_registration == 0){
			$('nav li.page_registration').hide();
		}
		if(auth_page_sponsorship == 0){
			$('nav li.page_sponsorship').hide();
		}

		if(auth_live_popup == 0){
			$('nav li.live_popup').hide();
		}
		if(auth_live_lecture == 0){
			$('nav li.live_lecture').hide();
		}
		if(auth_live_lecture_qna == 0){
			$('nav li.live_lecture_qna').hide();
		}
		if(auth_live_abstract == 0){
			$('nav li.live_abstract').hide();
		}
		if(auth_live_conference == 0){
			$('nav li.live_conference').hide();
		}
		if(auth_live_event == 0){
			$('nav li.live_event').hide();
		}

		if(auth_board_news == 0){
			$('nav li.news').hide();
		}
		if(auth_board_notice == 0){
			$('nav li.notice').hide();
		}
		if(auth_board_faq == 0){
			$('nav li.faq').hide();
		}
	});
</script>