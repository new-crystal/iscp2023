<?php
include_once('./include/head.php');
include_once('./include/header.php');

if ($admin_permission["auth_apply_registration"] == 0) {
	echo '<script>alert("권한이 없습니다.");history.back();</script>';
}

$id = isset($_GET["id"]) ? $_GET["id"] : "";

$name = isset($_GET["name"]) ? $_GET["name"] : "";
//$attendance_type = isset($_GET["attendance_type"]) ? $_GET["attendance_type"] : "";
$s_date = isset($_GET["s_date"]) ? $_GET["s_date"] : "";
$e_date = isset($_GET["e_date"]) ? $_GET["e_date"] : "";

$where = "";

if ($id != "") {
	$where .= " AND rr.email LIKE '%" . $id . "%' ";
}

if ($name != "") {
	$where .= " AND CONCAT(rr.first_name,' ',rr.last_name) LIKE '%" . $name . "%' ";
}

//if($attendance_type != "") {
//$where .= " AND rr.attendance_type = ".$attendance_type." ";
//}

if ($s_date != "") {
	$where .= " AND DATE(rr.register_date) >= '" . $s_date . "' ";
}

if ($e_date != "") {
	$where .= " AND DATE(rr.register_date) <= '" . $e_date . "' ";
}


$registration_list_query =  "
									SELECT									
										rr.idx,
										in_n.nation_en AS in_nation_en,
										rr.price,
										rr.welcome_reception_yn,
										rr.day1_luncheon_yn,
										rr.day2_breakfast_yn,
										rr.day2_luncheon_yn,
										rr.day3_breakfast_yn,
										rr.day3_luncheon_yn,

										rr.register_path,
										rr.register_path_others,
										rr.payment_methods,
										rr.promotion_code,
										rr.recommended_by,

										rr.invitation_yn,
										CONCAT(rr.invitation_first_name,' ',rr.invitation_last_name) AS invitation_name,
										rr.invitation_nation_no,
										rr.invitation_address,
										rr.invitation_passport,
										rr.invitation_date_of_birth,
										rr.invitation_date_of_issue,
										rr.invitation_date_of_expiry,
										rr.invitation_length_of_visit,

										rr.member_type, rr.member_status, rr.nation_no,
										m.member_idx, m.member_email, m.member_name, m.member_nation, m.member_name_kor,
										m.licence_number, m.specialty_number, m.nutritionist_number, m.phone, m.request_food,
										m.affiliation, m.department, m.affiliation_kor, 
										DATE(rr.register_date) AS register_date, rr.email AS registration_email, CONCAT(rr.first_name,' ',rr.last_name) AS registration_name,
										IFNULL(rr.status, '1') AS registration_status,
										DATE(p.payment_date) AS payment_date, p.total_price_kr, p.total_price_us,

										n.nation_ko AS registration_nation,
										(CASE
											WHEN rr.member_status = '1'
											THEN '회원'
											WHEN rr.member_status = '0'
											THEN '비회원'
											ELSE '-'
										END) AS member_status
									FROM request_registration rr
									LEFT JOIN (
										SELECT
											m.idx AS member_idx, m.email AS member_email, CONCAT(m.first_name,' ',m.last_name) AS member_name, n.nation_ko AS member_nation, m.name_kor AS member_name_kor, m.phone, m.licence_number, m.specialty_number, m.nutritionist_number, m.request_food, m.affiliation_kor, 
											m.affiliation, m.department
										FROM member m
										JOIN nation n
										ON m.nation_no = n.idx
									) AS m
									ON rr.register = m.member_idx
									LEFT JOIN nation n
									ON rr.nation_no = n.idx
									LEFT JOIN payment p
									ON rr.payment_no = p.idx
									LEFT JOIN nation in_n
									ON rr.invitation_nation_no = in_n.idx
									WHERE rr.is_deleted = 'N'
									{$where}
									ORDER BY rr.register_date
								";
// status 상태(0:등록취소, 1:결제대기, 2:결제완료, 3:환불대기, 4:환불완료)

$registration_list = get_data($registration_list_query);

$time = new DateTime();
$date_time = $time->format("Y-m-d");

$count = count($registration_list);

