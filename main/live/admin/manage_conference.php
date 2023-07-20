<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_conference"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$sql_info =	"SELECT
					fi_cb_en.original_name,
					CONCAT(fi_cb_en.path, '/', fi_cb_en.save_name) AS fi_conference_book_en
				FROM info_live AS il
				LEFT JOIN `file` AS fi_cb_en
					ON fi_cb_en.idx = il.conference_book_en_img";
	$info = sql_fetch($sql_info);
?>
<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix">
			<h1 class="font_title">Conference Program Book 관리</h1>
		</div>
		<!----- 컨텐츠 ----->
		<div class="contwrap has_fixed_title">
			<form name="search_form">
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>컨퍼런스 프로그램 북(영문)</th>
							<td class="file_up_wrap" colspan="3">
								<input type="file" id="cb_en" class="file_costom" accept=".pdf">
								<input type="text" readonly class="file_name" value="<?=$info['original_name']?>">
								<label for="cb_en">파일선택</label>
							</td>
							<!-- <th>컨퍼런스 프로그램 북(국문)</th>
							<td class="file_up_wrap">
								<input type="file" id="file_label_mo" class="file_costom">
								<input type="text" readonly class="file_name">
								<label for="file_label_mo">파일선택</label>
							</td> -->
						</tr>
					</tbody>
				</table>
			</form>
			<?php
				if($admin_permission["auth_live_conference"] > 1){
			?>
			<!-- 버튼 -->
			<div class="btn_wrap">
				<button type="button" class="btn save_btn">저장</button>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</section>
<script>
	// 파일 업로드 감지
	$("input[type=file]").on("change",function(e){
		var file = e.target.files[0]; // 단일 파일업로드만 고려된 개발
		var label = $(this).parent().find(".label");
		if(!file.type.match('pdf')){
			alert("pdf 파일만 가능합니다");
			return;
		}
		if(file && file != "" && typeof(file) != "undefined"){
			label.text(file.name);
		}
	});

	// 저장
	$('.save_btn').click(function(){
		if (!document.getElementById("cb_en").value) {
			alert('변경할 파일을 등록해주세요.');
		} else if (confirm('컨퍼런스 프로그램 북 파일을 변경하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "save_conference_book");
			form_data.append('cb_en',	$('#cb_en')[0].files[0]);

			$.ajax({
				url : "../ajax/admin/ajax_info_live.php",
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
</script>
<?php include_once('./include/footer.php');?>