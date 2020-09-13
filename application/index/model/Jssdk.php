<?php
namespace app\index\model;

use think\Model;
class Jssdk  extends Model {
  private $appId="wx96629735ac2e7cf8";
  private $appSecret="a00955de9882b91e3a1c445d5f01b455";
  public function getSignPackage() {
   return;
    $jsapiTicket = $this->getJsApiTicket();
    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    //trim(substr(file_get_contents($filename), 15))
    if(file_exists("jsapi_ticket.txt")){
      $gerphpfile=file_get_contents("jsapi_ticket.txt");
      $data = json_decode($gerphpfile);
      if (($data->expire_time < time())) {
        $accessToken = $this->getAccessToken();
        // 如果是企业号用以下 URL 获取 ticket
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
        $res = json_decode($this->httpGet($url));
        $ticket = $res->ticket;
        if ($ticket) {
          $data->expire_time = time() + 7000;
          $data->jsapi_ticket = $ticket;
//          $this->set_php_file("jsapi_ticket.php", json_encode($data));
          file_put_contents("jsapi_ticket.txt",json_encode($data));
        }
      } else {
        $ticket = $data->jsapi_ticket;
      }
    }else{
      $accessToken = $this->getAccessToken();
      $data=new \stdClass();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
//        $this->set_php_file("jsapi_ticket.php", json_encode($data));
        file_put_contents("jsapi_ticket.txt",json_encode($data));
      }
    }

    
    return $ticket;
  }

  private function getAccessToken() {
    if(file_exists("access_token.txt")){
      //如果存在
      $getphpfile=file_get_contents("access_token.txt");
      $data = json_decode($getphpfile);
      if ($data->expire_time < time()) {
        // 如果是企业号用以下URL获取access_token
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
        $res = json_decode($this->httpGet($url));
        $access_token = $res->access_token;
        if ($access_token) {
          $data->expire_time = time() + 7000;
          $data->access_token = $access_token;
//          $this->set_php_file("access_token.php", json_encode($data));

          file_put_contents("access_token.txt",json_encode($data));
        }
      } else {
        $access_token = $data->access_token;
      }
    }else{
      $data=new \stdClass();
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
//        $this->set_php_file("access_token.php", json_encode($data));

        file_put_contents("access_token.txt",json_encode($data));
      }
    }
    //////////////////////////////////////////////// access_token 应该全局存储与更新，以下代码以写入到文件中做示例

    return $access_token;
  }

  private function httpGet($url) {
    $weimodel=new Weichat();
    return $weimodel->curl1($url,"get","https");
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($curl, CURLOPT_TIMEOUT, 500);
////     为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
////     如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
//     curl_setopt($curl, CURLOPT_URL, $url);
//
//
//     curl_close($curl);
//    $res = file_get_contents($url);
//    return $res;
  }

}

