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

require_once (PUSH_SDK_HOME.'/sdk.php');

$key = "cRObqn4LPDrIMQs268hk93e3";
$secretKey = "x6GYZV4mYrorPN4RQGn7sS1yoTBo5U2P";

// SDK 생성
$sdk = new PushSDK($key,$secretKey);

//$channelId = '3939059166251793965';
$channelId = '3935400725434025681';

// message content.
$message = array (
    // 메시지 제목
    'title' => '你好!',
    // 메시지 내용
    'description' => "您好，来自“百度”推送服务的消息。",
	// 메시지 유형	[ 0 : onNotificationClicked, 1 : open_url, 2 : pkg_content ]
	'open_type' => 2,
	// 메시지 pkg_content
	//'pkg_content' => '#Intent; component = com.samsung.itfit / .ui.message.uas.B2bMsgActivity; end'
	'custom_content' => array (
		'url' => 'https://www.naver.com',
		'name' => 'honggildong'
	)
	//'url' => 'http://18.163.185.197/product_detail.php?idx=102'
);

// 메시지 유형을 알림 유형으로 설정하십시오. (0: 투명한 메시지, 1: 알림)
$opts = array (
    'msg_type' => 1
);

$push_type = 1;

// 대상 장치에 메시지 보내기
//$rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
$rs = (($push_type == 0) ? $sdk -> pushMsgToAll($message, $opts) : $sdk -> pushMsgToSingleDevice($channelId, $message, $opts));
//$rs = $sdk -> pushMsgToAll($message, $opts);

if ($rs !== false) {
	echo json_encode($rs);
	echo "\n";
	$message_id = $rs['msg_id'];
	
	$info = $sdk -> queryMsgStatus($message_id);

	echo json_encode($info);
}

// 조회
//$id = "892864270";		// RequestID로 조회가능(앱에 채널아이디와 함께 등록된)
//$rsa = $sdk -> queryMsgStatus($id);

//// 반환 값을 결정하고, 전송에 실패하면 $ rs의 결과는 false이고 getError를 통해 오류 정보를 얻을 수있다.

//if($rsa === false){
   //print_r($sdk->getLastErrorCode()); 
   //print_r($sdk->getLastErrorMsg()); 
//}else{
    //// 메시지의 ID, 전송 시간 및 기타 관련 정보가 출력됩니다.
    //print_r($rsa);
//}

///*
	//에러 코드	에러 메시지
	//1	SDK 초기화 오류
	//2	SDK 실행 오류
	//3	SDK 매개 변수 누락
	//4	잘못된 SDK 매개 변수
	//5	http 상태는 정상이지만 REST에서 잘못된 json 문자열을 반환했습니다.
//*/

//$rsq = $sdk->queryTags();

//if($rsq ===false){
	//echo $sdk -> getLastErrorMsg();
	//echo "/n";
//}else if($rsq['total_num'] > 0){
	//foreach($rs['result'] as $item){
		//extract($item);
		//echo "tid：$tid; tagname:$tag，createTime:$create_time";
	//}
//}

echo "done!";