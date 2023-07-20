<?php
header('Content-Type: text/html; charset=UTF-8');
include_once('./include/head.php');
include_once('./include/header.php');


//include "./plugin/NHNKCP/cfg/site_conf_inc.php";       // 환경설정 파일 


$member_idx = $_SESSION['USER']['idx'];
$registration_idx = $_GET["idx"];

//실서버에만 있음
if ($_SERVER["HTTP_HOST"] == "www.iscp2023.org") {
    //echo "<script>location.replace('https://iscp2023.org/main/registration2.php?idx={$registration_idx}')</script>";
}

$_SESSION["registration"]["idx"] = $registration_idx;

if (!$registration_idx) {
    echo "<script>alert('Undefined registration number!'); window.location.replace('./registration.php');</script>";
    exit;
}
//결제번호 생성
$rNo = $registration_idx;
$date = date("YmdHis");
$random = mt_rand(1, 1000);
while (strlen("" . $rNo) < 10) {
    $rNo = "0" . $rNo;
}
while (strlen("" . $random) < 3) {
    $random = "0" . $random;
}
$order_code = "PR" . $date . $random . "N" . $rNo;

$select_registration_query =    "
										SELECT
											r.*, n.nation_ko, nation_en, f.original_name as file_name, CONCAT(f.path,'/',f.save_name) AS file_path, 
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
										AND register = '{$member_idx}'
									";
$registration_data = sql_fetch($select_registration_query);

if (!is_array($registration_data)) {
    //echo "<script>alert('Undefined registration number!'); window.location.replace('./registration.php');</script>";
    //exit;
}

// 데이터
$attendance_type = isset($registration_data["attendance_type"]) ? $registration_data["attendance_type"] : "-";
$attendance_type = ($attendance_type == 0 ? "Offline" : ($attendance_type == 1 ? "Online" : ($attendance_type == 2 ? "Online+Offline" : "-")));
$member_status = isset($registration_data["member_status"]) ? $registration_data["member_status"] : "-";

$price_col_name = "";
$price_col_name .= ($attendance_type == 0) ? "off_" : "on_";
$price_col_name .= ($registration_data["member_status"] == 0) ? "guest_" : "member_";
//$price_col_name .= "usd";



$nation_no            = isset($registration_data["nation_no"]) ? $registration_data["nation_no"] : "-";

//2022-05-16 추가
$promotion_code = isset($registration_data["promotion_code"]) ? $registration_data["promotion_code"] : -1;
$recommended_by = isset($registration_data["recommended_by"]) ? $registration_data["recommended_by"] : "";
$register_path = isset($registration_data["register_path"]) ? $registration_data["register_path"] : "-";
$register_path_others = $registration_data["register_path_others"] ?? "";

$register_paths = array();
$register_paths = explode(",", $register_path);
$register_path_value = "";

if ($nation_no == 25) {
    for ($i = 0; $i < count($register_paths) - 1; $i++) {
        if ($register_paths[$i] == 0) {
            $register_path_value .= "대한심혈관약물치료학회 홈페이지 또는 홍보메일</p>";
        } else if ($register_paths[$i] == 1) {
            $register_path_value .= "<p>ISCP 홍보메일 또는 게시판 광고 </p> ";
        } else if ($register_paths[$i] == 2) {
            $register_path_value .= "<p>초청연자/좌장으로 초청받음 </p> ";
        } else if ($register_paths[$i] == 3) {
            $register_path_value .= "<p>이전 ISCP에 참석한 경험이 있음 </p> ";
        } else if ($register_paths[$i] == 4) {
            $register_path_value .= "<p>제약회사 소개 </p> ";
        } else if ($register_paths[$i] == 5) {
            $register_path_value .= "<p>지인을 통해 </p> ";
        } else if ($register_paths[$i] == 6) {
            $register_path_value .= "<p>인터넷 검색 </p> ";
        }
    }
} else {
    for ($i = 0; $i < count($register_paths) - 1; $i++) {
        if ($register_paths[$i] == 0) {
            $register_path_value .= "<p>Website or newletter of KSCP</p>";
        } else if ($register_paths[$i] == 1) {
            $register_path_value .= "<p>Website or notice of related society</p> ";
        } else if ($register_paths[$i] == 2) {
            $register_path_value .= "<p>Went to the last ISCP</p> ";
        } else if ($register_paths[$i] == 3) {
            $register_path_value .= "<p>Invitation for speaker or chair</p> ";
        } else if ($register_paths[$i] == 4) {
            $register_path_value .= "<p>Friend / Colleague</p> ";
        } else if ($register_paths[$i] == 5) {
            $register_path_value .= "<p>Medical corporate</p> ";
        } else if ($register_paths[$i] == 6) {
            $register_path_value .= "<p>Internet banner ads or search</p> ";
        }
    }
}

