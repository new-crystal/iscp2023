<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_main"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$sql_list =	"SELECT
					b.idx,
					CONCAT(fi_pc_en.path, '/', fi_pc_en.save_name) AS fi_pc_en_url
				FROM banner AS b
				LEFT JOIN `file` AS fi_pc_en
					ON fi_pc_en.idx = b.pc_en_img
				ORDER BY idx";
	$list = get_data($sql_list);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">메인페이지 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table>
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<thead>
							<tr class="tr_center">
								<th>순서</th>
								<th>이미지</th>
							</tr>
						</thead>
						<thead>
							<?php
								$order = 1;
								foreach($list as $bn){
							?>
							<tr>
								<td class="centerT"><?=$order?></td>
								<td>
									<a href="./set_main_detail.php?idx=<?=$bn['idx']?>">
										<?php
											if ($bn['fi_pc_en_url']) {
										?>
										<img src="<?=$bn['fi_pc_en_url']?>"/>
										<?php
											} else {
												echo "등록된 이미지가 없습니다.";
											}
										?>
									</a>
								</td>
							</tr>
							<?php
									$order++;
								}
							?>
						</thead>
					</table>
			   </form>
			</div>
		</div>
	</section>
<script src="./js/common.js"></script>
<?php include_once('./include/footer.php');?>