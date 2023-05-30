<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<?php
//$nation_query = $_nation_query; 

$nation_query = "SELECT
						*
					FROM nation
					ORDER BY 
					idx = 25 DESC, nation_en ASC";

$nation_list = get_data($nation_query);
?>

<style>
/*ldh 작성*/
.red_alert {
    display: none;
}

.mo_red_alert {
    display: none;
}

.red_alert_option {
    /*display:none;*/
}

.korea_only,
.korea_radio {
    display: none;
}

.korea_only.on,
.korea_radio.on {
    display: revert;
}

.mo_korea_only,
.korea_radio {
    display: none;
}

.mo_korea_only.on,
.korea_radio.on {
    display: revert;
}

.ksola_signup {
    display: none;
}

.mo_ksola_signup {
    display: none;
}

.ksola_signup.on {
    display: revert;
}

.mo_ksola_signup.on {
    display: revert;
}

/*태그 오른쪽 정렬*/
.checkbox_wrap {
    padding-top: 30px;
}

.checkbox_wrap ul {
    text-align: right;
}

.checkbox_wrap li {
    display: inline-block;
}

.checkbox_wrap li:last-child {
    margin-left: 20px;
}

.mo_other_radio {
    display: none;
}


/*2022-05-09*/
.select_others {
    margin-bottom: 5px;
}

.input_others {
    display: none;
    width: 100px;
    float: right;

}

/* 2022-05-10 HUBDNC LJH2 수정 */
.pc_only input.tel_number {
    width: 96px;
}

.pc_only input.tel_numbers {
    width: 115px;
    margin-left: 2px;
}

.mb_only input.tel_numbers {
    margin-left: 10px;
}

.mb_only input.tel_number,
.mb_only input.tel_numbers.tel_phone {
    width: 100px;
}

.mb_only input.tel_numbers.tel_phone2 {
    width: calc(100% - 220px);
}

@media screen and (max-width: 480px) {

    .mb_only input.tel_number,
    .mb_only input.tel_numbers.tel_phone {
        width: calc(50% - 5px);
    }

    .mb_only input.tel_numbers.tel_phone2 {
        width: 100%;
        margin: 10px 0 0;
    }
}
</style>
<script>
$(document).ready(function() {
    $("#user1").change(function() {
        if ($("#user1").prop('checked') == true) {
            $(".ksola_signup").addClass("on");
        }
    });
    $("#user2").change(function() {
        if ($("#user2").prop('checked') == true) {
            $(".ksola_signup").removeClass("on");
        }
    });

    $("select[name=nation_no]").change(function() {

        var value = $(this).val();

        if (value == 25) {
            $(".red_alert").eq(0).html("");
            $(".red_alert").eq(1).html("");
            $(".red_alert").eq(2).html("");
            $(".red_alert").eq(3).html("");
            $(".red_alert").eq(4).html("");

            $(".korea_only").addClass("on");
            $(".korea_radio").addClass("on");
        } else {
            $(".korea_radio").removeClass("on");
            $(".korea_only").removeClass("on");
            $(".ksola_signup").removeClass("on");

            remove_value();
            $("#user3").prop('checked', true);
        }

        var nt = $("#nation_no option:selected").data("nt");
        $("input[name=nation_tel]").val(nt);
        $("input[name=tel_nation_tel]").val(nt);

        if (nt != 82) {
            $(".red_alert").eq(0).html("good");
            $(".red_alert").eq(1).html("good");
            $(".red_alert").eq(2).html("good");
            $(".red_alert").eq(3).html("good");
            $(".red_alert").eq(4).html("good");
        }
    });


    $("input[name=food]").change(function() {

        var this_chk = $(this).val();
        if (this_chk == "Others") {
            $(".other_radio").next("label").find("input").addClass("on");
        } else {
            $(".other_radio").next("label").find("input").removeClass("on");
        }
    });

    $(".select_others").change(function() {

        var this_chk = $(this).val();
        if (this_chk == "Others" || this_chk == "Other Professional") {
            $(this).next().attr("style", "display:block;");
        } else {
            $(this).next().attr("style", "display:none;");
            $(this).next().val("");
        }
    });


    $(".not_checkbox").click(function() {
        var _this = $(this).is(":checked");
        if (_this == true) {
            $(this).next().next().attr("disabled", true);
            $(this).next().next().val("");
            $(this).next().next().next().html("good");
        } else {
            $(this).next().next().attr("disabled", false);
            $(this).next().next().next().html("");
        }
    });

});

function remove_value() {
    $("input[name=affiliation_kor]").val("");
    $("input[name=name_kor]").val("");

    $(".red_alert").eq(0).html("good");
    $(".red_alert").eq(1).html("good");
    $(".red_alert").eq(2).html("good");
    $(".red_alert").eq(3).html("good");
    $(".red_alert").eq(4).html("good");

    $("input[name=licence_number]").val("");
    $("input[name=specialty_number]").val("");
    $("input[name=nutritionist_number]").val("");

}


$(document).ready(function() {
    //$("#category").change(function(){
    //	var value = $(this).val();
    //	if (value == "Others"){
    //		$(this).addClass("on");
    //		$(this).next("input").addClass("on");
    //	} else {
    //		$(this).removeClass("on");
    //		$(this).next("input").removeClass("on");
    //	}

    //});
    $("#mo_user1").change(function() {
        if ($("#mo_user1").prop('checked') == true) {
            $(".mo_ksola_signup").addClass("on");

        }
    });
    $("#mo_user2").change(function() {
        if ($("#mo_user2").prop('checked') == true) {
            $(".mo_ksola_signup").removeClass("on");
        }
    });
    $("select[name='mo_nation_no']").change(function() {

        var value = $(this).val();

        if (value == 25) {
            $(".mo_red_alert").eq(0).html("");
            $(".mo_red_alert").eq(1).html("");
            $(".mo_red_alert").eq(2).html("");
            $(".mo_red_alert").eq(3).html("");
            $(".mo_red_alert").eq(4).html("");

            $(".mo_korea_only").addClass("on");
            $(".mo_korea_radio").addClass("on");
        } else {
            $(".mo_korea_radio").removeClass("on");
            $(".mo_korea_only").removeClass("on");
            $(".mo_ksola_signup").removeClass("on");

            remove_value();
            $("#mo_user2").prop('checked', true);
        }

        var nt = $("#mo_nation_no option:selected").data("nt");
        $("input[name=mo_nation_tel]").val(nt);
        $("input[name=mo_tel_nation_tel]").val(nt);

        if (nt != 82) {
            $(".mo_red_alert").eq(0).html("good");
            $(".mo_red_alert").eq(1).html("good");
            $(".mo_red_alert").eq(2).html("good");
            $(".mo_red_alert").eq(3).html("good");
            $(".mo_red_alert").eq(4).html("good");
        }
    });
    $("input[name=mo_food]").change(function() {

        var this_chk = $(this).val();
        //console.log(this_chk);
        if (this_chk == "Others") {
            //$(".mo_other_radio").next("label").find("input").addClass("on");
            $("input[name=mo_short_input]").removeClass("mo_other_radio");
        } else {
            //$(".mo_other_radio").next("label").find("input").removeClass("on");
            $("input[name=mo_short_input]").addClass("mo_other_radio");
        }
    });
});

function remove_value() {
    $("input[name=mo_affiliation_kor]").val("");
    $("input[name=mo_name_kor]").val("");

    $(".mo_red_alert").eq(0).html("good");
    $(".mo_red_alert").eq(1).html("good");
    $(".mo_red_alert").eq(2).html("good");
    $(".mo_red_alert").eq(3).html("good");
    $(".mo_red_alert").eq(4).html("good");

    $("input[name=mo_licence_number]").val("");
    $("input[name=mo_specialty_number]").val("");
    $("input[name=mo_nutritionist_number]").val("");

}
</script>

