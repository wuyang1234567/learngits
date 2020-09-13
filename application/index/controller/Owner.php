<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Owners as Owners;
use think\Db;
use think\Request;

class Owner extends Base
    {
        public function owner()//加盟界面
        {
            $owModel = new Owners();
            if(!empty($_POST)){
                $arr = [];
                $checkTel = checkPhone($_POST["tel"]);
                if($checkTel["status"]==0){//正则电话验证失败
                    $arr =  $checkTel;
                }else{
                    $validate = $this->validate($_POST,'User.owner');
                    if(true ===$validate){
                        $data = $owModel->owners($_POST["tel"]);
                        if(empty($data)){
                            unset($_POST["__token__"]);
                            $data = $owModel->insertData($_POST);
                            if($data==1){
                                $arr = retuanData(1,"你的申请已被接受，工作人员将在3-5个工作日内联系你，请保持电话畅通");
                            }else{
                                $arr = retuanData(0,"加盟失败，请重新填信息");
                            }
                        }else{
                            $arr = retuanData(0,"该电话号码已加盟，更多内容请跟工作人员联系");
                        }
                    }else{
                        //验证失败
                        $arr = retuanData(0,$validate);
                    }
                }
                return json_encode($arr);
            }else{
                return view("owner");
            }

        }

        public function aboutus()//关于我们
        {

            return view("aboutus");
        }
        public function shopcar()//购物车
        {
            return view("shopcar");
        }
        public function returnmoney()//返现
        {
            $openid=cookie("openid");//我的openid
            //从订单表中查找agentOpenid为我的客户 以及需要是付款的客户

            $result=Db::table("dry_order")
                ->alias("o")
                ->join('dry_join j','j.Id = o.shopId')
                ->join("dry_user u","u.openid=o.openid")
                ->field('j.rtitle,o.*,u.nickname')
                ->where("agentOpenid",$openid)
                ->where("status",1)
                ->select();
//        print_r($result);
            $this->assign("data",$result);
            return view("returnmoney");
        }
        public function tuiguang()//推广
        {
            return view("tuiguang");
        }

        public function addmyaddress(){
            echo "----";
            if(!$_POST) {
                return view("addmyadress");
            }else{

            }
        }

    /**
     *完善个人基本信息
     */
    public function myinfo(){
        $openid=cookie("openid");
        if(empty(Request::instance()->param())){
            //读取个人的基本信息

            $data=Db::table("dry_user")
                ->where("openid",$openid)
                ->find();
//            print_r($data);
            $this->assign("data",$data);
            return $this->fetch();
        }else{
            $data= Request::instance()->param();
//            print_r($data);
            if($data["nickname"]=="" ||$data["utel"]==""){
                echo 1;
            }else{
                //更新数据
                $data=Db::table("dry_user")
                    ->where("openid",$openid)
                    ->update($data);
                echo 0;
            }

        }
    }
    public function backmoney(){

    }

    }

