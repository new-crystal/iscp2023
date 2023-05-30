<?php
include_once('./common/common.php');
require_once('../../icomes.or.kr/main/plugin/dompdf/vendor/autoload.php');
require_once('../../icomes.or.kr/main/plugin/dompdf/autoload.inc.php');

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

$member_idx = $_SESSION["USER"]["idx"] ?? null;
$member_id = $_GET["key"] ?? null;
$registration_idx = $_GET["idx"] ?? null;

$sql= "
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
if (!$detail) {
	echo "<script>alert('Registration Not Found.');window.close();</script>";
	exit;
}

$inner_style = "";
$inner_body = '
		<div style="position:fixed; width:100%; height:100%; top:0; left:0; background:url(\'http://15.164.50.26/main/img/img_certifi_bg.jpg\') no-repeat center /contain; box-sizing:border-box;">

	<div style="max-width:395px; margin:146px auto 45px; text-align:center;">
		<img src="http://15.164.50.26/main/img/img_certificate_title_all.png" alt=""/>
	</div>
	<p style="font-family: Noto Serif, serif; font-size:40px; font-weight:bold; color:#422918; text-align:center; margin:0; line-height:1.5;">
		<img style="margin-bottom:26px;" src="http://15.164.50.26/main/img/img_certificate_title_all2.png" alt=""/><br/>
		<img src="http://15.164.50.26/main/img/img_certificate_title_all3.png" alt=""/>
		<!--<span style="font-family: inherit; list-style:none; font-size:14px; display:block; margin:0 0 26px 0; font-weight:bold;">This certificate is presented to</span>-->
	</p>
	<ul style="text-align:center; padding-left:0; margin-top:26px;">
		<!-- <li style="font-family:\'Kepler Std\',sans-serif; list-style:none; font-size:20px; margin:0 0 20px 0; font-weight:bold;">This certificate is presented to</li> -->
		<li style="font-family: Open Sans, sans-serif; list-style:none; font-size:22px; margin:0 0 10px 0; font-weight:bold;">'.$detail["name"].'</li>
		<li style="font-family: Open Sans, sans-serif; list-style:none; font-size:14px; margin:0;">'.$detail["affiliation"].'</li>
	</ul>
	<p></p>
	<p style="margin-top:60px; text-align:center;"><img src="http://15.164.50.26/main/img/img_certificate_title_all4.png" alt=""/></p>
	<ul style="display:block; width:700px; margin:80px auto 0; font-size:0;">
		<li style="display:inline-block; width:45%; box-sizing:border-box; vertical-align:middle;">
			<img src="http://15.164.50.26/main/img/certifi_sign01.png" style="vertical-align:middle;" alt="">
			<div style="display:inline-block; vertical-align:middle;">
				<p style="font-family:\'Montserrat\', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">Donghoon Choi, M.D., Ph.D</p>
				<p style="font-family:\'Montserrat\', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">Chairman, Board of directors</p>
				<p style="font-family:\'Montserrat\', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">The Korean Society of Lipid & </p>
				<p style="font-family:\'Montserrat\', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">Atherosclerosis (KSoLA)</p>
			</div>
		</li>
		<li style="display:inline-block; width:50%; padding-left: 16px; box-sizing:border-box; vertical-align:middle; border-left:1px solid #422918;">
			<img src="http://15.164.50.26/main/img/certifi_sign02.png" style="margin-right:10px; vertical-align:middle;" alt="">
			<div style="display:inline-block; vertical-align:middle;">
				<p style="font-family:\'Montserrat\', sans-serif; font-size:10px; font-weight:bold; margin-bottom:10px;">Sang-Hak Lee, M.D., Ph.D</p>
				<p style="font-family:\'Montserrat\', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">Chair of Scientiﬁc Program Committee</p>
				<p style="font-family:\'Montserrat\', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">The Korean Society of Lipid &</p>
				<p style="font-family:\'Montserrat\', sans-serif; font-size:8px; font-weight:500; line-height:10px; margin:0 0 2px 0;">Atherosclerosis (KSoLA)</p>
			</div>
		</li>
	</ul>
</div>
	';

///* dompdf 설정 */

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->set_option('enable_remote', true);

$markup = make_html($inner_style, $inner_body);
$dompdf->loadHtml($markup);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper("A4", 'landscape');

// Render the HTML as PDF
$dompdf->render();

//파일 이름 설정
$datetime = date("YmdHis");
$file_name = "ICoLA2022_certification_".$datetime.".pdf";

// Output the generated PDF to Browser
$dompdf->stream($file_name);


// html 기본 폼 붙여주기
function make_html($inner_style, $inner_body){
	$font_path = DOMAIN."/plugin/dompdf/vendor/dompdf/dompdf/lib/fonts";

	$html = "";
	$html .= '<!DOCTYPE html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"><link href="https://fonts.cdnfonts.com/css/noto-serif" rel="stylesheet"><style>html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, sub, sup, tt, var, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video, button, input, br, textarea {margin: 0;padding: 0;border: 0;box-sizing: border-box;color: #444;line-height: 1.2;letter-spacing: -0.36px;}* {-webkit-tap-highlight-color: transparent;font-size: 14px;word-break: keep-all;color: #170F00;}@font-face {font-family: "Nanum Myeongjo";src: url("'.$font_path.'/NanumMyeongjo.ttf") format("truetype");}body {font-family:"NanumMyeongjo", "나눔명조", "dotum", "돋움"; font-size: 11px;padding: 30px;}@font-face {font-family: "NanumMyeongjoBold";src: url("'.$font_path.'/NanumMyeongjoBold.ttf") format("truetype");}@font-face {font-family: "NanumMyeongjoExtraBold";src: url("'.$font_path.'/NanumMyeongjoExtraBold.ttf") format("truetype");}@font-face {font-family: "Noto Serif";font-style: normal;font-weight: 400;src: url("'.$font_path.'/NotoSerif-Regular.ttf") format("truetype");}@font-face {font-family: "Noto Serif";font-style: italic;font-weight: 400;src: url("'.$font_path.'/NotoSerif-Italic.ttf") format("truetype");}@font-face {font-family: "Noto Serif";font-style: normal;font-weight: 700;src: url("'.$font_path.'/NotoSerif-Bold.ttf") format("truetype");}@font-face {font-family: "Noto Serif";font-style: italic;font-weight: 700;src: url("'.$font_path.'/NotoSerif-BoldItalic.ttf") format("truetype");}
	'.$inner_style.'</style></head><body><div style="width:794px;">';
	$html .= $inner_body;
	$html .= "</div></body></html>";

	return $html;
}

?>