<?php
if (!defined('_DONG9_')) exit;

/*************************************************************************
**
**  일반 함수 모음
**
*************************************************************************/

// 마이크로 타임을 얻어 계산 형식으로 만듦
function get_microtime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

// 결과값 반환 공통화
function return_value($code, $msg, $arr=array()){
	http_response_code($code);

	$arr["code"] = $code;
	$arr["msg"] = $msg;
	echo json_encode($arr, JSON_NUMERIC_CHECK);

	exit;
}

// sql을 받아서 배열 리스트를 반환해줌
function get_data($sql){
    $resultBox = [];
    $resultCount = 0;
    $result = sql_query($sql);
    while($row = sql_fetch_array($result)){
        $resultBox[$resultCount] = $row;
        $resultCount++;
    }
    return $resultBox;
}
// 변수 또는 배열의 이름과 값을 얻어냄. print_r() 함수의 변형
function print_r2($var)
{
    ob_start();
    print_r($var);
    $str = ob_get_contents();
    ob_end_clean();
    $str = str_replace(" ", "&nbsp;", $str);
    echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}


// 메타태그를 이용한 URL 이동
// header("location:URL") 을 대체
function goto_url($url)
{
    $url = str_replace("&amp;", "&", $url);
    //echo "<script> location.replace('$url'); </script>";

    if (!headers_sent())
        header('Location: '.$url);
    else {
        echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
    exit;
}


// 세션변수 생성
function set_session($session_name, $value)
{
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);
    // PHP 버전별 차이를 없애기 위한 방법
    $$session_name = $_SESSION[$session_name] = $value;
}


// 세션변수값 얻음
function get_session($session_name)
{
    return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
}


// 쿠키변수 생성
function set_cookie($cookie_name, $value, $expire)
{
    global $d9;

    setcookie(md5($cookie_name), base64_encode($value), D9_SERVER_TIME + $expire, '/', D9_COOKIE_DOMAIN);
}


// 쿠키변수값 얻음
function get_cookie($cookie_name)
{
    $cookie = md5($cookie_name);
    if (array_key_exists($cookie, $_COOKIE))
        return base64_decode($_COOKIE[$cookie]);
    else
        return "";
}

// way.co.kr 의 wayboard 참고
function url_auto_link($str)
{
    global $d9;
    global $config;

    // 140326 유창화님 제안코드로 수정
    // http://sir.kr/pg_lecture/461
    // http://sir.kr/pg_lecture/463
    $attr_nofollow = (function_exists('check_html_link_nofollow') && check_html_link_nofollow('url_auto_link')) ? ' rel="nofollow"' : '';
    $str = str_replace(array("&lt;", "&gt;", "&amp;", "&quot;", "&nbsp;", "&#039;"), array("\t_lt_\t", "\t_gt_\t", "&", "\"", "\t_nbsp_\t", "'"), $str);
    //$str = preg_replace("`(?:(?:(?:href|src)\s*=\s*(?:\"|'|)){0})((http|https|ftp|telnet|news|mms)://[^\"'\s()]+)`", "<A HREF=\"\\1\" TARGET='{$config['cf_link_target']}'>\\1</A>", $str);
    $str = preg_replace("/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#!=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET=\"{$config['cf_link_target']}\" $attr_nofollow>\\2</A>", $str);
    $str = preg_replace("/(^|[\"'\s(])(www\.[^\"'\s()]+)/i", "\\1<A HREF=\"http://\\2\" TARGET=\"{$config['cf_link_target']}\" $attr_nofollow>\\2</A>", $str);
    $str = preg_replace("/[0-9a-z_-]+@[a-z0-9._-]{4,}/i", "<a href=\"mailto:\\0\" $attr_nofollow>\\0</a>", $str);
    $str = str_replace(array("\t_nbsp_\t", "\t_lt_\t", "\t_gt_\t", "'"), array("&nbsp;", "&lt;", "&gt;", "&#039;"), $str);

    /*
    // 속도 향상 031011
    $str = preg_replace("/&lt;/", "\t_lt_\t", $str);
    $str = preg_replace("/&gt;/", "\t_gt_\t", $str);
    $str = preg_replace("/&amp;/", "&", $str);
    $str = preg_replace("/&quot;/", "\"", $str);
    $str = preg_replace("/&nbsp;/", "\t_nbsp_\t", $str);
    $str = preg_replace("/([^(http:\/\/)]|\(|^)(www\.[^[:space:]]+)/i", "\\1<A HREF=\"http://\\2\" TARGET='{$config['cf_link_target']}'>\\2</A>", $str);
    //$str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,]+)/i", "\\1<A HREF=\"\\2\" TARGET='$config['cf_link_target']'>\\2</A>", $str);
    // 100825 : () 추가
    // 120315 : CHARSET 에 따라 링크시 글자 잘림 현상이 있어 수정
    $str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET='{$config['cf_link_target']}'>\\2</A>", $str);

    // 이메일 정규표현식 수정 061004
    //$str = preg_replace("/(([a-z0-9_]|\-|\.)+@([^[:space:]]*)([[:alnum:]-]))/i", "<a href='mailto:\\1'>\\1</a>", $str);
    $str = preg_replace("/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i", "<a href='mailto:\\1'>\\1</a>", $str);
    $str = preg_replace("/\t_nbsp_\t/", "&nbsp;" , $str);
    $str = preg_replace("/\t_lt_\t/", "&lt;", $str);
    $str = preg_replace("/\t_gt_\t/", "&gt;", $str);
    */

    return $str;
}

// url에 http:// 를 붙인다
function set_http($url)
{
    if (!trim($url)) return;

    if (!preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $url))
        $url = "http://" . $url;

    return $url;
}

// 파일의 용량을 구한다.
//function get_filesize($file)
function get_filesize($size)
{
    //$size = @filesize(addslashes($file));
    if ($size >= 1048576) {
        $size = number_format($size/1048576, 1) . "M";
    } else if ($size >= 1024) {
        $size = number_format($size/1024, 1) . "K";
    } else {
        $size = number_format($size, 0) . "byte";
    }
    return $size;
}

// 폴더의 용량 ($dir는 / 없이 넘기세요)
function get_dirsize($dir)
{
    $size = 0;
    $d = dir($dir);
    while ($entry = $d->read()) {
        if ($entry != '.' && $entry != '..') {
            $size += filesize($dir.'/'.$entry);
        }
    }
    $d->close();
    return $size;
}


/*************************************************************************
**
**  그누보드 관련 함수 모음
**
*************************************************************************/

// set_search_font(), get_search_font() 함수를 search_font() 함수로 대체
function search_font($stx, $str)
{
    global $config;

    // 문자앞에 \ 를 붙입니다.
    $src = array('/', '|');
    $dst = array('\/', '\|');

    if (!trim($stx) && $stx !== '0') return $str;

    // 검색어 전체를 공란으로 나눈다
    $s = explode(' ', $stx);

    // "/(검색1|검색2)/i" 와 같은 패턴을 만듬
    $pattern = '';
    $bar = '';
    for ($m=0; $m<count($s); $m++) {
        if (trim($s[$m]) == '') continue;
        // 태그는 포함하지 않아야 하는데 잘 안되는군. ㅡㅡa
        //$pattern .= $bar . '([^<])(' . quotemeta($s[$m]) . ')';
        //$pattern .= $bar . quotemeta($s[$m]);
        //$pattern .= $bar . str_replace("/", "\/", quotemeta($s[$m]));
        $tmp_str = quotemeta($s[$m]);
        $tmp_str = str_replace($src, $dst, $tmp_str);
        $pattern .= $bar . $tmp_str . "(?![^<]*>)";
        $bar = "|";
    }

    // 지정된 검색 폰트의 색상, 배경색상으로 대체
    $replace = "<b class=\"sch_word\">\\1</b>";

    return preg_replace("/($pattern)/i", $replace, $str);
}

// 관리자 페이지네이션
// 한페이지에 보여줄 행, 페이징 html에서 최대로 보여줄 페이지 수, 현재페이지, 리스트 갯수, 총페이지수, URL
function get_paging_admin($write_row, $write_page, $current_page, $total_count, $total_page, $url, $type, $add="")
{
	//$type = "";
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    //$url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '?page=';
	//print_r($type);
	
	if($type != ""){
	    $url = preg_replace($_SERVER['QUERY_STRING'], '', $url) . '?'.$type[0].'&page=';
	} else {
		$url = preg_replace($_SERVER['QUERY_STRING'], '', $url) . '?page=';
	}

    $str = '<ul class="clearfix">'.PHP_EOL;
    /*if ($current_page > 1) {
        $str .= '<li><a href="'.$url.'1'.$add.'"><img src="./img/back_arrow_icon.png" alt="처음 페이지로"></a></li>'.PHP_EOL;
    }*/
    $start_page = ( ( (int)( ($current_page - 1 ) / $write_page ) ) * $write_page ) + 1;
	
    $end_page = $start_page + $write_page - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    //if ($start_page > 1) $str .= '<li><a href="'.$url.($start_page-1).$add.'"><img src="/admin/img/back_arrow.png" alt="전 페이지로"></a></li>'.PHP_EOL;
	if ($current_page > 1) $str .= '<li><a href="'.$url.($current_page - 1).$add.'"><img src="/admin/img/back_arrow.png" alt="전 페이지로"></a></li>';

    if ($total_page >= 1) {
        for ($k=$start_page; $k <= $end_page; $k++) {
            if ($current_page != $k)
                // $str .= '<a href="'.$url.$k.$add.'" class="pg_page">'.$k.'<span class="sound_only">페이지</span></a>'.PHP_EOL;
                $str .= '<li><a href="'.$url.$k.$add.'">'.$k.'</a></li>'.PHP_EOL;
            else
                // $str .= '<span class="sound_only">열린</span><strong class="pg_current">'.$k.'</strong><span cslass="sound_only">페이지</span>'.PHP_EOL;
                $str .= '<li><a href="javascript:;" class="active">'.$k.'</a></li>'.PHP_EOL;
        }
    }

    //if ($total_page > $end_page) $str .= '<li><a href="'.$url.($end_page+1).$add.'"><img src="./img/arrow_right.png" alt="다음 페이지로"></a></li>'.PHP_EOL;
	if ($current_page < $end_page) $str .= '<li><a href="'.$url.($current_page + 1).'"><img src="/admin/img/front_arrow.png" alt="다음 페이지로"></a></li>';

    /*if ($current_page < $total_page) {
        $str .= '<li><a href="'.$url.$total_page.$add.'"><img src="./img/front_arrow_icon.png" alt="마지막 페이지로"></a></li>'.PHP_EOL;
    }*/

    $str .= '</ul>'.PHP_EOL;

   if ($str)
        $result['html'] = '<div class="pagination">'.$str.'</div>';
    else
        $result['html'] = "";

	// 리스트 출력할 번호
	$result['start_row'] = ($current_page <= 1) ? 0 : (($current_page - 1)*$write_row);
	$result['end_row'] = (($current_page*$write_row) > $total_count) ? $total_count : (($current_page*$write_row) - 1);
	if ($result['end_row'] == $total_count) {
		$result['end_row']--;
	}
	return $result;
}


