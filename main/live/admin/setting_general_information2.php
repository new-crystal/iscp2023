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
						<li class="active"><a href="./setting_general_information2.php">Organizing Committee</a></li>
						<li><a href="./setting_general_information3.php">Venue</a></li>
						<li><a href="./setting_general_information4.php">Photo Gallery</a></li>
					</ul>
				</div>
				<h2 class="sub_title">영문</h2>
				<table>
					<tr class="tr_center">
						<th>Title(영문)</th>
						<th>Name(영문)</th>
						<th>Affiliation(영문)</th>
						<th>Specialty(영문)</th>
						<th>관리</th>
					</tr>
					<tr>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td class="centerT"><button type="button" class="btn">삭제</button></td>
					</tr>
					<tr>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td class="centerT"><button type="button" class="btn">추가</button></td>
					</tr>
				</table>

				<h2 class="sub_title">국문</h2>
				<table class="list_table">
					<tr class="tr_center">
						<th>Title(국문)</th>
						<th>Name(국문)</th>
						<th>Affiliation(국문)</th>
						<th>Specialty(국문)</th>
						<th>관리</th>
					</tr>
					<tr>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td class="centerT"><button type="button" class="btn">삭제</button></td>
					</tr>
					<tr>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td><input type="text"></td>
						<td class="centerT"><button type="button" class="btn">추가</button></td>
					</tr>
				</table>

				<div class="btn_wrap">
					<button type="button" class="btn">저장</button>
				</div>
			</div>
		</div>
	</section>

<?php include_once('./include/footer.php');?>