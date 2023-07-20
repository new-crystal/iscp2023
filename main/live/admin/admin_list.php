<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_account_admin"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	//검색 파라미터
	$email	= $_GET["email"]	?? null;
	$name	= $_GET["name"]  ?? null;
	$phone	= $_GET["phone"] ?? null;
	$str	= $_GET["str"]   ?? null;
	$end	= $_GET["end"]   ?? null;

	$where = "";

	if(!empty($email)){
		$where .= " AND email LIKE '%{$email}%'";
	}
	if(!empty($name)){
		$where .= " AND name LIKE '%{$name}%'";
	}
	if(!empty($phone)){
		$where .= " AND phone LIKE '%{$phone}%'";
	}
	if(!empty($str)){
		$where .= " AND DATE(register_date) >= '{$str}'";
	}
	if(!empty($end)){
		$where .= " AND DATE(register_date) <= '{$end}'";
	}

	//2021_06_18 HUBDNC_KMJ 관리자 회원 리스트 쿼리
	$admin_list_query = "SELECT
							idx,
							email,
							`name`,
							phone,
							DATE(register_date) as reg_date,
							CONCAT(spot,'/',`position`) AS sp
						FROM admin
						WHERE is_deleted = 'N'
						{$where}
						ORDER BY register_date DESC";
	$admin_list = get_data($admin_list_query);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">관리자 회원</h1>
				<?php
					if($admin_permission["auth_account_admin"] > 1){
				?>
				<button type="button" class="btn" onclick="javascript:window.location.href='./admin_detail.php';">관리자 등록</button>
				<?php
					}
				?>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="serach_form">
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
								<td>
									<input name="email" type="text" value="<?=$email?>">
								</td>
								<th>Name</th>
								<td class="select_wrap clearfix2">
									<input name="name" type="text" value="<?=$name?>">
								</td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<td>
									<input name="phone" type="text" value="<?=$phone?>">
								</td>
								<th>등록일</th>
								<td class="input_wrap"><input type="text" name="str" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd"> <span>~</span> <input type="text" class="datepicker-here" name="end" data-language="en" data-date-format="yyyy-mm-dd"></td>
							</tr>
						</tbody>
					</table>
					<button class="btn search_btn">검색</button>
				</form>
			</div>
			<div class="contwrap">
				<p class="total_num">총 <?=count($admin_list)?>명</p>
				<table id="datatable" class="list_table">
					<thead>
						<tr class="tr_center">
							<th>ID(Email)</th>
							<th>Name</th>
							<th>직위/직급</th>
							<th>휴대폰번호</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if(count($admin_list) <= 0){
								echo '<tr><td colspan="6">No member data</td></tr>';
							}else{
								foreach($admin_list as $al){
						?>
									<tr class="tr_center">
									<td><a href="./admin_detail.php?idx=<?=$al["idx"]?>"><?=$al["email"]?></a></td>
									<td><?=$al["name"]?></td>
									<td><?=$al["sp"]?></td>
									<td><?=$al["phone"]?></td>
									<td><?=$al["reg_date"]?></td>
									</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
				
			</div>
		</div>
	</section>
	<script>
		//자동완성 off
		$(document).ready(function(){
			$('input').attr('autocomplete', 'off');
		})

		//검색창 datepicker 세팅
		if("<?=$str?>"){
			let last_update_start = $('[name=str]').datepicker().data('datepicker');
			last_update_start.selectDate(new Date("<?=$_GET["str"];?>"));
		}

		//검색창 datepicker 세팅
		if("<?=$end?>"){
			let last_update_end = $('[name=end').datepicker().data('datepicker');
			last_update_end.selectDate(new Date("<?=$_GET["end"];?>"));
		}
	</script>
<?php include_once('./include/footer.php');?>