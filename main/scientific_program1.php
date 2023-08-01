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
                    <h2>scientific program</h2>
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
    <section class="container program_glance sub_page">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Scientific program</h2>
                    <div class="color-bar"></div>
                    <!--
				<button onclick="javascript:window.location.href='./download/2022_program_glance2.pdf'" class="btn" target="_blank">Program at a Glance Download</button>-->
                    <!-- <a href="./download/ICoLA2022_Program at a Glance.pdf" target="_blank" class="btn" download>Program at a
						Glance Download</a> -->
                </div>
            </div>
        </div>
        <div class="inner">
            <ul class="tab_pager">
                <li class="on"><a href="javascript:;">All Days <br /> November 23~25 </a></li>
                <li><a href="javascript:;">Day1<Br>Thursday, November 23</a></li>
                <li><a href="javascript:;">Day2<Br>Friday, November 24</a></li>
                <li><a href="javascript:;">Day3<Br>Saturday, November 25 </a>
                </li>
            </ul>
            <div class="tab_wrap">
                <div class="tab_cont on">
                    <ul class="program_color_txt">
                        <li>
                            <p>All Days - November 23-25</p>
                        </li>
                        <!-- <div>
                            <li><i></i>&nbsp;:&nbsp;Korean</li>
                            <li><i></i>&nbsp;:&nbsp;English</li>
                        </div> -->
                    </ul>

                    <table class="table program_glance_table" name="1">
                        <colgroup>
                            <col width="7%">
                            <col width="43%">
                            <col width="9%">
                            <col width="41%">
                        </colgroup>
                        <tr style="border: none;">
                            <td colspan="4" style="padding: 0;">
                                <img src="./img/programheader1.png" />
                            </td>
                        </tr>
                        <tr>
                            <td class="table_header">Room
                            </td>

                            <td class=" table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Studio 4
                            </td>
                            <td colspan="2" class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Studio 8+9+10
                            </td>
                        </tr>
                        <tr>
                            <td class="time_bold">15:00-16:40</td>
                            <td style="background-color: #FFF9DE;">Symposium
                                1.<span>Coronary/Atherosclerosis/prevention</span> <br>
                                유승기<span>(이대서울병원 웰니스센터/심혈관클리닉)</span>, 한승환<span>(가천의대)</span>
                            </td>
                            <td class="time_bold">15:00-16:40</td>
                            <td style="background-color: #FFF9DE;">Symposium 2.<span>Lifestyle modiﬁcation for Prevention of
                                    CVD</span> <br>
                                <span>Chairpeson : TBD</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">15:00-15:20</td>
                            <td style="background-color: #FFF9DE;"><span>Anti-inflammatory drug use in ACS patients</span>
                                <br>
                                박훈준<span>(가톨릭의대 순환기내과)</span>
                            </td>
                            <td class="table_time">15:00-15:20</td>
                            <td style="background-color: #FFF9DE;"><span>Healthy dietary patterns in Koreans and</span> <br>
                                <span>their association with cardiovascular diseases</span> <br>
                                송수진<span>(한남대학교 식품영양학과)</span>
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">15:20-15:40</td>
                            <td style="background-color: #FFF9DE;"><span>Differences in risk factors for coronary
                                    atherosclerosis in men & women</span>
                                <br>
                                김미나<span>(고려의대 순환기내과)</span>
                            </td>
                            <td class="table_time">15:20-15:40</td>
                            <td style="background-color: #FFF9DE;"><span>Physical activity - one fits for all</span> <br>

                                양예슬<span>(서울대학교)</span>
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>Optimal duration of antiplatelet agents after
                                    PCI</span>
                                <br>
                                박만원<span>(가톨릭의대)</span>
                            </td>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>Precision Nutrition for prevention of T2DM</span>
                                <br>

                                Frank B. Hu
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>Role of digital health in cardiovascular
                                    disease</span>
                                <br>
                                권준명<span>(세종병원/메디컬에이아이)</span>
                            </td>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>KSCP 진료지침</span>
                                <br>
                                최성희<span>(서울의대 내분비내과)</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">16:20-16:40</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                <br>
                                강태수<span>(단국의대 심장혈관내과)</span>,이종영<sapn>(성균관의대),</sapn><br>
                                송영빈<span>(성균관의대 순환기내과)</span>,오규철<sapn>(가톨릭의대)</sapn>
                            </td>
                            <td class="table_time">16:20-16:40</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                <br>
                                <span>TBD</span>
                            </td>
                        </tr>
                        <td class="time_bold">16:40-17:40</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 1<br>
                            <span>Chairpeson : TBD</span><br>
                            <span>TBD</span>
                        </td>
                        <td class="time_bold">16:40-17:40</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 2<br>
                            <span>Chairpeson : TBD</span><br>
                            <span>TBD</span>
                        </td>
                        </tr>
                        <tr style="border: none;">
                            <td style="padding: 0;" colspan="4">
                                <img src="./img/programheader2.png" />
                            </td>
                        </tr>
                        <tr>
                            <td class="table_header">Room</td>
                            <td class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Grand ballroom 2+3
                            </td>
                            <td colspan="2" class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Park ballroom 1+2+3
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="time_bold">07:30-08:30</td>
                            <td style="background-color: #D9F1FC;">Breakfast Symposium 1</br>
                                <span>Boryung</span>
                            </td>
                            <td rowspan="2" style="background-color: #ddd;"></td>
                            <td rowspan="2" style="background-color: #ddd;"></td>
                        <tr>
                            <td style="border-left: 1px solid #9C9B9B;">TBD</td>
                        </tr>
                        </tr>
                        <tr>
                            <td class="table_time">08:30-09:00</td>
                            <td colspan="3">Registration and Opening Remark</td>
                        </tr>
                        <tr>
                            <td class="time_bold">09:00-10:50</td>
                            <td style="background-color: #FFF9DE;">Symposium 3.<span>Arrhythmia</span> <br>
                                Takanori Ikeda
                                <!-- <span>(Department of Cardiovascular Medicine,<br>Toho University Faculty of
									Medicine, Tokyo, Japan),</span> -->
                                <br>Young Keun ON
                                <!-- <sapn>(성균관의대)</sapn> -->

                            </td>
                            <td class="time_bold">09:00-10:50</td>
                            <td style="background-color: #FFF9DE;">Symposium 4. <span>SGLT-2 inhibitors</span><br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">09:00-09:30</td>
                            <td style="background-color: #FFF9DE;"><span>TBD (suggestion title: antiarrhythmic drugs, atrial
                                    fibrillation, heart failture)</span> <br>
                                Gheorghe Andrei Dan

                            </td>
                            <td class="table_time">09:00-09:30</td>
                            <td style="background-color: #FFF9DE;"><span>Cardiovascular benefits in T2DM: Rediscovery of
                                    mechanism</span> <br>
                                TR Oh
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">09:30-10:00</td>
                            <td style="background-color: #FFF9DE;"><span>TBD (suggestion title: Anticoagulation in
                                    patients<br>with atrial fibrillation and coronary artery disease)</span> <br>
                                Antoni Martínez Rubio

                            </td>
                            <td class="table_time">09:30-10:00</td>
                            <td style="background-color: #FFF9DE;"><span>TBD(suggestion title:SGLT2i-HF)</span> <br>
                                Felipe Martinez
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:00-10:15</td>
                            <td style="background-color: #FFF9DE;"><span>Wrap up! Factor Xa inhibitor</span> <br>
                                JM Lee
                            </td>
                            <td class="table_time">10:00-10:15</td>
                            <td style="background-color: #FFF9DE;"><span>SGLT2 inhibition: the new standard of care in
                                    kidney disease</span> <br>
                                Merlin Thomas
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:15-10:30</td>
                            <td style="background-color: #FFF9DE;"><span>Will DOACs find the role in mitral stenosis and
                                    atrial fibrillation?</span> <br>
                                JY Kim
                            </td>
                            <td class="table_time">10:15-10:30</td>
                            <td style="background-color: #FFF9DE;"><span>Perspectives on the role of SGLT1/2 co-inhibitors
                                    on cardiovascular disease</span> <br>
                                EJ Rhee
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:30-10:50</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                <!-- 김동민<sapn>(단국대),</sapn>임성일<sapn>(고신대),</sapn><br>
								이광노<sapn>(아주대),</sapn>정래영<sapn>(전북대)</sapn> -->
                            </td>
                            <td class="table_time">10:30-10:50</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                <!-- 김대중<sapn>(아주의대 내분비내과),</sapn>최대은<sapn>(충남의대 신장내과),</sapn><br>
								김현진<sapn>(한양의대 순환기내과), </sapn>정찬희<sapn>(순천향의대 내분비내과)</sapn> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:50-11:10</td>
                            <td colspan="3">Coffee break</td>
                        </tr>
                        <tr>
                            <td class="time_bold">11:10~12:00</td>
                            <td colspan="3" style="background-color: #E4DEEF;">Plenary Lecture 1.<span>Henry N. Neufeld
                                    memorial lecture</span><br>
                                DH Kim,CH Lee<br>
                                <br>
                                Marc A. Pfeffer
                            </td>
                        </tr>
                        <tr>
                            <td class="time_bold">12:20-13:30</td>
                            <td style="background-color: #FFE497;">Luncheon Satellite Symposium 1<br><span>Yuhan</span></td>
                            <td class="time_bold">12:20-13:30</td>
                            <td style="background-color: #FFE497;">Luncheon Satellite Symposium 4<br><span>NOVO
                                    NORDISK</span></td>
                        </tr>
                        <tr>
                            <td class="time_bold">13:20-15:00</td>
                            <td style="background-color: #FFF9DE;">Symposium 5.<span>Current trends in optimal</span> <br>
                                <span>medical therapy for post-PCI patients</span><br>CH Lee,</sapn>SW Na

                            </td>
                            <td class="time_bold">13:20-15:00</td>
                            <td style="background-color: #FFF9DE;">Symposium 6. <span>Recent landmark clinical trials in CV
                                    Prevention</span><br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">13:20-13:40</td>
                            <td style="background-color: #FFF9DE;"><span>Antithrombotic therapy after acute coronary
                                    syndrome:<br>
                                    clinical challenges in the older patient</span> <br>
                                Pablo Avanzas
                            </td>
                            <td class="table_time">13:20-13:40</td>
                            <td style="background-color: #FFF9DE;"><span>Lifestyle modification for prevention T2DM</span>
                                <br>
                                S Cheon
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0;" colspan="4">
                                <table class="table program_glance_table" style="border-top: none; width:102%;">
                                    <colgroup>
                                        <col width="7.9%">
                                        <col width="41.8%">
                                        <col width="8.8%">
                                        <col width="44%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td class="table_time">13:40-14:00</td>
                                            <td style="background-color: #FFF9DE;"><span>Evolving approaches to the
                                                    management
                                                    of
                                                    dyslipidemia</span> <br>
                                                Jack Tan
                                            </td>
                                            <td class="table_time">13:40-14:00</td>
                                            <td style="background-color: #FFF9DE;"><span>Early intensive glycemic control in
                                                    T2DM: VERIFY
                                                    study</span> <br>
                                                HS Kwon
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" class="table_time">14:00-14:15</td>
                                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Effect of
                                                    RAS/beta-blockers
                                                    on
                                                    survival in post-PCI
                                                    patients</span> <br>
                                                Alan Fong
                                            </td>
                                            <td rowspan="3" class="table_time">14:00-14:20</td>
                                            <td rowspan="3" style="background-color: #FFF9DE;"><span>The Fibrates Story - Is
                                                    It
                                                    Over
                                                    or Not?</span> <br>
                                                SG Kim
                                            </td>
                                        </tr>
                                        <tr>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" class="table_time">14:15-14:30</td>
                                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Anti-inflammatory
                                                    therapy
                                                    in
                                                    patients with coronary
                                                    atherosclerosis</span> <br>
                                                TBD
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" class="table_time" style="border-left: 1px solid #9C9B9B;">
                                                14:20-14:40</td>
                                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Dulaglutide</span> <br>
                                                CH Jeong
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" class="table_time">14:30-14:45</td>
                                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Biomarkers in
                                                    predicting
                                                    outcomes in patients with
                                                    CAD</span> <br>
                                                Koji Hasegawa
                                            </td>

                                        </tr>
                                        <tr>
                                            <td rowspan="2" class="table_time" style="border-left: 1px solid #9C9B9B;">
                                                14:40-15:00</td>
                                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                                <!-- <br>
												박세은<sapn>(성균관의대 내분비내과),</sapn>김명아<sapn>(TBD),</sapn><br>
												노은<sapn>(한림의대 내분비내과), </sapn>류혜진<sapn>(고려의대 내분비내과),</sapn><br>
												정요한<span>(연세의대 신경과)</span> -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table_time">14:45-15:00</td>
                                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                                <!-- 차정준<sapn>(고려의대 순환기내과),</sapn>조상호<sapn>(한림의대 순환기내과),</sapn><br>
                                            임홍석<sapn>(TBD),</sapn>조정래<sapn>(TBD)</sapn> -->
                                                Margarita Vejar
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>

                        </tr>

                        <tr>
                            <td class="time_bold" class="table_time">15:00-15:40</td>
                            <td colspan="3" style="background-color: #E4DEEF;">Plenary Lecture 2.<span>
                                    Ethnic and Regional
                                    Differences in the Management of Angina: The Way Forward</span><br>
                                <!-- Chairpeson : TBD<br>
								<span>TBD</span><br> -->
                                Thomas Kahan
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">15:40-16:00</td>
                            <td colspan="3">Coffee break</td>
                        </tr>
                        <tr>
                            <td class="time_bold">16:00-17:40</td>
                            <td style="background-color: #FFF9DE;">Symposium 7.<span> Comprehensive management of</span>
                                <br>
                                <span>heart failure patients with comorbidities</span><br>DS Kim, JJ Kim<sapn>
                            </td>
                            <td class="time_bold">16:00-16:20</td>
                            <td style="background-color: #FFF9DE;">Symposium 8. <span>Epidemiology of CVD</span><br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">16:00-16:20</td>
                            <td style="background-color: #FFF9DE;"><span>Current Status of HF management in Korea</span>
                                <br>
                                JC Yoon
                            </td>
                            <td class="table_time">16:00-16:20</td>
                            <td style="background-color: #FFF9DE;"><span>Trends and Challenges in the Epidemiology of CVD in
                                    Korea</span> <br>
                                HC Kim
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">16:20-16:40</td>
                            <td style="background-color: #FFF9DE;"><span>SGLT2i in HF</span>
                                <br>
                                Felipe Martinez
                            </td>
                            <td class="table_time">16:20-16:40</td>
                            <td style="background-color: #FFF9DE;"><span>Age difference, does it exist?</span> <br>
                                JS Yoon
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">16:40-17:00</td>
                            <td style="background-color: #FFF9DE;"><span>ARNi in HF</span>
                                <br>
                                IC Kim
                            </td>
                            <td class="table_time">16:40-17:00</td>
                            <td style="background-color: #FFF9DE;"><span>Sex difference, does it exist?</span> <br>
                                EY Lee
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">17:00-17:20</td>
                            <td style="background-color: #FFF9DE;"><span>Targeted therapy in specific
                                    cardiomyopathies</span>
                                <br>
                                DR Kim
                            </td>
                            <td class="table_time">17:00-17:20</td>
                            <td style="background-color: #FFF9DE;"><span>Socioeconomic disparity</span> <br>
                                YM Park
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">17:20-17:40</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                <!-- 최성훈<sapn>(한림의대 순환기내과),</sapn>조상호<sapn>(한림의대 순환기내과),</sapn><br>
								최진오<sapn>(성균관의대),</sapn>김미나<sapn>(고려의대)</sapn> -->
                            </td>
                            <td class="table_time">17:20-17:40</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                <!-- 김지희<sapn>(가톨릭의대 순환기내과),</sapn>이재혁<sapn>(명지병원 내분비내과),</sapn><br>
								신민호<sapn>(전남의대 예방의학교실), </sapn>안성복<sapn>(이화여대 융합보건학과),</sapn> -->
                            </td>
                        </tr>

                        <tr style="border: none;">
                            <td style="padding: 0;" colspan="4">
                                <img src="./img/programheader3.png" />
                            </td>
                        </tr>
                        <tr>
                            <td class="table_header">Room</td>
                            <td class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Grand ballroom 2+3
                            </td>
                            <td colspan="2" class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Park ballroom 1+2+3
                            </td>
                        </tr>
                        <tr>
                            <td class="time_bold">07:30-08:30</td>
                            <td style="background-color: #D9F1FC;">Breakfast Symposium 2<br><span>JW Pharma</span></td>
                            <td class="time_bold">07:30-08:30</td>
                            <td style="background-color: #D9F1FC;">Breakfast Symposium 3<br><span>Hanmi
                                </span></td>
                        </tr>
                        <tr>
                            <td class="table_time">08:30-08:50</td>
                            <td colspan="3" style="font-weight: normal;">Coffee Break</td>
                        </tr>
                        <tr style="border-bottom: none;">
                            <td style="padding: 0;" colspan="4">
                                <table class="table program_glance_table" style="border-top: none; width:101%;">
                                    <colgroup>
                                        <col width="8%">
                                        <col width="42.2%">
                                        <col width="8.9%">
                                        <col width="44%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td class="time_bold">08:50-10:00</td>
                                            <td style="background-color: #FFF9DE;">Syposium 9.<span> How to maximize eﬀects
                                                    of
                                                    cardiovascular drugs</span><br>
                                                JY Lee, HA Kim
                                            </td>
                            </td>
                            <td class="time_bold">08:50-10:00</td>
                            <td style="background-color: #E6DDD1;">Hot topics in CPP (Editor's session)<br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="table_time">08:50-09:05</td>
                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Pharmacokinetics and Pharmacodynamics
                                    of
                                    Cardiovascular Drug</span><br>
                                HY Ahn
                            </td>
                            <td class="table_time">08:50-09:00</td>
                            <td style="background-color: #E6DDD1;">Public awareness of cardiovascular disease prevention in
                                Korea<br>
                                EJ Kim
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" rowspan="2" style="border-left: 1px solid #9C9B9B;">09:00-09:10</td>
                            <td rowspan="2" style="background-color: #E6DDD1;"><span>Safety and efficacy of low-dose aspirin
                                    in patients
                                    with coronary<br>artery spasm: long-term clinical follow-up</span><br>
                                KH Kim
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" rowspan="2">09:05-09:20</td>
                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Overcome adverse drug reaction of
                                    cardiovascular
                                    drugs</span><br>
                                GY Shon
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" style="border-left: 1px solid #9C9B9B;">09:10-09:20</td>
                            <td style="background-color: #E6DDD1;"><span>Effects of exercise on reducing diabetes risk in
                                    Korean women<br>according to menopausal status</span><br>
                                JH Cho
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" rowspan="2">09:20-09:40</td>
                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Cardiovascular Pharmacist role in
                                    Singapore</span><br>
                                Doreen Tan
                            </td>
                            <td class="table_time">09:20-09:30</td>
                            <td style="background-color: #E6DDD1;">
                                <span>Fabry disease screening in young patients with acute ischemic<br>stroke in
                                    Korea</span><br>
                                TD Oak
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" style="border-left: 1px solid #9C9B9B;">09:30-09:40</td>
                            <td style="background-color: #E6DDD1; "><span>Effect of the
                                    addition of thiazolidinedione to
                                    sodium-glucose<br>cotransporter 2 inhibitor therapy</span><br>
                                TG Park
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">09:40-10:00</td>
                            <td style=" background-color: #FFF9DE;"><span>Panel discussion</span><br>
                                <!-- 이옥상<span>(서울대학교병원)</span>,박소진<span>(삼성서울병원),</span>이지영<span>(국립중앙병원),</span><br>
								Surakit Nathisuwan -->
                                Surakit Nathisuwan<br>
                                Tlongco, Richard Henry II P.
                            </td>
                            <td class="table_time">09:40-10:00</td>
                            <td style="background-color: #E6DDD1;"><span>Panel discussion</span><br><span>TBD</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </td>
                    </tr>

                    <tr>
                        <td class="time_bold">10:00-11:30</td>
                        <td style="background-color: #FFF9DE;">Symposium 10.<span> Hypertension</span>
                            <br>
                            SH Lim, Thomas Kahan

                        </td>
                        <td class="time_bold">10:00-11:30</td>
                        <td style="background-color: #FFF9DE;">Symposium 11. <span>Incretins</span><br>
                            <span>Chairpeson : TBD</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">10:00-10:20</td>
                        <td style="background-color: #FFF9DE;"><span> Low-dose combination of blood pressure-lowering
                                medicines</span>
                            <br>
                            Thomas Kahan

                        </td>
                        <td class="table_time">10:00-10:20</td>
                        <td style="background-color: #FFF9DE;"><span>Semaglutide-CVD</span><br>
                            <span>Prof. Martin Haluzik</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="table_time">10:20-10:40</td>
                        <td style="background-color: #FFF9DE;"><span>Hypertension control based on home blood pressure
                                telemonitoring</span>
                            <br>
                            SH Park

                        </td>
                        <td class="table_time">10:00-10:20</td>
                        <td style="background-color: #FFF9DE;"><span>GLP-1RA and diabetes/obesity</span><br>
                            SM Jim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">10:40-11:00</td>
                        <td style="background-color: #FFF9DE;"><span>Emerging drugs for resistant hypertension</span>
                            <br>
                            HR Kim

                        </td>
                        <td class="table_time">10:40-11:00</td>
                        <td style="background-color: #FFF9DE;"><span>Effects of dual agonist on cardiorenal
                                risk</span><br>
                            NH Kim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">11:00-11:20</td>
                        <td style="background-color: #FFF9DE;"><span>Recent hypertension guidelines in the world</span>
                            <br>
                            HY Lee

                        </td>
                        <td class="table_time">11:00-11:20</td>
                        <td style="background-color: #FFF9DE;"><span>Benefits of GLP-1 Receptor Agnostic for Stroke
                                Patients</span><br>
                            BJ Kim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">11:20-11:30</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                            <br> Celso Amodeo
                            <!-- 최종일<span>(TBD),</span>신미승<span>(가천의대 심장내과),</span>배장환<span>(충북의대),</span>김한영<span>(건국의대
                            신경과)</span> -->

                        </td>
                        <td class="table_time">11:20-11:30</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                            <br>
                            <!-- 배은희<span>(전남의대 신장내과),</span>한상원<span>(인제의대 신경과),</span>김범준<span>(울산의대
                            내분비내과),<br></span>최원석<span>(전남의대 내분비내과)</span> -->
                        </td>
                    </tr>

                    <tr>
                        <td class="time_bold">11:30-12:20</td>
                        <td colspan="3" style="background-color: #E4DEEF;">Plenary3. <span>Diabetes</span><br>
                            Won-Young Lee, Sang Hong Baek<br>
                            Felipe Martinez
                        </td>
                    </tr>

                    <tr>
                        <td class="time_bold">12:20-13:30</td>
                        <td style="background-color: #FFE497;">Luncheon satellite Symposium 3<br><span>HK Inno-N</span>
                        </td>
                        <td class="time_bold">12:20-13:30</td>
                        <td style="background-color: #FFE497;">Luncheon satellite Symposium4<br><span>Daewoong</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="time_bold">13:30-14:30</td>
                        <td style="background-color: #F7CDBF;" colspan="3">Meet-the-Editor<br><span>Chairpeson : TBD
                            </span><br>Stefan Agewall
                        </td>
                    </tr>
                    <tr>
                        <td class="time_bold">14:30-15:20</td>
                        <td colspan="3" style="background-color: #E4DEEF;">Plenary4. <span> Semaglutide-CVD</span><br>
                            <span>Chairpeson : TBD
                            </span><br>
                            Martin Haluzík
                        </td>
                    </tr>
                    <tr>
                        <td class="time_bold">15:20-17:00</td>
                        <td style="background-color: #FFF9DE;">Symposium 12.<span> Novel Cardiometabolic
                                pharmacotherapies <br>- FDA approved or approval pending</span><br>

                            HG Park,</sapn>Thomas Kahan

                        </td>
                        <td class="time_bold">15:20-17:00</td>
                        <td style="background-color: #FFF9DE;">Symposium 13. <span>Lipid</span><br>
                            MA Kim,SK Yoo
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">15:20-15:40</td>
                        <td style="background-color: #FFF9DE;"><span> New drugs in Hypertension</span><br>
                            Thomas Kahan
                        </td>
                        <td class="table_time">15:20-15:40</td>
                        <td style="background-color: #FFF9DE;"><span>PCSK9 inhibitors in lowering LDL-C</span><br>
                            TBD
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">15:40-16:00</td>
                        <td style="background-color: #FFF9DE;"><span>New drugs in Diabetes</span><br>
                            EY Lee
                        </td>
                        <td class="table_time">15:40-16:00</td>
                        <td style="background-color: #FFF9DE;"><span>Emerging therapies in LP(a)</span><br>
                            Heinz Drexel
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;"><span>New drugs in Dyslipidemia</span><br>
                            SH Kim
                        </td>
                        <td class="table_time">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;"><span>Treatment targets beyond LDL lowering
                                (Triglycerdie-rich lipoprotein)</span><br>
                            SH Lee
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:20-16:40</td>
                        <td style="background-color: #FFF9DE;"><span>New drugs in Heart Failure</span><br>
                            JJ Park
                        </td>
                        <td class="table_time">16:20-16:40</td>
                        <td style="background-color: #FFF9DE;"><span>Current use of omega-3 fatty acids</span><br>
                            SH Cho
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:40-17:00</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span><br>
                            <!-- 윤민재<sapn>(서울의대 분당서울대병원 순환기내과),</sapn>김병규<sapn>(인제의대),</sapn><br>
							김다래<sapn>(성균관의대),</sapn>최성희<sapn>(서울의대)</sapn><br> -->
                        </td>
                        <td class="table_time">16:40-17:00</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span><br>
                            <!-- 정미향<sapn>(가톨릭의대),</sapn>이승환<sapn>(가톨릭의대),</sapn>
							김한영<sapn>(건국의대),<br></sapn>박성하<sapn>(연세의대 심장내과)</sapn><br> -->
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">17:00-18:00</td>
                        <td colspan="3">Closing Remarks</td>
                    </tr>
                    </table>
                </div>
                <div class="tab_cont">
                    <ul class="program_color_txt">
                        <li>
                            <p>Day 1 - Thursday, November 23</p>
                        </li>
                        <!-- <div>
                            <li><i></i>&nbsp;:&nbsp;Korean</li>
                            <li><i></i>&nbsp;:&nbsp;English</li>
                        </div> -->
                    </ul>
                    <table class="table program_glance_table" name="2">
                        <colgroup>
                            <col width="7%">
                            <col width="43%">
                            <col width="9%">
                            <col width="41%">
                        </colgroup>
                        <tr style="border: none;">
                            <td colspan="4" style="padding: 0;">
                                <img src="./img/programheader1.png" />
                            </td>
                        </tr>
                        <tr>
                            <td class="table_header">Room
                            </td>

                            <td class=" table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Studio 4
                            </td>
                            <td colspan="2" class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Studio 8+9+10
                            </td>
                        </tr>
                        <tr>
                            <td class="time_bold">15:00-16:40</td>
                            <td style="background-color: #FFF9DE;">Symposium
                                1.<span>Coronary/Atherosclerosis/prevention</span> <br>
                                유승기<span>(이대서울병원 웰니스센터/심혈관클리닉)</span>, 한승환<span>(가천의대)</span>
                            </td>
                            <td class="time_bold">15:00-16:40</td>
                            <td style="background-color: #FFF9DE;">Symposium 2.<span>Lifestyle modiﬁcation for Prevention of
                                    CVD</span> <br>
                                <span>Chairpeson : TBD</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">15:00-15:20</td>
                            <td style="background-color: #FFF9DE;"><span>Anti-inflammatory drug use in ACS patients</span>
                                <br>
                                박훈준<span>(가톨릭의대 순환기내과)</span>
                            </td>
                            <td class="table_time">15:00-15:20</td>
                            <td style="background-color: #FFF9DE;"><span>Healthy dietary patterns in Koreans and</span> <br>
                                <span>their association with cardiovascular diseases</span> <br>
                                송수진<span>(한남대학교 식품영양학과)</span>
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">15:20-15:40</td>
                            <td style="background-color: #FFF9DE;"><span>Differences in risk factors for coronary
                                    atherosclerosis in men & women</span>
                                <br>
                                김미나<span>(고려의대 순환기내과)</span>
                            </td>
                            <td class="table_time">15:20-15:40</td>
                            <td style="background-color: #FFF9DE;"><span>Physical activity - one fits for all</span> <br>

                                양예슬<span>(서울대학교)</span>
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>Optimal duration of antiplatelet agents after
                                    PCI</span>
                                <br>
                                박만원<span>(가톨릭의대)</span>
                            </td>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>Precision Nutrition for prevention of T2DM</span>
                                <br>

                                Frank B. Hu
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>Role of digital health in cardiovascular
                                    disease</span>
                                <br>
                                권준명<span>(세종병원/메디컬에이아이)</span>
                            </td>
                            <td class="table_time">15:40-16:00</td>
                            <td style="background-color: #FFF9DE;"><span>KSCP 진료지침</span>
                                <br>
                                최성희<span>(서울의대 내분비내과)</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">16:20-16:40</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                <br>
                                강태수<span>(단국의대 심장혈관내과)</span>,이종영<sapn>(성균관의대),</sapn><br>
                                송영빈<span>(성균관의대 순환기내과)</span>,오규철<sapn>(가톨릭의대)</sapn>
                            </td>
                            <td class="table_time">16:20-16:40</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                <br>
                                <span>TBD</span>
                            </td>
                        </tr>
                        <td class="time_bold">16:40-17:40</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 1<br>
                            <span>Chairpeson : TBD</span><br>
                            <span>TBD</span>
                        </td>
                        <td class="time_bold">16:40-17:40</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 2<br>
                            <span>Chairpeson : TBD</span><br>
                            <span>TBD</span>
                        </td>
                        </tr>


                    </table>
                </div>
                <div class="tab_cont">
                    <ul class="program_color_txt">
                        <li>
                            <p>Day 2 - Friday, November 24</p>
                        </li>
                        <!-- <div>
                            <li><i></i>&nbsp;:&nbsp;Korean</li>
                            <li><i></i>&nbsp;:&nbsp;English</li>
                        </div> -->
                    </ul>
                    <table class="table program_glance_table" name="3">
                        <colgroup>
                            <col width="9.8%">
                            <col width="39.2%">
                            <col width="8.9%">
                            <col width="41%">
                        </colgroup>
                        <tr style="border: none;">
                            <td style="padding: 0;" colspan="4">
                                <img src="./img/programheader2.png" />
                            </td>
                        </tr>

                        <tr>
                            <td class="table_header">Room</td>
                            <td class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Grand ballroom 2+3
                            </td>
                            <td colspan="2" class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Park ballroom 1+2+3
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="time_bold">07:30-08:30</td>
                            <td style="background-color: #D9F1FC;">Breakfast Symposium 1</br>
                                <span>Boryung</span>
                            </td>
                            <td rowspan="2" style="background-color: #ddd;"></td>
                            <td rowspan="2" style="background-color: #ddd;"></td>
                        <tr>
                            <td style="border-left: 1px solid #9C9B9B;">TBD</td>
                        </tr>
                        </tr>
                        <tr>
                            <td class="table_time">08:30-09:00</td>
                            <td colspan="3">Registration and Opening Remark</td>
                        </tr>
                        <tr>
                            <td class="time_bold">09:00-10:50</td>
                            <td style="background-color: #FFF9DE;">Symposium 3.<span>Arrhythmia</span> <br>
                                Takanori Ikeda
                                <!-- <span>(Department of Cardiovascular Medicine,<br>Toho University Faculty of
									Medicine, Tokyo, Japan),</span> -->
                                <br>Young Keun ON
                                <!-- <sapn>(성균관의대)</sapn> -->

                            </td>
                            <td class="time_bold">09:00-10:50</td>
                            <td style="background-color: #FFF9DE;">Symposium 4. <span>SGLT-2 inhibitors</span><br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">09:00-09:30</td>
                            <td style="background-color: #FFF9DE;"><span>TBD (suggestion title: antiarrhythmic drugs, atrial
                                    fibrillation, heart failture)</span> <br>
                                Gheorghe Andrei Dan

                            </td>
                            <td class="table_time">09:00-09:30</td>
                            <td style="background-color: #FFF9DE;"><span>Cardiovascular benefits in T2DM: Rediscovery of
                                    mechanism</span> <br>
                                TR Oh
                            </td>
                        </tr>

                        <tr>
                            <td class="table_time">09:30-10:00</td>
                            <td style="background-color: #FFF9DE;"><span>TBD (suggestion title: Anticoagulation in
                                    patients<br>with atrial fibrillation and coronary artery disease)</span> <br>
                                Antoni Martínez Rubio

                            </td>
                            <td class="table_time">09:30-10:00</td>
                            <td style="background-color: #FFF9DE;"><span>TBD(suggestion title:SGLT2i-HF)</span> <br>
                                Felipe Martinez
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:00-10:15</td>
                            <td style="background-color: #FFF9DE;"><span>Wrap up! Factor Xa inhibitor</span> <br>
                                JM Lee
                            </td>
                            <td class="table_time">10:00-10:15</td>
                            <td style="background-color: #FFF9DE;"><span>SGLT2 inhibition: the new standard of care in
                                    kidney disease</span> <br>
                                Merlin Thomas
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:15-10:30</td>
                            <td style="background-color: #FFF9DE;"><span>Will DOACs find the role in mitral stenosis and
                                    atrial fibrillation?</span> <br>
                                JY Kim
                            </td>
                            <td class="table_time">10:15-10:30</td>
                            <td style="background-color: #FFF9DE;"><span>Perspectives on the role of SGLT1/2 co-inhibitors
                                    on cardiovascular disease</span> <br>
                                EJ Rhee
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:30-10:50</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                <!-- 김동민<sapn>(단국대),</sapn>임성일<sapn>(고신대),</sapn><br>
								이광노<sapn>(아주대),</sapn>정래영<sapn>(전북대)</sapn> -->
                            </td>
                            <td class="table_time">10:30-10:50</td>
                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                                <!-- 김대중<sapn>(아주의대 내분비내과),</sapn>최대은<sapn>(충남의대 신장내과),</sapn><br>
								김현진<sapn>(한양의대 순환기내과), </sapn>정찬희<sapn>(순천향의대 내분비내과)</sapn> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">10:50-11:10</td>
                            <td colspan="3">Coffee break</td>
                        </tr>
                        <tr>
                            <td class="time_bold">11:10~12:00</td>
                            <td colspan="3" style="background-color: #E4DEEF;">Plenary Lecture 1.<span>Henry N. Neufeld
                                    memorial lecture</span><br>
                                DH Kim,CH Lee<br>
                                <br>
                                Marc A. Pfeffer
                            </td>
                        </tr>
                        <tr>
                            <td class="time_bold">12:20-13:30</td>
                            <td style="background-color: #FFE497;">Luncheon Satellite Symposium 1<br><span>Yuhan</span></td>
                            <td class="time_bold">12:20-13:30</td>
                            <td style="background-color: #FFE497;">Luncheon Satellite Symposium 4<br><span>NOVO
                                    NORDISK</span></td>
                        </tr>
                        <tr>
                            <td class="time_bold">13:20-15:00</td>
                            <td style="background-color: #FFF9DE;">Symposium 5.<span>Current trends in optimal</span> <br>
                                <span>medical therapy for post-PCI patients</span><br>CH Lee,</sapn>SW Na

                            </td>
                            <td class="time_bold">13:20-15:00</td>
                            <td style="background-color: #FFF9DE;">Symposium 6. <span>Recent landmark clinical trials in CV
                                    Prevention</span><br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">13:20-13:40</td>
                            <td style="background-color: #FFF9DE;"><span>Antithrombotic therapy after acute coronary
                                    syndrome:<br>
                                    clinical challenges in the older patient</span> <br>
                                Pablo Avanzas
                            </td>
                            <td class="table_time">13:20-13:40</td>
                            <td style="background-color: #FFF9DE;"><span>Lifestyle modification for prevention T2DM</span>
                                <br>
                                S Cheon
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0;" colspan="4">
                                <table class="table program_glance_table" style="border-top: none; width:102%;">
                                    <colgroup>
                                        <col width="9.9%">
                                        <col width="38.8%">
                                        <col width="8.8%">
                                        <col width="44%">
                                    </colgroup>
                                    <tbody>

                                        <tr>
                                            <td class="table_header">Room
                                            </td>

                                            <td class=" table_header" style="border-left: none">
                                                <div class="blue_bar">
                                                </div>Studio 4
                                            </td>
                                            <td colspan="2" class="table_header" style="border-left: none">
                                                <div class="blue_bar">
                                                </div>Studio 8+9+10
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="time_bold">15:00-16:40</td>
                                            <td style="background-color: #FFF9DE;">Symposium
                                                1.<span>Coronary/Atherosclerosis/prevention</span> <br>
                                                유승기<span>(이대서울병원 웰니스센터/심혈관클리닉)</span>, 한승환<span>(가천의대)</span>
                                            </td>
                                            <td class="time_bold">15:00-16:40</td>
                                            <td style="background-color: #FFF9DE;">Symposium 2.<span>Lifestyle modiﬁcation
                                                    for Prevention of
                                                    CVD</span> <br>
                                                <span>Chairpeson : TBD</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table_time">15:00-15:20</td>
                                            <td style="background-color: #FFF9DE;"><span>Anti-inflammatory drug use in ACS
                                                    patients</span>
                                                <br>
                                                박훈준<span>(가톨릭의대 순환기내과)</span>
                                            </td>
                                            <td class="table_time">15:00-15:20</td>
                                            <td style="background-color: #FFF9DE;"><span>Healthy dietary patterns in Koreans
                                                    and</span> <br>
                                                <span>their association with cardiovascular diseases</span> <br>
                                                송수진<span>(한남대학교 식품영양학과)</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="table_time">15:20-15:40</td>
                                            <td style="background-color: #FFF9DE;"><span>Differences in risk factors for
                                                    coronary
                                                    atherosclerosis in men & women</span>
                                                <br>
                                                김미나<span>(고려의대 순환기내과)</span>
                                            </td>
                                            <td class="table_time">15:20-15:40</td>
                                            <td style="background-color: #FFF9DE;"><span>Physical activity - one fits for
                                                    all</span> <br>

                                                양예슬<span>(서울대학교)</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="table_time">15:40-16:00</td>
                                            <td style="background-color: #FFF9DE;"><span>Optimal duration of antiplatelet
                                                    agents after
                                                    PCI</span>
                                                <br>
                                                박만원<span>(가톨릭의대)</span>
                                            </td>
                                            <td class="table_time">15:40-16:00</td>
                                            <td style="background-color: #FFF9DE;"><span>Precision Nutrition for prevention
                                                    of T2DM</span>
                                                <br>

                                                Frank B. Hu
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="table_time">15:40-16:00</td>
                                            <td style="background-color: #FFF9DE;"><span>Role of digital health in
                                                    cardiovascular
                                                    disease</span>
                                                <br>
                                                권준명<span>(세종병원/메디컬에이아이)</span>
                                            </td>
                                            <td class="table_time">15:40-16:00</td>
                                            <td style="background-color: #FFF9DE;"><span>KSCP 진료지침</span>
                                                <br>
                                                최성희<span>(서울의대 내분비내과)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table_time">16:20-16:40</td>
                                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                                <br>
                                                강태수<span>(단국의대 심장혈관내과)</span>,이종영<sapn>(성균관의대),</sapn><br>
                                                송영빈<span>(성균관의대 순환기내과)</span>,오규철<sapn>(가톨릭의대)</sapn>
                                            </td>
                                            <td class="table_time">16:20-16:40</td>
                                            <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                                                <br>
                                                <span>TBD</span>
                                            </td>
                                        </tr>
                                        <td class="time_bold">16:40-17:40</td>
                                        <td style="background-color: #FBD9E8;">Satellite Session 1<br>
                                            <span>Chairpeson : TBD</span><br>
                                            <span>TBD</span>
                                        </td>
                                        <td class="time_bold">16:40-17:40</td>
                                        <td style="background-color: #FBD9E8;">Satellite Session 2<br>
                                            <span>Chairpeson : TBD</span><br>
                                            <span>TBD</span>
                                        </td>
                        </tr>


                        </tbody>
                    </table>
                    </td>

                    </tr>

                    <tr>
                        <td class="time_bold" class="table_time">15:00-15:40</td>
                        <td colspan="3" style="background-color: #E4DEEF;">Plenary Lecture 2.<span>
                                Ethnic and Regional
                                Differences in the Management of Angina: The Way Forward</span><br>
                            <!-- Chairpeson : TBD<br>
								<span>TBD</span><br> -->
                            Thomas Kahan
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">15:40-16:00</td>
                        <td colspan="3">Coffee break</td>
                    </tr>
                    <tr>
                        <td class="time_bold">16:00-17:40</td>
                        <td style="background-color: #FFF9DE;">Symposium 7.<span> Comprehensive management of</span>
                            <br>
                            <span>heart failure patients with comorbidities</span><br>DS Kim, JJ Kim<sapn>
                        </td>
                        <td class="time_bold">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;">Symposium 8. <span>Epidemiology of CVD</span><br>
                            <!-- <span>Chairpeson : TBD</span> -->
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;"><span>Current Status of HF management in Korea</span>
                            <br>
                            JC Yoon
                        </td>
                        <td class="table_time">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;"><span>Trends and Challenges in the Epidemiology of CVD in
                                Korea</span> <br>
                            HC Kim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:20-16:40</td>
                        <td style="background-color: #FFF9DE;"><span>SGLT2i in HF</span>
                            <br>
                            Felipe Martinez
                        </td>
                        <td class="table_time">16:20-16:40</td>
                        <td style="background-color: #FFF9DE;"><span>Age difference, does it exist?</span> <br>
                            JS Yoon
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:40-17:00</td>
                        <td style="background-color: #FFF9DE;"><span>ARNi in HF</span>
                            <br>
                            IC Kim
                        </td>
                        <td class="table_time">16:40-17:00</td>
                        <td style="background-color: #FFF9DE;"><span>Sex difference, does it exist?</span> <br>
                            EY Lee
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">17:00-17:20</td>
                        <td style="background-color: #FFF9DE;"><span>Targeted therapy in specific
                                cardiomyopathies</span>
                            <br>
                            DR Kim
                        </td>
                        <td class="table_time">17:00-17:20</td>
                        <td style="background-color: #FFF9DE;"><span>Socioeconomic disparity</span> <br>
                            YM Park
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">17:20-17:40</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                            <!-- 최성훈<sapn>(한림의대 순환기내과),</sapn>조상호<sapn>(한림의대 순환기내과),</sapn><br>
								최진오<sapn>(성균관의대),</sapn>김미나<sapn>(고려의대)</sapn> -->
                        </td>
                        <td class="table_time">17:20-17:40</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span> <br>
                            <!-- 김지희<sapn>(가톨릭의대 순환기내과),</sapn>이재혁<sapn>(명지병원 내분비내과),</sapn><br>
								신민호<sapn>(전남의대 예방의학교실), </sapn>안성복<sapn>(이화여대 융합보건학과),</sapn> -->
                        </td>
                    </tr>


                    </table>
                </div>

                <div class="tab_cont">
                    <ul class="program_color_txt">
                        <li>
                            <p>Day 3 - Saturday, November 25 </p>
                        </li>
                        <!-- <div>
                            <li><i></i>&nbsp;:&nbsp;Korean</li>
                            <li><i></i>&nbsp;:&nbsp;English</li>
                        </div> -->
                    </ul>
                    <table class="table program_glance_table" name="4">
                        <colgroup>
                            <col width="8%">
                            <col width="43.5%">
                            <col width="9%">
                            <col width="41%">
                        </colgroup>
                        <tr style="border: none;">
                            <td style="padding: 0;" colspan="4">
                                <img src="./img/programheader3.png" />
                            </td>
                        </tr>
                        <tr>
                            <td class="table_header">Room</td>
                            <td class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Grand ballroom 2+3
                            </td>
                            <td colspan="2" class="table_header" style="border-left: none">
                                <div class="blue_bar">
                                </div>Park ballroom 1+2+3
                            </td>
                        </tr>
                        <tr>
                            <td class="time_bold">07:30-08:30</td>
                            <td style="background-color: #D9F1FC;">Breakfast Symposium 2<br><span>JW Pharma</span></td>
                            <td class="time_bold">07:30-08:30</td>
                            <td style="background-color: #D9F1FC;">Breakfast Symposium 3<br><span>Hanmi
                                </span></td>
                        </tr>
                        <tr>
                            <td class="table_time">08:30-08:50</td>
                            <td colspan="3" style="font-weight: normal;">Coffee Break</td>
                        </tr>
                        <tr style="border-bottom: none;">
                            <td style="padding: 0;" colspan="4">
                                <table class="table program_glance_table" style="border-top: none; width:101%;">
                                    <colgroup>
                                        <col width="8%">
                                        <col width="42.2%">
                                        <col width="8.9%">
                                        <col width="44%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td class="time_bold">08:50-10:00</td>
                                            <td style="background-color: #FFF9DE;">Syposium 9.<span> How to maximize eﬀects
                                                    of
                                                    cardiovascular drugs</span><br>
                                                JY Lee, HA Kim
                                            </td>
                            </td>
                            <td class="time_bold">08:50-10:00</td>
                            <td style="background-color: #E6DDD1;">Hot topics in CPP (Editor's session)<br>
                                <!-- <span>Chairpeson : TBD</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="table_time">08:50-09:05</td>
                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Pharmacokinetics and Pharmacodynamics
                                    of
                                    Cardiovascular Drug</span><br>
                                HY Ahn
                            </td>
                            <td class="table_time">08:50-09:00</td>
                            <td style="background-color: #E6DDD1;">Public awareness of cardiovascular disease prevention in
                                Korea<br>
                                EJ Kim
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" rowspan="2" style="border-left: 1px solid #9C9B9B;">09:00-09:10</td>
                            <td rowspan="2" style="background-color: #E6DDD1;"><span>Safety and efficacy of low-dose aspirin
                                    in patients
                                    with coronary<br>artery spasm: long-term clinical follow-up</span><br>
                                KH Kim
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" rowspan="2">09:05-09:20</td>
                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Overcome adverse drug reaction of
                                    cardiovascular
                                    drugs</span><br>
                                GY Shon
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" style="border-left: 1px solid #9C9B9B;">09:10-09:20</td>
                            <td style="background-color: #E6DDD1;"><span>Effects of exercise on reducing diabetes risk in
                                    Korean women<br>according to menopausal status</span><br>
                                JH Cho
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" rowspan="2">09:20-09:40</td>
                            <td rowspan="2" style="background-color: #FFF9DE;"><span>Cardiovascular Pharmacist role in
                                    Singapore</span><br>
                                Doreen Tan
                            </td>
                            <td class="table_time">09:20-09:30</td>
                            <td style="background-color: #E6DDD1;">
                                <span>Fabry disease screening in young patients with acute ischemic<br>stroke in
                                    Korea</span><br>
                                TD Oak
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time" style="border-left: 1px solid #9C9B9B;">09:30-09:40</td>
                            <td style="background-color: #E6DDD1; "><span>Effect of the
                                    addition of thiazolidinedione to
                                    sodium-glucose<br>cotransporter 2 inhibitor therapy</span><br>
                                TG Park
                            </td>
                        </tr>
                        <tr>
                            <td class="table_time">09:40-10:00</td>
                            <td style=" background-color: #FFF9DE;"><span>Panel discussion</span><br>
                                <!-- 이옥상<span>(서울대학교병원)</span>,박소진<span>(삼성서울병원),</span>이지영<span>(국립중앙병원),</span><br>
								Surakit Nathisuwan -->
                                Surakit Nathisuwan<br>
                                Tlongco, Richard Henry II P.
                            </td>
                            <td class="table_time">09:40-10:00</td>
                            <td style="background-color: #E6DDD1;"><span>Panel discussion</span><br><span>TBD</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </td>
                    </tr>

                    <tr>
                        <td class="time_bold">10:00-11:30</td>
                        <td style="background-color: #FFF9DE;">Symposium 10.<span> Hypertension</span>
                            <br>
                            SH Lim, Thomas Kahan

                        </td>
                        <td class="time_bold">10:00-11:30</td>
                        <td style="background-color: #FFF9DE;">Symposium 11. <span>Incretins</span><br>
                            <span>Chairpeson : TBD</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">10:00-10:20</td>
                        <td style="background-color: #FFF9DE;"><span> Low-dose combination of blood pressure-lowering
                                medicines</span>
                            <br>
                            Thomas Kahan

                        </td>
                        <td class="table_time">10:00-10:20</td>
                        <td style="background-color: #FFF9DE;"><span>Semaglutide-CVD</span><br>
                            <span>Prof. Martin Haluzik</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="table_time">10:20-10:40</td>
                        <td style="background-color: #FFF9DE;"><span>Hypertension control based on home blood pressure
                                telemonitoring</span>
                            <br>
                            SH Park

                        </td>
                        <td class="table_time">10:00-10:20</td>
                        <td style="background-color: #FFF9DE;"><span>GLP-1RA and diabetes/obesity</span><br>
                            SM Jim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">10:40-11:00</td>
                        <td style="background-color: #FFF9DE;"><span>Emerging drugs for resistant hypertension</span>
                            <br>
                            HR Kim

                        </td>
                        <td class="table_time">10:40-11:00</td>
                        <td style="background-color: #FFF9DE;"><span>Effects of dual agonist on cardiorenal
                                risk</span><br>
                            NH Kim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">11:00-11:20</td>
                        <td style="background-color: #FFF9DE;"><span>Recent hypertension guidelines in the world</span>
                            <br>
                            HY Lee

                        </td>
                        <td class="table_time">11:00-11:20</td>
                        <td style="background-color: #FFF9DE;"><span>Benefits of GLP-1 Receptor Agnostic for Stroke
                                Patients</span><br>
                            BJ Kim
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">11:20-11:30</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                            <br> Celso Amodeo
                            <!-- 최종일<span>(TBD),</span>신미승<span>(가천의대 심장내과),</span>배장환<span>(충북의대),</span>김한영<span>(건국의대
                            신경과)</span> -->

                        </td>
                        <td class="table_time">11:20-11:30</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span>
                            <br>
                            <!-- 배은희<span>(전남의대 신장내과),</span>한상원<span>(인제의대 신경과),</span>김범준<span>(울산의대
                            내분비내과),<br></span>최원석<span>(전남의대 내분비내과)</span> -->
                        </td>
                    </tr>

                    <tr>
                        <td class="time_bold">11:30-12:20</td>
                        <td colspan="3" style="background-color: #E4DEEF;">Plenary3. <span>Diabetes</span><br>
                            Won-Young Lee, Sang Hong Baek<br>
                            Felipe Martinez
                        </td>
                    </tr>

                    <tr>
                        <td class="time_bold">12:20-13:30</td>
                        <td style="background-color: #FFE497;">Luncheon satellite Symposium 3<br><span>HK Inno-N</span>
                        </td>
                        <td class="time_bold">12:20-13:30</td>
                        <td style="background-color: #FFE497;">Luncheon satellite Symposium4<br><span>Daewoong</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="time_bold">13:30-14:30</td>
                        <td style="background-color: #F7CDBF;" colspan="3">Meet-the-Editor<br><span>Chairpeson : TBD
                            </span><br>Stefan Agewall
                        </td>
                    </tr>
                    <tr>
                        <td class="time_bold">14:30-15:20</td>
                        <td colspan="3" style="background-color: #E4DEEF;">Plenary4. <span> Semaglutide-CVD</span><br>
                            <span>Chairpeson : TBD
                            </span><br>
                            Martin Haluzík
                        </td>
                    </tr>
                    <tr>
                        <td class="time_bold">15:20-17:00</td>
                        <td style="background-color: #FFF9DE;">Symposium 12.<span> Novel Cardiometabolic
                                pharmacotherapies <br>- FDA approved or approval pending</span><br>

                            HG Park,</sapn>Thomas Kahan

                        </td>
                        <td class="time_bold">15:20-17:00</td>
                        <td style="background-color: #FFF9DE;">Symposium 13. <span>Lipid</span><br>
                            MA Kim,SK Yoo
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">15:20-15:40</td>
                        <td style="background-color: #FFF9DE;"><span> New drugs in Hypertension</span><br>
                            Thomas Kahan
                        </td>
                        <td class="table_time">15:20-15:40</td>
                        <td style="background-color: #FFF9DE;"><span>PCSK9 inhibitors in lowering LDL-C</span><br>
                            TBD
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">15:40-16:00</td>
                        <td style="background-color: #FFF9DE;"><span>New drugs in Diabetes</span><br>
                            EY Lee
                        </td>
                        <td class="table_time">15:40-16:00</td>
                        <td style="background-color: #FFF9DE;"><span>Emerging therapies in LP(a)</span><br>
                            Heinz Drexel
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;"><span>New drugs in Dyslipidemia</span><br>
                            SH Kim
                        </td>
                        <td class="table_time">16:00-16:20</td>
                        <td style="background-color: #FFF9DE;"><span>Treatment targets beyond LDL lowering
                                (Triglycerdie-rich lipoprotein)</span><br>
                            SH Lee
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:20-16:40</td>
                        <td style="background-color: #FFF9DE;"><span>New drugs in Heart Failure</span><br>
                            JJ Park
                        </td>
                        <td class="table_time">16:20-16:40</td>
                        <td style="background-color: #FFF9DE;"><span>Current use of omega-3 fatty acids</span><br>
                            SH Cho
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">16:40-17:00</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span><br>
                            <!-- 윤민재<sapn>(서울의대 분당서울대병원 순환기내과),</sapn>김병규<sapn>(인제의대),</sapn><br>
							김다래<sapn>(성균관의대),</sapn>최성희<sapn>(서울의대)</sapn><br> -->
                        </td>
                        <td class="table_time">16:40-17:00</td>
                        <td style="background-color: #FFF9DE;"><span>Panel discussion</span><br>
                            <!-- 정미향<sapn>(가톨릭의대),</sapn>이승환<sapn>(가톨릭의대),</sapn>
							김한영<sapn>(건국의대),<br></sapn>박성하<sapn>(연세의대 심장내과)</sapn><br> -->
                        </td>
                    </tr>
                    <tr>
                        <td class="table_time">17:00-18:00</td>
                        <td colspan="3">Closing Remarks</td>
                    </tr>




                    </table>
                </div>

            </div>

        </div>

    </section>
<?php
}
?>
<!-- <script>
$(document).ready(function() {
    $('.program_table').each(function() {
        var parents_div = $(this).parents('.program_table_wrap');
        $(this).clone(true).appendTo(parents_div).addClass('clone');
    });
    var i = 1;
    $('.program_table td').each(function() {
        if (!$(this).is(':empty')) {
            var td = $(this).attr('colspan');
            if (!$(this).hasClass("dark_bg") && !(td == 5)) {
                var tabId = $(this).closest('.program_table_wrap').attr('id');
                var lectureId = "lId_" + i;
                var lectureSrc = "./program_detail.php#" + tabId + "&#" + lectureId;
                $(this).attr('id', lectureId);
                $(this).wrapInner('<a target="_blank" href="' + lectureSrc + '"></a>');
                //               $('<a target="_blank" href="'+lectureSrc+'"></a>').prependTo($(this));
                i = i + 1;
            }
        }
    });
});
</script> -->

<script>
    $(document).ready(function() {
        $("td.pointer").click(function() {
            var e = $(this).find("input[name=e]").val();
            var day = $(this).parents("tbody[name=day]").attr("class");
            var target = $(this)
            var this_name = $(this).attr("name");
            var table_num = $(this).parents("table").attr("name")

            table_location(event, target, e, day, this_name, table_num);
        });
    });

    function table_location(event, _this, e, day, this_name, table_num) {
        window.location.href = "./scientific_program" + table_num + ".php?&e=" + e + "&name=" + this_name;

    }
</script>

<?php include_once('./include/footer.php'); ?>