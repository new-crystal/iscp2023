<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>
<?php

    if($admin_permission["auth_board_faq"] == 0){
        echo '<script>alert("권한이 없습니다.")</script>';
        echo '<script>history.back();</script>';
    }

	$sql = "
			SELECT
				idx, title_en, title_ko
			FROM board_category
			WHERE is_deleted = 'N'
			ORDER BY register_date DESC
		   ";
		
	$list = get_data($sql);
?>
	<section class="list">
		<div class="container">
			<div class="title clearfix2">
				<h1 class="font_title">FAQ</h1>
                <?php
                if($admin_permission["auth_board_faq"] != 1){
                ?>
				    <button type="button" class="btn add_category">카테고리 등록</button>
                <?php
                }
                ?>
			</div>
			<div class="contwrap has_fixed_title">
				<p class="total_num">총 <?=number_format(count($list))?>개</p>
				<table id="datatable" class="list_table">
					<thead>
						<tr class="tr_center">
							<th>FAQ카테고리(영문)</th>
							<th>FAQ카테고리(국문)</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($list as $l){?>
							<tr class="tr_center">
								<td><a href="./board_list.php?t=2&c=<?=$l["idx"]?>" class="ellipsis"><?=$l["title_en"]?></a></td>
								<td><a href="./board_list.php?t=2&c=<?=$l["idx"]?>" class="ellipsis"><?=$l["title_ko"]?></a></td>
								<td>	
                                <?php
                                    if($admin_permission["auth_board_faq"] != 1){
                                    ?>
                                        <button type="button" class="btn add_category modify_btn" data-id="<?=$l["idx"]?>">수정</button>
                                        <button type="button" class="border_btn remove_btn" data-id="<?=$l["idx"]?>">삭제</button>
                                    <?php
                                    }
                                    ?>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<div class="pop_wrap faq_category">
		<div class="pop_dim"></div>
		<div class="pop_contents">
			<div class="clearfix2">
				<h1 class="pop_title">카테고리 등록</h1>
				<button class="pop_close"><i class="la la-close"></i></button>
			</div>
			<input type="hidden" name="category_id" value=""/>
			<table>
				<tr class="tr_center">
					<th>FAQ 카테고리 이름(영문) *</th>
					<th>FAQ 카테고리 이름(국문) *</th>
				</tr>
				<tr>
					<td>
						<input type="text" name="title_en" placeholder="카테고리 이름을 입력해주세요.">
					</td>
					<td>
						<input type="text" name="title_ko" placeholder="카테고리 이름을 입력해주세요.">
					</td>
				</tr>
			</table>
			<div class="btn_wrap">
				<button type="button" class="border_btn pop_close">닫기</button>
				<button type="button" class="btn save_btn">저장</button>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			// 카테고리 등록버튼 Event
			$('.add_category').on('click',function(){
				$("input[name=category_id]").val("");
				$("input[name=title_en]").val("");
				$("input[name=title_ko]").val("");
				$(".faq_category").show();
			});

			// 수정버튼 Event
			$(".modify_btn").on("click",function(){
				var id	= $(this).data("id");
					id  = transferValue(id);

				var tEn = $(this).parents("tr").children("td").eq(0).text();
					tEn =  transferValue(tEn);

				var tKo = $(this).parents("tr").children("td").eq(1).text();
					tKo =  transferValue(tKo);

				if(id == ""){
					alert("유효하지 않은 카테고리 정보 입니다.");
					return false;
				}

				$("input[name=category_id]").val(id);
				$("input[name=title_en]").val(tEn);
				$("input[name=title_ko]").val(tKo);
				$(".faq_category").show();
			});

			// 저장버튼 Event
			$(".save_btn").on("click",function(){
				var id = transferValue($("input[name=category_id]").val());
				var tEn = transferValue($("input[name=title_en]").val());
				var tKo = transferValue($("input[name=title_ko]").val());

				if(tEn == ""){
					alert("영문 이름을 작성해주세요");
					return false;
				}

				if(tKo == ""){
					alert("국문 이름을 작성해주세요");
					return false;
				}

				$.ajax({
					url:"../ajax/admin/ajax_board.php",
					type:"POST",
					data:{
						flag : "category_save",
						c_id : id,
						title_en : tEn,
						title_ko : tKo
					},
					dataType:"JSON",
					success:function(data){
						if(data.code == 200){
							alert("변경사항이 저장되었습니다.");
							window.location.reload();
						}else if(data.code == 400){
							alert(data.msg);
						}else if(data.code == 401){
							alert("로그인이 필요합니다");
							window.location.replace("./");
						}else{
							alert("요청이 거절되었습니다. 관리자에게 문의해주세요.");
						}
					},
					error:function(request,status,error){
						console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
						alert("요청이 거절되었습니다. 관리자에게 문의해주세요.");
					},
					complete:function(){
						
					}
				})
			});

			// 삭제버튼 Event
			$(".remove_btn").on("click",function(){
				var c_id = transferValue($(this).data("id"));

				if(c_id == ""){
					alert("유효하지 않은 카테고리 정보입니다.");
					return false;
				}
				
				if(!confirm("해당 카테고리 안의 내용이 모두 지워집니다.\n작성하신 내용을 삭제하시겠습니까?")){
					return false;
				}

				$.ajax({
					url:"../ajax/admin/ajax_board.php",
					type:"POST",
					data:{
						flag:"remove_category",
						c_id: c_id
					},
					dataType:"JSON",
					success:function(data){
						if(data.code == 200){
							alert("삭제가 되었습니다.");
							window.location.replace("./board_category_list.php");
						}else if(data.code == 400){
							alert(data.msg);
						}else if(data.code == 401){
							alert("로그인이 필요합니다");
							window.location.replace("./");
						}else{
							alert("삭제 요청이 거절되었습니다. 관리자에게 문의해주세요.");
						}
					},
					error:function(){
						alert("삭제 요청이 거절되었습니다. 관리자에게 문의해주세요.");
					},
					complete:function(){
						// 로딩창 닫기
					}
				});

			});

		});

		function transferValue(v){
			return (v && v != "" && typeof(v) != "undefined") ? v : "";
		}
		
	</script>
<?php include_once('./include/footer.php');?>