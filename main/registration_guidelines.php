<?php
include_once('./include/head.php');
include_once('./include/header.php');
?>



<?php
$sql_event =    "SELECT
						period_event_start,
						period_event_end,
						period_event_pre_end
					FROM info_event AS ie";
$event = sql_fetch($sql_event);

$sql_registration =    "SELECT
							bank_name_" . $language . " AS bank_name,
							account_number_" . $language . " AS account_number,
							account_holder_" . $language . " AS account_holder,
							address_" . $language . " AS `address`,
							CONCAT(fi_pop.path, '/', fi_pop.save_name) AS fi_pop_url
						FROM info_registration AS ir
						LEFT JOIN `file` AS fi_pop
							ON fi_pop.idx = ir.score_pop_" . $language . "_img";
$registration = sql_fetch($sql_registration);

$sql_price =    "SELECT
						type_en, 
						off_member_usd, off_guest_usd, on_member_usd, on_guest_usd, 
						off_member_krw, off_guest_krw, on_member_krw, on_guest_krw
					FROM info_event_price
					WHERE is_deleted = 'N'
					ORDER BY off_member_usd DESC, off_guest_usd DESC, on_member_usd DESC, on_guest_usd DESC";
$price = get_data($sql_price);
?>

<style>
    /*th {border-width:1px !important;}*/
    /*.detail_table td:after {display:none;}*/
</style>



