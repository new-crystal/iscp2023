<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	/*foreach($_POST as $key=>$value){
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
	}*/

	// 추첨
	if ($flag === "lotto") {
		$member_idx = $_SESSION['USER']['idx'];

		$sql_period =	"SELECT
							period_live_start AS start_ymd, 
							period_live_end AS end_ymd,
							(DATEDIFF(period_live_end, period_live_start)+1) AS day_count
						FROM info_event";
		$live_ymds	= sql_fetch($sql_period);

		// 참여 가능한지 체크
		$sql_member_info =	"SELECT
								mb.idx AS member_idx,
								IFNULL(group_dc.cnt, 0) AS daily_check_count,
								IF(ld.idx IS NULL, 'N', 'Y') AS attend_yn,
								IFNULL(ld.win_yn, 'N') AS win_yn
							FROM member AS mb
							LEFT JOIN (
								SELECT
									member_idx, COUNT(idx) AS cnt
								FROM event_daily_check AS dc
								WHERE (
									DATE(dc.register_date) BETWEEN '".$live_ymds['start_ymd']."' AND '".$live_ymds['end_ymd']."'
								)
								GROUP BY member_idx
							) AS group_dc
								ON group_dc.member_idx = mb.idx
							LEFT JOIN event_luckydraw AS ld
								ON ld.member_idx = mb.idx
							WHERE mb.idx = '".$member_idx."'";
		$member_info = sql_fetch($sql_member_info);
		if ($member_info['daily_check_count'] < $live_ymds['day_count']) {
			return_value(403, "You need to present in all ".$live_ymds['day_count']." days to participate in the event.");

		} else if ($member_info['attend_yn'] == "Y") {
			return_value(403, "you have already participated.");
		}

		// 당첨 가능 확률 계산 관련 필요 값
		$max_win_count = 20; // 최대 당첨 가능 인원 수
		$sql_probability =	"SELECT
								#당첨 가능 인원 수(이미 당첨된 인원 있는 경우 줄어들 수 있음)
								(".$max_win_count." - COUNT(IF(win_yn = 'Y', 1, NULL))) AS win_able_count,

								#추첨 가능 대상 인원 수
								COUNT(member_idx) AS attend_able_count
							FROM (
								SELECT
									group_dc.member_idx,
									IF(ld.idx IS NULL, 'N', 'Y') AS attend_yn,
									IFNULL(ld.win_yn, 'N') AS win_yn
								FROM (
									SELECT
										member_idx, COUNT(idx) AS cnt
									FROM event_daily_check AS dc
									WHERE (
										DATE(dc.register_date) BETWEEN '".$live_ymds['start_ymd']."' AND '".$live_ymds['end_ymd']."'
									)
									GROUP BY member_idx
								) AS group_dc
								LEFT JOIN event_luckydraw AS ld
									ON ld.member_idx = group_dc.member_idx
								WHERE group_dc.cnt = ".$live_ymds['day_count']."
							) AS res";
		$probability = sql_fetch($sql_probability);

		if ($probability['win_able_count'] <= 0) {
			$win_yn = "N";
		} else {
			// 당첨확률
			$y_percent = 2;

			$y_arr = array_fill(0, $y_percent, "Y");
			$n_arr = array_fill(0, (100-$y_percent), "N");

			// 확률 합친 배열 넣고 섞음
			$percent_arr = array_merge($y_arr, $n_arr);
			shuffle($percent_arr);

			// 무작위 배열 중 1개를 선택 > 당첨 여부를 결정하게 됨
			$win_yn = $percent_arr[0];
		}

		$sql_result =	"INSERT INTO
							event_luckydraw
							(member_idx, win_yn)
						VALUES
							('".$member_idx."', '".$win_yn."')";
		if (sql_query($sql_result)) {
			return_value(200, "Completed.", array("win_yn" => $win_yn));
		} else {
			return_value(500, "Error during checking whether draw is possible.\nContact your administrator. [02-2039-7802]");
		}
	}

	// 스탬프 등록
	else if ($flag === "stamp") {
		// CORS 이슈 대응
		header('Access-Control-Allow-Origin: *');

		$click_point_idx = $_GET["click_point"];
		$member_idx = $_GET["member"];

		// 회원당 하루에 최대 25개
		$sql_count =	"SELECT
							COUNT(eb_l.idx) AS cnt
						FROM e_booth_log AS eb_l
						WHERE member_idx = ".$member_idx."
						AND DATE(NOW()) = DATE(eb_l.register_date)";
		$counts = sql_fetch($sql_count);
		if ($counts['cnt'] >= 25) {
			return_value(403, "스탬프 등록은 하루 최대 25개까지 가능합니다.");
		}

		// e-booth 별로 제한 갯수 있음
		$sql_company =	"SELECT
							eb_cp.company_idx,
							eb.stamp_count,
							IFNULL(calc_eb.cnt, 0) AS current_stamp_count
						FROM e_booth_click_point AS eb_cp
						INNER JOIN e_booth AS eb
							ON eb.idx = eb_cp.company_idx
						LEFT JOIN (
							SELECT	
								eb_cp.company_idx,
								COUNT(eb_l.idx) AS cnt
							FROM (
								SELECT
									*
								FROM e_booth_log
								WHERE member_idx = ".$member_idx."
								AND DATE(NOW()) = DATE(register_date)
							) AS eb_l
							INNER JOIN e_booth_click_point AS eb_cp
								ON eb_cp.idx = eb_l.click_point_idx
							GROUP BY eb_cp.company_idx
						) AS calc_eb
							ON calc_eb.company_idx = eb_cp.company_idx
						WHERE eb_cp.idx = ".$click_point_idx;
		$company = sql_fetch($sql_company);
		if ($company['current_stamp_count'] >= $company['stamp_count']) {
			return_value(403, "해당 online booth에서 받을 수 있는 일일 스탬프를 모두 받으셨습니다.");
		}

		$sql =	"INSERT INTO
					e_booth_log
					(click_point_idx, member_idx, useragent)
				VALUES
					('".$click_point_idx."', '".$member_idx."', '".$_GET["useragent"]."')
				";

		if (sql_query($sql)) {
			return_value(200, "Completed.");
		} else {
			return_value(500, "Error during checking whether draw is possible.\nContact your administrator. [02-2039-7802]");
		}
	}

	// 스탬프 리스트
	else if ($flag === "get_stamp_list") {
		$where = "";

		$sql =	"SELECT
					ebl.idx, 
					eb.`name` AS company_name,
					eb.logo_stamp_name
				FROM e_booth_log AS ebl
				INNER JOIN e_booth_click_point AS cp
					ON cp.idx = ebl.click_point_idx
				LEFT JOIN e_booth AS eb
					ON eb.idx = cp.company_idx
				WHERE DATE(ebl.register_date) = '".$_POST['date']."'
				AND member_idx = '".$_SESSION["USER"]["idx"]."'
				".$where."
				ORDER BY ebl.register_date
				";
		$list = get_data($sql);

		return_value(200, "Completed.", array("list"=>$list, "total_count"=>count($list)));
	}

	// 카드게임 진행한 횟수 가져오기
	else if ($flag === "get_card_game_count") {
		$sql =	"SELECT
					COUNT(idx) AS cnt
				FROM event_sameimg
				WHERE member_idx = '".$_SESSION["USER"]["idx"]."'
				AND DATE(register_date) = DATE(NOW())";
		$count = sql_fetch($sql)['cnt'];

		return_value(200, "Completed.", array("count"=>$count));
	}

	// 카드게임 시작하기
	else if ($flag === "start_card_game") {
		$sql =	"INSERT INTO
					event_sameimg
					(member_idx, score)
				VALUES
					('".$_SESSION["USER"]["idx"]."', '99:59:59')
				";

		if (sql_query($sql)) {
			return_value(200, "Completed.", array("idx"=>sql_insert_id()));
		} else {
			return_value(500, "Error during checking whether draw is possible.\nContact your administrator. [02-2039-7802]");
		}
	}

	// 카드게임 완료하기
	else if ($flag === "success_card_game") {
		list($min, $sec, $millisec) = explode(":", $_POST["time"]);
		$score = "00:".$min.":".$sec.".".$millisec;
		$sql =	"UPDATE event_sameimg
				SET
					score = '".$score."'
				WHERE idx = '".$_POST["idx"]."'";

		if (sql_query($sql)) {
			$sql_origin =	"SELECT
								member_idx
							FROM event_sameimg
							WHERE idx = '".$_POST["idx"]."'";
			$origin = sql_fetch($sql_origin);

			// 몇등
			$sql_rank =	"SELECT
							ranking.rank
						FROM (
							SELECT
								( @rank := @rank + 1 ) AS rank, 
								score_group.*
							FROM (
								SELECT
									es.min_score,
									es.member_idx,
									mb.first_name, mb.last_name,
									mb.affiliation
								FROM (
									SELECT
										member_idx, MIN(score) AS min_score
									FROM event_sameimg
									GROUP BY member_idx
								) AS es
								LEFT JOIN member AS mb
									ON mb.idx = es.member_idx
							) AS score_group
							, ( SELECT @rank := 0 ) AS b
							ORDER BY score_group.min_score ASC
						) AS ranking
						WHERE member_idx = '".$origin["member_idx"]."'";

			return_value(200, "Completed.", array("rank"=>sql_fetch($sql_rank)['rank']));
		} else {
			return_value(500, "Error during checking whether draw is possible.\nContact your administrator. [02-2039-7802]");
		}
	}

	// 카드게임 랭킹
	else if ($flag === "get_rank_list") {
		$where = "";

		$sql =	"SELECT
					( @rank := @rank + 1 ) AS rank, 
					score_group.*
				FROM (
					SELECT
						es.score AS min_score,
						#es.member_idx,
						mb.first_name, mb.last_name,
						IFNULL(mb.affiliation, '') AS affiliation
					FROM event_sameimg AS es
					LEFT JOIN member AS mb
						ON mb.idx = es.member_idx
					WHERE (member_idx, score) IN (
						SELECT
							member_idx, MIN(score) AS score
						FROM event_sameimg
						WHERE score < '99:59:59'
						GROUP BY member_idx
					)
				) AS score_group
				, ( SELECT @rank := 0 ) AS b
				ORDER BY score_group.min_score ASC
				LIMIT 3";
		$list = get_data($sql);

		return_value(200, "Completed.", array("list"=>$list, "total_count"=>count($list)));
	}

	// 결과값 반환 공통화
	function return_value($code, $msg, $arr=array()){
		$arr["code"] = $code;
		$arr["msg"] = $msg;
		echo json_encode($arr);
		exit;
	}
?>