<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../plugin/editor/smarteditor2/editor.lib.php');

	if($admin_permission["auth_page_poster"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// key date는 생성이 없어서 별도로 생성해주어야함
	$key_date_count = sql_fetch("SELECT COUNT(idx) AS cnt FROM key_date WHERE `type` = 'poster'")['cnt'];
	if ($key_date_count <= 0) {
		$sql_key_date_insert =	"INSERT INTO 
									key_date 
									(`type`, `key_date`, contents_en, contents_ko) 
								VALUES
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', ''),
									('poster', '0000-00-00', '', '')";
		sql_query($sql_key_date_insert);
	}

	// poster 공통정보는 생성이 없어서 별도로 생성해주어야함
	$info_poster_exist = sql_fetch("SELECT COUNT(modify_admin_idx) AS cnt FROM info_poster")['cnt'];
	if (!$info_poster_exist) {
		$sql_info_poster_insert =	"INSERT INTO 
									info_poster 
									(welcome_msg_en, presentation_type_en, welcome_msg_ko, presentation_type_ko, abstract_templete_img, contact_for_abstract) 
								VALUES
									('', '', '', '', 0, '')";
		sql_query($sql_info_poster_insert);
	}

	// key date
	$sql_key_date =	"SELECT
						idx, `key_date`, contents_en, contents_ko
					FROM key_date
					WHERE `type` = 'poster'
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

	// info_poster(Message for abstract, ETC)
	$sql_info_poster =	"SELECT
							ip.welcome_msg_en,
							ip.welcome_msg_ko,
							ip.abstract_templete_img,
							fi_at.original_name AS fi_at_original_name,
							ip.presentation_type_en,
							ip.presentation_type_ko,
							ip.contact_for_abstract
						FROM info_poster AS ip
						LEFT JOIN `file` AS fi_at
							ON fi_at.idx = ip.abstract_templete_img";
	$info_poster = sql_fetch($sql_info_poster);

	// instructions
	$sql_instructions =	"SELECT
							idx, title_en, title_ko, contents_en, contents_ko
						FROM info_poster_instructions
						WHERE is_deleted = 'N'
						ORDER BY idx";
	$instructions = get_data($sql_instructions);

	// abstract topics
	$sql_abstract_topic =	"SELECT
								idx, title_en, title_ko
							FROM info_poster_abstract_topic
							WHERE is_deleted = 'N'
							ORDER BY idx";
	$abstract_topic = get_data($sql_abstract_topic);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">Poster Abstract Submission 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li class="active"><a href="./set_poster.php">Abstract Submission Guideline</a></li>
						<li><a href="./set_online.php">Online Submission</a></li>
					</ul>
				</div>
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
					<p class="table_title">Message for abstract</p>
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Message for Abstract(영문)<br/>(페이지 최상단)</th>
								<td><textarea class="textarea_editor" name="welcome_msg_en" id="" cols="30" rows="10"><?=$info_poster['welcome_msg_en']?></textarea></td>
							</tr>
							<tr>
								<th>Message for Abstract(국문)<br/>(페이지 최상단)</th>
								<td><textarea class="textarea_editor" name="welcome_msg_ko" id="" cols="30" rows="10"><?=$info_poster['welcome_msg_ko']?></textarea></td>
							</tr>
							<tr>
								<th>Abstract Template</th>
								<td class="file_up_wrap">
									<input type="file" id="abstract_templete" class="file_costom" data-idx="<?=$info_poster['abstract_templete_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info_poster['fi_at_original_name']?>">
									<label for="abstract_templete">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<p class="table_title">Instructions</p>
					<table class="instructions">
						<colgroup>
							<col width="*">
							<col width="*">
							<col width="100px">
						</colgroup>
						<thead>
							<tr class="tr_center">
								<th>제목</th>
								<th>내용</th>
								<th>관리</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$inst_default_attr = 'type="text" class="width_30" readonly';
								foreach($instructions as $inst){
							?>
							<tr class="inst" data-flag="" data-idx="<?=$inst['idx']?>">
								<td class="input_wrap"><input <?=$inst_default_attr?> value="<?=$inst['title_ko']?>"> <input <?=$inst_default_attr?> value="<?=$inst['title_en']?>"></td>
								<td class="input_wrap"><input <?=$inst_default_attr?> value="<?=$inst['contents_ko']?>"> <input <?=$inst_default_attr?> value="<?=$inst['contents_en']?>"></td>
								<td><button type="button" class="border_btn del">삭제</button></td>
							</tr>
							<?php
								}
							?>
							<tr class="insert">
								<td class="input_wrap">
									<input type="text" class="width_30" placeholder="국문 / 최대 50자 입력가능" maxlength="50"> <input type="text" class="width_30" placeholder="영문 / 최대 50자 입력가능" maxlength="50">
								</td>
								<td class="input_wrap">
									<input type="text" class="width_30" placeholder="국문 / 최대 50자 입력가능" maxlength="50"> <input type="text" class="width_30" placeholder="영문 / 최대 50자 입력가능" maxlength="50">
								</td>
								<td><button type="button" class="border_btn ins">추가</button></td>
							</tr>
						</tbody>
					</table>
					<!-- <p class="table_title">Abstract Topic</p>
					<table class="abstract_topic">
						<colgroup>
							<col width="*">
							<col width="*">
							<col width="100px">
						</colgroup>
						<thead>
							<tr class="tr_center">
								<th>국문</th>
								<th>영문</th>
								<th>관리</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$abto_default_attr = 'type="text" readonly';
								foreach($abstract_topic as $abto){
							?>
							<tr class="abto" data-flag="" data-idx="<?=$abto['idx']?>">
								<td><input <?=$abto_default_attr?> value="<?=$abto['title_ko']?>"></td>
								<td><input <?=$abto_default_attr?> value="<?=$abto['title_en']?>"></td>
								<td><button type="button" class="border_btn del">삭제</button></td>
							</tr>
							<?php
								}
							?>
							<tr class="insert">
								<td><input type="text" placeholder="최대 50자 입력가능" maxlength="50"></td>
								<td><input type="text" placeholder="최대 50자 입력가능" maxlength="50"></td>
								<td><button type="button" class="border_btn ins">추가</button></td>
							</tr>
						</tbody>
					</table> -->
					<p class="table_title">ETC</p>
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Presentation Type(영문)</th>
								<td><?=editor_html("presentation_type_en", htmlspecialchars_decode(stripslashes($info_poster["presentation_type_en"])));?></td>
							</tr>
							<tr>
								<th>Presentation Type(국문)</th>
								<td><?=editor_html("presentation_type_ko", htmlspecialchars_decode(stripslashes($info_poster["presentation_type_ko"])));?></td>
							</tr>
							<tr>
								<th>Contact for Abstract</th>
								<td><?=editor_html("contact_for_abstract", htmlspecialchars_decode(stripslashes($info_poster["contact_for_abstract"])));?></td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_poster"] > 1){
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

	// Instructions - 추가
	$('.instructions button.ins').click(function(){
		var inputs = $(this).parents('tr').children('td').children('input');

		if (!inputs.eq(0).val()) {
			alert("제목(국문)을 입력해주세요.");
			return false;
		} else if (!inputs.eq(1).val()) {
			alert("제목(영문)을 입력해주세요.");
			return false;
		} else if (!inputs.eq(2).val()) {
			alert("내용(국문)을 입력해주세요.");
			return false;
		} else if (!inputs.eq(3).val()) {
			alert("내용(영문)을 입력해주세요.");
			return false;
		} else {
			var default_attr = '<?=$inst_default_attr?>';
			var inner = '<tr class="inst" data-flag="insert" data-idx=""><td class="input_wrap"><input ' + default_attr + ' value="' + inputs.eq(0).val() + '"> <input ' + default_attr + ' value="' + inputs.eq(1).val() + '"></td><td class="input_wrap"><input ' + default_attr + ' value="' + inputs.eq(2).val() + '"> <input ' + default_attr + ' value="' + inputs.eq(3).val() + '"></td><td><button type="button" class="border_btn del">삭제</button></td></tr>';
			$(this).parents('tr').before(inner);

			inputs.val("");
		}
	});

	// Instructions - 삭제
	$(document).on('click', '.instructions button.del', function(){
		if (confirm('삭제하시겠습니까?')) {
			var parent_tr = $(this).parents('tr');
			if (parent_tr.data("flag") == "insert") {
				parent_tr.remove();
			} else {
				parent_tr.data("flag", "delete").hide();
			}
		}
	});

	/*// Abstract Topic - 추가
	$('.abstract_topic button.ins').click(function(){
		var inputs = $(this).parents('tr').children('td').children('input');

		if (!inputs.eq(0).val()) {
			alert("내용(국문)을 입력해주세요.");
			inputs.eq(0).focus()
			return false;
		} else if (!inputs.eq(1).val()) {
			alert("내용(영문)을 입력해주세요.");
			return false;
		} else {
			var default_attr = '<?=$abto_default_attr?>';
			var inner = '<tr class="abto" data-flag="insert" data-idx=""><td><input ' + default_attr + ' value="' + inputs.eq(0).val() + '"></td><td><input ' + default_attr + ' value="' + inputs.eq(1).val() + '"></td><td><button type="button" class="border_btn del">삭제</button></td></tr>';
			$(this).parents('tr').before(inner);

			inputs.val("");
		}
	});

	// Abstract Topic - 삭제
	$(document).on('click', '.abstract_topic button.del', function(){
		if (confirm('삭제하시겠습니까?')) {
			var parent_tr = $(this).parents('tr');
			if (parent_tr.data("flag") == "insert") {
				parent_tr.remove();
			} else {
				parent_tr.data("flag", "delete").hide();
			}
		}
	});*/

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

		// Message for abstract
		var mfa_data = {
			welcome_msg_en : $('[name=welcome_msg_en]').val(),
			welcome_msg_ko : $('[name=welcome_msg_ko]').val(),
			fi_origin_empty : !$('#abstract_templete').data('idx'),
			fi_current_empty : !document.getElementById('abstract_templete').value
		}
		if (!mfa_data.welcome_msg_en) {
			alert("Message for Abstract(영문)을 입력해주세요.");
			return false;
		} else if (!mfa_data.welcome_msg_ko) {
			alert("Message for Abstract(국문)을 입력해주세요.");
			return false;
		} else if (mfa_data.fi_origin_empty && mfa_data.fi_current_empty) {
			alert("Abstract Template 파일을 등록해주세요.");
			return false;
		}

		// Instructions
		var inst_exist = false;
		var inst_arr = new Array();
		var insts = '';
		$('tr.inst').each(function(){
			temp_this = $(this);

			if (temp_this.data("flag") != "delete") {
				inst_exist = true;
			}

			temp_text = temp_this.data("flag") + '|' + temp_this.data("idx");

			temp_this.children("td").children("input").each(function(){
				temp_text += "|" + $(this).val();
			});

			inst_arr.push(temp_text);
		});
		if (!inst_exist) {
			alert("Instructions 정보를 1개 이상 입력해주세요.");
			return false;
		}
		insts = inst_arr.join('^&');

		/*// Abstract Topic
		var abto_exist = false;
		var abto_arr = new Array();
		var abto = '';
		$('tr.abto').each(function(){
			temp_this = $(this);

			if (temp_this.data("flag") != "delete") {
				abto_exist = true;
			}

			temp_text = temp_this.data("flag") + '|' + temp_this.data("idx");

			temp_this.children("td").children("input").each(function(){
				temp_text += "|" + $(this).val();
			});

			abto_arr.push(temp_text);
		});
		if (!abto_exist) {
			alert("Abstract Topic 정보를 1개 이상 입력해주세요.");
			return false;
		}
		abtos = abto_arr.join('^&');*/

		// ETC
		<?php
			echo get_editor_js("presentation_type_en");
			echo chk_editor_js("presentation_type_en");

			echo get_editor_js("presentation_type_ko");
			echo chk_editor_js("presentation_type_ko");

			echo get_editor_js("contact_for_abstract");
			echo chk_editor_js("contact_for_abstract");
		?>

		if (confirm('저장하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "update_guideline");

			form_data.append("key_dates", dates);

			form_data.append("welcome_msg_en", mfa_data.welcome_msg_en);
			form_data.append("welcome_msg_ko", mfa_data.welcome_msg_ko);
			if (!mfa_data.current_empty) {
				form_data.append('abstract_templete',	$('#abstract_templete')[0].files[0]);
			}

			form_data.append("instructions", insts);

			/*form_data.append("abstract_topics", abtos);*/

			form_data.append("presentation_type_en", presentation_type_en_editor_data);
			form_data.append("presentation_type_ko", presentation_type_ko_editor_data);
			form_data.append("contact_for_abstract", contact_for_abstract_editor_data);

			$.ajax({
				url : "../ajax/admin/ajax_info_poster.php",
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

	// 빈값 확인 함수
	function inputFileEmpty(id){
		var origin_empty = $('#'+id).data('idx') == "0";
		var current_empty = !document.getElementById(id).value;

		var res = {
			origin_empty : origin_empty,
			current_empty : current_empty,
			verify_fail : (origin_empty && current_empty)
		}

		return res;
	}
</script>
<?php
	include_once('./include/footer.php');
?>