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
							<tr>
								<th>평점인정<br/>체류시간</th>
								<td><input type="text"></td>
								<th></th>
								<td></td>
							</tr>
						</tbody>
					</table>
				</form>
				<ul class="qr_ul clearfix">
					<li class="color1">
						<p>대한의사협회 평점</p>
						<p>10</p>
					</li>
					<li class="color2">
						<p>대한비만학회 평점</p>
						<p>10</p>
					</li>
					<li class="color3 lineheight_none">
						<p>한국영양교육평가원 <br/>임상영양사 전문연수교육 (CPD) 평점</p>
						<p>10</p>
					</li>
					<li class="color4">
						<p>대한운동사협회 평점</p>
						<p>10</p>
					</li>
				</ul>
			</article>
			<button class="btn yellow_btn">등록</button>
		</section>
	</body>
</html>