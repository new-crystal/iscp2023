<?php
	// Baidu Android Push 
	require_once (PUSH_SDK_HOME.'/sdk.php');		
	
	/** 
		@see : 안드로이드 푸시 함수 
		@Param : channel_id : 푸시를 보낼 회원의 채널 아이디, message : 메시지 전체적인 내용, 
				 option : 메시지 보낼 유형 ( 0: 투명 메시지, 1: 알림 ), push_type : 0 전체 푸시, 1 단일 푸시
	*/
	function sendBaiduAndroidPush($channel_id, $message, $option, $push_type) {				
		$key = "cRObqn4LPDrIMQs268hk93e3";	// https://push.baidu.com/에서 생성한 애플리케이션 api key
		$secretKey = "x6GYZV4mYrorPN4RQGn7sS1yoTBo5U2P";	// https://push.baidu.com/에서 생성한 애플리케이션 secreat key
		
		// SDK 생성
		$sdk = new PushSDK($key, $secretKey);		
			
		// 대상 장치에 메시지 보내기
		$result = (($push_type == 0) ? $sdk -> pushMsgToAll($message, $option) : $sdk -> pushMsgToSingleDevice($channel_id, $message, $option));				
		 
		if ($result === false) {									// 현재 보낸 푸시가 올바르지 않게 전송 됐을 경우 
			$push_result = array (
				"error_code" => $sdk -> getLastErrorCode(),
				"error_message" => $sdk -> getLastErrorMsg()
			);
		} else {													// 현재 보낸 푸시가 올바르게 전송 됐을 경우			
			$push_result = array (
				"success" => "success"
			);
		}
		
		// push_result 결과 값 json_encode
		echo json_encode($push_result);
		exit;
	}
?>