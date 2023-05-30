<?php
	include_once("../common/common.php");

	$member_idx = $_SESSION['USER']['idx'];
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1.0, user-scalable=yes">
	<title>ICOMES</title>
	<link rel="shortcut icon" href="./assets/image/favicon.ico" type="image/x-icon">
	<link href="./assets/style/style.css" rel="stylesheet" type="text/css" />
	<script src="./assets/js/jquery.min.js"></script>
	<script src="./assets/js/jquery-ui.min.js"></script>
	<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
	<script src="./assets/js/script.js"></script>
	<!-- slick slider -->
	<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>
<body style="margin:0px" id="silver_bronze">
	<div class="main-body">
		<div id="container">
			<div id="main_content">
				<div id="booth-content">
					<img class="real" src="./assets/image/gold_view.png" style="opacity:0;">
					<a href="https://ibooth.webeon.net/home/ibooth20?idx=<?=$member_idx?>" target="_blank">
						<div class="ic1_on iccl_on"></div>
						<div class="speech_b left">JW Pharmaceutical</div>
						<div class="ic1 iccl obj_delay"></div> 
					</a>   
					<a href="http://ibooth.webeon.net/home/ibooth15?idx=<?=$member_idx?>" target="_blank">
						<div class="ic2_on iccl_on obj_delay"></div>
						<div class="speech_b left">Daiichi-Sankyo</div>
						<div class="ic2 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth14?idx=<?=$member_idx?>" target="_blank">
						<div class="ic3_on iccl_on obj_delay"></div>
						<div class="speech_b left">Aju Pharm</div>
						<div class="ic3 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth17?idx=<?=$member_idx?>" target="_blank">
						<div class="ic4_on iccl_on obj_delay"></div>
						<div class="speech_b left">KWANG DONG Pharmaceutical</div>
						<div class="ic4 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth18?idx=<?=$member_idx?>" target="_blank">
						<div class="ic5_on iccl_on obj_delay"></div>
						<div class="speech_b left">dalim</div>
						<div class="ic5 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth13?idx=<?=$member_idx?>" target="_blank">
						<div class="ic6_on iccl_on obj_delay"></div>
						<div class="speech_b left">Boehringger Ingelheim</div>
						<div class="ic6 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth4?idx=<?=$member_idx?>" target="_blank">
						<div class="ic7_on iccl_on obj_delay"></div>
						<div class="speech_b left">SANOFI</div>
						<div class="ic7 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth3?idx=<?=$member_idx?>" target="_blank">
						<div class="ic8_on iccl_on obj_delay"></div>
						<div class="speech_b left">LG Chem</div>
						<div class="ic8 iccl obj_delay"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth12?idx=<?=$member_idx?>" target="_blank">
						<div class="ic9_on iccl_on obj_delay"></div>
						<div class="speech_b right">BORYUNG Pharmaceutical</div>
						<div class="ic9 iccl obj_delay"></div>
					</a>
					<a href="https://www.novartis.co.kr/" target="_blank">
						<div class="ic10_on iccl_on obj_delay"></div>
						<div class="speech_b left">NOVARTIS</div>
						<div class="ic10 iccl obj_delay"></div>
					</a>
					<a href="https://www.otsuka.co.kr/" target="_blank">
						<div class="ic11_on iccl_on obj_delay"></div>
						<div class="speech_b right">Otsuka Pharmaceutical</div>
						<div class="ic11 iccl obj_delay"></div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div id="bg_cl">
		<div class="clouds">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
</body>
</html>