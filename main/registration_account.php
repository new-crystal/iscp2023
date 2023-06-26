<?php
include_once('./include/head.php');
include_once('./include/header.php');

$nation_no = $_GET["nation_no"] ?? null;

$sql_during =    "SELECT
						IF(DATE(NOW()) BETWEEN period_event_pre_start AND period_event_pre_end, 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

if ($during_yn !== "Y") {
?>

<section class="container submit_application registration_closed">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Registration</h2>
                <ul class="clearfix">
                    <li>Home</li>
                    <li>Registration</li>
                    <li>Payment</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner coming">
        <div class="sub_banner">
            <h5>Pre-Registration<br>has been closed</h5>
        </div>
    </div>
</section>


<?php
} else {
    $member_idx = $_SESSION['USER']['idx'];

    $registration_idx = $_GET["idx"];

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
											AND register = '{$member_idx}'
										";


    $registration_data = sql_fetch($select_registration_query);

    if (!is_array($registration_data)) {
        //echo "<script>alert('Undefined registration number!'); window.location.replace('./registration.php');</script>";
        //exit;
    }

    //2022-05-16 추가
    $promotion_code = isset($registration_data["promotion_code"]) ? $registration_data["promotion_code"] : -1;
    // 데이터
    $attendance_type = isset($registration_data["attendance_type"]) ? $registration_data["attendance_type"] : "-";
    $attendance_type = ($attendance_type == 0 ? "Offline" : ($attendance_type == 1 ? "Online" : ($attendance_type == 2 ? "Online+Offline" : "-")));
    $member_status = isset($registration_data["member_status"]) ? $registration_data["member_status"] : "-";

    $price_col_name = "";
    $price_col_name .= ($attendance_type == 0) ? "off_" : "on_";
    $price_col_name .= ($registration_data["member_status"] == 0) ? "guest_" : "member_";
    //$price_col_name .= "usd";

    if ($language == "en") {
        $price_col_name .= "usd";
        $cur = "USD";
        $name = $first_name . " " . $last_name;
    } else {
        $price_col_name .= "krw";
        $cur = "KRW";
        $name = $last_name . " " . $first_name;
    }

    $payment_methods    = isset($registration_data["payment_methods"]) ? $registration_data["payment_methods"] : "-";
    $nation_no            = isset($registration_data["nation_no"]) ? $registration_data["nation_no"] : "-";
    $member_status        = $member_status == 1 ? $locale("member") : $locale("non_member");
    $applied_review        = isset($registration_data["is_score"]) ? $registration_data["is_score"] : "-";
    $is_score            = $applied_review == 0 ? "NO" : ($applied_review == 1 ? "YES" : "-");
    $email                = isset($registration_data["email"]) ? $registration_data["email"] : "-";
    $nation                = isset($registration_data["nation_en"]) ? $registration_data["nation_en"] : "-";
    $first_name            = isset($registration_data["first_name"]) ? $registration_data["first_name"] : "-";
    $last_name            = isset($registration_data["last_name"]) ? $registration_data["last_name"] : "-";
    $name_kor            = isset($registration_data["name_kor"]) ? $registration_data["name_kor"] : "-";
    $phone                = isset($registration_data["phone"]) ? $registration_data["phone"] : "-";
    $registration_type    = isset($registration_data["registration_type"]) ? $registration_data["registration_type"] : "-";
    $registration_type    = $registration_type == 0 ? $locale("registration_type_select1") : ($registration_type == 1 ? $locale("registration_type_select2") : $locale("registration_type_select3"));
    $affiliation        = isset($registration_data["affiliation"]) ? $registration_data["affiliation"] : "-";
    $department            = isset($registration_data["department"]) ? $registration_data["department"] : "-";
    $licence_number        = isset($registration_data["licence_number"]) ? $registration_data["licence_number"] : "-";
    $academy_number        = isset($registration_data["academy_number"]) ? $registration_data["academy_number"] : "-";
    $register_path        = isset($registration_data["register_path"]) ? $registration_data["register_path"] : "-";
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

    //금액 변환
    //$us_price = "1";
    //$ko_price = "1000";
    $us_price = $registration_data["price"];

    $sql_during =    "SELECT
							IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
						FROM info_event";
    $r_during_yn = sql_fetch($sql_during)['yn'];

    if ($list['idx'] == 467 || $list['idx'] == 330) {
        $rr_during_yn = 'N';
    }

    if (!empty($_SESSION["USER"])) {
        $ksola_member_status = $member['ksola_member_status'];
    } else {
        echo "<script>alert('Need to login'); window.location.replace(PATH+'login.php');</script>";
        exit;
    }

    if ($r_during_yn == 'Y') {
        if ($us_price == 250) {
            $us_price = 200;
        } else if ($us_price == 150) {
            $us_price = 100;
        } else if ($us_price == 80000) {
            $us_price = 50000;
        } else if ($us_price == 100000 && $ksola_member_status == 0) {
            $us_price = 50000;
        } else if ($us_price == 50000) {
            $us_price = 10000;
        } else if ($us_price == 60000) {
            $us_price = 10000;
        }
    }

    $ko_price = $us_price;

    $price = $us_price;
    $price_eyes = $price;
    $price_name = ($nation_no == 25) ? "원" : "USD";

    if ($nation_no != 25) {
        $price_eyes = $price;
        //$price = $price * 100;
    }
    // if ($promotion_code == 0 && $promotion_code != "") {
    //     $price_eyes = 0;
    //$price = 0;
    // } else if ($promotion_code == 1 || $promotion_code == 2) {
    //     $price_eyes = $price_eyes / 2;
    //$price = $price / 2;
    // }

    if ($nation_no == 25) {
    ?>
<!-- 변경 한국 마크업 -->
<section class="container submit_application register">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Registration</h2>
                <ul class="clearfix">
                    <li>Home</li>
                    <li>Registration</li>
                    <li>Payment</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <div class="account_div">
            <div class="circle_title">계좌이체</div>
            <ul class="text_indent">
                <li>등록비 입금 시 등록자 명으로 입금해주시기 바랍니다.<br />다른 이름 혹은 소속기관명으로 입금하실 경우 반드시 사무국 이메일(iscp@into-on.com)로 연락 바랍니다
                </li>
            </ul>
            <div class="table_wrap form_types">
                <table class="table">
                    <!--detail_table-->
                    <colgroup>
                        <col class="col_th">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th class="leftT">은행명</th>
                            <td>우리은행</td>
                        </tr>
                        <tr>
                            <th class="leftT">계좌번호</th>
                            <td>1005-803-441694</td>
                        </tr>
                        <tr>
                            <th class="leftT">예금주</th>
                            <td>대한심혈관약물치료학회(Korean Society of Cardiovascular Pharmacotherapy)</td>
                        </tr>
                        <tr>
                            <th class="leftT red_txt bold">총 등록비</th>
                            <td class="red_txt bold">
                                <?= (($nation_no == 25) ? number_format($price_eyes) . " " . $price_name : $price_name . " " . number_format($price_eyes)) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- content 2 -->
        <!-- <div class="circle_title">결제 정보</div> -->
        <!-- <div class="details"> -->
        <!-- 	<p>총 금액 <span class="point_txt s_bold"><?= ($nation_no != 25) ? $price_name . " " . number_format($price_eyes) : number_format($price_eyes) . "" . $price_name ?></span></p> -->
        <!-- </div> -->
        <div class="details">
            <p>취소 규정 <a href="javascript:;" class="red_txt cancel_btn">상세 &gt;</a></p>
        </div>
        <div class="centerT pager_btn_wrap half">
            <button type="button" class="btn green_btn" onclick="prev()">Prev</button>
            <button type="button" class="btn green_btn" onclick="move()">Complete</button>
        </div>
    </div>
</section>

<div class="popup cancel_pop">
    <div class="pop_bg"></div>
    <div class="pop_contents">
        <button type="button" class="pop_close"><img src="./img/icons/pop_close.png"></button>
        <h3 class="pop_title">등록취소 및 환불정책</h3>
        <p class="pre">등록비 환불은 대회 종료 후 이루어지며, 등록 취소 시 반드시 이메일(iscp@into-on.com)을 통하여 취소 내용을 사무국에 접수해주시기 바랍니다.
        </p>
        <div class="table_wrap c_table_wrap2">
            <table class="c_table2">
                <colgroup>
                    <col width="50%">
                    <col width="50%">
                </colgroup>
                <thead>
                    <tr class="tr_center">
                        <th>날짜</th>
                        <th>환불 금액</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr_center">
                        <td>2023년 9월 30일까지 등록 취소 시</td>
                        <td>100% 환불</td>
                    </tr>
                    <tr class="tr_center">
                        <td>2023년 10월 1일부터 등록 취소 시 시</td>
                        <td>환불 없음</td>
                    </tr>
                    <!-- <tr class="tr_center">
								<td>2022년 8월 27일부터 등록 취소 시</td>
								<td>환불 없음</td>
							</tr> -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    } else {
    ?>
<!-- 변경 영어 마크업 -->
<section class="container submit_application register">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Registration</h2>
                <ul class="clearfix">
                    <li>Home</li>
                    <li>Registration</li>
                    <li>Payment</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <div class="account_div details">
            <div class="circle_title"><?= $locale("payment_bank_tit") ?></div>
            <ul class="text_indent">
                <li>• All bank remittance charges are to be paid by the registrant.</li>
                <li>• The sender’s name should be the registrant’s name.</li>
                <li>• Please send a copy of the wire transfer slip to the secretariat by
                    e-mail(iscp@into-on.com) after writing the registrant’s name on the bank remittance
                    receipt.</li>
                <li>• Appropriate payment should be completed within the right period of registration.<br>If you pay
                    after the registration period, you will need to pay the corresponding additional fees.</li>
            </ul>
            <div class="table_wrap form_types">
                <table class="table">
                    <!--detail_table-->
                    <colgroup>
                        <col class="col_th">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th><?= $locale("payment_bank_name_tit") ?></th>
                            <td>WOORI BANK</td>
                        </tr>
                        <tr>
                            <th><?= $locale("payment_account_number_tit") ?></th>
                            <td>1005-803-441694</td>
                        </tr>
                        <tr>
                            <th><?= $locale("payment_account_holder_tit") ?></th>
                            <td>Korean Society of Cardiovascular Pharmacotherapy</td>
                        </tr>
                        <tr>
                            <th>Swift Code</th>
                            <td>HVBKKRSEXXX</td>
                        </tr>
                        <!-- <tr>
                            <th>Branch</th>
                            <td>Mapo Jungang</td>
                        </tr> -->
                        <tr>
                            <th>Bank Address</th>
                            <td>1585, Sangam-dong, Mapo-gu, Seoul, Korea</td>
                        </tr>
                        <tr>
                            <th class="red_txt bold">Total registration fee</th>
                            <td class="red_txt bold">
                                <?= (($nation_no == 25) ? $price_name . " " . number_format($price_eyes) : $price_name . " " . number_format($price_eyes)) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- content 2 -->
        <!-- <div class="circle_title"><?= $locale("payment_info_tit") ?></div> -->
        <!-- <div class="details"> -->
        <!-- 	<p><?= $locale("total_price") ?> <span class="point_txt s_bold"><?= (($nation_no == 25) ? $price_name . " " . number_format($price_eyes) : $price_name . " " . number_format($price_eyes)) ?></span></p> -->
        <!-- </div> -->
        <div class="details">
            <p><?= $locale("cancellation_tit") ?> <a href="javascript:;" class="red_txt cancel_btn">Details &gt;</a></p>
        </div>
        <div class="centerT pager_btn_wrap half">
            <button type="button" class="btn green_btn "
                onclick="prev()"><?= (($nation_no == 25) ? "이전" : "Prev") ?></button>
            <button type="button" class="btn green_btn "
                onclick="move()"><?= (($nation_no == 25) ? "완료" : "Complete") ?></button>
        </div>
    </div>
</section>

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
                    <tr>
                        <td><?= $locale("cancellation_table_data3") ?></td>
                        <td><?= $locale("cancellation_table_data3_1") ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    }
    ?>
<!-- 변경 마크업 : end -->

<!-- <script src="./js/script/client/registration.js?v=0.1"></script> -->
<script>
$('.cancel_btn').on('click', function() {
    $('.cancel_pop').show();
});

function move() {
    window.location.replace(PATH + "mypage_registration.php");
}

function prev() {
    var idx = "<?= $registration_idx; ?>";
    window.location.replace(PATH + "registration2.php?idx=" + idx);
}
</script>
<?php
}

include_once('./include/footer.php');
?>