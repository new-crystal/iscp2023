<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// venue 관리
	if ($flag === "save_registration") {

		$sql_origin =	"SELECT * FROM info_registration";
		$origin = sql_fetch($sql_origin);

		// 파일업로드 및 유효성 검사
		$fi_en = simple_file_upload($_FILES["fi_en"], $origin['score_pop_en_img']);
		$fi_ko = simple_file_upload($_FILES["fi_ko"], $origin['score_pop_ko_img']);

		$sql =	"UPDATE info_registration
				SET
					bank_name_en		= '".$_POST["bank_name_en"]."',
					account_number_en	= '".$_POST["account_number_en"]."',
					account_holder_en	= '".$_POST["account_holder_en"]."',
					address_en			= '".$_POST["address_en"]."',
					score_pop_en_img	= '".$fi_en."',
					bank_name_ko		= '".$_POST["bank_name_ko"]."',
					account_number_ko	= '".$_POST["account_number_ko"]."',
					account_holder_ko	= '".$_POST["account_holder_ko"]."',
					address_ko			= '".$_POST["address_ko"]."',
					score_pop_ko_img	= '".$fi_ko."',
					modify_admin_idx = '".$_SESSION['ADMIN']['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 결과값 반환 공통화
	function return_value($code, $msg, $arr=array()){
		$arr["code"] = $code;
		$arr["msg"] = $msg;
		echo json_encode($arr);
		exit;
	}

	// 파일 업로드 간소화
	function simple_file_upload($file_obj, $origin_val){
		if($file_obj){
			$file_type = explode("/", $file_obj["type"])[0];

			if($file_type == "image") {
				$file_obj["name"] = htmlspecialchars($file_obj["name"], ENT_QUOTES);
				$file_no = upload_image($file_obj, 12);

				if ($file_no != "" && $file_no > 0) {
					return $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "이미지 파일만 등록가능합니다.");
			}
		} else {
			return $origin_val;
		}
	}