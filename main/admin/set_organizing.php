<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_general"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	$sql_list =	"SELECT
					idx,
					title_en, title_ko,
					name_en, name_ko, 
					affiliation_en, affiliation_ko,
					specialty_en, specialty_ko
				FROM info_general_commitee
				WHERE is_deleted = 'N'
				ORDER BY idx";
	$list = get_data($sql_list);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">General Information 관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<div class="tab_box">
					<ul class="tab_wrap clearfix">
						<li><a href="./set_general.php">Overview</a></li>
						<li class="active"><a href="javascript:;">Organizing Committee</a></li>
						<li><a href="./set_venue.php">Venue</a></li>
						<li><a href="./set_photo.php">Photo Gallery</a></li>
					</ul>
				</div>
				<form name="search_form">
					<table>
						<colgroup>
							<col width=""/>
							<col width=""/>
							<col width=""/>
							<col width=""/>
							<col width="100px"/>
						</colgroup>	
						<thead>
							<tr class="tr_center">
								<th>Title(영문)</th>
								<th>Name(영문)</th>
								<th>Affiliation(영문)</th>
								<th>Specialty(영문)</th>
								<th>관리</th>
							</tr>	
						</thead>
						<tbody name="en">
							<?php
								foreach($list as $cm){
									if ($cm['title_en'] !== "") {
							?>
							<tr class="save_en" data-type="" data-idx="<?=$cm['idx']?>">
								<td><input type="text" value="<?=$cm['title_en']?>" readonly></td>
								<td><input type="text" value="<?=$cm['name_en']?>" readonly></td>
								<td><input type="text" value="<?=$cm['affiliation_en']?>" readonly></td>
								<td><input type="text" value="<?=$cm['specialty_en']?>" readonly></td>
								<td class="centerT"><button type="button" class="border_btn del">삭제</button></td>
							</tr>
							<?php
									}
								}
							?>
							<tr class="insert">
								<td><input type="text" name="title"></td>
								<td><input type="text" name="name"></td>
								<td><input type="text" name="affiliation"></td>
								<td><input type="text" name="specialty"></td>
								<td class="centerT"><button type="button" class="border_btn ins" data-lang="en">추가</button></td>
							</tr>
						</tbody>
					</table>
					<table>
						<colgroup>
							<col width=""/>
							<col width=""/>
							<col width=""/>
							<col width=""/>
							<col width="100px"/>
						</colgroup>	
						<thead>
							<tr class="tr_center">
								<th>Title(국문)</th>
								<th>Name(국문)</th>
								<th>Affiliation(국문)</th>
								<th>Specialty(국문)</th>
								<th>관리</th>
							</tr>	
						</thead>
						<tbody name="ko">
							<?php
								foreach($list as $cm){
									if ($cm['title_ko'] !== "") {
							?>
							<tr class="save_ko" data-type="" data-idx="<?=$cm['idx']?>">
								<td><input type="text" value="<?=$cm['title_ko']?>" readonly></td>
								<td><input type="text" value="<?=$cm['name_ko']?>" readonly></td>
								<td><input type="text" value="<?=$cm['affiliation_ko']?>" readonly></td>
								<td><input type="text" value="<?=$cm['specialty_ko']?>" readonly></td>
								<td class="centerT"><button type="button" class="border_btn del">삭제</button></td>
							</tr>
							<?php
									}
								}
							?>
							<tr class="insert">
								<td><input type="text" name="title"></td>
								<td><input type="text" name="name"></td>
								<td><input type="text" name="affiliation"></td>
								<td><input type="text" name="specialty"></td>
								<td class="centerT"><button type="button" class="border_btn ins" data-lang="ko">추가</button></td>
							</tr>
						</tbody>
					</table>
					<?php
						if($admin_permission["auth_page_general"] > 1){
					?>
					<div class="btn_wrap leftT">
						<button type="button" class="btn save_btn">저장</button>
					</div>
					<?php
						}
					?>
				</form>
			</div>
		</div>
	</section>
