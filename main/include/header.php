<?php
$language = isset($_SESSION["language"]) ? $_SESSION["language"] : "en";
$locale = locale($language);

$_page_config = array(
    "m1" => [
        "welcome",
        "organizing_committee",
        "overview",
        "venue",
        "photo"
    ],
    "m2" => [
        "program_glance",
        "program_detail",
        "invited_speaker"
    ],
    "m3" => [
        "poster_abstract_submission",
        "abstract_submission",
        "abstract_submission2",
        "abstract_submission3",
        "eposter",
        "lecture_note_submission",
        "lecture_submission",
        "lecture_submission2",
        "lecture_submission3",
        "oral_presenters",
        "eposter_presenters"
    ],
    "m4" => [
        "registration_guidelines",
        "registration",
        "registration2",
        "registration3"
    ],
    "m5" => [
        "sponsor_information",
        "application",
        "application_complete"
    ],
    "m6" => [
        "accommodation",
        "attraction_historic",
        "useful_information"
    ]
);

$_page = str_replace(".php", "", end(explode("/", $_SERVER["REQUEST_URI"])));

//오늘 날짜 구하기 d_day 구하기
$today = date("Y. m. d");
$d_day = new DateTime("2023-11-23");

$current_date = new DateTime();
$current_date->format('Y-m-d');

$intvl = $current_date->diff($d_day);
$d_days = $intvl->days + 1;
?>
<!-- 모바일 메뉴박스 -->
<div class="m_nav_wrap">
    <ul class="g_h_tool">
        <li><a href="/main/index.php">Home</a></li>
        <?php
        if ($_SESSION["USER"]["idx"] == "") {
        ?>
        <li><a href="/main/login.php">Login</a></li>
        <!-- <li><a href="/main/signup.php">Sign up</a></li> -->
        <!-- <li><a class="pre-sign-up">Sign up</a></li> -->
        <?php
        } else {
        ?>
        <li><a href="/main/mypage.php">My page</a></li>
        <li><a class="logout_btn" href="javascript:;">Logout</a></li>
        <?php
        }
        ?>
    </ul>
    <button type="button" class="n_nav_close"><img src="/main/img/icons/m_nav_close.png"></button>
    <div class="m_nav">
        <ul class="m_nav_ul">
            <li class="m_nav_li">
                <a href="javascript:;" class="<?= (in_array($_page, $_page_config["m1"]) ? "show" : "") ?>"><span>ISCP
                        2023</span> <img src="/main/img/icons/nav_arrow.png"></a>
                <ul class="m_sub_nav" style="display:<?= (in_array($_page, $_page_config["m1"]) ? "block" : "none") ?>">
                    <li><a href="/main/welcome.php" class="page_complete">Welcome Message</a></li>
                    <li><a href="/main/organizing_committee.php" class="page_complete">Organization</a></li>
                    <li><a href="/main/venue.php" class="page_complete">Venue</a></li>
                    <!-- <li><a href="/main/accommodation.php" class="page_complete">Accommodation</a></li> -->
                    <!-- <li><a href="/main/board_news.php" class="page_complete">News & Notice</a></li> -->
                    <li><a href="/main/board_notice.php" class="page_complete">News & Notice</a></li>
                </ul>
            </li>
            <li class="m_nav_li">
                <a href="javascript:;"
                    class="<?= (in_array($_page, $_page_config["m2"]) ? "show" : "") ?>"><span>Program</span> <img
                        src="/main/img/icons/nav_arrow.png"></a>
                <ul class="m_sub_nav" style="display:<?= (in_array($_page, $_page_config["m2"]) ? "block" : "none") ?>">
                    <li><a href="/main/program_glance.php" class="page_complete">Program at a glance</a></li>
                    <li><a href="/main/scientific_program1.php" class="page_complete">Scientific Program</a></li>
                    <!--/main/scientific_program.php-->
                    <li><a href="/main/invited_speaker.php" class="page_complete">Invited Speakers</a></li>
                </ul>
            </li>
            <li class="m_nav_li">
                <a href="javascript:;"
                    class="<?= (in_array($_page, $_page_config["m3"]) ? "show" : "") ?>"><span>Abstracts</span> <img
                        src="/main/img/icons/nav_arrow.png"></a>
                <ul class="m_sub_nav" style="display:<?= (in_array($_page, $_page_config["m3"]) ? "block" : "none") ?>">
                    <li><a href="/main/submission_guideline.php" class="page_complete">Abstract Submission</a></li>
                    <!-- <li><a href="/main/lecture_note_submission.php" class="page_complete">Lecture Note Submission<br/>(Invited Speakers)</a></li> -->
                    <li><a href="/main/presentation_guidelines.php" class="page_complete">Presentation Guidelines</a>
                    </li>
                </ul>
            </li>
            <li class="m_nav_li" class="<?= (in_array($_page, $_page_config["m4"]) ? "show" : "") ?>">
                <a href="javascript:;"><span>Registration</span> <img src="/main/img/icons/nav_arrow.png"></a>
                <ul class="m_sub_nav" style="display:<?= (in_array($_page, $_page_config["m4"]) ? "block" : "none") ?>">
                    <li><a href="/main/registration_guidelines.php" class="page_complete">Guidelines</a></li>
                    <li><a href="/main/registration.php" class="page_complete">Registration</a></li>
                    <!--/main/registration.php-->
                </ul>
            </li>
            <li class="m_nav_li" class="<?= (in_array($_page, $_page_config["m5"]) ? "show" : "") ?>">
                <a href="javascript:;"><span>Sponsorship</span> <img src="/main/img/icons/nav_arrow.png"></a>
                <ul class="m_sub_nav" style="display:<?= (in_array($_page, $_page_config["m5"]) ? "block" : "none") ?>">
                    <li><a href="/main/sponsor_information.php" class="page_complete">Sponsors</a></li>
                    <!-- /main/sponsor_information.php-->
                    <li><a href="/main/sponsor_exhibition.php" class="page_complete">Exhibition</a></li>
                </ul>
            </li>
            <li class="m_nav_li" class="<?= (in_array($_page, $_page_config["m6"]) ? "show" : "") ?>">
                <a href="javascript:;"><span>Information</span> <img src="/main/img/icons/nav_arrow.png"></a>
                <ul class="m_sub_nav" style="display:<?= (in_array($_page, $_page_config["m6"]) ? "block" : "none") ?>">
                    <!-- <li><a href="/main/covid_faq.php" class="page_complete">COVID-19</a></li>
                    <li><a href="/main/about_korea.php" class="page_complete">About Korea</a></li>
                    <li><a href="/main/attraction_seoul.php" class="page_complete">Attractions in Seoul</a></li> -->
                    <li><a href="/main/transportation.php" class="page_complete">Transportation</a></li>
                    <li><a href="/main/useful_information.php" class="page_complete">Useful Information</a></li>
                    <li><a href="/main/visa.php" class="page_complete">Visa</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- 모바일 메뉴박스 : 끝 -->


