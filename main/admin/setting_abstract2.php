<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">Poster Abstract Submission 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li><a href="./setting_abstract.php">Abstract Submission Guideline</a></li>
						<li class="active"><a href="./setting_abstract2.php">Online Submission</a></li>
					</ul>
				</div>
				<h2 class="sub_title">Category 관리</h2>
				<table class="list_table">
					<colgroup>
						<col width="15%">
					</colgroup>
					<tr>
						<th>Abstract Category</th>
						<td colspan="3">
							<div class="input_wrap2">
								<input type="text" class="default_width append_input" placeholder="카테고리">
								<button type="button" class="btn append_btn">추가</button>
							</div> 
							<ul class="append_list clearfix">
							
							</ul>
						</td>
					</tr>
				</table>

				<h2 class="sub_title">썸네일 관리</h2>
				<table>
					<colgroup>
						<col width="5%">
					</colgroup>
					<tr  class="tr_center">
						<th>No</th>
						<th>Thumbnail Image</th>
					</tr>
					<tr>
						<td class="centerT">1</td>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="centerT">2</td>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="centerT">3</td>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<td class="centerT">4</td>
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