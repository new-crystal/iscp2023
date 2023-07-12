<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">메인페이지 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">

				<table class="list_table">
					<colgroup>
						<col width="15%">
						<col width="35%">
						<col width="15%">
						<col width="35%">
					</colgroup>
					<tr>
						<th>PC 이미지(영문) *</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<th>모바일 이미지(영문) *</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<th>PC 이미지(국문) *</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<th>모바일 이미지(국문) *</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
				</table>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./setting_main.php'">목록</button>
					<button type="button" class="btn">저장</button>
				</div>
			</div>
		</div>
	</section>
	<script>
	
	var inputs = document.querySelectorAll('.file_input')

	for (var i = 0, len = inputs.length; i < len; i++) {
	  customInput(inputs[i])
	}

	function customInput (el) {
	  const fileInput = el.querySelector('[type="file"]')
	  const label = el.querySelector('[data-js-label]')
	  
	  fileInput.onchange =
	  fileInput.onmouseout = function () {
		if (!fileInput.value) return
		
		var value = fileInput.value.replace(/^.*[\\\/]/, '')
		el.className += ' -chosen'
		label.innerText = value
	  }
	}
	</script>
<?php include_once('./include/footer.php');?>