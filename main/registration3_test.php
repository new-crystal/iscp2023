<?php include_once('./include/head.php');?>
<?php include_once('./include/header.php');?>

<?php
require_once('./plugin/KG_INICIS/libs/INIStdPayUtil.php');
require_once('./plugin/KG_INICIS/libs/HttpClient.php');
require_once('./plugin/KG_INICIS/libs/properties.php');

$util = new INIStdPayUtil();
$prop = new properties();

try {

    //#############################
    // 인증결과 파라미터 수신
    //#############################

    if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

        //############################################
        // 1.전문 필드 값 설정(***가맹점 개발수정***)
        //############################################

        $mid            = $_REQUEST["mid"];
        $signKey 	    = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS";
        $timestamp      = $util->getTimestamp();
        $charset        = "UTF-8";
        $format         = "JSON";
        $authToken      = $_REQUEST["authToken"];
        $authUrl        = $_REQUEST["authUrl"];
        $netCancel      = $_REQUEST["netCancelUrl"];
        $merchantData   = $_REQUEST["merchantData"];

        //##########################################################################
        // 승인요청 API url (authUrl) 리스트 는 properties 에 세팅하여 사용합니다.
        // idc_name 으로 수신 받은 센터 네임을 properties 에서 include 하여 승인요청하시면 됩니다.
        //##########################################################################
        $idc_name 	= $_REQUEST["idc_name"];
        $authUrl    = $prop->getAuthUrl($idc_name);

        if (strcmp($authUrl, $_REQUEST["authUrl"]) == 0) {

            //#####################
            // 2.signature 생성
            //#####################
            $signParam["authToken"] = $authToken;   // 필수
            $signParam["timestamp"] = $timestamp;   // 필수
            // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
            $signature = $util->makeSignature($signParam);

            $veriParam["authToken"] = $authToken;   // 필수
            $veriParam["signKey"]   = $signKey;     // 필수
            $veriParam["timestamp"] = $timestamp;   // 필수
            // verification 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
            $verification = $util->makeSignature($veriParam);


            //#####################
            // 3.API 요청 전문 생성
            //#####################
            $authMap["mid"]          = $mid;            // 필수
            $authMap["authToken"]    = $authToken;      // 필수
            $authMap["signature"]    = $signature;      // 필수
            $authMap["verification"] = $verification;   // 필수
            $authMap["timestamp"]    = $timestamp;      // 필수
            $authMap["charset"]      = $charset;        // default=UTF-8
            $authMap["format"]       = $format;         // default=XML

            try {

                $httpUtil = new HttpClient();

                //#####################
                // 4.API 통신 시작
                //#####################

                $authResultString = "";
                if ($httpUtil->processHTTP($authUrl, $authMap)) {
                    $authResultString = $httpUtil->body;

                } else {
                    echo "Http Connect Error\n";
                    echo $httpUtil->errormsg;

                    throw new Exception("Http Connect Error");
                }

                //############################################################
                //5.API 통신결과 처리(***가맹점 개발수정***)
                //############################################################

                $resultMap = json_decode($authResultString, true);


            } catch (Exception $e) {
                //    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                //####################################
                // 실패시 처리(***가맹점 개발수정***)
                //####################################
                //---- db 저장 실패시 등 예외처리----//
                $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                echo $s;

                //#####################
                // 망취소 API
                //#####################

                $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
                $netCancel    = $prop->getNetCancel($idc_name);

                if (strcmp($netCancel, $_REQUEST["netCancelUrl"]) == 0) {

                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    echo "<br/>## 망취소 API 결과 ##<br/>";

                    /*##XML output##*/
                    //$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
                    //$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);

                    // 취소 결과 확인
                    echo "<p>". $netcancelResultString . "</p>";
                }
            }

        } else {
            echo "authUrl check Fail\n";
        }

    } else {

    }

} catch (Exception $e) {
    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
    echo $s;
}
?>


    <!-- 22.04.15 기존 마크업
    <section class="submit_application sub_page">
        <div class="container">
            <div class="sub_banner">
                <h5>Home</h5>
                <h5>Registration</h5>
                <h1>Online Registration</h1>
            </div>
            <div class="section section1">
                <div class="completed_box">
                    <img src="./img/icons/post_complete.png">
                </div>
            </div>
        </div>
    </section> -->

    <!-- 22.04.15 수정 마크업 -->
    <section class="container submit_application payment">
        <div class="sub_background_box">
            <div class="sub_inner">
                <div>
                    <h2>Online Registration</h2>
                    <ul class="clearfix">
                        <li>Home</li>
                        <li>Registration</li>
                        <li>Online Registration</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner section section1">
            <div class="completed_box">
                <img src="./img/icons/post_complete.png">
            </div>
        </div>
    </section>

<?php include_once('./include/footer.php');?>