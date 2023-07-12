<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_abstract"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$idx = $_GET['idx'];
	$is_modify = isset($_GET['idx']);

	$info = array();
	if ($is_modify) {
		$sql_info =	"SELECT
						ab.*,
						IFNULL(fi_poster.original_name, '') AS abstract_poster_origin_name,
						IFNULL(fi_pdf.original_name, '') AS abstract_pdf_origin_name
					FROM abstract AS ab
					LEFT JOIN `file` AS fi_poster
						ON fi_poster.idx = ab.poster_img
					LEFT JOIN `file` AS fi_pdf
						ON fi_pdf.idx = ab.pdf_img
					WHERE ab.idx = '".$idx."'";
		$info = sql_fetch($sql_info);
	}

	// category list
	$sql_category_list =	"SELECT
								idx, title_en
							FROM info_poster_abstract_category
							WHERE is_deleted = 'N'
							ORDER BY idx ASC";
	$category_list = get_data($sql_category_list);
?>

	<section class="">
		<div class="container">
			<!-- 타이틀 -->
			<div class="title">
				<h1 class="font_title">Abstract 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<!-- 탭 -->
				<div class="tab_box">
					<?php
						if ($is_modify){
					?>
					<ul class="tab_wrap clearfix">
						<li class="active"><a href="javascript:;">기본정보</a></li>
						<li><a href="./manage_abstract_comment.php?idx=<?=$idx?>">댓글</a></li>
					</ul>
					<?php
						}
					?>
				</div>
				<!-- 컨텐츠 -->
				<form>
					<table>
						<colgroup>
							<col width="10%">
							<col width="40%">
							<col width="10%">
							<col width="40%">
						</colgroup>
						<tbody>
							<tr>
								<th>논문번호</th>
								<td><?=$info['code']?></td>
								<th>Abstract Category</th>
								<td>
									<select class="w100" name="category">
										<option value="" hidden>선택</option>
										<?php
											foreach($category_list as $ct){
										?>
										<option value="<?=$ct['idx']?>" <?=($info['category_idx'] == $ct['idx']) ? "selected" : ""?>><?=$ct['title_en']?></option>
										<?php
											}
										?>
									</select>
								</td>
							</tr>
							<!-- <tr>
								<th>Abstract 주제 *</th>
								<td colspan="3">
									<input type="text" placeholder="100자 이내" maxlength="100">
								</td>
							</tr> -->
							<tr>
								<th>Abstract Title *</th>
								<td colspan="3">
									<input type="text" placeholder="200자 이내" name="title" maxlength="200" value="<?=$info['title']?>">
								</td>
							</tr>
							<tr>
								<th>Author Name/Affiliation</th>
								<td colspan="3" class="input_wrap">
									<input type="text" placeholder="Author Name" name="name" value="<?=$info['author_name']?>" maxlength="300">
									<input type="text" placeholder="Affiliation" name="affiliation" value="<?=$info['author_affiliation']?>" maxlength="300">
								</td>
							</tr>
							<tr>
								<th>Poster 이미지 *</th>
								<td class="file_up_wrap">
									<input type="file" id="file_poster" class="file_costom" accept="image/*">
									<input type="text" readonly class="file_name" value="<?=$info['abstract_poster_origin_name']?>">
									<label for="file_poster">파일선택</label>
								</td>
								<th>Abstract PDF *</th>
								<td class="file_up_wrap">
									<input type="file" id="file_pdf" class="file_costom" accept=".pdf">
									<input type="text" readonly class="file_name" value="<?=$info['abstract_pdf_origin_name']?>">
									<label for="file_pdf">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="btn_wrap">
						<button type="button" class="border_btn" onclick="location.href='./manage_abstract_list.php'">목록</button>
						<?php
							if($admin_permission["auth_live_abstract"] > 1){
								if ($is_modify) {
						?>
						<button type="button" class="btn gray_btn remove_btn">삭제</button>
						<?php
								}
						?>
						<button type="button" class="btn save_btn">저장</button>
						<?php
							}
						?>
					</div>
				</form>
			</div>
		</div>
	</section>
	<script>
		// 파일 업로드 감지
		$("input[type=file]").on("change",function(e){
			var file = e.target.files[0]; // 단일 파일업로드만 고려된 개발

			if($(this).attr('id') == "file_poster" && !file.type.match('image.*')){
				alert("이미지 파일만 가능합니다");
				return false;
			} else if($(this).attr('id') == "file_pdf" && !file.type.match('pdf')){
				alert("pdf 파일만 가능합니다");
				return false;
			} else if(file && file != "" && typeof(file) != "undefined"){
				var label = $(this).parent().find(".label");
				label.text(file.name);
			}
		});

		// 저장
		$('.save_btn').click(function(){
			var temp_this;

			var post_data = {
				category : $("[name=category] option:selected").val(),
				title : $("[name=title]").val(),
				name : $("[name=name]").val(),
				affiliation : $("[name=affiliation]").val(),
				poster : document.getElementById("file_poster").value,
				pdf : document.getElementById("file_pdf").value
			};

			if (!post_data.category) {
				alert('Abstract Category를 선택해주세요.');
			} else if (!post_data.title) {
				alert('Abstract Title을 입력해주세요.');
			} else if (!post_data.name) {
				alert('Author Name을 입력해주세요.');
			} else if (!post_data.affiliation) {
				alert('Author Affiliation을 입력해주세요.');
			} else if ("<?=$idx?>" === "" && !post_data.poster) {
				alert('Poster 이미지 파일을 선택해주세요.');
			} else if ("<?=$idx?>" === "" && !post_data.pdf) {
				alert('Abstract PDF 파일을 선택해주세요.');
			} else if (confirm('저장하시겠습니까?')) {
				var form_data = new FormData();
				form_data.append("flag", "modify_abstract");
				form_data.append("idx", "<?=$idx?>");
				form_data.append("category", post_data.category);
				form_data.append("title", post_data.title);
				form_data.append("name", post_data.name);
				form_data.append("affiliation", post_data.affiliation);
				if (post_data.poster) {
					form_data.append('file_poster', $('#file_poster')[0].files[0]);
				}
				if (post_data.pdf) {
					form_data.append('file_pdf', $('#file_pdf')[0].files[0]);
				}

				$.ajax({
					url : "../ajax/admin/ajax_abstract.php",
					type : "POST",
					data : form_data,
					contentType : false,
					processData : false,
					dataType : "JSON",
					success : function(res) {
						alert(res.msg);
						if(res.code == 200) {
							if (!post_data.idx) {
								location.replace("/main/admin/manage_abstract_basic.php?idx="+res.idx);
							} else {
								location.reload();
							}
						}
					}
				});
			}
		});

		// 삭제
		$('.remove_btn').click(function(){
			if (confirm('삭제하시겠습니까?')) {
				$.ajax({
					url : "../ajax/admin/ajax_abstract.php",
					type : "POST",
					data : {
						flag : "remove_abstract",
						idx : "<?=$idx?>"
					},
					dataType : "JSON",
					success : function(res) {
						alert(res.msg);
						if(res.code == 200) {
							location.replace('/main/admin/manage_abstract_list.php');
						}
					}
				});
			}
		});
	</script>
<?php include_once('./include/footer.php');?>