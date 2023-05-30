<?php
include_once('./include/head.php');
include_once('./include/header.php');

$sql_info =	"SELECT
					CONCAT(fi_img.path, '/', fi_img.save_name) AS fi_img_url,
					igv.name_" . $language . " AS `name`,
					igv.address_" . $language . " AS address,
					igv.tel_" . $language . " AS tel,
					igv.homepage_en,
					igv.homepage_ko
				FROM info_general_venue AS igv
				LEFT JOIN `file` AS fi_img
					ON fi_img.idx = igv." . $language . "_img";

$info = sql_fetch($sql_info);

$user_idx = $_SESSION['USER']['idx'];

$nation_no_sql = "SELECT
						nation_no
					FROM member
					WHERE idx= 1";

$nation_no = sql_fetch($nation_no_sql)['nation_no'];
?>


<section class="container venue">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Venue</h2>
                <div class="color-bar"></div>
            </div>
        </div>
    </div>
    <div class="inner">
        <div>
            <div class="circle_title">
                Conrad Seoul Hotel
            </div>
            <img src="./img/img_venue.jpg" class="hotel_img" alt="">
            <div class="clearfix2">
                <div class="info_wrap">
                    <table class="venue-table">
                        <tbody>
                            <tr class="venue-tr">
                                <td class="venue-table-border-right">Address</td>
                                <td>10, Gukjegeumyung-ro, Yeongdeungpo-gu, Seoul, Korea</td>
                            </tr>
                            <tr>
                                <td class="venue-table-border-right">Tel</td>
                                <td>02-6137-7000</td>
                            </tr>
                            <tr class="venue-tr">
                                <td class="venue-table-border-right">Website</td>
                                <td>www.conradseoul.co.kr</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <ul>
                        <li>
                            <span>Address: </span>
                            10, Gukjegeumyung-ro, Yeongdeungpo-gu, Seoul, Korea
                        </li>
                        <li>
                            <span>Tel: </span>
                            +82 2-6137-7000
                        </li>
                        <li>
                            <span>Website: </span>
                            <a href="https://www.hilton.com/en/hotels/selcici-conrad-seoul/ ">www.conradseoul.co.kr</a>
                        </li>
                    </ul> -->
                    <!-- <h6><?= $info['name'] ?></h6> -->
                    <!-- <ul class="info_list"> -->
                    <!-- 	<li class="clearfix2"> -->
                    <!-- 		<p><?= $locale("address") ?></p> -->
                    <!-- 		<p><?= $info['address'] ?></p> -->
                    <!-- 	</li> -->
                    <!-- 	<li class="clearfix2"> -->
                    <!-- 		<p><?= $locale("tel") ?></p> -->
                    <!-- 		<p><?= $info['tel'] ?></p> -->
                    <!-- 	</li> -->
                    <!-- </ul> -->
                    <!-- <div class="btn_wrap"> -->
                    <!-- 	<a href="<?= $info['homepage_en'] ?>" target="_blank"><button type="button" class="btn">Go to Website - ENG</button></a> -->
                    <!-- 	<a href="<?= $info['homepage_ko'] ?>" target="_blank"><button type="button" class="btn">Go to Website - KOR</button></a> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div>
            <div class="circle_title">
                Location
            </div>
            <iframe id="map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3164.2611871345725!2d126.92436551558762!3d37.52533993424356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357c9f3bedaef86d%3A0x870e91c402860ad2!2sConrad%20Seoul!5e0!3m2!1sen!2skr!4v1650333121650!5m2!1sen!2skr"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            <!-- <div id="map"></div> -->
        </div>
    </div>

</section>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<?php
if ($nation_no == 25) {
	echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPtDrunl2i34nzP-YWKW8WehcnlKqkL5E&callback=initMap&v=weekly&channel=2" async></script>';
} else {
	echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPtDrunl2i34nzP-YWKW8WehcnlKqkL5E&language=en&callback=initMap&v=weekly&channel=2" async></script> ';
}

?>
<!-- 한글지도 -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPtDrunl2i34nzP-YWKW8WehcnlKqkL5E&callback=initMap&v=weekly&channel=2" async></script> -->
<!-- 영문지도 -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPtDrunl2i34nzP-YWKW8WehcnlKqkL5E&callback=initMap&v=weekly&channel=2" async></script> -->


<!-- <script> -->
<!-- 	let map; -->

<!-- function initMap() { -->
<!--   map = new google.maps.Map(document.getElementById("map"), { -->
<!--     center: { lat: 37.52541225958601, lng: 126.92657565583382 }, -->
<!--     zoom: 16, -->
<!--   }); -->
<!-- } -->
<!-- </script> -->
<?php include_once('./include/footer.php'); ?>