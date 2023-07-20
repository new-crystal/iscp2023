<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_event"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$sql_rank =	"SELECT
					( @rank := @rank + 1 ) AS rank, 
					score_group.*
				FROM (
					SELECT
						es.idx,
						DATE(es.register_date) AS register_date,
						es.score AS min_score,
						es.delivery_yn,
						mb.email,
						nt.nation_en,
						mb.first_name, mb.last_name,
						mb.phone,
						mb.affiliation
					FROM event_sameimg AS es
					LEFT JOIN member AS mb
						ON mb.idx = es.member_idx
					LEFT JOIN nation AS nt
						ON nt.idx = mb.nation_no
					WHERE (member_idx, score) IN (
						SELECT
							member_idx, MIN(score) AS score
						FROM event_sameimg
						WHERE score < '99:59:59'
						GROUP BY member_idx
					)
				) AS score_group
				, ( SELECT @rank := 0 ) AS b
				ORDER BY score_group.min_score ASC
				LIMIT 3";
	$rankers = get_data($sql_rank);
	$rankers_count = count($rankers);
?>
<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">이벤트 관리</h1>
		</div>
		<div class="contwrap has_fixed_title">
			<!----- 탭 ----->
			<div class="tab_box">
				<ul class="tab_wrap clearfix">
					<li><a href="./manage_event_luckyDraw.php">Lucky Draw</a></li>
					<li class="active"><a href="./manage_event_cardGame.php">같은그림찾기</a></li>
				</ul>
			</div>
			<!----- 컨텐츠 ----->
			<p class="total_num">총 <?=$rankers_count?>개</p>
			<table id="datatable" class="list_table">
				<thead>
					<tr class="tr_center">
						<th>게임참여일</th>
						<th>전체순위</th>
						<th>상품전달여부</th>
						<th>ID(Email)</th>
						<th>Country</th>
						<th>Name</th>
						<th>Phone Number</th>
						<th>Affiliation</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($rankers_count > 0) {
							foreach($rankers as $rk){
					?>
					<tr class="tr_center">
						<td><?=$rk['register_date']?></td>
						<td><?=$rk['rank']?></td>
						<td>
					<?php
								if($admin_permission["auth_live_event"] <= 1){
									echo ($at['delivery_yn'] == "Y") ? "예" : "아니오";
								} else {
					?>
							<label for="approve<?=$rk['idx']?>Y"><input type="radio" name="approve<?=$rk['idx']?>" id="approve<?=$rk['idx']?>Y" value="Y" <?=($rk['delivery_yn'] == "Y") ? "checked" : ""?>> 예</label>
							<label for="approve<?=$rk['idx']?>N"><input type="radio" name="approve<?=$rk['idx']?>" id="approve<?=$rk['idx']?>N" value="N" class="approveNO" <?=($rk['delivery_yn'] != "Y") ? "checked" : ""?>> 아니오</label>
					<?php
									if ($rk['delivery_yn'] != "Y") {
					?>
					&nbsp;&nbsp;<button type="button" class="border_btn delivery" data-idx="<?=$rk['idx']?>">저장</button>
					<?php
									}
								}
					?>
						</td>
						<td><?=$rk['email']?></td>
						<td><?=$rk['nation_en']?></td>
						<td><?=$rk['first_name']." ".$rk['last_name']?></td>
						<td><?=$rk['phone']?></td>
						<td><?=$rk['affiliation']?></td>
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
	$('.delivery').click(function(){
		if (confirm("한번 저장하시면 변경할 수 없습니다.\n저장하시겠습니까?")) {
			var idx = $(this).data("idx");
			$.ajax({
				url : "../ajax/admin/ajax_event.php",
				type : "POST",
				data : {
					flag : "delivery_sameimg",
					idx : idx,
					status : $("input[name=approve"+idx+"]:checked").val()
				},
				dataType : "JSON",
				success : function(res) {
					alert(res.msg);
					if(res.code == 200) {
						location.reload();
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>