<?php
header('Content-Type: text/html; charset=UTF-8');
include_once('./include/head.php');
include_once('./include/header.php');

//include "./plugin/NHNKCP/cfg/site_conf_inc.php";       // È¯°æ¼³Á¤ ÆÄÀÏ 


$member_idx = $_SESSION['USER']['idx'];
$registration_idx = $_GET["idx"];

//½Ç¼­¹ö¿¡¸¸ ÀÖÀ½
if ($_SERVER["HTTP_HOST"] == "www.iscp2023.org") {
    //echo "<script>location.replace('https://iscp2023.org/main/registration2.php?idx={$registration_idx}')</script>";
}

$_SESSION["registration"]["idx"] = $registration_idx;

if (!$registration_idx) {
    echo "<script>alert('Undefined registration number!'); window.location.replace('./registration.php');</script>";
    exit;
}
//°áÁ¦¹øÈ£ »ý¼º
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

// µ¥ÀÌÅÍ
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

$nation_no            = isset($registration_data["nation_no"]) ? $registration_data["nation_no"] : "-";

//2022-05-16 Ãß°¡
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
            $register_path_value .= "´ëÇÑ½ÉÇ÷°ü¾à¹°Ä¡·áÇÐÈ¸ È¨ÆäÀÌÁö ¶Ç´Â È«º¸¸ÞÀÏ</p>";
        } else if ($register_paths[$i] == 1) {
            $register_path_value .= "<p>ISCP È«º¸¸ÞÀÏ ¶Ç´Â °Ô½ÃÆÇ ±¤°í </p> ";
        } else if ($register_paths[$i] == 2) {
            $register_path_value .= "<p>ÃÊÃ»¿¬ÀÚ/ÁÂÀåÀ¸·Î ÃÊÃ»¹ÞÀ½ </p> ";
        } else if ($register_paths[$i] == 3) {
            $register_path_value .= "<p>ÀÌÀü ISCP¿¡ Âü¼®ÇÑ °æÇèÀÌ ÀÖÀ½ </p> ";
        } else if ($register_paths[$i] == 4) {
            $register_path_value .= "<p>Á¦¾àÈ¸»ç ¼Ò°³ </p> ";
        } else if ($register_paths[$i] == 5) {
            $register_path_value .= "<p>ÁöÀÎÀ» ÅëÇØ </p> ";
        } else if ($register_paths[$i] == 6) {
            $register_path_value .= "<p>ÀÎÅÍ³Ý °Ë»ö </p> ";
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

//2022-05-13 Ãß°¡
//ÀÌ°Å´Â ÇÁ·ÐÆ® ¿ë ´Ü º¯¼ö ¹Ø¿¡ payment_methods´Â º¤¿£µå¿ë
$payment_methods_select = $registration_data["payment_methods"] ?? null;
//2022-05-12 Ãß°¡
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
$phone                = isset($registration_data["phone"]) ? $registration_data["phone"] : "-";
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

// °¡°ÝÀÌ ¹«·áÀÎ °æ¿ì °áÁ¦ ¿Ï·á»óÅÂ·Î ¹Ù·Î º¯°æÇÔ
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
											4, 2, '¹«·á ½ÅÃ»', 2, 0, 0, 0, NOW(), NOW(), '{$member_idx}'
										)";
		sql_query($insert_payment_query);
		$payment_new_no = sql_insert_id();

		sql_query("UPDATE request_registration SET `status` = 2, payment_no = '{$payment_new_no}' WHERE idx = '{$registration_idx}'");
	}*/

//±Ý¾× º¯È¯
//$us_price = "1";
//$ko_price = "1000";
$us_price = $registration_data["price"];

$sql_during =    "SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];


//Æ¯Á¤ È¸¿ø °¡°Ý º¯µ¿ ÀÌÈÄ »èÁ¦
if ($registration_idx == 512) {
    $r_during_yn = 'N';
}

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

if ($promotion_code == 0 && $promotion_code != "") {
    $promotion_code_value = "ICoLA-77932";
    $price_payment = 0;
    $price = 0;
} else if ($promotion_code == 1) {
    $promotion_code_value = "ICoLA-59721";
    $price_payment = $price_payment / 2;
    $price = $price / 2;
} else if ($promotion_code == 2) {
    $promotion_code_value = "ICoLA-89359";
    $price_payment = $price_payment / 2;
    $price = $price / 2;
} else if ($promotion_code == 4) {
    $promotion_code_value = "ICoLA-83523";
    $price_payment = $price_payment / 2;
    $price = $price / 2;
}


