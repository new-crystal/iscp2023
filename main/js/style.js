$(document).ready(function(){

	// 아이폰 사파리에서 더블 탭 막기
	var lastTouchEnd = 0;
	document.documentElement.addEventListener('touchend', function (event) {
		var now = (new Date()).getTime();
		if (now - lastTouchEnd <= 300) {
		  event.preventDefault();
		}
		lastTouchEnd = now;
	}, false);

	//아이폰에 사파리에서 핀치 줌 막기 / 안드로이드에서 더블탭, 핀치 줌 막기
	document.documentElement.addEventListener('gesturestart', function (e) {
		e.preventDefault();
	});

	//pc header hover action 
	$('.depth01 li').on('mouseenter',function(){
		var bar_width = $(this).width();
		var left_position = $(this).position().left;
		$('.depth01 li a img').attr('src','./img/icons/nav_arrow_black.png');
		$(this).children('img').attr('src','./img/icons/nav_arrow_on.png');
		$('.bar').css('width', bar_width);
		$('.bar').css('left', left_position);
		// $(this).parents('header').addClass('nav_show');
		// $(this).child('ul').addClass('nav_show');
		//  $(this).siblings('ul').addClass('ul_show');
		$('.nav_dim').show();
	});
	$('.nav_wrap').on('mouseleave',function(){
		// $(this).parents('header').removeClass('nav_show');
		$('.nav_dim').hide();
	});

	$("header .depth01 li ul").mouseover(function(){
		var left_spot = $(this).parent("li").position().left;
		$('.bar').css('left', left_spot);
		//console.log("bye");
	});

	//footer s_logo_list
	$('.s_logo_list').slick({
		dots: false,
		infinite: true,
		slidesToShow: 8,
		arrows : true,
        autoplay: true,
        autoplaySpeed: 2000,
		responsive: [
		{
		  breakpoint: 1100,
		  settings: {
			slidesToShow: 6
		  }
		},
		{
		  breakpoint: 780,
		 settings: {
			slidesToShow: 4
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 3
		  }
		}
	  ]
	});

	$('header .top, .nav_dim, header .g_h_top').on('mouseenter',function(){
		$('.nav_dim').hide();
		$('.depth01 li a img').attr('src','./img/icons/nav_arrow.png');
		$('header').removeClass('nav_show');
	});
	//pc header hover action end

	//popup
	$('.pop_bg, .pop_close').on('click',function(){
		$(this).parents('.popup').hide();
	});

	//input type radio
	$('.toggle_wrap input').on('change',function(){
		var target = $(this).parents(".toggle_wrap").find("input[type=radio]:checked");
		var choice = target.val();

		language_change("change", choice);
		
	});
	
	//toggle pointer click event
	$('.toggle__pointer').on('click',function(){
		var target = $(this).parents(".toggle_wrap").find("input[type=radio]:checked");
		var choice = target.val();

		language_change("click", choice);
	});

	//mobile nav
	$('.m_nav_btn').on('click',function(){
		$('.m_nav_wrap').addClass('opened');
	});
	$('.m_nav_li a').on('click',function(){
		if(!$(this).hasClass('show')){
			$('.m_sub_nav').slideUp();
			$('.m_nav_li a').removeClass('show');
			$(this).addClass('show');
			$(this).siblings('.m_sub_nav').slideDown();
		}else{
			$('.m_sub_nav').slideUp();
			$('.m_nav_li a').removeClass('show');
		}
	});
	$('.n_nav_close').on('click',function(){
		$('.m_nav_wrap').removeClass('opened');
	});
	
	listR();
	
	$(window).resize(function(){
		listR();
		//ICOLA CONTAINER TOP
		container_top();
	});

	//ICOLA SCRIPT START
	container_top()

	$("#datepicker, #mb_datepicker").datepicker({
    	language: 'en',
    });

	//TAB
	$(".tab_pager li").click(function(){
		if (!$(this).parent("ul").hasClass("location")){
			var i = $(this).index();
			$(".tab_pager li").removeClass("on");
			$(this).addClass("on");
			$(".tab_cont").removeClass("on");
			$(".tab_cont").eq(i).addClass("on");
		}
		
	});

	//
	$(window).resize(function(){
		if ($(window).width() < 450){
			//console.log($(".sub_background_box ul li").eq(2).offset().top)
			var first_top = $(".sub_background_box ul li:first-child").offset().top
			var last_top = $(".sub_background_box ul li:last-child").offset().top
			if (first_top < last_top) {
				$(".sub_background_box ul li:last-child").css("margin-left", 0)
			}else {
				$(".sub_background_box ul li:last-child").css("margin-left", "30px")
			}
			//console.log(this_offset_top)
		}
	});

	$(".datepicker_input").datepicker();

	if(!$("section").hasClass("icola_main")){
		btnTop();
		btnTopClick();
	}

	function btnTop(){
		var footer_height = $("footer.footer").outerHeight();

		$(window).scroll(function(){
			var scroll_top = $(window).scrollTop();
			if(scroll_top > 50){
				$(".fixed_top").fadeIn(300);
			}else{
				$(".fixed_top").fadeOut(300);
			}
			var footer_top = $("footer.footer").offset().top;
			var fixed_bottom = $(".fixed_top_clone").offset().top + $(".fixed_top_clone").outerHeight();
			if(32 >= footer_top - fixed_bottom){
				$(".fixed_top").addClass("on");
				if($("section").hasClass("top_btn_move")){ // 우측하단에 register btn이 있는 경우
					$(".fixed_top").css("bottom", footer_height+110+"px");
				}else{
					$(".fixed_top").css("bottom", footer_height+30+"px");
				}
			}else{
				$(".fixed_top").removeClass("on");
				if($("section").hasClass("top_btn_move")){
					$(".fixed_top").css("bottom", "110px");;
				}else{
					$(".fixed_top").css("bottom", "30px");
				}
			}
		});

	};

	/*$(".favorite_btn").click(function(){
		$(this).toggleClass("on");
	});*/

	function btnTopClick(){
		$(".fixed_top").click(function(){
			$("html, body").animate({scrollTop : 0}, 300)
		})
	};
	
	//$(".Eligibility_text").hide();
	//$(".Eligibility_accodien").click(function(){
	//	$(this).next(".Eligibility_text").stop().slideToggle();
	//});

	$(".eligibility_open").click(function(){
		$(this).children(".eligibility_pop").toggleClass("on");
	});

});