<section class="container form_page sign_up">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Personal Information
                </h2>
                <div class="color-bar"></div>
                <!-- <ul>
					<li>Home</li>
					<li>Sign Up</li>
					<li>Sign Up</li>
				</ul> -->
            </div>
        </div>
    </div>
    <div class="inner">
        <!-- <div class="circle_title">
			Personal Information -->
        <p class="sign_up_alert">* All requested filed(<span class="star_red">*</span>) should be completed.</p>
        <!-- </div> -->
        <form class="table_wrap">
            <div class="pc_only">
                <table class="table detail_table">
                    <colgroup>
                        <col class="col_th" />
                        <col width="*" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("country") ?></th>
                            <td>
                                <div class="max_normal">
                                    <select id="nation_no" name="nation_no" class="required">
                                        <option value="" selected hidden>Choose</option>
                                        <?php
                                        foreach ($nation_list as $n) {
                                            if ($language == "ko") {
                                                $nation = $n["nation_ko"];
                                            } else {
                                                $nation = $n["nation_en"];
                                            }
                                        ?>
                                        <option data-nt="<?= $n['nation_tel']; ?>" value="<?= $n["idx"] ?>"
                                            <?= $select_option ?>><?= $nation ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <!-- <span class="mini_alert red_txt red_alert_option"></span> -->
                                </div>
                            </td>
                        </tr>
                        <tr class="korea_radio">
                            <th><span class="red_txt">*</span>회원 여부</th>
                            <td>
                                <div class="label_wrap">
                                    <input type="radio" class="radio" name="user" id="user3">
                                    <label for="user3">Non-member </label>
                                    <input type="radio" class="radio" name="user" id="user4">
                                    <label for="user4">KSCVP</label>
                                    <input type="radio" class="radio" name="user" id="user5">
                                    <label for="user5">KSCP</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="ksola_signup">
                            <th style="background-color:transparent"></th>
                            <td>
                                <!-- <button type="button" class="btn green_btn long_btn" onclick="javascript:window.open('https://www.lipid.or.kr/member/member_confirm.php')">한국지질동맥경화학회 회원정보로 간편 가입</button> -->
                                <p class="green_t">한국지질동맥경화학회 회원 정보로 간편 가입</p>
                                <ul class="clearfix">
                                    <li>
                                        <label for="">KSoLA ID*</label>
                                        <input class="email_id" name="kor_id" type="text" maxlength="60">
                                    </li>
                                    <li>
                                        <label for="">KSoLA PW*</label>
                                        <input class="passwords" name="kor_pw" type="password" maxlength="60"
                                            minlength="10">
                                    </li>
                                    <li>
                                        <button onclick="kor_api()" type="button" class="btn">회원인증</button>
                                    </li>
                                </ul>
                                <div class="clearfix2">
                                    <div>
                                        <input type="checkbox" class="checkbox" id="privacy">
                                        <label for="privacy">
                                            제 3자 개인정보 수집에 동의합니다.
                                            <!-- <a href="javascript:;" class="term2_btn red_txt"> Details ></a> -->
                                        </label>
                                    </div>
                                    <a href="https://www.lipid.or.kr/member/find_id_and_pw.php" target="_blank"
                                        class="id_pw_find">KSoLA 회원 ID/PW 찾기</a>
                                </div>

                                <!-- <div> -->
                                <!-- 	<span class="mini_alert red_txt red_api"></span> -->
                                <!-- </div> -->
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("id") ?></th>
                            <td>
                                <div class="max_long responsive_float">
                                    <input type="text" name="email" class="required" maxlength="50">
                                    <!-- <span class="mini_alert red_txt red_alert"></span> -->
                                </div>
                                <span class="mini_alert brown_txt">Please make sure you have entered your ID correctly
                                    as you can't modify it later.</span>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("password") ?></th>
                            <td>
                                <div class="max_long">
                                    <input class="passwords" type="password" name="password" class="required"
                                        placeholder="Password" maxlength="60">
                                    <!-- <span class="mini_alert red_txt red_alert"></span> -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("verify_password") ?></th>
                            <td>
                                <div class="max_long">
                                    <input class="passwords" type="password" name="password2" class="required"
                                        placeholder="Re-type Password" maxlength="60">
                                    <!-- <span class="mini_alert red_txt red_alert"></span> -->
                                </div>
                            </td>
                        </tr>
                        <!-- Name -->
                        <tr>
                            <th rowspan="2"><span class="red_txt">*</span><?= $locale("name") ?></th>
                            <td class="name_td clearfix">
                                <div class="max_normal">
                                    <input name="first_name" type="text" placeholder="First name" maxlength="60">
                                    <!-- <span class="mini_alert red_txt red_alert"></span> -->
                                    <!-- <span class="mini_alert red_txt red_alert"></span> -->
                                </div>
                                <div class="max_normal">
                                    <input name="last_name" type="text" placeholder="Last name" maxlength="60">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font_small brown_txt">Note.<br />your name will appear on your name badge exactly
                                as it is entered in these fields.<br />It you wish your name to appear in a specific
                                way, please contact the Secretariat viae-mail( iscp@into-on.com)</td>
                        </tr>
                        <tr class="korea_only">
                            <th><span class="red_txt">*</span><?= $locale("name") ?>(KOR)</th>
                            <td>
                                <div class="max_normal">
                                    <input name="name_kor" type="text" maxlength="60">
                                    <span class="mini_alert red_txt red_alert">good</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("affiliation") ?></th>
                            <td>
                                <div class="max_long">
                                    <input type="text" name="affiliation" maxlength="100">
                                    <!-- <span class="mini_alert red_txt red_alert"></span> -->
                                </div>
                            </td>
                        </tr>
                        <tr class="korea_only">
                            <th><span class="red_txt">*</span><?= $locale("affiliation") ?>(KOR)</th>
                            <td>
                                <div class="max_long">
                                    <input type="text" name="affiliation_kor" maxlength="100">
                                    <span class="mini_alert red_txt red_alert">good</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Department -->
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("department") ?></th>
                            <td class="clearfix">
                                <div class="max_normal responsive_float">
                                    <select name="department" id="department" class="select_others">
                                        <option value="" selected hidden>Choose</option>
                                        <?php
                                        $department_arr = array("Cardiology", "Endocrinology", "Internal Medicine", "Family Medicine", "Nursing", "Basic Science", "Pediatric", "Food & Nutrition", "Neurology", "Nephrology", "Pharmacology", "Pharmacy", "Preventive Medicine", "Exercise Physiology", "Clinical Pathology", "Other Professional");

                                        foreach ($department_arr as $d_arr) {
                                            echo '<option value="' . $d_arr . '">' . $d_arr . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="department_input" class="input_others en_check">
                                    <!-- <span class="mini_alert red_txt red_alert_option"></span> -->
                                </div>
                                <!-- <span class="mini_alert">Endocrinology, Cardiology, Internal Medicine, Family Medicine, Nursing, Basic Science, Pediatric,<br/>Food & Nutrition, Neurology, Nephrology, Pharmacology, Pharmacy, Preventive Medicine,<br/>Exercise Physiology, Clinical Pathology, Other Professional )</span> -->
                                <span class="mini_alert"></span>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span>Category</th>
                            <td class="clearfix">
                                <div class="max_normal responsive_float clearfix">
                                    <select name="category" id="category" class="select_others">
                                        <option value="" selected hidden>Choose</option>
                                        <?php
                                        $category_arr = array("Professor", "Specialist", "Fellow", "Resident", "Researcher", "Military medical officer", "Nurse", "Nutritionist", "Student", "Pharmacist", "Corporate member", "Others");

                                        foreach ($category_arr as $a_arr) {
                                            echo '<option value="' . $a_arr . '">' . $a_arr . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="category_input" class="input_others en_check">
                                    <!-- <span class="mini_alert red_txt red_alert_option"></span> -->
                                </div>
                                <!-- <span class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse,<br/>Nutritionist, Student, Pharmacist, Corporate member, Others)</span> -->
                                <span class="mini_alert"></span>
                            </td>
                        </tr>
                        <!--2022-05-09 추가사항-->
                        <tr>
                            <th><span class="red_txt">*</span>Title</th>
                            <td class="clearfix">
                                <div class="max_normal responsive_float clearfix">
                                    <select name="title" id="title" class="select_others">
                                        <option value="" selected hidden>Choose</option>
                                        <?php
                                        $title_arr = array("Professor", "Dr.", "Mr.", "Ms.", "Others");

                                        foreach ($title_arr as $t_arr) {
                                            echo '<option value="' . $t_arr . '">' . $t_arr . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="title_input" class="input_others en_check" maxlength="60">
                                    <!-- <span class="mini_alert red_txt red_alert_option"></span> -->
                                </div>
                                <!-- <span class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse,<br/>Nutritionist, Student, Pharmacist, Corporate member, Others)</span> -->
                                <span class="mini_alert"></span>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span>Degree</th>
                            <td class="clearfix">
                                <div class="max_normal responsive_float clearfix">
                                    <select name="degree" id="degree" class="select_others">
                                        <option value="" selected hidden>Choose</option>
                                        <?php
                                        $degree_arr = array("M.D", "Ph.D.", "M.D., Ph.D.", "Others");

                                        foreach ($degree_arr as $d_arr) {
                                            echo '<option value="' . $d_arr . '">' . $d_arr . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="degree_input" class="input_others en_check" maxlength="60">
                                    <!-- <span class="mini_alert red_txt red_alert_option"></span> -->
                                </div>
                                <!-- <span class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse,<br/>Nutritionist, Student, Pharmacist, Corporate member, Others)</span> -->
                                <span class="mini_alert"></span>
                            </td>
                        </tr>
                        <tr class="korea_only">
                            <th><span class="red_txt">*</span>의사 면허번호</th>
                            <td>
                                <div class="max_long">
                                    <input type="checkbox" class="checkbox input not_checkbox" id="licence_number"
                                        name="licence_number2" value="Not applicable"><label for="licence_number">Not
                                        applicable</label>
                                    <input name="licence_number" type="text" maxlength="60" class="kor_check_number">
                                    <span class="mini_alert red_txt red_alert">good</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="korea_only">
                            <th><span class="red_txt">*</span>전문의 번호</th>
                            <td>
                                <div class="max_long">
                                    <input type="checkbox" class="checkbox input not_checkbox" id="specialty_number"
                                        name="specialty_number2" value="Not applicable"><label
                                        for="specialty_number">Not applicable</label>
                                    <input name="specialty_number" type="text" maxlength="60" class="kor_check_number">
                                    <span class="mini_alert red_txt red_alert">good</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="korea_only">
                            <th><span class="red_txt">*</span>영양사 면허번호</th>
                            <td>
                                <div class="max_long">
                                    <input type="checkbox" class="checkbox input not_checkbox" id="nutritionist_number"
                                        name="nutritionist_number2" value="Not applicable"><label
                                        for="nutritionist_number">Not applicable</label>
                                    <input name="nutritionist_number" type="text" maxlength="60"
                                        class="kor_check_number">
                                    <span class="mini_alert red_txt red_alert">good</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span>Mobile Phone Number</th>
                            <td>
                                <div class="max_normal phone">
                                    <input class="numbers" name="nation_tel" type="text" maxlength="60">
                                    <input name="phone" type="text">
                                </div>
                                <!-- <div> -->
                                <!-- 	<span class="mini_alert red_txt red_alert"></span> -->
                                <!-- 	<span class="mini_alert red_txt red_alert"></span> -->
                                <!-- <div> -->
                            </td>
                        </tr>
                        <!--2022-05-09 추가사항-->
                        <tr>
                            <th><span class="red_txt">*</span>Telephone Number</th>
                            <td style="display: flex">
                                <input class="tel_number tel_phone" name="tel_nation_tel" type="text" maxlength="60">
                                <input class="tel_numbers tel_phone" name="telephone1" type="text" maxlength="60">
                                <input class="tel_numbers tel_phone2" name="telephone2" type="text" maxlength="60">
                                <!-- <div> -->
                                <!-- 	<span class="mini_alert red_txt red_alert"></span> -->
                                <!-- 	<span class="mini_alert red_txt red_alert"></span> -->
                                <!-- <div> -->
                                <p style="margin-left: 20px;" class="font_small brown_txt">Please enter your phone
                                    number including the country and
                                    area codes. <br /> (Example: +82-2-12345678)</p>
                            </td>
                        </tr>


                        <tr>
                            <th><span class="red_txt">*</span>Date of Birth</th>
                            <td>
                                <div class="max_normal">
                                    <input maxlength="10" name="date_of_birth" type="text" placeholder="dd.mm.yyyy"
                                        id="datepicker">
                                    <!-- <span class="mini_alert red_txt red_alert">good</span> -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Special Request for Food</th>
                            <td>
                                <div class="label_wrap">
                                    <input checked value="None" type="radio" id="none" class="radio" name="food">
                                    <label for="none">None</label>
                                    <input value="Vegetarian" type="radio" id="vegetarian" class="radio" name="food">
                                    <label for="vegetarian">Vegetarian</label>
                                    <input value="Halal" type="radio" id="halal" class="radio" name="food">
                                    <label for="halal">Halal</label>
                                    <input value="Others" type="radio" id="Others" class="radio other_radio"
                                        name="food">
                                    <label for="Others">
                                        Others
                                        <input name="short_input" type="text" class="short_input en_check"
                                            maxlength="60">
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th><span class="red_txt">*</span>Address</th>
                            <td>
                                <div class="max_long"> -->
                        <!-- <input name="address" type="text" maxlength="60"> -->
                        <!-- <input type="text" id="sample6_postcode" placeholder="우편번호">
                                    <input type="button" onclick="sample6_execDaumPostcode()" value="우편번호 찾기"><br>
                                    <input t name="address" type="text" id="sample6_address" placeholder="주소"><br>
                                    <input type="text" id="sample6_detailAddress" placeholder="국문 상세주소">
                                    <input type="text" id="sample6_extraAddress" placeholder="영문">
                                </div>
                            </td>
                        </tr> -->

                        <!-- <tr>
                            <th><span class="red_txt">*</span>City</th>
                            <td>
                                <div class="max_long">
                                    <input name="city" type="text" maxlength="60">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th><span class="red_txt">*</span>Postal Code</th>
                            <td>
                                <div class="max_long">
                                    <input name="postal_code" type="text" maxlength="60">
                                </div>
                            </td>
                        </tr> -->
                        <!-- <tr> -->
                        <!-- 	<th scope="row"><span class="label require">회원정보 공개여부</span></th> -->
                        <!-- 	<td> -->
                        <!-- 		<input name="infoYn" id="infoYn1" value="Y" type="radio"  /> -->
                        <!-- 		<label for="infoYn1">동의합니다.</label> -->
                        <!-- 		<input name="infoYn" id="infoYn2" value="N" type="radio"  /> -->
                        <!-- 		<label for="infoYn2">동의하지 않습니다.</label> -->

                        <!-- 		<span class="cmt block">(회원공간을 통해 회원께만 회원님의 소속, 전화번호, 이메일 정보를 보여줍니다.)</span> -->
                        <!-- 	</td> -->
                        <!-- </tr> -->

                        <!-- <tr> -->
                        <!-- 	<th scope="row"><span class="label require">메일수신 동의여부</span></th> -->
                        <!-- 	<td><input name="emailYn" id="emailYn1" value="Y" type="radio"  /> -->
                        <!-- 		<label for="emailYn1">동의합니다.</label> -->
                        <!-- 		<input name="emailYn" id="emailYn2" value="N" type="radio"  /> -->
                        <!-- 		<label for="emailYn2">동의하지 않습니다.</label> -->

                        <!-- 		<span class="cmt block">(동의하시면 학회에서 보내는 메일을 수신할 수 있습니다.)</span> -->
                        <!-- 	</td> -->
                        <!-- </tr> -->
                    </tbody>
                </table>
            </div>
            <div class="checkbox_wrap pc_only">
                <ul>
                    <!-- <li>
                        <input type="checkbox" class="checkbox input required" data-name="terms 1" id="terms1"
                            name="terms1" value="Y">
                        <label for="terms1">Terms & Conditions
                            <a href="javascript:;" class="term1_btn red_txt"> Details ></a>
                        </label>
                    </li> -->
                    <li>
                        <input type="checkbox" class="checkbox input required" data-name="terms 2" id="terms2"
                            name="terms2" value="Y">
                        <label for="terms2"> Privacy Policy
                            <a href="javascript:;" class="term2_btn red_txt"> Details ></a>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="mb_only">
                <ul class="sign_list">
                    <li>
                        <p class="label"><span class="red_txt">*</span><?= $locale("country") ?></p>
                        <div>
                            <select id="mo_nation_no" name="mo_nation_no" class="required">
                                <option value="" selected hidden>Choose</option>
                                <?php
                                foreach ($nation_list as $n) {
                                    if ($language == "ko") {
                                        $nation = $n["nation_ko"];
                                    } else {
                                        $nation = $n["nation_en"];
                                    }
                                ?>
                                <option data-nt="<?= $n['nation_tel']; ?>" value="<?= $n["idx"] ?>"
                                    <?= $select_option ?>>
                                    <?= $nation ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                        </div>
                    </li>
                    <li class="korea_radio mo_korea_radio">
                        <p class="label"><span class="red_txt">*</span>회원 여부</p>
                        <div class="label_wrap">
                            <input type="radio" class="radio" name="mo_user" id="mo_user1">
                            <label for="mo_user1">Non-member</label>
                            <input checked type="radio" class="radio" name="mo_user" id="mo_user2">
                            <label for="mo_user2">KSCVP</label>
                            <input checked type="radio" class="radio" name="mo_user" id="mo_user3">
                            <label for="mo_user3">KSCP</label>
                        </div>
                    </li>
                    <li class="mo_ksola_signup">
                        <!-- <button type="button" class="btn green_btn long_btn" onclick="javascript:window.open('https://www.lipid.or.kr/member/member_confirm.php')">한국지질동맥경화학회 회원정보로 간편 가입</button> -->
                        <p class="green_t">한국지질동맥경화학회 회원 정보로 간편 가입</p>
                        <ul class="simple_signup">
                            <li>
                                <label for="">KSoLA ID*</label>
                                <input class="email_id passwords" name="mo_kor_id" type="text" maxlength="60">
                            </li>
                            <li>
                                <label for="">KSoLA PW*</label>
                                <input class="passwords" name="mo_kor_pw" type="password" maxlength="60">
                            </li>
                            <li>
                                <button onclick="mo_kor_api()" type="button"
                                    class="btn btn_small gray_btn">회원인증</button>
                            </li>
                        </ul>
                        <div class="clearfix2">
                            <div>
                                <input type="checkbox" class="checkbox" id="mo_privacy">
                                <label for="mo_privacy">
                                    제 3자 개인정보 수집에 동의합니다.
                                    <!-- <a href="javascript:;" class="red_txt"> Details ></a> -->
                                </label>
                            </div>
                            <a href="https://www.lipid.or.kr/member/find_id_and_pw.php" target="_blank"
                                class="id_pw_find">KSoLA
                                회원 ID/PW 찾기</a>
                        </div>
                        <div>
                            <!-- <span class="mini_alert red_txt mo_red_api"></span> -->
                        </div>
                    </li>

                    <li>
                        <p class="label"><span class="red_txt">*</span><?= $locale("id") ?></p>
                        <div>
                            <input type="text" name="mo_email" class="required" maxlength="50">
                            <!-- <span class="mini_alert red_txt mo_red_alert"></span> -->
                        </div>
                        <p class="mini_alert">Please make sure you have entered your ID correctly as you can't modify it
                            later.</p>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span><?= $locale("password") ?></p>
                        <div>
                            <input class="passwords" type="password" name="mo_password" class="required" maxlength="60">
                            <!-- <span class="mini_alert red_txt mo_red_alert"></span> -->
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span><?= $locale("verify_password") ?></p>
                        <div>
                            <input class="passwords" type="password" name="mo_password2" class="required"
                                maxlength="60">
                            <!-- <span class="mini_alert red_txt mo_red_alert"></span> -->
                        </div>
                    </li>
                    <li class="name_li">
                        <p class="label"><span class="red_txt">*</span><?= $locale("name") ?></p>
                        <div class="clearfix">
                            <div class="">
                                <input name="mo_first_name" type="text" placeholder="First name" maxlength="50"
                                    class="en_check">
                                <!-- <span class="mini_alert red_txt mo_red_alert"></span> -->
                            </div>
                            <div class="">
                                <input name="mo_last_name" type="text" placeholder="Last name" maxlength="50"
                                    class="en_check">
                                <!-- <span class="mini_alert red_txt mo_red_alert"></span> -->
                            </div>
                        </div>
                        <p class="font_small brown_txt">Note.<br />your name will appear on your name badge exactly as
                            it is entered in these fields.<br />It you wish your name to appear in a specific way,
                            please contact the Secretariat via<br />e-mail(secretariat@icola2022.org)</p>
                    </li>
                    <li class="mo_korea_only">
                        <p class="label"><span class="red_txt">*</span><?= $locale("name") ?>(KOR)</p>
                        <div>
                            <input name="mo_name_kor" type="text" class="kor_check">
                            <span class="mini_alert red_txt mo_red_alert">good</span>
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span><?= $locale("affiliation") ?></p>
                        <div>
                            <input type="text" name="mo_affiliation" maxlength="50" class="en_check">
                            <!-- <span class="mini_alert red_txt mo_red_alert"></span> -->
                        </div>
                    </li>
                    <li class="mo_korea_only">
                        <p class="label"><span class="red_txt">*</span><?= $locale("affiliation") ?>(KOR)</p>
                        <div>
                            <input type="text" name="mo_affiliation_kor" maxlength="100" class="kor_check">
                            <span class="mini_alert red_txt mo_red_alert">good</span>
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span><?= $locale("department") ?></p>
                        <div>
                            <select name="department" id="mo_department">
                                <option value="" selected hidden>Choose</option>
                                <option value="Cardiology">Cardiology</option>
                                <option value="Endocrinology">Endocrinology</option>
                                <option value="Internal Medicine">Internal Medicine</option>
                                <option value="Family Medicine">Family Medicine</option>
                                <option value="Nursing">Nursing</option>
                                <option value="Basic Science">Basic Science</option>
                                <option value="Pediatric">Pediatric</option>
                                <option value="Food & Nutrition">Food & Nutrition</option>
                                <option value="Neurology">Neurology</option>
                                <option value="Nephrology">Nephrology</option>
                                <option value="Pharmacology">Pharmacology</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Preventive Medicine">Preventive Medicine</option>
                                <option value="Exercise Physiology">Exercise Physiology</option>
                                <option value="Clinical Pathology">Clinical Pathology</option>
                                <option value="Other Professiona">Other Professional</option>
                            </select>
                            <input type="text" name="department_input" class="input_others en_check">
                            <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                        </div>
                        <!-- <p class="mini_alert">Endocrinology, Cardiology, Internal Medicine, Family Medicine, Nursing, Basic Science, Pediatric, Food & Nutrition, Neurology, Nephrology, Pharmacology, Pharmacy, Preventive Medicine, Exercise Physiology, Clinical Pathology, Other Professional )</p> -->
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Category</p>
                        <div>
                            <select name="mo_category" id="mo_category" class="select_others">
                                <option value="" selected hidden>Choose</option>
                                <option value="Professor">Professor</option>
                                <option value="Specialist">Specialist</option>
                                <option value="Fellow">Fellow</option>
                                <option value="Resident">Resident</option>
                                <option value="Researcher">Researcher</option>
                                <option value="Military medical officer">Military medical officer</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Nutritionist">Nutritionist</option>
                                <option value="Student">Student</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Corporate member">Corporate member</option>
                                <option value="Others">Others</option>
                            </select>
                            <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                            <input type="text" name="mo_category_input" class="input_others en_check" maxlength="60">
                        </div>
                        <!-- <p class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse, Nutritionist, Student, Pharmacist, Corporate member, Others)</p> -->
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Title</p>
                        <div>
                            <select name="mo_title" id="mo_title" class="select_others">
                                <option value="" selected hidden>Choose</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Others">Others</option>
                            </select>
                            <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                            <input type="text" name="mo_title_input" class="input_others en_check" maxlength="60">
                        </div>
                        <!-- <p class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse, Nutritionist, Student, Pharmacist, Corporate member, Others)</p> -->
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Degree</p>
                        <div>
                            <select name="mo_degree" id="mo_degree" class="select_others">
                                <option value="" selected hidden>Choose</option>
                                <option value="M.D">M.D</option>
                                <option value="Ph.D.">Ph.D.</option>
                                <option value="M.D., Ph.D.">M.D., Ph.D.</option>
                                <option value="Others">Others</option>
                            </select>
                            <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                            <input type="text" name="mo_degree_input" class="input_others en_check" maxlength="60">
                        </div>
                        <!-- <p class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse, Nutritionist, Student, Pharmacist, Corporate member, Others)</p> -->
                    </li>
                    <li class="mo_korea_only">
                        <p class="label"><span class="red_txt">*</span>의사 면허번호</p>
                        <div>
                            <input type="checkbox" class="checkbox input not_checkbox" id="mo_licence_number"
                                name="mo_licence_number2" value="Not applicable"><label for="mo_licence_number">Not
                                applicable</label>
                            <input name="mo_licence_number" type="text" maxlength="60" class="kor_check_number">
                            <span class="mini_alert red_txt mo_red_alert">good</span>
                        </div>
                    </li>
                    <li class="mo_korea_only">
                        <p class="label"><span class="red_txt">*</span>전문의 번호</p>
                        <div>
                            <input type="checkbox" class="checkbox input not_checkbox" id="mo_specialty_number"
                                name="mo_specialty_number2" value="Not applicable"><label for="mo_specialty_number">Not
                                applicable</label>
                            <input name="mo_specialty_number" type="text" maxlength="60" class="kor_check_number">
                            <span class="mini_alert red_txt mo_red_alert">good</span>
                        </div>
                    </li>
                    <li class="mo_korea_only">
                        <p class="label"><span class="red_txt">*</span>영양사 면허번호</p>
                        <div>
                            <input type="checkbox" class="checkbox input not_checkbox" id="mo_nutritionist_number"
                                name="mo_nutritionist_number2" value="Not applicable"><label
                                for="mo_nutritionist_number">Not
                                applicable</label>
                            <input name="mo_nutritionist_number" type="text" maxlength="60" class="kor_check_number">
                            <span class="mini_alert red_txt mo_red_alert">good</span>
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Mobile Phone Number</p>
                        <div class="phone_form clearfix">
                            <input class="numbers" name="mo_nation_tel" type="text">
                            <input name="mo_phone" type="text">
                        </div>
                        <!-- <div> -->
                        <!-- 	<span class="mini_alert red_txt mo_red_alert"></span> -->
                        <!-- 	<span class="mini_alert red_txt mo_red_alert"></span> -->
                        <!-- </div> -->
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Telephone Number</p>
                        <div class="phone_form clearfix">
                            <input class="tel_number tel_phone" name="mo_tel_nation_tel" type="text" maxlength="60">
                            <input class="tel_numbers tel_phone" name="mo_telephone1" type="text" maxlength="60">
                            <input class="tel_numbers tel_phone2" name="mo_telephone2" type="text" maxlength="60">
                            <p class="font_small brown_txt">Please enter your phone number including the country and
                                area
                                codes. <br /> (Example: +82-2-12345678)</p>
                        </div>
                        <!-- <div> -->
                        <!-- 	<span class="mini_alert red_txt mo_red_alert"></span> -->
                        <!-- 	<span class="mini_alert red_txt mo_red_alert"></span> -->
                        <!-- </div> -->
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Date of Birth</p>
                        <div>
                            <input maxlength="10" name="mo_date_of_birth" type="text" placeholder="dd.mm.yyyy"
                                id="mb_datepicker">
                            <!-- <span class="mini_alert red_txt mo_red_alert">good</span> -->
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt"></span>Special Request for Food</p>
                        <div class="label_wrap">
                            <input checked value="None" type="radio" id="mb_none" class="radio" name="mo_food">
                            <label for="mb_none">None</label>
                            <input value="Vegetarian" type="radio" id="mb_vegetarian" class="radio" name="mo_food">
                            <label for="mb_vegetarian">Vegetarian</label>
                            <input value="Halal" type="radio" id="mb_halal" class="radio" name="mo_food">
                            <label for="mb_halal">Halal</label>
                            <input value="Others" type="radio" id="mo_others" class="radio" name="mo_food">
                            <label for="mo_others">Others
                                <input name="mo_short_input" type="text" class="short_input mo_other_radio en_check"
                                    maxlength="60">
                            </label>
                        </div>

                    </li>
                </ul>
            </div>
            <div class="checkbox_wrap mb_only">
                <ul>
                    <!-- <li>
                        <input type="checkbox" class="checkbox input required" data-name="terms 1" id="mo_terms1" name="mo_terms1" value="Y">
                        <label for="mo_terms1">Terms & Conditions
                            <a href="javascript:;" class="term1_btn red_txt"> Details ></a>
                        </label>
                    </li> -->
                    <li>
                        <input type="checkbox" class="checkbox input required" data-name="terms 2" id="mo_terms2"
                            name="mo_terms2" value="Y">
                        <label for="mo_terms2"> Privacy Policy
                            <a href="javascript:;" class="term2_btn red_txt"> Details ></a>
                        </label>
                    </li>
                </ul>
            </div>
            <input type="hidden" name="ksola_member_check">
        </form>
        <div class="pc_only">
            <div class="pager_btn_wrap half">
                <button id="submit" type="button" class="btn blue_btn">Submit</button>
                <button type="button" class="btn dark_gray_btn">Cancel</button>
            </div>
        </div>
        <div class="mb_only">
            <div class="pager_btn_wrap half">
                <!-- <button id="mo_submit" type="button" class="btn blue_btn">Submit</button> -->
                <button class="btn blue_btn">Submit</button>
                <button type="button" class="btn dark_gray_btn">Cancel</button>
            </div>
        </div>
    </div>

