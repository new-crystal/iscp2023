
<?php
include_once('./include/head.php');
include_once('./include/header.php');
include_once('./include/submission_data.php');
include_once('./plugin/editor/smarteditor2/editor.lib.php');

$sql_during =    "SELECT
						IF(DATE(NOW()) BETWEEN period_poster_start AND period_poster_end, 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//업데이트 시 abstract 인덱스
$submission_idx = $_GET["idx"];

if ($during_yn !== "Y" && empty($submission_idx)) {
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

    // 사전 등록이 된 유저인지 확인
    // 사전 등록 안 해도 제출 가능 하게 바뀌었음으로 주석처리
    //$registration_idx = check_registration($user_info["idx"]);
    //if(!$registration_idx) {
    //	echo "<script>alert(locale(language.value)('check_registration')); location.href=PATH+'registration_guidelines.php'</script>";
    //	exit;
    //}

    // detail
    $sql_detail = "
			SELECT
				preferred_presentation_type,
				topic, topic_detail,
				title,
				objectives, methods, results, conclusions, keywords,
				rs.image1_file AS image1_idx, fi_image1.original_name AS image1_original_name, rs.image1_caption,
				rs.image2_file AS image2_idx, fi_image2.original_name AS image2_original_name, rs.image2_caption,
				rs.image3_file AS image3_idx, fi_image3.original_name AS image3_original_name, rs.image3_caption,
				rs.image4_file AS image4_idx, fi_image4.original_name AS image4_original_name, rs.image4_caption,
				rs.image5_file AS image5_idx, fi_image5.original_name AS image5_original_name, rs.image5_caption,
				rs.similar_yn, rs.support_yn, rs.travel_grants_yn, rs.awards_yn, rs.investigator_grants_yn,
				rs.prove_age_file AS prove_age_idx, fi_prove_age.original_name AS prove_age_original_name
			FROM request_submission AS rs
			LEFT JOIN `file` AS fi_image1
				ON fi_image1.idx = rs.image1_file
			LEFT JOIN `file` AS fi_image2
				ON fi_image2.idx = rs.image2_file
			LEFT JOIN `file` AS fi_image3
				ON fi_image3.idx = rs.image3_file
			LEFT JOIN `file` AS fi_image4
				ON fi_image4.idx = rs.image4_file
			LEFT JOIN `file` AS fi_image5
				ON fi_image5.idx = rs.image5_file
			LEFT JOIN `file` AS fi_prove_age
				ON fi_prove_age.idx = rs.prove_age_file
			WHERE rs.is_deleted = 'N'
			AND rs.idx = '" . $submission_idx . "'
			AND rs.register = '" . $_SESSION["USER"]["idx"] . "'
		";
    $detail = sql_fetch($sql_detail);
    if (!$detail) {
        echo "<script>alert('Invalid abstract data.'); history.go(-1);</script>";
        exit;
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

    $editor_url = '/main/' . D9_PLUGIN_DIR . '/editor/smarteditor2';
    $config = "config_submission"; //"config";
    if ($use_mobile) {
        $config = "config_mobile";
    }
?>
<script src="<?= $editor_url ?>/js/service/HuskyEZCreator.js?ymd=220509"></script>
<script>
var g5_editor_url = "<?= $editor_url ?>",
    oEditors = [],
    ed_nonce = "<?= ft_nonce_create('smarteditor') ?>";
</script>
<script src="<?= $editor_url ?>/<?= $config ?>.js?ymd=220509"></script>

<!----------------------- 퍼블리싱 구분선 ----------------------->

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
            <div class="steps_area">
                <ul class="clearfix">
                    <li>
                        <p>STEP 01</p>
                        <p class="sm_txt"><?= $locale("abstract_submit_tit1") ?></p>
                    </li>
                    <li class="past">
                        <p>STEP 02</p>
                        <p class="sm_txt"><?= $locale("abstract_submit_tit2") ?></p>
                    </li>
                    <li>
                        <p>STEP 03</p>
                        <p class="sm_txt"><?= $locale("submit_completed_tit") ?></p>
                    </li>
                </ul>
            </div>
            <div class="input_area">
                <form name="abstract_form" class="abstract_form">
                    <div class="circle_title">Abstract</div>
                    <div class="text_box">
                        <p class="red_txt">• Submitter is responsible for typing errors.</p>
                        <p class="red_txt">• If you click the 'Save and Next' button, the abstract will be temporarily
                            saved.</p>
                        <p class="red_txt">• Temporarily saved contents can be modified & deleted on My page.</p>
                        <p class="red_txt">• Click the 'Submit' button at the final step to complete the submission.</p>
                        <p class="red_txt">• 'Abstract Submission No.' will be issued once you complete your submission.
                        </p>
                        <p class="red_txt" style="font-weight: 600; font-size:18px">• Please note: You can modify the
                            submitted abstract until the deadline.
                        </p>
                    </div>
                    <div class="x_scroll">
                        <table class="table green_table">
                            <colgroup>
                                <col class="green_col">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th class="leftT">Preferred Presentation<br />Type <span class="red_txt">*</span>
                                    </th>
                                    <td>
                                        <!-- <input type="radio" class="radio" id="preferred_presentation_type_0"
                                            name="preferred_presentation_type" value="0"
                                            <?= ($detail['preferred_presentation_type'] == "0" ? "checked" : "") ?>>
                                        <label for="preferred_presentation_type_0">Oral or Poster</label> -->
                                        <input checked type="radio" class="radio" id="preferred_presentation_type_1"
                                            name="preferred_presentation_type" value="1"
                                            <?= ($detail['preferred_presentation_type'] == "1" ? "checked" : "") ?>>
                                        <label for="preferred_presentation_type_1">Poster</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="leftT">Topic <span class="red_txt">*</span></th>
                                    <td class="half">
                                        <select name="topic1"
                                            id=""><?= get_topic1_option_text($topic1_list, $detail['topic']) ?></select>
                                        <!-- <select name="topic2"
                                            id=""><?= get_topic2_option_text($topic2_list, $detail['topic_detail'], $detail['topic']) ?></select> -->
                                    </td>
                                </tr>
                                <tr>
                                    <th class="leftT">Title <span class="red_txt">*</span></th>
                                    <td>
                                        <p class="rightT red_txt">Title is limited to 25 words. (All title words : <span
                                                class="red_txt" name="word_limit_title">0</span> / 25)</p>
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <? //=editor_html("title", htmlspecialchars_decode($detail['title'], ENT_QUOTES));
                                            ?>
                                        <textarea id="title" name="title" class="smarteditor2" maxlength="65536"
                                            style="width:100%;height:100px"><?= htmlspecialchars_decode($detail['title'], ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="leftT">Objectives <span class="red_txt">*</span></th>
                                    <td>
                                        <p class="rightT red_txt">Abstract shall not be longer than 300 words. (All
                                            abstract words <span class="red_txt" name="word_limit_contents">0</span> /
                                            300)</p>
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <? //=editor_html("objectives", htmlspecialchars_decode($detail['objectives'], ENT_QUOTES));
                                            ?>
                                        <textarea id="objectives" name="objectives" class="smarteditor2"
                                            maxlength="65536"
                                            style="width:100%;height:100px"><?= htmlspecialchars_decode($detail['objectives'], ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="leftT">Materials and Methods <span class="red_txt">*</span></th>
                                    <td>
                                        <p class="rightT red_txt">Abstract shall not be longer than 300 words. (All
                                            abstract words <span class="red_txt" name="word_limit_contents">0</span> /
                                            300)</p>
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <? //=editor_html("methods", htmlspecialchars_decode($detail['methods'], ENT_QUOTES));
                                            ?>
                                        <textarea id="methods" name="methods" class="smarteditor2" maxlength="65536"
                                            style="width:100%;height:100px"><?= htmlspecialchars_decode($detail['methods'], ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="leftT">Results <span class="red_txt">*</span></th>
                                    <td>
                                        <p class="rightT red_txt">Abstract shall not be longer than 300 words. (All
                                            abstract words <span class="red_txt" name="word_limit_contents">0</span> /
                                            300)</p>
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <? //=editor_html("results", htmlspecialchars_decode($detail['results'], ENT_QUOTES));
                                            ?>
                                        <textarea id="results" name="results" class="smarteditor2" maxlength="65536"
                                            style="width:100%;height:100px"><?= htmlspecialchars_decode($detail['results'], ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="leftT">Conclusions <span class="red_txt">*</span></th>
                                    <td>
                                        <p class="rightT red_txt">Abstract shall not be longer than 300 words. (All
                                            abstract words <span class="red_txt" name="word_limit_contents">0</span> /
                                            300)</p>
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <? //=editor_html("conclusions", htmlspecialchars_decode($detail['conclusions'], ENT_QUOTES));
                                            ?>
                                        <textarea id="conclusions" name="conclusions" class="smarteditor2"
                                            maxlength="65536"
                                            style="width:100%;height:100px"><?= htmlspecialchars_decode($detail['conclusions'], ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                                <tr style="display: none;">
                                    <th class="leftT">Keywords</th>
                                    <td>
                                        <!-- <p class="rightT red_txt">Abstract shall not be longer than 300 words. (All abstract words <span class="red_txt" name="word_limit_contents">0</span> / 300)</p> -->
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <? //=editor_html("keywords", htmlspecialchars_decode($detail['keywords'], ENT_QUOTES));
                                            ?>
                                        <textarea id="keywords" name="keywords" class="smarteditor2" maxlength="65536"
                                            style="width:100%;height:100px"><?= htmlspecialchars_decode($detail['keywords'], ENT_QUOTES) ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table_caption_green">
                        <p class="rightT devide_title">If you include a picture, it will count as 50 words and reduce
                            your word count.</p>
                        <p class="leftT red_txt"> - Please upload high resolution image with more than 300 dpi.</p>
                        <p class="leftT red_txt"> - Supported image formats are: jpeg, jpg, gif, bmp, png</p>
                    </div>
                    <div class="x_scroll">
                        <table class="table green_table file_table">
                            <tbody>
                                <?php
                                    for ($i = 1; $i <= 2; $i++) {
                                        $idx = $detail['image' . $i . '_idx'];
                                        $file_name = $detail['image' . $i . '_original_name'];
                                        $caption = $detail['image' . $i . '_caption'];
                                    ?>
                                <tr>
                                    <th class="leftT">Image <?= $i ?></th>
                                    <td>
                                        <div class="citation_box">
                                            <div class="file_input file_submission">
                                                <label class='label'
                                                    data-js-label><?= $file_name != "" ? $file_name : $locale("select_file") ?></label>
                                                <input type="file" name="abstract_file<?= $i ?>"
                                                    class="abstract_file check_word_limit"
                                                    accept=".jpeg, .jpg, .gif, .bmp, .png" data-idx="<?= $idx ?>">
                                                <span class="btn dark_gray_btn">File Find</span>
                                                <span class="btn dark_gray_btn delete_file">Delete</span>
                                            </div>
                                            <div>
                                                <input type="text" placeholder="Image <?= $i ?> caption"
                                                    name="abstract_file_caption<?= $i ?>" class="en_num_keyup"
                                                    value="<?= $caption ?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                    ?>
                                <tr style="display:none">
                                    <td colspan="2">
                                        <p>Have you submitted this abstract or an abstract of a similar topic at another
                                            conference?</p>
                                        <input type="radio" class="radio" name="similar_yn" id="similar_yn_y" value="Y"
                                            <?= $detail['similar_yn'] == "Y" ? "checked" : "" ?>>
                                        <label for="similar_yn_y">yes</label>
                                        <input checked type="radio" class="radio" name="similar_yn" id="similar_yn_n"
                                            value="N" <?= $detail['similar_yn'] == "N" ? "checked" : "" ?>>
                                        <label for="similar_yn_n">no</label>
                                    </td>
                                </tr>
                                <tr style="display:none">
                                    <td colspan="2">
                                        <p>This research is supported by the grant of Korean Society of Lipid and
                                            Atherosclerosis.</p>
                                        <input checkd type="radio" class="radio" name="support_yn" id="support_yn_y"
                                            value="Y" <?= $detail['support_yn'] == "Y" ? "checked" : "" ?>>
                                        <label for="support_yn_y">yes</label>
                                        <input type="radio" class="radio" name="support_yn" id="support_yn_n" value="N"
                                            <?= $detail['support_yn'] == "N" ? "checked" : "" ?>>
                                        <label for="support_yn_n">no</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php
                                            $travel_grants_y_flag = ($detail['travel_grants_yn'] == "Y");
                                            ?>
                                        <input type="checkbox" class="checkbox check_age" id="travel_grants_yn"
                                            name="travel_grants_yn" <?= $travel_grants_y_flag ? "checked" : "" ?>>
                                        <label for="travel_grants_yn">Apply for ISCP 2023 Travel Grants</label>
                                        <span class="eligibility_open pointer" style="transform:translateY(1px)">
                                            ⓘ Eligibility
                                            <div class="eligibility_pop">
                                                <div class="pop_bg"></div>
                                                <p class="balloon">※ Under 45 years old of age<br />※ Only overseas
                                                    participants</p>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="2">
                                        <?php
                                        $awards_y_flag = ($detail['awards_yn'] == "Y");
                                        ?>
                                        <input type="checkbox" class="checkbox check_age" id="awards_yn"
                                            name="awards_yn" <?= $awards_y_flag ? "checked" : "" ?>>
                                        <label for="awards_yn">Apply for APSAVD Young Investigator Awards</label>
                                        <span class="eligibility_open pointer" style="transform:translateY(1px)">
                                            ⓘ Eligibility
                                            <div class="eligibility_pop">
                                                <div class="pop_bg"></div>
                                                <p class="balloon">※ To be eligible for this award, the candidate must
                                                    be an early career scientist/clinician (under 40 years of age).</p>
                                            </div>
                                        </span>
                                    </td>
                                </tr> -->
                                <!-- <tr>
                                    <td colspan="2">
                                        <?php
                                        $investigator_grants_y_flag = ($detail['investigator_grants_yn'] == "Y");
                                        ?>
                                        <input type="checkbox" class="checkbox check_age" id="investigator_grants_yn"
                                            name="investigator_grants_yn"
                                            <?= $investigator_grants_y_flag ? "checked" : "" ?>>
                                        <label for="investigator_grants_yn">Apply for IAS Asia-Pacific Federation Young
                                            Investigator Grants</label>
                                        <span class="eligibility_open pointer" style="transform:translateY(1px)"
                                            data-type="tg">
                                            ⓘ Eligibility
                                            <div class="eligibility_pop">
                                                <div class="pop_bg"></div>
                                                <p class="balloon">※ Under 40 years of age<br />※ Not available to
                                                    attendees from the country hosting the Congress</p>
                                            </div>
                                        </span>
                                    </td>
                                </tr> -->
                                <tr name="check_age"
                                    style="<?= ($travel_grants_y_flag || $awards_y_flag || $investigator_grants_y_flag) ? "" : "display: none" ?>;">
                                    <td colspan="2">
                                        <p>Please, a copy of documents(passport) that prove age should be attached</p>
                                        <div class="citation_box">
                                            <div class="file_input file_submission">
                                                <?php
                                                    $idx = $detail['prove_age_idx'];
                                                    $file_name = $detail['prove_age_original_name'];
                                                    ?>
                                                <label class='label'
                                                    data-js-label><?= $file_name != "" ? $file_name : $locale("select_file") ?></label>
                                                <input type="file" name="prove_age_file" class="abstract_file"
                                                    accept=".jpeg, .jpg, .gif, .bmp, .png" data-idx="<?= $idx ?>">
                                                <span class="btn dark_gray_btn">File Find</span>
                                                <span class="btn dark_gray_btn delete_file">Delete</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="pager_btn_wrap">
                    <!-- <button type="button" class="btn submit is_submit" onclick="javascript:window.location.href='./abstract_submission2.php';"><?= $locale("next_btn") ?></button> -->
                    <button type="button" class="btn"
                        onclick="javascript:location.href='./abstract_submission.php?idx=<?= $submission_idx ?>';">Previous</button>
                    <button type="button" class="btn green_btn submit_btn">Save &amp; Next</button>
                </div>
            </div>
        </div>
        <!--//section1-->
    </div>
</section>
<div class="loading"><img src="./img/icons/loading.gif" /></div>

<!-- <div class="popup green_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<p class="centerT tg">※ Under 45 years old of age</p>
		<p class="centerT tg">※ Only overseas participants</p>
		<p class="centerT aw">※ To be eligible for this award, the candidate must be an early career scientist/clinician (under 40 years of age).</p>
		<p class="centerT ig">※ Under 40 years of age</p>
		<p class="centerT ig">※ Not available to attendees from the country hosting the Congress</p>
	</div>
</div> -->
<!----------------------- 퍼블리싱 구분선 ----------------------->

<script>
const submission_idx = '<?= $submission_idx ?>';
const editor_setting_seconds = 5000

$(document).ready(function() {
    // editor에 글자를 쳤을 때 글자 수 표출되는 이벤트 
    // setTimeout 을 안하면 iframe이 만들어지기 전에 이벤트가 등록되어 영역을 찾지 못한다 
    pending_on();
    setTimeout(function() {

        var textarea1 = document.querySelector("#title").nextSibling.contentWindow.document
            .querySelector("iframe").contentWindow.document.querySelector(".se2_inputarea");
        textarea1.addEventListener("keyup", function(e) {
            set_word_limit_title();
        });

        var textarea2 = document.querySelector("#objectives").nextSibling.contentWindow.document
            .querySelector("iframe").contentWindow.document.querySelector(".se2_inputarea");
        textarea2.addEventListener("keyup", function(e) {
            set_word_limit_contents();
        });

        var textarea3 = document.querySelector("#methods").nextSibling.contentWindow.document
            .querySelector("iframe").contentWindow.document.querySelector(".se2_inputarea");
        textarea3.addEventListener("keyup", function(e) {
            set_word_limit_contents();
        });

        var textarea4 = document.querySelector("#results").nextSibling.contentWindow.document
            .querySelector("iframe").contentWindow.document.querySelector(".se2_inputarea");
        textarea4.addEventListener("keyup", function(e) {
            set_word_limit_contents();
        });

        var textarea5 = document.querySelector("#conclusions").nextSibling.contentWindow.document
            .querySelector("iframe").contentWindow.document.querySelector(".se2_inputarea");
        textarea5.addEventListener("keyup", function(e) {
            set_word_limit_contents();
        });

        // var textarea6 = document.querySelector("#keywords").nextSibling.contentWindow.document
        //     .querySelector("iframe").contentWindow.document.querySelector(".se2_inputarea");
        // textarea6.addEventListener("keyup", function(e) {
        //     set_word_limit_contents();
        // });

        set_word_limit_title();
        set_word_limit_contents();

        pending_off();
    }, editor_setting_seconds);
});

$(".green_open").click(function() {
    $(".green_pop p").hide();
    $(".green_pop p." + ($(this).data('type'))).show();
    $(".green_pop").show();
});

// topic select
$('select[name=topic1]').change(function() {
    var selected_value = $('select[name=topic1] option:selected').val();

    if (selected_value < 5) {
        $('select[name=topic2]').show();
    } else {
        $('select[name=topic2]').hide();
    }

    $('select[name=topic2] option').eq(0).prop('selected', true);
    $('select[name=topic2] option').prop('hidden', true);
    $('select[name=topic2] option[data-parent=' + selected_value + ']').prop('hidden', false);
});

// word_limit - title
function get_word_count_title() {
    <?= get_editor_js("title"); ?>

    var len = get_word_count(title_editor_data);

    return len;
}

function set_word_limit_title() {
    var len = get_word_count_title();
    $('span[name=word_limit_title]').text(len);

    if (len > 25) {
        alert("Title shall not be longer than 25 words.");
    }
}

// word_limit - contents
function get_word_count_contents() {
    <?= get_editor_js("objectives"); ?>
    <?= get_editor_js("methods"); ?>
    <?= get_editor_js("results"); ?>
    <?= get_editor_js("conclusions"); ?>
    /*<?= get_editor_js("keywords"); ?>*/

    var len = 0;
    len += get_word_count(objectives_editor_data);
    len += get_word_count(methods_editor_data);
    len += get_word_count(results_editor_data);
    len += get_word_count(conclusions_editor_data);
    //len += get_word_count(keywords_editor_data);

    $('input[type=file].check_word_limit').siblings('label').each(function() {
        if ($(this).text() != "Select File") {
            len += 50;
        }
    });

    return len;
}

function set_word_limit_contents() {
    var len = get_word_count_contents();
    $('span[name=word_limit_contents]').text(len);

    if (len > 300) {
        alert("Abstract shall not be longer than 300 words.");
    }
}

// get word count
function get_word_count(str) {
    var text = str.trim();
    text = text.replace(/<br>/ig, " ").replace(/&nbsp;/ig, " ").replace(
        /<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/ig, ""); // html 제거

    var len = text.split(" ").filter((element, i) => element != "").length;

    return len;
}

// file upload
$("input.abstract_file").on("change", function() {
    var target = $(this);
    var lecture_file_type = ["JPEG", "JPG", "GIF", "BMP", "PNG"];
    var label = target.val().replace(/^.*[\\\/]/, '');
    var type = target.val().replace(/^.*[.]/, '').toUpperCase();

    /*if (target.hasClass('check_word_limit')) {
    	var cur_len = get_word_count_contents();
    	if (cur_len >= 250) {
    		alert('Your abstract contain too many word for an image to be attached.\nPlease ensure that you have at least 50 words remaining from the total word limit if you would like to add an image.\n');
    		target.val('');
    		return false;
    	}
    }*/

    //파일 용량 제한
    var file = target[0].files[0];
    // if (file.size > (10 * 1024 * 1024)) {
    //     alert("You can only save files that are less than 10MB.");
    //     target.val('');
    //     return false;
    // }
    var fileCheck = true; //fileCheck(file);

    if (!lecture_file_type.includes(type)) {
        alert(locale(language.value)("mismatch_file_type"));
        target.val("");
        return false;
    }

    if (!fileCheck) {
        // alert(locale(language.value)("file_size_error"));
        target.val("");
        return false;
    }

    if (target.val() != "") {
        target.prev("label.label").text(label);
        target.data('idx', 0);
        if (target.hasClass('check_word_limit')) {
            set_word_limit_contents();
        }
    } else {
        $("label.label").text("");
    }
});

// file delete
$(".delete_file").click(function() {
    if (confirm('Are you sure you want to remove?')) {
        var _this = $(this);

        _this.siblings('label').text("Select File");
        _this.parent().siblings("div").children("input[type=text]").val("");
        _this.siblings('input[type=file]').data("idx", -1);

        if (_this.siblings('input[type=file]').hasClass('check_word_limit')) {
            set_word_limit_contents();
        }
    }
});

$(document).on("change", ".en_num_keyup", function(key) {
    var pattern_eng = /[^0-9||a-zA-Z \s]/gi;
    var _this = $(this);
    if (key.keyCode != 8) {
        var first_name = _this.val().replace(pattern_eng, '');
        _this.val(first_name.trim());
    }
});

// check age
$('input.check_age').change(function() {
    var _this = $(this);
    var id = _this.attr('id');
    var check_flag = _this.prop('checked');

    if (check_flag) {
        switch (id) {
            case "travel_grants_yn":
                $('input[name=awards_yn]').prop('checked', false);
                $('input[name=investigator_grants_yn]').prop('checked', false);
                break;
            case "awards_yn":
                $('input[name=travel_grants_yn]').prop('checked', false);
                $('input[name=investigator_grants_yn]').prop('checked', false);
                break;
            case "investigator_grants_yn":
                $('input[name=travel_grants_yn]').prop('checked', false);
                $('input[name=awards_yn]').prop('checked', false);
                break;
        }
    }

    if ($('input.check_age:checked').length > 0) {
        $('tr[name=check_age]').show();
    } else {
        $('tr[name=check_age]').hide();
    }
});

// save
$('.submit_btn').click(function() {
    // preferred_presentation_type
    if ($('input[name=preferred_presentation_type]:checked').length <= 0) {
        alert('Please select the Presentation Type.');
        return false;
    }

    // topic
    var topic1 = $('select[name=topic1] option:selected').val();
    var topic2 = $('select[name=topic2] option:selected').val();
    if (topic1 == "") {
        alert('Please select the Topic.');
        return false;
    } else if (topic1 <= "4" && topic2 == "") {
        alert('Please select the Topic 2.');
        return false;
    }

    // editor
    <?= get_editor_js("title"); ?>
    <?= chk_editor_js("title", true, "Title"); ?>
    <?= get_editor_js("objectives"); ?>
    <?= chk_editor_js("objectives", true, "Objectives"); ?>
    <?= get_editor_js("methods"); ?>
    <?= chk_editor_js("methods", true, "Method"); ?>
    <?= get_editor_js("results"); ?>
    <?= chk_editor_js("results", true, "Results"); ?>
    <?= get_editor_js("conclusions"); ?>
    <?= chk_editor_js("conclusions", true, "Conclusions"); ?>
    // <?= get_editor_js("keywords"); ?>
    // <?= chk_editor_js("keywords", true, "Keywords"); ?>

    // word count
    var word_count_title = get_word_count_title();
    if (word_count_title > 25) {
        alert("Title shall not be longer than 25 words.");
        return false;
    }
    var word_count_contents = get_word_count_contents();
    if (word_count_contents > 300) {
        alert("Abstract shall not be longer than 300 words.");
        return false;
    }

    // image
    var file_image1 = $("input[name=abstract_file1]")[0];
    var file_image2 = $("input[name=abstract_file2]")[0];
    // var file_image3 = $("input[name=abstract_file3]")[0];
    // var file_image4 = $("input[name=abstract_file4]")[0];
    // var file_image5 = $("input[name=abstract_file5]")[0];
    if (file_image1.files[0] && $('input[name=abstract_file_caption1]').val() == "") {
        alert("Please enter Image 1 Caption.");
        return false;

    } else if (file_image2.files[0] && $('input[name=abstract_file_caption2]').val() == "") {
        alert("Please enter Image 2 Caption.");
        return false;
    }

    // } else if (file_image3.files[0] && $('input[name=abstract_file_caption3]').val() == "") {
    //     alert("Please enter Image 3 Caption.");
    //     return false;

    // } else if (file_image4.files[0] && $('input[name=abstract_file_caption4]').val() == "") {
    //     alert("Please enter Image 4 Caption.");
    //     return false;

    // } else if (file_image5.files[0] && $('input[name=abstract_file_caption5]').val() == "") {
    //     alert("Please enter Image 5 Caption.");
    //     return false;
    // }

    // similar_yn
    var similar_yn_flag = $('input[name=similar_yn]:checked').length <= 0
    if (similar_yn_flag) {
        alert('Have you submitted this abstract or an abstract of a similar topic at another conference?');
        return false;
    }

    // support_yn
    var support_yn_flag = $('input[name=support_yn]:checked').length <= 0
    if (!support_yn_flag) {
        // alert('This research is supported by the grant of Korean Society of Lipid and Atherosclerosis.');
        return false;
    }

    // apply etc
    var check_age_flag = $('input.check_age:checked').length > 0
    var file_prove_age = $("input[name=prove_age_file]")[0];
    var file_prove_age_flag = (file_prove_age.files[0] || $('input[name=prove_age_file]').data('idx') > 0);
    if (check_age_flag && !file_prove_age_flag) {
        alert("Please, a copy of documents(passport) that prove age should be attached");
        return false;
    }

    /* save */
    var formdata = new FormData();
    formdata.append('flag', 'step2');
    formdata.append('idx', submission_idx);

    formdata.append('preferred_presentation_type', $('input[name=preferred_presentation_type]:checked')
        .val());

    formdata.append('topic1', topic1);
    formdata.append('topic2', topic2);

    formdata.append('title', title_editor_data);
    formdata.append('objectives', objectives_editor_data);
    formdata.append('methods', methods_editor_data);
    formdata.append('results', results_editor_data);
    formdata.append('conclusions', conclusions_editor_data);
    // formdata.append('keywords', keywords_editor_data);

    var file_input_array = ["", file_image1, file_image2, ];
    var file_array = ["", file_image1.files[0], file_image2.files[0], ];
    var temp_idx_name, temp_idx_value, temp_file_name, temp_file_value, temp_caption_name,
        temp_caption_value;
    for (var i = 1; i <= 5; i++) {
        temp_idx_name = "abstract_file_idx" + i;
        temp_idx_value = $('input[name=abstract_file' + i + ']').data('idx');

        temp_file_name = "abstract_file" + i;
        temp_file_value = file_array[i];

        temp_caption_name = "abstract_caption" + i;
        temp_caption_value = $(('input[name=abstract_file_caption' + i + ']')).val();

        formdata.append(temp_idx_name, temp_idx_value);

        if (temp_file_value) {
            formdata.append(temp_file_name, temp_file_value);
        }

        if (temp_file_value || temp_idx_value > -1) {
            formdata.append(temp_caption_name, temp_caption_value);

        }
    }

    if (file_image1.files[0]) {
        formdata.append("abstract_file1", file_image1.files[0]);
        formdata.append("abstract_caption1", $('input[name=abstract_file_caption1]').val());
    }
    if (file_image2.files[0]) {
        formdata.append("abstract_file2", file_image2.files[0]);
        formdata.append("abstract_caption2", $('input[name=abstract_file_caption2]').val());
    }
    // if (file_image3.files[0]) {
    //     formdata.append("abstract_file3", file_image3.files[0]);
    //     formdata.append("abstract_caption3", $('input[name=abstract_file_caption3]').val());
    // }
    // if (file_image4.files[0]) {
    //     formdata.append("abstract_file4", file_image4.files[0]);
    //     formdata.append("abstract_caption4", $('input[name=abstract_file_caption4]').val());
    // }
    // if (file_image5.files[0]) {
    //     formdata.append("abstract_file5", file_image5.files[0]);
    //     formdata.append("abstract_caption5", $('input[name=abstract_file_caption5]').val());
    // }

    formdata.append('similar_yn', $('input[name=similar_yn]:checked').val());
    formdata.append('support_yn', $('input[name=support_yn]:checked').val());
    formdata.append('travel_grants_yn', ($('input[name=travel_grants_yn]').prop('checked') ? "Y" : "N"));
    formdata.append('awards_yn', ($('input[name=awards_yn]').prop('checked') ? "Y" : "N"));
    formdata.append('investigator_grants_yn', ($('input[name=investigator_grants_yn]').prop('checked') ?
        "Y" :
        "N"));
    formdata.append("prove_age_file_idx", $('input[name=prove_age_file]').data('idx'));
    if (file_prove_age_flag && file_prove_age.files[0]) {
        formdata.append("prove_age_file", file_prove_age.files[0]);
    }

    pending_on();
    $.ajax({
        url: PATH + "ajax/client/ajax_submission2022.php",
        type: "POST",
        data: formdata,
        dataType: "JSON",
        contentType: false,
        processData: false,

        success: function(res) {
            console.log(res);
            if (res.code == 200) {
                alert("Please note: You can modify the submitted abstract until the deadline.")
                //alert(locale(language.value)("send_mail_success"));
                location.href = './abstract_submission3.php?idx=' + submission_idx
            }

        },
        complete: function() {
            pending_off();
        },
        error: function(err) {
            alert("You can only save files that are less than 10MB.")
            // console.log(err)
        }
    });
    /* //save */
});
</script>
<?php
}

include_once('./include/footer.php');
?>