// air-datepicker korean
;(function ($) { $.fn.datepicker.language['ko'] = {
    days: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
    daysShort: ['일', '월', '화', '수', '목', '금', '토'],
    daysMin: ['일', '월', '화', '수', '목', '금', '토'],
    months: ['01월','02월','03월','04월','05월','06월', '07월','08월','09월','10월','11월','12월'],
    monthsShort: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
    today: 'Today',
    clear: 'Clear',
    dateFormat: 'dd-mm-yyyy',
    timeFormat: 'hh:ii:ss',
    firstDay: 0
}; })(jQuery);


// air-datepicker en
;(function ($) { $.fn.datepicker.language['en'] = {
    days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
	  daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
	  daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
	  months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	  monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	  today: "Today",
	  clear: "Clear",
    dateFormat: 'dd-mm-yyyy',
    timeFormat: 'hh:ii:ss',
    firstDay: 0
}; })(jQuery);

function container_top() {
	var container_pt = $(".green_header").height();
	$("section.container").css("padding-top",container_pt)
}

// 리스트 반응형 처리
function listR(){
	if ($(window).width() < 780) {
		for(var a = 0; a < $('.tab_area .clearfix').length; a++){
			var cf = $('.tab_area .clearfix').eq(a);
			var cfTotalWidth = 0;

			for(var b = 0; b < cf.children('li').length; b++){
				cfTotalWidth += cf.children('li').eq(b).width() + 10;
			}
			cf.css("width", cfTotalWidth);
		}
		//tab scroll
		if($('.tab_area a').hasClass('active')){
			var offset = $('.tab_area .active').offset();
			var left = offset.left;
			$('.tab_area').scrollLeft(left - 20);
		}
	}
}