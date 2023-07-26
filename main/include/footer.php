<div class="footer_wrap">
    <div class="fixed_btn_clone"></div>
    <div class="fixed_btn_wrap">
        <ul class="toolbar_wrap">
            <li><button type="button" onClick="location.href='/main/board_notice.php'"><i><img src="/main/img/footer_notice.png" alt=""></i></button></li>
            <li><button type="button" onClick="location.href='/main/registration.php'"><i><img src="/main/img/footer_registration.png" alt=""></i></button></li>
            <li><button type="button" onClick="location.href='/main/abstract_submission.php'"><i><img src="/main/img/footer_abstract.png" alt=""></i></button></li>
            <?php
            if ($_SESSION["USER"]["idx"] == "") {
            ?>
                <li><button type="button" onClick="alert('Need to login.')"><i><img src="/main/img/footer_mypage.png" alt=""></i></button></li>
            <?php
            } else {
            ?>
                <li><button type="button" onClick="location.href='/main/mypage.php'"><i><img src="/main/img/footer_mypage.png" alt=""></i></button></li>
            <?php
            }
            ?>

        </ul>
        <button type="button" class="btn_top"><img src="/main/img/footer_up.png" alt=""></button>
    </div>



    <!-- 2022-06-14 sponsor slide 추가작업 (HUBDNCHYJ) -->
    <div class="index_sponsor_wrap">

        <div class="spon_list_box">
            <!-- <span>Sponsored by</span> -->
            <ul class="sponsor_list">
                <li>
                    <a target="_blank" href="http://eng.yuhan.co.kr/Main/"><img src="/main/img/main_logo/gold04.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.inno-n.com/eng/"><img src="/main/img/main_logo/gold10.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.daewoong.co.kr/en/main/index"><img src="/main/img/main_logo/login_sponsor01.png" alt=""></a>
                </li>

                <li>
                    <a target="_blank" href="https://www.novonordisk.co.kr/"><img class="novo_logo" src="/main/img/main_logo/logo_novo.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.hanmi.co.kr"><img src="/main/img/main_logo/gold01.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="https://pharm.boryung.co.kr/eng/index.do"><img src="/main/img/main_logo/silver04.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.gccorp.com/kor/index"><img src="/main/img/main_logo/GC_biopharma_03.png" alt=""></a>
                </li>

                <li>
                    <a target="_blank" href="https://www.jw-pharma.co.kr/pharma/en/main.jsp"><img src="/main/img/main_logo/login_sponsor03.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="http://en.donga-st.com/Main.da"><img src="/main/img/main_logo/bronze05.png" alt=""></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.astrazeneca.com/"><img src="/main/img/main_logo/silver02.png" alt=""></a>
                </li>



                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.sanofi.com/en"><img src="/main/img/main_logo/gold02.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.amgen.co.kr/en"><img src="/main/img/main_logo/gold03.png"
                        alt=""></a> -->
                <!-- </li> -->

                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.viatris.com/en"><img src="/main/img/main_logo/gold05.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="http://www.ckdpharm.com/en/home"><img src="/main/img/main_logo/gold06.gif"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.boehringer-ingelheim.com/"><img
                        src="/main/img/main_logo/gold07.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.lilly.com/"><img src="/main/img/main_logo/gold08.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.celltrionph.com/en-us/home/index"><img
                        src="/main/img/main_logo/gold09_1.png" alt=""></a> -->
                <!-- </li> -->

                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.lgchem.com/main/index"><img src="/main/img/main_logo/silver01.png"
                        alt=""></a> -->
                <!-- </li> -->

                <!-- <li> -->
                <!-- <a target="_blank" href="https://daiichisankyo.us/"><img src="/main/img/main_logo/silver03.png"
                        alt=""></a> -->
                <!-- </li> -->

                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.novartis.com/about"><img src="/main/img/main_logo/bronze01.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.otsuka.co.kr/introduction_en"><img
                        src="/main/img/main_logo/bronze02.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <lig> -->
                <!-- <a target="_blank" href="https://www.ildong.com/eng/main/main.id"><img
                        src="/main/img/main_logo/bronze03_1.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.daewonpharm.com/eng/main/index.jsp"><img
                        src="/main/img/main_logo/bronze04.png" alt=""></a> -->
                <!-- </li> -->

                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.kup.co.kr/"><img src="/main/img/main_logo/bronze06.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://eng.yypharm.co.kr/main"><img src="/main/img/main_logo/bronze07.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.abbott.com/"><img src="/main/img/main_logo/bronze08.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.samjinpharm.co.kr/front/en/main/index.asp"><img
                        src="/main/img/main_logo/bronze09.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li>
                <a target="_blank" href="https://www.hanlim.com:49324/eng/"><img src="/main/img/main_logo/bronze10.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="http://www.gcbiopharma.com/eng/index.do"><img
                        src="/main/img/main_logo/bronze11.png" alt=""></a> -->
                <!-- </li>
            <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="https://www.pfizer.com/"><img src="/main/img/main_logo/bronze12.png"
                        alt=""></a> -->
                <!-- </li>
            <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="https://www.organon.com/"><img src="/main/img/main_logo/login_sponsor02.png"
                        alt=""></a> -->
                <!-- </li>

            <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="https://www.daewoong.co.kr/en/main/index"><img
                        src="/main/img/main_logo/login_sponsor01.png" alt=""></a> -->
                <!-- </li> -->

                <!-- <li><a target="_blank" href="https://www.sanofi.com/en"><img src="/main/img/main_logo/gold02.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="https://www.amgen.co.kr/en"><img src="/main/img/main_logo/gold03.png"
                        alt=""></a> -->
                <!-- </li>
            <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="http://eng.yuhan.co.kr/Main/"><img src="/main/img/main_logo/gold04.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li><a target="_blank" href="https://www.viatris.com/en"><img src="/main/img/main_logo/gold05.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="http://www.ckdpharm.com/en/home"><img src="/main/img/main_logo/gold06.gif"
                        alt=""></a> -->
                <!-- </li>
            <li><img src="/main/img/spon_img.png" alt=""> -->
                <!-- <a target="_blank" href="https://www.boehringer-ingelheim.com/"><img
                        src="/main/img/main_logo/gold07.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.lilly.com/"><img src="/main/img/main_logo/gold08.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.celltrionph.com/en-us/home/index"><img
                        src="/main/img/main_logo/gold09_1.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.inno-n.com/eng/"><img src="/main/img/main_logo/gold10.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.organon.com/"><img src="/main/img/main_logo/login_sponsor02.png"
                        alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.jw-pharma.co.kr/pharma/en/main.jsp"><img
                        src="/main/img/main_logo/login_sponsor03.png" alt=""></a> -->
                <!-- </li> -->
                <!-- <li> -->
                <!-- <a target="_blank" href="https://www.daewoong.co.kr/en/main/index"><img
                        src="/main/img/main_logo/login_sponsor01.png" alt=""></a> -->
                <!-- </li> -->
            </ul>
        </div>
    </div>


    <!-- 변경된 footer (22.03.15 HUBDNC LJH2 )-->
    <footer class="footer">

        <div class="container">

            <div>
                <div class="footer_left">
                    <h1 onClick="javascript:location.href='/main/index.php'" class="pointer"><img class="footer_left_img_first" src="/main/img/footer_logo.png" alt="footer_logo">
                        <img class="footer_left_img_second" src="/main/img/footer_logo02.png" alt="footer_logo">
                    </h1>
                    <!-- <ul>
                    <li><a href="https://www.instagram.com/icola2022_ksola/"><img src="/main/img/icons/sns_insta.svg" alt="sns_instagram"></a></li>
                    <li><a href="https://www.instagram.com/icola_2022/"><img src="/main/img/icons/sns_insta.svg" alt="sns_instagram"></a></li>
                    <li><a href="https://www.facebook.com/people/KSo-LA/100078130128012/"><img src="/main/img/icons/sns_facebook.svg" alt="sns_facebook"></a></li>
                    <li><a href="https://twitter.com/ICoLA2022"><img src="/main/img/icons/sns_twitter.svg" alt="sns_twitter"></a></li>
                    <li><a href="https://pf.kakao.com/_Mxexaab "><img src="/main/img/icons/sns_kakao.svg" alt="sns_kakaotalk"></a></li>
                </ul> -->
                    <!-- <div class="footer_logo_img">
                    <img src="/main/img/footer_logo_01.png" alt="">
                </div> -->
                </div>
                <div class="footer_center">
                    <h1 class="f_title">Organized by<br />Korean Society of Cardiovascular Pharmacotherapy</h1>
                    <ul class="f_info">
                        <li>31, Seochojungang-ro 18-gil, Seocho-gu, Seoul, Republic of Korea</li>
                        <li>Tel: 070-8873-6030 E-mail: k-iscp@kscvp.org</li>
                        <!-- <li>Business Registration Number: 110-82-60956</li> -->
                    </ul>
                    <h1 class="f_title" style="margin-top: 30px;">Korean Society of Cardiovascular Disease Prevention
                    </h1>
                    <ul class="f_info">
                        <li>99, Seongsuil-ro, Seongdong-gu, Seoul, Republic of Korea </li>
                        <li>Tel: 02-6408-1505 E-mail: kscpmd@kscpmd.or.kr</li>
                        <li>Business Registration Number: 110-82-71069</li>

                    </ul>
                </div>
                <div class="footer_right">
                    <h1 class="f_title">Secreatariat of ISCP 2023 </h1>
                    <ul class="f_info footer_bottom">
                        <li>Tel: +82-10-6549-2506 Fax: +82-3275-3099</li>
                        <li>E-mail: iscp@into-on.com</li>
                        <li>204, Wonhyo-ro, Yongsan-gu, Seoul(04368), Korea</li>
                    </ul>

                </div>
            </div>
            <p class="f_copyright">Copyrights © International Society of Cardiovascular Pharmacotherap
            </p>
        </div>
    </footer>
