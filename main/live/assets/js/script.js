// Internet Explorer 6-11
var isIE = /*@cc_on!@*/false || !!document.documentMode;

function hasTouch() {
    return 'ontouchstart' in document.documentElement ||
        navigator.maxTouchPoints > 0 ||
        navigator.msMaxTouchPoints > 0;
}

if (hasTouch()) { // remove all the :hover stylesheets
    try { // prevent exception on browsers not supporting DOM styleSheets properly
        for (var si in document.styleSheets) {
            var styleSheet = document.styleSheets[si];
            if (!styleSheet.rules) continue;

            for (var ri = styleSheet.rules.length - 1; ri >= 0; ri--) {
                if (!styleSheet.rules[ri].selectorText) continue;

                if (styleSheet.rules[ri].selectorText.match(':hover')) {
                    styleSheet.deleteRule(ri);
                }
            }
        }
    } catch (ex) {}
}


//pc,mobile 체크
var broswer = {};

broswer.isMobile = function () {
    var tempUser = navigator.userAgent;
    var isMobile = false;

    // userAgent 값에 iPhone, iPad, ipot, Android 라는 문자열이 하나라도 존재한다면 모바일로 간주됨.
    if (tempUser.indexOf("iPhone") > 0 || tempUser.indexOf("iPad") > 0 ||
        tempUser.indexOf("iPot") > 0 || tempUser.indexOf("Android") > 0) {
        isMobile = true;
    }
    return isMobile;
};

broswer.isMobileChkPrint = function (isMobileChk) {
    var result = "";
    if (isMobileChk) {
        result = "mobile";
    } else {
        result = "PC";
    }
    return result;
};

function btn_li_reset() {
    var btn_li = $('.btn_li');
    btn_li.removeClass('on');
    setTimeout(function () {
        btn_li.addClass('on');
    }, 1000);
}


$(document).ready(function () {
    var isMobileChk = broswer.isMobile();
    var resultData = broswer.isMobileChkPrint(isMobileChk);
    var iccl = $('.iccl');

        iccl.on('mouseenter', function () {
            var thisId = $(this).attr('id');
            $(this).animate({
                'padding': '1.5%',
                'margin-left': '-0.4%',
                'margin-top': '-0.4%'
            }, 500)
            iccl.addClass('pause');
            $(this).addClass('animate');
            $(this).prev('.speech_b').animate({
                'opacity':'1',
            },500);
        });
        iccl.on('mouseleave', function () {
            $(this).animate({
                'padding': '1%',
                'margin-left': '0',
                'margin-top': '0'
            }, 500);
            iccl.removeClass('pause');
            iccl.removeClass('animate');
            $(this).prev('.speech_b').animate({
                'opacity':'0',
            },500);
        });
        var iccl_on = $('.iccl_on');

        iccl_on.on('mouseenter', function () {
            $(this).next('.speech_b').animate({
                'opacity':'1',
            },500);
        });
        iccl_on.on('mouseleave', function () {
            $(this).next('.speech_b').animate({
                'opacity':'0',
            },500);
        });
        
        
        $("#video_01").html("<video id='vid_auto' preload='auto' muted='muted' volume='0' playsinline autoplay loop><source src='https://player.vimeo.com/external/593799309.hd.mp4?s=01ba66bf51f7cc662bf107858b93196e8d7f63fb&profile_id=174'></video>");
//        $("#video_01").html("<iframe id='vid_auto' width='100%' height='100%' src='https://player.vimeo.com/video/593799309?autoplay=1&loop=1&playsinline=true&controls=0&background=1&muted=1' allowfullscreen ></iframe>");
//     $("#video_01").html("<video id='my_video_1' class='video-js vjs-fluid vjs-default-skin' data-setup='{}' muted autoplay loop> <source src='https://cdn3.wowza.com/2/SkNVM1lPbFV0NDdx/azZXdGxr/hls/jqkfhsrs/playlist.m3u8' type='application/x-mpegURL'> </video>");

        if (resultData == 'mobile'){
            $('.speech_b').attr('style',"display:none");
//            $('#my_video_1').remove();
//            $('#booth-content .real').attr('src','./assets/image/3840_cont_mo.png');
//            $('#main #booth-content').css('background-image','url(./assets/image/3840_cont_mo.png)');
        }

    // rotate();
    var ve = document.getElementById("video");
    if (ve !== null && ve.addEventListener) {
        ve.addEventListener('ended', function () {
            $(".vid-back").hide();
            $(".main-body").fadeIn(1000);
        }, false);
    }


    //	resize_video();
    $('#register_modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    $('#private_info_ch').click(function () {
        if ($(this).prop("checked") == true) {
            $("#register_btn").removeAttr("disabled");
        } else if ($(this).prop("checked") == false) {
            $("#register_btn").attr("disabled", true);
        }
    });


    $("#videoPlay_modal").on('hidden.bs.modal', function () {
        $('#video_play_ctl').get(0).load();
        $('#video_play_ctl').get(0).pause();
    });

    var oldresize = window.onresize;
    window.onresize = function (e) {
        var event = window.event || e;
        if (typeof (oldresize) === 'function' && !oldresize.call(window, event)) {
            return false;
        }
        if (typeof (window.onzoom) === 'function') {
            return window.onzoom.call(window, event);
        }
    };

    $(".vid_close").click(function () {
        var video = $('#ie_vid');
        video.get(0).pause();
        $(".ie_vid_area").fadeOut();
    });     
    
    $(".img_close").click(function () {
        $(".img_area").fadeOut();
    });
    
    $(".div-vid-close").click(function () {
        video = videojs('my-video');
        video.pause();
        $(".div-main-vid").fadeOut();
    });
});

function change_fullscreen() {
    var elem = document.getElementById("my_body");

    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
        /* Firefox */
        elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
        /* Chrome, Safari & Opera */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
        /* IE/Edge */
        elem.msRequestFullscreen();
    }
}

function end_video(e) {
    $("#intro_video").hide();
    // $('#container').show();
}





$(document).on('keypress',function(e){
    if(e.which == 13){
        $(".logo_area").remove();
        $(".div-intro-page").remove();
        $(".vid-back").remove();
        bg_change();
    }
})