// abstract
// 한페이지에 보여줄 행, 페이징 html에서 최대로 보여줄 페이지 수, 현재페이지, 리스트 갯수, 총페이지수, URL
function get_paging_arrow($write_row, $write_page, $current_page, $total_count, $total_page, $url, $type, $add="")
{
	//$type = "";
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    //$url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '?page=';
	//print_r($type);
	
	if($type != ""){
	    $url = preg_replace($_SERVER['QUERY_STRING'], '', $url) . '?'.$type[0].'&page=';
	} else {
		$url = preg_replace($_SERVER['QUERY_STRING'], '', $url) . '?page=';
	}

    $str = '<ul class="pagenation">'.PHP_EOL;
    /*if ($current_page > 1) {
        $str .= '<li><a href="'.$url.'1'.$add.'"><img src="./img/back_arrow_icon.png" alt="처음 페이지로"></a></li>'.PHP_EOL;
    }*/
    $start_page = ( ( (int)( ($current_page - 1 ) / $write_page ) ) * $write_page ) + 1;
	
    $end_page = $start_page + $write_page - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    //if ($start_page > 1) $str .= '<li><a href="'.$url.($start_page-1).$add.'"><img src="/admin/img/back_arrow.png" alt="전 페이지로"></a></li>'.PHP_EOL;
	if ($current_page > 1) $str .= '<li class="arrow"><a href="'.$url.($current_page - 1).$add.'"> < </a></li>';

    if ($total_page >= 1) {
        for ($k=$start_page; $k <= $end_page; $k++) {
            if ($current_page != $k)
                // $str .= '<a href="'.$url.$k.$add.'" class="pg_page">'.$k.'<span class="sound_only">페이지</span></a>'.PHP_EOL;
                $str .= '<li><a href="'.$url.$k.$add.'">'.$k.'</a></li>'.PHP_EOL;
            else
                // $str .= '<span class="sound_only">열린</span><strong class="pg_current">'.$k.'</strong><span cslass="sound_only">페이지</span>'.PHP_EOL;
                $str .= '<li class="on"><a href="javascript:;">'.$k.'</a></li>'.PHP_EOL;
        }
    }

    //if ($total_page > $end_page) $str .= '<li><a href="'.$url.($end_page+1).$add.'"><img src="./img/arrow_right.png" alt="다음 페이지로"></a></li>'.PHP_EOL;
	if ($current_page < $end_page) $str .= '<li class ="arrow"><a href="'.$url.($current_page + 1).'"> > </a></li>';

    /*if ($current_page < $total_page) {
        $str .= '<li><a href="'.$url.$total_page.$add.'"><img src="./img/front_arrow_icon.png" alt="마지막 페이지로"></a></li>'.PHP_EOL;
    }*/

    $str .= '</ul>'.PHP_EOL;

   if ($str)
        //$result['html'] = '<div class="pagination">'.$str.'</div>';
	   $result['html'] = $str;
    else
        $result['html'] = "";

	// 리스트 출력할 번호
	$result['start_row'] = ($current_page <= 1) ? 0 : (($current_page - 1)*$write_row);
	$result['end_row'] = (($current_page*$write_row) > $total_count) ? $total_count : (($current_page*$write_row) - 1);
	if ($result['end_row'] == $total_count) {
		$result['end_row']--;
	}
	return $result;
}



// 제목을 변환
function conv_subject($subject, $len, $suffix='')
{
    return get_text(cut_str($subject, $len, $suffix));
}

// 내용을 변환
function conv_content($content, $html, $filter=true)
{
    global $config, $board;

    if ($html)
    {
        $source = array();
        $target = array();

        $source[] = "//";
        $target[] = "";

        if ($html == 2) { // 자동 줄바꿈
            $source[] = "/\n/";
            $target[] = "<br/>";
        }

        // 테이블 태그의 개수를 세어 테이블이 깨지지 않도록 한다.
        $table_begin_count = substr_count(strtolower($content), "<table");
        $table_end_count = substr_count(strtolower($content), "</table");
        for ($i=$table_end_count; $i<$table_begin_count; $i++)
        {
            $content .= "</table>";
        }

        $content = preg_replace($source, $target, $content);

        if($filter)
            $content = html_purifier($content);
    }
    else // text 이면
    {
        // & 처리 : &amp; &nbsp; 등의 코드를 정상 출력함
        $content = html_symbol($content);

        // 공백 처리
		//$content = preg_replace("/  /", "&nbsp; ", $content);
		$content = str_replace("  ", "&nbsp; ", $content);
		$content = str_replace("\n ", "\n&nbsp;", $content);

        $content = get_text($content, 1);
        $content = url_auto_link($content);
    }

    return $content;
}

function check_html_link_nofollow($type=''){
    return true;
}

// http://htmlpurifier.org/
// Standards-Compliant HTML Filtering
// Safe  : HTML Purifier defeats XSS with an audited whitelist
// Clean : HTML Purifier ensures standards-compliant output
// Open  : HTML Purifier is open-source and highly customizable
function html_purifier($html)
{
    $f = file(D9_PLUGIN_PATH.'/htmlpurifier/safeiframe.txt');
    $domains = array();
    foreach($f as $domain){
        // 첫행이 # 이면 주석 처리
        if (!preg_match("/^#/", $domain)) {
            $domain = trim($domain);
            if ($domain)
                array_push($domains, $domain);
        }
    }
    // 내 도메인도 추가
    array_push($domains, $_SERVER['HTTP_HOST'].'/');
    $safeiframe = implode('|', $domains);

    include_once(D9_PLUGIN_PATH.'/htmlpurifier/HTMLPurifier.standalone.php');
    include_once(D9_PLUGIN_PATH.'/htmlpurifier/extend.video.php');
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.SafeEmbed', false);
    $config->set('HTML.SafeObject', false);
    $config->set('Output.FlashCompat', false);
    $config->set('HTML.SafeIframe', true);
    if( (function_exists('check_html_link_nofollow') && check_html_link_nofollow('html_purifier')) ){
        $config->set('HTML.Nofollow', true);    // rel=nofollow 으로 스팸유입을 줄임
    }
    $config->set('URI.SafeIframeRegexp','%^(https?:)?//('.$safeiframe.')%');
    $config->set('Attr.AllowedFrameTargets', array('_blank'));
    //유튜브, 비메오 전체화면 가능하게 하기
    $config->set('Filter.Custom', array(new HTMLPurifier_Filter_Iframevideo()));
    $purifier = new HTMLPurifier($config);
    return $purifier->purify($html);
}

// 날짜, 조회수의 경우 높은 순서대로 보여져야 하므로 $flag 를 추가
// $flag : asc 낮은 순서 , desc 높은 순서
// 제목별로 컬럼 정렬하는 QUERY STRING
function subject_sort_link($col, $query_string='', $flag='asc')
{
    global $sst, $sod, $sfl, $stx, $page, $sca;

    $q1 = "sst=$col";
    if ($flag == 'asc')
    {
        $q2 = 'sod=asc';
        if ($sst == $col)
        {
            if ($sod == 'asc')
            {
                $q2 = 'sod=desc';
            }
        }
    }
    else
    {
        $q2 = 'sod=desc';
        if ($sst == $col)
        {
            if ($sod == 'desc')
            {
                $q2 = 'sod=asc';
            }
        }
    }

    $arr_query = array();
    $arr_query[] = $query_string;
    $arr_query[] = $q1;
    $arr_query[] = $q2;
    $arr_query[] = 'sfl='.$sfl;
    $arr_query[] = 'stx='.$stx;
    $arr_query[] = 'sca='.$sca;
    $arr_query[] = 'page='.$page;
    $qstr = implode("&amp;", $arr_query);

    return "<a href=\"{$_SERVER['SCRIPT_NAME']}?{$qstr}\">";
}

function option_selected($value, $selected, $text='')
{
    if (!$text) $text = $value;
    if ($value == $selected)
        return "<option value=\"$value\" selected=\"selected\">$text</option>\n";
    else
        return "<option value=\"$value\">$text</option>\n";
}


