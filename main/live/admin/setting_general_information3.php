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
						<li><a href="./setting_general_information.php">Overview</a></li>
						<li><a href="./setting_general_information2.php">Organizing Committee</a></li>
						<li class="active"><a href="./setting_general_information3.php">Venue</a></li>
						<li><a href="./setting_general_information4.php">Photo Gallery</a></li>
					</ul>
				</div>
				<h2 class="sub_title">영문</h2>
				<table class="list_table">
					<colgroup>
						<col width="15%">
					</colgroup>
					<tr>
						<th>Venue Image(영문)</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<th>Venue Name(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Venue Address(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
						<th>Venue Tel(영문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Website ENG(영문)</th>
						<td colspan="3"><input type="text"></td>
					</tr>
				</table>

				<h2 class="sub_title">국문</h2>
				<table class="list_table">
					<colgroup>
						<col width="15%">
					</colgroup>
					<tr>
						<th>Venue Image(국문)</th>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<th>Venue Name(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Venue Address(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
						<th>Venue Tel(국문)</th>
						<td><input type="text" placeholder="100자 이내"></td>
					</tr>
					<tr>
						<th>Website ENG(국문)</th>
						<td colspan="3"><input type="text"></td>
					</tr>
				</table>

				<h2 class="sub_title">Floor 정보 등록</h2>
				<table class="list_table">
					<colgroup>
						<col width="15%">
					</colgroup>
					<tr>
						<th>Venue Information</th>
						<td colspan="3">
							<div class="input_wrap2">
								<input type="text" class="default_width append_input" placeholder="venue 이름*">
								<button type="button" class="btn append_btn">추가</button>
							</div> 
							<ul class="append_list clearfix">
							
							</ul>
						</td>
					</tr>
				</table>
					
				<h2 class="sub_title">Floor 이미지 등록</h2>
				<table>
					<tr>
						<th>Venue Information</th>
						<th>이미지</th>
						<th>관리</th>
					</tr>
					<tr>
						<td>
							<select>
								<option disabled selected>choose</option>
							</select>
						</td>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<td class="centerT">
							<button type="button" class="btn">삭제</button>
						</td>
					</tr>
					<tr>
						<td>
							<select>
								<option disabled selected>choose</option>
							</select>
						</td>
						<td>
							<div class="file_input">
								<input type="file">
								<span class="btn">Choose</span>
								<span class="label" data-js-label="">No file selected</span>
							</div>
						</td>
						<td class="centerT">
							<button type="button" class="btn">추가</button>
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