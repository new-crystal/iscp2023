<?php
	extract($_POST);
	extract($_GET);

	require_once('./libs/INIStdPayUtil.php');
	require_once('./libs/HttpClient.php');
    require_once('./libs/properties.php');

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
			// 테스트 signKey
			$signKey 		= "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; 		// 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
			// 운영서버 signKey
			//$signKey 		= "eTA3bGZSeUdXTllTZ0RTYzdNWDJNZz09"; 		// 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
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

					//공통 부분만
					$tid				= @(in_array($resultMap["tid"] , $resultMap) ? $resultMap["tid"] : "null");									// 거래번호
					$pay_method			= @(in_array($resultMap["payMethod"] , $resultMap) ? $resultMap["payMethod"] : "null");						// 결제방법(지불수단)
					$result_code		= @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : "null");					// 결과코드
					$result_msg			= @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : "null");						// 결과내용
					$total_price		= @(in_array($resultMap["TotPrice"] , $resultMap) ? $resultMap["TotPrice"] : "null");						// 결제완료금액
					$moid				= @(in_array($resultMap["MOID"] , $resultMap) ? $resultMap["MOID"] : "null");								// 주문번호
					$appl_date			= @(in_array($resultMap["applDate"] , $resultMap) ? $resultMap["applDate"] : "null");						// 승인날짜
					$appl_time			= @(in_array($resultMap["applTime"] , $resultMap) ? $resultMap["applTime"] : "null");						// 승인시간

					//기존 주문서 정보 가져오기
					$payment_date = date("Y-m-d H:i:s", strtotime($appl_date.$appl_time));

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

<input type="hidden" name="tid"				value="<?=$tid?>"/>
<input type="hidden" name="moid"			value="<?=$moid?>"/>
<input type="hidden" name="method"			value="<?=$pay_method?>"/>
<input type="hidden" name="t_price"			value="<?=$total_price?>"/>
<input type="hidden" name="payment_date"	value="<?=$payment_date?>"/>

<script src="../../js/jquery-3.6.0.min.js"></script>
<!-- 230620 기존 icomes 소스인 부분이여서
gmail 메일 발송되는 부분이여서 주석 하였습니다
필요하신 경우 아래 주석 해제 후 데이터 가공하여 사용하시면 됩니다 -->
<script>
	var tid		= $("input[name=tid]").val();
	var moid	= $("input[name=moid]").val();
	var method	= $("input[name=method]").val();
	var price	= $("input[name=t_price]").val();
	var date	= $("input[name=payment_date]").val();

	$.ajax({
		url:"../../ajax/client/ajax_payment.php",
		type:"POST",
		data:{
			flag : "payment_inicis",
			type : 0,
			moid : moid,
			tid : tid,
			method : method,
			price : price,
			payment_date : date
		},
		dataType:"JSON",
		success : function(res){
			if(res.code == 200) {
			/*
				$.ajax({
					url : "../../ajax/client/ajax_gmail.php",
					type : "POST",
					data : {
						flag : "payment",
						name : res.name,
						email : res.email,
						data : res.data
					},
					dataType:"JSON"
				});
			*/
			}			
		},
		complete:function(){
			window.location.replace("../../registration3.php");
		}
	});
</script>