<section class="container registration registration_guidelines top_btn_move">
    <!-- location -->
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Guidelines</h2>

            </div>
        </div>
    </div>
    <!-- contents-->
    <div class="inner">
        <ul class="tab_pager location tab_pager_small">
            <li class="on"><a href="./registration_guidelines.php">Overseas</a></li>
            <li><a href="./registration_guidelines_kor.php">Domestic</a></li>
        </ul>
        <div class="section section1">
            <!-- 1. 등록 마감일 start -->
            <div class="circle_title">
                <!--<?= $locale("important_dates") ?>-->How to Register
            </div>
            <div class="details">
                <p>
                    All participants are required to register through the ISCP 2023 online registration system and are
                    advised to register in advance
                    (by October 27, 2023). Please read the following registration guidelines carefully.

                </p>
                <br>
                <ul class="submission_keydate">
                    <!-- <li>Registration Open: <span>Early June, 2022</span></li> -->
                    <!-- <li>
                        Deadline for Early Registration:
                        <span> -->
                    <!--
					 <?php
                        $date_start = date_create($event['period_event_start']);
                        $date_end = date_create($event['period_event_end']);

                        $format_start = "F d";
                        $format_end = "d, Y";

                        if (date_format($date_start, 'Y') != date_format($date_end, 'Y')) {
                            $format_start = "F d, Y";
                            $format_end = "F d, Y";
                        } else if (date_format($date_start, 'F') != date_format($date_end, 'F')) {
                            $format_end = "F d, Y";
                        }

                        echo date_format($date_start, $format_start) . "~" . date_format($date_end, $format_end);
                        ?> -->

                    <!-- July 27 (Wed), 2022
                        </span> -->
                    </li>
                    <li>
                        <?= $locale("important_date2_tit") ?>:
                        <span>
                            <!--<?= date_format(date_create($event['period_event_pre_end']), 'F d, Y') ?>-->
                            October 27 (Fri), 2023
                        </span>
                    </li>
                </ul>
            </div>
            <!---->

            <!-- 1. 등록 마감일 end -->

            <!-- 2. 등록비 / Registration start -->
            <?php
            if (count($price) > 0) {
                $tb_arr = array();
                $i = -1;
                $off_mb = 0;
                $off_gt = 0;
                $on_mb = 0;
                $on_gt = 0;

                $unit = $language == "en" ? "usd" : "krw";
                $unit_upper = strtoupper($unit);

                $off_mb_col = 'off_member_' . $unit;
                $off_gu_col = 'off_guest_' . $unit;
                $on_mb_col = 'on_member_' . $unit;
                $on_gu_col = 'on_guest_' . $unit;

                foreach ($price as $pr) {
                    if (
                        $off_mb != $pr[$off_mb_col]
                        || $off_gt != $pr[$off_gu_col]
                        || $on_mb != $pr[$on_mb_col]
                        || $on_gt != $pr[$on_gu_col]
                    ) {
                        $i++;
                        $off_mb = $pr[$off_mb_col];
                        $off_gt = $pr[$off_gu_col];
                        $on_mb = $pr[$on_mb_col];
                        $on_gt = $pr[$on_gu_col];

                        $tb_arr[$i] = $pr;
                        unset($tb_arr[$i]['type_en']);
                        $tb_arr[$i]['type_arr'] = array();
                    }

                    array_push($tb_arr[$i]['type_arr'], $pr['type_en']);
                }
            ?>
                <div class="circle_title">
                    <!--<?= $locale("air_registration_tit") ?>-->Registration Fees
                </div>
                <div class="details table_wrap icomes_air">
                    <!-- 기존 개발소스
				<table class="table detail_table">
					<colgroup>
						<col width="40%">
						<col width="30%">
						<col width="30%">
					</colgroup>
					<thead>
						<tr>
							<th rowspan="3">Category</th>
							<th colspan="2">icomes-AIR</th>
						</tr>
						<tr>
							<th rowspan="2"><?= $locale("registration_category") ?></th>
							<th colspan="3"><?= $locale("offline") ?> / <?= $locale("online") ?></th>
						</tr>
						<tr>
							<th><?= $locale("member") ?></th>
							<th><?= $locale("non_member") ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
                        foreach ($tb_arr as $tb) {
                        ?>
						<tr>
							<td><?= implode(', ', $tb['type_arr']) ?></td>
						<?php
                            if ($tb[$off_mb_col] + $tb[$off_gu_col] + $tb[$on_mb_col] + $tb[$on_gu_col] <= 0) {
                        ?>
							<td colspan="2">free</td>
						<?php
                            } else {
                        ?>
							<td><?= $unit_upper . " " . number_format($tb[$off_mb_col]) . " / " . $unit_upper . " " . number_format($tb[$off_gu_col]) ?></td>
							<td><?= $unit_upper . " " . number_format($tb[$on_mb_col]) . " / " . $unit_upper . " " . number_format($tb[$on_gu_col]) ?></td>
						<?php
                            }
                        ?>
						</tr>
						<?php
                        }
                        ?>
					</tbody>
				</table>-->
                    <table class="table left_border_table table_responsive">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <!-- <th>Early Registration</th> -->
                                <th>Pre-registration</th>
                                <th>On-site Registration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Specialist, Professor</td>
                                <td>USD 200</td>
                                <td>USD 300</td>
                                <!-- <td>USD 400</td> -->
                            </tr>
                            <tr>
                                <td>Fellow, Resident, Researcher,<br>Student, Nurses, Nutritionists,
                                    Pharmacists,<br />Corporate member</td>
                                <td>USD 100</td>
                                <td>USD 150</td>
                                <!-- <td>USD 200</td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
            <!-- 2. 등록비 / Registration end -->

            <!-- 3. 결제방법 / Payment Method start -->
            <div class="circle_title"><?= $locale("payment_method_tit") ?></div>
            <div class="details payment_detail">
                <!-- <p><?= $locale("payment_method_txt") ?></p> -->
                <!-- 1 -->
                <p class="details_title pt0">* <?= $locale("payment_card_tit") ?></p>
                <ul class="text_indent">
                    <li>• Payment by credit card is available only through the online registration system.</li>
                    <li>• The actual debit amount is subject to change according to the exchange rate.</li>
                    <li>• All credit card service charges are to be paid by registrants.</li>
                    <li>• <b>VISA, MASTER and JCB cards are accepted.</b></li>
                    <li>• If you are not able to charge the pre-registration fee to your credit card, please contact the
                        ISCP 2023 Secretariat.</li>
                </ul>
                <div class="payment_wrap">
                    <!-- <img src="./img/sample/credit_card.jpg" alt="credit_card_img"> -->
                    <div class="img_wrap">
                        <img src="./img/sample/credit_card_eng.png" alt="credit_card_img">
                    </div>
                </div>
                <!-- 2 -->
                <p class="details_title">* <?= $locale("payment_bank_tit") ?></p>
                <ul class="text_indent">
                    <!--
					<li>- <?= $locale("payment_bank_txt1") ?></li>
					<li>- <?= $locale("payment_bank_txt2") ?></li>
					<li>- <?= $locale("payment_bank_txt3") ?></li>-->
                    <li>• All bank remittance charges are to be paid by the registrant.</li>
                    <li>• The sender’s name should be the same as the registrant’s name.</li>
                    <li>• Please send a copy of the wire transfer slip to the Secretariat by e-mail
                        (iscp@into-on.com) after writing the registrant’s name on the bank remittance receipt.
                    </li>
                    <li>• Appropriate payment should be completed within the proper registration period.<br>If you pay
                        after the registration period, you will need to pay the corresponding additional fees.</li>
                </ul>
                <div class="table_wrap">
                    <table class="table">
                        <!--detail_table-->
                        <colgroup>
                            <col class="col_th">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th><?= $locale("payment_bank_name_tit") ?></th>
                                <td>
                                    <!--<?= $registration['bank_name'] ?>-->WOORI BANK

                                </td>
                            </tr>
                            <tr>
                                <th><?= $locale("payment_account_number_tit") ?></th>
                                <td>
                                    <!--<?= $registration['account_number'] ?>-->1005-803-441694
                                </td>
                            </tr>
                            <tr>
                                <th><?= $locale("payment_account_holder_tit") ?></th>
                                <td>
                                    <!--<?= $registration['account_holder'] ?>-->Korean Society of Cardiovascular
                                    Pharmacotherapy

                                </td>
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
                                <td>1585, Sangam-dong, Mapo-gu, Seoul, Korea
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 3. 결제방법 / Payment Method end -->

            <!-- 4. 등록취소 및 환불정책 / Cancellation start -->
            <div class="circle_title">
                <!--<?= $locale("cancellation_tit") ?>--> Cancellation & Refund Policy
            </div>
            <div class="details">
                <ul class="text_indent">
                    <!-- <li><?= $locale("cancellation_txt") ?></li> -->
                    <li>• The Secretariat must be notified in writing via e-mail (iscp@into-on.com) of any
                        cancellations.</li>
                    <li>• All refunds will be made after the conference.</li>
                    <li>• All bank service charges and all administration fees will be deducted from all congress
                        registration refunds.</li>
                    <li>• Please refer to the following cutoff dates for cancellation.</li>
                </ul>
                <br>
                <div class="table_wrap cancel_details">
                    <table class="table centerT left_border_table">
                        <thead>
                            <tr>
                                <th><?= $locale("date") ?></th>
                                <th><?= $locale("cancellation_table_category2") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 기존 개발소스
							<tr>
								<td><?= $locale("cancellation_table_data1") ?></td>
								<td><?= $locale("cancellation_table_data1_1") ?></td>
							</tr>
							<tr>
								<td><?= $locale("cancellation_table_data2") ?></td>
								<td><?= $locale("cancellation_table_data2_1") ?></td>
							</tr>
							-->
                            <tr>
                                <td>By September 30(Sat), 2023
                                </td>
                                <td>100% refund
                                </td>
                            </tr>
                            <tr>
                                <td>From October 1(Sun), 2023
                                </td>
                                <td>No refund
                                </td>
                            </tr>
                            <!-- <tr>
                                <td>As of August 27(Sat), 2022</td>
                                <td>No refund</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 4. 등록취소 및 환불정책 / Cancellation end -->
        </div>
    </div>
</section>
<?php

?>
<!-- 22.04.11 기존버튼 
<button type="button" class="fixed_btn" onclick="window.location.href='./registration.php';"><?= $locale("registration") ?></button>-->
<!-- 22.04.11 변경버튼 / 22.04.14 등록 오픈 전까지 주석처리 -->
<button type="button" class="btn_fixed_triangle fixed_btn_pc" onClick="location.href='./registration.php'"><span><?= $locale("registration") ?></span></button>

<?php include_once('./include/footer.php'); ?>