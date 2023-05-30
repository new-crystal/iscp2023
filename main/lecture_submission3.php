<head>
    <meta name="robots" content="noindex">
    <meta http-equiv="refresh" content="0;URL='https://iscp2023.org/main'" />
    <meta property="og:image" content="/main/img/xg_image.png" />
</head>
<?php
	exit;

	include_once('./include/head.php');
	include_once('./include/header.php');
?>

<!-- 기존 마크업 -->
<section class="submit_application sub_page" style="display: none;">
    <div class="container">
        <div class="sub_banner">
            <h5>Call for Abstract</h5>
            <h1>Poster Abstract Submission</h1>
        </div>
        <div class="tab_area">
            <ul class="clearfix">
                <li><a href="./lecture_note_submission.php" class="btn"><?=$locale("lecture_menu1")?></a></li>
                <li><a href="javascript:;" class="btn active"><?=$locale("lecture_menu2")?></a></li>
                <li><a href="./oral_presenters.php" class="btn"><?=$locale("lecture_menu3")?></a></li>
                <li><a href="./eposter_presenters.php" class="btn"><?=$locale("lecture_menu4")?></a></li>
            </ul>
        </div>
        <div class="section section1">
            <div class="steps_area">
                <ul class="clearfix">
                    <li class="past">
                        <p><img src="./img/icons/step_past.png"></p>
                        <p>STEP 01</p>
                        <p class="sm_txt"><?=$locale("lecture_submit_tit1")?></p>
                    </li>
                    <li class="past">
                        <p><img src="./img/icons/step_past.png"></p>
                        <p>STEP 02</p>
                        <p class="sm_txt"><?=$locale("lecture_submit_tit2")?></p>
                    </li>
                    <li class="on">
                        <p><img src="./img/icons/step_on.png"></p>
                        <p>STEP 03</p>
                        <p class="sm_txt"><?=$locale("submit_completed_tit")?></p>
                    </li>
                </ul>
            </div>
            <div class="completed_box">
                <!-- <p><?=$locale("lecture_submit_msg")?></p> -->
                <img src="./img/icons/abstract_complete2.png">
            </div>
        </div>
        <!--//section1-->
    </div>
</section>
<!-- 기존 마크업 : end -->

<!-- 변경 마크업 -->
<section class="container submit_application sub_page lecture_submission">
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
    <div class="inner">
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
                    <li class="past">
                        <p>STEP 03</p>
                        <p class="sm_txt"><?=$locale("submit_completed_tit")?></p>
                    </li>
                </ul>
            </div>
            <div class="completed_box">
                <!-- <p><?=$locale("lecture_submit_msg")?></p> -->
                <!-- <img src="./img/icons/abstract_complete2.png"> -->
                Thank you for submitting Lecture note.
                <br />You can modify the submitted CV and lecture note on 'My Page’ up until the submission deadline.

            </div>
        </div>
    </div>
</section>
<!-- 변경 마크업 : end -->


<?php include_once('./include/footer.php');?>