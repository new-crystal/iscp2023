<?php
	include_once ("./include/header.php");

	$idx = $_GET['idx'];
	$member_idx = isset($_SESSION["ADMIN"]["idx"]) ? $_SESSION["ADMIN"]["idx"] : $_SESSION["USER"]["idx"];

	// abstract
	$sql_info =	"SELECT
					ab.`code`,
					ipac.rownum AS category_rownum,
					ipac.title_en AS category_title_en,
					ab.title,
					ab.author_name,
					ab.author_affiliation,
					IFNULL(total_fv.cnt, 0) AS fave_count,
					IF(my_fv.abstract_idx IS NOT NULL, 'Y', 'N') AS my_fave_yn,
					CONCAT(fi_poster.path, '/', fi_poster.save_name) AS fi_poster_path,
					CONCAT(fi_pdf.path, '/', fi_pdf.save_name) AS fi_pdf_path
				FROM abstract AS ab
				LEFT JOIN (
					SELECT
						(@rownum:=@rownum+1) AS rownum, idx, title_en
					FROM info_poster_abstract_category, (SELECT @rownum:=0) TMP
					WHERE is_deleted = 'N'
					ORDER BY idx
				) AS ipac
					ON ipac.idx = ab.category_idx
				LEFT JOIN (
					SELECT
						abstract_idx, COUNT(idx) AS cnt
					FROM abstract_fave
					GROUP BY abstract_idx
				) AS total_fv
					ON total_fv.abstract_idx = ab.idx
				LEFT JOIN (
					SELECT
						abstract_idx
					FROM abstract_fave
					WHERE member_idx = '".$member_idx."'
				) AS my_fv
					ON my_fv.abstract_idx = ab.idx
				LEFT JOIN `file` AS fi_poster
					ON fi_poster.idx = ab.poster_img
				LEFT JOIN `file` AS fi_pdf
					ON fi_pdf.idx = ab.pdf_img
				WHERE ab.idx = '".$idx."'";
	$info = sql_fetch($sql_info);

	// reply
?>

<style>
	body {background: url("./images/img/img_ePosterbg.png") no-repeat center/cover;}
