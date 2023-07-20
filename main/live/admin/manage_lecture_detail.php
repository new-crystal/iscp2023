<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	include_once('../live/include/set_event_period.php');

	if($admin_permission["auth_live_lecture"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$idx = $_GET['idx'];
	$is_modify = isset($_GET['idx']);

	$info = array();
	if ($is_modify) {
		$sql_info =	"SELECT
						*
					FROM lecture AS lc
					WHERE lc.idx = '".$idx."'";
		$info = sql_fetch($sql_info);
		foreach($info as $key=>$value){
			$info[$key] = stripslashes($value);
		}

		$sql_places =	"SELECT 
							lpu.idx, 
							lpu.place_idx AS val,
							lp.title_en
						FROM lecture_place_use AS lpu
						INNER JOIN lecture_place AS lp
							ON lp.idx = lpu.place_idx
						WHERE lpu.lecture_idx = '".$idx."'";
		$info['places'] = get_data($sql_places);

		$sql_speakers =	"SELECT 
							lsj.idx, 
							lsj.speaker_idx AS val,
							ls.name_en
						FROM lecture_speaker_join AS lsj
						INNER JOIN lecture_speaker AS ls
							ON ls.idx = lsj.speaker_idx
						WHERE lsj.lecture_idx = '".$idx."'";
		$info['speakers'] = get_data($sql_speakers);
	}

	// category list
	$sql_category_list =	"SELECT
								idx, title_en
							FROM lecture_category
							WHERE is_deleted = 'N'
							ORDER BY idx ASC";
	$category_list = get_data($sql_category_list);

	// place list
	$sql_place_list =	"SELECT
							idx, title_en, url
						FROM lecture_place
						WHERE is_deleted = 'N'
						ORDER BY idx ASC";
	$place_list = get_data($sql_place_list);

	// speaker list
	$sql_speaker_list =	"SELECT
							ls.idx, 
							ls.name_en, ls.affiliation_en, 
							CONCAT(fi_profile.path, '/', fi_profile.save_name) AS fi_profile_path
						FROM lecture_speaker AS ls
						LEFT JOIN `file` AS fi_profile
							ON fi_profile.idx = ls.profile_img
						WHERE is_deleted = 'N'
						ORDER BY idx ASC";
	$speaker_list = get_data($sql_speaker_list);
?>
<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">Lecture 관리</h1>
		</div>
		<div class="contwrap centerT has_fixed_title">
			<form>
				<!----- 입력폼 ----->
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>Agenda Title(영문) *</th>
							<td colspan="3">
								<input type="text" placeholder="100자 이내" maxlength="100" name="title_en" value="<?=$info['agenda_title_en']?>">
							</td>
						</tr>
						<tr>
							<th>Theme(영문)</th>
							<td colspan="3">
								<input type="text" placeholder="100자 이내" maxlength="100" name="theme_en" value="<?=$info['theme_en']?>">
							</td>
						</tr>
						<tr>
							<th>Category *</th>
							<td>
								<select name="category">
									<option value="" hidden>Category 선택</option>
									<?php
										foreach($category_list as $ct){
											foreach($ct as $key=>$value){
												$ct[$key] = htmlspecialchars_decode($value);
											}
									?>
									<option value="<?=$ct['idx']?>" <?=($info['category_idx'] == $ct['idx']) ? "selected" : ""?>><?=$ct['title_en']?></option>
									<?php
										}
									?>
								</select>
							</td>
							<th>Time(강의일시) *</th>
							<td class="input_wrap">
								<input type="text" name="start" class="datepicker-here" data-date-format="yyyy-mm-dd" data-time-format="hh:ii" data-language='en' data-timepicker="true">
								<span>~</span>
								<input type="text" name="end" class="datepicker-here" data-date-format="yyyy-mm-dd" data-time-format="hh:ii" data-language='en' data-timepicker="true">
							</td>
						</tr>
						<tr>
							<th>Place *</th>
							<td class="clearfix">
								<!-- select -->
								<select class="w50 tag_input floatL" name="place">
									<option value="">Place 선택</option>
									<?php
										foreach($place_list as $pl){
											foreach($pl as $key=>$value){
												$pl[$key] = htmlspecialchars_decode($value);
											}
									?>
									<option value="<?=$pl['idx']?>"><?=$pl['title_en']?></option>
									<?php
										}
									?>
								</select>
								<!-- selected option box -->
								<ul class="tag_list floatL">
									<?php
										if ($is_modify) {
											if (count($info['places']) > 0) {
												foreach($info['places'] as $pl){
													foreach($pl as $key=>$value){
														$pl[$key] = htmlspecialchars_decode($value);
													}
									?>
									<li data-type="" data-idx="<?=$pl['idx']?>" data-val="<?=$pl['val']?>"><?=$pl['title_en']?><i class="delete_i"></i></li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td>
							<th>Chairperson *</th>
							<td class="clearfix">
								<!-- select -->
								<select class="w50 tag_input floatL" name="speaker">
									<option value="">Speaker 선택</option>
									<?php
										foreach($speaker_list as $sp){
											foreach($sp as $key=>$value){
												$sp[$key] = htmlspecialchars_decode($value);
											}
									?>
									<option value="<?=$sp['idx']?>"><?=$sp['name_en']?></option>
									<?php
										}
									?>
								</select>
								<!-- selected option box -->
								<ul class="tag_list floatL">
									<?php
										if ($is_modify) {
											if (count($info['speakers']) > 0) {
												foreach($info['speakers'] as $sp){
													foreach($sp as $key=>$value){
														$sp[$key] = htmlspecialchars_decode($value);
													}
									?>
									<li data-type="" data-idx="<?=$sp['idx']?>" data-val="<?=$sp['val']?>"><?=$sp['name_en']?><i class="delete_i"></i></li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
				<!----- btn ----->
				<div class="btn_wrap leftT">
					<button type="button" class="border_btn" onclick="location.href='./manage_lecture.php'">목록</button>
					<?php
						if($admin_permission["auth_live_lecture"] > 1){
							if ($is_modify) {
					?>
					<button type="button" class="btn gray_btn delete_btn">삭제</button>
					<?php
							}
					?>
					<button type="button" class="btn save_btn">저장</button>
					<?php
						}
					?>
				</div>
			</form>
		</div>
	</div>
</section>
<script>

	// ** DOCUMENT ** //
	$(document).ready(function() {
		// 자동완성 안됨
		$('input').attr('autocomplete', 'off');

		// datepicker
		$('.datepicker-here').datepicker({
			minDate: new Date('<?=$_PERIOD[0]?> 00:00'),
			maxDate: new Date('<?=end($_PERIOD)?> 23:59'),
			minutesStep: 5
		});

		// datepicker 데이터 세팅
		var pt_start = "<?=$info['period_time_start']?>";
		if (pt_start) {
			$('[name=start]').datepicker().data('datepicker').selectDate(new Date(pt_start));
		}
		var pt_end = "<?=$info['period_time_end']?>";
		if (pt_end) {
			$('[name=end]').datepicker().data('datepicker').selectDate(new Date(pt_end));
		}
	});

	/* lectureList popup */
	$(".btn_category").click(function(){$(".pop_category").show();});
	$(".btn_place").click(function(){$(".pop_place").show();});
	$(".btn_speaker").click(function(){$(".pop_speaker").show();});

	// place 추가
	$('[name=place]').change(function(){
		var dup_flag = false;
		var exist_cnt = 0;
		var selected_opt = $('[name=place] option:selected');
		$('[name=place]+.tag_list li').each(function(){
			if ($(this).data('val') == selected_opt.val()) {
				dup_flag = !dup_flag;
				return;
			}

			if ($(this).data('type') !== "delete") {
				exist_cnt++;
			}
		});
		if (dup_flag) {
			alert("중복되는 Place가 이미 등록되어있습니다.");
			return false;
		} else if (exist_cnt >= 3) {
			alert("최대 3개까지 등록 가능합니다.");
			return false;
		}

		$('[name=place]+.tag_list').append('<li data-type="insert" data-idx="" data-val="' + selected_opt.val() + '">' + selected_opt.text() + '<i class="delete_i"></i></li>');
	});

	// speaker 추가
	$('[name=speaker]').change(function(){
		var dup_flag = false;
		var exist_cnt = 0;
		var selected_opt = $('[name=speaker] option:selected');
		$('[name=speaker]+.tag_list li').each(function(){
			if ($(this).data('val') == selected_opt.val()) {
				dup_flag = !dup_flag;
				return;
			}

			if ($(this).data('type') !== "delete") {
				exist_cnt++;
			}
		});
		if (dup_flag) {
			alert("중복되는 Speaker가 이미 등록되어있습니다.");
			return false;
		} else if (exist_cnt >= 5) {
			alert("최대 5개까지 등록 가능합니다.");
			return false;
		}

		$('[name=speaker]+.tag_list').append('<li data-type="insert" data-idx="" data-val="' + selected_opt.val() + '">' + selected_opt.text() + '<i class="delete_i"></i></li>');
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
	$('.save_btn').click(function(){
		var temp_this;

		var li_place_exist = false;
		var li_place_arr = new Array();
		$('[name=place]+.tag_list li').each(function(){
			temp_this = $(this);
			if (temp_this.data("type") != "delete") {
				li_place_exist = true;
			}
			li_place_arr.push(temp_this.data("type") + "|" + temp_this.data("idx") + "|" + temp_this.data("val"));
		});

		var li_speaker_exist = false;
		var li_speaker_arr = new Array();
		$('[name=speaker]+.tag_list li').each(function(){
			temp_this = $(this);
			if (temp_this.data("type") != "delete") {
				li_speaker_exist = true;
			}
			li_speaker_arr.push(temp_this.data("type") + "|" + temp_this.data("idx") + "|" + temp_this.data("val"));
		});

		var post_data = {
			flag : "modify_lecture",
			idx : "<?=$idx?>",
			title_en : $("[name=title_en]").val(),
			theme_en : $("[name=theme_en]").val(),
			category : $("[name=category] option:selected").val(),
			start : $("[name=start]").val(),
			end : $("[name=end]").val(),
			li_place_arr : li_place_arr.join('^&'),
			li_speaker_arr : li_speaker_arr.join('^&')
		};

		if (!post_data.title_en) {
			alert('Agenda Title(영문)을 입력해주세요.');
		/*} else if (!post_data.theme_en) {
			alert('Theme(영문)을 입력해주세요.');*/
		} else if (!post_data.category) {
			alert('Category를 선택해주세요.');
		} else if (!post_data.start || !post_data.end) {
			alert('강의일시를 모두 입력해주세요.');
		} else if (!li_place_exist) {
			alert('Place를 1개 이상 선택해주세요.');
		} else if (!li_speaker_exist) {
			alert('Speaker를 1개 이상 선택해주세요.');
		} else if (confirm('저장하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : post_data,
				dataType : "JSON",
				success : function(res) {
					alert(res.msg);
					if(res.code == 200) {
						if (!post_data.idx) {
							location.replace("/main/admin/manage_lecture_detail.php?idx="+res.idx);
						} else {
							location.reload();
						}
					}
				}
			});
		}
	});

	// 삭제
	$('.delete_btn').click(function(){
		if (confirm('삭제하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "remove_lecture",
					idx : "<?=$idx?>"
				},
				dataType : "JSON",
				success : function(res) {
					alert(res.msg);
					if(res.code == 200) {
						location.replace('/main/admin/manage_lecture.php');
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>