$price_name = ($nation_no == 25) ? "¿ø" : "USD";


// KG INICIS °áÁ¦¸ðµâ Á¤º¸·Îµå
include_once(D9_PATH . "/plugin/KG_INICIS/inicis_loader.php");
?>

<?php
//¸ð¹ÙÀÏ¿ë
/* kcp¿Í Åë½ÅÈÄ kcp ¼­¹ö¿¡¼­ Àü¼ÛµÇ´Â °áÁ¦ ¿äÃ» Á¤º¸ */
$req_tx          = $_POST["req_tx"]; // ¿äÃ» Á¾·ù         
$res_cd          = $_POST["res_cd"]; // ÀÀ´ä ÄÚµå         
$tran_cd         = $_POST["tran_cd"]; // Æ®·£Àè¼Ç ÄÚµå     
$ordr_idxx       = $_POST["ordr_idxx"]; // ¼îÇÎ¸ô ÁÖ¹®¹øÈ£   
$good_name       = $_POST["good_name"]; // »óÇ°¸í            
$good_mny        = $_POST["good_mny"]; // °áÁ¦ ÃÑ±Ý¾×       
$buyr_name       = $_POST["buyr_name"]; // ÁÖ¹®ÀÚ¸í          
$buyr_tel1       = $_POST["buyr_tel1"]; // ÁÖ¹®ÀÚ ÀüÈ­¹øÈ£   
$buyr_tel2       = $_POST["buyr_tel2"]; // ÁÖ¹®ÀÚ ÇÚµåÆù ¹øÈ£
$buyr_mail       = $_POST["buyr_mail"]; // ÁÖ¹®ÀÚ E-mail ÁÖ¼Ò
$use_pay_method  = $_POST["use_pay_method"]; // °áÁ¦ ¹æ¹ý         
$enc_info        = $_POST["enc_info"]; // ¾ÏÈ£È­ Á¤º¸       
$enc_data        = $_POST["enc_data"]; // ¾ÏÈ£È­ µ¥ÀÌÅÍ     
$cash_yn         = $_POST["cash_yn"];
$cash_tr_code    = $_POST["cash_tr_code"];
/* ±âÅ¸ ÆÄ¶ó¸ÞÅÍ Ãß°¡ ºÎºÐ - Start - */
$param_opt_1    = $_POST["param_opt_1"]; // ±âÅ¸ ÆÄ¶ó¸ÞÅÍ Ãß°¡ ºÎºÐ
$param_opt_2    = $_POST["param_opt_2"]; // ±âÅ¸ ÆÄ¶ó¸ÞÅÍ Ãß°¡ ºÎºÐ
$param_opt_3    = $_POST["param_opt_3"]; // ±âÅ¸ ÆÄ¶ó¸ÞÅÍ Ãß°¡ ºÎºÐ
/* ±âÅ¸ ÆÄ¶ó¸ÞÅÍ Ãß°¡ ºÎºÐ - End -   */

$tablet_size     = "1.0"; // È­¸é »çÀÌÁî °íÁ¤
$url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

?>

