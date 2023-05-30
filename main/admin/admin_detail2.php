<?php
	include_once('./include/head.php');
	include_once('./include/header.php');

	$idx = $_GET["idx"] ?? 0;

	if($admin_permission["auth_account_admin"] == 0){
		echo '<script>alert("권한이 없습니다.");history.back();</script>';
	}

	$admin_member_query = "SELECT
							email,
							`name`,
							auth_account_member,
							auth_account_admin,
							auth_apply_poster,
							auth_apply_lecture,
							auth_apply_registration,
							auth_apply_sponsorship,
							auth_page_event,
							auth_page_main,
							auth_page_general,
							auth_page_poster,
							auth_page_lecture,
							auth_page_registration,
							auth_page_sponsorship,
							auth_live_popup,
							auth_live_lecture,
							auth_live_lecture_qna,
							auth_live_abstract,
							auth_live_conference,
							auth_live_event,
							auth_board_news,
							auth_board_notice,
							auth_board_faq
						FROM admin
						WHERE idx = {$idx}";
	$res = sql_fetch($admin_member_query);

	$auth_arr = array(
		array("title"=>"회원 관리 - 일반회원관리",							"col"=>"auth_account_member",		"class"=> "account_member"),
		array("title"=>"회원 관리 - 관리자 회원관리",						"col"=>"auth_account_admin",		"class"=> "account_admin"),
		array("title"=>"신청서 관리 - Poster Abstract Submission",		"col"=>"auth_apply_poster",			"class"=> "apply_poster"),
		array("title"=>"신청서 관리 - Lecture Note Submission",			"col"=>"auth_apply_lecture",		"class"=> "apply_lecture"),
		array("title"=>"신청서 관리 - Registration",					"col"=>"auth_apply_registration",	"class"=> "apply_registration"),
		array("title"=>"신청서 관리 - Sponsorship & Exhibition",		"col"=>"auth_apply_sponsorship",	"class"=> "apply_sponsorship"),
		array("title"=>"페이지 관리 - 행사정보 관리",						"col"=>"auth_page_event",			"class"=> "page_event"),
		array("title"=>"페이지 관리 - 메인페이지 관리",						"col"=>"auth_page_main",			"class"=> "page_main"),
		array("title"=>"페이지 관리 - General Information 관리",			"col"=>"auth_page_general",			"class"=> "page_general"),
		array("title"=>"페이지 관리 - Poster Abstract Submission 관리",	"col"=>"auth_page_poster",			"class"=> "page_poster"),
		array("title"=>"페이지 관리 - Lecture Note Submission 관리",		"col"=>"auth_page_lecture",			"class"=> "page_lecture"),
		array("title"=>"페이지 관리 - Registration 관리",				"col"=>"auth_page_registration",	"class"=> "page_registration"),
		array("title"=>"페이지 관리 - Sponsorship & Exhibition 관리",	"col"=>"auth_page_sponsorship",		"class"=> "page_sponsorship"),
		array("title"=>"라이브플랫폼 관리 - 팝업 관리",						"col"=>"auth_live_popup",			"class"=> "live_popup"),
		array("title"=>"라이브플랫폼 관리 - Lecture 관리",					"col"=>"auth_live_lecture",			"class"=> "live_lecture"),
		array("title"=>"라이브플랫폼 관리 - Lecture Q&A 관리",				"col"=>"auth_live_lecture_qna",		"class"=> "live_lecture_qna"),
		array("title"=>"라이브플랫폼 관리 - Abstract 관리",				"col"=>"auth_live_abstract",		"class"=> "live_abstract"),
		array("title"=>"라이브플랫폼 관리 - Conference Program Book 관리",	"col"=>"auth_live_conference",		"class"=> "live_conference"),
		array("title"=>"라이브플랫폼 관리 - 이벤트 관리",					"col"=>"auth_live_event",			"class"=> "live_event"),
		//array("title"=>"", "col"=>"", "class"=> ""),
		array("title"=>"게시판 관리 - News",							"col"=>"auth_board_news",			"class"=> "board_news"),
		array("title"=>"게시판 관리 - Notice",							"col"=>"auth_board_notice",			"class"=> "board_notice"),
		array("title"=>"게시판 관리 - FAQ",								"col"=>"auth_board_faq",			"class"=> "board_faq")
	);
