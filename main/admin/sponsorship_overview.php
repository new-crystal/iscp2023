<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../plugin/editor/smarteditor2/editor.lib.php');

	if($admin_permission["auth_page_sponsorship"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// sponsor 공통정보는 생성이 없어서 별도로 생성해주어야함
	$info_registration_exist = sql_fetch("SELECT COUNT(modify_admin_idx) AS cnt FROM info_sponsorship")['cnt'];
	if (!$info_registration_exist) {
		$sql_info_registration_insert =	"INSERT INTO 
											info_sponsorship 
											(welcome_msg_en, welcome_msg_ko, sponsorship_official_docs, business_license, copy_of_bankbook, important_dates_en, important_dates_ko, how_to_apply_en, how_to_apply_ko, procedure_en, procedure_ko, contact_info_en, contact_info_ko, contact_for_sponsorship) 
										VALUES
											('', '', 0, 0, 0, '', '', '', '', '', '', '', '', '')";
		sql_query($sql_info_registration_insert);
	}

	$sql_info =	"SELECT
					isp.welcome_msg_en, isp.welcome_msg_ko, 
					isp.sponsorship_official_docs, 
					fi_sod.original_name AS fi_sod_original_name,
					isp.business_license, 
					fi_bl.original_name AS fi_bl_original_name,
					isp.copy_of_bankbook, 
					fi_cob.original_name AS fi_cob_original_name,
					isp.important_dates_en, isp.important_dates_ko, 
					isp.how_to_apply_en, isp.how_to_apply_ko, 
					isp.procedure_en, isp.procedure_ko, 
					isp.contact_info_en, isp.contact_info_ko, 
					isp.contact_for_sponsorship
				FROM info_sponsorship AS isp
				LEFT JOIN `file` AS fi_sod
					ON fi_sod.idx = isp.sponsorship_official_docs
				LEFT JOIN `file` AS fi_bl
					ON fi_bl.idx = isp.business_license
				LEFT JOIN `file` AS fi_cob
					ON fi_cob.idx = isp.copy_of_bankbook";
	$info = sql_fetch($sql_info);
?>
<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">Sponsorship & Exhibition 관리</h1>
		</div>
		<div class="contwrap has_fixed_title">
			<!----- 탭 ----->
			<div class="tab_box">
				<ul class="tab_wrap clearfix">
					<li class="active"><a href="javascript:;">Overview</a></li>
					<li><a href="./sponsorship_sponsorship.php">Sponsorship</a></li>
				</ul>
			</div>
			<!----- 컨텐츠 ----->
			<form>
				<p class="table_title">Message for Sponsorship</p>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>Message for Abstract (영문) <br> (페이지 최상단)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="welcome_msg_en"><?=htmlspecialchars_decode(stripslashes($info["welcome_msg_en"]))?></textarea></td>
						</tr>
						<tr>
							<th>Message for Abstract (국문) <br> (페이지 최상단)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="welcome_msg_ko"><?=htmlspecialchars_decode(stripslashes($info["welcome_msg_ko"]))?></textarea></td>
						</tr>
						<tr>
							<th>Sponsorship Official Document</th>
							<td class="file_up_wrap">
								<input type="file" id="file_label_sod" class="" data-idx="<?=$info['sponsorship_official_docs']?>">
								<input type="text" readonly class="file_name" value="<?=$info['fi_sod_original_name']?>">
								<label for="file_label_sod">파일선택</label>
							</td>
						</tr>
						<tr>
							<th>Business License</th>
							<td class="file_up_wrap">
								<input type="file" id="file_label_bl" class="" data-idx="<?=$info['business_license']?>">
								<input type="text" readonly class="file_name" value="<?=$info['fi_bl_original_name']?>">
								<label for="file_label_bl">파일선택</label>
							</td>
						</tr>
						<tr>
							<th>Copy of a Bankbook</th>
							<td class="file_up_wrap">
								<input type="file" id="file_label_cob" class="" data-idx="<?=$info['copy_of_bankbook']?>">
								<input type="text" readonly class="file_name" value="<?=$info['fi_cob_original_name']?>">
								<label for="file_label_cob">파일선택</label>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="table_title">Information</p>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>Important dates(영문)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="important_dates_en"><?=htmlspecialchars_decode(stripslashes($info["important_dates_en"]))?></textarea></td>
						</tr>
						<tr>
							<th>Important dates(국문)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="important_dates_ko"><?=htmlspecialchars_decode(stripslashes($info["important_dates_ko"]))?></textarea></td>
						</tr>
						<tr>
							<th>How to apply(영문)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="how_to_apply_en"><?=htmlspecialchars_decode(stripslashes($info["how_to_apply_en"]))?></textarea></td>
						</tr>
						<tr>
							<th>How to apply(국문)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="how_to_apply_ko"><?=htmlspecialchars_decode(stripslashes($info["how_to_apply_ko"]))?></textarea></td>
						</tr>
						<tr>
							<th>Procedure(영문)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="procedure_en"><?=htmlspecialchars_decode(stripslashes($info["procedure_en"]))?></textarea></td>
						</tr>
						<tr>
							<th>Procedure(국문)</th>
							<td><textarea class="textarea_editor" placeholder="textarea" name="procedure_ko"><?=htmlspecialchars_decode(stripslashes($info["procedure_ko"]))?></textarea></td>
						</tr>
						<tr>
							<th>Contact Information(영문)</th>
							<td><?=editor_html("contact_info_en", htmlspecialchars_decode(stripslashes($info["contact_info_en"])));?></td>
						</tr>
						<tr>
							<th>Contact Information(국문)</th>
							<td><?=editor_html("contact_info_ko", htmlspecialchars_decode(stripslashes($info["contact_info_ko"])));?></td>
						</tr>
						<tr>
							<th>Contact for sponsorship</th>
							<td><?=editor_html("contact_for_sponsorship", htmlspecialchars_decode(stripslashes($info["contact_for_sponsorship"])));?></td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php
				if($admin_permission["auth_page_sponsorship"] > 1){
			?>
			<div class="btn_wrap">
				<button type="button" class="btn save_btn">저장</button>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</section>
<script src="./js/common.js"></script>
<script>
	// 파일 업로드 감지
	$("input[type=file]").on("change",function(e){
		var file = e.target.files[0]; // 단일 파일업로드만 고려된 개발
		var label = $(this).siblings("input[type=text]");
		/*if(!file.type.match('image')){
			alert("이미지 파일만 가능합니다");
		} else */
		if(file && file != "" && typeof(file) != "undefined"){
			label.val(file.name);
		}

		return false;
	});

	// 저장
	$('.save_btn').click(function(){
		var fi_sod = inputFileEmpty("file_label_sod");
		var fi_bl = inputFileEmpty("file_label_bl");
		var fi_cob = inputFileEmpty("file_label_cob");

		var input_data = {
			welcome_msg_en			:	$('[name=welcome_msg_en]').val(),
			welcome_msg_ko			:	$('[name=welcome_msg_ko]').val(),
			important_dates_en		:	$('[name=important_dates_en]').val(),
			important_dates_ko		:	$('[name=important_dates_ko]').val(),
			how_to_apply_en			:	$('[name=how_to_apply_en]').val(),
			how_to_apply_ko			:	$('[name=how_to_apply_ko]').val(),
			procedure_en			:	$('[name=procedure_en]').val(),
			procedure_ko			:	$('[name=procedure_ko]').val(),
			contact_info_en			:	$('[name=contact_info_en]').val(),
			contact_info_ko			:	$('[name=contact_info_ko]').val(),
			contact_for_sponsorship	:	$('[name=contact_for_sponsorship]').val()
		};
		<?php
			echo get_editor_js("contact_info_en");
			echo get_editor_js("contact_info_ko");
			echo get_editor_js("contact_for_sponsorship");
		?>

		console.log(fi_sod);
		console.log(fi_bl);
		console.log(fi_cob);

		if (!input_data.welcome_msg_en) {
			alert('Message for Abstract(영문)을 입력해주세요.');
			return false;

		} else if (!input_data.welcome_msg_ko) {
			alert('Message for Abstract(국문)를 입력해주세요.');
			return false;

		} else if (fi_sod.verify_fail) {
			alert('Sponsorship Official Document 파일을 등록해주세요.');
			return false;

		} else if (fi_bl.verify_fail) {
			alert('Business License 파일을 등록해주세요.');
			return false;

		} else if (fi_cob.verify_fail) {
			alert('Copy of a Bankbook 파일을 등록해주세요.');
			return false;

		} else if (!input_data.important_dates_en) {
			alert('Important dates(영문)를 입력해주세요.');
			return false;

		} else if (!input_data.important_dates_ko) {
			alert('Important dates(국문)를 입력해주세요.');
			return false;

		} else if (!input_data.how_to_apply_en) {
			alert('How to apply(영문)을 입력해주세요.');
			return false;

		} else if (!input_data.how_to_apply_ko) {
			alert('How to apply(국문)를 입력해주세요.');
			return false;

		} else if (!input_data.procedure_en) {
			alert('Procedure(영문)를 입력해주세요.');
			return false;

		} else if (!input_data.procedure_ko) {
			alert('Procedure(국문)를 입력해주세요.');
			return false;

		}
		<?php
			echo chk_editor_js("contact_info_en");
			echo chk_editor_js("contact_info_ko");
			echo chk_editor_js("contact_for_sponsorship");
		?>

		if (confirm('저장하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "save_overview");

			form_data.append("welcome_msg_en",			input_data.welcome_msg_en);
			form_data.append("welcome_msg_ko",			input_data.welcome_msg_ko);

			if (!fi_sod.current_empty) {
				form_data.append('fi_sod',				fi_sod.fi_obj);
			}
			if (!fi_bl.current_empty) {
				form_data.append('fi_bl',				fi_bl.fi_obj);
			}
			if (!fi_cob.current_empty) {
				form_data.append('fi_cob',				fi_cob.fi_obj);
			}

			form_data.append("important_dates_en",		input_data.important_dates_en);
			form_data.append("important_dates_ko",		input_data.important_dates_ko);
			form_data.append("how_to_apply_en",			input_data.how_to_apply_en);
			form_data.append("how_to_apply_ko",			input_data.how_to_apply_ko);
			form_data.append("procedure_en",			input_data.procedure_en);
			form_data.append("procedure_ko",			input_data.procedure_ko);
			form_data.append("contact_info_en",			contact_info_en_editor_data);
			form_data.append("contact_info_ko",			contact_info_ko_editor_data);

			form_data.append("contact_for_sponsorship",	contact_for_sponsorship_editor_data);

			$.ajax({
				url : "../ajax/admin/ajax_info_sponsorship.php",
				type : "POST",
				data : form_data,
				contentType : false,
				processData : false,
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

	// 빈값 확인 함수
	function inputFileEmpty(id){
		var origin_empty = $('#'+id).data('idx') == "0";
		var current_empty = !document.getElementById(id).value;

		var res = {
			origin_empty : origin_empty,
			current_empty : current_empty,
			verify_fail : (origin_empty && current_empty),
			fi_obj : $('#'+id)[0].files[0]
		}

		return res;
	}
</script>
<?php include_once('./include/footer.php');?>