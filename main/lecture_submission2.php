<head>
    <meta name="robots" content="noindex">
    <meta http-equiv="refresh" content="0;URL='https://iscp2023.org/main'" />
    <meta property="og:image" content="/main/img/xg_image.png" />
</head>
<?php
	exit;

	include_once('./include/head.php');
	include_once('./include/header.php');

	$lecture_idx = $_GET["idx"];

	if($lecture_idx) {
		 $select_lecture_detail_query = "
											SELECT
												ra.idx, 
												ra.presentation_type, 
												ra.cv,
												f_cv.original_name AS file_name_cv,
												f_abf.original_name AS file_name_abf
											FROM request_abstract ra
											LEFT JOIN file f_cv
												ON ra.cv_file = f_cv.idx
											LEFT JOIN file f_abf
												ON ra.notice_file = f_abf.idx
											WHERE ra.idx = {$lecture_idx}
										";
		$lecture_detail = sql_fetch($select_lecture_detail_query);

		$presentation_type = isset($lecture_detail["presentation_type"]) ? $lecture_detail["presentation_type"] : "";
		$cv = isset($lecture_detail["cv"]) ? $lecture_detail["cv"] : "";
		$file_name_cv = isset($lecture_detail["file_name_cv"]) ? $lecture_detail["file_name_cv"] : "";
		$file_name_abf = isset($lecture_detail["file_name_abf"]) ? $lecture_detail["file_name_abf"] : "";
	}

	echo "<script>var type='lecture'; </script>";

?>
<section class="container submit_application lecture_submission">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Lecture Note Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Lecture Note Submission (invited speaker)</li>
                    <li>Online Submission</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./lecture_note_submission.php">Lecture Note Submission Guideline</a></li>
            <li class="on"><a href="javascript:;">Online Submission</a></li>
        </ul>
        <div>
            <div class="steps_area">
                <ul class="clearfix">
                    <li class="past">
                        <p>STEP 01</p>
                        <p class="sm_txt">
                            <!-- <?=$locale("lecture_submit_tit1")?> --> Presenting author’s<br>contact details
                        </p>
                    </li>
                    <li class="past">
                        <p>STEP 02</p>
                        <p class="sm_txt">
                            <!-- <?=$locale("lecture_submit_tit2")?> --> Complete lecture note
                        </p>
                    </li>
                    <li>
                        <p>STEP 03</p>
                        <p class="sm_txt"><?=$locale("submit_completed_tit")?></p>
                    </li>
                </ul>
            </div>
            <div class="input_area">
                <div>
                    <ul class="sign_list max685">
                        <li>
                            <p class="label">
                                <!--<?=$locale("lecture_item_cv")?> *--><span class="red_txt">*</span>CV file
                            </p>
                            <div class="citation_box">
                                <div class="file_input file_submission">
                                    <label class='cv_label'
                                        data-js-label><?=$file_name_cv != "" ? $file_name_cv : $locale("lecture_item_cv_placeholder")?></label>
                                    <input class="required" type="file" name="cv_file" accept=".docx, .pdf">
                                    <span class="btn dark_gray_btn">search</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <p class="label">
                                <!--<?=$locale("abstract_item_file")?> *--><span class="red_txt">*</span>Lecture Note
                                File
                            </p>
                            <div class="citation_box">
                                <div class="file_input file_submission">
                                    <label class='label'
                                        data-js-label><?=$file_name_abf != "" ? $file_name_abf : $locale("abstract_item_file_placeholder")?></label>
                                    <input class="required" type="file" name="lecture_file" accept=".docx, .pdf">
                                    <span class="btn dark_gray_btn">search</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- 기존 버튼 개발소스
				<div class="btn_wrap submission_step2">
					<button type="button" class="btn" onclick="window.location.href='./lecture_submission.php<?=$lecture_idx ? "?idx=".$lecture_idx : ""?>';"><?=$locale("prev_btn")?></button>
					<a class="btn preview_pop_btn"><?=$locale("preview_btn")?></a>
					<button type="button" class="btn submit_btn" data-idx=<?=$lecture_idx?>><?=$locale("submit_btn")?></button>
				</div>
				-->
                <div class="pager_btn_wrap half">
                    <button type="button" class="btn gray_btn"
                        onClick="javascript:location.href='./lecture_submission.php'">Prev</button>
                    <button type="button" class="btn green_btn" data-idx=<?=$lecture_idx?>>Submit</button>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="loading"><img src="./img/icons/loading.gif" /></div>