?>
	<section class="detail">
		<div class="container">
			<div class="title">
				<h1 class="font_title">관리자회원</h1>
			</div>
			<div class="contwrap has_fixed_title">
				<div class="clearfix2">
					<div class="tab_box">
						<ul class="tab_wrap clearfix">
							<li><a href="./admin_detail.php?idx=<?=$idx?>">기본 정보</a></li>
							<li class="active"><a href="./admin_detail2.php?idx=<?=$idx?>">권한 정보</a></li>
						</ul>
					</div>
					<div class="info clearfix">
						<p><?=$res["email"]?> / <?=$res["name"]?></p>
						<a href="javascript:;">네임택 보기</a>
					</div>
				</div>
				<table>
					<tbody>
				<?php
					for($i=0;$i<count($auth_arr);$i++){
						$at = $auth_arr[$i];
						$new_tr_flag = ($i%2 === 0);
						$auth_val = $res[($at['col'])];

						if ($new_tr_flag) {
				?>
						<tr>
				<?php
						}
				?>
							<th><?=$at['title']?></th>
							<td class="radio_wrap" colspan="<?=(($i==count($auth_arr)-1) && $new_tr_flag) ? "3" : ""?>">
								<input type="checkbox" id="checkbox1_<?=$at['class']?>" class="<?=$at['class']?> read pm_o" value="1" <?php if($auth_val >= 1){echo "checked";}?>>
								<label for="checkbox1_<?=$at['class']?>">읽기</label>
								<input type="checkbox" id="checkbox2_<?=$at['class']?>" class="<?=$at['class']?> write pm_o" value="2" <?php if($auth_val >= 2){echo "checked";}?>>
								<label for="checkbox2_<?=$at['class']?>">쓰기</label>
								<input type="checkbox" id="checkbox3_<?=$at['class']?>" class="<?=$at['class']?> pm_x" value="0" <?php if($auth_val == 0){echo "checked";}?>>
								<label for="checkbox3_<?=$at['class']?>">권한없음</label>
							</td>
				<?php
						if (!$new_tr_flag || (($i==count($auth_arr)-1) && $new_tr_flag)) {
				?>
						</tr>
				<?php
						}
					}
				?>
					</tbody>
				</table>
				<div class="btn_wrap">
					<button type="button" class="border_btn" onclick="location.href='./admin_list.php'">목록</button>
					<?php
						if($admin_permission["auth_account_admin"] >= 2){
							echo '<button type="button" class="btn save_btn">저장</button>';
						}
					?>
				</div>
			</div>
		</div>
	</section>
	<script>
		// 권한 값 반환 함수
		function get_auth(class_name){
			var res;
			var chks = $("input[type=checkbox]."+class_name);
			if(chks.eq(0).is(":checked") && chks.eq(1).is(":checked")){
				res = 3;
			}else{
				res = $("input[type=checkbox]."+class_name+":checked").val();
			}
			return res;
		}

		// 저장
		$(".save_btn").on("click", function(){
			if (confirm("저장하시겠습니까?")) {
				var data = new FormData();
				var idx = "<?=$idx?>";

				data.append("flag", "permission");
				data.append("idx", idx);
				data.append("account_member",		get_auth('account_member'));
				data.append("account_admin",		get_auth('account_admin'));
				data.append("apply_poster",			get_auth('apply_poster'));
				data.append("apply_lecture",		get_auth('apply_lecture'));
				data.append("apply_registration",	get_auth('apply_registration'));
				data.append("apply_sponsorship",	get_auth('apply_sponsorship'));
				data.append("page_event",			get_auth('page_event'));
				data.append("page_main",			get_auth('page_main'));
				data.append("page_general",			get_auth('page_general'));
				data.append("page_poster",			get_auth('page_poster'));
				data.append("page_lecture",			get_auth('page_lecture'));
				data.append("page_registration",	get_auth('page_registration'));
				data.append("page_sponsorship",		get_auth('page_sponsorship'));
				data.append("live_popup",			get_auth('live_popup'));
				data.append("live_lecture",			get_auth('live_lecture'));
				data.append("live_lecture_qna",		get_auth('live_lecture_qna'));
				data.append("live_abstract",		get_auth('live_abstract'));
				data.append("live_conference",		get_auth('live_conference'));
				data.append("live_event",			get_auth('live_event'));
				//data.append("ebooth",					get_auth('live_ebooth'));
				data.append("board_news",			get_auth('board_news'));
				data.append("board_notice",			get_auth('board_notice'));
				data.append("board_faq",			get_auth('board_faq'));

				$.ajax({
					url:'../ajax/admin/ajax_admin.php',
					data:data,
					type:"POST",
					dataType:"JSON",
					contentType:false,
					processData:false,
					success:function(res){
						if(res.code == 1){
							alert("권한정보 저장 성공");
							location.reload();
						}else{
							alert("권한정보 저장에 실패하였습니다.");
						}
					}
				});
			}
		});

		/* 체크박스 예외처리 */
		$(".pm_x").change(function(){
			$(this).prevAll().prop('checked', false);
		});
		$(".pm_o").change(function(){
			var parent = $(this).parent();
			parent.find($('.pm_x')).prop('checked', false);
		});
		$(".write").change(function(){
			var parent = $(this).parent();
			if($(this).is(":checked") == true){
				parent.find($('.read')).prop("checked", true);
			}
		});
		$(".read").change(function(){
			var parent = $(this).parent();
			if(parent.find($('.write')).is(":checked") == true){
				$(this).prop("checked", true);
			}
		});
	</script>
<?php include_once('./include/footer.php');?>