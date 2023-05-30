<?php
//괄호 안의 에러 메세지 출력
/*
php.ini 에서 "display_errors" 가 1 인 경우나 ini_set('display_errors', 1); 인 경우에만 동작합니다.
ini_set('display_errors', 1); 는 시스템이나 버전에 따라 지원되지 않는 경우도 있습니다.
*/
/*
에러 예약상수

E_NOTICE - notice 에러 출력 여부를 나타내는 예약상수 입니다.
Notice 는 실행시에 발생하는 주의사항, 확인사항 으로서, 변수나 상수가 정의 되지 않은 상태에서 사용되어질때 주로 발생합니다. 
이 에러가 발생하더라도 프로그램(스크립트)은 중단 되지 않습니다.

E_WARNING - warning 에러 출력 여부를 나타내는 예약상수 입니다.
Warning 은 실행시에 발생하는 경고입니다. 치명적인 에러는 아닙니다. 
서버상에 존재하지 않는 파일이나 디렉토리 또는 메모리 상에 존재하지 않는 리소스(resource) 를 사용하고자 할때 주로 발생합니다.
이 에러가 발생하더라도 프로그램(스크립트)은 중단 되지 않습니다.

E_PARSE - Parse 에러 출력 여부를 나타내는 예약상수 입니다.
Parse 에러는 php parser 가 코드를 해석하는 단계에서 발생하는 에러로서, 문법적으로 맞지 않는 경우 주로 발생합니다.
프로그램 실행이전에 해석 단계에서 발생하는 에러이므로, 프로그램 실행은 전혀 이루어지지 않습니다.

E_ERROR - 일반적인 에러 출력 여부를 나타내는 예약상수 입니다.
일반적인 에러는 프로그램 실행시 발생하는 치명적인 에러 입니다. 메모리가 부족하거나 메모리에 데이터를 할당 할수 없을 경우에 주로 발생합니다.
프로그램 실행시 발생하는 에러이므로, 이 에러가 발생하기 이전까지는 프로그램이 실행됩니다. 발생된 시점에서 프로그램은 중단 됩니다.

E_DEPRECATED - 상위버전에서 더이상 지원되지 않는 함수나 클래스 등을 사용할 경우 발생하는 에러를 출력할지 나타내는 예약상수 입니다.

E_STRICT - 상호작용을 고려하여 현재의 코드에 대한 변경을 요청, 제안할때 발생하는 에러를 출력할지 나타내는 예약상수 입니다.

E_ALL - 발생하는 모든 에러의 출력 여부를 나타내는 예약상수 입니다.

나머지 _NOTICE, _WARNING, _ERROR 가 붙은 상수는 기존 의미에서 세분화된 내용이라고 이해하면 될듯합니다.
*/

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
// https://sir.kr/bbs/board.php?bo_table=pg_tip&wr_id=14397
/*
핵심은, 브라우져에게 이 페이지는 대부분의 모든 정보(CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC)의 접근을 허용한다는 것을 헤더로 알려준다는 의미입니다.
즉, 허용하니 특별히 제한 하지 말라는 뜻입니다.
*/
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

//최대 실행시간 제한 : 0일때 시간이 무제한
//ex 서버가 로드 중 멈추면 해당 시점부터 지정한 시간만큼 시간 연장
//https://smallmir.tistory.com/141 참조
//@ -> 파일이 없어도 오류메세지 출력 X
if (!defined('D9_SET_TIME_LIMIT')) define('D9_SET_TIME_LIMIT', 0);
@set_time_limit(D9_SET_TIME_LIMIT);

//==========================================================================================================================
// extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
// 081029 : letsgolee 님께서 도움 주셨습니다.
//--------------------------------------------------------------------------------------------------------------------------
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
				  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
				  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
	// POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
	if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
	if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}
//==========================================================================================================================

