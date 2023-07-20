<?php
include_once("../../common/common.php");

$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
$locale = locale($language);

if ($_POST["flag"] == "submission_step1") {
    // 유저IDX
    $user_idx = $_SESSION["USER"]["idx"];

    // 등록 타입(abstract:논문, lecture:강연노트)
    $type = isset($_POST["type"]) ? $_POST["type"] : "";

    $submission_type = $type == "abstract" ? "0" : "1";

    // 제출 정보
    $data = isset($_POST["data"]) ? $_POST["data"] : "";

    // 주저자 정보
    $main_data = isset($data["main_data"]) ? $data["main_data"] : "";

    // 공동저자1 정보
    $co_data1 = isset($data["co_data1"]) ? $data["co_data1"] : "";

    //공동저자 수
    $co_count = isset($data["co_count"]) ? $data["co_count"] : "";

    for ($i = 0; $i < $co_count; $i++) {
        $coauthor_data[$i] = isset($data["coauthor_data" . $i]) ? $data["coauthor_data" . $i] : "";
    }

    // STEP2에서 최종 입력 후 INSERT를 위해 SESSION에 임시 저장
    if ($type == "abstract") {
        $_SESSION["abstract"] = "";
        $_SESSION["abstract"] = [
            "data" => $main_data,
            "co_data1" => $co_data1
        ];
        //co_author데이터 for문(INTO-ON)
        for ($i = 0; $i < $co_count; $i++) {
            if ($coauthor_data[$i] != "") {
                $_SESSION["abstract"]["coauthor_data" . $i] = $coauthor_data[$i];
            }
        }
    } else if ($type == "lecture") {
        $_SESSION["lecture"] = "";
        $_SESSION["lecture"] = [
            "data" => $main_data,
            "co_data1" => $co_data1
        ];
        //co_author데이터 for문(INTO-ON)
        for ($i = 0; $i < $co_count; $i++) {
            if ($coauthor_data[$i] != "") {
                $_SESSION["lecture"]["coauthor_data" . $i] = $coauthor_data[$i];
            }
        }
    }

    if ($type == "abstract") {
        if ($_SESSION["abstract"]) {
            echo json_encode(array(
                "code" => 200,
                "msg" => "success"
            ));
            exit;
        } else {
            echo json_encode(array(
                "code" => 400,
                "msg" => "abstract session error"
            ));
            exit;
        }
    } else if ($type == "lecture") {
        if ($_SESSION["lecture"]) {
            echo json_encode(array(
                "code" => 200,
                "msg" => "success"
            ));
            exit;
        } else {
            echo json_encode(array(
                "code" => 400,
                "msg" => "lecture session error"
            ));
            exit;
        }
    }
} else if ($_POST["flag"] == "lecture_step2") {
    //로그인 회원 idx
    $user_idx = $_SESSION["USER"]["idx"];

    //업데이트시 필요한 데이터
    $lecture_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
    $type = isset($_POST["type"]) ? $_POST["type"] : "";

    //제출고유코드 생성
    $submission_code = createSubmissionCode("lecture");

    //SESSION에 저장한 STEP1 데이터
    $data = isset($_SESSION["lecture"]["data"]) ? $_SESSION["lecture"]["data"] : "";
    $co_data1 = isset($_SESSION["lecture"]["co_data1"]) ? $_SESSION["lecture"]["co_data1"] : "";

    //co_author데이터 for문(INTO-ON)
    for ($i = 0; $i < (count($_SESSION["lecture"]) - 2); $i++) {
        $coauthor_data[$i] = isset($_SESSION["lecture"]["coauthor_data" . $i]) ? $_SESSION["lecture"]["coauthor_data" . $i] : "";
    }

    //강연 정보
    //$lecture_presentation_type = isset($_POST["presentation_type"]) ? $_POST["presentation_type"] : "";
    //$lecture_cv = isset($_POST["cv"]) ? $_POST["cv"] : "";


    foreach ($co_data1 as $key => $value) {
        $value = stripslashes($value);
        if ($key == "co_affiliation") {
            $co_data1["co_affiliation"] = htmlspecialchars($value, ENT_QUOTES);
        } else {
            $value = addslashes(htmlspecialchars($value, ENT_QUOTES));
        }
    }
    foreach ($_POST as $key => $value) {
        $value = stripslashes($value);
        $value = addslashes(htmlspecialchars($value, ENT_QUOTES));
    }

    //step1 정보
    //주저자
    $nation_no = isset($data["nation_no"]) ? $data["nation_no"] : "";
    $department = isset($data["department"]) ? $data["department"] : "";
    $first_name = isset($data["first_name"]) ? $data["first_name"] : "";
    $last_name = isset($data["last_name"]) ? $data["last_name"] : "";
    $affiliation = isset($data["affiliation"]) ? $data["affiliation"] : "";
    $email = isset($data["email"]) ? $data["email"] : "";
    $nation_tel = isset($data["nation_tel"]) ? $data["nation_tel"] : "";

    //공동저자1
    $co_nation_no1 = isset($co_data1["co_nation_no"]) ? $co_data1["co_nation_no"] : "";
    $co_first_name1 = isset($co_data1["co_first_name"]) ? $co_data1["co_first_name"] : "";
    $co_last_name1 = isset($co_data1["co_last_name"]) ? $co_data1["co_last_name"] : "";
    $co_affiliation1 = isset($co_data1["co_affiliation"]) ? $co_data1["co_affiliation"] : "";
    $co_email1 = isset($co_data1["co_email"]) ? $co_data1["co_email"] : "";

    $co_department1 = isset($co_data1["co_department"]) ? $co_data1["co_department"] : "";

    $co_idx1 = isset($co_data1["co_idx"]) ? $co_data1["co_idx"] : "";

    $coauthor_affiliation = array();
    $coauthor_first_name = array();
    $coauthor_last_name = array();
    $coauthor_email = array();
    if ($coauthor_data) {
        for ($i = 0; $i < (count($coauthor_data)); $i++) {
            $coauthor_nation_no[$i] = isset($coauthor_data[$i]["co_nation_no"]) ? $coauthor_data[$i]["co_nation_no"] : "";
            $coauthor_first_name[$i] = isset($coauthor_data[$i]["co_first_name"]) ? $coauthor_data[$i]["co_first_name"] : "";
            $coauthor_last_name[$i] = isset($coauthor_data[$i]["co_last_name"]) ? $coauthor_data[$i]["co_last_name"] : "";
            $coauthor_email[$i] = isset($coauthor_data[$i]["co_email"]) ? $coauthor_data[$i]["co_email"] : "";
            $coauthor_affiliation[$i] = isset($coauthor_data[$i]["co_affiliation"]) ? $coauthor_data[$i]["co_affiliation"] : "";
            $coauthor_affiliation[$i] = htmlspecialchars(stripslashes($coauthor_affiliation[$i]), ENT_QUOTES);
            $coauthor_department[$i] = isset($coauthor_data[$i]["co_department"]) ? $coauthor_data[$i]["co_department"] : "";

            $coauthor_idx[$i] = isset($coauthor_data[$i]["co_idx"]) ? $coauthor_data[$i]["co_idx"] : "";
        }
    }

    if ($type == "update") {
        $submission_query = "
                                    UPDATE request_abstract
                                    SET
                                        modifier = {$user_idx},
                                        modify_date = NOW(),
                                ";
    } else {
        $submission_query = "
                                    INSERT request_abstract
                                    SET
                                        `type` = 1,
                                        submission_code = '{$submission_code}',
                                        register = {$user_idx},

                                ";
    }

    $submission_query .=    "
                                    nation_no        =        {$nation_no},
                                    last_name        =        '{$last_name}',
                                    first_name        =        '{$first_name}',
                                    #city            =        '{$city}',
                                    affiliation        =        '{$affiliation}',
									department			=		'{$department}',
                                    email            =        '{$email}'
                                    #phone            =        '{$phone}'
                                    #presentation_type    =    {$presentation_type}
                                ";

    if ($state != "") {
        $submission_query .=    " , state = '{$state}' ";
    }

    /*        
        //error_log(print_r($email, true));
        //error_log(print_r($user_idx, true));

        $file_no = upload_file($_FILES["lecture_file"], 1);
        error_log(print_r($_FILES["lecture_file"], true));
        error_log("file_no: " . print_r($file_no, true));
        if($file_no == "") {
            error_log("4444");
            $res = [
                code => 401,
                msg => "lecture_file upload error"
            ];
            echo json_encode($res);
            exit;
        }

        if($file_no != "") {
            $insert_submission_query .= ", notice_file = '{$file_no}' ";
        }

        //파일 업로드
        $file_no2 = upload_file($_FILES["cv_file"], 1);
        error_log(print_r($_FILES["cv_file"], true));
        error_log("file_no2: " . print_r($file_no2, true));

        if($file_no2 == "") {
            error_log("5555");
            $res = [
                code => 401,
                msg => "cv_file upload error"
            ];
            echo json_encode($res);
            exit;
        }

        if($file_no2 != "") {
            $insert_submission_query .= ", cv_file = '{$file_no2}' ";
        }
*/

    if ($_FILES["lecture_file"]) {
        //파일 업로드
        $file_no = upload_file($_FILES["lecture_file"], 1);

        if ($file_no == "") {
            $res = [
                code => 401,
                msg => "file upload error"
            ];
            echo json_encode($res);
            exit;
        }

        if ($file_no != "") {
            $submission_query .= ", notice_file = '{$file_no}' ";
        }
    }

    if ($_FILES["cv_file"]) {
        //파일 업로드
        $file_no = upload_file($_FILES["cv_file"], 1);

        if ($file_no == "") {
            $res = [
                code => 401,
                msg => "file upload error"
            ];
            echo json_encode($res);
            exit;
        }

        if ($file_no != "") {
            $submission_query .= ", cv_file = '{$file_no}' ";
        }
    }

    if ($type == "update") {
        $submission_query .=    " WHERE idx = {$lecture_idx} ";

        //일단 전부 삭제 시킨 후 수정 되는 것들만 복귀 시킨다.
        $ready_delete_query = "SELECT
										idx
									FROM request_abstract
									WHERE parent_author = {$lecture_idx}";

        $ready_delete_result = sql_fetch($ready_delete_query);

        if (isset($ready_delete_result)) {

            $delete_query = "UPDATE
									request_abstract
								SET
									is_deleted = 'Y'
								WHERE parent_author = {$lecture_idx}";

            sql_query($delete_query);
        }
    }

    $result = sql_query($submission_query);

    if (!$result) {
        $res = [
            code => 400,
            msg => "main query error"
        ];
        echo json_encode($res);
        exit;
    } else {
        if ($co_nation_no1) {

            $select_last_idx_query =    "
												SELECT 
													MAX(idx) AS last_idx
												FROM request_abstract
												WHERE register = {$user_idx}
												ORDER BY register_date DESC
											";

            if (!$lecture_idx) {
                $last_idx = sql_fetch($select_last_idx_query)["last_idx"];
            } else {
                $last_idx = $lecture_idx;
            }

            $select_co_idx_query =  "
											SELECT
												idx
											FROM request_abstract
											WHERE register = {$user_idx}
											AND parent_author = {$last_idx}
											ORDER BY idx
										";

            $co_abstract_idx = get_data($select_co_idx_query);

            if (count($coauthor_data) == 1) {
                //하나만 있을 경우
                $coauthor_count = 2;
            } else {
                $coauthor_count = count($coauthor_data) + 1;
            }

            for ($i = 1; $i < $coauthor_count; $i++) {

                if ($coauthor_idx[$i - 1] != -1) {

                    $co_submission_query =  "
													UPDATE request_abstract
													SET
														modifier            =           {$user_idx},
														modify_date         =           NOW(),
														is_deleted			=			'N',
												";
                } else {
                    $co_submission_query =  "
													INSERT request_abstract
													SET
														`type`          =           1,
														register        =           {$user_idx},
														parent_author   =           {$last_idx},
												";
                }

                if ($i == 1) {
                    $co_submission_query .=    "
													`order`			=			{$i},
													nation_no        =        {$co_nation_no1},
													last_name        =        '{$co_last_name1}',
													first_name        =        '{$co_first_name1}',
													#city            =        '{$co_city1}',
													affiliation        =        '{$co_affiliation1}',
													email            =        '{$co_email1}',
													department			=		'{$co_department1}'
													#phone            =        '{$co_phone1}'
													#position        =       '{$co_position}'
												";

                    if ($co_state1 != "") {
                        $co_submission_query .= " , state = '{$co_state1}' ";
                    }

                    if ($co_position_other != "") {
                        $co_submission_query .= " , position_other = '{$co_position_other}' ";
                    }
                } else {
                    $n = $i - 1;
                    $co_submission_query .= "
													`order`			=			{$i},
													nation_no     =       '" . $coauthor_nation_no[$n] . "',			     
													affiliation     =       '" . $coauthor_affiliation[$n] . "',
													last_name       =       '" . $coauthor_last_name[$n] . "',
													first_name      =       '" . $coauthor_first_name[$n] . "',
													email      =       '" . $coauthor_email[$n] . "',
													department     =       '" . $coauthor_department[$n] . "'
												";
                }

                if ($coauthor_idx[$i - 1] != -1) {
                    //$co_submission_query .= "
                    //							WHERE idx = {$co_abstract_idx[($i-1)]['idx']}
                    //						";
                    $co_submission_query .= "
													WHERE idx = " . $coauthor_idx[$i - 1];
                }


                $co_result = sql_query($co_submission_query);

                if (!$co_result) {
                    echo json_encode(array(
                        "code" => 400,
                        "msg" => "co" . $i . " query error"
                    ));
                    exit;
                }
            }
        }
    }


    //세션 초기화
    $_SESSION["lecture"] = "";

    $res = [
        code => 200,
        msg => "success"
    ];
    echo json_encode($res);
    exit;
} else if ($_POST["flag"] == "abstract_step2") {
    //로그인 회원 idx
    $user_idx = $_SESSION["USER"]["idx"];

    //업데이트시 필요한 데이터
    $abstract_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
    $type = isset($_POST["type"]) ? $_POST["type"] : "";

    //제출고유코드 생성
    $submission_code = createSubmissionCode("abstract");

    //SESSION에 저장한 STEP1 데이터
    $data = isset($_SESSION["abstract"]["data"]) ? $_SESSION["abstract"]["data"] : "";
    $co_data1 = isset($_SESSION["abstract"]["co_data1"]) ? $_SESSION["abstract"]["co_data1"] : "";

    //co_author데이터 for문(INTO-ON)
    for ($i = 0; $i < (count($_SESSION["abstract"]) - 2); $i++) {
        $coauthor_data[$i] = isset($_SESSION["abstract"]["coauthor_data" . $i]) ? $_SESSION["abstract"]["coauthor_data" . $i] : "";
    }

    //foreach($data as $key=>$value){
    //    $value = stripslashes($value);
    //    if ($key !== "affiliation") {
    //        $data["affiliation"] = htmlspecialchars($value, ENT_QUOTES);
    //    } else {
    //        $value = addslashes(htmlspecialchars($value, ENT_QUOTES));
    //    }
    //}
    foreach ($co_data1 as $key => $value) {
        $value = stripslashes($value);
        if ($key == "co_affiliation") {
            $co_data1["co_affiliation"] = htmlspecialchars($value, ENT_QUOTES);
        } else {
            $value = addslashes(htmlspecialchars($value, ENT_QUOTES));
        }
    }
    foreach ($_POST as $key => $value) {
        $value = stripslashes($value);
        $value = addslashes(htmlspecialchars($value, ENT_QUOTES));
    }


    //step2 정보
    //논문 정보	
    $objectives = $_POST["objectives"] ?? null;
    $method = $_POST["method"] ?? null;
    $results = $_POST["results"] ?? null;
    $conclusions = $_POST["conclusions"] ?? null;
    $keywords = $_POST["keywords"] ?? null;

    $objectives = addslashes(htmlspecialchars($objectives));
    $method = addslashes(htmlspecialchars($method));
    $results = addslashes(htmlspecialchars($results));
    $conclusions = addslashes(htmlspecialchars($conclusions));
    $keywords = addslashes(htmlspecialchars($keywords));

    $funding_yn = $_POST["funding_yn"] ?? null;
    $award_yn = $_POST["award_yn"] ?? null;
    $investigator_awards_yn = $_POST["investigator_awards_yn"] ?? null;
    $ask_grants_yn = $_POST["ask_grants_yn"] ?? null;

    $presentation_type = $_POST["presentation_type"] ?? null;
    $abstract_category = $_POST["abstract_category"] ?? null;

    $abstract_file_title = isset($_POST["abstract_file_title"]) ? $_POST["abstract_file_title"] : "";
    //$oral_presentation = isset($_POST["oral_presentation"]) ? $_POST["oral_presentation"] : "";

    //step1 정보
    //주저자
    $abstract_title = isset($data["abstract_title"]) ? $data["abstract_title"] : "";
    $nation_no = isset($data["nation_no"]) ? $data["nation_no"] : "";
    $department = isset($data["department"]) ? $data["department"] : "";
    //$city = isset($data["city"]) ? $data["city"] : "";
    //$state = isset($data["state"]) ? $data["state"] : "";
    $first_name = isset($data["first_name"]) ? $data["first_name"] : "";
    $last_name = isset($data["last_name"]) ? $data["last_name"] : "";
    $affiliation = isset($data["affiliation"]) ? $data["affiliation"] : "";
    $email = isset($data["email"]) ? $data["email"] : "";
    //$position = isset($data["position"]) ? $data["position"] : "";
    //if($position == "4") {
    //    $position_other = isset($data["other_position"]) ? $data["other_position"] : "";
    //}
    $nation_tel = isset($data["nation_tel"]) ? $data["nation_tel"] : "";
    //$phone = isset($data["phone"]) ? $data["phone"] : "";

    //$phone = phoneNumberTransform($nation_tel, $phone);
    //$affiliation = affiliationJson($affiliation);

    //공동저자1
    $co_nation_no1 = isset($co_data1["co_nation_no"]) ? $co_data1["co_nation_no"] : "";
    //$co_city1 = isset($data["co_city"]) ? $data["co_city"] : "";
    //$co_state1 = isset($data["co_state"]) ? $data["co_state"] : "";
    $co_first_name1 = isset($co_data1["co_first_name"]) ? $co_data1["co_first_name"] : "";
    $co_last_name1 = isset($co_data1["co_last_name"]) ? $co_data1["co_last_name"] : "";
    $co_affiliation1 = isset($co_data1["co_affiliation"]) ? $co_data1["co_affiliation"] : "";
    $co_email1 = isset($co_data1["co_email"]) ? $co_data1["co_email"] : "";

    $co_department1 = isset($co_data1["co_department"]) ? $co_data1["co_department"] : "";

    $co_idx1 = isset($co_data1["co_idx"]) ? $co_data1["co_idx"] : "";

    //$co_position = isset($data["co_position"]) ? $data["co_position"] : "";
    //if($co_position == "4") {
    //    $co_position_other = isset($data["co_other_position"]) ? $data["co_other_position"] : "";
    //}

    // $co_nation_tel1 = isset($co_data1["co_nation_tel1"]) ? $co_data1["co_nation_tel1"] : "";
    // $co_phone1 = isset($co_data1["co_phone"]) ? $co_data1["co_phone"] : "";

    //  $co_phone1 = phoneNumberTransform($co_nation_tel1, $co_phone1);
    //$co_affiliation1 = affiliationJson($co_affiliation1);

    $coauthor_affiliation = array();
    $coauthor_first_name = array();
    $coauthor_last_name = array();
    $coauthor_email = array();
    //$coauthor_affiliation = array();

    //co_author데이터 for문(INTO-ON)
    if ($coauthor_data) {
        for ($i = 0; $i < (count($coauthor_data)); $i++) {
            //coauthor
            $coauthor_nation_no[$i] = isset($coauthor_data[$i]["co_nation_no"]) ? $coauthor_data[$i]["co_nation_no"] : "";
            $coauthor_first_name[$i] = isset($coauthor_data[$i]["co_first_name"]) ? $coauthor_data[$i]["co_first_name"] : "";
            $coauthor_last_name[$i] = isset($coauthor_data[$i]["co_last_name"]) ? $coauthor_data[$i]["co_last_name"] : "";
            $coauthor_email[$i] = isset($coauthor_data[$i]["co_email"]) ? $coauthor_data[$i]["co_email"] : "";
            $coauthor_affiliation[$i] = isset($coauthor_data[$i]["co_affiliation"]) ? $coauthor_data[$i]["co_affiliation"] : "";
            $coauthor_affiliation[$i] = htmlspecialchars(stripslashes($coauthor_affiliation[$i]), ENT_QUOTES);
            // $coauthor_affiliation_value[$i] = affiliationJson($coauthor_affiliation[$i]);
            $coauthor_department[$i] = isset($coauthor_data[$i]["co_department"]) ? $coauthor_data[$i]["co_department"] : "";

            $coauthor_idx[$i] = isset($coauthor_data[$i]["co_idx"]) ? $coauthor_data[$i]["co_idx"] : "";
        }
    }


    if ($type == "update") {
        $submission_query = "
                                UPDATE request_abstract
                                SET
                                    modifier            =           {$user_idx},
                                    modify_date         =           NOW(),

                            ";
    } else {
        $submission_query =    "
                                    INSERT request_abstract
                                    SET 
                                        `type`            =        0,
                                        submission_code =       '{$submission_code}',
                                        register        =        {$user_idx},
                                ";
    }

    //if(!empty($funding_text)) {
    //	$funding_text_sql = "funding_text = '{$funding_text}',";
    //} else {
    //	$funding_text_sql = "";
    //}

    if (!empty($investigator_awards_yn)) {
        $investigator_awards_yn = "investigator_awards_yn = '{$investigator_awards_yn}',";
    } else {
        $investigator_awards_yn = "";
    }

    if (!empty($ask_grants_yn)) {
        $ask_grants_yn = "ask_grants_yn = '{$ask_grants_yn}',";
    } else {
        $ask_grants_yn = "";
    }
    if (!empty($award_yn)) {
        $award_yn = "award_yn = '{$award_yn}',";
    } else {
        $award_yn = "";
    }

    if (!empty($abstract_file_title)) {
        $abstract_file_title = "abstract_file_title      =   '{$abstract_file_title}',";
    } else {
        $abstract_file_title = "";
    }


    $submission_query .=    "
									{$award_yn}
									objectives		=			'{$objectives}',
									method			=			'{$method}',
									results			=			'{$results}',
									conclusions		=			'{$conclusions}',
									keywords		=			'{$keywords}',
                                    last_name        =        '{$last_name}',
                                    first_name        =        '{$first_name}',
                                    #city            =        '{$city}',
                                    affiliation        =        '{$affiliation}',
                                    email            =        '{$email}',
                                    #phone            =        '{$phone}',
                                    #position        =       '{$position}',
                                    abstract_category   =   '{$abstract_category}',
									funding_yn			=	'{$funding_yn}',
									{$investigator_awards_yn}
									{$ask_grants_yn}
									{$abstract_file_title}
									department			= '{$department}',
									presentation_type = '{$presentation_type}',
									abstract_title		= '{$abstract_title}',
									nation_no        =        {$nation_no}
                                    #oral_presentation    =    {$oral_presentation}
                                ";
    if ($state != "") {
        $submission_query .= " , state = '{$state}' ";
    }

    if ($position_other != "") {
        $submission_query .= " , position_other = '{$position_other}' ";
    }

    if ($_FILES["abstract_file"]) {

        $file_no = upload_file($_FILES["abstract_file"], 0);

        if ($file_no != "") {
            $submission_query .=    ", abstract_file = '{$file_no}' ";
        }

        if ($file_no == "") {
            $res = [
                code => 401,
                msg => "file upload error"
            ];
            echo json_encode($res);
            exit;
        }
    }

    if ($type == "update") {
        $submission_query .=    " WHERE idx = {$abstract_idx} ";

        //일단 전부 삭제 시킨 후 수정 되는 것들만 복귀 시킨다.
        $ready_delete_query = "SELECT
										idx
									FROM request_abstract
									WHERE parent_author = {$abstract_idx}";

        $ready_delete_result = sql_fetch($ready_delete_query);

        if (isset($ready_delete_result)) {

            $delete_query = "UPDATE
									request_abstract
								SET
									is_deleted = 'Y'
								WHERE parent_author = {$abstract_idx}";

            sql_query($delete_query);
        }
    }

    $result = sql_query($submission_query);

    if (!$result) {
        $res = [
            code => 400,
            msg => "main query error"
        ];
        echo json_encode($res);
        exit;
    } else {

        if ($co_nation_no1) {

            $select_last_idx_query =    "
												SELECT 
													MAX(idx) AS last_idx
												FROM request_abstract
												WHERE register = {$user_idx}
												ORDER BY register_date DESC
											";

            if (!$abstract_idx) {
                $last_idx = sql_fetch($select_last_idx_query)["last_idx"];
            } else {
                $last_idx = $abstract_idx;
            }

            $select_co_idx_query =  "
											SELECT
												idx
											FROM request_abstract
											WHERE register = {$user_idx}
											AND parent_author = {$last_idx}
											ORDER BY idx
										";



            $co_abstract_idx = get_data($select_co_idx_query);

            if (count($coauthor_data) == 1) {
                //하나만 있을 경우
                $coauthor_count = 2;
            } else {
                $coauthor_count = count($coauthor_data) + 1;
            }

            for ($i = 1; $i < $coauthor_count; $i++) {

                if ($coauthor_idx[$i - 1] != -1) {

                    $co_submission_query =  "
													UPDATE request_abstract
													SET
														modifier            =           {$user_idx},
														modify_date         =           NOW(),
														is_deleted			=			'N',
												";
                } else {
                    $co_submission_query =  "
													INSERT request_abstract
													SET
														`type`          =           0,
														register        =           {$user_idx},
														parent_author   =           {$last_idx},
												";
                }

                if ($i == 1) {
                    $co_submission_query .=    "
													`order`			=			{$i},
													nation_no        =        {$co_nation_no1},
													last_name        =        '{$co_last_name1}',
													first_name        =        '{$co_first_name1}',
													#city            =        '{$co_city1}',
													affiliation        =        '{$co_affiliation1}',
													email            =        '{$co_email1}',
													department			=		'{$co_department1}'
													#phone            =        '{$co_phone1}'
													#position        =       '{$co_position}'
												";

                    if ($co_state1 != "") {
                        $co_submission_query .= " , state = '{$co_state1}' ";
                    }

                    if ($co_position_other != "") {
                        $co_submission_query .= " , position_other = '{$co_position_other}' ";
                    }
                } else {
                    $n = $i - 1;
                    $co_submission_query .= "
													`order`			=			{$i},
													nation_no     =       '" . $coauthor_nation_no[$n] . "',			     
													affiliation     =       '" . $coauthor_affiliation[$n] . "',
													last_name       =       '" . $coauthor_last_name[$n] . "',
													first_name      =       '" . $coauthor_first_name[$n] . "',
													email      =       '" . $coauthor_email[$n] . "',
													department     =       '" . $coauthor_department[$n] . "'
												";
                }

                if ($coauthor_idx[$i - 1] != -1) {
                    //$co_submission_query .= "
                    //							WHERE idx = {$co_abstract_idx[($i-1)]['idx']}
                    //						";
                    $co_submission_query .= "
													WHERE idx = " . $coauthor_idx[$i - 1];
                }


                $co_result = sql_query($co_submission_query);

                if (!$co_result) {
                    echo json_encode(array(
                        "code" => 400,
                        "msg" => "co" . $i . " query error"
                    ));
                    exit;
                }
            }
        }
    }


    if ($type != "update") {
        $select_user_query = "
                                    SELECT
                                        *
                                    FROM member
                                    WHERE idx = '{$user_idx}'
                                    AND is_deleted = 'N'
                                ";

        $select_category_query = "
                                    SELECT
										*
									FROM info_poster_abstract_category
									WHERE is_deleted = 'N'
                                    AND idx = '{$abstract_category}'
                                ";

        $user_data = sql_fetch($select_user_query);
        $category_data = sql_fetch($select_category_query);

        $subject = $language == "ko" ? "초록 신청 완료" : "Abstract Successfully Submitted";
        $mail_result = mailer($language, "abstract", "", $email, "[ISCP]" . $subject, date("Y-m-d H:i:s"), "", "", 1, "", "", "", $user_data['email'], date("Y-m-d H:i:s"), $category_data['title'], $abstract_title);

        $email = !empty($email) ? $email : $user_data['email'];

        $name = $language == "en" ? $user_data["first_name"] . " " . $user_data["last_name"] : $user_data["last_name"] . $user_data["first_name"];

        $mail_result = mailer($language, "abstract", $name, $email, "[ISCP 2023]" . $subject, date("Y-m-d H:i:s"), "", "", 1, "", "", "", $user_data['email'], date("Y-m-d H:i:s"), $category_data['title_en'], $abstract_title);

        if (!$mail_result) {
            $res = [
                code => 401,
                msg => "send mail fail"
            ];
            echo json_encode($res);
            exit;
        }
    }

    ////세션 초기화
    //$_SESSION["abstract"] = "";
    //$_SESSION["abstract_flag"] = "";

    $res = [
        code => 200,
        msg => "success"
    ];
    echo json_encode($res);
    exit;
} else if ($_POST["flag"] == "submission_delete") {
    $user_idx = $_SESSION["USER"]["idx"];
    $idx = isset($_POST["idx"]) ? $_POST["idx"] : "";

    $abstract_delete_query =    "
                                        UPDATE request_abstract
                                        SET
                                            is_deleted  = 'Y',
                                            modifier = {$user_idx},
                                            modify_date = NOW()
                                        WHERE idx = {$idx}
                                        OR parent_author = {$idx}
                                    ";
    $delete = sql_query($abstract_delete_query);

    if (!$delete) {
        $res = [
            code => 400,
            msg => "delete query error"
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
} else if ($_POST["flag"] == "abstract_step2_prev") {

    $_SESSION["abstract_flag"] = "true";

    $res = [
        code => 200,
        msg => "success"
    ];
    echo json_encode($res);
    exit;
}


function affiliationJson($affiliation)
{
    if ($affiliation != "") {
        if (strpos($afflilation, ",")) {
            $affiliation =  substr($affiliation, -1, 1);
        }

        $arr = explode(",", $affiliation);
        $json_data = json_encode($arr, JSON_UNESCAPED_UNICODE);

        return $json_data;
    } else {
        return $affiliation;
    }
}

function createSubmissionCode($type)
{
    $year = date("Y");

    $type_no = $type == "abstract" ? 0 : 1;
    $type_name = $type == "abstract" ? "A" : "L";

    $count_query =  "
                            SELECT
                                count(idx) AS count
                            FROM request_abstract
                            WHERE `type` = {$type_no}
                            AND parent_author IS NULL
                        ";

    $count = sql_fetch($count_query)["count"];

    $code_number = $count + 1;

    while (strlen("" . $code_number) < 6) {
        $code_number = "0" . $code_number;
    }

    $code = "ISCP" . $year . "-" . $type_name . "-" . $code_number;
    return $code;
}