<script src="./js/script/client/submission.js"></script>
<script>
$(document).ready(function() {
    $(".green_btn").on("click", function() {

        var idx = $(this).data("idx");
        var type = idx ? "update" : "insert";

        var process = InputCheck(type, idx);
        var status = process.status;
        var data = process.data;
        //console.log(data);

        if (status) {
            $(".loading").show();
            $("body").css("overflow-y", "hidden");

            $.ajax({
                url: "./ajax/client/ajax_submission.php",
                type: "POST",
                data: data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.code == 200) {
                        alert(locale(language.value)("complet_submission"));
                        $(window).off("beforeunload");
                        window.location.replace("./lecture_submission3.php");
                    } else if (res.code == 400) {
                        alert(locale(language.value)("lecture_submit_error") + "\n" +
                            locale(language.value)("retry_msg"));
                        return false;
                    } else {
                        alert(res.code);
                        alert(locale(language.value)("reject_msg"));
                        return false;
                    }
                },
                complet: function() {
                    $(".loading").hide();
                    $("body").css("overflow-y", "auto");
                }
            });
        }
    });

    $("input[name=lecture_file]").on("change", function() {
        var lecture_file_type = ["DOCX", "PDF"];
        var label = $(this).val().replace(/^.*[\\\/]/, '');
        var type = $(this).val().replace(/^.*[.]/, '').toUpperCase();

        //파일 용량 제한
        var file = $(this)[0].files[0];
        var fileCheck = true; //fileCheck(file);

        if (!lecture_file_type.includes(type)) {
            alert(locale(language.value)("mismatch_file_type"));
            $(this).val("");
            return false;
        }

        if (!fileCheck) {
            // alert(locale(language.value)("file_size_error"));
            $(this).val("");
            return false;
        }

        if ($(this).val() != "") {
            $("label.label").text(label);
        } else {
            $("label.label").text("");
        }

    });

    /* 21.06.11 퍼블 긴급패치로 인한 추가개발 필요(주석)*/
    $("input[name=cv_file]").on("change", function() {
        var cv_file_type = ["DOCX", "PDF"];
        var label = $(this).val().replace(/^.*[\\\/]/, '');
        var type = $(this).val().replace(/^.*[.]/, '').toUpperCase();

        //파일 용량 제한
        var fileSize = $(this)[0].files[0].size;
        var maxSize = 5 * 1024 * 1024 * 1024;

        if (!cv_file_type.includes(type)) {
            alert(locale(language.value)("mismatch_file_type"));
            $(this).val("");
            return false;
        }

        if (fileSize > maxSize) {
            alert(locale(language.value)("file_size_error"));
            $(this).val("");
            return false;
        }

        $(".cv_label").text(label);
    });

});

function InputCheck(type, idx = '') {
    var formData = new FormData();
    var inputCheck = true;

    //if(!$("input[name=presentation_type]").is(":checked")) {
    //	console.log(locale(language.value)("check_presentation_type"));
    //	alert(locale(language.value)("check_presentation_type"));
    //	inputCheck = false;
    //	return false;
    //}

    //if($("input[name=cv]").val() == "") {
    //	alert(locale(language.value)("check_cv"));
    //	inputCheck = false;
    //	return false;
    //}
    if (type != "update") {
        if (!$("input[name=cv_file]").val()) {
            alert(locale(language.value)("check_cv"));
            inputCheck = false;
            return false;
        }
    }
    if (type != "update") {
        if (!$("input[name=lecture_file]").val()) {
            alert(locale(language.value)("check_lecture_file"));
            inputCheck = false;
            return false;
        }
    } else {
        formData.append("type", type);
        formData.append("idx", idx);
    }

    //formData.append("presentation_type", $("input[name=presentation_type]").val());
    formData.append("cv", $("input[name=cv]").val());
    formData.append("lecture_file", $("input[name=lecture_file]")[0].files[0]);
    // 21.06.11 퍼블 긴급패치로 인한 추가개발 필요(주석)
    formData.append("cv_file", $("input[name=cv_file]")[0].files[0]);
    formData.append("flag", "lecture_step2");
    return {
        data: formData,
        status: inputCheck
    }
}
</script>

<?php
	include_once('./include/footer.php');
?>