function d9_path()
{
	//$_SERVER['SCRIPT_FILENAME'] = 실행되고 있는 파일의 전체 경로 = index.php
	//__FILE__ : 현재 파일(common.php)의 절대 경로
	//dirname 인자로 들어온 경로의 상위 디렉토리까지의 경로

	/*
	만약, "/home/계정/public_html/d9" 에 그누보드를 설치하였다면
	__FILE__ 은 "/home/계정/public_html/d9/common.php" 가 되고
	dirname(__FILE__) 은 "/home/계정/public_html/d9" 가 됩니다.
	*/
	$chroot = substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], dirname(__FILE__)));

	//디렉토리 구분자 / 로 변경
	/*
	if (DIRECTORY_SEPARATOR !== '/')
		$result['path'] = str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__));
	*/
	$result['path'] = str_replace('\\', '/', $chroot.dirname(__FILE__));
	$result['path'] = str_replace('/common', '', $result['path']);

	// https://아이피/~계정/index.php 형식 -> https://도메인/index.php 형식과 일치하게 변경
	// $tilde_remove = preg_replace('`^/~[^/]+(.*)$`', '$1', $_SERVER['SCRIPT_NAME']);
	$tilde_remove = preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);

	// https://아이피/~계정/index.php 형식 -> https://도메인/index.php 형식과 일치하게 변경
	$document_root = str_replace($tilde_remove, '', $_SERVER['SCRIPT_FILENAME']);


	$pattern = '/' . preg_quote($document_root, '/') . '/i';

	/*
	"/home/계정/public_html/d9" 에서 "/home/계정/public_html" 제거함으로써 "/d9" 만 남게됩니다.
	만약, 설치를 "/home/계정/public_html" 에 하였다면 $root 는 "" 만 남게 됩니다.
	*/
	//$root = preg_replace($pattern, '', $result['path']);
	$root = "";

	//웹서버의 포트가 80, 443번이 아니면 포트를 따로 저장한다는 뜻입니다.
	$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];

	//접속환경이 보안서버인지 아닌지 판단하는 부분입니다.
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';

	/*
	"/home/계정/public_html/d9/index.php" 에서 "/home/계정/public_html" 를 제거 하고 ("/d9/index.php")
	"http://도메인/d9/index.php" 형태로 접속하면, $_SERVER['SCRIPT_NAME'] 이 "/d9/index.php"" 이고, 거기서 위에서 뽑은 "/d9/index.php" 제거하면 "" 만 남게 됩니다.
	"http://아이피/~계정/d9/index.php"  형태로 접속하면, $_SERVER['SCRIPT_NAME'] 이 "/~계정/d9/index.php"" 이고, 거기서 위에서 뽑은 "/d9/index.php" 제거하면 "/~계정" 만 남게 됩니다.
	*/
	$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);

	/*
	접속호스트를 뽑습니다.
	"http://도메인/d9/index.php" 형태로 접속하면, "도메인" 이고
	"http://아이피/~계정/d9/index.php" 형태로 접속하면, "아이피" 입니다.
	*/
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

	//호스트에 포트번호 붙혀있을때 제거
	if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
		$host = preg_replace('/:[0-9]+$/', '', $host);
	
	//호스트 뒤에 특수문자들 제거
	$host = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);

	//url 반환
	$result['url'] = $http.$host.$port.$user.$root;

	/*
	반환 값 예시

	"http://도메인/d9/index.php" 형태로 접속하면, "http://" . "도메인" . "" . "" . "/d9";

	"http://도메인:8080/d9/index.php" 형태로 접속하면, "http://" . "도메인" . ":8080" . "" . "/d9";

	"http://아이피/~계정/d9/index.php" 형태로 접속하면, "http://" . "아이피" . "" . "/~계정" . "/d9";

	"http://아이피:8080/~계정/d9/index.php" 형태로 접속하면, "http://" . "아이피" . ":8080" . "/~계정" . "/d9";

	*/

	//result 반환
	return $result;
}

//d9_path 뽑음
$d9_path = d9_path();

//config(설정파일) include
include_once($d9_path['path'].'/common/config.php');   // 설정 파일

//language(설정파일) include
include_once($d9_path['path'].'/common/locale.php');

//상수로 뽑았기 때문에 unset처리
unset($d9_path);

// 어떤 배열을 $d9_common_pathrray 로 받았을때 하위 모든 배열의 값에 어떤 처리를 일괄적으로 해줌
// multi-dimensional array에 사용자지정 함수적용
function array_map_deep($fn, $array)
{
	if(is_array($array)) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				$array[$key] = array_map_deep($fn, $value);
			} else {
				$array[$key] = call_user_func($fn, $value);
			}
		}
	} else {
		$array = call_user_func($fn, $array);
	}

	return $array;
}

// SQL Injection 대응 문자열 필터링
// 현재 config에서 D9_ESCAPE_PATTERN 와 D9_ESCAPE_REPLACE가 주석처리 되어있음
function sql_escape_string($str)
{

	if(defined('D9_ESCAPE_PATTERN') && defined('D9_ESCAPE_REPLACE')) {
		$pattern = D9_ESCAPE_PATTERN;
		$replace = D9_ESCAPE_REPLACE;

		if($pattern)
			$str = preg_replace($pattern, $replace, $str);
	}
	//sql 인젝션 공격에 온 str을 addslashes(백슬래시 추가)처리해줌
	$str = call_user_func('addslashes', $str);

	return $str;
}

