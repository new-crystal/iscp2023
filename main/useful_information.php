<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>
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
                    <h2>Useful Information</h2>
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
    <section class="container useful_information">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Useful Information</h2>
                    <div class="color-bar"></div>
                    <!-- <ul class="clearfix">
                        <li>Home</li>
                        <li>General Information</li>
                        <li>Useful Information</li>
                    </ul> -->
                </div>
            </div>
        </div>
        <div class="inner">
            <div>
                <div class="circle_title">
                    Useful Information
                </div>
                <ul class="useful_list">
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Business Hours</p>
                            <ul>
                                <li>Government office hours are usually from 9:00 am to 6:00 pm on weekdays and closed on
                                    weekends.</li>
                                <li>Banks are open from 9:00 am to 4:00 pm on weekdays and closed on Saturdays and Sundays.
                                </li>
                                <li>Major stores are open every day from 10:30 am to 8:00 pm including Sundays.</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Climate</p>
                            <ul>
                                <li>Four distinct seasons in Korea :</li>
                                <li>Spring (March - May)</li>
                                <li>Summer (June - August)</li>
                                <li>Autumn (September - November)</li>
                                <li>Winter (December - February)</li>
                                <li>The temperature in Seoul in September is approximately between 19-24 ℃ degrees.</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Currency</p>
                            <ul>
                                <li>The unit of the Korean currency is the Won (₩). Coin denominations are ₩10, ₩50, ₩100
                                    and ₩500.</li>
                                <li>Banknotes are ₩1,000, ₩5,000, ₩10,000 and ₩50,000.</li>
                                <li>The exchange rate is approximately US $1 to KR 1,230 as of April 2022.</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Electricity</p>
                            <ul>
                                <li>In Korea, 220 volt outlets are most common. Some hotels provide 110 volt outlets for
                                    shavers.</li>
                                <li>Please check the power supply before use.</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Emergency Dial Number</p>
                            <ul>
                                <li><span class="bold">119 :</span> Emergencies for fire, rescue & hospital services</li>
                                <li><span class="bold">112 :</span> Police</li>
                                <!-- <li><span class="bold">1339 :</span> Medical emergency</li> -->
                                <!-- <li><span class="bold">129 :</span> First aid services</li> -->
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Passport and Visa</p>
                            <ul>
                                <li>A valid passport and Korean Visa are needed for all visitors to the Republic Korea.</li>
                                <li>Exemption: Visitors with round-trip tickets from countries that have a special agreement
                                    with Korea can stay in Korea up to 30 days or 90 days depending on the type of agreement
                                    between the two countries.</li>
                                <li>For more information: <a href="http://www.mofa.go.kr" target="_blank">http://www.mofa.go.kr</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Time Difference</p>
                            <ul>
                                <li>Korean Standard Time : UTC/GMT +9 hours (Daylight saving time is not applied in Korea.)
                                </li>
                                <li>Current time in Korea: <a href="http://www.worldtimeserver.com" target="_blank">http://www.worldtimeserver.com</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>VAT</p>
                            <ul>
                                <li>Value-Added Tax (VAT) is levied on most goods and services at a standard rate of 10% and
                                    is included in the retail price.</li>
                                <li>In tourist hotels, this 10% tax applies to rooms, meals and other services and is
                                    included in the bill.</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="imgs"></div>
                        <div>
                            <p>Useful Website</p>
                            <ul>
                                <li>- Gateway to Korea : <a href="http://www.korea.net" target="_blank">http://www.korea.net</a></li>
                                <li>- Korea Immigration Service : <a href="http://www.immigration.go.kr" target="_blank">http://www.immigration.go.kr</a></li>
                                <li>- Ministry of Foreign Affairs : <a href="http://www.mofa.go.kr" target="_blank">http://www.mofa.go.kr</a></li>
                                <li>- Korea Tourism Organization : <a href="http://www.visitkorea.or.kr" target="_blank">http://www.visitkorea.or.kr</a></li>
                                <li>- Visit Seoul : <a href="http://english.visitseoul.net" target="_blank">http://english.visitseoul.net/m</a></li>
                                <li>- Incheon International Airport : <a href="http://www.airport.kr" target="_blank">http://www.airport.kr</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <script>
        $('.useful_information_slider').slick({
            dots: false,
            infinite: true,
            slidesToShow: 1
        });
    </script>
<?php
}

?>
<?php include_once('./include/footer.php'); ?>