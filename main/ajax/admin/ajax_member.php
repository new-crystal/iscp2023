<?php
    include_once("../../common/common.php");

    $flag = $_POST["flag"] ?? $_GET["flag"];

    //2021_06_18 HUBDNC_KMJ 관리자회원 삭제
    if($flag == "delete_admin"){
        /** Request Parameter 핸들링**/
        $idx = $_POST["idx"] ?? 0;
        /** Request Parameter 핸들링**/
        try{
            $delete_query = "UPDATE
                                admin
                            SET
                                delete_date = NOW(),
                                is_deleted = 'Y'
                            WHERE idx = {$idx}";
                            
            sql_query($delete_query);
            $res = array(
                "code"=>200,
                "msg"=>"ok"
            );
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }catch(\Ecetpcion $ex){
            $res = array(
                "code"=>500,
                "msg"=>"fail"
            );
            
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    //2021_06_18 HUBDNC_KMJ 관리자회원 등록
    if($flag == "admin_regist"){
        $error_message = admin_validation($_POST);
        if(!empty($error_message)){
            $res = [
                "code"=>401,
                "msg"=>$error_message
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }
        $pwd = password_hash($password, PASSWORD_DEFAULT);

        try{
            $insert_query = "INSERT
                                admin
                            SET
                                email = '{$email}',
                                name = '{$name}',
                                department = '{$department}',
                                spot = '{$spot}',
                                `position` = '{$position}',
                                phone = '{$phone}',
                                `password` = '{$pwd}',
                                postcode = '{$postcode}',
                                street_address1 = '{$address1}',
                                street_address2 = '{$address2}'";

            sql_query($insert_query);

            $res = [
                "code"=>200,
                "msg"=>"ok"
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;

        }catch(\Exception $ex){
            $res = [
                "code"=>500,
                "msg"=>"fail"
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    //2021_06_18 HUBDNC_KMJ 관리자회원수정
    if($flag == "admin_update"){
        /*$error_message = admin_validation($_POST);
        if(!empty($error_message)){
            $res = [
                "code"=>401,
                "msg"=>$error_message
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }*/

        try{
            $cols = "";

            if ($pwd != "") {
                $pwd = password_hash($password, PASSWORD_DEFAULT);
                $cols .= "`password` = '{$pwd}',";
            }

            $cols .= "email = '{$email}',
                    name = '{$name}',
                    department = '{$department}',
                    spot = '{$spot}',
                    `position` = '{$position}',
                    phone = '{$phone}',
                    postcode = '{$postcode}',
                    street_address1 = '{$address1}',
                    street_address2 = '{$address2}',
                    modify_date = NOW()";

            $update_query = "UPDATE admin
                            SET
                                {$cols}
                            WHERE idx = {$idx}";

            sql_query($update_query);

            $res = array(
                "code"=>200,
                "msg"=>"ok" 
            );
            
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }catch(\Exception $ex){
            $res = [
                "code"=>500,
                "msg"=>"fail"
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // 2021-09-20 HUBDNC_PSY 관리자 마이페이지 비번 변경
    if($flag == "update_pw_only"){

        try{
            $admin_idx = $_SESSION["ADMIN"]["idx"];

            $admin_info_query =  "
                                SELECT
                                    *
                                FROM admin
                                WHERE is_deleted = 'N'
                                AND idx = '{$admin_idx}'
                                ";
            $admin_info = sql_fetch($admin_info_query);

            if(password_verify($_POST["pw_origin"] ,$admin_info["password"]) == false) {
                $res = [
                    code => 401,
                    msg => "이전 비밀번호를 확인해주세요."
                ];
                echo json_encode($res);
                exit;
            } else {
                $pw_hash = password_hash($_POST["pw"], PASSWORD_DEFAULT);

                $update_query = "UPDATE admin
                                SET
                                    `password` = '{$pw_hash}',
                                    modify_date = NOW()
                                WHERE idx = {$admin_idx}";
                sql_query($update_query);

                $res = array(
                    "code"=>200,
                    "msg"=>"ok" 
                );
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
                exit;
            }
        }catch(\Exception $ex){
            $res = [
                "code"=>500,
                "msg"=>"fail"
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    function admin_validation($data){
        $message = null;
        $idx        = $data["idx"]        ?? 0;
        $email      = $data["email"]      ?? null;
        $name       = $data["name"]       ?? null;
        $password   = $data["password"]   ?? null;
        $department = $data["department"] ?? null;
        $spot       = $data["spot"]       ?? null; 
        $position   = $data["position"]   ?? null;
        $phone      = $data["phone"]      ?? null;
        $postcode   = $data["postcode"]   ?? null;
        $address1   = $data["address1"]   ?? null;
        $address2   = $data["address2"]   ?? null;

        $phone = preg_match("/([0-9]{3})-([0-9]{4})-([0-9]{4})/", $phone) ? $phone : null;

        if(empty($email)){
            $message = "이메일을 입력해주세요.";
            return $message;
        }
        if(empty($name)){
            $message = "이름을 입력해주세요";
            return $message;
        }
        if(empty($password)){
            $message = "비밀번호를 입력해주세요";
            return $message;
        }
        if(empty($department)){
            $message = "부서를 입력해주세요";
            return $message;
        }
        if(empty($spot)){
            $message = "직위를 입력해주세요";
            return $message;
        }
        if(empty($position)){
            $message = "직급을 입력해주세요";
            return $message;
        }
        if(empty($phone)){
            $message = "휴대폰번호를 입력해주세요";
            return $message;
        }
        return $message;
    }
?>