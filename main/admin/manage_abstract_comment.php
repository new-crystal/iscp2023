<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_abstract"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$idx = $_GET['idx'];

	// list
	$where = "";

	$sql_list =	"SELECT
					mb.idx AS member_idx,
					mb.email AS member_email,
					CONCAT(mb.first_name, ' ', mb.last_name) AS member_name,
					rp.contents,
					DATE_FORMAT(rp.register_date, '%y-%m-%d') AS register_date
				FROM abstract_reply AS rp
				LEFT JOIN member AS mb
					ON mb.idx = rp.register_idx
				WHERE rp.is_deleted = 'N'
				AND rp.abstract_idx = '".$idx."'
				".$where."
				ORDER BY rp.register_date DESC";
	$list = get_data($sql_list);
	$total_count = count($list);
	//echo "<pre>{$sql_list}</pre>";
?>

	<section class="">
		<div class="container">
			<!-- 타이틀 -->
			<div class="title">
				<h1 class="font_title">Abstract 관리</h1>
			</div>
			
			<div class="contwrap has_fixed_title">
				<!-- 탭 -->
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li><a href="./manage_abstract_basic.php?idx=<?=$idx?>">기본정보</a></li>
						<li class="active"><a href="javascript:;">댓글</a></li>
					</ul>
				</div>
				<!-- 컨텐츠 -->
				<p class="total_num">총 <?=number_format($total_count)?>개</p>
				<table id="datatable">
					<thead>
						<tr class="tr_center">
							<th>ID(Email)</th>
							<th>이름</th>
							<th>댓글 내용</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($total_count > 0) {
								foreach($list as $rp){
						?>
						<tr class="tr_center">
							<td><a href="./member_detail.php?idx=<?=$rp['member_idx']?>"><?=$rp['member_email']?></a></td>
							<td><?=$rp['member_name']?></td>
							<td class="leftT"><?=$rp['contents']?></td>
							<td><?=$rp['register_date']?></td>
						</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
				<!-- btn -->
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./manage_abstract_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
	<script src="./js/common.js"></script>
<?php include_once('./include/footer.php');?>