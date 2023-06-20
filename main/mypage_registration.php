<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<?php

$user_idx = $member["idx"] ?? -1;

// [22.04.25] 미로그인시 처리
if ($user_idx <= 0) {
    echo "<script>alert('Need to login'); location.replace(PATH+'login.php');</script>";
    exit;
}

echo "
		<!--
	";
print_r($_SESSION);
echo "
		-->
	";

$nation_list = get_data($_nation_query);

$select_user_registration_query = "
		SELECT
			reg.idx, reg.email, reg.nation_no, reg.first_name, reg.last_name, reg.affiliation, reg.phone, reg.department, reg.member_type, DATE(reg.register_date) AS register_date, reg.status,
			p.idx AS payment_idx, p.total_price_kr, p.total_price_us, p.payment_no, p.order_no, p.deposit_price, reg.payment_methods, reg.promotion_code, reg.price AS before_price,
			(CASE
				WHEN reg.attendance_type = 0
				THEN 'Offline'
				WHEN reg.attendance_type = 1
				THEN 'Online'
				WHEN reg.attendance_type = 2
				THEN 'Online + Offline'
				ELSE '-'
			END) AS attendance_type
		FROM request_registration reg
		LEFT JOIN payment p
		ON reg.payment_no = p.idx
		WHERE reg.register = {$user_idx}
		AND reg.is_deleted = 'N'
		ORDER BY reg.register_date DESC
	";

$registration_list = get_data($select_user_registration_query);

$member_nation_query = "SELECT
								nation_no
							FROM member
							WHERE idx = {$user_idx}";

$member_nation_no = sql_fetch($member_nation_query)["nation_no"];

