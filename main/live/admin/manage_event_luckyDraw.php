<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_event"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$sql_attend =	"SELECT
						ld.idx AS idx,
						ld.delivery_yn,
						mb.email,
						nt.nation_en,
						mb.first_name, mb.last_name,
						mb.phone,
						mb.affiliation
					FROM event_luckydraw AS ld
					INNER JOIN member AS mb
						ON mb.idx = ld.member_idx
					LEFT JOIN nation AS nt
						ON nt.idx = mb.nation_no
					WHERE ld.win_yn = 'Y'
					ORDER BY ld.idx";
	$attends = get_data($sql_attend);
	$attends_count = count($attends);
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
					<li class="active"><a href="./manage_event_luckyDraw.php">Lucky Draw</a></li>
					<li><a href="./manage_event_cardGame.php">같은그림찾기</a></li>
				</ul>
			</div>
			<!----- 컨텐츠 ----->
			<p class="total_num">총 <?=number_format($attends_count)?>개</p>
			<table id="datatable" class="list_table">
				<thead>
					<tr class="tr_center">
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
						if ($attends_count > 0) {
							foreach($attends as $at){
					?>
					<tr class="tr_center">
						<td>
					<?php
								if($admin_permission["auth_live_event"] <= 1){
									echo ($at['delivery_yn'] == "Y") ? "예" : "아니오";
								} else {
					?>
							<label for="approve<?=$at['idx']?>Y"><input type="radio" name="approve<?=$at['idx']?>" id="approve<?=$at['idx']?>Y" value="Y" <?=($at['delivery_yn'] == "Y") ? "checked" : ""?>> 예</label>
							<label for="approve<?=$at['idx']?>N"><input type="radio" name="approve<?=$at['idx']?>" id="approve<?=$at['idx']?>N" value="N" class="approveNO" <?=($at['delivery_yn'] != "Y") ? "checked" : ""?>> 아니오</label>
					<?php
									if ($at['delivery_yn'] != "Y") {
					?>
							&nbsp;&nbsp;<button type="button" class="border_btn delivery" data-idx="<?=$at['idx']?>">저장</button>
					<?php
									}
								}
					?>
						</td>
						<td><?=$at['email']?></td>
						<td><?=$at['nation_en']?></td>
						<td><?=$at['first_name']." ".$at['last_name']?></td>
						<td><?=$at['phone']?></td>
						<td><?=$at['affiliation']?></td>
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
					flag : "delivery_luckydraw",
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