<?php
	include_once('./include/head.php');

	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.")</script>';
		echo '<script>window.close();</script>';
	}

	$member_idx = $_GET["idx"];

	if ($member_idx == "all") {
		$sql_info = "SELECT
						mb.idx,
						md5(mb.idx) AS idx_encrypt,
						mb.last_name, mb.first_name,
						mb.affiliation,
						req.pay_unit, req.pay_price
					FROM member AS mb
					INNER JOIN (
						SELECT
							rr.idx, rr.register, 
							(
								CASE pmt.`type`
									WHEN 0 THEN 'KRW'
									WHEN 1 THEN 'USD'
									WHEN 2 THEN IF(pmt.total_price_kr IS NOT NULL, 'KRW', 'USD')
									WHEN 3 THEN ''
								END
							) AS pay_unit, 
							(
								CASE pmt.`type`
									WHEN 0 THEN pmt.total_price_kr
									WHEN 1 THEN pmt.total_price_us
									WHEN 2 THEN IFNULL(pmt.total_price_kr, pmt.total_price_us)
									WHEN 3 THEN 0
								END
							) AS pay_price
						FROM request_registration AS rr
						INNER JOIN payment AS pmt
							ON pmt.idx = rr.payment_no
						WHERE rr.`status` = 2
						AND rr.attendance_type IN (0, 2)
					) AS req
						ON req.register = mb.idx";
	} else {
		$sql_info = "SELECT
						mb.idx,
						md5(mb.idx) AS idx_encrypt,
						mb.last_name, mb.first_name,
						mb.affiliation,
						req.pay_unit, req.pay_price
					FROM member AS mb
					INNER JOIN (
						SELECT
							rr.idx, rr.register, 
							(
								CASE pmt.`type`
									WHEN 0 THEN 'KRW'
									WHEN 1 THEN 'USD'
									WHEN 2 THEN IF(pmt.total_price_kr IS NOT NULL, 'KRW', 'USD')
									WHEN 3 THEN ''
								END
							) AS pay_unit, 
							(
								CASE pmt.`type`
									WHEN 0 THEN pmt.total_price_kr
									WHEN 1 THEN pmt.total_price_us
									WHEN 2 THEN IFNULL(pmt.total_price_kr, pmt.total_price_us)
									WHEN 3 THEN 0
								END
							) AS pay_price
						FROM request_registration AS rr
						INNER JOIN payment AS pmt
							ON pmt.idx = rr.payment_no
						WHERE rr.`status` = 2
						AND rr.attendance_type IN (0, 2)
					) AS req
						ON req.register = mb.idx
					WHERE mb.idx = '".$member_idx."'";
	}
	$infoes = get_data($sql_info);

	if(!is_array($infoes)){
		echo '<script>alert("조회된 내역이 없습니다.")</script>';
		echo '<script>window.close();</script>';
	}
?>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<!--<link href="http://conf.webeon.net/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">-->
	<link href="/main/live/assets/style/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="/main/css/core.css" rel="stylesheet" type="text/css">
	<link href="/main/live/assets/style/components.css" rel="stylesheet" type="text/css">
	<link href="/main/live/assets/style/colors.css" rel="stylesheet" type="text/css">
	<!-- Bootstrap CSS -->
	<!--<link href="/assets/css/bootstrap.min.css" rel="stylesheet">-->
	<!-- bootstrap theme -->
	<!-- /global stylesheets -->

	<!-- Custom styles -->
	<!--<link href="/assets/css/admin_style.css" rel="stylesheet">-->
	<link href="/main/live/assets/style/admin_style-responsive.css" rel="stylesheet">

	<!-- Core JS files -->
	<script type="text/javascript" src="/main/live/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/main/live/assets/js/select2.min.js"></script>
	<!-- /core JS files -->

	<script type="text/javascript" src="/main/admin/js/qrcode.js"></script>

	<style>
		body{background-color: #fff;}
	</style>
	<body>
		<div id="nametag_wrapper">
			<div class="edit_wrapper">
				<button id="btnPrint" type="button" class="btn btn-primary" style="margin-left:20px;">Print</button>
			</div>
			<!-- Content area -->
			<div class="content" id="nametag<?=$info['idx']?>">
				<div id="printThis">
                <?php
                    foreach ($infoes as $info) {
                ?>
				<div class="a4_area">
					<div class="bg_area">
						<div style="display: none;">1</div>
						<div class="txt_con">
							<div class="nick_name" id="nick_name"><?=$info['last_name']." ".$info['first_name']?></div>
							<div class="org draggable"><?=$info['affiliation']?></div>
							<div id="qrcode<?=$info['idx']?>" class="draggable qrcodes" data-encrypt="<?=$info['idx_encrypt']?>"></div>
							<!-- 영수증 삭제-->
							<!--
							<div class="receipt receipt_name"><?=$info['last_name'].$info['first_name']?></div>
							<div class="payment_price"><?=$info['pay_unit']." ".number_format($info['pay_price'])?></div>
							-->
						</div>
					</div>
				</div>
                <!-- /content area -->
                <?php
                    }
                ?>
			</div>
		</div>
		<script>
			document.getElementById("btnPrint").onclick = function () {
				printElement(document.getElementById("printThis"));
			}

			function printElement(elem) {
				var domClone = elem.cloneNode(true);

				var $printSection = document.getElementById("printSection");

				if (!$printSection) {
					var $printSection = document.createElement("div");
					$printSection.id = "printSection";
					document.body.appendChild($printSection);
				}

				$printSection.innerHTML = "";
				$printSection.appendChild(domClone);
				window.print();
			}

			// qrcode 생성
			document.querySelectorAll("div.content .qrcodes").forEach(function(el){
				var qrcode = new QRCode(document.getElementById(el.id), {
					text: el.dataset.encrypt,
					width: 128,
					height: 128,
					colorDark : "#000000",
					colorLight : "#ffffff",
					correctLevel : QRCode.CorrectLevel.H
				});
			});
		</script>
	</body>
</html>