<?php
namespace app\index\controller;


use think\Controller;
use \app\index\model\Weichat as WeichatModel;
use think\Request;

class Weichat extends Controller
{

    public function valid()
    {


        $model=new WeichatModel();
        $model->responseMsg();
//        if(!empty(request()->param())) {
//            if ($this->checkSignature()) {
//                $echoStr = request()->param("echostr");
//                ob_clean();
//                echo $echoStr;
//                exit;
//            }
//        }
    }
    private function checkSignature()
    {
        if(!empty(request()->param())){
            $signature = request()->param("signature");
            $timestamp = request()->param("timestamp");
            $nonce =request()->param("nonce");

            $token = "weichat2009";
            $tmpArr = array($token, $timestamp, $nonce);
            // use SORT_STRING rule
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                return true;
            }else{
                return false;
            }
        }

    }


    public function changecode($page){
//        echo "接收参数".$page;
//        $this->redirect("account/user");

//        exit;
        //code
        $weichat=new WeichatModel();
        $weichat->getUserOpenId();

//        echo cookie("openid");

        //调回之前的页面

        $this->redirect($page);
    }

    public function menu(){
        if(empty($_POST)){
            return $this->fetch();
        }else{
            if(isset($_POST["body"])){
                $body=$_POST["body"];
                $weichat=new WeichatModel();


                $result= $weichat->menu($_POST["body"]);
//                print_r($result);
            }
        }
    }

    public function huodong(){
        $this->redirect("http://product.jujiaoweb.com/dry/public/index.php/rents?huodong=1");
    }

    public function destroycookie(){
        echo "--清除cookie和shareopenid";
        cookie('openid', null);
        cookie('shareopenid', null);
    }

    public function savevoice(){
//        $data=request()->param("res");
//        file_put_contents("voice.txt",$data);
//        $arr=json_decode($data);
//        $serverId=$arr=["serverId"];  //这里的serverId即为素材中的media_id
        $serverId="pR5DVMFhw0kUcqXMS0xqmLmf6IIRG8NmfhficYw0M0varmWp6Pz_BXbo92H1-Enb";

        //开始保存语音到本地服务器
        $weichat=new WeichatModel();
        $token=$weichat->getToken();
//        echo $token;
//        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$token."&media_id=".$serverId;
       $url1="https://api.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=$token&media_id=$serverId";
//        $arr1=$weichat->curl1($url1,"get","https");

        $arr = $this->downloadWeixinFile($url1);
            print_r($arr);
        file_put_contents("voice.txt1",$arr["body"]);
            $this->saveWeixinFile("2.mp3",$arr['body']);
    }
    function downloadWeixinFile($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        echo "接受到的数据=".$package."<br>";
        file_put_contents("3.mp3",$package);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        echo "头部=".json_encode($httpinfo);
        $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
        return $imageAll;
    }


    function saveWeixinFile($filename, $filecontent)
    {
        file_put_contents($filename,$filecontent);
    }



}
