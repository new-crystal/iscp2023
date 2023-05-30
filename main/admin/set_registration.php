<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_registration"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// registration 공통정보는 생성이 없어서 별도로 생성해주어야함
	$info_registration_exist = sql_fetch("SELECT COUNT(modify_admin_idx) AS cnt FROM info_registration")['cnt'];
	if (!$info_registration_exist) {
		$sql_info_registration_insert =	"INSERT INTO 
											info_registration 
											(bank_name_en, account_number_en, account_holder_en, address_en, score_pop_en_img, bank_name_ko, account_number_ko, account_holder_ko, address_ko, score_pop_ko_img) 
										VALUES
											('', '', '', '', 0, '', '', '', '', 0)";
		sql_query($sql_info_registration_insert);
	}

	$sql_info =	"SELECT
					ir.bank_name_en, ir.account_number_en, ir.account_holder_en, ir.address_en, ir.score_pop_en_img, 
					fi_en.original_name AS en_original_name,
					ir.bank_name_ko, ir.account_number_ko, ir.account_holder_ko, ir.address_ko, ir.score_pop_ko_img, 
					fi_ko.original_name AS ko_original_name
				FROM info_registration AS ir
				LEFT JOIN `file` AS fi_en
					ON fi_en.idx = ir.score_pop_en_img
				LEFT JOIN `file` AS fi_ko
					ON fi_ko.idx = ir.score_pop_ko_img";
	$info = sql_fetch($sql_info);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">Registration 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Bank Name(영문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="bank_name_en" value="<?=$info['bank_name_en']?>"></td>
								<th>Account Number(영문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="account_number_en" value="<?=$info['account_number_en']?>"></td>
							</tr>
							<tr>
								<th>Account Holder(영문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="account_holder_en" value="<?=$info['account_holder_en']?>"></td>
								<th>Address(영문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="address_en" value="<?=$info['address_en']?>"></td>
							</tr>
							<tr>
								<th>평점안내 팝업(영문)</th>
								<td class="file_up_wrap" colspan="3">
									<input type="file" id="file_label" class="" accept="image/*" data-idx="<?=$info['score_pop_en_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['en_original_name']?>">
									<label for="file_label">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Bank Name(국문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="bank_name_ko" value="<?=$info['bank_name_ko']?>"></td>
								<th>Account Number(국문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="account_number_ko" value="<?=$info['account_number_ko']?>"></td>
							</tr>
							<tr>
								<th>Account Holder(국문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="account_holder_ko" value="<?=$info['account_holder_ko']?>"></td>
								<th>Address(국문)</th>
								<td><input type="text" placeholder="100자 이내" maxlength="100" name="address_ko" value="<?=$info['address_ko']?>"></td>
							</tr>
							<tr>
								<th>평점안내 팝업(국문)</th>
								<td class="file_up_wrap" colspan="3">
									<input type="file" id="file_label_ko" class="" accept="image/*" data-idx="<?=$info['score_pop_ko_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['ko_original_name']?>">
									<label for="file_label_ko">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_registration"] > 1){
					?>
					<div class="btn_wrap leftT">
						<button type="button" class="btn save_btn">저장</button>
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
	// 파일 업로드 감지
	$("input[type=file]").on("change",function(e){
		var file = e.target.files[0]; // 단일 파일업로드만 고려된 개발
		var label = $(this).siblings("input[type=text]");
		if(!file.type.match('image')){
			alert("이미지 파일만 가능합니다");
		} else if(file && file != "" && typeof(file) != "undefined"){
			label.val(file.name);
		}

		return false;
	});

	// 저장
	$('.save_btn').click(function(){
		var fl = inputFileEmpty("file_label");
		var flk = inputFileEmpty("file_label_ko");

		var input_data = {
			bank_name_en		:	$('[name=bank_name_en]').val(),
			account_number_en	:	$('[name=account_number_en]').val(),
			account_holder_en	:	$('[name=account_holder_en]').val(),
			address_en			:	$('[name=address_en]').val(),
			bank_name_ko		:	$('[name=bank_name_ko]').val(),
			account_number_ko	:	$('[name=account_number_ko]').val(),
			account_holder_ko	:	$('[name=account_holder_ko]').val(),
			address_ko			:	$('[name=address_ko]').val()
		};

		if (!input_data.bank_name_en) {
			alert('Bank Name(영문)을 입력해주세요.');

		} else if (!input_data.account_number_en) {
			alert('Account Number(영문)를 입력해주세요.');

		} else if (!input_data.account_holder_en) {
			alert('Account Holder(영문)를 입력해주세요.');

		} else if (!input_data.address_en) {
			alert('Address(영문)를 입력해주세요.');

		} else if (fl.verify_fail) {
			alert('평점안내 팝업(영문) 파일을 등록해주세요.');

		} else if (!input_data.bank_name_ko) {
			alert('Bank Name(국문)을 입력해주세요.');

		} else if (!input_data.account_number_ko) {
			alert('Account Number(국문)를 입력해주세요.');

		} else if (!input_data.account_holder_ko) {
			alert('Account Holder(국문)를 입력해주세요.');

		} else if (!input_data.address_ko) {
			alert('Address(국문)를 입력해주세요.');

		} else if (flk.verify_fail) {
			alert('평점안내 팝업(국문) 파일을 등록해주세요.');

		} else if (confirm('저장하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "save_registration");

			form_data.append("bank_name_en",		input_data.bank_name_en);
			form_data.append("account_number_en",	input_data.account_number_en);
			form_data.append("account_holder_en",	input_data.account_holder_en);
			form_data.append("address_en",			input_data.address_en);
			if (!fl.current_empty) {
				form_data.append('fi_en',	fl.fi_obj);
			}

			form_data.append("bank_name_ko",		input_data.bank_name_ko);
			form_data.append("account_number_ko",	input_data.account_number_ko);
			form_data.append("account_holder_ko",	input_data.account_holder_ko);
			form_data.append("address_ko",			input_data.address_ko);
			if (!flk.current_empty) {
				form_data.append('fi_ko',	flk.fi_obj);
			}

			$.ajax({
				url : "../ajax/admin/ajax_info_registration.php",
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