<?php include_once("../../common/common.php");?>
<?php 
    if($_POST["flag"] == "login") {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";

        $login_query =  "
                            SELECT
                                *
                            FROM admin
                            WHERE is_deleted = 'N'
                            AND email = '{$id}'
                            ORDER BY register_date DESC
                            LIMIT 1
                        ";
        
        $admin_info = sql_fetch($login_query);

        if(!$admin_info) {
            $res = [
                code => 401,
                msg => "존재하지 않는 ID(이메일입니다.)"
            ];
            echo json_encode($res);
            exit;
        }

        if(password_verify($password ,$admin_info["password"]) == false) {
            $res = [
                code => 401,
                msg => "비밀번호를 확인해주세요."
            ];
            echo json_encode($res);
            exit;
        }

        $_SESSION["ADMIN"] = [
            "idx" => $admin_info["idx"],
            "name" => $admin_info["name"],
            "phone" => $admin_info["phone"],
            "postcode" => $admin_info["postcode"],
            "city" => $admin_info["city"],
            "state" => $admin_info["state"],
            "street_address1" => $admin_info["street_address1"],
            "street_address2" => $admin_info["street_address2"],
            "department" => $admin_info["department"],
            "spot" => $admin_info["spot"],
            "position" => $admin_info["position"]
        ];

        //어드민 권한정보 가져오는 쿼리
        $admin_idx = $_SESSION["ADMIN"]["idx"];
        $admin_permission_query = "SELECT
                                    auth_account_member,
                                    auth_account_admin, 
                                    auth_apply_poster,
                                    auth_apply_lecture,
                                    auth_apply_registration,
                                    auth_apply_sponsorship,
                                    auth_page_event,
                                    auth_page_main,
                                    auth_page_general,
                                    auth_page_poster,
                                    auth_page_lecture,
                                    auth_page_registration,
                                    auth_page_sponsorship,
                                    auth_live_popup,
                                    auth_live_lecture,
                                    auth_live_lecture_qna,
                                    auth_live_abstract,
                                    auth_live_conference,
                                    auth_live_event,
                                    auth_board_news,
                                    auth_board_notice,
                                    auth_board_faq
                                FROM admin
                                WHERE idx = {$admin_idx}";
        $admin_permission = sql_fetch($admin_permission_query);

        $key = "";
        $location = "";
        foreach($admin_permission as $k => $v){
            if($v != 0){
                switch($k){
                    case "auth_account_member" :
                        $location = "member_list.php";
                        break;
                    case "auth_account_admin" :
                        $location = "admin_list.php";
                        break;
                    case "auth_apply_poster" :
                        $location = "abstract_application_list.php";
                        break;
                    case "auth_apply_lecture" :
                        $location = "lecture_note_list.php";
                        break;
                    case "auth_apply_registration" :
                        $location = "registration_list.php";
                        break;
                    case "auth_apply_sponsorship" :
                        $location = "sponsorship_list.php";
                        break;
                    case "auth_page_event" :
                        $location = "set_event.php";
                        break;
                    case "auth_page_main" :
                        $location = "set_main.php";
                        break;
                    case "auth_page_general" :
                        $location = "set_general.php";
                        break;
                    case "auth_page_poster" :
                        $location = "set_poster.php";
                        break;
                    case "auth_page_lecture" :
                        $location = "set_lecture.php";
                        break;
                    case "auth_page_registration" :
                        $location = "set_registration.php";
                        break;
                    case "auth_page_sponsorship" :
                        $location = "sponsorship_overview.php";
                        break;
                    case "auth_live_popup" :
                        $location = "manage_popup.php";
                        break;
                    case "auth_live_lecture" :
                        $location = "manage_lecture.php";
                        break;
                    case "auth_live_lecture_qna" :
                        $location = "manage_lectureQA_list.php";
                        break;
                    case "auth_live_abstract" :
                        $location = "manage_abstract_list.php";
                        break;
                    case "auth_live_conference" :
                        $location = "manage_conference.php";
                        break;
                    case "auth_live_event" :
                        $location = "manage_event_luckyDraw.php";
                        break;
                    case "auth_board_news" :
                        $location = "board_list.php?t=0";
                        break;
                    case "auth_board_notice" :
                        $location = "board_list.php?t=1";
                        break;
                    case "auth_board_faq" :
                        $location = "board_category_list.php";
                        break;
                }
                break;
            }
        }

        $res = [
            code => 200,
            msg => "로그인 성공",
            url => $location
        ];
        echo json_encode($res);
        exit;
    }

    else if($_POST["flag"] == "logout") {
        $_SESSION["ADMIN"] = [];

        $res = [
            code => 200,
            msg => "로그아웃 성공"
        ];
        echo json_encode($res);
        exit;
    }

    else if($flag == "permission"){
        $idx                     = $_POST["idx"] ?? 0;
        $account_member          = $_POST["account_member"]     == "undefined" ? 0 : $_POST["account_member"];
        $account_admin           = $_POST["account_admin"]      == "undefined" ? 0 : $_POST["account_admin"];
        $apply_poster            = $_POST["apply_poster"]       == "undefined" ? 0 : $_POST["apply_poster"];
        $apply_lecture           = $_POST["apply_lecture"]      == "undefined" ? 0 : $_POST["apply_lecture"];
        $apply_registration      = $_POST["apply_registration"] == "undefined" ? 0 : $_POST["apply_registration"];
        $apply_sponsorship       = $_POST["apply_sponsorship"]  == "undefined" ? 0 : $_POST["apply_sponsorship"];
        $page_event              = $_POST["page_event"]         == "undefined" ? 0 : $_POST["page_event"];
        $page_main               = $_POST["page_main"]          == "undefined" ? 0 : $_POST["page_main"];
        $page_general            = $_POST["page_general"]       == "undefined" ? 0 : $_POST["page_general"];
        $page_poster             = $_POST["page_poster"]        == "undefined" ? 0 : $_POST["page_poster"];
        $page_lecture            = $_POST["page_lecture"]       == "undefined" ? 0 : $_POST["page_lecture"];
        $page_registration       = $_POST["page_registration"]  == "undefined" ? 0 : $_POST["page_registration"];
        $page_sponsorship        = $_POST["page_sponsorship"]   == "undefined" ? 0 : $_POST["page_sponsorship"];
        $live_popup              = $_POST["live_popup"]         == "undefined" ? 0 : $_POST["live_popup"];
        $live_lecture            = $_POST["live_lecture"]       == "undefined" ? 0 : $_POST["live_lecture"];
        $live_lecture_qna        = $_POST["live_lecture_qna"]   == "undefined" ? 0 : $_POST["live_lecture_qna"];
        $live_abstract           = $_POST["live_abstract"]      == "undefined" ? 0 : $_POST["live_abstract"];
        $live_conference         = $_POST["live_conference"]    == "undefined" ? 0 : $_POST["live_conference"];
        $live_event              = $_POST["live_event"]         == "undefined" ? 0 : $_POST["live_event"];
        //$live_ebooth             = $_POST["live_ebooth"]        == "undefined" ? 0 : $_POST["live_ebooth"];
        $board_news              = $_POST["board_news"]         == "undefined" ? 0 : $_POST["board_news"];
        $board_notice            = $_POST["board_notice"]       == "undefined" ? 0 : $_POST["board_notice"];
        $board_faq               = $_POST["board_faq"]          == "undefined" ? 0 : $_POST["board_faq"];

        $permission_query = "UPDATE admin
                            SET
                                auth_account_member     = {$account_member},
                                auth_account_admin      = {$account_admin},
                                auth_apply_poster       = {$apply_poster},
                                auth_apply_lecture      = {$apply_lecture},
                                auth_apply_registration = {$apply_registration},
                                auth_apply_sponsorship  = {$apply_sponsorship},
                                auth_page_event         = {$page_event},
                                auth_page_main          = {$page_main},
                                auth_page_general       = {$page_general},
                                auth_page_poster        = {$page_poster},
                                auth_page_lecture       = {$page_lecture},
                                auth_page_registration  = {$page_registration},
                                auth_page_sponsorship   = {$page_sponsorship},
                                auth_live_popup         = {$live_popup},
                                auth_live_lecture       = {$live_lecture},
                                auth_live_lecture_qna   = {$live_lecture_qna},
                                auth_live_abstract      = {$live_abstract},
                                auth_live_conference    = {$live_conference},
                                auth_live_event         = {$live_event},
                                #auth_live_ebooth       = {$live_ebooth},
                                auth_board_news         = {$board_news},
                                auth_board_notice       = {$board_notice},
                                auth_board_faq          = {$board_faq}
                            WHERE idx = {$idx}";
        $permission = sql_query($permission_query);

        if($permission){
            $res["code"] = 1;
            $res["msg"] = "ok";
        }else{
            $res["code"] = 0;
            $res["msg"] = "fail";
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        exit;
    }
?>