</section>

<?php include_once('./include/footer.php'); ?>

<div class="loading">
    <img src="./img/icons/loading.gif" />
</div>

<!-- Terms&Conditions POP -->
<div class="popup term1">
    <div class="pop_bg"></div>
    <div class="pop_contents terms">
        <h1 class="text_r"><img src="./img/icons/icon_x.png" alt="" class="pop_close"></h1>
        <p class="pre">
            <!--<?= $locale("terms") ?>-->
            <span class="terms_big_title">Standard Terms and Conditions of E-commerce (Internet Cyber Mall)</span>

            Standard Terms No. 10023 (2015. 6. 26. Revision)

            <span>Article 1 (Purpose)</span>

            These Terms and Conditions provided by the ISCP 2023 homepage (http://iscp2023.org/) (hereinafter called
            the "Society Homepage") operated by the Korean Society of the Study of Lipid & Atherosclerosis (e-commerce
            business), are to regulate the website of the Society and the rights, duty and responsibility of the users
            for the use of internet-related services (hereinafter called "Services").

            These Terms and Conditions shall also apply to electronic commerce using PC communication, wireless, etc.,
            unless it is against its nature.


            <span>Article 2 (Definition)</span>

            (1) "Homepage" refers to a virtual sales office set up to trade materials using information and
            communication facilities such as computers to provide users with the products or services of the Korean
            Society of the Study of Lipid & Atherosclerosis (hereinafter called "products, etc.") and use them as
            meanings of the business who operates the Society's homepage.

            (2) "User" refers to members and non-members who access the "Society Homepage" and receive the services
            provided by the "Society Homepage" in accordance with these Terms and Conditions.

            (3) "Member" means a person who has registered as a member on the "Society Homepage" and who can continue to
            use the services provided by the "Society Homepage".

            (4) "Non-member" refers to a person who uses the services provided by the "Society Homepage" without
            registering as a member.


            <span>Article 3 (Provisions, Explanations and Revisions of Terms and Conditions, etc.)</span>

            (1) The "Society Homepage" shall post on the initial service page (front) of the society's website so that
            users can easily know including the contents of these Terms and Conditions, the name of the company and
            representative, the address of the business location (including the address where consumer complaints can be
            handled), the telephone number, E-mail address, business registration number, telecommunications sales
            business report number, etc.

            (2) The "Society Homepage" shall seek the user's confirmation to the terms and conditions in order for the
            user to understand important contents such as withdrawal of subscription · refund terms, via a separate
            connection screen or pop-up screen prior to agreeing to the terms and conditions.

            (3) The "Society Homepage" may revise these Terms and Conditions to the extent that it does not violate
            applicable laws such as the Act on Consumer Protection in Electronic Commerce, the Act on the Regulation of
            Terms and Conditions, the Electronics and Electronic Transactions Act, the Electronic Financial Transactions
            Act, the Digital Signature Act, the Act on Promotion of Information and Communications Network Use and
            Information Protection, the Act on Door-to-Door Sales, and the Consumer Standards Act.

            (4) If the "Society Homepage" revises the Terms and Conditions, the Company shall specify the date of
            application and the date of revision and notify on the initial page of the Society's website with the
            current terms and conditions from 7 days before the application date to the day before the application date.
            However, if the terms and conditions are altered against the user, the company shall notify the user with a
            grace period of at least 30 days in advance. In this case, the "Society Homepage" clearly compares the
            contents before and after the revision in order for the user to easily understand.

            (5) If the "Society Homepage" revises the Terms and Conditions, the revised terms and conditions shall apply
            only to contracts concluded after the date of application, and the terms and conditions before the revision
            shall apply to contracts already concluded before that. However, if a user who has already entered into a
            contract sends a message that he/she wants to be subject to the revised terms and conditions to the "Society
            Homepage" within the notice period of the revised terms and conditions under paragraph 3, and the revised
            terms and conditions are applied if the consent of the "Society Homepage" is obtained.

            (6) Matters not regulated in these Terms and Conditions and interpretation of these Terms and Conditions
            shall be subject to the Act on Consumer Protection in Electronic Commerce, the Act on The Regulation of
            Terms and Conditions, consumer protection guidelines and related laws or practices in electronic commerce,
            etc. as set forth by the Fair Trade Commission.


            <span>Article 4 (Provision and Change of Services)</span>

            (1) The "Society Homepage" performs the following tasks:

            1. Providing information on the product or service and concluding the purchase contract
            2. Delivery of goods or service with purchase contract
            3. Other tasks set by the "Society Homepage"

            (2) The "Society Homepage" may change the contents of the products or services to be provided by the
            contract concluded in the future in the case of out of stock of the product or service or a change in
            technical specifications. In this case, the contents of the changed product or service and the date of
            delivery will be specified and immediately notified where the contents of the current business or service
            were posted.


            (3) If the contents of the service contracted with the user offered by the "Society Homepage", are changed
            due to out of stock or changes in technical specifications, etc. the reason will be immediately notified to
            the user at the address where it can be notified.

            (4) In the case of the above paragraph, the "Society Homepage" shall compensate the user for the damages
            suffered by this. However, this is not the case if the "Society Homepage" proves that there is no will or
            negligence.


            <span>Article 5 (Suspension of Service)</span>

            (1) The "Society Homepage" can temporarily suspend the service in the event of a maintenance, replacement,
            failure, or communication failure of information and communication facilities such as computers.

            (2) The "Society Homepage" shall indemnity the user or a third party for damages suffered because of the
            temporary suspension of the Service for the reasons of paragraph (1). However, this is not the case if the
            "Society Homepage" proves that there is no will or negligence.

            (3) If the Service is unable to be provided due to the conversion of business items, abandonment of
            business, or integration between companies, the "Society Homepage" shall notify the user in the way set
            forth in Article 8 and compensate the consumer in accordance with the conditions set forth in the "Society
            Homepage". However, if the "Society Homepage" does not provide compensation standards, etc., the mileage or
            reserves of the users shall be paid to the user in cash or in cash corresponding to the currency value
            commonly accepted on the "Society's website".


            <span>Article 6 (Membership Subscription)</span>

            (1) The user shall apply for membership by entering the member information according to the registration
            form set forth by the "Society Homepage" and by agreeing his/her consent to these Terms and Conditions.

            (2) The "Society Homepage" shall register as a member unless the following items apply for applicant as
            shown in Paragraph (1).

            1. If the applicant has previously lost his/her membership under Article 7 (3) of these Terms and
            Conditions, he/she shall be the exception if he/she has obtained approval to register as a member of the
            "Society Homepage" as a member three years after the loss of membership under Article 7 (3).
            2. If there is a false, missing description, or false information in the registration content
            3. If it is determined that registering as a member is significantly in the technical way of the "Society
            Homepage".

            (3) The time of the membership agreement shall be when the approval of the "Society Homepage" reaches the
            member.

            (4) If there is a change in the information registered at the time of membership application, the member
            shall notify the "Society Homepage" within a considerable period by modifying the member information.


            <span>Article 7 (Withdrawal of Membership and Loss of Eligibility, etc.)</span>

            (1) Members may request withdrawal at any time on the "Society Homepage", and the "Society Homepage” shall
            immediately process the withdrawal of membership.

            (2) If the member is in any of the following reasons, the "Society Homepage" may limit or suspend the
            membership.

            1. When false information is registered at the time of application
            2. In case the member does not pay the debts in connection with the payment of the purchased products, etc.
            or other debts using the "Society Homepage" within due dates.
            3. When the e-commerce order is threatened by interfering with the use of other people's "Society Homepage",
            or stealing the information
            4. When using the "Society Homepage" to prohibit laws or these Terms and Conditions or to act against public
            order

            (3) After "Society Homepage" restricts membership, If the same act is repeated more than once after
            suspension or if the reason is not corrected within 30 days, the "Society Homepage” may disqualify its
            membership.

            (4) If the "Society Homepage" disqualifies its membership, the membership registration shall be exalted. In
            this case, the member shall be notified and given the opportunity to speak for at least 30 days before the
            membership registration is exalted.


            <span>Article 8 (Notification to Members)</span>

            (1) If the "Society Homepage" notifies the member, it will be through the designated e-mail address with the
            "Society Homepage" by Member.

            (2) The "Society Homepage" may be allowed as an individual notice by posting it on the "Society Homepage"
            bulletin board. Also, individual notice will be made in case of important personal information regarding the
            transactions of the member.


            <span>Article 9 (Application for Purchase and Consent to Provide Personal Information, etc.)</span>

            (1) The "Society Homepage" user shall apply for purchase on the "Society Homepage" by the following or
            similar method as below, and the "Society Homepage" shall provide the following contents in an
            easy-to-understand way when the user makes an application for purchase.

            1. Search and select products, etc.
            2. Input of the recipient's name, address, telephone number, e-mail address (or mobile phone number), etc.
            3. Terms and conditions, services that restrict subscription reselling, shipping fees, Confirmation of
            contents related to expenses such as installation costs
            4. Signs that accept these Terms and Conditions and confirm or reject the above 3.
            5. Consent to the application for purchase of the products, confirmation of such purchases, or confirmation
            of the "Society Homepage"
            6. Choosing a payment method

            (2) If the "Society Homepage" is required to provide buyer's personal information to a third party, the
            purchaser must be informed and consented to the following: (The same is the case if the consent is changed.)

            1. the recipient of personal information
            2. the purpose of personal information use of the recipient of the personal information
            3. the item of personal information provided
            4. the personal information retention and use period of the person receiving the personal information

            (3) If the "Society Homepage" entrusts a third party with the responsibility of handling the buyer's
            personal information, 1) the person entrusted with handling the personal information and 2) the contents of
            the task of entrusting the handling of personal information, must be known to the buyer and obtain consent.
            (The same is the case if the consent is changed.) However, if it is necessary for the performance of
            contracts concerning the provision of services and related to the promotion of convenience of buyers, it is
            not necessary to go through the notice process and consent process by notification through the Personal
            Information Policy in the way set out in the Act on Promotion of Information and Communications Network Use
            and Information Protection, etc.


            <span>Article 10 (Form of Contract)</span>

            (1) The "Society Homepage" may not accept purchase applications such as Article 9 if they are in any of the
            following sub-articles:

            1. If there is a false, missing description, or false information in the contents of the application
            2. If the company deems that accepting the purchase application is significantly in the technical way of
            "Society Homepage"

            (2) The contract shall be considered to have been established at the time the approval of the "Society
            Homepage" reaches the user in the form of a confirmation of reception as of Article 12 (1).

            (3) The approval of the "Society Homepage" shall include information on the user's confirmation of the
            purchase application, availability of sale, cancellation or correction of the purchase application, etc.


            <span>Article 11 (Payment Method)</span>

            The method of payment for a product or service purchased on the "Society Homepage" may be made in the
            following ways as available. However, the "Society Homepage" may not collect any nominal fee for payment of
            the user's payment method.

            1. Various account transfers such as phone banking, internet banking, mail banking, etc.
            2. Payment of prepaid cards, debit cards, credit cards, etc.
            3. Online deposit without bankbook


            <span>Article 12 (Confirmation notice of Reception· change and cancel the purchase application)</span>

            (1) The "Society Homepage" shall provide the user with a confirmation notice of the reception if there is an
            application for purchase.

            (2) If there is a discrepancy in the confirmation of the information, the user may request the change and
            cancellation of the purchase application immediately after receiving the confirmation of the reception, and
            the "Society Homepage" shall handle without delay if the user requests it before delivery. However, if you
            have already paid, you will be required to do so in accordance with article 15's provisions on the
            re-payment of your purchase.


            <span>Article 13 (Refund)</span>

            "Society Homepage" notifies the user of the reason without delay when the product requested by the user is
            not able to deliver or provide due to reasons such as out of stock, and if the company received payment for
            the product in advance, it shall refund within 3 business days from the date of receiving the payment or
            take the necessary measures for the refund.


            <span>Article 14 (Effect of the withdrawal of agreement)</span>

            (1) The "Society Homepage" shall refund the payment of the products already paid within 3 business days if
            the user returns the products. In this case, if the "Society Homepage" delays the refund of the product to
            the user, the delayed interest rate as set out in Article 21-2 of the Enforcement Decree of the Act on
            Consumer Protection in Electronic Commerce, etc. shall be paid for the delayed period.

            (2) The "Society Homepage" shall request that the company providing the payment method stop or cancel the
            billing of the product without delay when the user has paid the payment of the product by payment method
            such as credit card or electronic money in refunding the above payment.

            (3) In the case of the case of the withdrawal of agreement, the user shall bear the costs necessary for the
            return of the supplied products, etc. The "Society Homepage" does not claim penalties or damages for reasons
            such as withdrawal of the user's agreement. However, If the contract is fulfilled differently than the
            contents of the advertisement or the contents of the contract, the cost necessary for the return of the
            products, etc. will be borne by the "Society Homepage".



            <span>Article 15 (Personal Information Protection)</span>

            (1) The "Society Homepage" collects the minimum amount of personal information necessary for the provision
            of services when collecting personal information of users.

            (2) The "Society Homepage" does not collect the information necessary to enter into a purchase contract at
            the time of membership registration. However, this shall not be the case if identification is required prior
            to the purchase contract in order to comply with the obligations under applicable laws and regulations, and
            the minimum specific personal information is collected.

            (3) When the "Society Homepage" collects and uses personal information of users, the user is notified of the
            purpose and consent is obtained.

            (4) The "Society Homepage" may not use the collected personal information for other than the purpose, and in
            the event of a new purpose of use or when it is provided to a third party, the purpose is to be agreed to by
            the user at the provision stage. However, exceptions shall be made if otherwise provided in the relevant
            laws and regulations.

            (5) If the "Society Homepage" is required to obtain the consent of the user in paragraphs 2 and 3, the
            "Society Homepage" shall specify or give notice of the provisions of Article 22(2) of the Act on Promotion
            of Information and Communications Network Use and Information Protection, etc., such as the identity of the
            person in charge of personal information management (affiliation, name, phone number, other contact
            information), purpose of collection and use of information, and information provision related to a third
            party, and the user may withdraw this consent at any time.

            (6) The user may request to view and correct errors about his/her personal information held by the "Society
            Homepage” at any time, and the "Society Homepage" shall be on duty to take necessary measures without delay.
            If the user requests correction of the error, the "Society Homepage" will not use the personal information
            until the error is corrected.

            (7) The "Society Homepage" shall limit the person handling the user's personal information to a minimum for
            the protection of personal information and shall be responsible for all damages caused by loss, theft,
            outflow, provision of third parties without consent, or alteration of the user's personal information,
            including credit cards, bank accounts, etc.

            (8) The "Society Homepage" or a third party who has received personal information from it will destroy the
            personal information without delay when it has achieved the purpose of collecting or receiving personal
            information.

            (9) The "Society Homepage" do not set the consent column for collection, use and supply of personal
            information provision to be pre-selected. Specifically specify the services that are restricted when the
            user's consent to the provision is rejected, and do not restrict or refuse to provide services such as
            membership due to refusal of consent of users regarding the collection of personal information that is not a
            required collection items, offer.


            <span>Article 16 (Obligation of "Society Homepage")</span>

            (1) The "Society Homepage" does not act against the laws and these Terms and Conditions prohibits or
            violates public order and shall do our best to provide services continuously and stably according to the
            Terms and Conditions.

            (2) The "Society Homepage" shall have a security system to protect the user's personal information
            (including credit information) so that the user can safely use the Internet service.

            (3) "Society Homepage" shall be responsible for compensation about products or services according to The Law
            on the Becoming Fair of Advertising" Article 3 If the user suffers damages by advertising.

            (4) The "Society Homepage" does not send advertising e-mails for commercial purposes that the user does not
            want.


            <span>Article 17 (Obligations on Member's ID and Password)</span>

            (1) The Member shall be responsible for managing the ID and password except in the case of Article 15.

            (2) Members shall not use their ID and password to a third party.

            (3) If a member becomes aware that his/her ID and password have been stolen or used by a third party, he/she
            shall immediately notify the "Society Homepage" and follow the instructions on the "Society Homepage".


            <span>Article 18 (User's Obligation) Users shall not act:</span>

            1. Registration of false information when applying or changing
            2. Stealing other people's information
            3. Changing information posted on the "Society Homepage"
            4. Transmission or posting of information (computer programs, etc.) other than the information set by the
            "Society Homepage"
            5. Infringement of intellectual property rights such as copyrights of "Society Homepage" and other third
            parties
            6. "Society Homepage" or other acts that damage the honor of a third party or interfere with business
            7. Disclosing or posting pornography or violent messages, images, voices, or other information that is
            against public letter and public service on the society's website.


            <span>Article 19 (Relationship between connecting "Society Homepage" and non-connecting "Society
                Homepage")</span>

            (1) If the upper "Society Homepage" and the lower "Society Homepage" are linked by hyperlinks (e.g.,
            hyperlinks include letters, pictures, and fairy tales), the former is connecting "Society Homepage"(website)
            and the latter is called the non-connecting "Society Homepage"(website).

            (2) The connecting "Society Homepage" shall not be responsible for the guarantee of transactions made with
            the user by the products provided independently by the non-connecting "Society Homepage” and shall not be
            responsible for the guarantee of the transaction if it is stated on the initial screen of the connecting
            "Society Homepage" or as a pop-up screen at the time of connection.


            <span>Article 20 (Attribution and Restriction of Use of Copyright)</span>

            (1) Copyrights and other intellectual property rights for works created by the "Society Homepage" belong to
            the "Society Homepage".

            (2) The user shall not use the information of Copyrights and other intellectual property rights for works
            created by the "Society Homepage" obtained by using the "Society Homepage" for commercial purposes or use it
            to a third party by reproduction, transmission, publication, distribution, broadcast, or other means without
            the prior consent of the "Society Homepage" to the "Society Homepage".

            (3) The "Society Homepage" shall notify the user when using the copyright attributed to the user in
            accordance with the agreement.


            <span>Article 21 (Dispute Resolution)</span>

            (1) The "Society Homepage" establishes a damage compensation treatment organization to reflect the
            legitimate opinions or complaints raised by users and to compensate for the damages.

            (2) The "Society Homepage" shall first handle complaints and opinions submitted from users. However, if it
            is difficult to process quickly, the user will be notified immediately of the reason and the date of
            processing.

            (3) If there is an application for damages from the user in connection with an e-commerce dispute between
            user and "Society Homepage", it can be adjusted by the Fair Trade Commission or a dispute coordination
            agency commissioned by city or province government.


            <span>Article 22 (Right to Trial and Compliance Law)</span>

            (1) Any lawsuit concerning an e-commerce dispute between the "Society Homepage" and the user shall be based
            on the address of the user at the time of filing the lawsuit, and in the event of no address, the exclusive
            jurisdiction of the district court in which the lawsuit is located shall be made. However, if the user's
            address or claim is not clear at the time of the lawsuit, or if the user is a foreign resident, it shall be
            filed in the competent court under the Civil Litigation Act.

            (2) Korean law applies to e-commerce lawsuits filed between the "Society Homepage" and the user.
        </p>

    </div>
</div>

<!-- Privacy Policy POP -->
<div class="popup term2">
    <div class="pop_bg"></div>
    <div class="pop_contents terms">
        <h1 class="text_r"><img src="./img/icons/icon_x.png" alt="" class="pop_close"></h1>
        <p class="pre">
            <!--<?= $locale("terms") ?>-->
            <span class="terms_big_title">Privacy Policy </span>

            We, ISCP 2023 secretariat, collect and use personal information for the following purposes described below.

            <span>1. Collection and Use of Personal Information</span>
            • Personal information is data that can be used to identify or contact a single person.
            • We do not use the personal information for any purpose that disclose such information to any third party
            without the consent of the participant.


            <span>2. What personal information we collect</span>
            • When you create an ISCP 2023 we may collect a variety of information, including your e-mail, password,
            country, name, organization, phone number, and address information.


            <span>3. Duration of Retention and Use of Personal Information and Destruction</span>
            • As a general rule, the ISCP 2023 retains and uses participant’s personal information for the notified and
            agreed durations and once the purposes of collection and use of the personal information are achieved, it is
            without delay destroyed.
            • The duration of retention / use of collected personal information will start from when the User Agreement
            is entered into (i.e., signing up for a membership) and end when the User Agreement is terminated
            (including, but not limited to, applying for withdrawal from the membership, and discretionary
            withdrawal/dismissal). Further, in the case of termination of the User Agreement upon mutual agreement, the
            Company will without delay destroy all of your personal information other than contained in materials
            required to retain for a certain period for the afore-mentioned reasons for data retention, and will also
            instruct its third-party service providers to destroy the personal information provided to them for the
            outsourcing of data processing.
            • Your personal information will be destroyed without delay if the purposes of collection and use of the
            personal information are achieved. If printed on paper, your personal information will be destroyed by
            shredding or incinerating the paper documents or otherwise and, if saved in the form of electronic files,
            your personal information will be destroyed by technical means making the records non reproducible.
        </p>

    </div>
</div>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
function sample6_execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수
            let enAddr = ""; //영문주소

            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
                enAddr = data.addressEnglish
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
                enAddr = data.addressEnglish
            }

            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
            if (data.userSelectedType === 'R') {
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                    extraAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if (data.buildingName !== '' && data.apartment === 'Y') {
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if (extraAddr !== '') {
                    extraAddr = ' (' + extraAddr + ')';
                }
                // 조합된 참고항목을 해당 필드에 넣는다.
                document.getElementById("sample6_extraAddress").value = extraAddr;

            } else {
                document.getElementById("sample6_extraAddress").value = '';
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            document.getElementById('sample6_postcode').value = data.zonecode;
            document.getElementById("sample6_address").value = addr;
            document.getElementById("sample6_extraAddress").value = enAddr;
            // 커서를 상세주소 필드로 이동한다.
            document.getElementById("sample6_detailAddress").focus();
        }
    }).open();
}
</script>