// '예', '아니오'를 SELECT 형식으로 얻음
function get_yn_select($name, $selected='1', $event='')
{
    $str = "<select name=\"$name\" $event>\n";
    if ($selected) {
        $str .= "<option value=\"1\" selected>예</option>\n";
        $str .= "<option value=\"0\">아니오</option>\n";
    } else {
        $str .= "<option value=\"1\">예</option>\n";
        $str .= "<option value=\"0\" selected>아니오</option>\n";
    }
    $str .= "</select>";
    return $str;
}

function cut_str($str, $len, $suffix="…")
{
    $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    $str_len = count($arr_str);

    if ($str_len >= $len) {
        $slice_str = array_slice($arr_str, 0, $len);
        $str = join("", $slice_str);

        return $str . ($str_len > $len ? $suffix : '');
    } else {
        $str = join("", $arr_str);
        return $str;
    }
}


// TEXT 형식으로 변환
function get_text($str, $html=0, $restore=false)
{
    $source[] = "<";
    $target[] = "&lt;";
    $source[] = ">";
    $target[] = "&gt;";
    $source[] = "\"";
    $target[] = "&#034;";
    $source[] = "\'";
    $target[] = "&#039;";

    if($restore)
        $str = str_replace($target, $source, $str);

    // 3.31
    // TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
    if ($html == 0) {
        $str = html_symbol($str);
    }

    if ($html) {
        $source[] = "\n";
        $target[] = "<br/>";
    }

    return str_replace($source, $target, $str);
}


/*
// HTML 특수문자 변환 htmlspecialchars
function hsc($str)
{
    $trans = array("\"" => "&#034;", "'" => "&#039;", "<"=>"&#060;", ">"=>"&#062;");
    $str = strtr($str, $trans);
    return $str;
}
*/

// 3.31
// HTML SYMBOL 변환
// &nbsp; &amp; &middot; 등을 정상으로 출력
function html_symbol($str)
{
    return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}


/*************************************************************************
**
**  SQL 관련 함수 모음
**
*************************************************************************/

// DB 연결
function sql_connect($host, $user, $pass, $db=MYSQL_DB)
{
    global $d9;

    if(function_exists('mysqli_connect') && D9_MYSQLI_USE) {
	
        $link = mysqli_connect($host, $user, $pass, $db);

        // 연결 오류 발생 시 스크립트 종료
        if (mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {

        $link = mysql_connect($host, $user, $pass);
    }

    return $link;
}


// DB 선택
function sql_select_db($db, $connect)
{
    global $d9;

    if(function_exists('mysqli_select_db') && D9_MYSQLI_USE)
        return @mysqli_select_db($connect, $db);
    else
        return @mysql_select_db($db, $connect);
}


function sql_set_charset($charset, $link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];

    if(function_exists('mysqli_set_charset') && D9_MYSQLI_USE)
        mysqli_set_charset($link, $charset);
    else
        mysql_query(" set names {$charset} ", $link);
}


// mysqli_query 와 mysqli_error 를 한꺼번에 처리
// mysql connect resource 지정 - 명랑폐인님 제안
function sql_query($sql, $error=D9_DISPLAY_SQL_ERROR, $link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && D9_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}


// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=D9_DISPLAY_SQL_ERROR, $link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];

    $result = sql_query($sql, $error, $link);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
    $row = sql_fetch_array($result);
    return $row;
}


// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    if(function_exists('mysqli_fetch_assoc') && D9_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}


// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
function sql_free_result($result)
{
    if(function_exists('mysqli_free_result') && D9_MYSQLI_USE)
        return mysqli_free_result($result);
    else
        return mysql_free_result($result);
}


function sql_password($value)
{
    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
    $row = sql_fetch(" select password('$value') as pass ");

    return $row['pass'];
}


function sql_insert_id($link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];

    if(function_exists('mysqli_insert_id') && D9_MYSQLI_USE)
        return mysqli_insert_id($link);
    else
        return mysql_insert_id($link);
}


function sql_num_rows($result)
{
    if(function_exists('mysqli_num_rows') && D9_MYSQLI_USE)
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}


function sql_field_names($table, $link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];

    $columns = array();

    $sql = " select * from `$table` limit 1 ";
    $result = sql_query($sql, $link);

    if(function_exists('mysqli_fetch_field') && D9_MYSQLI_USE) {
        while($field = mysqli_fetch_field($result)) {
            $columns[] = $field->name;
        }
    } else {
        $i = 0;
        $cnt = mysql_num_fields($result);
        while($i < $cnt) {
            $field = mysql_fetch_field($result, $i);
            $columns[] = $field->name;
            $i++;
        }
    }

    return $columns;
}


function sql_error_info($link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];

    if(function_exists('mysqli_error') && D9_MYSQLI_USE) {
        return mysqli_errno($link) . ' : ' . mysqli_error($link);
    } else {
        return mysql_errno($link) . ' : ' . mysql_error($link);
    }
}


// PHPMyAdmin 참고
function get_table_define($table, $crlf="\n")
{
    global $d9;

    // For MySQL < 3.23.20
    $schema_create .= 'CREATE TABLE ' . $table . ' (' . $crlf;

    $sql = 'SHOW FIELDS FROM ' . $table;
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        $schema_create .= '    ' . $row['Field'] . ' ' . $row['Type'];
        if (isset($row['Default']) && $row['Default'] != '')
        {
            $schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';
        }
        if ($row['Null'] != 'YES')
        {
            $schema_create .= ' NOT NULL';
        }
        if ($row['Extra'] != '')
        {
            $schema_create .= ' ' . $row['Extra'];
        }
        $schema_create     .= ',' . $crlf;
    } // end while
    sql_free_result($result);

    $schema_create = preg_replace('/,' . $crlf . '$/', '', $schema_create);

    $sql = 'SHOW KEYS FROM ' . $table;
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        $kname    = $row['Key_name'];
        $comment  = (isset($row['Comment'])) ? $row['Comment'] : '';
        $sub_part = (isset($row['Sub_part'])) ? $row['Sub_part'] : '';

        if ($kname != 'PRIMARY' && $row['Non_unique'] == 0) {
            $kname = "UNIQUE|$kname";
        }
        if ($comment == 'FULLTEXT') {
            $kname = 'FULLTEXT|$kname';
        }
        if (!isset($index[$kname])) {
            $index[$kname] = array();
        }
        if ($sub_part > 1) {
            $index[$kname][] = $row['Column_name'] . '(' . $sub_part . ')';
        } else {
            $index[$kname][] = $row['Column_name'];
        }
    } // end while
    sql_free_result($result);

    while (list($x, $columns) = @each($index)) {
        $schema_create     .= ',' . $crlf;
        if ($x == 'PRIMARY') {
            $schema_create .= '    PRIMARY KEY (';
        } else if (substr($x, 0, 6) == 'UNIQUE') {
            $schema_create .= '    UNIQUE ' . substr($x, 7) . ' (';
        } else if (substr($x, 0, 8) == 'FULLTEXT') {
            $schema_create .= '    FULLTEXT ' . substr($x, 9) . ' (';
        } else {
            $schema_create .= '    KEY ' . $x . ' (';
        }
        $schema_create     .= implode($columns, ', ') . ')';
    } // end while

    $schema_create .= $crlf . ') ENGINE=MyISAM DEFAULT CHARSET=utf8';

    return $schema_create;
} // end of the 'PMA_getTableDef()' function


// 리퍼러 체크
function referer_check($url='')
{
    /*
    // 제대로 체크를 하지 못하여 주석 처리함
    global $d9;

    if (!$url)
        $url = D9_URL;

    if (!preg_match("/^http['s']?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER']))
        alert("제대로 된 접근이 아닌것 같습니다.", $url);
    */
}


// 한글 요일
function get_yoil($date, $full=0)
{
    $arr_yoil = array ('일', '월', '화', '수', '목', '금', '토');

    $yoil = date("w", strtotime($date));
    $str = $arr_yoil[$yoil];
    if ($full) {
        $str .= '요일';
    }
    return $str;
}


