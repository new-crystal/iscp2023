$(document).ready(function () {
  //팝업 공통영역
  $(".pop_bg, .pop_close").click(function () {
    $(this).parents(".popup").removeClass("on");
    /* 같은카드찾기게임 관련 내용들 */
    //$(".btn_lucky, .btn_gameIn").removeClass("btnClicked");
    $(".btn_gamePlay").css("display", "block");
    $(".cardGame_setting_popup .pop_cont").css("padding-bottom", "0");
    $(".card").removeClass("flipped");
  });

  //탭
  /*$(".tab_pager li").click(function () {
    var i = $(this).index();
    $(".tab_pager li").removeClass("on");
    $(this).addClass("on");
    $(".tab_cont").removeClass("on");
    $(".tab_cont").eq(i).addClass("on");
  });*/

  if ($(".container").hasClass("video")){
    $(".mb_icon_menu").hide();
    $("header > .mb_only").prepend('<a href="javascript:;" class="exit_btn floatR exit_lecture">EXIT</a>');
  }

  //이벤트존 탭 (출석체크 -> e-Booth방문스탬프)
  /*$(".btn_eBooth").click(function () {
    $(".myAttendance").css("display", "none");
    $(".visitStamp").css("display", "block");
    $(".btn_attend").removeClass("yellow_btn").addClass("transparent_btn");
    $(".btn_eBooth").removeClass("transparent_btn").addClass("yellow_btn");
  });*/

  //이벤트존 탭 (출석체크 -> e-Booth방문스탬프)
  /* $(".btn_attend").click(function () {
    $(".myAttendance").css("display", "block");
    $(".visitStamp").css("display", "none");
    $(".btn_attend").removeClass("transparent_btn").addClass("yellow_btn");
    $(".btn_eBooth").removeClass("yellow_btn").addClass("transparent_btn");
  });*/

  /*//lucky draw popup (경로파악 후 추후 수정필요)
  $(".btn_lucky").click(function () {
    $(this).addClass("btnClicked");
    $(".luckyDraw_before_popup").addClass("on");
  });

  $(".luckyDraw_before_popup button").click(function () {
  $(".luckyDraw_after_popup").addClass("on");
  });

  $(".luckyDraw_after_popup button").click(function () {
    $(".luckyDraw_good_popup").addClass("on");
  });
  $(".luckyDraw_good_popup .pop_cont").click(function () {
  $(".luckyDraw_good_popup").removeClass("on");
    $(".luckyDraw_bad_popup").addClass("on");
  });*/

  // e-Booth 방문스탬프 날짜 onClick event
  /*$(".eventDate span a").on("click", function(){
    $(".eventDate span a").removeClass("yellow_txt");
    $(this).addClass("yellow_txt");
  })*/

  //같은 카드 찾기 게임 관련 popup
  /*$(".btn_gameIn").click(function () {
    $(this).addClass("btnClicked");
    $(".cardGame_info_popup").addClass("on");
  });
  $(".btn_gameStart").click(function () {
    $(".cardGame_setting_popup").addClass("on");
  });*/
  // $(".cardGame_timeOut_popup .timeBox").click(function () {
  //   $(this).parents(".popup").removeClass("on");
  //   $(".cardGame_setting_popup").addClass("on");
  // });
  
  // e_poster chat 좋아요 박스
  /*$(".chat_likeBox").on("click", function(){
    $(this).toggleClass("on");

    var $img = $(this).children("img");
    $img.attr("src", function(index, attr){
      if(attr.match('_w')){
        return attr.replace('_w.png', '_b.png');
      }else{
        return attr.replace('_b.png', '_w.png');
      }
    })
  });*/

  //동영상 비율
  /*$(window).resize(function () {
    var vdoH = $(".video_container form").height() - 77;
    $(".iframe_box").height(vdoH);
  });
  $(window).trigger("resize");*/

	//파트너 슬릭
	$(".partner_slick ul").slick({
		infinite: false,
		slidesToShow: 11,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		variableWidth: true,
		responsive: [{  
			breakpoint: 450,
				settings: {
				//infinite: true,
				slidesToShow: 'auto',
				} 
			}
		]	
	});

  //채팅 업로드
  $(".chat_upload01").click(function () {
    var chat_text = $(this).siblings("input").val();
    $(".scroll_chat ul").prepend("<li>" + chat_text + "</li>");
    $(this).siblings("input").val("");
  });

  //인덱스일때 레이아웃 bg 수정
  if ($(".container").hasClass("index")) {
    $("header").hide();
  } else if ($(".container").hasClass("approval")) {
    $("header").hide();
    $("body").css("background", "#fff");
  }/* else if ($(".container").hasClass("video")) {
    $(".grade_pop").addClass("on");
  }*/

  //퇴장 confirm
  /*$(".exit_title").click(function () {
    confirm("퇴장하시겠습니까?");
  });*/

  /*//small_player
  $(".page_iframe").hide();
  $(".small_player").click(function () {
    $("body").append(
      "<iframe class='iframe_small' src='https://www.youtube.com/embed/nzDO6tAB6ng'></iframe>"
    );
    $("header").hide();
    $(".container").hide();
    $(".page_iframe").show();
  $(window).trigger("resize");
  $("html, body").css("height", "-webkit-fill-available")
    if ($("iframe").hasClass("iframe_small")) {
      $(".small_player").hide();
    }
  });*/

  /*현재시간
  var setinterval = setInterval(function () {
    var time_txt = null;
    var d = new Date();
    var h = d.getHours();
    var m = d.getMinutes();
    time_txt = h + ":" + m;
    $(".now_time").text(time_txt);
  }, 1000);*/

  // e-Poster 리스트
  $(".ePoster_list li.category_contents > div:first-child").click(function () {
    $(this).parent("li").toggleClass("on");
    if ($(window).width() > 450){
      var top1 = $(".ePoster_list").offset().top;
      var top2 = $(this).parent("li").offset().top;
      var top = top1 - top2;
      //$(".ePoster_list > li:first-child").css("margin-top", top);
      if ($(this).parents("li").hasClass("on")){
        $(".scrollImg").hide();
        $(".ePoster_list").css("height","calc(100% - 80px)")
        $(".ePoster_list li.category_contents:nth-child(1)").css("margin-top", top);
      }else {
        $(".scrollImg").show();
        $(".ePoster_list").css("height","calc(100% - 145px)");
        $(".ePoster_list li.category_contents:nth-child(1)").css("margin-top", 0);
      }
    };
  });


  // eposter_chat(mobile) chat popup
  $(".mb_only button.open_chat_btn").click(function(){
    $(".chat_cont_R").addClass('on popup');
    $("html, body").css({"height": "100%", "overflow" : "hidden"});
  })
  $(".chat_delete_btn").click(function(){
    $(".chat_cont_R").removeClass("on");
    $("html, body").css({"height": "auto", "overflow" : "initial"});
  })
  $(window).resize(function(){
    if ($(window).width() < 450){
      $(".chat_btn.send").text("Comment");
    }
  });
  $(window).trigger("resize");
  /*$(".ePoster_cont_wrap").hide(); 
  $(".ePoster_list_more").click(function(){
    $(this).parents("li").children(".ePoster_cont_wrap").stop().slideToggle("slow");


    $("ul.ePoster_list").toggleClass("noHeight");
    $(".ePoster_list li, .scrollImg").toggleClass("disappear");
    $(this).parents("li").toggleClass("appear");
  });*/

  // e-Poster 좋아요 페이지로 이동
  /*$("input[id='chk_liked']").click(function () {
    if ($("input[id='chk_liked']").is(":checked")) {
      window.document.location.href = "eposter_like.php";
    } else {
      window.document.location.href = "eposter_list.php";
    }
  });*/

  function setPosition(_left, _top, _height_ratio, target) {
    // 백그라운드 Rect data
    var background_bound = document
      .querySelector("#index-background")
      .getBoundingClientRect();

    // 백그라운드 이미지 위치 , 사이즈 할당
    var left = background_bound.left,
      top = background_bound.top,
      width = background_bound.width,
      height = background_bound.height;

    // 이미지 오리지널 사이즈
    var original_width = 1992;
    var original_height = 1105;

    // 오리지널 이미지 내 렉쳐 위치
    var original_left = _left;
    var original_top = _top;

    // 현재 이미지 사이즈 내 비디오 박스 위치 유추
    // width : x = original_width : original_left
    // heighy : y = original_height : original_top
    var x = (width * original_left) / original_width;
    var y = (height * original_top) / original_height;

    // 브라우저 사이즈 내 비디오 박스 위치 유추
    var x_in_browser = x + left;
    var y_in_browser = y + top;

    // 현재 이미지 사이즈 내 비디오 높이 값 유추
    var height_in_image = height * _height_ratio;

    $(target).css({
      left: x_in_browser + "px",
      top: y_in_browser + "px",
      height: height_in_image + "px",
    });
  }

  //인덱스 페이지 비디오 박스 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setVideoPosition() {
      setPosition(90, 375, 0.28, ".index_video");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setVideoPosition);
    window.addEventListener("resize", setVideoPosition);

    setVideoPosition();
  }

  //인덱스 페이지 렉쳐 룸 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setLectionPosition() {
      setPosition(105, 704, 0.2, "li.lecture");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 포스터 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setLectionPosition() {
      setPosition(777, 705, 0.14, "li.eposter");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 온라인부스 위치 조정
  if ($(".container").hasClass("index")) {
    function setLectionPosition() {
      setPosition(1008, 705, 0.14, "li.online_booth");
    }
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 온라인부스 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setLectionPosition() {
      setPosition(1326, 705, 0.14, "li.event_zone");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 프로그램 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setLectionPosition() {
      setPosition(1348, 840, 0.14, "li.program");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 마이페이지 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setLectionPosition() {
      setPosition(1475, 840, 0.16, "li.mypage");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 마이페이지 위치 조정
  if ($(".container").hasClass("index")) {
    // 비디오 박스 위치 조정 함수
    function setLectionPosition() {
      setPosition(1610, 850, 0.16, "li.abstract");
    }

    // 리사이즈 , 스크롤 이벤트 리스너 등록
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 온라인부스 위치 조정
  if ($(".container").hasClass("index")) {
    function setLectionPosition() {
      setPosition(820, 790, 0.185, "li.registration");
    }
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  //인덱스 페이지 파트너 슬라이드 위치 조정
  if ($(".container").hasClass("index")) {
    function setLectionPosition() {
      setPosition(800, 554,0.06, "li.partner_slick");
    }
    window.addEventListener("scroll", setLectionPosition);
    window.addEventListener("resize", setLectionPosition);

    setLectionPosition();
  }

  /*팝업*/
  /*$(".table_open").click(function () {
    $(".table_pop").addClass("on");
  });*/
  $(".fc-timegrid-event").click(function () {
    $(".lecture_pop").addClass("on");
  });
  /*$(".full_vdo_open").click(function () {
    $(".lecture_pop").removeClass("on");
    $(".full_vdo_pop").addClass("on");
  });*/
  /*$(".move_open").click(function(){
  $(".move_pop").addClass("on");
  });*/

  if ($("section").hasClass("auto")) {
    $("html,body").css("height", "auto");
  }

  var util = {
    random : function (min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min
    },
    filter : function (array, index) {
      var return_array = []

      for ( var x = 0; x < array.length; x++ ) {
        if ( x !== index ) {
          return_array.push(array[x])
        }
      }

      return return_array
    },
    numberFormat: function(e) {
      if ( e >= 10 ) return e
      else           return '0' + e
    },
    getHMS : function (second) {
      // 시간
      var hour = util.numberFormat(Math.floor(second / 3600))
      second -= (hour * 3600)

      // 분
      var minute = util.numberFormat(Math.floor(second / 60))
      second -= (minute * 60)

      // 초
      return hour + ':' + minute + ':' + util.numberFormat(second)
    }
  }

  /**
   * 카드 뒤집기 게임
   */
  if (
    window.location.href.indexOf("icomes_live/event_myAttendance.php") !== -1
  ) {

    // 타이머 시간
    var time_second = 0

    // 타이머 함수
    var tickTock = null

    // 뒤집은 카드
    var flipped = []

    // 카드 내 이미지 경로 querySelector
    var image_selector = '.card-back img'

    var success = 0;

    // 카드 이미지 섞기
    var imageSuffle = function () {
    console.log('카드섞기');
      // 카드 불러오기
     // var cards = document.querySelectorAll(".cardGame_set td.card");
    var cards = document.querySelectorAll(".cardGame_set li.card");
    
      // 이미지 경로 리스트
      var image_urls = [];

      // 이미지 경로 리스트에 업데이트
      for (
        var x = 0; x < cards.length; x++
      ) {
        var url = cards[x].querySelector(image_selector).src;
        image_urls.push(url);
      }

      // 이미지 경로 재할당
      for (
        var x = 0; x < cards.length; x++
      ) {
        var image_index = util.random(0,image_urls.length - 1)
        var image = image_urls[image_index]
        cards[x].querySelector(image_selector).src = image
        
        image_urls = util.filter(image_urls , image_index)
      }
    };

    // 시간 출력하기
    var viewTime = function () {
      document.querySelector('.timer').innerText = util.getHMS(time_second)
    }

    // 타이머 함수 할당
    var timerRegist = function () {
    console.log('시간추가');
      tickTock = setInterval(function() {
        time_second += 1
        viewTime()
      },1000)
    }

    // 타이머 제거
    var timerClear = function () {
      clearInterval(tickTock)
      time_second = 0;
      viewTime()
    }

    // 게임 종료
    var onSuccess = function () {
      $('.cardGame_setting_popup').removeClass('on')
      $('.cardGame_timeOut_popup').addClass('on')

      document.querySelector('.success-time').innerText = util.getHMS(time_second)

      onExit();
    }

    // 카드 클릭 이벤트
    var onClickCard = function (e) {
      var target = e.currentTarget

      // 같은 카드 두 번 연속 클릭 방지
      if ( 
        target.classList.value.indexOf('flipped') !== -1
      ) {
        return
      }

      target.classList.add('flipped')
      target.classList.add('checking')

      flipped.push(target.querySelector(image_selector).src)

      // 카드 2개 뒤집힌 경우
      if (
        flipped.length === 2
      ) {
        cardRemoveEvent()
        // 두 카드가 일치하지 않는 경우
        if (
          flipped[0] !== flipped[1]
        ) {
          setTimeout(() => {
            $('.flipped.checking').removeClass('checking flipped')
            cardAddEvent()
          },800)
        } 
        // 두 카드가 일치하는 경우
        else {
          success += 1
          setTimeout(() => {

            var cards = document.querySelectorAll(".cardGame_set li.card");

            $('.flipped.checking').removeClass('checking')

            if ( success === cards.length / 2 ) {
              onSuccess()
            } else {
              cardAddEvent()
            }
          },800)
        }

        flipped = []
      }
    }

    // 카드 이벤트 등록
    var cardAddEvent = function () {
    console.log('카드이벤트등록');
      // 카드 불러오기
      var cards = document.querySelectorAll(".cardGame_set li.card");

      for ( var x = 0; x < cards.length; x++ ) {
        cards[x].addEventListener('click' , onClickCard)
      } 
    }

    // 카드 이벤트 해제
    var cardRemoveEvent = function () {
      // 카드 불러오기
      var cards = document.querySelectorAll(".cardGame_set li.card");

      for ( var x = 0; x < cards.length; x++ ) {
        cards[x].removeEventListener('click' , onClickCard)
      } 
    }

    // 게임 종료 공통 이벤트
    var onExit = () => {
      timerClear();
      cardRemoveEvent();
      flipped = [];
      success = 0;
    }

    // 게임 시작 버튼 클릭 이벤트
    $(".btn_gamePlay").click(function () {
      $(this).css("display", "none");
      $(".cardGame_setting_popup .pop_cont").css("padding-bottom", "82px");

      imageSuffle();
      timerRegist();
      cardAddEvent();
    });

    // 탈출 시 타이머 초기화
    $(".pop_bg, .pop_close").click(function () {
      onExit();
    });
  }
  
  /*$(".lecture_info_white").hide();
  $(".card_list li").mouseover(function(){
    $(".lecture_info_white").show();
    $(".lecture_information > div:first-child").hide();
  });
  $(".card_list li").mouseleave(function(){
    $(".lecture_info_white").hide();
    $(".lecture_information > div:first-child").show();
  });*/

  if ($("section").hasClass("qr_page")){
    $("header").hide();
  }

  // 모바일 화면 header 제목
  var getName = $(".mb_pg_title").text();
  $(".mb_pg_name").text(getName);

  // 평점팝업 테이블 반응형
  $(window).resize(function(){
    if ($(window).width() < 450){
      $(".custom_table .mb_custom").addClass("on");
      $(".custom_table td:last-child").hide();
      $(".custom_table colgroup").remove();
      $(".mb_custom_table col").attr("width","33.33%")
    } else {
      $(".custom_table td:last-child").show();
      $(".custom_table .mb_custom").removeClass("on");
    }
  });
  $(window).trigger("resize")

});//the end

function Enter_Check(){
  // 엔터키의 코드는 13입니다.
  if(event.keyCode == 13){
    var chat_text = $(".chat_input input").val();
    $(".scroll_chat ul").prepend("<li>" + chat_text + "</li>");
    $(".chat_input input").val("");
  }
}


function exit() {
  confirm("퇴장하시겠습니까?")
}