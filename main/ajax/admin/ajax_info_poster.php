<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// online submission
	if ($flag === "update_guideline") {
		//print_r($_POST); EXIT;

		// key date
		$key_date_arr = explode('^&', htmlspecialchars_decode($_POST['key_dates']));
		if (count($key_date_arr) > 0) {
			foreach($key_date_arr as $li){
				list($idx, $date, $contents_en, $contents_ko) = explode('|', $li);

				$sql_key_date =	"UPDATE
									key_date
								SET
									`key_date` = '".$date."',
									contents_en = '".$contents_en."',
									contents_ko = '".$contents_ko."'
								WHERE idx = '".$idx."'";

				if (!sql_query($sql_key_date)) {
					return_value(500, "Key Date 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
				}
			}
		}

		// info_poster
		$sql_origin = "SELECT * FROM info_poster";
		$origin = sql_fetch($sql_origin);

		$fi_templete = $origin['abstract_templete_img'];
		$file_obj = $_FILES['abstract_templete'];
		if($file_obj){
			$file_type = explode("/", $file_obj["type"])[0];

			$file_obj["name"] = htmlspecialchars($file_obj["name"], ENT_QUOTES);
			$fi_templete = upload_file($file_obj, 6);

			if ($fi_templete == "" || $fi_templete <= 0) {
				return_value(500, "파일업로드가 실패했습니다.");
			}
		}

		$sql_info_poster = "UPDATE
								info_poster
							SET
								welcome_msg_en			= '".$_POST['welcome_msg_en']."',
								welcome_msg_ko			= '".$_POST['welcome_msg_ko']."',
								abstract_templete_img	= '".$fi_templete."',
								presentation_type_en	= '".$_POST['presentation_type_en']."',
								presentation_type_ko	= '".$_POST['presentation_type_ko']."',
								contact_for_abstract	= '".$_POST['contact_for_abstract']."',
								modify_admin_idx		= '".$_SESSION['ADMIN']['idx']."'";
		if (!sql_query($sql_info_poster)) {
			return_value(500, "Message for abstract, ETC 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		}

		// instructions
		$inst_arr = explode('^&', htmlspecialchars_decode($_POST['instructions']));
		if (count($inst_arr) > 0) {
			foreach($inst_arr as $li){
				list($type, $idx, $title_ko, $title_en, $contents_ko, $contents_en) = explode('|', $li);

				if ($type !== "") {
					if ($type == "insert") { // insert
						$sql_instruction =	"INSERT INTO
												info_poster_instructions
												(title_ko, title_en, contents_ko, contents_en)
											VALUES
												('".$title_ko."', '".$title_en."', '".$contents_ko."', '".$contents_en."')";
					} else { // delete
						$sql_instruction =	"UPDATE
												info_poster_instructions
											SET
												is_deleted = 'Y',
												delete_date = NOW()
											WHERE idx = '".$idx."'";
					}
					if (!sql_query($sql_instruction)) {
						return_value(500, "Instructions 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
					}
				}
			}
		}

		$sql_topic = "";

		/*// abstract_topic
		$abto_arr = explode('^&', htmlspecialchars_decode($_POST['abstract_topics']));
		if (count($abto_arr) > 0) {
			foreach($abto_arr as $li){
				list($type, $idx, $title_ko, $title_en) = explode('|', $li);

				if ($type !== "") {
					if ($type == "insert") { // insert
						$sql_topic =	"INSERT INTO
											info_poster_abstract_topic
											(title_ko, title_en)
										VALUES
											('".$title_ko."', '".$title_en."')";
					} else { // delete
						$sql_topic =	"UPDATE
											info_poster_abstract_topic
										SET
											is_deleted = 'Y',
											delete_date = NOW()
										WHERE idx = '".$idx."'";
					}
					if (!sql_query($sql_topic)) {
						return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
					}
				}
			}
		}*/

		return_value(200, "완료되었습니다.");
	}

	// online submission
	else if ($flag === "update_online_submission") {
		$li_arr = explode('^&', htmlspecialchars_decode($_POST['li_arr']));

		if (count($li_arr) > 0) {
			foreach($li_arr as $li){
				list($type, $idx, $title_en, $title_ko, $prefix) = explode('|', $li);

				if ($type !== "") {
					if ($type == "insert") { // insert
						// prefix 중복체크
						$sql_dup =	"SELECT COUNT(idx) AS cnt FROM info_poster_abstract_category WHERE is_deleted = 'N' AND prefix = '".$prefix."'";
						if (sql_fetch($sql_dup)['cnt'] > 0) {
							return_value(500, "논문번호 앞 2글자는 중복될 수 없습니다.\n확인 후 재요청하세요.");
						}

						$sql =	"INSERT INTO
									info_poster_abstract_category
									(title_en, title_ko, prefix, register_admin_idx)
								VALUES
									('".$title_en."', '".$title_ko."', '".$prefix."', '".$_SESSION['ADMIN']['idx']."')
								";
					} else { // delete
						$sql =	"UPDATE
									info_poster_abstract_category
								SET
									is_deleted = 'Y',
									delete_date = NOW()
								WHERE idx = '".$idx."'";
					}
					if (!sql_query($sql)) {
						return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
					}
				}
			}
		}

		return_value(200, "완료되었습니다.");
	}

	// 결과값 반환 공통화
	function return_value($code, $msg){
		echo json_encode(array(
			"code"=>$code,
			"msg" =>$msg
		));
		exit;
	}