<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_live_lecture"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// lecture list
	$where = "";
	$add = "";

	// 제목
	if ($_GET['title'] != "") {
		$where .= " AND lec.agenda_title_en LIKE '%".$_GET['title']."%'";
		$add .= "&title=".$_GET['title'];
	}

	// 등록일 (시작일)
	if ($_GET["str"] && $_GET["str"] != "") {
		$where .= (($_GET["str"] <= 0) ? "" : " AND DATE(lec.register_date) >= '{$_GET['str']}'");
		$add .= "&str=".$_GET['str'];
	}
	// 등록일 (종료일)
	if ($_GET["end"] && $_GET["end"] != "") {
		$where .= " AND DATE(lec.register_date) < DATE_ADD('{$_GET['end']}', INTERVAL +1 day)";
		$add .= "&end=".$_GET['end'];
	}

	$sql_list =	"SELECT
					lec.idx,
					lec.agenda_title_en,
					lec.theme_en,
					lc.title_en AS category_title_en,
					lpu.title_en_text AS place_title_en,
					lsj.name_en_text AS speaker_name_en,
					CONCAT(DATE_FORMAT(lec.period_time_start, '%y-%m-%d %H:%i'), ' ~ ', DATE_FORMAT(lec.period_time_end, '%y-%m-%d %H:%i')) AS period_time_text,
					DATE_FORMAT(lec.register_date, '%y-%m-%d') AS register_date
				FROM lecture AS lec
				LEFT JOIN lecture_category AS lc
					ON lc.idx = lec.category_idx
				LEFT JOIN (
					SELECT
						lpu.lecture_idx,
						GROUP_CONCAT(lp.title_en ORDER BY lp.title_en) AS title_en_text
					FROM lecture_place_use AS lpu
					INNER JOIN lecture_place AS lp
						ON lp.idx = lpu.place_idx
					GROUP BY lpu.lecture_idx
				) AS lpu
					ON lpu.lecture_idx = lec.idx
				LEFT JOIN (
					SELECT
						lsj.lecture_idx,
						GROUP_CONCAT(ls.name_en ORDER BY lsj.idx) AS name_en_text
					FROM lecture_speaker_join AS lsj
					INNER JOIN lecture_speaker AS ls
						ON ls.idx = lsj.speaker_idx
					GROUP BY lsj.lecture_idx
				) AS lsj
					ON lsj.lecture_idx = lec.idx
				WHERE lec.is_deleted = 'N'
				".$where."
				ORDER BY lec.period_time_start";
	$list = get_data($sql_list);
	$total_count = count($list);
	//echo "<pre>{$sql_list}</pre>";

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

	$can_modify = ($admin_permission["auth_live_lecture"] > 1);
