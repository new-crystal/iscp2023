<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_apply_lecture"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$lecture_idx = $_GET["idx"];

	$lecture_detail_query = "
								SELECT 
									ra.city, ra.state, CONCAT(ra.first_name,' ',ra.last_name) AS `name`, ra.affiliation, ra.email, ra.phone, ra.cv,
									m.idx AS member_idx, m.member_email, m.member_name, m.member_nation, m.member_register_date,
									lecture.original_name AS lecture_file_name, CONCAT(lecture.path,'/',lecture.save_name) AS lecture_path,
									cv.original_name AS cv_file_name, CONCAT(cv.path,'/',cv.save_name) AS cv_path,
									n.nation_ko AS nation
								FROM request_abstract ra
								LEFT JOIN(
									SELECT
										m.idx, m.email AS member_email, CONCAT(m.first_name,' ',m.last_name) AS member_name, DATE(m.register_date) AS member_register_date, n.nation_ko AS member_nation
									FROM member m
									JOIN nation n
									ON m.nation_no = n.idx
								) AS m
								ON ra.register = m.idx
								LEFT JOIN file lecture
								ON ra.notice_file = lecture.idx
								LEFT JOIN file cv
								ON ra.cv_file = cv.idx
								LEFT JOIN nation n
								ON ra.nation_no = n.idx
								WHERE ra.idx = {$lecture_idx}
								OR ra.parent_author = {$lecture_idx}
							";
	$lecture_detail = get_data($lecture_detail_query);

	for($i=0; $i<count($lecture_detail); $i++) {
		$num = $i+1;
			${"author_detail".$num} = $lecture_detail[$i];
		foreach(${"author_detail".$num} as $key => $value) {
			${"author_detail".$num}[$key] = isset(${"author_detail".$num}[$key]) ? ${"author_detail".$num}[$key] : "-";
		}
	}
?>
	<section class="detail">
		<div class="container">
			<div class="title">
				<h1 class="font_title">Lecture Note Submission</h1>
			</div>
			<div class="contwrap has_fixed_title">
			<?php
			
			?>
				<h2 class="sub_title">회원 정보</h2>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>ID(Email)</th>
							<td><a href="./member_detail.php?idx=<?=$author_detail1["member_idx"]?>"><?=$author_detail1["member_email"]?></a></td>
							<th>Name / Country</th>
							<td><?=$author_detail1["member_name"]?> / <?=$author_detail1["member_nation"]?></td>
						</tr>
						<tr>
							<th>등록일</th>
							<td colspan="3"><?=$author_detail1["member_register_date"]?></td>
						</tr>
					</tbody>
				</table>
				<?php
					for($i=1; $i<count($lecture_detail)+1; $i++) {
						$title = $i == 1 ? "신청자 정보" : "Co-author 정보";
						if($i == 1 || $i == 2) {
				?>
							<h2 class="sub_title">신청자 정보</h2>
				<?php   } ?>
							<table>
								<colgroup>
									<col width="10%">
									<col width="40%">
									<col width="10%">
									<col width="40%">
								</colgroup>
								<tbody>
									<tr>
										<th>Country</th>
										<td><?=${"author_detail".$i}["nation"]?></td>
										<th>City</th>
										<td><?=${"author_detail".$i}["city"]?></td>
									</tr>
									<tr>
										<th>State</th>
										<td><?=${"author_detail".$i}["state"]?></td>
										<th>Name</th>
										<td><?=${"author_detail".$i}["name"]?></td>
									</tr>
									<tr>
										<th>Affiliation</th>
										<td><?=${"author_detail".$i}["affiliation"]?></td>
										<th>Email</th>
										<td><?=${"author_detail".$i}["email"]?></td>
									</tr>
									<tr>
										<th>Phone Number</th>
										<td colspan="3"><?=${"author_detail".$i}["phone"]?></td>
									</tr>
								</tbody>
							</table>
				<?php } ?>
				<h2 class="sub_title">Lecture Note 정보</h2>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>CV file</th>
							<!--기존 CV input text <td><?=$author_detail1["cv"]?></td> -->
							<!-- 21.06.11 퍼블 긴급패치로 인한 추가개발 필요(주석)-->
							<?php
								$ext = strtolower(end(explode(".",$author_detail1["cv_file_name"])));
								if($ext == "pdf") {
							?>
								<td><a href="./pdf_viewer.php?path=<?=$author_detail1["cv_path"]?>" target="_blank"><?=$author_detail1["cv_file_name"]?></a></td>
							<?php } else { ?>
								<td><a href="<?=$author_detail1["cv_path"]?>" download><?=$author_detail1["cv_file_name"]?></a></td>
							<?php } ?>
							<th>Lecture Note file</th>
							<?php
								$ext = strtolower(end(explode(".",$author_detail1["lecture_file_name"])));
								if($ext == "pdf") {
							?>
								<td><a href="./pdf_viewer.php?path=<?=$author_detail1["lecture_path"]?>" target="_blank"><?=$author_detail1["lecture_file_name"]?></a></td>
							<?php } else { ?>
								<td><a href="<?=$author_detail1["lecture_path"]?>" download><?=$author_detail1["lecture_file_name"]?></a></td>
							<?php } ?>
						</tr>
					</tbody>
				</table>

				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./lecture_note_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
<?php include_once('./include/footer.php');?>