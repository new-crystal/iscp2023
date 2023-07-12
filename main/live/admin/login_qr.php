<?php include_once('./include/head.php');?>
<html>
	<body>
	<section class="adm_login qrcode_page">
		<form action="">
			<div class="centerT tit">QR Code 입력
				<button class="border_btn">QR 스캔</button>
			</div>
			<ul>
				<li class="clearfix">
					<div class="w100">
						<input type="text" placeholder="휴대폰번호">
						<button class="btn">확인</button>
					</div>
				</li>
				<li class="clearfix">
					<div>
						<label for="">Name</label>
						<input type="text">
					</div>
					<div>
						<label for="">Entrance Time</label>
						<input type="text">
					</div>
				</li>
				<li class="clearfix">
					<div>
						<label for="">Affiliation</label>
						<input type="text">
					</div>
					<div>
						<label for="">Exit time</label>
						<input type="text">
					</div>
				</li>
			</ul>
			<button type="button" class="btn" onclick="javascript:window.location.href='./member_list.php'">등록</button>
		</form>
	</section>


	</body>
</html>