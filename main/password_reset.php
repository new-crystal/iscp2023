<?php include_once($_SERVER["DOCUMENT_ROOT"]."/main/common/common.php");?>
<?php
	$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en"; 

	$email = $_GET["e"];
	$token = $_GET["t"];
	
	$select_member_query =	"
								SELECT
									idx, temporary_password
								FROM member
								WHERE temporary_password_token = '{$token}'
								AND email = '{$email}'
								AND is_deleted = 'N'
							";

	$select_member = sql_fetch($select_member_query);

	if(!$select_member["idx"]) {
		echo "<script>alert('".($language == "en" ? "This is an terminated access." : "만료된 접근 입니다.")."'); window.location.href='/';</script>";
		exit;
	}


	$update_member_query =	"
								UPDATE member
								SET
									password = '".$select_member["temporary_password"]."',
									temporary_password = NULL,
									temporary_password_token = NULL
								WHERE idx = ".$select_member["idx"]."
								AND is_deleted = 'N'
							";
							
	$update_member = sql_query($update_member_query);

	if(!$update_member) {
		echo "<script>alert('".($language == "en" ? "Failed to change password." : "비밀번호 변경에 실패하였습니다.")."'); window.location.href='/';</script>"; //언어 어떻게 할지 생각해야됨
		exit;
	}

	echo "<script>alert('".($language == "en" ? "Password change is complete." : "비밀번호가 변경되었습니다.")."'); window.location.href='./login.php';</script>";
?>