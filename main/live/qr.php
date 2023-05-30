<?php include_once ("./include/header.php") ?>
		<section class="container auto qr_page">
			<h2 class="title">출입기록</h2>
			<div class="qr_scan clearfix">
				<div>
					<h2>QR CODE 입력</h2>
					<p>커서를 텍스트박스 안에 놓고 QR 코드 스캐너를 사용하세요.</p>
				</div>
				<div>
					<input type="text" readonly value="asdasdas01021391023">
				</div>
			</div>
			<article class="contents_bg eventZone_1">
				<form action="">
					<table>
						<colgroup>
							<col width="100px"/>
							<col width=""/>
							<col width="100px"/>
							<col width=""/>
						</colgroup>
						<tbody>
							<tr>
								<th class="letter_spacing"><span>이</span>름</th>
								<td><input type="text"></td>
								<th class="letter_spacing"><span>소</span>속</th>
								<td><input type="text"></td>
							</tr>
							<tr>
								<th>입장시간</th>
								<td><input type="text"></td>
								<th>퇴장시간</th>
								<td><input type="text"></td>
							</tr>
						</tbody>
					</table>
				</form>
			</article>
			<button class="btn yellow_btn">등록</button>
		</section>
	</body>
</html>