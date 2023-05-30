<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 카테고리 - 생성
	if ($flag === "add_category") {

		$sql =	"INSERT INTO
					lecture_category
					(title_en)
				VALUES
					('".$_POST['title_en']."')
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 카테고리 - 삭제
	else if ($flag === "remove_category") {

		// 등록된 강의가 있는 경우 삭제할 수 없음
		$sql_lecture =	"SELECT
							COUNT(idx) AS cnt
						FROM lecture
						WHERE category_idx = '".$_POST['idx']."'";
		$use_count = sql_fetch($sql_lecture)['cnt'];
		if ($use_count > 0) {
			return_value(403, "사용중인 Category는 삭제가 불가능합니다.");
		}

		$sql =	"UPDATE lecture_category
				SET
					is_deleted = 'Y',
					delete_date = NOW()
				WHERE idx = '".$_POST['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 강의실 - 생성
	else if ($flag === "add_place") {

		$sql =	"INSERT INTO
					lecture_place
					(title_en)
				VALUES
					('".$_POST['title_en']."')
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 강의실 - 수정
	else if ($flag === "modify_place") {

		$sql =	"UPDATE lecture_place
				SET
					url = '".$_POST['url']."'
				WHERE idx = '".$_POST['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 강의실 - 삭제
	else if ($flag === "remove_place") {

		// 등록된 강의가 있는 경우 삭제할 수 없음
		$sql_lecture =	"SELECT
							COUNT(idx) AS cnt
						FROM lecture_place_use
						WHERE place_idx = '".$_POST['idx']."'";
		$use_count = sql_fetch($sql_lecture)['cnt'];
		if ($use_count > 0) {
			return_value(403, "사용중인 Place는 삭제가 불가능합니다.");
		}

		$sql =	"UPDATE lecture_place
				SET
					is_deleted = 'Y',
					delete_date = NOW()
				WHERE idx = '".$_POST['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 발표자 - 생성
	else if ($flag === "add_speaker") {

		//print_r($_FILES);

		// 파일업로드 및 유효성 검사
		$file_profile = 0;
		if($_FILES["file_speaker_profile"]){
			$file_type = explode("/", $_FILES["file_speaker_profile"]["type"])[0];

			if($file_type == "image") {
				$file_no = upload_image($_FILES["file_speaker_profile"], 8);

				if ($file_no != "") {
					$file_profile = $file_no;
				} else {
					return_value(500, "파일업로드가 실패했습니다.");
				}
			} else {
				return_value(403, "이미지만 등록가능합니다.");
			}
		}

		$sql =	"INSERT INTO
					lecture_speaker
					(name_en, affiliation_en, profile_img)
				VALUES
					('".$_POST['name_en']."', '".$_POST['affiliation_en']."', '".$file_profile."')
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 발표자 - 삭제
	else if ($flag === "remove_speaker") {

		// 등록된 강의가 있는 경우 삭제할 수 없음
		$sql_lecture =	"SELECT
							COUNT(idx) AS cnt
						FROM lecture_speaker_join
						WHERE speaker_idx = '".$_POST['idx']."'";
		$use_count = sql_fetch($sql_lecture)['cnt'];
		if ($use_count > 0) {
			return_value(403, "사용중인 Speaker는 삭제가 불가능합니다.");
		}

		$sql =	"UPDATE lecture_speaker
				SET
					is_deleted = 'Y',
					delete_date = NOW()
				WHERE idx = '".$_POST['idx']."'
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 수정(+생성)
	else if ($flag === "modify_lecture") {
		$lecture_idx = $_POST['idx'];

		// lecture
		if ($lecture_idx == "") {
			// 생성
			$sql =	"INSERT INTO
						lecture
						(
							agenda_title_en, theme_en, category_idx, period_time_start, period_time_end,
							panel_name_en, panel_affiliation_en, speaker_period_en, speaker_subject_en, speaker_name_en, speaker_affiliation_en, speaker_img_path, speaker_pdf_path
						)
					VALUES
						(
							'".$_POST['title_en']."', '".$_POST['theme_en']."', '".$_POST['category']."', '".$_POST['start']."', '".$_POST['end']."', 
							'','','','','','','',''
						)
					";
			if (!sql_query($sql)) {
				return_value(500, "Lecture 등록 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
			} else {
				$lecture_idx = sql_insert_id();
			}
		} else {
			// 수정
			$sql =	"UPDATE lecture
					SET
						agenda_title_en		= '".$_POST['title_en']."',
						theme_en			= '".$_POST['theme_en']."',
						category_idx		= '".$_POST['category']."',
						period_time_start	= '".$_POST['start']."',
						period_time_end		= '".$_POST['end']."'
					WHERE idx = '".$lecture_idx."'";
			if (!sql_query($sql)) {
				return_value(500, "Lecture 수정 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
			}
		}

		// place_use
		$li_place_arr = explode('^&', htmlspecialchars_decode($_POST['li_place_arr']));
		if (count($li_place_arr) > 0) {
			foreach($li_place_arr as $li){
				list($type, $idx, $val) = explode('|', $li);

				if ($type !== "") {
					if ($type == "insert") { // insert
						$sql =	"INSERT INTO
									lecture_place_use
									(lecture_idx, place_idx)
								VALUES
									('".$lecture_idx."', '".$val."')
								";
					} else { // delete
						$sql =	"DELETE FROM lecture_place_use
								WHERE idx = '".$idx."'";
					}
					if (!sql_query($sql)) {
						return_value(500, "Place 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
					}
				}
			}
		}

		// speaker_join
		$li_speaker_arr = explode('^&', htmlspecialchars_decode($_POST['li_speaker_arr']));
		if (count($li_speaker_arr) > 0) {
			foreach($li_speaker_arr as $li){
				list($type, $idx, $val) = explode('|', $li);

				if ($type !== "") {
					if ($type == "insert") { // insert
						$sql =	"INSERT INTO
									lecture_speaker_join
									(lecture_idx, speaker_idx)
								VALUES
									('".$lecture_idx."', '".$val."')
								";
					} else { // delete
						$sql =	"DELETE FROM lecture_speaker_join
								WHERE idx = '".$idx."'";
					}
					if (!sql_query($sql)) {
						return_value(500, "Speaker 정보 저장 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
					}
				}
			}
		}

		return_value(200, "완료되었습니다.", array("idx"=>$lecture_idx));
	}

	// 삭제
	else if ($flag === "remove_lecture") {
		$sql =	"UPDATE lecture
				SET
					is_deleted = 'Y',
					delete_date = NOW()
				WHERE idx = '".$_POST['idx']."'
				";
		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 질의 - 승인
	else if ($flag === "confirm_qna") {
		$sql =	"UPDATE lecture_qna
				SET
					confirm_yn = '".$_POST['status']."'
				";
		switch($_POST['status']){
			case "Y" :
				$sql .=	",
							confirm_date = NOW()
						";
				break;
			case "N" :
			case "R" :
				$sql .=	",
							confirm_date = NULL
						";
				break;
		}
		$sql .=	"WHERE idx = '".$_POST['idx']."'";
		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 질의 - 삭제
	else if ($flag === "remove_qna") {
		$sql =	"UPDATE lecture_qna
				SET
					is_deleted = 'Y',
					delete_date = NOW()
				WHERE place_idx = '".$_POST['idx']."'
				AND confirm_yn = 'Y'
				AND (
					register_date BETWEEN '".$_POST['start']."' AND '".$_POST['end']."'
				)
				";
		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 질의 - 강연자용 리스트
	else if ($flag === "get_qna_for_speaker") {
		// qna
		$sql_qna =	"SELECT
						lq.idx,
						lq.question
					FROM lecture_qna AS lq
					LEFT JOIN member AS mb
						ON mb.idx = lq.member_idx
					WHERE lq.is_deleted = 'N'
					AND lq.place_idx = '".$_POST['idx']."'
					AND lq.confirm_yn = 'Y'
					ORDER BY lq.confirm_date ASC";
		$qnas = get_data($sql_qna);

		return_value(200, "완료되었습니다.", array("list"=>$qnas, "total_count"=>count($qnas)));
	}

	// 결과값 반환 공통화
	function return_value($code, $msg, $arr=array()){
		$arr["code"] = $code;
		$arr["msg"] = $msg;
		echo json_encode($arr);
		exit;
	}