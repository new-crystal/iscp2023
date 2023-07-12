<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$member_idx =$_GET["idx"];

	$nation_list = get_data($_nation_query);

	if($member_idx) {
		$member_detail_query =	"
									SELECT
										*
									FROM member
									WHERE idx = {$member_idx};
								";
		$member_info = sql_fetch($member_detail_query);
	}

	//2022-05-10 추가
	$telephone = isset($member_info["telephone"]) ? $member_info["telephone"] : "";
	$title = isset($member_info["title"]) ? $member_info["title"] : "";
	$degree = isset($member_info["degree"]) ? $member_info["degree"] : "";
	$category = isset($member_info["category"]) ? $member_info["category"] : "";
	$request_food = isset($member_info["request_food"]) ? $member_info["request_food"] : "";

	$date_of_birth = isset($member_info["date_of_birth"]) ? $member_info["date_of_birth"] : "";

	$email = isset($member_info["email"]) ? $member_info["email"] : "";
	$first_name = isset($member_info["first_name"]) ? $member_info["first_name"] : "";
	$last_name = isset($member_info["last_name"]) ? $member_info["last_name"] : "";
	$nation_no = isset($member_info["nation_no"]) ? $member_info["nation_no"] : "";
	$phone = isset($member_info["phone"]) ? $member_info["phone"] : "";
	$affiliation = isset($member_info["affiliation"]) ? $member_info["affiliation"] : "";
	$department = isset($member_info["department"]) ? $member_info["department"] : "";
	$affiliation_kor = isset($member_info["affiliation_kor"]) ? $member_info["affiliation_kor"] : "";
	$name_kor = isset($member_info["name_kor"]) ? $member_info["name_kor"] : "";
	
	$register_date = isset($member_info["register_date"]) ? $member_info["register_date"] : "-";

	$licence_number = isset($member_info["licence_number"]) ? $member_info["licence_number"] : "";
	$specialty_number = isset($member_info["specialty_number"]) ? $member_info["specialty_number"] : "";
	$nutritionist_number = isset($member_info["nutritionist_number"]) ? $member_info["nutritionist_number"] : "";
?>
<style>
	.input_others_on {
		display: none;
	}
	.short_input {
		display:none;
	}
	.short_input.on {
		display:revert;
	}
