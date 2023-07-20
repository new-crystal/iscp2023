<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_apply_poster"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$abstract_idx = $_GET["idx"];

	$abstract_detail_query =	"
									SELECT 
										ra.submission_code, 
										#ra.city, ra.state, 
										ra.department, ra.affiliation, 
										CONCAT(ra.first_name,' ',ra.last_name) AS `name`, ra.email, 
										#ra.phone, 
										ra.abstract_title, c.title_en AS abstract_category_text,
										ra.presentation_type,
										m.idx AS member_idx, m.member_email, m.member_name, m.member_nation, m.member_register_date,
										f.original_name AS file_name, CONCAT(f.path,'/',f.save_name) AS path,
										n.nation_ko AS nation,
										(CASE
											WHEN ra.oral_presentation = 0
											THEN 'No'
											WHEN ra.oral_presentation = 1
											THEN 'Yes'
											ELSE ''
										END) AS oral_presentation,
										ra.objectives, ra.method, ra.results, ra.conclusions, ra.keywords,
										ra.ask_grants_yn, ra.award_yn, ra.investigator_awards_yn, ra.funding_yn
									FROM request_abstract ra
									LEFT JOIN(
										SELECT
											m.idx, m.email AS member_email, CONCAT(m.first_name,' ',m.last_name) AS member_name, DATE(m.register_date) AS member_register_date, n.nation_ko AS member_nation
										FROM member m
										JOIN nation n
										ON m.nation_no = n.idx
									) AS m
										ON ra.register = m.idx
									LEFT JOIN file f
										ON ra.abstract_file = f.idx
									LEFT JOIN info_poster_abstract_category c
										ON ra.abstract_category = c.idx
									LEFT JOIN nation n
										ON ra.nation_no = n.idx
									WHERE ra.idx = {$abstract_idx}
									OR ra.parent_author = {$abstract_idx}
									ORDER BY `order`
								";

	$abstract_detail = get_data($abstract_detail_query);

	for($i=0; $i<count($abstract_detail); $i++) {
		if($i == 0) {
			$author_detail = $abstract_detail[$i];

			foreach($author_detail as $key => $value) {
				//if($key == "affiliation") {
				//	$author_detail[$key] = isset($author_detail[$key]) ? json_decode($author_detail[$key]) : "-"; 
				//} else {
				//	$author_detail[$key] = isset($author_detail[$key]) ? $author_detail[$key] : "-";
				//}
				
			}
		} else {
			${"co_author_detail".$i} = $abstract_detail[$i];

			foreach(${"co_author_detail".$i} as $key => $value) {
				/*if($key == "affiliation") {
					if ($i == 1){
						${"co_author_detail".$i}[$key] = isset(${"co_author_detail".$i}[$key]) ? json_decode(${"co_author_detail".$i}[$key]) : "-";
					}else{
						${"co_author_detail".$i}[$key] = isset(${"co_author_detail".$i}[$key]) ? ${"co_author_detail".$i}[$key] : "-";
					}
				} else {
					${"co_author_detail".$i}[$key] = isset(${"co_author_detail".$i}[$key]) ? ${"co_author_detail".$i}[$key] : "-";
				}*/
				${"co_author_detail".$i}[$key] = isset(${"co_author_detail".$i}[$key]) ? ${"co_author_detail".$i}[$key] : "-";
			}
		}
	}
