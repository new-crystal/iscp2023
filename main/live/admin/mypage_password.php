<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
?>
<style>
	.register_btn {float: right;}
	.excel_download_btn {float: right;margin-right: 10px;}
</style>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">마이페이지</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table>
						<colgroup>
							<col width="15%">
							<col width="85%">
						</colgroup>
						<tbody>
							<tr>
								<th>이전 비밀번호 *</th>
								<td>
									<input type="password" placeholder="비밀번호(숫자+문자 최소 8자리)" name="pw_origin">
								</td>
							</tr>
							<tr>
								<th>새 비밀번호 *</th>
								<td>
									<input type="password" placeholder="비밀번호(숫자+문자 최소 8자리)" name="pw">
								</td>
							</tr>
							<tr>
								<th>새 비밀번호 확인 *</th>
								<td>
									<input type="password" placeholder="비밀번호(숫자+문자 최소 8자리)" name="pw_re">
								</td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="btn border_btn" onclick="javascript:history.go(-1);">뒤로가기</button>
					<button type="button" class="btn" name="save">저장</button>
				</form>
			</div>
		</div>
	</section>
<script src="./js/common.js"></script>
<script>
	var regex_pw = /^.*(?=^.{8,}$)(?=.*[a-zA-Z]).*$/;

	// 저장
	$('[name=save]').click(function(){
		var pw_origin = $('[name=pw_origin]').val();
		var pw = $('[name=pw]').val();
		var pw_re = $('[name=pw_re]').val();

		console.log('num', pw.search(/[0-9]/g));
		console.log('eng', pw.search(/[a-z]/g));

		if(pw_origin == ""){
			alert("이전 비밀번호를 입력해주세요.");

		} else if(pw == ""){
			alert("비밀번호를 입력해주세요.");

		} else if(pw == "" || pw !== pw_re){
			alert("비밀번호를 확인해주세요.");

		} else if (!regex_pw.test(pw)) { 
			alert('비밀번호는 최소 8자리를 사용해야 합니다.'); 

		} else if ((pw.search(/[0-9]/g)) < 0 || (pw.search(/[a-z]/g)) < 0) {
			alert('비밀번호는 숫자와 영문자를 혼용하여야 합니다.');

		} else if (confirm("저장하시겠습니까?")) {
			var data = new FormData();
			data.append("flag", "update_pw_only");
			data.append("pw_origin", pw_origin);
			data.append("pw", pw);
			data.append("pw_re", pw_re);

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
						alert("완료되었습니다.");
						window.location.href="../admin/admin_list.php";
					}else{
						alert(res.msg);
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>