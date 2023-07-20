<?php
include_once('./include/head.php');
include_once('./include/header.php');

if ($admin_permission["auth_apply_registration"] == 0) {
	echo '<script>alert("권한이 없습니다.");history.back();</script>';
}

$registration_idx = $_GET["idx"];

$auth = $admin_permission["auth_apply_registration"];
if ($auth == 0) {
	echo '<script>alert("권한이 없습니다.")</script>';
	echo '<script>history.back();</script>';
}
$is_modify = ($auth >= 2);

$registration_detail_query =	"
										SELECT
											(
												CASE rr.welcome_reception_yn
													WHEN 'Y' THEN 'YES'
													ELSE 'NO'
												END
											) AS welcome_reception_yn,
											(
												CASE rr.day1_luncheon_yn
													WHEN 'Y' THEN 'YES'
													ELSE 'NO'
												END
											) AS day1_luncheon_yn,
											(
												CASE rr.day2_breakfast_yn
													WHEN 'Y' THEN 'YES'
													ELSE 'NO'
												END
											) AS day2_breakfast_yn,
											(
												CASE rr.day2_luncheon_yn
													WHEN 'Y' THEN 'YES'
													ELSE 'NO'
												END
											) AS day2_luncheon_yn,
											(
												CASE rr.day3_breakfast_yn
													WHEN 'Y' THEN 'YES'
													ELSE 'NO'
												END
											) AS day3_breakfast_yn,
											(
												CASE rr.day3_luncheon_yn
													WHEN 'Y' THEN 'YES'
													ELSE 'NO'
												END
											) AS day3_luncheon_yn,
											rr.register_path,
											rr.register_path_others,
											rr.invitation_yn,
											rr.invitation_first_name,
											rr.invitation_last_name,
											rr.invitation_nation_no,
											rr.invitation_address,
											rr.invitation_passport,
											rr.invitation_date_of_birth,
											rr.invitation_date_of_issue,
											rr.invitation_date_of_expiry,
											rr.invitation_length_of_visit,
											rr.payment_methods,
											rr.promotion_code,
											rr.recommended_by,

											rr.member_type, rr.member_status, rr.nation_no,
											m.member_idx, m.member_email, m.member_name, m.member_nation, m.member_name_kor,
											DATE(rr.register_date) AS register_date, rr.email AS registration_email, CONCAT(rr.first_name,' ',rr.last_name) AS registration_name, rr.phone,
											rr.affiliation, rr.department, rr.licence_number, rr.academy_number, IFNULL(rr.status, '1') AS registration_status,
											DATE(p.payment_date) AS payment_date, p.total_price_kr, p.total_price_us, p.refund_reason, DATE_FORMAT(p.refund_date, '%Y-%m-%d') AS refund_date, p.refund_bank, p.refund_holder, p.refund_account,
											n.nation_ko AS registration_nation, rr.etc1,
											f.original_name as file_name, CONCAT(f.path,'/',f.save_name) AS file_path,
											(
												CASE rr.attendance_type
													WHEN '2' THEN 'Online + On-site'
													WHEN '1' THEN 'Online Attend'
													WHEN '0' THEN 'On-site Attend'
													ELSE '-'
												END
											) AS attendance_type,
											(
												CASE rr.registration_type
													WHEN '4' THEN 'Faculty'
													WHEN '3' THEN 'Poster Presenter'
													WHEN '2' THEN 'Oral Presenter'
													WHEN '1' THEN 'Invited Speaker'
													WHEN '0' THEN 'Participant'
													ELSE '-'
												END
											) AS registration_type,
											(CASE
												WHEN rr.member_status = '1'
												THEN '회원'
												WHEN rr.member_status = '0'
												THEN '비회원'
												ELSE '-'
											END) AS member_status,
											(CASE
												WHEN rr.is_score = '1'
												THEN '신청'
												WHEN rr.is_score = '0'
												THEN '미신청'
												ELSE '-'
											END) AS is_score,
											ksola_member_status
										FROM request_registration rr
										LEFT JOIN (
											SELECT
												ksola_member_status,
												m.idx AS member_idx, m.email AS member_email, CONCAT(m.first_name,' ',m.last_name) AS member_name, n.nation_ko AS member_nation, m.name_kor AS member_name_kor
											FROM member m
											JOIN nation n
											ON m.nation_no = n.idx
											AND m.idx = (
												SELECT 
													register
												FROM request_registration
												WHERE idx = {$registration_idx}
											)
										) AS m
										ON rr.register = m.member_idx
										LEFT JOIN nation n
										ON rr.nation_no = n.idx
										LEFT JOIN payment p
										ON rr.payment_no = p.idx
										LEFT JOIN file f
										ON rr.etc3 = f.idx
										WHERE rr.idx = {$registration_idx}
									";


