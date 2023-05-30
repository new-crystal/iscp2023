var device = "";							// Agent Info
var header_language = "";					// Default:Empty(=en)
var language = new Object();
language.value = "en";

// Running agent checked function
agentCheck();

// [함수] 접속기기 확인
function agentCheck(){
	var UserAgent = navigator.userAgent;
	if (UserAgent.match(/iPhone|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || UserAgent.match(/LG|SAMSUNG|Samsung/) != null){
		device = "mobile";
	}else{
		device = "pc";
	}
}

// [함수] 언어 변환 프로세스
function language_change(event, choice){
	/*if(event == "click"){
		choice = (choice == "eng") ? "ko" : "en";		// 토글버튼 클릭시 값의 Reverse 효과필요
	}else{
		choice = (choice == "kor") ? "ko" : "en";
	}

	header_language = choice;

	if(header_language == 'ko'){
		$('.toggle_wrap').addClass('left');
	}else{
		$('.toggle_wrap').removeClass('left');
	}
	

	setTimeout(function(){
		$.ajax({
			url: PATH+"ajax/client/ajax_language.php",
			type: "POST",
			data: {
				language:header_language
			},
			dataType : "JSON",
			success : function(res){
				if(res == 1) {
					location.reload();
				} else if(res.code == 400) {
					alert(header_language == "ko" ? "언어 변환 실패" : "Language Transformation Failed");
					return;
				} else {
					alert(header_language == "ko" ? "데이터 전송에 실패했습니다. 다시 시도해주십시오." : "Reject the request. Please try again.");
					return;
				}
			}
		});	
	}, 500);*/
}


// 파일 사이즈 제한 함수
function fileCheck(file)
{
        // 사이즈체크
        var maxSize  = 5 * 1024 * 1024    //5MB
        var fileSize = 0;

	// 브라우저 확인
	var browser=navigator.appName;
	
	// 익스플로러일 경우
	if (browser=="Microsoft Internet Explorer")
	{
		var oas = new ActiveXObject("Scripting.FileSystemObject");
		fileSize = oas.getFile( file.value ).size;
	}
	// 익스플로러가 아닐경우
	else
	{
		fileSize = file.files[0].size;
	}

    if(language.value == "en") {
        alert("File size : "+ fileSize +", Max file size : 5MB");
    } else {
        alert("파일 크기 : "+ fileSize +", 제한파일크기 : 5MB");
    }
	

        if(fileSize > maxSize)
        {
            var alert = language.value == "en" ? "Attachment size can be registered within 5MB." : "첨부파일 사이즈는 5MB 이내로 등록 가능합니다.";
            alert(alert);
            return false;
        }

    return true;
}

// 쿠키 생성
function setCookie (name, value, day) {
	var date = new Date();
	date.setTime(date.getTime() + day*24*60*60*1000);
	document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
}

// 쿠키 삭제하기
function removeCookie (name) {
	var date = new Date();
	document.cookie = name + "= " + "; expires=" + date.toUTCString() + "; path=/";
}

// pending 켜기
function pending_on(){
	$(".loading").show();
	$("body").css("overflow-y","hidden");
}

// pending 끄기
function pending_off(){
	$(".loading").hide();
	$("body").css("overflow-y","auto");
}