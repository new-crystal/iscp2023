<?php
function calc_score ($_PERIOD, $member_idx) {

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
	$entrance_strtotimes = array();
	$entrance_log = array();
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

		$entrance_log[$ymd]['entrance_date'] = '';
		$entrance_log[$ymd]['entrance_strtotime'] = 0;
		$entrance_log[$ymd]['exit_date'] = '';
		$entrance_log[$ymd]['exit_strtotime'] = 0;
		$entrance_log[$ymd]['watch_mins'] = 0;
		$entrance_log[$ymd]['watch_time'] = '';
	}

	// 계산
	foreach($_PERIOD as $ymd){
		$sql_logs =	"SELECT
						place_idx,
						MIN(vl.entrance_date) AS entrance_date,
						MAX(vl.exit_date) AS exit_date
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
					for($j=0;$j<count($daily[$ymd]);$j++) {
						$lec = $daily[$ymd][$j];
						if (
							in_array($log['place_idx'], explode(",", $lec['place_idxs'])) 
							&& $slot_strtotime >= strtotime($lec['period_time_start']) 
							&& $slot_strtotime <= strtotime($lec['period_time_end'])
						) {
							//echo $slot_strtotime." ";

							$update_entrance = ($lec['entrance_date'] == "");
							$update_exit = ($slot_strtotime > $daily[$ymd][$j]['exit_strtotime']);

							if ($update_entrance) {
								$daily[$ymd][$j]['entrance_date'] = date("Y-m-d H:i:s", $slot_strtotime);
								$daily[$ymd][$j]['entrance_strtotime'] = $slot_strtotime;
							}

							if ($update_exit) {
								$daily[$ymd][$j]['exit_date'] = date("Y-m-d H:i:s", $slot_strtotime);
								$daily[$ymd][$j]['exit_strtotime'] = $slot_strtotime;
							}

							if (($update_entrance || $update_exit) && !in_array($slot_strtotime, $entrance_strtotimes)) {
								// 평점 변수
								$spent++;
								/* 카테고리 별 체류시간 제외 예외처리 */
								if ($lec['category_idx'] != 3) {
									// pre-congress symposium 체류시간에서 제외
									$spent_kma++;
								}

								// 조회시간 변수
								$daily[$ymd][$j]['watch_mins']++;

								array_push($entrance_strtotimes, $slot_strtotime);
							}

							/*if ($lec['idx'] == 3) {
								echo $lec['idx']." / ".$log['place_idx']."<br>";
								echo $daily[$ymd][$j]['entrance_date']." / ".$daily[$ymd][$j]['exit_date']."<br>";
								echo $lec['period_time_start']." / ".$lec['period_time_end']."<br>";
								echo ($daily[$ymd][$j]['exit_strtotime'] - $daily[$ymd][$j]['entrance_strtotime'])." / ".(strtotime($lec['period_time_end']) - strtotime($lec['period_time_start']))."<br>";
								echo $daily[$ymd][$j]['watch_mins']."<br><br>";
							}*/
						}

						//$entrance_log[$ymd]['entrance_date_strtotime'] = 0;
						if ($entrance_log[$ymd]['entrance_strtotime'] == 0 || $slot_strtotime < $entrance_log[$ymd]['entrance_strtotime']) {
							$entrance_log[$ymd]['entrance_date'] = date("Y-m-d H:i:s", $slot_strtotime);
							$entrance_log[$ymd]['entrance_strtotime'] = $slot_strtotime;
						}

						if ($slot_strtotime > $entrance_log[$ymd]['exit_strtotime']) {
							$entrance_log[$ymd]['exit_date'] = date("Y-m-d H:i:s", $slot_strtotime);
							$entrance_log[$ymd]['exit_strtotime'] = $slot_strtotime;
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
	$total_watch_mins = 0;
	foreach($daily as $day=>$lecs){
		$daily_watch_mins = 0;
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
				$daily_watch_mins += $daily[$day][$j]['watch_mins'];

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

		$total_watch_mins += $daily_watch_mins;
		$total_watch_time[$day] = get_h_i_text($daily_watch_mins);

		sort($daily[$day]);

		$entrance_log[$day]['watch_mins'] = $daily_watch_mins;
		$entrance_log[$day]['watch_time'] = get_h_i_text($entrance_log[$day]['watch_mins']);
		unset($entrance_log[$day]['entrance_strtotime']);
		unset($entrance_log[$day]['exit_strtotime']);
		//unset($entrance_log[$day]['watch_mins']);
	}
	$total_watch_time['total'] = get_h_i_text($total_watch_mins);

	$res = array("score"=>$score_arr, "daily"=>$daily, "entrance_log"=>$entrance_log, "total_watch_time"=>$total_watch_time);

	/*
		다시

	$sql = "SELECT * FROM lecture_score_online WHERE member_idx = '".$member_idx."'";
	$lso = sql_fetch($sql);
	$res = array();
	$res['score'][0]['name']		= '대한의사협회';
	$res['score'][0]['2021-09-02']	= $lso['sep2_kma'];
	$res['score'][0]['2021-09-03']	= $lso['sep3_kma'];
	$res['score'][0]['2021-09-04']	= $lso['sep4_kma'];
	$res['score'][0]['total']		= $lso['sep2_kma'] + $lso['sep3_kma'] + $lso['sep4_kma'];

	$res['score'][1]['name']		= '대한비만학회';
	$res['score'][1]['2021-09-02']	= $lso['sep2_ksso'];
	$res['score'][1]['2021-09-03']	= $lso['sep3_ksso'];
	$res['score'][1]['2021-09-04']	= $lso['sep4_ksso'];
	$res['score'][1]['total']		= $lso['sep2_ksso'] + $lso['sep3_ksso'] + $lso['sep4_ksso'];

	$res['score'][2]['name']		= '한국영양교육평가원 임상영양사<br>전문연수교육(CPD)';
	$res['score'][2]['2021-09-02']	= $lso['sep2_cpd'];
	$res['score'][2]['2021-09-03']	= $lso['sep3_cpd'];
	$res['score'][2]['2021-09-04']	= $lso['sep4_cpd'];
	$res['score'][2]['total']		= $lso['sep2_cpd'] + $lso['sep3_cpd'] + $lso['sep4_cpd'];
	$res['score'][2]['total']		= ($res['score'][2]['total'] > 5) ? 5 : $res['score'][2]['total'];

	$res['score'][3]['name']		= '대한운동사협회';
	$res['score'][3]['2021-09-02']	= $lso['sep2_kacep'];
	$res['score'][3]['2021-09-03']	= $lso['sep3_kacep'];
	$res['score'][3]['2021-09-04']	= $lso['sep4_kacep'];
	$res['score'][3]['total']		= $lso['sep2_kacep'] + $lso['sep3_kacep'] + $lso['sep4_kacep'];
	$res['score'][3]['total']		= ($res['score'][3]['total'] > 40) ? 40 : $res['score'][3]['total'];

	$res['entrance_log']['2021-09-02']['entrance_date']		= $lso['sep2_entrance_date'];
	$res['entrance_log']['2021-09-02']['exit_date']			= $lso['sep2_exit_date'];
	$res['entrance_log']['2021-09-02']['watch_mins']		= floor((strtotime($lso['sep2_exit_date']) - strtotime($lso['sep2_entrance_date']))/60);
	$res['entrance_log']['2021-09-02']['watch_time']		= get_h_i_text($res['entrance_log']['2021-09-02']['watch_mins']);

	$res['entrance_log']['2021-09-03']['entrance_date']		= $lso['sep3_entrance_date'];
	$res['entrance_log']['2021-09-03']['exit_date']			= $lso['sep3_exit_date'];
	$res['entrance_log']['2021-09-03']['watch_mins']		= floor((strtotime($lso['sep3_exit_date']) - strtotime($lso['sep3_entrance_date']))/60);
	$res['entrance_log']['2021-09-03']['watch_time']		= get_h_i_text($res['entrance_log']['2021-09-03']['watch_mins']);

	$res['entrance_log']['2021-09-04']['entrance_date']		= $lso['sep4_entrance_date'];
	$res['entrance_log']['2021-09-04']['exit_date']			= $lso['sep4_exit_date'];
	$res['entrance_log']['2021-09-04']['watch_mins']		= floor((strtotime($lso['sep4_exit_date']) - strtotime($lso['sep4_entrance_date']))/60);
	$res['entrance_log']['2021-09-04']['watch_time']		= get_h_i_text($res['entrance_log']['2021-09-04']['watch_mins']);
	*/

	/*$res =Array
(
    ['score'] => Array
        (
            [0] => Array
                (
                    ['2021-09-03'] => $lso['sep3_kma']
                    ['2021-09-02'] => 0
                    ['2021-09-04'] => 0
                    ['name'] => 대한의사협회
                    ['total'] => 5
                )

            [1] => Array
                (
                    ['2021-09-03'] => 5
                    ['2021-09-02'] => 0
                    ['2021-09-04'] => 0
                    ['name'] => 대한비만학회
                    ['total'] => 5
                )

            [2] => Array
                (
                    ['2021-09-03'] => 5
                    ['2021-09-02'] => 0
                    ['2021-09-04'] => 0
                    ['name'] => 한국영양교육평가원 임상영양사 전문연수교육(CPD)
                    ['total'] => 5
                )

            [3] => Array
                (
                    ['2021-09-03'] => 15
                    ['2021-09-02'] => 0
                    ['2021-09-04'] => 0
                    ['name'] => 대한운동사협회
                    ['total'] => 15
                )

        )

    ['daily'] => Array
        (
            ['2021-09-02'] => Array
                (
                )

            ['2021-09-03'] => Array
                (
                    [0] => Array
                        (
                            [idx] => 8
                            [agenda_title_en] => Symposium 1
                            [entrance_date] => 2021-09-03 09:03
                            [exit_date] => 2021-09-03 10:29
                            [watch_time] => 01:27
                        )

                    [1] => Array
                        (
                            [idx] => 15
                            [agenda_title_en] => Oral Presentation 1
                            [entrance_date] => 2021-09-03 12:29
                            [exit_date] => 2021-09-03 12:29
                            [watch_time] => 00:01
                        )

                    [2] => Array
                        (
                            [idx] => 16
                            [agenda_title_en] => Oral Presentation 2
                            [entrance_date] => 2021-09-03 11:30
                            [exit_date] => 2021-09-03 12:29
                            [watch_time] => 00:59
                        )

                    [3] => Array
                        (
                            [idx] => 25
                            [agenda_title_en] => Sponsored Session 2 (Alvogen)
                            [entrance_date] => 2021-09-03 13:40
                            [exit_date] => 2021-09-03 15:09
                            [watch_time] => 01:30
                        )

                    [4] => Array
                        (
                            [idx] => 31
                            [agenda_title_en] => Sponsored Session 3 (Novo Nordisk)
                            [entrance_date] => 2021-09-03 16:10
                            [exit_date] => 2021-09-03 17:40
                            [watch_time] => 01:31
                        )

                )

            ['2021-09-04'] => Array
                (
                )

        )

    ['entrance_log'] => Array
        (
            ['2021-09-02'] => Array
                (
                    [entrance_date] => 
                    [exit_date] => 
                    [watch_mins] => 0
                    [watch_time] => 00:00
                )

            ['2021-09-03'] => Array
                (
                    [entrance_date] => 2021-09-03 09:03:00
                    [exit_date] => 2021-09-03 17:44:00
                    [watch_mins] => 328
                    [watch_time] => 05:28
                )

            ['2021-09-04'] => Array
                (
                    [entrance_date] => 
                    [exit_date] => 
                    [watch_mins] => 0
                    [watch_time] => 00:00
                )

        )

    ['total_watch_time'] => Array
        (
            ['2021-09-02'] => 00:00
            ['2021-09-03'] => 05:28
            ['2021-09-04'] => 00:00
            ['total'] => 05:28
        )

);*/

	return $res;
}

// 분 값으로 H:i format 문자열 반환 함수
function get_h_i_text($mins){
	$hour = floor($mins/60);
	$min = $mins-($hour*60);
	$min = $min < 0 ? 0 : $min;

	$result = sprintf('%02d', $hour).":".sprintf('%02d', $min);

	return $result;
}
?>