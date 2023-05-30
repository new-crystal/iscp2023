<?php
include_once('./include/head.php');
include_once('./include/header.php');
?>

<!-- //++++++++++++++++++++++++++ -->
<?php

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
                    <h2>COVID-19</h2>
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
?>
    <!-- //++++++++++++++++++++++++++ -->
    <section class="container covid_faq">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>COVID-19</h2>
                    <ul>
                        <li>Home</li>
                        <li>General Information</li>
                        <li>COVID-19 Safety Information </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner">
            <div>
                <div class="circle_title">COVID-19 Safety Information</div>
                <div class="details">
                    <p>
                        <span class="red_txt">Last Updated on September 5, 2022 <br />ISCP 2023 has prepared all necessary
                            hygiene and safety measures according to Korean regulations.</span>
                        <br><br>
                        Please note that the following rules apply for participation in the ISCP 2023.
                    </p>
                </div>
                <div class="covid_btns centerT">
                    <button onClick="javascipr:window.open('./download/Immigration Guidelines for International Attendees_0905.pdf')" class="btn green_btn round" target="_blank">Guidelines for International Attendees <i class="btn_round_icon"><img src="./img/icons/covid_arrow01.png" alt=""></i></button>
                    <!-- <button href="./download/icomes_lecture_note_form.docx" class="btn green_btn round" target="_blank">Guidelines for International Attendees <i class="btn_round_icon"><img src="./img/icons/covid_arrow01.png" alt=""></i></button> -->
                    <!-- <button href="./download/icomes_lecture_note_form.docx" class="btn wine_btn round" target="_blank">Guidelines for Unvaccinated Attendees <i class="btn_round_icon"><img src="./img/icons/covid_arrow02.png" alt=""></i></button> -->
                </div>
            </div>
            <div>
                <div class="circle_title">Entry to Korea</div>
                <div class="clearfix2">
                    <div class="covid_img">

                    </div>
                    <p>
                        <span class="red_txt bold">Effective August 31, the pre-departure PCR test has been abolished and it
                            is no longer required when entering Korea.</span>
                        <br><br>
                        You will be required to complete a short Q-CODE <a href="https://cov19ent.kdca.go.kr/cpassportal/biz/beffatstmnt/main.do?lang=en" class="italic blue_txt underline">online form</a> before arrival (we strongly recommend using a
                        mobile phone for the best experience, as the desktop version may ask you to download a security
                        plug-in which is likely to be blocked by your computer network). The Korean government will strive
                        to encourage foreign nationals with short-term stay visas who enter the country for tourism or other
                        reasons to get tested promptly at the airport testing center or other location.
                        <br><br>
                        On arrival at Incheon Airport, you are required to take a PCR test. After taking the test, you can
                        travel straight to your hotel to await the result, which will arrive within 4-6 hours of taking the
                        test. If you do not complete PCR test at the airport, you must complete PCR test at medical center
                        nearby your accommodation. (RAT test is <span class="bold">NOT</span> valid).
                        <!-- *Vaccinated travelers are those  who have been vaccinated 
					with 2 doses of an approved World Health Organization vaccine  between14 to 180 days prior to their arrival or those who have received a booster. -->
                    </p>
                </div>
            </div>
            <div>
                <div class="circle_title">COVID-19 Updates</div>
                <div class="clearfix2">
                    <div class="covid_img type2">

                    </div>
                    <p>
                        As the pandemic stabilizes in Republic of Korea, the Korean government is moving closer to returning
                        to normal life post-pandemic by lifting almost all COVID-19 social distancing rules including the
                        outdoor mask mandate as of May 2.
                        <br><br>
                        According to the Korean government plan, the 7-day quarantine for those who test positive for
                        COVID-19 will be eased from ‘mandatory’ to ‘recommended’ on May 23.
                        <br><br>
                        Korea has reached over 86% of fully vaccinated people, ranking 7th highest among OECD member
                        countries. View the latest vaccination details in Korea <a href="https://covidvax.live/location/kor" class="blue_txt underline" target="_blank">here.</a>
                        <br><br>
                        For the most up-to-date information on entering Korea, please click <a href="http://ncov.mohw.go.kr/en" class="blue_txt underline" target="_blank">here</a> for general
                        COVID-19 updates in Korea and for other useful information please <a href="https://english.visitkorea.or.kr/enu/TRV/TV_ENG_1_COVID.jsp#tab1" class="blue_txt underline" target="_blank">here.</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
<?php
}
?>
<?php include_once('./include/footer.php'); ?>