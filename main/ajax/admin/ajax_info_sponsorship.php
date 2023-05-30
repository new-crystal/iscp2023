<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// overview 관리
	if ($flag === "save_overview") {

		$sql_origin =	"SELECT * FROM info_sponsorship";
		$origin = sql_fetch($sql_origin);

		// 파일업로드 및 유효성 검사
		$fi_sod = simple_file_upload($_FILES["fi_sod"], $origin['sponsorship_official_docs']);
		$fi_bl = simple_file_upload($_FILES["fi_bl"], $origin['business_license']);
		$fi_cob = simple_file_upload($_FILES["fi_cob"], $origin['copy_of_bankbook']);

		$sql =	"UPDATE info_sponsorship
				SET
					welcome_msg_en				= '".$_POST["welcome_msg_en"]."',
					welcome_msg_ko				= '".$_POST["welcome_msg_ko"]."',
					sponsorship_official_docs	= '".$fi_sod."',
					business_license			= '".$fi_bl."',
					copy_of_bankbook			= '".$fi_cob."',
					important_dates_en			= '".$_POST["important_dates_en"]."',
					important_dates_ko			= '".$_POST["important_dates_ko"]."',
					how_to_apply_en				= '".$_POST["how_to_apply_en"]."',
					how_to_apply_ko				= '".$_POST["how_to_apply_ko"]."',
					procedure_en				= '".$_POST["procedure_en"]."',
					procedure_ko				= '".$_POST["procedure_ko"]."',
					contact_info_en				= '".$_POST["contact_info_en"]."',
					contact_info_ko				= '".$_POST["contact_info_ko"]."',
					contact_for_sponsorship		= '".$_POST["contact_for_sponsorship"]."',
					modify_admin_idx			= '".$_SESSION['ADMIN']['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// sponsorship 관리
	else if ($flag === "save_sponsorship") {
		$price_arr = explode('^&', htmlspecialchars_decode($_POST['prices']));
		if (count($price_arr) > 0) {
			foreach($price_arr as $li){
				list($idx, $name_en, $name_ko, $price_usd, $price_krw) = explode('|', $li);

				$sql =	"UPDATE info_sponsorship_package 
						SET
							name_en = '".$name_en."', 
							name_ko = '".$name_ko."', 
							price_usd = '".$price_usd."', 
							price_krw = '".$price_krw."', 
							modify_date = NOW(), 
							modify_admin_idx = '".$_SESSION['ADMIN']['idx']."'
						WHERE idx = '".$idx."'";
				if (!sql_query($sql)) {
					return_value(500, "가격정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
				}
			}
		}

		return_value(200, "완료되었습니다.");
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
			$file_obj["name"] = htmlspecialchars($file_obj["name"], ENT_QUOTES);

			if($file_type == "image") {
				$file_no = upload_image($file_obj, 3);
			} else {
				$file_no = upload_file($file_obj, 3);
			}

			if ($file_no != "" && $file_no > 0) {
				return $file_no;
			} else {
				return_value(500, "파일업로드가 실패했습니다.");
			}
		} else {
			return $origin_val;
		}
	}