</style>
		<p class="mb_pg_title">Poster</p>
		<section class="container auto poster_comment">
			<article class="ePoster_chat">
				<!----- title ----->
				<div>
					<h2 class="chat_category">Category. <?=sprintf('%02d', $info['category_rownum'])." ".$info['category_title_en']?></h2>
					<h1 class="poster_name"><?=$info['title']?></h1>
					<h1 class="poster_uploader">
						<?php
							echo $info['author_name'];
							if ($info['author_affiliation'] != "") {
								echo " (".$info['author_affiliation'].")";
							}
						?>
					</h1>
				</div>
				<!----- contents ----->
				<div class="ePoster_chat_cont">
					<!-- 상단 : 좋아요 박스 -->
					<div class="clearfix">
						<div class="floatR">
							<span class="chat_likeBox_comment">Please press LIKE button if this poster was beneficial.</span>
							<?php
								$class_on = "";
								$heart_color = "w";
								if ($info['my_fave_yn'] == "Y") {
									$class_on = "on";
									$heart_color = "b";
								}
							?>
							<div class="chat_likeBox <?=$class_on?>">
								<img src="./images/icon/icon_heart_<?=$heart_color?>.png" alt="아이콘_하트"> LIKE <span name="like_count"><?=$info['fave_count']?></span>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<!-- 왼쪽 : poster -->
						<div class="floatL chat_cont_L">
							<div class="img_spot" style="background-image: url('<?=$info['fi_poster_path']?>'); background-repeat: no-repeat;"></div>
							<a href="/main/pdf_library/viewer.html?file=<?=$info['fi_pdf_path']?>" rel="noopener noreferrer" class="ePoster_btn_download centerT" target="_blank"><p class="sub_section_title main_theme">Poster File Viewer</p></a>
							
						</div>
						<!----- 0826 추가 ----->
						<div class="btn_wrap mb_only">
							<button type="button" class="chat_btn open_chat_btn">Comment</button>
							<button type="button" class="chat_btn" onclick="location.href='./eposter_list.php'">List</button>
						</div>
						<!-- 오른쪽 : chat -->
						<div class="floatR chat_cont_R">
							<div class="pop_bg"></div>
							<div class="chat_inner">
								<i class="chat_delete_btn mb_only"><img src="./images/icon/icon_x_w.png" alt=""></i>
								<h3 class="comments_count">Comments<span name="total_count">35</span></h3>
								<div class="ePoster_chat_area scroll_plugin1">
									
								</div>
								<div class="clearfix ePoster_chat_write">
									<div class="floatL">
										<label for="chat_write_area" class="chat_write_area">
											<input type="text" id="chat_write_area" placeholder="Please leave a comment.(200 characters)" max-length="200">
										</label>
									</div>
									<div class="floatR">
										<button type="button" class="chat_btn send" data-idx>Comment</button>
										<button type="button" class="chat_btn" onclick="location.href='./eposter_list.php'">List</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
		</section>
		<?php include_once("./include/popup_mypage.php") ?>
		<script src="/main/pdf_library/viewer.js"></script>
		<link rel="stylesheet" href="/main/pdf_library/viewer.css">
		<script>
			$(function(){
				get_list();
			});

			// 좋아요
			$('.chat_likeBox').click(function(){
				$.ajax({
					url : "../ajax/client/ajax_abstract.php",
					type : "POST",
					data : {
						flag : 'fave',
						idx : '<?=$idx?>'
					},
					dataType : "JSON",
					success : function(res) {
						console.log(res);
						if(res.code == 200) {

							var _this = $('.chat_likeBox');
							var heart_src = "";

							if (res.type == "ins") {
								_this.addClass("on");
								heart_src = "./images/icon/icon_heart_b.png";
							} else {
								_this.removeClass("on");
								heart_src = "./images/icon/icon_heart_w.png";
							}

							_this.children("img").attr("src", heart_src);
							$('[name=like_count]').text(res.current_count);
						} else {
							alert(res.msg);
						}
					}
				});
			});

			// 댓글 등록
			$('#chat_write_area').keyup(function(e){
				if (e.keyCode == 13) {
					modify_reply();
				} else {
					$(this).val($(this).val().substr(0,200));
				}
			});
			$('.send').click(function(){
				modify_reply();
			});
			function modify_reply(){
				var contents = $('#chat_write_area').val();
				if (!contents) {
					alert('Please enter the comment.');
				} else {
					$.ajax({
						url : "../ajax/client/ajax_abstract.php",
						type : "POST",
						data : {
							flag : 'modify_reply',
							abstract_idx : '<?=$idx?>',
							reply_idx : $('.send').data('idx'),
							contents : contents
						},
						dataType : "JSON",
						success : function(res) {
							//console.log(res);
							if(res.code == 200) {
								$('#chat_write_area').val("");
								$('.send').data('idx', "").text("Comment");
								get_list();
							} else {
								alert(res.msg);
							}
						}
					});
				}
			}

			// 댓글 수정
			$(document).on('click', 'button.modify', function(){
				$('#chat_write_area').val($(this).parent().siblings(".userChat").children('p').eq(1).text());
				$('.send').data('idx', $(this).parents('.ePoster_chat_box').data('idx')).text("댓글 수정");
			});

			// 댓글 삭제
			$(document).on('click', 'button.remove', function(){
				if (confirm('Are you sure you want to delete the selected comment?')) {
					$.ajax({
						url : "../ajax/client/ajax_abstract.php",
						type : "POST",
						data : {
							flag : 'remove_reply',
							idx : $(this).parents('.ePoster_chat_box').data('idx')
						},
						dataType : "JSON",
						success : function(res) {
							//console.log(res);
							if(res.code == 200) {
								get_list();
							} else {
								alert(res.msg);
							}
						}
					});
				}
			});

			// 댓글 리스트
			function get_list(){
				var wrap = $('.ePoster_chat_area');
				$.ajax({
					url : "../ajax/client/ajax_abstract.php",
					type : "POST",
					data : {
						flag : 'get_reply_list',
						idx : '<?=$idx?>'
					},
					beforeSend: function() {
						wrap.mCustomScrollbar("destroy");
					},
					dataType : "JSON",
					success : function(res) {
						console.log(res);
						if(res.code == 200) {

							var inner = "";

							if (res.total_count <= 0) {
								inner +=	'<div class="">No Data</div>';
							} else {
								res.list.forEach(function(el){
									inner +=	'<div class="clearfix ePoster_chat_box" data-idx="' + el.idx + '">';
									inner +=		'<div class="floatL"><img src="./images/icon/icon_noProfile.png" alt="아이콘_프로필사진기본" class="profile_img"></div>';
									inner +=		'<div class="floatL userChat">';
									inner +=			'<p>' + el.register_date + '<span>' + el.member_name + '</span></p>';
									inner +=			'<p>' + el.contents + '</p>';
									inner +=		'</div>';
									if (el.mine_yn == 'Y') {
										inner +=	'<div class="comment_btn rightT">';
										inner +=		'<button type="button" class="modify transparent_btn">Correct</button>';
										inner +=		'<button type="button" class="remove transparent_btn">Delete</button>';
										inner +=	'</div>';
									}
									inner +=	'</div>';
								});
							}

							wrap.html(inner);
							wrap.scrollTop(wrap[0].scrollHeight);
							wrap.mCustomScrollbar({
								theme : 'white',
								/*mouseWheelPixels: 100,
								scrollInertia: 0*/
							});
							wrap.mCustomScrollbar("scrollTo", wrap[0].scrollHeight);

							$('[name=total_count]').text(res.total_count);
						} else {
							alert(res.msg);
						}
					}
				});
			}
		</script>
	</body>
</html>