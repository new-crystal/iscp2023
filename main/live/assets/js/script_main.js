$(document).ready(function () {
    var isMobileChk = broswer.isMobile();
    var resultData = broswer.isMobileChkPrint(isMobileChk);
    var iccl = $('.iccl');

        iccl.on('mouseenter', function () {
            var thisId = $(this).attr('id');
            var onImgsrc = '../../assets/image/light_on_'+thisId+'.png';
            $(this).animate({
                'padding': '1.5vw',
                'margin-left': '-0.4vw',
                'margin-top': '-0.4vw'
            }, 500)
            iccl.addClass('pause');
            $(this).addClass('animate');
//            $(this).find('img').attr('src',onImgsrc);
        });
        iccl.on('mouseleave', function () {
            $(this).animate({
                'padding': '1vw',
                'margin-left': '0',
                'margin-top': '0'
            }, 500);
            var thisId = $(this).attr('id');
            var offImgsrc = '../../assets/image/light_off_'+thisId+'.png';
            iccl.removeClass('pause');
            iccl.removeClass('animate');
//            $(this).find('img').attr('src',offImgsrc);
        });
        
        
//        $("#video_01").html("<video id='vid_auto' preload='auto' muted='muted' volume='0' playsinline autoplay loop><source src='http://pre.icomes.or.kr/assets/video/main_vid.mp4'></video>");
        $("#video_01").html("<video id='vid_auto' preload='auto' muted='muted' volume='0' playsinline autoplay loop><source src='../../assets/download/vid_03.mp4'></video>");



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


    $('.iccl').click(function () {
        var click_id = $(this).attr('id');
        var data_src = eval(click_id + "_datasrc");

        if ($('#' + click_id).hasClass("link")) {
            window.open(data_src);
        } else if ($('#' + click_id).hasClass("play")) {
            if(isIE){         
                var v_val = data_src;
                var video = $('#ie_vid');
                $(".ie_vid_area").fadeIn();
                video.attr('src',data_src);
                video.get(0).play();
            }else{
                var v_val = data_src;
                var video = videojs('my-video');
                $(".div-main-vid").fadeIn();

                video.src(v_val);
                video.play();;  
            }
        } else if ($('#' + click_id).hasClass("img")) {
            $('.img_cont').attr('src',data_src);
            $('.img_area').fadeIn();
        } else if ($('#' + click_id).hasClass("pdf")) {
            show_flipbook_modal(data_src);
        } else if ($('#' + click_id).hasClass("visitor")) {
            show_regiter_modal();
        }
    });

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