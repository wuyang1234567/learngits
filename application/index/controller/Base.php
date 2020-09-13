<?php
namespace app\index\controller;
use app\index\model\Jssdk;
use app\index\model\Weichat;
use think\Controller;
use think\Db;
use think\Request;


class Base extends Controller{
        public function __construct(Request $request)
        {
            parent::__construct($request);

            //读取分类
            $cate=Db::view('cate','*')
                ->select();
            $this->assign("cate",$cate);

            $index="";
            if(Request::instance()->param("shareopenid")){
//                $index="存在";
//                file_put_contents("shareopenid.txt",Request::instance()->param("shareopenid"));
                cookie("shareopenid",Request::instance()->param("shareopenid"),3600*7*24);
            }else{
                if(!cookie("shareopenid")){
                    cookie("shareopenid"," ",3600*7*24);
//                    $index="不存在";
                }

            }
//            file_put_contents("share",$index.cookie("shareopenid"));
            $this->jssdk=new Jssdk();
            $this->signPackage = $this->jssdk->GetSignPackage();  //获取前端所需要的一些数据
            $this->assign("signPackage",$this->signPackage);

            if(!cookie("openid")){
//                print_r($_SERVER);
//
//                exit;
                $path=$_SERVER["PATH_INFO"];

                if($path=="" ||$path=="/"){
                    $path="index";
                }else{
                    $path=substr($path,1);
                }
                if($path=="delcookie"){
                    echo "删除cookie中openid=".cookie("openid");
                }else{

                    $weichatModel=new Weichat();
                    $weichatModel->getCodeOpenid($path);
                }

                $this->assign("openid","");
            }else{
//               //查看一下数据库中昵称是否存在 如果不存在再读取一次
//                $arr=Db::table('dry_user')
//                    ->where('openid',cookie("openid"))
//                    ->find();
//                if(!$arr["nickname"]){
//
//                }
                $this->assign("openid",cookie("openid"));
            }

        }
}