</style>
	<section class="detail">
		<div class="container">
			<div class="title">
				<h1 class="font_title">일반회원</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<?php
					if($member_idx) {
						include_once("./include/member_nav.php");
					}
				?>
				<form name="member_detail_form">
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
								<td><input type="text" name="email" value="<?=$email?>"></td>
								<th>Password *</th>
								<td class="input_wrap"><input type="password" name="<?=$member_idx ? "" : "password"?>" id="password" class="width_30" placeholder=""><input type="password"  name="<?=$member_idx ? "" : "re_password"?>" id="re_password" class="width_30" placeholder="비밀번호 확인"></td>
							</tr>
							<tr>
								<th>First Name</th>
								<td><input type="text" name="first_name" value="<?=$first_name?>"></td>
								<th>Last Name</th>
								<td><input type="text"name="last_name" value="<?=$last_name?>"></td>
							</tr>
							<tr>
								<th>name (KOR)</th>
								<td><input type="text" name="name_kor" value="<?=$name_kor?>"></td>
								<th>Affiliation (KOR)</th>
								<td><input type="text" name="affiliation_kor" value="<?=$affiliation_kor?>"></td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<td><input type="text" name="phone" value="<?=$phone?>"></td>
								<th>Telephone</th>
								<td><input type="text" name="telephone" value="<?=$telephone?>"></td>
							</tr>
							<tr>
								<th>Affiliation</th>
								<td><input type="text" name="affiliation" value="<?=$affiliation?>"></td>
								<th>Department</th>
								<td><input type="text" name="department" value="<?=$department?>" placeholder=""></td>
							</tr>
							<tr>
								<th>Title</th>
								<td>
									<select name="title" id="title" class="select_others">
										<option value="" selected hidden>Choose</option>
									<?php
										$title_arr = array("Professor", "Dr.", "Mr.", "Ms.", "Others");
										$title_count = 0;
										if(!empty($member_idx)) {
											foreach($title_arr as $t_arr) {
												if($title == $t_arr) {
													echo '<option selected value="'.$t_arr.'">'.$t_arr.'</option>';
													$title_count = -5;
												} else if($title_count == 4) {
													echo '<option selected value="'.$t_arr.'">'.$t_arr.'</option>';
												} else {
													echo '<option value="'.$t_arr.'">'.$t_arr.'</option>';
													$title_count++;
												}
											}
										} else {
											foreach($title_arr as $t_arr) {
												echo '<option value="'.$t_arr.'">'.$t_arr.'</option>';
											}
										}			
									?>
									</select>
									<?php
										if($title_count == 4) {
									?>
										<input value="<?= $title ?>" type="text" name="title_input" class="input_others en_check" maxlength="60">
									<?php
										} else {
									?>
										<input type="text" name="title_input" class="input_others en_check input_others_on" maxlength="60">
									<?php
										}
									?>
								</td>
								<th>Degree</th>
								<td>
									<select name="degree" id="degree" class="select_others">
										<option value="" selected hidden>Choose</option>
										<?php
											$degree_arr = array("M.D", "Ph.D.", "M.D., Ph.D.", "Others");
											$degree_count = 0;
											if(!empty($member_idx)) {
												foreach($degree_arr as $d_arr) {
													if($degree == $d_arr) {
														echo '<option selected value="'.$d_arr.'">'.$d_arr.'</option>';
														$degree_count = -5;
													} else if($degree_count == 3) {
														echo '<option selected value="'.$d_arr.'">'.$d_arr.'</option>';
													} else {
														echo '<option value="'.$d_arr.'">'.$d_arr.'</option>';
														$degree_count++;
													}
												}
											} else {
												foreach($degree_arr as $d_arr) {
													echo '<option value="'.$d_arr.'">'.$d_arr.'</option>';
												}
											}
										?>
										</select>
										<?php
											if($degree_count == 3) {
										?>
											<input value="<?= $degree ?>" type="text" name="degree_input" class="input_others en_check" maxlength="60">
										<?php
											} else {
										?>
											<input type="text" name="degree_input" class="input_others en_check input_others_on" maxlength="60">
										<?php
											}
										?>
								</td>
							</tr>
							<tr>
								<th>Country</th>
								<td>
									<select name="nation_no"> 
										<option value="" selected hidden>Choose </option>
									<?php
										foreach($nation_list as $list) {
											$selected = $nation_no == $list["idx"] ? "selected" : "";
											echo  '<option value="'.$list["idx"].'"'.$selected.'>'.$list["nation_ko"].'</option>';
										}
									?>
									</select>
								</td>
								<th>Category</th>
								<td>
									<select name="category" id="category" class="select_others">
										<option value="" selected hidden>Choose </option>
									<?php
										$category_arr = array("Professor", "Specialist", "Fellow", "Resident", "Researcher", "Military Medical Officer", "Nurse", "Nutritionist", "Student", "Pharmacist", "Corporate member", "Others");
										$category_count = 0;
										if(!empty($member_idx)) {
											foreach($category_arr as $c_arr) {
												if($category == $c_arr) {
													echo '<option selected value="'.$c_arr.'">'.$c_arr.'</option>';
													$category_count = -12;
												} else if($category_count == 11) {
													echo '<option selected value="'.$c_arr.'">'.$c_arr.'</option>';
												} else {
													echo '<option value="'.$c_arr.'">'.$c_arr.'</option>';
													$category_count++;
												}
											} 
										} else {
											foreach($category_arr as $c_arr) {
												echo '<option value="'.$c_arr.'">'.$c_arr.'</option>';
											}
										}
										
									?>
									</select>
									<?php
										if($category_count == 11) {
									?>
										<input value="<?= $category ?>" type="text" name="category_input" class="input_others en_check" maxlength="60">
									<?php
										} else {
									?>
										<input type="text" name="category_input" class="input_others en_check input_others_on" maxlength="60">
									<?php
										}
									?>
								</td>
							</tr>
							<tr>
								<th>의사번호</th>
								<td>
									<input <?=$licence_number != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="licence_number" name="licence_number2" value="Not applicable"><label for="licence_number">Not applicable</label>
									<input <?=$licence_number != "Not applicable" ? "" : "disabled"; ?> name="licence_number" type="text" value="<?=$licence_number != "Not applicable" ? $licence_number : ""; ?>" class="kor_check">
								</td>
								<th>전문의번호</th>
								<td>
									<input <?=$specialty_number != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="specialty_number" name="specialty_number2" value="Not applicable"><label for="specialty_number">Not applicable</label>
									<input <?=$specialty_number != "Not applicable" ? "" : "disabled"; ?> name="specialty_number" type="text" value="<?=$specialty_number != "Not applicable" ? $specialty_number : ""; ?>" class="kor_check">
								</td>
							</tr>
							<tr>
								<th>영양사번호</th>
								<td>
									<input <?=$nutritionist_number != "Not applicable" ? "" : "checked"; ?> type="checkbox" class="checkbox input not_checkbox" id="nutritionist_number" name="nutritionist_number2" value="Not applicable"><label for="nutritionist_number">Not applicable</label>
									<input <?=$nutritionist_number != "Not applicable" ? "" : "disabled"; ?> name="nutritionist_number" type="text" value="<?=$nutritionist_number != "Not applicable" ? $nutritionist_number : ""; ?>" class="kor_check">
								</td>
								<th>Date of Birth</th>
								<td><input maxlength="10" name="date_of_birth" type="text" class="datepicker_input" id="datepicker" value="<?= $date_of_birth; ?>"></td>
							</tr>
							<tr>
								<th>Special Request for Food</th>
								<td>
								<?php

									$food_radio = array("None", "Vegetarian", "Halal", "Others");
									$food_radio_value = array("", "", "", "checked");
									
									for($i=0; $i<4; $i++) {
										if($food_radio[$i] == $request_food) {
											$food_radio_value[$i] = "checked";
											$food_radio_value[3] = "";
										}
									}
								?>
									<input <?= !empty($member_idx) ? $food_radio_value[0] : "checked";?> value="None" type="radio" id="none" class="radio" name="food">
									<label for="none">None</label>
									<input <?php echo $food_radio_value[1];?> value="Vegetarian" type="radio" id="vegetarian" class="radio" name="food">
									<label for="vegetarian">Vegetarian</label>
									<input <?php echo $food_radio_value[2];?> value="Halal" type="radio" id="halal" class="radio" name="food">
									<label for="halal">Halal</label>
									<input <?= !empty($member_idx) ? $food_radio_value[3] : "";?> value="Others" type="radio" id="Others" class="radio other_radio" name="food">
									<label for="Others">
										Others
										<?php
											if(!empty($member_idx)) {
												if($food_radio_value[3] == "checked") {
													echo '<input value="'.$request_food.'" name="short_input" type="text" class="short_input on">';
												} else {
													echo '<input name="short_input" type="text" class="short_input">';
												}
											} else {
												echo '<input name="short_input" type="text" class="short_input">';
											}
											
										?>
									</label>
								</td>
								<th>등록일</th>
								<td><?=$register_date?></td>
							</tr>
						</tbody>
					</table>
				</form>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./member_list.php'">목록</button>
				<?php
					if ($admin_permission["auth_account_member"] > 1) {
						if($member_idx) {
				?>
					<button type="button" class="btn gray_btn delete_btn">삭제</button>
				<?php
						}
				?>
					<button type="button" class="btn save_btn">저장</button>
				<?php
					}
				?>
				</div>
			</div>
		</div>
	</section>
