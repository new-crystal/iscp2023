<?php

// 이 상수가 정의되지 않으면 각각의 개별 페이지는 별도로 실행될 수 없음
define('_DONG9_', true);

//timezone 한국시간으로 설정
if (PHP_VERSION >= '5.1.0') {
	//if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");
	date_default_timezone_set("Asia/Seoul");

}


//보안 서버 설정방법 더 찾아봐야함
define('D9_DOMAIN', 'http://13.209.65.41');
define('D9_HTTPS_DOMAIN', '');

/*
www.sir.kr 과 sir.kr 도메인은 서로 다른 도메인으로 인식합니다. 쿠키를 공유하려면 .sir.kr 과 같이 입력하세요.
이곳에 입력이 없다면 www 붙은 도메인과 그렇지 않은 도메인은 쿠키를 공유하지 않으므로 로그인이 풀릴 수 있습니다.
*/
define('D9_COOKIE_DOMAIN',  '');


/*
디비와 관련 정보를 담은 파일의 이름을 설정합니다.
보안상의 이유로 기본 "dbconfig.php" 라는 파일명 대신 다른 것(secret.php)을 사용한다면 "secret.php" 로 설정합니다.
*/
define('D9_DBCONFIG_FILE',  'dbconfig.php');

/*****************************************************
*     경로 상수 설정
******************************************************/
define('D9_COMMON_DIR',		'common');
define('D9_ADMIN_DIR',      'admin');
define('D9_AJAX_DIR',       'ajax');
define('D9_CSS_DIR',        'css');
define('D9_JS_DIR',		    'js');
define('D9_IMG_DIR',        'img');
define('D9_LIB_DIR',        'lib');
define('D9_INC_DIR',        'include');

// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
if (D9_DOMAIN) {
    define('D9_URL', D9_DOMAIN);
} else {
    if (isset($d9_path['url']))
        define('D9_URL', $d9_path['url']);
    else
        define('D9_URL', '');
}

if (isset($d9_path['path'])) {
    define('D9_PATH', $d9_path['path']);
} else {
    define('D9_PATH', '');
}

define('D9_COMMON_URL',					     D9_URL.'/'.D9_COMMON_DIR);
define('D9_COMMON_LIB_URL',                  D9_COMMON_URL.'/'.D9_LIB_DIR);

define('D9_ADMIN_URL',                       D9_URL.'/'.D9_ADMIN_DIR);
define('D9_ADMIN_CSS_URL',                   D9_ADMIN_URL.'/'.D9_CSS_DIR);
define('D9_ADMIN_JS_URL',                    D9_ADMIN_URL.'/'.D9_JS_DIR);
define('D9_ADMIN_IMG_URL',                   D9_ADMIN_URL.'/'.D9_IMG_DIR);

define('D9_IMG_URL',                         D9_URL.'/'.D9_IMG_DIR);
define('D9_AJAX_URL',						 D9_URL.'/'.D9_AJAX_DIR);

// PATH 는 서버상에서의 절대경로
define('D9_COMMON_PATH',                     D9_PATH.'/'.D9_COMMON_DIR);
define('D9_COMMON_LIB_PATH',                 D9_COMMON_PATH.'/'.D9_LIB_DIR);

define('D9_ADMIN_PATH',                      D9_PATH.'/'.D9_ADMIN_DIR);
define('D9_ADMIN_CSS_PATH',                  D9_ADMIN_PATH.'/'.D9_CSS_DIR);
define('D9_ADMIN_JS_PATH',                   D9_ADMIN_PATH.'/'.D9_JS_DIR);
define('D9_ADMIN_IMG_PATH',                  D9_ADMIN_PATH.'/'.D9_IMG_DIR);

define('D9_IMG_PATH',                        D9_PATH.'/'.D9_IMG_DIR);
define('D9_SESSION_PATH',                    D9_COMMON_PATH.'/'.D9_SESSION_DIR);

//==============================================================================
// 사용기기 설정
// pc 설정 시 모바일 기기에서도 PC화면 보여짐
// mobile 설정 시 PC에서도 모바일화면 보여짐
// both 설정 시 접속 기기에 따른 화면 보여짐
//------------------------------------------------------------------------------
define('D9_SET_DEVICE', 'PC');

define('D9_USE_CACHE',  true); // 최신글등에 cache 기능 사용 여부

/********************
    시간 상수
********************/
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 수정하세요.
// 하루는 86400 초입니다. 1시간은 3600초
// 6시간이 빠른 경우 time() + (3600 * 6);
// 6시간이 느린 경우 time() - (3600 * 6);
define('D9_SERVER_TIME',    time());
define('D9_TIME_YMDHIS',    date('Y-m-d H:i:s', D9_SERVER_TIME));
define('D9_TIME_YMD',       substr(D9_TIME_YMDHIS, 0, 10));
define('D9_TIME_HIS',       substr(D9_TIME_YMDHIS, 11, 8));

