<?php
include_once('./include/head.php');
include_once('./include/header.php');

$registration_idx = $_GET["idx"] ?? null;

/*$sql_during =	"SELECT
						IF(DATE(NOW()) BETWEEN period_event_pre_start AND period_event_pre_end, 'Y', 'N') AS yn
					FROM info_event";*/

$sql_during = "SELECT
						IF(NOW() BETWEEN '2022-08-18 17:00:00' AND '2022-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//할인 가격 끝 여부
$sql_during =    "SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

//특정 회원 가격 변동 이후 삭제
//if($registration_idx == 512) {
//	$r_during_yn = 'N';
//}

if ($_SESSION['USER']['idx'] == 336) {
    $during_yn = 'Y';
}

if ($during_yn !== "Y") {
?>

    <section class="container submit_application registration_closed">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Registration</h2>
                    <!-- <ul class="clearfix">
					<li>Home</li>
					<li>Registration</li>
				</ul> -->
                </div>
            </div>
        </div>
        <div class="inner coming">
            <div class="sub_banner">
                <h5>coming soon...</h5>
            </div>
        </div>
    </section>


<?php
} else {
    $nation_list_query = $_nation_query;
    $nation_list = get_data($nation_list_query);

    if (!empty($_SESSION["USER"])) {
        $user_info = $member;
    } else {
        echo "<script>alert('Need to login'); window.location.replace(PATH+'login.php');</script>";
        exit;
    }

    $_arr_phone = explode("-", $user_info["phone"]);
    $nation_tel = $_arr_phone[0];
    $phone = implode("-", array_splice($_arr_phone, 1));

    $sql_price =    "SELECT
							type_en
						FROM info_event_price
						WHERE is_deleted = 'N'
						ORDER BY FIELD(idx, 1,2,3,4,5,6,7,8,9,10,12,11)";
    $price = get_data($sql_price);

    $user_idx = $_SESSION["USER"]["idx"];

    $category_sql = "SELECT
							category, nation_no
						FROM member
						WHERE idx =" . $user_idx;

    $category_value = sql_fetch($category_sql);
    $category = $category_value["category"];

    $nation_query = "SELECT
							nation_en, idx
						FROM nation
						WHERE idx = " . $category_value["nation_no"];


    $nation_value = sql_fetch($nation_query);
    $nation = $nation_value['nation_en'];
    $nation_no = $nation_value['idx'];
    $langage = ($nation_value["idx"] == 25) ? "kor" : "en";

    $usd_80_check = "";
    $usd_40_check = "";
    $krw_8_check = "";
    $krw_10_check = "";
    $krw_4_check = "";

    if ($nation_value["idx"] != 25) {
        if ($user_info["category"] == "Specialist" || $user_info["category"] == "Professor") {
            $usd_80_check = "checked";
        } else {
            $usd_40_check = "checked";
        }
    } else {
        if ($user_info["category"] == "Specialist" || $user_info["category"] == "Professor") {

            if ($user_info["ksola_member_status"] == 1) {
                //회원
                $krw_8_check = "checked";
            } else {
                //비회원
                $krw_10_check = "checked";
            }
        } else {
            $krw_4_check = "checked";
        }
    }

    $user_info = $member;

    $visa_nation_no = $user_info["nation_no"];
    $first_name = $user_info["first_name"];
    $last_name = $user_info["last_name"];
    $date_of_birth = $user_info["date_of_birth"];


    if (!empty($registration_idx)) {

        $registration_sql = "SELECT
								*
							FROM request_registration
							WHERE idx = {$registration_idx}
		";

        $registration_sql_select = sql_fetch($registration_sql);

        $price = $registration_sql_select["price"];
        if ($price == 50000) {
            $krw_4_check = "checked";
            $krw_8_check = "";
            $krw_10_check = "";
        } else if ($price == 80000) {
            $krw_4_check = "";
            $krw_8_check = "checked";
            $krw_10_check = "";
        } else if ($price == 100000) {
            $krw_4_check = "";
            $krw_8_check = "";
            $krw_10_check = "checked";
        }
        if ($price == 250) {
            $usd_80_check = "checked ";
            $usd_40_check = "";
        } else if ($price == 100) {
            $usd_80_check = "";
            $usd_40_check = "checked";
        }


        $nation_no = $registration_sql_select["nation_no"] ?? null;
        $nation_query = "SELECT
							nation_en, idx
						FROM nation
						WHERE idx = " . $nation_no;


        $nation_value = sql_fetch($nation_query);
        $nation = $nation_value['nation_en'];
        $langage = ($nation_value["idx"] == 25) ? "kor" : "en";

        //수정일 땐 레지스트레이션에 등록되어 있는 회원 정보
        $user_info = $registration_sql_select;

        $welcome_reception_yn = $registration_sql_select["welcome_reception_yn"];;
        $day1_luncheon_yn = $registration_sql_select["day1_luncheon_yn"];
        $day2_breakfast_yn = $registration_sql_select["day2_breakfast_yn"];
        $day2_luncheon_yn = $registration_sql_select["day2_luncheon_yn"];
        $day3_breakfast_yn = $registration_sql_select["day3_breakfast_yn"];
        $day3_luncheon_yn = $registration_sql_select["day3_luncheon_yn"];
        $register_path = $registration_sql_select["register_path"];
        $register_path_others = $registration_sql_select["register_path_others"];

        $register_path_arr = explode(',', $register_path);

        $invitation_yn = $registration_sql_select["invitation_yn"];
        $invitation_first_name = $registration_sql_select["invitation_first_name"];
        $invitation_last_name = $registration_sql_select["invitation_last_name"];
        $invitation_nation_no = $registration_sql_select["invitation_nation_no"];
        $invitation_address = $registration_sql_select["invitation_address"];
        $invitation_passport = $registration_sql_select["invitation_passport"];
        $invitation_date_of_birth = $registration_sql_select["invitation_date_of_birth"];
        $invitation_date_of_issue = $registration_sql_select["invitation_date_of_issue"];
        $invitation_date_of_expiry = $registration_sql_select["invitation_date_of_expiry"];
        $invitation_length_of_visit = $registration_sql_select["invitation_length_of_visit"];
    }

?>

    <style>
        input.others {
            display: none
        }

        ;
    </style>
    <!-- 변경 마크업 -->
    <section class="container submit_application register">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Registration</h2>
                    <ul class="clearfix">
                        <li>Home</li>
                        <li>Registration</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner bottom_short">
            <div class="input_area">
                <!-- content1 -->
                <div class="circle_title"><?= $locale("participant_tit") ?></div>
                <div class="table_wrap">
                    <table class="table detail_table">
                        <colgroup>
                            <col class="col_th" />
                            <col width="*" />
                        </colgroup>
                        <tbody>
                            <tr>
                                <th><?= $locale("id") ?></th>
                                <td id="email"><?= isset($user_info["email"]) ? $user_info["email"] : "" ?></td>
                            </tr>
                            <?php
                            if ($langage == "en") {
                            ?>
                                <tr>
                                    <th>Name(ENG)</th>
                                    <td id="name_en">
                                        <?= isset($user_info["first_name"]) ? $user_info["first_name"] : "" ?>
                                        <?= isset($user_info["last_name"]) ? $user_info["last_name"] : "" ?>
                                    </td>
                                    <input name="first_name" type="hidden" value="<?= isset($user_info["first_name"]) ? $user_info["first_name"] : "" ?>">
                                    <input name="last_name" type="hidden" value="<?= isset($user_info["last_name"]) ? $user_info["last_name"] : "" ?>">
                                </tr>
                            <?php
                            } else {
                            ?>
                                <tr>
                                    <th>Name(ENG)</th>
                                    <td id="name_en">
                                        <?= isset($user_info["first_name"]) ? $user_info["first_name"] : "" ?>
                                        <?= isset($user_info["last_name"]) ? $user_info["last_name"] : "" ?>
                                    </td>
                                    <input name="first_name" type="hidden" value="<?= isset($user_info["first_name"]) ? $user_info["first_name"] : "" ?>">
                                    <input name="last_name" type="hidden" value="<?= isset($user_info["last_name"]) ? $user_info["last_name"] : "" ?>">
                                </tr>
                                <tr>
                                    <th>Name(KOR)</th>
                                    <td id="name_kor"><?= isset($user_info["name_kor"]) ? $user_info["name_kor"] : ""; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <th><?= $locale("country") ?></th>
                                <td id="nation"><?= $nation; ?></td>
                                <input id="nation_no" type="hidden" value="<?= $nation_no; ?>">
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td id="category"><?= $category; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- content2 -->
                <form name="registration_form" onsubmit="return false" class="form_types">
                    <div class="table_wrap input_table">
                        <table>
                            <colgroup>
                                <col class="col_th" />
                                <col width="*" />
                            </colgroup>
                            <tbody>
                                <!--
							<tr>
								<th><span class="red_txt">*</span>Attendance type<?= ($langage == "kor") ? "<br>(참석 형태)" : ""; ?></th>
								<td>
									<div class="radio_wrap">
										<ul class="flex">
											<li>
												<input type="radio" class="radio required" id="online" checked name="attendance_type" value="1">
												<label for="online">Online Attend</label>
											</li>
											<li>
												<input type="radio" class="radio required" id="offline" name="attendance_type" value="0">
												<label for="offline">On-site Attend</label>
											</li>
											<li>
												<input type="radio" class="radio required" id="onoff" name="attendance_type" value="2">
												<label for="onoff"> Online + On-site</label>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							<tr>
								<th><span class="red_txt">*</span><?= $locale("registration_type") ?><?= ($langage == "kor") ? "<br>(참석 형태)" : ""; ?></th>
								<td>
									<div class="radio_wrap">
										<ul class="flex">
											<li>
												<input type="radio" class="radio required" id="r_type1" checked name="registration_type" value="0">
												<label for="r_type1">Participant</label>
											</li>
											<li>
												<input type="radio" class="radio required" id="r_type2" name="registration_type" value="1">
												<label for="r_type2"><?= $locale("registration_type_select2") ?></label>
											</li>
											<li>
												<input type="radio" class="radio required" id="r_type3" name="registration_type" value="2">
												<label for="r_type3">Oral Presenter</label>
											</li>
											<li>
												<input type="radio" class="radio required" id="r_type4" name="registration_type" value="3">
												<label for="r_type4">Poster Presenter</label>
											</li>
											<li>
												<input type="radio" class="radio required" id="r_type5" name="registration_type" value="4">
												<label for="r_type5">Faculty</label>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							-->
                            </tbody>
                        </table>
                    </div>
                </form>

                <?php
                if ($langage == "en") {

                ?>
                    <!-- content3 -->
                    <div class="circle_title">Registration Fee</div>
                    <div class="table_wrap">
                        <table class="table table_responsive left_border_table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Early Registration Fees</th>
                                </tr>
                            </thead>
                            <tbody class="centerT">
                                <tr>
                                    <td>Specialist, Professor</td>
                                    <td>
                                        <input type="radio" class="radio" id="c_type2-1" name="c_type1" value="<?= $r_during_yn == 'N' ? "250" : "300"; ?>" onclick="return(false);" <?= $usd_80_check; ?>>
                                        <label for="c_type2-1">USD <?= $r_during_yn == 'N' ? "250" : "300"; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Fellow, Resident, Researcher, Nurse, Military medical officer,<br />
                                        Nutritionist, Student, Pharmacist, Corporate member, Others
                                    </td>
                                    <td>
                                        <input type="radio" class="radio" id="c_type2-2" name="c_type1" value="<?= $r_during_yn == 'N' ? "100" : "150"; ?>" onclick="return(false);" <?= $usd_40_check; ?>>
                                        <label for="c_type2-2">USD <?= $r_during_yn == 'N' ? "100" : "150"; ?></label>
                                    </td>
                                </tr>
                                <!--
						<tr>
							<td>Dinner</td>
							<td>
								<input type="radio" class="radio" id="c_type3-1" name="c_type4" checked>
								<label for="c_type3-1">Yes</label>
								<input type="radio" class="radio" id="c_type3-2" name="c_type4">
								<label for="c_type3-2">No</label>
							</td>
						</tr>
						-->
                                <!-- <tr> -->
                                <!-- 	<td>Total</td> -->
                                <!-- 	<!-- <td><label class="total_price"><?= ($langage == "kor") ? "KRW 80,000" : "USD 80" ?></label></td> -->
                                <!-- 	<td><label class="total_price"></label></td> -->
                                <!-- </tr> -->

                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                ?>
                    <!-- content3 -->
                    <div class="circle_title">등록비</div>
                    <div class="table_wrap">
                        <table class="table table_responsive">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>KSoLA 회원</th>
                                    <th>비회원</th>
                                </tr>
                            </thead>
                            <tbody class="centerT">
                                <tr>
                                    <td>전문의, 교수</td>
                                    <td>
                                        <input type="radio" class="radio" id="c_type1-1" name="c_type1" value="<?= $r_during_yn == 'N' ? "80000" : "100000"; ?>" onclick="return(false);" <?= $krw_8_check; ?>>
                                        <label for="c_type1-1"><?= $r_during_yn == 'N' ? "80,000원" : "100,000원"; ?></label>
                                    </td>
                                    <td>
                                        <input type="radio" class="radio" id="c_type1-2" name="c_type1" value="<?= $r_during_yn == 'N' ? "100000" : "120000"; ?>" onclick="return(false);" <?= $krw_10_check; ?>>
                                        <label for="c_type1-2"><?= $r_during_yn == 'N' ? "100,000원" : "120,000원"; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        전임의, 전공의, 군의관/공보의,<br />
                                        연구원, 학생, 간호사,<br />
                                        영양사, 약사, 기업회원, 기타
                                    </td>
                                    <td colspan="2">
                                        <input type="radio" class="radio" id="c_type2" name="c_type1" value="<?= $r_during_yn == 'N' ? "50000" : "60000"; ?>" onclick="return(false);" <?= $krw_4_check; ?>>
                                        <label for="c_type2"><?= $r_during_yn == 'N' ? "50,000원" : "60,000원"; ?></label>
                                    </td>
                                </tr>
                                <!-- <tr> -->
                                <!-- 	<td>Welcome Reception</td> -->
                                <!-- 	<td colspan="2"> -->
                                <!-- 		<input type="radio" class="radio" id="c_type3-1" name="c_type3" value="Y"> -->
                                <!-- 		<label for="c_type3-1">Yes</label> -->
                                <!-- 		<input type="radio" class="radio" id="c_type3-2" name="c_type3" value="N" checked> -->
                                <!-- 		<label for="c_type3-2">No</label> -->
                                <!-- 	</td> -->
                                <!-- </tr> -->
                                <!-- <tr> -->
                                <!-- 	<td>Total</td> -->
                                <!-- 	<td colspan="2"><label for="c_type" class="total_price"></label></td> -->
                                <!-- 	<!-- <td colspan="2"><label for="c_type" class="total_price"><?= ($langage == "kor") ? "KRW 80,000" : "USD 80" ?></label></td> -->
                                <!-- </tr> -->
                            </tbody>
                        </table>
                    </div>
                <?php
                }
                ?>

                <!-- content4 -->
                <!--<form name="registration_form" onsubmit="return false" class="form_types">
				<div class="table_wrap input_table">
					<table>
						<colgroup>
							<col class="col_th"/>
							<col width="*"/>
						</colgroup>
						<tbody>
							<tr>
								<th>Promotion Code</th>
								<td>
									<div class="file_submission input_2btn promote_code">
										<input class="num_keyup" type="text">
										<!-- <button type="button" class="btn gray_btn">코드인증</button>
										<button type="button" class="btn dark_gray_btn">Apply</button>
									</div>
								</td>
							</tr>
							<tr>
								<th>Payment Methods</th>
								<td>
									<div class="radio_wrap">
										<ul class="flex">
											<li>
												<input checked type="radio" class="radio required" id="pay_type1" name="payment_methods" value="0">
												<label for="pay_type1"><?= ($langage == "en") ? "Credit Card" : "카드 결제"; ?></label>
											</li>
											<li>
												<input type="radio" class="radio required" id="pay_type2" name="payment_methods" value="1">
												<label for="pay_type2"><?= ($langage == "en") ? "Bank Transfer" : "계좌 이체"; ?></label>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form> -->

                <form name="registration_form" onsubmit="return false" class="form_types">
                    <div class="circle_title">Others</div>
                    <div class="table_wrap">
                        <table class="table table_responsive">
                            <thead>
                            </thead>
                            <tbody class="centerT">
                                <tr>
                                    <th>Welcome Reception</th>
                                    <th>17:10 ~, 15 Sep (Thu), 2022</th>
                                    <td>
                                        <input type="radio" class="radio required" id="others_type11" name="welcome_reception" value="Y" <?= $welcome_reception_yn != "N" ? "checked" : ""; ?>>
                                        <label for="others_type11">Yes</label>
                                        <?php
                                        if (empty($registration_idx)) {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type12" name="welcome_reception" value="N" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type12" name="welcome_reception" value="N" <?= $welcome_reception_yn != "Y" ? "checked" : ""; ?>>
                                        <?php
                                        }
                                        ?>
                                        <label for="others_type12">No</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Day 1- Luncheon Symposium</th>
                                    <th>12:00-12:50, 15 Sep (Thu), 2022</th>
                                    <td>
                                        <input type="radio" class="radio required" id="others_type1" name="day1_luncheon" value="Y" <?= $day1_luncheon_yn != "N" ? "checked" : ""; ?>>
                                        <label for="others_type1">Yes</label>
                                        <?php
                                        if (empty($registration_idx)) {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type2" name="day1_luncheon" value="N" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type2" name="day1_luncheon" value="N" <?= $day1_luncheon_yn != "Y" ? "checked" : ""; ?>>
                                        <?php
                                        }
                                        ?>
                                        <label for="others_type2">No</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Day 2- Breakfast Symposium</th>
                                    <th>08:00-09:00, 16 Sep (Fri), 2022</th>
                                    <td>
                                        <input type="radio" class="radio required" id="others_type3" name="day2_breakfast" value="Y" <?= $day2_breakfast_yn != "N" ? "checked" : ""; ?>>
                                        <label for="others_type3">Yes</label>
                                        <?php
                                        if (empty($registration_idx)) {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type4" name="day2_breakfast" value="N" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type4" name="day2_breakfast" value="N" <?= $day2_breakfast_yn != "Y" ? "checked" : ""; ?>>
                                        <?php
                                        }
                                        ?>
                                        <label for="others_type4">No</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Day 2- Luncheon Symposium</th>
                                    <th>12:00-12:50, 16 Sep (Fri), 2022</th>
                                    <td>
                                        <input type="radio" class="radio required" id="others_type5" name="day2_luncheon" value="Y" <?= $day2_luncheon_yn != "N" ? "checked" : ""; ?>>
                                        <label for="others_type5">Yes</label>
                                        <?php
                                        if (empty($registration_idx)) {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type6" name="day2_luncheon" value="N" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type6" name="day2_luncheon" value="N" <?= $day2_luncheon_yn != "Y" ? "checked" : ""; ?>>
                                        <?php
                                        }
                                        ?>
                                        <label for="others_type6">No</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Day 3- Breakfast Symposium</th>
                                    <th>08:00-09:00, 17 Sep (Sat), 2022</th>
                                    <td>
                                        <input type="radio" class="radio required" id="others_type7" name="day3_breakfast" value="Y" <?= $day3_breakfast_yn != "N" ? "checked" : ""; ?>>
                                        <label for="others_type7">Yes</label>
                                        <?php
                                        if (empty($registration_idx)) {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type8" name="day3_breakfast" value="N" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type8" name="day3_breakfast" value="N" <?= $day3_breakfast_yn != "Y" ? "checked" : ""; ?>>
                                        <?php
                                        }
                                        ?>
                                        <label for="others_type8">No</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Day 3- Luncheon Symposium</th>
                                    <th>12:05-12:55, 17 Sep (Sat), 2022</th>
                                    <td>
                                        <input type="radio" class="radio required" id="others_type9" name="day3_luncheon" value="Y" <?= $day3_luncheon_yn != "N" ? "checked" : ""; ?>>
                                        <label for="others_type9">Yes</label>
                                        <?php
                                        if (empty($registration_idx)) {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type10" name="day3_luncheon" value="N" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" class="radio required" id="others_type10" name="day3_luncheon" value="N" <?= $day3_luncheon_yn != "Y" ? "checked" : ""; ?>>
                                        <?php
                                        }
                                        ?>
                                        <label for="others_type10">No</label>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </form>

                <?php
                if ($nation_no == 25) {
                ?>
                    <form name="registration_form" onsubmit="return false" class="form_types">
                        <div class="circle_title">ISCP 2023 개최정보를 어떻게 알게 되셨나요?</div>
                        <div class="table_wrap">
                            <table class="table green_table file_table">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <input value="0" type="checkbox" class="checkbox check_age" id="register_path1" name="register_path" <?= in_array(0, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path1">한국지질동맥경화학회 홈페이지 또는 홍보메일</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="1" type="checkbox" class="checkbox check_age" id="register_path2" name="register_path" <?= in_array(1, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path2">유관학회 홍보메일 또는 게시판 광고</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="2" type="checkbox" class="checkbox check_age" id="register_path3" name="register_path" <?= in_array(2, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path3">초청연자/좌장으로 초청받음</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="3" type="checkbox" class="checkbox check_age" id="register_path4" name="register_path" <?= in_array(3, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path4">이전 ICoLA에 참석한 경험이 있음</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="4" type="checkbox" class="checkbox check_age" id="register_path5" name="register_path" <?= in_array(4, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path5">제약회사 소개</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="5" type="checkbox" class="checkbox check_age" id="register_path6" name="register_path" <?= in_array(5, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path6">지인을 통해</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="6" type="checkbox" class="checkbox check_age" id="register_path7" name="register_path" <?= in_array(6, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path7">인터넷 검색</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="7" type="checkbox" class="checkbox check_age" id="register_path8" name="register_path" <?= in_array(7, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path8">
                                                기타
                                                <input <?= in_array(7, $register_path_arr) ? "style='display:inline-block;'" : ""; ?> name="register_path_others" type="text" maxlength="60" class="others ko_keyup" value="<?= $register_path_others; ?>">
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php
                } else {
                ?>
                    <form name="registration_form" onsubmit="return false" class="form_types">
                        <div class="circle_title">How did you hear about the ISCP 2023?</div>
                        <div class="table_wrap">
                            <table class="table green_table file_table">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <input value="0" type="checkbox" class="checkbox check_age" id="register_path1" name="register_path" <?= in_array(0, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path1">Website or newletter of KSoLA</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="1" type="checkbox" class="checkbox check_age" id="register_path2" name="register_path" <?= in_array(1, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path2">Website or notice of related society</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="2" type="checkbox" class="checkbox check_age" id="register_path3" name="register_path" <?= in_array(2, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path3">Went to the last ICoLA</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="3" type="checkbox" class="checkbox check_age" id="register_path4" name="register_path" <?= in_array(3, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path4">Invitation for speaker or chair</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="4" type="checkbox" class="checkbox check_age" id="register_path5" name="register_path" <?= in_array(4, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path5">Friend / Colleague</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="5" type="checkbox" class="checkbox check_age" id="register_path6" name="register_path" <?= in_array(5, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path6">Medical corporate</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="6" type="checkbox" class="checkbox check_age" id="register_path7" name="register_path" <?= in_array(6, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path7">Internet banner ads or search</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input value="7" type="checkbox" class="checkbox check_age" id="register_path8" name="register_path" <?= in_array(7, $register_path_arr) ? "checked" : ""; ?>>
                                            <label for="register_path8">
                                                Others
                                                <input <?= in_array(7, $register_path_arr) ? "style='display:inline-block;'" : ""; ?> name="register_path_others" type="text" maxlength="60" class="others en_keyup" value="<?= $register_path_others; ?>">
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php
                }
                ?>

                <!-- content5 -->
                <?php
                if ($nation_no != 25) {
                ?>
                    <div>
                        <input type="checkbox" class="checkbox" id="invitation" name="invitation" <?= $invitation_yn == "Y" ? "checked" : ""; ?>>
                        <label for="invitation">I required an Invitation letter for VISA application</label>
                    </div>
                    <br>
                <?php
                }
                ?>

                <?php
                if ($invitation_yn == "Y") {
                ?>
                    <form class="table_wrap apply_invitaion show">
                    <?php
                } else {
                    ?>
                        <form class="table_wrap apply_invitaion">
                        <?php
                    }
                        ?>
                        <div class="pc_only">
                            <table class="table detail_table">
                                <colgroup>
                                    <col class="col_th" />
                                    <col width="*" />
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Name of Passport</th>
                                        <td class="name_td clearfix">
                                            <div class="max_normal">
                                                <!-- <input type="text" placeholder="First(Given) Name" disabled> -->
                                                <input class="en_keyup" name="invitation_first_name" type="text" placeholder="First Name" value="<?= $invitation_first_name; ?>">
                                            </div>
                                            <div class="max_normal">
                                                <!-- <input type="text"placeholder="Last(Family) Name" disabled> -->
                                                <input class="en_keyup" name="invitation_last_name" type="text" placeholder="Last Name" value="<?= $invitation_last_name; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td>
                                            <div class="max_normal">
                                                <select class="required" name="invitation_nation_no" id="invitation_nation_no">
                                                    <option value="" selected hidden>Choose</option>
                                                    <?php
                                                    foreach ($nation_list as $list) {
                                                        $nation = $language == "en" ? $list["nation_en"] : $list["nation_ko"];

                                                        if ($list["idx"] == $invitation_nation_no) {
                                                            echo "<option selected value='" . $list["idx"] . "'>" . $nation . "</option>";
                                                        } else {
                                                            echo "<option value='" . $list["idx"] . "'>" . $nation . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>
                                            <div class="max_normal">
                                                <input class="en_num_keyup" type="text" id="address_input" name="invitation_address" value="<?= $invitation_address; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Passport Number</th>
                                        <td>
                                            <div class="max_normal">
                                                <input class="en_num_keyup" type="text" placeholder="Passport Number" name="invitation_passport" value="<?= $invitation_passport; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>
                                            <div class="max_normal">
                                                <input type="text" placeholder="dd.mm.yyyy" id="datepicker" name="invitation_date_of_birth" value="<?= $invitation_date_of_birth; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date of Issue</th>
                                        <td>
                                            <div class="max_normal">
                                                <input type="text" placeholder="dd.mm.yyyy" id="datepicker" name="invitation_date_of_issue" value="<?= $invitation_date_of_issue; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date of Expiry</th>
                                        <td>
                                            <div class="max_normal">
                                                <input type="text" placeholder="dd.mm.yyyy" id="datepicker" name="invitation_date_of_expiry" value="<?= $invitation_date_of_expiry; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Length of Visit</th>
                                        <td>
                                            <div class="max_normal">
                                                <input class="en_num_keyup" type="text" placeholder="Length of Visit" name="invitation_length_of_visit" value="<?= $invitation_length_of_visit; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="checkbox" class="checkbox check_age" id="visa_check" name="visa_check">
                            <label class="red_txt" for="visa_check">Check here if your information appeared on the passport
                                matches it contained in your sign up information.</label>
                        </div>
                        <div class="mb_only">
                            <ul class="sign_list">
                                <li>
                                    <p class="label">Name of Passport</p>
                                    <div class="half_form clearfix">
                                        <input class="en_keyup" name="mo_invitation_first_name" type="text" placeholder="First Name" value="<?= $invitation_first_name; ?>" />
                                        <input class="en_keyup" name="mo_invitation_last_name" type="text" placeholder="Last Name" value="<?= $invitation_last_name; ?>" />
                                    </div>
                                </li>
                                <li>
                                    <p class="label">Country</p>
                                    <div>
                                        <select class="required" name="mo_invitation_nation_no" id="mo_invitation_nation_no">
                                            <option value="" selected hidden>Choose</option>
                                            <?php
                                            foreach ($nation_list as $list) {
                                                $nation = $language == "en" ? $list["nation_en"] : $list["nation_ko"];
                                                if ($list["idx"] == $invitation_nation_no) {
                                                    echo "<option selected value='" . $list["idx"] . "'>" . $nation . "</option>";
                                                } else {
                                                    echo "<option value='" . $list["idx"] . "'>" . $nation . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <p class="label">Address</p>
                                    <div>
                                        <input name="mo_invitation_address" class="en_keyup" type="text" id="address_input" placeholder="Please enter a default address." value="<?= $invitation_address; ?>">
                                    </div>
                                </li>
                                <li>
                                    <p class="label">Passport Number</p>
                                    <div><input name="mo_invitation_passport" class="num_keyup" type="text" placeholder="Passport Number" value="<?= $invitation_passport; ?>" /></div>
                                </li>
                                <li>
                                    <p class="label">Date of Birth</p>
                                    <div><input name="mo_invitation_date_of_birth" type="text" placeholder="dd.mm.yyyy" id="datepicker" value="<?= $invitation_date_of_birth; ?>" /></div>
                                </li>
                                <li>
                                    <p class="label">Date of Issue</p>
                                    <div><input name="mo_invitation_date_of_issue" type="text" placeholder="dd.mm.yyyy" id="datepicker" value="<?= $invitation_date_of_issue; ?>" /></div>
                                </li>
                                <li>
                                    <p class="label">Date of Expiry</p>
                                    <div><input name="mo_invitation_date_of_expiry" type="text" placeholder="dd.mm.yyyy" id="datepicker" value="<?= $invitation_date_of_expiry; ?>" /></div>
                                </li>
                                <li>
                                    <p class="label">Length of Visit</p>
                                    <div><input name="mo_invitation_length_of_visit" class="en_num_keyup" type="text" value="<?= $invitation_length_of_visit; ?>" /></div>
                                </li>
                            </ul>
                            <input type="checkbox" class="checkbox check_age" id="mo_visa_check" name="visa_check">
                            <label class="red_txt" for="mo_visa_check">Check here if your information appeared on the
                                passport matches it contained in your sign up information.</label>
                            <input type="hidden" name="registration_idx" value="<?= $registration_idx; ?>">
                        </div>
                        </form>
            </div>
            <div class="btn_wrap pager_btn_wrap">
                <!-- <button type="button" class="btn green_btn" onClick="javascript:location.href='./registration2.php'">Register</button> -->
                <button type="button" class="btn green_btn">Next</button>
            </div>
        </div>
        <p class="pc_only"></p>

    </section>
    <!-- 변경 마크업 : end -->

    <script src="./js/script/client/registration.js?v=0.2"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on("keyup", ".en_keyup", function(key) {
                var pattern_eng = /[^a-zA-Z\s]/gi;
                var _this = $(this);
                if (key.keyCode != 8) {
                    var first_name = _this.val().replace(pattern_eng, '');
                    _this.val(first_name);
                }
            });

            $(document).on("keyup", ".ko_keyup", function(key) {
                var pattern_eng = /[^ㄱ-ㅎ가-힣\s]/gi;
                var _this = $(this);
                if (key.keyCode != 8) {
                    var first_name = _this.val().replace(pattern_eng, '');
                    _this.val(first_name);
                }
            });

            $(document).on("keyup", ".num_keyup", function(key) {
                var pattern_eng = /[^0-9]/gi;
                var _this = $(this);
                if (key.keyCode != 8) {
                    var first_name = _this.val().replace(pattern_eng, '');
                    _this.val(first_name);
                }
            });
            $(document).on("keyup", ".en_num_keyup", function(key) {
                var pattern_eng = /[^0-9||a-zA-Z\s]/gi;
                var _this = $(this);
                if (key.keyCode != 8) {
                    var first_name = _this.val().replace(pattern_eng, '');
                    _this.val(first_name);
                }
            });

            //생년월일유효성
            $(document).on('change keyup', "#datepicker", function(key) {
                console.log("aa");
                var _this = $(this);
                if (key.keyCode != 8) {
                    var date_of_birth = _this.val().replace(/[^0-9]/gi, '');
                    if (date_of_birth.length > 9) {
                        date_of_birth = date_of_birth.substr(0, 2) + "-" + date_of_birth.substr(2, 2) + "-" +
                            date_of_birth.substr(4, 4);
                    } else if (date_of_birth.length > 4) {
                        date_of_birth = date_of_birth.substr(0, 2) + "-" + date_of_birth.substr(2, 2) + "-" +
                            date_of_birth.substr(4, 4);
                    } else if (date_of_birth.length > 2) {
                        date_of_birth = date_of_birth.substr(0, 2) + "-" + date_of_birth.substr(2, 2);
                    }
                    _this.val(date_of_birth);
                }
            });

        });


        $("input[name=visa_check]").change(function() {

            var checked = $(this).is(":checked");

            var visa_nation_no = "<?= $visa_nation_no; ?>";

            var first_name = "<?= $first_name; ?>";
            var last_name = "<?= $last_name; ?>";
            var date_of_birth = "<?= $date_of_birth; ?>";

            if (checked == true) {
                $("input[name=invitation_first_name]").val(first_name);
                $("input[name=invitation_last_name]").val(last_name);
                $("select[name=invitation_nation_no]").val(visa_nation_no).prop("selected", true);
                $("input[name=invitation_date_of_birth]").val(date_of_birth);
                $("input[name=mo_invitation_first_name]").val(first_name);
                $("input[name=mo_invitation_last_name]").val(last_name);
                $("select[name=mo_invitation_nation_no]").val(visa_nation_no).prop("selected", true);
                $("input[name=mo_invitation_date_of_birth]").val(date_of_birth);

            } else {
                $("input[name=invitation_first_name]").val("");
                $("input[name=invitation_last_name]").val("");
                $("select[name=invitation_nation_no]").val("").prop("selected", true);
                $("input[name=invitation_date_of_birth]").val("");
                $("input[name=mo_invitation_first_name]").val("");
                $("input[name=mo_invitation_last_name]").val("");
                $("select[name=mo_invitation_nation_no]").val("").prop("selected", true);
                $("input[name=mo_invitation_date_of_birth]").val("");

            }
        });


        // VISA application form toggle
        $("input[type='checkbox']#invitation").click(function() {
            if ($(this).is(":checked")) {
                $(".apply_invitaion").addClass("show");
            } else {
                $(".apply_invitaion").removeClass("show");
            }
        });


        $("input[type='checkbox']#register_path8").change(function() {
            if ($(this).is(":checked")) {
                $(".others").show();
            } else {
                $(".others").hide();
            }
        });

        //window.onload = function(){
        //	document.getElementById("address_kakao").addEventListener("click", function(){
        //		//카카오 지도 발생
        //		new daum.Postcode({
        //			oncomplete: function(data) { //선택시 입력값 세팅
        //				document.getElementById("address_input").value = data.address; // 주소 넣기
        //				document.getElementById("address_detail").focus(); //상세입력 포커싱
        //			}
        //		}).open();
        //	});
        //}
        //$(document).ready(function(){
        //	var lanage = "<?= $langage; ?>";

        //	//var money = AddComma($("input[name=c_type1]:checked").val());
        //	//if(lanage == "kor") {
        //	//	$(".total_price").text("KRW "+money);
        //	//} else {
        //	//	$(".total_price").text("USD "+money);
        //	//}
        //});

        //$(document).on("change", "input[name=c_type1]", function(){
        //	
        //	var lanage = "<?= $langage; ?>";

        //	var money = AddComma($("input[name=c_type1]:checked").val());
        //	if(lanage == "kor") {
        //		$(".total_price").text(money+"원");
        //	} else {
        //		$(".total_price").text("USD "+money);
        //	}
        //	
        //});



        //가격 , 찍기
        function AddComma(num) {
            var regexp = /\B(?=(\d{3})+(?!\d))/g;
            return num.toString().replace(regexp, ',');
        }
    </script>

<?php
}

include_once('./include/footer.php');
?>