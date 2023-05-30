<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../plugin/editor/smarteditor2/editor.lib.php');

	if($admin_permission["auth_page_general"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// overview
	$sql_detail =	"
						SELECT 
							ig.*,
							fi_poster_en.original_name AS fi_poster_en_original_name,
							fi_wms_en.original_name AS fi_wms_en_original_name,
							fi_poster_ko.original_name AS fi_poster_ko_original_name,
							fi_wms_ko.original_name AS fi_wms_ko_original_name
						FROM info_general AS ig
						LEFT JOIN `file` AS fi_poster_en
							ON fi_poster_en.idx = ig.overview_poster_en_img
						LEFT JOIN `file` AS fi_wms_en
							ON fi_wms_en.idx = ig.overview_welcome_sign_en_img
						LEFT JOIN `file` AS fi_poster_ko
							ON fi_poster_ko.idx = ig.overview_poster_ko_img
						LEFT JOIN `file` AS fi_wms_ko
							ON fi_wms_ko.idx = ig.overview_welcome_sign_ko_img
					";
	$detail = sql_fetch($sql_detail);

	// venue_floor
	$sql_venue_floor =	"
							SELECT 
								* 
							FROM info_general_venue_floor 
							WHERE is_deleted = 'N' 
							ORDER BY idx
						";
	$venue_floor = get_data($sql_venue_floor);

	// venue_floor_img
	$sql_venue_floor_img = "
								SELECT 
									igvfi.*,
									CONCAT(igvf.name_en,'/',igvf.name_ko) AS floor_name_text,
									fi.original_name as fi_original_name
								FROM info_general_venue_floor_img AS igvfi
								LEFT JOIN info_general_venue_floor AS igvf
									ON igvf.idx = igvfi.floor_idx
								LEFT JOIN `file` AS fi
									on fi.idx = igvfi.img
								WHERE igvfi.is_deleted = 'N' 
								ORDER BY igvfi.floor_idx
							";
	$venue_floor_img = get_data($sql_venue_floor_img);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">General Information 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li class="active"><a href="javascript:;">Overview</a></li>
						<li><a href="./set_organizing.php">Organizing Committee</a></li>
						<li><a href="./set_venue.php">Venue</a></li>
						<li><a href="./set_photo.php">Photo Gallery</a></li>
					</ul>
				</div>
				<form name="search_form">
					<table class="overview">
						<colgroup>
							<col width="200px">
							<col width="*">
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Organized By(영문)</th>
								<td><input type="text" placeholder="100자이내" name="organized_en" maxlength="100" value="<?=$detail['overview_organized_en']?>"></td>
								<th>Theme(영문)</th>
								<td><input type="text" placeholder="100자이내" name="theme_en" maxlength="100" value="<?=$detail['overview_theme_en']?>"></td>
							</tr>
							<tr>
								<th>Official Language(영문)</th>
								<td><input type="text" placeholder="100자이내" name="official_language_en" maxlength="100" value="<?=$detail['overview_official_language_en']?>"></td>
								<th>Secretariat(영문)</th>
								<td><input type="text" placeholder="100자이내" name="secretariat_en" maxlength="100" value="<?=$detail['overview_secretariat_en']?>"></td>
							</tr>
							<tr>
								<th>Poster(영문)</th>
								<td class="file_up_wrap" colspan="3">
									<input type="file" id="fi_poster_en" class="" accept="image/*" data-idx="<?=$detail['overview_poster_en_img']?>">
									<input type="text" readonly class="file_name" value="<?=$detail['fi_poster_en_original_name']?>">
									<label for="fi_poster_en">파일선택</label>
								</td>
							</tr>
							<tr>
								<th>Welcome Message(영문)</th>
								<td colspan="3">
									<?=editor_html("welcome_msg_en", htmlspecialchars_decode(stripslashes($detail["overview_welcome_msg_en"])));?>
								</td>
							</tr>
							<tr>
								<th>Welcome Message Sign(영문)</th>
								<td class="file_up_wrap" colspan="3">
									<input type="file" id="fi_wms_en" class="" accept="image/*" data-idx="<?=$detail['overview_welcome_sign_en_img']?>">
									<input type="text" readonly class="file_name" value="<?=$detail['fi_wms_en_original_name']?>">
									<label for="fi_wms_en">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="overview">
						<colgroup>
							<col width="200px">
							<col width="*">
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Organized By(국문)</th>
								<td><input type="text" placeholder="100자이내" name="organized_ko" maxlength="100" value="<?=$detail['overview_organized_ko']?>"></td>
								<th>Theme(국문)</th>
								<td><input type="text" placeholder="100자이내" name="theme_ko" maxlength="100" value="<?=$detail['overview_theme_ko']?>"></td>
							</tr>
							<tr>
								<th>Official Language(국문)</th>
								<td><input type="text" placeholder="100자이내" name="official_language_ko" maxlength="100" value="<?=$detail['overview_official_language_ko']?>"></td>
								<th>Secretariat(국문)</th>
								<td><input type="text" placeholder="100자이내" name="secretariat_ko" maxlength="100" value="<?=$detail['overview_secretariat_ko']?>"></td>
							</tr>
							<tr>
								<th>Poster(국문)</th>
								<td class="file_up_wrap" colspan="3">
									<input type="file" id="fi_poster_ko" class="" accept="image/*" data-idx="<?=$detail['overview_poster_ko_img']?>">
									<input type="text" readonly class="file_name" value="<?=$detail['fi_poster_ko_original_name']?>">
									<label for="fi_poster_ko">파일선택</label>
								</td>
							</tr>
							<tr>
								<th>Welcome Message(국문)</th>
								<td colspan="3">
									<?=editor_html("welcome_msg_ko", htmlspecialchars_decode(stripslashes($detail["overview_welcome_msg_ko"])));?>
								</td>
							</tr>
							<tr>
								<th>Welcome Message Sign(국문)</th>
								<td class="file_up_wrap" colspan="3">
									<input type="file" id="fi_wms_ko" class="" accept="image/*" data-idx="<?=$detail['overview_welcome_sign_ko_img']?>">
									<input type="text" readonly class="file_name" value="<?=$detail['fi_wms_ko_original_name']?>">
									<label for="fi_wms_ko">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<table>
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Venue Information</th>
								<td colspan="3" class="clearfix">
									<div class="tag_input floatL">
										<input type="text" class="tag_input" placeholder="Venue 이름">
										<button type="button" class="border_btn tag_add">추가</button>
									</div>
									<ul class="tag_list floatL">
										<!-- <li>1234<i></i></li> -->
										<?php
											foreach($venue_floor as $vf){
										?>
										<li data-flag="" data-idx="<?=$vf['idx']?>"><?=$vf['name_en']."/".$vf['name_ko']?><i></i></li>
										<?php
											}
										?>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="venue_floor">
						<colgroup>
							<col width="400px">
							<col width="*">
							<col width="100px">
						</colgroup>
						<thead>
							<tr class="tr_center">
								<th>Venue Information</th>
								<th>이미지</th>
								<th>관리</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($venue_floor_img as $vfi){
							?>
							<tr data-flag="" data-idx="<?=$vfi['idx']?>" data-floor="<?=$vfi['floor_idx']?>" data-arr="">
								<td>
									<select name="" id=""><option><?=$vfi['floor_name_text']?></option></select>
								</td>
								<td class="file_up_wrap">
									<input type="text" readonly class="file_name big" value="<?=$vfi['fi_original_name']?>">
								</td>
								<td>
									<button type="button" class="border_btn file_remove">삭제</button>
								</td>
							</tr>
							<?php
								}
							?>
							<tr>
								<td>
									<select name="vf" id="">
										<!--<option value="">3F Grand Ballroom / 3층 그랜드볼룸</option>-->
										<?php
											foreach($venue_floor as $vf){
										?>
										<option value="<?=$vf['idx']?>"><?=$vf['name_en']."/".$vf['name_ko']?></option>
										<?php
											}
										?>
									</select>
								</td>
								<td class="file_up_wrap">
									<input type="file" id="fi_floor" class="" accept="image/*">
									<input type="text" readonly class="file_name big">
									<label for="fi_floor">파일선택</label>
								</td>
								<td><button type="button" class="border_btn file_add">추가</button></td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_general"] > 1){
					?>
					<div class="btn_wrap leftT">
						<button type="button" class="btn" name="save">저장</button>
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
	// overview - input text 유효성
	$(".overview input[type=text]").on("change",function(e){
		var val = $(this).val();
		$(this).val(val.substr(0,100));
	});

	// overview - input file 유효성
	$(".overview input[type=file]").on("change",function(e){
		var file = e.target.files[0];
		var label = $(this).siblings("input[type=text]");
		if(!file.type.match('image')){
			alert("이미지 파일만 가능합니다");
			$(this).val("");
			label.val("");
		} else if(file && file != "" && typeof(file) != "undefined"){
			label.val(file.name);
		}

		return false;
	});

	// venue_floor - 층 추가
	var dur_input_enter = false;
	$('.tag_add').click(function(){
		var name = $('input[type=text].tag_input').val();
		var name_arr = name.split('/');

		if ($('.tag_list li').length === 5) {
			alert("최대 5개까지 저장 가능합니다.");

		} else if (!name) {
			alert("Venue Information을 입력해주세요.");

		} else if (name_arr.length !== 2) {
			alert("영문,국문을 /로 구분해주세요.\n(예시 : 3F Grand Ballroom/3층 그랜드볼룸)");

		} else {
			$('.tag_list').append('<li data-flag="insert" data-idx="TEMP' + random_text() + '">' + name + '<i></i></li>');

			$('input[type=text].tag_input').val("");

			set_venue_floor_select();
		}
	});

	// venue_floor - 층 삭제
	$(document).on('click', '.tag_list li i', function(){
		if ($('.tag_list li').length-1 === 0) {
			alert("모든 요소를 삭제할 수 없습니다.");

		} else if (confirm("해당 층으로 등록한 이미지도 모두 삭제 처리됩니다.\n삭제하시겠습니까?")) {
			var parent_tr = $(this).parent();
			if (parent_tr.data('flag') == "insert") {
				parent_tr.remove();
			} else {
				parent_tr.data('flag', 'delete').hide();
			}

			var temp_tr;
			$('.file_remove').each(function(){
				temp_tr = $(this).parents('tr');
				if (temp_tr.data("floor") == parent_tr.data("idx")) {
					if (temp_tr.data('flag') == "insert") {
						temp_tr.remove();
					} else {
						temp_tr.data('flag', 'delete').hide();
					}
				}
			});

			set_venue_floor_select();
		}
	});

	// venue_floor - 층 업데이트에 따른 select 반영
	function set_venue_floor_select(){
		var temp_this;
		var select_inner = "";
		$('.tag_list li').each(function(){
			temp_this = $(this);
			if (temp_this.data('flag') != "delete") {
				select_inner += '<option value="' + temp_this.data('idx') + '">' + temp_this.text() + '</option>';
			}
		});
		$('[name=vf]').html(select_inner);
	}

	// venue_floor - input file 유효성
	var upload_files = [];
	$(document).on("change", ".venue_floor input[type=file]", function(e){
		var file = e.target.files[0];
		var label = $(this).siblings("input[type=text]");
		if(!file.type.match('image')){
			alert("이미지 파일만 가능합니다");
			$(this).val("");
			label.val("");
		} else if(file && file != "" && typeof(file) != "undefined"){
			label.val(file.name);
			upload_files.push(file);
			$(this).data("arr", (upload_files.length-1));
		}

		return false;
	});

	// venue_floor - 파일 추가
	$('.file_add').click(function(){
		var select = $('select[name=vf] option:selected');
		var fi = chk_file_empty("fi_floor");

		if ($("tr[data-floor=" + select.val() + "]").length - $("tr[data-flag=delete][data-floor=" + select.val() + "]").length >= 10) {
			alert('최대 10개까지 등록 가능합니다.');

		} else if (!select.val()) {
			alert("Venue Information을 선택해주세요.");

		} else if (fi.current_empty) {
			alert('이미지 파일을 등록해주세요.');

		} else {
			var arr = $(".venue_floor input[type=file]").data("arr");
			var inner = '<tr data-flag="insert" data-idx="" data-floor="' + select.val() + '" data-arr="' + arr + '"><td><select name="" id=""><option>' + select.text() + '</option></select></td><td class="file_up_wrap"><input type="text" readonly class="file_name big" value="' + upload_files[arr].name + '"></td><td><button type="button" class="border_btn file_remove">삭제</button></td></tr>';
			$(this).parents('tr').before(inner);

			$('#fi_floor').val("");
			$('#fi_floor').siblings('.file_name').val("");
		}
	});

	// venue_floor - 파일 삭제
	$(document).on("click", ".file_remove", function(e){
		var select = $('select[name=vf] option:selected');
		var fi = chk_file_empty("fi_floor");

		if (confirm("삭제하시겠습니까?")) {
			var parent_tr = $(this).parents('tr');
			if (parent_tr.data('flag') == "insert") {
				parent_tr.remove();
			} else {
				parent_tr.data('flag', 'delete').hide();
			}
		}
	});

	// 저장
	$('button[name=save]').click(function(){
		var form_data = new FormData();

		/* overview */
		<?= get_editor_js("welcome_msg_en")?>
		<?= get_editor_js("welcome_msg_ko")?>

		var data_overview = {
			organized_en			: $('input[name=organized_en]').val(),
			theme_en				: $('input[name=theme_en]').val(),
			official_language_en	: $('input[name=official_language_en]').val(),
			secretariat_en			: $('input[name=secretariat_en]').val(),
			fi_poster_en			: chk_file_empty("fi_poster_en"),
			fi_wms_en				: chk_file_empty("fi_wms_en"),
			organized_ko			: $('input[name=organized_ko]').val(),
			theme_ko				: $('input[name=theme_ko]').val(),
			official_language_ko	: $('input[name=official_language_ko]').val(),
			secretariat_ko			: $('input[name=secretariat_ko]').val(),
			fi_poster_ko			: chk_file_empty("fi_poster_ko"),
			fi_wms_ko				: chk_file_empty("fi_wms_ko"),
		};

		if (!data_overview.organized_en) {
			alert('Organized By(영문)을 입력해주세요.');
			return false;

		} else if (!data_overview.theme_en) {
			alert('Theme(영문)을 입력해주세요.');
			return false;

		} else if (!data_overview.official_language_en) {
			alert('Official Language(영문)을 입력해주세요.');
			return false;

		} else if (!data_overview.secretariat_en) {
			alert('Secretariat(영문)을 입력해주세요.');
			return false;

		} else if (data_overview.fi_poster_en.verify_fail) {
			alert('Poster(영문) 파일을 등록해주세요.');
			return false;

		} else if (data_overview.fi_wms_en.verify_fail) {
			alert('Welcome Message Sign(영문) 파일을 등록해주세요.');
			return false;
		}
		<?=chk_editor_js("welcome_msg_en");?>

		if (!data_overview.organized_ko) {
			alert('Organized By(국문)을 입력해주세요.');

		} else if (!data_overview.theme_ko) {
			alert('Theme(국문)을 입력해주세요.');

		} else if (!data_overview.official_language_ko) {
			alert('Official Language(국문)을 입력해주세요.');

		} else if (!data_overview.secretariat_ko) {
			alert('Secretariat(국문)을 입력해주세요.');

		} else if (data_overview.fi_poster_ko.verify_fail) {
			alert('Poster(국문) 파일을 등록해주세요.');
			return false;

		} else if (data_overview.fi_wms_ko.verify_fail) {
			alert('Welcome Message Sign(국문)을 입력해주세요.');
			return false;
		}
		<?=chk_editor_js("welcome_msg_ko");?>
		/* //overview */

		/* venue */
		var floor_arr = new Array();
		var floor_exist = false;
		var floors = '';
		var temp_this, temp_text, temp_arr;

		$('.tag_list li').each(function(){
			temp_this = $(this);
			if (temp_this.data("flag") != "delete") {
				floor_exist = true;
			}
			temp_arr = temp_this.text().split('/');
			temp_text = temp_this.data("flag") + "|" + temp_this.data("idx") + "|" + temp_arr[0] + "|" + temp_arr[1];
			floor_arr.push(temp_text);
		});
		floors = floor_arr.join('^&');

		var floor_img_arr = new Array();
		var floor_img_exist = false;
		var floor_imgs = '';

		$('.file_remove').each(function(){
			temp_this = $(this).parents('tr');
			if (temp_this.data("flag") != "delete") {
				floor_img_exist = true;
			}
			temp_text = temp_this.data("flag") + "|" + temp_this.data("idx") + "|" + temp_this.data("floor") + "|" + temp_this.data("arr");
			floor_img_arr.push(temp_text);

			form_data.append("fi_"+temp_this.data("arr"), upload_files[temp_this.data("arr")]);
		});
		floor_imgs = floor_img_arr.join('^&');

		if (floor_arr.length <= 0 || floor_img_arr.length <= 0) {
			alert('Venue Information을 1개 이상 입력해주세요.');
			return false;
		}
		/* //venue */

		if (confirm("저장하시겠습니까?")) {
			form_data.append("flag", "save_overview");

			form_data.append("organized_en",			data_overview.organized_en);
			form_data.append("theme_en",				data_overview.theme_en);
			form_data.append("official_language_en",	data_overview.official_language_en);
			form_data.append("secretariat_en",			data_overview.secretariat_en);
			if (!data_overview.fi_poster_en.current_empty) {
				form_data.append('fi_poster_en',		data_overview.fi_poster_en.fi_obj);
			}
			form_data.append("welcome_msg_en",			welcome_msg_en_editor_data);
			if (!data_overview.fi_wms_en.current_empty) {
				form_data.append('fi_wms_en',			data_overview.fi_wms_en.fi_obj);
			}

			form_data.append("organized_ko",			data_overview.organized_ko);
			form_data.append("theme_ko",				data_overview.theme_ko);
			form_data.append("official_language_ko",	data_overview.official_language_ko);
			form_data.append("secretariat_ko",			data_overview.secretariat_ko);
			if (!data_overview.fi_poster_ko.current_empty) {
				form_data.append('fi_poster_ko',		data_overview.fi_poster_ko.fi_obj);
			}
			form_data.append("welcome_msg_ko",			welcome_msg_ko_editor_data);
			if (!data_overview.fi_wms_ko.current_empty) {
				form_data.append('fi_wms_ko',			data_overview.fi_wms_ko.fi_obj);
			}

			form_data.append("floor_exist", floor_exist);
			form_data.append("floors", floors);

			form_data.append("floor_img_exist", floor_img_exist);
			form_data.append("floor_imgs", floor_imgs);

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

	// overview - input file 빈값 확인 함수
	function chk_file_empty(id){
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

	// 난수 발생 함수
	function random_text(){
		var alphabet = "abcdefghijklmnopqrstuvwxyz";
		var num = "0123456789";

		var text1 = "";
		var text2 = "";
		for( var i=0; i < 4; i++ ) {
			text1 += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
			text2 += num.charAt(Math.floor(Math.random() * num.length));
		}

		return (text1+text2);
	}
</script>
<?php include_once('./include/footer.php');?>