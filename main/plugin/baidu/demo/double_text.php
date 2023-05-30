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
 * @file double_text.php
 * @encoding UTF-8
 * 
 * 
 *         @date 2019年5月9日
 *        
 */

require_once '../sdk.php';

// 创建SDK对象.
$sdk = new PushSDK();

//$channelId = '4445784821004007812';
$channelId = '4414228985319982973';

// message 此处是必传字段，双文本时候msgtype 和 extra_msg_type 其中一个为1，则对应的消息体为上通知栏的消息，另外一个是透传消息.
$message = array (
    // 消息的标题.
    'title' => '普通文本消息',
    // 消息内容 
    'description' => "普通文本消息体" 
);
// 自定义消息体
$costom_content = array (
    'my_key' => 'my_value',
    'my_key1' => 'my_value1'    
);
$json_costom_content = json_encode($costom_content);
// 可选参数 双文本extra_message
$extra_message = array (
    // 消息的标题.
    'title' => '双文本消息',
    // 消息内容 
    //'description' => "这里是双文本消息测试这里是双文本消息测试这里是双文本消息测试这里是双文本消息测试这里是双文本消息测试",
    'description' => "这里是双文本消息测试88",
    'notify_style_type' => 2,
    "notification_builder_id" => 0,
    "notification_basic_style" => 7,
    "open_type" => 2,
    "url" => "http://www.baidu.com",
    "pkg_content" => "baidupush://bdpush/hwnotify?bdpush_hwmsgbody={}#Intent;action=android.intent.action.VIEW;launchFlags=0x10000000;package=com.baidu.push.qa;end",
    //"pkg_content" => "intent:#Intent;launchFlags=0x10008000;component=com.baidu.newbridge\/.activity.SplashActivity;S.fromId=4415196650012829546;i.jump_target=1;end",
    // 自定义消息体
    'custom_content' => $costom_content,
    //'hw_intenturi' => ''
    // 华为代理通知消息回调和自定义行为 需要添加此字段
    //'hw_intenturi' => "baidupush://bdpush/hwnotify?bdpush_hwmsgbody=$json_costom_content#Intent;action=android.intent.action.VIEW;package=com.baidu.push.qa;launchFlags=0x10000000;end"
);
// 设置消息类型为 通知类型.
$opts = array (
    'msg_type' => 0,// 标识message是透传的消息
    'extra_msg_type' => 1,// 标识 extra_messgage 是上通知栏的消息
    'extra_msg' => json_encode($extra_message),
    'topic_id' => 'baidupush113'
);

// 向目标设备发送一条消息
$rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);

// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
if($rs === false){
   print_r($sdk->getLastErrorCode()); 
   print_r($sdk->getLastErrorMsg()); 
}else{
    // 将打印出消息的id,发送时间等相关信息.
    print_r($rs);
}

echo "done!";
 
