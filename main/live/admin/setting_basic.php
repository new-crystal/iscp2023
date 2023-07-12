<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

	<section class="detail">
		<div class="container">
			<div class="title">
				<h1 class="font_title">행사정보 관리</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<h2 class="sub_title">행사 기본 정보</h2>
				<table>
					<colgroup>
						<col width="10%">
						<col width="40%">
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<tr>
							<th>행사 제목</th>
							<td><input type="text" value=""></td>
							<th>행사 기간</th>
							<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"></td>
						</tr>
						<tr>
							<th>행사 사전등록기간</th>
							<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"></td>
							<th>행사 등록기간</th>
							<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"></td>
						</tr>
						<tr>
							<th>라이브플랫폼 행사기간</th>
							<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"></td>
							<th>행사 장소(Venue)</th>
							<td><input type="text" value="" placeholder="100자 이내"></td>
						</tr>
						<tr>
							<th>Poster Abstract Submission 등록 기간</th>
							<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"></td>
							<th>Lecture Note Submission 등록기간</th>
							<td class="input_wrap"><input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here" data-language="en" data-date-format="yyyy/mm/dd"></td>
						</tr>
						<tr>
							<th>Poster Abstract Submission 등록 기간</th>
							<td class="input_wrap" colspan="3"><input type="text" class="datepicker-here default_width" data-language="en" data-date-format="yyyy/mm/dd"> <span>~</span> <input type="text" class="datepicker-here default_width" data-language="en" data-date-format="yyyy/mm/dd"></td>
						</tr>
					</tbody>
				</table>
				<h2 class="sub_title">행사 가격 정보</h2>
				<table>
					<tr class="tr_center">
						<th>Category</th>
						<th>Off-line 회원</th>
						<th>Off-line 비회원</th>
						<th>On-line 회원</th>
						<th>On-line 비회원</th>
						<th>관리</th>
					</tr>
					<tr>
						<td><input type="text" placeholder="카테고리"></td>
						<td><input type="text" placeholder="USD"></td>
						<td><input type="text" placeholder="USD"></td>
						<td><input type="text" placeholder="USD"></td>
						<td><input type="text" placeholder="USD"></td>
						<td class="centerT"><button type="button" class="btn">삭제</button></td>
					</tr>
					<tr>
						<td><input type="text" placeholder="카테고리"></td>
						<td><input type="text" placeholder="USD"></td>
						<td><input type="text" placeholder="USD"></td>
						<td><input type="text" placeholder="USD"></td>
						<td><input type="text" placeholder="USD"></td>
						<td class="centerT"><button type="button" class="btn">추가</button></td>
					</tr>
				</table>
				<div class="btn_wrap">
					<button type="button" class="btn save_btn">저장</button>
				</div>
			</div>
		</div>
	</section>
<?php include_once('./include/footer.php');?>