// 날짜를 select 박스 형식으로 얻는다
function date_select($date, $name='')
{
    global $d9;

    $s = '';
    if (substr($date, 0, 4) == "0000") {
        $date = D9_TIME_YMDHIS;
    }
    preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", $date, $m);

    // 년
    $s .= "<select name='{$name}_y'>";
    for ($i=$m['0']-3; $i<=$m['0']+3; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['0']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>년 \n";

    // 월
    $s .= "<select name='{$name}_m'>";
    for ($i=1; $i<=12; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['2']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>월 \n";

    // 일
    $s .= "<select name='{$name}_d'>";
    for ($i=1; $i<=31; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['3']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>일 \n";

    return $s;
}


// 시간을 select 박스 형식으로 얻는다
// 1.04.00
// 경매에 시간 설정이 가능하게 되면서 추가함
function time_select($time, $name="")
{
    preg_match("/([0-9]{2}):([0-9]{2}):([0-9]{2})/", $time, $m);

    // 시
    $s .= "<select name='{$name}_h'>";
    for ($i=0; $i<=23; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['0']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>시 \n";

    // 분
    $s .= "<select name='{$name}_i'>";
    for ($i=0; $i<=59; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['2']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>분 \n";

    // 초
    $s .= "<select name='{$name}_s'>";
    for ($i=0; $i<=59; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m['3']) {
            $s .= " selected";
        }
        $s .= ">$i";
    }
    $s .= "</select>초 \n";

    return $s;
}


// DEMO 라는 파일이 있으면 데모 화면으로 인식함
function check_demo()
{
    global $is_admin;
    if ($is_admin != 'super' && file_exists(D9_PATH.'/DEMO'))
        alert('데모 화면에서는 하실(보실) 수 없는 작업입니다.');
}


// 문자열이 한글, 영문, 숫자, 특수문자로 구성되어 있는지 검사
function check_string($str, $options)
{
    global $d9;

    $s = '';
    for($i=0;$i<strlen($str);$i++) {
        $c = $str[$i];
        $oc = ord($c);

        // 한글
        if ($oc >= 0xA0 && $oc <= 0xFF) {
            if ($options & D9_HANGUL) {
                $s .= $c . $str[$i+1] . $str[$i+2];
            }
            $i+=2;
        }
        // 숫자
        else if ($oc >= 0x30 && $oc <= 0x39) {
            if ($options & D9_NUMERIC) {
                $s .= $c;
            }
        }
        // 영대문자
        else if ($oc >= 0x41 && $oc <= 0x5A) {
            if (($options & D9_ALPHABETIC) || ($options & D9_ALPHAUPPER)) {
                $s .= $c;
            }
        }
        // 영소문자
        else if ($oc >= 0x61 && $oc <= 0x7A) {
            if (($options & D9_ALPHABETIC) || ($options & D9_ALPHALOWER)) {
                $s .= $c;
            }
        }
        // 공백
        else if ($oc == 0x20) {
            if ($options & D9_SPACE) {
                $s .= $c;
            }
        }
        else {
            if ($options & D9_SPECIAL) {
                $s .= $c;
            }
        }
    }

    // 넘어온 값과 비교하여 같으면 참, 틀리면 거짓
    return ($str == $s);
}


// 한글(2bytes)에서 마지막 글자가 1byte로 끝나는 경우
// 출력시 깨지는 현상이 발생하므로 마지막 완전하지 않은 글자(1byte)를 하나 없앰
function cut_hangul_last($hangul)
{
    global $d9;

    // 한글이 반쪽나면 ?로 표시되는 현상을 막음
    $cnt = 0;
    for($i=0;$i<strlen($hangul);$i++) {
        // 한글만 센다
        if (ord($hangul[$i]) >= 0xA0) {
            $cnt++;
        }
    }

    return $hangul;
}


// 테이블에서 INDEX(키) 사용여부 검사
function explain($sql)
{
    if (preg_match("/^(select)/i", trim($sql))) {
        $q = "explain $sql";
        echo $q;
        $row = sql_fetch($q);
        if (!$row['key']) $row['key'] = "NULL";
        echo " <font color=blue>(type={$row['type']} , key={$row['key']})</font>";
    }
}

// 악성태그 변환
function bad_tag_convert($code)
{
    global $view;
    global $member, $is_admin;

    if ($is_admin && $member['mb_id'] != $view['mb_id']) {
        //$code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>(\<\/(embed|object)\>)?#i",
        // embed 또는 object 태그를 막지 않는 경우 필터링이 되도록 수정
        $code = preg_replace_callback("#(\<(embed|object)[^\>]*)\>?(\<\/(embed|object)\>)?#i",
                    create_function('$matches', 'return "<div class=\"embedx\">보안문제로 인하여 관리자 아이디로는 embed 또는 object 태그를 볼 수 없습니다. 확인하시려면 관리권한이 없는 다른 아이디로 접속하세요.</div>";'),
                    $code);
    }

    return preg_replace("/\<([\/]?)(script|iframe|form)([^\>]*)\>?/i", "&lt;$1$2$3&gt;", $code);
}


// 토큰 생성
function _token()
{
    return md5(uniqid(rand(), true));
}

function is_empty ($var) {
	return ($var == "" || $var == "undefined" || $var == "0" || $var == null || $var == "null");
}


// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function get_token()
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_token', $token);

    return $token;
}


// POST로 넘어온 토큰과 세션에 저장된 토큰 비교
function check_token()
{
    set_session('ss_token', '');
    return true;
}


// 문자열에 utf8 문자가 들어 있는지 검사하는 함수
// 코드 : http://in2.php.net/manual/en/function.mb-check-encoding.php#95289
function is_utf8($str)
{
    $len = strlen($str);
    for($i = 0; $i < $len; $i++) {
        $c = ord($str[$i]);
        if ($c > 128) {
            if (($c > 247)) return false;
            elseif ($c > 239) $bytes = 4;
            elseif ($c > 223) $bytes = 3;
            elseif ($c > 191) $bytes = 2;
            else return false;
            if (($i + $bytes) > $len) return false;
            while ($bytes > 1) {
                $i++;
                $b = ord($str[$i]);
                if ($b < 128 || $b > 191) return false;
                $bytes--;
            }
        }
    }
    return true;
}


// UTF-8 문자열 자르기
// 출처 : https://www.google.co.kr/search?q=utf8_strcut&aq=f&oq=utf8_strcut&aqs=chrome.0.57j0l3.826j0&sourceid=chrome&ie=UTF-8
function utf8_strcut( $str, $size, $suffix='...' )
{
        $substr = substr( $str, 0, $size * 2 );
        $multi_size = preg_match_all( '/[\x80-\xff]/', $substr, $multi_chars );

        if ( $multi_size > 0 )
            $size = $size + intval( $multi_size / 3 ) - 1;

        if ( strlen( $str ) > $size ) {
            $str = substr( $str, 0, $size );
            $str = preg_replace( '/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str );
            $str .= $suffix;
        }

        return $str;
}


/*
-----------------------------------------------------------
    Charset 을 변환하는 함수
-----------------------------------------------------------
iconv 함수가 있으면 iconv 로 변환하고
없으면 mb_convert_encoding 함수를 사용한다.
둘다 없으면 사용할 수 없다.
*/
function convert_charset($from_charset, $to_charset, $str)
{

    if( function_exists('iconv') )
        return iconv($from_charset, $to_charset, $str);
    elseif( function_exists('mb_convert_encoding') )
        return mb_convert_encoding($str, $to_charset, $from_charset);
    else
        die("Not found 'iconv' or 'mbstring' library in server.");
}


// mysqli_real_escape_string 의 alias 기능을 한다.
function sql_real_escape_string($str, $link=null)
{
    global $d9;

    if(!$link)
        $link = $d9['connect_db'];
    
    if(function_exists('mysqli_connect') && D9_MYSQLI_USE) {
        return mysqli_real_escape_string($link, $str);
    }

    return mysql_real_escape_string($str, $link);
}

function escape_trim($field)
{
    $str = call_user_func(D9_ESCAPE_FUNCTION, $field);
    return $str;
}


// $_POST 형식에서 checkbox 엘리먼트의 checked 속성에서 checked 가 되어 넘어 왔는지를 검사
function is_checked($field)
{
    return !empty($_POST[$field]);
}


function abs_ip2long($ip='')
{
    $ip = $ip ? $ip : $_SERVER['REMOTE_ADDR'];
    return abs(ip2long($ip));
}


function get_selected($field, $value)
{
    if( is_int($value) ){
        return ((int) $field===$value) ? ' selected="selected"' : '';
    }

    return ($field===$value) ? ' selected="selected"' : '';
}


function get_checked($field, $value)
{
    if( is_int($value) ){
        return ((int) $field===$value) ? ' checked="checked"' : '';
    }

    return ($field===$value) ? ' checked="checked"' : '';
}

/*******************************************************************************
    유일한 키를 얻는다.

    결과 :

        년월일시분초00 ~ 년월일시분초99
        년(4) 월(2) 일(2) 시(2) 분(2) 초(2) 100분의1초(2)
        총 16자리이며 년도는 2자리로 끊어서 사용해도 됩니다.
        예) 2008062611570199 또는 08062611570199 (2100년까지만 유일키)

    사용하는 곳 :
    1. 게시판 글쓰기시 미리 유일키를 얻어 파일 업로드 필드에 넣는다.
    2. 주문번호 생성시에 사용한다.
    3. 기타 유일키가 필요한 곳에서 사용한다.
*******************************************************************************/
// 기존의 get_unique_id() 함수를 사용하지 않고 get_uniqid() 를 사용한다.
function get_uniqid()
{
    sql_query(" LOCK TABLE 'uniqid' WRITE ");
    while (1) {
        // 년월일시분초에 100분의 1초 두자리를 추가함 (1/100 초 앞에 자리가 모자르면 0으로 채움)
        $key = date('YmdHis', time()) . str_pad((int)(microtime()*100), 2, "0", STR_PAD_LEFT);

        $result = sql_query(" insert into 'uniqid' set uq_id = '$key', uq_ip = '{$_SERVER['REMOTE_ADDR']}' ", false);
        if ($result) break; // 쿼리가 정상이면 빠진다.

        // insert 하지 못했으면 일정시간 쉰다음 다시 유일키를 만든다.
        usleep(10000); // 100분의 1초를 쉰다
    }
    sql_query(" UNLOCK TABLES ");

    return $key;
}


// CHARSET 변경 : euc-kr -> utf-8
function iconv_utf8($str)
{
    return iconv('euc-kr', 'utf-8', $str);
}


// CHARSET 변경 : utf-8 -> euc-kr
function iconv_euckr($str)
{
    return iconv('utf-8', 'euc-kr', $str);
}


// 에디터 이미지 얻기
function get_editor_image($contents, $view=true)
{
    if(!$contents)
        return false;

    // $contents 중 img 태그 추출
    if ($view)
        $pattern = "/<img([^>]*)>/iS";
    else
        $pattern = "/<img[^>]*src=[\'\"]?([^>\'\"]+[^>\'\"]+)[\'\"]?[^>]*>/i";
    preg_match_all($pattern, $contents, $matchs);

    return $matchs;
}

// 에디터 썸네일 삭제
function delete_editor_thumbnail($contents)
{
    if(!$contents)
        return;

    // $contents 중 img 태그 추출
    $matchs = get_editor_image($contents);

    if(!$matchs)
        return;

    for($i=0; $i<count($matchs[1]); $i++) {
        // 이미지 path 구함
        $imgurl = @parse_url($matchs[1][$i]);
        $srcfile = $_SERVER['DOCUMENT_ROOT'].$imgurl['path'];

        $filename = preg_replace("/\.[^\.]+$/i", "", basename($srcfile));
        $filepath = dirname($srcfile);
        $files = glob($filepath.'/thumb-'.$filename.'*');
        if (is_array($files)) {
            foreach($files as $filename)
                unlink($filename);
        }
    }
}

// file_put_contents 는 PHP5 전용 함수이므로 PHP4 하위버전에서 사용하기 위함
// http://www.phpied.com/file_get_contents-for-php4/
if (!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data) {
        $f = @fopen($filename, 'w');
        if (!$f) {
            return false;
        } else {
            $bytes = fwrite($f, $data);
            fclose($f);
            return $bytes;
        }
    }
}


// HTML 마지막 처리
function html_end()
{
    global $html_process;

    return $html_process->run();
}

function add_stylesheet($stylesheet, $order=0)
{
    global $html_process;

    if(trim($stylesheet))
        $html_process->merge_stylesheet($stylesheet, $order);
}

function add_javascript($javascript, $order=0)
{
    global $html_process;

    if(trim($javascript))
        $html_process->merge_javascript($javascript, $order);
}

class html_process {
    protected $css = array();
    protected $js  = array();

    function merge_stylesheet($stylesheet, $order)
    {
        $links = $this->css;
        $is_merge = true;

        foreach($links as $link) {
            if($link[1] == $stylesheet) {
                $is_merge = false;
                break;
            }
        }

        if($is_merge)
            $this->css[] = array($order, $stylesheet);
    }

    function merge_javascript($javascript, $order)
    {
        $scripts = $this->js;
        $is_merge = true;

        foreach($scripts as $script) {
            if($script[1] == $javascript) {
                $is_merge = false;
                break;
            }
        }

        if($is_merge)
            $this->js[] = array($order, $javascript);
    }

    function run()
    {
        $buffer = ob_get_contents();
        ob_end_clean();

        $stylesheet = '';
        $links = $this->css;

        if(!empty($links)) {
            foreach ($links as $key => $row) {
                $order[$key] = $row[0];
                $index[$key] = $key;
                $style[$key] = $row[1];
            }

            array_multisort($order, SORT_ASC, $index, SORT_ASC, $links);

            foreach($links as $link) {
                if(!trim($link[1]))
                    continue;

                $link[1] = preg_replace('#\.css([\'\"]?>)$#i', '.css?ver='.D9_CSS_VER.'$1', $link[1]);

                $stylesheet .= PHP_EOL.$link[1];
            }
        }

        $javascript = '';
        $scripts = $this->js;
        $php_eol = '';

        unset($order);
        unset($index);

        if(!empty($scripts)) {
            foreach ($scripts as $key => $row) {
                $order[$key] = $row[0];
                $index[$key] = $key;
                $script[$key] = $row[1];
            }

            array_multisort($order, SORT_ASC, $index, SORT_ASC, $scripts);

            foreach($scripts as $js) {
                if(!trim($js[1]))
                    continue;

                $js[1] = preg_replace('#\.js([\'\"]?>)$#i', '.js?ver='.D9_JS_VER.'$1', $js[1]);

                $javascript .= $php_eol.$js[1];
                $php_eol = PHP_EOL;
            }
        }

        /*
        </title>
        <link rel="stylesheet" href="default.css">
        밑으로 스킨의 스타일시트가 위치하도록 하게 한다.
        */
        $buffer = preg_replace('#(</title>[^<]*<link[^>]+>)#', "$1$stylesheet", $buffer);

        /*
        </head>
        <body>
        전에 스킨의 자바스크립트가 위치하도록 하게 한다.
        */
        $nl = '';
        if($javascript)
            $nl = "\n";
        $buffer = preg_replace('#(</head>[^<]*<body[^>]*>)#', "$javascript{$nl}$1", $buffer);

        return $buffer;
    }
}

// 휴대폰번호의 숫자만 취한 후 중간에 하이픈(-)을 넣는다.
function hyphen_hp_number($hp)
{
    $hp = preg_replace("/[^0-9]/", "", $hp);
    return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $hp);
}


// 로그인 후 이동할 URL
function login_url($url='')
{
    if (!$url) $url = D9_URL;

    return urlencode(clean_xss_tags(urldecode($url)));
}


// $dir 을 포함하여 https 또는 http 주소를 반환한다.
function https_url($dir, $https=true)
{
    if ($https) {
        if (D9_HTTPS_DOMAIN) {
            $url = D9_HTTPS_DOMAIN.'/'.$dir;
        } else {
            $url = D9_URL.'/'.$dir;
        }
    } else {
        if (D9_DOMAIN) {
            $url = D9_DOMAIN.'/'.$dir;
        } else {
            $url = D9_URL.'/'.$dir;
        }
    }

    return $url;
}

// goo.gl 짧은주소 만들기
function googl_short_url($longUrl)
{
    global $config;

    // Get API key from : http://code.google.com/apis/console/
    // URL Shortener API ON
    $apiKey = $config['cf_googl_shorturl_apikey'];

    $postData = array('longUrl' => $longUrl);
    $jsonData = json_encode($postData);

    $curlObj = curl_init();

    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($curlObj);

    //change the response json string to object
    $json = json_decode($response);

    curl_close($curlObj);

    return $json->id;
}

// get_sock 함수 대체
if (!function_exists("get_sock")) {
    function get_sock($url, $timeout=30)
    {
        // host 와 uri 를 분리
        //if (ereg("http://([a-zA-Z0-9_\-\.]+)([^<]*)", $url, $res))
        if (preg_match("/http:\/\/([a-zA-Z0-9_\-\.]+)([^<]*)/", $url, $res))
        {
            $host = $res[1];
            $get  = $res[2];
        }

        // 80번 포트로 소캣접속 시도
        $fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
        if (!$fp)
        {
            //die("$errstr ($errno)\n");

            echo "$errstr ($errno)\n";
            return null;
        }
        else
        {
            fputs($fp, "GET $get HTTP/1.0\r\n");
            fputs($fp, "Host: $host\r\n");
            fputs($fp, "\r\n");

            // header 와 content 를 분리한다.
            while (trim($buffer = fgets($fp,1024)) != "")
            {
                $header .= $buffer;
            }
            while (!feof($fp))
            {
                $buffer .= fgets($fp,1024);
            }
        }
        fclose($fp);

        // content 만 return 한다.
        return $buffer;
    }
}

// 인증, 결제 모듈 실행 체크
function module_exec_check($exe, $type)
{
    $error = '';
    $is_linux = false;
    if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
        $is_linux = true;

    // 모듈 파일 존재하는지 체크
    if(!is_file($exe)) {
        $error = $exe.' 파일이 존재하지 않습니다.';
    } else {
        // 실행권한 체크
        if(!is_executable($exe)) {
            if($is_linux)
                $error = $exe.'\n파일의 실행권한이 없습니다.\n\nchmod 755 '.basename($exe).' 과 같이 실행권한을 부여해 주십시오.';
            else
                $error = $exe.'\n파일의 실행권한이 없습니다.\n\n'.basename($exe).' 파일에 실행권한을 부여해 주십시오.';
        } else {
            // 바이너리 파일인지
            if($is_linux) {
                $search = false;
                $isbinary = true;
                $executable = true;

                switch($type) {
                    case 'ct_cli':
                        exec($exe.' -h 2>&1', $out, $return_var);

                        if($return_var == 139) {
                            $isbinary = false;
                            break;
                        }

                        for($i=0; $i<count($out); $i++) {
                            if(strpos($out[$i], 'KCP ENC') !== false) {
                                $search = true;
                                break;
                            }
                        }
                        break;
                    case 'pp_cli':
                        exec($exe.' -h 2>&1', $out, $return_var);

                        if($return_var == 139) {
                            $isbinary = false;
                            break;
                        }

                        for($i=0; $i<count($out); $i++) {
                            if(strpos($out[$i], 'CLIENT') !== false) {
                                $search = true;
                                break;
                            }
                        }
                        break;
                    case 'okname':
                        exec($exe.' D 2>&1', $out, $return_var);

                        if($return_var == 139) {
                            $isbinary = false;
                            break;
                        }

                        for($i=0; $i<count($out); $i++) {
                            if(strpos(strtolower($out[$i]), 'ret code') !== false) {
                                $search = true;
                                break;
                            }
                        }
                        break;
                }

                if(!$isbinary || !$search) {
                    $error = $exe.'\n파일을 바이너리 타입으로 다시 업로드하여 주십시오.';
                }
            }
        }
    }

    if($error) {
        $error = '<script>alert("'.$error.'");</script>';
    }

    return $error;
}

// 주소출력
function print_address($addr1, $addr2, $addr3, $addr4)
{
    $address = get_text(trim($addr1));
    $addr2   = get_text(trim($addr2));
    $addr3   = get_text(trim($addr3));

    if($addr4 == 'N') {
        if($addr2)
            $address .= ' '.$addr2;
    } else {
        if($addr2)
            $address .= ', '.$addr2;
    }

    if($addr3)
        $address .= ' '.$addr3;

    return $address;
}

// input vars 체크
function check_input_vars()
{
    $max_input_vars = ini_get('max_input_vars');

    if($max_input_vars) {
        $post_vars = count($_POST, COUNT_RECURSIVE);
        $get_vars = count($_GET, COUNT_RECURSIVE);
        $cookie_vars = count($_COOKIE, COUNT_RECURSIVE);

        $input_vars = $post_vars + $get_vars + $cookie_vars;

        if($input_vars > $max_input_vars) {
            alert('폼에서 전송된 변수의 개수가 max_input_vars 값보다 큽니다.\\n전송된 값중 일부는 유실되어 DB에 기록될 수 있습니다.\\n\\n문제를 해결하기 위해서는 서버 php.ini의 max_input_vars 값을 변경하십시오.');
        }
    }
}

// HTML 특수문자 변환 htmlspecialchars
function htmlspecialchars2($str)
{
    $trans = array("\"" => "&#034;", "'" => "&#039;", "<"=>"&#060;", ">"=>"&#062;");
    $str = strtr($str, $trans);
    return $str;
}

// date 형식 변환
function conv_date_format($format, $date, $add='')
{
    if($add)
        $timestamp = strtotime($add, strtotime($date));
    else
        $timestamp = strtotime($date);

    return date($format, $timestamp);
}

// 검색어 특수문자 제거
function get_search_string($stx)
{
    $stx_pattern = array();
    $stx_pattern[] = '#\.*/+#';
    $stx_pattern[] = '#\\\*#';
    $stx_pattern[] = '#\.{2,}#';
    $stx_pattern[] = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]+#';

    $stx_replace = array();
    $stx_replace[] = '';
    $stx_replace[] = '';
    $stx_replace[] = '.';
    $stx_replace[] = '';

    $stx = preg_replace($stx_pattern, $stx_replace, $stx);

    return $stx;
}

// XSS 관련 태그 제거
function clean_xss_tags($str)
{
    $str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);

    $str = str_replace(array('<script>','</script>','<noscript>','</noscript>'), '', $str);

    return $str;
}