</div>

<div class="popup term3">
    <div class="pop_bg"></div>
    <div class="pop_contents">
        <button type="button" class="pop_close"><img src="/main/img/icons/pop_close.png"></button>
        <h3 class="pop_title">Terms</h3>
        <?= $locale("terms") ?>
    </div>
</div>


<div class="popup term4">
    <div class="pop_bg"></div>
    <div class="pop_contents">
        <button type="button" class="pop_close"><img src="/main/img/icons/pop_close.png"></button>
        <h3 class="pop_title">Conditions</h3>
        <?= $locale("privacy") ?>
    </div>
</div>

<script>
    $(".sponsor_list").slick({
        variableWidth: true,
        autoplay: true,
        autoplaySpeed: 4000,
    });

    $('.term3_btn').on('click', function() {
        $('.term3').show();
    })
    $('.term4_btn').on('click', function() {
        $('.term4').show();
    })


    if ($("section").hasClass("index_test")) {
        $(".fixed_btn_wrap").addClass("index_pg");
    }
    // fixed button 스크롤할때 고정
    var footer_height = $('.footer_wrap').outerHeight();
    $(window).on('scroll', function() {
        var scroll_top = $(window).scrollTop();

        if (scroll_top > 50) {
            $(".btn_top").fadeIn(300);
        } else {
            $(".btn_top").fadeOut(300);
        }

        var footer_top = $(".footer_wrap").offset().top;
        var fixed_bottom = $(".fixed_btn_clone").offset().top + $(".fixed_btn_clone").outerHeight();
        if (!$("section").hasClass("index_test")) {

            if (32 >= footer_top - fixed_bottom) {
                // $(".fixed_btn_wrap").addClass("on");
                // $(".fixed_btn_wrap").css("bottom", footer_height + 32 + "px");
            } else {
                // $(".fixed_btn_wrap").removeClass("on");
                $(".fixed_btn_wrap").css("bottom", "32px");
            }
        }
    });
    if (window.innerWidth < 1300) {
        const btnWrap = document.querySelector(".fixed_btn_wrap")
        btnWrap.style.display = "none";
    }
    if (window.innerWidth >= 1300) {
        const btnWrap = document.querySelector(".fixed_btn_wrap")
        btnWrap.style.display = "";
    }
    window.onresize = function() {
        if (window.innerWidth < 1300) {
            const btnWrap = document.querySelector(".fixed_btn_wrap")
            btnWrap.style.display = "none";
        }
        if (window.innerWidth >= 1300) {
            const btnWrap = document.querySelector(".fixed_btn_wrap")
            btnWrap.style.display = "";
        }
    }
    // top button 클릭이벤트
    $(".btn_top").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 500)
    })
</script>