<script src="./js/script/client/member.js?day=2022-04-25"></script>
<script>
$(document).ready(function() {
    $(".term1_btn").click(function() {
        $(".popup.term1").show();
    });
    $(".term2_btn").click(function() {
        console.log("hello")
        $(".popup.term2").show();
    });
    $(document).on("keyup", ".kor_check_number", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(this).next().html("");
        } else {
            $(this).next().html("good");
        }
    });

});


function name_check(name, mo = "") {

    //console.log(name);

    var first_name = $("input[name=" + name + "]").val();
    var first_name_len = first_name.trim().length;
    first_name = (typeof(first_name) != "undefined") ? first_name : null;

    if (!first_name || first_name_len <= 0) {
        $("input[name=" + name + "]").focus();
        if (mo === "mo") {
            name = name.replace("mo_", "");
        }
        if (name === "short_input") {
            alert("Invalid Others");
        } else {
            if (name == "first_name") {
                name = "first name";
            } else if (name == "last_name") {
                name = "last name";
            } else if (name == "name_kor") {
                name = "name (KOR)";
            } else if (name == "affiliation_kor") {
                name = "affiliation (KOR)";
            } else if (name == "licence_number") {
                name = "licence number";
            } else if (name == "nutritionist_number") {
                name = "nutritionist number";
            } else if (name == "specialty_number") {
                name = "specialty number";
            }
            alert("Invalid " + name);
        }
        return false;
    }
    return true;
}

