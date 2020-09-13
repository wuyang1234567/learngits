<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


// [ 应用入口文件 ]
//通过入口页面来判断当前浏览器是否是微信浏览器 便于后面程序使用1）是否跳出登陆页面
function is_weixin(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        //这是微信浏览器
        return 1;
    }
    $_COOKIE["openid"]="oWpzD1MB5F5PxfsyK-uLKP764_VU";
    return 0;
}
//$_COOKIE["openid"]="oXwxJwnIAzU42_ECVbd3c-1s8cd4";
define("WEICHAT",is_weixin());




// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('DRY', 'dry');


//导入微信支付的文件
require_once "static/libs/weixinpay/lib/WxPay.Api.php";
require_once "static/libs/weixinpay/WxPay.JsApiPay.php";
require_once 'static/libs/weixinpay/log.php';
require_once "static/libs/weixinpay/lib/WxPay.Data.php";

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';



