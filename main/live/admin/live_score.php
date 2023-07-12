<?php
	include_once('./include/head.php');
	include_once('../common/lib/calc_score.lib.php');
	include_once("../live/include/set_event_period.php");

	$sql_member =	"SELECT
						rr.register AS idx,
						(
							CASE pmt.payment_status
								WHEN 0 THEN '주문취소'
								WHEN 1 THEN '결제대기'
								WHEN 2 THEN '결제완료'
								WHEN 3 THEN '환불대기'
								WHEN 4 THEN '환불완료'
								ELSE '-'
							END
						) AS pmt_status_text,
						(
							CASE rr.attendance_type
								WHEN 0 THEN '오프라인'
								WHEN 1 THEN '온라인'
								WHEN 2 THEN '온라인+오프라인'
								ELSE '-'
							END
						) AS attend_type_text,
						(
							CASE rr.is_score
								WHEN 0 THEN '미신청'
								WHEN 1 THEN '신청'
								ELSE '-'
							END
						) AS apply_score_text,
						(
							CASE rr.member_status
								WHEN 0 THEN '비회원'
								WHEN 1 THEN '회원'
								ELSE '-'
							END
						) AS member_status_text,
						rr.email,
						nt.nation_ko AS nation_ko_text,
						CONCAT(rr.first_name, ' ', rr.last_name) AS `name`,
						rr.phone,
						(
							CASE rr.registration_type
								WHEN 0 THEN '일반 참가자'
								WHEN 1 THEN '연설자'
								WHEN 2 THEN '위원회'
								ELSE '-'
							END
						) AS registration_type_text,
						rr.member_type,
						rr.affiliation,
						rr.department,
						rr.licence_number,
						rr.academy_number,
						rr.register_path,
						rr.register_date,
						rr.etc1, #가입경로 주관식
						rr.etc2,
						rr.etc3
					FROM request_registration AS rr
					LEFT JOIN payment AS pmt
						ON pmt.idx = rr.payment_no
					LEFT JOIN nation AS nt
						ON nt.idx = rr.nation_no
					WHERE rr.is_deleted = 'N'
					AND rr.`status` = 2
					AND rr.attendance_type > 0
					AND rr.register NOT IN (28, 67, 756, 122, 123, 124, 156, 1217, 1218, 1219, 1220)
					ORDER BY rr.register_date
					LIMIT 5";
	$mb_has_log = get_data($sql_member);
	//print_r2($mb_has_log);
?>
<section class="list">
	<div class="">
		<div class="contwrap">
			<?php
				/*
			<table id="" class="list_table">
				<thead>
					<tr class="tr_center">
						<th rowspan="2"></th>
						<th rowspan="2">회원번호</th>
						<th rowspan="2">회원 이름</th>
						<th colspan="<?=$_PERIOD_COUNT+2?>">평점</th>
					</tr>
					<tr class="tr_center">
						<th></th>
						<?php
							for($i=0;$i<$_PERIOD_COUNT;$i++){
						?>
						<th><?=$_PERIOD[$i]?></th>
						<?php
							}
						?>
						<th>합계</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$rownum = 0;
						foreach($mb_has_log as $mb){
							$rownum++;
							$scores = calc_score($_PERIOD, $mb['idx']);
							//print_R2($scores);
							$rowspan = count($scores['score']);

							$asso = $scores['score'][0];
					?>
					<tr class="tr_center">
						<td rowspan="<?=$rowspan?>"><?=$rownum?></td>
						<td rowspan="<?=$rowspan?>"><?=$mb['idx']?></td>
						<td rowspan="<?=$rowspan?>"><?=$mb['name']?></td>
						<td><?=$asso['name']?></td>
					<?php
								for($j=0;$j<$_PERIOD_COUNT;$j++){
					?>
						<td><?=$asso[($_PERIOD[$j])]?></td>
					<?php
								}
					?>
						<td><?=$asso['total']?></td>
					</tr>
					<?php
							for($i=1;$i<$rowspan;$i++){
								$asso = $scores['score'][$i];
					?>
					<tr class="tr_center">
						<td><?=$asso['name']?></td>
					<?php
								for($j=0;$j<$_PERIOD_COUNT;$j++){
					?>
						<td><?=$asso[($_PERIOD[$j])]?></td>
					<?php
								}
					?>
						<td><?=$asso['total']?></td>
					</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
				*/
			?>
			<table id="" class="list_table">
				<thead>
					<tr class="tr_center">
						<th></th>
						<th>회원번호</th>
						<th>이메일</th>
						<th>이름</th>
						<?php
							foreach($_PERIOD as $ymd){
								$ymd_text = date_format(date_create($ymd), 'm/d');
								echo '<th>'.$ymd_text.' 입장</th><th>'.$ymd_text.' 퇴장</th>';
							}
						?>
						<th>대한의사협회</th>
						<th>대한비만학회</th>
						<th>한국영양교육평가원</th>
						<th>대한운동사협회</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$rownum = 0;
						foreach($mb_has_log as $mb){
							$rownum++;
							$scores = calc_score($_PERIOD, $mb['idx']);
							//print_r2($scores['entrance_log']);
					?>
					<tr class="tr_center">
						<td><?=$rownum?></td>
						<td><?=$mb['idx']?></td>
						<td><?=$mb['email']?></td>
						<td><?=$mb['name']?></td>
					<?php
							foreach($_PERIOD as $ymd){
					?>
						<td><?=date_format(date_create($scores['entrance_log'][$ymd]['entrance_date']), 'H:i')?></td>
						<td><?=date_format(date_create($scores['entrance_log'][$ymd]['exit_date']), 'H:i')?></td>
					<?php
							}
					?>
					<?php
							foreach($scores['score'] as $asso){
					?>
						<td><?=$asso['total']?></td>
					<?php
							}
					?>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<script>
$(function(){
	var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
	tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
	tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
	tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
	tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
	tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
	tab_text = tab_text + "<table border='1px'>";

	// var exportTable = $('#' + id).clone();
	var exportTable = $(".list_table").html();

	// exportTable.find('input').each(function (index, elem) { $(elem).remove(); });
	tab_text = tab_text + exportTable;

	tab_text = tab_text.replace(/▲|▼|/g, "");//remove if u want links in your table
	tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
	tab_text = tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
	tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params
	tab_text = tab_text.replaceAll("+","&nbsp+");

	var data_type = 'data:application/vnd.ms-excel';
	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE ");
	var fileName = '라이브플랫폼 평점.xls';
	//Explorer 환경에서 다운로드
	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
		if (window.navigator.msSaveBlob) {
			var blob = new Blob([tab_text], {
			type: "application/csv;charset=utf-8;"
		});
		navigator.msSaveBlob(blob, fileName);
		}
	} else {
		var blob2 = new Blob([tab_text], {
		type: "application/csv;charset=utf-8;"
		});
		var filename = fileName;
		var elem = window.document.createElement('a');
		elem.href = window.URL.createObjectURL(blob2);
		elem.download = filename;
		document.body.appendChild(elem);
		elem.click();
		document.body.removeChild(elem);
	}
});
</script>