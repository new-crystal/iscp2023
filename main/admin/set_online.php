<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_poster"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$sql_category_list =	"SELECT
								ipac.idx, ipac.title_en, ipac.title_ko, ipac.prefix
							FROM info_poster_abstract_category AS ipac
							WHERE ipac.is_deleted = 'N'
							ORDER BY ipac.idx ASC";
	$category_list = get_data($sql_category_list);

	$prefix_arr = array();
?>
<style>
	input{max-width: 200px;}
</style>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">Poster Abstract Submission 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li><a href="./set_poster.php">Abstract Submission Guideline</a></li>
						<li class="active"><a href="javascript:;">Online Submission</a></li>
					</ul>
				</div>
				<form name="search_form">
					<table class="">
						<colgroup>
							<col width="200px">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>Abstract Category</th>
								<td class="category_select">
									<input type="text" placeholder="영문 카테고리 *" name="title_en">
									<input type="text" placeholder="국문 카테고리 *" name="title_ko">
									<input type="text" placeholder="논문번호 앞 2글자 *" name="prefix" maxlength="2">
									<button type="button" class="border_btn add">추가</button>
									<ul class="tag_list">
										<?php
											if (count($category_list) > 0) {
												foreach($category_list as $ct){
													array_push($prefix_arr, $ct['prefix']);
										?>
										<li 
											data-type="" data-idx="<?=$ct['idx']?>" 
											data-en="<?=$ct['title_en']?>" data-ko="<?=$ct['title_ko']?>" data-prefix="<?=$ct['prefix']?>"
										><?=$ct['title_en']?> / <?=$ct['title_ko']?> / <?=$ct['prefix']?><i class="delete_i"></i></li>
										<?php
												}
											}
										?>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_poster"] > 1){
					?>
					<div class="btn_wrap leftT">
						<button type="button" class="btn search_btn save">저장</button>
					</div>
					<?php
						}
					?>
				</form>
			</div>
		</div>
	</section>
<script>
	const prefix_arr = JSON.parse('<?=json_encode($prefix_arr)?>');

	$('input[name=prefix]').change(function(){
		var val = $(this).val();
		$(this).val(val.substr(0,2));
	});

	// 추가
	$('.add').click(function(){
		var title_en = $('input[name=title_en]').val();
		var title_ko = $('input[name=title_ko]').val();
		var prefix = $('input[name=prefix]').val();

		if (!title_en) {
			alert('영문 카테고리명을 입력해주세요.');
		} else if (!title_ko) {
			alert('국문 카테고리명을 입력해주세요.');
		} else if (!prefix) {
			alert('논문번호 앞 2글자를 입력해주세요.');
		} else if (prefix_arr.indexOf(prefix) > -1) {
			alert("논문번호 앞 2글자는 중복될 수 없습니다.\n확인 후 재요청하세요.");
		} else {
			$('.tag_list').append('<li data-type="insert" data-idx="" data-en="' + title_en + '" data-ko="' + title_ko + '" data-prefix="' + prefix + '">' + title_en + ' / ' + title_ko + ' / ' + prefix + '<i class="delete_i"></i></li>');

			$('input[name=title_en]').val("");
			$('input[name=title_ko]').val("");
			$('input[name=prefix]').val("");
		}
	});

	// 삭제
	$(document).on('click', '.delete_i', function(){
		var type = $(this).parent().data('type');
		if (type == "insert") {
			$(this).parent().remove();
		} else {
			$(this).parent().data('type', 'delete').hide();
		}
	});

	// 저장
	$('.save').click(function(){
		var prefix_dup_yn = false;

		var li_arr = new Array();
		var temp_this;
		$('.tag_list li').each(function(){
			temp_this = $(this);
			if (temp_this.data("type") == "insert" && prefix_arr.indexOf(temp_this.data("prefix")) > -1) {
				prefix_dup_yn = !prefix_dup_yn;
				return;
			}
			li_arr.push(temp_this.data("type") + "|" + temp_this.data("idx") + "|" + temp_this.data("en") + "|" + temp_this.data("ko") + "|" + temp_this.data("prefix"))
		});

		if (prefix_dup_yn) {
			alert("논문번호 앞 2글자는 중복될 수 없습니다.\n확인 후 재요청하세요.");
		} else if (confirm('저장하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_info_poster.php",
				type : "POST",
				data : {
					flag : "update_online_submission",
					li_arr : li_arr.join('^&')
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