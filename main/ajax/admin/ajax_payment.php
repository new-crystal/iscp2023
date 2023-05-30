<?php include_once("../../common/common.php");?>
<?php
    if($_POST["flag"] == "update_payment") {
        $registration_idx = isset($_POST["idx"]) ? $_POST["idx"] : "";
        $data = isset($_POST["data"]) ? $_POST["data"] : "";
        $submit_type = isset($_POST["type"]) ? $_POST["type"] : "";

        $payment_status = isset($data["payment_status"]) ? $data["payment_status"] : "";

        $payment_unit = isset($data["payment_status"]) ? $data["payment_unit"] : "";
        $payment_price = isset($data["payment_price"]) ? $data["payment_price"] : "";

        $refund_reason = isset($data["refund_reason"]) ? $data["refund_reason"] : "";

        $refund_bank = isset($data["refund_bank"]) ? $data["refund_bank"] : "";
        $refund_holder = isset($data["refund_holder"]) ? $data["refund_holder"] : "";
        $refund_account = isset($data["refund_account"]) ?$data["refund_account"] : "";

        $registration_info = sql_fetch("SELECT * FROM request_registration WHERE idx = {$registration_idx}");
        $payment_no = $registration_info['payment_no'];

        if($submit_type == "update_refund_reason" || $submit_type == "update_refund_info") {
            if(!$payment_no) {
                $res= [
                    code => 401,
                    msg => "Invalid payment_no"
                ];
                echo json_encode($res);
                exit;
            }
        }

        if($submit_type == "update_payment_status" && $payment_status == 2) {
            $member_idx = $_SESSION['ADMIN']['idx'];
            $payment_unit_col = $payment_unit=="KRW" ? "kr" : "us";
            $insert_payment_query = "INSERT INTO 
                                        payment 
                                        (
                                            `type`, payment_type, payment_type_name, payment_status, 
                                            payment_price_{$payment_unit_col}, tax_{$payment_unit_col}, 
                                            total_price_{$payment_unit_col}, 
                                            payment_date,
                                            register_date, register, register_admin
                                        )
                                    VALUES
                                        (
                                            2, 2, '관리자 결제완료처리', 2, 
                                            0, 0,
                                            '{$payment_price}', 
                                            NOW(), 
                                            NOW(), '{$registration_info['register']}', '{$member_idx}'
                                        )";
            $insert_payment = sql_query($insert_payment_query);
            if(!$insert_payment) {
                $res = [
                    code => 400,
                    msg => "payment query error"
                ];
            } else {
                $payment_new_no = sql_insert_id();
                if ($payment_no) {
                    // 기존 건에 이력 업데이트
                    sql_query("UPDATE payment SET etc1 = '{$registration_idx}' WHERE idx = {$payment_no}");
                }
                sql_query("UPDATE request_registration SET payment_no = '{$payment_new_no}' WHERE idx = '{$registration_idx}'");
            }
        }

        $update_payment_query =  "
                                            UPDATE payment
                                            SET
                                        ";

        if($payment_status != "") {
            $update_payment_query .= " payment_status = '{$payment_status}', ";

            if ($payment_status == 4) {
                $update_payment_query .= " refund_date = NOW(), ";
            }

            $update_registartion_query =    "
                                                UPDATE request_registration
                                                SET
                                                    status = '{$payment_status}'
                                                WHERE idx = {$registration_idx}
                                            ";
            
            $registration_update = sql_query($update_registartion_query);

            if(!$registration_update) {
                $res = [
                    code => 400,
                    msg => "registration query error"
                ];
            }
        }

        if($refund_reason != "") {
            $update_payment_query .= " refund_reason = '{$refund_reason}', ";
        }

        if($refund_bank != "") {
            $update_payment_query .= " refund_bank = '{$refund_bank}', ";
        }

        if($refund_holder != "") {
            $update_payment_query .= " refund_holder = '{$refund_holder}', ";
        }

        if($refund_account != "") {
            $update_payment_query .= " refund_account = '{$refund_account}', ";
        }

        $update_payment_query = substr($update_payment_query, 0, -2);

        $update_payment_query .= " WHERE idx = '{$payment_no}' ";
 
        $payment_update = sql_query($update_payment_query);

        if(!$payment_update) {
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
    }
function get_payment_no($registration_idx) {
    $payment_no_query = "
                            SELECT
                                payment_no
                            FROM request_registration
                            WHERE is_deleted = 'N'
                            AND idx = {$registration_idx}
                            ORDER BY register_date DESC
                            LIMIT 1
                        ";
    $payment_no = sql_fetch($payment_no_query)["payment_no"];

    return $payment_no;
}
?>