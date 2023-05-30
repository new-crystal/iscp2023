<?php
/**
 * *************************************************************************
 *
 * Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved
 *
 * ************************************************************************
 */
/**
 *
 * @file hello.php
 * @encoding UTF-8
 * 
 * 
 *         @date 2015年3月10日
 *        
 */

require_once '../sdk.php';

// SDK 생성
$sdk = new PushSDK();

$channelId = '5537919837622979077';

// message content.
$message = array (
    'aps' => array (
        // 메시지 내용
        'alert' => "hello, this message from baidu push service.", 
    ), 
);

// 메시지 유형을 알림 유형으로 설정하십시오.
$opts = array (
    'msg_type' => 1,        // iOS는 투명 전송을 지원하지 않으며 알림 메시지 인 msg_type : 1 만 설정할 수 있습니다.
    'deploy_status' => 1,   // iOS 애플리케이션 배포 상태 : 1 : 개발 상태, 2 : 프로덕션 상태, 지정되지 않은 경우 기본 설정은 프로덕션 상태입니다.
);

// 대상 장치에 메시지 보내기
$rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);

/*
	에러 코드	에러 메시지
	1	SDK 초기화 오류
	2	SDK 실행 오류
	3	SDK 매개 변수 누락
	4	잘못된 SDK 매개 변수
	5	http 상태는 정상이지만 REST에서 잘못된 json 문자열을 반환했습니다.
*/

// 반환 값을 결정하고, 전송에 실패하면 $ rs의 결과는 false이고 getError를 통해 오류 정보를 얻을 수있다.
if($rs === false){
   print_r($sdk->getLastErrorCode()); 
   print_r($sdk->getLastErrorMsg()); 
}else{
    // 메시지의 ID, 전송 시간 및 기타 관련 정보가 인쇄됩니다.
    print_r($rs);
}

echo "done!";
 