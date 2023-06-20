<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	
	include "./plugin/NHNKCP/cfg/site_conf_inc.php";       // 환경설정 파일 

	$member_idx = $_SESSION['USER']['idx'];
	$registration_idx = $_GET["idx"];

	//실서버에만 있음
	if($_SERVER["HTTP_HOST"] == "www.iscp2023.org") {
		//echo "<script>location.replace('https://iscp2023.org/main/registration2.php?idx={$registration_idx}')</script>";
	}

	$_SESSION["registration"]["idx"] = $registration_idx;

	if(!$registration_idx) {
		echo "<script>alert('Undefined registration number!'); window.location.replace('./registration.php');</script>";
		exit;
	}
	//결제번호 생성
	$rNo = $registration_idx;
	$date = date("YmdHis");
	$random = mt_rand(1, 1000);
	while(strlen("".$rNo) < 10){
		$rNo = "0".$rNo;
	}
	while(strlen("".$random) < 3){
		$random = "0".$random;
	}
	$order_code = "PR".$date.$random."N".$rNo;

	$select_registration_query =	"
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

	if(!is_array($registration_data)) {
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


	//if ($nation_no == 25) {
	//	$price_col_name .= "usd";
	//	$cur = "USD";
	//	$name = $first_name." ".$last_name;
	//} else {
	//	$price_col_name .= "krw";
	//	$cur = "KRW";
	//	$name = $last_name." ".$first_name;
	//}

	$nation_no			= isset($registration_data["nation_no"]) ? $registration_data["nation_no"] : "-";

	//2022-05-16 추가
	$promotion_code = isset($registration_data["promotion_code"]) ? $registration_data["promotion_code"] : -1;
	$recommended_by = isset($registration_data["recommended_by"]) ? $registration_data["recommended_by"] : "";
	$register_path = isset($registration_data["register_path"]) ? $registration_data["register_path"] : "-";
	$register_path_others = $registration_data["register_path_others"] ?? "";
	
	$register_paths = array();
	$register_paths = explode(",", $register_path);
	$register_path_value = "";

	if($nation_no == 25) {
		for($i=0; $i<count($register_paths)-1; $i++) {
			if($register_paths[$i] == 0) {
				$register_path_value .= "한국지질동맥경화학회 홈페이지 또는 홍보메일</p>";
			} else if($register_paths[$i] == 1){
				$register_path_value .= "<p>유관학회 홍보메일 또는 게시판 광고 </p> ";
			} else if($register_paths[$i] == 2){
				$register_path_value .= "<p>초청연자/좌장으로 초청받음 </p> ";
			} else if($register_paths[$i] == 3){
				$register_path_value .= "<p>이전 ICoLA에 참석한 경험이 있음 </p> ";
			} else if($register_paths[$i] == 4){
				$register_path_value .= "<p>제약회사 소개 </p> ";	
			} else if($register_paths[$i] == 5){
				$register_path_value .= "<p>지인을 통해 </p> ";
			} else if($register_paths[$i] == 6){
				$register_path_value .= "<p>인터넷 검색 </p> ";
			} 
		}
	} else {
		for($i=0; $i<count($register_paths)-1; $i++) {
			if($register_paths[$i] == 0) {
				$register_path_value .= "<p>Website or newletter of KSoLA</p>";
			} else if($register_paths[$i] == 1){
				$register_path_value .= "<p>Website or notice of related society</p> ";
			} else if($register_paths[$i] == 2){
				$register_path_value .= "<p>Went to the last ICoLA</p> ";
			} else if($register_paths[$i] == 3){
				$register_path_value .= "<p>Invitation for speaker or chair</p> ";
			} else if($register_paths[$i] == 4){
				$register_path_value .= "<p>Friend / Colleague</p> ";	
			} else if($register_paths[$i] == 5){
				$register_path_value .= "<p>Medical corporate</p> ";
			} else if($register_paths[$i] == 6){
				$register_path_value .= "<p>Internet banner ads or search</p> ";
			} 
		}
	}

	if(!empty($register_path_others)) {
		$register_path_value .= "<p>".$register_path_others." </p> ";
	}

	//2022-05-13 추가
	//이거는 프론트 용 단 변수 밑에 payment_methods는 벡엔드용
	$payment_methods_select = $registration_data["payment_methods"] ?? null;
	//2022-05-12 추가
	$welcome_reception_yn= $registration_data["welcome_reception_yn"] == "Y" ? "Yes" : "No";
	$day1_luncheon_yn	= $registration_data["day1_luncheon_yn"] == "Y" ? "Yes" : "No";
	$day2_breakfast_yn	= $registration_data["day2_breakfast_yn"] == "Y" ? "Yes" : "No";
	$day2_luncheon_yn	= $registration_data["day2_luncheon_yn"] == "Y" ? "Yes" : "No";
	$day3_breakfast_yn	= $registration_data["day3_breakfast_yn"] == "Y" ? "Yes" : "No";
	$day3_luncheon_yn	= $registration_data["day3_luncheon_yn"] == "Y" ? "Yes" : "No";


	//$payment_methods	= isset($registration_data["payment_methods"]) ? $registration_data["payment_methods"] : "-";
	$payment_methods = 0;
	
	$member_status		= $member_status == 1 ? $locale("member") : $locale("non_member");
	$applied_review		= isset($registration_data["is_score"]) ? $registration_data["is_score"] : "-";
	$is_score			= $applied_review == 0 ? "NO" : ($applied_review == 1 ? "YES" : "-");
	$email				= isset($registration_data["email"]) ? $registration_data["email"] : "-";
	$nation				= isset($registration_data["nation_en"]) ? $registration_data["nation_en"] : "-";
	$first_name			= isset($registration_data["first_name"]) ? $registration_data["first_name"] : "-";
	$last_name			= isset($registration_data["last_name"]) ? $registration_data["last_name"] : "-";
	$name_kor			= isset($registration_data["name_kor"]) ? $registration_data["name_kor"] : "-";
	$phone				= isset($registration_data["phone"]) ? $registration_data["phone"] : "-";
	$registration_type	= isset($registration_data["registration_type"]) ? $registration_data["registration_type"] : "-";
	$registration_type	= $registration_type == 0 ? $locale("registration_type_select1") : ($registration_type == 1 ? $locale("registration_type_select2") : $locale("registration_type_select3"));
	$affiliation		= isset($registration_data["affiliation"]) ? $registration_data["affiliation"] : "-";
	$department			= isset($registration_data["department"]) ? $registration_data["department"] : "-";
	$licence_number		= isset($registration_data["licence_number"]) ? $registration_data["licence_number"] : "-";
	$academy_number		= isset($registration_data["academy_number"]) ? $registration_data["academy_number"] : "-";
	//$register_path		= isset($registration_data["register_path"]) ? $registration_data["register_path"] : "-";
	$member_type		= isset($registration_data["member_type"]) ? $registration_data["member_type"] : "-";
	$etc				= $registration_data["etc1"] ?? "-";
	$result_org		= isset($registration_data["etc2"]) ? $registration_data["etc2"] : "";
	$result_org = explode(",",$result_org);
	foreach($result_org as $key => $value){
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

	$sql_during =	"SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
	$r_during_yn = sql_fetch($sql_during)['yn'];


	//특정 회원 가격 변동 이후 삭제
	if($registration_idx == 512) {
		$r_during_yn = 'N';
	}

	if(!empty($_SESSION["USER"])){
		$ksola_member_status = $member['ksola_member_status'];
	}else{
		echo "<script>alert('Need to login'); window.location.replace(PATH+'login.php');</script>";
		exit;
	}

	if($r_during_yn == 'Y') {
		if($us_price == 250) {
			$us_price = 300;
		} else if($us_price == 100) {
			$us_price = 150;
		} else if($us_price == 80000) {
			$us_price = 100000;
		} else if($us_price == 100000 && $ksola_member_status == 0) {
			$us_price = 120000;
		} else if($us_price == 50000) {
			$us_price = 60000;
		}
	}

	if ($member['idx'] == 137) {
		$us_price = 75;
	}

	$ko_price = $us_price;
	
	$price = $us_price;
	$price_eyes = $us_price;
	if($nation_no != 25) {
		$price_payment = $price * 100;
	} else {
		$price_payment = $price;
	}
	
	if($promotion_code == 0 && $promotion_code != "") {
		$promotion_code_value = "ICoLA-77932";
		$price_payment = 0;
		$price = 0;
	} else if($promotion_code == 1) {
		$promotion_code_value = "ICoLA-59721";
		$price_payment = $price_payment / 2;
		$price = $price / 2;
	} else if($promotion_code == 2) {
		$promotion_code_value = "ICoLA-89359";
		$price_payment = $price_payment / 2;
		$price = $price / 2;
	} else if($promotion_code == 4) {
		$promotion_code_value = "ICoLA-83523";
		$price_payment = $price_payment / 2;
		$price = $price / 2;
	}


	$price_name = ($nation_no == 25) ? "원" : "USD";


	// KG INICIS 결제모듈 정보로드
	//include_once(D9_PATH."/plugin/php_kcp_api_pay_sample/kcp_api_pay.php");
?>

<?php
	//모바일용
	 /* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보 */
    $req_tx          = $_POST[ "req_tx"         ]; // 요청 종류         
    $res_cd          = $_POST[ "res_cd"         ]; // 응답 코드         
    $tran_cd         = $_POST[ "tran_cd"        ]; // 트랜잭션 코드     
    $ordr_idxx       = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호   
    $good_name       = $_POST[ "good_name"      ]; // 상품명            
    $good_mny        = $_POST[ "good_mny"       ]; // 결제 총금액       
    $buyr_name       = $_POST[ "buyr_name"      ]; // 주문자명          
    $buyr_tel1       = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호   
    $buyr_tel2       = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
    $buyr_mail       = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소
    $use_pay_method  = $_POST[ "use_pay_method" ]; // 결제 방법         
	$enc_info        = $_POST[ "enc_info"       ]; // 암호화 정보       
    $enc_data        = $_POST[ "enc_data"       ]; // 암호화 데이터     
    $cash_yn         = $_POST[ "cash_yn"        ];
    $cash_tr_code    = $_POST[ "cash_tr_code"   ];
    /* 기타 파라메터 추가 부분 - Start - */
    $param_opt_1    = $_POST[ "param_opt_1"     ]; // 기타 파라메터 추가 부분
    $param_opt_2    = $_POST[ "param_opt_2"     ]; // 기타 파라메터 추가 부분
    $param_opt_3    = $_POST[ "param_opt_3"     ]; // 기타 파라메터 추가 부분
    /* 기타 파라메터 추가 부분 - End -   */

	$tablet_size     = "1.0"; // 화면 사이즈 고정
	$url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

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
<!--
		결제창 호출 JS
		 개발 : https://testpay.kcp.co.kr/plugin/payplus_web.jsp
		 운영 : https://pay.kcp.co.kr/plugin/payplus_web.jsp
-->
<!--  <script type="text/javascript" src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"></script> -->
<script type="text/javascript" src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"></script>
<!-- 거래등록 하는 kcp 서버와 통신을 위한 스크립트-->
<script type="text/javascript" src="./plugin/NHNKCP/mobile_sample/js/approval_key.js?v=0.2"></script>
<script type="text/javascript">
/* 표준웹 실행 */
function jsf__pay(form) {
    ajax_save();

    try {
        KCP_Pay_Execute(form);
    } catch (e) {
        /* IE 에서 결제 정상종료시 throw로 스크립트 종료 */
    }
}
/* 주문번호 생성 예제 */
function init_orderid() {
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var date = today.getDate();
    var time = today.getTime();

    if (parseInt(month) < 10) {
        month = "0" + month;
    }

    if (parseInt(date) < 10) {
        date = "0" + date;
    }

    var order_idxx = "ICoLA" + year + "" + month + "" + date + "" + time;
    var ipgm_date = year + "" + month + "" + date;

    document.order_info.ordr_idxx.value = order_idxx;
    document.order_info2.ordr_idxx.value = order_idxx;
    document.order_info2.ipgm_date.value = ipgm_date;
}

var payment_methods = "<?= $payment_methods;?>";

$(document).ready(function() {
    if (payment_methods == 0) {
        document.order_info2.pay_method.value = "CARD";
    } else {
        document.order_info2.pay_method.value = "BANK";
    }
});

//모바일
function jsf__chk_type() {
    if (document.order_info2.ActionResult.value == "card") {
        document.order_info2.pay_method.value = "CARD";
    } else if (document.order_info2.ActionResult.value == "acnt") {
        document.order_info2.pay_method.value = "BANK";
    }
}
/* kcp web 결제창 호츨 (변경불가) */
function call_pay_form() {
    var v_frm = document.order_info2;

    v_frm.action = PayUrl;

    if (v_frm.Ret_URL.value == "") {
        /* Ret_URL값은 현 페이지의 URL 입니다. */
        alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
        return false;
    } else {
        v_frm.submit();
    }
}
/* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청 (변경불가) */
function chk_pay() {
    self.name = "tar_opener";
    var pay_form = document.pay_form;

    if (pay_form.res_cd.value == "3001") {
        alert("Cancelled by user.");
        pay_form.res_cd.value = "";
    }

    if (pay_form.enc_info.value)
        pay_form.submit();
}

$(document).ready(function() {
    init_orderid();
    jsf__chk_type();
    chk_pay();

});
</script>

<section class="container submit_application payment">
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
    <form name="order_info" method="post" action="./plugin/NHNKCP/sample/pp_cli_hub.php">
        <div class="inner bottom_short">
            <div class="input_area">
                <!-- content 1 -->
                <div class="circle_title"><?=$locale("registration_info_tit")?></div>
                <div class="details">
                    <p><?=$locale("registration_info_txt")?></p>
                </div>
                <div class="table_wrap">
                    <table class="table detail_table">
                        <colgroup>
                            <col class="col_th">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th><?=$locale("id")?></th>
                                <td><?=$email?></td>
                                <input type="hidden" name="buyr_mail" value="<?=$email?>" />
                            </tr>
                            <tr>
                                <th>Name(Eng)</th>
                                <td><?=$first_name?> <?=$last_name?></td>
                                <?php
						if($nation_no == 25) {
					?>
                                <!--여기 혹시 모르니 주의-->
                                <input type="hidden" name="buyr_name" value="<?=$name_kor; ?>" />
                                <?php
						} else {
					?>
                                <input type="hidden" name="buyr_name" value="<?=$first_name?> <?=$last_name?>" />
                                <?php
						}
					?>

                            </tr>
                            <?php
						if($nation_no == 25) {
					?>
                            <tr>
                                <th>Name(Kor)</th>
                                <td><?=$name_kor; ?></td>
                            </tr>
                            <?php
						}
					?>
                            <tr>
                                <th><?=$locale("country")?></th>
                                <td><?=$nation?></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td><?= $member_type; ?></td>
                            </tr>
                            <tr>
                                <th>Others</th>
                                <td>
                                    Welcome Reception (17:10-20:00, 15 Sep (Thu), 2022): <?= $welcome_reception_yn?>
                                    </br>
                                    Day 1 – Luncheon Symposium (12:00-12:50, 15 Sep (Thu), 2022):
                                    <?= $day1_luncheon_yn?> </br>
                                    Day 2 – Breakfast Symposium (08:00-09:00, 16 Sep (Fri), 2022):
                                    <?= $day2_breakfast_yn?> </br>
                                    Day 2 - Luncheon Symposium (12:00-12:50, 16 Sep (Fri), 2022):
                                    <?= $day2_luncheon_yn?> </br>
                                    Day 3 – Breakfast Symposium (08:00-09:00, 17 Sep (Sat), 2022):
                                    <?= $day3_breakfast_yn?> </br>
                                    Day 3 - Luncheon Symposium (12:05-12:55, 17 Sep (Sat), 2022):
                                    <?= $day3_luncheon_yn?> </br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php
							if($nation_no == 25) {
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
                                <th>Registration fee</th>
                                <td><?=(($nation_no != 25) ? $price_name." ".number_format($price_eyes) : number_format($price_eyes)."".$price_name)?>
                                </td>
                                <!-- <input type="hidden" name="good_mny" value="100" maxlength="9" /> -->
                                <input type="hidden" name="good_mny" value="<?= $price_payment ?>" maxlength="9" />
                            </tr>
                            <tr>
                                <th>Promotion code</th>
                                <td>
                                    <div class="file_submission input_2btn promote_code">
                                        <input class="en_num_keyup" type="text" name="promotion_code"
                                            placeholder="Promotion code" maxlength="11"
                                            value="<?= $promotion_code_value; ?>">
                                        <button type="button" class="btn dark_gray_btn" onclick="apply()">Apply</button>
                                    </div>
                                    <div class="code_result"></div>
                                    <div class="file_submission input_2btn promote_code promote_code2">
                                        <input class="ko_en_keyup" type="text" name="recommended_by"
                                            placeholder="Recommended by" maxlength="50" value="<?= $recommended_by; ?>">
                                        <input type="hidden" name="hidden_code">
                                        <button type="button" class="btn dark_gray_btn"
                                            onclick="complete()">Complete</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="red_txt bold">Total registration fee</th>
                                <td class="red_txt bold">
                                    <?=(($nation_no != 25) ? $price_name." ".number_format($price) : number_format($price)."".$price_name)?>
                                </td>
                            </tr>
                            <?php
						if($promotion_code != 0) {
					?>
                            <tr>
                                <th>Payment methods</th>
                                <td>
                                    <div class="radio_wrap">
                                        <ul class="flex">
                                            <li>
                                                <input <?= $payment_methods_select == 0 ? "checked" : "";?> type="radio"
                                                    class="radio required" id="pay_type1" name="payment_methods"
                                                    value="0">
                                                <label
                                                    for="pay_type1"><?= ($nation_no != 25) ? "Credit Card" : "카드 결제";?></label>
                                            </li>
                                            <li>
                                                <input <?= $payment_methods_select == 1 ? "checked" : "";?> type="radio"
                                                    class="radio required" id="pay_type2" name="payment_methods"
                                                    value="1">
                                                <label
                                                    for="pay_type2"><?= ($nation_no != 25) ? "Bank Transfer" : "계좌 이체";?></label>
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
                <!-- 	<p><?=$locale("total_price")?> <span class="point_txt s_bold"><?=(($nation_no != 25) ? $price_name." ".number_format($price) : number_format($price)."".$price_name)?></span></p> -->
                <!-- </div> -->
                <div class="details">
                    <p><?=$locale("cancellation_tit")?> <a href="javascript:;" class="red_txt cancel_btn">Details
                            &gt;</a></p>
                </div>
                <!-- btn_wrap -->
                <!-- 기존 버튼 마크업
			<div class="btn_wrap">
				<button type="button" class="btn submit" onclick="kgpay();"><?=$locale("d_payment_btn")?></button>
				<?php if($_SESSION["language"] != "ko"){?>
					<button type="button" class="btn submit" onclick="payment();"><?=$locale("payment_btn")?></button>
				<?php }?>
			</div>-->
                <!-- 220324 기존에는 결제방식이 '국내/해외'로 분리되었으나, 현재는 1개의 버튼으로 통일됨 (HUBDNC LJH2)-->

                <div class="pager_btn_wrap pc_only centerT pager_btn_wrap half">
                    <button type="button" class="btn green_btn pc-wd-3"
                        onclick="prev(<?=$registration_idx;?>)">Prev</button>

                    <?php
				if($payment_methods_select == 0) {
					if($promotion_code == 0) {
						//100% 할인
			?>
                    <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="code_100()">
                        Payment
                    </button>
                    <?php
					} else {
			?>
                    <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3"
                        onclick="jsf__pay(document.order_info);">
                        Payment
                    </button>
                    <?php
					}
				} else {
					if($promotion_code == 0) {
			?>
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="code_100()">
                        Payment
                    </button>
                    <?php
					} else {
			?>
                    <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="transfer();">
                        Payment
                    </button>
                    <?php
					}
				}
			?>
                </div>
                <div class=" pager_btn_wrap mb_only centerT pager_btn_wrap half">
                    <button type="button" class="btn green_btn pc-wd-3"
                        onclick="prev(<?=$registration_idx;?>)">Prev</button>
                    <?php
				if($payment_methods_select == 0) {
					if($promotion_code == 0) {
			?>
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="code_100()">
                        Payment
                    </button>
                    <?php
					} else {
			?>
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="mb_click()">
                        Payment
                    </button>
                    <?php
					}
				} else {
					if($promotion_code == 0) {
			?>
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="code_100()">
                        Payment
                    </button>
                    <?php
					} else {
			?>
                    <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="transfer()">
                        Payment
                    </button>
                    <?php
					}
				}
			?>
                </div>
            </div>

        </div>
        <!-- idx -->
        <input type="hidden" name="registration_idx" value="<?= $registration_idx; ?>" maxlength="40" />
        <!-- nation_no -->
        <input type="hidden" name="nation_no" value="<?= $nation_no; ?>" maxlength="40" />
        <!--주문번호-->
        <input type="hidden" name="ordr_idxx" value="" maxlength="40" />
        <!--결제 정보 -->
        <input type="radio" id="radio-2-1" class="ipt-radio-1" name="pay_method" value="100000000000"
            <?= ($payment_methods==0 ? "checked" : "")?> />
        <input type="radio" id="radio-2-2" class="ipt-radio-1" name="pay_method" value="010000000000"
            <?= ($payment_methods==1 ? "checked" : "")?> />

        <!-- 필수 항목 : 결제 금액/화폐단위 -->
        <?php
		if($nation_no == 25) {
	?>
        <input type="hidden" name="site_cd" value="N4993">
        <input type="hidden" name="currency" value="WON" />
        <input type="hidden" name="eng_flag" value="N" /> <!-- 한 / 영 -->
        <?php
		} else {
	?>
        <input type="hidden" name="currency" value="USD" />
        <input type="hidden" name="eng_flag" value="Y" /> <!-- 한 / 영 -->
        <input type="hidden" name="site_cd" value="N4994">
        <input type="hidden" name="keyin" value="KEYIN">
        <?php
		}
	?>

        <!-- 가맹점 정보 설정-->
        <input type="hidden" name="req_tx" value="pay" />
        <!--<input type="hidden" name="site_cd"         value="T0000" /> -->

        <input type="hidden" name="site_name" value="ICoLA" />
        <input type="hidden" name="pay_method" value="" />
        <!-- 
						※필수 항목
						 표준웹에서 값을 설정하는 부분으로 반드시 포함되어야 합니다.값을 설정하지 마십시오
		-->
        <input type="hidden" name="res_cd" value="" />
        <input type="hidden" name="res_msg" value="" />
        <input type="hidden" name="enc_info" value="" />
        <input type="hidden" name="enc_data" value="" />
        <input type="hidden" name="ret_pay_method" value="" />
        <input type="hidden" name="tran_cd" value="" />
        <input type="hidden" name="use_pay_method" value="" />
        <!-- 주문정보 검증 관련 정보 : 표준웹 에서 설정하는 정보입니다 -->
        <input type="hidden" name="ordr_chk" value="" />
        <!--  현금영수증 관련 정보 : 표준웹 에서 설정하는 정보입니다 -->
        <input type="hidden" name="cash_yn" value="" />
        <input type="hidden" name="cash_tr_code" value="" />
        <input type="hidden" name="cash_id_info" value="" />

        <input type="hidden" name="good_expr" value="0">

        <!-- 
			====================================================
							 추가 옵션 정보
							※ 옵션 - 결제에 필요한 추가 옵션 정보를 입력 및 설정합니다. 
			====================================================
		-->

        <!--사용카드 설정 여부 파라미터 입니다.(통합결제창 노출 유무) -->
        <!-- <input type="hidden" name="used_card_YN"        value="Y" /> -->
        <!-- 사용카드 설정 파라미터 입니다. (해당 카드만 결제창에 보이게 설정하는 파라미터입니다. used_card_YN 값이 Y일때 적용됩니다. -->
        <!-- <input type="hidden" name="used_card"        value="CCBC:CCKM:CCSS" /> -->

        <!--
					   신용카드 결제시 OK캐쉬백 적립 여부를 묻는 창을 설정하는 파라미터 입니다
						포인트 가맹점의 경우에만 창이 보여집니다
		-->
        <!-- <input type="hidden" name="save_ocb"        value="Y" /> -->

        <!-- 고정 할부 개월 수 선택
			value값을 "7" 로 설정했을 경우 => 카드결제시 결제창에 할부 7개월만 선택가능  -->
        <!-- <input type="hidden" name="fix_inst"        value="07" /> -->

        <!-- 무이자 옵션
				※ 설정할부    (가맹점 관리자 페이지에 설정 된 무이자 설정을 따른다) - "" 로 설정
				※ 일반할부    (KCP 이벤트 이외에 설정 된 모든 무이자 설정을 무시한다) - "N" 로 설정
				※ 무자 할부 (가맹점 관리자 페이지에 설정 된 무이자 이벤트 중 원하는 무이자 설정을 세팅한다) - "Y" 로 설정 -->
        <!-- <input type="hidden" name="kcp_noint"       value="" /> -->

        <!-- 무이자 설정
				※ 주의 1 : 할부는 결제금액이 50,000 원 이상일 경우에만 가능
				※ 주의 2 : 무이자 설정값은 무이자 옵션이 Y일 경우에만 결제 창에 적용
				예) BC 2,3,6개월, 국민 3,6개월, 삼성 6,9개월 무이자 : CCBC-02:03:06,CCKM-03:06,CCSS-03:06:04 -->
        <!-- <input type="hidden" name="kcp_noint_quota" value="CCBC-02:03:06,CCKM-03:06,CCSS-03:06:09" /> -->


        <!--  해외카드 구분하는 파라미터 입니다.(해외비자, 해외마스터, 해외JCB로 구분하여 표시) -->
        <!-- <input type="hidden" name="used_card_CCXX"        value="Y"/> -->

        <!--  가상계좌 은행 선택 파라미터
			 ※ 해당 은행을 결제창에서 보이게 합니다.(은행코드는 매뉴얼을 참조)  -->
        <!-- <input type="hidden" name="wish_vbank_list" value="05:03:04:07:11:23:26:32:34:81:71" /> -->

        <!--  가상계좌 입금 기한 설정하는 파라미터 - 발급일 + 3일 -->
        <!-- <input type="hidden" name="vcnt_expire_term" value="3"/> -->

        <!-- 가상계좌 입금 시간 설정하는 파라미터
			HHMMSS형식으로 입력하시기 바랍니다
					  설정을 안하시는경우 기본적으로 23시59분59초가 세팅이 됩니다 -->
        <!-- <input type="hidden" name="vcnt_expire_term_time" value="120000" /> -->

        <!-- 포인트 결제시 복합 결제(신용카드+포인트) 여부를 결정할 수 있습니다.- N 일경우 복합결제 사용안함 -->
        <!-- <input type="hidden" name="complex_pnt_yn" value="N" /> -->

        <!-- 현금영수증 등록 창을 출력 여부를 설정하는 파라미터 입니다
				   ※ Y : 현금영수증 등록 창 출력
				   ※ N : 현금영수증 등록 창 출력 안함 
				   ※ 주의 : 현금영수증 사용 시 KCP 상점관리자 페이지에서 현금영수증 사용 동의를 하셔야 합니다 -->
        <!-- <input type="hidden" name="disp_tax_yn"     value="Y" /> -->

        <!--  결제창에 가맹점 사이트의 로고를 표준웹 좌측 상단에 출력하는 파라미터 입니다
				  업체의 로고가 있는 URL을 정확히 입력하셔야 하며, 최대 150 X 50  미만 크기 지원
				  ※ 주의 : 로고 용량이 150 X 50 이상일 경우 site_name 값이 표시됩니다. -->
        <!-- <input type="hidden" name="site_logo"       value="" /> -->

        <!-- 결제창 영문 표시 파라미터 입니다. 영문을 기본으로 사용하시려면 Y로 세팅하시기 바랍니다 -->
        <!-- <input type="hidden" name="eng_flag"      value="Y"> -->

        <!--  KCP는 과세상품과 비과세상품을 동시에 판매하는 업체들의 결제관리에 대한 편의성을 제공해드리고자, 
				복합과세 전용 사이트코드를 지원해 드리며 총 금액에 대해 복합과세 처리가 가능하도록 제공하고 있습니다
				복합과세 전용 사이트 코드로 계약하신 가맹점에만 해당이 됩니다
				상품별이 아니라 금액으로 구분하여 요청하셔야 합니다
				총결제 금액은 과세금액 + 부과세 + 비과세금액의 합과 같아야 합니다. 
			(good_mny = comm_tax_mny + comm_vat_mny + comm_free_mny) -->
        <!-- <input type="hidden" name="tax_flag"       value="TG03" /> -->
        <!-- 변경불가     -->
        <!-- <input type="hidden" name="comm_tax_mny"   value=""     /> -->
        <!-- 과세금액     -->
        <!-- <input type="hidden" name="comm_vat_mny"   value=""     /> -->
        <!-- 부가세      -->
        <!-- <input type="hidden" name="comm_free_mny"  value=""     /> -->
        <!-- 비과세 금액 -->

        <!--  skin_indx 값은 스킨을 변경할 수 있는 파라미터이며 총 7가지가 지원됩니다. 
				 변경을 원하시면 1부터 7까지 값을 넣어주시기 바랍니다. -->
        <!-- <input type="hidden" name="skin_indx"      value="1" /> -->
        <!-- 상품코드 설정 파라미터 입니다.(상품권을 따로 구분하여 처리할 수 있는 옵션기능입니다.) -->
        <!-- <input type="hidden" name="good_cd"      value="" /> -->

        <!-- 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다. 상품권 결제 시 반드시 입력하시기 바랍니다. -->
        <!-- <input type="hidden" name="shop_user_id"    value="" /> -->

        <!--  복지포인트 결제시 가맹점에 할당되어진 코드 값을 입력해야합니다. -->
        <!-- <input type="hidden" name="pt_memcorp_cd"   value="" /> -->

        <!--  결제창의 상단문구를 변경할 수 있는 파라미터 입니다. -->
        <!-- <input type="hidden" name="kcp_pay_title"   value="상단문구추가" /> -->
    </form>


    <!-- 거래등록 정보 입력 form : order_info -->
    <form name="order_info2" method="post" accept-charset="euc-kr" style="display:none;">
        <!--
	==================================================================
		1. 거래등록                                                       
	------------------------------------------------------------------
	거래등록에 필요한 정보를 입력 및 설정합니다.                            
	------------------------------------------------------------------
	-->
        <!-- header -->
        <div class="header">
            <a href="../index.html" class="btn-back"><span>뒤로가기</span></a>
            <h1 class="title">주문/결제 SAMPLE</h1>
        </div>
        <!-- //header -->
        <!-- contents -->
        <div id="skipCont" class="contents">
            <p class="txt-type-1">이 페이지는 거래등록을 요청하는 샘플 페이지입니다.</p>
            <p class="txt-type-2">소스 수정 시 [※ 필수] 또는 [※ 옵션] 표시가 포함된 문장은 가맹점의 상황에 맞게 적절히 수정 적용하시기 바랍니다.</p>
            <!-- 거래등록 -->
            <h2 class="title-type-3">거래등록</h2>
            <ul class="list-type-1">
                <!-- 주문번호(ordr_idxx) -->
                <li>
                    <div class="left">
                        <p class="title">주문번호</p>
                    </div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="ordr_idxx" value="" maxlength="40" />
                        </div>
                    </div>
                </li>
                <!-- 상품명(good_name) -->
                <li>
                    <div class="left">
                        <p class="title">상품명</p>
                    </div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="good_name" value="ICoLA2022" />
                        </div>
                    </div>
                </li>
                <!-- 결제금액(good_mny) - ※ 필수 : 값 설정시 ,(콤마)를 제외한 숫자만 입력하여 주십시오. -->
                <li>
                    <div class="left">
                        <p class="title">상품금액</p>
                    </div>
                    <div class="right">
                        <div class="ipt-type-1 gap-2 pc-wd-2">
                            <input type="text" name="good_mny" value="<?= $price_payment ?>" maxlength="9" />
                            <!-- <input type="text" name="good_mny" value="1000" maxlength="9" /> -->
                            <span class="txt-price">원</span>
                        </div>
                    </div>
                </li>
                <input type="hidden" name="buyr_mail" value="<?=$email?>" />
                <?php
				if($language != "en") {
			?>
                <input type="hidden" name="buyr_name" value="<?=$name_kor; ?>" />
                <?php
				} else {
			?>
                <input type="hidden" name="buyr_name" value="<?=$first_name?> <?=$last_name?>" />
                <?php
				}
			?>
                <input type="text" name="buyr_tel2" class="w100" value="<?= $phone; ?>">


            </ul>
            <!--
		==================================================================
					결제 수단 정보 설정                                                        
		 ------------------------------------------------------------------
					결제에 필요한 결제 수단 정보를 설정합니다

					신용카드 : CARD, 계좌이체 : BANK, 가상계좌 : VCNT = */
					포인트   : TPNT, 휴대폰   : MOBX, 상품권   : GIFT = */

				   위와 같이 설정한 경우 표준웹에서 설정한 결제수단이 표시됩니다.

				※ 필수
		KCP에 신청된 결제수단으로만 결제가 가능합니다.
		------------------------------------------------------------------
		-->
            <h2 class="title-type-3">결제수단</h2>
            <ul class="list-type-1">
                <!-- 결제수단 -->
                <li>
                    <div class="left">
                        <p class="title">결제수단</p>
                    </div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <select name="ActionResult" onchange="jsf__chk_type();" style="width:100%;height:35px;">
                                <!-- <option value="" selected>선택하십시오</option> -->
                                <option value="card" <?= ($payment_methods==0) ? "selected":""; ?>>신용카드</option>
                                <option value="acnt" <?= ($payment_methods==1) ? "selected":""; ?>>계좌이체</option>
                                <option value="vcnt">가상계좌</option>
                                <option value="mobx">휴대폰</option>
                                <option value="ocb">OK캐쉬백</option>
                                <option value="tpnt">복지포인트</option>
                                <option value="scbl">도서상품권</option>
                                <option value="sccl">문화상품권</option>
                                <option value="schm">해피머니</option>
                            </select>
                        </div>
                    </div>
                </li>
            </ul>
            <div Class="Line-Type-1"></div>
            <ul class="list-btn-2">
                <li class="pc-only-show"><a href="../index.html" class="btn-type-3 pc-wd-2">뒤로</a></li>
                <li><input id="mb_submit" type="button" class="submit" value="거래등록" onclick="kcp_AJAX();"></li>
            </ul>
        </div>
        <!-- //contents -->

        <!-- footer -->
        <div class="grid-footer">
            <div class="inner">
                <div class="footer">
                    ⓒ NHN KCP Corp.
                </div>
            </div>
        </div>
        <!--//footer-->
        <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
        <!-- <input type="hidden"   name="Ret_URL"         value="/main/plugin/php_kcp_api_pay_sample/mobile_sample/order_mobile.php" /> -->
        <!-- <input type="hidden"   name="user_agent"      value="" /> <!--사용 OS--> -->
        <!-- <input type="hidden"   name="site_cd"         value="T0000" /> <!--사이트코드--> -->
        <!-- <!-- 인증시 필요한 파라미터(변경불가)--> -->
        <!-- <input type="hidden" name="pay_method"      value=""> -->
        <!-- <input type="hidden" name="van_code"        value=""> -->

        <!-- nation_no -->
        <!-- idx -->
        <input type="hidden" name="registration_idx" value="<?= $registration_idx; ?>" maxlength="40" />
        <input type="hidden" name="nation_no" value="<?= $nation_no; ?>" maxlength="40" />

        <input type="hidden" name="encoding_trans" value="UTF-8" />
        <input type="hidden" name="PayUrl">
        <!-- 공통정보 -->
        <input type="hidden" name="req_tx" value="pay"> <!-- 요청 구분 -->
        <input type="hidden" name="shop_name" value="<?= $g_conf_site_name ?>"> <!-- 사이트 이름 -->


        <?php
		if($nation_no == 25) {
	?>
        <input type="hidden" name="site_cd" value="N4993"> <!-- 사이트 코드 -->
        <input type="hidden" name="currency" value="410" /> <!-- 통화 코드 -->
        <input type="hidden" name="eng_flag" value="N" /> <!-- 한 / 영 -->
        <?php
		} else {
	?>
        <input type="hidden" name="site_cd" value="N4994"> <!-- 사이트 코드 -->
        <input type="hidden" name="currency" value="840" /> <!-- 통화 코드 -->
        <input type="hidden" name="eng_flag" value="Y" /> <!-- 한 / 영 -->
        <input type="hidden" name="card_cert_type" value="KEYIN">
        <?php
		}
	?>
        <!-- 결제등록 키 -->
        <input type="hidden" name="approval_key" id="approval">
        <!-- 인증시 필요한 파라미터(변경불가)-->
        <input type="hidden" name="escw_used" value="N">
        <input type="hidden" name="pay_method" value="">
        <input type="hidden" name="van_code" value="">
        <!-- 신용카드 설정 -->
        <input type="hidden" name="quotaopt" value="12" /> <!-- 최대 할부개월수 -->
        <!-- 가상계좌 설정 -->
        <input type="hidden" name="ipgm_date" value="" />
        <!-- 가맹점에서 관리하는 고객 아이디 설정을 해야 합니다.(필수 설정) -->
        <input type="hidden" name="shop_user_id" value="" />
        <!-- 복지포인트 결제시 가맹점에 할당되어진 코드 값을 입력해야합니다.(필수 설정) -->
        <input type="hidden" name="pt_memcorp_cd" value="" />
        <!-- 현금영수증 설정 -->
        <input type="hidden" name="disp_tax_yn" value="Y" />
        <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
        <!-- <input type="hidden" name="Ret_URL"         value="<?=$url?>"> -->
        <input type="hidden" name="Ret_URL" value="<?=$url?>">
        <!-- 화면 크기조정 -->
        <input type="hidden" name="tablet_size" value="<?=$tablet_size?>">

        <!-- 추가 파라미터 ( 가맹점에서 별도의 값전달시 param_opt 를 사용하여 값 전달 ) -->
        <input type="hidden" name="param_opt_1" value="">
        <input type="hidden" name="param_opt_2" value="">
        <input type="hidden" name="param_opt_3" value="">
    </form>


    <form name="pay_form" method="post" action="./plugin/NHNKCP/mobile_sample/pp_cli_hub.php">
        <input type="hidden" name="nation_no" value="<?= $nation_no?>">

        <input type="hidden" name="req_tx" value="<?=$req_tx?>"> <!-- 요청 구분          -->
        <input type="hidden" name="res_cd" value="<?=$res_cd?>"> <!-- 결과 코드          -->
        <input type="hidden" name="tran_cd" value="<?=$tran_cd?>"> <!-- 트랜잭션 코드      -->
        <input type="hidden" name="ordr_idxx" value="<?=$ordr_idxx?>"> <!-- 주문번호           -->
        <input type="hidden" name="good_mny" value="<?=$good_mny?>"> <!-- 휴대폰 결제금액    -->
        <input type="hidden" name="good_name" value="<?=$good_name?>"> <!-- 상품명             -->
        <input type="hidden" name="buyr_name" value="<?=$buyr_name?>"> <!-- 주문자명           -->
        <input type="hidden" name="buyr_tel1" value="<?=$buyr_tel1?>"> <!-- 주문자 전화번호    -->
        <input type="hidden" name="buyr_tel2" value="<?=$buyr_tel2?>"> <!-- 주문자 휴대폰번호  -->
        <input type="hidden" name="buyr_mail" value="<?=$buyr_mail?>"> <!-- 주문자 E-mail      -->
        <input type="hidden" name="cash_yn" value="<?=$cash_yn?>"> <!-- 현금영수증 등록여부-->
        <input type="hidden" name="enc_info" value="<?=$enc_info?>">
        <input type="hidden" name="enc_data" value="<?=$enc_data?>">
        <input type="hidden" name="use_pay_method" value="<?=$use_pay_method?>">
        <input type="hidden" name="cash_tr_code" value="<?=$cash_tr_code?>">

        <!-- 추가 파라미터 -->
        <input type="hidden" name="param_opt_1" value="<?=$param_opt_1?>">
        <input type="hidden" name="param_opt_2" value="<?=$param_opt_2?>">
        <input type="hidden" name="param_opt_3" value="<?=$param_opt_3?>">
    </form>



    <div class="popup cancel_pop">
        <div class="pop_bg"></div>
        <div class="pop_contents">
            <button type="button" class="pop_close"><img src="./img/icons/pop_close.png"></button>
            <h3 class="pop_title"><?=$locale("cancellation_tit")?></h3>
            <p class="pre"><?=$locale("cancellation_txt")?></p>
            <div class="table_wrap c_table_wrap2">
                <table class="c_table2">
                    <thead>
                        <tr>
                            <th><?=$locale("date")?></th>
                            <th><?=$locale("cancellation_table_category2")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$locale("cancellation_table_data1")?></td>
                            <td><?=$locale("cancellation_table_data1_1")?></td>
                        </tr>
                        <tr>
                            <td><?=$locale("cancellation_table_data2")?></td>
                            <td><?=$locale("cancellation_table_data2_1")?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<!-- <script src="./js/script/client/registration.js"></script> -->
<script>
function code_100() {

    var registration_idx = "<?= $registration_idx; ?>";
    var nation_no = "<?= $nation_no ?>";

    var data = {
        "flag": "code_100_payment",
        "registration_idx": registration_idx,
        "nation_no": nation_no
    };

    $.ajax({
        url: PATH + "ajax/client/ajax_payment.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                window.location.replace("mypage_registration.php");
            } else if (res.code == 400) {
                alert(res.msg);
                return;
            }
        }
    });
}

function apply() {

    var promotion_code = $("input[name=promotion_code]").val();
    var registration_idx = "<?= $registration_idx; ?>";

    var data = {
        "flag": "promotion_code_update",
        "promotion_code": promotion_code,
        "registration_idx": registration_idx
    };

    $.ajax({
        url: PATH + "ajax/client/ajax_registration.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                if (res.promotion_code_value == 0) {
                    $(".code_result").html(res.promotion_code + " [100% Discount]");
                } else if (res.promotion_code_value == 1 || res.promotion_code_value == 2 || res
                    .promotion_code_value == 4) {
                    $(".code_result").html(res.promotion_code + " [50% Discount]");
                } else if (res.promotion_code_value == 3) {
                    //$(".code_result").html("Promotion code used");
                    alert("Promotion code used");
                    $("input[name=hidden_code]").val("");
                }
                $("input[name=hidden_code]").val(res.promotion_code_value);
                //window.location.replace("registration2.php?idx="+registration_idx);
            } else if (res.code == 401) {
                $(".code_result").html("Invalid promotion code");
                $("input[name=hidden_code]").val("");
                return false;
            }
        }
    });
}

