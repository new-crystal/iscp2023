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
                <h2>Transportation</h2>
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
<section class="container transportation">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Transportation</h2>
                <div class="color-bar"></div>
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="details_info_wrap">
            <div class="clearfix2">
                <!--
                            <div class="img_wrap">
                                <img src="./img/contact_05.svg" alt="비행기">
                            </div> -->
                <div class="info" style="float: none;">
                    <div class="circle_title">Airport ▶ CONRAD Seoul Hotel, Korea</div>
                    <!--(1)-->
                    <div class="airplane_cont">
                        <h5 class="sub_title">By Bus <span>(No. 6019 / Airport Bus)</span></h5>
                        <div class="table_wrap detail_table_common x_scroll">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Board</th>
                                        <td>Terminal 1 : Arrival Gate 6B-1 (1F) / Terminal 2 : Arrival Gate 27 (B1)</td>
                                    </tr>
                                    <tr>
                                        <th>Travel Time</th>
                                        <td>
                                            - Approx. 70mins (20mins from Terminal 2 to 1)
                                            <br>
                                            - Time : 6:45 am – 22:45 pm / Allocation : every 50 mins
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Fare</th>
                                        <td>KRW 17,000
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bus Stop</th>
                                        <td>Marriott Hotel (Yeouido Station)</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>
                                            Advance ticket purchase is required before boarding the bus.<br>
                                            - Location of airport ticket counter. Terminal 1 Gate 6~13 (1F) / Terminal 2
                                            : Eastside B1<br>
                                            - K-Limousine Website : <a href="http://www.klimousine.com/eng/main"
                                                target="_blank" class="link">www.klimousine.com</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--(2)-->
                    <div class="airplane_cont">
                        <h5 class="sub_title">By Subway</h5>
                        <p class="content">
                            The Airport Railroad Express (AREX) provides transportation services that connect Incheon
                            International Airport and Gimpo Airport. Passengers arriving at Gimpo Airport have the
                            option to transfer to Subway Line 9 for further transportation. You can take the AREX
                            (Airport Railroad Express) at the Incheon Airport Transportation Center.
                        </p>
                        <div class="table_wrap detail_table_common x_scroll">
                            <table class="table type1">
                                <thead>
                                    <tr>
                                        <th>Route</th>
                                        <th>Traveling Time</th>
                                        <th>Fare</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img class="venue_airplane" src="./img/venue_airplane1.svg" alt=""></td>
                                        <td>Approx. T2: 78 min <br>Approx. T1: 70 min</td>
                                        <td>T2: KRW 4,750 <br>T1: KRW 4,150</td>
                                        <td>
                                            Take Airport Railroad (AREX) from Incheon<br>airport Terminal 1
                                            or 2(bound for Gongdeok<br>Station) then Transfer to subway Line
                                            #5 at<br>Gongdeok Station (bound for Banghwa station)<br> → take
                                            off at Yeouido Station
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img class="venue_airplane" src="./img/venue_airplane2.svg" alt=""></td>
                                        <td>Approx. T2: 78 min <br>Approx. T1: 70 min</td>
                                        <td>T2: KRW 4,550 <br>T1: KRW 4,050</td>
                                        <td>
                                            From Gimpo Airport (approximately 18 min):<br>Take the Subway
                                            express line #9 at Gimpo<br>International Airport station Get
                                            off at Yeouido<br>station which provides direct access to
                                            Conrad<br>Seoul
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img class="venue_airplane" src="./img/venue_airplane3.svg" alt=""></td>
                                        <td>19 min (6 line Express) <br>T1: 26 min(5 line)</td>
                                        <td>KRW 1,350</td>
                                        <td>Yeouido Stn. (exit #3) is 10 min <br>walking distance away from
                                            Hotel</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--(3)-->
                    <div class="airplane_cont">
                        <!-- <h5>By Taxi<span>(Incheon Airport ▶ Conrad Seoul Hotel)</span></h5> -->
                        <h5 class="sub_title">By Taxi</h5>
                        <p class="content">
                            Taxi services are always available and the fare from Incheon International Airport to the
                            Venue(Conrad Seoul) is approximately KRW 55,000 for a standard taxi. Expressway fee(KRW
                            7,100 each way) will be added to the total fare. The rides take about 40-50 minutes,
                            however, it may vary depending on traffic conditions. There is an additional fee for taxi
                            rides taken between midnight and 4:00 am, resulting in an approximate 20% increase in the
                            fare.
                        </p>
                        <div class="table_wrap detail_table_common x_scroll">
                            <table class="table type2">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Type</th>
                                        <th rowspan="2">Base Fare (KRW)</th>
                                        <th colspan="2">Stop Location</th>
                                        <th rowspan="2">Remarks</th>
                                    </tr>
                                    <tr>
                                        <th style="border-left: 1px solid #003366;">Terminal 1</th>
                                        <th>Terminal 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Standard Taxi</td>
                                        <td>3,800</td>
                                        <td>5C, 6C, 6D</td>
                                        <td>5C</td>
                                        <td>24:00 - 04:00 additional late-night charge 20%</td>
                                    </tr>
                                    <tr>
                                        <td>First-Class / Oversized Taxi<br>(Up to 9 passengers)</td>
                                        <td>6,500</td>
                                        <td>7C/8C</td>
                                        <td>5D</td>
                                        <td>No late-night surcharge or timed fare</td>
                                    </tr>
                                    <tr>
                                        <td>International Taxi</td>
                                        <td>Standard Seoul's<br>distance fare applies</td>
                                        <td>4C</td>
                                        <td>1C</td>
                                        <td>
                                            Taxis officially designated to provide foreign<br>
                                            language service<br>
                                            For reservation: <a href="http://www.intltaxi.co.kr" target="_blank"
                                                class="link">www.intltaxi.co.kr</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="taxi_text_area content">
                            For more information on each mode of transportation and the related services, please visit
                            the websites below.
                            <div>
                                -
                                <a href="https://www.airport.kr/ap/en/index.do" target="_blank" class="link">Incheon
                                    International Airport(click!) </a>
                                /
                                <a href="https://www.airport.co.kr/gimpoeng/index.do" target="_blank" class="link">Gimpo
                                    International Airport(click!)</a>
                            </div>
                        </div>
                    </div>
                    <!--(3) end-->
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
?>

<?php include_once('./include/footer.php'); ?>