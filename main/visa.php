<?php
include_once('./include/head.php');
include_once('./include/header.php');
?>
<!-- //++++++++++++++++++++++++++ -->
<?php

$sql_during = "SELECT
						IF(NOW() BETWEEN '2022-08-18 17:00:00' AND '2023-11-25 18:00:00', 'Y', 'N') AS yn
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
                    <h2>Visa</h2>
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
    <section class="container visa">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Visa</h2>
                    <div class="color-bar"></div>
                </div>
            </div>
        </div>
        <div class="inner">
            <div>
                <!--1-->
                <div class="circle_title">Ministry of Foreign Affairs</div>
                <div class="details">
                    <p><a href="https://www.mofa.go.kr/eng/index.do" class="s_bold underline">https://www.mofa.go.kr/eng/index.do</a></p>
                </div>
                <!--2-->
                <div class="circle_title">Immigration Bureau</div>
                <div class="details">
                    <p><a href="https://www.immigration.go.kr/immigration_eng/index.do" class="s_bold underline break_all">https://www.immigration.go.kr/immigration_eng/index.do</a>
                    </p>
                    <p>
                        All visitors to Korea must have a valid passport and visa before coming. Visitors from countries
                        that have a special agreement with Korea are exempt from the visa requirement and allowed to stay in
                        Korea without a visa for 30 days or up to 90 days, depending on agreements. For more information,
                        please contact the local Korean consulate or embassy, or visit the official website of the Korean
                        Ministry of Foreign Affairs.
                    </p>
                </div>
                <!--3-->
                <div class="circle_title">Countries under visa exemption agreements</div>
                <div class="details table_wrap">
                    <table class="table left_border_table min800">
                        <thead>
                            <tr>
                                <th>Total</th>
                                <th>Passport Type</th>
                                <th colspan="2">Countries</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="12">103 countries<br>(up to 90 Days unless noticed otherwise)</td>
                                <td>Diplomatic<br>(2 countries)</td>
                                <td colspan="2">Turkmenistan (30 days), Ukraine (90 days)</td>
                            </tr>
                            <tr>
                                <td class="border_left nowrap">Diplomatic & Official <br>(35 countries)</td>
                                <td colspan="2">
                                    Algeria, Argentina, Azerbaijan (30 days), Bangladesh, Belarus, Belize, Benin, Cambodia
                                    (60 days), China (30 days), Cyprus, Croatia, Ecuador (Diplomatic: as needed for work
                                    performance, Official: 3 months), Egypt, Gabon, India, Iran (3 months), Japan (3
                                    months), Kuwait, Laos, Mongolia, Pakistan (3 months), Paraguay, the Philippines
                                    (Unlimited), Uzbekistan (60 days), Uruguay, Vietnam, Moldova (90 days within 180 days),
                                    Tajikistan, Georgia, Myanmar, Bolivia, Kyrgyz (30 days), Armenia, Angola (30 days), Oman
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="8" class="border_left">Diplomatic<br>& Official<br>& Ordinary<br>(66 countries)
                                </td>
                                <td>Asia <br>(4 countries)</td>
                                <td>Malaysia, New Zealand, Singapore, Thailand</td>
                            </tr>
                            <tr>
                                <td class="border_left">America <br>(25 countries)</td>
                                <td>
                                    Antigua and Barbuda, Bahamas, Barbados, Brazil, Chile, Colombia, Commonwealth of
                                    Dominica, Costa Rica, Dominican Republic, El Salvador, Grenada, Guatemala, Haiti,
                                    Jamaica, Mexico, Nicaragua, Panama, Peru, Saint Kitts and Nevis, Saint Lucia, Saint
                                    Vincent and the Grenadines, Suriname, Trinidad and Tobago, Venezuela
                                    (Diplomatic/Official: 30 days, Ordinary: 90 days), Uruguay
                                </td>
                            </tr>
                            <tr>
                                <td class="border_left" rowspan="2">Europe <br>(32 countries)</td>
                                <td>
                                    [Schengen countries (except for Slovenia out of the 26 Schengen countries)], Austria
                                    (Diplomatic/Official: 180 days), Belgium, Czech Republic, France, Germany, Greece,
                                    Hungary, Italy, Liechtenstein, Lithuania, Latvia, Luxemburg, Malta, Netherlands, Poland,
                                    Portugal (60days), Slovakia, Spain, Switzerland ※ Denmark, Estonia, Finland, Iceland,
                                    Norway, Sweden (90 days within 180 days)
                                </td>
                            </tr>
                            <tr>
                                <td class="border_left">
                                    [Non-Schengen countries] Bulgaria, Ireland, Romania, Turkey, UK, Kazakhstan ※ Russia (60
                                    days in a row, not exceeding 90 days within 180 days)
                                </td>
                            </tr>
                            <tr>
                                <td class="border_left nowrap">Africa & Middle East <br>(5 countries)</td>
                                <td>Israel, Liberia, Morocco, Tunisia (30 days), Lesotho (60 days)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
<?php
}
?>
<?php include_once('./include/footer.php'); ?>