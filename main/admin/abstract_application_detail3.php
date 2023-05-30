<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../include/submission_data.php');

	if($admin_permission["auth_apply_poster"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$submission_idx = $_GET["idx"];
	$member_idx = $_GET["no"];

	$member_info = "SELECT
						m.idx AS member_idx, m.email, n.nation_ko AS nation, CONCAT(m.first_name,' ',m.last_name) AS name,
						DATE_FORMAT(m.register_date, '%y-%m-%d') AS member_register_date
					FROM member m
					JOIN nation n
					ON m.nation_no = n.idx
					WHERE m.idx = ".$member_idx;
	$member_info_data = sql_fetch($member_info);

	$sql_detail = "
		SELECT
			rs.submission_code,
			`status`,
			preferred_presentation_type,
			topic, topic_detail,
			title,
			objectives, methods, results, conclusions, keywords,
			IFNULL(CONCAT(fi_image1.path, '/', fi_image1.save_name), '') AS image1_path, fi_image1.original_name AS image1_original_name, rs.image1_caption,
			IFNULL(CONCAT(fi_image2.path, '/', fi_image2.save_name), '') AS image2_path, fi_image2.original_name AS image2_original_name, rs.image2_caption,
			IFNULL(CONCAT(fi_image3.path, '/', fi_image3.save_name), '') AS image3_path, fi_image3.original_name AS image3_original_name, rs.image3_caption,
			IFNULL(CONCAT(fi_image4.path, '/', fi_image4.save_name), '') AS image4_path, fi_image4.original_name AS image4_original_name, rs.image4_caption,
			IFNULL(CONCAT(fi_image5.path, '/', fi_image5.save_name), '') AS image5_path, fi_image5.original_name AS image5_original_name, rs.image5_caption,
			rs.similar_yn, rs.support_yn, rs.travel_grants_yn, rs.awards_yn, rs.investigator_grants_yn,
			IFNULL(CONCAT(fi_prove_age.path, '/', fi_prove_age.save_name), '') AS prove_age_path, fi_prove_age.original_name AS prove_age_original_name
		FROM request_submission AS rs
		LEFT JOIN `file` AS fi_image1
			ON fi_image1.idx = rs.image1_file
		LEFT JOIN `file` AS fi_image2
			ON fi_image2.idx = rs.image2_file
		LEFT JOIN `file` AS fi_image3
			ON fi_image3.idx = rs.image3_file
		LEFT JOIN `file` AS fi_image4
			ON fi_image4.idx = rs.image4_file
		LEFT JOIN `file` AS fi_image5
			ON fi_image5.idx = rs.image5_file
		LEFT JOIN `file` AS fi_prove_age
			ON fi_prove_age.idx = rs.prove_age_file
		WHERE rs.is_deleted = 'N'
		AND rs.idx = '".$submission_idx."'
		AND rs.register = '".$member_idx."'
	";

	$detail = sql_fetch($sql_detail);

	if (!$detail) {
		echo "<script>alert('Invalid abstract data.'); history.go(-1);</script>";
		exit;
	}

	// affiliations
	$af_query = "
		SELECT
			rsaf.idx, rsaf.`order`, rsaf.affiliation, rsaf.department, rsaf.department_detail, rsaf.nation_no, n.nation_en AS nation_name_en
		FROM request_submission_affiliation AS rsaf
		LEFT JOIN nation AS n
			ON n.idx = rsaf.nation_no
		WHERE rsaf.is_deleted = 'N'
		AND rsaf.submission_idx = '".$submission_idx."'
		AND rsaf.register = '".$member_idx."'
		ORDER BY rsaf.`order`
	";
	$af_list = get_data($af_query);

	// authors
	$au_query = "
		SELECT
			rsau.idx, 
			rsau.`order`, 
			rsau.same_signup_yn, 
			rsau.presenting_yn, 
			rsau.corresponding_yn, 
			rsau.first_name, rsau.last_name, 
			rsau.name_kor, rsau.affiliation_kor,
			email, 
			affiliation_selected, 
			mobile
		FROM request_submission_author AS rsau
		WHERE rsau.is_deleted = 'N'
		AND rsau.submission_idx = '".$submission_idx."'
		AND rsau.register = '".$member_idx."'
		ORDER BY rsau.`order`
	";


	$au_list = get_data($au_query);

	$au_presenting = array();
	$au_corresponding = array();
	$au_co_author = array();
	/*foreach($au_list as $au){
		if ($au['presenting_yn'] == "Y") {
			$au_presenting = $au;
			//echo "<u>".$au['first_name']." ".$au['last_name']."</u><sup>".$au['order']."</sup>";
		} 
		if ($au['corresponding_yn'] == "Y" && $au['corresponding_yn'] == "N") {
			$au_corresponding = $au;
		}
		if($au['corresponding_yn'] == "N" && $au['corresponding_yn'] == "N") {
			$au_co_author = $au;
		}
		if ($au['order'] < count($au_list)) {
			//echo ", ";
		}
		
		else {
			//echo $au['first_name']." ".$au['last_name']."<sup>".$au['order']."</sup>";
		}
	}*/

	$topic;
	$topic_detail;
	if($detail['topic'] == 0) {
	}
	foreach($topic1_list as $tp){
		if ($tp['idx'] == $detail['topic']) {
			$topic = $tp["idx"].". ".$tp["name_en"];
		}
	}
	if ($detail['topic'] != 5) {
		//echo " / ";
		foreach($topic2_list as $tp){
			if ($tp['idx'] == $detail['topic_detail']) {
				$topic_detail = $tp["idx"].". ".$tp['order'].". ".$tp["name_en"];
			}
		}
	}

	// 소속 구하기
	function get_auther_affiliation($author_idx){
		$sql = "
			SELECT
				#rsaf1.affiliation AS af1, rsaf1.department AS dp1,
				#rsaf2.affiliation AS af2, rsaf2.department AS dp2,
				#rsaf3.affiliation AS af3, rsaf3.department AS dp3
				CONCAT(
					'#', af1, 
					IF(
						af2 = '', 
						'', 
						CONCAT(', #', af2)
					), 
					IF(
						af3 = '', 
						'', 
						CONCAT(', #', af3)
					)
				) AS `text`
			FROM (
				SELECT
					submission_idx, 
					affiliation_selected,
					SUBSTRING_INDEX(affiliation_selected, '|', 1) AS af1,
					SUBSTRING_INDEX(SUBSTRING_INDEX(affiliation_selected, '|', 2), '|', -1) AS af2,
					SUBSTRING_INDEX(affiliation_selected, '|', -1) AS af3 
				FROM request_submission_author
				WHERE idx = '".$author_idx."'
			) AS rsau
		";
		$result = sql_fetch($sql);

		return $result['text'];
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
                        <td><a
                                href="./member_detail.php?idx=<?=$member_info_data["member_idx"]?>"><?=$member_info_data["email"]?></a>
                        </td>
                        <th>Name / Country</th>
                        <td><?=$member_info_data["name"]?> / <?=$member_info_data["nation"]?></td>
                    </tr>
                    <tr>
                        <th>등록일</th>
                        <td><?=$member_info_data["member_register_date"]?></td>
                        <th>Sumission Code</th>
                        <td><?=$detail["submission_code"]?></td>
                    </tr>
                </tbody>
            </table>

            <h2 class="sub_title">소속 정보</h2>
            <?php
					foreach($af_list as $aff) {
				?>
            <table>
                <colgroup>
                    <col width="10%">
                    <col width="40%">
                    <col width="10%">
                    <col width="40%">
                </colgroup>
                <tbody>
                    <tr>
                        <th colspan="4"># <?=$aff["order"]?></th>
                    </tr>
                    <tr>
                        <th>Affiliation</th>
                        <td><?= $aff["affiliation"]?></td>
                        <th>Country</th>
                        <td><?=$aff["nation_name_en"]?></td>
                    </tr>
                    <tr>
                        <th>Department </th>
                        <?php
							foreach($department_list as $dl) {
								if($aff["department"] == $dl["idx"]) {
									$de_name = $dl["name_en"];
								}
							} 
							
							$de_detail = ($aff["department_detail"] != "") ? "(".$aff["department_detail"].")" : "";
						?>
                        <td colspan="3"><?=$de_name."".$de_detail?></td>
                    </tr>
                </tbody>
            </table>
            <?php
					}
				?>

            <h2 class="sub_title">저자 정보</h2>
            <?php
					foreach($au_list as $au) {
				?>
            <table>
                <colgroup>
                    <col width="10%">
                    <col width="40%">
                    <col width="10%">
                    <col width="40%">
                </colgroup>
                <tbody>
                    <tr>
                        <th colspan="4"># <?=$au["order"]?></th>
                    </tr>
                    <?php
						if ($au['same_signup_yn'] == "Y") {
				?>
                    <tr>
                        <th colspan="4">Same as sign-up information</th>
                    </tr>
                    <?php
						}

						if ($au['presenting_yn'] == "Y") {
				?>
                    <tr>
                        <th colspan="4">Presenting author</th>
                    </tr>
                    <?php
						}

						if ($au['corresponding_yn'] == "Y") {
				?>
                    <tr>
                        <th colspan="4">Corresponding author</th>
                    </tr>
                    <?php
						}
				?>
                    <tr>
                        <th>Name</th>
                        <td><?=$au['first_name']." ".$au['last_name']?></td>
                        <th>Affiliation / Department</th>
                        <td><?=get_auther_affiliation($au['idx'])?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $au['email']; ?></td>
                        <th>Phone Number</th>
                        <td><?= $au['mobile'] ?></td>
                    </tr>
                </tbody>
            </table>
            <?php
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
                        <td colspan="3"><?=htmlspecialchars_decode(stripslashes($detail["title"]))?></td>
                        <!-- <th>Abstract file</th> -->
                        <!-- <td> -->
                        <?php
									//if ($author_detail["image1_file"]) {
								?>
                        <!-- <a href="<?=$author_detail["path"]?>"><?=$author_detail["file_name"]?></a> -->
                        <?php
									//} else {
									//	echo "-";
								//	}
								?>
                        <!-- </td> -->
                    </tr>
                    <tr>
                        <th>Preferred presentation type</th>
                        <td colspan="3">
                            <?=($detail["preferred_presentation_type"] == 0) ? "Oral or Poster" : "Poster"; ?></td>
                    </tr>
                    <tr>
                        <th>Topic</th>
                        <td><?= $topic; ?></td>
                        <th>Topic detail</th>
                        <td><?= $topic_detail; ?></td>
                    </tr>
                    <!-- ra.objectives, ra.method, ra.results, ra.conclusions, ra.keywords -->
                    <tr>
                        <th>Objectives</th>
                        <td colspan="3"><?=htmlspecialchars_decode(stripslashes($detail["objectives"]))?></td>
                    </tr>
                    <tr>
                        <th>Materials and Methods</th>
                        <td colspan="3"><?=htmlspecialchars_decode(stripslashes($detail["methods"]))?></td>
                    </tr>
                    <tr>
                        <th>Results</th>
                        <td colspan="3"><?=htmlspecialchars_decode(stripslashes($detail["results"]))?></td>
                    </tr>
                    <tr>
                        <th>Conclusions</th>
                        <td colspan="3"><?=htmlspecialchars_decode(stripslashes($detail["conclusions"]))?></td>
                    </tr>
                    <tr>
                        <th>Keywords</th>
                        <td colspan="3"><?=htmlspecialchars_decode(stripslashes($detail["keywords"]))?></td>
                    </tr>
                    <?php
							for($i=1;$i<=5;$i++){
								$key_prefix = "image".$i."_";
								$key_path = $key_prefix."path";
								if ($detail[$key_path] != "") {
									$key_original_name = $key_prefix."original_name";
									$key_caption = $key_prefix."caption";
						?>
                    <tr>
                        <th>Image <?=$i?></th>
                        <td colspan="3">
                            <img src="<?=$detail[$key_path]?>"
                                download="<?=$detail[$key_original_name]?>"><br><br><?=$detail[$key_caption]?>
                        </td>
                    </tr>
                    <?php
								}
							}
						?>
                    <tr>
                        <th>Have you submitted this abstract or an abstract of a similar topic at another conference?
                        </th>
                        <td><?=$detail["similar_yn"] == "Y" ? "Yes" : "No"?></td>
                        <!-- <th>This research is supported by the grant of Korean Society of Lipid and Atherosclerosis.</th> -->
                        <td><?=$detail["support_yn"] == "Y" ? "Yes" : "No"?></td>
                    </tr>
                    <tr>
                        <th>Ask for ISCP 2023 Travel Grants</th>
                        <td><?=$detail["travel_grants_yn"] == "Y" ? "Yes" : "No"?></td>
                        <th>Apply for APSAVD Young Investigator Awards</th>
                        <td><?=$detail["awards_yn"] == "Y" ? "Yes" : "No"?></td>
                    </tr>
                    <tr>
                        <th>Ask for IAS Asia-Pacific Federation Young Investigator Grants</th>
                        <td colspan="3"><?=$detail["investigator_grants_yn"] == "Y" ? "Yes" : "No"?></td>
                        <!-- <th>Funding Acknowledgments</th> -->
                        <!-- <td><?=$detail["funding_yn"] == "Y" ? "Yes" : "No"?></td> -->
                    </tr>
                    <?php
							$key_prefix = "prove_age_";
							$key_path = $key_prefix."path";
							if ($detail["prove_age_path"] != "") {
								$key_original_name = $key_prefix."original_name";
						?>
                    <tr>
                        <th>Copy of documents(passport) that prove age</th>
                        <td colspan="3">
                            <a href="<?=$detail[$key_path]?>" target="_BLANK"><?=$detail[$key_original_name]?></a>
                        </td>
                    </tr>
                    <?php
							}
						?>
                </tbody>
            </table>
            <div class="btn_wrap">
                <button type="button" class="border_btn"
                    onclick="location.href='./abstract_application_list2.php'">목록</button>
            </div>
        </div>
    </div>
</section>
<?php include_once('./include/footer.php');?>