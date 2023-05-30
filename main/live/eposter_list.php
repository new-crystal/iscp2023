<?php
	include_once ("./include/header.php");

	// category list
	$sql_category_list =	"SELECT
								idx, title_en
							FROM info_poster_abstract_category
							WHERE is_deleted = 'N'
							ORDER BY idx ASC";
	$category_list = get_data($sql_category_list);
	
?>

<style>
	body {background: url("./images/img/img_ePosterbg.png") no-repeat center/cover;}
	@media screen and (max-width: 1024px)
html, body {
    height: auto;
}
	/*.ePoster_list::-webkit-scrollbar {
		background-color: transparent;
		width: 2px;
	}
	.ePoster_list::-webkit-scrollbar-track {
		background-color: #3d3d3d;
		border-radius: 20px;
	}
	.ePoster_list::-webkit-scrollbar-thumb {
		background-color: red;
		border-radius: 20px;
		box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
		border: 20px solid #1a1a1a;
	}*/
	.ePoster_list{ -ms-overflow-style: none; } 
	.ePoster_list::-webkit-scrollbar{ display:none; }

</style>
		<p class="mb_pg_title">Poster</p>
		<section class="container eposter_list">
			<!----- title ----->
			<h2 class="title">
				<img src="./images/icon/icon_ePoster.png" alt="#">Poster
			</h2>
			<article class="clearfix posrter_article">
				<!----- search ----->
				<div class="rightT ePoster_top clearfix">
					<!-- <form> -->
						<input type="checkbox" id="chk_liked">
						<label for="chk_liked" class="chk_liked"><span></span>Liked</label>
						<select class="ePoster_select" name="keyfield">
							<option value="title">Title</option>
							<option value="author">Author</option>
							<option value="code">Poster Code</option>
						</select>
						<label for="searchPoster" class="searchPoster">
							<input type="text" id="searchPoster" name="keyword" placeholder="Search a Poster">
							<button type="button" name="search"><img src="./images/icon/arrow_right_yellow.png" alt="오른쪽 화살표"></button>
						</label>
					<!-- </form> -->
				</div>
				<!----- list ----->
				<ul class="ePoster_list clearfix">
					<!-- 1 -->
					<li class="category_strongGreen likedPoster category_contents" style="display: none;">
						<div class="clearfix">
							<p class="floatL ePoster_list_title"><span>Liked Poster</span></p>
							<div class="floatR ePoster_list_more"><img src="./images/icon/arrow_down_b.png" alt=""></div>
						</div>
						<div class="ePoster_cont_wrap scroll_plugin1">
							<ul class="clearfix posters" name="liked">
								<!-- contents -->
							</ul>
						</div>
					</li>
					
					<?php
						//foreach($category_list as $ct){
						for($i=0;$i<count($category_list);$i++){
							$class_num = sprintf('%02d', ($i+1));
							$ct = $category_list[$i];
					?>
					<li class="contents<?=$class_num?> category_contents">
						<div class="clearfix">
							<p class="floatL ePoster_list_title"><span>Category. <?=$class_num?></span><span class="detail"><?=$ct['title_en']?></span></p>
							<div class="floatR ePoster_list_more"><img src="./images/icon/arrow_down_b.png" alt=""></div>
						</div>
						<!----- list contents start ----->
						<div class="ePoster_cont_wrap">
							<ul class="clearfix posters" name="posters_<?=$ct['idx']?>">
								<!-- contents -->
							</ul>
						</div>
					</li>
					<?php
						}
					?>
				</ul>
				<!----- btn_scroll ----->
				<!-- scorll btn 삭제 (인투온) -->
				<!--
				<div class="centerT scrollImg">
					<img src="./images/icon/icon_scroll_down_w.png" alt="아이콘_스크롤다운">
				</div>
				-->
			</article>
		</section>
		<?php include_once("./include/popup_mypage.php") ?>
		<script>

			$(function(){
				get_list();
			});

			$('input[name=keyword]').keyup(function(e){
				if (e.keyCode == 13) {
					get_list();
				}
			});

			$('button[name=search]').click(function(){
				get_list();
			});

			$(document).on('click', '.ePoster_cont_like', function(){
				get_list();
				$.ajax({
					url : "../ajax/client/ajax_abstract.php",
					type : "POST",
					data : {
						flag : 'fave',
						idx : $(this).data('idx')
					},
					dataType : "JSON",
					success : function(res) {
						console.log(res);
						if(res.code == 200) {
							get_list();
						} else {
							alert(res.msg);
						}
					}
				});
				return false;
			});

			// list
			function get_list(){
				$.ajax({
					url : "../ajax/client/ajax_abstract.php",
					type : "POST",
					data : {
						flag : 'get_list',
						keyfield : $('select[name=keyfield] option:selected').val(),
						keyword : $('input[name=keyword]').val()
					},
					dataType : "JSON",
					success : function(res) {
						if(res.code == 200) {
							$('ul.posters').empty();
							if (res.total_count > 0) {
								var li_color_arr = ["purple", "grayBlue", "emerald", "lightGreen", "green", "darkYellow", "yellow", "red", "darkRed", "pink"];
								var inner, inner_class, temp_this, heart_name;
								res.list.forEach(function(el){
									heart_name = el.my_fave_yn == "Y" ? "icon_heart_b" : "icon_heart";
									inner = '';
									inner +=	'<li class="ePoster_cont likedBG_' + li_color_arr[(el.category_rownum-1)] + '">';
									inner +=		'<a href="./eposter_chat.php?idx=' + el.idx + '">';
									inner +=			'<div class="floatL ePoster_cont_like" data-idx="' + el.idx + '">';
									inner +=				'<img src="./images/icon/' + heart_name + '.png" alt="아이콘_하트">LIKE <span>' + el.fave_count + '</span>';
									inner +=			'</div>';
									inner +=			'<div class="ePoster_cont_comments">Comments<span>' + el.reply_count + '</span></div>';
									inner +=			'<h1 class="ePoster_cont_title">' + el.code + '</h1>';
									inner +=			'<p class="ePoster_cont_txt">' + el.title + '</p>';
									inner +=			'<h2 class="ePoster_cont_writer">PRESENTER</h2>';
									inner +=			'<h3 class="ePoster_cont_name">' + el.author_name + '</h3>';
									inner +=			'<h4 class="ePoster_cont_from">' + el.author_affiliation + '</h4>';
									inner +=		'</a>';
									inner +=	'</li>';

									if (el.my_fave_yn == "Y") {
										$('ul[name=liked]').append(inner);
									}
									$('ul[name=posters_' + el.category_idx + ']').append(inner);
								});

								if ($('ul[name=liked] li').length <= 0) {
									$('ul[name=liked]').html('<li style="text-align:center;width:100%;">No Data</li>');
								}

								$('ul[name^=posters_]').each(function(){
									temp_this = $(this);
									if (temp_this.children('li').length > 0) {
										temp_this.parents('.category_contents').show();
									} else {
										temp_this.parents('.category_contents').hide();
									}
								});
							}
						} else {
							alert(res.msg);
						}
					}
				});
			}

			// liked checkbox
			$('#chk_liked').change(function(){
				//console.log('hi', $(this).is('checked'));
				if ($(this).prop('checked')) {
					$('.likedPoster').show();
				} else {
					$('.likedPoster').hide();
				}
			});
		</script>
	</body>
</html>