if (!empty($register_path_others)) {
    $register_path_value .= "<p>" . $register_path_others . " </p> ";
}

//2022-05-13 추가
//이거는 프론트 용 단 변수 밑에 payment_methods는 벡엔드용
$payment_methods_select = $registration_data["payment_methods"] ?? null;
//2022-05-12 추가
$welcome_reception_yn = $registration_data["welcome_reception_yn"] == "Y" ? "Yes" : "No";
$day1_luncheon_yn    = $registration_data["day1_luncheon_yn"] == "Y" ? "Yes" : "No";
$day2_breakfast_yn    = $registration_data["day2_breakfast_yn"] == "Y" ? "Yes" : "No";
$day2_luncheon_yn    = $registration_data["day2_luncheon_yn"] == "Y" ? "Yes" : "No";
$day3_breakfast_yn    = $registration_data["day3_breakfast_yn"] == "Y" ? "Yes" : "No";
$day3_luncheon_yn    = $registration_data["day3_luncheon_yn"] == "Y" ? "Yes" : "No";


//$payment_methods	= isset($registration_data["payment_methods"]) ? $registration_data["payment_methods"] : "-";
$payment_methods = 0;

$member_status        = $member_status == 1 ? $locale("member") : $locale("non_member");
$applied_review        = isset($registration_data["is_score"]) ? $registration_data["is_score"] : "-";
$is_score            = $applied_review == 0 ? "NO" : ($applied_review == 1 ? "YES" : "-");
$email                = isset($registration_data["email"]) ? $registration_data["email"] : "-";
$nation                = isset($registration_data["nation_en"]) ? $registration_data["nation_en"] : "-";
$first_name            = isset($registration_data["first_name"]) ? $registration_data["first_name"] : "-";
$last_name            = isset($registration_data["last_name"]) ? $registration_data["last_name"] : "-";
$name_kor            = isset($registration_data["name_kor"]) ? $registration_data["name_kor"] : "-";
// $phone                = isset($registration_data["phone"]) ? $registration_data["phone"] : "-";
$registration_type    = isset($registration_data["registration_type"]) ? $registration_data["registration_type"] : "-";
$registration_type    = $registration_type == 0 ? $locale("registration_type_select1") : ($registration_type == 1 ? $locale("registration_type_select2") : $locale("registration_type_select3"));
$affiliation        = isset($registration_data["affiliation"]) ? $registration_data["affiliation"] : "-";
$department            = isset($registration_data["department"]) ? $registration_data["department"] : "-";
$licence_number        = isset($registration_data["licence_number"]) ? $registration_data["licence_number"] : "-";
$academy_number        = isset($registration_data["academy_number"]) ? $registration_data["academy_number"] : "-";
//$register_path		= isset($registration_data["register_path"]) ? $registration_data["register_path"] : "-";
$member_type        = isset($registration_data["member_type"]) ? $registration_data["member_type"] : "-";
$etc                = $registration_data["etc1"] ?? "-";
$result_org        = isset($registration_data["etc2"]) ? $registration_data["etc2"] : "";
$result_org = explode(",", $result_org);
foreach ($result_org as $key => $value) {
    $result_org[$key] = ($value == 1 ? $locale("applied_org1") : ($value == 2 ? $locale("applied_org2") : ($value == 3 ? $locale("applied_org3") : ($value == 4 ? $locale("applied_org4") : '-'))));
}
$identification_file   = isset($registration_data["file_name"]) ? $registration_data["file_name"] : "-";
$identification_file_path = isset($registration_data["file_path"]) ? $registration_data["file_path"] : "";

// 가격이 무료인 경우 결제 완료상태로 바로 변경함
/*if ($price == 0 && $registration_data['status'] == 1) {
		$unit_col = ($language == "en") ? "us" : "kr";

		$insert_payment_query = "INSERT INTO 
										payment 
										(
											`type`, payment_type, payment_type_name, payment_status, 
											payment_price_{$unit_col}, tax_{$unit_col}, total_price_{$unit_col}, 
											payment_date, register_date, register
										)
									VALUES
										(
											4, 2, '무료 신청', 2, 0, 0, 0, NOW(), NOW(), '{$member_idx}'
										)";
		sql_query($insert_payment_query);
		$payment_new_no = sql_insert_id();

		sql_query("UPDATE request_registration SET `status` = 2, payment_no = '{$payment_new_no}' WHERE idx = '{$registration_idx}'");
	}*/


