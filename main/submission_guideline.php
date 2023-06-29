<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
<!-- //++++++++++++++++++++++++++ -->
<?php

$sql_during = "SELECT
						IF(NOW() BETWEEN '2023-08-18 17:00:00' AND '2023-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//할인 가격 끝 여부
$sql_during =    "SELECT
						IF(NOW() >= '2023-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

//특정 회원 가격 변동 이후 삭제
//if($registration_idx == 512) {
//	$r_during_yn = 'N';
//}

if ($_SESSION['USER']['idx'] == 336) {
    $during_yn = 'Y';
}

if ($during_yn === "Y") {
?>

<section class="container submit_application registration_closed">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Abstract Submission Guideline</h2>
                <div class="color-bar"></div>
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
<section class="container guideline submission_guideline top_btn_move">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Abstract Submission Guideline</h2>
                <div class="color-bar"></div>
                <!-- <ul>
						<li>Home</li>
						<li>Call for Abstracts</li>
						<li>Abstract Submission</li>
						<li>Abstract Submission Guideline</li>
					</ul> -->
            </div>
        </div>
    </div>
    <div class="inner">

        <div class="section section1">
            <!-- contents1 -->
            <!-- <div class="circle_title">For Oral / Poster</div> -->
            <div class="details">
                <div class="mb50">

                    <h1 class="abstract_title">Abstract Submission Guideline</h1>
                    <!-- <p>We welcome the submission of abstracts from worldwide experts in Lipid and Atherosclerosis.</p> -->
                    <p>All congress abstracts must be submitted online via the "Online Submission System."</p>
                    <p>Submitted abstracts will be reviewed by the Scientific Program Committee.</p>
                    <p>All presenters are required to register and pay the registration fee.</p>
                    <p style="font-weight: 700;color: #990000;">Please read the guidelines carefully before submitting
                        your abstract.</p>

                </div>
                <div class="centerT">
                    <!-- <a href="javascript:;" class="btn_oval_line" target="_blank">Abstract Submission Form Download</a> -->
                </div>
            </div>

            <div class="guide_red_box" style="cursor: pointer;"><a href="./abstract_submission.php">Abstract
                    Submission </a>
            </div>

            <!-- contents2 -->
            <div class="circle_title" id="scroll">Key dates</div>
            <div class="details submission_keydate">
                <div class="abstract_yellow">
                    <p>Abstract submission deadline</p>
                    <h1>September 5 (Tue)</h1>
                </div>
                <div class="abstract_sky">
                    <p>Notification of acceptance</p>
                    <h1>October 6 (FRI)</h1>
                </div>
                <div class="abstract_blue">
                    <p>Registration deadlines for presenters<br />
                        of accepted abstracts</p>
                    <h1>November 3 (Fri)</h1>
                </div>
            </div>
            <!-- contents3 -->
            <div class="circle_title">Steps for Abstract Submission</div>
            <div class="details step_gradation">
                <div class="step_container">
                    <div class="step_1">
                        <div class="circle_step">
                            <p>STEP</p>
                            <span>01</span>
                        </div>
                        <p>Click the Abstract <br>Submission Button <br>(Bottom right corner<br> of the page)</p>
                    </div>
                    <div class="step_2">
                        <div class="circle_step">
                            <p>STEP</p>
                            <span>02</span>
                        </div>
                        <p>Log-in (If you don’t<br> have an account,<br>please sign up first)</p>
                    </div>
                    <div class="step_3">
                        <div class="circle_step">
                            <p>STEP</p>
                            <span>03</span>
                        </div>
                        <p>Fill out personal<br> information and <br>author information. <br>Then click the Next
                            <br>button
                        </p>
                    </div>
                    <div class="step_4">
                        <div class="circle_step">
                            <p>STEP</p>
                            <span>04</span>
                        </div>
                        <p>Fill out the abstract <br>section.</p>
                    </div>
                    <div class="step_5">
                        <div class="circle_step">
                            <p>STEP</p>
                            <span>05</span>
                        </div>
                        <p>Completed</p>
                    </div>
                </div>
            </div>
            <!-- contents4 -->
            <div class="circle_title">Topic Categories</div>
            <div class="details table_wrap">
                <table class="table wide_table">
                    <colgroup>
                        <col class="col_th">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td>
                                <div class="table_num" style="transform: translate(-5px, -18px);">01</div>
                                <p>Ischemic heart disease/ <br>coronary artery disease</p>
                            </td>
                            <td>
                                <div class="table_num">02</div>
                                <p>Anti-platelets and anticoagulation</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="table_num">03</div>
                                <p>Heart failure with reduced ejection fraction and
                                    preserved
                                    ejection fraction</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="table_num">04</div>
                                <p>Cardiomyopathies</p>
                            </td>
                            <td>
                                <div class="table_num">05</div>
                                <p>Cardio-renal syndromes</p>
                        </tr>
                        </tr>
                        <tr>
                            <td>
                                <div class="table_num">06</div>
                                <p>Preventive Cardiology</p>
                            </td>
                            <td>
                                <div class="table_num">07</div>
                                <p>Cardiac arrhythmias</p>
                            </td>
                            <!-- <td></td> -->
                        </tr>
                        <tr>
                            <td>
                                <div class="table_num">08</div>
                                <p>Peripheral arterial disease</p>
                            </td>
                            <td>
                                <div class="table_num">09</div>
                                <p>Pulmonary hypertension</p>
                            </td>
                            <!-- <td></td> -->
                        </tr>

                        <tr>
                            <td>
                                <div class="table_num">10</div>
                                <p>Geriatric pharmacology</p>
                            </td>
                            <td>
                                <div class="table_num">11</div>
                                <p>Women’s Heart Health</p>
                            </td>
                            <!-- <td></td> -->
                        </tr>

                        <tr>
                            <td>
                                <div class="table_num">12</div>
                                <p>Basic science and genetics</p>
                            </td>
                            <td>
                                <div style="transform: translate(-5px, -18px);" class="table_num">13</div>
                                <p>COVID-19 related <br>cardio-pharmacotherapy</p>
                            </td>
                            <!-- <td></td> -->
                        </tr>

                        <tr>
                            <td>
                                <div class="table_num">14</div>
                                <p>Diabetes & Obesity</p>
                            </td>
                            <td>
                                <div class="table_num">15</div>
                                <p>Hyperlipidemia and CVD</p>
                            </td>
                            <!-- <td></td> -->
                        </tr>

                        <tr>
                            <td>
                                <div class="table_num">16</div>
                                <p>Epidemiology</p>
                            </td>
                            <td>
                                <div class="table_num">17</div>
                                <p>Precision medicine/ Digital healthcare</p>
                            </td>
                            <!-- <td></td> -->
                        </tr>


                    </tbody>
                </table>
            </div>
            <!-- contents5 -->
            <!-- <div class="circle_title">Instructions</div>
                <div class="details">
                    <ul class="text_indent">
                        <li>• All abstracts must be submitted online.</li>
                        <li>• Faxed or emailed abstracts will not be accepted.</li>
                        <li>• It is important to select the best matching topic category. </li>
                        <li>• Abstracts must be written in clear <b class="mo_b">English</b> and submitted prior to <b class="mo_b">30 June (Thu), 2022</b> (KST midnight). </li>
                        <li>• Abstracts should be no more than 300 words. If the abstracts include 1 or 2 tables, charts,
                            figures, and any other information, each will be counted as 50 words</li> -->
            <!-- <li>• File format is MS word for Windows.</li> -->
            <!-- <li>• Abstracts should be no more than 300 words. 1 or 2 tables, charts, figures and any other information are acceptable as part of the abstract.</li> -->
            <!-- <li>• Authors may further edit and modify submitted abstracts until the submission deadline <b class="mo_b">(30 June, 2022)</b>.</li>
                        <li>• It is the author's responsibility to ensure that their text does not contain typos or
                            grammatical errors.</li>
                        <li>• Authors have the option of choosing their presentation type. But, the presentation type may be
                            changed by the Scientific Program Committee’s consensus.</li> -->
            <!-- <li>• The presentation type may be changed following review by the Scientific Program Committee.</li> -->
            <!-- <li>• The abstract should be objective and concise, including key information in the four sections:
                            Objectives, methods, results, conclusions.</li>
                        <li>• Acknowledgment of your submission will be sent via email. Please make sure that you receive an
                            email confirmation after you submit an abstract.</li>
                        <li>• If you do not receive the email confirmation, it means we have no record on our system. If you
                            are sure you made a submission, please check your submission information on “My Page”. </li>
                        <li>• The presenting author must register for the congress through the website before <b class="mo_b">the deadline for presenter registration.</b></li>
                    </ul>
                </div> -->
            <!-- contents6 -->
            <div class="circle_title">Awards & Grants</div>
            <div class="details">
                <!-- 6-2 -->
                <p class="mb20" style="font-size: 20px; font-weight: 700;">There are several categories of awards and
                    travel grants for a certain
                    number of
                    investigators. </p>
                <div class="awards_box">
                    <img src="./img/awards.png" alt="" style="height: 50px;" />
                    <ul>
                        <li><b>ISCP Awards</b></li>
                        <li>The “ISCP” will award to the selected presenters for the original top rated work during the
                            poster sessions.
                        </li>
                    </ul>
                </div>
                <br>
                <!-- 6-3 -->
                <div class="awards_box">
                    <img src="./img/travel.png" alt="" />
                    <ul>
                        <li><b> Travel grants (for international participants only)
                            </b></li>
                        <li>ISCP 2023 offers travel grants to international participants who have submitted an abstract.
                            The scientific committee will nominate the travel grant recipients.
                            Recipients of travel grants must attend the congress on-site.
                        </li>
                    </ul>
                </div>
                <br>
                <div class="table_wrap">
                    <table class="table wide_table centerT left_border_table travel_table">
                        <thead>
                            <tr>
                                <th colspan="3" class="centerT" style="color: #003366; background-color:#EEF2F5;">
                                    Travel grant
                                    benefits</th>
                            </tr>
                            <tr>
                                <!-- <th class="centerT">Region</th> -->
                                <td class="centerT semi_title">Amount</td>
                                <td class="centerT semi_title">Additional benefits</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- <td>Americas / Europe</td> -->
                                <td>USD 500</td>
                                <td rowspan="4">
                                    To be notified individually before the congress
                                </td>
                            </tr>
                            <!-- <tr>
                                <td>Oceania</td>
                                <td>USD 1,000</td>
                            </tr>
                            <tr>
                                <td>Southeast Asia</td>
                                <td>USD 500</td>
                            </tr>
                            <tr>
                                <td>Northeast Asia</td>
                                <td>USD 400</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <br>
                <!-- <ul class="text_indent"> -->
                <!-- 	<li>• Travel grant applicants must submit abstract(s) online.</li> -->
                <!-- 	<li>• Applicants must be age of under 45 years old.</li> -->
                <!-- </ul> -->
                <br>
                <!-- 6-4 -->
                <!-- <ul class="text_indent">
                    <li><b>◆ APSAVD Young Investigator Awards</b></li>
                    <li>• Applications for APSAVD Young Investigator Presentations (oral) should be invited as part of
                        the abstract submission process.</li>
                    <li>• The highest scoring abstracts from those Young Investigators nominated to give an oral
                        presentation will be selected to present in the Young Investigator Award Session.</li>
                    <li>• Special prizes will be awarded to the best presentations.</li>
                    <li>• Applications for APSAVD Young Investigator Awards are only available for authors who have
                        selected 'APSAVD Young Investigator' in the abstract.</li>
                    <li class="eligibility_open bold pointer">
                        ⓘ Eligibility
                        <div class="eligibility_pop">
                            <div class="pop_bg"></div>
                            <p class="balloon"> 1. The candidate must be an early career scientist/clinician (under 40
                                years of age).</p>
                        </div>
                    </li>
                </ul>
                <br> -->
                <!-- 6-5 -->
                <!-- <ul class="text_indent">
                    <li><b>◆ IAS Asia-Pacific Federation Young Investigator Grants</b></li>
                    <li>• The purpose of the Young Investigator Grant is to stimulate interest in research training by
                        rewarding outstanding examples of excellence amongst those involved in research training in the
                        early stages of their career. </li>
                    <li class="eligibility_open bold pointer">
                        ⓘ Eligibility
                        <div class="eligibility_pop">
                            <div class="pop_bg"></div>
                            <div class="balloon">
                                <p> 1. At the time of the congress, the first author should be under 40 years of age
                                    (copy of documents that prove age should be attached)</p>
                                <p> 2. Applications will only be accepted from outside Korea.</p>
                            </div>
                        </div>
                    </li>
                </ul> -->
                <br>
                <!-- 6-1 -->
                <!-- <ul class="text_indent gap17">
                    <li>※ To apply for Awards & Grants, please tick/check the box of the according Award or Grant on the
                        abstract submission page.</li>
                    <li>※ If the authors submit abstract to ICoLA, the abstract will not be reviewed for by any APSAVD
                        Young Investigator Awards and IAS Asia-Pacific Federation Young Investigator Grants. Also,
                        authors will not be able to submit abstracts to others (APSAVD Awards, IAS Grants).</li>
                </ul> -->
                <br>
            </div>
            <!-- contents7 
			<div class="details mb72">
				<p>
					※ Please note that if you submit your abstract to ISCP 2023, your abstract will not be reviewed for any APSAVD Young Investigator Awards and IAS Asia-Pacific Federation Young Investigator Grants. You will not be able to submit abstracts to others (APSAVD Awards, IAS Grants)
				</p>
			</div>-->
            <!-- contents8 -->
            <!-- <div class="circle_title">Notification of Acceptance</div>
            <div class="details">
                <ul class="text_indent">
                    <li>• All submitted abstracts will be reviewed by the Scientific Program Committee according to the
                        review procedures.</li>
                    <li>• Notification of acceptance will be sent by email to the presenting author, corresponding
                        author and submitter in <b class="mo_b">mid-July, 2022.</b></li>
                </ul>
            </div> -->
            <!-- contents9 -->
            <!-- <div class="circle_title">Withdrawal Policy</div>
            <div class="details">
                <ul class="text_indent">
                    <li>• If the presenting author of an accepted abstract does not register by <b class="mo_b">19
                            August, 2022,</b> the abstract will be automatically withdrawn from the final program.</li>
                    <li>• If you would like to withdraw an abstract, please notify the ISCP 2023 Secretariat as soon as
                        possible.</li>
                </ul>
            </div> -->
        </div>
    </div>
</section>
<?php
}
?>
<!-- 22.04.08 기존버튼 
<button type="button" class="fixed_btn fixed_btn_pc" onclick="window.location.href='./abstract_submission.php';">Abstract Submission</button>-->
<!-- 22.04.08 변경버튼 -->

<!-- <div class="popup eligibility_pop"> -->
<!-- 	<div class="pop_bg"></div> -->
<!-- 	<div class="pop_contents"> -->
<!-- 		<p> 1. The candidate must be an early career scientist/clinician (under 40 years of age).</p> -->
<!-- 	</div> -->
<!-- </div> -->
<!-- <div class="popup eligibility_pop2"> -->
<!-- 	<div class="pop_bg"></div> -->
<!-- 	<div class="pop_contents"> -->
<!-- 		<p> 1. At the time of the congress, the first author should be under 40 years of age (copy of documents that prove age should be attached)</p> -->
<!-- 		<p> 2. Applications will only be accepted from outside Korea.</p> -->
<!-- 	</div> -->
<!-- </div> -->
<!-- <button type="button" class="btn_fixed_triangle fixed_btn_pc"
    onClick="location.href='./abstract_submission.php'"><span>Abstract<br>Submission</span></button> -->

<?php include_once('./include/footer.php'); ?>