function complete() {

    var registration_idx = "<?= $registration_idx; ?>";
    var hidden_code = $("input[name=hidden_code]").val();

    if (!hidden_code || hidden_code == 3) {
        alert("Please check the promotion code");
        return;
    }

    var recommended_by = $("input[name=recommended_by]").val().trim();
    var recommended_by_trim = "";

    //추천인 유효성
    if (!recommended_by) {
        alert("Invalid Recommended by");
        return;
    }

    recommended_by_trim = recommended_by.toLowerCase();
    recommended_by_trim = recommended_by_trim.replace(/ /g, "")

    var data = {
        "flag": "promotion_code_complate",
        "recommended_by": recommended_by,
        "recommended_by_trim": recommended_by_trim,
        "hidden_code": hidden_code,
        "registration_idx": registration_idx
    };

    $.ajax({
        url: PATH + "ajax/client/ajax_registration.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                window.location.replace("registration2.php?idx=" + registration_idx);
            } else if (res.code == 400) {
                alert(res.msg);
                return;
            } else if (res.code == 401) {
                alert("Invalid promotion code");
                return;
            } else if (res.code == 402) {
                alert("Promotion code used");
                return;
            }
        }
    });
}

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

    ajax_save();

    document.getElementById("mb_submit").click();
    //kcp_AJAX();
}

