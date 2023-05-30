<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix">
			<h1 class="font_title">E-Booth 관리</h1>
		</div>
		<!----- 컨텐츠 ----->
		<div class="contwrap has_fixed_title">
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
							<th>E-Booth 업로드(영문)</th>
							<td class="file_up_wrap">
								<input type="file" id="file_label_mo" class="file_costom">
								<input type="text" readonly class="file_name">
								<label for="file_label_mo">파일선택</label>
							</td>
							<th>E-Booth 업로드(국문)</th>
							<td class="file_up_wrap">
								<input type="file" id="file_label_mo" class="file_costom">
								<input type="text" readonly class="file_name">
								<label for="file_label_mo">파일선택</label>
							</td>
						</tr>
					</tbody>
				</table>
		   </form>
		</div>
	</div>
</section>

<?php include_once('./include/footer.php');?>