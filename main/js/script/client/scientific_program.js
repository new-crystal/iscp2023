$(document).ready(function(){

  var type = $("input[name=type]").val();
  var e = $("input[name=e]").val();
  var e_num = $("input[name=e_num]").val();
  var d_num = $("input[name=d_num]").val();
  var name = $("input[name=name]").val();
  //탭 활성화
  if (e_num == "") {
		$(".room_tab li:first-child").addClass("on");
  $(".room_tab").siblings(".tab_wrap").children(".tab_cont:first-child").addClass("on");
  }
  //작은탭
  $(".room_tab li").removeClass("on");
  $(".room_tab + .tab_wrap .tab_cont2").removeClass("on");
  $(".room_tab li:nth-child("+e_num+")").addClass("on");
  $(".room_tab + .tab_wrap .tab_cont2:nth-child("+e_num+")").addClass("on");

  window.onkeydown = function() {
	var kcode = event.keyCode;
	if(kcode == 116) {
		history.replaceState({}, null, location.pathname);
		window.scrollTo({top:0, left:0, behavior:"auto"});
	}
  }

  //스크롤 위치 & 액션
  $("table").each(function(){
	  var window_height = $(window).height();
	  var div_height = $(this).parent("div").height();
	  var top = window_height - div_height

	  console.log(top, "top")
	  if ($(window).width() > 1024) {
		if(name === $(this).attr("name")) {
			var this_top = $(this).offset().top;
			$("html, body").scrollTop(this_top - top/2);
			//$("html, body").animate({scrollTop: this_top - 150}, 1000);
			//console.log(this_top)
		}
	  }else {
		  if(name+"_mb" === $(this).attr("name")) {
			var this_top = $(this).offset().top;
			$("html, body").scrollTop(this_top - top/2);
			//$("html, body").animate({scrollTop: this_top - 150}, 1000);
			//console.log(this_top)
		}
	  }
	
  });
});