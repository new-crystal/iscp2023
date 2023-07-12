<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../include/submission_data.php');

	$member_idx = $_GET["idx"];
	if(!$member_idx) {
		echo"<script>alert('비정상적인 접근 방법입니다.'); window.location.replace('./member_list.php');</script>";
		exit;
	}
	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$abstract_list_query =  "
								SELECT
									ra.submission_code, ra.idx AS abstract_idx, ra.abstract_title, DATE_FORMAT(ra.register_date, '%y-%m-%d') AS register_date, ra.presentation_type,
									m.idx AS member_idx, m.email, m.name, m.nation,
									f.original_name AS abstract_file_name, CONCAT(f.path,'/',f.save_name) AS path,
									c.title_en AS category
								FROM request_abstract ra
								LEFT JOIN (
									SELECT
										m.idx, m.email, CONCAT(m.first_name,' ',m.last_name) AS name, n.nation_ko AS nation
									FROM member m
									JOIN nation n
									ON m.nation_no = n.idx
								) AS m
									ON ra.register = m.idx
								LEFT JOIN info_poster_abstract_category c
									ON ra.abstract_category = c.idx
								LEFT JOIN file f
									ON ra.abstract_file = f.idx
								WHERE ra.is_deleted = 'N'
								AND ra.parent_author IS NULL
								AND ra.`type` = 0
								AND ra.register = {$member_idx} 
								ORDER BY ra.register_date DESC
							";

	$abstract_list1 = get_data($abstract_list_query);

	$abstract_list_query = "SELECT
								rs.idx,
								member_idx,
								DATE_FORMAT(rs.modify_date, '%y-%m-%d') AS submission_date,
								IFNULL(rs.submission_code,'-') AS submission_code,
								m.email,
								nation_ko,
								`name`,
								CASE
									WHEN preferred_presentation_type = 0 THEN 'Oral or Poster'
									WHEN preferred_presentation_type = 1 THEN 'Poster' 
								END AS pre_type,
								rs.topic,
								rs.topic_detail,
								rs.title,
								rs.objectives,
								rs.methods,
								rs.results,
								rs.conclusions,
								rs.keywords,
								aff.aff_idx,
								aff.aff_affiliation,
								aff.aff_department,
								aff.aff_nation_en,
								GROUP_CONCAT( au.presenting_yn) AS au_presenting_yn,
								GROUP_CONCAT( au.corresponding_yn) AS au_corresponding_yn,
								GROUP_CONCAT( au.affiliation_selected) AS au_affiliation_selected,
								GROUP_CONCAT( au_name) AS au_name,
								GROUP_CONCAT( au_email) AS au_email,
								GROUP_CONCAT( au_phone_number) AS au_phone_number,
								rs.similar_yn,
								rs.support_yn,
								rs.travel_grants_yn,
								rs.awards_yn,
								rs.investigator_grants_yn,
								paths1,
								image1_caption,
								paths2,
								image2_caption,
								paths3,
								image3_caption,
								paths4,
								image4_caption,
								paths5,
								image5_caption,
								documents
							FROM request_submission AS rs
							LEFT JOIN(
								SELECT
									m.idx AS member_idx, m.email, n.nation_ko AS nation_ko, CONCAT(m.first_name,' ',m.last_name) AS `name`
								FROM member m
								JOIN nation n
								ON m.nation_no = n.idx
							) AS m
							ON rs.register = m.member_idx
							LEFT JOIN(
								SELECT 
									aff.idx, aff.submission_idx,
									GROUP_CONCAT(aff.submission_idx ORDER BY aff.`order`) AS aff_idx,
									GROUP_CONCAT(aff.affiliation ORDER BY aff.`order` ASC) AS aff_affiliation,
									GROUP_CONCAT(aff.department ORDER BY aff.`order` ASC) AS aff_department,
									GROUP_CONCAT(n_aff.nation_en ORDER BY aff.`order` ASC) AS aff_nation_en
								FROM request_submission_affiliation AS aff
								LEFT JOIN(
									SELECT
										*
									FROM nation
								) AS n_aff
								ON nation_no = n_aff.idx
								WHERE aff.is_deleted = 'N'
								GROUP BY aff.submission_idx
								ORDER BY aff.`order` DESC
							) AS aff
							ON rs.idx = aff.submission_idx
							LEFT JOIN(
								SELECT	
									au.idx,
									au.submission_idx,
									au.presenting_yn,
									au.corresponding_yn,
									CONCAT(au.first_name,' ',au.last_name) AS au_name,
									au.affiliation_selected,
									au.email AS au_email,
									au.mobile AS au_phone_number
								FROM request_submission_author AS au
								WHERE au.is_deleted = 'N'
								#ORDER BY au.`order`
							) AS au
							ON rs.idx = au.submission_idx
							LEFT JOIN(
								SELECT
									idx,
									CONCAT('https://iscp2023.org',fi1.path,'/',fi1.save_name) AS paths1
								FROM file AS fi1
							) AS fi1
							ON rs.image1_file = fi1.idx
							LEFT JOIN(
								SELECT
									idx,
									CONCAT('https://iscp2023.org',fi2.path,'/',fi2.save_name) AS paths2
								FROM file AS fi2
							) AS fi2
							ON rs.image2_file = fi2.idx
							LEFT JOIN(
								SELECT
									idx,
									CONCAT('https://iscp2023.org',fi3.path,'/',fi3.save_name) AS paths3
								FROM file AS fi3
							) AS fi3
							ON rs.image3_file = fi3.idx
							LEFT JOIN(
								SELECT
									idx,
									CONCAT('https://iscp2023.org',fi4.path,'/',fi4.save_name) AS paths4
								FROM file AS fi4
							) AS fi4
							ON rs.image4_file = fi4.idx
							LEFT JOIN(
								SELECT
									idx,
									CONCAT('https://iscp2023.org',fi5.path,'/',fi5.save_name) AS paths5
								FROM file AS fi5
							) AS fi5
							ON rs.image5_file = fi5.idx
							LEFT JOIN(
								SELECT
									idx,
									CONCAT('https://iscp2023.org',documents.path,'/',documents.save_name) AS documents
								FROM file AS documents
							) AS documents
							ON rs.prove_age_file = documents.idx
							WHERE rs.is_deleted = 'N'
							AND rs.`status` = 1
							AND rs.register = {$member_idx} 
							GROUP BY rs.idx
							ORDER BY rs.register_date DESC
	";

	$abstract_list2 = get_data($abstract_list_query);

