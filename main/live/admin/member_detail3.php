<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$member_idx = $_GET["idx"];
	if(!$member_idx) {
		echo"<script>alert('비정상적인 접근 방법입니다.'); window.location.replace('./member_list.php');</script>";
		exit;
	}
	if($admin_permission["auth_account_member"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$member_lecture_query = "
								SELECT
									ra.idx, CONCAT(ra.first_name,' ',ra.last_name) AS name, DATE_FORMAT(ra.register_date, '%y-%m-%d') AS regist_date, ra.cv,
									f.original_name AS file_name, CONCAT(f.path,'/',f.save_name) AS file_path  
								FROM request_abstract ra
								JOIN file f
								ON ra.notice_file = f.idx
								WHERE ra.is_deleted = 'N'
								AND ra.`type` = 1
								AND ra.register = {$member_idx}
							";
	$member_lecture = sql_fetch($member_lecture_query);

	$idx = isset($member_lecture["idx"]) ? $member_lecture["idx"] : "";
	$name = isset($member_lecture["name"]) ? $member_lecture["name"] : "";
	$cv = isset($member_lecture["cv"]) ? $member_lecture["cv"] : "";
	$file_name = isset($member_lecture["file_name"]) ? $member_lecture["file_name"] : "";
	$file_path = isset($member_lecture["file_path"]) ? $member_lecture["file_path"] : "";
	$register_date = isset($member_lecture["regist_date"]) ? $member_lecture["regist_date"] : "";

?>
<style>
	.no_data {font-size: 18px; text-align: center;}
</style>
	<section class="detail">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">일반회원</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<?php include_once("./include/member_nav.php");?>
				<table class="list_table">
					<thead>
						<tr class="tr_center">
							<th>이름</th>
							<th>CV</th>
							<th>Lecture Note File</th>
							<!-- <th>Category</th> -->
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(!$member_lecture) {
							echo "<tr><td class='no_data' colspan='4'>No Data</td></tr>";
						} else {
							$ext = strtolower(end(explode(".",$file_name)));
					?>
						<tr class="tr_center">
							<td><a href="./lecture_note_detail.php?idx=<?=$idx?>"><?=$name?></a></td>
							<!-- <td><a href="./pdf_viewer.php?path=<?=$cv_file_path?>" target="_blank"><?=$cv_file_name?></a></td> -->
							<td><?=$cv?></td>
						<?php
							if($ext == "pdf") {
						?>
								<td><a href="./pdf_viewer.php?path=<?=$file_path?>" target="_blank"><?=$file_name?></a></td>
						<?php } else {?>
								<td><a href="<?=$file_path?>" download><?=$file_name?></a></td>
						<?php }?>
							<td><?=$register_date?></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./member_list.php'">목록</button>
				</div>
			</div>
		</div>
	</section>
<script>
$(document).ready(function(){
	$(".tab_wrap").children("li").eq(2).addClass("active");
});
</script>
<?php include_once('./include/footer.php');?>