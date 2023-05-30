// in_iframe 변수가 실시간으로 계속 바뀌기 때문에 공통 변수를 함수화함
function get_is_sub_show(){
	//var in_iframe = (window.parent.document.querySelector('#sub_iframe').style.display == 'block');// (self !== top);	// iframe 여부
	var doc_sub_iframe = window.parent.document.querySelector('#sub_iframe');
	var result;
	if (doc_sub_iframe == null) {
		result = false;
	} else {
		result = (doc_sub_iframe.style.display == 'block');
	}
	return result;
}

// entrance 시 팝업
$(document).on('click', ".move_open", function(){
	/*var now = new Date();

	var srt = $(this).data('start');
	srt = typeof(srt) == "date" ? srt : new Date(srt.toString().replace(/-/g, "/"));

	var end = $(this).data('end');
	console.log('end', end);
	end = typeof(end) == "date" ? end : new Date(end.toString().replace(/-/g, "/"));

	if (now >= srt && now <= end) {
		index = $(this).parents('li.show_detail').data('index'); // lecture 페이지에서만 씀
		if (get_is_sub_show()) {
			$(".move_pop").addClass("on");
		} else {
			open_grade_pop();
		}
	} else {
		alert('The live lecture is not available.');
	}*/
	index = $(this).parents('li.show_detail').data('index'); // lecture 페이지에서만 씀
	if (get_is_sub_show()) {
		$(".move_pop").addClass("on");
	} else {
		open_grade_pop();
	}
});

// entrance 팝업 - enter
$('.move_pop .enter').click(function(){
	open_grade_pop();
});

//팝업닫기
$('.grade_pop .enter').click(function(){
	if($("#stop_see_grade").is(":checked")){
		var toDate = new Date();
		toDate.setHours(toDate.getHours() + ((23-toDate.getHours()) + 9));
		toDate.setMinutes(toDate.getMinutes() + (60-toDate.getMinutes()));
		toDate.setSeconds(0);
		//console.log(toDate);
		document.cookie = "live_grade_pop=" + escape("done") + "; path=/; expires=" + toDate.toGMTString() + ";";
	}
	go_detail();
});

// 평점안내 팝업 쿠키체크
function open_grade_pop(){
	var grade_pop_value = document.cookie.match('(^|;) ?live_grade_pop=([^;]*)(;|$)');
	grade_pop_value = grade_pop_value ? grade_pop_value[2] : null;

	if(grade_pop_value == null) {
		//쿠키가 존재하지 않으면 팝업창을 연다.
		$(".move_pop").removeClass("on");
		$(".grade_pop").addClass("on");
	} else {
		//아니라면 바로 링크 이동함
		go_detail();
	}
}

// 영상 상세 링크 공통
function go_detail(){
	// entrance
	var is_sub_show	= get_is_sub_show();
	var lecture_idx	= get_detail_lecture_idx();
	var place_idx	= get_detail_place_idx();

	var member_idx = document.cookie.match('(^|;) ?member_idx=([^;]*)(;|$)');
	member_idx = member_idx ? member_idx[2] : null;
	if(member_idx == null) {
		alert("Need to login.");
		window.parent.location.replace('/main/login.php?from=live');
	} else {
		$.ajax({
			url : "../ajax/client/ajax_lecture.php",
			type : "POST",
			data : {
				flag : 'entrance',
				member_idx : member_idx,
				lecture_idx : lecture_idx,
				place_idx : place_idx,
				auto_exit : is_sub_show ? "Y" : "N"
			},
			dataType : "JSON",
			success : function(res) {
				if(res.code == 200) {
					var detail_url = ("./video.php?idx=" + place_idx + "&mb=" + member_idx);

					if (is_sub_show) {
						var _window = window;
						var _window_parent = _window.parent;

						$('.popup.on').removeClass('on');
						_window_parent.frames[0].location.href = './lecture.php';
						_window_parent.document.querySelector('#sub_iframe').style.display = 'none';

						_window_parent.document.querySelector('#common_small_player').style.display = 'none';

						_window_parent.frames[1].location.href = detail_url;
						_window_parent.document.querySelector('#main_iframe').style.display = 'block';
					} else {
						location.href = detail_url;
					}
				} else {
					alert(res.msg);
				}
			}
		});
	}
}