function prev(idx) {
    window.location.replace("registration.php?idx=" + idx);
}

$(document).on("change", "input[name=payment_methods]", function() {
    var promotion_code = "<?= $promotion_code; ?>";
    if ($(this).val() == 0) {
        $("#pc_payment_btn").removeAttr("onclick");
        $("#mb_payment_btn").removeAttr("onclick");

        if (promotion_code == 0) {
            $("#pc_payment_btn").attr("onclick", "code_100()");
            $("#mb_payment_btn").attr("onclick", "code_100()");
        } else {
            $("#pc_payment_btn").attr("onclick", "jsf__pay(document.order_info);");
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

function transfer() {
    var nation_no = "<?= $nation_no; ?>";

    var registration_idx = "<?= $registration_idx; ?>";
    var payment_methods = $("input[name=payment_methods]:checked").val();

    ajax_save();
    window.location.replace(PATH + "registration_account.php?idx=" + registration_idx + "&nation_no=" + nation_no);
}

function ajax_save() {
    var registration_idx = "<?= $registration_idx; ?>";
    var payment_methods = $("input[name=payment_methods]:checked").val();
    var data = new FormData();
    data.append("flag", "method_update");
    data.append("idx", registration_idx);
    data.append("payment_methods", payment_methods)

    $.ajax({
        url: PATH + "ajax/client/ajax_registration.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        contentType: false,
        processData: false,
        success: function(res) {
            if (res.code == 200) {

            } else if (res.code == 400) {
                alert(locale(language.value)("error_registration"));
                return false;
            } else if (res.code == 401) {
                alert(locale(language.value)("already_registration"));
                return false;
            } else {
                alert(locale(language.value)("reject_msg") + locale(language.value)("retry_msg"));
                return false;
            }
        }
    });
}
$(document).on("keyup", ".en_num_keyup", function(key) {
    var pattern_eng = /[^0-9||a-zA-Z\s||-]/gi;
    var _this = $(this);
    if (key.keyCode != 8) {
        var first_name = _this.val().replace(pattern_eng, '');
        _this.val(first_name);
    }
});
$(document).on("keyup", ".ko_en_keyup", function(key) {
    var pattern_eng = /[^a-zA-Z\s||ㄱ-ㅎ가-힣]/gi;
    var _this = $(this);
    if (key.keyCode != 8) {
        var first_name = _this.val().replace(pattern_eng, '');
        _this.val(first_name);
    }
});
</script>

<?php include_once('./include/footer.php');?>