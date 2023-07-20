<?php
include_once('./include/head.php');

$member_idx = $_SESSION["USER"]["idx"] ?? null;
$member_id = $_GET["key"] ?? null;
$registration_idx = $_GET["idx"] ?? null;

$sql = "
		SELECT
			CONCAT(first_name, ' ', last_name) AS `name`,
			m.affiliation
		FROM request_registration AS r
		LEFT JOIN(
			SELECT
				idx,
				SUBSTRING_INDEX(email, '@', 1) AS id,
				affiliation
			FROM member
		) AS m
			ON m.idx = register
		WHERE m.id = '{$member_id}'
		AND r.idx = {$registration_idx}
		AND is_deleted = 'N'
		AND `status` = 2
	";

$detail = sql_fetch($sql);
if (empty($detail)) {
    echo "<script>alert('Registration Not Found.');window.close();</script>";
    exit;
}
?>
<l<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <div style="width:1284px; height:830px; padding:211px 60px 30px; box-sizing:border-box; z-index: 999;">
        <p style="font-family:'Montserrat', sans-serif; font-size:0; font-weight:bold; text-align:center; position:relative; padding:11px 0 13px; border-top:1px solid #e1c1a6; border-bottom:1px solid #e1c1a6; max-width:400px; margin:0 auto 28px;">
            <span style="font-family:inherit; font-size:25px; font-weight:inherit;">ISCP 2023 </span>
            <span style="font-family:inherit; font-size:24px; font-weight:400;">with </span>
            <span style="font-family:inherit; font-size:24px; font-weight:inherit;"> KSCVP</span>
            <span style="font-family:inherit; font-size:24px; font-weight:400;">& </span>
            <span style="font-family:inherit; font-size:24px; font-weight:inherit;"> KSCP</span>
            <img style="position:absolute; left:50%; transform:translateX(-50%); top:-20px;" src="./img/icon_certifi_title.svg" alt="">
        </p>
        <p style="font-family: Noto Serif, serif; font-size:40px; font-weight:bold; color:#422918; text-align:center; margin:0; line-height:1.5;">
            Certificate of Attendance
            <!-- <span style="font-size:25px; margin-top:18px; display:block;">This ig certificate is presented to</span> -->
        </p>
        <ul style="text-align:center; padding-left:0;">
            <li style="font-family: Noto Serif, serif; list-style:none; font-size:14px; margin:0; font-weight:bold;">
                This certificate is presented to</li>
            <li style="font-family: 'Great Vibes', cursive; list-style:none; font-size:60px; margin:0 0 10px 0;">
                <?= $detail["name"]; ?></li>
            <li style="font-family:Open Sans, sans-serif; list-style:none; font-size:14px; margin:0;">
                <?= $detail["affiliation"]; ?></li>
        </ul>
        <p></p>
        <p style="font-family: Noto Serif, serif; font-size:13px; font-weight:bold; line-height:23px; text-align:center; margin-top:60px; color:#422918;">
            for attending the 28<sup style="font-family: Noto Serif, serif; font-size:10px; font-weight:bold; line-height:23px; text-align:center; margin-top:60px; color:#422918;">th</sup>
            International Society of Cardiovascular Pharmacotherapy<br />Annual Scientific
            Meeting held on November 23-25, 2023 in Seoul, Korea </p>
        <ul style="display:flex; width:1000px; margin:80px auto 0; font-size:0; transform: translateX(60px);">
            <li style="display:flex; width:27%; box-sizing:border-box; vertical-align:middle; align-items: center;">
                <img src="./img/certifi_sign01.png" style="vertical-align:middle;" alt="" height="35px">
                <div style="display:inline-block; vertical-align:middle;">
                    <p style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">
                        Sang Hong Baek, MD, PhD</p>
                    <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                        President, ISCP</p>

                </div>
            </li>
            <li style="display:flex; width:33%; padding-left: 16px; box-sizing:border-box; vertical-align:middle; border-left:1px solid #422918; align-items: center;">
                <img src="./img/certifi_sign02.png" style="margin-right:10px; vertical-align:middle;" alt="" height="35px">
                <div style="display:inline-block; vertical-align:middle;">
                    <p style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">
                        Young Keun On, MD, PhD</p>
                    <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                        Governor, ISCP</p>
                    <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                        President, Korean Society of</p>
                    <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                        Cardiovascular Pharmacotherapy</p>
                </div>
            </li>
            <li style="display:flex; width:33%; padding-left: 16px; box-sizing:border-box; vertical-align:middle; border-left:1px solid #422918;align-items: center;">
                <img src="./img/certifi_sign03.png" style="margin-right:10px; vertical-align:middle;" alt="" height="35px">
                <div style="display:inline-block; vertical-align:middle;">
                    <p style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">
                        Won-Young Lee, MD, PhD</p>
                    <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                        President, Korean Society of</p>
                    <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                        Cardiovascular Disease Prevention</p>
                </div>
            </li>
        </ul>
        <img src="https://iscp2023.org/main/img/img_certifi_bg.png" alt="background" style="position:absolute; width:100%; height:100%; top:0; left:0; box-sizing:border-box;z-index: -1;" />
    </div>
    <div class="btn_wrap" style="width:1122px; text-align:center;">
        <button type="button" class="btn update_btn pop_save_btn" style="transform: translate(80px, 60px);" onclick="CreatePDFfromHTML()">Save</button>
        <!-- <a class="btn update_btn pop_save_btn" onclick="CreatePDFfromHTML()">Save</a> -->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <script>
        function CreatePDFfromHTML() {
            const buttonBox = document.querySelector(".btn_wrap");
            const button = document.querySelector(".update_btn");

            buttonBox.removeChild(button)
            let doc = new jsPDF('p', 'pt', 'a4');

            doc.addHTML(document.body, function() {
                doc.save('registration.pdf');
            });
        }
    </script>