function pw_check(i, password, password2) {
    var pw1 = $("input[name=" + password + "]").val();
    var pw1_len = pw1.trim().length;
    pw1 = (typeof(pw1) != "undefined") ? pw1 : null;

    var pw2 = $("input[name=" + password2 + "]").val();
    var pw2_len = pw2.trim().length;
    pw2 = (typeof(pw2) != "undefined") ? pw2 : null;

    if (i == 1) {
        if (!pw1 || pw1_len <= 0) {
            $("input[name=" + password + "]").focus();
            alert("Invalid passwrod");
            return false;
        }
    } else {
        if (!pw2 || pw2_len <= 0) {
            $("input[name=" + password2 + "]").focus();
            alert("Invalid passwrod");
            return false;
        }
    }
    if (pw1_len > 0 && pw2_len > 0) {
        if (pw1 !== pw2) {
            $("input[name=" + password + "]").focus();
            alert("inconsistency passwrod");
            return false;
        }
    }
}

//국가 선택시 자동 국가번호 삽입
//function option_changes() {

//	var value = $(this).val();
//			
//	if (value == 25){
//		$(".red_alert").eq(0).html("");
//		$(".red_alert").eq(1).html("");
//		$(".red_alert").eq(2).html("");
//		$(".red_alert").eq(3).html("");
//		$(".red_alert").eq(4).html("");

