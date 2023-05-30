<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_general"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$sql_info =	"SELECT
					fi_en.original_name AS en_original_name,
					igv.en_img, igv.name_en, igv.address_en, igv.tel_en, igv.homepage_en,
					fi_ko.original_name AS ko_original_name,
					igv.ko_img, igv.name_ko, igv.address_ko, igv.tel_ko, igv.homepage_ko
				FROM info_general_venue AS igv
				LEFT JOIN `file` AS fi_en
					ON fi_en.idx = igv.en_img
				LEFT JOIN `file` AS fi_ko
					ON fi_ko.idx = igv.ko_img";
	$info = sql_fetch($sql_info);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">General Information 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li><a href="./set_general.php">Overview</a></li>
						<li><a href="./set_organizing.php">Organizing Committee</a></li>
						<li class="active"><a href="javascript:;">Venue</a></li>
						<li><a href="./set_photo.php">Photo Gallery</a></li>
					</ul>
				</div>
				<form name="search_form">
					<table>
						<colgroup>
							<col width="200px">
							<col width="*">
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Venue Image(영문)</th>
								<td class="file_up_wrap">
									<input type="file" id="file_label" class="" accept="image/*" data-idx="<?=$info['en_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['en_original_name']?>">
									<label for="file_label">파일선택</label>
								</td>
								<th>Venue Name(영문)</th>
								<td><input type="text" placeholder="100자이내" maxlength="100" name="name_en" value="<?=$info['name_en']?>"></td>
							</tr>
							<tr>
								<th>Venue Address(영문)</th>
								<td><input type="text" placeholder="100자이내" maxlength="100" name="address_en" value="<?=$info['address_en']?>"></td>
								<th>Venue Tel(영문)</th>
								<td><input type="text" placeholder="100자이내" maxlength="100" name="tel_en" value="<?=$info['tel_en']?>"></td>
							</tr>
							<tr>
								<th>Website ENG(영문)</th>
								<td colspan="3"><input type="text" name="homepage_en" value="<?=$info['homepage_en']?>"></td>
							</tr>
						</tbody>
					</table>
					<table>
						<colgroup>
							<col width="200px">
							<col width="*">
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Venue Image(국문)</th>
								<td class="file_up_wrap">
									<input type="file" id="file_label_k" class="" accept="image/*" data-idx="<?=$info['ko_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['ko_original_name']?>">
									<label for="file_label_k">파일선택</label>
								</td>
								<th>Venue Name(국문)</th>
								<td><input type="text" placeholder="100자이내" maxlength="100" name="name_ko" value="<?=$info['name_ko']?>"></td>
							</tr>
							<tr>
								<th>Venue Address(국문)</th>
								<td><input type="text" placeholder="100자이내" maxlength="100" name="address_ko" value="<?=$info['address_ko']?>"></td>
								<th>Venue Tel(국문)</th>
								<td><input type="text" placeholder="100자이내" maxlength="100" name="tel_ko" value="<?=$info['tel_ko']?>"></td>
							</tr>
							<tr>
								<th>Website KOR(국문)</th>
								<td colspan="3"><input type="text" name="homepage_ko" value="<?=$info['homepage_ko']?>"></td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_general"] > 1){
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
		var flk = inputFileEmpty("file_label_k");

		var input_data = {
			name_en		:	$('[name=name_en]').val(),
			address_en	:	$('[name=address_en]').val(),
			tel_en		:	$('[name=tel_en]').val(),
			homepage_en	:	$('[name=homepage_en]').val(),
			name_ko		:	$('[name=name_ko]').val(),
			address_ko	:	$('[name=address_ko]').val(),
			tel_ko		:	$('[name=tel_ko]').val(),
			homepage_ko	:	$('[name=homepage_ko]').val()
		};

		if (fl.verify_fail) {
			alert('Venue 이미지(영문) 파일을 등록해주세요.');

		} else if (!input_data.name_en) {
			alert('Venue 이름(영문)을 입력해주세요.');

		} else if (!input_data.address_en) {
			alert('Venue 주소(영문)를 입력해주세요.');

		} else if (!input_data.tel_en) {
			alert('Venue 전화번호(영문)를 입력해주세요.');

		} else if (!input_data.homepage_en) {
			alert('Venue 홈페이지 주소(영문)를 입력해주세요.');

		} else if (flk.verify_fail) {
			alert('Venue 이미지(국문) 파일을 등록해주세요.');

		} else if (!input_data.name_ko) {
			alert('Venue 이름(국문)을 입력해주세요.');

		} else if (!input_data.address_ko) {
			alert('Venue 주소(국문)를 입력해주세요.');

		} else if (!input_data.tel_ko) {
			alert('Venue 전화번호(국문)를 입력해주세요.');

		} else if (!input_data.homepage_ko) {
			alert('Venue 홈페이지 주소(국문)를 입력해주세요.');

		} else if (confirm('저장하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "save_venue");

			if (!fl.current_empty) {
				form_data.append('fi_en',	fl.fi_obj);
			}
			form_data.append("name_en",		input_data.name_en);
			form_data.append("address_en",	input_data.address_en);
			form_data.append("tel_en",		input_data.tel_en);
			form_data.append("homepage_en",	input_data.homepage_en);

			if (!flk.current_empty) {
				form_data.append('fi_ko',	flk.fi_obj);
			}
			form_data.append("name_ko",		input_data.name_ko);
			form_data.append("address_ko",	input_data.address_ko);
			form_data.append("tel_ko",		input_data.tel_ko);
			form_data.append("homepage_ko",	input_data.homepage_ko);

			$.ajax({
				url : "../ajax/admin/ajax_info_general.php",
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