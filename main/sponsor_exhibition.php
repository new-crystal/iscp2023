<?php
include_once('./include/head.php');
include_once('./include/header.php');
//++++++++++++++++++++++++++++++++++++++++
$sql_during = "SELECT
						IF(NOW() BETWEEN '2022-08-18 17:00:00' AND '2022-09-06 18:00:00', 'Y', 'N') AS yn
					FROM info_event";
$during_yn = sql_fetch($sql_during)['yn'];

//할인 가격 끝 여부
$sql_during =    "SELECT
						IF(NOW() >= '2022-07-28 09:00:00', 'Y', 'N') AS yn
					FROM info_event";
$r_during_yn = sql_fetch($sql_during)['yn'];

if ($_SESSION['USER']['idx'] == 336) {
    $during_yn = 'Y';
}

if ($during_yn !== "Y") {
?>

    <section class="container submit_application registration_closed">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Exhibition</h2>
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
    //++++++++++++++++++++++++++++++++++++++
    $sql_info =    "SELECT
					welcome_msg_" . $language . " AS welcome_msg,
					important_dates_" . $language . " AS important_dates,
					how_to_apply_" . $language . " AS how_to_apply,
					procedure_" . $language . " AS `procedure`,
					contact_info_" . $language . " AS contact_info,
					isp.contact_for_sponsorship, 
					CONCAT(fi_sod.path, '/', fi_sod.save_name) AS fi_sod_url,
					CONCAT(fi_bl.path, '/', fi_bl.save_name) AS fi_bl_url,
					CONCAT(fi_cob.path, '/', fi_cob.save_name) AS fi_cob_url
				FROM info_sponsorship AS isp
				LEFT JOIN `file` AS fi_sod
					ON fi_sod.idx = isp.sponsorship_official_docs
				LEFT JOIN `file` AS fi_bl
					ON fi_bl.idx = isp.business_license
				LEFT JOIN `file` AS fi_cob
					ON fi_cob.idx = isp.copy_of_bankbook";
    $info = sql_fetch($sql_info);
?>
    <section class="container sponsor_exhibition sub_page">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Exhibition</h2>
                    <ul class="clearfix">
                        <li>Home</li>
                        <li>Sponsorship</li>
                        <li>Exhibition</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner">
            <div class="exhibition_wrap clearfix2">
                <div>
                    <img src="./img/sponsor/exhibition_3f.png" alt="">
                </div>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Booth No.</th>
                                <th>Grade</th>
                                <th class="leftT">Company Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="platinum_prev">1~6</td>
                                <td rowspan="3" class="platinum_bg">Platinum</td>
                                <td>Organon Korea</td>
                            </tr>
                            <tr>
                                <td class="platinum_prev">7~12</td>
                                <td>DAEWOONG PHARMACEUTICAL CO.,LTD</td>
                            </tr>
                            <tr>
                                <td class="platinum_prev">13~18</td>
                                <td>JW Pharmaceutical</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">19~20</td>
                                <td class="bronze_bg">Bronze</td>
                                <td>Korea United Pharm. INC.</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">21~24</td>
                                <td rowspan="3" class="gold_bg">Gold</td>
                                <td>Inno.N</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">25~28</td>
                                <td>Chong Kun Dang Pharm.</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">29~32</td>
                                <td>Viatris Korea</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="exhibition_wrap clearfix2">
                <div>
                    <img src="./img/sponsor/exhibition_5f.png" alt="">
                </div>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Booth No.</th>
                                <th>Grade</th>
                                <th class="leftT">Company Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="exhibition_prev">1</td>
                                <td class="exhibition_bg">Exhibitor</td>
                                <td>Novo Nordisk</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">2~5</td>
                                <td rowspan="6" class="gold_bg">Gold</td>
                                <td>Hanmi Pharmaceutical</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">6~9</td>
                                <td>Boehringer Ingelheim Korea / Lilly Korea</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">10~13</td>
                                <td>Yuhan Corporation</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">14~17</td>
                                <td>Amgen Korea</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">18~21</td>
                                <td>Sanofi Aventis Korea</td>
                            </tr>
                            <tr>
                                <td class="gold_prev">22~25</td>
                                <td>Celltrion Pharm</td>
                            </tr>
                            <tr>
                                <td class="exhibition_prev">26</td>
                                <td class="exhibition_bg">Exhibitor</td>
                                <td>Ahngook Pharm.</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">27~28</td>
                                <td class="bronze_bg" rowspan="5">Bronze</td>
                                <td>Ildong Pharmaceutical Co.,Ltd</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">29~30</td>
                                <td>YooYoung Phamaceutical Co., Ltd</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">31~32</td>
                                <td>Abbott Korea Ltd.</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">33~34</td>
                                <td>Dong-A ST</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">35~36</td>
                                <td>Daewon Pharm</td>
                            </tr>
                            <tr>
                                <td class="exhibition_prev">37</td>
                                <td class="exhibition_bg" rowspan="2">Exhibitor</td>
                                <td>SERVIER KOREA LTD.</td>
                            </tr>
                            <tr>
                                <td class="exhibition_prev">38</td>
                                <td>Handok</td>
                            </tr>
                            <tr>
                                <td class="silver_prev">39~41</td>
                                <td class="silver_bg" rowspan="5">Silver</td>
                                <td>AstraZeneca</td>
                            </tr>
                            <tr>
                                <td class="silver_prev">42~44</td>
                                <td>LG Chem</td>
                            </tr>
                            <tr>
                                <td class="silver_prev">45~47</td>
                                <td>Boryung Pharmaceutical Company</td>
                            </tr>
                            <tr>
                                <td class="silver_prev">48~50</td>
                                <td>DIICHI SANKYO Korea</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="exhibition_wrap clearfix2">
                <div>
                    <img src="./img/sponsor/exhibition_6f4.svg" alt="">
                </div>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Booth No.</th>
                                <th>Grade</th>
                                <th class="leftT">Company Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bronze_prev">1~2</td>
                                <td class="bronze_bg" rowspan="6">Bronze</td>
                                <td>Novartis Korea</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">3~4</td>
                                <td>Samjin pharm Co., Ltd</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">5~6</td>
                                <td>GC Biopharma</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">7~8</td>
                                <td>HANLIM PHARM.CO.LTD.</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">9~10</td>
                                <td>Pfizer Korea</td>
                            </tr>
                            <tr>
                                <td class="bronze_prev">11~12</td>
                                <td>Korea Otsuka Pharmaceutical Co., Ltd.</td>
                            </tr>
                            <!-- <tr> -->
                            <!-- 	<td class="exhibition_prev">13</td> -->
                            <!-- 	<td class="exhibition_bg">Exhibitor</td> -->
                            <!-- 	<td>Handok</td> -->
                            <!-- </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <button type="button" class="fixed_btn" onclick="javascript:window.location.href='./application.php';"><?= $locale("apply_btn") ?></button> -->
    </section>
<?php
}
?>



<?php include_once('./include/footer.php'); ?>