//		$(".korea_only").addClass("on");
//		$(".korea_radio").addClass("on");
//	}else {
//		$(".korea_radio").removeClass("on");
//		$(".korea_only").removeClass("on");
//		$(".ksola_signup").removeClass("on");

//		remove_value();
//		$("#user2").prop('checked', true);
//	}

//	var nt = $("#nation_no option:selected").data("nt");
//	$("input[name=nation_tel]").val(nt);
//	$("input[name=tel_nation_tel]").val(nt);

//	if(nt != 82) {
//		$(".red_alert").eq(0).html("good");
//		$(".red_alert").eq(1).html("good");
//		$(".red_alert").eq(2).html("good");
//		$(".red_alert").eq(3).html("good");
//		$(".red_alert").eq(4).html("good");
//	}
//}
//function mo_option_changes() {
//	
//	//var red_alert_option = $(".mo_red_alert_option");

//	//red_alert_option.eq(i).html("");
//	var nt = $("#mo_nation_no option:selected").data("nt");
//	$("input[name=mo_nation_tel]").val(nt);
//	$("input[name=mo_tel_nation_tel]").val(nt);

//	if(nt != 82) {
//		$(".mo_red_alert").eq(0).html("good");
//		$(".mo_red_alert").eq(1).html("good");
//		$(".mo_red_alert").eq(2).html("good");
//		$(".mo_red_alert").eq(3).html("good");
//		$(".mo_red_alert").eq(4).html("good");
//	}

//	//if(i== 0) {
//	//	var nt = $("#mo_nation_no option:selected").data("nt");
//	//	$("input[name=mo_nation_tel]").val(nt);
//	//	//$(".mo_red_alert").eq(8).html("good");
//	//	//$(".mo_red_alert").eq(8).css('display', 'none');
//	//}
//}


$(document).on("click", "#mo_submit", function() {

    //var red_alert_option = $(".mo_red_alert_option");

    var value_arr = ["ID(email)", "Password", "Verify Password", "Frist_name", "Last_name", "Name(KOR)",
        "Affiliation", "Affiliation(KOR)", "Mobile Phone Number", "Mobile Phone Number", "Date of Birth"
    ];
    var option_arr = ["Country", "Department", "Category", "Title", "Degree"];

    var red_alert = document.getElementsByClassName("mo_red_alert");

    //국가 유효성
    var nation_no = $("#mo_nation_no option:selected").val();

    if (!nation_no) {
        alert("Invalid " + option_arr[0]);
        //red_alert_option.eq(0).html("check_"+option_arr[0]);
        return;
    }

    //for(var i=0; i<red_alert.length-3; i++) {
    //	
    //	if(red_alert[i].innerHTML !== "good") {
    //		red_alert[i].innerHTML = "enter_"+value_arr[i];
    //		red_alert[i].style.display = "block";
    //		return;
    //	}
    //}

    var check = name_check("mo_email", "mo");

    if (check == false) return;

    check = pw_check(1, "mo_password", "mo_password2");

    if (check == false) return;

    check = pw_check(2, "mo_password", "mo_password2");

    if (check == false) return;

    check = name_check("mo_first_name", "mo");
    if (check == false) return;
    check = name_check("mo_last_name", "mo");
    if (check == false) return;

    if (red_alert[0].innerHTML !== "good") {
        check = name_check("mo_name_kor", "mo");
        if (check == false) return;
    }

    check = name_check("mo_affiliation", "mo");
    if (check == false) return;

    if (red_alert[1].innerHTML !== "good") {
        check = name_check("mo_affiliation_kor", "mo");
        if (check == false) return;
    }

    var department = $("#mo_department option:selected").val();
    var category_input = $("input[name=department_input").val();
    if (department == "" || department == null) {
        alert("Invalid " + option_arr[1]);
        return;
    }

    var category = $("#mo_category option:selected").val();
    var category_input = $("input[name=mo_category_input").val();

    if (!category) {
        alert("Invalid " + option_arr[2]);
        return;
    } else if (category == "Others") {
        if (category_input == "" || category_input == null) {
            alert("Invalid category others");
            return;
        }
    }

    //2022-05-09 추가
    var title = $("#mo_title option:selected").val();
    var title_input = $("input[name=mo_title_input").val();

    if (title == "" || title == null) {
        alert("Invalid " + option_arr[3]);
        return;
    } else if (title == "Others") {
        if (title_input == "" || title_input == null) {
            alert("Invalid title others");
            return;
        }
    }

    var degree = $("#mo_degree option:selected").val();
    var degree_input = $("input[name=mo_degree_input").val();

    if (degree == "" || degree == null) {
        alert("Invalid " + option_arr[4]);
        return;
    } else if (degree == "Others") {
        if (degree_input == "" || degree_input == null) {
            alert("Invalid degree others");
            return;
        }
    }


    var licence_number = $("input[name=mo_licence_number]").val();
    var licence_number2 = $("input[name=mo_licence_number2]").is(":checked");
    var nutritionist_number = $("input[name=mo_nutritionist_number]").val();
    var nutritionist_number2 = $("input[name=mo_nutritionist_number2]").is(":checked");
    var specialty_number = $("input[name=mo_specialty_number]").val();
    var specialty_number2 = $("input[name=mo_specialty_number2]").is(":checked");

    if (red_alert[2].innerHTML !== "good") {
        if (licence_number == "" && licence_number2 == false) {
            check = name_check("licence_number", "mo");
            if (check == false) return;
        }
    }

    if (red_alert[3].innerHTML !== "good") {
        if (specialty_number == "" && specialty_number2 == false) {
            check = name_check("specialty_number", "mo");
            if (check == false) return;
        }
    }

    if (red_alert[4].innerHTML !== "good") {
        if (nutritionist_number == "" && nutritionist_number2 == false) {
            check = name_check("nutritionist_number", "mo");
            if (check == false) return;
        }
    }


    check = name_check("mo_nation_tel", "mo");
    if (check == false) return;
    check = name_check("mo_phone", "mo");
    if (check == false) return;

    var tel_nation_tel = $("input[name=mo_tel_nation_tel]").val();
    var telephone1 = $("input[name=mo_telephone1]").val();
    var telephone2 = $("input[name=mo_telephone2]").val();

    if (telephone1 != "") {
        if (tel_nation_tel == null || tel_nation_tel == "" || telephone2 == null || telephone2 == "") {
            alert("Invalid telephone");
            return;
        }
    }
    if (telephone2 != "") {
        if (tel_nation_tel == null || tel_nation_tel == "" || telephone1 == null || telephone1 == "") {
            alert("Invalid telephone");
            return;
        }
    }

    var date_of_birth = $("input[name=mo_date_of_birth]").val();
    if (date_of_birth.length < 10) {
        alert("Invalid date of birth\nex) 01-01-1970");
        return;
    }

    if ($("input[name=mo_food]:checked").val() == "Others") {
        var check = name_check("mo_short_input", "mo");
        if (check == false) {
            return;
        }
    }

    //console.log(red_alert.length);
    //두개를 빼내서 작업하는 이유는 option을 체크해야 돼서
    //for(var i=8; i<red_alert.length; i++) {
    //	
    //	if(red_alert[i].innerHTML !== "good") {
    //	
    //		red_alert[i].innerHTML = "enter_"+value_arr[i];
    //		red_alert[i].style.display = "block";
    //		return;
    //	}
    //}

    //이용약관 동의
    var terms1 = $("#mo_terms1").is(":checked");
    //개인정보 동의
    var terms2 = $("#mo_terms2").is(":checked");

    if (terms1 == false) {
        //alert("Please agree to Terms.");
        //22.04.12 고객사 요청으로 alert 문구 변경 (HUBDNC LJH2)
        alert("Please agree to Terms & Conditions.");
        return;
    }
    if (terms2 == false) {
        alert("Please agree to Privacy Policy.");
        return;
    }

    if (!confirm("Would you like to join?")) return;

    var ksola_member_status = "";
    if ($("#mo_user1").prop('checked') == true) {
        ksola_member_status = 1;
    } else {
        ksola_member_status = 0;
    }

    var email = $("input[name=mo_email]").val();

    var pw = $("input[name=mo_password]").val();
    var pw2 = $("input[name=mo_password2]").val();

    var first_name = $("input[name=mo_first_name]").val();
    var last_name = $("input[name=mo_last_name]").val();

    var affiliation = $("input[name=mo_affiliation]").val();

    var nation_tel = $("input[name=mo_nation_tel]").val();
    var phone = $("input[name=mo_phone]").val();

    var food = $("input[name=mo_food]:checked").val();

    var name_kor = $("input[name=mo_name_kor]").val();
    var affiliation_kor = $("input[name=mo_affiliation_kor]").val();
    var licence_number3 = $("input[name=mo_licence_number2]").val();
    var specialty_number3 = $("input[name=mo_specialty_number2]").val();
    var nutritionist_number3 = $("input[name=mo_nutritionist_number2]").val();
    var short_input = $("input[name=mo_short_input]").val();

    var ksola_member_check = $("input[name=ksola_member_check]").val();

    var data = {
        "flag": "signup_join",
        "ksola_member_status": ksola_member_status,
        "nation_no": nation_no,
        "email": email,
        "password": pw,
        "first_name": first_name,
        "last_name": last_name,
        "affiliation": affiliation,
        "department": department,
        "category": category,
        "category_input": category_input,
        "nation_tel": nation_tel,
        "phone": phone,
        "date_of_birth": date_of_birth,
        "food": food,
        "name_kor": name_kor,
        "affiliation_kor": affiliation_kor,
        "licence_number": licence_number,
        "specialty_number": specialty_number,
        "nutritionist_number": nutritionist_number,
        "licence_number2": licence_number3,
        "specialty_number2": specialty_number3,
        "nutritionist_number2": nutritionist_number3,
        "short_input": short_input,
        "terms1": terms1,
        "terms2": terms2,
        "ksola_member_check": ksola_member_check,
        "type": "INSERT",
        "title": title,
        "title_input": title_input,
        "degree": degree,
        "degree_input": degree_input,
        "tel_nation_tel": tel_nation_tel,
        "telephone1": telephone1,
        "telephone2": telephone2
    };

    save(data);
});

