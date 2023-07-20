<?php include_once("../../common/common.php"); ?>
<?php include_once("../../common/locale.php"); ?>
<?php

$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
$locale = locale($language);
if ($_POST["flag"] == "id_check") {
	$email = isset($_POST["email"]) ? $_POST["email"] : "";

	if ($email == "") {
		echo json_encode(array(
			code => 401,
			msg => "no email"
		));
		exit;
	}

	$select_id_query =	"
								SELECT
									COUNT(*) AS check_cnt
								FROM member
								WHERE email = '{$email}'
								AND is_deleted = 'N'
							";

	$is_checked = sql_fetch($select_id_query)["check_cnt"];

	if ($is_checked == 0) {
		echo json_encode(array(
			code => 200,
			msg => "success"
		));
		exit;
	} else {
		echo json_encode(array(
			code => 400,
			msg => "email already used"
		));
		exit;
	}
}

//[2022.03.24] LDH 작성 새로운 회원 가입 내 정보 수정 일단 사용자만
else if ($_POST["flag"] == "signup_join") {

	//회원가입 후 정보 보여주기
	$_SESSION["signup_join"] = $_POST;

	$idx = $_POST["idx"] ?? null;
	$type = $_POST["type"] ?? null;

	$ksola_member_status = $_POST["ksola_member_status"] ?? null;

	$category = $_POST["category"] ?? null;
	//2022-05-09 추가
	$category_input = $_POST["category_input"] ?? null;

	if (!empty($category_input)) {
		$category = $category_input;
	}

	$title = $_POST["title"] ?? null;
	$title_input = $_POST["title_input"] ?? null;

	if (!empty($title_input)) {
		$title = $title_input;
	}

	$degree = $_POST["degree"] ?? null;
	$degree_input = $_POST["degree_input"] ?? null;

	if (!empty($degree_input)) {
		$degree = $degree_input;
	}

	$telephone = "";
	if (!empty($telephone1)) {
		$tel_nation_tel = $_POST["tel_nation_tel"] ?? null;
		$telephone1 = $_POST["telephone1"] ?? null;
		$telephone2 = $_POST["telephone2"] ?? null;
		$telephone = telphoneNumberTransform($tel_nation_tel, $telephone1, $telephone2);
	}

	$date_of_birth = $_POST["date_of_birth"] ?? null;
	$food = $_POST["food"] ?? null;
	$email = $_POST["email"] ?? null;
	$password = $_POST["password"] ?? null;

	if (!empty($password)) {
		$password = password_hash($password, PASSWORD_DEFAULT);
	}

	$nation_no = $_POST["nation_no"] ?? null;
	$first_name = $_POST["first_name"] ?? null;
	$last_name = $_POST["last_name"] ?? null;
	$nation_tel = $_POST["nation_tel"] ?? null;
	$phone = $_POST["phone"] ?? null;
	$affiliation = $_POST["affiliation"] ?? null;
	$department = $_POST["department"] ?? null;
	$terms1 = $_POST["terms1"] ?? null;
	$terms2 = $_POST["terms2"] ?? null;
	$ksola_member_check = $_POST["ksola_member_check"] ?? null;

	$terms_value = "";

	if ($terms1 == true) {
		$terms_value .= ", terms_access = 'Y' ";
		$terms_value .= ", terms_access_date = NOW() ";
	}
	if ($terms2 == true) {
		$terms_value .= ", privacy_access = 'Y' ";
		$terms_value .= ", privacy_access_date = NOW() ";
	}

	//한국 선택시
	$name_kor = $_POST["name_kor"] ?? null;
	$affiliation_kor = $_POST["affiliation_kor"] ?? null;
	$licence_number = $_POST["licence_number"] ?? null;
	$specialty_number = $_POST["specialty_number"] ?? null;
	$nutritionist_number = $_POST["nutritionist_number"] ?? null;
	$short_input = $_POST["short_input"] ?? null;

	$kor = "";
	$number_kor = "";

	if (!empty($name_kor)) {
		$kor .= "name_kor = '{$name_kor}',";
	} else {
		$kor .= "name_kor = '',";
	}
	if (!empty($affiliation_kor)) {
		$kor .= "affiliation_kor = '{$affiliation_kor}',";
	} else {
		$kor .= "affiliation_kor = '',";
	}
	if (!empty($licence_number)) {
		$number_kor .= "licence_number = '{$licence_number}',";
	} else {
		$licence_number2 = $_POST["licence_number2"] ?? "";
		$number_kor .= "licence_number = '{$licence_number2}',";
	}
	if (!empty($specialty_number)) {
		$number_kor .= "specialty_number = '{$specialty_number}',";
	} else {
		$specialty_number2 = $_POST["specialty_number2"] ?? "";
		$number_kor .= "specialty_number = '{$specialty_number2}',";
	}
	if (!empty($nutritionist_number)) {
		$number_kor .= "nutritionist_number = '{$nutritionist_number}',";
	} else {
		$nutritionist_number2 = $_POST["nutritionist_number2"] ?? "";
		$number_kor .= "nutritionist_number = '{$nutritionist_number2}',";
	}

	//$update_kor = "";
	//update 시 한국 아니면 한국 관련 값들 초기화
	if ($nation_no != 25) {
		$kor = "";
		$number_kor = "";
		$kor .= "name_kor = '',";
		$kor .= "affiliation_kor = '',";
		$kor .= "licence_number = '',";
		$kor .= "specialty_number = '',";
		$kor .= "nutritionist_number = '',";
	}

	if ($food == "Others") {
		$food = $short_input;
	}
	$phone = phoneNumberTransform($nation_tel, $phone);

	try {

		if (!empty($ksola_member_status)) {
			$ksola_member_status_value = "ksola_member_status = '{$ksola_member_status}',";
		}
		if (!empty($password)) {
			$password = "password = '{$password}',";
		}

		if (!empty($date_of_birth)) {
			$date_of_birth = "date_of_birth = '{$date_of_birth}', ";
		}

		if (!empty($ksola_member_check)) {
			$ksola_member_check_value = "ksola_member_check = '{$ksola_member_check}',";
		}
		if (!empty($telephone)) {
			$telephone = "telephone = '{$telephone}', ";
		}

		$insert_member_query =	"{$type}
										member
									SET
										{$date_of_birth}
										{$kor}
										{$number_kor}
										{$password}
										{$ksola_member_status_value}
										{$ksola_member_check_value}
										{$telephone}
										email = '{$email}',
										nation_no = {$nation_no},
										last_name = '{$last_name}',
										first_name = '{$first_name}',
										phone = '{$phone}',
										department = '{$department}',
										affiliation = '{$affiliation}',
										category = '{$category}',
										title	=	'{$title}',
										degree	=	'{$degree}',
										request_food = '{$food}'
										{$terms_value}
										";

		if ($type == "UPDATE") {
			$insert_member_query .= "WHERE idx = {$idx}";
		}

		$insert = sql_query($insert_member_query);

		if (!$insert) {
			$res = [
				code => 400,
				msg => "sign_up error"
			];
			echo json_encode($res);
			exit;
		}

		$select_user_query =	"
                                    SELECT
                                        *
                                    FROM member
                                    WHERE email = '{$email}'
                                    AND is_deleted = 'N'
                                ";

		$user_data = sql_fetch($select_user_query);

		//회원가입 메일러 기능 삭제로 인한 주석처리
		//$subject = $locale("mail_sign_up_subject");
		//$callback_url = "http://15.164.50.26//main/signup_certified.php?idx=" . $user_data["idx"];
		//$mail_result = mailer($language, "sign_up", "", $email, "[ISCP]" . $subject, date("Y-m-d H:i:s"), "", $callback_url, 1);

		//if (!$mail_result) {
		//	$res = [
		//		code => 401,
		//		msg => "send mail fail"
		//	];
		//	echo json_encode($res);
		//	exit;
		//}
	} catch (\Throwable $tw) {
		return_value("저장하는 중 오류가 발생했습니다.", ['error' => $tw->getMessage()]);
	}
	return_value(200, 'ok');
} else if ($_POST["flag"] == "signup") {
	$register_type = isset($_POST["register_tpe"]) ? "admin" : "user"; //관리자 회원가입용

	$data = isset($_POST["data"]) ? $_POST["data"] : "";

	$degree = isset($data["degree"]) ? $data["degree"] : "";
	$degree_input = isset($data["degree_input"]) ? $data["degree_input"] : "";
	$title = isset($data["title"]) ? $data["title"] : "";
	$title_input = isset($data["title_input"]) ? $data["title_input"] : "";
	$category = isset($data["category"]) ? $data["category"] : "";
	$category_input = isset($data["category_input"]) ? $data["category_input"] : "";

	if ($title == "Others") {
		$title = $title_input;
	}
	if ($degree == "Others") {
		$degree = $degree_input;
	}
	if ($category == "Others") {
		$category = $category_input;
	}

	$email = isset($data["email"]) ? $data["email"] : "";
	$password = isset($data["password"]) ? $data["password"] : "";
	$password = password_hash($password, PASSWORD_DEFAULT);
	$nation_no = isset($data["nation_no"]) ? $data["nation_no"] : "";
	$first_name = isset($data["first_name"]) ? $data["first_name"] : "";
	$last_name = isset($data["last_name"]) ? $data["last_name"] : "";
	$nation_tel = isset($data["nation_tel"]) ? $data["nation_tel"] : "";
	$phone = isset($data["phone"]) ? $data["phone"] : "";
	$affiliation = isset($data["affiliation"]) ? $data["affiliation"] : "";
	$department = isset($data["department"]) ? $data["department"] : "";

	$licence_number = isset($data["licence_number"]) ? $data["licence_number"] : "";
	$licence_number2 = isset($data["licence_number2"]) ? $data["licence_number2"] : "";
	$licence_number_bool = isset($data["licence_number_bool"]) ? $data["licence_number_bool"] : "";

	$specialty_number = isset($data["specialty_number"]) ? $data["specialty_number"] : "";
	$specialty_number2 = isset($data["specialty_number2"]) ? $data["specialty_number2"] : "";
	$specialty_number_bool = isset($data["specialty_number_bool"]) ? $data["specialty_number_bool"] : "";

	$nutritionist_number = isset($data["nutritionist_number"]) ? $data["nutritionist_number"] : "";
	$nutritionist_number2 = isset($data["nutritionist_number2"]) ? $data["nutritionist_number2"] : "";
	$nutritionist_number_bool = isset($data["nutritionist_number_bool"]) ? $data["nutritionist_number_bool"] : "";

	$date_of_birth = isset($data["date_of_birth"]) ? $data["date_of_birth"] : "";
	$request_food = isset($data["food"]) ? $data["food"] : "";
	$short_input = isset($data["short_input"]) ? $data["short_input"] : "";

	$name_kor = isset($data["name_kor"]) ? $data["name_kor"] : "";
	$affiliation_kor = isset($data["affiliation_kor"]) ? $data["affiliation_kor"] : "";

	if ($request_food == "Others") {
		$request_food = $short_input;
	}

	$terms1 = isset($data["terms1"]) ? $data["terms1"] : "";
	$terms2 = isset($data["terms2"]) ? $data["terms2"] : "";

	if ($register_type == "admin") {
		//$arr_phone = explode($phone, "-");
		//$nation_tel = $arr_phone[0];
		//$phone = implode("-", array_splice($arr_phone,1));
	}

	//$phone = phoneNumberTransform($nation_tel, $phone);
	$telephone = isset($data["telephone"]) ? $data["telephone"] : "";

	$insert_member_query =	"
									INSERT member
									SET
										email = '{$email}',
										password = '{$password}',
										nation_no = {$nation_no},
										last_name = '{$last_name}',
										first_name = '{$first_name}',
										phone = '{$phone}' 
								";

	if ($affiliation != "") {
		$insert_member_query .= ", affiliation = '{$affiliation}' ";
	}
	if ($department != "") {
		$insert_member_query .= ", department = '{$department}' ";
	}

	if ($licence_number != "") {
		$insert_member_query .= ", licence_number = '{$licence_number}' ";
	} else {
		if ($licence_number_bool == true) {
			$insert_member_query .= ", licence_number = '{$licence_number2}' ";
		} else {
			$insert_member_query .= ", licence_number = NULL ";
		}
	}
	if ($specialty_number != "") {
		$insert_member_query .= ", specialty_number = '{$specialty_number}' ";
	} else {
		if ($specialty_number_bool == true) {
			$insert_member_query .= ", specialty_number = '{$specialty_number2}' ";
		} else {
			$insert_member_query .= ", specialty_number = NULL ";
		}
	}
	if ($nutritionist_number != "") {
		$insert_member_query .= ", nutritionist_number = '{$nutritionist_number}' ";
	} else {
		if ($nutritionist_number_bool == true) {
			$insert_member_query .= ", nutritionist_number = '{$nutritionist_number2}' ";
		} else {
			$insert_member_query .= ", nutritionist_number = NULL ";
		}
	}

	if ($terms1 != "") {
		$insert_member_query .= ", terms_access = '{$terms1}' ";
		$insert_member_query .= ", terms_access_date = NOW() ";
	}
	if ($terms2 != "") {
		$insert_member_query .= ", privacy_access = '{$terms2}' ";
		$insert_member_query .= ", privacy_access_date = NOW() ";
	}

	if ($title != "") {
		$insert_member_query .= ", title = '{$title}' ";
	} else {
		$insert_member_query .= ", title = NULL ";
	}

	if ($degree != "") {
		$insert_member_query .= ", degree = '{$degree}' ";
	} else {
		$insert_member_query .= ", degree = NULL ";
	}

	if ($category != "") {
		$insert_member_query .= ", category = '{$category}' ";
	} else {
		$insert_member_query .= ", category = NULL ";
	}

	if ($telephone != "") {
		//$telephone= phoneNumberTransform($nation_tel, $telephone);
		$insert_member_query .= ", telephone = '{$telephone}' ";
	} else {
		$insert_member_query .= ", telephone = NULL ";
	}

	if ($date_of_birth != "") {
		$insert_member_query .= ", date_of_birth = '{$date_of_birth}' ";
	} else {
		$insert_member_query .= ", date_of_birth = NULL ";
	}
	if ($request_food != "") {
		$insert_member_query .= ", request_food = '{$short_input}' ";
	} else {
		$insert_member_query .= ", request_food = NULL ";
	}

	if ($name_kor != "") {
		$insert_member_query .= ", name_kor = '{$name_kor}' ";
	} else {
		$insert_member_query .= ", name_kor = NULL ";
	}
	if ($affiliation_kor != "") {
		$insert_member_query .= ", affiliation_kor = '{$affiliation_kor}' ";
	} else {
		$insert_member_query .= ", name_kor = NULL ";
	}


	if ($register_type == "admin") {
		$insert_member_query .= ", email_certified = 'Y' ";
		$insert_member_query .= ", register_type = 1 ";
	}

	$insert = sql_query($insert_member_query);

	if (!$insert) {
		$res = [
			code => 400,
			msg => "sign_up error"
		];
		echo json_encode($res);
		exit;
	}

	if ($register_type != "admin") {

		$select_user_query =	"
                                    SELECT
                                        *
                                    FROM member
                                    WHERE email = '{$email}'
                                    AND is_deleted = 'N'
                                ";

		$user_data = sql_fetch($select_user_query);

		$subject = $locale("mail_sign_up_subject");
		$callback_url = "https://iscp2023.org/main/signup_certified.php?idx=" . $user_data["idx"];
		$mail_result = mailer($language, "sign_up", "", $email, "[ISCP]" . $subject, date("Y-m-d H:i:s"), "", $callback_url, 1);

		if (!$mail_result) {
			$res = [
				code => 401,
				msg => "send mail fail"
			];
			echo json_encode($res);
			exit;
		}
	}
	$res = [
		code => 200,
		msg => "success"
	];
	echo json_encode($res);
	exit;
} else if ($_POST["flag"] == "update") {
	$data = isset($_POST["data"]) ? $_POST["data"] : "";

	$degree = isset($data["degree"]) ? $data["degree"] : "";
	$degree_input = isset($data["degree_input"]) ? $data["degree_input"] : "";
	$title = isset($data["title"]) ? $data["title"] : "";
	$title_input = isset($data["title_input"]) ? $data["title_input"] : "";
	$category = isset($data["category"]) ? $data["category"] : "";
	$category_input = isset($data["category_input"]) ? $data["category_input"] : "";

	if ($title == "Others") {
		$title = $title_input;
	}
	if ($degree == "Others") {
		$degree = $degree_input;
	}
	if ($category == "Others") {
		$category = $category_input;
	}

	$email = isset($data["email"]) ? $data["email"] : "";
	$password = isset($data["password"]) ? $data["password"] : "";
	$password = password_hash($password, PASSWORD_DEFAULT);
	$nation_no = isset($data["nation_no"]) ? $data["nation_no"] : "";
	$first_name = isset($data["first_name"]) ? $data["first_name"] : "";
	$last_name = isset($data["last_name"]) ? $data["last_name"] : "";
	$nation_tel = isset($data["nation_tel"]) ? $data["nation_tel"] : "";
	$phone = isset($data["phone"]) ? $data["phone"] : "";
	$affiliation = isset($data["affiliation"]) ? $data["affiliation"] : "";
	$department = isset($data["department"]) ? $data["department"] : "";

	$licence_number = isset($data["licence_number"]) ? $data["licence_number"] : "";
	$licence_number2 = isset($data["licence_number2"]) ? $data["licence_number2"] : "";
	$licence_number_bool = isset($data["licence_number_bool"]) ? $data["licence_number_bool"] : "";

	$specialty_number = isset($data["specialty_number"]) ? $data["specialty_number"] : "";
	$specialty_number2 = isset($data["specialty_number2"]) ? $data["specialty_number2"] : "";
	$specialty_number_bool = isset($data["specialty_number_bool"]) ? $data["specialty_number_bool"] : "";

	$nutritionist_number = isset($data["nutritionist_number"]) ? $data["nutritionist_number"] : "";
	$nutritionist_number2 = isset($data["nutritionist_number2"]) ? $data["nutritionist_number2"] : "";
	$nutritionist_number_bool = isset($data["nutritionist_number_bool"]) ? $data["nutritionist_number_bool"] : "";

	$date_of_birth = isset($data["date_of_birth"]) ? $data["date_of_birth"] : "";
	$request_food = isset($data["food"]) ? $data["food"] : "";
	$short_input = isset($data["short_input"]) ? $data["short_input"] : "";

	$name_kor = isset($data["name_kor"]) ? $data["name_kor"] : "";
	$affiliation_kor = isset($data["affiliation_kor"]) ? $data["affiliation_kor"] : "";

	if ($request_food == "Others") {
		$request_food = $short_input;
	}

	$telephone = isset($data["telephone"]) ? $data["telephone"] : "";

	//$phone = phoneNumberTransform($nation_tel, $phone);

	$update_member_query =	"
									UPDATE member
									SET
										password = '{$password}',
										nation_no = {$nation_no},
										last_name = '{$last_name}',
										first_name = '{$first_name}',
										phone = '{$phone}'
								";

	if ($affiliation != "") {
		$update_member_query .= ", affiliation = '{$affiliation}' ";
	} else {
		$update_member_query .= ", affiliation = NULL ";
	}

	if ($department != "") {
		$update_member_query .= ", department = '{$department}' ";
	} else {
		$update_member_query .= ", department = NULL ";
	}

	if ($licence_number != "") {
		$update_member_query .= ", licence_number = '{$licence_number}' ";
	} else {
		if ($licence_number_bool == true) {
			$update_member_query .= ", licence_number = '{$licence_number2}' ";
		} else {
			$update_member_query .= ", licence_number = NULL ";
		}
	}
	if ($specialty_number != "") {
		$update_member_query .= ", specialty_number = '{$specialty_number}' ";
	} else {
		if ($specialty_number_bool == true) {
			$update_member_query .= ", specialty_number = '{$specialty_number2}' ";
		} else {
			$update_member_query .= ", specialty_number = NULL ";
		}
	}
	if ($nutritionist_number != "") {
		$update_member_query .= ", nutritionist_number = '{$nutritionist_number}' ";
	} else {
		if ($nutritionist_number_bool == true) {
			$update_member_query .= ", nutritionist_number = '{$nutritionist_number2}' ";
		} else {
			$update_member_query .= ", nutritionist_number = NULL ";
		}
	}

	if ($title != "") {
		$update_member_query .= ", title = '{$title}' ";
	} else {
		$update_member_query .= ", title = NULL ";
	}

	if ($degree != "") {
		$update_member_query .= ", degree = '{$degree}' ";
	} else {
		$update_member_query .= ", degree = NULL ";
	}

	if ($category != "") {
		$update_member_query .= ", category = '{$category}' ";
	} else {
		$update_member_query .= ", category = NULL ";
	}

	if ($telephone != "") {
		//$telephone= phoneNumberTransform($nation_tel, $telephone);
		$update_member_query .= ", telephone = '{$telephone}' ";
	} else {
		$update_member_query .= ", telephone = NULL ";
	}

	if ($date_of_birth != "") {
		$update_member_query .= ", date_of_birth = '{$date_of_birth}' ";
	} else {
		$update_member_query .= ", date_of_birth = NULL ";
	}
	if ($request_food != "") {
		$update_member_query .= ", request_food = '{$request_food}' ";
	} else {
		$update_member_query .= ", request_food = NULL ";
	}

	if ($name_kor != "") {
		$update_member_query .= ", name_kor = '{$name_kor}' ";
	} else {
		$update_member_query .= ", name_kor = NULL ";
	}
	if ($affiliation_kor != "") {
		$update_member_query .= ", affiliation_kor = '{$affiliation_kor}' ";
	} else {
		$update_member_query .= ", name_kor = NULL ";
	}


	$update_member_query .= "	WHERE email = '{$email}' AND is_deleted = 'N' ";

	$update_member = sql_query($update_member_query);

	if ($update_member) {
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
} else if ($_POST["flag"] == "login") {
	$email = isset($_POST["email"]) ? $_POST["email"] : "";
	$password = isset($_POST["password"]) ? $_POST["password"] : "";
	$hash_password = password_hash($password, PASSWORD_DEFAULT);

	$login_query =	"
							SELECT
								idx, email, password, nation_no, last_name, first_name, phone, affiliation, department, licence_number, email_certified, register_type, 
								DATE(last_login) AS last_login_date
							FROM member
							WHERE email = '{$email}'
							AND is_deleted = 'N'
						";
	$member = sql_fetch($login_query);

	if ($member["idx"] == "") {
		echo json_encode(array(
			"code" => 400,
			"msg" => "입력하신 아이디/이메일을 확인해주세요."
		));
		exit;
	}

	if (password_verify($password, $member["password"]) == false) {
		echo json_encode(array(
			"code" => 401,
			"msg" => "입력하신 비밀번호를 확인해주세요"
		));
		exit;
	}

	//메일 인증을 안 하게 됐음으로 주석처리
	//if($member["email_certified"] == "N" && $member["register_type"] == 0) {
	//	$res = [
	//		code => 402,
	//		"msg" => "이메일 인증이 완료되지 않은 계정입니다."
	//	];
	//	echo json_encode($res);
	//	exit;
	//}

	// 오늘 처음 로그인인 경우 출석체크 처리함
	if ($member['last_login_date'] != date('Y-m-d')) {
		$insert_daily_check_query =	"INSERT INTO 
											event_daily_check
											(member_idx)
										VALUES
											('" . $member["idx"] . "')";
		sql_query($insert_daily_check_query);
	}

	$update_login_date_query =	"
										UPDATE member
										SET
											last_login = NOW()
										WHERE email = '{$email}'
										AND is_deleted = 'N'
									";
	$update_login_date = sql_query($update_login_date_query);

	$_SESSION["USER"] = [
		"idx" => $member["idx"],
		"email" => $member["email"],
		"first_name" => $member["first_name"],
		"last_name" => $member["last_name"],
		"phone" => $member["phone"],
		"nation_no" => $member["nation_no"],
		"affiliation" => $member["affiliation"],
		"department" => $member["department"],
		"licence_number" => $member["licence_number"]
	];

	echo json_encode(array(
		code => 200,
		msg => "로그인 성공",
		idx => $member["idx"]
	));
} else if ($_GET["flag"] == "logout") {
	$_SESSION["USER"] = [];
	$_SESSION["abstract"] = [];
	$_SESSION["lecture"] = [];
	$_SESSION["signup_join"] = [];

	echo json_encode(array(
		code => 200,
		msg => "로그아웃 성공"
	));
} else if ($_POST["flag"] == "find_password") {
	$email = isset($_POST["email"]) ? $_POST["email"] : "";

	$check_user_query =	"
										SELECT
											idx, email, first_name, last_name, nation_no
										FROM member
										WHERE email = '{$email}'
										AND is_deleted = 'N'
									";

	$check_user = sql_fetch($check_user_query);

	if (!$check_user) {
		$res = [
			code => 401,
			msg => "does not exist email"
		];
		echo json_encode($res);
		exit;
	}

	$temporary_password = "";
	$random_token = generator_token();		// 비밀번호 찾기시 사용되는 토큰

	for ($i = 0; $i < 6; $i++) {
		$temporary_password .= mt_rand(1, 9);
	}

	//$name = $check_user['nation_no'] == 25 ? $check_user["first_name"].$check_user["last_name"] : $check_user["last_name"]." ".$check_user["first_name"];

	$name = $check_user["last_name"] . " " . $check_user["first_name"];

	$subject = $locale("mail_find_password_subject");
	//$callback_url = "http://54.180.86.106/main/password_reset.php?e=".$email."&t=".$random_token;
	$callback_url = "https://iscp2023.org/main/password_reset.php?e=" . $email . "&t=" . $random_token;
	$mail_result = mailer($language, "find_password", $name, $email, "[ISCP]" . $subject, date("Y-m-d H:i:s"), $temporary_password, $callback_url, 0);


	if (!$mail_result) {
		$res = [
			code => 402,
			msg => "mail send fail."
		];
		echo json_encode($res);
		exit;
	}


	$hash_temporary_password = password_hash($temporary_password, PASSWORD_DEFAULT);

	$update_temporary_password_query =	"
												UPDATE member
												SET
													temporary_password = '{$hash_temporary_password}',
													temporary_password_token = '{$random_token}'
												WHERE email = '{$email}'
												AND is_deleted = 'N'
											";

	$update_temporary_password = sql_query($update_temporary_password_query);


	if ($update_temporary_password) {
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
} else if ($_POST["flag"] == "delete") {
	$member_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";

	if ($member_idx == "") {
		$res = [
			code => 400,
			msg => "error"
		];
		echo json_encode($res);
		exit;
	}

	$delete_member_query =  "
                                    UPDATE member
                                    SET
                                        is_deleted = 'Y'
                                    WHERE idx = {$member_idx};
                                ";

	$delete_member = sql_query($delete_member_query);

	if ($delete_member) {
		$res = [
			code => 200,
			msg => "delete success"
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
} else if ($_POST["flag"] == "delete_registration") {
	$member_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";

	if ($member_idx == "") {
		$res = [
			code => 400,
			msg => "error"
		];
		echo json_encode($res);
		exit;
	}

	$delete_member_query =  "
                                    UPDATE request_registration
                                    SET
                                        is_deleted = 'Y'
                                    WHERE register = {$member_idx};
                                ";

	$delete_member = sql_query($delete_member_query);

	if ($delete_member) {
		$res = [
			code => 200,
			msg => "delete success"
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
} else if ($_POST["flag"] == "auto_login") {
	$member_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";

	$res = [
		code => 200,
		msg => "success"
	];
	echo json_encode($res);
	exit;
}


function generator_token()
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < 10; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

//전화번호 변환
function telphoneNumberTransform($nation_tel, $phone, $phone2)
{
	if ($nation_tel != "" && $phone != "" && $phone2 != "") {
		if (strpos($phone, "0") == 0) {			//연락처에 맨 앞자리가 0으로 시작할 경우 국가전화번호와 합치기 위해 앞부분 0 삭제 ex)010-1234-1234 => 10-1234-1234
			$phone = substr($phone, 1);
		}
		$phone = $nation_tel . "-" . $phone . "-" . $phone2;
	}
	return $phone;
}
?>