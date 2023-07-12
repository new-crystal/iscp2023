<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail gallery">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">Photo Gallery 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<table  class="list_table">
					<colgroup>
						<col width="10%">
					</colgroup>
					<tr>
						<th>Year</th>
						<td>
							<select class="default_width">
								<option>2014</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>이미지</th>
						<td>
							<input id="file-input" type="file" multiple><label for="file-input" class="btn">등록하기 +</label>
							<div class="clearfix" id="preview">
								
							</div>
						</td>
					</tr>
				</table>

				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./setting_general_information4.php'">목록</button>
					<button type="button" class="btn gray_btn">삭제</button>
					<button type="button" class="btn save_btn">저장</button>
				</div>
			</div>
		</div>
	</section>
	

	<script>
	function previewImages() {

		var preview = document.querySelector('#preview');
		var html = "";
		if (this.files) {
			[].forEach.call(this.files, readAndPreview);
		}

		function readAndPreview(file) {

			if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
				return alert(file.name + " is not an image");
			} 
				var reader = new FileReader();
				reader.addEventListener("load", function() {
					var image = new Image();
					image.src    = this.result;
					//preview.appendChild(image);
					html = '<div class="img_wrap">';
					html += '<img src="'+image.src+'">';
					html += '<button type="button" class="delete_img"><i class="la la-close"></i></button>';
					html += '</div>';
					$('#preview').append(html);
				});
				reader.readAsDataURL(file);
		}
	}

	document.querySelector('#file-input').addEventListener("change", previewImages);

	$(document).on('click','.delete_img',function(){
		$(this).parents('.img_wrap').remove();
	});

	</script>


<?php include_once('./include/footer.php');?>