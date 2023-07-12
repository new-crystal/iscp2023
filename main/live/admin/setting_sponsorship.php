<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">Sponsorship & Exhibition 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li class="active"><a href="./setting_sponsorship.php">Overview</a></li>
						<li><a href="./setting_sponsorship2.php">Sponsorship</a></li>
					</ul>
				</div>
				<h2 class="sub_title">Overview - 영문</h2>
				<table class="list_table">
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tr>
						<th>상단 텍스트(영문)</th>
						<td colspan="3"><textarea></textarea></td>
					</tr>
					<tr>
						<th>상단 다운로드 파일 1(영문)</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<th>상단 다운로드 파일 2(영문)</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<th>Date & Time Description(영문)</th>
						<td colspan="3">
							<input type="text">
						</td>
					</tr>
					<tr>
						<th>How to Apply(영문)</th>
						<td colspan="3"><textarea></textarea></td>
					</tr>
					<tr>
						<th>Procedure(영문)</th>
						<td colspan="3"><textarea></textarea></td>
					</tr>
					<tr>
						<th>Package for Sponsorship(영문)</th>
						<td colspan="3"><textarea>웹에디터</textarea></td>
					</tr>
					<tr>
						<th>Contact Information(영문)</th>
						<td colspan="3"><textarea>웹에디터</textarea></td>
					</tr>
				</table>

				<h2 class="sub_title">Overview - 국문</h2>
				<table class="list_table">
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tr>
						<th>상단 텍스트(국문)</th>
						<td colspan="3"><textarea></textarea></td>
					</tr>
					<tr>
						<th>상단 다운로드 파일 1(국문)</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<th>상단 다운로드 파일 2(국문)</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<th>Date & Time Description(국문)</th>
						<td colspan="3">
							<input type="text">
						</td>
					</tr>
					<tr>
						<th>How to Apply(국문)</th>
						<td colspan="3"><textarea></textarea></td>
					</tr>
					<tr>
						<th>Procedure(국문)</th>
						<td colspan="3"><textarea></textarea></td>
					</tr>
					<tr>
						<th>Package for Sponsorship(국문)</th>
						<td colspan="3"><textarea>웹에디터</textarea></td>
					</tr>
					<tr>
						<th>Contact Information(국문)</th>
						<td colspan="3"><textarea>웹에디터</textarea></td>
					</tr>
				</table>
				<div class="btn_wrap">
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