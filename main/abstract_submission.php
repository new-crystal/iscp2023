<?php
include_once('./include/head.php');
include_once('./include/header.php');
include_once('./include/submission_data.php');

//이전 눌렀을 때 값 유지되고 다른 페이지에서 오면 초기화한다.
/*if($_SESSION["abstract_flag"] != "true") {
		$_SESSION["abstract"] = "";
	}
	$_SESSION["abstract_flag"] = "";*/

$submission_idx = $_GET["idx"];

// 등록 가능한 기간인지
$sql_during =	"SELECT
						IF(DATE(NOW()) BETWEEN '2022-08-18 17:00:00' AND '2023-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];


if ($during_yn !== "Y" && empty($submission_idx)) {
	// 행사 기간이 아닐 때
?>
<section class="container submit_application">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Online Submission</h2>
                <!-- <ul>
						<li>Home</li>
						<li>Call for Abstracts</li>
						<li>Abstract Submission</li>
						<li>Online Submission</li>
					</ul> -->
                <div class="color-bar"></div>
            </div>
        </div>
    </div>
    <div class="inner">
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./submission_guideline.php">
                    <!--<?= $locale("abstract_menu1") ?>-->Abstract Submission<br>Guideline
                </a></li>
            <li class="on"><a href="./abstract_submission.php">
                    <!--<?= $locale("abstract_menu2") ?>-->Online Submission
                </a></li>
            <!--<li><a href="./award.php"><!--<?= $locale("abstract_menu3") ?>Awards & Grants</a></li>-->
        </ul>
        <section class="coming">
            <div class="container">
                <div class="sub_banner">
                    <h5>Abstract Submission<br>has been closed</h5>
                </div>
            </div>
        </section>
    </div>
</section>
<?php
} else {

	//로그인 유무 확인 
	if (empty($_SESSION["USER"])) {
		echo "<script>alert(locale(language.value)('need_login')); location.href=PATH+'login.php';</script>";
		exit;
	}

	// country
	$nation_query = "SELECT
							*
						FROM nation
						ORDER BY 
						idx = 25 DESC, nation_en ASC";
	$nation_list = get_data($nation_query);
	function get_nation_option_text($nation_list, $selected)
	{
		$nation_option_text = '<option value="" hidden>Choose</option>';
		foreach ($nation_list as $nt) {
			$nation_option_text .= '<option value="' . $nt['idx'] . '" ' . ($nt['idx'] == $selected ? 'selected' : '') . '>' . $nt['nation_en'] . '</option>';
		}
		return $nation_option_text;
	}

	// affiliations
	$af_query = "
			SELECT
				rsaf.idx, rsaf.`order`, rsaf.affiliation, rsaf.department, rsaf.department_detail, rsaf.nation_no
			FROM request_submission_affiliation AS rsaf
			WHERE rsaf.is_deleted = 'N'
			AND rsaf.submission_idx = '" . $submission_idx . "'
			AND rsaf.register = '" . $_SESSION["USER"]["idx"] . "'
			ORDER BY rsaf.`order`
		";
	$af_list = get_data($af_query);

	// authors
	$au_query = "
			SELECT
				rsau.idx, rsau.`order`, rsau.same_signup_yn, rsau.presenting_yn, rsau.corresponding_yn, rsau.first_name, rsau.last_name, rsau.name_kor, rsau.affiliation_kor, email, affiliation_selected, mobile
			FROM request_submission_author AS rsau
			WHERE rsau.is_deleted = 'N'
			AND rsau.submission_idx = '" . $submission_idx . "'
			AND rsau.register = '" . $_SESSION["USER"]["idx"] . "'
			ORDER BY rsau.`order`
		";
	$au_list = get_data($au_query);

	// author - affiliation/department select option
	function get_affiliation_option_text($af_count, $selected)
	{
		$affiliation_option_text = '<option value="">select</option>';
		for ($i = 1; $i <= $af_count; $i++) {
			$affiliation_option_text .= '<option ' . ($i == $selected ? 'selected' : '') . '>' . $i . '</option>';
		}
		return $affiliation_option_text;
	}

	//초록 유효성 확인
	if (isset($_GET['idx']) && (!$af_list || !$au_list)) {
		echo "<script>alert('Invalid abstract data.'); history.go(-1);</script>";
		exit;
	}

	// 국가번호
	if ($member["phone"]) {
		$_arr_phone = explode("-", $member["phone"]);
		$nation_tel = $_arr_phone[0];
		$phone = implode("-", array_splice($_arr_phone, 1));
	}
?>

<!----------------------- 퍼블리싱 구분선 ----------------------->

<section class="container submit_application">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Online Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Abstract Submission</li>
                    <li>Online Submission</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner">
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./submission_guideline.php">
                    <!--<?= $locale("abstract_menu1") ?>-->Abstract Submission<br>Guideline
                </a></li>
            <li class="on"><a href="./abstract_submission.php">
                    <!--<?= $locale("abstract_menu2") ?>-->Online Submission
                </a></li>
            <!--<li><a href="./award.php"><!--<?= $locale("abstract_menu3") ?>Awards & Grants</a></li>-->
        </ul>
        <div class="section section1">

            <!-- 제목 시작 -->
            <div class="steps_area">
                <ul class="clearfix">
                    <li class="past">
                        <p>STEP 01</p>
                        <p class="sm_txt"><?= $locale("abstract_submit_tit1") ?></p>
                    </li>
                    <li>
                        <p>STEP 02</p>
                        <p class="sm_txt"><?= $locale("abstract_submit_tit2") ?></p>
                    </li>
                    <li>
                        <p>STEP 03</p>
                        <p class="sm_txt"><?= $locale("submit_completed_tit") ?></p>
                    </li>
                </ul>
            </div>
            <!-- //제목 끝 -->

            <div class="input_area">
                <!-- 소속 시작 -->
                <form name="affiliations_forms" class="abstract_form affiliations_forms">

                    <div class="circle_title">Affiliations
                        <button type="button" class="btn green_btn floatR af_add">Add</button>
                    </div>
                    <p>Please fill out affiliations of all authors.</p>
                    <p class="red_txt">* Fields with(*) must be filled out.</p>

                    <!-- 소속 요소 시작 -->
                    <?php
						if (count($af_list) > 0) {
							foreach ($af_list as $af) {
						?>
                    <div class="x_scroll af" data-order="<?= $af['order'] ?>">
                        <table class="table green_table">
                            <tbody>
                                <tr>
                                    <th rowspan="3">Affiliation #<span name="order"><?= $af['order'] ?></span>
                                        <button type="button" class="mini_btn green_btn af_del">Delete</button>
                                    </th>

                                    <th class="border_left">Department <span class="red_txt">*</span></th>
                                    <td class="half">
                                        <select name="department"
                                            id=""><?= get_department_option_text($department_list, $af['department']) ?></select>
                                        <input type="text" name="department_other" class="en_num_keyup" maxlength="255"
                                            value="<?= $af['department_detail'] ?>"
                                            <?= ($af['department'] == 16) ? "" : "disabled" ?>>
                                    </td>

                                </tr>
                                <tr>
                                    <th class="border_left">Affiliation <span class="red_txt">*</span></th>
                                    <td><input type="text" name="affiliation" class="" maxlength="255"
                                            value="<?= $af['affiliation'] ?>"></td>
                                </tr>
                                <tr>
                                    <th class="border_left">Country <span class="red_txt">*</span></th>
                                    <td>
                                        <select class="required"
                                            name="country"><?= get_nation_option_text($nation_list, $af['nation_no']) ?></select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
							}
						}
						?>
                    <!-- <div class="x_scroll af" data-num="1" data-idx="">
						<table class="table green_table">
							<tbody>
								<tr>
									<th rowspan="3">
										Affiliation #<span name="num">1</span>
										<button type="button" class="mini_btn green_btn afs_del">Delete</button>
									</th>
									<th class="border_left">Affiliation <span class="red_txt">*</span></th>
									<td><input type="text"></td>
								</tr>
								<tr>
									<th class="border_left">Department <span class="red_txt">*</span></th>
									<td class="half">
										<select name="" id="">
											<option value="">Department CHICE</option>
										</select>
										<input type="text">
									</td>
								</tr>
								<tr>
									<th class="border_left">Country <span class="red_txt">*</span></th>
									<td>
										<select class="required" name="nation_no"> 
											<option value="" selected hidden>Choose</option>
											<?php
											foreach ($nation_list as $list) {
												$nation = $language == "en" ? $list["nation_en"] : $list["nation_ko"];
												$selected = $nation_no == $list["idx"] ? "selected" : "";
												echo "<option value='" . $list["idx"] . "'" . $selected . ">" . $nation . "</option>";
											}
											?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</div> -->
                    <!-- //소속 요소 끝 -->
                </form>
                <!-- //소속 끝 -->

                <!-- 저자 시작 -->
                <form name="authors_forms" class="abstract_form authors_forms">

                    <div class="circle_title">Authors Information
                        <button type="button" class="btn green_btn floatR au_add">Add</button>
                    </div>
                    <p class="red_txt">* Fields with(*) must be filled out.</p>

                    <!-- 저자 요소 시작 -->
                    <?php
						if (count($au_list) > 0) {
							$token = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
							foreach ($au_list as $au) {
								$key = '';
								for ($i = 0; $i < 8; $i++) {
									$key .= $token[mt_rand(0, strlen($token) - 1)];
								}

								$same_signup_flag = $au['same_signup_yn'] == 'Y';
								$presenting_flag = $au['presenting_yn'] == 'Y';
								$corresponding_flag = $au['corresponding_yn'] == 'Y';

								if ($au["mobile"]) {
									$_arr_phone = explode("-", $au["mobile"]);
									$au["nation_tel"] = $_arr_phone[0];
									$au["mobile"] = implode("-", array_splice($_arr_phone, 1));
								}
						?>
                    <div class="x_scroll au" data-order="<?= $au['order'] ?>" data-key="<?= $key ?>">
                        <table class="table green_table step1">
                            <tbody>
                                <tr>
                                    <th rowspan="5">Authors #<span name="order"><?= $au['order'] ?></span>
                                        <div class="btn3_box">
                                            <button type="button" class="green_btn au_up">▲</button>
                                            <button type="button" class="green_btn au_down">▼</button>
                                            <button type="button" class="green_btn au_del">Ｘ</button>
                                        </div>
                                    </th>
                                    <th class="border_left radios" colspan="4">
                                        <input type="radio" class="radio" id="ssy<?= $key ?>" name="same_signup_yn"
                                            value="<?= $key ?>" <?= $same_signup_flag ? "checked" : "" ?>>
                                        <label for="ssy<?= $key ?>">Same as sign-up information<span
                                                class="red_txt">*</span></label>
                                        <input type="radio" class="radio" id="py<?= $key ?>" name="presenting_yn"
                                            value="<?= $key ?>" <?= $presenting_flag ? "checked" : "" ?>>
                                        <label for="py<?= $key ?>">Presenting author<span
                                                class="red_txt">*</span></label>
                                        <input type="radio" class="radio" id="cy<?= $key ?>" name="corresponding_yn"
                                            value="<?= $key ?>" <?= $corresponding_flag ? "checked" : "" ?>>
                                        <label for="cy<?= $key ?>">Corresponding author<span
                                                class="red_txt">*</span></label>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="border_left">First name <span class="red_txt">*</span></th>
                                    <td><input type="text" name="name_en_first" class="en_name_keyup" maxlength="60"
                                            value="<?= $au['first_name'] ?>"></td>
                                    <th class="border_left">Last name <span class="red_txt">*</span></th>
                                    <td><input type="text" name="name_en_last" class="en_name_keyup" maxlength="60"
                                            value="<?= $au['last_name'] ?>"></td>
                                </tr>
                                <!-- <tr>
									<th class="border_left">성명(국문)</th>
									<td><input type="text" name="name_ko" class="ko_keyup" maxlength="60" value="<?= $au['name_kor'] ?>"></td>
									<th class="border_left">소속(국문)</th>
									<td><input type="text" name="affiliation_ko" class="ko_num_keyup" maxlength="60" value="<?= $au['affiliation_kor'] ?>"></td>
								</tr> -->
                                <tr>
                                    <th class="border_left">E-mail <span class="red_txt">*</span></th>
                                    <td><input type="text" name="email" class="email" maxlength="60"
                                            value="<?= $au['email'] ?>"></td>
                                    <th class="border_left">Affiliation/</br />Department <span class="red_txt">*</span>
                                    </th>
                                    <td class="sel_3">
                                        <?php
													$selected_array = explode("|", $au['affiliation_selected']);
													foreach ($selected_array as $selected) {
													?>
                                        <select name="" id=""
                                            class="au_affiliation"><?= get_affiliation_option_text(count($af_list), $selected) ?></select>
                                        <?php
													}
													?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border_left">Phone Number <span class="red_txt"
                                            name="mobile_required"><?= ($presenting_flag || $corresponding_flag) ? "*" : "" ?></span>
                                    </th>
                                    <td colspan="3" class="phone_2">
                                        <input type="text" name="nation_tel" class="num_keyup" maxlength="5"
                                            value="<?= $au["nation_tel"] ?>" placeholder="82">
                                        <input type="text" name="mobile" class="num_keyup" maxlength="60"
                                            value="<?= $au['mobile'] ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
							}
						}
						?>
                    <!-- <div class="x_scroll au">
						<table class="table green_table step1">
							<tbody>
								<tr>
									<th rowspan="5">
										Authors #1
										<div class="btn3_box">
											<button type="button" class="green_btn">▲</button>
											<button type="button" class="green_btn">▼</button>
											<button type="button" class="green_btn">Ｘ</button>
										</div>
									</th>
									<th class="border_left" colspan="4">
										<input type="checkbox" class="radio" id="chk1">
										<label for="chk1">
											Same as sign-up information
											<span class="red_txt">*</span>
										</label>
										<input type="checkbox" class="radio" id="chk2">
										<label for="chk2">
											presenting author
											<span class="red_txt">*</span>
										</label>
										<input type="checkbox" class="radio" id="chk3">
										<label for="chk3">
											Corresponding author
											<span class="red_txt">*</span>
										</label>
									</th>
								</tr>
								<tr>
									<th class="border_left">First name <span class="red_txt">*</span></th>
									<td><input type="text"></td>
									<th class="border_left">Last name <span class="red_txt">*</span></th>
									<td><input type="text"></td>
								</tr>
								<tr>
									<th class="border_left">성명(국문)</th>
									<td><input type="text"></td>
									<th class="border_left">소속(국문)</th>
									<td><input type="text"></td>
								</tr>
								<tr>
									<th class="border_left">E-mail <span class="red_txt">*</span></th>
									<td><input type="text"></td>
									<th class="border_left">Affiliation/</br/>Department <span class="red_txt">*</span></th>
									<td class="sel_3">
										<select name="" id="" class="au_affiliation">
											<option value="">3</option>
										</select>
										<select name="" id="" class="au_affiliation">
											<option value="">3</option>
										</select>
										<select name="" id="" class="au_affiliation">
											<option value="">3</option>
										</select>
									</td>
								</tr>
								<tr>
									<th class="border_left">Mobile <span class="red_txt">*</span></th>
									<td colspan="3"><input type="text"></td>
								</tr>
							</tbody>
						</table>
					</div> -->
                    <!-- //저자 요소 끝 -->
                </form>
                <!-- //저자 끝 -->

                <div class="pager_btn_wrap">
                    <!-- <button type="button" class="btn submit is_submit" onclick="javascript:window.location.href='./abstract_submission2.php';"><?= $locale("next_btn") ?></button> -->
                    <button type="button" class="btn green_btn submit_btn">Save &amp; Next</button>
                </div>
            </div>
        </div>
        <!--//section1-->
    </div>
</section>
<!----------------------- 퍼블리싱 구분선 ----------------------->

<script>
const email_regex = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

const submission_idx = '<?= $submission_idx ?>';

const member_name_first = '<?= $member["first_name"] ?>';
const member_name_last = '<?= $member["last_name"] ?>';
const member_name_kor = '<?= $member["name_kor"] ?>';
const member_affiliation_kor = '<?= $member["affiliation_kor"] ?>';
const member_email = '<?= $member["email"] ?>';
const member_nation_tel = '<?= $nation_tel ?>';
const member_mobile = '<?= $phone ?>';

var au_same;
$(document).ready(function() {
    /*$(document).on("click", ".circle_title .btn", function(){
    	var clone = $(this).parents(".abstract_form").children(".x_scroll:last-of-type()").clone();
    	$(this).parents(".abstract_form").append(clone)
    });*/

    // 처음 생성하는 경우 1개 생성
    if (get_affiliation_count() <= 0) {
        make_affiliation(1);
    }
    if (get_author_count() <= 0) {
        make_author(1);
        $("div.au input[type=radio]").prop("checked", true);
        $('div.au span[name=mobile_required]').text("*");
        $("div.au input[name=name_en_first]").val(member_name_first);
        $("div.au input[name=name_en_last]").val(member_name_last);
        $("div.au input[name=name_ko]").val(member_name_kor);
        $("div.au input[name=affiliation_ko]").val(member_affiliation_kor);
        $("div.au input[name=email]").val(member_email);
        $("div.au input[name=nation_tel]").val(member_nation_tel);
        $("div.au input[name=mobile]").val(member_mobile);
    }

    au_same = $('input.radio[name=same_signup_yn]:checked').parents('div.au');
});

//affiliations insert
$(".af_add").on("click", function() {
    var current_count = get_affiliation_count();
    var order = current_count + 1;

    if (order <= 20) {
        make_affiliation(order);
    } else {
        // 20개까지만 가능
        alert("Up to 20 can be added.");
    }
});

//affiliations delete
$(document).on("click", ".af_del", function() {
    var current_count = get_affiliation_count();
    if (current_count <= 1) {
        // 1개 이상 필수
        alert("At least 1 can not be deleted.");

    } else if (confirm("Are you sure you want to remove?")) {
        var af = $(this).parents("div.af");
        af.remove();
        set_affiliation_order();

    }
});

// department disabled 예외처리
$(document).on("change", "select[name=department]", function() {
    var _this = $(this);

    var val = _this.children("option:selected").val();
    var select_other_flag = (val == 16); // Other professional

    _this.siblings("input[name=department_other]").val("").prop("disabled", !select_other_flag);
});

//get count
function get_affiliation_count() {
    var current_count = $("div.af").length;
    return current_count;
}

//set data-order
function set_affiliation_order() {
    var temp, temp_order;
    var affiliation_option_text = '<option value="">select</option>';
    $("div.af").each(function(index) {
        temp = $(this);
        0
        temp_order = index + 1;

        temp.data('order', temp_order);
        temp.children('table').children('tbody').children('tr').children('th').children('span[name=order]')
            .text(temp_order);

        affiliation_option_text += '<option>' + temp.data('order') + '</option>';
    });

    $("div.au select.au_affiliation").html(affiliation_option_text);
}

// make af
function make_affiliation(order) {
    var html = "";
    html += '<div class="x_scroll af" data-order="">';
    html += '<table class="table green_table">';
    html += '<tbody>';
    html += '<tr>';
    html += '<th rowspan="3">Affiliation #<span name="order"></span>';
    html += '<button type="button" class="mini_btn green_btn af_del">Delete</button>';
    html += '</th>';
    html += '<th class="border_left">Department <span class="red_txt">*</span></th>';
    html += '<td class="half">';
    html += '<select name="department" id=""><?= get_department_option_text($department_list, 0) ?></select>&nbsp;';
    html += '<input type="text" name="department_other" class="en_num_keyup" maxlength="255" disabled>';
    html += '</td>';
    html += '</tr>';
    html += '<tr>';
    html += '<th class="border_left">Affiliation <span class="red_txt">*</span></th>';
    html += '<td><input type="text" name="affiliation" class="" maxlength="255"></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<th class="border_left">Country <span class="red_txt">*</span></th>';
    html += '<td>';
    html += '<select class="required" name="country"><?= get_nation_option_text($nation_list, 0) ?></select>';
    html += '</td>';
    html += '</tr>';
    html += '</tbody>';
    html += '</table>';
    html += '</div>';

    $("form[name=affiliations_forms]").append(html);

    set_affiliation_order();
}



//authors insert
$(".au_add").on("click", function() {
    var current_count = get_author_count();
    var order = current_count + 1;

    if (order <= 20) {
        make_author(order);
    } else {
        // 20개까지만 가능
        alert("Up to 20 can be added.");
    }
});

//authors up
$(document).on("click", ".au_up", function() {
    var au = $(this).parents("div.au");
    var au_prev = au.prev();

    //console.log('au_prev', au_prev);
    if (!au_prev.hasClass("au")) {
        alert("First group.");
    } else {
        var html = au.detach();
        au_prev.before(html);
        set_author_order();
    }
});

//authors down
$(document).on("click", ".au_down", function() {
    var au = $(this).parents("div.au");
    var au_next = au.next();

    //console.log('au_next', au_next);
    if (!au_next.hasClass("au")) {
        alert("The last group.");
    } else {
        var html = au.detach();
        au_next.after(html);
        set_author_order();
    }
});

//authors delete
$(document).on("click", ".au_del", function() {
    var current_count = get_author_count();
    if (current_count <= 1) {
        // 1개 이상 필수
        alert("At least 1 can not be deleted.");

    } else if (confirm("Are you sure you want to remove?")) {
        var au = $(this).parents("div.au");
        au.remove();
        set_author_order();

    }
});

// Same as sign-up information 적용
$(document).on("change", "input.radio[name=same_signup_yn]", function() {
    au_same.find("input[name=name_en_first]").val("");
    au_same.find("input[name=name_en_last]").val("");
    au_same.find("input[name=name_ko]").val("");
    au_same.find("input[name=affiliation_ko]").val("");
    au_same.find("input[name=email]").val("");
    au_same.find("input[name=nation_tel]").val("");
    au_same.find("input[name=mobile]").val("");

    var au = $(this).parents('div.au');
    au.find("input[name=name_en_first]").val(member_name_first);
    au.find("input[name=name_en_last]").val(member_name_last);
    au.find("input[name=name_ko]").val(member_name_kor);
    au.find("input[name=affiliation_ko]").val(member_affiliation_kor);
    au.find("input[name=email]").val(member_email);
    au.find("input[name=nation_tel]").val(member_nation_tel);
    au.find("input[name=mobile]").val(member_mobile);

    au_same = au;
});

// authors radio 예외처리
$(document).on("change", "input.radio", function() {
    var temp, temp_au_tbody, py_chk, cy_chk, inner_text;
    $("div.au .radios").each(function(index) {
        temp = $(this);
        temp_au_tbody = temp.parents("tbody");

        py_chk = temp.children('input[name=presenting_yn]').prop('checked');
        cy_chk = temp.children('input[name=corresponding_yn]').prop('checked');

        inner_text = (py_chk || cy_chk) ? "*" : "";

        temp_au_tbody.children('tr').children('th').children('span[name=mobile_required]').text(
            inner_text);
    });
});

//get count
function get_author_count() {
    var current_count = $("div.au").length;
    return current_count;
}

//set data-order
function set_author_order() {
    var temp, temp_order;
    $("div.au").each(function(index) {
        temp = $(this);
        0
        temp_order = index + 1;

        temp.data('order', temp_order);
        temp.children('table').children('tbody').children('tr').children('th').children('span[name=order]')
            .text(temp_order);
    });
}

// make af
function make_author(order) {

    // radio 구분용 난수 생성
    var alphabet = "abcdefghijklmnopqrstuvwxyz";
    var num = "0123456789";
    var text1 = "";
    var text2 = "";
    for (var i = 0; i < 4; i++) {
        text1 += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
        text2 += num.charAt(Math.floor(Math.random() * num.length));
    }
    var key = (text1 + text2);

    // affiliation option
    var af_length = get_affiliation_count();
    var affiliation_option_text = '<option value="">select</option>';
    for (var i = 1; i <= af_length; i++) {
        affiliation_option_text += '<option>' + i + '</option>';
    }

    var html = "";
    html += '<div class="x_scroll au" data-order="" data-key="' + key + '">';
    html += '<table class="table green_table step1">';
    html += '<tbody>';
    html += '<tr>';
    html += '<th rowspan="5">Authors #<span name="order"></span>';
    html += '<div class="btn3_box">';
    html += '<button type="button" class="green_btn au_up">▲</button> ';
    html += '<button type="button" class="green_btn au_down">▼</button> ';
    html += '<button type="button" class="green_btn au_del">Ｘ</button>';
    html += '</div>';
    html += '</th>';
    html += '<th class="border_left radios" colspan="4">';
    html += '<input type="radio" class="radio" id="ssy' + key + '" name="same_signup_yn" value="' + key + '">';
    html += '<label for="ssy' + key + '">Same as sign-up information<span class="red_txt">*</span></label>';
    html += '<input type="radio" class="radio" id="py' + key + '" name="presenting_yn" value="' + key + '">';
    html += '<label for="py' + key + '">Presenting author<span class="red_txt">*</span></label>';
    html += '<input type="radio" class="radio" id="cy' + key + '" name="corresponding_yn" value="' + key + '">';
    html += '<label for="cy' + key + '">Corresponding author<span class="red_txt">*</span></label>';
    html += '</th>';
    html += '</tr>';
    html += '<tr>';
    html += '<th class="border_left">First name <span class="red_txt">*</span></th>';
    html += '<td><input type="text" name="name_en_first" class="en_name_keyup" maxlength="60"></td>';
    html += '<th class="border_left">Last name <span class="red_txt">*</span></th>';
    html += '<td><input type="text" name="name_en_last" class="en_name_keyup" maxlength="60"></td>';
    html += '</tr>';
    html += '<tr>';
    /*html +=					'<th class="border_left">성명(국문)</th>';
    html +=					'<td><input type="text" name="name_ko" class="ko_keyup" maxlength="60"></td>';
    html +=					'<th class="border_left">소속(국문)</th>';
    html +=					'<td><input type="text" name="affiliation_ko" class="ko_num_keyup" maxlength="60"></td>';
    html +=				'</tr>';*/
    html += '<tr>';
    html += '<th class="border_left">E-mail <span class="red_txt">*</span></th>';
    html += '<td><input type="text" name="email" class="email" maxlength="60"></td>';
    html += '<th class="border_left">Affiliation/</br/>Department <span class="red_txt">*</span></th>';
    html += '<td class="sel_3">';
    html += '<select name="" id="" class="au_affiliation">' + affiliation_option_text + '</select> ';
    html += '<select name="" id="" class="au_affiliation">' + affiliation_option_text + '</select> ';
    html += '<select name="" id="" class="au_affiliation">' + affiliation_option_text + '</select>';
    html += '</td>';
    html += '</tr>';
    html += '<tr>';
    html += '<th class="border_left">Phone Number <span class="red_txt" name="mobile_required"></span></th>';
    html += '<td colspan="3" class="phone_2">';
    html += '<input type="text" name="nation_tel" class="num_keyup" maxlength="5" placeholder="82"> ';
    html += '<input type="text" name="mobile" class="num_keyup" maxlength="60">';
    html += '</td>';
    html += '</tr>';
    html += '</tbody>';
    html += '</table>';
    html += '</div>';

    $("form[name=authors_forms]").append(html);

    set_author_order();
}



$(document).on("change", ".ko_keyup", function(key) {
    var pattern = /[^ㄱ-ㅎ가-힣\s]/gi;
    var _this = $(this);
    if (key.keyCode != 8) {
        var first_name = _this.val().replace(pattern, '');
        _this.val(first_name.trim());
    }
});
$(document).on("change", ".ko_num_keyup", function(key) {
    var pattern_eng = /[^0-9||ㄱ-ㅎ가-힣|| \s]/gi;
    var _this = $(this);
    if (key.keyCode != 8) {
        var first_name = _this.val().replace(pattern_eng, '');
        _this.val(first_name.trim());
    }
});

$(document).on("change", ".en_keyup", function(key) {
    var pattern = /[^a-zA-Z\s]/gi;
    set_pattern(pattern, $(this), key.keyCode);
});
$(document).on("change", ".en_num_keyup", function(key) {
    var pattern = /[^0-9||a-zA-Z||\s]/gi;
    set_pattern(pattern, $(this), key.keyCode);
});
$(document).on("change", ".num_keyup", function(key) {
    var pattern = /[^0-9-+]/gi;
    set_pattern(pattern, $(this), key.keyCode);
});

$(document).on("change", ".en_name_keyup", function(key) {
    var pattern = /[^a-zA-Z-\s]/gi;
    set_pattern(pattern, $(this), key.keyCode);
});
$(document).on("change", "[name=affiliation]", function(key) {
    var pattern = /[^0-9a-zA-Z,\s]/gi;
    set_pattern(pattern, $(this), key.keyCode);
});

function set_pattern(pattern, _this, key_code) {
    if (key_code != 8) {
        var val = _this.val().replace(pattern, '');
        _this.val(val.trim());
    }
}

/*$(document).on("change", ".email" ,function(){
	var email = $(this).val().trim();
	var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	
	if(email.match(regExp) != null) {
		$(this).val(email);
	} else {
		alert("Invalid email format.");
		$(this).val("").focus();
		return;
	}
});*/



// save
$('.submit_btn').click(function() {
    var temp;

    /* affiliations */
    var af_verify_flag = true;
    var af_array = new Array();
    var af_text = "";
    var af_temp_affiliation, af_temp_department, af_temp_department_other, af_temp_country;
    $('div.af').each(function(index) {
        temp = $(this);

        // affiliation
        af_temp_affiliation = temp.find('input[name=affiliation]');
        if (af_temp_affiliation.val() == "") {
            af_verify_flag = false;
            alert(make_save_alert_msg("Affiliation", index));
            af_temp_affiliation.focus();
            return false;
        }

        // department
        af_temp_department = temp.find('select[name=department] option:selected');
        if (af_temp_department.val() == "") {
            af_verify_flag = false;
            alert(make_save_alert_msg("Department", index));
            return false;
        }

        // department - other
        af_temp_department_other = temp.find('input[name=department_other]');
        if (af_temp_department.val() == "16" && af_temp_department_other.val() == "") {
            af_verify_flag = false;
            alert(make_save_alert_msg("Department", index));
            af_temp_department_other.focus();
            return false;
        }

        // country
        af_temp_country = temp.find('select[name=country] option:selected');
        if (af_temp_country.val() == "") {
            af_verify_flag = false;
            alert(make_save_alert_msg("Country", index));
            return false;
        }

        af_text = temp.data('order') + '@#' + af_temp_affiliation.val() + '@#' + af_temp_department
            .val() + '@#' + af_temp_department_other.val() + '@#' + af_temp_country.val();
        af_array.push(af_text);
    });

    if (!af_verify_flag) {
        return false;
    }
    /* //affiliations */

    /* authors */
    if ($('div.au input[name=same_signup_yn]:checked').length <= 0) {
        alert("Please select the same as Sign-up Information.");
        return false;

    } else if ($('div.au input[name=presenting_yn]:checked').length <= 0) {
        alert("Please select the Presenting.");
        return false;

    } else if ($('div.au input[name=corresponding_yn]:checked').length <= 0) {
        alert("Please select the Corresponding.");
        return false;
    }

    var au_verify_flag = true;
    var au_array = new Array();
    var au_text = "";
    var au_temp_same, au_temp_presenting, au_temp_corresponding, au_temp_name_first, au_temp_name_last,
        au_temp_name_ko, au_temp_affiliation_ko, au_temp_email, au_temp_affiliation_1, au_temp_affiliation_2,
        au_temp_affiliation_3, au_temp_mobile;
    $('div.au').each(function(index) {
        temp = $(this);

        // Presenting author
        au_temp_same = temp.find('input[name=same_signup_yn]');

        // Presenting author
        au_temp_presenting = temp.find('input[name=presenting_yn]');

        // Corresponding author
        au_temp_corresponding = temp.find('input[name=corresponding_yn]');

        // name - en - first
        au_temp_name_first = temp.find('input[name=name_en_first]');
        if (au_temp_name_first.val() == "") {
            au_verify_flag = false;
            alert(make_save_alert_msg("First Name", index));
            au_temp_name_first.focus();
            return false;
        }

        // name - en - last
        au_temp_name_last = temp.find('input[name=name_en_last]');
        if (au_temp_name_last.val() == "") {
            au_verify_flag = false;
            alert(make_save_alert_msg("Last Name", index));
            au_temp_name_last.focus();
            return false;
        }

        // name - ko
        au_temp_name_ko = temp.find('input[name=name_ko]');

        // affiliation - ko
        au_temp_affiliation_ko = temp.find('input[name=affiliation_ko]');

        // email
        au_temp_email = temp.find('input[name=email]');
        if (au_temp_email.val() == "") {
            au_verify_flag = false;
            alert(make_save_alert_msg("Email", index));
            au_temp_email.focus();
            return false;
        } else if (au_temp_email.val().match(email_regex) == null) {
            au_verify_flag = false;
            alert(ordinal_number_array[index] + " email is invalid");
            au_temp_email.val("").focus();
            return;
        }

        // affiliation - select
        au_temp_affiliation_1 = temp.find('select.au_affiliation').eq(0).children('option:selected');
        console.log('au_temp_affiliation_1', au_temp_affiliation_1.val());
        if (au_temp_affiliation_1.val() == "") {
            au_verify_flag = false;
            alert(make_save_alert_msg("Affiliation", index));
            return false;
        }
        au_temp_affiliation_2 = temp.find('select.au_affiliation').eq(1).children('option:selected');
        au_temp_affiliation_3 = temp.find('select.au_affiliation').eq(2).children('option:selected');

        // nation_tel
        au_temp_nation_tel = temp.find('input[name=nation_tel]');
        if ((au_temp_presenting.prop('checked') || au_temp_corresponding.prop('checked')) &&
            au_temp_nation_tel.val() == "") {
            au_verify_flag = false;
            alert(make_save_alert_msg("Country code", index));
            au_temp_nation_tel.focus();
            return false;
        }

        // mobile
        au_temp_mobile = temp.find('input[name=mobile]');
        if ((au_temp_presenting.prop('checked') || au_temp_corresponding.prop('checked')) &&
            au_temp_mobile.val() == "") {
            au_verify_flag = false;
            alert(make_save_alert_msg("Mobile", index));
            au_temp_mobile.focus();
            return false;
        }


        au_text = temp.data('order') + '@#' + (au_temp_same.prop('checked') ? "Y" : "N") + '@#' + (
                au_temp_presenting.prop('checked') ? "Y" : "N") + '@#' + (au_temp_corresponding.prop(
                'checked') ? "Y" : "N") + '@#' + au_temp_name_first.val() + '@#' + au_temp_name_last
            .val() + '@#' + au_temp_email.val() + '@#' + au_temp_affiliation_1.val() + '@#' +
            au_temp_affiliation_2.val() + '@#' + au_temp_affiliation_3.val() + '@#' + au_temp_nation_tel
            .val() + '-' + au_temp_mobile.val();
        au_array.push(au_text); // + '@#' + au_temp_name_ko.val() + '@#' + au_temp_affiliation_ko.val()
    });

    if (!au_verify_flag) {
        return false;
    }
    /* //authors */

    /* save */
    $.ajax({
        url: PATH + "ajax/client/ajax_submission2022.php",
        type: "POST",
        data: {
            flag: "step1",
            idx: submission_idx,
            afs: af_array.join('%^'),
            aus: au_array.join('%^')
        },
        dataType: "JSON",
        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                //alert(locale(language.value)("send_mail_success"));
                location.href = './abstract_submission2.php?idx=' + res.submission_idx
            }
            /* else if(res.code == 401) {
            					alert(locale(language.value)("not_exist_email"));
            					return false;
            				} else if(res.code == 400) {
            					alert(locale(language.value)("error_find_password"));
            					return false;
            				} else {
            					alert(locale(language.value)("reject_msg"));
            					return false;
            				}*/
        },
        complete: function() {
            $(".loading").hide();
            $("body").css("overflow-y", "auto");

            //alreadyProcess = false;
        }
    });
    /* //save */
});

// make alert
const ordinal_number_array = ['1st', '2nd', '3rd'];
for (var i = 4; i <= 20; i++) {
    ordinal_number_array.push((i + 'th'));
}

function make_save_alert_msg(column, index) {
    var msg = "Please enter the " + ordinal_number_array[index] + " " + column + ".";
    return msg;
}
</script>
<?php
}

include_once('./include/footer.php');
?>