$html = '<table id="datatable" class="list_table">';
$html .= '<thead>';
$html .= '<tr><th colspan="3"><h3>ISCP 2023 등록현황</h3></th></tr>';
$html .= '<tr><th style="font-size:9px;" colspan="2">';
$html .= $date_time . ' ' . $count . '명';
$html .= '</th></tr>';
$html .= '<tr class="tr_center">';
$html .= '<th style="background-color:#D9D9D9; border-style: solid; border-width:thin;" colspan="2">Registration</th>';
$html .= '<th style="background-color:#FFF2CC; border-style: solid; border-width:thin;" colspan="15">Participants Information</th>';
$html .= '<th style="background-color:#BDD7EE; border-style: solid; border-width:thin;" colspan="7">Satellite Session</th>';
$html .= '<th style="background-color:#D9D9D9; border-style: solid; border-width:thin;" colspan="1">Others</th>';
$html .= '<th style="background-color:#FFCCCC; border-style: solid; border-width:thin;" colspan="6">Payment Information</th>';
$html .= '<th style="background-color:#7030A0; border-style: solid; border-width:thin;" colspan="8">VISA Informaion</th>';
$html .= '</tr>';
$html .= '<tr class="tr_center">';
$html .= '<th style="background-color:#F2F2F2; border-style: solid; border-width:thin;">No.</th>';
$html .= '<th style="background-color:#F2F2F2; border-style: solid; border-width:thin;">등록일</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">id(Email)</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">국내/국외</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">Country</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">KSoLA 회원 여부</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">Name</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">성함</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">Affiliation</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">소속</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">Department</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">Category</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">카테고리</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">면허번호</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">전문의번호</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">영양사번호</th>';
$html .= '<th style="background-color:#FFE699; border-style: solid; border-width:thin;">Phone Number</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">Welcome Reception</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">D1LS</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">D2BS</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">D2LS</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">D3BS</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">D3LS</th>';
$html .= '<th style="background-color:#DDEBF7; border-style: solid; border-width:thin;">Special Request for Food</th>';
$html .= '<th style="background-color:#F2F2F2; border-style: solid; border-width:thin;">가입경로</th>';
$html .= '<th style="background-color:#F5C3EB; border-style: solid; border-width:thin;">결제상태</th>';
$html .= '<th style="background-color:#F5C3EB; border-style: solid; border-width:thin;">결제일</th>';
$html .= '<th style="background-color:#F5C3EB; border-style: solid; border-width:thin;">결제금액</th>';
$html .= '<th style="background-color:#F5C3EB; border-style: solid; border-width:thin;">결제방식</th>';
$html .= '<th style="background-color:#F5C3EB; border-style: solid; border-width:thin;">Promotion Code</th>';
$html .= '<th style="background-color:#F5C3EB; border-style: solid; border-width:thin;">추천인</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Name of Passport</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Coutry</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Address</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Passport Number</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Date of Birth</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Date of Issue</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Date of Expiry</th>';
$html .= '<th style="background-color:#C06AC2; border-style: solid; border-width:thin;">Length of Visit</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';


