<?php
	include_once("../common/common.php");

	$admin_idx = $_SESSION["ADMIN"]["idx"];
	$except_uri_list = ["/main/admin","/main/admin/"];
	$uri = $_SERVER["REQUEST_URI"];

	if($admin_idx == '' && !in_array($uri, $except_uri_list)){
		Header("Location:/main/admin");
		exit;
	}

	//어드민 권한정보 가져오는 쿼리
	$admin_permission_query = "SELECT
								auth_account_member,
								auth_account_admin,
								auth_apply_poster,
								auth_apply_lecture,
								auth_apply_registration,
								auth_apply_sponsorship,
								auth_page_event,
								auth_page_main,
								auth_page_general,
								auth_page_poster,
								auth_page_lecture,
								auth_page_registration,
								auth_page_sponsorship,
								auth_live_popup,
								auth_live_lecture,
								auth_live_lecture_qna,
								auth_live_abstract,
								auth_live_conference,
								auth_live_event,
								#auth_live_ebooth,
								auth_board_news,
								auth_board_notice,
								auth_board_faq
							FROM admin
							WHERE idx = {$admin_idx}";
	$admin_permission = sql_fetch($admin_permission_query);
?>
<!DOCTYPE HTML>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<title>ISCP - 관리자</title>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!--외부 라이브러리-->
	<link href="dist/css/datepicker.css" rel="stylesheet" type="text/css">	
	<link href="dist/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">	
	<link href="dist/css/line-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<!--common/style.css-->
	<link rel="stylesheet" href="./css/common.css">
	<link rel="stylesheet" href="./css/style.css">
	<!--외부 라이브러리-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="dist/js/datepicker.js"></script>	
	<script src="dist/js/i18n/datepicker.kr.js"></script>
	<script src="dist/js/jquery.dataTables.min.js"></script>
	<script src="dist/js/dataTables.bootstrap4.min.js"></script>
	<script src="dist/js/dataTables.buttons.min.js"></script>
	<script src="dist/js/custom-table-datatable.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>
<body>