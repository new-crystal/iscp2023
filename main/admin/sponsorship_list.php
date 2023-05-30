<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_apply_sponsorship"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$company_name = isset($_GET["company_name"]) ? $_GET["company_name"] : "";
	$s_date = isset($_GET["s_date"]) ? $_GET["s_date"] : "";
	$e_date = isset($_GET["e_date"]) ? $_GET["e_date"] : "";

	$where = "";

	if($company_name != "") {
		$where .= $where == "" ? " WHERE " : " AND ";
		$where .= " ra.company_name LIKE '%".$company_name."%' ";
	}

	if($s_date != "") {
		$where .= $where == "" ? " WHERE " : " AND ";
		$where .= " DATE(ra.register_date) >= '".$s_date."' ";
	}

	if($e_date != "") {
		$where .= $where == "" ? " WHERE " : " AND ";
		$where .= " DATE(ra.register_date) <= '".$e_date."' ";
	}

	$sponsorship_list_query ="
							SELECT
								ra.company_name, ra.ceo, ra.address, ra.url, CONCAT(ra.first_name,' ',ra.last_name,'/',ra.position,'/',ra.email,'/',ra.phone,'/',ra.mobile) AS manager_info,DATE_FORMAT(ra.register_date, '%y-%m-%d') AS register_date,
								licence.original_name AS licence_file_name, CONCAT(licence.path,'/',licence.save_name) AS licence_file_path,
								signature.original_name AS signature_file_name, CONCAT(signature.path,'/',signature.save_name) AS signature_file_path,
								(CASE
									WHEN ra.sponsorship_package = 0
									THEN '다이아몬드'
									WHEN ra.sponsorship_package = 1
									THEN '플래티넘'
									WHEN ra.sponsorship_package = 2
									THEN '골드 플러스'
									WHEN ra.sponsorship_package = 3
									THEN '골드'
									WHEN ra.sponsorship_package = 4
									THEN '실버'
									WHEN ra.sponsorship_package = 5
									THEN '브론즈'
									WHEN ra.sponsorship_package = 6
									THEN '베이직'
									ELSE '-'
								END) AS sponsorship_package
							FROM request_application ra
							LEFT JOIN file licence
							ON ra.business_licence_file = licence.idx
							LEFT JOIN file signature
							ON ra.signature_file = signature.idx
							{$where}
							ORDER BY ra.register_date DESC
							";

	$sponsorship_list = get_data($sponsorship_list_query);

	$html = '<table id="datatable" class="list_table">';
	$html .= '<thead>';
	$html .= '<tr class="tr_center">';
	$html .= '<th>Company Name</th>';
	$html .= '<th>President/CEO</th>';
	$html .= '<th>Address</th>';
	$html .= '<th>Official Website</th>';
	$html .= '<th>Contact Person</th>';
	$html .= '<th>Sponsorship Package</th>';
	$html .= '<th>Business License</th>';
	$html .= '<th>Online Signature</th>';
	$html .= '<th>등록일</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';

	foreach($sponsorship_list as $sl){
		$html .= '<tr class="tr_center">';
		$html .= '<td>'.$sl["company_name"].'</td>';
		$html .= '<td>'.$sl["ceo"].'</td>';
		$html .= '<td>'.$sl["address"].'</td>';
		$html .= '<td>'.$sl["url"].'</td>';
		$html .= '<td>'.$sl["manager_info"].'</td>';
		$html .= '<td>'.$sl["sponsorship_package"].'</td>';
		$html .= '<td>'.$sl["licence_file_name"].'</td>';
		$html .= '<td>'.$sl["signature_file_name"].'</td>';
		$html .= '<td>'.$sl["register_date"].'</td>';
		$html .= '</tr>';
	}
	$html .= '</tbody>';
	$html .= '</table>';

	$html = str_replace("'", "\'", $html);
	$html = str_replace("\n", "", $html);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">Sponsorship & Exhibition</h1>
				<button class="btn excel_download_btn" onclick="javascript:fnExcelReport('Sponsorship & Exhibition', html);">엑셀 다운로드</button>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table>
						<colgroup>
							<col width="10%">
							<col width="40%">
							<col width="10%">
							<col width="40%">
						</colgroup>
						<tbody>
							<tr>
								<th>Company Name</th>
								<td>
									<input type="text" name="company_name">
								</td>
								<th>등록일</th>
								<td class="input_wrap"><input type="text" name="s_date" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" data-type="date"> <span>~</span> <input type="text" name="e_date" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" data-type="date"></td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="btn search_btn">검색</button>
			   </form>
			</div>
			<div class="contwrap">
				<p class="total_num">총 <?=number_format(count($sponsorship_list))?>개</p>
				<table id="datatable" class="list_table">
					<thead>
						<tr class="tr_center">
							<th>Company Name</th>
							<th>President/CEO</th>
							<th>Address</th>
							<th>Official Website</th>
							<th>Contact Person</th>
							<th>Sponsorship Package</th>
							<th>Business License</th>
							<th>Online Signature</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php																																																												 
						if(!$sponsorship_list) {
							echo "<tr><td colspan='9' class='no_data'>No Data</td></tr>";
						} else {
							foreach($sponsorship_list as $list) {
								$ext = strtolower(end(explode(".",$list["licence_file_name"])));
					?>
						<tr>
							<td><?=$list["company_name"]?></td>
							<td><?=$list["ceo"]?></td>
							<td><?=$list["address"]?></td>
							<td><a href="<?=$list["url"]?>" target="_blank"><?=$list["url"]?></a></td>
							<td><?=$list["manager_info"]?></td>
							<td><?=$list["sponsorship_package"]?></td>
							<td>
								<?php if($ext == "pdf"){?>
									<a href="./pdf_viewer.php?path=<?=$list["licence_file_path"]?>" target="_blank"><?=$list["licence_file_name"]?></a>
								<?php }else{?>
									<a href="<?=$list["licence_file_path"]?>" download><?=$list["licence_file_name"]?></a>
								<?php }?>
							</td>
							<td><a href="<?=$list["signature_file_path"]?>" download><?=$list["signature_file_name"]?></a></td>
							<td><?=$list["register_date"]?></td>
						</tr>
					<?php
							}
						}
					?>
					</tbody>
				</table>
				
			</div>
		</div>
	</section>
<script src="./js/common.js?v=0.1"></script>
<script>
	var html = '<?=$html?>';
</script>
<?php include_once('./include/footer.php');?>