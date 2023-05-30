<?php
	include_once("../../common/common.php");

	$flag = $_POST["flag"] ?? $_GET["flag"];

	foreach($_POST as $post){
		$post = htmlspecialchars($post, ENT_QUOTES);
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
					AND exit_date IS NULL
					ORDER BY idx DESC
					LIMIT 1";
		$idx = sql_fetch($sql_idx)['idx'];
		if (!$idx) {
			return_value(500, "종료 처리할 이력이 확인되지 않습니다.\n관리자에게 문의하세요.");
		}

		$sql_update =	"UPDATE lecture_view_log
						SET
							exit_date = NOW()
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

		// 회원 인덱스
		$member_idx = $_SESSION['USER']['idx'];

		// 행사 일정
		$log_arr = array();
		$default_score_arr = array();
		foreach($_PERIOD as $ymd){
			$default_arr[$ymd] = 0;
		}

		/* score */
		$score = array(
			// 대한의사협회
			"KMA" => $default_score_arr,
			// 대한비만학회
			"KSSO" => $default_score_arr,
			// 한국영양교육평가원
			"KIDEE" => $default_score_arr,
			// 대한운동사협회
			"KACEP" => $default_score_arr
		);

		// 쉬는시간
		$breaktimes = array(
			$_PERIOD[0]=>array(
				"17:00:00~19:00:00"
			),
			$_PERIOD[1]=>array(
				"08:00:00~08:15:00",
				"08:55:00~09:00:00",
				"10:30:00~10:40:00",
				"11:25:00~11:30:00",
				"12:30:00~12:40:00",
				"15:10:00~15:30:00"
			),
			$_PERIOD[2]=>array(
				"08:00:00~08:15:00",
				"08:55:00~09:00:00",
				"10:30:00~10:40:00",
				"12:10:00~12:20:00",
				"14:20:00~14:30:00",
				"15:30:00~15:40:00",
				"16:20:00~16:30:00"
			)
		);

		/* daily */
		$daily = array();
		$temp = array();
		foreach($_PERIOD as $ymd){
			$sql_daily = "SELECT
							lec.idx,
							lec.agenda_title_en,
							lec.category_idx,
							lpu.place_idxs,
							lec.period_time_start,
							lec.period_time_end,
							'' AS entrance_date,
							'' AS entrance_strtotime,
							'' AS exit_date,
							'' AS exit_strtotime,
							0 AS watch_mins
						FROM lecture AS lec
						LEFT JOIN (
							SELECT
								lecture_idx, GROUP_CONCAT(place_idx) AS place_idxs
							FROM lecture_place_use
							GROUP BY lecture_idx
						) AS lpu
							ON lpu.lecture_idx = lec.idx
						WHERE lec.is_deleted = 'N'
						AND DATE(lec.period_time_start) = '".$ymd."'
						ORDER BY lec.period_time_start";
			$daily[$ymd] = get_data($sql_daily);
		}

		// 계산
		foreach($_PERIOD as $ymd){
			$sql_logs =	"SELECT
							place_idx,
							IFNULL(MIN(vl.entrance_date), MIN(vl.exit_date)) AS entrance_date,
							IFNULL(MAX(vl.exit_date), MAX(vl.entrance_date)) AS exit_date
						FROM lecture_view_log AS vl
						WHERE member_idx = '".$member_idx."'
						#AND exit_date IS NOT NULL
						AND DATE(entrance_date) = '".$ymd."'
						GROUP BY place_idx";
			$logs = get_data($sql_logs);
			array_push($log_arr, $logs);

			$granularity = 60;

			foreach($logs as $log) {
				$enter = $log['entrance_date'];		//입장시간
				$leave = $log['exit_date'];			//퇴장시간

				$enter_ = strtotime($enter); 
				$enter_ = $enter_ - $enter_ % $granularity;

				$leave_ = strtotime($leave); 
				$leave_ = $leave_ - $leave_ % $granularity;

				$e_start = $enter_;
				$e_end = $leave_;

				$slots = array();
				for ($i = $e_start; $i < $e_end; $i += $granularity) {
					$slots[($i - $e_start)/$granularity] = 1;
				}
				$count = sizeof($slots);

				foreach ($breaktimes[$ymd] as $_breaktime) {
					list($s_time, $e_time) = explode('~', $_breaktime);
					$s = strtotime(($ymd." ".$s_time));
					$e = strtotime(($ymd." ".$e_time));
					for ($j = $s; $j < $e; $j += $granularity) {
						$x = ($j - $e_start)/$granularity;
						if ($x >= 0 && $x < $count) {
							$slots[$x] = 0;
						}
					}
				}

				$spent = 0;
				$spent_kma = 0;
				for ($i = 0; $i < $count; $i++) {
					if ($slots[$i] == 1){
						$slot_strtotime = ($i * $granularity + $e_start);
						//foreach($daily[$ymd] as $lec){
						for($j=0;$j<count($daily[$ymd]);$j++) {
							$lec = $daily[$ymd][$j];
							if (
								in_array($log['place_idx'], explode(",", $lec['place_idxs'])) 
								&& $slot_strtotime >= strtotime($lec['period_time_start']) 
								&& $slot_strtotime <= strtotime($lec['period_time_end'])
							) {
								//echo $slot_strtotime." ";

								// 평점 변수
								$spent++;
								/* 카테고리 별 체류시간 제외 예외처리 */
								if ($lec['category_idx'] != 3) {
									// pre-congress symposium 체류시간에서 제외
									$spent_kma++;
								}

								// 조회시간 변수
								$daily[$ymd][$j]['watch_mins']++;

								if ($lec['entrance_date'] == "") {
									$daily[$ymd][$j]['entrance_date'] = date("Y-m-d H:i:s", $slot_strtotime);
									$daily[$ymd][$j]['entrance_strtotime'] = $slot_strtotime;
								}

								if ($slot_strtotime > $daily[$ymd][$j]['exit_strtotime']) {
									$daily[$ymd][$j]['exit_date'] = date("Y-m-d H:i:s", $slot_strtotime);
									$daily[$ymd][$j]['exit_strtotime'] = $slot_strtotime;
								}
							}
						}
					}
				}

				$temp_spent = 0;
				foreach($score as $key => $value){
					// $score[$key][$ymd] = $spent;

					/*시간당 평점, 날짜별 최대평점 관련 예외처리*/
					if ($key == "KMA") {
						//시간당 1평점
						$temp_spent = $spent_kma;
						$temp_spent = floor($temp_spent/60);

						$score[$key][$ymd] += $temp_spent;

						// 날짜별로 최대 평점 다름
						if ($ymd == "2021-09-02" && $score[$key][$ymd] > 1) {
							$score[$key][$ymd] = 1;
						} else if ($ymd == "2021-09-03" && $score[$key][$ymd] > 6) {
							$score[$key][$ymd] = 6;
						} else if ($ymd == "2021-09-04" && $score[$key][$ymd] > 6) {
							$score[$key][$ymd] = 6;
						}
					} else if ($key == "KSSO") {
						//시간당 1평점
						$temp_spent = $spent;
						$temp_spent = floor($temp_spent/60);

						$score[$key][$ymd] += $temp_spent;

						// 날짜별로 최대 평점 다름
						if ($ymd == "2021-09-02" && $score[$key][$ymd] > 2) {
							$score[$key][$ymd] = 2;
						} else if ($ymd == "2021-09-03" && $score[$key][$ymd] > 6) {
							$score[$key][$ymd] = 6;
						} else if ($ymd == "2021-09-04" && $score[$key][$ymd] > 6) {
							$score[$key][$ymd] = 6;
						}
					} else if ($key == "KIDEE") {
						//시간당 1평점
						$temp_spent = $spent;
						$temp_spent = floor($temp_spent/60);

						$score[$key][$ymd] += $temp_spent;
					} else if ($key == "KACEP") {
						//시간당 3평점
						$temp_spent = $spent;
						$temp_spent = floor($temp_spent/60);
						$temp_spent *= 3;

						$score[$key][$ymd] += $temp_spent;
					}
				}
			}
		}

		// 평점 점수 정리
		$score_arr = array();
		foreach($score as $key => $value){
			$temp_total = 0;
			foreach($_PERIOD as $ymd){
				if (!isset($score[$key][$ymd])) {
					$score[$key][$ymd] = 0;
				}
				$temp_total += $score[$key][$ymd];
			}

			/*통합 최대평점 관련 예외처리*/
			if ($key == "KMA") {
				$score[$key]['name'] = "대한의사협회";
				//
			} else if ($key == "KSSO") {
				$score[$key]['name'] = "대한비만학회";
				//
			} else if ($key == "KIDEE") {
				$score[$key]['name'] = "한국영양교육평가원<br>임상영양사 전문연수교육(CPD)";
				//통합 최대평점 있음
				if ($temp_total > 5) {
					$temp_total = 5;
				}
			} else if ($key == "KACEP") {
				$score[$key]['name'] = "대한운동사협회";
				//통합 최대평점 있음
				if ($temp_total > 40) {
					$temp_total = 40;
				}
			}
			$score[$key]['total'] = $temp_total;

			array_push($score_arr, $score[$key]);
		}

		// 조회시간 정리
		foreach($daily as $day=>$lecs){
			$total_watch_mins = 0;
			for($j=0;$j<count($lecs);$j++) {

				if ($daily[$day][$j]['watch_mins'] <= 0) {
					// 시청시간 없으면 배열에서 삭제
					unset($daily[$day][$j]);
				} else {
					// 분 세는 방식 때문에 1분이 추가로 들어가는 현상 방지
					//$daily[$day][$j]['watch_mins']--;

					// 사용자단에서 바로 출력할 수 있도록 편집
					$daily[$day][$j]['entrance_date'] = date("Y-m-d H:i", $daily[$day][$j]['entrance_strtotime']);
					$daily[$day][$j]['exit_date'] = date("Y-m-d H:i", $daily[$day][$j]['exit_strtotime']);
					$daily[$day][$j]['watch_time'] = get_h_i_text($daily[$day][$j]['watch_mins']);
					$total_watch_mins += $daily[$day][$j]['watch_mins'];

					// 시청시간 있어도 사용자단에서 필요 없는 값은 삭제
					unset($daily[$day][$j]['category_idx']);
					unset($daily[$day][$j]['place_idxs']);
					unset($daily[$day][$j]['period_time_start']);
					unset($daily[$day][$j]['period_time_end']);
					unset($daily[$day][$j]['entrance_strtotime']);
					unset($daily[$day][$j]['exit_strtotime']);
					unset($daily[$day][$j]['watch_mins']);
				}
			}

			$total_watch_time[$day] = get_h_i_text($total_watch_mins);

			sort($daily[$day]);
		}

		$res = array("score"=>$score_arr, "daily"=>$daily, "total_watch_time"=>$total_watch_time);

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
				AND lq.member_idx = '".$_SESSION['USER']['idx']."'
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
					('".$_POST['lecture_idx']."', '".$_POST['place_idx']."', '".$_SESSION["USER"]["idx"]."', '".$_POST['question']."')
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

	// 분 값으로 H:i format 문자열 반환 함수
	function get_h_i_text($mins){
		$hour = floor($mins/60);
		$min = $mins-($hour*60);
		$min = $min < 0 ? 0 : $min;

		$result = sprintf('%02d', $hour).":".sprintf('%02d', $min);

		return $result;
	}