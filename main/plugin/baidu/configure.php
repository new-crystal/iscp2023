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
 * @file const.conf.php
 * @encoding UTF-8
 * 
 * 
 *         @date 2020年5月29日
 *        
 */

class BAIDU_PUSH_CONFIG {

    /**
     * api 서버의 주소입니다.
     *
     * @var string
     */
    const HOST = 'http://api.tuisong.baidu.com/rest/3.0/';
    /**
     * 개발자 센터 (http://developer.baidu.com)에서 얻은 개발자 apikey, 
     * apikey가 코드에 설정되지 않은 경우이 apikey를 사용하십시오.
     * @var string
     */
    const default_apiKey = 'lFQwfUHgM8XPAdn1VAC3zWIQ';
    
    /**
     * 개발자의 현재 secretKey는 애플리케이션이 비밀 키를 재생성 한 후 이전 비밀 키가 무효화되며 개발자 센터 (http://developer.baidu.com)에서 얻을 수 있습니다.
     * 코드에 apikey가 설정되지 않은 경우이 secretkey를 사용하십시오.
     * @var string
     */
    const default_secretkey = 'DqwEcqkVGRNteD1WtIukAkOG9DUUMg7S';
    
    /**
     * 기본적으로 전송되는 장치 유형
     *  
     * @var int | null
     */
    const default_devicetype = 3;
    
    /**
     * 테스트 메시지를 수신하는 데 사용되는 channel_id입니다.
     * 이 항목을 설정하면 테스트 디렉터리에서 check_sdk_test.php를 실행할 때마다 알림 메시지가이 장치로 푸시되며 SDK 및 환경이 정상적으로 작동하는지 확인하는 데 사용됩니다.
     * 
     * @var string
     */
    const test_channel_id = '4222258442617456931';
    
    /**
     * log level 상수.
     * 
     * @var int
     */
    const LOG_LEVEL_DEV = 0; // 开发状态, rd开发时使用, 最详细 log. 发布后被移除
    const LOG_LEVEL_TRACE = 1; // 开发者开发时状态,隐藏rd开发时的细碎信息
    const LOG_LEVEL_ONLINE = 2; // 开发者线上使用, 只有fault和warn
    const LOG_LEVEL_ONLINE_FAULT = 3; // 开发者线上使用, 只有fault
    const LOG_LEVEL_ONLINE_SILENCE = 4; // 静默.
    
    /**
     * 对log模块进行配置, 可选值为 [0 - 4], 参见上面的常量设置
     *
     * @var int
     */
    const LOG_LEVEL = BAIDU_PUSH_CONFIG::LOG_LEVEL_TRACE;
    
    /**
     * 输出位置.
     * page, 直接打印至页面.
     * stdout 打印至 php://stdout
     * {fpath} 打印至所指定的目标文件
     * 
     * @var string
     */
    const LOG_OUTPUT = 'stdout';
    
    /**
     * 异常控制方式.一个布尔值.
     * false 当出现异常将被抛出.
     * true 不抛出异常, 需通过 getErrorCode() 及 getErrorMessage() 进行获取.
     * 
     * @var boolean
     */
    const SUPPRESS_EXCPTION = true;
    
    /**
     * 每次生成请求签名的失效时长.单位为秒, SIGN_EXPIRES <= 0 表示为由服务端自动处理.
     * default 0;
     *
     * @var int
     */
    const SIGN_EXPIRES = 0;
} 

