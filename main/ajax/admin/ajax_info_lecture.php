<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// online submission
	if ($flag === "update_lecture") {
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

		$sql_info_poster = "UPDATE
								info_lecture
							SET
								note_msg_en					= '".$_POST['note_msg_en']."',
								formatting_guidelines_en	= '".$_POST['formatting_guidelines_en']."',
								how_to_modify_en			= '".$_POST['how_to_modify_en']."',
								note_msg_ko					= '".$_POST['note_msg_ko']."',
								formatting_guidelines_ko	= '".$_POST['formatting_guidelines_ko']."',
								how_to_modify_ko			= '".$_POST['how_to_modify_ko']."',
								modify_admin_idx			= '".$_SESSION['ADMIN']['idx']."'";
		if (!sql_query($sql_info_poster)) {
			return_value(500, "에디터 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
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