<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>
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
							<col width="10%">
							<col width="40%">
							<col width="10%">
							<col width="40%">
						</colgroup>
						<tbody>
							<tr>
								<th>이메일 *</th>
								<td>
									<input type="text" readonly value="jys@hubdnc.com">
								</td>
								<th>비밀번호 *</th>
								<td class="select_wrap clearfix2">
									<a href="./mypage_password.php" class="btn border_btn">비밀번호 변경</a>
								</td>
							</tr>
							<tr>
								<th>이름 *</th>
								<td>
									<input type="text" value="홍길동">
								</td>
								<th>부서 *</th>
								<td>
									<input type="text" value="기획팀">
								</td>
							</tr>
							<tr>
								<th>직위/직급 *</th>
								<td class="input_wrap">
									<input type="text" value="과장">
									<span>/</span>
									<input type="text" value="팀장">
								</td>
								<th>휴대폰번호 *</th>
 								<td class="phone_num">
									<select name="" id="">
										<option value="">+82</option>
									</select>
									<input type="text" value="010-1234-1234">
								</td>
							</tr>
							<tr>
								<th>주소</th>
								<td colspan="3" class="input_wrap address_form">
									<div class="clearfix">
										<input type="text" value="우편번호" id="member_post" readonly onclick="findAddr()">
									</div>
									<input type="text" value="기본주소" id="member_addr" readonly>
									<input type="text" placeholder="상세주소">
								</td>
							</tr>
						</tbody>
					</table>
				   <button type="button" class="btn">저장</button>
			   </form>
			</div>
		</div>
	</section>
	<script>
		function findAddr(){
			new daum.Postcode({
				oncomplete: function(data) {
					
					console.log(data);
					
					// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
					// 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
					// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
					var roadAddr = data.roadAddress; // 도로명 주소 변수
					var jibunAddr = data.jibunAddress; // 지번 주소 변수
					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					document.getElementById('member_post').value = data.zonecode;
					if(roadAddr !== ''){
						document.getElementById("member_addr").value = roadAddr;
					} 
					else if(jibunAddr !== ''){
						document.getElementById("member_addr").value = jibunAddr;
					}
				}
			}).open();
		}
	</script>
	<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="./js/common.js"></script>
<script>
    var html = '<?=$html?>';
</script>
<?php include_once('./include/footer.php');?>