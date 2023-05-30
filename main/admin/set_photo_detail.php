<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_general"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$is_modify = isset($_GET['y']);
	$year = $_GET['y'] ?? 0;

	$photo_query = "
						SELECT 
							pg.idx, 
							fi.path, 
							CONCAT(fi.path, '/', fi.save_name) AS url
						FROM photo_gallery AS pg
						LEFT JOIN `file` AS fi 
							ON fi.idx = pg.img
						WHERE pg.is_deleted = 'N' 
						AND pg.`year` = '".$y."'
					";
	$photo_list = get_data($photo_query);
?>
	<section class="list">
		<div class="container photo_create">
			<div class="title clearfix">
				<h1 class="font_title">Photo Gallery 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table>
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th class="centerT">Year</th>
								<td>
									<select name="year" id="" <?=$is_modify ? "disabled" : ""?>>
										<?php
											if ($is_modify) {
										?>
										<option><?=$year?></option>
										<?php
											} else {
												for ($y=2014;$y<=2030;$y++) {
													$cnt_query = "
																	SELECT 
																		COUNT(idx) AS cnt 
																	FROM photo_gallery 
																	WHERE is_deleted = 'N' 
																	AND `year` = '".$y."'
																";
													if (sql_fetch($cnt_query)['cnt'] <= 0) {
										?>
										<option><?=$y?></option>
										<?php
													}
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th class="centerT">이미지</th>
								<td class="file_up_wrap img_file">
									<input type="file" id="file_label_mo" class="" name="upload[]" multiple accept="image/*";>
									<input type="text" readonly disabled class="file_name">
									<label for="file_label_mo">파일선택</label>
									<div id="preview">
										<ul>
											<?php
												if (count($photo_list) > 0) {
													foreach($photo_list as $pt){
											?>
											<li data-idx="<?=$pt['idx']?>" data-flag=""><img src="<?=$pt['url']?>"/><i class="icon_delete"></i></li>
											<?php
													}
												}
											?>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="btn_wrap leftT">
						<button type="button" class="border_btn" onclick="location.href='./set_photo.php'">뒤로가기</button>
						<?php
							if($admin_permission["auth_page_general"] > 1){
								if($is_modify){
						?>
						<button id="del_btn" type="button" class="btn gray_btn" name="remove">삭제</button>
						<?php
								}
						?>
						<button id="reg_btn" type="button" class="btn save_btn" name="save">저장</button>
						<?php
							}
						?>
					</div>
				</form>
			</div>
		</div>
	</section>

<script src="./js/common.js"></script>
<script>
	// 등록 이미지 등록 미리보기
	var upload_files = [];
	$("#file_label_mo").on('change', function(evt){
		var _this = this;
		if(_this.files && _this.files[0]) {

			var fi_arr =Array.prototype.slice.call(evt.target.files);

			var img_flag = true;
			fi_arr.forEach(function(f){
				if(!f.type.match('image.*')){
					img_flag = false;
				}
			});
			if (!img_flag) {
				alert("이미지만 업로드 가능합니다.");
				return false;
			}

			if (fi_arr.length > 10 || (upload_files.length + fi_arr.length) > 10) {
				alert("최대 10장까지 업로드 가능합니다.");
				return false;
			}

			var uf_count = 0;
			fi_arr.forEach(function(f){
				if (upload_files.length < 10) {

					var reader = new FileReader();
					reader.onload = function (e) {
						upload_files.push(f);
						uf_count = upload_files.length;
						//console.log(upload_files);
						$('#preview ul').append('<li data-idx="" data-flag="insert"><img src='+ e.target.result +'><i class="icon_delete"></i></li>');
					}
					reader.readAsDataURL(f);
				}
			});
		}
	});

	/* 포토갤러리 > 상세 > 사진삭제 */
	$('#preview ul').on("click", ".icon_delete", function(){
		if (confirm('삭제하시겠습니까?')) {
			var _this_parent_li = $(this).parents('li');
			var flag = _this_parent_li.data('flag');
			if (flag == "insert") {
				_this_parent_li.remove();
				upload_files.splice(_this_parent_li.data('uf'), 1);
			} else {
				_this_parent_li.data('flag', 'delete').hide();
			}
		}
	});

	// 삭제
	$('[name=remove]').click(function(){
		if (confirm("삭제하시겠습니까?")) {
			upload_files = [];
			$('#preview ul li').each(function(){
				if ($(this).data("flag") == "insert") {
					$(this).remove();
				} else {
					$(this).data('flag', 'delete');
				}
			});
			save();
		}
	});

	// 저장
	$('[name=save]').click(function(){
		var is_modify = '<?=$is_modify?>';
		var file_count = is_modify ? ($('#preview li').length - $('#preview li[data-flag=delete]').length) : upload_files.length;

		if (file_count <= 0) {
			alert("업로드할 파일을 1개 이상 선택해주세요.");
		} else if (confirm("저장하시겠습니까?")) {
			save();
		}
	});

	// 저장처리 함수
	function save(){
		var form_data = new FormData();

		var year = $('select[name=year] option:selected').val();
		var photo_arr = new Array();
		var photo_exist = false;
		var photoes = '';
		var temp_this, temp_text;

		$('#preview li').each(function(){
			temp_this = $(this);
			if (temp_this.data("flag") != "delete") {
				photo_exist = true;
			}
			temp_text = temp_this.data("flag") + "|" + temp_this.data("idx");
			photo_arr.push(temp_text);
		});
		photoes = photo_arr.join('^&');

		form_data.append("flag", "save_photo");
		form_data.append("year", year);
		form_data.append("photo_exist", photo_exist);
		form_data.append("photoes", photoes);

		upload_files.forEach(function(el, index){
			form_data.append("fi_"+index, el);
		});

		$.ajax({
			url : "../ajax/admin/ajax_info_general.php",
			type : "POST",
			dataType : "JSON",
			contentType : false,
			processData : false,
			data : form_data,
			success : function(res) {
				if(res.code == 200){
					alert("저장이 완료되었습니다.");
					location.replace('/main/admin/set_photo.php');
				} else{
					alert(res.msg);
				}
			}
		});
	}
</script>
<?php include_once('./include/footer.php');?>