//==============================================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//------------------------------------------------------------------------------
// 이스케이프 작업 : addslashes()와 stripslashes()를 이용하여 데이터를 변환하는 작업
// magic_quotes_gpc(이스케이프 처리가 되었는지 확인) 에 의한 backslashes 제거

if (get_magic_quotes_gpc()) {
	//stripslashes 백슬래쉬 제거
	$_POST	= array_map_deep('stripslashes',  $_POST);
	$_GET	 = array_map_deep('stripslashes',  $_GET);
	$_COOKIE  = array_map_deep('stripslashes',  $_COOKIE);
	$_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
}

// sql_escape_string 적용
$_POST	= array_map_deep(D9_ESCAPE_FUNCTION,  $_POST);
$_GET	 = array_map_deep(D9_ESCAPE_FUNCTION,  $_GET);
$_COOKIE  = array_map_deep(D9_ESCAPE_FUNCTION,  $_COOKIE);
$_REQUEST = array_map_deep(D9_ESCAPE_FUNCTION,  $_REQUEST);
//==============================================================================

//extract : 함수에 $_GET을 인자로 넣으면 ($_POST도 가능) GET으로 넘기는 파라미터와 값을 변수와 그 초기값으로 설정할 수 있다.
//보안에 취약하기에(https://aceatom.tistory.com/164), 변수 선언전에 함수를 사용하거나, 함수 사용 후에 다시 변수를 덮어야함

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);

// $member 에 값을 직접 넘길 수 있음
$config = array();
$member = array();
$board  = array();
$group  = array();
$d9	 = array();

//==============================================================================
// 공통
//------------------------------------------------------------------------------

//include와 require 같은 동작이지만, require는 include와 달리 파일이 없거나, 에러 발생시 스크립트가 바로 중지되기 때문에 핵심 파일은 require가 조금 더 좋은거 같다.
include_once('lib/common.lib.php');	// 공통 라이브러리
include_once('lib/query.lib.php'); // 공통 쿼리 라이브러리

//디비서버에 연결하고, 사용할 디비를 선택하는 부분입니다.
//or die : 왼쪽의 함수 실패 시 오른쪽 함수 실행
$connect_db = sql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
$select_db  = sql_select_db(MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');

// mysql connect resource $d9 배열에 저장 - 명랑폐인님 제안
$d9['connect_db'] = $connect_db;

//DB와 연결할 때, 데이터를 주고받을 때 utf8 사용
sql_set_charset('utf8', $connect_db);
// MYSQL_SET_MODE : 그누보드의  install/install_db.php 54~59 에서 true/false로 설정 된 값
// install_db.php 54~59 -> sql버전이 작성된 버전 이상이면 true, 아니면 false
// 디비 설정 시 https://sir.kr/pg_lecture/606?page=1 참고
if(defined('MYSQL_SET_MODE') && MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = ''");

//그누보드에서는 기본 timezone이 미 설정되어있음 -> Asia/Seoul로 설정해줘야함
//현재 세션에서만 sql서버의 timezone 사용
if (defined('D9_TIMEZONE')) sql_query(" set time_zone = '".D9_TIMEZONE."'");

//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------

// ini_set 은 php.ini 에 설정할수 있는 환경설정값을 php 실행시에 현재 접속에 대해서만 설정 하는 함수
/*
session.use_trans_sid -> url 을 통해서 세션아이디(기본 - PHPSESSID)​ 를 전달 할수 있느냐 여부, false(0) 은 불가 true(1) 은 가능
보안상 크게 좋을것이 없으므로 0 또는 false 를 설정합니다.
*/
@ini_set("session.use_trans_sid", 0); // PHPSESSID를 자동으로 넘기지 않음

ini_set("session.cache_expire", 1440); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 86400); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 0);
ini_set("session.gc_divisor", 1000);

session_set_cookie_params(86400, '/');
ini_set("session.cookie_domain", D9_COOKIE_DOMAIN);

session_start();

/*
url_rewriter.tags -> php 가 html 출력시에 세션아이디(기본 - PHPSESSID) 를 각 태그의 src 나 href 같은 속성에 자동으로 넣을수 있도록 설정하는 것입니다. 
보안상 크게 좋을것이 없으므로 아무값도 설정하지 않습니다.
*/
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)

//==============================================================================
// 로그인 관련
//------------------------------------------------------------------------------
//회원정보 가져오기
if($_SESSION["USER"]["email"]) {
	$member = get_member($_SESSION["USER"]["email"]);
}

// 메일 관련
include_once('lib/mailer.lib.php');
?>