$(document).on("click", "#submit", function() {

    //var red_alert_option = $(".red_alert_option");

    var value_arr = ["ID(email)", "Password", "Verify Password", "Frist_name", "Last_name", "Name(KOR)",
        "Affiliation", "Affiliation(KOR)", "Mobile Phone Number", "Mobile Phone Number", "Date of Birth"
    ];
    var option_arr = ["Country", "Department", "Category", "Title", "Degree"];

    var red_alert = document.getElementsByClassName("red_alert");

    //국가 유효성
    var nation_no = $("#nation_no option:selected").val();
    if (!nation_no) {
        alert("Invalid " + option_arr[0]);
        //red_alert_option.eq(0).html("check_"+option_arr[0]);
        return;
    }

    //for(var i=0; i<red_alert.length-3; i++) {
    //	
    //	if(red_alert[i].innerHTML !== "good") {
    //		red_alert[i].innerHTML = "enter_"+value_arr[i];
    //		red_alert[i].style.display = "block";
    //		return;
    //	}
    //}

    var check = name_check("email");

    if (check == false) return;

    check = pw_check(1, "password", "password2");

    if (check == false) return;

    check = pw_check(2, "password", "password2");

    if (check == false) return;

    check = name_check("first_name");
    if (check == false) return;
    check = name_check("last_name");
    if (check == false) return;

    if (red_alert[0].innerHTML !== "good") {
        check = name_check("name_kor");
        if (check == false) return;
    }

    check = name_check("affiliation");
    if (check == false) return;

    if (red_alert[1].innerHTML !== "good") {
        check = name_check("affiliation_kor");
        if (check == false) return;
    }

    var department = $("#department option:selected").val();
    var department_input = $("input[name=department_input").val();
    if (department == "" || department == null) {
        alert("Invalid " + option_arr[1]);
        //red_alert_option.eq(1).html("check_"+option_arr[1]);
        return;
    } else if (department == "Other Professional") {
        if (department_input == "" || department_input == null) {
            alert("Invalid department others");
            return;
        }
    }

    var category = $("#category option:selected").val();
    var category_input = $("input[name=category_input").val();

    if (category == "" || category == null) {
        alert("Invalid " + option_arr[2]);
        //red_alert_option.eq(2).html("check_"+option_arr[2]);
        return;
    } else if (category == "Others") {
        if (category_input == "" || category_input == null) {
            alert("Invalid category others");
            return;
        }
    }

    //2022-05-09 추가
    var title = $("#title option:selected").val();
    var title_input = $("input[name=title_input").val();

    if (title == "" || title == null) {
        alert("Invalid " + option_arr[3]);
        return;
    } else if (title == "Others") {
        if (title_input == "" || title_input == null) {
            alert("Invalid title others");
            return;
        }
    }

    var degree = $("#degree option:selected").val();
    var degree_input = $("input[name=degree_input").val();

    if (degree == "" || degree == null) {
        alert("Invalid " + option_arr[4]);
        return;
    } else if (degree == "Others") {
        if (degree_input == "" || degree_input == null) {
            alert("Invalid degree others");
            return;
        }
    }

    var licence_number = $("input[name=licence_number]").val();
    var licence_number2 = $("input[name=licence_number2]").is(":checked");
    var nutritionist_number = $("input[name=nutritionist_number]").val();
    var nutritionist_number2 = $("input[name=nutritionist_number2]").is(":checked");
    var specialty_number = $("input[name=specialty_number]").val();
    var specialty_number2 = $("input[name=specialty_number2]").is(":checked");

    if (red_alert[2].innerHTML !== "good") {
        if (licence_number == "" && licence_number2 == false) {
            check = name_check("licence_number");
            if (check == false) return;
        }
    }

    if (red_alert[3].innerHTML !== "good") {
        if (specialty_number == "" && specialty_number2 == false) {
            check = name_check("specialty_number");
            if (check == false) return;
        }
    }

    if (red_alert[4].innerHTML !== "good") {
        if (nutritionist_number == "" && nutritionist_number2 == false) {
            check = name_check("nutritionist_number");
            if (check == false) return;
        }
    }

    check = name_check("nation_tel");
    if (check == false) return;

    check = name_check("phone");
    if (check == false) return;

    var tel_nation_tel = $("input[name=tel_nation_tel]").val();
    var telephone1 = $("input[name=telephone1]").val();
    var telephone2 = $("input[name=telephone2]").val();

    if (telephone1 != "") {
        if (tel_nation_tel == null || tel_nation_tel == "" || telephone2 == null || telephone2 == "") {
            alert("Invalid telephone");
            return;
        }
    }
    if (telephone2 != "") {
        if (tel_nation_tel == null || tel_nation_tel == "" || telephone1 == null || telephone1 == "") {
            alert("Invalid telephone");
            return;
        }
    }

    var date_of_birth = $("input[name=date_of_birth]").val();
    if (date_of_birth.length < 10) {
        alert("Invalid date of birth\nex) 01-01-1970");
        return;
    }


    if ($("input[name=food]:checked").val() == "Others") {
        var check = name_check("short_input");
        if (check == false) {
            return;
        }
    }

    //두개를 빼내서 작업하는 이유는 option을 체크해야 돼서
    //for(var i=8; i<red_alert.length; i++) {
    //	
    //	if(red_alert[i].innerHTML !== "good") {
    //	
    //		red_alert[i].innerHTML = "enter_"+value_arr[i];
    //		red_alert[i].style.display = "block";
    //		return;
    //	}
    //}

    //이용약관 동의
    var terms1 = $("#terms1").is(":checked");
    //개인정보 동의
    var terms2 = $("#terms2").is(":checked");

    // if (terms1 == false) {
    //     alert("Please agree to Terms & Conditions.");
    //     return;
    // }
    if (terms2 == false) {
        alert("Please agree to Privacy Policy.");
        return;
    }

    if (!confirm("Would you like to join?")) return;

    var ksola_member_status = "";
    if ($("#user4").prop('checked') == true) {
        ksola_member_status = "KSCVP";
    } else if ($("#user5").prop('checked') == true) {
        ksola_member_status = "KSCP";
    } else {
        ksola_member_status = "NON";
    }

    var email = $("input[name=email]").val();

    var pw = $("input[name=password]").val();
    var pw2 = $("input[name=password2]").val();

    var first_name = $("input[name=first_name]").val();
    var last_name = $("input[name=last_name]").val();

    var affiliation = $("input[name=affiliation]").val();

    var nation_tel = $("input[name=nation_tel]").val();
    var phone = $("input[name=phone]").val();

    var food = $("input[name=food]:checked").val();

    var name_kor = $("input[name=name_kor]").val();
    var affiliation_kor = $("input[name=affiliation_kor]").val();

    var licence_number3 = $("input[name=licence_number2]").val();
    var specialty_number3 = $("input[name=specialty_number2]").val()
    var nutritionist_number3 = $("input[name=nutritionist_number2]").val();
    var short_input = $("input[name=short_input]").val();

    var ksola_member_check = $("input[name=ksola_member_check]").val();

    var data = {
        "flag": "signup_join",
        "ksola_member_status": ksola_member_status,
        "nation_no": nation_no,
        "email": email,
        "password": pw,
        "first_name": first_name,
        "last_name": last_name,
        "affiliation": affiliation,
        "department": department,
        "category": category,
        "category_input": category_input,
        "nation_tel": nation_tel,
        "phone": phone,
        "date_of_birth": date_of_birth,
        "food": food,
        "name_kor": name_kor,
        "affiliation_kor": affiliation_kor,
        "licence_number": licence_number,
        "specialty_number": specialty_number,
        "nutritionist_number": nutritionist_number,
        "licence_number2": licence_number3,
        "specialty_number2": specialty_number3,
        "nutritionist_number2": nutritionist_number3,
        "short_input": short_input,
        "terms1": terms1,
        "terms2": terms2,
        "ksola_member_check": ksola_member_check,
        "type": "INSERT",
        "title": title,
        "title_input": title_input,
        "degree": degree,
        "degree_input": degree_input,
        "tel_nation_tel": tel_nation_tel,
        "telephone1": telephone1,
        "telephone2": telephone2
    };

    save(data)
});


