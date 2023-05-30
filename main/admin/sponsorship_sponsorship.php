<?php
	include_once('./include/head.php');
	include_once('./include/header.php');
	include_once('../plugin/editor/smarteditor2/editor.lib.php');

	if($admin_permission["auth_page_sponsorship"] == 0){
		echo	'<script>
					alert("권한이 없습니다.");
					history.back();
				</script>';
	}

	// key date는 생성이 없어서 별도로 생성해주어야함
	$package_count = sql_fetch("SELECT COUNT(idx) AS cnt FROM info_sponsorship_package")['cnt'];
	if ($package_count <= 0) {
		$sql_package_insert =	"INSERT INTO 
									info_sponsorship_package 
									(name_en, name_ko, price_usd, price_krw) 
								VALUES
									('', '', 0, 0),
									('', '', 0, 0),
									('', '', 0, 0),
									('', '', 0, 0),
									('', '', 0, 0),
									('', '', 0, 0)";
		sql_query($sql_package_insert);
	}

	$sql_package =	"SELECT
						idx, name_en, name_ko, price_usd, price_krw
					FROM info_sponsorship_package
					WHERE is_deleted = 'N'
					ORDER BY idx";
	$packages = get_data($sql_package);
?>
<style>
	.sponsorPackage input[type="text"] {width: 16.66%}
</style>
<section class="list">
	<div class="container">
		<!----- 타이틀 ----->
		<div class="title clearfix2">
			<h1 class="font_title">Sponsorship & Exhibition 관리</h1>
		</div>
		<div class="contwrap has_fixed_title">
			<!----- 탭 ----->
			<div class="tab_box">
				<ul class="tab_wrap clearfix">
					<li><a href="./sponsorship_overview.php">Overview</a></li>
					<li class="active"><a href="javascript:;">Sponsorship</a></li>
				</ul>
			</div>
			<!----- 컨텐츠 ----->
			<form>
				<table class="sponsorPackage">
					<colgroup>
						<col width="10%">
						<col width="40%">
					</colgroup>
					<tbody>
						<?php
							for ($i=0;$i<count($packages);$i++) {
								$pg = $packages[$i];
						?>
						<tr class="save_price" data-idx="<?=$pg['idx']?>">
							<th>Sponsorship Package <?=($i+1)?></th>
							<td>
								<input type="text" placeholder="Sponsorship Name(영문)" maxlength="50" value="<?=$pg['name_en']?>">
								<input type="text" placeholder="Sponsorship Name(국문)" maxlength="50" value="<?=$pg['name_ko']?>">
								<input type="text" placeholder="USD" class="rightT numformat" value="<?=$pg['price_usd'] == 0 ? "" : number_format($pg['price_usd'])?>">
								<input type="text" placeholder="KRW" class="rightT numformat" value="<?=$pg['price_krw'] == 0 ? "" : number_format($pg['price_krw'])?>">
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</form>
			<?php
				if($admin_permission["auth_page_sponsorship"] > 1){
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
	// numberformat
	$('input.numformat').change(function(){
		var _this = $(this);
		var val = _this.val().format();
		_this.val(val);
	});

	// 저장
	$('.save_btn').click(function(){
		var verify_flags = {
			flag		: 'save_sponsorship',
			price_exist	: true,
			prices		: ''
		}

		var temp_this, temp_text;
		var price_arr = new Array();
		$('tr.save_price').each(function(index){
			temp_this = $(this);

			temp_text = temp_this.data("idx");

			temp_this.children("td").children("input").each(function(children_index){
				if ((index == 0 || temp_this.children("td").children("input").eq(0) != "") && $(this).val() == "") {
					verify_flags.price_exist = false;
					return false;
				} else {
					temp_text += "|";
					temp_text += children_index <= 1 ? $(this).val() : $(this).val().unformat();
				}
			});

			price_arr.push(temp_text);
		});
		verify_flags.prices = price_arr.join('^&');

		if (!verify_flags.price_exist) {
			alert("Sponsorship Package의 입력 값을 확인해주세요.");

		} else if (confirm('저장하시겠습니까?')) {
			$.ajax({
				url : "../ajax/admin/ajax_info_sponsorship.php",
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