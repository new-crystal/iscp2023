<?php
extract($_POST);
extract($_GET);

require_once('./libs/INIStdPayUtil.php');
require_once('./libs/HttpClient.php');

$util = new INIStdPayUtil();

try {

	//#############################
	// 인증결과 파라미터 일괄 수신
	//#############################
	//		$var = $_REQUEST["data"];

	//#####################
	// 인증이 성공일 경우만
	//#####################
	if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

		//############################################
		// 1.전문 필드 값 설정(***가맹점 개발수정***)
		//############################################;

		$mid 			= $_REQUEST["mid"];     					// 가맹점 ID 수신 받은 데이터로 설정
		// 테스트 signKey
		//$signKey 		= "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; 		// 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
		// 운영서버 signKey
		$signKey 		= "eTA3bGZSeUdXTllTZ0RTYzdNWDJNZz09"; 		// 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
		$timestamp 		= $util->getTimestamp();   					// util에 의해서 자동생성
		$charset 		= "UTF-8";        							// 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
		$format 		= "JSON";        							// 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

		$authToken 		= $_REQUEST["authToken"];   				// 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
		$authUrl 		= $_REQUEST["authUrl"];    					// 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
		$netCancel 		= $_REQUEST["netCancelUrl"];   				// 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

		$mKey 			= hash("sha256", $signKey);					// 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

		//#####################
		// 2.signature 생성
		//#####################
		$signParam["authToken"] 	= $authToken;  	// 필수
		$signParam["timestamp"] 	= $timestamp;  	// 필수
		// signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
		$signature = $util->makeSignature($signParam);


		//#####################
		// 3.API 요청 전문 생성
		//#####################
		$authMap["mid"] 			= $mid;   		// 필수
		$authMap["authToken"] 		= $authToken; 	// 필수
		$authMap["signature"] 		= $signature; 	// 필수
		$authMap["timestamp"] 		= $timestamp; 	// 필수
		$authMap["charset"] 		= $charset;  	// default=UTF-8
		$authMap["format"] 			= $format;  	// default=XML

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

			/*************************  결제보안 추가 2016-05-18 START ****************************/
			$secureMap["mid"]		= $mid;							//mid
			$secureMap["tstamp"]	= $timestamp;					//timestemp
			$secureMap["MOID"]		= $resultMap["MOID"];			//MOID
			$secureMap["TotPrice"]	= $resultMap["TotPrice"];		//TotPrice

			// signature 데이터 생성 
			$secureSignature = $util->makeSignatureAuth($secureMap);
			/*************************  결제보안 추가 2016-05-18 END ****************************/

			if ((strcmp("0000", $resultMap["resultCode"]) == 0) && (strcmp($secureSignature, $resultMap["authSignature"]) == 0)) {	//결제보안 추가 2016-05-18
				/*****************************************************************************
				 * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.  
				   
					 [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
							처리중 에러 발생시 망취소를 한다.
				 ******************************************************************************/
			} else {
				//결제보안키가 다른 경우.
				if (strcmp($secureSignature, $resultMap["authSignature"]) != 0) {
					error_log("거래 성공 여부 : 실패 | 결과코드 : " . @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null") . " | 결과 내용 : 데이터 위변조 체크 실패");

					echo "거래 성공 여부 : 실패 | 결과코드 : " . @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null") . " | 결과 내용 : 데이터 위변조 체크 실패";
					exit;

					//망취소
					if (strcmp("0000", $resultMap["resultCode"]) == 0) {
						throw new Exception("데이터 위변조 체크 실패");
					}
				} else {
					error_log("거래 성공 여부 : 실패 | 결과코드 : " . @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null") . " | 결과 내용 : " . @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null"));
				}

				echo "<script>alert('" . @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null") . "'); window.location.replace('/main/registration_guidelines.php')</script>";
				exit;
			}

			//공통 부분만
			$tid				= @(in_array($resultMap["tid"], $resultMap) ? $resultMap["tid"] : "null");									// 거래번호
			$pay_method			= @(in_array($resultMap["payMethod"], $resultMap) ? $resultMap["payMethod"] : "null");						// 결제방법(지불수단)
			$result_code		= @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null");					// 결과코드
			$result_msg			= @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null");						// 결과내용
			$total_price		= @(in_array($resultMap["TotPrice"], $resultMap) ? $resultMap["TotPrice"] : "null");						// 결제완료금액
			$moid				= @(in_array($resultMap["MOID"], $resultMap) ? $resultMap["MOID"] : "null");								// 주문번호
			$appl_date			= @(in_array($resultMap["applDate"], $resultMap) ? $resultMap["applDate"] : "null");						// 승인날짜
			$appl_time			= @(in_array($resultMap["applTime"], $resultMap) ? $resultMap["applTime"] : "null");						// 승인시간

			if (isset($resultMap["payMethod"]) && strcmp("VBank", $resultMap["payMethod"]) == 0) { //가상계좌

				$vact_num			= @(in_array($resultMap["VACT_Num"], $resultMap) ? $resultMap["VACT_Num"] : "null");					// 계좌번호
				$vact_bank_code		= @(in_array($resultMap["VACT_BankCode"], $resultMap) ? $resultMap["VACT_BankCode"] : "null");			// 은행코드
				$vact_bank_name		= @(in_array($resultMap["vactBankName"], $resultMap) ? $resultMap["vactBankName"] : "null");			// 은행명
				$vact_name			= @(in_array($resultMap["VACT_Name"], $resultMap) ? $resultMap["VACT_Name"] : "null");					// 예금주 명
				$vact_input_name	= @(in_array($resultMap["VACT_InputName"], $resultMap) ? $resultMap["VACT_InputName"] : "null");		// 송금자 명
				$vact_date			= @(in_array($resultMap["VACT_Date"], $resultMap) ? $resultMap["VACT_Date"] : "null");					// 송금일자
				$vact_time			= @(in_array($resultMap["VACT_Time"], $resultMap) ? $resultMap["VACT_Time"] : "null");					// 송금시간

			} else if (isset($resultMap["payMethod"]) && strcmp("DirectBank", $resultMap["payMethod"]) == 0) { //실시간계좌이체

				$acct_bank_code		= @(in_array($resultMap["ACCT_BankCode"], $resultMap) ? $resultMap["ACCT_BankCode"] : "null");			// 은행코드
				$cshr_result_code	= @(in_array($resultMap["CSHR_ResultCode"], $resultMap) ? $resultMap["CSHR_ResultCode"] : "null");		// 현금영수증 발급결과코드
				$cshr_type			= @(in_array($resultMap["CSHR_Type"], $resultMap) ? $resultMap["CSHR_Type"] : "null");					// 현금영수증 발급결과코드 (0 - 소득공제용, 1 - 지출증빙용)

			} else if (isset($resultMap["payMethod"]) && strcmp("HPP", $resultMap["payMethod"]) == 0) { //휴대폰

				$hpp_corp			= @(in_array($resultMap["HPP_Corp"], $resultMap) ? $resultMap["HPP_Corp"] : "null");					// 통신사
				$pay_device			= @(in_array($resultMap["payDevice"], $resultMap) ? $resultMap["payDevice"] : "null");					// 결제장치 
				$hpp_num			= @(in_array($resultMap["HPP_Num"], $resultMap) ? $resultMap["HPP_Num"] : "null");						// 휴대폰번호

			} else if (isset($resultMap["payMethod"]) && strcmp("KWPY", $resultMap["payMethod"]) == 0) { //뱅크월렛 카카오

				$kwpy_cellphone		= @(in_array($resultMap["KWPY_CellPhone"], $resultMap) ? $resultMap["KWPY_CellPhone"] : "null");		// 휴대폰번호
				$kwpy_sales_amount	= @(in_array($resultMap["KWPY_SalesAmount"], $resultMap) ? $resultMap["KWPY_SalesAmount"] : "null");	// 거래금액
				$kwpy_amount		= @(in_array($resultMap["KWPY_Amount"], $resultMap) ? $resultMap["KWPY_Amount"] : "null");				// 공급가액
				$kwpy_tax			= @(in_array($resultMap["KWPY_Tax"], $resultMap) ? $resultMap["KWPY_Tax"] : "null");					// 부가세
				$kwpy_service_fee	= @(in_array($resultMap["KWPY_ServiceFee"], $resultMap) ? $resultMap["KWPY_ServiceFee"] : "null");		// 봉사료

			} else if (isset($resultMap["payMethod"]) && strcmp("Culture", $resultMap["payMethod"]) == 0) { //문화상품권

				$appl_date			= @(in_array($resultMap["applDate"], $resultMap) ? $resultMap["applDate"] : "null");					// 문화상품권 승인일자
				$appl_time			= @(in_array($resultMap["applTime"], $resultMap) ? $resultMap["applTime"] : "null");					// 문화상품권 승인시간
				$appl_num			= @(in_array($resultMap["applNum"], $resultMap) ? $resultMap["applNum"] : "null");						// 문화상품권 승인번호

			} else if (isset($resultMap["payMethod"]) && strcmp("DGCL", $resultMap["payMethod"]) == 0) { //게임문화상품권

				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>게임문화상품권승인금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GAMG_ApplPrice"], $resultMap) ? $resultMap["GAMG_ApplPrice"] : "null") . "원</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>사용한 카드수</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GAMG_Cnt"], $resultMap) ? $resultMap["GAMG_Cnt"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>사용한 카드번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GAMG_Num1"], $resultMap) ? $resultMap["GAMG_Num1"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>카드잔액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GAMG_Price1"], $resultMap) ? $resultMap["GAMG_Price1"] : "null") . "원</p></td></tr>";

				if (!strcmp("", $resultMap["GAMG_Num2"]) == 0) {

					echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>사용한 카드번호</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Num2"], $resultMap) ? $resultMap["GAMG_Num2"] : "null") . "</p></td></tr>
							<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>카드잔액</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Price2"], $resultMap) ? $resultMap["GAMG_Price2"] : "null") . "원</p></td></tr>";
				}
				if (!strcmp("", $resultMap["GAMG_Num3"]) == 0) {

					echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>사용한 카드번호</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Num3"], $resultMap) ? $resultMap["GAMG_Num3"] : "null") . "</p></td></tr>
							<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>카드잔액</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Price3"], $resultMap) ? $resultMap["GAMG_Price3"] : "null") . "원</p></td></tr>";
				}
				if (!strcmp("", $resultMap["GAMG_Num4"]) == 0) {

					echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>사용한 카드번호</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Num4"], $resultMap) ? $resultMap["GAMG_Num4"] : "null") . "</p></td></tr>
							<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>카드잔액</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Price4"], $resultMap) ? $resultMap["GAMG_Price4"] : "null") . "원</p></td></tr>";
				}
				if (!strcmp("", $resultMap["GAMG_Num5"]) == 0) {

					echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>사용한 카드번호</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Num5"], $resultMap) ? $resultMap["GAMG_Num5"] : "null") . "</p></td></tr>
							<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>카드잔액</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Price5"], $resultMap) ? $resultMap["GAMG_Price5"] : "null") . "원</p></td></tr>";
				}
				if (!strcmp("", $resultMap["GAMG_Num6"]) == 0) {

					echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>사용한 카드번호</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Num6"], $resultMap) ? $resultMap["GAMG_Num6"] : "null") . "</p></td></tr>
							<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>카드잔액</p></th>
							<td class='td02'><p>" . @(in_array($resultMap["GAMG_Price6"], $resultMap) ? $resultMap["GAMG_Price6"] : "null") . "원</p></td></tr>";
				}

				echo "<tr><th class='line' colspan='2'><p></p></th></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("OCBPoint", $resultMap["payMethod"]) == 0) { //오케이 캐쉬백
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>지불구분</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["PayOption"], $resultMap) ? $resultMap["PayOption"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>결제완료금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["applPrice"], $resultMap) ? $resultMap["applPrice"] : "null") . "원</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>OCB 카드번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["OCB_Num"], $resultMap) ? $resultMap["OCB_Num"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>적립 승인번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["OCB_SaveApplNum"], $resultMap) ? $resultMap["OCB_SaveApplNum"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>사용 승인번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["OCB_PayApplNum"], $resultMap) ? $resultMap["OCB_PayApplNum"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>OCB 지불 금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["OCB_PayPrice"], $resultMap) ? $resultMap["OCB_PayPrice"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>";
			} else if (isset($resultMap["payMethod"]) && (strcmp("GSPT", $resultMap["payMethod"]) == 0)) { //GSPoint
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>지불구분</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["PayOption"], $resultMap) ? $resultMap["PayOption"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>GS 포인트 승인금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GSPT_ApplPrice"], $resultMap) ? $resultMap["GSPT_ApplPrice"] : "null") . "원</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>GS 포인트 적립금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GSPT_SavePrice"], $resultMap) ? $resultMap["GSPT_SavePrice"] : "null") . "원</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>GS 포인트 지불금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["GSPT_PayPrice"], $resultMap) ? $resultMap["GSPT_PayPrice"] : "null") . "원</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("UPNT", $resultMap["payMethod"]) == 0) {  //U-포인트
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>U포인트 카드번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["UPoint_Num"], $resultMap) ? $resultMap["UPoint_Num"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>가용포인트</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["UPoint_usablePoint"], $resultMap) ? $resultMap["UPoint_usablePoint"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>포인트지불금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["UPoint_ApplPrice"], $resultMap) ? $resultMap["UPoint_ApplPrice"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("KWPY", $resultMap["payMethod"]) == 0) {  //뱅크월렛 카카오
				echo "<tr><th class='td01'><p>결제방법</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["payMethod"], $resultMap) ? $resultMap["payMethod"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>결과 코드</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>결과 내용</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>거래 번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["tid"], $resultMap) ? $resultMap["tid"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>주문 번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["MOID"], $resultMap) ? $resultMap["MOID"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>결제완료금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["price"], $resultMap) ? $resultMap["price"] : "null") . "원</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>사용일자</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["applDate"], $resultMap) ? $resultMap["applDate"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>사용시간</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["applTime"], $resultMap) ? $resultMap["applTime"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("YPAY", $resultMap["payMethod"]) == 0) { //엘로우 페이
				//별도 응답 필드 없음
			} else if (isset($resultMap["payMethod"]) && strcmp("TEEN", $resultMap["payMethod"]) == 0) { //틴캐시
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>틴캐시 승인번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["TEEN_ApplNum"], $resultMap) ? $resultMap["TEEN_ApplNum"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>틴캐시아이디</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["TEEN_UserID"], $resultMap) ? $resultMap["TEEN_UserID"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>틴캐시승인금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["TEEN_ApplPrice"], $resultMap) ? $resultMap["TEEN_ApplPrice"] : "null") . "원</p></td></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("Bookcash", $resultMap["payMethod"]) == 0) { //도서문화상품권
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>도서상품권 승인번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["BCSH_ApplNum"], $resultMap) ? $resultMap["BCSH_ApplNum"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>도서상품권 사용자ID</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["BCSH_UserID"], $resultMap) ? $resultMap["BCSH_UserID"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>도서상품권 승인금액</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["BCSH_ApplPrice"], $resultMap) ? $resultMap["BCSH_ApplPrice"] : "null") . "원</p></td></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("PhoneBill", $resultMap["payMethod"]) == 0) { //폰빌전화결제
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>승인전화번호</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["PHNB_Num"], $resultMap) ? $resultMap["PHNB_Num"] : "null") . "</p></td></tr>
						<tr><th class='line' colspan='2'><p></p></th></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("Bill", $resultMap["payMethod"]) == 0) { //빌링결제
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
						<tr><th class='td01'><p>빌링키</p></th>
						<td class='td02'><p>" . @(in_array($resultMap["CARD_BillKey"], $resultMap) ? $resultMap["CARD_BillKey"] : "null") . "</p></td></tr>";
			} else if (isset($resultMap["payMethod"]) && strcmp("Auth", $resultMap["payMethod"]) == 0) { //빌링결제
				echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							<tr><th class='td01'><p>빌링키</p></th>";
				if (isset($resultMap["payMethodDetail"]) && strcmp("BILL_CARD", $resultMap["payMethodDetail"]) == 0) {
					echo "<td class='td02'><p>" . @(in_array($resultMap["CARD_BillKey"], $resultMap) ? $resultMap["CARD_BillKey"] : "null") . "</p></td></tr>";
				} else  if (isset($resultMap["payMethodDetail"]) && strcmp("BILL_HPP", $resultMap["payMethodDetail"]) == 0) {
					echo "<td class='td02'><p>" . @(in_array($resultMap["HPP_BillKey"], $resultMap) ? $resultMap["HPP_BillKey"] : "null") . "</p></td></tr>
								<tr><th class='line' colspan='2'><p></p></th></tr>
								<tr><th class='line' colspan='2'><p></p></th></tr>
								<tr><th class='td01'><p>통신사</p></th>
								<td class='td02'><p>" . @(in_array($resultMap["HPP_Corp"], $resultMap) ? $resultMap["HPP_Corp"] : "null") . "</p></td></tr>
								<tr><th class='line' colspan='2'><p></p></th></tr>
								<tr><th class='td01'><p>결제장치</p></th>
								<td class='td02'><p>" . @(in_array($resultMap["payDevice"], $resultMap) ? $resultMap["payDevice"] : "null") . "</p></td></tr>
								<tr><th class='line' colspan='2'><p></p></th></tr>
								<tr><th class='td01'><p>휴대폰번호</p></th>
								<td class='td02'><p>" . @(in_array($resultMap["HPP_Num"], $resultMap) ? $resultMap["HPP_Num"] : "null") . "</p></td></tr>
								<tr><th class='line' colspan='2'><p></p></th></tr>
								<tr><th class='td01'><p>상품명</p></th>
								<td class='td02'><p>" . @(in_array($resultMap["goodName"], $resultMap) ? $resultMap["goodName"] : "null") . "</p></td></tr>";
				}
			} else { //카드

				if (isset($resultMap["EventCode"]) && !is_null($resultMap["EventCode"])) {
					$event_code = @(in_array($resultMap["EventCode"], $resultMap) ? $resultMap["EventCode"] : "null");							// 이벤트 코드
				}

				$card_num			= @(in_array($resultMap["CARD_Num"], $resultMap) ? $resultMap["CARD_Num"] : "null");						// 카드번호
				$card_quota			= @(in_array($resultMap["CARD_Quota"], $resultMap) ? $resultMap["CARD_Quota"] : "null");					// 할부기간
				$card_quota_type	= "";																										// 할부유형(1:무이자, 2:유이자)
				$use_point			= 0;																										// 포인트 사용여부(0:미사용, 1:사용)

				if (isset($resultMap["EventCode"]) && isset($resultMap["CARD_Interest"]) && (strcmp("1", $resultMap["CARD_Interest"]) == 0 || strcmp("1", $resultMap["EventCode"]) == 0)) {

					$card_quota_type = 1;
				} else if (isset($resultMap["CARD_Interest"]) && !strcmp("1", $resultMap["CARD_Interest"]) == 0) {

					$card_quota_type = 2;
				}

				if (isset($resultMap["point"]) && strcmp("1", $resultMap["point"]) == 0) {

					$use_point = 1;
				}

				$card_code			= @(in_array($resultMap["CARD_Code"], $resultMap) ? $resultMap["CARD_Code"] : "null");						// 카드종류
				$card_bank_code		= @(in_array($resultMap["CARD_BankCode"], $resultMap) ? $resultMap["CARD_BankCode"] : "null");				// 카트 발급사
				$card_prtc_code		= @(in_array($resultMap["CARD_PRTC_CODE"], $resultMap) ? $resultMap["CARD_PRTC_CODE"] : "null");			// 부분취소 가능여부
				$card_check_flag	= @(in_array($resultMap["CARD_CheckFlag"], $resultMap) ? $resultMap["CARD_CheckFlag"] : "null");			// 체크카드 여부

				if (isset($resultMap["OCB_Num"]) && !is_null($resultMap["OCB_Num"]) && !empty($resultMap["OCB_Num"])) {

					$ocb_num			= @(in_array($resultMap["OCB_Num"], $resultMap) ? $resultMap["OCB_Num"] : "null");						// OK CASHBAG 카드번호
					$ocb_save_appl_num	= @(in_array($resultMap["OCB_SaveApplNum"], $resultMap) ? $resultMap["OCB_SaveApplNum"] : "null");		// OK CASHBAG 적립 승인번호
					$ocb_pay_price		= @(in_array($resultMap["OCB_PayPrice"], $resultMap) ? $resultMap["OCB_PayPrice"] : "null");			// OK CASHBAG 포인트지불금액

				}

				if (isset($resultMap["GSPT_Num"]) && !is_null($resultMap["GSPT_Num"]) && !empty($resultMap["GSPT_Num"])) {

					$gspt_num			= @(in_array($resultMap["GSPT_Num"], $resultMap) ? $resultMap["GSPT_Num"] : "null");					// GS&Point 카드번호
					$gspt_remains		= @(in_array($resultMap["GSPT_Remains"], $resultMap) ? $resultMap["GSPT_Remains"] : "null");			// GS&Point 잔여한도
					$gspt_appl_price	= @(in_array($resultMap["GSPT_ApplPrice"], $resultMap) ? $resultMap["GSPT_ApplPrice"] : "null");		// GS&Point 승인금액

				}

				if (isset($resultMap["UNPT_CardNum"]) && !is_null($resultMap["UNPT_CardNum"]) && !empty($resultMap["UNPT_CardNum"])) {

					$upnt_card_num		= @(in_array($resultMap["UNPT_CardNum"], $resultMap) ? $resultMap["UNPT_CardNum"] : "null");			// U-Point 카드번호
					$upnt_usable_point	= @(in_array($resultMap["UPNT_UsablePoint"], $resultMap) ? $resultMap["UPNT_UsablePoint"] : "null");	// 가용포인트
					$upnt_pay_price		= @(in_array($resultMap["UPNT_PayPrice"], $resultMap) ? $resultMap["UPNT_PayPrice"] : "null");			// 포인트 지불금액
				}
			}

			//기존 주문서 정보 가져오기
			$payment_date = date("Y-m-d H:i:s", strtotime($appl_date . $appl_time));

			// 수신결과를 파싱후 resultCode가 "0000"이면 승인성공 이외 실패
			// 가맹점에서 스스로 파싱후 내부 DB 처리 후 화면에 결과 표시
			// payViewType을 popup으로 해서 결제를 하셨을 경우
			// 내부처리후 스크립트를 이용해 opener의 화면 전환처리를 하세요
			//throw new Exception("강제 Exception");
		} catch (Exception $e) {
			// $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
			//####################################
			// 실패시 처리(***가맹점 개발수정***)
			//####################################
			//---- db 저장 실패시 등 예외처리----//
			error_log("데이터 베이스 저장오류 : (" . $e->getCode() . ") => " . $e->getMessage());

			//#####################
			// 망취소 API
			//#####################

			$netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)

			if ($httpUtil->processHTTP($netCancel, $authMap)) {
				$netcancelResultString = $httpUtil->body;
			} else {
				echo "Http Connect Error\n";
				echo $httpUtil->errormsg;

				throw new Exception("Http Connect Error");
			}

			/*##XML output##*/
			//$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
			//$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);

			// 취소 결과 확인
			error_log("망취소 API 결과 : " . $netcancelResultString . "");
			echo "<script>alert('만료된 결제 요청입니다.'); window.location.replace('/main/registration_guidelines.php')</script>";
			exit;
		}
	} else {

		//#############
		// 모바일
		//#############

		if ($_REQUEST["P_STATUS"] === "00") {     // 인증이 P_STATUS===00 일 경우만 승인 요청

			$p_tid = $_REQUEST["P_TID"];
			$id_merchant = substr($p_tid, '10', '10');     // P_TID 내 MID 구분
			$data = array(
				'P_MID' => $id_merchant,			// P_MID
				'P_TID' => $p_tid                   // P_TID
			);

			// curl 통신 시작 
			$ch = curl_init();                                                             //curl 초기화
			curl_setopt($ch, CURLOPT_URL, $_REQUEST["P_REQ_URL"]);							//URL 지정하기
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);									//요청 결과를 문자열로 반환 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);									//connection timeout 10초 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);									//원격 서버의 인증서가 유효한지 검사 안함
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));					//POST 로 $data 를 보냄
			curl_setopt($ch, CURLOPT_POST, 1);												//true시 post 전송 

			$response = curl_exec($ch);
			curl_close($ch);

			$result = @explode("&", $response);

			$result_param = [];
			foreach ($result as $r) {
				if (strpos($r, "=")) {
					$param = explode("=", $r);
					$result_param[$param[0]] = $param[1];
				} else if ($r != "") {
					$result_param[$r] = "";
				}
			}

			if ($result_param["P_STATUS"] != "00") {
				error_log("모바일 승인요청 실패 : " . $response . "");
				echo "<script>alert('" . $result_param["P_RMESG1"] . "'); window.location.replace('/main/registration_guidelines.php')</script>";
				exit;
			}

			$tid = $result_param["P_TID"];
			$moid = $result_param["P_OID"];
			$method = $result_param["P_TYPE"];
			$total_price = $result_param["P_AMT"];
			$payment_date = $result_param["P_AUTH_DT"];
			$payment_date = date("Y-m-d H:i:s", strtotime($payment_date));
		} else if ($_REQUEST["P_STATUS"] != "") {		// 모바일 결제후 성공이지 않은 경우
			error_log("모바일 결제실패 : " . $response . "");
			echo "<script>alert('" . $result_param["P_RMESG1"] . "'); window.location.replace('/main/registration_guidelines.php')</script>";
			exit;
		} else {

			//#############
			// 인증 실패시
			//#############

			error_log("인증실패 : " . $_REQUEST . "");
			echo "<script>alert('유효하지 않은 결제요청입니다.'); window.location.replace('/main/registration_guidelines.php')</script>";
			exit;
		}
	}
} catch (Exception $e) {
	error_log("결제 페이지 오류 : (" . $e->getCode() . ") => " . $e->getMessage());
	echo "<script>alert('관리자에게 문의해주세요.'); window.location.replace('/main/registration_guidelines.php')</script>";
	exit;
}
?>