<!-- 변경된 header (22.03.15 HUBDNC LJH2) -->
<header class="green_header">
    <div class="g_h_top">
        <div class="container">
            <!-- <div class="dday_wrap">
                <div class="dday_top"><span>D-<?= number_format($d_days); ?></span></div>
                <div class="dday_bot">Today is <span><?= $today; ?></span></div>
            </div> -->
            <!-- <div class="text_center g_h_logo"><img src="/main/img/footer_logo.png" alt="" class="pointer"
                    onClick="javascript:location.href='/main/index.php'"></div> -->
            <ul class="g_h_tool">
                <li><a href="/main/index.php">Home</a></li>
                <?php
                if ($_SESSION["USER"]["idx"] == "") {
                ?>
                <li><a href="/main/login.php">Login</a></li>
                <li><a href="/main/signup.php">Sign up</a></li>
                <!-- <li class="pre"><a>Sign up</a></li> -->
                <?php
                } else {
                ?>
                <li><a href="/main/mypage.php">My page</a></li>
                <li><a class="logout_btn" href="javascript:;">Logout</a></li>
                <?php
                }
                ?>
                <!-- <li><a href="https://www.lipid.or.kr/">Go to KSoLA</a></li> -->
            </ul>
            <div class="tablet_show">
                <button type="button" class="m_nav_btn"><img src="/main/img/icons/m_nav.png"></button>
            </div>
        </div>
    </div>
    <div class="g_h_bottom">
        <div class="header_container">
            <div class="nav_wrap pc_only">
                <ul class="depth01 clearfix">
                    <li class="<?= (in_array($_page, $_page_config["m1"]) ? "active" : "") ?>">
                        <div class="text_center g_h_logo">
                            <img src="/main/img/TopLogo1.png" alt="" class="pointer"
                                onClick="javascript:location.href='/main/index.php'">
                            <!-- <img src="/main/img/TopLogo2.png" alt="" class="pointer"
                                onClick="javascript:location.href='/main/index.php'">
                            <img src="/main/img/TopLogo3.png" alt="" class="pointer"
                                onClick="javascript:location.href='/main/index.php'"> -->
                        </div>
                    </li>
                    <!-- <li style="margin-left: 140px;" class="<?= (in_array($_page, $_page_config["m1"]) ? "active" : "") ?> nav_bar"> -->
                    <li style="margin-left: 100px;" class="nav_bar">
                        <a href="javascript:;" id="welcome"><span>ISCP 2023</span></a>
                        <ul class="sub_nav">
                            <li><a href="/main/welcome.php" class="page_complete">Welcome Message</a></li>
                            <li><a href="/main/organizing_committee.php" class="page_complete">Organization</a></li>
                            <li><a href="/main/venue.php" class="page_complete">Venue</a></li>
                            <!-- <li><a href="/main/accommodation.php" class="page_complete">Accommodation</a></li> -->
                            <!--/main/accommodation.php-->
                            <!-- <li><a href="/main/board_news.php" class="page_complete">News & Notice</a></li> -->
                            <li><a href="/main/board_notice.php" class="page_complete">News & Notice</a></li>
                        </ul>
                    </li>
                    <li class="<?= (in_array($_page, $_page_config["m2"]) ? "active" : "") ?> nav_bar">
                        <a href="javascript:;" id="program"><span>Program</span></a>
                        <ul class="sub_nav">
                            <li><a href="/main/program_glance.php" class="page_complete">Program at a glance</a>
                            </li>
                            <li><a href="/main/scientific_program1.php" class="page_complete">Scientific Program</a>
                            </li>
                            <!---->
                            <li><a href="/main/invited_speaker.php" class="page_complete">Invited Speakers</a></li>
                        </ul>
                    </li>
                    <li class="<?= (in_array($_page, $_page_config["m3"]) ? "active" : "") ?> nav_bar">
                        <a href="javascript:;" id="abstracts"><span> Abstracts</span></a>
                        <ul class="sub_nav">
                            <li><a href="/main/submission_guideline.php" class="page_complete">Abstract
                                    Submission</a>
                            </li>
                            <!-- <li><a href="/main/lecture_note_submission.php" class="page_complete">Lecture Note Submission<br/>(Invited Speakers)</a></li>  -->
                            <li><a href="/main/presentation_guidelines.php" class="page_complete">Presentation
                                    Guidelines</a></li>
                        </ul>
                    </li>
                    <li class="<?= (in_array($_page, $_page_config["m4"]) ? "active" : "") ?> nav_bar">
                        <a href="javascript:;" id="registration"><span>Registration</span></a>
                        <ul class="sub_nav">
                            <li><a href="/main/registration_guidelines.php" class="page_complete">Guidelines</a>
                            </li>
                            <li><a href="/main/registration.php" class="page_complete">Registration</a></li>
                            <!-- /main/registration.php-->
                        </ul>
                    </li>
                    <li class="<?= (in_array($_page, $_page_config["m5"]) ? "active" : "") ?> nav_bar">
                        <a href="javascript:;" id="sponsorship"><span>Sponsorship</span></a>
                        <ul class="sub_nav">
                            <li><a href="/main/sponsor_information.php" class="page_complete">Sponsors</a></li>
                            <!-- /main/sponsor_information.php -->
                            <li><a href="/main/sponsor_exhibition.php" class="page_complete">Exhibition</a></li>
                        </ul>
                    </li>
                    <li class="<?= (in_array($_page, $_page_config["m6"]) ? "active" : "") ?> nav_bar">
                        <a href="javascript:;" id="information"><span>Information</span></a>
                        <ul class="sub_nav">
                            <!-- <li><a href="/main/covid_faq.php" class="page_complete">COVID-19</a></li> -->
                            <!-- <li><a href="/main/about_korea.php" class="page_complete">About Korea</a></li>
                            <li><a href="/main/attraction_seoul.php" class="page_complete">Attractions in Seoul</a> -->
                    </li>
                    <li><a href="/main/transportation.php" class="page_complete">Transportation</a></li>
                    <li><a href="/main/useful_information.php" class="page_complete">Useful Information</a>
                    </li>
                    <li><a href="/main/visa.php" class="page_complete">Visa</a></li>
                </ul>
                </li>

                </ul>
            </div>
        </div>
    </div>