<!--°áÁ¦ °ü·Ã css ldh Ãß°¡ 2022-04-20-->
<!-- <link href="./plugin/php_kcp_api_pay_sample/static/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/> -->
<style>
    /*2022-05-12 ldh Ãß°¡*/
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
    /* m_Completepayment  ¼³¸í                                      */
    /****************************************************************/
    /* ÀÎÁõ¿Ï·á½Ã Àç±Í ÇÔ¼ö                                         */
    /* ÇØ´ç ÇÔ¼ö¸íÀº Àý´ë º¯°æÇÏ¸é ¾ÈµË´Ï´Ù.                        */
    /* ÇØ´ç ÇÔ¼öÀÇ À§Ä¡´Â payplus.js º¸´Ù¸ÕÀú ¼±¾ðµÇ¾î¿© ÇÕ´Ï´Ù.    */
    /* Web ¹æ½ÄÀÇ °æ¿ì ¸®ÅÏ °ªÀÌ form À¸·Î ³Ñ¾î¿È                   */
    /****************************************************************/
    function m_Completepayment(FormOrJson, closeEvent) {
        var frm = document.order_info;

        /********************************************************************/
        /* FormOrJsonÀº °¡¸ÍÁ¡ ÀÓÀÇ È°¿ë ±ÝÁö                               */
        /* frm °ª¿¡ FormOrJson °ªÀÌ ¼³Á¤ µÊ frm °ªÀ¸·Î È°¿ë ÇÏ¼Å¾ß µË´Ï´Ù.  */
        /* FormOrJson °ªÀ» È°¿ë ÇÏ½Ã·Á¸é ±â¼úÁö¿øÆÀÀ¸·Î ¹®ÀÇ¹Ù¶ø´Ï´Ù.       */
        /********************************************************************/
        GetField(frm, FormOrJson);


        if (frm.res_cd.value == "0000") {
            //alert("°áÁ¦ ½ÂÀÎ ¿äÃ» Àü,\n\n¹Ýµå½Ã °áÁ¦Ã¢¿¡¼­ °í°´´ÔÀÌ °áÁ¦ ÀÎÁõ ¿Ï·á ÈÄ\n\n¸®ÅÏ ¹ÞÀº ordr_chk ¿Í ¾÷Ã¼ Ãø ÁÖ¹®Á¤º¸¸¦\n\n´Ù½Ã ÇÑ¹ø °ËÁõ ÈÄ °áÁ¦ ½ÂÀÎ ¿äÃ»ÇÏ½Ã±â ¹Ù¶ø´Ï´Ù."); //¾÷Ã¼ ¿¬µ¿ ½Ã ÇÊ¼ö È®ÀÎ »çÇ×.
            /*
            					 °¡¸ÍÁ¡ ¸®ÅÏ°ª Ã³¸® ¿µ¿ª
            */

            frm.submit();
        } else {
            alert("[" + frm.res_cd.value + "] " + frm.res_msg.value);

            closeEvent();
        }
    }
