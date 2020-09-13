<?php
namespace app\index\model;

use think\Cookie;
use think\Db;
use think\Model;

class Weichat extends Model
{
    private $appid="wx96629735ac2e7cf8";
    private $appsecte="a00955de9882b91e3a1c445d5f01b455";  //
    public static $openId="";   //

//接收用户发过来的消息  以及你需要给用户回复的消息方法
    public function responseMsg()
    {
//		print_r($GLOBALS);
//		exit;
//		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];   //php.ini
        $postStr = file_get_contents("php://input");
        //extract post data
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $msgType=$postObj->MsgType;
            $keyword = trim($postObj->Content);
            $event=$postObj->Event;   //接收事件类型
            $time = time();
            $arr = array(

                array(
                    'title'=>'hao123',
                    'description'=>"hao123 is very cool",
                    'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                    'url'=>'http://www.hao123.com',
                ),
                array(
                    'title'=>'jujiao',
                    'description'=>"jujiao is very cool",
                    'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                    'url'=>'http://www.baidu.com',
                ),
                array(
                    'title'=>'qq',
                    'description'=>"qq is very cool",
                    'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                    'url'=>'http://www.qq.com',
                ),
                array(
                    'title'=>'百度',
                    'description'=>"百度 is very cool",
                    'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                    'url'=>'http://www.baidu.com',
                ),
            );




            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
            $newsTpl="<xml>
                        <ToUserName>< ![CDATA[%s] ]></ToUserName>
                        <FromUserName>< ![CDATA[%s] ]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType>< ![CDATA[%s] ]></MsgType>
                        <ArticleCount>%s</ArticleCount>
                        <Articles>%s</Articles>
                        </xml>";
            $itemTpl="<item>
                <Title>< ![CDATA[%s] ]></Title>
                 <Description>< ![CDATA[%s] ]></Description>
                 <PicUrl>< ![CDATA[%s] ]></PicUrl>
                 <Url>< ![CDATA[%s] ]></Url>
                 </item>";




            //对用户发来的内容进行判断
            //天气---  北京天气晴朗
            //你好---hello
            if($msgType=="text"){
                if(mb_stripos($keyword,"天气") !==false){
                    //返回的消息  文本消息
                    $this->getUserInfo($fromUsername);


                    $msgType="text";
                    $content="北京天气".$fromUsername."<a href='http://product.jujiaoweb.com/ljp/public/index.php/'>http://product.jujiaoweb.com/ljp/public/index.php/</a>";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $content);
                    echo $resultStr;
                }else if(mb_stripos($keyword,"你好") !==false){
                    $msgType="text";
                    $content="hello".$msgType;
                    $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $content);
                    echo $resultStr;
                }else{
                    //拼成图片
//                    $articleArr="";
//                    foreach($arr as $item){
//                        $itemStr = sprintf($itemTpl, $item["title"], $item["description"], $item["picUrl"], $item["url"]);
//                        $articleArr.=$itemStr;
//                    }
//
//
//                    $msgType="news";
//                    $count=count($arr);
//                    $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $count,$articleArr);
//                    file_put_contents("a.txt",$resultStr);
//                    echo $resultStr;


                    $arr = array(

                        array(
                            'title'=>'hao123',
                            'description'=>"hao123 is very cool",
                            'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                            'url'=>'http://www.hao123.com',
                        ),
                        array(
                            'title'=>'jujiao',
                            'description'=>"jujiao is very cool",
                            'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                            'url'=>'http://www.baidu.com',
                        ),
                        array(
                            'title'=>'qq',
                            'description'=>"qq is very cool",
                            'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                            'url'=>'http://www.qq.com',
                        ),
                        array(
                            'title'=>'百度',
                            'description'=>"百度 is very cool",
                            'picUrl'=>'http://yzc.jujiaoweb.com/static/admin/img/668127.png',
                            'url'=>'http://www.baidu.com',
                        ),
                    );
                    $template = "<xml>
                     <ToUserName>< ![CDATA[%s]]></ToUserName>
                     <FromUserName>< ![CDATA[%s]]></FromUserName>
                     <CreateTime>%s</CreateTime>
                     <MsgType>< ![CDATA[%s]]></MsgType>
                     <ArticleCount>".count($arr)."</ArticleCount>
                     <Articles>";
                    foreach($arr as $k=>$v){
                        $template .="<item>
                        <Title><![CDATA[".$v['title']."]]></Title>
                        <Description><![CDATA[".$v['description']."]]></Description>
                        <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                        <Url><![CDATA[".$v['url']."]]></Url>
                        </item>";
                    }

                    $template .="</Articles>
                     </xml> ";
                    $str1=sprintf($template, $fromUsername, $toUsername, time(), 'news');
                    file_put_contents("b.txt",$str1);
                    echo $str1;



                }
            }else if($msgType=="event"){
                if($event=="subscribe"){
                    //关注
                    $openid=$fromUsername;
                    $userInfo=$this->getUserInfo($openid);
                    $name=$userInfo["nickname"];
                    $ifsubscribe=$userInfo["subscribe"];
                    $sex=$userInfo["sex"];
                    $uImg=$userInfo["headimgurl"];
                    $str=$openid."---".$name."--".$ifsubscribe."--".$sex."--".$uImg;
//                    file_put_contents("weixin.txt",$str);
                    //写入数据库
                    $data = ['name' => $name, 'ifsubscribe' => $ifsubscribe,"sex"=>$sex,"openid"=>$openid,"uImg"=>$uImg];
                    $result=Db::table('hsm_user')->insert($data);
                    //用户通过分享的链接进入的网站的某个页面，
                    //网页授权
                    //openid  nickname,国家，城市，头像地址

                    //调用获取个人信息的url  --openid  token
//                    https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
//                    https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN


                    $msgType = "text";
                    $contentStr = "感谢你关注当前公众号-----<a href='http://product.jujiaoweb.com/ljp/public/index.php'>网站</a>".$userInfo["nickname"];
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
            }

        }else {
            echo "";
            exit;
        }
    }

    /**
     * @param $openid
     * @return mixed
     * 获取用户的信息
     */
    public function getUserInfo($openid){

        $token=$this->getToken();
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
        $result=$this->curl1($url,"get","https");

//        file_put_contents("weixin.txt",$result);
        $result1=json_decode($result,true);  //转成数组
//        $nike=$result1["nickname"];
//        file_put_contents("a.txt","---nichengresult---=".$nike."\n");
        return $result1;
    }

    /**
     * @return mixed
     * 获取所有关注的用户列表
     */
    public function getUserList(){
        $token=$this->getToken();
        $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$token;
        $result=$this->curl1($url,"get","https");

        file_put_contents("list.txt",$result);
        $result1=json_decode($result,true);  //转成数组
//        $nike=$result1["nickname"];
//        file_put_contents("a.txt","---nichengresult---=".$nike."\n");
        return $result1;
    }

    function curl1($url,$method="get",$type="http",$data=""){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        if($type=="https"){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器认证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
        }
        if($method=="post"){
            curl_setopt($ch, CURLOPT_POST, true);//设置请求是POST方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置POST请求的数据
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $data=curl_exec($ch);
        curl_close($ch);

        return $data;

    }

    function getToken(){
        $token="";
        $file="token.txt";
        if(file_exists($file)){
            $now=time();
            $tokenTime=filemtime($file);
            if(($now-$tokenTime)<7200){
                $token=file_get_contents($file);

                return $token;
            }
        }

        $token= $this->curl1("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecte","get","https");
        file_put_contents("asstoken",$token);
        $acc=json_decode($token)->access_token;
        file_put_contents("token.txt",$acc);
        return $token;
//    if()
    }

    /**
     * 创建菜单项
     * @param $body---数据源
     */
    public function menu($body){
        $token=$this->getToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$token";
//        $url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;

        $result= $this->curl1($url,"post","https",$body);
        echo $result;
    }

    //获取通过网页进入的威信用户的openid
    public function getCodeOpenid($page){

        $redirect_uri=urlencode("http://product.jujiaoweb.com/dry/public/index.php/changecode/page/".$page);

        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";

        //echo $url;
        header("location:".$url);
    }

    //通过获取的code来读取用户的openid
    public function getUserOpenId(){

        $code=input("code");  //获取code

        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecte."&code=".$code."&grant_type=authorization_code";

        $res=$this->curl1($url,"get","https");
        //已日志的形式写入
        $data=json_decode($res);

        $openid=$data->openid;

        cookie("openid",$openid,3600*7*24);



        //查找数据库中是否存在openid
        $arr=Db::table('dry_user')
            ->where('openid',$openid)
            ->find();
        if($arr==null){
            //说明数据库不存在当前用户 继续获取用户的基本信息
            $userInfo=$this->getUserInfo($openid);   //读取用户的openid
//            file_put_contents("openid.txt",json_encode($userInfo));
//
            $name=isset($userInfo["nickname"])?$userInfo["nickname"]:"微信昵称";
            $ifsubscribe=isset($userInfo["subscribe"])?$userInfo["subscribe"]:0;
            $sex=isset($userInfo["sex"])?$userInfo["sex"]:0;
            $uImg=$userInfo["headimgurl"];


//            file_put_contents("weichat.txt",$name."-----if=".$ifsubscribe."----sex=".$sex."----img=".$uImg);
            $data = ['nickname' => $name, 'ifsubscribe' => $ifsubscribe,"sex"=>$sex,"openid"=>$openid,"uImg"=>$uImg];
            $result=Db::table('dry_user')->insert($data);
        }
    }


    /**
     * @param $template_id   模版消息id
     * @param $url  跳转的链接
     * @param $data  模版数据
     * @return string
     */
    public function sendTPLInfo($template_id, $url, $data){
        $token= $this->getToken();
        $openid=cookie("openid");
        $arr=array(
            "touser"=>$openid,
            "template_id"=>$template_id,
            "url"=>$url,
            "data"=>$data
        );
        $postdata= json_encode($arr);
        echo $postdata;
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;

        $data= $this->curl1($url,"post","https",$postdata);
        $jsondata=json_encode($data);
        return $jsondata;
    }



}