<script>
$(document).ready(function(){

	$(".radio").change(function(){
		var _this = $(this).val();
		if (_this != "Others"){
			$(".short_input").removeClass("on");
		} else {
			$(".short_input").addClass("on");
			$(".short_input").val("");
		}
	});

	$(".not_checkbox").click(function(){
		var _this =$(this).is(":checked");
		if(_this == true) {
			$(this).next().next().attr("disabled", true);
			$(this).next().next().val("");
		} else {
			$(this).next().next().attr("disabled", false);
		}
	});

	$(".select_others").change(function(){
			
		var this_chk = $(this).val();
		if (this_chk == "Others"){
			$(this).next().removeClass("input_others_on");
		} else {
			$(this).next().addClass("input_others_on");
			$(this).next().val("");
		}
	});

	$(".tab_wrap").children("li").eq(0).addClass("active");
	
	//비밀번호 변경시 인풋체크 활성화
	$("#password, #re_password").on("change", function(){
		if(!$(this).attr("name")) {
			$(this).attr("name", $(this).attr("id"));
		}
	});

	//국가 선택 시 국가번호 추가
	$("select[name=nation_no]").on("change", function(){
		var nation = $(this).val();
		$.ajax({
			url : "../ajax/ajax_nation.php",
			type : "POST",
			data : {
				flag : "nation_tel",
				nation : nation
			},
			dataType : "JSON",
			success : function(res) {
				if(res.code == 200) {
					if($("input[name=phone]").val()) {
						var _phone = $("input[name=phone]").val().split("-");
						var _delete_nation_tel = _phone.splice(0,1);
						var enter_phone = _phone.join("-");
						
						$("input[name=phone]").val(res.tel+"-"+enter_phone);
					} else {
						$("input[name=phone]").val(res.tel+"-");
					}
					if($("input[name=telephone]").val()) {
						var _telephone = $("input[name=telephone]").val().split("-");
						var _delete_nation_tel = _telephone.splice(0,1);
						var enter_phone = _telephone.join("-");
						
						$("input[name=telephone]").val(res.tel+"-"+enter_phone);
					} else {
						$("input[name=telephone]").val(res.tel+"-");
					}
				}
			}
		});
	});

	//삭제
	$(".delete_btn").on("click", function() {
		var member_idx = "<?=$member_idx?>";
		if(confirm("해당 회원을 삭제하시겠습니까?")) {
			$.ajax({
				url : "../ajax/client/ajax_member.php",
				type : "POST",
				data : {
					flag : "delete",
					idx : member_idx
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						alert("회원이 삭제되었습니다.");
						window.location.replace("./member_list.php");
					} else if(res.code == 400) {
						alert("회원 삭제에 실패하였습니다.");
						return false;
					} else {
						alert("일시적으로 요청이 거절되었습니다.");
						return false;
					}
				}
			});
		}
	});

	$(".save_btn").on("click", function(){
		var member_idx = "<?=$member_idx?>";
		var flag = member_idx != "" ? "update" : "signup";
	
		var process = inputCheck();

		var status = process.status;
		var data = process.data;

		if(status) {
			if(confirm("저장하시겠습니까?")) {
				$.ajax({
					url : "../ajax/client/ajax_member.php",
					type : "POST",
					data : {
						flag : flag,
						idx : member_idx,
						register_type : "admin",
						data : data
					},
					dataType : "JSON",
					success : function(res) {
						if(res.code == 200) {
							alert("저장이 완료되었습니다.");
							window.location.reload();
						} else if(res.code == 400){
							alert("저장에 실패하였습니다.");
							return false;
						} else {
							alert("일시적으로 요청이 거절되었습니다.");
							return false;
						}
					}
				});
			}
		}
	});
});
function inputCheck() {
	var data = {};
	var formData = $("form[name=member_detail_form]").serializeArray();

	var inputCheck = true;

	$.each(formData, function(key, value){
		var ok = value["name"];
		var ov = value["value"];

		if(ov == "" || ov == "undefined" || ov == null) {
			if(ok == "email" || ok == "password" || ok == "re_password" || ok == "first_name" || ok == "last_name" || ok == "phone") {
				if(ok == "email") {
					alert("이메일을 입력하지 않으셨습니다.");
				} else if(ok == "password") {
					alert("비밀번호를 입력하지 않으셨습니다.");
				} else if(ok == "re_password") {	
					alert("비밀번호 확인을 입력하지 않으셨습니다.")
				} else if(ok == "first_name") {
					alert("이름을 입력하지 않으셨습니다.");
				} else if(ok == "last_name") {
					alert("이름(성)을 입력하지 않으셨습니다.");
				} else if(ok == "phone") {
					alert("연락처를 입력하지 않으셨습니다.");
				}

				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			}
		} else {
			if(ok== "re_password" && ov != $("input[name=password]").val()) {
				alert("비밀번호가 일치하지 않습니다.");
				$("input[name="+ok+"]").focus();
				inputCheck = false;
				return false;
			}
		}
		data[ok] = ov;
	});
	if(inputCheck) {
		if(!$("select[name=nation_no]").val()) {
			alert("국가를 선택하지 않으셨습니다.");
			inputCheck = false;
			return false;
		}
	}

	var licence_number_bool = $("input[name=licence_number2]").is(":checked");
	data.licence_number_bool = licence_number_bool;
	var specialty_number_bool = $("input[name=specialty_number2]").is(":checked");
	data.specialty_number_bool = specialty_number_bool;
	var nutritionist_number_bool = $("input[name=nutritionist_number2]").is(":checked");
	data.nutritionist_number_bool = nutritionist_number_bool;

	return {
		data : data,
		status : inputCheck
	}
}
</script>
<?php include_once('./include/footer.php');?>