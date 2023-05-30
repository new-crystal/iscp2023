<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$id		= isset($_GET["id"])		? $_GET["id"]		: "";
	$name	= isset($_GET["name"])		? $_GET["name"]		: "";
	$phone	= isset($_GET["phone"])		? $_GET["phone"]	: "";
	$s_date = isset($_GET["s_date"])	? $_GET["s_date"]	: "";
	$e_date = isset($_GET["e_date"])	? $_GET["e_date"]	: "";
	$for_offline = ($_GET["for"] == "offline");
	//$for_offline = True;

	$where = "";

	if($id != ""){
		$where .= " AND m.email LIKE '%".$id."%' ";
	}

	if($name != ""){
		$where .= " AND CONCAT(m.first_name, ' ', m.last_name) LIKE '%".$name."%' ";
	}

	if($phone != ""){
		$where .= " AND m.phone LIKE '%".$phone."%' ";
	}

	if($s_date != ""){
		$where .= " AND DATE(m.regist_date) > '".$s_date."' ";
	}

	if($e_date != ""){
		$where .= " AND DATE(DATE_ADD(m.regist_date, INTERVAL 1 DAY)) LIKE < '".$e_date."' ";
	}

	$join_req_type = "LEFT";
	if ($for_offline) {
		$join_req_type = "INNER";
	}

	$select_member_list_query = "
									SELECT
										m.idx, 
										m.email, 
										n.nation_ko, 
										m.first_name, m.last_name, 
										m.phone, 
										IF(m.affiliation IS NULL, '-', m.affiliation) AS affiliation, 
										IF(req.idx IS NULL, 'N', 'Y') AS printable_nametag_yn,
										DATE_FORMAT(m.register_date, '%y-%m-%d') AS regist_date
									FROM member m
									{$join_req_type} JOIN (
										SELECT
											rr.idx, rr.register
										FROM request_registration AS rr
										INNER JOIN payment AS pmt
											ON pmt.idx = rr.payment_no
										WHERE rr.`status` = 2
									) AS req
										ON req.register = m.idx
									LEFT JOIN nation n
									ON m.nation_no = n.idx
									WHERE is_deleted = 'N'
									{$where}
									GROUP BY m.idx
									ORDER BY m.register_date DESC
								";

//    error_log(print_r($select_member_list_query, TRUE), 3, '/tmp/errors.log');

	$member_list = get_data($select_member_list_query);

	$html = '<table id="datatable" class="list_table">';
	$html .= '<thead>';
	$html .= '<tr class="tr_center">';
	$html .= '<th>ID(Email)</th>';
	$html .= '<th>Country</th>';
	$html .= '<th>Name</th>';
	$html .= '<th>Phone Number</th>';
	$html .= '<th>Affiliation</th>';
	$html .= '<th>등록일</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	foreach($member_list as $ml){
		$html .= '<tr class="tr_center">';
		$html .= '<td><a href="./member_detail.php?idx='.$ml["idx"].'">'.$ml["email"].'</a></td>';
		$html .= '<td>'.$ml["nation_ko"].'</td>';
		$html .= '<td>'.$ml["first_name"]." ".$ml["last_name"].'</td>';
		$html .= '<td>'.$ml["phone"].'</td>';
		$html .= '<td>'.$ml["affiliation"].'</td>';
		$html .= '<td>'.$ml["regist_date"].'</td>';
		$html .= '</tr>';
	}
	$html .= '</tbody>';
	$html .= '</table>';

	$html = str_replace("'", "\'", $html);
	$html = str_replace("\n", "", $html);

	$count = count($member_list);
?>
<style>
	.register_btn {float: right;}
	.excel_download_btn {float: right;margin-right: 10px;}
</style>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<?php
					if ($for_offline) {
				?>
					<h1 class="font_title">일반 회원 (오프라인 회원만 보기)</h1>
					<!-- <button class="btn register_btn" onclick="javascript:window.open('./member_nametag.php?idx=all')">전체 네임택 보기</button> -->
				<?php
					} else {
						if($admin_permission["auth_account_member"] > 1){
				?>
					<h1 class="font_title">일반 회원</h1>
					<button class="btn register_btn" onclick="javascript:location.href='./member_detail.php'">회원 등록</button>
				<?php
						}
					}
				?>
				<button class="btn excel_download_btn" onclick="javascript:fnExcelReport('member_list', html);">엑셀 다운로드</button>
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
									<input type="text" name="id" value="<?=$id?>">
								</td>
								<th>Name</th>
								<td class="select_wrap clearfix2">
									<input type="text" name="name" value="<?=$name?>" data-type="string">
								</td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<td>
									<input type="text" name="phone" value="<?=$phone?>" data-type="phone">
								</td>
								<th>등록일</th>
								<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" name="s_date" value="<?=$s_date?>" data-type="date"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" name="e_date" value="<?=$e_date?>" data-type="date"></td>
							</tr>
						</tbody>
					</table>
				   <button type="button" class="btn search_btn">검색</button>
			   </form>
			</div>
			<div class="contwrap">
				<p class="total_num">총 <?=number_format($count)?>명</p>
				<table id="datatable" class="list_table">
					<thead>
						<tr class="tr_center">
							<th>ID(Email)</th>
							<th>Country</th>
							<th>Name</th>
							<th>Phone Number</th>
							<th>Affiliation</th>
							<!-- <th>네임택</th> -->
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!$member_list) {
							echo '<tr class="tr_center"><td colspan="6">No member data</td></tr>';
						} else {
							foreach($member_list as $list) {
					?>
						<tr class="tr_center">
							<td><a href="./member_detail.php?idx=<?=$list["idx"]?>"><?=$list["email"]?></a></td>
							<td><?=$list["nation_ko"]?></td>
							<td><?=$list["first_name"]." ".$list["last_name"]?></td>
							<td><?=$list["phone"]?></td>
							<td><?=$list["affiliation"]?></td>
							<!--<td>
								<?php
									if ($list['printable_nametag_yn'] == "Y") {
								?>
								<a href="./member_nametag.php?idx=<?=$list['idx']?>" target="_BLANK">보기</a>
								<?php
									} else {
										echo "-";
									}
								?>
							</td>-->
							<td><?=$list["regist_date"]?></td>
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
<script src="./js/common.js"></script>
<script>
	var html = '<?=$html?>';
</script>
<?php include_once('./include/footer.php');?>
