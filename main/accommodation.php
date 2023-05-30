<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>

<section class="container accommodation">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Accommodation</h2>
                <div class="color-bar"></div>
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="section section1" style="display:none;">
            <div class="clearfix2">
                <div class="img_wrap">
                    <img src="./img/Venue_1.jpg" alt="hotel img">
                </div>
                <div class="info_wrap">
                    <h6><?= $locale("hotel_name") ?></h6>
                    <div class="table_wrap c_table_wrap">
                        <table class="c_table">
                            <tr>
                                <th><?= $locale("address") ?></th>
                                <td><?= $locale("hotel_address") ?><a class="btn has_txt" target="_blank" href="https://conrad.hilton.co.kr/hotel/seoul/conrad-seoul/access"><?= $locale("direction_btn") ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th><?= $locale("tel") ?></th>
                                <td>+82-2-6137-7000</td>
                            </tr>
                            <tr>
                                <th><?= $locale("email") ?></th>
                                <td>conradseoul.reservation@conradhotels.com</td>
                            </tr>
                            <tr>
                                <th><?= $locale("website") ?></th>
                                <td><a href="http://conradseoul.co.kr/" class="btn" target="_blank">Go to Website</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="details">
                        <p class="pre"><?= $locale("hotel_txt") ?></p>
                    </div>
                </div>

            </div>
            <!--Room info & reservation start-->
            <div class="section_title_wrap2 clearfix2">
                <h3 class="title"><?= $locale("room_info_tit") ?></h3>
                <a href="/main/download/icomes_reservation_form.doc" class="btn"><?= $locale("room_file_btn") ?></a>
            </div>
            <div class="table_wrap c_table_wrap2 room_table">
                <table class="c_table2">
                    <thead>
                        <tr>
                            <th><?= $locale("room_type") ?></th>
                            <!--<th><?= $locale("room_info") ?></th>-->
                            <th><?= $locale("rate") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Deluxe Room</td>
                            <td>KRW 264,000 (vat included)</td>
                        </tr>
                        <tr>
                            <td>Premium Room</td>
                            <td>KRW 297,000 (vat included)</td>
                        </tr>
                        <tr>
                            <td>Queen Corner Suite Room</td>
                            <td>KRW 313,500 (vat included)</td>
                        </tr>
                        <tr>
                            <td>Executive Room</td>
                            <td>KRW 407,000 (vat included)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--Room info & reservation end-->
        </div>
        <!--1-->
        <!-- <p>In order to take advantage of the special rates for hotel accommodations secured by the committee, please fill out the hotel reservation form and send it directly to the hotel.</p> -->
        <div class="details step_gradation">
            <ul>
                <li>
                    <div class="step_circle"><span>STEP 01</span></div>
                    <p class="step_text">Choose the room you would like to reserve</p>
                </li>
                <li>
                    <div class="step_circle"><span>STEP 02</span></div>
                    <p class="step_text">Download the reservation form listed by the hotel below and fill it out</p>
                </li>
                <li>
                    <div class="step_circle"><span>STEP 03</span></div>
                    <p class="step_text">Send the form directly to the hotel</p>
                </li>
            </ul>
        </div>
        <!--2-->
        <div class="circle_title">Booking & Payment Conditions</div>
        <div class="details">
            <ul>
                <li>1. The below rates are per room per night.</li>
                <li>2. As rooms will be assigned on a first-come, first-served basis, reserving early is recommended.
                </li>
                <li>3. Cancellation and refund policies are in accordance with the rules of hotel.</li>
                <li>4. Rates are based on single occupancy per room. Double occupancy rates vary according to each
                    hotel, so
                    please confirm before check-in.</li>
                <li>5. All personal charges (i.e. room service, phone calls, the mini bar, etc.) are the participant’s
                    responsibility.</li>
                <!-- <li>6. The below rates only apply to ICoLA2022 with APSAVD participants.</li> -->
            </ul>
        </div>
        <!--3-->
        <div class="circle_title">List of Congress Hotel</div>
        <!--3.1-->
        <div class="table_wrap">
            <table class="table table_responsive left_border_table" style="text-align: center;">
                <thead>
                    <tr>
                        <th>Grade</th>
                        <th>Hotels</th>
                        <th>Distance from Venue</th>
                        <th>Room Type</th>
                        <th>Room Rate</th>
                        <!-- <th>Reservation form</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="red_txt s_bold">★★★★★</td>
                        <td><a target="_blank" class="s_bold underline">Conrad Seoul</a></td>
                        <td>Venue</td>
                        <td>Single Room</td>
                        <td>KRW 250,000~</td>
                        <!-- <td><a class="btn download_btn" target="_blank">Reservation Form Download</a></td> -->
                    </tr>
                    <tr>
                        <td class="red_txt s_bold">★★★★</td>
                        <td><a target="_blank" class="s_bold underline">Seoul
                                Garden<br />Hotel & Suites</a></td>
                        <td>6 min. by car</td>
                        <td>Standard Room</td>
                        <td>KRW 100,000</td>
                        <!-- <td><a class="btn download_btn" target="_blank">Reservation Form Download</a></td> -->
                    </tr>
                    <!-- <tr>
                        <td class="red_txt s_bold">★★★★</td>
                        <td><a href="https://be.synxis.com/?_ga=2.129104587.63992943.1639639874-2017945784.1639639874&adult=1&arrive=2022-05-17&chain=25084&child=0&currency=KRW&depart=2022-05-18&hotel=10775&level=hotel&locale=en-US&rooms=1"
                                target="_blank" class="s_bold underline">Glad Yeouido</a></td>
                        <td>19 min. on foot</td>
                        <td>Standard Room<br />Deluxe Room</td>
                        <td>KRW 132,000<br>KRW 154,000</td>
                        <td><a href="./download/Reservation Form_GLAD Hotel Yeouido(ICoLA2022).docx"
                                class="btn download_btn" target="_blank">Reservation Form Download</a></td>
                    </tr>
                    <tr>
                        <td class="red_txt s_bold">★★★★</td>
                        <td><a href="https://www.glad-hotels.com/mapo/index.do?locale=en" target="_blank"
                                class="s_bold underline">Glad Mapo</a></td>
                        <td>9 min. by car</td>
                        <td>Standard Room</td>
                        <td>KRW 99,000(Double)<br>KRW 88,000(Twin)</td>
                        <td><a href="./download/Reservation Form_GLAD Hotel Mapo(ICoLA2022).docx"
                                class="btn download_btn" target="_blank">Reservation Form Download</a></td>
                    </tr>
                    <tr>
                        <td class="red_txt s_bold">★★★★</td>
                        <td><a href="https://www.lottehotel.com/mapo-city/en.html" target="_blank"
                                class="s_bold underline">LOTTE City Hotel Mapo</a></td>
                        <td>11 min. by car</td>
                        <td>Standard Room</td>
                        <td>KRW 110,000</td>
                        <td><a href="./download/lotte_reservation_form.doc" class="btn download_btn"
                                target="_blank">Reservation
                                Form Download</a></td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <br>
        <div class="details">
            <p>*The room rates above can be changed from the current status of the hotels</p>
        </div>
        <!--3.2-->
        <ul class="useful_list">
            <li>
                <div class="imgs"></div>
                <div>
                    <p>Conrad Seoul</p>
                    <div class="table_wrap table_responsive">
                        <table class="table">
                            <colgroup>
                                <col class="col_th">
                                <col width="*">
                                <col class="col_th">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>Check in</th>
                                    <td>16:00</td>
                                    <th>Check out</th>
                                    <td>11:00</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3">10 Gukjegeumyung-ro Yeouido Yeongdeungpo-gu Seoul, 07326, South
                                        Korea</td>
                                </tr>
                                <tr>
                                    <th>Tel / Fax</th>
                                    <td colspan="3">Tel +82-2-6137-7000 / Fax +82-2-6137-7001</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><a href="mailto:Conrad_Seoul@conradhotels.com" class="s_bold underline">Conrad_Seoul@conradhotels.com</a></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td colspan="3"><a href="https://www.hilton.com/en/hotels/selcici-conrad-seoul/" target="_blank" class="s_bold underline">https://www.hilton.com/en/hotels/selcici-conrad-seoul/</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
            <li>
                <div class="imgs"></div>
                <div>
                    <p>Seoul Garden Hotel & Suites</p>
                    <div class="table_wrap">
                        <table class="table">
                            <colgroup>
                                <col class="col_th">
                                <col width="*">
                                <col class="col_th">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>Check in</th>
                                    <td>15:00</td>
                                    <th>Check out</th>
                                    <td>12:00</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3">58-Mapo-daero, Mapo-gu, Seoul, Republic of Korea</td>
                                </tr>
                                <tr>
                                    <th>Tel / Fax</th>
                                    <td colspan="3">Tel +82-2-710-7111 / Fax +82-2-710-7333</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><a href="mailto:resv@seoulgarden.co.kr" class="s_bold underline">resv@seoulgarden.co.kr</a></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td colspan="3"><a href="https://www.seoulgarden.co.kr/en/" target="_blank" class="s_bold underline">https://www.seoulgarden.co.kr/EN/</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
            <!-- <li>
                <div class="imgs"></div>
                <div>
                    <p>Glad Yeouido</p>
                    <div class="table_wrap">
                        <table class="table">
                            <colgroup>
                                <col class="col_th">
                                <col width="*">
                                <col class="col_th">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>Check in</th>
                                    <td>15:00</td>
                                    <th>Check out</th>
                                    <td>12:00 PM</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3">16 Uisadang daero Yeongdeungpogu, Seoul, Korea-Republic Of, 07236
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tel / Fax</th>
                                    <td colspan="3">Tel +82-2-6222-5000 / Fax +82-2-6222-5731</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><a href="mailto:info@glad-hotels.com"
                                            class="s_bold underline">info@glad-hotels.com</a></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td colspan="3"><a href="https://www.glad-hotels.com/yeouido/index.do?locale=en"
                                            target="_blank"
                                            class="s_bold underline">https://www.glad-hotels.com/yeouido/index.do?locale=en</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li> -->
            <!-- <li>
                <div class="imgs"></div>
                <div>
                    <p>Glad Mapo</p>
                    <div class="table_wrap">
                        <table class="table">
                            <colgroup>
                                <col class="col_th">
                                <col width="*">
                                <col class="col_th">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>Check in</th>
                                    <td>15:00</td>
                                    <th>Check out</th>
                                    <td>12:00</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3">92, Mapo-daero, Mapo-gu, Seoul, Republic of Korea</td>
                                </tr>
                                <tr>
                                    <th>Tel</th>
                                    <td colspan="3">Tel +82-2-2197-5000 / Fax +82-2-2197-5009</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><a href="mailto:rsvn.mapo@glad-hotels.com" class="s_bold underline">rsvn.mapo@glad-hotels.com</a></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td colspan="3"><a href="https://www.glad-hotels.com/mapo/index.do" target="_blank" class="s_bold underline">https://www.glad-hotels.com/mapo/index.do</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
            <li>
                <div class="imgs"></div>
                <div>
                    <p>LOTTE City Hotel Mapo</p>
                    <div class="table_wrap">
                        <table class="table">
                            <colgroup>
                                <col class="col_th">
                                <col width="*">
                                <col class="col_th">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>Check in</th>
                                    <td>15:00</td>
                                    <th>Check out</th>
                                    <td>12:00</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="3">109 Mapo-daero, Mapo-gu, Seoul, Republic of Korea</td>
                                </tr>
                                <tr>
                                    <th>Tel / Fax</th>
                                    <td colspan="3">Tel +82-2-6009-1000 / Fax +82-2-6009-1004</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><a href="mailto:rsv.city.mapo@lotte.net" class="s_bold underline">rsv.city.mapo@lotte.net</a></td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td colspan="3" class="nowrap_x">
                                        <a href="https://www.lottehotel.com/mapo-city/en.html" target="_blank" class="s_bold underline">
                                            https://www.lottehotel.com/mapo-city/en.html
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
</section>


<?php include_once('./include/footer.php'); ?>