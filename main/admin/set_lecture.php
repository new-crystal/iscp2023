<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../plugin/editor/smarteditor2/editor.lib.php');

	if($admin_permission["auth_page_lecture"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// key date는 생성이 없어서 별도로 생성해주어야함
	$key_date_count = sql_fetch("SELECT COUNT(idx) AS cnt FROM key_date WHERE `type` = 'lecture'")['cnt'];
	if ($key_date_count <= 0) {
		$sql_key_date_insert =	"INSERT INTO 
									key_date 
									(`type`, `key_date`, contents_en, contents_ko) 
								VALUES
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', ''),
									('lecture', '0000-00-00', '', '')";
		sql_query($sql_key_date_insert);
	}

	// lecture 공통정보는 생성이 없어서 별도로 생성해주어야함
	$info_lecture_exist = sql_fetch("SELECT COUNT(modify_admin_idx) AS cnt FROM info_lecture")['cnt'];
	if (!$info_lecture_exist) {
		$sql_info_lecture_insert =	"INSERT INTO 
										info_lecture 
										(note_msg_en, formatting_guidelines_en, how_to_modify_en, note_msg_ko, formatting_guidelines_ko, how_to_modify_ko) 
									VALUES
										('', '', '', '', '', '')";
		sql_query($sql_info_lecture_insert);
	}

	// key date
	$sql_key_date =	"SELECT
						idx, `key_date`, contents_en, contents_ko
					FROM key_date
					WHERE `type` = 'lecture'
					ORDER BY idx";
	$key_date = get_data($sql_key_date);

	// datepicker setting
	$datepicker_set = 'type="text" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" data-type="date"';
	$set_date_code = "";
	function set_datepicker($name, $date){
		return '
			date_text = "'.$date.'";
			if (date_text) {
				setDate("'.$name.'", date_text);
			}
		';
	}

	// info_lecture
	$sql_info_lecture =	"SELECT
							note_msg_en, formatting_guidelines_en, how_to_modify_en, note_msg_ko, formatting_guidelines_ko, how_to_modify_ko
						FROM info_lecture";
	$info_lecture = sql_fetch($sql_info_lecture);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">Lecture Note Submission 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<p class="table_title">Key Dates</p>
					<table class="key_dates">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<?php
								for ($i=0;$i<count($key_date);$i++) {
									$kd = $key_date[$i];

									$input_name = "keydate".$i;

									if ($kd['key_date'] != "0000-00-00") {
										$set_date_code .= set_datepicker($input_name, $kd['key_date']);
									}
							?>
							<tr data-idx="<?=$kd['idx']?>">
								<th>Key Dates<?=($i+1)?></th>
								<td class="input3_td">
									<input type="text" <?=$datepicker_set?> name="<?=$input_name?>" placeholder="Date">
									<input type="text" placeholder="영문 100자 이내" maxlength="100" value="<?=$kd['contents_en']?>">
									<input type="text" placeholder="국문 100자 이내" maxlength="100" value="<?=$kd['contents_ko']?>">
								</td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
					<p class="table_title">Lecture Note Submission 관리</p>
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Message for Lecture Note(영문)</th>
								<td><?=editor_html("note_msg_en", htmlspecialchars_decode(stripslashes($info_lecture["note_msg_en"])));?></td>
							</tr>
							<tr>
								<th>Formatting Guidelines and<br/>Suggestions(영문)</th>
								<td><?=editor_html("formatting_guidelines_en", htmlspecialchars_decode(stripslashes($info_lecture["formatting_guidelines_en"])));?></td>
							</tr>
							<tr>
								<th>How to Modify(영문)</th>
								<td><?=editor_html("how_to_modify_en", htmlspecialchars_decode(stripslashes($info_lecture["how_to_modify_en"])));?></td>
							</tr>
						</tbody>
					</table>
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Message for Lecture Note(국문)</th>
								<td><?=editor_html("note_msg_ko", htmlspecialchars_decode(stripslashes($info_lecture["note_msg_ko"])));?></td>
							</tr>
							<tr>
								<th>Formatting Guidelines and<br/>Suggestions(국문)</th>
								<td><?=editor_html("formatting_guidelines_ko", htmlspecialchars_decode(stripslashes($info_lecture["formatting_guidelines_ko"])));?></td>
							</tr>
							<tr>
								<th>How to Modify(국문)</th>
								<td><?=editor_html("how_to_modify_ko", htmlspecialchars_decode(stripslashes($info_lecture["how_to_modify_ko"])));?></td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_lecture"] > 1){
					?>
					<div class="btn_wrap leftT">
						<button type="button" class="btn save">저장</button>
					</div>
					<?php
						}
					?>
				</form>
			</div>
		</div>
	</section>
<script src="./js/common.js"></script>
<script>
	// ** DOCUMENT ** //
	$(document).ready(function() {
		var date_text = "";

		// datepicker 데이터 세팅
		<?=$set_date_code?>
	});

	// 저장
	$('.save').click(function(){
		var temp_this, temp_text, temp_arr;

		// Key Dates
		var date_exist = true;
		var date_arr = new Array();
		var dates = '';
		$('.key_dates tr').each(function(index){
			temp_this = $(this);

			temp_text = temp_this.data("idx");

			temp_this.children("td").children("input").each(function(){
				if (index == 0 && $(this).val() == "") {
					date_exist = false;
					return false;
				} else {
					temp_text += "|" + $(this).val();
				}
			});

			date_arr.push(temp_text);
		});
		if (!date_exist) {
			alert("key date의 입력 값을 확인해주세요.");
			return false;
		}
		dates = date_arr.join('^&');

		<?php
			echo get_editor_js("note_msg_en");
			echo chk_editor_js("note_msg_en");

			echo get_editor_js("formatting_guidelines_en");
			echo chk_editor_js("formatting_guidelines_en");

			echo get_editor_js("how_to_modify_en");
			echo chk_editor_js("how_to_modify_en");

			echo get_editor_js("note_msg_ko");
			echo chk_editor_js("note_msg_ko");

			echo get_editor_js("formatting_guidelines_ko");
			echo chk_editor_js("formatting_guidelines_ko");

			echo get_editor_js("how_to_modify_ko");
			echo chk_editor_js("how_to_modify_ko");
		?>

		if (confirm('저장하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "update_lecture");

			form_data.append("key_dates", dates);

			form_data.append("note_msg_en", note_msg_en_editor_data);
			form_data.append("formatting_guidelines_en", formatting_guidelines_en_editor_data);
			form_data.append("how_to_modify_en", how_to_modify_en_editor_data);

			form_data.append("note_msg_ko", note_msg_ko_editor_data);
			form_data.append("formatting_guidelines_ko", formatting_guidelines_ko_editor_data);
			form_data.append("how_to_modify_ko", how_to_modify_ko_editor_data);

			$.ajax({
				url : "../ajax/admin/ajax_info_lecture.php",
				type : "POST",
				dataType : "JSON",
				data : form_data,
				contentType : false,
				processData : false,
				success : function(res) {
					if(res.code == 200){
						alert("저장이 완료되었습니다.");
						location.reload();
					} else{
						alert(res.msg);
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>