$no = 1;
foreach ($registration_list as $rl) {

	$member_type = $rl["member_type"];

	if ($member_type == "Specialist") {
		$member_type_kor = "전문의";
	} else if ($member_type == "Professor") {
		$member_type_kor = "교수";
	} else if ($member_type == "Fellow") {
		$member_type_kor = "전임의";
	} else if ($member_type == "Resident") {
		$member_type_kor = "전공의";
	} else if ($member_type == "Researcher") {
		$member_type_kor = "연구원";
	} else if ($member_type == "Nurse") {
		$member_type_kor = "간호사";
	} else if ($member_type == "Nutritionist") {
		$member_type_kor = "영양사";
	} else if ($member_type == "Student") {
		$member_type_kor = "학생";
	} else if ($member_type == "Pharmacist") {
		$member_type_kor = "약사";
	} else if ($member_type == "Corporate member") {
		$member_type_kor = "기업회원";
	} else if ($member_type == "Others") {
		$member_type_kor = "기타";
	} else if ($member_type == "Military medical officer") {
		$member_type_kor = "군의관/공보의";
	}

	$register_paths = array();
	$register_paths = explode(",", $rl["register_path"]);
	$register_path_value = "";

	$register_path_others = $rl["register_path_others"];

	if ($rl["nation_no"] == 25) {
		for ($i = 0; $i < count($register_paths) - 1; $i++) {
			if ($register_paths[$i] == 0) {
				$register_path_value .= "1. 한국지질동맥경화학회 홈페이지 또는 홍보메일 <br/> ";
			} else if ($register_paths[$i] == 1) {
				$register_path_value .= "2. 유관학회 홍보메일 또는 게시판 광고 <br/>";
			} else if ($register_paths[$i] == 2) {
				$register_path_value .= "3. 초청연자/좌장으로 초청받음 <br/>";
			} else if ($register_paths[$i] == 3) {
				$register_path_value .= "4. 이전 ICoLA에 참석한 경험이 있음 <br/>";
			} else if ($register_paths[$i] == 4) {
				$register_path_value .= "5. 제약회사 소개 <br/>";
			} else if ($register_paths[$i] == 5) {
				$register_path_value .= "6. 지인을 통해 <br/> ";
			} else if ($register_paths[$i] == 6) {
				$register_path_value .= "7. 인터넷 검색 <br/> ";
			}
		}
		$nation_name = "국내";
	} else {
		for ($i = 0; $i < count($register_paths) - 1; $i++) {
			if ($register_paths[$i] == 0) {
				$register_path_value .= "1. 한국지질동맥경화학회 홈페이지 또는 홍보메일 <br/> ";
			} else if ($register_paths[$i] == 1) {
				$register_path_value .= "2. 유관학회 홍보메일 또는 게시판 광고 <br/> ";
			} else if ($register_paths[$i] == 3) {
				$register_path_value .= "3. 초청연자/좌장으로 초청받음 <br/> ";
			} else if ($register_paths[$i] == 2) {
				$register_path_value .= "4. 이전 ICoLA에 참석한 경험이 있음 <br/> ";
			} else if ($register_paths[$i] == 5) {
				$register_path_value .= "5. 제약회사 소개 <br/> ";
			} else if ($register_paths[$i] == 4) {
				$register_path_value .= "6. 지인을 통해 <br/> ";
			} else if ($register_paths[$i] == 6) {
				$register_path_value .= "7. 인터넷 검색 <br/> ";
			}
		}
		$nation_name = "국외";
	}

	if (!empty($register_path_others)) {
		$register_path_value .= $register_path_others . ", ";
	}

	$register_path_value = rtrim($register_path_value, ", ");

	switch ($rl["registration_status"]) {
		case 1:
			$status_type = "결제대기";
			break;
		case 2:
			$status_type = "결제완료";
			break;
		case 3:
			$status_type = "환불 요청";
			break;
		case 4:
			$status_type = "환불";
			break;
		case 0:
			$status_type = "등록 취소";
			break;
	}

	$promotion_code_value = "";
	$price_eyes = "";
	$price = $rl["price"];
	$total_price_us = $rl["total_price_us"];
	$total_price_kr = $rl["total_price_kr"];

	if (isset($rl["promotion_code"])) {
		if ($rl["promotion_code"] == 0) {
			$promotion_code_value = "ICoLA-77932 / [100% Discount]";
			$price_eyes = 0;
			$price = 0;
		} else if ($rl["promotion_code"] == 1) {
			$promotion_code_value = "ICoLA-59721 / [50% Discount]";
			$price_eyes = $price_eyes / 2;
			$price = $price / 2;
		} else if ($rl["promotion_code"] == 2) {
			$promotion_code_value = "ICoLA-89359 / [50% Discount]";
			$price_eyes = $price_eyes / 2;
			$price = $price / 2;
		} else if ($rl["promotion_code"] == 4) {
			$promotion_code_value = "ICoLA-83523 / [50% Discount]";
			$price_eyes = $price_eyes / 2;
			$price = $price / 2;
		}
	}


	if ($rl["registration_status"] == 2 || $rl["registration_status"] == 3) {
		$price = isset($total_price_kr) ? "₩ " . $total_price_kr : "USD " . $total_price_us;
	} else if ($rl["registration_status"] == 4) {
		$price = isset($total_price_kr) ? "₩ 0" : "USD 0";
	} else {
		if ($rl["nation_no"] == 25) {
			$price = "₩ " . $price;
		} else {
			$price = "USD " . $price;
		}
	}

	//결제 방식
	$payment_methods = $rl["payment_methods"] == 0 ? "카드결제" : "계좌이체";

	$html .= '<tr class="tr_center">';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $no++ . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["register_date"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;"><a href="mailto:' . $rl["member_email"] . '">' . $rl["member_email"] . '</a></td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $nation_name . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["member_nation"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["member_status"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["registration_name"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["member_name_kor"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["affiliation"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["affiliation_kor"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["department"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["member_type"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $member_type_kor . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . ($rl["licence_number"] != "Not applicable" ? $rl["licence_number"] : "") . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . ($rl["specialty_number"] != "Not applicable" ? $rl["specialty_number"] : "") . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . ($rl["nutritionist_number"] != "Not applicable" ? $rl["nutritionist_number"] : "") . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["phone"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["welcome_reception_yn"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["day1_luncheon_yn"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["day2_breakfast_yn"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["day2_luncheon_yn"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["day3_breakfast_yn"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["day3_luncheon_yn"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["request_food"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $register_path_value . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $status_type . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["payment_date"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $price . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $payment_methods . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $promotion_code_value . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["recommended_by"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_name"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["in_nation_en"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_address"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_passport"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_date_of_birth"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_date_of_issue"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_date_of_expiry"] . '</td>';
	$html .= '<td style="border-style: solid; border-width:thin;">' . $rl["invitation_length_of_visit"] . '</td>';
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
			<h1 class="font_title">Registration</h1>
			<!-- <button type="button" class="btn floatR" onclick="javascript:window.open('./member_list.php?for=offline');">네임택 보기</button> -->
			<button type="button" class="btn excel_download_btn" onclick="javascript:fnExcelReport('Registration', html);">엑셀 다운로드</button>
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
								<input type="text" name="id" value="<?= $id; ?>">
							</td>
							<th>Name</th>
							<td class="select_wrap clearfix2">
								<input type="text" name="name" data-type="string" value="<?= $name; ?>">
							</td>
						</tr>
						<tr>
							<!--<th>Online/Offline</th>-->
							<!--<td>-->
							<!--	<select name="attendance_type">-->
							<!--		<option value="" <?= $attendance_type == "" ? "selected" : "" ?>>전체</option>-->
							<!--		<option value="1" <?= $attendance_type == "1" ? "selected" : "" ?>>Online</option>-->
							<!--		<option value="0" <?= $attendance_type == "0" ? "selected" : "" ?>>Offline</option>-->
							<!--		<option value="2" <?= $attendance_type == "2" ? "selected" : "" ?>>Online + Offline</option>-->
							<!--	</select>-->
							<!--</td> -->
							<th>등록일</th>
							<td class="input_wrap"><input value="<?= $s_date ?>" type="text" name="s_date" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" data-type="date"> <span>~</span> <input type="text" value="<?= $e_date; ?>" name="e_date" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" data-type="date"></td>

							<td colspan="2"></td>
						</tr>
					</tbody>
				</table>
				<button type="button" class="btn search_btn">검색</button>
			</form>
		</div>
		<div class="contwrap">
			<p class="total_num">총 <?= number_format($count) ?>개</p>
			<table id="datatable" class="list_table">
				<thead>
					<tr class="tr_center">
						<th>결제상태</th>
						<th>ID(Email)</th>
						<th>Member Type</th>
						<!--<th>참석유형</th>-->
						<th>Country</th>
						<th>Name</th>
						<th>Require VISA</th>
						<!--<th>평점신청여부</th>-->
						<!--<th>신청협회</th>-->
						<th>등록일</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (!$registration_list) {
						echo "<tr><td class='no_data' colspan='8'>No Data</td></td>";
					} else {
						foreach ($registration_list as $list) {

							switch ($list["registration_status"]) {
								case 1:
									$payment_status = "결제대기";
									break;
								case 2:
									$payment_status = "결제완료";
									break;
								case 3:
									$payment_status = "환불 요청";
									break;
								case 4:
									$payment_status = "환불";
									break;
								case 0:
									$payment_status = "등록 취소";
									break;
							}
					?>
							<tr class="tr_center">
								<td class="<?= $payment_status == "결제대기" ? "red_color" : "blue_color" ?>">
									<?= isset($payment_status) ? $payment_status : "-" ?></td>
								<td><a href="./member_detail_registration.php?idx=<?= isset($list["member_idx"]) ? $list["member_idx"] : "" ?>"><?= isset($list["member_email"]) ? $list["member_email"] : "-" ?></a>
								</td>
								<td><?= isset($list["member_type"]) ? $list["member_type"] : "-" ?></td>
								<!--<td><?= isset($list["registration_type"]) ? $list["registration_type"] : "-" ?></td>-->
								<td><?= isset($list["member_nation"]) ? $list["member_nation"] : "-" ?></td>
								<td><?= isset($list["member_name"]) ? $list["member_name"] : "-" ?></td>
								<td><a href="./member_detail_registration.php.php?idx=<?= isset($list["idx"]) ? $list["idx"] : "" ?>"><?= ($list['invitation_yn'] == 'Y' ? "Yes" : "No") ?></a>
								</td>
								<!--<td><?= isset($list["is_score"]) ? $list["is_score"] : "-" ?></td>-->
								<!--<td><?= isset($list["etc2"]) ? $list["etc2"] : "-" ?></td>-->
								<td><?= isset($list["register_date"]) ? $list["register_date"] : "-" ?></td>
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
	var html = '<?= $html ?>';
</script>
<?php include_once('./include/footer.php'); ?>