$registration_detail = sql_fetch($registration_detail_query);

$member_name_kor = isset($registration_detail["member_name_kor"]) ? $registration_detail["member_name_kor"] : "";
$member_idx = isset($registration_detail["member_idx"]) ? $registration_detail["member_idx"] : "";
$member_type = isset($registration_detail["member_type"]) ? $registration_detail["member_type"] : "";
$member_status = isset($registration_detail["member_status"]) ? $registration_detail["member_status"] : "";
$member_email = isset($registration_detail["member_email"]) ? $registration_detail["member_email"] : "";
$member_name = isset($registration_detail["member_name"]) ? $registration_detail["member_name"] : "";
$member_nation = isset($registration_detail["member_nation"]) ? $registration_detail["member_nation"] : "";
$attendance_type = isset($registration_detail["attendance_type"]) ? $registration_detail["attendance_type"] : "";
$registration_type = isset($registration_detail["registration_type"]) ? $registration_detail["registration_type"] : "";
$is_score = isset($registration_detail["is_score"]) ? $registration_detail["is_score"] : "";
$registration_email = isset($registration_detail["registration_email"]) ? $registration_detail["registration_email"] : "";
$registration_nation = isset($registration_detail["registration_nation"]) ? $registration_detail["registration_nation"] : "";
$registration_name = isset($registration_detail["registration_name"]) ? $registration_detail["registration_name"] : "";
$phone = isset($registration_detail["phone"]) ? $registration_detail["phone"] : "";
$affiliation = isset($registration_detail["affiliation"]) ? $registration_detail["affiliation"] : "-";
$department = isset($registration_detail["department"]) ? $registration_detail["department"] : "-";
$licence_number = isset($registration_detail["licence_number"]) ? $registration_detail["licence_number"] : "-";
$academy_number = isset($registration_detail["academy_number"]) ? $registration_detail["academy_number"] : "-";
$registration_status = isset($registration_detail["registration_status"]) ? $registration_detail["registration_status"] : "";
$payment_date = isset($registration_detail["payment_date"]) ? $registration_detail["payment_date"] : "-";
$payment_price = isset($registration_detail["total_price_us"]) ? "$ " . number_format($registration_detail["total_price_us"]) : (isset($registration_detail["total_price_kr"]) ? "￦ " . number_format($registration_detail["total_price_kr"]) : "-");
$refund_reason = isset($registration_detail["refund_reason"]) ? $registration_detail["refund_reason"] : "";
$refund_date = isset($registration_detail["refund_date"]) ? $registration_detail["refund_date"] : "-";
$refund_bank = isset($registration_detail["refund_bank"]) ? $registration_detail["refund_bank"] : "";
$refund_holder = isset($registration_detail["refund_bank"]) ? $registration_detail["refund_holder"] : "";
$refund_account = isset($registration_detail["refund_account"]) ? $registration_detail["refund_account"] : "";
$register_date = isset($registration_detail["register_date"]) ? $registration_detail["register_date"] : "";