?>
<style>
	.no_data {font-size: 18px; text-align: center;}
</style>
	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">일반회원</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<?php include_once("./include/member_nav.php");?>
				<h1 class="font_title">Poster Abstract Submission</h1>
				<table class="list_table">
					<colgroup>
						<col width="15%">
						<col width="40%">
						<col width="25%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr class="tr_center">
							<th>논문번호</th>
							<th>Title</th>
							<th>카테고리</th>
							<th>Oral</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!$abstract_list1) {
							echo "<tr><td class='no_data' colspan='8'>No Data</td></tr>";
						} else {
							foreach($abstract_list1 as $list) {
								$ext = strtolower(end(explode(".",$list["abstract_file_name"])));
					?>
						<tr class="tr_center">
							<td><?=$list["submission_code"]?></td>
							<td><a href="./abstract_application_detail.php?idx=<?=$list["abstract_idx"]?>"><?=$list["abstract_title"]?></a></td>
							<td><?=$list["category"]?></td>
							<td><?=$list["presentation_type"] == "Poster" ? "No" : "Yes"?></td>
							<td><?=$list["register_date"]?></td>
						</tr>
					<?php
							}
						}
					?>
					</tbody>
				</table>
				<h1 class="font_title">Poster Abstract Submission2</h1>
				<table class="list_table" class="list_table table_fixed">
					<colgroup>
						<col width="15%">
						<col width="40%">
						<col width="25%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr class="tr_center">
							<th>논문번호</th>
							<th>Title</th>
							<th>Topic</th>
							<th>Oral</th>
							<th class="ellipsis">등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!$abstract_list2) {
							echo "<tr><td class='no_data' colspan='5'>No Data</td></tr>";
						} else {
							foreach($abstract_list2 as $list) {
								$ext = strtolower(end(explode(".",$list["abstract_file_name"])));
								foreach($topic1_list as $tp){
									if ($tp['idx'] == $list['topic']) {
										$topic = $tp["idx"].". ".$tp["name_en"];
									}
								}
					?>
						<tr class="tr_center">
							<td class="ellipsis"><?=$list["submission_code"]?></td>
							<td><a class="ellipsis" href="./abstract_application_detail3.php?idx=<?=$list["idx"]?>&no=<?= $list['member_idx'] ?>"><?=strip_tags(htmlspecialchars_decode($list["title"]))?></a></td>
							<td><?= $topic; ?></td>
							<td><?=$list["preferred_presentation_type"] == 1 ? "No" : "Yes"?></td>
							<td class="ellipsis"><?=$list["submission_date"]?></td>
						</tr>
					<?php
							}
						}
					?>
					</tbody>
				</table>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./member_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
<script>
$(document).ready(function(){
	$(".tab_wrap").children("li").eq(1).addClass("active");
});
</script>
<?php include_once('./include/footer.php');?>