
$(document).ready(function(){
	$('.nav .main_nav').click(function(){
		$(this).children('.sub_nav').slideToggle();
		$(this).toggleClass('on');
	});	

	$(".setting_open").click(function(){
		$(this).next(".setting_toggle").toggleClass("on");
	});

	//append_btn
	$('.append_btn').on('click',function(){
		var value = $('.append_input').val();
		var html = '';

		html = '<li>';
		html +=		value;
		html +=		'<button type="button" class="append_delete"><i class="la la-close"></i></button>';
		html +='</li>';

		$('.append_list').append(html);
		$('.append_input').val('');
	});
	//append_delete
	$(document).on('click','.append_delete', function(){
		$(this).parents('li').remove();
	});

	//popup
	$('.pop_close, .pop_dim').on('click',function(){
		$(this).parents('.pop_wrap').hide();
	});

	// 썸네일 이미지 업로드 시 파일이름 노출
	$(document).on('change', 'input[type=file]', function(event){
		var file = event.target.files[0];
		var fileReader = new FileReader();
		var verify_flag = true;

		if (verify_flag) {
			$(this).siblings('.file_name').val(file.name);
		} else {
			var agent = navigator.userAgent.toLowerCase();
			if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ){
				// ie 일때 input[type=file] init.
				$(this).replaceWith($(this).clone(true));
			} else {
				//other browser 일때 input[type=file] init.
				$(this).val("");
			}
			$(this).siblings('.file_name').val("");
		}

	});

	/*//태그 추가
	$(".tag_add").click(function(){
		var value = $(this).siblings("input").val();
		$(this).parent("div").siblings(".tag_list").append("<li>"+value+"<i></i></li>")
		$(this).siblings("input").val("")
		console.log(value)
	});
	//태그삭제
	$(".tag_list li i").click(function(){
		$(this).parent("li").remove();
	});*/

	/*// 등록 이미지 등록 미리보기
	function readInputFile(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#preview ul').append("<li><img src="+ e.target.result +"><i class='icon_delete'></i></li>");
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	 
	$(".file_costom").on('change', function(){
		readInputFile(this);
	});*/

	/* lectureList 상세페이지 이동 */
	/*$(".lec_listToDetail tbody td:nth-child(1), .lec_listToDetail tbody td:nth-child(2)").on("click", function(){
		window.location.href="./manage_lecture_detail.php";
	});*/
	
	/* lectureQAList 상세페이지 이동 */
	/*$(".qna_listToDetail tbody td:nth-child(1), .qna_listToDetail tbody td:nth-child(2)").on("click", function(){
		window.location.href="./manage_lectureQA_detail.php";
	});*/
	
	/* lectureList popup */
	/*$(".btn_category").click(function(){$(".pop_category").show();});
	$(".btn_place").click(function(){$(".pop_place").show();});
	$(".btn_speaker").click(function(){$(".pop_speaker").show();});*/

	/* 포토갤러리 > 상세 > 사진삭제 */
	/*$('#preview ul').on("click", ".icon_delete", function(){
		$(this).parent("li").remove();
	})*/

})