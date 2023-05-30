<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 팝업관리 - 영상 경로 저장
	if ($flag === "save_popup_url") {

		$sql =	"UPDATE info_live
				SET
					popup_video_url = '".$_POST['url']."'
				";

		if (sql_query($sql)) {
			$res = [
				code => 200,
				msg => "완료되었습니다."
			];
		} else {
			$res = [
				code => 500,
				msg => "오류가 발생했습니다.\n관리자에게 문의하세요"
			];
		}

		echo json_encode($res);
		exit;
	}

	// conference program book 관리
	else if ($flag === "save_conference_book") {

		//print_r($_FILES);

		// 파일업로드 및 유효성 검사
		$cb_en = 0;
		if($_FILES["cb_en"]){
			$file_type = explode("/", $_FILES["cb_en"]["type"])[1];

			if($file_type == "pdf") {
				$_FILES["cb_en"]["name"] = htmlspecialchars($_FILES["cb_en"]["name"], ENT_QUOTES);
				$file_no = upload_image($_FILES["cb_en"], 9);

				if ($file_no != "" && $file_no > 0) {
					$cb_en = $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "pdf 파일만 등록가능합니다.");
			}
		} else {
			return_value(403, "등록할 파일이 없습니다.");
		}

		$sql =	"UPDATE info_live
				SET
					conference_book_en_img = '".$cb_en."',
					modify_admin_idx = '".$_SESSION['ADMIN']['idx']."'
				";

		if (sql_query($sql)) {
			$res = [
				code => 200,
				msg => "완료되었습니다."
			];
		} else {
			$res = [
				code => 500,
				msg => "오류가 발생했습니다.\n관리자에게 문의하세요"
			];
		}

		echo json_encode($res);
		exit;
	}

	// 결과값 반환 공통화
	function return_value($code, $msg){
		echo json_encode(array(
			"code"=>$code,
			"msg" =>$msg
		));
		exit;
	}