<script src="./js/common.js"></script>
<script>
	// 삭제
	$(document).on('click', '.del', function(){
		if (confirm('삭제하시겠습니까?')) {
			var _this_parent_tr = $(this).parents('tr');
			var type = _this_parent_tr.data('type');
			if (type == "insert") {
				_this_parent_tr.remove();
			} else {
				_this_parent_tr.data('type', 'delete').hide();
			}
		}
	});

	// 추가
	$('.ins').click(function(){
		var lang = $(this).data('lang');
		var tbody = 'tbody[name='+ lang +']';

		var input_data = {
			title		:	$(tbody+ ' [name=title]').val(),
			name		:	$(tbody+ ' [name=name]').val(),
			affiliation	:	$(tbody+ ' [name=affiliation]').val(),
			specialty	:	$(tbody+ ' [name=specialty]').val()
		};

		if (!input_data.title) {
			alert('Title을 입력해주세요.');
			$(tbody+ ' [name=title]').focus();

		} else if (!input_data.name) {
			alert('Name을 입력해주세요.');
			$(tbody+ ' [name=name]').focus();

		} else if (!input_data.affiliation) {
			alert('Affiliation을 입력해주세요.');
			$(tbody+ ' [name=affiliation]').focus();

		} else if (!input_data.specialty) {
			alert('Specialty를 입력해주세요.');
			$(tbody+ ' [name=specialty]').focus();

		} else {
			var inner = '';
			inner +=	'<tr class="save_' + lang + '" data-type="insert" data-idx="">';
			inner +=		'<td><input type="text" value="' + input_data.title + '" readonly></td>';
			inner +=		'<td><input type="text" value="' + input_data.name + '" readonly></td>';
			inner +=		'<td><input type="text" value="' + input_data.affiliation + '" readonly></td>';
			inner +=		'<td><input type="text" value="' + input_data.specialty + '" readonly></td>';
			inner +=		'<td class="centerT"><button type="button" class="border_btn del">삭제</button></td>';
			inner +=	'</tr>';

			$(tbody+ ' tr.insert').before(inner);
			$(tbody+ ' tr.insert input').val('');
			$(tbody+ ' tr.insert input').eq(0).focus();
		}
	});

	// 저장
	$('.save_btn').click(function(){
		var verify_flags = {
			flag		: 'save_committee',
			en_exist	: false,
			ens			: '',
			ko_exist	: false,
			kos			: ''
		}

		var temp_this, temp_text;

		var en_arr = new Array();
		$('tr.save_en').each(function(){
			temp_this = $(this);
			if (temp_this.data("type") != "delete") {
				verify_flags.en_exist = true;
			}
			temp_text = temp_this.data("type") + "|" + temp_this.data("idx");
			temp_this.children('td').children('input').each(function(index){
				temp_text += "|" + $(this).val();
			});
			en_arr.push(temp_text);
		});
		verify_flags.ens = en_arr.join('^&');

		var ko_arr = new Array();
		$('tr.save_ko').each(function(){
			temp_this = $(this);
			if (temp_this.data("type") != "delete") {
				verify_flags.ko_exist = true;
			}
			temp_text = temp_this.data("type") + "|" + temp_this.data("idx");
			temp_this.children('td').children('input').each(function(index){
				temp_text += "|" + $(this).val();
			});
			ko_arr.push(temp_text);
		});
		verify_flags.kos = ko_arr.join('^&');

		if (!verify_flags.en_exist) {
			alert('영문 정보를 1개 이상 등록해주세요.');
			$('tbody[name=en] [name=title]').focus();

		} else if (!verify_flags.ko_exist) {
			alert('국문 정보를 1개 이상 등록해주세요.');
			$('tbody[name=ko] [name=title]').focus();

		} else if (confirm('저장하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_info_general.php",
				type : "POST",
				dataType : "JSON",
				data : verify_flags,
				success : function(res) {
					if(res.code == 200){
						alert("저장이 완료되었습니다.");
						location.reload();
					} else{
						alert(res.msg);
					}
				}
			});
		}
	});
</script>
<?php include_once('./include/footer.php');?>