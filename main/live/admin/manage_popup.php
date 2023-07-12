<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_popup"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$sql_info =	"SELECT
					popup_video_url
				FROM info_live";
	$url = sql_fetch($sql_info)['popup_video_url'];
?>
<section class="detail">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix">
			<h1 class="font_title">팝업 관리</h1>
		</div>
		<!----- 컨텐츠 ----->
		<div class="contwrap has_fixed_title">
			<!-- <form method="POST" action=""> -->
			<table>
				<colgroup>
					<col width="10%">
					<col width="40%">
				</colgroup>
				<tbody>
					<tr>
						<th>Youtube 영상주소</th>
						<td>
							<input type="text" placeholder="URL 입력" name="url" value="<?=$url?>">
						</td>
					</tr>
				</tbody>
			</table>
			<!-- </form> -->
			<!----- 버튼 ----->
			<?php
				if($admin_permission["auth_live_popup"] > 1){
			?>
			<div class="btn_wrap">
				<button type="button" class="btn save_btn">저장</button>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</section>
<script>
	$('.save_btn').click(function(){
		var url = $('[name=url]').val();

		var confirm_msg = "저장하시겠습니까?";
		if (!url) {
			confirm_msg = "경로를 빈 값으로 입력 시, 화면에 팝업이 노출되지 않습니다.\n" + confirm_msg;
		}

		if (confirm(confirm_msg)) {
			$.ajax({
				url : "../ajax/admin/ajax_info_live.php",
				type : "POST",
				data : {
					flag : "save_popup_url",
					url : url
				},
				dataType : "JSON",
				success : function(res) {
					if(res.code == 200) {
						alert('완료되었습니다');
						location.reload();
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>