// XSS 어트리뷰트 태그 제거
function clean_xss_attributes($str)
{
    $str = preg_replace('#(onabort|onactivate|onafterprint|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onblur|onbounce|oncellchange|onchange|onclick|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavaible|ondatasetchanged|ondatasetcomplete|ondblclick|ondeactivate|ondrag|ondragdrop|ondragend|ondragenter|ondragleave|ondragover|ondragstart|ondrop|onerror|onerrorupdate|onfilterupdate|onfinish|onfocus|onfocusin|onfocusout|onhelp|onkeydown|onkeypress|onkeyup|onlayoutcomplete|onload|onlosecapture|onmousedown|onmouseenter|onmouseleave|onmousemove|onmoveout|onmouseover|onmouseup|onmousewheel|onmove|onmoveend|onmovestart|onpaste|onpropertychange|onreadystatechange|onreset|onresize|onresizeend|onresizestart|onrowexit|onrowsdelete|onrowsinserted|onscroll|onselect|onselectionchange|onselectstart|onstart|onstop|onsubmit|onunload)\\s*=\\s*\\\?".*?"#is', '', $str);

    return $str;
}

// unescape nl 얻기
function conv_unescape_nl($str)
{
    $search = array('\\r', '\r', '\\n', '\n');
    $replace = array('', '', "\n", "\n");

    return str_replace($search, $replace, $str);
}

