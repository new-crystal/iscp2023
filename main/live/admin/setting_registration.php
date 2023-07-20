<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">Registration 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<h2 class="sub_title">Registration 관리 - 영문</h2>
				<table class="list_table">
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tr>
						<th>Bank Name(영문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
						<th>Account Number(영문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
					</tr>
					<tr>
						<th>Account Holder(영문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
						<th>Address(영문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
					</tr>
					<tr>
						<th>평점안내 팝업(영문)</th>
						<td colspan="3">
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
				</table>
				
				<h2 class="sub_title">Registration 관리 - 국문</h2>
				<table class="list_table">
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tr>
						<th>Bank Name(국문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
						<th>Account Number(국문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
					</tr>
					<tr>
						<th>Account Holder(국문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
						<th>Address(국문)</th>
						<td>
							<input type="text" placeholder="100자 이내">
						</td>
					</tr>
					<tr>
						<th>평점안내 팝업(국문)</th>
						<td colspan="3">
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
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