<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">General Information 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li class="active"><a href="./setting_general_information.php">Overview</a></li>
						<li><a href="./setting_general_information2.php">Organizing Committee</a></li>
						<li><a href="./setting_general_information3.php">Venue</a></li>
						<li><a href="./setting_general_information4.php">Photo Gallery</a></li>
					</ul>
				</div>
				<h2 class="sub_title">영문</h2>
				<table class="list_table">
					<colgroup>
						<col width="15%">
					</colgroup>
					<tr>
						<th>Organized By(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
						<th>Theme(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Official Language(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
						<th>Secretariat(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Poster(영문)</th>
						<td colspan="3">
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<th>Welcome Message(영문)</th>
						<td colspan="3"><textarea>웹에디터</textarea></td>
					</tr>
					<tr>
						<th>Welcome Message Sign(영문)</th>
						<td colspan="3">
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
				</table>

				<h2 class="sub_title">국문</h2>
				<table class="list_table">
					<colgroup>
						<col width="15%">
					</colgroup>
					<tr>
						<th>Organized By(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
						<th>Theme(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Official Language(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
						<th>Secretariat(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Poster(국문)</th>
						<td colspan="3">
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
					</tr>
					<tr>
						<th>Welcome Message(국문)</th>
						<td colspan="3"><textarea>웹에디터</textarea></td>
					</tr>
					<tr>
						<th>Welcome Message Sign(국문)</th>
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