?>
	<section class="detail">
		<div class="container">
			<div class="title">
				<h1 class="font_title">Poster Abstract Submission</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<!-- <div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li class="active"><a href="./abstract_application_detail.php">기본 정보</a></li>
						<li><a href="./abstract_application_detail2.php">댓글</a></li>
					</ul>
				</div> -->
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
							<td><a href="./member_detail.php?idx=<?=$author_detail["member_idx"]?>"><?=$author_detail["member_email"]?></a></td>
							<th>Name / Country</th>
							<td><?=$author_detail["member_name"]?> / <?=$author_detail["member_nation"]?></td>
						</tr>
						<tr>
							<th>등록일</th>
							<td><?=$author_detail["member_register_date"]?></td>
							<th>Sumission Code</th>
							<td><?=$author_detail["submission_code"]?></td>
						</tr>
					</tbody>
				</table>
				<h2 class="sub_title">신청자 정보</h2>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<!-- <tr>
							<th>Country</th>
							<td><?=$author_detail["nation"]?></td>
							<th>City</th>
							<td><?=$author_detail["city"]?></td>
						</tr>
						<tr>
							<th>State</th>
							<td><?=$author_detail["state"]?></td>
							<th>Name</th>
							<td><?=$author_detail["name"]?></td>
						</tr>
						<tr>
							<th>Affiliation</th>
							<td><?=$abstract_detail[0]["affiliation"]; ?></td>
							<th>Email</th>
							<td><?=$author_detail["email"]?></td>
						</tr>
						<tr>
							<th>Phone Number</th>
							<td colspan="3"><?=$author_detail["phone"]?></td>
						</tr> -->
						<tr>
							<th>Country</th>
							<td colspan="3"><?=$author_detail["nation"]?></td>
						</tr>
						<tr>
							<th>Affiliation</th>
							<td><?=$abstract_detail[0]["affiliation"]; ?></td>
							<th>Department</th>
							<td><?=$author_detail["department"]?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?=$author_detail["name"]?></td>
							<th>Email</th>
							<td><?=$author_detail["email"]?></td>
						</tr>
					</tbody>
				</table>
				<?php
					$count_co = count($abstract_detail);
					//print_r($abstract_detail);
					if ($count_co <= 1) {
				?>
				<?php
					} else {
				?>
				<h2 class="sub_title">co-author 정보</h2>
				<?php
						for($i=1; $i<$count_co; $i++) {
							$co = ${"co_author_detail".$i};
							//print_r($co);
				?>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<!-- <tr>
							<th>Country</th>
							<td><?=${"co_author_detail".$i}["nation"]?></td>
							<th>City</th>
							<td><?=${"co_author_detail".$i}["city"]?></td>
						</tr>
						<tr>
							<th>State</th>
							<td><?=${"co_author_detail".$i}["state"]?></td>
							<th>Name</th>
							<td><?=${"co_author_detail".$i}["name"]?></td>
						</tr>
						<tr>
							<th>Affiliation</th>
							<td>
							<?php
								if($i == 1){									
									foreach(${"co_author_detail".$i}["affiliation"] as $list) {
										echo $list."<br>";
									}
								}else{
									echo ${"co_author_detail".$i}["affiliation"];
								}
							?>
							</td>
							<th>Email</th>
							<td><?=${"co_author_detail".$i}["email"]?></td>
						</tr>
						<tr>
							<th>Phone Number</th>
							<td colspan="3"><?=${"co_author_detail".$i}["phone"]?></td>
						</tr> -->
						<tr>
							<th>Country</th>
							<td colspan="3"><?=$co["nation"]?></td>
						</tr>
						<tr>
							<th>Affiliation</th>
							<td><?=$co["affiliation"]?></td>
							<th>Department</th>
							<td><?=$co["department"]?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?=$co["name"]?></td>
							<th>Email</th>
							<td><?=$co["email"]?></td>
						</tr>
					</tbody>
				</table>
				<?php
						}
					}
				?>
				<h2 class="sub_title">Abstract 정보</h2>
				<table class="resize_img">
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<!-- <tr>
							<th>Abstract title</th>
							<td><?=$author_detail["abstract_title"]?></td>
							<th>Abstract category</th>
							<td><?=$author_detail["category"]?></td>
						</tr>
						<tr>
							<th>Abstract file</th>
						<?php
							$ext = strtolower(end(explode(".",$author_detail["file_name"])));
							if($ext == "pdf") {
						?>
							<td><a href="./pdf_viewer.php?path=<?=$author_detail["path"]?>" target="_blank"><?=$author_detail["file_name"]?></a></td>
						<?php } else {?>
							<td><a href="<?=$author_detail["path"]?>" download><?=$author_detail["file_name"]?></a></td>
						<?php }?>
							<th>Oral presentation</th>
							<td><?=$author_detail["oral_presentation"]?></td>
						</tr> -->
						<!-- <tr>
							<th>Thumbnail image</th>
							<td colspan="3">
								<div class="img_wrap">
									<img src="" alt="썸네일"> 
								</div>
							</td>
						</tr> -->
						<tr>
							<th>Abstract title</th>
							<td><?=$author_detail["abstract_title"]?></td>
							<th>Abstract file</th>
							<td>
								<?php
									if ($author_detail["file_name"]) {
								?>
								<a href="<?=$author_detail["path"]?>"><?=$author_detail["file_name"]?></a>
								<?php
									} else {
										echo "-";
									}
								?>
							</td>
						</tr>
						<tr>
							<th>Abstract category</th>
							<td><?=$author_detail["abstract_category_text"]?></td>
							<th>Preferred presentation type</th>
							<td><?=$author_detail["presentation_type"]?></td>
						</tr>
						<!-- ra.objectives, ra.method, ra.results, ra.conclusions, ra.keywords -->
						<tr>
							<th>Objectives</th>
							<td colspan="3"><?=htmlspecialchars_decode(stripslashes($author_detail["objectives"]))?></td>
						</tr>
						<tr>
							<th>Method</th>
							<td colspan="3"><?=htmlspecialchars_decode(stripslashes($author_detail["method"]))?></td>
						</tr>
						<tr>
							<th>Results</th>
							<td colspan="3"><?=htmlspecialchars_decode(stripslashes($author_detail["results"]))?></td>
						</tr>
						<tr>
							<th>Conclusions</th>
							<td colspan="3"><?=htmlspecialchars_decode(stripslashes($author_detail["conclusions"]))?></td>
						</tr>
						<tr>
							<th>Keywords</th>
							<td colspan="3"><?=htmlspecialchars_decode(stripslashes($author_detail["keywords"]))?></td>
						</tr>
						<tr>
							<th>Ask for ISCP 2023 Travel Grants</th>
							<td><?=$author_detail["ask_grants_yn"] == "Y" ? "Yes" : "No"?></td>
							<th>Apply for APSAVD Young Investigator Awards</th>
							<td><?=$author_detail["award_yn"] == "Y" ? "Yes" : "No"?></td>
						</tr>
						<tr>
							<th>Ask for IAS Asia-Pacific Federation Young Investigator Grants</th>
							<td><?=$author_detail["investigator_awards_yn"] == "Y" ? "Yes" : "No"?></td>
							<th>Funding Acknowledgments</th>
							<td><?=$author_detail["funding_yn"] == "Y" ? "Yes" : "No"?></td>
						</tr>
					</tbody>
				</table>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./abstract_application_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
<?php include_once('./include/footer.php');?>