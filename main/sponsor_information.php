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
                    <h2>Sponsors</h2>
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
    <section class="container sponsor_information sub_page">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Sponsors</h2>
                    <ul class="clearfix">
                        <li>Home</li>
                        <li>Sponsorship</li>
                        <li>Sponsors</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner">
            <div>
                <div class="title_bar platinum">Platinum Sponsors</div>
                <ul>
                    <li><a target="_blank" href="https://www.organon.com/"><img src="./img/sponsor/login_sponsor02.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.jw-pharma.co.kr/pharma/en/main.jsp"><img src="./img/sponsor/login_sponsor03.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.daewoong.co.kr/en/main/index"><img src="./img/sponsor/login_sponsor01.png" alt=""></a></li>
                </ul>
            </div>
            <div>
                <div class="title_bar gold">Gold Sponsors</div>
                <ul>
                    <li><a target="_blank" href="https://www.hanmipharm.com/ehanmi/handler/Home-Start"><img src="./img/sponsor/gold01.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.sanofi.com/en"><img src="./img/sponsor/gold02.png" alt=""></a>
                    </li>
                    <li><a target="_blank" href="https://www.amgen.co.kr/en"><img src="./img/sponsor/gold03.png" alt=""></a>
                    </li>
                    <li><a target="_blank" href="http://eng.yuhan.co.kr/Main/"><img src="./img/sponsor/gold04.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.viatris.com/en"><img src="./img/sponsor/gold05.png" alt=""></a>
                    </li>
                    <li><a target="_blank" href="http://www.ckdpharm.com/en/home"><img src="./img/sponsor/gold06.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.boehringer-ingelheim.com/"><img src="./img/sponsor/gold07.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.lilly.com/"><img src="./img/sponsor/gold08.png" alt=""></a>
                    </li>
                    <li><a target="_blank" href="https://www.celltrionph.com/en-us/home/index"><img src="./img/sponsor/gold09_2.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.inno-n.com/eng/"><img src="./img/sponsor/gold10.png" alt=""></a></li>
                </ul>
            </div>
            <div>
                <div class="title_bar silver">Silver Sponsors</div>
                <ul>
                    <li><a target="_blank" href="https://www.lgchem.com/main/index"><img src="./img/sponsor/silver01.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.astrazeneca.com/"><img src="./img/sponsor/silver02.png" alt=""></a></li>
                    <li><a target="_blank" href="https://daiichisankyo.us/"><img src="./img/sponsor/silver03.png" alt=""></a></li>
                    <li><a target="_blank" href="https://pharm.boryung.co.kr/eng/index.do"><img src="./img/sponsor/silver04.png" alt=""></a></li>
                </ul>
            </div>
            <div>
                <div class="title_bar bronze">Bronze Sponsors</div>
                <ul>
                    <li><a target="_blank" href="https://www.novartis.com/about"><img src="./img/sponsor/bronze01.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.otsuka.co.kr/introduction_en"><img src="./img/sponsor/bronze02.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.ildong.com/eng/main/main.id"><img src="./img/sponsor/bronze03_1.png" alt=""></a></li>
                    <!-- <li><a target="_blank" href="https://www.ildong.com/eng/main/main.id"><img src="./img/sponsor/bronze03.png" alt=""></a></li> -->
                    <li><a target="_blank" href="https://www.daewonpharm.com/eng/main/index.jsp"><img src="./img/sponsor/bronze04.png" alt=""></a></li>
                    <li><a target="_blank" href="http://en.donga-st.com/Main.da"><img src="./img/sponsor/bronze05.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.kup.co.kr/"><img src="./img/sponsor/bronze06.png" alt=""></a>
                    </li>
                    <li><a target="_blank" href="https://eng.yypharm.co.kr/main"><img src="./img/sponsor/bronze07.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.abbott.com/"><img src="./img/sponsor/bronze08.png" alt=""></a>
                    </li>
                    <li><a target="_blank" href="https://www.samjinpharm.co.kr/front/en/main/index.asp"><img src="./img/sponsor/bronze09.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.hanlim.com:49324/eng/"><img src="./img/sponsor/bronze10.png" alt=""></a></li>
                    <li><a target="_blank" href="http://www.gcbiopharma.com/eng/index.do"><img src="./img/sponsor/bronze11.png" alt=""></a></li>
                    <li><a target="_blank" href="https://www.pfizer.com/"><img src="./img/sponsor/bronze12.png" alt=""></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <button type="button" class="fixed_btn" onclick="javascript:window.location.href='./application.php';"><?= $locale("apply_btn") ?></button> -->
    </section>
<?php
}
?>


<?php include_once('./include/footer.php'); ?>