// 이메일 주소 추출
function get_email_address($email)
{
    preg_match("/[0-9a-z._-]+@[a-z0-9._-]{4,}/i", $email, $matches);

    return $matches[0];
}

// 파일명에서 특수문자 제거
function get_safe_filename($name)
{
    $pattern = '/["\'<>=#&!%\\\\(\)\*\+\?]/';
    $name = preg_replace($pattern, '', $name);

    return $name;
}

// 파일명 치환
function replace_filename($name)
{
    @session_start();
    $ss_id = session_id();
    $usec = get_microtime();
    $file_path = pathinfo($name);
    $ext = $file_path['extension'];
    $return_filename = sha1($ss_id.$_SERVER['REMOTE_ADDR'].$usec); 
    if( $ext )
        $return_filename .= '.'.$ext;

    return $return_filename;
}

// 아이코드 사용자정보
function get_icode_userinfo($id, $pass)
{
    $res = get_sock('http://www.icodekorea.com/res/userinfo.php?userid='.$id.'&userpw='.$pass, 2);
    $res = explode(';', $res);
    $userinfo = array(
        'code'      => $res[0], // 결과코드
        'coin'      => $res[1], // 고객 잔액 (충전제만 해당)
        'gpay'      => $res[2], // 고객의 건수 별 차감액 표시 (충전제만 해당)
        'payment'   => $res[3]  // 요금제 표시, A:충전제, C:정액제
    );

    return $userinfo;
}

// 문자열 암호화
function get_encrypt_string($str)
{
    if(defined('D9_STRING_ENCRYPT_FUNCTION') && D9_STRING_ENCRYPT_FUNCTION) {
        $encrypt = call_user_func(D9_STRING_ENCRYPT_FUNCTION, $str);
    } else {
        $encrypt = sql_password($str);
    }

    return $encrypt;
}

// 비밀번호 비교
function check_password($pass, $hash)
{
    $password = get_encrypt_string($pass);

    return ($password === $hash);
}

// 동일한 host url 인지
function check_url_host($url, $msg='', $return_url=D9_URL, $is_redirect=false)
{
    if(!$msg)
        $msg = 'url에 타 도메인을 지정할 수 없습니다.';

    $p = @parse_url($url);
    $host = preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']);
    $is_host_check = false;
    
    // url을 urlencode 를 2번이상하면 parse_url 에서 scheme와 host 값을 가져올수 없는 취약점이 존재함
    if ( $is_redirect && !isset($p['host']) && urldecode($url) != $url ){
        $i = 0;
        while($i <= 3){
            $url = urldecode($url);
            if( urldecode($url) == $url ) break;
            $i++;
        }

        if( urldecode($url) == $url ){
            $p = @parse_url($url);
        } else {
            $is_host_check = true;
        }
    }

    if(stripos($url, 'http:') !== false) {
        if(!isset($p['scheme']) || !$p['scheme'] || !isset($p['host']) || !$p['host'])
            alert('url 정보가 올바르지 않습니다.', $return_url);
    }

    //php 5.6.29 이하 버전에서는 parse_url 버그가 존재함
    //php 7.0.1 ~ 7.0.5 버전에서는 parse_url 버그가 존재함
    if ( $is_redirect && (isset($p['host']) && $p['host']) ) {
        $bool_ch = false;
        foreach( array('user','host') as $key) {
            if ( isset( $p[ $key ] ) && strpbrk( $p[ $key ], ':/?#@' ) ) {
                $bool_ch = true;
            }
        }
        if( $bool_ch ){
            $regex = '/https?\:\/\/'.$host.'/i';
            if( ! preg_match($regex, $url) ){
                $is_host_check = true;
            }
        }
    }

    if ((isset($p['scheme']) && $p['scheme']) || (isset($p['host']) && $p['host']) || $is_host_check) {
        //if ($p['host'].(isset($p['port']) ? ':'.$p['port'] : '') != $_SERVER['HTTP_HOST']) {
        if ( ($p['host'] != $host) || $is_host_check ) {
            echo '<script>'.PHP_EOL;
            echo 'alert("url에 타 도메인을 지정할 수 없습니다.");'.PHP_EOL;
            echo 'document.location.href = "'.$return_url.'";'.PHP_EOL;
            echo '</script>'.PHP_EOL;
            echo '<noscript>'.PHP_EOL;
            echo '<p>'.$msg.'</p>'.PHP_EOL;
            echo '<p><a href="'.$return_url.'">돌아가기</a></p>'.PHP_EOL;
            echo '</noscript>'.PHP_EOL;
            exit;
        }
    }
}

// QUERY STRING 에 포함된 XSS 태그 제거
function clean_query_string($query, $amp=true)
{
    $qstr = trim($query);

    parse_str($qstr, $out);

    if(is_array($out)) {
        $q = array();

        foreach($out as $key=>$val) {
            $key = strip_tags(trim($key));
            $val = trim($val);

            switch($key) {
                case 'wr_id':
                    $val = (int)preg_replace('/[^0-9]/', '', $val);
                    $q[$key] = $val;
                    break;
                case 'sca':
                    $val = clean_xss_tags($val);
                    $q[$key] = $val;
                    break;
                case 'sfl':
                    $val = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $val);
                    $q[$key] = $val;
                    break;
                case 'stx':
                    $val = get_search_string($val);
                    $q[$key] = $val;
                    break;
                case 'sst':
                    $val = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $val);
                    $q[$key] = $val;
                    break;
                case 'sod':
                    $val = preg_match("/^(asc|desc)$/i", $val) ? $val : '';
                    $q[$key] = $val;
                    break;
                case 'sop':
                    $val = preg_match("/^(or|and)$/i", $val) ? $val : '';
                    $q[$key] = $val;
                    break;
                case 'spt':
                    $val = (int)preg_replace('/[^0-9]/', '', $val);
                    $q[$key] = $val;
                    break;
                case 'page':
                    $val = (int)preg_replace('/[^0-9]/', '', $val);
                    $q[$key] = $val;
                    break;
                case 'w':
                    $val = substr($val, 0, 2);
                    $q[$key] = $val;
                    break;
                case 'bo_table':
                    $val = preg_replace('/[^a-z0-9_]/i', '', $val);
                    $val = substr($val, 0, 20);
                    $q[$key] = $val;
                    break;
                case 'gr_id':
                    $val = preg_replace('/[^a-z0-9_]/i', '', $val);
                    $q[$key] = $val;
                    break;
                default:
                    $val = clean_xss_tags($val);
                    $q[$key] = $val;
                    break;
            }
        }

        if($amp)
            $sep = '&amp;';
        else
            $sep ='&';

        $str = http_build_query($q, '', $sep);
    } else {
        $str = clean_xss_tags($qstr);
    }

    return $str;
}