function save(data) {

    $.ajax({
        url: PATH + "ajax/client/ajax_member.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        success: success,
        fail: fail,
        error: error
    });

    function success(res) {
        alert("Your Sign-up is complete.");
        window.location.replace("signup_complete.php");
    }

    function fail(res) {
        alert("Failed.\nPlease try again later.");
        return false;
    }

    function error(res) {
        alert("An error has occurred. \nPlease try again later.");
        return false;
    }
}

//red_api
$("input[name=mo_kor_id]").on("change", function() {
    var _this = $(this);
    _this.val();
    kor_api_check("mo_kor_id", _this.val(), "mo");
});
$("input[name=mo_kor_pw]").on("change", function() {
    var _this = $(this);
    _this.val();
    kor_api_check("mo_kor_password", _this.val(), "mo");
});


$("input[name=kor_id]").on("change", function() {
    var _this = $(this);
    _this.val();
    kor_api_check("kor_id", _this.val());
});
$("input[name=kor_pw]").on("change", function() {
    var _this = $(this);
    _this.val();
    kor_api_check("kor_password", _this.val());
});

function kor_api_check(name, value, mo = "") {
    var first_name = value;
    var first_name_len = first_name.trim().length;
    first_name = (typeof(first_name) != "undefined") ? first_name : null;

    if (mo === "mo") {
        name = name.replace("mo_", "");
    }

    if (!first_name || first_name_len <= 0) {
        alert("Invalid_" + name);
        //$(".red_api").eq(0).html("format_"+name);
        //$(".mo_red_api").eq(0).html("format_"+name);
    }
    //else {
    //	$(".red_api").eq(0).html("");
    //	$(".mo_red_api").eq(0).html("");
    //}
}

//한국 회원 인증시 api호출
function mo_kor_api() {

    var kor_id = $("input[name=mo_kor_id]").val().trim();
    var kor_pw = $("input[name=mo_kor_pw]").val().trim();
    //제 3자 개인정보 수집에 동의 여부
    var privacy = $("#mo_privacy").is(":checked");

    if (!kor_id) {
        //$(".mo_red_api").eq(0).html("format_id");
        alert("Invalid id");
        return;
    }
    if (!kor_pw) {
        //$(".mo_red_api").eq(0).html("Invalid_password");
        alert("Invalid password");
        return;
    }

    if (privacy == false) {
        alert("Please agree to the collection of personal information.");
        //$(".mo_red_api").eq(0).html("Please agree to the collection of personal information.");
        return;
    }

    var data = {
        'id': kor_id,
        'password': kor_pw
    };

    $.ajax({
        url: "signup_api.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        success: success,
        fail: fail,
        error: error
    });

    function success(res) {

        var kor_sign = JSON.parse(res.value);
        if (kor_sign.msg == "N1") {
            alert("아이디를 입력해주세요.");
            //$(".mo_red_api").eq(0).html("아이디를 입력해주세요.");
        } else if (kor_sign.msg == "N2") {
            alert("비밀번호를 입력해주세요.");
            //$(".mo_red_api").eq(0).html("비밀번호를 입력해주세요.");
        } else if (kor_sign.msg == "N3") {
            alert("가입되지 않은 아이디입니다.");
            //$(".mo_red_api").eq(0).html("가입되지 않은 아이디입니다.");
        } else if (kor_sign.msg == "N4") {
            alert("잘못된 비밀번호 입니다.");
            //$(".mo_red_api").eq(0).html("잘못된 비밀번호 입니다.");
        } else if (kor_sign.msg == "N5") {
            alert("탈퇴된 아이디 입니다.");
            //$(".mo_red_api").eq(0).html("탈퇴된 아이디 입니다.");
        } else if (kor_sign.msg == "Y") {

            //$(".mo_red_api").eq(0).html("");

            var name_eng_arr = kor_sign.name_eng.split(" ");

            //이거 실행했을 때도 이메일 중복체크
            var check_email = email_check(kor_sign.email);
            if (check_email == false) {
                return;
            }

            $("input[name=ksola_member_check]").val(kor_sign.id);
            $("input[name=mo_email]").val(kor_sign.email);
            $("input[name=mo_name_kor]").val(kor_sign.name);
            $("input[name=mo_first_name]").val(name_eng_arr[0]);
            $("input[name=mo_last_name]").val(name_eng_arr[1]);
            $("input[name=mo_phone]").val(kor_sign.phone);
            $("input[name=mo_nation_tel]").val("82");

            //select option에 비교해서 selected 처리
            var options = $('#mo_department').find('option').map(function() {
                return $(this).val();
            }).get()
            for (var i = 0; i < options.length; i++) {
                if (options[i] == kor_sign.depart && options[i] !== '') {
                    $("#mo_department option:eq(" + i + ")").attr("selected", "selected");
                }
            }

            var birthday_arr = kor_sign.birthday.split("-");

            $("input[name=mo_date_of_birth]").val(birthday_arr[2] + "-" + birthday_arr[1] + "-" + birthday_arr[0]);
            $("input[name=mo_licence_number]").val(kor_sign.license_number);
            $("input[name=mo_affiliation_kor]").val(kor_sign.office_name);

            //for(var i=0; i<$(".mo_red_alert").length; i++) {
            //	//한국 아이디 입력했을 때 입력 안 되는 값들은 제외
            //	if(i==1 || i==2 || i==6) {
            //		continue;
            //	}
            //	$(".mo_red_alert").eq(i).html("good");
            //	$(".mo_red_alert").eq(i).css('display', 'none');
            //}
        }

    }

    function fail(res) {
        alert("Failed.\nPlease try again later.");
        return false;
    }

    function error(res) {
        alert("An error has occurred. \nPlease try again later.");
        return false;
    }
}

function kor_api() {

    var kor_id = $("input[name=kor_id]").val().trim();
    var kor_pw = $("input[name=kor_pw]").val().trim();
    //제 3자 개인정보 수집에 동의 여부
    var privacy = $("#privacy").is(":checked");

    if (!kor_id) {
        alert("Invalid id");
        //$(".red_api").eq(0).html("format_id");
        return;
    }
    if (!kor_pw) {
        alert("Invalid password");
        //$(".red_api").eq(0).html("format_password");
        return;
    }

    if (privacy == false) {
        alert("Please agree to the collection of personal information.");
        $(".red_api").eq(0).html("Please agree to the collection of personal information.");
        return;
    }

    var data = {
        'id': kor_id,
        'password': kor_pw
    };

    $.ajax({
        url: "signup_api.php",
        type: "POST",
        data: data,
        dataType: "JSON",
        success: success,
        fail: fail,
        error: error
    });

    function success(res) {

        var kor_sign = JSON.parse(res.value);
        //console.log(kor_sign.id);
        if (kor_sign.msg == "N1") {
            alert("아이디를 입력해주세요.");
        } else if (kor_sign.msg == "N2") {
            alert("비밀번호를 입력해주세요.");
        } else if (kor_sign.msg == "N3") {
            alert("가입되지 않은 아이디입니다.");
        } else if (kor_sign.msg == "N4") {
            alert("잘못된 비밀번호 입니다.");
        } else if (kor_sign.msg == "N5") {
            alert("탈퇴된 아이디 입니다.");
        } else if (kor_sign.msg == "N6") {
            alert("이미 가입된 아이디 입니다.");
        } else if (kor_sign.msg == "Y") {

            var name_eng_arr = kor_sign.name_eng.split(" ");

            //이거 실행했을 때도 이메일 중복체크
            var check_email = email_check(kor_sign.email);
            if (check_email == false) {
                return;
            }

            $("input[name=ksola_member_check]").val(kor_sign.id);
            $("input[name=email]").val(kor_sign.email);
            $("input[name=name_kor]").val(kor_sign.name);
            $("input[name=first_name]").val(name_eng_arr[0]);
            $("input[name=last_name]").val(name_eng_arr[1]);
            $("input[name=phone]").val(kor_sign.phone);
            $("input[name=nation_tel]").val("82");

            //select option에 비교해서 selected 처리
            var options = $('#department').find('option').map(function() {
                return $(this).val();
            }).get()
            for (var i = 0; i < options.length; i++) {
                if (options[i] == kor_sign.depart && options[i] !== '') {
                    $("#department option:eq(" + i + ")").attr("selected", "selected");
                }
            }

            var birthday_arr = kor_sign.birthday.split("-");

            $("input[name=date_of_birth]").val(birthday_arr[2] + "-" + birthday_arr[1] + "-" + birthday_arr[0]);
            $("input[name=licence_number]").val(kor_sign.license_number);
            $("input[name=affiliation_kor]").val(kor_sign.office_name);

            //for(var i=0; i<$(".red_alert").length; i++) {
            //	//한국 아이디 입력했을 때 입력 안 되는 값들은 제외
            //	if(i==1 || i==2 || i==6) {
            //		continue;
            //	}
            //	$(".red_alert").eq(i).html("good");
            //	$(".red_alert").eq(i).css('display', 'none');
            //}
        }

    }

    function fail(res) {
        alert("Failed.\nPlease try again later.");
        return false;
    }

    function error(res) {
        alert("An error has occurred. \nPlease try again later.");
        return false;
    }
}


//이메일 중복 체크 한국으로 체크시
function email_check(email) {
    $.ajax({
        url: PATH + "ajax/client/ajax_member.php",
        type: "POST",
        data: {
            flag: "id_check",
            email: email
        },
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                //$(".red_alert").eq(0).html("good");
                //$(".red_alert").eq(0).css('display', 'none');
                //$(".mo_red_alert").eq(0).html("good");
                //$(".mo_red_alert").eq(0).css('display', 'none');
            } else if (res.code == 400) {
                alert("used_email_msg");
                $("input[name=email]").val("");
                $("input[name=mo_email]").val("");
                //$(".mo_red_alert").eq(0).html("used_email_msg");
                //$(".mo_red_alert").eq(0).css('display', 'block');
                return false;
            } else {
                alert("reject_msg");
                //$(".mo_red_alert").eq(0).html("reject_msg");
                //$(".mo_red_alert").eq(0).css('display', 'block');
                return false;
            }
        }
    });
}

/*$(document).ready(function(){
    $('select[name=nation_no]').val('25').trigger('change');
    
	//회원가입 이벤트
	$(document).on("click", "#submit", function(){
		var formData = $("form[name=signup_form]").serializeArray();

		var process = inputCheck(formData, checkType);
		var is_checked = process.status;
		var data = process.data;

		if(is_checked) {
			$(".loading").show();
			$("body").css("overflow-y","hidden");

			$.ajax({
				url : PATH+"ajax/client/ajax_member.php",
				type : "POST",
				data : {
					flag : "signup",
					data : data
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						alert(locale(language.value)("complet_signup"))
						window.location.replace(PATH);
					} else if(res.code == 400) {
						alert(locale(language.value)("error_signup"))
						return false;
					} else {
						alert(locale(language.value)("reject_msg"))
						return false;
					}
				},
				complete:function(){
					$(".loading").hide();
					$("body").css("overflow-y","auto");
				}
			});
		}
	});

	$('.term1_btn').on('click',function(){
		$('.term1').show();
		$('#terms1').attr("checked", true);
	});
	$('.term2_btn').on('click',function(){
		$('.term2').show();
		$('#terms2').attr("checked", true);
	});
});*/
</script>