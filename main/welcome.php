<?php
include_once('./include/head.php');
include_once('./include/header.php');

//$language
$sql_info = "SELECT
					overview_welcome_msg_" . $language . " AS welcome_msg,
					CONCAT(fi_sign.path, '/', fi_sign.save_name) AS fi_sign_url
				FROM info_general as ig
				left join `file` as fi_sign
					on fi_sign.idx = ig.overview_welcome_sign_" . $language . "_img";
$info = sql_fetch($sql_info);
?>

<section class="container welcome">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Welcome Message</h2>
                <div class="color-bar"></div>
                <!-- <ul>
					<li>Home</li>
					<li>ISCP 2023</li>
					<li>Welcome Message</li>
				</ul> -->
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="section section2">
            <!-- <div class="circle_title"> -->
            28 <sup>th</sup>
            ISCP Annual Scientific Meeting, Seoul, S. Korea <br>
            Conjunction with KSCP and KSCVP meeting
        </div>
        <div class="text_box">
            <p>
                It is our great privilege and pleasure to cordially invite all of you to our upcoming 28<span
                    class="upper_txt">th</span>
                ISCP 2023 Seoul.<br>
                This ISCP 2023 Seoul will be held in Conrad Seoul, S. Korea, from 23 November to 25 November 2023.<br>
                The great event is jointly organized by ISCP (International Society of Cardiovascular Pharmacotherapy),
                KSCVP (Korean Society of Cardiovascular Pharmacotherapy),<br>
                and KSCP (Korean Society of Cardiovascular Disease Prevention) When we look back on the past, we have
                faced the toughest challenges in the moment <br>
                of COVID19 since 2020. However, while we fight against the COVID19, we are not only becoming stronger
                but more resilient.<br>
                The organizing committee has decided to hold ISCP 2023 Seoul in a hybrid format both in-person and
                online meetings. <br>
                ISCP 2023 Seoul will provide key insight, practice-changing updates, and cutting-edge educational
                content with outstanding world-class professionals.<br>
                It brings together key stakeholders in all areas of cardiovascular pharmacotherapies, cardiovascular
                disease prevention, and better patient care. It is our pride, <br>
                privilege, and pleasure to keep highly educational communications transpiring through ISCP 2023
                Seoul.<br></p>
            <p>
                As the hosting co-president of ISCP 2023 Seoul, we eagerly anticipate this meeting to be the greatest
                academic experience you’ve ever had the pleasure to take part in. <br>
                We would like to express my sincerest gratitude to all of your attendance and continued support. We look
                forward to seeing you all at ISCP 2023 Seoul in November 2023.
                <br>
                Thank you all very much.
            </p>

        </div>
        <div class="footer-img-box">
            <div>
                <div class="footer-first-img">
                </div>
                <div>
                    <p>Sang Hong Baek, MD, PhD<br>
                        President, ISCP</p>
                </div>
            </div>
            <div>
                <div class="footer-second-img"></div>
                <div>
                    <p>Young Keun On, MD, PhD<br>
                        Governor, ISCP<br>
                        President, Korean Society of<br>
                        Cardiovascular Pharmacotherapy</p>
                </div>
            </div>
            <div>
                <div class="footer-third-img"></div>
                <div>
                    <p>Won-Young Lee, MD, PhD<br>
                        President, Korean Society of<br>
                        Cardiovascular Disease Prevention</p>
                </div>
            </div>
        </div>
        <!-- <ul class="poeple_profile clearfix">
            <li class="clearfix">
                <div class="prof_img">
                    <img src="./img/img_profile01.jpg" alt="">
                </div>
                <div>
                    <img src="./img/img_sign01.jpg" class="sign_img" alt="">
                    <p class="name">Myung A Kim, M.D., Ph.D</p>
                    <p>President</p>
                    <p>The Korean Society of Lipid &</p>
                    <p>Atherosclerosis (KSoLA)</p>
                </div>
            </li>
            <li class="clearfix">
                <div class="prof_img">
                    <img src="./img/img_profile02.jpg" alt="">
                </div>
                <div>
                    <img src="./img/img_sign02.jpg" class="sign_img" alt="">
                    <p class="name">Donghoon Choi, M.D., Ph.D</p>
                    <p>Chairman, Board of directors</p>
                    <p>The Korean Society of Lipid &</p>
                    <p>Atherosclerosis (KSoLA)</p>
                </div>
            </li>
        </ul> -->
        <!-- <div class="text_wrap"> -->
        <!-- 	<div class="clearfix"> -->
        <!-- 		<?= htmlspecialchars_decode($info['welcome_msg']) ?> -->
        <!-- 		<div class="sign"><img src="<?= $info['fi_sign_url'] ?>"></div> -->
        <!-- 	</div> -->
        <!-- </div> -->
    </div>
    </div>
</section>

<?php include_once('./include/footer.php'); ?>