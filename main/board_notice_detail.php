<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$board_id = isset($_GET["no"]) ? preg_replace("/[^0-9]/","",$_GET["no"]) : "";
	$page = isset($_GET["p"]) ? preg_replace("/[^0-9]/","",$_GET["p"]) : "";

	$sql =	"
			SELECT
				b.idx, b.title_en, b.title_ko, f.path, 
				b.content_en, b.content_ko, b.answer_en, b.answer_ko, 
				b.view, DATE_FORMAT(b.register_date, '%Y-%m-%d') AS register_date,
				b.file_view
			FROM board AS b
			LEFT JOIN(
				SELECT
					idx, CONCAT(path,'/',save_name) AS path, original_name
				FROM `file`
			)AS f
			ON b.thumnail = f.idx
			WHERE b.idx = {$board_id}
			AND b.is_deleted = 'N'
			AND b.type = 1
			";
	$detail = sql_fetch($sql);

	if($detail["idx"] == ""){
		echo "<script>alert('유효하지 않은 게시글입니다.'); window.location.replace('./board_list.php?t=".$board_type."')</script>";
		exit;
	}

	$view_sql = "UPDATE board SET view = view+1 WHERE idx = {$board_id}";
	sql_query($view_sql);

	$title = $detail["title_ko"];
	$contents = $detail["content_ko"];
	$date_title = "등록일";
	$view_title = "조회수";
	$back_title = "목록";
	if ($language !== "ko") {
		$title = $detail["title_en"];
		$contents = $detail["content_en"];
		$date_title = "Date";
		$view_title = "View";
		$back_title = "List";
	}
	$num = $_GET['num'] ?? null;
?>

<style>
	#tbodys tr{border-bottom:none; } 
</style>

<section class="container board_detail">
	<div class="sub_background_box">
		<div class="sub_inner">
			<div>
				<h2>News & Notice</h2>
				<!-- <ul class="clearfix"> -->
				<!-- 	<li>Home</li> -->
				<!-- 	<li>News & Notice</li> -->
				<!-- 	<li>Notice</li> -->
				<!-- </ul> -->
			</div>
		</div>
	</div>
	<div class="inner">
		<!--
		<ul class="tab_pager">
			<li><a href="./board_news.php">News</a></li>
			<li class="on"><a href="./board_notice.php">Notice</a></li>
			<li><a href="./board_faq.php">FAQ</a></li>
		</ul>
		-->
		<div class="circle_title">News & Notice</div> 
		<div>
			<table class="table">
				<colgroup>
					<col class="num_td">
					<col>
					<col class="date_td mobile_none">
				</colgroup>
				<thead>
					<tr>
						<th><?= $num; ?></th>
						<td class="board_title">
							<h5>
								<?php
									echo stripslashes($title);

									$boardtime = $detail["register_date"];
									$timenow = date("Y-m-d");
									$time_yesterday = date("Y-m-d", strtotime($day." -1 day"));
									if($boardtime >= $time_yesterday && $boardtime <= $timenow){
										echo '&nbsp;<p class="label ml5">new</p>';
									}
								?>
								<p class="mb_only"><?= $boardtime ?></p>
							</h5>
						</td>
						<td class="mobile_none"><?= $boardtime ?></td>
					</tr>
				</thead>
				<tbody id="tbodys" style="border-bottom: 1px solid black;">
					<tr>
						<td colspan="3">
							<?=htmlspecialchars_decode(stripslashes($contents))?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php
			if($detail["idx"]== 34) {
		?>
			<table class="table">
				<colgroup>
					<col class="num_td" style="width:100px;">
					<col>
					<col class="date_td mobile_none">
				</colgroup>
				<thead>
				</thead>
				<tbody>
					<tr>
						<th>첨부파일1</th>
						<td class="board_title downloads">
							<a href="./download/(Final) ISCP 2023_Program Book.pdf" download="">(Final) ISCP 2023_Program Book.pdf (다운 <?= number_format($detail['file_view']); ?>회)</a>
						</td>
						<td class="mobile_none"></td>
					</tr>
				</tbody>
			</table>
		<?php
			}
		?>
			<div class="pager_btn_wrap">
				<button type="button" class="btn green_btn" onclick="javascript:window.location.replace('./board_notice.php?page=<?=$page?>');"><!--<?=$back_title?>-->List</button>
			</div>
		</div>
	</div>
</section>
<input type="hidden" name="idx" value="<?= $detail["idx"]; ?>">
<script>
$(document).on("click", ".downloads", function(){

	var idx = $("input[name=idx]").val();
	var data = {
		flag : "file_view",
		idx : idx
	};
	$.ajax({
		url : PATH+"ajax/client/ajax_board.php",
		type : "POST",
		data : data,
		dataType : "JSON",
		success : function(res){
			console.log(res);
		}
	});
});

	$(document).ready(function(){
		$(window).resize(function(){
			var window_width = $(window).width();
			console.log(window_width);
			if (window_width <= 1024){
				var x = $(".table").rows[0].cells
				x[0].colSpan="2"
				x[1].colSpan="6"

				alert(x)
			}
		});
	});
</script>
<?php include_once('./include/footer.php');?>