<?php
	require_once('./plugin/KG_INICIS/libs/INIStdPayUtil.php');
	$SignatureUtil = new INIStdPayUtil();
	/*
	  //*** 위변조 방지체크를 signature 생성 ***

	  oid, price, timestamp 3개의 키와 값을

	  key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값

	  ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004


	 * key기준 알파벳 정렬

	 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그대로 사용하여야함
	 */

	/**
	* 23.06.07 HUBDNC_LSH
	* mid = KG 이니시스 로그인 ID (운영서버 이전 시 운영서버 값으로 변경 필요)
	* signKey = 부가정보 > signKey 발급완료 (운영서버 이전 시 운영서버 값으로 변경 필요)
	*/
	//############################################
	// 1.전문 필드 값 설정(***가맹점 개발수정***)
	//############################################
	// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
	$mid 			= "INIpayTest";  								// 상점아이디(test값)
	//$mid			= "iscpkrcvph";									// 상점아이디(운영서버 값)

	$signKey 		= "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; 			// 웹 결제 signkey(test값)
	//$signKey		= "eTA3bGZSeUdXTllTZ0RTYzdNWDJNZz09";			// 웹 결제 signkey(운영서버 값)
	$timestamp 		= $SignatureUtil->getTimestamp();   			// util에 의해서 자동생성

	$use_chkfake	= "Y";											// PC결제 보안강화 사용 ["Y" 고정]
	//$orderNumber 	= $mid . "_" . $timestamp; 						// 가맹점 주문번호(가맹점에서 직접 설정)
	$orderNumber = $order_code;
	$price 		= "1000";        									// 상품가격(특수기호 제외, 가맹점에서 직접 설정)

	if($order_code == ""){
		die("정보가 유효하지 않은 건입니다. 관리자에게 문의해주세요.");
	}

	if($price == ""){
		die("가격정보가 없는 유효하지 않은 건입니다. 관리자에게 문의해주세요.");
	}

	//###################################
	// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
	//###################################
	$mKey 	= $SignatureUtil->makeHash($signKey, "sha256");

	$params = array(
		"oid" => $orderNumber,
		"price" => $price,
		"timestamp" => $timestamp
	);
	$sign   = $SignatureUtil->makeSignature($params);

	$params = array(
		"oid" => $orderNumber,
		"price" => $price,
		"signKey" => $signKey,
		"timestamp" => $timestamp
	);

	$sign2   = $SignatureUtil->makeSignature($params);
?>