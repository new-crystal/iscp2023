<head>
    <meta name="robots" content="noindex">
    <meta http-equiv="refresh" content="0;URL='https://iscp2023.org/main'" />
    <meta property="og:image" content="/main/img/xg_image.png" />
</head>
<?php
	exit;

	include_once('./include/head.php');
	include_once('./include/header.php');
	
	//이전 눌렀을 때 값 유지되고 다른 페이지에서 오면 초기화한다.
	//if($_SESSION["lecture_flag"] != "true") {
		//$_SESSION["lecture"] = "";
//	}
	
//	$_SESSION["lecture_flag"] = "";
	
	$sql_during =	"SELECT
						IF(DATE(NOW()) BETWEEN period_poster_start AND period_poster_end, 'Y', 'N') AS yn
					FROM info_event";
	$during_yn = sql_fetch($sql_during)['yn'];


	if ($during_yn !== "Y") {
?>

<section class="container submit_application sub_page">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Lecture Note Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Lecture Note Submission (invited speaker)</li>
                    <li>Online Submission</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner">
        <!-- location -->
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./lecture_note_submission.php">Lecture Note Submission Guideline</a></li>
            <li class="on"><a href="javascript:;">Online Submission</a></li>
        </ul>
        <section class="coming">
            <div class="container">
                <div class="sub_banner">
                    <h5>Poster Abstract Submission<br>has been closed</h5>
                </div>
            </div>
        </section>
</section>

<?php
	} else {
		//업데이트 시 lecture 인덱스
		$lecture_idx = $_GET["idx"];

		//로그인 유무 확인 
		if(empty($_SESSION["USER"])) {
			echo "<script>alert(locale(language.value)('need_login')); location.href=PATH+'login.php';</script>";
			exit;
		} else {
			//로그인 회원 정보
			$user_info = $member;
		}

		// 사전 등록이 된 유저인지 확인
		// 사전 등록 안 해도 제출 가능 하게 바뀌었음으로 주석처리
		//$registration_idx = check_registration($user_info["idx"]);
		//if(!$registration_idx) {
		//	echo "<script>alert(locale(language.value)('check_registration')); location.href=PATH+'registration_guidelines.php'</script>";
		//	exit;
		//}
		
		// 제출 유무 확인 주석 안함 (중복제출(불)가능)
		if(!$lecture_idx) {
			//제출 유무 확인
			$check_submission = check_submission($user_info["idx"], "lecture");
			if($check_submission) {
				echo "<script>alert(locale(language.value)('already_submission')); location.href=PATH+'mypage_abstract.php'</script>";
				exit;
			}
		}
	
		//$_nation_query
		//한국을 가장 위로
		$nation_query = "SELECT
							*
						FROM nation
						ORDER BY 
						idx = 25 DESC, nation_en ASC";
	 
		//국가정보 가져오기
		$nation_list = get_data($nation_query);

		//카테고리 정보 가져오기
		//$category_list = get_data($_lecture_category_query);

		// -------------------------------------------------------------- Abstrcat Update -------------------------------------------------------------- //
		if($lecture_idx) {

			$lecture_sql = "
								SELECT
									ra.idx, ra.nation_no, ra.last_name, ra.first_name, ra.city, ra.state, ra.affiliation,
									ra.email, ra.phone
								FROM request_abstract AS ra
								WHERE ra.is_deleted = 'N'
							";
			
			$authors = sql_fetch($lecture_sql." AND ra.idx = {$lecture_idx} AND ra.parent_author IS NULL ORDER BY ra.register_date DESC LIMIT 1");

			if($authors["idx"] == ""){
				echo "<script>alert('Invalid lecture data'); history.back();</script>";
				exit;
			}
			
			//$submit_data = isset($_SESSION["lecture"]["data"]) ? $_SESSION["lecture"]["data"] : "";

			//foreach($authors as $k => $v){
			//	
			//	$user_info[$k] = $v;

			//	if($k == "affiliation") {
			//		$user_info["affiliation"] = !empty($_SESSION["lecture"]) ? $submit_data['affiliation'] : json_decode($v);
			//		$user_info["affiliation_value"] = !empty($_SESSION["lecture"]) ? $submit_data['affiliation'] : implode(json_decode($v), ","); 
			//	}
			//	
			//}
			///*
			//$co_authors = sql_fetch($lecture_sql." AND ra.parent_author = {$lecture_idx} AND ra.city IS NOT NULL ORDER BY ra.idx ASC");
			//*/
			//$co_authors = sql_fetch($lecture_sql." AND ra.parent_author = {$lecture_idx} AND ra.city IS NOT NULL ORDER BY ra.idx ASC");

			//foreach($co_authors as $k => $v){
			//	$user_info["co_".$k] = $v;

			//	if($k == "affiliation") {
			//		$user_info["co_affiliation"] = json_decode($v);
			//		$user_info["co_affiliation_value"] = implode(json_decode($v), ","); 
			//	}

			//	if($k == "phone"){
			//		$_arr_phone = explode("-", $v);
			//		$co_nation_tel = $_arr_phone[0];
			//		$co_phone = implode("-",array_splice($_arr_phone, 1));

			//		$user_info["co_nation_tel"] = $co_nation_tel;
			//		$user_info["co_phone"] = $co_phone;
			//	}
			//}

			
			//$add_co_authors = get_data($lecture_sql." AND ra.parent_author = {$lecture_idx} AND ra.phone IS NULL ORDER BY ra.idx ASC"); 
			
			//$no = 0;
			//$collect_key = ["first_name", "last_name", "affiliation", "email"];
			//foreach($add_co_authors as $ca){
			//	foreach($ca as $k => $v){
			//		if(in_array($k, $collect_key)){
			//			$coauthor_submit_data[$no]["add_co_".$k.$no] = $v;

			//			if($k == "affiliation") {
			//				$coauthor_submit_data[$no]["add_co_".$k.$no] = ($v); 
			//				$coauthor_submit_data[$no]["add_co_".$k."_value".$no] = ($v);
			//			}
			//		}
			//	}
			//	
			//	$no = $no + 1;
			//}


			$count_idx_query =  "
									SELECT
										COUNT(idx) AS cnt
									FROM request_abstract
									WHERE is_deleted = 'N'
									AND parent_author = {$lecture_idx}
								";

			$count = sql_fetch($count_idx_query)['cnt'];

			$lecture_query = "SELECT
									idx, nation_no, last_name, first_name, affiliation,
									email, department
								FROM request_abstract
								WHERE is_deleted = 'N'
								AND idx = {$lecture_idx}";

			$lecture_result = sql_fetch($lecture_query);


			$coauthor_lecture_query = "SELECT
											idx, nation_no, last_name, first_name, affiliation, 
											email, department
										FROM request_abstract
										WHERE is_deleted = 'N'
										AND parent_author = {$lecture_idx}
									 	ORDER BY `order`";

			$coauthor_lecture_result = get_data($coauthor_lecture_query);
		
		}

		// -------------------------------------------------------------- Abstrcat Insert -------------------------------------------------------------- //

		//세션에 저장된 논문 제출 데이터 (step2에서 step1으로 되돌아올시) update 세션 포함

		$data_count = $_SESSION["lecture"] ? count($_SESSION["lecture"]) : $count;

		$coauthor_submit_data = array();

		//update
		if($lecture_idx) {

			$submit_data = isset($_SESSION["lecture"]["data"]) ? $_SESSION["lecture"]["data"] : $lecture_result;

			$co_submit_data1 = isset($_SESSION["lecture"]["co_data1"]) ? $_SESSION["lecture"]["co_data1"] : $coauthor_lecture_result[0];

			if(isset($_SESSION["lecture"]["data"])) {
				for($i=0; $i<($data_count-2); $i++) {
					$coauthor_submit_data[$i] = isset($_SESSION["lecture"]["coauthor_data".$i]) ? $_SESSION["lecture"]["coauthor_data".$i] : $coauthor_submit_data[$i];	
				}
			} else {
				//co_author데이터 for문(INTO-ON)
				for($i=0; $i<$data_count; $i++) {
					
					$coauthor_submit_data[$i]["co_nation_no"] = $coauthor_lecture_result[$i]['nation_no'];
					$coauthor_submit_data[$i]["co_last_name"] = $coauthor_lecture_result[$i]['last_name'];
					$coauthor_submit_data[$i]["co_first_name"] = $coauthor_lecture_result[$i]['first_name'];
					$coauthor_submit_data[$i]["co_affiliation"] = $coauthor_lecture_result[$i]['affiliation'];
					$coauthor_submit_data[$i]["co_email"] = $coauthor_lecture_result[$i]['email'];
					$coauthor_submit_data[$i]["co_department"] = $coauthor_lecture_result[$i]['department'];
					$coauthor_submit_data[$i]["co_idx"] = $coauthor_lecture_result[$i]['idx'];

				}
				$data_count = $data_count + 2;
			}
		}
		//insert
		else {
			$submit_data = isset($_SESSION["lecture"]["data"]) ? $_SESSION["lecture"]["data"] : "";

			//print_r($_SESSION["lecture"]["data"]);
		//	exit;

			$co_submit_data1 = isset($_SESSION["lecture"]["co_data1"]) ? $_SESSION["lecture"]["co_data1"] : "";

			//co_author데이터 for문(INTO-ON)
			for($i=0; $i<($data_count-2); $i++) {
				$coauthor_submit_data[$i] = isset($_SESSION["lecture"]["coauthor_data".$i]) ? $_SESSION["lecture"]["coauthor_data".$i] : $coauthor_submit_data[$i];		
			}	
		}

		$nation_no = !empty($submit_data) ? $submit_data["nation_no"] : $user_info["nation_no"];

		$first_name = !empty($submit_data) ? $submit_data["first_name"] : $user_info["first_name"];
		$last_name = !empty($submit_data) ? $submit_data["last_name"] : $user_info["last_name"];

		$affiliation = !empty($submit_data) ? $submit_data["affiliation"] : $user_info["affiliation"];
		$department = !empty($submit_data) ? $submit_data["department"] : $user_info["department"];

		$email = !empty($submit_data) ? $submit_data["email"] : $user_info["email"];
		$co_nation_no = !empty($submit_data) ? $submit_data["co_nation_no"] : $user_info["co_nation_no"];
		$co_first_name = !empty($submit_data) ? $submit_data["co_first_name"] : $user_info["co_first_name"];
		$co_last_name = !empty($submit_data) ? $submit_data["co_last_name"] : $user_info["co_last_name"];
		$co_affiliation = !empty($submit_data) ? $submit_data["co_affiliation"] : $user_info["co_affiliation"];
		$co_email = !empty($submit_data) ? $submit_data["co_email"] : $user_info["co_email"];


		if($lecture_idx) {
			//co_author데이터 for문(INTO-ON)
			for($i=0; $i<$data_count-1; $i++) {
				//coauthor
				$coauthor_nation_no[$i] =!empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_nation_no"] : "";
				$coauthor_first_name[$i] =!empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_first_name"] : "";	
				$coauthor_last_name[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_last_name"] : "";
				$coauthor_email[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_email"] : "";
				$coauthor_affiliation[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_affiliation"] : "";
				$coauthor_affiliation_value[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_affiliation"] : "";
				$coauthor_department[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_department"] : "";
				$coauthor_idx[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_idx"] : -1;

			}
		} else {
			//co_author데이터 for문(INTO-ON)
			for($i=0; $i<(($data_count)-2); $i++) {
				$coauthor_nation_no[$i] =!empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_nation_no"] : "";
				$coauthor_first_name[$i] =!empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_first_name"] : "";	
				$coauthor_last_name[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_last_name"] : "";
				$coauthor_email[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_email"] : "";
				$coauthor_affiliation[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_affiliation"] : "";
				$coauthor_affiliation_value[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_affiliation"] : "";
				$coauthor_department[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_department"] : "";
				$coauthor_idx[$i] = !empty($coauthor_submit_data[$i]) ? $coauthor_submit_data[$i]["co_idx"] : -1;

			}
		}
		

		if(!empty($nation_list)) {	
			echo "<script> var nation = [];";
				foreach($nation_list AS $list) {
					$idx = $list["idx"];
					$nation_ko = $list["nation_ko"];
					$nation_en = $list["nation_en"];

					echo "nation.push({idx : {$idx}, nation_ko : '{$nation_ko}', nation_en : '{$nation_en}'});";
				}
			}
			echo "</script>";

		//제출타입 지정
		echo "<script>var type = 'lecture';</script>";
?>

<section class="container submit_application lecture_submission">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Lecture Note Submission</h2>
                <ul>
                    <li>Home</li>
                    <li>Call for Abstracts</li>
                    <li>Lecture Note Submission (invited speaker)</li>
                    <li>Online Submission</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="inner bottom_short">
        <!-- location -->
        <ul class="tab_pager location tab_pager_small">
            <li><a href="./lecture_note_submission.php">Lecture Note Submission Guideline</a></li>
            <li class="on"><a href="javascript:;">Online Submission</a></li>
        </ul>
        <!-- steps_area -->
        <div class="steps_area">
            <ul class="clearfix">
                <li class="past">
                    <p>STEP 01</p>
                    <p class="sm_txt">
                        <!-- <?=$locale("lecture_submit_tit1")?> --> Presenting author’s<br>contact details
                    </p>
                </li>
                <li>
                    <p>STEP 02</p>
                    <p class="sm_txt">
                        <!-- <?=$locale("lecture_submit_tit2")?> --> Complete lecture note
                    </p>
                </li>
                <li>
                    <p>STEP 03</p>
                    <p class="sm_txt"><?=$locale("submit_completed_tit")?></p>
                </li>
            </ul>
        </div>
        <!-- form_area -->
        <div class="input_area">
            <form name="lecture_form">
                <ul class="sign_list max685">
                    <li>
                        <p class="label"><span class="red_txt">*</span><?=$locale("country")?></p>
                        <div>
                            <select class="required" name="nation_no">
                                <option value="" selected hidden>Choose</option>
                                <?php
										foreach($nation_list AS $list) {
											$nation = $language == "en" ? $list["nation_en"] : $list["nation_ko"];
											$selected = $nation_no == $list["idx"] ? "selected" : "";
											echo "<option value='".$list["idx"]."'".$selected.">".$nation."</option>";
										}
									?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span><?=$locale("affiliation")?></p>
                        <div>
                            <input class="required" type="text" name="affiliation" value="<?=$affiliation; ?>"
                                maxlength="100">
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Department</p>
                        <div>
                            <input type="text" name="department" value="<?=$department; ?>" maxlength="100">
                        </div>
                    </li>
                    <li>
                        <p class="label"><span class="red_txt">*</span>Name</p>
                        <div class="half_form clearfix">
                            <input class="required" type="text" name="first_name" value="<?=$first_name?>">
                            <input class="required" type="text" name="last_name" value="<?=$last_name?>">
                        </div>
                    </li>
                    <li>
                        <p class="label"><?=$locale("email")?></p>
                        <div>
                            <input class="required" type="text" name="email" value="<?=$email?>">
                        </div>
                    </li>
                </ul>
            </form>

            <!-- <form name="co_lecture_form"></form> -->

            <div class="clearfix2 coauther_wrap">
                <p>
                    <!--<?=$locale("check_co_author2")?>-->Have a co-author?
                </p>
                <!-- 기존 radio로 co-author를 추가했지만, 추가 버튼으로 입력값 append형태로 변경 -->
                <div class="radio_wrap">
                    <ul class="flex">
                        <?php
								if(!empty($co_submit_data1)) {
							?>
                        <li><input type="radio" class="radio" id="co_yes" name="co_yn" value="Y" checked><label
                                for="co_yes">Yes</label></li>
                        <li><input type="radio" class="radio" id="co_no" name="co_yn" value="N"><label
                                for="co_no">No</label></li>
                        <?php
								} else {
							?>
                        <li><input type="radio" class="radio" id="co_yes" name="co_yn" value="Y"><label
                                for="co_yes">Yes</label></li>
                        <li><input type="radio" class="radio" id="co_no" name="co_yn" value="N" checked><label
                                for="co_no">No</label></li>
                        <?php
								}
							?>

                    </ul>
                </div>
                <!--
					<div>
						<select class="number_of_author">
							<?php 
								for($i=0; $i<=10; $i++)
								{   
									if($i == 0){
										echo "<option value='0' selected>Select</option>";
									}else{
										if(($data_count-2) == $i){
											echo "<option value=".$i." selected>".$i."</option>";
										}else{
											echo "<option value=".$i.">".$i."</option>";
										}
									}
								}
							?> 
						</select>
					</div>
					-->
            </div>

            <!----------------------------------------------------------->

            <!--coauthor append-->
            <div class="co_author_appended">
                <?php
						//echo $nation_list[1]['idx'];
						//exit;
						$i=0;
						if($coauthor_submit_data[0] != "") {
							for($i=0; $i<($data_count-2); $i++) {
								echo '<form class="number_of_author" name="coauthor_lecture_form">';
								echo	'<ul class="sign_list max685">';
								echo		'<li>';
								echo			'<p class="label"><span class="red_txt">*</span>'.$locale("country").'</p>';
								echo			'<div>';
								echo				'<select class="required co_nation" name="co_nation_no" data-count='.$i.'>';
														for($j=0; $j<count($nation_list); $j++) {
															$nation = $language == "en" ? $nation_list[$j]['nation_en'] : $nation_list[$j]['nation_ko'];
															$selected = $coauthor_nation_no[$i] == $nation_list[$j]['idx'] ? "selected" : "";
															echo '<option value="'.$nation_list[$j]['idx'].'" '.$selected.'>'.$nation.'</option>';
														}
								echo				'</select>';
								echo			'</div>';
								echo		'</li>';
								echo		'<li>';
								echo			'<p class="label"><span class="red_txt">*</span>'.$locale("affiliation").'</p>';
								echo			'<div><input class="required" type="text" name="co_affiliation" value="'.$coauthor_affiliation[$i].'" maxlength="100"></div>';
								echo		'</li>';
								echo		'<li>';
								echo			'<p class="label"><span class="red_txt">*</span>Department</p>';
								echo			'<div><input class="required" type="text" name="co_department" value="'.$coauthor_department[$i].'" maxlength="100"></div>';
								echo		'</li>';
								echo		'<li>';
								echo			'<p class="label"><span class="red_txt">*</span>Name</p>';
								echo			'<div class="half_form clearfix">';
								echo				'<input class="required" type="text" name="co_first_name" value="'.$coauthor_first_name[$i].'" maxlength="50">';
								echo				'<input class="required" type="text" name="co_last_name" value="'.$coauthor_last_name[$i].'" maxlength="50">';
								echo			'</div>';
								echo		'</li>';
								echo		'<li>';
								echo			'<p class="label">'.$locale("email").'</p>';
								echo			'<div><input class="required" type="text" name="co_email" value="'.$coauthor_email[$i].'" maxlength="50"></div>';
								echo		'</li>';
								echo		'<li>';
								echo			'<div class="co_author_btn_wrap">';
								echo				'<button type="button" class="co_author_add">add</button>';
								echo				'<button type="button" data-order='.$i.' class="co_author_del">Del</button>';					
								echo				'<input name="co_idx" type="hidden" value="'.$coauthor_idx[$i].'">';
								echo			'</div>';
								echo		'</li>';
								echo	'</ul>';
								echo'</form>';
								
							}	
						}
						//if($coauthor_submit_data[0] != "") {
						//	for($i=0; $i<($data_count-2); $i++) {
						//		$display = $coauthor_affiliation[$i] != "" ? "block" : "none";
						//		echo	'<div class="section_title_wrap2">';
						//		echo		'<h3 class="title">'.$locale("co_author_tit").($i+1).'</h3>';
						//		echo	'</div>';
						//		echo  '<form name="coauthor_lecture_form'.$i.'">';
						//		echo	  '<div class="table_wrap c_table_wrap input_table" style="margin-top:20px;">';
						//		echo		'<table class="c_table">';
						//		echo			'<tr>';
						//		echo				'<th>'.$locale("first_name").' *</th>';
						//		echo				'<td><input class="required" type="text" name="add_co_first_name'.$i.'" value="'.$coauthor_first_name[$i].'" maxlength="50"></td>';
						//		echo			'</tr>';
						//		echo			'<tr>';
						//		echo				'<th>'.$locale("last_name").' *</th>';
						//		echo				'<td><input class="required" type="text" name="add_co_last_name'.$i.'" value="'.$coauthor_last_name[$i].'" maxlength="50"></td>';
						//		echo			'</tr>';
						//		echo			'<tr>';
						//		echo				'<th>'.$locale("email").' *</th>';
						//		echo				'<td><input class="required" type="text" name="add_co_email'.$i.'" value="'.$coauthor_email[$i].'" maxlength="50"></td>';
						//		echo			'</tr>';
						//		echo			'<tr>';
						//		echo				'<th>'.$locale("affiliation").' *</th>';
						//		echo				'<td class="affiliation_td">';
						//		echo					'<div class="clearfix affiliation_input">';
						//		echo						'<input type="text" class="institution" placeholder="Institution">';
						//		echo						'<input type="text" class="department" placeholder="Department">';
						//		echo						'<button type="button" class="btn affiliation_add">ADD</button>';
						//		echo					'</div>';
						//		echo					'<ul class="affiliation_wrap affiliation_wrap_'.$i.'" style="display:'.$display.'">';
						//								if($coauthor_affiliation[$i] != "") {
						//									$affiliation_arr = explode(",",$coauthor_affiliation_value[$i]);
						//									foreach($affiliation_arr as $list) {
						//										echo '<li class="clearfix">';
						//										echo	'<p>'.$list.'</p>';
						//										echo	'<button type="button" class="btn affiliation_delete">Delete</button>';
						//										echo '</li>';
						//									}
						//								}
						//		echo					'</ul>';
						//		echo				 '<input type="hidden" name="add_co_affiliation'.$i.'" value="'.$coauthor_affiliation_value[$i].'">';
						//		echo				'</td>';
						//		echo			'</tr>';
						//		echo		'</table>';
						//		echo	'</div>';
						//		echo '</form>';
						//	}
						//}
					?>
            </div>

            <!----------------------------------------------------------->
            <div class="pager_btn_wrap">
                <!-- <button type="button" class="btn submit is_submit" onclick="javascript:window.location.href='./lecture_submission2.php';"><?=$locale("next_btn")?></button> -->
                <button type="button" class="btn green_btn submit_btn"
                    data-idx=<?=$lecture_idx?>><?=$locale("next_btn")?></button>
            </div>
        </div>
    </div>
    <!--//section1-->
    </div>
</section>
<!----------------------- 퍼블리싱 구분선 ----------------------->

<script src="./js/script/client/submission.js"></script>
<script>
$(document).ready(function() {
    $(document).on("click", ".submit_btn", function() {
        var idx = $(this).data("idx");
        var data = {};

        var formData = $("form[name=lecture_form]").serializeArray();

        var co_formData1 = $(".number_of_author").eq(0).serializeArray();

        var co_count = $(".number_of_author").length;

        var process = inputCheck(formData);
        var status = process.status;
        data["main_data"] = process.data;

        if (!status) return false; // 유효성 검증 후 실패 시 return false;

        var co_process1 = inputCheck(co_formData1, 0);
        status = co_process1.status;
        data["co_data1"] = co_process1.data;
        data["co_count"] = co_count;

        if (!status) return false; //유효성 검증 후 실패 시 return false;

        var coauthor_formData = [];

        for (i = 0; i < co_count; i++) {
            coauthor_formData[i] = $(".number_of_author").eq(i).serializeArray();

            if (coauthor_formData[i]) {
                var coauthor_process = inputCheck(coauthor_formData[i], i);
                status = coauthor_process.status;
                console.log(coauthor_process);
                data["coauthor_data" + i] = coauthor_process.data;
            }

            if (!status) return false; //공동저자 데이터 유효성 검증 후 실패 시 return false;

        }

        // lecture 수정하기 정보
        // var lecture_no = $("input[name=lecture_no]").val();
        // 	lecture_no = (lecture_no && lecture_no != "" && typeof(lecture_no) != undefined) ? lecture_no : "";

        if (status) {
            $.ajax({
                url: PATH + "ajax/client/ajax_submission.php",
                type: "POST",
                data: {
                    flag: "submission_step1",
                    type: "lecture",
                    data: data,
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {
                        $(window).off("beforeunload");

                        if (idx != "") {
                            window.location.href = "./lecture_submission2.php?idx=" + idx;
                        } else {
                            window.location.href = "./lecture_submission2.php";
                        }

                    } else if (res.code == 400) {
                        alert(locale(language.value)("reject_msg"));
                        return false;
                    }
                    /* 제출 유무 확인 주석 (중복제출가능) else if(res.code == 401) {
						alert(locale(language.value)("already_submission"));
						location.href="./mypage_lecture.php";
					}*/
                    else {
                        alert(locale(language.value)("retry_msg"));
                        return false;
                    }
                }
            });
        }
    });

    $(document).on('click', '.affiliation_add', function() {
        var instit = $(this).siblings('.institution').val();
        var depart = $(this).siblings('.department').val();
        var affiliation_input = $(this).parent().siblings("input");

        if (instit == '') {
            alert('Please insert institution');
        } else if (depart == '') {
            alert('Please insert department');
        } else {
            html = '';
            html += '<li class="clearfix">';
            html += '<p>' + instit + '<span class="middle">/</span>' + depart + '</p>';
            html += '<button type="button" class="btn affiliation_delete">Del</button>';
            html += '</li>';

            $(this).siblings('.institution').val('');
            $(this).siblings('.department').val('');
            $(this).parent().next('.affiliation_wrap').show();
            $(this).parent().next('.affiliation_wrap').append(html);
        }

        //소속 항목 input에 추가
        var affiliation_list = [];
        var affiliation_count = $(this).parent().next().children().length;
        var affiliation = $(this).parent().next().children();
        for (i = 0; i < affiliation_count; i++) {
            affiliation_list.push(affiliation.eq(i).find("p").text());
        }

        affiliation_input.val(affiliation_list);
    });

    $(document).on('click', '.affiliation_delete', function() {
        var parents = $(this).parents('.affiliation_wrap');
        var num = parents.children('li').length;
        var affiliation_input = parents.siblings("input");
        $(this).parents('li').remove();
        if (num == 1) {
            parents.hide();
        }

        //소속 업데이트
        var affiliation_list = [];
        var affiliation = parents.children("li");
        for (i = 0; i < num; i++) {
            affiliation_list.push(affiliation.eq(i).find("p").text());
        }
        affiliation_input.val(affiliation_list);
        //console.log(affiliation_input.val());
    });


    //position 삭제로 기존 소스 주석 처리
    //$('input[name="position"]').on('change',function(){
    //	var name = $(this).attr("name");
    //	var value = $('input[name='+name+']:checked').val();

    //	if(value == '4'){
    //		$(this).parent().find(".other_input").show();
    //	}else{
    //		$(this).parents("ul").siblings("div").find(".other_input").hide();
    //	}

    //});

    //co-author select on change event
    //$('.number_of_author').on('change',function(){
    $("input[type=radio][name=co_yn]").on("change", function() {

        var form_count = "<?= $i; ?>";
        var lecture_idx = "<?= $lecture_idx; ?>";
        var checked_val = $("input[type=radio][name=co_yn]:checked").val();
        if (checked_val == "Y") {
            $(".co_author_appended").append(make_author_form(0));
        } else {
            $('.co_author_appended').empty();
        }
    });

    // form 만드는 부분
    function make_author_form(i) {

        i = i - 1;

        var opts_nation = "";
        var temp;

        if (language.value == "en") {
            for (var j = 0; j < nation.length; j++) {
                temp = nation[j];
                opts_nation += '<option value="' + temp.idx + '">' + temp.nation_en + '</option>';
            }
        } else {
            for (var j = 0; j < nation.length; j++) {
                temp = nation[j];
                opts_nation += '<option value="' + temp.idx + '">' + temp.nation_ko + '</option>';
            }
        }


        var html = "";
        html += '<form class="number_of_author" name="coauthor_lecture_form">';
        /*
        html +=		'<div class="pc_only">';
        html +=			'<table class="table detail_table">';
        html +=				'<colgroup>';
        html +=					'<col class="col_th"/>';
        html +=					'<col width="*"/>';
        html +=				'</colgroup>';
        html +=				'<tbody>';
        html +=					'<tr>';
        html +=						'<th><span class="red_txt">*</span><?=$locale("country")?></th>';
        html +=						'<td>';
        html +=							'<div class="max_normal">';
        html +=								'<select class="required co_nation" name="co_nation_no'+i+'" data-count='+i+'> ';
        html +=									'<option value="" selected hidden>Choose </option>' + opts_nation;
        html +=								'</select>';
        html +=							'</div>';
        html +=						'</td>';
        html +=					'</tr>';
        html +=					'<tr>';
        html +=						'<th><span class="red_txt">*</span><?=$locale("affiliation")?></th>';
        html +=						'<td><div class="max_normal"><input class="required" type="text" name="co_affiliation'+i+'" value="" maxlength="100"></div></td>';
        /*		affiliation 관련 기존 소스
        html +=						'<td class="affiliation_td">';
        html +=							'<div class="clearfix affiliation_input">';
        html +=								'<input type="text" class="institution" placeholder="Institution">';
        html +=								'<input type="text" class="department" placeholder="Department">';
        html +=								'<button type="button" class="btn affiliation_add">ADD</button>';
        html +=							'</div>';
        html +=							'<ul class="affiliation_wrap affiliation_wrap_'+i+'">';
        html +=							'</ul>';
        html +=							'<input type="hidden" name="add_co_affiliation'+i+'" value="">';
        html +=						'</td>';//
        html +=					'</tr>';
        html +=					'<tr>';
        html +=						'<th><span class="red_txt">*</span>Department</th>';
        html +=						'<td><div class="max_normal"><input class="required" type="text" name="co_department'+i+'" value="" maxlength="100"></div></td>';
        html +=					'</tr>';
        html +=					'<tr>';
        html +=						'<th><span class="red_txt">*</span>Name</th>';
        html +=						'<td class="name_td clearfix">';
        html +=							'<div class="max_normal"><input class="required" type="text" name="co_first_name'+i+'" value="" maxlength="50"></div>';
        html +=							'<div class="max_normal"><input class="required" type="text" name="co_last_name'+i+'" value="" maxlength="50"></div>';
        html +=						'</td>';
        html +=					'</tr>';
        html +=					'<tr>';
        html +=						'<th><?=$locale("email")?></th>';
        html +=						'<td><div class="max_normal"><input class="required" type="text" name="co_email'+i+'" value="" maxlength="50"></div></td>';
        html +=					'</tr>';
        html +=				'</tbody>';
        html +=			'</table>';
        html +=	'	</div>';
        html +=		'<div class="mb_only">';
        */
        html += '<ul class="sign_list max685">';
        html += '<li>';
        html += '<p class="label"><span class="red_txt">*</span><?=$locale("country")?></p>';
        html += '<div>';
        html += '<select class="required co_nation" name="co_nation_no" data-count=' + i + '> ';
        html += '<option value="" selected hidden>Choose </option>' + opts_nation;
        html += '</select>';
        html += '</div>';
        html += '</li>';
        html += '<li>';
        html += '<p class="label"><span class="red_txt">*</span><?=$locale("affiliation")?></p>';
        html +=
        '<div><input class="required" type="text" name="co_affiliation" value="" maxlength="100"></div>';
        html += '</li>';
        html += '<li>';
        html += '<p class="label"><span class="red_txt">*</span>Department</p>';
        html += '<div><input class="required" type="text" name="co_department" value="" maxlength="100"></div>';
        html += '</li>';
        html += '<li>';
        html += '<p class="label"><span class="red_txt">*</span>Name</p>';
        html += '<div class="half_form clearfix">';
        html += '<input class="required" type="text" name="co_first_name" value="" maxlength="50">';
        html += '<input class="required" type="text" name="co_last_name" value="" maxlength="50">';
        html += '</div>';
        html += '</li>';
        html += '<li>';
        html += '<p class="label"><?=$locale("email")?></p>';
        html += '<div><input class="required" type="text" name="co_email" value="" maxlength="50"></div>';
        html += '</li>';
        html += '<li>';
        html += '<div class="co_author_btn_wrap">';
        html += '<button type="button" class="co_author_add">add</button>';
        html += '<button type="button" data-order=' + i + ' class="co_author_del">Del</button>';
        html += '<input type="hidden" name="co_idx" value="-1">';
        html += '</div>';
        html += '</li>';
        html += '</ul>';
        html += '</div>';
        html += '</form>';

        return html;
    }


    //삭제 하면 기존 순서를 넣기 위해 이러한 작업을 한다.
    var num_data = -1;
    /* form 추가 */
    $(document).on("click", ".co_author_add", function() {

        var num = $('.co_author_appended form').length + 1;
        if (num_data == -1) {
            $(this).parents(".number_of_author").after(make_author_form(num));
        } else {
            $(this).parents(".number_of_author").after(make_author_form(num_data + 1));
            num_data = -1;
        }
    });
    /* form 삭제 */
    $(document).on("click", ".co_author_del", function() {

        num_data = $(this).data("order");;
        var num = $('.co_author_appended form').length;
        if (num > 1) {
            $(this).parents(".number_of_author").remove();
        }
    });

    //주저자와 공동저자가 동일 시 체크버튼 이벤트
    $("#same_with").on("change", function() {
        if ($(this).is(":checked")) {
            var nation_no = $("select[name=nation_no]").val();
            var position = $("input[name=position]:checked").val();
            $("select[name=co_nation_no]").children("option[value=" + nation_no + "]").prop("selected",
                true);
            $("select[name=co_nation_tel1] option").val($("select[name=nation_tel] option").val()).text(
                $("select[name=nation_tel] option").val());
            $("input[name=co_first_name]").val($("input[name=first_name]").val());
            $("input[name=co_last_name]").val($("input[name=last_name]").val());
            $("input[name=co_city]").val($("input[name=city]").val());
            $("input[name=co_state]").val($("input[name=state]").val());
            $("input[name=co_email]").val($("input[name=email]").val());
            $("input[name=co_phone]").val($("input[name=phone]").val());
            if (position == "4") {
                $("input[name=co_position][value=" + position + "]").prop("checked", true);
                $("input[name=co_other_position]").val($("input[name=other_position]").val());
                $("form[name=co_lecture_form] .other_input").show();

            } else {
                $("input[name=co_position][value=" + position + "]").prop("checked", true);
            }

            if ($("input[name=affiliation]").val() != "") {
                $("input[name=co_affiliation]").val($("input[name=affiliation]").val());
                $(".affiliation_wrap_2").append($(".affiliation_wrap_1").html()).show();
            }
        } else {
            $("select[name=co_nation_no]").children("option[value=" + nation_no + "]").prop("selected",
                false);
            $("select[name=co_nation_no]").children("option[hidden]").prop("selected", true);
            $("select[name=co_nation_tel1] option").val("").text("select");
            $("input[name=co_first_name]").val("");
            $("input[name=co_last_name]").val("");
            $("input[name=co_city]").val("");
            $("input[name=co_state]").val("");
            $("input[name=co_affililation]").val("");
            $("input[name=co_position][value=" + position + "]").prop("checked", false);
            $("input[name=co_other_postion]").val("");
            $("input[name=co_other_position]").hide();
            $("input[name=co_email]").val("");
            $("input[name=co_phone]").val("");

            $(".affiliation_wrap_2").empty().hide();
        }
    });

});

function inputCheck(formData, i = "") {
    var data = {};
    var length_100 = ["email", "co_email"]
    var length_50 = ["first_name", "last_name", "co_first_name", "co_last_name"];

    var inputCheck = true;

    $.each(formData, function(key, value) {
        var ok = value["name"];
        var ov = value["value"];

        if (ov == "" || ov == null || ov == "undefinded") {
            //if(ok == "lecture_category") {
            //	alert(locale(language.value)("check_lecture_category"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //} 

            if (ok == "nation_no") {
                alert(locale(language.value)("check_nation"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            } else if (ok == "first_name") {
                alert(locale(language.value)("check_first_name"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            } else if (ok == "last_name") {
                alert(locale(language.value)("check_last_name"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            }

            //else if(ok == "city") {
            //	alert(locale(language.value)("check_city"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //} 
            else if (ok == "affiliation") {
                alert(locale(language.value)("check_affiliation"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            }

            //else if (ok == "email") {
            //	alert(locale(language.value)("check_email"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //} else if(ok == "phone") {
            //	alert(locale(language.value)("check_phone"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //}
            else if (ok == "co_nation_no") {
                alert(locale(language.value)("check_co_nation"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            } else if (ok == "co_first_name") {
                alert(locale(language.value)("check_co_first_name"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            } else if (ok == "co_last_name") {
                alert(locale(language.value)("check_co_last_name"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            }
            /* 21.06.11 퍼블 긴급패치로 인한 추가개발 필요(주석)*/
            //else if(ok == "co_email" || ok == "add_co_email0" || ok == "add_co_email1" || ok == "add_co_email2" || ok == "add_co_email3" || ok == "add_co_email4" || ok == "add_co_email5" || ok == "add_co_email6" || ok == "add_co_email7" || ok == "add_co_email8" || ok == "add_co_email9") {
            //	alert(locale(language.value)("check_co_email"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //} 
            //else if(ok == "co_email"){
            //	alert(locale(language.value)("check_co_email"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //} 

            //else if(ok == "co_city") {
            //	alert(locale(language.value)("check_co_city"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //}
            else if (ok == "co_affiliation") {
                alert(locale(language.value)("check_co_affiliation"));
                $("input[name=" + ok + "]").focus();
                inputCheck = false;
                return false;
            }

            //else if(ok == "co_phone") {
            //	alert(locale(language.value)("check_co_phone"));
            //	$("input[name="+ok+"]").focus();
            //	inputCheck = false;
            //	return false;
            //}
        } else {
            if ((length_50.indexOf(ok) + 1) && ov.length > 50) {
                alert(ok + locale(language.value)("under_50"));
                inputCheck = false;
                return false;
            } else if ((length_100.indexOf(ok) + 1) && ov.length > 100) {
                alert(ok + locale(language.value)("under_100"));
                inputCheck = false;
                return false;
            } else if (ok == "phone" && ov.length < 6) {
                alert(ok + locale(language.value)("over_6"));
                inputCheck = false;
                return false;
            } else if (ok == "phone" && ov.length > 20) {
                alert(ok + locale(language.value)("under_20"));
                inputCheck = false;
                return false;
            }
        }

        data[ok] = ov;
    });


    //postion 없어져서 주석
    //if(inputCheck) {
    //	if(!$("input[name=position]").is(":checked")) {
    //		alert(locale(language.value)("check_position"));
    //		inputCheck = false;
    //		return false;
    //	}
    //	if(!$("input[name=co_position]").is(":checked")) {
    //		alert(locale(language.value)("check_co_position"));
    //		inputCheck = false;
    //		return false;
    //	}
    //}

    return {
        data: data,
        status: inputCheck
    }
}
</script>
<?php
	}
	include_once('./include/footer.php');
?>