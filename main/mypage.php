<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<?php
//$nation_list = get_data($_nation_query);

$nation_query = "SELECT
						*
					FROM nation
					ORDER BY 
					idx = 25 DESC, nation_en ASC";

$nation_list = get_data($nation_query);

$user_info = $member;

$user_idx = $user_info['idx'] ?? null;

if ($user_info["phone"]) {
    $_arr_phone = explode("-", $user_info["phone"]);
    $nation_tel = $_arr_phone[0];
    $phone = implode("-", array_splice($_arr_phone, 1));
}
if ($user_info["telephone"]) {
    $_tel_arr_phone = explode("-", $user_info["telephone"]);
    $tel_nation_tel = $_tel_arr_phone[0];
    $tel_nation_tel2 = $_tel_arr_phone[1];
    $tel_phone = implode("-", array_splice($_tel_arr_phone, 2));
}

// [22.04.25] 미로그인시 처리
if (empty($user_info)) {
    echo "<script>alert('Need to login'); location.replace(PATH+'login.php');</script>";
    exit;
}

echo "<script>
			$(document).ready(function(){
				var date_of_birth = '" . $user_info['date_of_birth'] . "';
				$('.datepicker_input').val(date_of_birth);
			});
		</script>";


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

    .mo_short_input {
        display: none;
    }

    .mo_short_input.on {
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
        width: 100px;
        float: right;

    }

    .input_others_on {
        display: none;
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
        $("select[name='nation_no']").change(function() {

            var value = $(this).val();

            if (value == 25) {
                $(".red_alert").eq(0).html("");
                $(".red_alert").eq(1).html("");
                $(".red_alert").eq(2).html("");
                $(".red_alert").eq(3).html("");
                $(".red_alert").eq(4).html("");

                $(".korea_only").addClass("on");
                //$(".korea_radio").addClass("on");
            } else {
                //$(".korea_radio").removeClass("on");
                $(".korea_only").removeClass("on");

                remove_value();
                $("#user2").prop('checked', true);
            }
        });
        $("select[name='mo_nation_no']").change(function() {

            var value = $(this).val();

            if (value == 25) {
                $(".red_alert").eq(0).html("");
                $(".red_alert").eq(1).html("");
                $(".red_alert").eq(2).html("");
                $(".red_alert").eq(3).html("");
                $(".red_alert").eq(4).html("");

                $(".korea_only").addClass("on");
                //$(".mo_korea_radio").addClass("on");
            } else {
                //$(".mo_korea_radio").removeClass("on");
                $(".korea_only").removeClass("on");

                remove_value("mo_");
            }
        });

        $(".select_others").change(function() {

            var this_chk = $(this).val();
            if (this_chk == "Others") {
                $(this).next().removeClass("input_others_on");
            } else {
                $(this).next().addClass("input_others_on");
                $(this).next().val("");
            }
        });


        function remove_value(mo = "") {
            $("input[name=" + mo + "affiliation_kor]").val("");
            $("input[name=" + mo + "name_kor]").val("");

            $(".red_alert").eq(0).html("good");
            $(".red_alert").eq(1).html("good");

            $("input[name=" + mo + "licence_number]").val("");
            $("input[name=" + mo + "specialty_number]").val("");
            $("input[name=" + mo + "nutritionist_number]").val("");

            $(".red_alert").eq(2).html("good");
            $(".red_alert").eq(3).html("good");
            $(".red_alert").eq(4).html("good");
        }
        $("input[name=food]").change(function() {

            var this_chk = $(this).val();
            if (this_chk == "Others") {
                $(".other_radio").next("label").addClass("on");
                $(".other_radio").next("label").find("input").addClass("on");
            } else {
                $(".other_radio").next("label").removeClass("on");
                $(".other_radio").next("label").find("input").removeClass("on");
            }
        });
        $("input[name=mo_food]").change(function() {
            var this_chk = $(this).val();

            if (this_chk == "Others") {
                //$(".mo_short_input").addClass("on");
                $(".other_radio").next("label").find("input").addClass("on");
            } else {
                //$(".mo_short_input").removeClass("on");
                $(".other_radio").next("label").find("input").removeClass("on");
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
        $("#mo_licence_number").click(function() {
            var _this = $(this).is(":checked");
            if (_this == true) {
                $(".red_alert").eq(2).html("good");
            } else {
                $(".red_alert").eq(2).html("");
            }
        });
        $("#mo_specialty_number").click(function() {
            var _this = $(this).is(":checked");
            if (_this == true) {
                $(".red_alert").eq(3).html("good");
            } else {
                $(".red_alert").eq(3).html("");
            }
        });
        $("#mo_nutritionist_number").click(function() {
            var _this = $(this).is(":checked");
            if (_this == true) {
                $(".red_alert").eq(4).html("good");
            } else {
                $(".red_alert").eq(4).html("");
            }
        });



    });
</script>
<section class="container mypage sub_page">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2><?= $locale("mypage") ?></h2>
                <div class="color-bar"></div>
                <!-- <ul>
                    <li>Home</li>
                    <li><?= $locale("mypage") ?></li>
                    <li>Account</li>
                </ul> -->
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <!-- <div class="sub_banner"> -->
        <!-- 	<h1><?= $locale("mypage") ?></h1> -->
        <!-- </div> -->
        <div class="x_scroll tab_scroll">
            <ul class="tab_pager location">
                <li class="on"><a href="./mypage.php"><?= $locale("mypage_account") ?></a></li>
                <li><a href="./mypage_registration.php"><?= $locale("mypage_registration") ?></a></li>
                <li><a href="./mypage_abstract.php"><?= $locale("mypage_abstract") ?></a></li>
                <!-- <li><a href="./mypage_favorite.php"><?= $locale("mypage_favorite") ?></a></li> -->
            </ul>
        </div>
        <div class="">
            <input type="hidden" name="check_type" value="1">
            <form name="modify_form">
                <div class="pc_only">
                    <table class="table detail_table">
                        <colgroup>
                            <col class="col_th" />
                            <col width="*" />
                        </colgroup>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("id") ?></th>
                            <td>
                                <div class="max_normal">
                                    <input type="text" name="email" value="<?= $user_info["email"] ?>" readonly value="<?= $user_info["email"]; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("password") ?></th>
                            <td>
                                <div class="max_normal">
                                    <input class="passwords" name="password" type="password" id="password" placeholder="Password">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("re_type_password") ?></th>
                            <td>
                                <div class="max_normal">
                                    <input class="passwords" name="password2" type="password" id="re_password" placeholder="Re-type Password">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("country") ?></th>
                            <td>
                                <div class="max_normal">
                                    <select id="nation_no" name="nation_no" class="required" onchange="option_changes()">
                                        <?php
                                        foreach ($nation_list as $n) {
                                            if ($language == "ko") {
                                                $nation = $n["nation_ko"];
                                            } else {
                                                $nation = $n["nation_en"];
                                            }
                                            if ($n["idx"] == $user_info["nation_no"]) {
                                                echo "<option selected data-nt=" . $n['nation_tel'] . " value=" . $n["idx"] . " " . $select_option . ">" . $nation . "</option>";
                                            } else {
                                                echo "<option data-nt=" . $n['nation_tel'] . " value=" . $n["idx"] . " " . $select_option . ">" . $nation . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("name") ?></th>
                            <td>
                                <div class="name_td clearfix max_normal">
                                    <div class="">
                                        <input name="first_name" type="text" placeholder="First name" value="<?= $user_info["first_name"] ?>">
                                    </div>
                                    <div class="">
                                        <input name="last_name" type="text" placeholder="Last name" value="<?= $user_info["last_name"] ?>">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<tr class="korea_only on">';
                        } else {
                            echo '<tr class="korea_only">';
                        }
                        ?>
                        <th><span class="red_txt">*</span><?= $locale("name") ?> (KOR)</th>
                        <td>
                            <div class="max_normal">
                                <input name="name_kor" type="text" value="<?= $user_info["name_kor"] ?>" class="kor_check">
                                <span class="mini_alert red_txt red_alert">good</span>
                            </div>
                        </td>
                        </tr>
                        <!--<tr>
							<th><?= $locale("first_name") ?>*</th>
							<td><input type="text" name="first_name" class="required" value="<?= $user_info["first_name"] ?>"></td>
						</tr>
						<tr>
							<th><?= $locale("last_name") ?>*</th>
							<td><input type="text" name="last_name" class="required" value="<?= $user_info["last_name"] ?>"></td>
						</tr>-->
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("affiliation") ?></th>
                            <td>
                                <div class="max_normal">
                                    <input type="text" name="affiliation" value="<?= $user_info["affiliation"] ?>">
                                </div>
                            </td>
                        </tr>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<tr class="korea_only on">';
                        } else {
                            echo '<tr class="korea_only">';
                        }
                        ?>
                        <th><span class="red_txt">*</span><?= $locale("affiliation") ?> (KOR)</th>
                        <td>
                            <div class="max_normal">
                                <input type="text" name="affiliation_kor" value="<?= $user_info["affiliation_kor"] ?>" class="kor_check">
                                <span class="mini_alert red_txt red_alert">good</span>
                            </div>
                        </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("department") ?></th>
                            <td>
                                <div class="max_normal">
                                    <select name="department" id="department">
                                        <?php
                                        $department_arr = array("Cardiology", "Endocrinology", "Internal Medicine", "Family Medicine", "Nursing", "Basic Science", "Pediatric", "Food & Nutrition", "Neurology", "Nephrology", "Pharmacology", "Pharmacy", "Preventive Medicine", "Exercise Physiology", "Clinical Pathology", "Other Professional");

                                        foreach ($department_arr as $d_arr) {
                                            if ($user_info["department"] == $d_arr) {
                                                echo '<option selected value="' . $d_arr . '">' . $d_arr . '</option>';
                                            } else {
                                                echo '<option value="' . $d_arr . '">' . $d_arr . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("phone") ?></th>
                            <td>
                                <!-- <div class="clearfix phone max_normal"> -->
                                <!-- <select name="nation_tel" class="required">  -->
                                <!-- 	<option value="" selected hidden>select</option> -->
                                <?php
                                //if($nation_tel) {
                                //echo "<option selected>".$nation_tel."</option>";
                                //}
                                ?>
                                <!-- </select> -->
                                <!-- 	<input type="text" name="nation_tel" value=""></td> -->
                                <!-- 	<input type="text" name="phone" class="required" placeholder="010-0000-0000" value="<?= $phone ?>"></td> -->
                                <!-- </div> -->
                                <div class="max_normal phone">
                                    <input name="nation_tel" type="text" value="<?= $nation_tel; ?>">
                                    <input name="phone" type="text" value="<?= $phone ?>">
                                </div>
                            </td>
                        </tr>
                        <!--2022-05-09 추가사항-->
                        <tr>
                            <th><span class="red_txt"></span>Telephone</th>
                            <td>
                                <input value="<?= $tel_nation_tel; ?>" class="tel_number tel_phone" name="tel_nation_tel" type="text" maxlength="60">
                                <input value="<?= $tel_nation_tel2; ?>" class="tel_numbers tel_phone" name="telephone1" type="text" maxlength="60">
                                <input value="<?= $tel_phone; ?>" class="tel_numbers tel_phone2" name="telephone2" type="text" maxlength="60">
                                <!-- <div> -->
                                <!-- 	<span class="mini_alert red_txt red_alert"></span> -->
                                <!-- 	<span class="mini_alert red_txt red_alert"></span> -->
                                <!-- <div> -->
                            </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span><?= $locale("category_title") ?></th>
                            <td>
                                <div class="max_normal">
                                    <select name="category" id="category" class="select_others">
                                        <?php
                                        $category_arr = array("Professor", "Specialist", "Fellow", "Resident", "Researcher", "Military Medical Officer", "Nurse", "Nutritionist", "Student", "Pharmacist", "Corporate member", "Others");
                                        $category_count = 0;
                                        foreach ($category_arr as $c_arr) {
                                            if ($user_info["category"] == $c_arr) {
                                                echo '<option selected value="' . $c_arr . '">' . $c_arr . '</option>';
                                                $category_count = -12;
                                            } else if ($category_count == 11) {
                                                echo '<option selected value="' . $c_arr . '">' . $c_arr . '</option>';
                                            } else {
                                                echo '<option value="' . $c_arr . '">' . $c_arr . '</option>';
                                                $category_count++;
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if ($category_count == 11) {
                                    ?>
                                        <input value="<?= $user_info["category"] ?>" type="text" name="category_input" class="input_others en_check" maxlength="60">
                                    <?php
                                    } else {
                                    ?>
                                        <input type="text" name="category_input" class="input_others en_check input_others_on" maxlength="60">
                                    <?php
                                    }
                                    ?>
                                </div>
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
                                        $title_count = 0;
                                        foreach ($title_arr as $t_arr) {
                                            if ($user_info["title"] == $t_arr) {
                                                echo '<option selected value="' . $t_arr . '">' . $t_arr . '</option>';
                                                $title_count = -5;
                                            } else if ($title_count == 4) {
                                                echo '<option selected value="' . $t_arr . '">' . $t_arr . '</option>';
                                            } else {
                                                echo '<option value="' . $t_arr . '">' . $t_arr . '</option>';
                                                $title_count++;
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if ($title_count == 4) {
                                    ?>
                                        <input value="<?= $user_info["title"] ?>" type="text" name="title_input" class="input_others en_check" maxlength="60">
                                    <?php
                                    } else {
                                    ?>
                                        <input type="text" name="title_input" class="input_others en_check input_others_on" maxlength="60">
                                    <?php
                                    }
                                    ?>
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
                                        $degree_count = 0;
                                        foreach ($degree_arr as $d_arr) {
                                            if ($user_info["degree"] == $d_arr) {
                                                echo '<option selected value="' . $d_arr . '">' . $d_arr . '</option>';
                                                $degree_count = -5;
                                            } else if ($degree_count == 3) {
                                                echo '<option selected value="' . $d_arr . '">' . $d_arr . '</option>';
                                            } else {
                                                echo '<option value="' . $d_arr . '">' . $d_arr . '</option>';
                                                $degree_count++;
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if ($degree_count == 3) {
                                    ?>
                                        <input value="<?= $user_info["degree"] ?>" type="text" name="degree_input" class="input_others en_check" maxlength="60">
                                    <?php
                                    } else {
                                    ?>
                                        <input type="text" name="degree_input" class="input_others en_check input_others_on" maxlength="60">
                                    <?php
                                    }
                                    ?>

                                    <!-- <span class="mini_alert red_txt red_alert_option"></span> -->
                                </div>
                                <!-- <span class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse,<br/>Nutritionist, Student, Pharmacist, Corporate member, Others)</span> -->
                                <span class="mini_alert"></span>
                            </td>
                        </tr>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<tr class="korea_only on">';
                        } else {
                            echo '<tr class="korea_only">';
                        }
                        ?>

                        <th><span class="red_txt">*</span>의사면허번호</th>
                        <td>
                            <div class="max_normal">
                                <input <?= $user_info["licence_number"] != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="licence_number" name="licence_number2" value="Not applicable"><label for="licence_number">Not
                                    applicable</label>
                                <input <?= $user_info["licence_number"] != "Not applicable" ? "" : "disabled"; ?> name="licence_number" type="text" value="<?= $user_info["licence_number"] != "Not applicable" ? $user_info["licence_number"] : ""; ?>" class="kor_check_number">
                                <span class="mini_alert red_txt red_alert">good</span>
                            </div>
                        </td>
                        </tr>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<tr class="korea_only on">';
                        } else {
                            echo '<tr class="korea_only">';
                        }
                        ?>
                        <th><span class="red_txt">*</span>전문의 번호</th>
                        <td>
                            <div class="max_normal">
                                <input <?= $user_info["specialty_number"] != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="specialty_number" name="specialty_number2" value="Not applicable"><label for="specialty_number">Not
                                    applicable</label>
                                <input <?= $user_info["specialty_number"] != "Not applicable" ? "" : "disabled"; ?> name="specialty_number" type="text" value="<?= $user_info["specialty_number"] != "Not applicable" ? $user_info["specialty_number"] : ""; ?>" class="kor_check_number">
                                <span class="mini_alert red_txt red_alert">good</span>
                            </div>
                        </td>

                        </tr>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<tr class="korea_only on">';
                        } else {
                            echo '<tr class="korea_only">';
                        }
                        ?>
                        <th><span class="red_txt">*</span>영양사면허번호</th>
                        <td>
                            <div class="max_normal">
                                <input <?= $user_info["nutritionist_number"] != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="nutritionist_number" name="nutritionist_number2" value="Not applicable"><label for="nutritionist_number">Not applicable</label>
                                <input <?= $user_info["nutritionist_number"] != "Not applicable" ? "" : "disabled"; ?> name="nutritionist_number" type="text" value="<?= $user_info["nutritionist_number"] != "Not applicable" ? $user_info["nutritionist_number"] : ""; ?>" class="kor_check_number">
                                <span class="mini_alert red_txt red_alert">good</span>
                            </div>
                        </td>
                        </tr>
                        <tr>
                            <th><span class="red_txt">*</span>Date of Birth</th>
                            <td>
                                <div class="max_normal">
                                    <input maxlength="10" name="date_of_birth" type="text" class="datepicker_input" id="datepicker" value="<?= $user_info["date_of_birth"]; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Special Request for Food</th>
                            <td>
                                <div class="label_wrap">
                                    <?php
                                    $food_radio = array("None", "Vegetarian", "Halal", "Others");
                                    $user_info["request_food"];
                                    $food_radio_value = array("", "", "", "checked");

                                    for ($i = 0; $i < 4; $i++) {
                                        if ($food_radio[$i] == $user_info["request_food"]) {
                                            $food_radio_value[$i] = "checked";
                                            $food_radio_value[3] = "";
                                        }
                                    }
                                    ?>
                                    <input <?php echo $food_radio_value[0]; ?> value="None" type="radio" id="none" class="radio" name="food">
                                    <label for="none">None</label>
                                    <input <?php echo $food_radio_value[1]; ?> value="Vegetarian" type="radio" id="vegetarian" class="radio" name="food">
                                    <label for="vegetarian">Vegetarian</label>
                                    <input <?php echo $food_radio_value[2]; ?> value="Halal" type="radio" id="halal" class="radio" name="food">
                                    <label for="halal">Halal</label>
                                    <input <?php echo $food_radio_value[3]; ?> value="Others" type="radio" id="Others" class="radio other_radio" name="food">
                                    <label for="Others">
                                        Others
                                        <?php
                                        if ($food_radio_value[3] == "checked") {
                                            echo '<input value="' . $user_info["request_food"] . '" name="short_input" type="text" class="short_input on">';
                                        } else {
                                            echo '<input name="short_input" type="text" class="short_input">';
                                        }
                                        ?>

                                    </label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <form name="mo_modify_form">
                <div class="mb_only">
                    <ul class="sign_list">
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("id") ?></p>
                            <div>
                                <input type="text" name="mo_email" class="required" maxlength="50" readonly value="<?= $user_info["email"]; ?>">
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("password") ?></p>
                            <div>
                                <input class="passwords" type="password" name="mo_password" class="required" placeholder="Password">
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("re_type_password") ?></p>
                            <div>
                                <input class="passwords" type="password" name="mo_password2" class="required" placeholder="Re-type Password">
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("country") ?></p>
                            <div>
                                <select id="mo_nation_no" name="mo_nation_no" class="required" onchange="option_changes()">
                                    <option value="" selected hidden>Choose </option>
                                    <?php
                                    foreach ($nation_list as $n) {
                                        if ($language == "ko") {
                                            $nation = $n["nation_ko"];
                                        } else {
                                            $nation = $n["nation_en"];
                                        }
                                        if ($n["idx"] == $user_info["nation_no"]) {
                                            echo "<option selected data-nt=" . $n['nation_tel'] . " value=" . $n["idx"] . " " . $select_option . ">" . $nation . "</option>";
                                        } else {
                                            echo "<option data-nt=" . $n['nation_tel'] . " value=" . $n["idx"] . " " . $select_option . ">" . $nation . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("name") ?></p>
                            <div class="half_form clearfix">
                                <input name="mo_first_name" type="text" placeholder="First name" value="<?= $user_info["first_name"] ?>" class="en_check">
                                <input name="mo_last_name" type="text" placeholder="Last name" value="<?= $user_info["last_name"] ?>" class="en_check">
                            </div>
                        </li>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<li class="korea_only on">';
                        } else {
                            echo '<li class="korea_only">';
                        }
                        ?>
                        <p class="label"><span class="red_txt">*</span><?= $locale("name") ?> (KOR)</p>
                        <div>
                            <input name="mo_name_kor" type="text" value="<?= $user_info["name_kor"] ?>" class="kor_check">
                        </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("affiliation") ?></p>
                            <div>
                                <input type="text" name="mo_affiliation" value="<?= $user_info["affiliation"] ?>" class="en_check">
                            </div>
                        </li>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<li class="korea_only on">';
                        } else {
                            echo '<li class="korea_only">';
                        }
                        ?>
                        <p class="label"><span class="red_txt">*</span><?= $locale("affiliation") ?> (KOR)</p>
                        <div>
                            <input type="text" name="mo_affiliation_kor" value="<?= $user_info["affiliation_kor"] ?>" class="kor_check">
                        </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("department") ?></p>
                            <div>
                                <select name="mo_department" id="mo_department">
                                    <?php
                                    $department_arr = array("Cardiology", "Endocrinology", "Internal Medicine", "Family Medicine", "Nursing", "Basic Science", "Pediatric", "Food & Nutrition", "Neurology", "Nephrology", "Pharmacology", "Pharmacy", "Preventive Medicine", "Exercise Physiology", "Clinical Pathology", "Other Professiona");

                                    foreach ($department_arr as $d_arr) {
                                        if ($user_info["department"] == $d_arr) {
                                            echo '<option selected value="' . $d_arr . '">' . $d_arr . '</option>';
                                        } else {
                                            echo '<option value="' . $d_arr . '">' . $d_arr . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("phone") ?></p>
                            <div class="phone_form clearfix">
                                <input name="mo_nation_tel" type="text" value="<?= $nation_tel; ?>">
                                <input name="mo_phone" type="text" value="<?= $phone ?>">
                            </div>
                        </li>
                        <li>
                            <p class="label">Telephone</p>
                            <div class="phone_form clearfix">
                                <input value="<?= $tel_nation_tel; ?>" class="tel_number tel_phone" name="mo_tel_nation_tel" type="text" maxlength="60">
                                <input value="<?= $tel_nation_tel2; ?>" class="tel_numbers tel_phone" name="mo_telephone1" type="text" maxlength="60">
                                <input value="<?= $tel_phone; ?>" class="tel_numbers tel_phone2" name="mo_telephone2" type="text" maxlength="60">
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span><?= $locale("category_title") ?></p>
                            <div>
                                <select name="mo_category" id="mo_category" class="select_others">
                                    <?php
                                    $category_arr = array("Professor", "Specialist", "Fellow", "Resident", "Researcher", "Military Medical Officer", "Nurse", "Nutritionist", "Student", "Pharmacist", "Corporate member", "Others");
                                    $mo_category_count = 0;
                                    foreach ($category_arr as $c_arr) {
                                        if ($user_info["category"] == $c_arr) {
                                            echo '<option selected value="' . $c_arr . '">' . $c_arr . '</option>';
                                            $mo_category_count = -12;
                                        } else if ($mo_category_count == 11) {
                                            echo '<option selected value="' . $c_arr . '">' . $c_arr . '</option>';
                                        } else {
                                            echo '<option value="' . $c_arr . '">' . $c_arr . '</option>';
                                            $mo_category_count++;
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                                if ($mo_category_count == 11) {
                                ?>
                                    <input value="<?= $user_info["category"] ?>" type="text" name="mo_category_input" class="input_others en_check" maxlength="60">
                                <?php
                                } else {
                                ?>
                                    <input type="text" name="mo_category_input" class="input_others en_check input_others_on" maxlength="60">
                                <?php
                                }
                                ?>
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span>Title</p>
                            <div>
                                <select name="mo_title" id="mo_title" class="select_others">
                                    <option value="" selected hidden>Choose</option>
                                    <?php
                                    $title_arr = array("Professor", "Dr.", "Mr.", "Ms.", "Others");
                                    $mo_title_count = 0;
                                    foreach ($title_arr as $t_arr) {
                                        if ($user_info["title"] == $t_arr) {
                                            echo '<option selected value="' . $t_arr . '">' . $t_arr . '</option>';
                                            $mo_title_count = -5;
                                        } else if ($mo_title_count == 4) {
                                            echo '<option selected value="' . $t_arr . '">' . $t_arr . '</option>';
                                        } else {
                                            echo '<option value="' . $t_arr . '">' . $t_arr . '</option>';
                                            $mo_title_count++;
                                        }
                                    }
                                    ?>
                                </select>
                                <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                                <?php
                                if ($mo_title_count == 4) {
                                ?>
                                    <input value="<?= $user_info["title"] ?>" type="text" name="mo_title_input" class="input_others en_check" maxlength="60">
                                <?php
                                } else {
                                ?>
                                    <input type="text" name="mo_title_input" class="input_others en_check input_others_on" maxlength="60">
                                <?php
                                }
                                ?>
                            </div>
                            <!-- <p class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse, Nutritionist, Student, Pharmacist, Corporate member, Others)</p> -->
                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span>Degree</p>
                            <div>
                                <select name="mo_degree" id="mo_degree" class="select_others">
                                    <option value="" selected hidden>Choose</option>
                                    <?php
                                    $degree_arr = array("M.D", "Ph.D.", "M.D., Ph.D.", "Others");
                                    $mo_degree_count = 0;
                                    foreach ($degree_arr as $d_arr) {
                                        if ($user_info["degree"] == $d_arr) {
                                            echo '<option selected value="' . $d_arr . '">' . $d_arr . '</option>';
                                            $mo_degree_count = -5;
                                        } else if ($mo_degree_count == 3) {
                                            echo '<option selected value="' . $d_arr . '">' . $d_arr . '</option>';
                                        } else {
                                            echo '<option value="' . $d_arr . '">' . $d_arr . '</option>';
                                            $mo_degree_count++;
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                                if ($mo_degree_count == 3) {
                                ?>
                                    <input value="<?= $user_info["degree"] ?>" type="text" name="mo_degree_input" class="input_others en_check" maxlength="60">
                                <?php
                                } else {
                                ?>
                                    <input type="text" name="mo_degree_input" class="input_others en_check input_others_on" maxlength="60">
                                <?php
                                }
                                ?>
                                <!-- <span class="mini_alert red_txt mo_red_alert_option"></span> -->
                            </div>
                            <!-- <p class="mini_alert">(Professor, Specialist, Fellow, Resident, Researcher, Military Medical Officer, Nurse, Nutritionist, Student, Pharmacist, Corporate member, Others)</p> -->
                        </li>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<li class="korea_only on">';
                        } else {
                            echo '<li class="korea_only">';
                        }
                        ?>
                        <p class="label"><span class="red_txt">*</span>의사면허번호</p>
                        <div>
                            <input <?= $user_info["licence_number"] != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="mo_licence_number" name="mo_licence_number2" value="Not applicable"><label for="mo_licence_number">Not
                                applicable</label>
                            <input <?= $user_info["licence_number"] != "Not applicable" ? "" : "disabled"; ?> name="mo_licence_number" type="text" value="<?= $user_info["licence_number"] != "Not applicable" ? $user_info["licence_number"] : ""; ?>" class="mo_kor_check">
                        </div>
                        </li>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<li class="korea_only on">';
                        } else {
                            echo '<li class="korea_only">';
                        }
                        ?>
                        <p class="label"><span class="red_txt">*</span>전문의 번호</p>
                        <div>
                            <input <?= $user_info["specialty_number"] != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="mo_specialty_number" name="mo_specialty_number2" value="Not applicable"><label for="mo_specialty_number">Not
                                applicable</label>
                            <input <?= $user_info["specialty_number"] != "Not applicable" ? "" : "disabled"; ?> name="mo_specialty_number" type="text" value="<?= $user_info["specialty_number"] != "Not applicable" ? $user_info["specialty_number"] : ""; ?>" class="mo_kor_check">
                        </div>

                        </li>
                        <?php
                        if ($user_info["nation_no"] == 25) {
                            echo '<li class="korea_only on">';
                        } else {
                            echo '<li class="korea_only">';
                        }
                        ?>
                        <p class="label"><span class="red_txt">*</span>영양사면허번호</p>
                        <div>
                            <input <?= $user_info["nutritionist_number"] != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="mo_nutritionist_number" name="mo_nutritionist_number2" value="Not applicable"><label for="mo_nutritionist_number">Not applicable</label>
                            <input <?= $user_info["nutritionist_number"] != "Not applicable" ? "" : "disabled"; ?> name="mo_nutritionist_number" type="text" value="<?= $user_info["nutritionist_number"] != "Not applicable" ? $user_info["nutritionist_number"] : ""; ?>" class="mo_kor_check">
                        </div>

                        </li>
                        <li>
                            <p class="label"><span class="red_txt">*</span>Date of Birth</p>
                            <div>
                                <input maxlength="10" name="mo_date_of_birth" type="text" class="datepicker_input" id="datepicker" value="<?= $user_info["date_of_birth"]; ?>">
                            </div>
                        </li>
                        <li>
                            <p class="label"><span class="red_txt"></span>Special Request for Food</p>
                            <div>
                                <div class="label_wrap">
                                    <?php
                                    $food_radio = array("None", "Vegetarian", "Halal", "Others");
                                    $user_info["request_food"];
                                    $food_radio_value = array("", "", "", "checked");

                                    for ($i = 0; $i < 4; $i++) {
                                        if ($food_radio[$i] == $user_info["request_food"]) {
                                            $food_radio_value[$i] = "checked";
                                            $food_radio_value[3] = "";
                                        }
                                    }
                                    ?>
                                    <input <?php echo $food_radio_value[0]; ?> value="None" type="radio" id="mo_none" class="radio" name="mo_food">
                                    <label for="mo_none">None</label>
                                    <input <?php echo $food_radio_value[1]; ?> value="Vegetarian" type="radio" id="mo_vegetarian" class="radio" name="mo_food">
                                    <label for="mo_vegetarian">Vegetarian</label>
                                    <input <?php echo $food_radio_value[2]; ?> value="Halal" type="radio" id="mo_halal" class="radio" name="mo_food">
                                    <label for="mo_halal">Halal</label>
                                    <input <?php echo $food_radio_value[3]; ?> value="Others" type="radio" id="mo_Others" class="radio other_radio" name="mo_food">
                                    <label for="mo_Others">
                                        Others
                                        <?php
                                        if ($food_radio_value[3] == "checked") {
                                            echo '<input value="' . $user_info["request_food"] . '" name="mo_short_input" type="text" class="mo_short_input on">';
                                        } else {
                                            echo '<input name="mo_short_input" type="text" class="mo_short_input">';
                                        }
                                        ?>
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="right_btn_wrap">
                    <button type="button" id="submit" class="btn submit submit_btn"><?= $locale("edit_btn") ?></button>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="./js/script/client/member.js"></script>
<script>
    //국가 선택시 자동 국가번호 삽입
    function option_changes() {

        var pc_only = $(".pc_only").is(':visible');

        var mo = pc_only == true ? "" : "mo_";

        var nt = $("#" + mo + "nation_no option:selected").data("nt");
        $("input[name=" + mo + "nation_tel]").val(nt);
        $("input[name=" + mo + "tel_nation_tel]").val(nt);

        if (nt != 82) {
            $(".red_alert").eq(0).html("good");
            $(".red_alert").eq(1).html("good");
            $(".red_alert").eq(2).html("good");
            $(".red_alert").eq(3).html("good");
            $(".red_alert").eq(4).html("good");
        } else {
            $(".red_alert").eq(0).html("");
            $(".red_alert").eq(1).html("");
            $(".red_alert").eq(2).html("");
            $(".red_alert").eq(3).html("");
            $(".red_alert").eq(4).html("");

        }
    }

    function name_check(name) {

        var pc_only = $(".pc_only").is(':visible');

        var mo = pc_only == true ? "" : "mo_";

        var first_name = $("input[name=" + name + "]").val();
        var first_name_len = first_name.trim().length;
        first_name = (typeof(first_name) != "undefined") ? first_name : null;

        if (!first_name || first_name_len <= 0) {
            $("input[name=" + name + "]").focus();
            if (mo === "mo_") {
                name = name.replace("mo_", "");
            }

            if (name == "first_name") {
                name = "first name";
            } else if (name == "last_name") {
                name = "last name";
            } else if (name == "name_kor") {
                name = "name (KOR)";
            } else if (name == "affiliation_kor") {
                name = "affiliation (KOR)";
            } else if (name == "short_input") {
                name = "short input";
            }

            alert("Invalid " + name);
            return false;
        }
    }

    function pw_check(i, password, password2) {
        var pw1 = $("input[name=" + password + "]").val();
        var pw1_len = pw1.trim().length;
        pw1 = (typeof(pw1) != "undefined") ? pw1 : null;

        var pw2 = $("input[name=" + password2 + "]").val();
        var pw2_len = pw2.trim().length;
        pw2 = (typeof(pw2) != "undefined") ? pw2 : null;

        if (pw1_len > 0 || pw2_len > 0) {
            if (pw1 !== pw2) {
                $("input[name=" + password + "]").focus();
                alert("inconsistency_passwrod");
                return false;
            }
        }
    }

    $(document).on("keyup", ".kor_check_number", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(this).next().html("");
        } else {
            $(this).next().html("good");
        }
    });

    $(document).on("keyup", "input[name=mo_name_kor]", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(".red_alert").eq(0).html("");
        } else {
            $(".red_alert").eq(0).html("good");
        }
    });
    $(document).on("keyup", "input[name=mo_affiliation_kor]", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(".red_alert").eq(1).html("");
        } else {
            $(".red_alert").eq(1).html("good");
        }
    });
    $(document).on("keyup", "input[name=mo_licence_number]", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(".red_alert").eq(2).html("");
        } else {
            $(".red_alert").eq(2).html("good");
        }
    });
    $(document).on("keyup", "input[name=mo_nutritionist_number]", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(".red_alert").eq(3).html("");
        } else {
            $(".red_alert").eq(3).html("good");
        }
    });
    $(document).on("keyup", "input[name=mo_specialty_number]", function() {
        var _this = $(this).val();
        if (_this == "") {
            $(".red_alert").eq(4).html("");
        } else {
            $(".red_alert").eq(4).html("good");
        }
    });


    $(document).on("keyup", ".short_input", function(key) {
        var pattern_eng = /[^a-zA-Z\s]/gi;
        var _this = $(this);
        if (key.keyCode != 8) {
            var first_name = _this.val().replace(pattern_eng, '');
            _this.val(first_name);
        }
    });

    $(document).on("click", "#submit", function() {

        var pc_only = $(".pc_only").is(':visible');

        var mo = pc_only == true ? "" : "mo_";
        var option_arr = ["Country", "Department", "Category", "Title", "Degree"];

        var red_alert = document.getElementsByClassName("red_alert");

        //국가 유효성
        var nation_no = $("#" + mo + "nation_no option:selected").val();
        if (!nation_no) {
            alert("check_" + mo + "" + option_arr[0]);
            return;
        }

        var check = pw_check(1, mo + "password", mo + "password2");

        if (check == false) return;

        check = pw_check(2, mo + "password", mo + "password2");

        if (check == false) return;

        check = name_check(mo + "first_name");
        if (check == false) return;
        check = name_check(mo + "last_name");
        if (check == false) return;


        if (red_alert[0].innerHTML !== "good") {
            check = name_check(mo + "name_kor");
            if (check == false) return;
        }

        check = name_check(mo + "affiliation");
        if (check == false) return;

        if (red_alert[1].innerHTML !== "good") {
            check = name_check(mo + "affiliation_kor");
            if (check == false) return;
        }

        var department = $("#" + mo + "department option:selected").val();

        if (!department) {
            alert("check_" + mo + "" + option_arr[1]);
            return;
        }

        var category = $("#" + mo + "category option:selected").val();
        var category_input = $("input[name=" + mo + "category_input").val();

        if (!category) {
            alert("check_" + mo + "" + option_arr[2]);
            return;
        } else if (category == "Others") {
            if (category_input == "" || category_input == null) {
                alert("Invalid category others");
                return;
            }
        }

        //2022-05-09 추가
        var title = $("#" + mo + "title option:selected").val();
        var title_input = $("input[name=" + mo + "title_input").val();

        if (title == "" || title == null) {
            alert("Invalid " + option_arr[3]);
            return;
        } else if (title == "Others") {
            if (title_input == "" || title_input == null) {
                alert("Invalid title others");
                return;
            }
        }

        var degree = $("#" + mo + "degree option:selected").val();
        var degree_input = $("input[name=" + mo + "degree_input").val();

        if (degree == "" || degree == null) {
            alert("Invalid " + option_arr[4]);
            return;
        } else if (degree == "Others") {
            if (degree_input == "" || degree_input == null) {
                alert("Invalid degree others");
                return;
            }
        }

        var licence_number = $("input[name=" + mo + "licence_number]").val();
        var licence_number2 = $("input[name=" + mo + "licence_number2]").is(":checked");
        var nutritionist_number = $("input[name=" + mo + "nutritionist_number]").val();
        var nutritionist_number2 = $("input[name=" + mo + "nutritionist_number2]").is(":checked");
        var specialty_number = $("input[name=" + mo + "specialty_number]").val();
        var specialty_number2 = $("input[name=" + mo + "specialty_number2]").is(":checked");

        if (red_alert[2].innerHTML !== "good") {
            if (licence_number == "" && licence_number2 == false) {
                alert("Invalid licence number");
                return;
            }
        }

        if (red_alert[3].innerHTML !== "good") {
            if (specialty_number == "" && specialty_number2 == false) {
                alert("Invalid specialty number");
                return;
            }
        }

        if (red_alert[4].innerHTML !== "good") {
            if (nutritionist_number == "" && nutritionist_number2 == false) {
                alert("Invalid nutritionist number");
                return;
            }
        }

        var tel_nation_tel = $("input[name=" + mo + "tel_nation_tel]").val();
        var telephone1 = $("input[name=" + mo + "telephone1]").val();
        var telephone2 = $("input[name=" + mo + "telephone2]").val();

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

        if ($("input[name=" + mo + "food]:checked").val() == "Others") {
            var check = name_check(mo + "short_input");
            if (check == false) {
                return;
            }
        }

        check = name_check(mo + "nation_tel");
        if (check == false) return;

        check = name_check(mo + "phone");
        if (check == false) return;

        if (!confirm(locale(language.value)("account_modify_msg"))) return;

        var formdata;
        if (pc_only == true) {
            formdata = $("form[name=modify_form]").eq(0).serializeArray();
        } else {
            formdata = $("form[name=mo_modify_form]").eq(0).serializeArray();
        }

        var data = {};

        $.each(formdata, function(key, value) {
            var ok = value["name"];

            ok = ok.replace("mo_", "");
            var ov = value["value"];

            data[ok] = ov;

        });

        var user_idx = "<?= $user_idx ?>";

        data.type = "UPDATE";
        data.flag = "signup_join";
        data.idx = user_idx;
        data.nation_no = nation_no;
        data.category = category;
        data.category_input = category_input;
        data.department = department;
        data.password = data.password2;

        data.title = title;
        data.title_input = title_input;
        data.degree = degree;
        data.degree_input = degree_input;
        data.tel_nation_tel = tel_nation_tel;
        data.telephone1 = telephone1;
        data.telephone2 = telephone2;

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
            if (res.code == 200) {
                alert(locale(language.value)("complet_account_modify"));
                location.reload();
            } else if (res.code == 400) {
                alert(locale(language.value)("error_account_modify"));
                return false;
            } else {
                alert(locale(language.value)("reject_msg"))
                return false;
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





    //$(document).ready(function(){
    //	//비밀번호 입력 시 비밀번호 필수값으로 전환
    //	$("#password, #re_password").on("change", function(){
    //		$(this).attr("name", $(this).attr("id"));
    //		$("#password, #re_password").addClass("required");
    //	});

    //	$(document).on("click", ".submit_btn", function(){

    //		var formData = $("form[name=modify_form]").serializeArray();

    //		var process = inputCheck(formData,checkType);

    //		var data = process.data;
    //		var status = process.status;
    //        if(status) {
    //            if(confirm(locale(language.value)("account_modify_msg"))) {
    //                $.ajax({
    //                    url : PATH+"ajax/client/ajax_member.php",
    //                    type : "POST",
    //                    data : {
    //                        flag : "update",
    //                        data : data
    //                    },
    //                    dataType : "JSON",
    //                    success : function(res){
    //                        if(res.code == 200) {
    //                            alert(locale(language.value)("complet_account_modify"));
    //                            location.reload();
    //                        } else if(res.code == 400) {
    //                            alert(locale(language.value)("error_account_modify"));
    //                            return false;
    //                        } else {
    //                            alert(locale(language.value)("reject_msg"))
    //                            return false;
    //                        }
    //                    }
    //                });
    //		    }
    //        }
    //	});

    //});
</script>
<?php include_once('./include/footer.php'); ?>