// 발신번호 유효성 체크
function check_vaild_callback($callback){
   $_callback = preg_replace('/[^0-9]/','', $callback);

   /**
   * 1588 로시작하면 총8자리인데 7자리라 차단
   * 02 로시작하면 총9자리 또는 10자리인데 11자리라차단
   * 1366은 그자체가 원번호이기에 다른게 붙으면 차단
   * 030으로 시작하면 총10자리 또는 11자리인데 9자리라차단
   */

   if( substr($_callback,0,4) == '1588') if( strlen($_callback) != 8) return false;
   if( substr($_callback,0,2) == '02')   if( strlen($_callback) != 9  && strlen($_callback) != 10 ) return false;
   if( substr($_callback,0,3) == '030')  if( strlen($_callback) != 10 && strlen($_callback) != 11 ) return false;

   if( !preg_match("/^(02|0[3-6]\d|01(0|1|3|5|6|7|8|9)|070|080|007)\-?\d{3,4}\-?\d{4,5}$/",$_callback) &&
       !preg_match("/^(15|16|18)\d{2}\-?\d{4,5}$/",$_callback) ){
             return false;
   } else if( preg_match("/^(02|0[3-6]\d|01(0|1|3|5|6|7|8|9)|070|080)\-?0{3,4}\-?\d{4}$/",$_callback )) {
             return false;
   } else {
             return true;
   }
}

// 문자열 암복호화
class str_encrypt
{
    var $salt;
    var $lenght;

    function __construct($salt='')
    {
        if(!$salt)
            $this->salt = md5(preg_replace('/[^0-9A-Za-z]/', substr(MYSQL_USER, -1), $_SERVER['SERVER_SOFTWARE'].$_SERVER['DOCUMENT_ROOT']));
        else
            $this->salt = $salt;

        $this->length = strlen($this->salt);
    }

    function encrypt($str)
    {
        $length = strlen($str);
        $result = '';

        for($i=0; $i<$length; $i++) {
            $char    = substr($str, $i, 1);
            $keychar = substr($this->salt, ($i % $this->length) - 1, 1);
            $char    = chr(ord($char) + ord($keychar));
            $result .= $char;
        }

        return strtr(base64_encode($result) , '+/=', '._-');
    }

    function decrypt($str) {
        $result = '';
        $str    = base64_decode(strtr($str, '._-', '+/='));
        $length = strlen($str);

        for($i=0; $i<$length; $i++) {
            $char    = substr($str, $i, 1);
            $keychar = substr($this->salt, ($i % $this->length) - 1, 1);
            $char    = chr(ord($char) - ord($keychar));
            $result .= $char;
        }

        return $result;
    }
}

// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function get_write_token($bo_table)
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_write_'.$bo_table.'_token', $token);

    return $token;
}


// POST로 넘어온 토큰과 세션에 저장된 토큰 비교
function check_write_token($bo_table)
{
    if(!$bo_table)
        alert('올바른 방법으로 이용해 주십시오.', D9_URL);

    $token = get_session('ss_write_'.$bo_table.'_token');
    set_session('ss_write_'.$bo_table.'_token', '');

    if(!$token || !$_REQUEST['token'] || $token != $_REQUEST['token'])
        alert('올바른 방법으로 이용해 주십시오.', D9_URL);

    return true;
}

function is_use_email_certify(){
    global $config;

    if( $config['cf_use_email_certify'] && function_exists('social_is_login_check') ){
        if( $config['cf_social_login_use'] && (get_session('ss_social_provider') || social_is_login_check()) ){      //소셜 로그인을 사용한다면
            $tmp = (defined('D9_SOCIAL_CERTIFY_MAIL') && D9_SOCIAL_CERTIFY_MAIL) ? 1 : 0;
            return $tmp;
        }
    }

    return $config['cf_use_email_certify'];
}

function get_real_client_ip(){

    $real_ip = $_SERVER['REMOTE_ADDR'];

    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_SERVER['HTTP_X_FORWARDED_FOR']) ){
        $real_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return preg_replace('/[^0-9.]/', '', $real_ip);
}

function check_mail_bot($ip=''){

    //아이피를 체크하여 메일 크롤링을 방지합니다.
    $check_ips = array('211.249.40.');
    $bot_message = 'bot 으로 판단되어 중지합니다.';
    
    if($ip){
        foreach( $check_ips as $c_ip ){
            if( preg_match('/^'.preg_quote($c_ip).'/', $ip) ) {
                die($bot_message);
            }
        }
    }

    // user agent를 체크하여 메일 크롤링을 방지합니다.
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if ($user_agent === 'Carbon' || strpos($user_agent, 'BingPreview') !== false || strpos($user_agent, 'Slackbot') !== false) { 
        die($bot_message);
    } 
}

function get_call_func_cache($func, $args=array()){
    
    static $cache = array();

    $key = md5(serialize($args));

    if( isset($cache[$func]) && isset($cache[$func][$key]) ){
        return $cache[$func][$key];
    }

    $result = null;

    try{
        $cache[$func][$key] = $result = call_user_func_array($func, $args);
    } catch (Exception $e) {
        return null;
    }
    
    return $result;
}

