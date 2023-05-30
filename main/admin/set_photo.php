<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_general"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$photo_gallery_query = "
							SELECT
								pg_group.year, 
								fi.path, 
								CONCAT(fi.path, '/', fi.save_name) AS url
							FROM (
								SELECT 
									year, MAX(img) AS max_img
								FROM photo_gallery
								WHERE is_deleted = 'N'
								GROUP BY year
							) AS pg_group
							LEFT JOIN `file` AS fi 
								ON fi.idx = pg_group.max_img
							ORDER BY pg_group.year DESC
							";
	$photo_gallery = get_data($photo_gallery_query);
?>
	<style>
		td img{max-width: 200px;}
	</style>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">General Information 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li><a href="./set_general.php">Overview</a></li>
						<li><a href="./set_organizing.php">Organizing Committee</a></li>
						<li><a href="./set_venue.php">Venue</a></li>
						<li class="active"><a href="javascript:;">Photo Gallery</a></li>
					</ul>
					<?php
						if($admin_permission["auth_page_general"] > 1){
					?>
					<a href="./set_photo_detail.php" class="btn absolute_btn">추가</a>
					<?php
						}
					?>
				</div>
				<form name="search_form">
					<table>
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<thead>
							<tr class="tr_center">
								<th>Year</th>
								<th>Image</th>
							</tr>
						</thead>
						<thead>
							<?php
								if (count($photo_gallery) <= 0) {
							?>
							<tr>
								<td class="centerT" colspan="2">No Data</td>
							</tr>
							<?php
								} else {
									foreach($photo_gallery as $pg){
										//$imgs = get_data($imgs_query."AND year = '".$y."'");
							?>
							<tr>
								<td class="centerT"><?=$pg['year']?></td>
								<td>
									<a href="./set_photo_detail.php?y=<?=$pg['year']?>">
										<img src="<?=$pg['url']?>"/>
									</a>
								</td>
							</tr>
							<?php
									}
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