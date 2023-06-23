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
<div style="width:1122px; height:793px; background:url('./img/img_certifi_bg.jpg') no-repeat center /contain; padding:146px 60px 84px; box-sizing:border-box;">
    <p style="font-family:'Montserrat', sans-serif; font-size:0; font-weight:bold; text-align:center; position:relative; padding:11px 0 13px; border-top:1px solid #e1c1a6; border-bottom:1px solid #e1c1a6; max-width:395px; margin:0 auto 28px;">
        <span style="font-family:inherit; font-size:25px; font-weight:inherit;">ISCP 2023 </span>
        <span style="font-family:inherit; font-size:24px; font-weight:400;">with </span>
        <span style="font-family:inherit; font-size:24px; font-weight:inherit;"> KSCP</span>
        <img style="position:absolute; left:50%; transform:translateX(-50%); top:-20px;" src="./img/icon_certifi_title.svg" alt="">
    </p>
    <p style="font-family: Noto Serif, serif; font-size:40px; font-weight:bold; color:#422918; text-align:center; margin:0; line-height:1.5;">
        Certificate of Attendance
        <!-- <span style="font-size:25px; margin-top:18px; display:block;">This ig certificate is presented to</span> -->
    </p>
    <ul style="text-align:center; padding-left:0;">
        <li style="font-family: Noto Serif, serif; list-style:none; font-size:14px; margin:0 0 26px 0; font-weight:bold;">
            This certificate is presented to</li>
        <li style="font-family:Open Sans, sans-serif; list-style:none; font-size:22px; margin:0 0 10px 0; font-weight:bold;">
            <?= $detail["name"]; ?></li>
        <li style="font-family:Open Sans, sans-serif; list-style:none; font-size:14px; margin:0;">
            <?= $detail["affiliation"]; ?></li>
    </ul>
    <p></p>
    <p style="font-family: Noto Serif, serif; font-size:13px; font-weight:bold; line-height:23px; text-align:center; margin-top:60px; color:#422918;">
        for attending the 28 th International Society
        of Cardiovascular Pharmacotherapy<br />with Asian-Pacific Society of
        Atherosclerosis and Vascular Disease<br />held on September 15-17, 2022 in Seoul, Korea.</p>
    <ul style="display:block; width:700px; margin:80px auto 0; font-size:0;">
        <li style="display:inline-block; width:45%; box-sizing:border-box; vertical-align:middle;">
            <img src="./img/certifi_sign01.png" style="vertical-align:middle;" alt="">
            <div style="display:inline-block; vertical-align:middle;">
                <p style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">
                    Donghoon Choi, M.D., Ph.D</p>
                <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                    Chairman, Board of directors</p>
                <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                    The Korean Society of Lipid & </p>
                <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                    Atherosclerosis (KSoLA)</p>
            </div>
        </li>
        <li style="display:inline-block; width:55%; padding-left: 16px; box-sizing:border-box; vertical-align:middle; border-left:1px solid #422918;">
            <img src="./img/certifi_sign02.png" style="margin-right:10px; vertical-align:middle;" alt="">
            <div style="display:inline-block; vertical-align:middle;">
                <p style="font-family:'Montserrat', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">
                    Sang-Hak Lee, M.D., Ph.D</p>
                <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                    Chair of Scienti?c Program Committee</p>
                <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                    The Korean Society of Lipid &</p>
                <p style="font-family:'Montserrat', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">
                    Atherosclerosis (KSoLA)</p>
            </div>
        </li>
    </ul>
</div>
<div class="btn_wrap" style="width:1122px; text-align:center;">
    <button type="button" class="btn update_btn pop_save_btn" onclick="CreatePDFfromHTML()">Save</button>
    <!-- <a class="btn update_btn pop_save_btn" onclick="CreatePDFfromHTML()">Save</a> -->
</div>

<script>
    function CreatePDFfromHTML() {
        console.log("download")
        var key = "<?= $member_id; ?>";
        var idx = "<?= $registration_idx; ?>";
        window.location.replace("pre_registration_confirm2.html?key=" + key + "&idx=" + idx);
    }
</script>