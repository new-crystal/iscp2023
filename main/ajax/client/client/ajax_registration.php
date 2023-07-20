<?php include_once("../../common/common.php"); ?>
<?php

if ($_POST["flag"] == "registration") {
	$user_idx = $_SESSION["USER"]["idx"];

	$member_query = "SELECT
							ksola_member_status
						FROM member
						WHERE idx = " . $user_idx;

	$member_status = sql_fetch($member_query)["ksola_member_status"];

	$data = isset($_POST["data"]) ? $_POST["data"] : "";

	//필수
	//$attendance_type = isset($_POST["attendance_type"]) ? $_POST["attendance_type"] : "";
	//$rating = isset($_POST["rating"]) ? $_POST["rating"] : "";
	//$member_status = isset($_POST["member_status"]) ? $_POST["member_status"] : "";
	$email = isset($_POST["email"]) ? $_POST["email"] : "";
	$nation_no = isset($_POST["nation_no"]) ? $_POST["nation_no"] : "";
	$last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : "";
	$first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : "";
	$name_kor = isset($_POST["name_kor"]) ? $_POST["name_kor"] : "";
	//$nation_tel = isset($_POST["nation_tel"]) ? $_POST["nation_tel"] : "";
	//$phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
	$member_type = isset($_POST["member_type"]) ? $_POST["member_type"] : "";
	//$member_type = ($member_type != "Choose") ? $member_type : "";
	//$registration_type = isset($_POST["registration_type"]) ? $_POST["registration_type"] : "";

	//$payment_methods = isset($_POST["payment_methods"]) ? $_POST["payment_methods"] : "";
	$price = ($_POST["price"] != "undefined") ? $_POST["price"] : "''";
	//$welcome_reception = ($_POST["welcome_reception"] != "undefined") ? $_POST["welcome_reception"] : "";


	$welcome_reception_yn = isset($_POST["welcome_reception_yn"]) ? $_POST["welcome_reception_yn"] : "";
	//2022-05-06 새로 추가 된 항목들
	$day1_luncheon_yn = isset($_POST["day1_luncheon_yn"]) ? $_POST["day1_luncheon_yn"] : "";
	$day2_breakfast_yn = isset($_POST["day2_breakfast_yn"]) ? $_POST["day2_breakfast_yn"] : "";
	$day2_luncheon_yn = isset($_POST["day2_luncheon_yn"]) ? $_POST["day2_luncheon_yn"] : "";
	$day3_breakfast_yn = isset($_POST["day3_breakfast_yn"]) ? $_POST["day3_breakfast_yn"] : "";
	$day3_luncheon_yn = isset($_POST["day3_luncheon_yn"]) ? $_POST["day3_luncheon_yn"] : "";

	$register_path = isset($_POST["register_path"]) ? $_POST["register_path"] : "";
	$register_path_others = isset($_POST["register_path_others"]) ? $_POST["register_path_others"] : "";

	$invitation_yn = isset($_POST["invitation_yn"]) ? $_POST["invitation_yn"] : "";
	$invitation_first_name = isset($_POST["invitation_first_name"]) ? $_POST["invitation_first_name"] : "";
	$invitation_last_name = isset($_POST["invitation_last_name"]) ? $_POST["invitation_last_name"] : "";
	$invitation_nation_no = isset($_POST["invitation_nation_no"]) ? $_POST["invitation_nation_no"] : "";
	$invitation_address = isset($_POST["invitation_address"]) ? $_POST["invitation_address"] : "";
	$invitation_passport = isset($_POST["invitation_passport"]) ? $_POST["invitation_passport"] : "";
	$invitation_date_of_birth = isset($_POST["invitation_date_of_birth"]) ? $_POST["invitation_date_of_birth"] : "";
	$invitation_date_of_issue = isset($_POST["invitation_date_of_issue"]) ? $_POST["invitation_date_of_issue"] : "";
	$invitation_date_of_expiry = isset($_POST["invitation_date_of_expiry"]) ? $_POST["invitation_date_of_expiry"] : "";
	$invitation_length_of_visit = isset($_POST["invitation_length_of_visit"]) ? $_POST["invitation_length_of_visit"] : "";


	$sql_type =  isset($_POST["sql_type"]) ? $_POST["sql_type"] : "";

	if ($sql_type == "UPDATE") {
		$update_idx = isset($_POST["registration_idx"]) ? $_POST["registration_idx"] : "";
	}

	//$affiliation = isset($_POST["affiliation"]) ? $_POST["affiliation"] : "";
	//$department = isset($_POST["department"]) ? $_POST["department"] : "";
	//$licence_number = isset($_POST["licence_number"]) ? $_POST["licence_number"] : "";
	//$academy_number = isset($_POST["academy_number"]) ? $_POST["academy_number"] : "";
	//$register_path = isset($_POST["register_path"]) ? $_POST["register_path"] : "";
	//$register_path = ($register_path != "Choose") ? $register_path : "";
	//$etc = $_POST["etc"] ?? null;
	//$etc = htmlspecialchars($etc);
	//$result_org = isset($_POST["result_org"]) ? $_POST["result_org"] : "";
	//if($nation_tel != "" && $phone != "") {
	//	$phone = $nation_tel."-".$phone;
	//}

	$check_registration_query =	"
										SELECT
											r.idx, p.idx AS payment_idx, p.payment_status, r.status
										FROM request_registration AS r
										LEFT JOIN(
											SELECT
												idx, payment_status
											FROM payment
										)AS p
										ON r.payment_no = p.idx
										WHERE is_deleted = 'N'
										AND register = {$user_idx}
										ORDER BY register_date DESC
										LIMIT 1
									";

	$check_registration = sql_fetch($check_registration_query);

	$registration_idx = $check_registration["idx"];
	$payment_idx = $check_registration["payment_idx"];
	$payment_status = $check_registration["status"];


	if ($sql_type == "UPDATE") {
		if ($registration_idx && ($payment_status != "0" && $payment_status != "4" && $payment_status != "1")) {
			$res = [
				code => 401,
				msg => "already registration"
			];
			echo json_encode($res);
			exit;
		}
	} else {
		if ($registration_idx && ($payment_status != "0" && $payment_status != "4")) {
			$res = [
				code => 401,
				msg => "already registration"
			];
			echo json_encode($res);
			exit;
		}
	}

	$insert_registration_query =	"
											{$sql_type} request_registration
											SET
												member_type		= '{$member_type}',
												#attendance_type = {$attendance_type},
												#is_score = {$rating},
												member_status = {$member_status},
												email = '{$email}',
												nation_no = {$nation_no},
												last_name = '{$last_name}',
												first_name = '{$first_name}',
												#phone = '{$phone}',
												#registration_type = '{$registration_type}',
												register = '{$user_idx}',
												#payment_methods		= '{$payment_methods}',
												price				=  {$price},
												#welcome_reception	=  '{$welcome_reception}',
												invitation_yn		=  '{$invitation_yn}',
												welcome_reception_yn=  '{$welcome_reception_yn}',
												day1_luncheon_yn	=  '{$day1_luncheon_yn}',
												day2_breakfast_yn	=  '{$day2_breakfast_yn}',
												day2_luncheon_yn	=  '{$day2_luncheon_yn}',
												day3_breakfast_yn	=  '{$day3_breakfast_yn}',
												day3_luncheon_yn	=	'{$day3_luncheon_yn}',
												register_path		=  '{$register_path}'
								";

	if ($register_path_others != "") {
		$insert_registration_query .= ", register_path_others = '{$register_path_others}' ";
	}

	if ($name_kor != "") {
		$insert_registration_query .= ", name_kor = '{$name_kor}' ";
	}

	if ($invitation_first_name != "") {
		$insert_registration_query .= ", invitation_first_name = '{$invitation_first_name}' ";
	} else {
		$insert_registration_query .= ", invitation_first_name = '' ";
	}
	if ($invitation_last_name != "") {
		$insert_registration_query .= ", invitation_last_name = '{$invitation_last_name}' ";
	} else {
		$insert_registration_query .= ", invitation_last_name = '' ";
	}
	if ($invitation_nation_no != "") {
		$insert_registration_query .= ", invitation_nation_no = '{$invitation_nation_no}' ";
	} else {
		$insert_registration_query .= ", invitation_nation_no = '' ";
	}
	if ($invitation_address != "") {
		$insert_registration_query .= ", invitation_address = '{$invitation_address}' ";
	} else {
		$insert_registration_query .= ", invitation_address = '' ";
	}
	if ($invitation_passport != "") {
		$insert_registration_query .= ", invitation_passport = '{$invitation_passport}' ";
	} else {
		$insert_registration_query .= ", invitation_passport = '' ";
	}
	if ($invitation_date_of_birth != "") {
		$insert_registration_query .= ", invitation_date_of_birth = '{$invitation_date_of_birth}' ";
	} else {
		$insert_registration_query .= ", invitation_date_of_birth = '' ";
	}
	if ($invitation_date_of_issue != "") {
		$insert_registration_query .= ", invitation_date_of_issue = '{$invitation_date_of_issue}' ";
	} else {
		$insert_registration_query .= ", invitation_date_of_issue = '' ";
	}

	if ($invitation_date_of_expiry != "") {
		$insert_registration_query .= ", invitation_date_of_expiry = '{$invitation_date_of_expiry}' ";
	} else {
		$insert_registration_query .= ", invitation_date_of_expiry = '' ";
	}
	if ($invitation_length_of_visit != "") {
		$insert_registration_query .= ", invitation_length_of_visit = '{$invitation_length_of_visit}' ";
	} else {
		$insert_registration_query .= ", invitation_length_of_visit = '' ";
	}
	if ($update_idx != "") {
		$insert_registration_query .= "WHERE idx = {$update_idx} ";
	}

	//if($affiliation != "") {
	//	$insert_registration_query .= ", affiliation = '{$affiliation}' ";
	//}
	//if($department != "") {
	//	$insert_registration_query .= ", department = '{$department}' ";
	//}
	//if($licence_number != "") {
	//	$insert_registration_query .= ", licence_number = '{$licence_number}' ";
	//}
	//if($academy_number != "") {
	//	$insert_registration_query .= ", academy_number = '{$academy_number}' ";
	//}

	//if($member_type != "") {
	//	$insert_registration_query .= ", member_type = '{$member_type}' ";
	//}
	//if($register_path != "") {
	//	$insert_registration_query .= ", register_path = '{$register_path}' ";
	//}
	//if(!empty($etc)){
	//    $insert_registration_query .= ", etc1 = '{$etc}' ";
	//}
	//if(!empty($result_org)){
	//    $insert_registration_query .= ", etc2 = '{$result_org}' ";
	//}

	//if($_FILES["identification_file"]) {
	//    //파일 업로드
	//    $file_no = upload_file($_FILES["identification_file"], 5);

	//    if($file_no == "") {
	//        $res = [
	//            code => 401,
	//            msg => "file upload error"
	//        ];
	//        echo json_encode($res);
	//        exit;
	//    }

	//    if($file_no != "") {
	//        $insert_registration_query .= ", etc3 = '{$file_no}' ";
	//    }
	//}

	$insert = sql_query($insert_registration_query);

	if ($insert) {
		if ($sql_type == "INSERT") {
			$sql = "SELECT LAST_INSERT_ID() AS last_idx";
			$registration_idx = sql_fetch($sql)['last_idx'];
		} else {
			$registration_idx = $update_idx;
		}

		echo json_encode(array(
			code => 200,
			msg => "success",
			registration_idx => $registration_idx,
			//payment_methods => $payment_methods,
			nation_no		=> $nation_no
		));
		exit;
	} else {
		echo json_encode(array(
			code => 400,
			msg => "error"
		));
		exit;
	}
} else if ($_POST["flag"] == "update") {
	$user_idx = $_SESSION["USER"]["idx"];
	$idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
	//$_POST = isset($_POST["data"]) ? $_POST["data"] : "";

	if ($idx == "") {
		$res = [
			code => 401,
			msg => "no idx"
		];
		echo json_encode($res);
		exit;
	}

	$nation_no = isset($_POST["nation_no"]) ? $_POST["nation_no"] : "";
	$affiliation = isset($_POST["affiliation"]) ? $_POST["affiliation"] : "";
	$department = isset($_POST["department"]) ? $_POST["department"] : "";
	$licence_number = isset($_POST["licence_number"]) ? $_POST["licence_number"] : "";
	$academy_number = isset($_POST["academy_number"]) ? $_POST["academy_number"] : "";

	$update_registration_query =	"
											UPDATE request_registration
											SET
												nation_no   = {$nation_no},
												affiliation = '{$affiliation}',
												department = '{$department}',
												licence_number = '{$licence_number}',
												academy_number = '{$academy_number}',
												modifier = {$user_idx},
												modify_date = NOW()
											WHERE idx = {$idx}
										";

	$update = sql_query($update_registration_query);

	if ($update) {
		$res = [
			code => 200,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 400,
			msg => "update query error"
		];
		echo json_encode($res);
		exit;
	}
} else if ($_POST["flag"] == "update_registration") {
	$user_idx = $_SESSION["USER"]["idx"];
	$idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
	//$_POST = isset($_POST["data"]) ? $_POST["data"] : "";

	if ($idx == "") {
		$res = [
			code => 401,
			msg => "no idx"
		];
		echo json_encode($res);
		exit;
	}


	$last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : "";
	$first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : "";
	$phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
	$nation_tel = isset($_POST["nation_tel"]) ? $_POST["nation_tel"] : "";

	$phone = phoneNumberTransform($nation_tel, $phone);
	$nation_no = isset($_POST["nation_no"]) ? $_POST["nation_no"] : "";
	$affiliation = isset($_POST["affiliation"]) ? $_POST["affiliation"] : "";
	$department = isset($_POST["department"]) ? $_POST["department"] : "";
	//$licence_number = isset($_POST["licence_number"]) ? $_POST["licence_number"] : "";
	//$academy_number = isset($_POST["academy_number"]) ? $_POST["academy_number"] : "";

	$update_registration_query =	"
											UPDATE request_registration
											SET
												phone		= '{$phone}',
												last_name	= '{$last_name}',
												first_name	=	'{$first_name}',
												nation_no   = {$nation_no},
												affiliation = '{$affiliation}',
												department = '{$department}',
												modifier = {$user_idx},
												modify_date = NOW()
											WHERE idx = {$idx}
										";

	$update = sql_query($update_registration_query);

	if ($update) {
		$res = [
			code => 200,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 400,
			msg => "update query error"
		];
		echo json_encode($res);
		exit;
	}
} else if ($_POST["flag"] == "cancel") {
	$user_idx = $_SESSION["USER"]["idx"];
	$registration_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";

	$select_payment_idx_query =	"
									SELECT
										payment_no, register
									FROM request_registration
									WHERE idx = {$registration_idx}
									";

	$payment = sql_fetch($select_payment_idx_query);

	if ($user_idx == "" || $payment["register"] != $user_idx) {
		// 허가받지 않은 사람이나 타인이 요청한 경우
		$res = [
			code => 401,
			msg => "invalid auth"
		];
		echo json_encode($res);
		exit;
	}

	if ($payment["payment_no"]) {
		// 이미 결제건은 취소가 불가능하고 환불요청으로 넘어가야됨.
		$res = [
			code => 402,
			msg => "invalid request status"
		];
		echo json_encode($res);
		exit;
	}

	$update_registration_query =	"
											UPDATE request_registration
											SET 
												status = '0',
												is_deleted = 'Y',
												delete_date = NOW()
											WHERE idx = {$registration_idx}
										";
	$update_payment = sql_query($update_registration_query);

	if ($update_payment) {
		$res = [
			code => 200,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 400,
			msg => "error"
		];
		echo json_encode($res);
		exit;
	}
} else if ($_POST["flag"] == "refund") {
	$user_idx = $_SESSION["USER"]["idx"];
	$registration_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
	$payment_status = isset($_POST["payment_status"]) ? $_POST["payment_status"] : "";

	$update_status = $payment_status == 1 ? "0" : "3"; //결제상태가 결제대기였으면 결제상태를 등록취소(0)로 결제 완료상태이였을땐 환불대기(3) 상태로

	$select_payment_idx_query =	"
									SELECT
										payment_no
									FROM request_registration
									WHERE idx = {$registration_idx}
									";

	$payment_no = sql_fetch($select_payment_idx_query)["payment_no"];

	$update_registration_query =	"
											UPDATE request_registration
											SET
												`status` = '{$update_status}',
												modifier = '{$user_idx}',
												modify_date = NOW()
											WHERE idx = '{$registration_idx}'
										";

	$update_registration = sql_query($update_registration_query);

	if (!$update_registration) {
		$res = [
			code => 400,
			msg => "registration query error"
		];
		echo json_encode($res);
		exit;
	}

	$update_payment_query =		"
										UPDATE payment
										SET 
											payment_status = '{$update_status}'
									";

	if ($update_status == "3") {
		$update_payment_query .=	" , refund_request_date = NOW() ";
	}

	$update_payment_query .= " WHERE idx = {$payment_no} ";

	$update_payment = sql_query($update_payment_query);

	if (!$update_payment) {
		$res = [
			code => 400,
			msg => "payment query error"
		];
		echo json_encode($res);
		exit;
	}

	$res = [
		code => 200,
		msg => "success"
	];
	echo json_encode($res);
	exit;
} else if ($_POST["flag"] == "registration_information") {
	$registration_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";

	$registration_info_query =	"
										SELECT
											reg.*, payment.payment_status, nation.nation_tel
										FROM request_registration reg
										LEFT JOIN payment
										ON reg.payment_no = payment.idx
										LEFT JOIN nation
										ON reg.nation_no = nation.idx 
										WHERE reg.idx = {$idx}
									";

	$registration_info = sql_fetch($registration_info_query);

	if ($registration_info) {
		$res = [
			code => 200,
			msg => "success",
			data => $registration_info
		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 400,
			msg => "error",
		];
		echo json_encode($res);
		exit;
	}
} else if ($_POST["flag"] == "method_update") {

	$registration_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
	$payment_methods = isset($_POST["payment_methods"]) ? $_POST["payment_methods"] : "";

	$update_registration_query =		"
										UPDATE request_registration
										SET 
											payment_methods = '{$payment_methods}'
									";

	$update_registration_query .= " WHERE idx = {$registration_idx} ";
	$update_registration = sql_query($update_registration_query);

	if (!$update_registration) {
		$res = [
			code => 400,
			msg => "registration query error"
		];
		echo json_encode($res);
		exit;
	}

	$res = [
		code => 200,
		msg => "success"
	];
	echo json_encode($res);
	exit;
} else if ($_POST["flag"] == "promotion_code_update") {

	$registration_idx = isset($_POST["registration_idx"]) ? $_POST["registration_idx"] : "";
	$promotion_code = isset($_POST["promotion_code"]) ? $_POST["promotion_code"] : "";

	$promotion_code = strtoupper($promotion_code);

	if ($promotion_code == "ISCP-77932") {
		$promotion_code_value = 0;
	} else if ($promotion_code == "ISCP-59721") {
		$promotion_code_value = 1;
	} else if ($promotion_code == "ISCP-89359") {
		$promotion_code_value = 2;
	} else if ($promotion_code == "ISCP-83523") {
		$promotion_code_value = 4;
	} else {
		//없는 코드
		$res = [
			code => 401,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	}

	$res = [
		code => 200,
		msg => "success",
		promotion_code => $promotion_code,
		promotion_code_value => $promotion_code_value
	];
	echo json_encode($res);
	exit;
} else if ($_POST["flag"] == "promotion_code_complate") {

	$recommended_by = isset($_POST["recommended_by"]) ? $_POST["recommended_by"] : "";
	$hidden_code = isset($_POST["hidden_code"]) ? $_POST["hidden_code"] : "";

	$registration_idx = isset($_POST["registration_idx"]) ? $_POST["registration_idx"] : "";

	$recommended_by_trim = isset($_POST["recommended_by_trim"]) ? $_POST["recommended_by_trim"] : "";

	if ($hidden_code == 0 && $hidden_code != "") {
		//100% 할인 제한없음
		//$promotion_code_value = 0;
	} else if ($hidden_code == 1) {
		//50% 할인 10명 제한

		$count_sql = "SELECT
							COUNT(idx) AS cnt
						FROM request_registration
						WHERE promotion_code = 1
						AND is_deleted = 'N'
						AND `status` <> 4
						AND recommended_by_trim = '{$recommended_by_trim}'
						";

		$cnt = sql_fetch($count_sql)["cnt"];

		if ($cnt >= 10) {
			$res = [
				code => 402,
				msg => "count over"
			];
			echo json_encode($res);
			exit;
		}
	} else if ($hidden_code == 2) {
		//50% 할인 3명 제한

		$count_sql = "SELECT
							COUNT(idx) AS cnt
						FROM request_registration
						WHERE promotion_code = 2
						AND is_deleted = 'N'
						AND `status` <> 4
						AND recommended_by_trim = '{$recommended_by_trim}'
						";

		$cnt = sql_fetch($count_sql)["cnt"];

		if ($cnt >= 3) {
			$res = [
				code => 402,
				msg => "count over"
			];
			echo json_encode($res);
			exit;
		}
	} else if ($hidden_code == 4) {
		//50% 할인 제한없음
		//$promotion_code_value = 0;
	} else {
		//없는 코드
		$res = [
			code => 401,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	}

	$update_registration_query =	"
											UPDATE request_registration
											SET
												promotion_code			= '{$hidden_code}',
												recommended_by			= '{$recommended_by}',
												recommended_by_trim		= '{$recommended_by_trim}'
											WHERE idx = {$registration_idx}
										";

	$update = sql_query($update_registration_query);

	if ($update) {
		$res = [
			code => 200,
			msg => "success"
		];
		echo json_encode($res);
		exit;
	} else {
		$res = [
			code => 400,
			msg => "update query error"
		];
		echo json_encode($res);
		exit;
	}
}
?>