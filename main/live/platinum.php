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
<body style="margin:0px" id="platinum">
	<div class="main-body">
		<div id="container">
			<div id="main_content">
				<div id="booth-content">
					<img class="real" src="./assets/image/platinum_view.png" style="opacity:0;">
					<a href="https://ibooth.webeon.net/home/ibooth5?idx=<?=$member_idx?>" target="_blank">
						<div class="ic1_on iccl_on"></div>
						<div class="speech_b left">Alvogen</div>
						<div class="ic1 iccl obj_delay"></div> 
						<div class="grade_icons dia_icon"><img src="./assets/image/dia_icon.svg"></div>
					</a>   
					<a href="http://ibooth.webeon.net/home/ibooth11?idx=<?=$member_idx?>" target="_blank">
						<div class="ic2_on iccl_on obj_delay"></div>
						<div class="speech_b left">MSD</div>
						<div class="ic2 iccl obj_delay"></div>
						<div class="grade_icons pla_icon"><img src="./assets/image/pla_icon.svg"></div>
					</a>
					<a href="http://ibooth.webeon.net/home/ibooth16?idx=<?=$member_idx?>" target="_blank">
						<div class="ic3_on iccl_on obj_delay"></div>
						<div class="speech_b left">Novo Nordisk</div>
						<div class="ic3 iccl obj_delay"></div>
						<div class="grade_icons gold_icon"><img src="./assets/image/gold_icon.svg"></div>
					</a>
					<a href="gold.php" target="_self">
						<div class="ic4_on iccl_on obj_delay"></div>
						<div class="speech_b left">Gold Gate</div>
						<div class="ic4 iccl obj_delay"></div>
					</a>
					<a href="silver_bronze.php" target="_self">
						<div class="ic5_on iccl_on obj_delay"></div>
						<div class="speech_b right">Silver & Bronze Gate</div>
						<div class="ic5 iccl obj_delay"></div>
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
		</div>
	</div>
</body>
<html>