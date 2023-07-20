<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_lecture_qna"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$idx = $_GET['idx'];

	// place
	$sql_info =	"SELECT
					title_en
				FROM lecture_place AS lp
				WHERE lp.idx = '".$idx."'";
	$info = sql_fetch($sql_info);

	// lecture
	$sql_lecture =	"SELECT
						lec.*
					FROM lecture_place_use AS lpu
					INNER JOIN (
						SELECT
							lec.idx,
							lec.agenda_title_en,
							lc.title_en AS category_title_en,
							lpu.title_en_text AS place_title_en,
							lsj.name_en_text AS speaker_name_en,
							lec.period_time_start,
							lec.period_time_end,
							CONCAT(DATE_FORMAT(lec.period_time_start, '%y-%m-%d %H:%i'), ' ~ ', DATE_FORMAT(lec.period_time_end, '%y-%m-%d %H:%i')) AS period_time_text
						FROM lecture AS lec
						LEFT JOIN lecture_category AS lc
							ON lc.idx = lec.category_idx
						LEFT JOIN (
							SELECT
								lpu.lecture_idx,
								GROUP_CONCAT(lp.title_en) AS title_en_text
							FROM lecture_place_use AS lpu
							INNER JOIN lecture_place AS lp
								ON lp.idx = lpu.place_idx
							GROUP BY lpu.lecture_idx
						) AS lpu
							ON lpu.lecture_idx = lec.idx
						LEFT JOIN (
							SELECT
								lsj.lecture_idx,
								GROUP_CONCAT(ls.name_en) AS name_en_text
							FROM lecture_speaker_join AS lsj
							INNER JOIN lecture_speaker AS ls
								ON ls.idx = lsj.speaker_idx
							GROUP BY lsj.lecture_idx
						) AS lsj
							ON lsj.lecture_idx = lec.idx
						WHERE lec.is_deleted = 'N'
					) AS lec
						ON lec.idx = lpu.lecture_idx
					WHERE lpu.place_idx = '".$idx."'
					AND NOW() <= lec.period_time_end
					ORDER BY lec.period_time_start";
	$lectures = get_data($sql_lecture);
	$lectures_count = count($lectures);

	// qna
	$sql_qna =	"SELECT
					lq.idx,
					lq.question,
					CONCAT(mb.first_name, ' ', mb.last_name) AS member_name,
					lq.confirm_yn,
					DATE_FORMAT(lq.register_date, '%y-%m-%d %H:%i') AS register_date
				FROM lecture_qna AS lq
				LEFT JOIN member AS mb
					ON mb.idx = lq.member_idx
				WHERE lq.is_deleted = 'N'
				AND lq.place_idx = '".$idx."'
				AND lq.confirm_yn = 'R'
				ORDER BY lq.register_date DESC";
	$qnas = get_data($sql_qna);
	$qnas_count = count($qnas);
?>

<section class="manage_lectureQA_detail2">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">Lecture Q&A 관리</h1>
		</div>
		<div class="contwrap has_fixed_title">
			<!-- {Room A} Lecture -->
			<h2 class="sub_title"><?=$info['title_en']?> Lecture</h2>
			<div class="scroll_container">
				<table>
					<thead>
						<tr class="tr_center">
							<th>Agenda Title(영문)</th>
							<th>Category</th>
							<th>Place</th>
							<th>Chirperson</th>
							<th>Time(강의일시)</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($lectures_count <= 0) {
						?>
						<tr class="tr_center">
							<td colspan="5">No data available in table</td>
						</tr>
						<?php
							} else {
								foreach($lectures as $lec){
									foreach($lec as $key=>$value){
										$lec[$key] = htmlspecialchars_decode($value);
									}
						?>
						<tr class="tr_center">
							<td><a href="./manage_lecture_detail.php?idx=<?=$lec['idx']?>" class="leftT"><?=$lec['agenda_title_en']?></a></td>
							<td><?=$lec['category_title_en']?></td>
							<td><?=$lec['place_title_en']?></td>
							<td><?=$lec['speaker_name_en']?></td>
							<td><?=$lec['period_time_text']?></td>
						</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<!-- {Room A} Lecture Q&A -->
			<div class="clearfix2">
				<h2 class="sub_title"><?=$info['title_en']?> Lecture Q&A</h2>
				<div>
					<button type="button" class="btn" onclick="window.open('./manage_lectureQA_popup_speaker.php?idx=<?=$idx?>')">연사용 Q&A 보기</button>
					<button type="button" class="btn" onclick="window.open('./manage_lectureQA_popup.php?idx=<?=$idx?>&confirm=N')">미승인 Q&A</button>
					<button type="button" class="btn blue_btn" onclick="window.open('./manage_lectureQA_popup.php?idx=<?=$idx?>&confirm=Y')">승인 Q&A</button>
				</div>
			</div>
			<p class="total_num">총 <?=$qnas_count?>개</p>
			<table id="">
				<colgroup>
					<col style="width: 50%;">
					<col style="width: 10%;">
					<col style="width: 20%;">
					<col style="width: 20%;">
				</colgroup>
				<thead>
					<tr class="tr_center">
						<th>질문내용</th>
						<th>작성자</th>
						<th>승인여부</th>
						<th>등록일시</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($qnas_count <= 0) {
					?>
					<tr class="tr_center">
						<td colspan="5">No data available in table</td>
					</tr>
					<?php
						} else {
							foreach($qnas as $qa){
					?>
					<tr class="tr_center">
						<td class="leftT"><?=$qa['question']?></td>
						<td><?=$qa['member_name']?></td>
						<td class="approve_td">
					<?php
								if($admin_permission["auth_live_lecture_qna"] <= 1){
									$confirm_yn_text = "";
									switch($qa['confirm_yn']){
										case "Y":
											$confirm_yn_text = "예";
											break;
										case "N":
											$confirm_yn_text = "아니오";
											break;
										case "R":
											$confirm_yn_text = "대기";
											break;
									}

									echo $confirm_yn_text;
								} else {
					?>
							<input 
								type="radio" value="Y" 
								name="approve<?=$qa['idx']?>" id="yes<?=$qa['idx']?>"
								<?=($qa['confirm_yn'] == "Y") ? "checked" : ""?>
							> <label for="yes<?=$qa['idx']?>">예</label>
							<input 
								type="radio" value="N" class="approveNO" 
								name="approve<?=$qa['idx']?>" id="no<?=$qa['idx']?>"
								<?=($qa['confirm_yn'] == "N") ? "checked" : ""?>
							> <label for="no<?=$qa['idx']?>">아니오</label>
							<input 
								type="radio" value="R" class="approveNO" 
								name="approve<?=$qa['idx']?>" id="hold<?=$qa['idx']?>" 
								<?=($qa['confirm_yn'] == "R") ? "checked" : ""?>
							> <label for="hold<?=$qa['idx']?>">대기</label>
							<button type="button" class="border_btn confirm" data-idx="<?=$qa['idx']?>">저장</button>
					<?php
								}
					?>
						</td>
						<td><?=$qa['register_date']?></td>
					</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
			<!-- btn -->
			<div class="btn_wrap">
				<button type="button" class="border_btn" onclick="location.href='./manage_lectureQA_list.php'">목록</button>
			</div>
		</div>
	</div>
</section>
<script>
	$('.confirm').click(function(){
		if (confirm("저장하시겠습니까?")) {
			var idx = $(this).data("idx");
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "confirm_qna",
					idx : idx,
					status : $("input[name=approve"+idx+"]:checked").val()
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						location.reload();
					} else {
						alert(res.msg);
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>