<?php
	// 행사기간 공통 변수
	$sql_period =	"SELECT
						period_live_start, period_live_end
					FROM info_event";
	$live_ymds = sql_fetch($sql_period);

	if (isset($_SESSION['live_period']) && ($live_ymds['period_live_start'] == $_SESSION['live_period'][0]) && ($live_ymds['period_live_end'] == end($_SESSION['live_period']))) {
		$_PERIOD = $_SESSION['live_period'];
	} else {
		$_PERIOD = array();

		$start_ymd = date($live_ymds['period_live_start']);
		for ($i=0;date($temp_ymd)<date($live_ymds['period_live_end']);$i++) {
			$diff_text = $start_ymd." +".$i." day";
			$temp_ymd = date('Y-m-d', strtotime($diff_text));
			array_push($_PERIOD, $temp_ymd);
		}

		$_SESSION['live_period'] = $_PERIOD;
	}
	$_PERIOD_COUNT = count($_PERIOD);
?>