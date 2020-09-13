<?php
namespace app\index\controller;

use app\index\model\Login as logModel;
use app\index\model\Register as reModel;
use app\index\model\Weichat;
use think\Controller;
use think\captcha\Captcha;
use \app\index\model\Index as indexModel;
use \app\index\model\Forget as forgetModel;
use think\Db;
use think\Request;

class Order extends Base
{
    /**
     * 点击商品详细页面时的购买按钮
     * @return mixed
     */
    public function payorder(){
//        echo "buy";
        $arr=  Request::instance()->param();
        $id=$arr["id"];

        $openid=cookie("openid");

        $addr=Db::table("dry_addr")
            ->where('openid',$openid)
            ->where('addr_index',1)  //默认的地址
            ->find();
        if(substr($id, -1)=="R"){
            //表示重复付款
            $tradeNo = substr($id,0,strlen($id)-1);
            $data=Db::table("dry_order")
                ->where('dry_order.Id',$tradeNo)
                ->field("shopId")
                ->find();
            $id=$data["shopId"];

            //删除原来的订单 生成一个新的
            $data=Db::table("dry_order")
                ->where('dry_order.Id',$tradeNo)
                ->delete();
        }

        $data=Db::table("dry_join")->where('Id',$id)->find();
        $price=$data["rprice"];
        $title=$data["rtitle"];

        /////////////////////////先写入数据库 状态为未付款
        $agentOpenid=cookie("shareopenid");
        $tradeNo=date("YmdHis");  //生成订单号
        $data=array(
            "shopId"=>$id,
            "price"=>$price,
            "openid"=>cookie("openid"),
            "agentOpenid"=>$agentOpenid,
            "time"=>date("Y-m-d H:i:s"),
            "tradeNo"=>$tradeNo,
            "addrId"=>$addr["Id"]
        );
        $result=Db::table("dry_order")
            ->insert($data);

        $data["rtitle"]=$title;


        $orderId=$tradeNo;  //得到生成的订单号
        /////////////////////////////////////////////////////开始微信支付

//①、获取用户openid
        $tools = new \JsApiPay();

        $openId=cookie("openid");

//②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($title);
        $input->SetAttach($title);
        $input->SetOut_trade_no($orderId);   //\WxPayConfig::MCHID.date("YmdHis")
        $input->SetTotal_fee("1"); //价格测试
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($title);
//        $input->SetNotify_url("http://product.jujiaoweb.com/ljp/public/static/libs/weixinpay/notify.php");
        $input->SetNotify_url("http://product.jujiaoweb.com/dry/public/index.php/notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $order = \WxPayApi::unifiedOrder($input);
        file_put_contents("order",$order["return_msg"]."openid=".$openId."orderid=".$orderId);
//        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//        printf_info($order);

        $jsApiParameters = $tools->GetJsApiParameters($order);
//        echo "<br>";
//        echo $jsApiParameters;
//获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();
//        echo "<br>";
//        echo $editAddress;

        $this->assign("jsApiParameters",$jsApiParameters);
        $this->assign("editAddress",$editAddress);
        /////////////////////////////////////////////

        ////////////////////////////////读取当前用户的默认地址 当真正确认付款的时候需要选择一个地址

//        print_r($arr);
        $this->assign("addr",$addr);
        $this->assign("data",$data);

        return $this->fetch();
    }
    public function myOrder(){
//        $result=Db::table("dry_order")
//            ->where("openid",cookie("openid"))
//            ->select();
        $result=Db::table("dry_order")
            ->alias("o")
            ->join('dry_join j','j.Id = o.shopId')
            ->field('j.rtitle,o.*')
            ->where("openid",cookie("openid"))
            ->select();
        $this->assign("data",$result);
        return view("myOrder");
    }

    /**
     *这是一个测试的函数 其中包含模版消息发送 不是真正的支付的方法
     */
    public function weichatpay(){
//        echo 1;
        $arr=  Request::instance()->param();
//        print_r($arr);
        //写入数据库 此时是没有付款成功的状态
        $agentOpenid=cookie("shareopenid");
        $data=array(
            "shopId"=>$arr["id"],
            "price"=>$arr["price"],
            "openid"=>cookie("openid"),
            "addrId"=>$arr["addr"],
            "agentOpenid"=>$agentOpenid,
            "time"=>date("Y-m-d H:i:s")
        );
        $result=Db::table("dry_order")
            ->insert($data);

        $orderId=Db::getLastInsID();
//        echo $orderId;

        $data=$this->weixinpay();
        $data["msg"]=1;

        file_put_contents("pay.txt",json_encode($data));
        echo json_encode($data);
        //开始微信支付 支付成功改变状态

        return;
        $weichatmodel=new Weichat();

        $keyword1=cookie("openid");
        $keyword2=date("Y-m-d H:i:s");  //商品信息
        $keyword3="11111111";  //订单号

        $data=array(
            "name"=>array(
                "value" =>$keyword1,
                "color"=>"#ff0000"
            ),
            "time"=>array(
                "value" =>$keyword2,
                "color"=>"#173177"
            ),
            "order"=>array(
                "value" =>$keyword3,
                "color"=>"#173177"
            )
        );

        $tplId="14TqrgYgUngjFKhVnrBkcFGSATTP3JMFGksI_lTDtbg";
        $url="http://product.jujiaoweb.com/ljp/public/index.php";
        $weichatmodel->sendTPLInfo($tplId,$url,$data);
    }

//
//    public function weixinpay(){
//        //初始化日志
//        // $logHandler= new \CLogFileHandler("logs/".date('Y-m-d').'.log');
//        //  $log = \Log::Init($logHandler, 15);
//
//        //打印输出数组信息
////        function printf_info($data)
////        {
////            foreach($data as $key=>$value){
////                echo "<font color='#00ff55;'>$key</font> : $value <br/>";
////            }
////        }
//
////①、获取用户openid
//        $tools = new \JsApiPay();
//
//        $openId=cookie("openid");
//
////②、统一下单
//        $input = new \WxPayUnifiedOrder();
//        $input->SetBody("test");
//        $input->SetAttach("test");
//        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
//        $input->SetTotal_fee("100000");
//        $input->SetTime_start(date("YmdHis"));
//        $input->SetTime_expire(date("YmdHis", time() + 600));
//        $input->SetGoods_tag("test");
//        $input->SetNotify_url("http://product.jujiaoweb.com/ljp/public/libs/weixinpay/notify.php");
////        $input->SetNotify_url("http://product.jujiaoweb.com/ljp/public/index.php/notify");
//
//        $input->SetTrade_type("JSAPI");
//        $input->SetOpenid($openId);
//
//        $order = \WxPayApi::unifiedOrder($input);
//        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
////        printf_info($order);
//
//        $jsApiParameters = $tools->GetJsApiParameters($order);
//        echo "<br>";
//        echo $jsApiParameters;
////获取共享收货地址js函数参数
//        $editAddress = $tools->GetEditAddressParameters();
//        echo "<br>";
//        echo $editAddress;
//
//        $this->assign("jsApiParameters",$jsApiParameters);
//        $this->assign("editAddress",$editAddress);
//
//        return $this->fetch();
//    }

    public function notify(){
        file_put_contents("ac","进入notify");
        $postStr = file_get_contents("php://input");
//        $notify = new \PayNotifyCallBack();
//        $notify->Handle(false);
        file_put_contents("weipay.txt",$postStr);
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $out_trade_no = $postObj->out_trade_no;  //得到订单号
            //对订单状态进行修改
            //查看当前订单的状态 如果是已经付款成功 下面的就不再执行
            $status=$result=Db::table("dry_order")
                ->where("tradeNo",$out_trade_no)
                ->field("status")
                ->find();
            if($status["status"]==1){
                return;
            }

            $shopId=$result=Db::table("dry_order")
                ->where("tradeNo",$out_trade_no)
                ->field("shopId")
                ->find();
            Db::startTrans();

            $result=Db::table("dry_order")
                ->where("tradeNo",$out_trade_no)
                ->update(["status"=>1]);

            //更新商品数量减一
            Db::table('dry_join')
                ->where('Id', $shopId["shopId"])
                ->setDec('count');

            Db::commit();
//            $notify->setReturnParameter("return_code","SUCCESS");
        }
    }

    public function detail(){
        $id=  Request::instance()->param("id");

        $data=Db::table("dry_order")
            ->join("dry_join","dry_join.Id=dry_order.shopId")
            ->join("dry_addr","dry_addr.Id=dry_order.addrId")
            ->join("dry_user","dry_user.openid=dry_order.openid")
            ->where('dry_order.Id',$id)
            ->find();

        $this->assign("data",$data);
        return $this->fetch();
    }
}
