<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$user_idx = $member["idx"] ?? -1;

	// [22.04.25] 미로그인시 처리
	if($user_idx <= 0) {
		echo "<script>alert('Need to login'); location.replace(PATH+'login.php');</script>";
		exit;
	}

	$select_query = "
		SELECT
			idx, table_idx, title, room, `date`
		FROM lecture_fave AS lf
		WHERE member_idx = '{$user_idx}'
		ORDER BY idx DESC
	";
	$list = get_data($select_query);
?>
<style>
	/*130번 줄에 인라인 css 있음 2022-04-21*/
</style>
<section class="container mypage sub_page">
	<div class="sub_background_box">
		<div class="sub_inner">
			<div>
				<h2><?=$locale("mypage")?></h2>
				<ul>
					<li>Home</li>
					<li><?=$locale("mypage")?></li>
					<li>My Favorite</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="inner bottom_short">
		<div class="x_scroll tab_scroll">
			<ul class="tab_pager location">
				<li><a href="./mypage.php"><?=$locale("mypage_account")?></a></li>
				<li><a href="./mypage_registration.php"><?=$locale("mypage_registration")?></a></li>
				<li><a href="./mypage_abstract.php"><?=$locale("mypage_abstract")?></a></li>
				<li class="on"><a href="./mypage_favorite.php"><?=$locale("mypage_favorite")?></a></li>
			</ul>
		</div>
		<div>
			<div class="x_scroll">
				<table class="table table_responsive">
					<colgroup>
						<col width="25%">
						<col width="25%">
						<col width="25%">
						<col width="25%">
					</colgroup>
					<thead>
						<tr>
							<th>Title</th>
							<th>Room</th>
							<th>Date</th>
							<th>Management</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if (count($list) <= 0) {
						?>
						<tr>
							<td colspan='4' class='centerT'>No Data</td></td>
						</tr>
						<?php
							} else {
								foreach($list as $fv){
						?>
						<tr>
							<td><?=htmlspecialchars_decode($fv['title'], ENT_QUOTES)?></td>
							<td class="centerT"><?=$fv['room']?></td>
							<td class="centerT"><?=$fv['date']?></td>
							<td class="centerT"><button type="button" class="btn delete_btn" data-idx="<?=$fv['idx']?>">Delete</button></td>
						</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<script>
	$(".delete_btn").click(function(){
		if (confirm('Are you sure you want to delete the bookmarked lecture?')) {
			var _this = $(this);

			$.ajax({
				url : PATH+"ajax/client/ajax_lecture.php",
				type : "POST",
				data : {
					flag: 'fave_delete',
					idx: _this.data('idx')
				},
				dataType : "JSON",
				success : function(res){
					if(res.code == 200) {
						location.reload();
					}
				},
				complete:function(){
					$(".loading").hide();
					$("body").css("overflow-y","auto");
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>