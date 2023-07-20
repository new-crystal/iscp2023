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
                <h2>Program at glance</h2>
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
                <h2>Program at a glance</h2>
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

                    <tr style="border: none;">
                        <td colspan="3" style="padding: 0;">
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
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Studio 8+9+10
                        </td>
                    </tr>
                    <tr>
                        <td>15:00-16:40</td>
                        <td style="background-color: #FFF9DE;">Symposium 1 <br>
                            <span>Coronary / Atherosclerosis / prevention</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 2 <br>
                            <span>Lifestyle modiﬁcation for Prevention of CVD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>16:40-17:40</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 1</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 2</td>
                    </tr>
                    <tr style="border: none;">
                        <td style="padding: 0;" colspan="3">
                            <img src="./img/programheader2.png" />
                        </td>
                    </tr>
                    <tr>
                        <td class="table_header">Room</td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Grand ballroom 2+3
                        </td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Park ballroom 1+2+3
                        </td>
                    </tr>
                    <tr>
                        <td>07:30-08:30</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 1</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 2</td>
                    </tr>
                    <tr>
                        <td>08:30-09:00</td>
                        <td colspan="2" style="font-weight: normal;">Registration and Opening remark</td>
                    </tr>
                    <tr>
                        <td>09:00-10:50</td>
                        <td style="background-color: #FFF9DE;">Symposium 3 <br>
                            <span>Arrhythmia</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 4 <br>
                            <span>SGLT-2 inhibitors</span>
                        </td>
                    </tr>
                    <tr>
                        <td>10:50-11:10</td>
                        <td colspan="2" style="font-weight: normal;">Coﬀee Break</td>
                    </tr>
                    <tr>
                        <td>11:10-12:00</td>
                        <td style="background-color: #E4DEEF;" colspan="2">Plenary Lecture 1<br><span>Henry N. Neufeld
                                memorial lecture</span></td>
                    </tr>
                    <tr>
                        <td>
                            12:00-13:20
                        </td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 1</td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 2</td>
                    </tr>
                    <tr>
                        <td>13:20-15:00</td>
                        <td style="background-color: #FFF9DE;">Symposium 5 <br>
                            <span>Current trends in optimal medical therapy for post-PCI patients</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 6 <br>
                            <span>Recent landmark clinical trials in CV Prevention</span>
                        </td>
                    </tr>
                    <tr>
                        <td>15:00-15:40</td>
                        <td colspan="2" style="background-color: #E4DEEF;">Plenary Lecture 2<br><span>Ethnic and
                                Regional Diﬀerences in the Management of
                                Angina : The Way Forward</span></td>
                    </tr>
                    <tr>
                        <td>15:40-16:00</td>
                        <td colspan="2" style="font-weight: normal;">Coﬀee Break</td>
                    </tr>
                    <tr>
                        <td>16:00-17:40</td>
                        <td style="background-color: #FFF9DE;">Symposium 7 <br>
                            <span>Comprehensive management of heart failure patients<br>
                                with comorbidities</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 8 <br>
                            <span>Epidemiology of CVD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>17:40-18:40</td>
                        <td style="background-color: #B8D6F2;">Moderate Session 1</td>
                        <td style="background-color: #B8D6F2;">Moderate Session 2</td>
                    </tr>

                    <tr style="border: none;">
                        <td style="padding: 0;" colspan="3">
                            <img src="./img/programheader3.png" />
                        </td>
                    </tr>
                    <tr>
                        <td class="table_header">Room</td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Grand ballroom 2+3
                        </td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Park ballroom 1+2+3
                        </td>
                    </tr>
                    <tr>
                        <td>07:30-08:30</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 3</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 4</td>
                    </tr>
                    <tr>
                        <td>08:30-08:50</td>
                        <td colspan="2" style="font-weight: normal;">Registration and Opening remark</td>
                    </tr>
                    <tr>
                        <td>08:50-10:00</td>
                        <td style="background-color: #FFF9DE;">Syposium 9<br>
                            <span> How to maximize eﬀects of cardiovascular drugs</span>
                        </td>
                        <td style="background-color: #E6DDD1;">Hot topics in CPP<br>
                            <span>(Editor’s session)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>10:00-11:30</td>
                        <td style="background-color: #FFF9DE;">Syposium 10<br>
                            <span>Hypertension</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Syposium 11<br>
                            <span>Incretins</span>
                        </td>
                    </tr>
                    <tr>
                        <td>11:30-12:20</td>
                        <td colspan="2" style="background-color: #E4DEEF;">Plenary Lecture 3
                            <br><span>SGLT2i-HF</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12:20-13:30</td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 3</td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 4</td>
                    </tr>
                    <tr>
                        <td>11:30-12:20</td>
                        <td style="background-color: #F7CDBF;" colspan="2">Meet the editor - Up-to-date(Based on ISCP
                            journal editor’s pick)</td>
                    </tr>
                    <tr>
                        <td>14:30-15:20</td>
                        <td style="background-color: #E4DEEF;" colspan="2">Plenary Lecture 4
                            <br><span>Semaglutide-CVD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>15:20-17:00</td>
                        <td style="background-color: #FFF9DE;">Syposium 12<br>
                            <span> Novel Cardiometabolic pharmacotherapies - FDA<br>
                                approved or approval pending</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Syposium 13<br>
                            <span>Lipid</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #F0F0F0;">17:00-18:00</td>
                        <td style="background-color: #F0F0F0;" colspan="2" style="font-weight: normal;">closing ceremony
                        </td>
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
                    <tr style="border: none;">
                        <td colspan="3" style="padding: 0;">
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
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Studio 8+9+10
                        </td>
                    </tr>
                    <tr>
                        <td>15:00-16:40</td>
                        <td style="background-color: #FFF9DE;">Symposium 1 <br>
                            <span>Coronary / Atherosclerosis / prevention</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 2 <br>
                            <span>Lifestyle modiﬁcation for Prevention of CVD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>16:40-17:40</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 1</td>
                        <td style="background-color: #FBD9E8;">Satellite Session 2</td>
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
                    <tr style="border: none;">
                        <td style="padding: 0;" colspan="3">
                            <img src="./img/programheader2.png" />
                        </td>
                    </tr>
                    <tr>
                        <td class="table_header">Room</td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Grand ballroom 2+3
                        </td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Park ballroom 1+2+3
                        </td>
                    </tr>
                    <tr>
                        <td>07:30-08:30</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 1</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 2</td>
                    </tr>
                    <tr>
                        <td>08:30-09:00</td>
                        <td colspan="2" style="font-weight: normal;">Registration and Opening remark</td>
                    </tr>
                    <tr>
                        <td>09:00-10:50</td>
                        <td style="background-color: #FFF9DE;">Symposium 3 <br>
                            <span>Arrhythmia</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 4 <br>
                            <span>SGLT-2 inhibitors</span>
                        </td>
                    </tr>
                    <tr>
                        <td>10:50-11:10</td>
                        <td colspan="2" style="font-weight: normal;">Coﬀee Break</td>
                    </tr>
                    <tr>
                        <td>11:10-12:00</td>
                        <td style="background-color: #E4DEEF;" colspan="2">Plenary Lecture 1<br><span>Henry N. Neufeld
                                memorial lecture</span></td>
                    </tr>
                    <tr>
                        <td>
                            12:00-13:20
                        </td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 1</td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 2</td>
                    </tr>
                    <tr>
                        <td>13:20-15:00</td>
                        <td style="background-color: #FFF9DE;">Symposium 5 <br>
                            <span>Current trends in optimal medical therapy for post-PCI patients</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 6 <br>
                            <span>Recent landmark clinical trials in CV Prevention</span>
                        </td>
                    </tr>
                    <tr>
                        <td>15:00-15:40</td>
                        <td colspan="2" style="background-color: #E4DEEF;">Plenary Lecture 2<br><span>Ethnic and
                                Regional Diﬀerences in the Management of
                                Angina : The Way Forward</span></td>
                    </tr>
                    <tr>
                        <td>15:40-16:00</td>
                        <td colspan="2" style="font-weight: normal;">Coﬀee Break</td>
                    </tr>
                    <tr>
                        <td>16:00-17:40</td>
                        <td style="background-color: #FFF9DE;">Symposium 7 <br>
                            <span>Comprehensive management of heart failure patients<br>
                                with comorbidities</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Symposium 8 <br>
                            <span>Epidemiology of CVD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>17:40-18:40</td>
                        <td style="background-color: #B8D6F2;">Moderate Session 1</td>
                        <td style="background-color: #B8D6F2;">Moderate Session 2</td>
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
                    <tr style="border: none;">
                        <td style="padding: 0;" colspan="3">
                            <img src="./img/programheader3.png" />
                        </td>
                    </tr>
                    <tr>
                        <td class="table_header">Room</td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Grand ballroom 2+3
                        </td>
                        <td class="table_header" style="border-left: none">
                            <div class="blue_bar">
                            </div>Park ballroom 1+2+3
                        </td>
                    </tr>
                    <tr>
                        <td>07:30-08:30</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 3</td>
                        <td style="background-color: #D9F1FC;">Breakfast Symposium 4</td>
                    </tr>
                    <tr>
                        <td>08:30-08:50</td>
                        <td colspan="2" style="font-weight: normal;">Registration and Opening remark</td>
                    </tr>
                    <tr>
                        <td>08:50-10:00</td>
                        <td style="background-color: #FFF9DE;">Syposium 9<br>
                            <span> How to maximize eﬀects of cardiovascular drugs</span>
                        </td>
                        <td style="background-color: #E6DDD1;">Hot topics in CPP<br>
                            <span>(Editor’s session)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>10:00-11:30</td>
                        <td style="background-color: #FFF9DE;">Syposium 10<br>
                            <span>Hypertension</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Syposium 11<br>
                            <span>Incretins</span>
                        </td>
                    </tr>
                    <tr>
                        <td>11:30-12:20</td>
                        <td colspan="2" style="background-color: #E4DEEF;">Plenary Lecture 3
                            <br><span>SGLT2i-HF</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12:20-13:30</td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 3</td>
                        <td style="background-color: #FFE497;">Luncheon Satellite Symposium 4</td>
                    </tr>
                    <tr>
                        <td>11:30-12:20</td>
                        <td style="background-color: #F7CDBF;" colspan="2">Meet the editor - Up-to-date(Based on ISCP
                            journal editor’s pick)</td>
                    </tr>
                    <tr>
                        <td>14:30-15:20</td>
                        <td style="background-color: #E4DEEF;" colspan="2">Plenary Lecture 4
                            <br><span>Semaglutide-CVD</span>
                        </td>
                    </tr>
                    <tr>
                        <td>15:20-17:00</td>
                        <td style="background-color: #FFF9DE;">Syposium 12<br>
                            <span> Novel Cardiometabolic pharmacotherapies - FDA<br>
                                approved or approval pending</span>
                        </td>
                        <td style="background-color: #FFF9DE;">Syposium 13<br>
                            <span>Lipid</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #F0F0F0;">17:00-18:00</td>
                        <td style="background-color: #F0F0F0;" colspan="2" style="font-weight: normal;">closing ceremony
                        </td>
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