<?php include_once($_SERVER["DOCUMENT_ROOT"]."/main/common/common.php");?>
<?php
	$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en"; 
	$member_idx = $_GET["idx"];

	if(!$member_idx) {
		echo "<script>alert('".($language == "en" ? "This is an abnormal access method." : "비정상적인 접근 입니다.")."'); window.location.href='/';</script>";
		exit;
	}

	$select_member_query =	"
								SELECT
									*
								FROM member
								WHERE idx = {$member_idx}
								AND is_deleted = 'N'
							";

	$select_member = sql_fetch($select_member_query);

	if(!$select_member["email_certified"] == "Y") {
		echo "<script>alert('".($language == "en" ? "You have already certified this account." : "이미 인증하신 계정입니다.")."'); window.location.href='/';";
		exit;
	}

	$update_member_query =	"
								UPDATE member
								SET
									email_certified = 'Y'
								WHERE idx = {$member_idx}
								AND is_deleted = 'N'
							";
							
	$update_member = sql_query($update_member_query);

	if(!$update_member) {
		echo "<script>alert('".($language == "en" ? "Email authentication failed." : "이메일 인증에 실패하였습니다.")."'); window.location.href='/';</script>";
		exit;
	}

	echo "<script>alert('".($language == "en" ? "Email authentication completed." : "이메일 인증이 완료되었습니다.")."'); window.location.href='./login.php';</script>";
?>