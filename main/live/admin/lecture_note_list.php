<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_apply_lecture"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	$name = isset($_GET["name"]) ? $_GET["name"] : "";
	$s_date = isset($_GET["s_date"]) ? $_GET["s_date"] : "";
	$e_date = isset($_GET["e_date"]) ? $_GET["e_date"] : "";

	$where = "";
	
	if($id != "") {
		$where .= " AND ra.email LIKE '%".$id."%' ";
	}

	if($name != "") {
		$where .= " AND CONCAT(ra.first_name,' ',ra.last_name) LIKE '%".$name."%' ";
	}

	if($s_date != "") {
		$where .= " AND DATE(ra.register_date) >= '".$s_date."' ";
	}

	if($e_date != "") {
		$where .= " AND DATE(ra.register_date) <= '".$e_date."' ";
	}

	$lecture_list_query =  "
								SELECT
								ra.idx AS lectrue_idx, ra.cv, DATE_FORMAT(ra.register_date, '%y-%m-%d') AS register_date,
								m.idx AS member_idx, m.email, m.name, m.nation,
								lecture.original_name AS lecture_file_name, CONCAT(lecture.path,'/',lecture.save_name) AS lecture_path,
								cv.original_name AS cv_file_name, CONCAT(cv.path,'/',cv.save_name) AS cv_path
								FROM request_abstract ra
								LEFT JOIN (
									SELECT
										m.idx, m.email, CONCAT(m.first_name,' ',m.last_name) AS name, n.nation_ko AS nation
									FROM member m
									JOIN nation n
									ON m.nation_no = n.idx
									) AS m
								ON ra.register = m.idx
								LEFT JOIN file lecture
								ON ra.notice_file = lecture.idx
								LEFT JOIN file cv
								ON ra.cv_file = cv.idx
								WHERE ra.is_deleted = 'N'
								AND ra.parent_author IS NULL
								AND ra.`type` = 1
								{$where}
								ORDER BY ra.register_date DESC
							";

	$lecture_list = get_data($lecture_list_query);

	$html = '<table id="datatable" class="list_table">';
	$html .= '<thead>';
	$html .= '<tr class="tr_center">';
	$html .= '<th>ID(Email)</th>';
	$html .= '<th>Country</th>';
	$html .= '<th>Name</th>';
	$html .= '<th>파일명</th>';
	$html .= '<th>약력</th>';
	$html .= '<th>등록일</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';

	foreach($lecture_list as $ll){
		$html .= '<tr class="tr_center">';
		$html .= '<td>'.$ll["email"].'</td>';
		$html .= '<td>'.$ll["nation"].'</td>';
		$html .= '<td>'.$ll["name"].'</td>';
		$html .= '<td>'.$ll["lecture_file_name"].'</td>';
		$html .= '<td>'.$ll["cv_file_name"].'</td>';
		$html .= '<td>'.$ll["register_date"].'</td>';
		$html .= '</tr>';
	}
	$html .= '</tbody>';
	$html .= '</table>';

	$html = str_replace("'", "\'", $html);
	$html = str_replace("\n", "", $html);

	$count= count($lecture_list);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">Lecture Note Submission</h1>
				<button class="btn excel_download_btn" onclick="javascript:fnExcelReport('Lecture Note Submission', html);">엑셀 다운로드</button>
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
								<th>ID(Email)</th>
								<td>
									<input type="text" name="id">
								</td>
								<th>Name</th>
								<td class="select_wrap clearfix2">
									<input type="text" name="name" data-type="string">
								</td>
							</tr>
							<tr>
								<th>등록일</th>
								<td class="input_wrap" colspan="3"><input type="text" name="s_date" class="datepicker-here default_width" data-language="en" data-date-format="yyyy/mm/dd" data-type="date"> <span>~</span> <input type="text" name="e_date" class="datepicker-here default_width" data-language="en" data-date-format="yyyy/mm/dd" data-type="date"></td>
							</tr>
						</tbody>
					</table>
				<button class="btn search_btn">검색</button>
				</form>
			</div>
			<div class="contwrap">
				<p class="total_num">총 <?=number_format($count)?>개</p>
				<table id="datatable" class="list_table">
					<thead>
						<tr class="tr_center">
							<th>ID(Email)</th>
							<th>Country</th>
							<th>Name</th>
							<th>파일명</th>
							<th>약력</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!$lecture_list) {
							echo "<tr><td class='no_data' colspan='6'>No Data</td></tr>";
						} else {
							foreach($lecture_list as $list) {
								$ext = strtolower(end(explode(".",$list["lecture_file_name"])));
								$ext2 = strtolower(end(explode(".",$list["cv_file_name"])));
					?>
						<tr class="tr_center">
							<td><a href="./member_detail.php?idx=<?=$list["member_idx"]?>"><?=$list["email"]?></a></td>
							<td><?=$list["nation"]?></td>
							<td><a href="./lecture_note_detail.php?idx=<?=$list["lectrue_idx"]?>"><?=$list["name"]?></a></td>
							
							<?php if($ext == "pdf") {?>
								<td><a href="./pdf_viewer.php?path=<?=$list["lecture_path"]?>" target="_blank"><?=$list["lecture_file_name"]?></a></td>
							<?php } else { ?>
								<td><a href="<?=$list["lecture_path"]?>" download><?=$list["lecture_file_name"]?></a></td>	
							<?php } ?>

							<?php if($ext2 == "pdf") {?>
								<td><a href="./pdf_viewer.php?path=<?=$list["cv_path"]?>" target="_blank"><?=$list["cv_file_name"]?></a></td>
							<?php } else { ?>
								<td><a href="<?=$list["cv_path"]?>" download><?=$list["cv_file_name"]?></a></td>	
							<?php } ?>
							<td><?=$list["register_date"]?></td>
						</tr>
					<?php
							}
						}
					?>
						</tr>
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