$etc = $registration_detail["etc1"] ?? null;
$identification_file = isset($registration_detail["file_name"]) ? $registration_detail["file_name"] : "";
$identification_file_path = isset($registration_detail["file_path"]) ? $registration_detail["file_path"] : "";

$disabled = $registration_status == "3" ? "" : ($registration_status == "4" ? "" : "disabled");


$nation_no = isset($registration_detail["nation_no"]) ? $registration_detail["nation_no"] : "";
$payment_methods = isset($registration_detail["payment_methods"]) ? $registration_detail["payment_methods"] : "";
$payment_methods = ($payment_methods == 0) ? "카드 결제" : "계좌 이체";


//2022-05-17 추가
$promotion_code = isset($registration_detail["promotion_code"]) ? $registration_detail["promotion_code"] : -1;
$recommended_by = isset($registration_detail["recommended_by"]) ? $registration_detail["recommended_by"] : "-";

//2022-05-06 추가
$welcome_reception_yn = isset($registration_detail["welcome_reception_yn"]) ? $registration_detail["welcome_reception_yn"] : "";
$day1_luncheon_yn = isset($registration_detail["day1_luncheon_yn"]) ? $registration_detail["day1_luncheon_yn"] : "";
$day2_breakfast_yn = isset($registration_detail["day2_breakfast_yn"]) ? $registration_detail["day2_breakfast_yn"] : "";
$day2_luncheon_yn = isset($registration_detail["day2_luncheon_yn"]) ? $registration_detail["day2_luncheon_yn"] : "";
$day3_breakfast_yn = isset($registration_detail["day3_breakfast_yn"]) ? $registration_detail["day3_breakfast_yn"] : "";
$day3_luncheon_yn = isset($registration_detail["day3_luncheon_yn"]) ? $registration_detail["day3_luncheon_yn"] : "";

$register_path = $registration_detail["register_path"] ?? null;
$register_path_others = $registration_detail["register_path_others"] ?? "";


$invitation_yn = isset($registration_detail["invitation_yn"]) ? $registration_detail["invitation_yn"] : "";

if ($invitation_yn == "Y") {
	$invitation_first_name = isset($registration_detail["invitation_first_name"]) ? $registration_detail["invitation_first_name"] : "";
	$invitation_last_name = isset($registration_detail["invitation_last_name"]) ? $registration_detail["invitation_last_name"] : "";
	$invitation_nation_no = isset($registration_detail["invitation_nation_no"]) ? $registration_detail["invitation_nation_no"] : "";
	$invitation_address = isset($registration_detail["invitation_address"]) ? $registration_detail["invitation_address"] : "";
	$invitation_passport = isset($registration_detail["invitation_passport"]) ? $registration_detail["invitation_passport"] : "";
	$invitation_date_of_birth = isset($registration_detail["invitation_date_of_birth"]) ? $registration_detail["invitation_date_of_birth"] : "";
	$invitation_date_of_issue = isset($registration_detail["invitation_date_of_issue"]) ? $registration_detail["invitation_date_of_issue"] : "";
	$invitation_date_of_expiry = isset($registration_detail["invitation_date_of_expiry"]) ? $registration_detail["invitation_date_of_expiry"] : "";
	$invitation_length_of_visit = isset($registration_detail["invitation_length_of_visit"]) ? $registration_detail["invitation_length_of_visit"] : "";

	$nation_query = "SELECT
							nation_en
						FROM nation
						WHERE idx =" . $invitation_nation_no;

	$nation_value = sql_fetch($nation_query)["nation_en"];
}

$ksola_member_status = isset($registration_detail["ksola_member_status"]) ? $registration_detail["ksola_member_status"] : "";

$register_paths = array();
$register_paths = explode(",", $register_path);
$register_path_value = "";


