<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$idx = $_GET["idx"] ?? 0;

	$is_mine = ($_SESSION['ADMIN']['idx'] === $idx); // 본인 정보는 수정 가능
	$is_modify = ($idx !== 0);
	$can_modify = ($admin_permission["auth_account_admin"] > 1);

	if($admin_permission["auth_account_admin"] == 0 && !$is_mine){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	//관리자회원 상세 쿼리
	$admin_detail_query = "SELECT
							idx,
							email,
							`name`,
							phone,
							DATE_FORMAT(register_date, '%y-%m-%d') as reg_date,
							spot,
							department,
							`position`,
							postcode,
							street_address1,
							street_address2
						FROM admin
						WHERE is_deleted = 'N'
						AND idx = {$idx}";
	$admin_detail = sql_fetch($admin_detail_query);
	$email		= $admin_detail["email"]			 ?? null;
	$name		= $admin_detail["name"]				?? null;
	$phone		= $admin_detail["phone"]			 ?? null;
	$spot		= $admin_detail["spot"]				?? null;
	$department = $admin_detail["department"]		?? null;
	$position	= $admin_detail["position"]			?? null;
	$reg_date	= $admin_detail["reg_date"]			?? null;
	$postcode	= $admin_detail["postcode"]			?? null;
	$address1	= $admin_detail["street_address1"]	?? null;
	$address2	= $admin_detail["street_address2"]	?? null;
?>
	<style>
		.input_wrap input{width: calc(50% - 5px) !important}
	</style>
	<section class="detail">
		<div class="container">
			<div class="title">
				<h1 class="font_title"><?=($is_mine) ? "마이페이지" : "관리자회원"?></h1>
			</div>
			<div class="contwrap has_fixed_title">
				<div class="clearfix2">
					<div class="tab_box">
						<ul class="tab_wrap clearfix">
							<?php
								if($is_modify && ($admin_permission["auth_account_admin"] >= 1) && !$is_mine){
									echo '<li class="active"><a href="./admin_detail.php?idx='.$idx.'">기본 정보</a></li>';
									echo '<li><a href="./admin_detail2.php?idx='.$idx.'">권한 정보</a></li>';
								}
							?>
						</ul>
					</div>
					<div class="info clearfix">
						<?php
							if($is_modify && !$is_mine){
						?>
						<p><?=$email." / ".$name." / ".$position?> </p>
						<?php
							}
						?>
					</div>
				</div>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>ID(Email) *</th>
							<td><input id="email" type="text" value="<?=$email?>"></td>
							<th>비밀번호 *</th>
							<?php
								if ($is_mine) {
							?>
								<td class="select_wrap clearfix2">
									<a href="./mypage_password.php" class="btn border_btn">비밀번호 변경</a>
								</td>
							<?php
								} else {
							?>
							<td class="input_wrap"><input id="password1" type="password" class="width_30" placeholder="비밀번호(숫자+문자 최소 8자리)"> <input type="password" id="password" class="width_30" placeholder="비밀번호 확인"></td>
							<?php
								}
							?>
						</tr>
						<tr>
							<th>이름 *</th>
							<td><input id="name" type="text" value="<?=$name?>"></td>
							<th>부서 *</th>
							<td><input id="department" type="text" value="<?=$department?>"></td>
						</tr>
						<tr>
							<th>직위/직급 *</th>
							<td class="input_wrap"><input id="spot" type="text" value="<?=$spot?>"> <input id="position" type="text" value="<?=$position?>"></td>
							<th>휴대폰번호 *</th>
							<td><input id="phone" type="text" value="<?=$phone?>" placeholder=""></td>
						</tr>
						<tr>
							<th>주소</th>
							<td colspan="3">
								<input id="postcode" type="text" value="<?=$postcode?>" class="default_width addr_pop" placeholder="우편번호" readonly>
								<div class="input_wrap">
									<input id="address1" type="text" value="<?=$address1?>" class="default_width addr_pop" placeholder="기본주소" readonly>
									<input id="address2" type="text" value="<?=$address2?>" class="default_width" placeholder="상세주소">
								</div>
							</td>
						</tr>
						<?php
						if($is_modify && !$is_mine){
							echo "<tr><th>등록일</th><td colspan='3'>{$reg_date}</td></tr>";
						}
						?>
					</tbody>
				</table>
				<div class="btn_wrap">
					<?php
						if(!$is_mine){
					?>
					<button type="button" class="border_btn" onclick="location.href=\'./admin_list.php\'">목록</button>
					<?php
							if($is_modify && $can_modify){
					?>
					<button id="del_btn" type="button" class="btn gray_btn">삭제</button>
					<?php
							}
						}

						if($can_modify || $is_mine){
					?>
					<button id="reg_btn" type="button" class="btn save_btn">저장</button>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- 주소검색 -->
	<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script>
		$(document).ready(function(){
			$('input').attr("autocomplete", "off");
		});

		$('#reg_btn').on("click", function(){
			var modify_flag = '<?=$is_modify?>';

			var data = new FormData();
			var email		= $('#email').val();
			var name		= $('#name').val();
			var spot		= $('#spot').val();
			var position	= $('#position').val();
			var department	= $('#department').val();
			var phone		= $('#phone').val();
			var password	= $('#password').val();
			var password1	= $('#password1').val();
			var postcode	= $('#postcode').val();
			var address1	= $('#address1').val();
			var address2	= $('#address2').val();
			var idx			= '<?=$idx?>';

			if(email == ""){
				alert("이메일을 입력해주세요.");
				return false;
			}

			var chk_password_flag = !modify_flag ? true : (password1 !== "" && password1 !== undefined);
			if (chk_password_flag) {
				var regex_pw = /^.*(?=^.{8,}$)(?=.*[a-zA-Z]).*$/;

				if(password1 == ""){
					alert("비밀번호를 입력해주세요.");
					return false;
				} else if (!regex_pw.test(password1)) { 
					alert('비밀번호는 최소 8자리를 사용해야 합니다.'); 
					return false;
				} else if ((password1.search(/[0-9]/g)) < 0 || (password1.search(/[a-z]/g)) < 0) {
					alert('비밀번호는 숫자와 영문자를 혼용하여야 합니다.');
					return false;
				} else if(password == "" || password1 !== password){
					alert("비밀번호를 확인해주세요.");
					return false;
				} else {
					data.append('password', password);
				}
			}

			if(name == ""){
				alert("이름을 입력해주세요.");
				return false;
			}
			if(department == ""){
				alert("부서를 입력해주세요.");
				return false;
			}
			if(spot == ""){
				alert("직위를 입력해주세요.");
				return false;
			}
			if(position == ""){
				alert("직급을 입력해주세요.");
				return false;
			}
			if(phone == ""){
				alert("휴대폰번호를 입력해주세요.");
				return false;
			}

			data.append("email", email);
			data.append('idx', idx);
			data.append("name", name);
			data.append('spot', spot);
			data.append('position', position);
			data.append('department', department);
			data.append('phone', phone);
			//data.append('password', password);
			data.append('postcode', postcode);
			data.append('address1', address1);
			data.append('address2', address2);

			var flag = "";
			var confirm_msg = "";
			var complete_alert_msg = "";
			var complete_href = "";

			if(modify_flag){
				//수정
				flag = "admin_update";
				confirm_msg = "저장하시겠습니까?";
				complete_alert_msg = "회원 수정 완료";
			} else {
				//등록
				flag = "admin_regist";
				confirm_msg = "등록하시겠습니까?";
				complete_alert_msg = "회원 등록 완료\n(생성된 회원은 권한 설정 후 로그인이 가능합니다.)";
			}

			if(confirm(confirm_msg)){
				data.append("flag", flag);
				$.ajax({
					url:'../ajax/admin/ajax_member.php',
					data:data,
					type:"POST",
					datatype:"JSON",
					contentType:false,
					processData:false,
					success:function(res){
						res = JSON.parse(res);
						if(res.code == 200){
							alert(complete_alert_msg);
							window.location.href="../admin/admin_list.php";
						}else if(res.code == 401){
							alert(res.msg);
						}else{
							alert("처리 중 오류발생");
						}
					}
				});
			}
		})

		//회원삭제버튼
		$('#del_btn').on("click", function(){
			if(confirm("해당 회원을 삭제하시겠습니까?")){
				var data = new FormData();
				data.append("flag","delete_admin");
				data.append("idx",'<?=$idx?>');
				$.ajax({
					url:'../ajax/admin/ajax_member.php',
					data:data,
					type:"POST",
					datatype:"JSON",
					contentType:false,
					processData:false,
					success:function(res){
						res = JSON.parse(res);
						if(res.code == 200){
							alert("삭제가 완료되었습니다.");
						}else if(res.code == 500){
							alert("회원 삭제중 오류 발생");
						}
					}
				})
			}
		});

		$('.addr_pop').click(function(){
			daum_post_code();
		});

		// 다음 주소 API
		function daum_post_code() {
			new daum.Postcode({
				oncomplete: function(data) {
					// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

					// 각 주소의 노출 규칙에 따라 주소를 조합한다.
					// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
					var addr = ''; // 주소 변수
					var extraAddr = ''; // 참고항목 변수

					//사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
						addr = data.roadAddress;
					} else { // 사용자가 지번 주소를 선택했을 경우(J)
						addr = data.jibunAddress;
					}

					// 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
					if(data.userSelectedType === 'R'){
						// 법정동명이 있을 경우 추가한다. (법정리는 제외)
						// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
						if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
							extraAddr += data.bname;
						}
						// 건물명이 있고, 공동주택일 경우 추가한다.
						if(data.buildingName !== '' && data.apartment === 'Y'){
							extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
						}
						// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
						if(extraAddr !== ''){
							extraAddr = ' (' + extraAddr + ')';
						}
						// 조합된 참고항목을 해당 필드에 넣는다.
						//document.getElementById(header + "_extra").value = extraAddr;
					
					} else {
						//document.getElementById(header + "_extra").value = '';
					}

					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					document.getElementById("postcode").value = data.zonecode;
					document.getElementById("address1").value = addr + ' ' + extraAddr;
					// 커서를 상세주소 필드로 이동한다.
					document.getElementById("address2").focus();
				}
			}).open();
		}
	</script>
<?php include_once('./include/footer.php');?>