</script>
<!-- 23.06.07 HUBDNC_LSH º¯°æ PG»ç Á¤º¸ -->
<!--Å×½ºÆ® JS-->
<!-- <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script> -->
<!--¿î¿µ JS>-->
<script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8">
</script>
<script type="text/javascript">
    // 23.06.07 HUBDNC_LSH º¯°æ PG»ç °áÁ¦¹öÆ° ½ºÅ©¸³Æ® (PC)
    function paybtn() {
        INIStdPay.pay('SendPayForm_id');
    }

    // 23.06.07 HUBDNC_LSH º¯°æ PG»ç °áÁ¦¹öÆ° ½ºÅ©¸³Æ® (MOBILE)
    function on_pay() {

        let payment_methods = parseInt($("input[name=payment_methods]:checked").val());

        // payment methods ¼±ÅÃ¿¡ µû¶ó ¸ð¹ÙÀÏ P_INI_PAYMENT(ÁöºÒ¹æ½Ä) º¯°æ
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
		°áÁ¦Ã¢ È£Ãâ JS
		 °³¹ß : https://testpay.kcp.co.kr/plugin/payplus_web.jsp
		 ¿î¿µ : https://pay.kcp.co.kr/plugin/payplus_web.jsp
-->
<!--  <script type="text/javascript" src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"></script> -->
<script type="text/javascript" src="https://pay.kcp.co.kr/plugin/payplus_web.jsp"></script>
<!-- °Å·¡µî·Ï ÇÏ´Â kcp ¼­¹ö¿Í Åë½ÅÀ» À§ÇÑ ½ºÅ©¸³Æ®-->
<script type="text/javascript" src="./plugin/NHNKCP/mobile_sample/js/approval_key.js?v=0.2"></script>

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
                                    <!--¿©±â È¤½Ã ¸ð¸£´Ï ÁÖÀÇ-->
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
                                <td>
                                    Welcome Reception (17:10-20:00, 23 Nov (Thu), 2023): <?= $welcome_reception_yn ?>
                                    </br>
                                    Day 1 ? Luncheon Symposium (12:00-12:50, 23 Nov (Thu), 2023):
                                    <?= $day1_luncheon_yn ?> </br>
                                    Day 2 ? Breakfast Symposium (08:00-09:00, 24 Nov (Fri), 2023):
                                    <?= $day2_breakfast_yn ?> </br>
                                    Day 2 - Luncheon Symposium (12:00-12:50, 24 Nov (Fri), 2023):
                                    <?= $day2_luncheon_yn ?> </br>
                                    Day 3 ? Breakfast Symposium (08:00-09:00, 25 Nov (Sat), 2023):
                                    <?= $day3_breakfast_yn ?> </br>
                                    Day 3 - Luncheon Symposium (12:05-12:55, 25 Nov (Sat), 2023):
                                    <?= $day3_luncheon_yn ?> </br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    if ($nation_no == 25) {
                                    ?>
                                        <p class="bold">ISCP 2023 °³ÃÖ Á¤º¸¸¦ ¾î¶»°Ô ¾Ë°Ô µÇ¼Ì³ª¿ä?</p>
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
                                                    <input <?= $payment_methods_select == 0 ? "checked" : ""; ?> type="radio" class="radio required" id="pay_type1" name="payment_methods" value="0">
                                                    <label for="pay_type1"><?= ($nation_no != 25) ? "Credit Card" : "Ä«µå °áÁ¦"; ?></label>
                                                </li>
                                                <li>
                                                    <input <?= $payment_methods_select == 1 ? "checked" : ""; ?> type="radio" class="radio required" id="pay_type2" name="payment_methods" value="1">
                                                    <label for="pay_type2"><?= ($nation_no != 25) ? "Bank Transfer" : "°èÁÂ ÀÌÃ¼"; ?></label>
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
                <!-- ±âÁ¸ ¹öÆ° ¸¶Å©¾÷
				<div class="btn_wrap">
					<button type="button" class="btn submit" onclick="kgpay();"><?= $locale("d_payment_btn") ?></button>
					<?php if ($_SESSION["language"] != "ko") { ?>
						<button type="button" class="btn submit" onclick="payment();"><?= $locale("payment_btn") ?></button>
					<?php } ?>
				</div>-->
                <!-- 220324 ±âÁ¸¿¡´Â °áÁ¦¹æ½ÄÀÌ '±¹³»/ÇØ¿Ü'·Î ºÐ¸®µÇ¾úÀ¸³ª, ÇöÀç´Â 1°³ÀÇ ¹öÆ°À¸·Î ÅëÀÏµÊ (HUBDNC LJH2)-->

                <!--  23.06.0 HUBDNC_LSH PC °áÁ¦¹öÆ° ±â´É   -->
                <div class="pager_btn_wrap pc_only centerT pager_btn_wrap half">
                    <button type="button" class="btn green_btn pc-wd-3" onclick="prev(<?= $registration_idx; ?>)">Prev</button>

                    <?php
                    if ($payment_methods_select == 0) {
                        if ($nation_no == 25) {
                            //100% ÇÒÀÎ
                    ?>
                            <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="paybtn()">
                                Payment
                            </button>
                        <?php
                        } else {
                        ?>
                            <!-- ±âÁ¸ : jsf__pay(document.order_info) / Å×½ºÆ® º¯°æ : paybtn() )  -->
                            <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="alert('prepare...')">
                                Payment
                            </button>
                        <?php
                        }
                    } else {
                        if ($nation_no == 25) {
                        ?>
                            <!-- ±âÁ¸ : code_100() / Å×½ºÆ® º¯°æ : paybtn() )  -->
                            <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="transfer(<?= $nation_no; ?>)">
                                Payment
                            </button>
                        <?php
                        } else {
                        ?>
                            <!-- ±âÁ¸ : transfer() / Å×½ºÆ® º¯°æ : paybtn() )  -->
                            <button id="pc_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="transfer(<?= $nation_no; ?>)">
                                Payment
                            </button>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!--  23.06.0 HUBDNC_LSH ¸ð¹ÙÀÏ °áÁ¦¹öÆ° ±â´É          -->
                <div class=" pager_btn_wrap mb_only centerT pager_btn_wrap half">
                    <button type="button" class="btn green_btn pc-wd-3" onclick="prev(<?= $registration_idx; ?>)">Prev</button>
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
                            <!-- ±âÁ¸ : mb_click() / Å×½ºÆ® º¯°æ : paybtn() )  -->
                            <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="alert('prepare...')">
                                Payment
                            </button>
                        <?php

                        }
                    } else {
                        if ($nation_no == 25) {
                        ?>
                            <!-- ±âÁ¸ : code_100() / Å×½ºÆ® º¯°æ : paybtn() )  -->
                            <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="transfer(<?= $nation_no; ?>)">
                                Payment
                            </button>
                        <?php
                        } else {
                        ?>
                            <!-- ±âÁ¸ : transfer() / Å×½ºÆ® º¯°æ : paybtn() )  -->
                            <button id="mb_payment_btn" type="button" class="btn green_btn pc-wd-3" onclick="transfer(<?= $nation_no; ?>)">
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

    <!-- 23.06.07 HUBDNC_LSH º¯°æ ÈÄ PG»ç ÆÄ¶ó¹ÌÅÍ Àü¼Û form (PC)-->
    <form id="SendPayForm_id" name="" method="POST" accept-charset="EUC-KR" class="mt-5">
        <!-- ÇÊ¼ö -->
        <input type="hidden" name="version" value="1.0">
        <input type="hidden" name="mid" value="<?= $mid ?>">
        <input type="hidden" name="goodname" value="ISCP 2023">
        <input type="hidden" name="oid" value="<?= $orderNumber ?>">
        <input type="hidden" name="price" value="<?= $price ?>">
        <input type="hidden" name="currency" value="WON">
        <input type="hidden" name="buyername" value="ISCP 2023">
        <input type="hidden" name="buyertel" value="01012345678">
        <input type="hidden" name="buyeremail" value="<?= $email ?>">
        <input type="hidden" name="timestamp" value="<?= $timestamp ?>">
        <input type="hidden" name="signature" value="<?= $sign ?>">
        <input type="hidden" name="returnUrl" value="https://iscp2023.org/main/plugin/KG_INICIS/result.php">
        <input type="hidden" name="closeUrl" value="https://iscp2023.org/main/plugin/KG_INICIS/close.php">
        <input type="hidden" name="mKey" value="<?= $mKey ?>">

        <!-- ±âº»¿É¼Ç -->
        <input type="hidden" name="gopaymethod" value="Card">
        <input type="hidden" name="acceptmethod" value="HPP(1):below1000:centerCd(Y)">
        <input type="hidden" name="use_chkfake" value="<?= $use_chkfake ?>">
        <input type="hidden" name="verification" value="<?= $sign2 ?>">
    </form>

    <!-- 23.06.07 HUBDNC_LSH º¯°æ ÈÄ PG»ç ÆÄ¶ó¹ÌÅÍ Àü¼Û form (MOBILE)-->
    <form name="mobileweb" id="" method="post" class="mt-5" accept-charset="euc-kr">
        <input type="hidden" name="P_INI_PAYMENT" value="">
        <input type="hidden" name="P_MID" value="iscpkrcvph">
        <input type="hidden" name="P_OID" value="mobile_test1234">
        <input type="hidden" name="P_AMT" value="<?= $price ?>">
        <input type="hidden" name="P_GOODS" value="ISCP">
        <input type="hidden" name="P_UNAME" value="ISCP">
        <input type="hidden" name="P_MOBILE" value="<?= $phone ?>">
        <input type="hidden" name="P_EMAIL" value="<?= $email ?>">
        <input type="hidden" name="P_CHARSET" value="utf8">
        <input type="hidden" name="P_RESERVED" value="below1000=Y&vbank_receipt=Y&centerCd=Y">
        <!-- <input type="hidden" name="P_NEXT_URL" value="https://iscp2023.org/main/registration3_test.php"> -->
    </form>
