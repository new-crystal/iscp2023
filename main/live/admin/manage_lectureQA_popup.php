<?php
	include_once('./include/head.php');

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

	// qna
	$sql_qna =	"SELECT
					lq.idx,
					lq.question,
					CONCAT(mb.first_name, ' ', mb.last_name) AS member_name,
					lq.confirm_yn,
					lq.register_date AS register_date
				FROM lecture_qna AS lq
				LEFT JOIN member AS mb
					ON mb.idx = lq.member_idx
				WHERE lq.is_deleted = 'N'
				AND lq.place_idx = '".$idx."'
				AND lq.confirm_yn = '".$_GET['confirm']."'
				ORDER BY lq.register_date DESC";
	$qnas = get_data($sql_qna);
	$qnas_count = count($qnas);

	$can_modify = ($admin_permission["auth_live_lecture_qna"] > 1);
?>
<!-- {Room A} Lecture 승인 Q&A -->
<div class="contwrap">
	<ul class="clearfix approve_QA_window_top">
		<li>
			<h2 class="sub_title"><?=$info['title_en']?> Lecture <?=($_GET['confirm'] == "N") ? "미승인" : "승인"?> Q&A</h2>
		</li>
		<?php
			if ($_GET['confirm'] == "Y" && $can_modify) {
		?>
		<li>
			<div class="input_wrap">
				<input type="text" name="start" class="datepicker-here" placeholder="시작일시" data-date-format="yyyy-mm-dd" data-time-format="hh:ii" data-language='en' data-timepicker="true">
				<span>~</span>
				<input type="text" name="end" class="datepicker-here" placeholder="종료일시" data-date-format="yyyy-mm-dd" data-time-format="hh:ii" data-language='en' data-timepicker="true">
			</div>
		</li>
		<li>
			<button type="button" class="border_btn remove_btn">삭제</button>
		</li>
		<?php
			}
		?>
	</ul>

	<p class="total_num">총 <?=$qnas_count?>개</p>
	<table id="datatable">
		<thead>
			<tr class="tr_center">
				<th>질문내용</th>
				<th>작성자</th>
				<?php
					if ($can_modify) {
				?>
				<th>대기</th>
				<?php
					}
				?>
				<th>등록일시</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if ($qnas_count > 0) {
					foreach($qnas as $qa){
			?>
			<tr class="tr_center">
				<td class="leftT"><?=$qa['question']?></td>
				<td><?=$qa['member_name']?></td>
				<?php
					if ($can_modify) {
				?>
				<td><button type="button" class="border_btn confim_r" data-idx="<?=$qa['idx']?>">대기</button></td>
				<?php
					}
				?>
				<td><?=$qa['register_date']?></td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
<script>
	<?php
		if ($_GET['confirm'] == "Y") {
	?>
	// ** DOCUMENT ** //
	$(document).ready(function() {
		// 자동완성 안됨
		$('input').attr('autocomplete', 'off');;
	});

	// 일괄삭제
	$('.remove_btn').click(function(){
		var post_data = {
			flag : "remove_qna",
			idx : "<?=$idx?>",
			start : $("[name=start]").val(),
			end : $("[name=end]").val()
		};

		if (!post_data.start || !post_data.end) {
			alert('삭제처리 기간을 모두 입력해주세요.');
		} else if (confirm('저장하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : post_data,
				dataType : "JSON",
				success : function(res) {
					alert(res.msg);
					if(res.code == 200) {
						location.reload();
					}
				}
			});
		}
	});
	<?php
		}
	?>

	// 대기
	$('.confim_r').click(function(){
		if (confirm("대기로 바꾸시겠습니까?")) {
			var idx = $(this).data("idx");
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "confirm_qna",
					idx : idx,
					status : 'R'
				},
				dataType : "JSON",
				success : function(res) {
					alert(res.msg);
					if(res.code == 200) {
						location.reload();
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>