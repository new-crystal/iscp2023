<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_main"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$sql_info =	"SELECT
					b.pc_en_img,
					fi_pc_en.original_name AS pc_en_original_name,
					b.mo_en_img,
					fi_mo_en.original_name AS mo_en_original_name,
					b.pc_ko_img,
					fi_pc_ko.original_name AS pc_ko_original_name,
					b.mo_ko_img,
					fi_mo_ko.original_name AS mo_ko_original_name
				FROM banner AS b
				LEFT JOIN `file` AS fi_pc_en
					ON fi_pc_en.idx = b.pc_en_img
				LEFT JOIN `file` AS fi_mo_en
					ON fi_mo_en.idx = b.mo_en_img
				LEFT JOIN `file` AS fi_pc_ko
					ON fi_pc_ko.idx = b.pc_ko_img
				LEFT JOIN `file` AS fi_mo_ko
					ON fi_mo_ko.idx = b.mo_ko_img
				WHERE b.idx = ".$_GET['idx'];
	$info = sql_fetch($sql_info);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">메인페이지 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table class="mein_set_table">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>PC 이미지(영문) *</th>
								<td class="file_up_wrap">
									<input type="file" id="file_label" class="" accept="image/*" data-idx="<?=$info['pc_en_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['pc_en_original_name']?>">
									<label for="file_label">파일선택</label>
								</td>
							</tr>
							<tr>
								<th>모바일 이미지(영문) *</th>
								<td class="file_up_wrap">
									<input type="file" id="file_label_mo" class="file_costom" accept="image/*" data-idx="<?=$info['mo_en_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['mo_en_original_name']?>">
									<label for="file_label_mo">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="mein_set_table">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>PC 이미지(국문) *</th>
								<td class="file_up_wrap">
									<input type="file" id="file_label_k" class="file_costom" accept="image/*" data-idx="<?=$info['pc_ko_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['pc_ko_original_name']?>">
									<label for="file_label_k">파일선택</label>
								</td>
							</tr>
							<tr>
								<th>모바일 이미지(국문) *</th>
								<td class="file_up_wrap">
									<input type="file" id="file_label_mo_k" class="file_costom" accept="image/*" data-idx="<?=$info['mo_ko_img']?>">
									<input type="text" readonly class="file_name" value="<?=$info['mo_ko_original_name']?>">
									<label for="file_label_mo_k">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="btn_wrap leftT">
						<button type="button" class="border_btn" onclick="location.href='./set_main.php'">목록</button>
						<?php
							if($admin_permission["auth_page_main"] > 1){
						?>
						<button id="reg_btn" type="button" class="btn save_btn">저장</button>
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
		var flm = inputFileEmpty("file_label_mo");
		var flk = inputFileEmpty("file_label_k");
		var flmk = inputFileEmpty("file_label_mo_k");

		if (fl.verify_fail) {
			alert('PC 이미지(영문) 파일을 등록해주세요.');

		} else if (flm.verify_fail) {
			alert('모바일 이미지(영문) 파일을 등록해주세요.');

		} else if (flk.verify_fail) {
			alert('PC 이미지(국문) 파일을 등록해주세요.');

		} else if (flmk.verify_fail) {
			alert('모바일 이미지(국문) 파일을 등록해주세요.');

		} else if (confirm('메인페이지 배너 파일을 변경하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "save");
			form_data.append("idx", "<?=$_GET['idx']?>");

			if (!fl.current_empty) {
				form_data.append('pc_en',	$('#file_label')[0].files[0]);
			}
			if (!flm.current_empty) {
				form_data.append('mo_en',	$('#file_label_mo')[0].files[0]);
			}
			if (!flk.current_empty) {
				form_data.append('pc_ko',	$('#file_label_k')[0].files[0]);
			}
			if (!flmk.current_empty) {
				form_data.append('mo_ko',	$('#file_label_mo_k')[0].files[0]);
			}

			$.ajax({
				url : "../ajax/admin/ajax_banner.php",
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
			verify_fail : (origin_empty && current_empty)
		}

		return res;
	}
</script>
<?php include_once('./include/footer.php');?>