if ($nation_no == 25) {
	for ($i = 0; $i < count($register_paths) - 1; $i++) {
		if ($register_paths[$i] == 0) {
			$register_path_value .= " 홈페이지 또는 홍보메일, ";
		} else if ($register_paths[$i] == 1) {
			$register_path_value .= "유관학회 홍보메일 또는 게시판 광고, ";
		} else if ($register_paths[$i] == 2) {
			$register_path_value .= "초청연자/좌장으로 초청받음, ";
		} else if ($register_paths[$i] == 3) {
			$register_path_value .= "이전 ICoLA에 참석한 경험이 있음, ";
		} else if ($register_paths[$i] == 4) {
			$register_path_value .= "제약회사 소개, ";
		} else if ($register_paths[$i] == 5) {
			$register_path_value .= "지인을 통해, ";
		} else if ($register_paths[$i] == 6) {
			$register_path_value .= "인터넷 검색, ";
		}
	}
} else {
	for ($i = 0; $i < count($register_paths) - 1; $i++) {
		if ($register_paths[$i] == 0) {
			$register_path_value .= " 홈페이지 또는 홍보메일, ";
		} else if ($register_paths[$i] == 1) {
			$register_path_value .= "유관학회 홍보메일 또는 게시판 광고, ";
		} else if ($register_paths[$i] == 3) {
			$register_path_value .= "초청연자/좌장으로 초청받음, ";
		} else if ($register_paths[$i] == 2) {
			$register_path_value .= "이전 ICoLA에 참석한 경험이 있음, ";
		} else if ($register_paths[$i] == 5) {
			$register_path_value .= "제약회사 소개, ";
		} else if ($register_paths[$i] == 4) {
			$register_path_value .= "지인을 통해, ";
		} else if ($register_paths[$i] == 6) {
			$register_path_value .= "인터넷 검색, ";
		}
	}
}

if ($member_type == "Specialist") {
	$member_type = "전문의";
} else if ($member_type == "Professor") {
	$member_type = "교수";
} else if ($member_type == "Fellow") {
	$member_type = "전임의";
} else if ($member_type == "Resident") {
	$member_type = "전공의";
} else if ($member_type == "Researcher") {
	$member_type = "연구원";
} else if ($member_type == "Nurse") {
	$member_type = "간호사";
} else if ($member_type == "Nutritionist") {
	$member_type = "영양사";
} else if ($member_type == "Student") {
	$member_type = "학생";
} else if ($member_type == "Pharmacist") {
	$member_type = "약사";
} else if ($member_type == "Corporate member") {
	$member_type = "기업회원";
} else if ($member_type == "Others") {
	$member_type = "기타";
} else if ($member_type == "Military medical officer") {
	$member_type = "군의관/공보의";
}


if (!empty($register_path_others)) {
	$register_path_value .= $register_path_others . ", ";
}

$register_path_value = rtrim($register_path_value, ", ");

$select_registration_query =	"
											SELECT
												r.*, n.nation_ko, n.nation_en, f.original_name as file_name, CONCAT(f.path,'/',f.save_name) AS file_path, 
												iep.off_member_usd, iep.off_guest_usd, iep.on_member_usd, iep.on_guest_usd, 
												iep.off_member_krw, iep.off_guest_krw, iep.on_member_krw, iep.on_guest_krw
											FROM request_registration r
											LEFT JOIN nation n
												ON r.nation_no = n.idx
											LEFT JOIN file f
												ON r.etc3 = f.idx
											LEFT JOIN info_event_price AS iep
												ON iep.type_en = r.member_type
											WHERE r.idx = {$registration_idx}
										";


$registration_data = sql_fetch($select_registration_query);

$us_price = $registration_data["price"];