// include 하는 경로에 data file 경로가 포함되어 있는지 체크합니다.
function is_include_path_check($path='', $is_input='')
{
    if( $path ){
        if ($is_input){

            if( stripos($path, 'php:') !== false || stripos($path, 'zlib:') !== false || stripos($path, 'bzip2:') !== false || stripos($path, 'zip:') !== false || stripos($path, 'data:') !== false || stripos($path, 'phar:') !== false ){
                return false;
            }

            try {
                // whether $path is unix or not
                $unipath = strlen($path)==0 || $path{0}!='/';
                $unc = substr($path,0,2)=='\\\\'?true:false;
                // attempts to detect if path is relative in which case, add cwd
                if(strpos($path,':') === false && $unipath && !$unc){
                    $path=getcwd().DIRECTORY_SEPARATOR.$path;
                    if($path{0}=='/'){
                        $unipath = false;
                    }
                }

                // resolve path parts (single dot, double dot and double delimiters)
                $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
                $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
                $absolutes = array();
                foreach ($parts as $part) {
                    if ('.'  == $part){
                        continue;
                    }
                    if ('..' == $part) {
                        array_pop($absolutes);
                    } else {
                        $absolutes[] = $part;
                    }
                }
                $path = implode(DIRECTORY_SEPARATOR, $absolutes);
                // resolve any symlinks
                // put initial separator that could have been lost
                $path = !$unipath ? '/'.$path : $path;
                $path = $unc ? '\\\\'.$path : $path;
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
                return false;
            }

            if( preg_match('/\/data\/(file|editor|qa|cache|member|member_image|session|tmp)\/[A-Za-z0-9_]{1,20}\//i', str_replace('\\', '/', $path)) ){
                return false;
            }
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        if($extension && preg_match('/(jpg|jpeg|png|gif|bmp|conf)$/i', $extension)) {
            return false;
        }
    }

    return true;
}

function option_array_checked($option, $arr=array()){
    $checked = '';

    if( !is_array($arr) ){
        $arr = explode(',', $arr);
    }

    if ( !empty($arr) && in_array($option, (array) $arr) ){
        $checked = 'checked="checked"';
    }

    return $checked;
}

// agency 목록 공통 쿼리 
function get_agency_search_list($end_num, $start_num, $search_name) {
	// 대행사 목록 쿼리
	$agency_search_list_query = "SELECT 
									idx,
									IFNULL(company_name, '-') AS company_name,
									IFNULL(manager_name, '-') AS manager_name,
									IFNULL(manager_phone, '-') AS manager_phone,
									DATE_FORMAT(register_date, '%y-%m-%d') AS register_date
								FROM member
								WHERE `level` = 5
								AND is_deleted = 'N'
								{$search_name}
								ORDER BY idx DESC
								LIMIT {$start_num}, {$end_num}";

	// 대행사 목록 결과값 
	$list = get_data($agency_search_list_query);	

	return $list;
}

// 기본 정보 공통 쿼리 
function matchingScheduleDlete($expo_idx) {
	$matching_schedule_delete_query = "DELETE FROM matching_schedule 
										WHERE expo_idx = {$_POST['expo_idx']}";
		//echo $matching_schedule_delete_query; exit;
	// 기존 일정 관련 데이터 삭제 쿼리 결과값 
	sql_query($matching_schedule_delete_query);
	
	return -1;
}

// 행사 기본 정보 날짜 관련 내용 넣기 
function insert_meeting_expo($matching_start_time, $matching_end_time, $expo_idx, $start_matching_day) {
	$matching_schedule_insert_query = "INSERT INTO matching_schedule SET
										expo_idx = {$expo_idx},
										start_time = '".$matching_start_time."',
										end_time = '".$matching_end_time."',
										matching_date = '".$start_matching_day."'";

	sql_query($matching_schedule_insert_query);

	return -1;
}

function upload_image($file_obj, $file_directory_idx, $thumb_yn='N', $wish_width=0, $wish_height=0){
	// -------------------------------------------- Date ----------------------------------------------- //
	$current_date = date("YmdHis");
	$mili_sec = explode(".",date("YmdHis").microtime(true))[1];
	$year_dir = date("Y");
	$month_dir = date("m");
	$day_dir = date("d");
	
	while(strlen("".$mili_sec) < 4){
		$mili_sec = "0".$mili_sec;
	}
	// --------------------------------------------- Date ----------------------------------------------- //

	// ------------------------------------------- Directory -------------------------------------------- //
	// 0:abstract = 논문, 1:lecture = 강연노트, 2:member = 회원, 3:sponsorship = 후원, 4:editor = 에디터, 5:admin = 관리자, 6:banner = 배너, 7:board = 게시판, 8:speaker = 라이브_강의_발표자, 9:conference_book = 라이브_Conference Program Book, 10:general = general information, 11:gallery = photo_gallery, 12:registration
	$file_directory_list = ["abstract", "lecture", "member", "sponsorship", "editor", "admin", "banner", "board", "speaker", "conference_book", "general", "gallery", "registration"];
	$file_directory = $file_directory_list[$file_directory_idx];

	$absolute_path = D9_UPLOAD_PATH."/img";
	$upload_path = $absolute_path;
	
	$upload_path .= "/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;
	$upload_db_path = "/main/upload/img/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;

	if (isset($file_directory_idx) && !empty($file_directory_idx)) {
		$upload_path = $absolute_path."/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;
		$upload_db_path = "/main/upload/img/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;
	}
	
	if(!is_dir($upload_path)){
		mkdir($upload_path, 0777, true);
	}
	// ------------------------------------------- Directory -------------------------------------------- //

	// --------------------------------------------- File ----------------------------------------------- //
	$file_name = $file_obj['name'];										// 파일명
	$file_size = $file_obj['size'];										// 크기
	$file_extension = end(explode(".",$file_name));						// 확장자
	$file_save_name = $current_date.$mili_sec.".".$file_extension;		// 저장된 파일명
	$file_tmp = $file_obj['tmp_name'];									// 파일경로(메모리 상의)
	// --------------------------------------------- File ----------------------------------------------- //

	$save_path = $upload_path."/".$file_save_name;
    $save_resize_path = $upload_path."/R".$file_save_name;

	move_uploaded_file($file_tmp, $upload_path."/".$file_save_name);

	if($thumb_yn == "Y" && preg_match("(jpg|png|gif)" , $file_extension) && $wish_height != 0){
		$wish_width = $wish_width ? $wish_width : 70;
		$wish_height = $wish_height ? $wish_height : 70;

		resize_image($save_path, $save_resize_path, $file_extension, $wish_width, $wish_height);
		$file_save_name = "R".$file_save_name;
	}

	$sql = "INSERT `file`
			SET
				original_name = '{$file_name}',
				save_name = '{$file_save_name}',
				path = '{$upload_db_path}',
				size = {$file_size},
				extension = '{$file_extension}',
				register_date = NOW()";

	sql_fetch($sql);

	$sql = "SELECT LAST_INSERT_ID() AS last_idx";
	$file_idx = sql_fetch($sql)['last_idx'];

	return (($file_directory_idx == 4) ? $upload_db_path."/".$file_save_name : $file_idx);
    return $file_idx;
}

function upload_file($file_obj, $file_directory_idx){
	// -------------------------------------------- Date ----------------------------------------------- //
	$current_date = date("YmdHis");
	$mili_sec = explode(".",date("YmdHis").microtime(true))[1];
	$year_dir = date("Y");
	$month_dir = date("m");
	$day_dir = date("d");
	
	while(strlen("".$mili_sec) < 4){
		$mili_sec = "0".$mili_sec;
	}
	// --------------------------------------------- Date ----------------------------------------------- //

	// ------------------------------------------- Directory -------------------------------------------- //
	// 0:abstract = 논문, 1:lecture = 강연노트, 2:member = 회원, 3:sponsorship = 후원, 4:admin = 관리자, 5:registration = 사전등록, 6:poster = Poster Abstract Submission
	$file_directory_list = ["abstract", "lecture", "member", "sponsorship", "admin", "registration", "poster"];
	$file_directory = $file_directory_list[$file_directory_idx];

	$absolute_path = D9_UPLOAD_PATH."/file";
	$upload_path = $absolute_path;
	
	$upload_path .= "/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;
	$upload_db_path = "/main/upload/file/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;

	if (isset($file_directory_idx) && !empty($file_directory_idx)) {
		$upload_path = $absolute_path."/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;
		$upload_db_path = "/main/upload/file/".$file_directory."/".$year_dir."/".$month_dir."/".$day_dir;
	}
	
	if(!is_dir($upload_path)){
		mkdir($upload_path, 0777, true);
	}
	// ------------------------------------------- Directory -------------------------------------------- //

	// --------------------------------------------- File ----------------------------------------------- //
	$file_name = $file_obj['name'];										// 파일명
	$file_size = $file_obj['size'];										// 크기
	$file_extension = end(explode(".",$file_name));						// 확장자
	$file_save_name = $current_date.$mili_sec.".".$file_extension;		// 저장된 파일명
	$file_tmp = $file_obj['tmp_name'];									// 파일경로(메모리 상의)
	// --------------------------------------------- File ----------------------------------------------- //

	$save_path = $upload_path."/".$file_save_name;
    $save_resize_path = $upload_path."/R".$file_save_name;

	move_uploaded_file($file_tmp, $upload_path."/".$file_save_name);

	if($thumb_yn == "Y" && preg_match("(jpg|png|gif)" , $file_extension) && $wish_height != 0){
		$wish_width = $wish_width ? $wish_width : 70;
		$wish_height = $wish_height ? $wish_height : 70;

		resize_image($save_path, $save_resize_path, $file_extension, $wish_width, $wish_height);
		$file_save_name = "R".$file_save_name;
	}

	$sql = "INSERT `file`
			SET
				original_name = '{$file_name}',
				save_name = '{$file_save_name}',
				path = '{$upload_db_path}',
				size = {$file_size},
				extension = '{$file_extension}',
				register_date = NOW()";

	sql_fetch($sql);

	$sql = "SELECT LAST_INSERT_ID() AS last_idx";
	$file_idx = sql_fetch($sql)['last_idx'];
	
	// return (($file_directory_idx == 2) ? $upload_db_path."/".$file_save_name : $file_idx);
    return $file_idx;
}

function resize_image($file, $newfile, $extension, $w, $h) {
   list($width, $height) = getimagesize($file);
   if($extension == "jpg")
      $src = imagecreatefromjpeg($file);
   else if($extension == "png")
      $src = imagecreatefrompng($file);
   else if($extension == "gif")
      $src = imagecreatefromgif($file);

   $dst = imagecreatetruecolor($w, $h);
   imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);

   if($extension == "jpg")
      imagejpeg($dst, $newfile);
   else if($extension == "png")
      imagepng($dst, $newfile);
   else if($extension == "gif")
      imagegif($dst, $newfile);
}

// 끝 날짜와 시작 날짜의 일수 차이 구하기 
function dateDifference($start_date, $end_date) {
	$dateDifference = abs(strtotime($end_date) - strtotime($start_date));

	$yeares = floor($dateDifference / (365 * 60 * 60 * 24));
	$month = floor(($dateDifference - $yeares * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
	$days = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $month * 30 * 60 * 60 * 24) / (60 * 60 * 24));
	
	return $days;
}

// 지정한 GET Parameter 변경하는 함수 
function replaceUrlParam($key_name, $new_value, $http_flag) {
	if ($http_flag) {
		$url = (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	} else {
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}

	$pattern = "/{$key_name}=[^&]+(.*)/";
	$replace_ment = "{$key_name}={$new_value}";

	if (preg_match($pattern, $url, $matches)) {
		$new_url = preg_replace($pattern, $replace_ment, $url);
	} else {
		$sep = COUNT($_GET) == 0 ? "?" : "&";
		$new_url = $url."{$sep}{$replace_ment}";
	}

	return $new_url;
}

//Check Mobile
function check_device(){
	$m_agent = array("iPhone","iPod","Android","Blackberry", "Opera Mini", "Windows ce", "Nokia", "sony","lgtelecom","skt","mobile","samsung","phone");
	$chk_mobile = false;
	for($i=0; $i<sizeof($m_agent); $i++){
		if(stripos( $_SERVER['HTTP_USER_AGENT'], $m_agent[$i] )){
			$chk_mobile = true;
			break;
		}
	}
	return $chk_mobile;
}

// 탑 메뉴에 있는 수정일 / 등록일 공통 쿼리 
function topNavigationList($expo_idx) {
	$modi_regist_date_query = "SELECT 
								ex.idx,
								IFNULL(DATE_FORMAT(ex.register_date, '%y-%m-%d'), '-') AS register_date,
								IFNULL(DATE_FORMAT(ex.modify_date, '%y-%m-%d'), '수정한 내역이 없습니다') AS modify_date
							FROM expo AS ex
							INNER JOIN (
								SELECT 
									idx
								FROM member
							) AS mb
							ON mb.idx = ex.member_idx
							WHERE ex.idx = {$expo_idx}";
	
	// 결과값
	$data = sql_fetch($modi_regist_date_query);

	return $data;
	exit;
}

//핸드폰 번호 변환
function phoneNumberTransform($nation_tel, $phone) {
	if($nation_tel != "" && $phone != "") {
			if(strpos($phone, "0") == 0) {			//연락처에 맨 앞자리가 0으로 시작할 경우 국가전화번호와 합치기 위해 앞부분 0 삭제 ex)010-1234-1234 => 10-1234-1234
				$phone = substr($phone, 1); 	
			}
			$phone = $nation_tel."-".$phone;
	}
	return $phone;
}

// 회원 정보 가져오는 함수
function get_member($user_id) {
	$get_member_info_query =	"
									SELECT
										*
									FROM member
									WHERE email = '{$user_id}'
                                    AND is_deleted = 'N'
								";
	return sql_fetch($get_member_info_query);
}

// 사전 등록 유무 체크 함수
function check_registration($user_idx) {
	$select_registration_query =	"
											SELECT
												idx
											FROM request_registration
											WHERE is_deleted = 'N'
                                            AND status IN (1,2)
											AND register = {$user_idx}
		
                                        ";
	return sql_fetch($select_registration_query)["idx"];
}

// 초록,강연노트 제출 제크 함수
function check_submission($user_idx, $type) {
    $type = $type == "abstract" ? 0 : 1;

    $check_submisssion_query =  "
                                    SELECT
                                        idx
                                    FROM request_abstract
                                    WHERE is_deleted = 'N'
                                    AND register = {$user_idx}
                                    AND `type` = {$type}
                                ";

    return sql_fetch($check_submisssion_query)["idx"];
}

?>