// 입력값 검사 상수 (숫자를 변경하시면 안됩니다.)
define('D9_ALPHAUPPER',      1); // 영대문자
define('D9_ALPHALOWER',      2); // 영소문자
define('D9_ALPHABETIC',      4); // 영대,소문자
define('D9_NUMERIC',         8); // 숫자
define('D9_HANGUL',         16); // 한글
define('D9_SPACE',          32); // 공백
define('D9_SPECIAL',        64); // 특수문자


/*
프로그램 실행도중 생성되는 디렉토리와 파일의 권한 설정입니다.
윈도우 서버는 신경 쓸 필요없고,
리눅스 서버일때는 보안상의 이유로 적당히 변경하여 사용할수 있는 설정입니다.
*/
define('D9_DIR_PERMISSION',  0755); // 디렉토리 생성시 퍼미션

define('D9_FILE_PERMISSION', 0644); // 파일 생성시 퍼미션


// SMTP
// lib/mailer.lib.php 에서 사용
define('D9_SMTP',      '127.0.0.1');
define('D9_SMTP_PORT', '25');


/*
내부적으로 사용될 암호화 함수를 설정합니다.
암호화에는 풀수 있는것과 없는 것이 있는데, 경우에 따라 암호화 된것을 풀어서 사용해야 한다면
여기서 거기에 맞는 함수를 설정하여 줍니다.
변경시에는 반드시, 이것은 설치전에 미리 이 파일을 열어서 변경해야합니다.
설치후에 변경하게 되면 로그인이 되지 않거나 정보가 엉키는 경우가 발생합니다.
*/
define('D9_STRING_ENCRYPT_FUNCTION', 'sql_password');

/*
디비 작업을 하면서 발생되는 에러를 보여줄것인지 설정합니다.
이것을 true 로 설정하게 되면 SQL 인젝션 공격의 빌미를 제공할수도 있습니다.
오픈전에 개발단계라면 true, 오픈 하면 false 로 놓는 것이 바람직합니다.
*/
define('D9_DISPLAY_SQL_ERROR', FALSE);

// escape string 처리 함수 지정
// addslashes 로 변경 가능
/*
define('D9_ESCAPE_FUNCTION', 'sql_escape_string');
디비에 저장시 들어갈 값을 필터링 해주거나 sql 실행상 문제가 없도록 만들어주는 함수를 설정합니다.
개인이 개별적으로 만들어서 여기에 설정하고 사용하여도 됩니다.
*/
define('D9_ESCAPE_FUNCTION', 'sql_escape_string');


// 게시판에서 링크의 기본개수를 말합니다.
// 필드를 추가하면 이 숫자를 필드수에 맞게 늘려주십시오.
define('D9_LINK_COUNT', 2);

//게시판이나 다른 프로그램 내에서 썸네일 이미지를 생성할때 jpg 인경우 그 질을 얼마에 맞출것인가에 대한 설정입니다. 100 이 최고값입니다.
define('D9_THUMB_JPG_QUALITY', 90);

 
//게시판이나 다른 프로그램 내에서 썸네일 이미지를 생성할때 png 인경우 결과물의 압축 레벨을 설정합니다.
//0 에서 9까지 설정 가능합니다. 숫자가 높을수록 압축율이 높습니다.
define('D9_THUMB_PNG_COMPRESS', 5);

// MySQLi 사용여부를 설정합니다.
define('D9_MYSQLI_USE', true);

// ip 숨김방법 설정
/* 123.456.789.012 ip의 숨김 방법을 변경하는 방법은
\\1 은 123, \\2는 456, \\3은 789, \\4는 012에 각각 대응되므로
표시되는 부분은 \\1 과 같이 사용하시면 되고 숨길 부분은 ♡등의
다른 문자를 적어주시면 됩니다.
*/
define('D9_IP_DISPLAY', '\\1.♡.\\3.\\4');

/*
다음 주소 api를 사용할때 필요한 부분입니다.
큰 차이는 업고 현재 접속 환경이 https 냐 http 냐에 따라 다른 스크리트 파일을 사용한다는 설정입니다. 
*/
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신일때 daum 주소 js
    define('D9_POSTCODE_JS', '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>');
} else {  //http 통신일때 daum 주소 js
    define('D9_POSTCODE_JS', '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');
}

/*****************************************************
*     DataBase 설정값
******************************************************/

define('MYSQL_HOST', '13.209.65.41');
define('MYSQL_USER', 'icomes');
define('MYSQL_PASSWORD', 'Gjqm6953!');
define('MYSQL_DB', 'icomes');
define('MYSQL_SET_MODE', true);