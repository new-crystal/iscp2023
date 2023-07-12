<?php
	include_once('./include/head.php');

	if($admin_permission["auth_live_lecture_qna"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}
?>
<!-- 연사용 Q&A 새창 -->
<section class="container approval">
	<h2 class="bigTitle">Question</h2>
	<ul class="question_slick wheel_zoom">
		<!-- <li>ICOMES has grown as a worldwide academic society with <br/>more than 1,000 participants and eminent representative <br/>speakers in obesity every year since 2015 at its launch. <br/>ICOMES is an international academic conference that <br/>promotes cooperation. </li> -->
	</ul>
	<div class="custom_option">
		<div class="pagingInfo"></div>
		<div><button class="custom_arrow next_arrow"></button></div>
		<div><button class="custom_arrow prev_arrow"></button></div>
	</div>
</section>

<script>
	var first_flag = true;
	var show_index = 0;
	var current_list = new Array();
	var current_question = "";
	refresh();
	setInterval(refresh, 5000);
	function refresh(){
		$.ajax({
			url : "../ajax/admin/ajax_lecture.php",
			type : "POST",
			data : {
				flag : "get_qna_for_speaker",
				idx : "<?=$_GET['idx']?>"
			},
			dataType : "JSON",
			success : function(res) {
				if (!first_flag && current_list.length == 0 && res.list.length > 0) {
					location.reload();
				}

				var inner = "";
				res.list.forEach(function(el, index){
					if (el.idx = current_question) {
						show_index = index;
					}
					inner += '<li class="slick-slide" data-idx="' + el.idx + '">' + el.question + '</li>';
				});
				$('.question_slick').html(inner);
				current_list = res.list;
				if (show_index >= current_list.length) {
					show_index = (current_list.length-1);
				}
				set_page(show_index);

				if (first_flag) {
					first_flag = !first_flag;
				}
			}
		});
	}

	function set_page(i){
		$('li.slick-slide').hide();
		$('li.slick-slide').eq(i).show();
		$('.pagingInfo').text((i+1) + '/' + ($('li.slick-slide').length));
		current_question = $('li.slick-slide').eq(i).data('idx');
	}

	$('.prev_arrow').click(function(){
		if (show_index == 0) {
			show_index = (current_list.length-1);
		} else {
			show_index--;
		}
		set_page(show_index);
	});

	$('.next_arrow').click(function(){
		if ((show_index+1) == current_list.length) {
			show_index = 0;
		} else {
			show_index++;
		}
		set_page(show_index);
	});
</script>
<?php include_once('./include/footer.php');?>