</section>
<script src="./js/script/client/registration.js"></script>
<script>
    function prev(idx) {
        window.location.replace("registration.php?idx=" + idx);
    }

    /* 23.06.07 HUBDNC_LSH ±âÁ¸ ÀÛ¼ºµÈ ºÎºÐ ÁÖ¼® Ã³¸® */

    function code_100() {
        var registration_idx = "<?php //= $registration_idx; 
                                ?>//";
        var nation_no = "<?php //= $nation_no 
                            ?>//";

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
        var registration_idx = "<?php //= $registration_idx; 
                                ?>//";

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

        var registration_idx = "<?php //= $registration_idx; 
                                ?>//";
        var hidden_code = $("input[name=hidden_code]").val();

        if (!hidden_code || hidden_code == 3) {
            alert("Please check the promotion code");
            return;
        }

        var recommended_by = $("input[name=recommended_by]").val().trim();
        var recommended_by_trim = "";

        //ÃßÃµÀÎ À¯È¿¼º
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


    /* 23.06.07 HUBDNC_LSH ±âÁ¸ ÀÛ¼ºµÈ ºÎºÐ ÁÖ¼® Ã³¸® */
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

    function ajax_save() {
        var registration_idx = "<?php $registration_idx;
                                ?>";
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
        var pattern_eng = /[^a-zA-Z\s||¤¡-¤¾°¡-ÆR]/gi;
        var _this = $(this);
        if (key.keyCode != 8) {
            var first_name = _this.val().replace(pattern_eng, '');
            _this.val(first_name);
        }
    });
</script>

<?php include_once('./include/footer.php'); ?>