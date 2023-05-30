<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('./include/submission_data.php');

	//업데이트 시 abstract 인덱스
	$submission_idx = $_GET["idx"];
	
	//이전 눌렀을 때 값 유지되고 다른 페이지에서 오면 초기화한다.
	if($_SESSION["abstract_flag"] != "true") {
		$_SESSION["abstract"] = "";
	}
	
	$_SESSION["abstract_flag"] = "";
	
	$sql_during =	"SELECT
						IF(DATE(NOW()) BETWEEN period_poster_start AND period_poster_end, 'Y', 'N') AS yn
					FROM info_event";
	$during_yn = sql_fetch($sql_during)['yn'];


	if ($during_yn !== "Y" && (empty($submission_idx))) {
?>
<section class="container submit_application">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Online Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Abstract Submission</li>
                    <li>Online Submission</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner">
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./submission_guideline.php">
                    <!--<?=$locale("abstract_menu1")?>-->Abstract Submission<br>Guideline
                </a></li>
            <li class="on"><a href="./abstract_submission.php">
                    <!--<?=$locale("abstract_menu2")?>-->Online Submission
                </a></li>
            <!--<li><a href="./award.php"><!--<?=$locale("abstract_menu3")?>Awards & Grants</a></li>-->
        </ul>
        <section class="coming">
            <div class="container">
                <div class="sub_banner">
                    <h5>Abstract Submission<br>has been closed</h5>
                </div>
            </div>
        </section>
    </div>
</section>

<?php
	} else {

		//로그인 유무 확인 
		if(empty($_SESSION["USER"])) {
			echo "<script>alert(locale(language.value)('need_login')); location.href=PATH+'login.php';</script>";
			exit;
		}

		// 사전 등록이 된 유저인지 확인
		// 사전 등록 안 해도 제출 가능 하게 바뀌었음으로 주석처리
		//$registration_idx = check_registration($user_info["idx"]);
		//if(!$registration_idx) {
		//	echo "<script>alert(locale(language.value)('check_registration')); location.href=PATH+'registration_guidelines.php'</script>";
		//	exit;
		//}

		// detail
		$sql_detail = "
			SELECT
				`status`,
				preferred_presentation_type,
				topic, topic_detail,
				title,
				objectives, methods, results, conclusions, keywords,
				fi_image1.original_name AS image1_original_name, rs.image1_caption,
				fi_image2.original_name AS image2_original_name, rs.image2_caption,
				fi_image3.original_name AS image3_original_name, rs.image3_caption,
				fi_image4.original_name AS image4_original_name, rs.image4_caption,
				fi_image5.original_name AS image5_original_name, rs.image5_caption,
				rs.similar_yn, rs.support_yn, rs.travel_grants_yn, rs.awards_yn, rs.investigator_grants_yn,
				fi_prove_age.original_name AS prove_age_original_name
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
			AND rs.register = '".$_SESSION["USER"]["idx"]."'
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
			AND rsaf.register = '".$_SESSION["USER"]["idx"]."'
			ORDER BY rsaf.`order`
		";
		$af_list = get_data($af_query);

		// authors
		$au_query = "
			SELECT
				rsau.idx, rsau.`order`, 
				rsau.same_signup_yn, rsau.presenting_yn, rsau.corresponding_yn, 
				rsau.first_name, rsau.last_name, 
				email, rsau.affiliation_selected
			FROM request_submission_author AS rsau
			WHERE rsau.is_deleted = 'N'
			AND rsau.submission_idx = '".$submission_idx."'
			AND rsau.register = '".$_SESSION["USER"]["idx"]."'
			ORDER BY rsau.`order`
		";
		$au_list = get_data($au_query);
		$au_presenting = array();
		$au_corresponding = array();
		$au_co_cuthor = array();

		// 소속 구하기
		function get_auther_affiliation($author_idx){
			$sql = "
				SELECT
					#rsaf1.affiliation AS af1, rsaf1.department AS dp1,
					#rsaf2.affiliation AS af2, rsaf2.department AS dp2,
					#rsaf3.affiliation AS af3, rsaf3.department AS dp3
					CONCAT(
						rsaf1.affiliation, 
						IF(
							rsaf2.affiliation IS NULL, 
							'', 
							CONCAT(', ', rsaf2.affiliation)
						), 
						IF(
							rsaf3.affiliation IS NULL, 
							'', 
							CONCAT(', ', rsaf3.affiliation)
						)
					) AS `text`
				FROM (
					SELECT
						submission_idx, affiliation_selected
					FROM request_submission_author
					WHERE idx = '".$author_idx."'
				) AS rsau
				LEFT JOIN request_submission_affiliation AS rsaf1
					ON (
						rsaf1.submission_idx = rsau.submission_idx
						AND rsaf1.`order` = SUBSTRING_INDEX(affiliation_selected, '|', 1) 
					)
				LEFT JOIN request_submission_affiliation AS rsaf2
					ON (
						rsaf2.submission_idx = rsau.submission_idx
						AND rsaf2.`order` = SUBSTRING_INDEX(SUBSTRING_INDEX(affiliation_selected, '|', 2), '|', -1) 
					)
				LEFT JOIN request_submission_affiliation AS rsaf3
					ON (
						rsaf3.submission_idx = rsau.submission_idx
						AND rsaf3.`order` = SUBSTRING_INDEX(affiliation_selected, '|', -1) 
					)
			";
			$result = sql_fetch($sql);

			return $result['text'];
		}
?>

<!----------------------- 퍼블리싱 구분선 ----------------------->

<section class="container submit_application">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Online Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Abstract Submission</li>
                    <li>Online Submission</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner">
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./submission_guideline.php">
                    <!--<?=$locale("abstract_menu1")?>-->Abstract Submission<br>Guideline
                </a></li>
            <li class="on"><a href="./abstract_submission.php">
                    <!--<?=$locale("abstract_menu2")?>-->Online Submission
                </a></li>
            <!--<li><a href="./award.php"><!--<?=$locale("abstract_menu3")?>Awards & Grants</a></li>-->
        </ul>
        <div class="section section1">
            <div class="steps_area">
                <ul class="clearfix">
                    <li>
                        <p>STEP 01</p>
                        <p class="sm_txt"><?=$locale("abstract_submit_tit1")?></p>
                    </li>
                    <li>
                        <p>STEP 02</p>
                        <p class="sm_txt"><?=$locale("abstract_submit_tit2")?></p>
                    </li>
                    <li class="past">
                        <p>STEP 03</p>
                        <p class="sm_txt"><?=$locale("submit_completed_tit")?></p>
                    </li>
                </ul>
            </div>
            <div class="input_area">
                <form name="abstract_form" class="abstract_form">
                    <div class="circle_title">Preview</div>
                    <div class="x_scroll">
                        <div class="gray_border">
                            <div class="clearfix2">
                                <span>[-]</span>
                                <span>
                                    <?php
										foreach($topic1_list as $tp){
											if ($tp['idx'] == $detail['topic']) {
												echo $tp['order'].'. '.$tp['name_en'];
											}
										}
										if ($detail['topic'] != 5) {
											echo " / ";
											foreach($topic2_list as $tp){
												if ($tp['idx'] == $detail['topic_detail']) {
													echo $tp['parent'].'.'.$tp['order'].'. '.$tp['name_en'];
												}
											}
										}
									?>
                                </span>
                            </div>
                            <ul class="font_style centerT">
                                <li><?=htmlspecialchars_decode($detail['title'], ENT_QUOTES)?></li>
                                <li>
                                    <?php
										foreach($au_list as $k=> $au){
											$au_orders = "";
											$affiliation_selected = explode("|", $au['affiliation_selected']);
											
											foreach($affiliation_selected AS $as) {
												if(!empty($as)) {
													$au_orders .= $as.",";
												}
											}
											$au_orders = substr($au_orders, 0, -1);
											if ($au['presenting_yn'] == "Y") {
												$au_presenting = $au;
												echo "<u>".$au['first_name']." ".$au['last_name']."</u><sup>".$au_orders."</sup>";
											} else {
												echo $au['first_name']." ".$au['last_name']."<sup>".$au_orders."</sup>";
											}
											if ($au['corresponding_yn'] == "Y") {
												$au_corresponding = $au;
											}
											if($au['presenting_yn'] == "N" && $au['corresponding_yn'] == "N") {
												$au_co_cuthor[] = $au;
											}
											if(($k+1) < count($au_list)) {
												echo ", ";
											}
										}
									?>
                                </li>
                                <li>
                                    <?php
										foreach($af_list as $af){
											foreach($department_list as $dp){
												$department_details = "";
												if ($dp['idx'] == $af['department']) {
													if(!empty($af['department_detail'])) {
														$department_details = $af['department_detail'];
													} else {
														$department_details = $dp['name_en'];
													}
									?>
                                    <sup><?=$af['order']?></sup><?=$department_details.", ".$af['affiliation'].", ".$af['nation_name_en']?>
                                    <?php
												}
											}
											if ($af['order'] < count($af_list)) {
									?>
                                    <br>
                                    <?php
											}
										}
									?>
                                </li>
                                <li><?=$au_corresponding['email']?></li>
                            </ul>
                            <ul>
                                <li>
                                    <p class="bold">I. Objectives</p>
                                    <?=htmlspecialchars_decode($detail['objectives'], ENT_QUOTES)?>
                                </li>
                                <li>
                                    <p class="bold">II. Materials and Methods</p>
                                    <?=htmlspecialchars_decode($detail['methods'], ENT_QUOTES)?>
                                </li>
                                <li>
                                    <p class="bold">III. Results</p>
                                    <?=htmlspecialchars_decode($detail['results'], ENT_QUOTES)?>
                                </li>
                                <li>
                                    <p class="bold">IV. Conclusions</p>
                                    <?=htmlspecialchars_decode($detail['conclusions'], ENT_QUOTES)?>
                                </li>
                                <?php
									if ($detail['keywords']) {
								?>
                                <li>
                                    <p class="bold">V. Keywords</p>
                                    <?=htmlspecialchars_decode($detail['keywords'], ENT_QUOTES)?>
                                </li>
                                <?php
									}
								?>
                            </ul>
                            <div class="last_box clearfix">
                                <span>Presenting Author :</span><br />
                                <div>
                                    <?=$au_presenting['first_name']." ".$au_presenting['last_name']?><br />
                                    <!-- <?=$au_presenting['affiliation_kor'].", ".$au_presenting['nation_name_en']?><br/> -->
                                    <!-- <?=get_auther_affiliation($au_presenting['idx'])?><br/>-->
                                    <?php
										foreach($af_list as $af){
											foreach($department_list as $dp){
												$department_details = "";
												if ($dp['idx'] == $af['department']) {
													if(!empty($af['department_detail'])) {
														$department_details = "(".$af['department_detail'].")";
													}
									?>
                                    <sup><?=$af['order']?></sup><?=$dp['name_en']."".$department_details.", ".$af['affiliation'].", ".$af['nation_name_en']?>
                                    <?php
												}
											}

											if ($af['order'] < count($af_list)) {
									?>
                                    <br />
                                    <?php
											}
										}
									?>
                                    <br /><a href="<?=$au_presenting['email']?>"><?=$au_presenting['email']?></a>
                                </div>
                            </div>
                            <div class="last_box clearfix">
                                <span>Corresponding Author :</span><br />
                                <div>
                                    <?=$au_corresponding['first_name']." ".$au_corresponding['last_name']?><br />
                                    <!-- <?=$au_corresponding['affiliation_kor'].", ".$au_corresponding['nation_name_en']?><br/> -->
                                    <!-- <?=get_auther_affiliation($au_corresponding['idx'])?><br/>-->
                                    <?php
										foreach($af_list as $af){
											foreach($department_list as $dp){
												$department_details = "";
												if ($dp['idx'] == $af['department']) {
													if(!empty($af['department_detail'])) {
														$department_details = "(".$af['department_detail'].")";
													}
									?>
                                    <sup><?=$af['order']?></sup><?=$dp['name_en']."".$department_details.", ".$af['affiliation'].", ".$af['nation_name_en']?>
                                    <?php
												}
											}
											if ($af['order'] < count($af_list)) {
									?>
                                    <br />
                                    <?php
											}
										}
									?>
                                    <br /><a href="<?=$au_corresponding['email']?>"><?=$au_corresponding['email']?></a>
                                </div>
                            </div>
                            <?php
							foreach($au_co_cuthor AS $k=>$acc) {
						?>
                            <div class="last_box clearfix">
                                <span>Co-Author<?= ($k+1); ?> :</span><br />
                                <div>
                                    <?=$acc['first_name']." ".$acc['last_name']?></br>
                                    <?php
										foreach($af_list as $af){
											foreach($department_list as $dp){
												$department_details = "";
												if ($dp['idx'] == $af['department']) {
													if(!empty($af['department_detail'])) {
														$department_details = "(".$af['department_detail'].")";
													}
									?>
                                    <sup><?=$af['order']?></sup><?=$dp['name_en']."".$department_details.", ".$af['affiliation'].", ".$af['nation_name_en']?>
                                    <?php
												}
											}
											if ($af['order'] < count($af_list)) {
									?>
                                    <br />
                                    <?php
											}
										}
									?>
                                    <br /><a href="<?=$acc['email']?>"><?=$acc['email']?></a>
                                </div>
                            </div>
                            <?php
							}				
						?>

                        </div>
                    </div>
                </form>
                <div class="pager_btn_wrap">
                    <!-- <button type="button" class="btn submit is_submit" onclick="javascript:window.location.href='./abstract_submission2.php';"><?=$locale("next_btn")?></button> -->
                    <button type="button" class="btn"
                        onclick="javascript:location.href='./abstract_submission2.php?idx=<?=$submission_idx?>';">Modify</button>
                    <?php
						if ($detail['status'] == 0) {
					?>
                    <button type="button" class="btn green_btn submit_btn">Submit</button>
                    <?php
						}
					?>
                </div>
            </div>
        </div>
        <!--//section1-->
    </div>
</section>
<!----------------------- 퍼블리싱 구분선 ----------------------->

<div class="loading"><img src="./img/icons/loading.gif" /></div>
<script>
const submission_idx = '<?=$submission_idx?>';

// save
$('.submit_btn').click(function() {
    pending_on();
    $.ajax({
        url: PATH + "ajax/client/ajax_submission2022.php",
        type: "POST",
        data: {
            flag: 'step3',
            submission_idx: submission_idx
        },
        dataType: "JSON",
        success: function(res) {
            //console.log(res);
            if (res.code == 200) {
                abstract_gmail(res.email, res.name, res.subject, res.title, res.topic_text);
                //alert(locale(language.value)("send_mail_success"));
                location.href = './mypage_abstract.php';
            }
        },
        complete: function() {
            pending_off();
        }
    });
    /* //save */
});


function abstract_gmail(email, name, subject, title, topic_text) {
    pending_on();
    $.ajax({
        url: PATH + "ajax/client/ajax_gmail.php",
        type: "POST",
        data: {
            flag: "abstract",
            email: email,
            name: name,
            subject: subject,
            title: title,
            topic_text: topic_text
        },
        dataType: "JSON",
        success: function(res) {
            if (res.code == 200) {
                location.href = './mypage_abstract.php';
            }
        },
        complete: function() {
            pending_off();
        }
    });
}
</script>
<?php
	}
	include_once('./include/footer.php');
?>