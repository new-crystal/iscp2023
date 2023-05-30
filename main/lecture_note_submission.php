<head>
    <meta name="robots" content="noindex">
    <meta http-equiv="refresh" content="0;URL='https://iscp2023.org/main'" />
    <meta property="og:image" content="/main/img/xg_image.png" />
</head>
<?php
exit;

include_once('./include/head.php');
include_once('./include/header.php');

// key date
$sql_key_date =    "SELECT
						idx, `key_date`, contents_" . $language . " AS contents
					FROM key_date
					WHERE `type` = 'lecture'
					AND `key_date` <> '0000-00-00'
					ORDER BY idx";
$key_date = get_data($sql_key_date);

// info
$sql_info = "SELECT
					note_msg_" . $language . " AS note_msg,
					formatting_guidelines_" . $language . " AS formatting_guidelines,
					how_to_modify_" . $language . " AS how_to_modify
				FROM info_lecture";
$info = sql_fetch($sql_info);
?>
<section class="container lecture_guideline sub_page">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Lecture Note Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Lecture Note Submission (invited speaker)</li>
                    <li>Lecture Note Submission Guideline</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <ul class="tab_pager location tab_pager_small">
            <li class="on"><a href="javascript:;">Lecture Note Submission Guideline</a></li>
            <li><a href="./lecture_submission.php">Online Submission</a></li>
        </ul>
        <div class="rightT mb30">
            <a href="javascript:;" class="btn_oval_line" target="_blank">CV Form Download</a><br>
        </div>
        <!-- contents 1 -->
        <div class="circle_title">Message for Lecture Note</div>
        <div class="details">
            <p>
                Thank you for submitting the lecture note submission for the upcoming ISCP 2023 with APSAVD.
                <br />If you are an invited speaker and is to give a lecture(s) at the ISCP 2023 with APSAVD, please
                submit your CV and lecture note following the below procedures.
                <br />All Lecture Notes must be submitted through the ‘Online Submission System’ on the ISCP 2023 with
                APSAVD website.
            </p>
        </div>
        <!-- contents 2 -->
        <div class="circle_title"><?= $locale("keydate") ?></div>
        <!--
		<div class="table_wrap">
			<table class="table detail_table">
				<colgroup>
					<col class="col_th" />
					<col width="*" />
				</colgroup>
				<tbody>
					<?php
                    foreach ($key_date as $kd) {
                    ?>
					<tr>
						<th><?= $kd['contents'] ?></th>
						<td>
							<?php
                            if ($language == "en") {
                                echo date_format(date_create($kd['key_date']), "F d(D), Y");
                            } else {
                                echo date_format(date_create($kd['key_date']), "Y년 m월 d일");
                                echo "(";
                                echo $weekday[(date_format(date_create($kd['key_date']), "w"))];
                                echo ")";
                            }
                            ?>
						</td>
					</tr>
					<?php
                    }
                    ?>
				</tbody>
			</table>
		</div>
		-->
        <div class="details submission_keydate">
            <ul>
                <!-- <li>Abstract submission system open: <span>2 MAY, 2022</span></li> -->
                <li>Abstract submission system open: <span>Mid-April,2022</span></li>
                <li class="red_txt">Deadline for Speaker Abstract Submission: <span>31 July, 2022</span></li>
                <li>Deadline for Upload Presentation File: <span>20 Aug, 2022</span></li>
            </ul>
        </div>
        <!-- contents 3 -->
        <div class="circle_title">Lecture Materials</div>
        <div class="details table_wrap">
            <table class="table wide_table materials_table">
                <colgroup>
                    <col class="col_th" />
                    <col width="*" />
                </colgroup>
                <tbody>
                    <tr>
                        <th>Lecture Note Form and Instruction</th>
                        <td><a href="./download/icomes_lecture_note_form.docx" class="download_btn" target="_blank"><?= $locale("lecture_note_btn") ?></a></td>
                    </tr>
                    <tr>
                        <th>Consent form for providing lecture materials</th>
                        <td><a href="./download/icomes_copyright_transfer_agreement.docx" class="download_btn" target="_blank"><?= $locale("lecture_copyright_btn") ?></a></td>
                    </tr>
                    <tr>
                        <th>Instruction on Making Lecture Video<br /><span class="mini_alert">**Video files must be
                                saved in (*.mp4)</span></th>
                        <td>
                            <a href="./download/icomes_making_presentation_mac.pdf" class="download_btn" target="_blank"><?= $locale("lecture_video_btn") ?></a>
                            <a href="./download/icomes_making_presentation_ppt.pdf" class="download_btn" target="_blank"><?= $locale("lecture_video_btn2") ?></a>
                        </td>
                    </tr>
                    <tr>
                        <th>Lecture Video Upload</th>
                        <td><a href="https://www.dropbox.com/request/MU8mnzHk8Wh3V23foa7V" target="_blank" class="link_btn"><?= $locale("lecture_video_txt3") ?></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- contents 4 -->
        <div class="circle_title">Steps for Lecture Note Submission</div>
        <div class="details step_gradation">
            <ul>
                <li>
                    <div class="step_circle"><span>STEP 01</span></div>
                    <p class="step_text">Click the Lecture Note Submission Button</p>
                </li>
                <li>
                    <div class="step_circle"><span>STEP 02</span></div>
                    <p class="step_text">Log in to ISCP 2023 with APSAVD (If you don’t have an account, please sign up
                        first)</p>
                </li>
                <li>
                    <div class="step_circle"><span>STEP 03</span></div>
                    <p class="step_text">Fill out personal information and click Lecture Note submission.</p>
                </li>
                <li>
                    <div class="step_circle"><span>STEP 04</span></div>
                    <p class="step_text">Upload lecture note and Speaker’s information section.</p>
                </li>
                <li>
                    <div class="step_circle"><span>STEP 05</span></div>
                    <p class="step_text">Completed</p>
                </li>
            </ul>
        </div>
        <!-- contents 5 -->
        <div class="circle_title">Formatting guidelines and suggestions</div>
        <div class="details">
            <ul>
                <li>• All lecture notes must be submitted via the congress website only.</li>
                <li>• When you submit a lecture note online, it will be automatically edited according to the congress
                    submission format. It is the authors’ responsibility to review the submissions and correct them.
                    Please proofread your lecture note before completing your submission.</li>
                <li>• Submitted lecture note should not exceed 1,000 words in length, and should be typed in English.
                </li>
                <li>• No tables, graphs and images are allowed.</li>
                <li>• If you do not complete the submission process, your information will be held in temporary storage
                    until you return later to complete your submission. Please note that your submission must be
                    completed before the submission deadline.</li>
                <li>• A confirmation of the lecture note will be automatically sent to you by e-mail upon the on-line
                    submission.</li>
                <li>• If on-line submission is not available, please contact the congress secretariat at
                    <!-- Icola_abstract@into-on.com  -->
                </li>
            </ul>
        </div>
        <!-- contents 6 -->
        <div class="circle_title">How to modify</div>
        <div class="details">
            <ul>
                <li>You can modify the submitted CV and lecture note, on 'My Page’ up until the submission deadline.
                </li>
                <li>• Go to 'My Page’ and click ‘Lecture Note Submission’ on the left side of the page.</li>
                <li>• Click the 'Modify’ button to modify.</li>
                <li>• Modify your CV and lecture note by following the steps.</li>
                <li>• Make sure to click the 'Submit’ button at the end of the steps to save your modification.</li>
            </ul>
        </div>
    </div>

</section>

<button type="button" class="fixed_btn" onclick="window.location.href='./lecture_submission.php';">
    <!-- <?= $locale("invited_speakers_btn") ?> -->
    Lecture Note<br />Submission
</button>

<?php include_once('./include/footer.php'); ?>