<?php include_once('./include/head.php'); ?>
<?php include_once('./include/header.php'); ?>

<section class="detail">
	<div class="container">
		<div class="title">
			<h1 class="font_title">Poster Abstract Submission</h1>
		</div>
		<div class="contwrap has_fixed_title">
			<div class="tab_box">
				<ul class="tab_wrap clearfix">
					<li><a href="./abstract_application_detail.php">기본 정보</a></li>
					<li class="active"><a href="./abstract_application_detail2.php">댓글</a></li>
				</ul>
			</div>
			<p class="total_num">총 350개</p>
			<table id="datatable" class="list_table">
				<thead>
					<tr class="tr_center">
						<th>ID(Email)</th>
						<th>이름</th>
						<th>댓글 내용</th>
						<th>등록일</th>
					</tr>
				</thead>
				<tbody>
					<tr class="tr_center">
						<td><a href="./member_detail.php">sample@sample.co.kr</a></td>
						<td>홍길동</td>
						<td class="leftT">댓글 내용이 다 표시됩니다. 200자가 표시됩니다.</td>
						<td>21-08-15</td>
					</tr>
					<tr class="tr_center">
						<td><a href="./member_detail.php">sample@sample.co.kr</a></td>
						<td>홍길동</td>
						<td class="leftT">댓글 내용이 다 표시됩니다. 200자가 표시됩니다.</td>
						<td>21-08-15</td>
					</tr>
					<tr class="tr_center">
						<td><a href="./member_detail.php">sample@sample.co.kr</a></td>
						<td>홍길동</td>
						<td class="leftT">댓글 내용이 다 표시됩니다. 200자가 표시됩니다.</td>
						<td>21-08-15</td>
					</tr>
					<tr class="tr_center">
						<td><a href="./member_detail.php">sample@sample.co.kr</a></td>
						<td>홍길동</td>
						<td class="leftT">댓글 내용이 다 표시됩니다. 200자가 표시됩니다.</td>
						<td>21-08-15</td>
					</tr>
					<tr class="tr_center">
						<td><a href="./member_detail.php">sample@sample.co.kr</a></td>
						<td>홍길동</td>
						<td class="leftT">댓글 내용이 다 표시됩니다. 200자가 표시됩니다.</td>
						<td>21-08-15</td>
					</tr>
					<tr class="tr_center">
						<td><a href="./member_detail.php">sample@sample.co.kr</a></td>
						<td>홍길동</td>
						<td class="leftT">댓글 내용이 다 표시됩니다. 200자가 표시됩니다.</td>
						<td>21-08-15</td>
					</tr>
				</tbody>
			</table>

			<div class="btn_wrap">
				<button type="button" class="border_btn" onclick="location.href='./abstract_application_list.php'">목록</button>
			</div>
		</div>
	</div>
</section>

<?php include_once('./include/footer.php'); ?>