if ($nation_no == 25) {
    // $price_col_name .= "usd";
    // $cur = "USD";

    $name = $first_name . " " . $last_name;
    // echo '<script>';
    // echo 'console.log("25")';
    // echo 'console.log("' . $name . '")';
    // echo '</scirpt>';
} else {
    // $price_col_name .= "krw";
    // $cur = "KRW";
    $name = $last_name . " " . $first_name;
    // echo '<script>';
    // echo 'console.log("!!25")';
    // echo 'console.log("' . $name . '")';
    // echo '</scirpt>';
}


//금액 변환
//$us_price = "1";
//$ko_price = "1000";
$us_price = $registration_data["price"];
$phone =  $registration_data["phone"] ?  $registration_data["phone"] : "01012345678";
$sql_during =    "SELECT
						IF(NOW() >= '2024-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];


//특정 회원 가격 변동 이후 삭제
// if ($registration_idx == 512) {
//     $r_during_yn = 'N';
// }

if (!empty($_SESSION["USER"])) {
    $ksola_member_status = $member['ksola_member_status'];
} else {
    echo "<script>alert('Need to login'); window.location.replace(PATH+'login.php');</script>";
    exit;
}

if ($r_during_yn == 'Y') {

    if ($us_price == 300) {
        $us_price = 200;
    } else if ($us_price == 150) {
        $us_price = 100;
    } else if ($us_price == 120000) {
        $us_price = 50000;
    } else if ($us_price == 100000) {
        $us_price = 50000;
    } else if ($us_price == 60000) {
        $us_price = 10000;
    }
}

// if ($member['idx'] == 137) {
//     $us_price = 75;
// }

$ko_price = $us_price;

$price = $us_price;
$price_eyes = $us_price;
if ($nation_no != 25) {
    $price_payment = $price * 100;
} else {
    $price_payment = $price;
}

// if ($promotion_code == 0 && $promotion_code != "") {
//     $promotion_code_value = "ICoLA-77932";
//     $price_payment = 0;
//     $price = 0;
// } else if ($promotion_code == 1) {
//     $promotion_code_value = "ICoLA-59721";
//     $price_payment = $price_payment / 2;
//     $price = $price / 2;
// } else if ($promotion_code == 2) {
//     $promotion_code_value = "ICoLA-89359";
//     $price_payment = $price_payment / 2;
//     $price = $price / 2;
// } else if ($promotion_code == 4) {
//     $promotion_code_value = "ICoLA-83523";
//     $price_payment = $price_payment / 2;
//     $price = $price / 2;
// }


$price_name = ($nation_no == 25) ? "원" : "USD";


// KG INICIS 결제모듈 정보로드
include_once(D9_PATH . "/plugin/KG_INICIS/inicis_loader.php");
?>

<?php
//모바일용
/* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */
// $req_tx          = $_POST["req_tx"]; // 요청 종류         
// $res_cd          = $_POST["res_cd"]; // 응답 코드         
// $tran_cd         = $_POST["tran_cd"]; // 트랜잭션 코드     
// $ordr_idxx       = $_POST["ordr_idxx"]; // 쇼핑몰 주문번호   
// $good_name       = $_POST["good_name"]; // 상품명            
// $good_mny        = $_POST["good_mny"]; // 결제 총금액       
// $buyr_name       = $_POST["buyr_name"]; // 주문자명          
// $buyr_tel1       = $_POST["buyr_tel1"]; // 주문자 전화번호   
// $buyr_tel2       = $_POST["buyr_tel2"]; // 주문자 핸드폰 번호
// $buyr_mail       = $_POST["buyr_mail"]; // 주문자 E-mail 주소
// $use_pay_method  = $_POST["use_pay_method"]; // 결제 방법         
// $enc_info        = $_POST["enc_info"]; // 암호화 정보       
// $enc_data        = $_POST["enc_data"]; // 암호화 데이터     
// $cash_yn         = $_POST["cash_yn"];
// $cash_tr_code    = $_POST["cash_tr_code"];
// /* 기타 파라메터 추가 부분 - Start - */
// $param_opt_1    = $_POST["param_opt_1"]; // 기타 파라메터 추가 부분
// $param_opt_2    = $_POST["param_opt_2"]; // 기타 파라메터 추가 부분
// $param_opt_3    = $_POST["param_opt_3"]; // 기타 파라메터 추가 부분
// /* 기타 파라메터 추가 부분 - End -   */

// $tablet_size     = "1.0"; // 화면 사이즈 고정
// $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

?>

<!--결제 관련 css ldh 추가 2022-04-20-->
<!-- <link href="./plugin/php_kcp_api_pay_sample/static/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/> -->
<style>
/*2022-05-12 ldh 추가*/
/*.double_btn {*/
/*	margin-right:10px;*/
/*}*/
/*.mb_double_btn {*/
/*	margin-bottom:10px;*/
/*}*/
.promote_code2 {
    margin-top: 10px;
}

.table_wrap {
    overflow-y: hidden;
}

.detail_table td:after {
    width: calc(102% - 24px);
}
</style>
<script type="text/javascript">
/****************************************************************/
/* m_Completepayment  설명                                      */
/****************************************************************/
/* 인증완료시 재귀 함수                                         */
/* 해당 함수명은 절대 변경하면 안됩니다.                        */
/* 해당 함수의 위치는 payplus.js 보다먼저 선언되어여 합니다.    */
/* Web 방식의 경우 리턴 값이 form 으로 넘어옴                   */
/****************************************************************/
function m_Completepayment(FormOrJson, closeEvent) {
    var frm = document.order_info;

    /********************************************************************/
    /* FormOrJson은 가맹점 임의 활용 금지                               */
    /* frm 값에 FormOrJson 값이 설정 됨 frm 값으로 활용 하셔야 됩니다.  */
    /* FormOrJson 값을 활용 하시려면 기술지원팀으로 문의바랍니다.       */
    /********************************************************************/
    GetField(frm, FormOrJson);


    if (frm.res_cd.value == "0000") {
        //alert("결제 승인 요청 전,\n\n반드시 결제창에서 고객님이 결제 인증 완료 후\n\n리턴 받은 ordr_chk 와 업체 측 주문정보를\n\n다시 한번 검증 후 결제 승인 요청하시기 바랍니다."); //업체 연동 시 필수 확인 사항.
        /*
        					 가맹점 리턴값 처리 영역
        */

        frm.submit();
    } else {
        alert("[" + frm.res_cd.value + "] " + frm.res_msg.value);

        closeEvent();
    }
}
</script>
<!-- 23.06.07 HUBDNC_LSH 변경 PG사 정보 -->
<!--테스트 JS-->
<!-- <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script> -->
<!--운영 JS>-->
<script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8">
</script>
<script type="text/javascript">
// 23.06.07 HUBDNC_LSH 변경 PG사 결제버튼 스크립트 (PC)
function paybtn() {
    INIStdPay.pay('SendPayForm_id');
}

// 23.06.07 HUBDNC_LSH 변경 PG사 결제버튼 스크립트 (MOBILE)
function on_pay() {

    let payment_methods = parseInt($("input[name=payment_methods]:checked").val());

    // payment methods 선택에 따라 모바일 P_INI_PAYMENT(지불방식) 변경
    if (payment_methods == 0) {
        $('input[name="P_INI_PAYMENT"]').val("CARD");
    } else if (payment_methods == 1) {
        $('input[name="P_INI_PAYMENT"]').val("BANK");
    }

    myform = document.mobileweb;
    myform.action = "https://mobile.inicis.com/smart/payment/";
    myform.target = "_self";
    myform.submit();

}
</script>
<!--
		결제창 호출 JS
		 개발 : https://testpay.kcp.co.kr/plugin/payplus_web.jsp
		 운영 : https://pay.kcp.co.kr/plugin/payplus_web.jsp
-->
<!--  <script type="text/javascript" src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"></script> -->
<script type="text/javascript" src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"></script>
<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="./plugin/NHNKCP/mobile_sample/js/approval_key.js?v=0.2"></script>

<section class="container submit_application payment">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Registration</h2>
                <div class="color-bar"></div>
            </div>
        </div>
    </div>
    <form name="order_info" method="post" action="./plugin/NHNKCP/sample/pp_cli_hub.php">
        <div class="inner bottom_short">
            <div class="input_area">
                <!-- content 1 -->
                <div class="circle_title"><?= $locale("registration_info_tit") ?></div>
                <div class="details">
                    <p><?= $locale("registration_info_txt") ?></p>
                </div>
                <div class="table_wrap">
                    <table class="table detail_table">
                        <colgroup>
                            <col class="col_th">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th><?= $locale("id") ?></th>
                                <td><?= $email ?></td>
                                <input type="hidden" name="buyr_mail" value="<?= $email ?>" />
                            </tr>
                            <tr>
                                <th>Name(Eng)</th>
                                <td><?= $first_name ?> <?= $last_name ?></td>
                                <?php
                                if ($nation_no == 25) {
                                ?>
                                <!--여기 혹시 모르니 주의-->
                                <input type="hidden" name="buyr_name" value="<?= $name_kor; ?>" />
                                <?php
                                } else {
                                ?>
                                <input type="hidden" name="buyr_name" value="<?= $first_name ?> <?= $last_name ?>" />
                                <?php
                                }
                                ?>

                            </tr>
                            <?php
                            if ($nation_no == 25) {
                            ?>
                            <tr>
                                <th>Name(Kor)</th>
                                <td><?= $name_kor; ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <th><?= $locale("country") ?></th>
                                <td><?= $nation ?></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td><?= $member_type; ?></td>
                            </tr>
                            <tr>
                                <th>Others</th>
                                <!-- <td>
                                    Welcome Reception (17:10-20:00, 23 Nov (Thu), 2023): <?= $welcome_reception_yn ?>
                                    </br>
                                    Day 1 - Luncheon Symposium (12:00-12:50, 23 Nov (Thu), 2023):
                                    <?= $day1_luncheon_yn ?> </br>
                                    Day 2 - Breakfast Symposium (08:00-09:00, 24 Nov (Fri), 2023):
                                    <?= $day2_breakfast_yn ?> </br>
                                    Day 2 - Luncheon Symposium (12:00-12:50, 24 Nov (Fri), 2023):
                                    <?= $day2_luncheon_yn ?> </br>
                                    Day 3 - Breakfast Symposium (08:00-09:00, 25 Nov (Sat), 2023):
                                    <?= $day3_breakfast_yn ?> </br>
                                    Day 3 - Luncheon Symposium (12:05-12:55, 25 Nov (Sat), 2023):
                                    <?= $day3_luncheon_yn ?> </br>
                                </td> -->
                                <td>
                                    Welcome Reception (23 Nov (Thu), 2023): <?= $welcome_reception_yn ?>
                                    </br>
                                    Day 1 - Luncheon Symposium (23 Nov (Thu), 2023):
                                    <?= $day1_luncheon_yn ?> </br>
                                    Day 2 - Breakfast Symposium (24 Nov (Fri), 2023):
                                    <?= $day2_breakfast_yn ?> </br>
                                    Day 2 - Luncheon Symposium (24 Nov (Fri), 2023):
                                    <?= $day2_luncheon_yn ?> </br>
                                    Day 3 - Breakfast Symposium (25 Nov (Sat), 2023):
                                    <?= $day3_breakfast_yn ?> </br>
                                    Day 3 - Luncheon Symposium (25 Nov (Sat), 2023):
                                    <?= $day3_luncheon_yn ?> </br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    if ($nation_no == 25) {
                                    ?>
                                    <p class="bold">ISCP 2023 개최 정보를 어떻게 알게 되셨나요?</p>
                                    </br>
                                    <?php
                                    } else {
                                    ?>
                                    <p class="bold">How did you hear about the ISCP 2023?</p>
                                    </br>

                                    <?php
                                    }
                                    echo $register_path_value;
                                    ?>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table_wrap form_types">
                    <div class="circle_title">Payment</div>
                    <table class="table detail_table">
                        <colgroup>
                            <col class="col_th">
                            <col width="*">
                        </colgroup>
                        <tbody>


                            <tr>
                                <th class="red_txt bold">Total registration fee</th>
                                <td class="red_txt bold">
                                    <?= (($nation_no != 25) ? $price_name . " " . number_format($price) : number_format($price) . "" . $price_name) ?>
                                </td>
                            </tr>
                            <?php
                            if ($promotion_code != 0) {
                            ?>
                            <tr>
                                <th>Payment methods</th>
                                <td>
                                    <div class="radio_wrap">
                                        <ul class="flex">
                                            <li>
                                                <input <?= $payment_methods_select == 0 ? "checked" : ""; ?>
                                                    type="radio" class="radio required" id="pay_type1"
                                                    name="payment_methods" value="0">
                                                <label
                                                    for="pay_type1"><?= ($nation_no != 25) ? "Credit Card" : "카드 결제"; ?></label>
                                            </li>
                                            <li>
                                                <input <?= $payment_methods_select == 1 ? "checked" : ""; ?>
                                                    type="radio" class="radio required" id="pay_type2"
                                                    name="payment_methods" value="1">
                                                <label
                                                    for="pay_type2"><?= ($nation_no != 25) ? "Bank Transfer" : "계좌 이체"; ?></label>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <!-- content 2 -->
                <!-- <div class="details"> -->
                <!-- 	<p><?= $locale("total_price") ?> <span class="point_txt s_bold"><?= (($nation_no != 25) ? $price_name . " " . number_format($price) : number_format($price) . "" . $price_name) ?></span></p> -->
                <!-- </div> -->
                <div class="details">
                    <p><?= $locale("cancellation_tit") ?> <a href="javascript:;" class="red_txt cancel_btn">Details
                            &gt;</a></p>
                </div>
                <!-- btn_wrap -->
                <!-- 기존 버튼 마크업
				<div class="btn_wrap">
					<button type="button" class="btn submit" onclick="kgpay();"><?= $locale("d_payment_btn") ?></button>
					<?php if ($_SESSION["language"] != "ko") { ?>
						<button type="button" class="btn submit" onclick="payment();"><?= $locale("payment_btn") ?></button>
					<?php } ?>
				</div>-->
                <!-- 220324 기존에는 결제방식이 '국내/해외'로 분리되었으나, 현재는 1개의 버튼으로 통일됨 (HUBDNC LJH2)-->

                <!--  23.06.0 HUBDNC_LSH PC 결제버튼 기능   -->
                <div class="pager_btn_wrap pc_only centerT pager_btn_wrap half">
                    <button type="button" class="btn green_btn pc-wd-3"
                        onclick="prev(<?= $registration_idx; ?>)">Prev</button>

                    <?php
                    if ($payment_methods_select == 0) {
                        if ($nation_no == 25) {
                            //100% 할인
                    ?>
                    <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="paybtn()">
                        Payment
                    </button>
                    <?php
                        } else {
                        ?>
                    <!-- 기존 : jsf__pay(document.order_info) / 테스트 변경 : paybtn() )  -->
                    <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="payment()">
                        Payment
                    </button>
                    <?php
                        }
                    } else {
                        if ($nation_no == 25) {
                        ?>
                    <!-- 기존 : code_100() / 테스트 변경 : paybtn() )  -->
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3"
                        onclick="transfer(<?= $nation_no; ?>)">
                        Payment
                    </button>
                    <?php
                        } else {
                        ?>
                    <!-- 기존 : transfer() / 테스트 변경 : paybtn() )  -->
                    <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3"
                        onclick="transfer(<?= $nation_no; ?>)">
                        Payment
                    </button>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!--  23.06.0 HUBDNC_LSH 모바일 결제버튼 기능          -->
                <div class=" pager_btn_wrap mb_only centerT pager_btn_wrap half">
                    <button type="button" class="btn green_btn pc-wd-3"
                        onclick="prev(<?= $registration_idx; ?>)">Prev</button>
                    <?php
                    if ($payment_methods_select == 0) {
                        if ($nation_no == 25) {
                    ?>
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="on_pay()">
                        Payment
                    </button>
                    <?php
                        } else {
                        ?>
                    <!-- 기존 : mb_click() / 테스트 변경 : paybtn() )  -->
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="payment()">
                        Payment
                    </button>
                    <?php

                        }
                    } else {
                        if ($nation_no == 25) {
                        ?>
                    <!-- 기존 : code_100() / 테스트 변경 : paybtn() )  -->
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3"
                        onclick="transfer(<?= $nation_no; ?>)">
                        Payment
                    </button>
                    <?php
                        } else {
                        ?>
                    <!-- 기존 : transfer() / 테스트 변경 : paybtn() )  -->
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3"
                        onclick="transfer(<?= $nation_no; ?>)">
                        Payment
                    </button>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>

    <!-- 23.06.07 HUBDNC_LSH 변경 후 PG사 파라미터 전송 form (PC)-->
    <form id="SendPayForm_id" method="post" class="mt-5" accept-charset="UTF-8">
        <!-- 필수 -->
        <input type="hidden" name="version" value="1.0">
        <input type="hidden" name="mid" value="<?= $mid ?>">
        <input type="hidden" name="goodname" value="ISCP 2023">
        <input type="hidden" name="oid" value="<?= $order_code ?>">
        <input type="hidden" name="price" value="<?= $price ?>">
        <input type="hidden" name="currency" value="WON">
        <input type="hidden" name="buyername" value="<?= $name_kor ?>">
        <input type="hidden" name="buyertel" value="<?= $phone ?>">
        <input type="hidden" name="buyeremail" value="<?= $email ?>">
        <input type="hidden" name="timestamp" value="<?= $timestamp ?>">
        <input type="hidden" name="signature" value="<?= $sign ?>">
        <input type="hidden" name="returnUrl" value="https://iscp2023.org/main/plugin/KG_INICIS/result.php">
        <input type="hidden" name="closeUrl" value="https://iscp2023.org/main/plugin/KG_INICIS/close.php">
        <input type="hidden" name="mKey" value="<?= $mKey ?>">
        <input type="hidden" name="charset" value="UTF-8">
        <!-- 기본옵션 -->
        <input type="hidden" name="gopaymethod" value="Card">
        <!--결제수단-->

        <input type="hidden" name="acceptmethod" value="HPP(1):below1000:centerCd(Y)">
        <input type="hidden" name="use_chkfake" value="<?= $use_chkfake ?>">
        <input type="hidden" name="verification" value="<?= $sign2 ?>">

    </form>

    <!-- 23.06.07 HUBDNC_LSH 변경 후 PG사 파라미터 전송 form (MOBILE)-->
    <form name="mobileweb" id="" method="post" class="mt-5" accept-charset="euc-kr">
        <input type="hidden" name="P_INI_PAYMENT" value="">
        <input type="hidden" name="P_MID" value="<?= $mid ?>">
        <input type="hidden" name="P_OID" value="<?= $order_code ?>">
        <input type="hidden" name="P_AMT" value="<?= $price ?>">
        <input type="hidden" name="P_GOODS" value="ISCP 2023">
        <input type="hidden" name="P_UNAME" value="<?= $name_kor ?>">
        <input type="hidden" name="P_MOBILE" value="<?= $phone ?>">
        <input type="hidden" name="P_EMAIL" value="<?= $email ?>">
        <input type="hidden" name="P_CHARSET" value="utf8">
        <input type="hidden" name="P_RESERVED" value="below1000=Y&vbank_receipt=Y&centerCd=Y">
        <input type="hidden" name="P_NEXT_URL" value="https://iscp2023.org/main/plugin/KG_INICIS/mo_result.php">
    </form>



    <!-- 엑심베이 결제 -->
    <form class="form-horizontal" name="regForm" method="post"
        action="https://iscp2023.org/main/plugin/eximbay/request.php">
        <!-- 결제에 필요 한 필수 파라미터 -->
        <input type="hidden" name="ver" value="230" /><!-- 연동 버전 -->
        <input type="hidden" name="txntype" value="PAYMENT" /><!-- 거래 타입 -->
        <input type="hidden" name="charset" value="UTF-8" /><!-- 고정 : UTF-8 -->

        <!-- statusurl(필수 값) : 결제 완료 시 Back-end 방식으로 Eximbay 서버에서 statusurl에 지정된 가맹점 페이지를 Back-end로 호출하여 파라미터를 전송 -->
        <!-- 스크립트, 쿠키, 세션 사용 불가 -->
        <input type="hidden" name="statusurl" value="https://iscp2023.org/main/plugin/eximbay/status.php" />
        <input type="hidden" name="returnurl" value="https://iscp2023.org/main/plugin/eximbay/return.php" />

        <!--결제 완료 시 Front-end 방식으로 사용자 브라우저 상에 호출되어 보여질 가맹점 페이지 -->

        <!-- 결제 응답 값 처리 파라미터 -->
        <input type="hidden" name="rescode" />
        <input type="hidden" name="resmsg" />

        <!-- 테스트용 -->
        <!--<input type="hidden" name="mid" value="1849705C64">-->
        <!-- 실서버 -->
        <input type="hidden" name="mid" value="189A6E05E4">
        <input type="hidden" name="ref" value="<?= $order_code ?>">
        <input type="hidden" name="ostype" value="P">
        <input type="hidden" name="displaytype" value="P">
        <input type="hidden" name="email" value="<?= $email ?>">
        <input type="hidden" name="buyer" value="<?= $name ?>">
        <input type="hidden" name="tel" value="<?= $phone ?>">
        <input type="hidden" name="item_0_product" value="ISCP 2023">
        <input type="hidden" name="item_0_quantity" value="1">
        <!-- 실서버 -->
        <input type="hidden" name="item_0_unitPrice" value="<?= $us_price ?>">
        <!-- 테스트용 -->
        <!-- <input type="hidden" name="item_0_unitPrice" value="5"> -->

        <input type="hidden" name="lang" value="<?= $language == "ko" ? "KR" : "EN" ?>">
        <input type="hidden" name="cur" value="USD">
        <!-- 실서버 -->
        <input type="hidden" name="amt" value="<?= $us_price ?>">
        <!-- 테스트용 -->
        <!-- <input type="hidden" name="amt" value="5"> -->
        <!-- union pay -->
        <!-- <input type="hidden" name="paymethod" value="P000"> -->
    </form>
</section>
<script src="./js/script/client/registration.js"></script>
<div class="popup cancel_pop">
    <div class="pop_bg"></div>
    <div class="pop_contents">
        <button type="button" class="pop_close"><img src="./img/icons/pop_close.png"></button>
        <h3 class="pop_title"><?= $locale("cancellation_tit") ?></h3>
        <p class="pre"><?= $locale("cancellation_txt") ?></p>
        <div class="table_wrap c_table_wrap2">
            <table class="c_table2">
                <thead>
                    <tr>
                        <th><?= $locale("date") ?></th>
                        <th><?= $locale("cancellation_table_category2") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $locale("cancellation_table_data1") ?></td>
                        <td><?= $locale("cancellation_table_data1_1") ?></td>
                    </tr>
                    <tr>
                        <td><?= $locale("cancellation_table_data2") ?></td>
                        <td><?= $locale("cancellation_table_data2_1") ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
<script src="./js/script/client/registration.js"></script>
<script>
function prev(idx) {
    window.location.replace("registration.php?idx=" + idx);
}

/* 23.06.07 HUBDNC_LSH 기존 작성된 부분 주석 처리 */

$('.cancel_btn').on('click', function() {
    $('.cancel_pop').show();
});

function move() {
    location.replace('/main/registration3.php')
}

function error() {
    setTimeout(function() {
        var error_msg = $("input[name=resmsg]").val();
        alert(locale(language.value)("payment_fail_msg") + " " + locale(language.value)("retry_msg") + "\n" +
            error_msg);
    }, 50)
}

function mb_click() {

    //ajax_save();

    document.getElementById("mb_submit").click();
    //kcp_AJAX();
}


/* 23.06.07 HUBDNC_LSH 기존 작성된 부분 주석 처리 */
$(document).on("change", "input[name=payment_methods]", function() {
    var promotion_code = "<?php //= $promotion_code; 
                                ?>//";
    if ($(this).val() == 0) {
        $("#pc_payment_btn").removeAttr("onclick");
        $("#mb_payment_btn").removeAttr("onclick");

        if (promotion_code == 0) {
            $("#pc_payment_btn").attr("onclick", "code_100()");
            $("#mb_payment_btn").attr("onclick", "code_100()");
        } else {
            // $("#pc_payment_btn").attr("onclick", "jsf__pay(document.order_info);");
            $("#mb_payment_btn").attr("onclick", "mb_click()");
        }
    } else {
        $("#pc_payment_btn").removeAttr("onclick");
        $("#mb_payment_btn").removeAttr("onclick");

        if (promotion_code == 0) {
            $("#pc_payment_btn").attr("onclick", "code_100()");
            $("#mb_payment_btn").attr("onclick", "code_100()");
        } else {
            $("#pc_payment_btn").attr("onclick", "transfer();");
            $("#mb_payment_btn").attr("onclick", "transfer();");
        }
    }
});

function transfer(nation_no) {

    // var registration_idx = "<?php $registration_idx; ?>";
    var registration_idx = window.location.search.split("=")[1];
    var payment_methods = $("input[name=payment_methods]:checked").val();
    // console.log(nation_no)
    // console.log(registration_idx)
    // ajax_save();
    window.location.replace(PATH + "registration_account.php?idx=" + registration_idx + "&nation_no=" + nation_no);
    // window.location.replace(PATH + "registration_account.php");
}
</script>

<?php include_once('./include/footer.php'); ?>