?>
<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">Lecture 관리</h1>
		</div>
		<!----- 검색조건박스 ----->
		<div class="contwrap centerT has_fixed_title">
			<form>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>제목</th>
							<td>
								<input type="text" name="title" value="<?=$_GET['title']?>">
							</td>
							<th>등록일</th>
							<td class="input_wrap">
								<input type="text" class="datepicker-here" data-date-format="yyyy-mm-dd" data-type="date" data-language="en" name="str">
								<span>~</span>
								<input type="text" class="datepicker-here" data-date-format="yyyy-mm-dd" data-type="date" data-language="en" name="end">
							</td>
						</tr>
					</tbody>
				</table>
				<button class="btn search_btn">검색</button>
			</form>
		</div>
		<!----- 컨텐츠 ----->
		<div class="contwrap" style="width: 100%;">
			<div class="clearfix">
				<div class="floatL">
					<button type="button" class="btn search_btn btn_category">Category 등록</button>
					<button type="button" class="btn search_btn btn_place">Place 등록</button>
					<button type="button" class="btn search_btn btn_speaker">Speaker 등록</button>
				</div>
				<?php
					if($can_modify){
				?>
				<div class="floatR">
					<button type="button" class="btn search_btn" onclick="location.href='./manage_lecture_detail.php'">Lecture 등록</button>
				</div>
				<?php
					}
				?>
			</div>
			<p class="total_num">총 <?=number_format($total_count)?>개</p>
			<table id="datatable" class="list_table lec_listToDetail">
				<colgroup>
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="*">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="tr_center">
						<th>Agenda Title(영문)</th>
						<th>Theme</th>
						<th>Category</th>
						<th>Place</th>
						<th>Chairperson</th>
						<th>Time(강의일시)</th>
						<th>등록일</th>
					</tr>
				</thead>
				<tbody class=""><!-- no1_td_left -->
					<?php
						if ($total_count > 0) {
							foreach($list as $lec){
								foreach($lec as $key=>$value){
									$lec[$key] = htmlspecialchars_decode($value);
								}
					?>
					<tr class="tr_center">
						<td><a href="./manage_lecture_detail.php?idx=<?=$lec['idx']?>"><?=$lec['agenda_title_en']?></a></td>
						<td><?=$lec['theme_en']?></td>
						<td><?=$lec['category_title_en']?></td>
						<td><?=$lec['place_title_en']?></td>
						<td><?=$lec['speaker_name_en']?></td>
						<td><?=$lec['period_time_text']?></td>
						<td><?=$lec['register_date']?></td>
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

<!-- category등록 팝업 -->
<div class="pop_wrap pop_category">
	<div class="pop_dim"></div>
	<div class="pop_contents">
		<!-- 팝업제목 -->
		<h1 class="pop_title clearfix">
			<span>Category 등록</span>
			<div class="floatR pop_close"><i></i></div>
		</h1>
		<!-- 팝업내용 -->
		<div class="pop_cont">
			<div class="contwrap">
				<?php
					if($can_modify){
				?>
				<!-- <form> -->
					<table>
						<colgroup>
							<col width="10%">
							<col width="40%">
						</colgroup>
						<tbody>
							<tr class="form_tr">
								<th>Category *</th>
								<td>
									<input type="text" placeholder="영문" name="title_en">
									<!--<input type="text" placeholder="국문">-->
									<button type="button" class="btn add">추가</button>
								</td>
							</tr>
						</tbody>
					</table>
				<!-- </form> -->
				<?php
					}
				?>
				<div class="list_scroll">
					<table id="" class="list_table">
						<colgroup>
							<col width="*">
							<?php
								if($can_modify){
							?>
							<col width="10%">
							<?php
								}
							?>
						</colgroup>
						<thead>
							<tr class="tr_center">
								<th>Category(영문)</th>
							<?php
								if($can_modify){
							?>
								<th>삭제</th>
							<?php
								}
							?>
							</tr>
						</thead>
						<tbody>
							<?php
								if (count($category_list) <= 0) {
							?>
							<tr class="tr_center">
								<td colspan="2">조회된 내역이 없습니다.</td>
							</tr>
							<?php
								} else {
									foreach($category_list as $ct){
										foreach($ct as $key=>$value){
											$ct[$key] = htmlspecialchars_decode($value);
										}
							?>
							<tr class="tr_center">
								<td><?=$ct['title_en']?></td>
							<?php
										if($can_modify){
							?>
								<td><button type="button" class="border_btn remove" data-idx="<?=$ct['idx']?>">삭제</button></td>
							<?php
										}
							?>
							</tr>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- 팝업닫기버튼 -->
		<div class="btn_wrap">
			<button type="button" class="border_btn pop_close">닫기</button>
		</div>
	</div>
</div>

<!-- place등록 팝업 -->
<div class="pop_wrap pop_place">
	<div class="pop_dim"></div>
	<div class="pop_contents">
		<!-- 팝업제목 -->
		<h1 class="pop_title clearfix">
			<span>Place 등록</span>
			<div class="floatR pop_close"><i></i></div>
		</h1>
		<!-- 팝업내용 -->
		<div class="pop_cont">
			<div class="contwrap">
				<?php
					if($can_modify){
				?>
				<!-- <form> -->
					<table>
						<colgroup>
							<col width="10%">
							<col width="40%">
						</colgroup>
						<tbody>
							<tr class="form_tr">
								<th>Place *</th>
								<td>
									<input type="text" placeholder="영문" name="title_en">
									<!--<input type="text" placeholder="국문">-->
									<button type="button" class="btn add">추가</button>
								</td>
							</tr>
						</tbody>
					</table>
				<!-- </form> -->
				<?php
					}
				?>
				<div class="list_scroll">
					<table id="" class="list_table">
						<thead>
							<tr class="tr_center">
								<th>Category(영문)</th>
								<th>스트리밍 주소</th>
								<?php
									if($can_modify){
								?>
								<th>삭제</th>
								<?php
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
								if (count($place_list) <= 0) {
							?>
							<tr class="tr_center">
								<td colspan="3">조회된 내역이 없습니다.</td>
							</tr>
							<?php
								} else {
									foreach($place_list as $pl){
										foreach($pl as $key=>$value){
											$pl[$key] = htmlspecialchars_decode($value);
										}
							?>
							<tr class="tr_center">
								<td><?=$pl['title_en']?></td>
								<td>
									<input type="text" placeholder="URL" name="url" class="input_url" value="<?=$pl['url']?>">
							<?php
										if($can_modify){
							?>
									<button type="button" class="border_btn modify" data-idx="<?=$pl['idx']?>">저장</button>
							<?php
										}
							?>
								</td>
							<?php
										if($can_modify){
							?>
								<td><button type="button" class="border_btn remove" data-idx="<?=$pl['idx']?>">삭제</button></td>
							<?php
										}
							?>
							</tr>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- 팝업닫기버튼 -->
		<div class="btn_wrap">
			<button type="button" class="border_btn pop_close">닫기</button>
		</div>
	</div>
</div>

<!-- speaker등록 팝업 -->
<div class="pop_wrap pop_speaker">
	<div class="pop_dim"></div>
	<div class="pop_contents">
		<!-- 팝업제목 -->
		<h1 class="pop_title clearfix">
			<span>Speaker 등록</span>
			<div class="floatR pop_close"><i></i></div>
		</h1>
		<!-- 팝업내용 -->
		<div class="pop_cont">
			<div class="contwrap">
				<?php
					if($can_modify){
				?>
				<!-- <form> -->
					<table>
						<colgroup>
							<col width="10%">
							<col width="32%">
							<col width="10%">
							<col width="32%">
							<col width="14%">
						</colgroup>
						<tbody>
							<tr class="form_tr">
								<th>Speaker이름 *</th>
								<td>
									<input type="text" placeholder="영문" name="name_en">
									<!-- <input type="text" placeholder="국문"> -->
								</td>
								<th>Speaker소속 *</th>
								<td>
									<input type="text" placeholder="영문" name="affiliation_en">
									<!-- <input type="text" placeholder="국문"> -->
								</td>
								<td rowspan="2" class="centerT">
									<button type="button" class="btn search_btn add">추가</button>
								</td>
							</tr>
							<tr>
								<th>이미지 *</th>
								<td colspan="3" class="file_up_wrap">
									<input type="file" id="file_speaker_profile" class="file_costom" accept="image/*">
									<input type="text" readonly class="file_name">
									<label for="file_speaker_profile">파일선택</label>
								</td>
							</tr>
						</tbody>
					</table>
				<!-- </form> -->
				<?php
					}
				?>
				<div class="list_scroll">
					<table id="" class="list_table">
						<thead>
							<tr class="tr_center">
								<th>Speaker 이름</th>
								<th>Speaker 소속</th>
								<th>이미지</th>
								<?php
									if($can_modify){
								?>
								<th>삭제</th>
								<?php
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
								if (count($speaker_list) <= 0) {
							?>
							<tr class="tr_center">
								<td colspan="4">조회된 내역이 없습니다.</td>
							</tr>
							<?php
								} else {
									foreach($speaker_list as $sp){
										foreach($sp as $key=>$value){
											$sp[$key] = htmlspecialchars_decode($value);
										}
							?>
							<tr class="tr_center">
								<td><?=$sp['name_en']?></td>
								<td><?=$sp['affiliation_en']?></td>
								<td><img src="<?=$sp['fi_profile_path']?>" alt="" onError="javascript:this.src='http://via.placeholder.com/150';" class="thumbnail"></td>
								<?php
									if($can_modify){
								?>
								<td><button type="button" class="border_btn remove" data-idx="<?=$sp['idx']?>">삭제</button></td>
								<?php
									}
								?>
							</tr>
							<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- 팝업닫기버튼 -->
		<div class="btn_wrap">
			<button type="button" class="border_btn pop_close">닫기</button>
		</div>
	</div>
</div>

<script>

	// ** DOCUMENT ** //
	$(document).ready(function() {
		// 자동완성 안됨
		$('input').attr('autocomplete', 'off');

		// datepicker 데이터 세팅
		var pt_start = "<?=$_GET['str']?>";
		if (pt_start) {
			$('[name=str]').datepicker().data('datepicker').selectDate(new Date(pt_start));
		}
		var pt_end = "<?=$_GET['end']?>";
		if (pt_end) {
			$('[name=end]').datepicker().data('datepicker').selectDate(new Date(pt_end));
		}
	});

	// popup open
	$(".btn_category").click(function(){$(".pop_category").show();});
	$(".btn_place").click(function(){$(".pop_place").show();});
	$(".btn_speaker").click(function(){$(".pop_speaker").show();});

	// 카테고리 - 추가
	$('.pop_category .add').click(function(){
		var title_en = $('.pop_category [name=title_en]').val();

		if (!title_en) {
			alert('카테고리명을 입력해주세요.');
		} else if (confirm('카테고리를 추가하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "add_category",
					title_en : title_en
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

	// 카테고리 - 삭제
	$('.pop_category .remove').click(function(){
		var idx = $(this).data('idx');

		if (!idx) {
			alert('삭제할 카테고리의 고유값이 유효하지 않습니다.\n관리자에게 문의해주세요.');
		} else if (confirm('카테고리를 삭제하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "remove_category",
					idx : idx
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

	// 장소 - 추가
	$('.pop_place .add').click(function(){
		var title_en = $('.pop_place [name=title_en]').val();

		if (!title_en) {
			alert('강의실명을 입력해주세요.');
		} else if (confirm('강의실을 추가하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "add_place",
					title_en : title_en
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

	// 장소 - 수정
	$('.pop_place .modify').click(function(){
		var idx = $(this).data('idx');
		var url = $(this).parents('tr').children('td').find('input.input_url').val();

		if (!idx) {
			alert('삭제할 강의실의 고유값이 유효하지 않습니다.\n관리자에게 문의해주세요.');
		} else if (confirm('강의실 영상 url을 수정하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "modify_place",
					idx : idx,
					url : url
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

	// 장소 - 삭제
	$('.pop_place .remove').click(function(){
		var idx = $(this).data('idx');

		if (!idx) {
			alert('삭제할 강의실의 고유값이 유효하지 않습니다.\n관리자에게 문의해주세요.');
		} else if (confirm('강의실을 삭제하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "remove_place",
					idx : idx
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

	// 파일 업로드 감지
	$("input[type=file]").on("change",function(e){
		var file = e.target.files[0]; // 단일 파일업로드만 고려된 개발

		var label = $(this).parent().find(".label");
		if(!file.type.match('image.*')){
			alert("썸네일은 이미지 파일만 가능합니다");
			return;
		}

		if(file && file != "" && typeof(file) != "undefined"){
			label.text(file.name);
		}
	});

	// 발표자 - 추가
	$('.pop_speaker .add').click(function(){
		var name_en = $('.pop_speaker [name=name_en]').val();
		var affiliation_en = $('.pop_speaker [name=affiliation_en]').val();

		if (!name_en) {
			alert('발표자 이름을 입력해주세요.');
		} else if (!affiliation_en) {
			alert('발표자 소속을 입력해주세요.');
		} else if (confirm('발표자를 추가하시겠습니까?')) {
			var form_data = new FormData();
			form_data.append("flag", "add_speaker");
			form_data.append("name_en", name_en);
			form_data.append("affiliation_en", affiliation_en);
			if (document.getElementById("file_speaker_profile").value) {
				form_data.append('file_speaker_profile',	$('#file_speaker_profile')[0].files[0]);
			}

			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : form_data,
				contentType : false,
				processData : false,
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

	// 발표자 - 삭제
	$('.pop_speaker .remove').click(function(){
		var idx = $(this).data('idx');

		if (!idx) {
			alert('삭제할 발표자의 고유값이 유효하지 않습니다.\n관리자에게 문의해주세요.');
		} else if (confirm('발표자를 삭제하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_lecture.php",
				type : "POST",
				data : {
					flag : "remove_speaker",
					idx : idx
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