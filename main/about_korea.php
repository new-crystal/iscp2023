<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
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
                    <h2>About Korea</h2>
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
    <section class="container about_korea">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>About Korea</h2>
                    <ul>
                        <li>Home</li>
                        <li>General Information</li>
                        <li>About Korea</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner">
            <div>
                <div class="circle_title">About Korea</div>
                <table class="table">
                    <colgroup>
                        <col class="col_th">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>Country Name</th>
                            <td>Republic of Korea (South Korea)</td>
                        </tr>
                        <tr>
                            <th>Capital City</th>
                            <td>Seoul (population: 10.2 million as of 2016)</td>
                        </tr>
                        <tr>
                            <th>Size</th>
                            <td>1,012km from north to south and 165km from east to west</td>
                        </tr>
                        <tr>
                            <th>National Flag</th>
                            <td>Taegeukgi</td>
                        </tr>
                        <tr>
                            <th>Language</th>
                            <td>Korean (writing system: Hangeul)</td>
                        </tr>
                        <tr>
                            <th>Country Dialing Code</th>
                            <td>+82</td>
                        </tr>
                        <tr>
                            <th>National Flower</th>
                            <td>Mugunghwa</td>
                        </tr>
                        <tr>
                            <th>Population</th>
                            <td>51 million (July 2015)</td>
                        </tr>
                        <tr>
                            <th>Time Zone</th>
                            <td>GMT +9 (Korean Standard Time KST)</td>
                        </tr>
                    </tbody>
                </table>
                <p>
                    The Korean peninsula is located in North-East Asia. It is surrounded by the ocean on three sides, making
                    it a unique geographical location. With Seoul as its capital city, the landsite is roughly 1,030 km (612
                    miles) long and 175 km (105 miles) wide at its narrowest point. Korea’s total land area is 100,033
                    square km, neighboring Japan to the east, China to the west, and sharing a northern border with
                    Democratic People’s Republic of Korea (North Korea).
                </p>
            </div>
            <div>
                <!-- <div class="circle_title">About Korea</div> -->
                <ul class="useful_list">
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p><strong>National Flag : </strong>Taegeukgi</p>
                            <ul>
                                <li>
                                    Its design symbolizes the principles of the yin and yang in oriental philosophy. The
                                    circle in the center is divided into two equal parts, where the upper red responds to
                                    the active cosmic forces of the yang; conversely, the lower blue section represents the
                                    passive cosmic forces of the yin. The flag's background is white, representing Korean’s
                                    desire for peace and purity. The circle is surrounded by four trigrams, one in each
                                    corner, characterizing continual movement, balance and harmony. Each trigram symbolizes
                                    one of the four universal elements (heaven, earth, fire, and water).
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p><strong>National Flower : </strong>Mugunghwa</p>
                            <ul>
                                <li>
                                    The national flower of Korea is mugunghwa, or rose of Sharon, which comes into bloom
                                    from July to October every year. Profusions of the blossom gracefully decorate the
                                    entire nation during that time, providing a view which has been loved by all Korean for
                                    many years. It is also favorite plant of the people as the flower’s symbolic
                                    significance stems from the Korean word ‘mugung’, meaning immortality. This word
                                    accurately reflects the enduring nature of Korean culture, and the determination and
                                    perseverance of the Korean people.
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p><strong>National Anthem : </strong>Aegukga</p>
                            <ul>
                                <li>
                                    Aegukga literally means 'a song expressing one’s love towards their country' in Korean,
                                    and that was the exact reason this anthem came to be born. Since its creation, the song
                                    has undergone several versions of transition; however, it remained focused on praising
                                    the sense of loyalty to the country. Maestro Ahn Eak-tai (1905-1965) is credited with
                                    having made the present form of the song in 1935, which was then adopted by the Korean
                                    Government (1948) officially as the national anthem and began to be used at all schools
                                    and official functions.
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
<?php
}
?>


<?php include_once('./include/footer.php'); ?>