<input type="hidden" name="tid" value="<?= $tid ?>" />
<input type="hidden" name="moid" value="<?= $moid ?>" />
<input type="hidden" name="method" value="<?= $pay_method ?>" />
<input type="hidden" name="t_price" value="<?= $total_price ?>" />
<input type="hidden" name="payment_date" value="<?= $payment_date ?>" />

<script src="../../js/jquery-3.6.0.min.js"></script>
<!-- 230620 기존 icomes 소스인 부분이여서
결제 db insert 및 gmail 메일 발송되는 부분이여서 주석 하였습니다
필요하신 경우 아래 주석 해제 후 데이터 가공하여 사용하시면 됩니다 -->

<script>
	var tid = $("input[name=tid]").val();
	var moid = $("input[name=moid]").val();
	var method = $("input[name=method]").val();
	var price = $("input[name=t_price]").val();
	var date = $("input[name=payment_date]").val();

	$.ajax({
		url: "../../ajax/client/ajax_payment.php",
		type: "POST",
		data: {
			flag: "payment_inicis",
			type: 0,
			moid: moid,
			tid: tid,
			method: method,
			price: price,
			payment_date: date
		},
		dataType: "JSON",
		success: function(res) {
			if (res.code == 200) {
				payment_ajax(res.name, res.email, res.data, res.flag);
			}
		},
		complete: function() {
			window.location.replace("../../registration3.php");
		}

	});

	function payment_ajax(name, eamil, data, flag) {

		$.ajax({
			url: "../../ajax/client/ajax_gmail.php",
			type: "POST",
			data: {
				flag: "payment",
				name: name,
				email: eamil,
				data: data
			},
			dataType: "JSON",
			success: function(res) {

			},
			complete: function() {
				window.location.replace("../../registration3.php");
			}
		});
	}
</script>