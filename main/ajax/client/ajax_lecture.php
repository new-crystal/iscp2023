<?php
	include_once("../../common/common.php");
	include_once('../../common/lib/calc_score.lib.php');

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}

	// 진입
	if ($flag === "entrance") {
		if ($_POST['auto_exit'] == "Y") {
			$sql =	"SELECT
						MAX(idx) AS lately_entrance
					FROM lecture_view_log
					WHERE exit_date IS NULL
					AND member_idx = '".$_POST["member_idx"]."'";
			$exit_idx = sql_fetch($sql)['lately_entrance'];

			$sql_update =	"UPDATE lecture_view_log
							SET
								exit_date = NOW()
							WHERE idx = '".$exit_idx."'";
			if (!sql_query($sql_update)) {
				return_value(500, "자동 퇴실 처리 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
			}
		}

		$sql =	"INSERT INTO
					lecture_view_log
					(lecture_idx, place_idx, member_idx, entrance_date)
				VALUES
					('".$_POST['lecture_idx']."', '".$_POST['place_idx']."', '".$_POST["member_idx"]."', NOW())
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "입실 처리 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 퇴장
	else if ($flag === "exit") {
		$sql_idx =	"SELECT
						idx
					FROM lecture_view_log
					WHERE place_idx = '".$_POST['place_idx']."'
					AND member_idx = '".$_POST["member_idx"]."'
					#AND exit_date IS NULL
					ORDER BY idx DESC
					LIMIT 1";
		$idx = sql_fetch($sql_idx)['idx'];
		if (!$idx) {
			return_value(500, "종료 처리할 이력이 확인되지 않습니다.\n관리자에게 문의하세요.");
		}

		$time_diff = $_POST['time_diff'] == "" ? "Now" : $_POST['time_diff'];
		$exit_timestamp = date('Y-m-d H:i:s', strtotime($_POST['time_diff']));

		$sql_update =	"UPDATE lecture_view_log
						SET
							exit_date = '".$exit_timestamp."'
						WHERE idx = '".$idx."'";
		if (sql_query($sql_update)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 평점 공통 계산
	else if ($flag === "calc_score") {
		include_once("../../live/include/set_event_period.php");
		$res = calc_score($_PERIOD, $_SESSION['USER']['idx']);

		return_value(200, "완료되었습니다.", $res);
	}

	// 질의 - 리스트
	else if ($flag === "get_qna_list") {

		$where = "";

		$sql =	"SELECT
					lq.idx,
					lq.question,
					CONCAT(mb.first_name, ' ', mb.last_name) AS member_name,
					lq.confirm_yn,
					DATE_FORMAT(lq.register_date, '%y-%m-%d %H:%i') AS register_date
				FROM lecture_qna AS lq
				LEFT JOIN member AS mb
					ON mb.idx = lq.member_idx
				WHERE lq.is_deleted = 'N'
				AND lq.place_idx = '".$_POST['place_idx']."'
				AND lq.lecture_idx = '".$_POST['lecture_idx']."'
				AND lq.member_idx = '".$_POST["member_idx"]."'
				ORDER BY lq.register_date DESC
				".$where;
		$list = get_data($sql);

		return_value(200, "완료되었습니다.", array("list"=>$list, "total_count"=>count($list)));
	}

	// 질의 - 생성
	else if ($flag === "add_qna") {
		$sql =	"INSERT INTO
					lecture_qna
					(lecture_idx, place_idx, member_idx, question)
				VALUES
					('".$_POST['lecture_idx']."', '".$_POST['place_idx']."', '".$_POST["member_idx"]."', '".$_POST['question']."')
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 채팅 - 리스트
	else if ($flag === "get_chat_list") {
		//print_R($_POST);
		//print_R($_FILES);

		$where = "";

		$sql =	"SELECT
					lc.idx,
					CONCAT(mb.first_name, ' ', mb.last_name) AS member_name,
					lc.contents
				FROM lecture_chat AS lc
				LEFT JOIN member AS mb
					ON mb.idx = lc.member_idx
				WHERE lc.is_deleted = 'N'
				AND lc.place_idx = '".$_POST['place_idx']."'
				AND lc.lecture_idx = '".$_POST['lecture_idx']."'
				ORDER BY lc.register_date
				LIMIT 300
				";
		$list = get_data($sql);

		return_value(200, "완료되었습니다.", array("list"=>$list, "total_count"=>count($list)));
	}

	// 채팅 - 생성
	else if ($flag === "send_chat") {
		$sql =	"INSERT INTO
					lecture_chat
					(lecture_idx, place_idx, member_idx, contents)
				VALUES
					('".$_POST['lecture_idx']."', '".$_POST['place_idx']."', '".$_POST["member_idx"]."', '".$_POST['contents']."')
				";

		if (sql_query($sql)) {
			return_value(200, "완료되었습니다.");
		} else {
			return_value(500, "오류가 발생했습니다.\n관리자에게 문의하세요.");
		}
	}

	// 좋아요
	else if ($flag === "fave") {
		$type = "";
		$table_idx = $_POST["idx"];
		$date = $_POST["date"];
		$title = $_POST["title"];
		$room = $_POST["room"];

		$member_idx = $_SESSION["USER"]["idx"];

		$sql =	"SELECT
					COUNT(idx) AS cnt
				FROM lecture_fave
				WHERE table_idx = '".$table_idx."'
				AND member_idx = '".$member_idx."'";
		$exist = sql_fetch($sql)['cnt'] > 0;

		if (!$exist) { // insert
			$type = "ins";
			$sql =	"INSERT INTO
						lecture_fave
						(table_idx, member_idx, date, title, room)
					VALUES
						('".$table_idx."', '".$member_idx."', '".$date."', '".$title."', '".$room."')
					";
		} else { // delete
			$type = "del";
			$sql =	"DELETE FROM lecture_fave
					WHERE table_idx = '".$table_idx."'
					AND member_idx = '".$member_idx."'";
		}
		if (!sql_query($sql)) {
			return_value(500, "좋아요 처리 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		} else {
			$sql_cnt =	"SELECT
							COUNT(idx) AS cnt
						FROM lecture_fave
						WHERE table_idx = '".$table_idx."'";
			$fave_count = sql_fetch($sql_cnt)['cnt'];

			return_value(200, "완료되었습니다.", array("type"=>$type, "current_count"=>$fave_count));
		}
	}

	// 좋아요(삭제만)
	else if ($flag === "fave_delete") {
		$table_idx = $_POST["idx"];

		$member_idx = $_SESSION["USER"]["idx"];

		$sql =	"DELETE FROM lecture_fave
				WHERE idx = '".$table_idx."'
				AND member_idx = '".$member_idx."'";
		if (!sql_query($sql)) {
			return_value(500, "좋아요 처리 중 오류가 발생했습니다.\n관리자에게 문의하세요.");
		} else {
			return_value(200, "완료되었습니다.");
		}
	}