$sql_during =    "SELECT
						IF(DATE(NOW()) >= '2022-09-18', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

$sql_during =    "SELECT
						IF(NOW() > '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$rr_during_yn = sql_fetch($sql_during)['yn'];


if (!empty($_SESSION["USER"])) {
    $ksola_member_status = $member['ksola_member_status'];
} else {
    echo "<script>alert('Need to login'); window.location.replace(PATH+'login.php');</script>";
    exit;
}

?>
<style>
/*165번 줄에 인라인 css 있음 2022-04-21*/
.non_click {
    cursor: default;
}
</style>
<section class="container mypage sub_page">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2><?= $locale("mypage") ?></h2>
                <ul>
                    <li>Home</li>
                    <li><?= $locale("mypage") ?></li>
                    <li>Registration</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <!-- <div class="sub_banner"> -->
        <!--	 <h1>Mypage</h1> -->
        <!-- </div> -->
        <div class="x_scroll tab_scroll">
            <ul class="tab_pager location">
                <li><a href="./mypage.php"><?= $locale("mypage_account") ?></a></li>
                <li class="on"><a href="./mypage_registration.php"><?= $locale("mypage_registration") ?></a></li>
                <li><a href="./mypage_abstract.php"><?= $locale("mypage_abstract") ?></a></li>
                <li><a href="./mypage_favorite.php"><?= $locale("mypage_favorite") ?></a></li>
            </ul>
        </div>
        <div>
            <div class="x_scroll">
                <table class="table table_responsive">
                    <thead>
                        <tr>
                            <th><?= $locale("status") ?></th>
                            <th><?= $locale("registration_name") ?></th>
                            <th><?= $locale("registration_category") ?></th>
                            <!-- <th><?= $locale("online_offline") ?></th> -->
                            <th><?= $locale("registration_fee") ?></th>
                            <th><?= $locale("date_of_register") ?></th>
                            <th><?= $locale("management") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($registration_list as $list) {

                            $before_price = $list["before_price"];

                            //특정 회원 가격 변동 이후 삭제
                            if ($list['idx'] == 512) {
                                $rr_during_yn = 'N';
                            }

                            if ($rr_during_yn == 'Y') {
                                if ($before_price == 300) {
                                    $before_price = 300;
                                } else if ($before_price == 150) {
                                    $before_price = 100;
                                } else if ($before_price == 120000) {
                                    $before_price = 50000;
                                } else if ($before_price == 100000) {
                                    $before_price = 50000;
                                }
                                else if ($before_price == 60000) {
                                    $before_price = 10000;
                                }
                            }

                            $before_price_text = number_format($before_price);
                            $promotion_code = $list["promotion_code"] ?? -1;

                            $unit_code = ($before_price > 1000) ? "￦" : "$";
                            if ($promotion_code == 0 && $promotion_code != "") {
                                $before_price = 0;
                            } else if ($promotion_code == 1 || $promotion_code == 2 || $promotion_code == 4) {
                                $before_price /= 2;
                            }
                            $before_price = $unit_code . " " . number_format($before_price);

                            $payment_no = $list["payment_no"];
                            $order_no = $list["order_no"];
                            $deposit_price = $list["deposit_price"];
                            $nation_no = $list["nation_no"];
                            $payment_url = "javascript:;";
                            //$popup_class = "revise_pop_btn";
                            $popup_class = "non_click";
                            $disabled = "disabled";

                            if ($list["status"] == 2) {
                                $price = $list["total_price_kr"] != "" ? "￦ " . number_format($list["total_price_kr"]) : ($list["total_price_us"] != "" ? "$ " . number_format($list["total_price_us"]) : $before_price);
                            } else {
                                $price = $before_price;
                            }

                            if ($list["idx"] == 608) { // member_idx = 137
                                $price = "$ 75";
                            }


                            // if($list["status"] != ""){
                            switch ($list["status"]) {
                                case 1:
                                    $status_type = $member_nation_no != 25 ? "Holding" : "결제대기";
                                    $status_type_en = "Holding";
                                    $payment_url = "./registration2.php?idx=" . $list["idx"];
                                    $popup_class = "";
                                    $disabled = "";
                                    break;
                                case 2:
                                    $status_type = $member_nation_no != 25 ? "Payment Received" : "결제완료";
                                    $status_type_en = "Payment Received";
                                    $disabled = "";
                                    break;
                                case 3:
                                    $status_type = $member_nation_no != 25 ? "Request Refund" : "환불 요청";
                                    $status_type_en = "Request Refund";
                                    break;
                                case 4:
                                    $status_type = $member_nation_no != 25 ? "Refunded" : "환불";
                                    $status_type_en = "Refunded";
                                    break;
                                case 0:
                                    $status_type = $member_nation_no != 25 ? "Canceled" : "등록 취소";
                                    $status_type_en = "Canceled";
                                    break;
                            }
                            // }else{
                            //	 $status_type = $language == "en" ? "holding" : "결제대기";
                            //	 $payment_url = "./registration2.php?idx=".$list["idx"];
                            //	 $popup_class = "";
                            //	 $disabled = "";
                            // }

                            if ($list["payment_methods"] == 1 && $list["status"] == 1) {
                                $payment_url = "./registration_account.php?idx=" . $list["idx"] . "&nation_no=" . $nation_no;
                            }

                            echo '<tr class="centerT">';
                            echo     '<td>' . $status_type . '</td>';
                            echo     '<td><a href="' . $payment_url . '" class="' . $popup_class . '" data-idx="' . $list["idx"] . '">ISCP 2023</a></td>';
                            echo     '<td>' . $list["member_type"] . '</td>';
                            //echo	 '<td>'.$list["attendance_type"].'</td>';
                            /*if($list["payment_methods"] == 0){
								echo	 '<td>'.$locale("payment_card_tit").'</td>';
							}else if($list["payment_methods"] == 1){
								echo	 '<td>'.$locale("payment_bank_tit").'</td>';
							}*/
                            echo     '<td>' . $price . '</td>';
                            echo     '<td>' . $list["register_date"] . '</td>';

                            if ($list["status"] == "1") {
                                echo     '<td>';
                                echo    '	<button type="button" class="btn payment_btn" data-url="' . $payment_url . '" ' . $disabled . '>Payment</button>';
                                //echo	'	<button type="button" class="btn cancel_btn" data-idx="'.$list["idx"].'" '.$disabled.'>Cancel</button>';
                                echo    '</td>';
                            } else if ($list["status"] == "0") {
                                echo     '<td>Canceled</td>';
                            } else if ($list["status"] == "2") {
                                echo     '<td>';
                                if ($list["payment_methods"] == 0 && $promotion_code != 0) {
                                    if ($r_during_yn == 'Y') {
                                        echo '<button style="height:50px;" type="button" class="btn deposit_btn" onclick="registration_btn(' . $list["idx"] . ')">Certificate</button><br><br>';
                                    }
                                    echo '<button style="height:50px;" type="button" class="btn deposit_btn review_btn" data-payment_no="' . $payment_no . '" data-order_no="' . $order_no . '" data-deposit_price="' . $deposit_price . '" onclick="receiptView()">Payment <br>Receipt</button>';
                                } else {
                                    if ($r_during_yn == 'Y') {
                                        echo '<button style="height:50px;" type="button" class="btn deposit_btn" onclick="registration_btn(' . $list["idx"] . ')">Certificate</button>';
                                    } else {
                                        echo 'Payment Received';
                                    }
                                }
                                //echo		'<button type="button" class="btn refund_btn" data-status="'.$list["payment_status"].'" data-idx="'.$list["idx"].'" '.$disabled.'>cancel</button>';
                                echo     '</td>';
                            } else {
                                echo     '<td>' . $status_type_en . '</td>';
                            }

                            echo '</tr>';
                        }

                        if (count($registration_list) < 1) {
                            echo '<tr><td colspan="7" class="centerT">Empty registration</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- <div class="left"><p class="title">영수증 확인</p></div> -->
    <!-- <div class="right"> -->
    <!-- 	<div class="ipt-type-1 pc-wd-2"> -->
    <!-- 		<a href="javascript:receiptView('<?= $tno ?>','<?= $ordr_idxx ?>','<?= $amount ?>')"><span style="color:blue">영수증을 확인합니다.</span></a> -->
    <!-- 	</div> -->
    <!-- </div> -->


    <div class="popup revise_pop">
        <div class="pop_bg"></div>
        <div class="pop_contents">
            <button type="button" class="pop_close"><img src="./img/icons/pop_close.png"></button>
            <input type="hidden" name="registration_idx" value="">
            <h3 class="pop_title">Participant Information</h3>
            <form name="registration_form">
                <div class="pc_only">
                    <table class="table detail_table">
                        <colgroup>
                            <col class="col_th" />
                            <col width="*" />
                        </colgroup>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("id") ?></th>
                            <td><input type="text" name="email" readonly></td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("country") ?></th>
                            <td>
                                <select class="update" name="nation_no" id="nation_no"
                                    onchange="nation_change(this.value)">
                                    <option selected>Choose </option>
                                    <?php
                                    foreach ($nation_list as $list) {
                                        $nation = $language == "en" ? $list["nation_en"] : $list["nation_ko"];
                                        echo "<option data-nt=" . $list['nation_tel'] . " value='" . $list["idx"] . "'>" . $nation . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("name") ?></th>
                            <td class="name_td clearfix">
                                <div class="max_normal">
                                    <input name="first_name" type="text" placeholder="First name">
                                </div>
                                <div class="max_normal">
                                    <input name="last_name" type="text" placeholder="Last name">
                                </div>
                            </td>
                        </tr>
                        <!-- <tr> -->
                        <!-- 	<th><?= $locale("first_name") ?> *</th> -->
                        <!-- 	<td><input type="text" name="first_name" value="Jihye" readonly></td> -->
                        <!-- </tr> -->
                        <!-- <tr> -->
                        <!-- 	<th><?= $locale("last_name") ?> *</th> -->
                        <!-- 	<td><input type="text" name="last_name" value="Lee" readonly></td> -->
                        <!-- </tr> -->
                        <tr>
                            <th><?= $locale("affiliation") ?></th>
                            <td><input class="update" type="text" name="affiliation"></td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("phone") ?></th>
                            <td>
                                <div class="clearfix phone">
                                    <select name="nation_tel">
                                        <option selected disabled></option>
                                    </select>
                                    <input type="text" name="phone" placeholder="010-0000-0000">
                            </td>
                </div>
                </td>
                </tr>
                <tr>
                    <th><?= $locale("department") ?></th>
                    <td><input class="update" type="text" name="department"></td>
                </tr>
                <!-- <tr> -->
                <!-- 	<th><?= $locale("licence_number") ?></th> -->
                <!-- 	<td><input class="update" type="text" name="licence_number"></td> -->
                <!-- </tr> -->
                <!-- <tr> -->
                <!-- 	<th><?= $locale("academy_number") ?></th> -->
                <!-- 	<td><input class="update" type="text" name="academy_number"></td> -->
                <!-- </tr> -->
                </table>
        </div>
        <div class="mb_only">
            <ul class="sign_list content_none">
                <li>
                    <p class="label"><span class="red_txt">*</span><?= $locale("id") ?></p>
                    <div>
                        <input type="text" name="mo_email" class="required" maxlength="50" readonly>
                    </div>
                </li>
                <li>
                    <p class="label"><span class="red_txt">*</span><?= $locale("country") ?></p>
                    <div>
                        <select class="update" name="mo_nation_no" id="mo_nation_no"
                            onchange="nation_change(this.value)">
                            <option selected>Choose </option>
                            <?php
                            foreach ($nation_list as $list) {
                                $nation = $language == "en" ? $list["nation_en"] : $list["nation_ko"];
                                echo "<option value='" . $list["idx"] . "'>" . $nation . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </li>
                <li>
                    <p class="label"><span class="red_txt">*</span><?= $locale("name") ?></p>
                    <div class="half_form clearfix">
                        <input type="text" name="mo_first_name" placeholder="First name">
                        <input type="text" name="mo_last_name" placeholder="Last name">
                    </div>
                </li>
                <li>
                    <p class="label"><?= $locale("affiliation") ?></p>
                    <div>
                        <input class="update" type="text" name="mo_affiliation">
                    </div>
                </li>
                <li>
                    <p class="label"><span class="red_txt"></span><?= $locale("phone") ?></p>
                    <div class="phone">
                        <select name="mo_nation_tel">
                            <option selected></option>
                        </select>
                        <input type="text" name="mo_phone" placeholder="010-0000-0000"></td>
                    </div>
                </li>
                <li>
                    <p class="label"><?= $locale("department") ?></p>
                    <div>
                        <input class="update" type="text" name="mo_department">
                    </div>
                </li>
                <!-- <li> -->
                <!-- 	<p class="label"><?= $locale("licence_number") ?></p> -->
                <!-- 	<div> -->
                <!-- 		<input class="update" type="text" name="licence_number"> -->
                <!-- 	</div> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- 	<p class="label"><?= $locale("academy_number") ?></p> -->
                <!-- 	<div> -->
                <!-- 		<input class="update" type="text" name="academy_number"> -->
                <!-- 	</div> -->
                <!-- </li> -->
            </ul>
        </div>
        </form>
        <div class="btn_wrap">
            <button type="button" class="btn update_btn"><?= $locale("save_btn") ?></button>
        </div>
    </div>
    </div>

    <div class="popup payment_pop">
        <div class="pop_bg"></div>
        <div class="pop_contents">
            <button type="button" class="pop_close"><img src="./img/icons/pop_close.png"></button>
            <h3 class="pop_title">Payment Receipt</h3>
            <img src="./img/img_payment01.png" alt="">
            <div class="btn_wrap">
                <button type="button" class="btn update_btn"><?= $locale("save_btn") ?></button>
            </div>
        </div>
    </div>

</section>
<script src="./js/script/client/registration.js?v=0.2"></script>
<script>
$(document).ready(function() {
    $(window).off("beforeunload");
});

//등록증 띄우기
function registration_btn(idx) {
    //$(".receipt_pop").show();
    var url =
        "https://iscp2023.org/main/pre_registration_confirm.php?key=<?= explode('@', $_SESSION['USER']['email'])[0] ?>&idx=" +
        idx;
    window.open(url, "Certificate", "width=1145, height=900, top=30, left=30");
};

$('.revise_pop_btn').on('click', function() {
    var idx = $(this).data("idx");
    $.ajax({
        url: PATH + "ajax/client/ajax_registration.php",
        type: "POST",
        data: {
            flag: "registration_information",
            idx: idx
        },
        dataType: "JSON",
        success: function(res) {
            //console.log(res);
            if (res.code == 200 && res.data) {
                var mo = "";

                if (Mobile() == true) {
                    mo = "mo_";
                }

                //var nation_tel = res.data.phone.split("-")[0];
                //var _phone = res.data.phone.split("-");
                //var _remove = _phone.splice(0,1);
                //	var phone = _phone.join("-");
                if (res.data.payment_status == 0 || res.data.payment_status == 3 || res.data
                    .payment_status == 4) {
                    $(".revise_pop input").attr("readonly", true);
                    $(".revise_pop select").attr("disabled", true);
                    $(".update_btn").attr("disabled", true);
                } else {
                    $(".update").attr("readonly", false);
                    $(".revise_pop select").attr("disabled", false);
                    $(".update_btn").attr("disabled", false);
                }
                $("input[name=registration_idx]").val(res.data.idx);
                $("input[name=" + mo + "email]").val(res.data.email);
                $("option[value=" + res.data.nation_no + "]").attr("selected", true);
                $("input[name=" + mo + "first_name]").val(res.data.first_name);
                $("input[name=" + mo + "last_name]").val(res.data.last_name);

                //$("select[name="+mo+"nation_tel] option").text(res.data.nation_tel);

                //$("input[name="+mo+"phone]").val(phone);
                $("input[name=" + mo + "affiliation]").val(res.data.affiliation);
                $("input[name=" + mo + "department]").val(res.data.department);
                //$("input[name=licence_number]").val(res.data.licence_number);
                //$("input[name=academy_number]").val(res.data.academy_number);
                $('.revise_pop').show();
            } else if (res.code == 400) {
                return false;
            }
        }
    });

});

//모바일 여부
$(".update_btn").on("click", function() {
    var mo = "";
    if (Mobile() == true) {
        mo = "mo_";
    }

    var idx = $("input[name=registration_idx]").val();
    var nation_no = $("#" + mo + "nation_no option:selected").val();
    var first_name = $("input[name=" + mo + "first_name]").val();
    var last_name = $("input[name=" + mo + "last_name]").val();
    var affiliation = $("input[name=" + mo + "affiliation]").val();
    var nation_tel = $("select[name=" + mo + "nation_tel] option").text();

    var phone = $("input[name=" + mo + "phone]").val();
    var department = $("input[name=" + mo + "department]").val();

    if (nation_no == "" || nation_no == null) {
        alert("check_Country");
        return;
    }
    if (first_name == "" || first_name == null) {
        alert("check_Country");
        return;
    }
    if (last_name == "" || last_name == null) {
        alert("check_Country");
        return;
    }

    if (confirm(locale(language.value)("registration_modify_msg"))) {
        $.ajax({
            url: PATH + "ajax/client/ajax_registration.php",
            type: "POST",
            data: {
                flag: "update_registration",
                idx: idx,
                nation_no: nation_no,
                first_name: first_name,
                last_name: last_name,
                affiliation: affiliation,
                nation_tel: nation_tel,
                phone: phone,
                department: department
            },
            dataType: "JSON",
            success: function(res) {
                if (res.code == 200) {
                    alert(locale(language.value)("complet_registration_cancel"));
                    location.reload();
                } else if (res.code == 400) {
                    alert(locale(language.value)("error_registration_cancel"));
                    return false;
                } else if (res.code == 401) {
                    alert(locale(language.value)("invalid_auth"));
                    return false;
                } else if (res.code == 402) {
                    alert(locale(language.value)("invalid_registration_status"));
                    return false;
                } else {
                    alert(locale(language.value)("reject_msg"));
                    return false;
                }
            }
        });
    }

});

$(".payment_btn").on("click", function() {
    var paymentUrl = $(this).data("url");
    window.location.href = paymentUrl;
});

$(".cancel_btn").on("click", function() {
    var idx = $(this).data("idx");
    if (confirm(locale(language.value)("registration_cancel_msg"))) {
        $.ajax({
            url: PATH + "ajax/client/ajax_registration.php",
            type: "POST",
            data: {
                flag: "cancel",
                idx: idx
            },
            dataType: "JSON",
            success: function(res) {
                if (res.code == 200) {
                    alert(locale(language.value)("complet_registration_cancel"));
                    location.reload();
                } else if (res.code == 400) {
                    alert(locale(language.value)("error_registration_cancel"));
                    return false;
                } else if (res.code == 401) {
                    alert(locale(language.value)("invalid_auth"));
                    return false;
                } else if (res.code == 402) {
                    alert(locale(language.value)("invalid_registration_status"));
                    return false;
                } else {
                    alert(locale(language.value)("reject_msg"));
                    return false;
                }
            }
        });
    }
});

$(".refund_btn").on("click", function() {
    var payment_status = $(this).data("status");
    var idx = $(this).data("idx");
    if (confirm(locale(language.value)("registration_refund_msg"))) {
        $.ajax({
            url: PATH + "ajax/client/ajax_registration.php",
            type: "POST",
            data: {
                flag: "refund",
                payment_status: payment_status,
                idx: idx
            },
            dataType: "JSON",
            success: function(res) {
                if (res.code == 200) {
                    alert(locale(language.value)("complet_registration_refund"));
                    location.reload();
                } else if (res.code == 400) {
                    alert(locale(language.value)("error_registration_refund"));
                    return false;
                } else if (res.code == 401) {
                    return false;
                } else if (res.code == 402) {
                    return false;
                } else {
                    alert(locale(language.value)("reject_msg"));
                    return false;
                }
            }
        });
    }
});

//국가 선택시 자동 국가번호 삽입
//국가 선택 시 국가번호 append
$("select[name=nation_no]").on("change", function() {
    var nation = $(this).find("option:selected").val();
    var nation_tel_length = $("select[name=nation_tel] option").length;
    $.ajax({
        url: PATH + "ajax/ajax_nation.php",
        type: "POST",
        data: {
            flag: "nation_tel",
            nation: nation
        },
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                if (nation_tel_length => 2) {
                    $("select[name=nation_tel] option").not(":eq(0)").detach();
                    $("select[name=nation_tel]").append("<option selected>" + res.tel +
                        "</option>");
                } else {
                    $("select[name=nation_tel]").append("<option selected>" + res.tel +
                        "</option>");
                }
            }
        }
    });
});

function Mobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
</script>
<script type="text/javascript">
/* 신용카드 영수증 */
/* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" */
/* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" */
function receiptView() {
    var tno = $(".review_btn").data("payment_no");
    var ordr_idxx = $(".review_btn").data("order_no");
    var amount = $(".review_btn").data("deposit_price");

    /*
    var tno2 = "22361973505609";
    var ordr_idxx2 = "TEST1234567890";
    var amount2 = "80000";
    */

    receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=";
    receiptWin += tno + "&";
    receiptWin += "order_no=" + ordr_idxx + "&";
    receiptWin += "trade_mony=" + amount;


    window.open(receiptWin, "", "width=455, height=815");
}

/* 현금 영수증 */
/* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do" */
/* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillActionNew.do" */
function receiptView2(cash_no, ordr_idxx, amount) {
    receiptWin2 = "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do";
    receiptWin2 += cash_no + "&";
    receiptWin2 += "order_id=" + ordr_idxx + "&";
    receiptWin2 += "trade_mony=" + amount;

    window.open(receiptWin2, "", "width=370, height=625");
}

/* 가상 계좌 모의입금 페이지 호출 */
/* 테스트시에만 사용가능 */
/* 실결제시 해당 스크립트 주석처리 */
//function receiptView3() 
//{
//	receiptWin3 = "http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti.jsp"; 
//	window.open(receiptWin3, "", "width=520, height=300"); 
//}
</script>
<?php include_once('./include/footer.php'); ?>