$sql_during =	"SELECT
						IF(NOW() <= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

//특정 회원 가격 변동 이후 삭제
if ($registration_idx == 512) {
	$r_during_yn = 'N';
}

if ($r_during_yn == 'Y') {
	if ($us_price == 250) {
		$us_price = 300;
	} else if ($us_price == 100) {
		$us_price = 150;
	} else if ($us_price == 80000) {
		$us_price = 100000;
	} else if ($us_price == 100000 && $ksola_member_status == 0) {
		$us_price = 120000;
	} else if ($us_price == 50000) {
		$us_price = 60000;
	}
}


$ko_price = $us_price;

$price = $us_price;
$price_eyes = $price;
$price_name = ($nation_no == 25) ? "KRW" : "USD";

if ($nation_no != 25) {
	$price_eyes = $price;
	$price = $price * 100;
}

if ($promotion_code == 0 && $promotion_code != "") {
	$promotion_code_value = "ICoLA-77932 / [100% Discount]";
	$price_eyes = 0;
	$price = 0;
} else if ($promotion_code == 1) {
	$promotion_code_value = "ICoLA-59721 / [50% Discount]";
	$price_eyes = $price_eyes / 2;
	$price = $price / 2;
} else if ($promotion_code == 2) {
	$promotion_code_value = "ICoLA-89359 / [50% Discount]";
	$price_eyes = $price_eyes / 2;
	$price = $price / 2;
} else if ($promotion_code == 4) {
	$promotion_code_value = "ICoLA-83523 / [50% Discount]";
	$price_eyes = $price_eyes / 2;
	$price = $price / 2;
}

?>
<style>
	.rs2_hidden {
		display: none;
		margin-top: 10px;
		width: calc(100% - 180px);
	}

	[name=rs2_unit] {
		width: 30% !important;
	}

	[name=rs2_price] {
		width: calc(68% - 10px) !important;
		margin-left: 10px;
	}
</style>
<section class="detail">
	<div class="container">
		<div class="title">
			<h1 class="font_title">Registration</h1>
		</div>
		<div class="contwrap has_fixed_title">
			<h2 class="sub_title">회원 정보</h2>
			<input type="hidden" name="registration_idx" value="<?= $registration_idx ?>">
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
						<td><a href="./member_detail.php?idx=<?= $member_idx ?>"><?= $member_email ?></a></td>
						<th>Name / Country</th>
						<td><?= $member_name ?> / <?= $member_nation ?></td>
					</tr>
					<tr>
						<th>Category</th>
						<td><?= $member_type; ?></td>
						<th>Name (KOR)</th>
						<td><?= $member_name_kor; ?></td>
					</tr>
					<tr>
						<th>등록일</th>
						<td colspan="3"><?= $register_date ?></td>
					</tr>
				</tbody>
			</table>
			<!-- <h2 class="sub_title">신청자 정보</h2> -->
			<!-- <table> -->
			<!-- 	<colgroup> -->
			<!-- 		<col width="10%"> -->
			<!-- 		<col width="40%"> -->
			<!-- 		<col width="10%"> -->
			<!-- 		<col width="40%"> -->
			<!-- 	</colgroup> -->
			<!-- 	<tbody> -->
			<!-- 		<tr> -->
			<!-- 			<th>Attendance Type</th> -->
			<!-- 			<td><?= $attendance_type ?></td> -->
			<!-- 			<th>Registration Type</th> -->
			<!-- 			<td><?= $registration_type ?></td> -->
			<!-- 		</tr> -->
			<!--<tr>
							<th>평점신청여부</th>
							<td><?= $is_score ?></td>
							<th>회원여부</th>
							<td><?= $member_status ?></td>
						</tr>
						<tr>
							<th>ID(Email)</th>
							<td><?= $registration_email ?></td>
							<th>Country</th>
							<td><?= $registration_nation ?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?= $registration_name ?></td>
							<th>Phone Number</th>
							<td><?= $phone ?></td>
						</tr>
						<tr>
							<th>Affiliation</th>
							<td><?= $affiliation ?></td>
							<th>Department</th>
							<td><?= $department ?></td>
						</tr>
						<tr>
							<th>Doctor’s Licence Number</th>
							<td><?= $licence_number ?></td>
							<th>학회번호</th>
							<td><?= $academy_number ?></td>
						</tr>
						<tr>
							<th>Register Path</th>
							<td>
							<?php
							echo $register_path;
							if (!empty($etc)) {
								echo ' / ' . $etc;
							}
							?>
							</td>
							<th>증빙서류</th>
							<?php
							if (!$identification_file) {
								echo "<td>No Data</td>";
							} else {
								$ext = strtolower(end(explode(".", $identification_file)));
							?>
							<?php if ($ext == "pdf") { ?>
								<td><a href="./pdf_viewer.php?path=<?= $identification_file_path ?>" target="_blank"><?= $identification_file ?></a></td>
							<?php } else { ?>
								<td><a href="<?= $identification_file_path ?>" download><?= $identification_file ?></a></td>
							<?php } ?>
							<?php
							}
							?>
						</tr>-->
			<!-- 	</tbody> -->
			<!-- </table> -->

			<h2 class="sub_title">결제 정보</h2>
			<table>
				<colgroup>
					<col width="10%">
					<col width="40%">
					<col width="10%">
					<col width="40%">
				</colgroup>
				<tbody>
					<!--<tr>
							<th>Online/Offline</th>
							<td><?= $attendance_type ?></td>
							<th>참석유형</th>
							<td><?= $registration_type ?></td>
						</tr>
						<tr>
							<th>평점신청여부</th>
							<td><?= $is_score ?></td>
							<th>회원여부</th>
							<td><?= $member_status ?></td>
						</tr>
						<tr>
							<th>ID(Email)</th>
							<td><?= $registration_email ?></td>
							<th>Country</th>
							<td><?= $registration_nation ?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?= $registration_name ?></td>
							<th>Phone Number</th>
							<td><?= $phone ?></td>
						</tr>
						<tr>
							<th>Affiliation</th>
							<td><?= $affiliation ?></td>
							<th>Department</th>
							<td><?= $department ?></td>
						</tr>
						<tr>
							<th>Doctor’s Licence Number</th>
							<td><?= $licence_number ?></td>
							<th>학회번호</th>
							<td><?= $academy_number ?></td>
						</tr>
						<tr>
							<th>Register Path</th>
							<td>
							<?php
							echo $register_path;
							if (!empty($etc)) {
								echo ' / ' . $etc;
							}
							?>
							</td>
							<th>증빙서류</th>
							<?php
							if (!$identification_file) {
								echo "<td>No Data</td>";
							} else {
								$ext = strtolower(end(explode(".", $identification_file)));
							?>
							<?php if ($ext == "pdf") { ?>
								<td><a href="./pdf_viewer.php?path=<?= $identification_file_path ?>" target="_blank"><?= $identification_file ?></a></td>
							<?php } else { ?>
								<td><a href="<?= $identification_file_path ?>" download><?= $identification_file ?></a></td>
							<?php } ?>
							<?php
							}
							?>
						</tr>-->
					<tr>
						<th>결제상태</th>
						<td class="input_btn_wrap">
							<select name="payment_status">
								<option value="1" <?= $registration_status == 1 ? "selected" : "" ?>>Holding</option>
								<option value="2" <?= $registration_status == 2 ? "selected" : "" ?>>Payment Received
								</option>
								<option value="3" <?= $registration_status == 3 ? "selected" : "" ?>>Request Cancel
								</option>
								<option value="4" <?= $registration_status == 4 ? "selected" : "" ?>>Canceled</option>
							</select>
							<div class="rs2_hidden">
								<select name="rs2_unit">
									<option>KRW</option>
									<option>USD</option>
								</select>
								<input type="text" name="rs2_price" placeholder="price">
							</div>
							<?php
							if ($is_modify) {
							?>
								<button type="button" class="btn submit" data-type="update_payment_status">저장</button>
							<?php
							}
							?>
						</td>
						<?php
						if ($registration_status == 1) {
						?>
							<th>결제 예정금액</th>
							<td>
								<?= (($nation_no == 25) ? $price_name . " " . number_format($price_eyes) : $price_name . " " . number_format($price_eyes)) ?>
							</td>
						<?php
						} else {
						?>
							<th>결제일 / 결제금액</th>
							<td><?= $payment_date . " / " . $payment_price ?></td>
						<?php
						}
						?>
					</tr>
					<tr>
						<th>환불사유</th>
						<td class="input_btn_wrap">
							<input type="text" class="refund" name="refund_reason" maxlength="100" value="<?= $refund_reason ?>" <?= $disabled ?>>
							<?php
							if ($is_modify) {
							?>
								<button type="button" class="btn submit refund" data-type="update_refund_reason" <?= $disabled ?>>저장</button>
							<?php
							}
							?>
						</td>
						<th>환불일</th>
						<td><?= $refund_date ?></td>
					</tr>
					<tr>
						<th>환불받을 계좌</th>
						<td>
							<div class="clearfix input_wrap2">
								<input type="text" class="default_width refund" name="refund_bank" placeholder="은행명" value="<?= $refund_bank ?>" <?= $disabled ?>>
								<input type="text" class="default_width refund" name="refund_holder" placeholder="예금주" value="<?= $refund_holder ?>" <?= $disabled ?>>
								<input type="text" class="default_width refund" name="refund_account" placeholder="계좌번호" value="<?= $refund_account ?>" <?= $disabled ?>>
								<?php
								if ($is_modify) {
								?>
									<button type="button" class="btn submit refund" data-type="update_refund_info" <?= $disabled ?>>저장</button>
								<?php
								}
								?>
							</div>
						</td>
						<th>결제 방식</th>
						<td><?= ($promotion_code == 0) ? "-" : $payment_methods; ?></td>
					</tr>
					<?php
					if ($promotion_code != -1) {
					?>
						<tr>
							<th>Promotion code / 할인율</th>
							<td><?= $promotion_code_value; ?></td>
							<th>추천인</th>
							<td><?= $recommended_by; ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<!--20222-05-06 추가-->
			<h2 class="sub_title">기타</h2>
			<table>
				<colgroup>
					<col width="10%">
					<col width="40%">
					<col width="10%">
					<col width="40%">
				</colgroup>
				<tbody>
					<tr>
						<th>Welcome Reception</th>
						<td colspan="3"><?= $welcome_reception_yn; ?></td>
					</tr>
					<tr>
						<th>Day 1- Luncheon Symposium</th>
						<td colspan="3"><?= $day1_luncheon_yn; ?></td>
					</tr>
					<tr>
						<th>Day 2- Breakfast Symposium</th>
						<td colspan="3"><?= $day2_breakfast_yn; ?></td>
					</tr>
					<tr>
						<th>Day 2- Luncheon Symposium</th>
						<td colspan="3"><?= $day2_luncheon_yn; ?></td>
					</tr>
					<tr>
						<th>Day 3- Breakfast Symposium</th>
						<td colspan="3"><?= $day3_breakfast_yn; ?></td>
					</tr>
					<tr>
						<th>Day 3- Luncheon Symposium</th>
						<td colspan="3"><?= $day3_luncheon_yn; ?></td>
					</tr>
				</tbody>
			</table>

			<h2 class="sub_title">설문조사 정보</h2>
			<table>
				<colgroup>
					<col width="10%">
					<col width="40%">
					<col width="10%">
					<col width="40%">
				</colgroup>
				<tbody>
					<tr>
						<th>ISCP 2023 개최정보를<br>어떻게 알게 되셨나요?</th>
						<td colspan="3"><?= $register_path_value ?></td>
					</tr>
				</tbody>
			</table>

			<?php
			if ($invitation_yn == "Y") {
			?>
				<h2 class="sub_title">비자 관련 정보</h2>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>Name of Passport</th>
							<td><?= $invitation_first_name . " " . $invitation_last_name ?></td>
							<th>Country</th>
							<td><?= $nation_value ?></td>
						</tr>
						<tr>
							<th>Address</th>
							<td><?= $invitation_address ?></td>
							<th>Passport Number</th>
							<td><?= $invitation_passport ?></td>
						</tr>
						<tr>
							<th>Date of Birth</th>
							<td><?= $invitation_date_of_birth ?></td>
							<th>Date of Issue</th>
							<td><?= $invitation_date_of_issue ?></td>
						</tr>
						<tr>
							<th>Date of Expiry</th>
							<td><?= $invitation_date_of_expiry ?></td>
							<th>Length of Visit</th>
							<td><?= $invitation_length_of_visit ?></td>
						</tr>
					</tbody>
				</table>
			<?php
			}
			?>
			<div class="btn_wrap">
				<button type="button" class="border_btn" onclick="location.href='./registration_list.php'">목록</button>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function() {
		const reg_status = "<?= $registration_status ?>";
		$("select[name=payment_status]").on("change", function() {
			var _this_status = $(this).val();

			if (reg_status == 1 && _this_status == 2) {
				$('.rs2_hidden').css('display', 'inline-block');
			} else {
				$('.rs2_hidden').hide();
			}

			if (_this_status == 3 || _this_status == 4) {
				$(".refund").attr("disabled", false);
			} else {
				$(".refund").attr("disabled", true);
			}
		});

		// 결제 금액 숫자만
		$("input[name=rs2_price]").keyup(function() {
			var _this = $(this);
			if (_this == 0) return 0;
			var n = _this.val().toString().replace(/[^0-9]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ',');
			_this.val(n);
		});

		$(".submit").on("click", function() {
			var data = {};
			var submit_type = $(this).data("type");
			var registration_idx = $("input[name=registration_idx]").val();

			if (submit_type == "update_payment_status") {
				if (!$("select[name=payment_status]").val()) {
					alert("결제상태가 선택되지 않았습니다.");
					return false;
				}
				data["payment_status"] = $("select[name=payment_status]").val();

				if (reg_status == 1 && data["payment_status"] == 2) {
					// 금액
					if (!$("input[name=rs2_price]").val()) {
						alert("결제금액이 입력되지 않았습니다.");
						return false;
					} else {
						data["payment_unit"] = $("select[name=rs2_unit]").val();
						data["payment_price"] = $("input[name=rs2_price]").val().replace(/[^0-9]/g, "");
					}
				}
			} else if (submit_type == "update_refund_reason") {
				if ($("input[name=refund_reason]").val() == "") {
					alert("환불사유가 입력되지 않았습니다.");
					return false;
				}
				data["refund_reason"] = $("input[name=refund_reason]").val();
			} else if (submit_type == "update_refund_info") {
				if ($("input[name=refund_bank]").val() == "" || $("input[name=refund_holder]").val() ==
					"" || $("input[name=refund_account]").val() == "") {
					alert("환불받은 계좌 정보를 확인해주세요.");
					return false;
				}
				data["refund_bank"] = $("input[name=refund_bank]").val();
				data["refund_holder"] = $("input[name=refund_holder]").val();
				data["refund_account"] = $("input[name=refund_account]").val();

			}

			if (confirm("입력하신 내용으로 저장하시겠습니까?")) {
				$.ajax({
					url: "../ajax/admin/ajax_payment.php",
					type: "POST",
					data: {
						flag: "update_payment",
						idx: registration_idx,
						type: submit_type,
						data: data
					},
					dataType: "JSON",
					success: function(res) {
						if (res.code == 200) {
							alert("저장이 완료되었습니다.");
							window.location.reload();
						} else if (res.code == 400) {
							alert("저장에 실패하였습니다.");
							return false;
						} else if (res.code == 401) {
							alert("결제정보가 존재하지 않아 환불정보 입력에 실패하였습니다.");
							return false;
						} else {
							alert("일시적으로 요청이 거절되었습니다. 잠시 후 다시 시도해주세요.");
							return false;
						}
					}
				});
			}
		});

	});
</script>
<?php include_once('./include/footer.php'); ?>