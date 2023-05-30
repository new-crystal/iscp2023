<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// overview 관리
	if ($flag === "save_overview") {
		//print_R($_POST);
		//print_R($_FILES);

		$sql_origin =	"SELECT * FROM info_general";
		$origin = sql_fetch($sql_origin);

		// overview
		$fi_poster_en = simple_file_upload_general($_FILES["fi_poster_en"], $origin['overview_poster_en_img']);
		$fi_wms_en = simple_file_upload_general($_FILES["fi_wms_en"], $origin['overview_welcome_sign_en_img']);
		$fi_poster_ko = simple_file_upload_general($_FILES["fi_poster_ko"], $origin['overview_poster_ko_img']);
		$fi_wms_ko = simple_file_upload_general($_FILES["fi_wms_ko"], $origin['overview_welcome_sign_ko_img']);

		$sql =	"UPDATE info_general
				SET
					overview_organized_en			= '".$_POST["organized_en"]."',
					overview_theme_en				= '".$_POST["theme_en"]."',
					overview_official_language_en	= '".$_POST["official_language_en"]."',
					overview_secretariat_en			= '".$_POST["secretariat_en"]."',
					overview_poster_en_img			= '".$fi_poster_en."',
					overview_welcome_msg_en			= '".$_POST["welcome_msg_en"]."',
					overview_welcome_sign_en_img	= '".$fi_wms_en."',
					overview_organized_ko			= '".$_POST["organized_ko"]."',
					overview_theme_ko				= '".$_POST["theme_ko"]."',
					overview_official_language_ko	= '".$_POST["official_language_ko"]."',
					overview_secretariat_ko			= '".$_POST["secretariat_ko"]."',
					overview_poster_ko_img			= '".$fi_poster_ko."',
					overview_welcome_msg_ko			= '".$_POST["welcome_msg_ko"]."',
					overview_welcome_sign_ko_img	= '".$fi_wms_ko."',
					modify_admin_idx = '".$_SESSION['ADMIN']['idx']."'
				";
		//echo "<pre>{$sql}</pre>";
		if (!sql_query($sql)) {
			return_value(500, "Overview 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		}

		// venue_floor
		$floor_arr = explode('^&', htmlspecialchars_decode($_POST['floors']));
		if (count($floor_arr) > 0) {
			foreach($floor_arr as $li){
				list($flag, $idx, $name_en, $name_ko) = explode('|', $li);

				if ($flag !== "") {
					if ($flag == "insert") { // insert
						$sql =	"INSERT INTO
									info_general_venue_floor
									(name_en, name_ko)
								VALUES
									('".$name_en."', '".$name_ko."')
								";

						if (!sql_query($sql)) {
							return_value(500, "Venue floor 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
						}

						$_POST['floor_imgs'] = str_replace($idx, sql_insert_id(), $_POST['floor_imgs']);
					} else { // delete
						$sql =	"UPDATE
									info_general_venue_floor
								SET
									is_deleted = 'Y',
									delete_date = NOW()
								WHERE idx = '".$idx."'";

						if (!sql_query($sql)) {
							return_value(500, "Venue floor 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
						}
					}

					//echo "<pre>{$flag}</pre>";
				}
			}
		}

		// venue_floor_img
		$floor_img_arr = explode('^&', htmlspecialchars_decode($_POST['floor_imgs']));
		if (count($floor_arr) > 0) {
			foreach($floor_img_arr as $li){
				list($flag, $idx, $floor_idx, $fi_idx) = explode('|', $li);

				if ($flag !== "") {
					if ($flag == "insert") { // insert
						$file_idx = simple_file_upload_general($_FILES["fi_".$fi_idx], 0);

						$sql =	"INSERT INTO
									info_general_venue_floor_img
									(floor_idx, img)
								VALUES
									('".$floor_idx."', '".$file_idx."')
								";
					} else { // delete
						$sql =	"UPDATE
									info_general_venue_floor_img
								SET
									is_deleted = 'Y',
									delete_date = NOW()
								WHERE idx = '".$idx."'";
					}

					if (!sql_query($sql)) {
						return_value(500, "Venue floor image 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
					}
				}
			}
		}

		return_value(200, "완료되었습니다.");
	}

	// committee 관리
	else if ($flag === "save_committee") {
		$en_arr = explode('^&', htmlspecialchars_decode($_POST['ens']));
		if (count($en_arr) > 0) {
			foreach($en_arr as $li){
				$sql = set_sql_committee("en", $li);
				if ($sql !== "" && !sql_query($sql)) {
					return_value(500, "소속원 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
				}
			}
		}

		$ko_arr = explode('^&', htmlspecialchars_decode($_POST['kos']));
		if (count($ko_arr) > 0) {
			foreach($ko_arr as $li){
				$sql = set_sql_committee("ko", $li);
				if ($sql !== "" && !sql_query($sql)) {
					return_value(500, "소속원 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
				}
			}
		}

		return_value(200, "완료되었습니다.");
	}

	// venue 관리
	else if ($flag === "save_venue") {

		$sql_origin =	"SELECT * FROM info_general_venue";
		$origin = sql_fetch($sql_origin);

		// 파일업로드 및 유효성 검사
		$fi_en = simple_file_upload_general($_FILES["fi_en"], $origin['en_img']);
		$fi_ko = simple_file_upload_general($_FILES["fi_ko"], $origin['ko_img']);

		$sql =	"UPDATE info_general_venue
				SET
					en_img		= '".$fi_en."',
					name_en		= '".$_POST["name_en"]."',
					address_en	= '".$_POST["address_en"]."',
					tel_en		= '".$_POST["tel_en"]."',
					homepage_en	= '".$_POST["homepage_en"]."',
					ko_img		= '".$fi_ko."',
					name_ko		= '".$_POST["name_ko"]."',
					address_ko	= '".$_POST["address_ko"]."',
					tel_ko		= '".$_POST["tel_ko"]."',
					homepage_ko	= '".$_POST["homepage_ko"]."',
					modify_admin_idx = '".$_SESSION['ADMIN']['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// photo - 저장
	else if ($flag === "save_photo") {
		$photo_arr = explode('^&', htmlspecialchars_decode($_POST['photoes']));
		if (count($photo_arr) > 0) {
			$fi_idx = 0;
			foreach($photo_arr as $li){
				$sql = "";

				list($flag, $idx) = explode('|', $li);

				if ($flag !== "") {
					if ($flag == "insert") { // insert

						$file_obj_col = 'fi_'.$fi_idx;
						$fi_idx++;

						$sql =	"INSERT INTO 
									photo_gallery 
									(year, img) 
								VALUES 
									('".$_POST['year']."', '".simple_file_upload_photo($_FILES[$file_obj_col])."')";
					} else { // delete
						$sql =	"UPDATE photo_gallery 
								SET
									is_deleted = 'Y', 
									delete_date = NOW()
								WHERE idx = '".$idx."'";
					}
				}

				if ($sql !== "" && !sql_query($sql)) {
					return_value(500, "처리 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
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

	// committee query 만들기
	function set_sql_committee($lang, $li){
		$sql = "";

		list($flag, $idx, $title, $name, $affiliation, $specialty) = explode('|', $li);

		if ($flag !== "") {
			if ($flag == "insert") { // insert
				$sql =	"INSERT INTO 
							info_general_commitee 
							(title_".$lang.", name_".$lang.", affiliation_".$lang.", specialty_".$lang.", register_admin_idx) 
						VALUES 
							('".$title."', '".$name."', '".$affiliation."', '".$specialty."', '".$_SESSION['ADMIN']['idx']."')";
			} else { // delete
				$sql =	"UPDATE info_general_commitee 
						SET
							is_deleted = 'Y', 
							delete_date = NOW()
						WHERE idx = '".$idx."'";
			}
		}

		return $sql;
	}

	// 파일 업로드 간소화(venue 탭)
	function simple_file_upload_general($file_obj, $origin_val){
		if($file_obj){
			$file_type = explode("/", $file_obj["type"])[0];

			if($file_type == "image") {
				$file_obj["name"] = htmlspecialchars($file_obj["name"], ENT_QUOTES);
				$file_no = upload_image($file_obj, 10);

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

	// 파일 업로드 간소화(photo gallery 탭)
	function simple_file_upload_photo($file_obj){
		if($file_obj){
			$file_type = explode("/", $file_obj["type"])[0];

			if($file_type == "image") {
				$file_obj["name"] = htmlspecialchars($file_obj["name"], ENT_QUOTES);
				$file_no = upload_image($file_obj, 11);

				if ($file_no != "" && $file_no > 0) {
					return $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "이미지 파일만 등록 가능합니다.");
			}
		} else {
			return_value(403, "등록할 파일이 존재하지 않습니다.");
		}
	}