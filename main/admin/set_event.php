<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	if($admin_permission["auth_page_event"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// 행사정보
	$sql_info =	"SELECT
					*
				FROM info_event AS ie";
	$info = sql_fetch($sql_info);

	// 가격정보
	$sql_price =	"SELECT
						*
					FROM info_event_price AS iep
					WHERE is_deleted = 'N'
					ORDER BY idx";
	$prices = get_data($sql_price);

	$datepicker_set = 'type="text" class="datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" data-type="date"';
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix">
				<h1 class="font_title">행사정보관리</h1>
			</div>
			<div class="contwrap centerT has_fixed_title">
				<form name="search_form">
					<table>
						<colgroup>
							<col width="10%">
							<col width="40%">
							<col width="10%">
							<col width="40%">
						</colgroup>
						<tbody>
							<tr>
								<th>행사제목</th>
								<td>
									<input type="text" placeholder="100자 이내" name="title" maxlength="100" value="<?=$info['title']?>">
								</td>
								<th>행사기간</th>
								<td class="input_wrap">
									<input <?=$datepicker_set?> name="period_event_start"> <span>~</span> <input <?=$datepicker_set?> name="period_event_end">
								</td>
							</tr>
							<tr>
								<th>행사 사전등록기간</th>
								<td class="input_wrap">
									<input <?=$datepicker_set?> name="period_event_pre_start"> <span>~</span> <input <?=$datepicker_set?> name="period_event_pre_end">
								</td>
								<th>라이브플랫폼 행사기간</th>
								<td class="input_wrap">
									<input <?=$datepicker_set?> name="period_live_start"> <span>~</span> <input <?=$datepicker_set?> name="period_live_end">
								</td>
							</tr>
							<tr>
								<th>Poster Abstract Submission 등록 기간</th>
								<td class="input_wrap">
									<input <?=$datepicker_set?> name="period_poster_start"> <span>~</span> <input <?=$datepicker_set?> name="period_poster_end">
								</td>
								<th>Lecture Note Submission 등록기간</th>
								<td class="input_wrap">
									<input <?=$datepicker_set?> name="period_lecture_start"> <span>~</span> <input <?=$datepicker_set?> name="period_lecture_end">
								</td>
							</tr>
							<tr>
								<th>Sponsorship & Exhibition 신청기간</th>
								<td class="input_wrap">
									<input <?=$datepicker_set?> name="period_sponsorship_start"> <span>~</span> <input <?=$datepicker_set?> name="period_sponsorship_end">
								</td>
								<td class="input_wrap" colspan="2"></td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="contwrap">
				<table class="list_table">
					<thead>
						<tr class="tr_center">
							<th>Member type</th>
							<th>Off-line 회원(USD)</th>
							<th>Off-line 비회원(USD)</th>
							<th>On-line 회원(USD)</th>
							<th>On-line 비회원(USD)</th>
							<th>Off-line 회원(KRW)</th>
							<th>Off-line 비회원(KRW)</th>
							<th>On-line 회원(KRW)</th>
							<th>On-line 비회원(KRW)</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($prices as $pr){
						?>
						<tr class="save_price" data-type="" data-idx="<?=$pr['idx']?>">
							<td><input type="text" value="<?=$pr['type_en']?>" readonly></td>
							<td><input type="text" value="$<?=number_format($pr['off_member_usd'])?>" class="rightT" readonly></td>
							<td><input type="text" value="$<?=number_format($pr['off_guest_usd'])?>" class="rightT" readonly></td>
							<td><input type="text" value="$<?=number_format($pr['on_member_usd'])?>" class="rightT" readonly></td>
							<td><input type="text" value="$<?=number_format($pr['on_guest_usd'])?>" class="rightT" readonly></td>
							<td><input type="text" value="\<?=number_format($pr['off_member_krw'])?>" class="rightT" readonly></td>
							<td><input type="text" value="\<?=number_format($pr['off_guest_krw'])?>" class="rightT" readonly></td>
							<td><input type="text" value="\<?=number_format($pr['on_member_krw'])?>" class="rightT" readonly></td>
							<td><input type="text" value="\<?=number_format($pr['on_guest_krw'])?>" class="rightT" readonly></td>
							<td class="centerT"><button type="button" class="border_btn del_price">삭제</button></td>
						</tr>
						<?php
							}
						?>
						<tr class="insert">
							<td><input type="text" placeholder="카테고리" name="type_en"></td>
							<td><input type="text" placeholder="USD" class="rightT numformat" name="off_member_usd"></td>
							<td><input type="text" placeholder="USD" class="rightT numformat" name="off_guest_usd"></td>
							<td><input type="text" placeholder="USD" class="rightT numformat" name="on_member_usd"></td>
							<td><input type="text" placeholder="USD" class="rightT numformat" name="on_guest_usd"></td>
							<td><input type="text" placeholder="KRW" class="rightT numformat" name="off_member_krw"></td>
							<td><input type="text" placeholder="KRW" class="rightT numformat" name="off_guest_krw"></td>
							<td><input type="text" placeholder="KRW" class="rightT numformat" name="on_member_krw"></td>
							<td><input type="text" placeholder="KRW" class="rightT numformat" name="on_guest_krw"></td>
							<td class="centerT"><button type="button" class="border_btn ins_price">추가</button></td>
						</tr>
					</tbody>
				</table>
				<?php
					if ($admin_permission["auth_page_general"] >= 2) {
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
<script src="./js/common.js"></script>
<script>
	// ** DOCUMENT ** //
	$(document).ready(function() {
		// 자동완성 안됨
		$('input').attr('autocomplete', 'off');

		var date_text = "";

		// datepicker 데이터 세팅
		<?php
			$names_arr =	[
								'period_event_start', 'period_event_end', 
								'period_event_pre_start', 'period_event_pre_end', 
								'period_live_start', 'period_live_end', 
								'period_poster_start', 'period_poster_end', 
								'period_lecture_start', 'period_lecture_end', 
								'period_sponsorship_start', 'period_sponsorship_end'
							];
			foreach($names_arr as $name){
				set_datepicker($name, $info);
			}
		?>
	});

	// 가격 삭제
	$(document).on('click', '.del_price', function(){
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

	// 가격 추가
	$('.ins_price').click(function(){
		var input_data = {
			type			:	$('[name=type_en]').val(),
			off_member_usd	:	$('[name=off_member_usd]').val(),
			off_guest_usd	:	$('[name=off_guest_usd]').val(),
			on_member_usd	:	$('[name=on_member_usd]').val(),
			on_guest_usd	:	$('[name=on_guest_usd]').val(),
			off_member_krw	:	$('[name=off_member_krw]').val(),
			off_guest_krw	:	$('[name=off_guest_krw]').val(),
			on_member_krw	:	$('[name=on_member_krw]').val(),
			on_guest_krw	:	$('[name=on_guest_krw]').val(),
		};

		if (!input_data.type) {
			alert('Member type을 입력해주세요.');
		} else if (!input_data.off_member_usd || Number(input_data.off_member_usd) < 0) {
			alert('Off-line 회원(USD) 가격을 입력해주세요.');
		} else if (!input_data.off_guest_usd || Number(input_data.off_guest_usd) < 0) {
			alert('Off-line 비회원(USD) 가격을 입력해주세요.');
		} else if (!input_data.on_member_usd || Number(input_data.on_member_usd) < 0) {
			alert('On-line 회원(USD) 가격을 입력해주세요.');
		} else if (!input_data.on_guest_usd || Number(input_data.on_guest_usd) < 0) {
			alert('On-line 비회원(USD) 가격을 입력해주세요.');
		} else if (!input_data.off_member_krw || Number(input_data.off_member_krw) < 0) {
			alert('Off-line 회원(KRW) 가격을 입력해주세요.');
		} else if (!input_data.off_guest_krw || Number(input_data.off_guest_krw) < 0) {
			alert('Off-line 비회원(KRW) 가격을 입력해주세요.');
		} else if (!input_data.on_member_krw || Number(input_data.on_member_krw) < 0) {
			alert('On-line 회원(KRW) 가격을 입력해주세요.');
		} else if (!input_data.on_guest_krw || Number(input_data.on_guest_krw) < 0) {
			alert('On-line 비회원(KRW) 가격을 입력해주세요.');
		} else {
			var inner = '';
			inner +=	'<tr class="save_price" data-type="insert" data-idx="">';
			inner +=		'<td><input type="text" value="' + input_data.type + '" readonly></td>';
			inner +=		'<td><input type="text" value="$' + input_data.off_member_usd + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="$' + input_data.off_guest_usd + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="$' + input_data.on_member_usd + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="$' + input_data.on_guest_usd + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="\\' + input_data.off_member_krw + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="\\' + input_data.off_guest_krw + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="\\' + input_data.on_member_krw + '" class="rightT" readonly></td>';
			inner +=		'<td><input type="text" value="\\' + input_data.on_guest_krw + '" class="rightT" readonly></td>';
			inner +=		'<td class="centerT"><button type="button" class="border_btn del_price">삭제</button></td>';
			inner +=	'</tr>';

			$('tr.insert').before(inner);
			$('tr.insert input').val('');
			$('tr.insert input').eq(0).focus();
		}
	});

	// numberformat
	$('tr.insert input.numformat').change(function(){
		var _this = $(this);
		var val = _this.val().format();
		_this.val(val);
	});

	// 저장
	$('.save_btn').click(function(){
		var verify_flags = {
			flag						: 'save',
			title						: $('input[name=title]').val(),
			period_event_start			: $('input[name=period_event_start]').val(),
			period_event_end			: $('input[name=period_event_end]').val(),
			period_event_pre_start		: $('input[name=period_event_pre_start]').val(),
			period_event_pre_end		: $('input[name=period_event_pre_end]').val(),
			period_live_start			: $('input[name=period_live_start]').val(),
			period_live_end				: $('input[name=period_live_end]').val(),
			period_poster_start			: $('input[name=period_poster_start]').val(),
			period_poster_end			: $('input[name=period_poster_end]').val(),
			period_lecture_start		: $('input[name=period_lecture_start]').val(),
			period_lecture_end			: $('input[name=period_lecture_end]').val(),
			period_sponsorship_start	: $('input[name=period_sponsorship_start]').val(),
			period_sponsorship_end		: $('input[name=period_sponsorship_end]').val(),
			price_exist					: false,
			prices						: ''
		}

		var temp_this, temp_text;
		var price_arr = new Array();
		$('tr.save_price').each(function(){
			temp_this = $(this);
			if (temp_this.data("type") != "delete") {
				verify_flags.price_exist = true;
			}
			temp_text = temp_this.data("type") + "|" + temp_this.data("idx") + "|" + temp_this.children('td').children('input').eq(0).val();
			temp_this.children('td').children('input.rightT').each(function(index){
				temp_text += "|" + $(this).val().unformat();
			});
			price_arr.push(temp_text);
		});
		verify_flags.prices = price_arr.join('^&');

		if (!verify_flags.title) {
			alert('행사 제목을 입력해주세요.');

		} else if (!verify_flags.period_event_start || !verify_flags.period_event_end) {
			alert('행사기간을 모두 입력해주세요.');

		} else if (verify_flags.period_event_start > verify_flags.period_event_end) {
			alert('행사 종료일이 시작일보다 빠를 수 없습니다.');
			$('input[name=period_event_end]').val('').focus();

		} else if (!verify_flags.period_event_pre_start || !verify_flags.period_event_pre_end) {
			alert('행사 사전등록기간을 모두 입력해주세요.');

		} else if (verify_flags.period_event_pre_start > verify_flags.period_event_pre_end) {
			alert('행사 사전등록 종료일이 시작일보다 빠를 수 없습니다.');
			$('input[name=period_event_pre_end]').val('').focus();

		} else if (!verify_flags.period_live_start || !verify_flags.period_live_end) {
			alert('라이브 플랫폼 행사기간을 모두 입력해주세요.');

		} else if (verify_flags.period_live_start > verify_flags.period_live_end) {
			alert('라이브 플랫폼 행사 종료일이 시작일보다 빠를 수 없습니다.');
			$('input[name=period_live_end]').val('').focus();

		} else if (!verify_flags.period_poster_start || !verify_flags.period_poster_end) {
			alert('Poster Abstract Submission 등록기간을 모두 입력해주세요.');

		} else if (verify_flags.period_poster_start > verify_flags.period_poster_end) {
			alert('Poster Abstract Submission 등록 종료일이 시작일보다 빠를 수 없습니다.');
			$('input[name=period_poster_end]').val('').focus();

		} else if (!verify_flags.period_lecture_start || !verify_flags.period_lecture_end) {
			alert('Lecture Note Submission 등록기간을 모두 입력해주세요.');

		} else if (verify_flags.period_lecture_start > verify_flags.period_lecture_end) {
			alert('Lecture Note Submission 등록 종료일이 시작일보다 빠를 수 없습니다.');
			$('input[name=period_lecture_end]').val('').focus();

		} else if (!verify_flags.period_sponsorship_start || !verify_flags.period_sponsorship_end) {
			alert('Sponsorship & Exhibition 신청기간을 모두 입력해주세요.');

		} else if (verify_flags.period_sponsorship_start > verify_flags.period_sponsorship_end) {
			alert('Sponsorship & Exhibition 신청 종료일이 시작일보다 빠를 수 없습니다.');
			$('input[name=period_sponsorship_end]').val('').focus();

		} else if (!verify_flags.price_exist) {
			alert('가격 정보를 1개 이상 등록해주세요.');
			$('input[name=type_en]').focus();

		} else if (confirm('저장하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_info_event.php",
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
<?php
	include_once('./include/footer.php');

	function set_datepicker($name, $info_arr){
		echo '
			date_text = "'.$info_arr[$name].'";
			if (date_text) {
				setDate("'.$name.'", date_text);
			}
		';
	}
?>