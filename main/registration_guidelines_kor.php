<?php
include_once('./include/head.php');
include_once('./include/header.php');

$sql_event =	"SELECT
						period_event_start,
						period_event_end,
						period_event_pre_end
					FROM info_event AS ie";
$event = sql_fetch($sql_event);

$sql_registration =	"SELECT
							bank_name_" . $language . " AS bank_name,
							account_number_" . $language . " AS account_number,
							account_holder_" . $language . " AS account_holder,
							address_" . $language . " AS `address`,
							CONCAT(fi_pop.path, '/', fi_pop.save_name) AS fi_pop_url
						FROM info_registration AS ir
						LEFT JOIN `file` AS fi_pop
							ON fi_pop.idx = ir.score_pop_" . $language . "_img";
$registration = sql_fetch($sql_registration);

$sql_price =	"SELECT
						type_en, 
						off_member_usd, off_guest_usd, on_member_usd, on_guest_usd, 
						off_member_krw, off_guest_krw, on_member_krw, on_guest_krw
					FROM info_event_price
					WHERE is_deleted = 'N'
					ORDER BY off_member_usd DESC, off_guest_usd DESC, on_member_usd DESC, on_guest_usd DESC";
$price = get_data($sql_price);
?>
<section class="container registration registration_guidelines top_btn_move">
    <!-- location -->
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Guidelines</h2>
                <ul>
                    <li>Home</li>
                    <li>Registration</li>
                    <li>Guidelines</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- contents-->
    <div class="inner">
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./registration_guidelines.php">Overseas</a></li>
            <li class="on"><a href="./registration_guidelines_kor.php">Domestic</a></li>
        </ul>
        <div class="section section1">
            <!-- 1. 등록 마감일 start -->
            <div class="circle_title">
                <!--<?= $locale("important_dates") ?>-->등록 마감일
            </div>
            <div class="details">
                <ul class="submission_keydate mb50">
                    <!-- <li>사전 등록 시작일: <span>2022년 6월 초</span></li> -->
                    <!-- <li>
                       <?= $locale("important_date1_tit") ?>조기 등록 마감일:
                        <span>
                          
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
							?>
						
                            2023년 10월 27일(금)
                        </span>
                    </li> -->
                    <li>
                        <!--<?= $locale("important_date2_tit") ?>-->사전 등록 마감일:
                        <span>
                            <!--<?= date_format(date_create($event['period_event_pre_end']), 'F d, Y') ?>-->
                            2023년 10월 27일(금)
                        </span>
                    </li>
                </ul>
                <div class="pager_btn_wrap half mb50">
                    <button type="button" class="btn gray_btn show_pop">평점안내</button>
                    <button type="button" class="btn green_btn" onClick="location.href='http://kscvp.org'">KSCVP 가입
                    </button>
                    <button type="button" class="btn green_btn"
                        onClick="location.href='https://koreascp.or.kr:459/index.htm'">KSCP 가입

                    </button>
                </div>
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
                <!--<?= $locale("air_registration_tit") ?>-->등록비
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
                            <th rowspan="2">구분</th>
                            <!-- <th colspan="2">조기 등록</th> -->
                            <th colspan="2">사전 등록</th>
                            <th colspan="2">현장 등록</th>
                        </tr>
                        <!-- <tr>
								<th>KSoLA 회원</th>
								<th>비회원</th>
								<th>KSoLA 회원</th>
								<th>비회원</th>
								<th>KSoLA 회원</th>
								<th>비회원</th>
							</tr> -->
                    </thead>
                    <tbody>
                        <tr>
                            <td>전문의, 교수</td>
                            <!-- <td>80,000원</td> -->
                            <!-- <td>100,000원</td> -->
                            <!-- <td>100,000원</td>
                            <td>120,000원</td>
                            <td>120,000원</td>
                            <td>140,000원</td> -->
                            <td colspan="2">50,000원</td>
                            <td colspan="2">70,000원</td>
                        </tr>
                        <tr>
                            <td>
                                전임의, 전공의, 군의관/공보의, <br>
                                연구원, 학생, 간호사, 영양사, 약사, 기업회원, 기타
                                <!-- 의사 외 의료 분야 종사자*,연구원, 학생, 기업회원, 기타 -->
                            </td>
                            <!-- <td colspan="2">50,000원</td> -->
                            <td colspan="2">10,000원</td>
                            <td colspan="2">30,000원</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <!-- 				<p>*의사 외 의료분야종사자: 간호사, 영양사, 약사, 기타</p> -->
            </div>
            <?php
			}
			?>
            <!-- 2. 등록비 / Registration end -->

            <!-- 3. 결제방법 / Payment Method start -->
            <div class="circle_title">
                <!--<?= $locale("payment_method_tit") ?>-->결제방법
            </div>
            <div class="details payment_detail">
                <ul>
                    <li><b>
                            <!--<?= $locale("payment_method_txt") ?>-->Mac OS에서는 일부 신용카드 결제가 제한됩니다.
                        </b></li><br>
                    <li>ISP 인증을 사용하는 신용카드 결제가 제한되오니, 아래 카드로 등록비 결제하실경우 Windows OS 환경에서 이용 부탁드립니다.</li>
                    <li>- 사용제한 카드: BC카드(우리), KB 국민카드, 기타카드 (우체국, 수협, 새마을금고, 제주, 카카오뱅크 카드)</li>
                    <li>- 사용가능 카드: 신한, 삼성, 롯데, 하나, 농협NH카드</li><br>
                    <li>상기 카드가 결제 진행이 되지 않는 경우, 크로스사이트 추적방지, 모든 쿠키 차단은 모두 해제해 주세요.</li>
                </ul>
                <div class="payment_wrap">
                    <p class="details_title">*
                        <!--<?= $locale("payment_card_tit") ?>-->신용카드
                    </p>
                    <div class="img_wrap">
                        <!-- <img src="./img/sample/credit_card.jpg" alt="credit_card_img"> -->
                        <img src="./img/sample/credit_card2.png" alt="credit_card_img">
                    </div>
                </div>
                <p class="details_title">*
                    <!--<?= $locale("payment_bank_tit") ?>--> 계좌이체
                </p>
                <ul>
                    <!--
					<li>- <?= $locale("payment_bank_txt1") ?></li>
					<li>- <?= $locale("payment_bank_txt2") ?></li>
					<li>- <?= $locale("payment_bank_txt3") ?></li>-->
                    <li>등록비 입금 시 등록자 명으로 입금해주시기 바랍니다.</li>
                    <li>다른 이름 혹은 소속기관명으로 입금하실 경우 반드시 사무국 이메일(iscp@into-on.com) 로 연락바랍니다.</li>
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
                                <th>
                                    <!--<?= $locale("payment_bank_name_tit") ?>-->은행명
                                </th>
                                <td>
                                    <!--<?= $registration['bank_name'] ?>-->우리은행
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <!--<?= $locale("payment_account_number_tit") ?>-->계좌번호
                                </th>
                                <td>
                                    <!--<?= $registration['account_number'] ?>-->1005-803-441694
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <!--<?= $locale("payment_account_holder_tit") ?>-->예금주
                                </th>
                                <td>
                                    <!--<?= $registration['account_holder'] ?>-->대한심혈관약물치료학회

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 3. 결제방법 / Payment Method end -->

            <!-- 4. 등록취소 및 환불정책 / Cancellation start -->
            <div class="circle_title">
                <!--<?= $locale("cancellation_tit") ?>--> 등록취소 및 환불정책
            </div>
            <div class="details">
                <p>
                    <!--<?= $locale("cancellation_txt") ?>-->
                    등록비 환불은 대회 종료 후 이루어지며, 등록 취소 시 반드시 이메일(iscp@into-on.com)을 통하여 취소 내용을 사무국에 접수해주시기 바랍니다.
                </p>
                <br>
                <div class="table_wrap cancel_details">
                    <table class="table centerT left_border_table">
                        <thead>
                            <tr>
                                <th>
                                    <!--<?= $locale("date") ?>-->날짜
                                </th>
                                <th>
                                    <!--<?= $locale("cancellation_table_category2") ?>-->환불 금액
                                </th>
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
                            <!-- <tr>
                                <td>2022년 8월 6일까지 등록 취소 시</td>
                                <td>75% 환불</td>
                            </tr> -->
                            <tr>
                                <td>2023년 9월 30일까지 등록 취소 시
                                </td>
                                <td>100% 환불
                                </td>
                            </tr>
                            <tr>
                                <td>2023년 10월 1일부터 등록 취소 시
                                    시</td>
                                <td>환불 없음</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 4. 등록취소 및 환불정책 / Cancellation end -->
        </div>
    </div>

    <!-- 팝업 -->
    <div class="popup pop_info">
        <div class="pop_bg"></div>
        <div class="pop_contents">
            <button type="button" class="pop_close"><img src="./img/icons/pop_close.png"></button>
            <h3 class="pop_title">평점안내</h3>
            <div class="table_wrap">
                <table class="table centerT">
                    <thead>
                        <tr>
                            <th colspan="2">참석날짜</th>
                            <th>9월 15일(목)</th>
                            <th>9월 16일(금)</th>
                            <th>9월 17일(토)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>의사</th>
                            <th class="border_left">대한의사협회 연수평점</th>
                            <td>최대 3평점</td>
                            <td>최대 6평점</td>
                            <td>최대 6평점</td>
                        </tr>
                        <tr>
                            <!-- <th rowspan="2">영양사</th> -->
                            <!-- <th class="border_left">대한영양사협회</th> -->
                            <!-- <td colspan="3">전문영양사 전문연수교육 기타 4평점</td> -->
                        </tr>
                        <tr>
                            <th>영양사</th>
                            <th class="border_left">임상영양사 전문연수교육(CPD)</th>
                            <td colspan="3">5평점<br />* 3일 모두 수강하셔도 최대 5평점 승인됩니다.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div>
                <ul>
                    <li class="warning_point">등록 시 의사 면허번호를 정확하게 입력해주시기 바랍니다. 면허번호 오류 시 의사협회 평점이수자에서 누락될 수 있습니다.</li>
                    <li class="warning_point">학술대회 종료 후, 학회 사무국에서 의사 명단을 의사협회 연수교육 시스템에 등록하게 되면 자동으로 평점이 부여되고 있으며 개인에게
                        평점카드를 발급하지 않습니다. (소요기간 : 약 4주)</li>
                    <li class="warning_point">대한의사협회 2016년도 연수교육 관리 변경사항 공지에 따라 학술대회 참석 증명을 위한 출결 확인 작업이 있을 예정입니다.</li>
                    <li class="warning_point">대회 참석 시 출결 버튼(시작/종료)을 눌러주셔야만 출결 확인이 되니 유의 바랍니다.</li>
                </ul>
            </div>
            <br>
            <div class="table_wrap">
                <table class="table centerT">
                    <thead>
                        <tr>
                            <th>시스템 기록에 따른 이수시간</th>
                            <th>일반평점</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>온라인 일반평점 교육 이수시간 1시간 미만</td>
                            <td>X(없음)</td>
                        </tr>
                        <tr>
                            <td>1시간 이상 ~ 2시간 미만</td>
                            <td>1평점</td>
                        </tr>
                        <tr>
                            <td>2시간 이상 ~ 3시간 미만</td>
                            <td>2평점</td>
                        </tr>
                        <tr>
                            <td>3시간 이상 ~ 4시간 미만</td>
                            <td>3평점</td>
                        </tr>
                        <tr>
                            <td>4시간 이상 ~ 5시간 미만</td>
                            <td>4평점</td>
                        </tr>
                        <tr>
                            <td>5시간 이상 ~ 6시간 미만</td>
                            <td>5평점</td>
                        </tr>
                        <tr>
                            <td>6시간 이상 ~ </td>
                            <td>6평점(최대)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="section_title_wrap2">
                <a class="btn" href="http://doc-lic.kma.org/mypage/sub1.asp" target="_blank">면허신고현황조회 바로가기</a>
                <a class="btn" href="https://edu.kma.org/dataRoom/drMember.asp" target="_blank">대한의사협회 안내 공지 바로가기</a>
                <a class="btn" href="https://edu.kma.org" target="_blank">대한의사협회 연수교육 필수 평점 이수 내역 확인 바로가기</a>
                <li>대한의사협회 연수평점문의 Tel. 02-6350-6552, 대한의사협회 면허신고문의 Tel. 02-6350-6610</li>
            </div>
        </div>
    </div>
</section>

<!-- 22.04.11 기존버튼 
<button type="button" class="fixed_btn" onclick="window.location.href='./registration.php';"><?= $locale("registration") ?></button>-->
<!-- 22.04.11 변경버튼 / 22.04.14 등록 오픈 전까지 주석처리 -->
<button type="button" class="btn_fixed_triangle fixed_btn_pc" onClick="location.href='./registration.php'"><span>등록
        바로가기</span></button>

<script>
$('.show_pop').on('click', function() {
    $('.pop_info').show();
});
</script>

<?php include_once('./include/footer.php'); ?>