</header>
<!-- 변경된 header : 끝 -->

<!-- Top btn 추가 (22.03.31 HUBDNC LJH2) -->
<button type="button" class="fixed_top_clone" style="display: none;"></button>
<button type="button" class="fixed_top" style="display: none;"></button>
<!-- Top btn 추가 : 끝 -->

<script>
$(document).ready(function() {
    $("header .depth01 li ul li a, .m_sub_nav li a").click(function() {
        if (!$(this).hasClass("page_complete")) {
            alert("Coming Soon.")
        }
    });
    $(".logout_btn").on("click", function() {
        $.ajax({
            url: PATH + "ajax/client/ajax_member.php",
            type: "GET",
            data: {
                flag: "logout"
            },
            dataType: "JSON",
            success: function() {
                //window.location.replace(PATH);
                window.location.href = "login.php";
            },
            error: function() {
                alert("일시적으로 로그아웃 요청이 거절되었습니다.");
            }
        });
    });
});
const program = document.querySelector("#program")
const abstract = document.querySelector("#abstracts")
const registration = document.querySelector("#registration")
const sponship = document.querySelector("#sponsorship")
const info = document.querySelector("#information")
const welcome = document.querySelector("#welcome")
const pre = document.querySelector(".pre")

program.addEventListener("click", () => window.location.href = "program_glance.php")
abstract.addEventListener("click", () => window.location.href = "submission_guideline.php")
registration.addEventListener("click", () => window.location.href = "registration_guidelines.php")
sponship.addEventListener("click", () => window.location.href = "sponsor_information.php")
info.addEventListener("click", () => window.location.href = "transportation.php")
welcome.addEventListener("click", () => window.location.href = "welcome.php")
</script>