<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 13:54
 */
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Myadress as MyadressModel;

class Myadress extends Controller{
    public function myadress(){

        $myadress=new MyadressModel();
        $adressarr=$myadress->selectmyaddr();
        $this->assign("adressarr",$adressarr);
        return $this->fetch();
    }
    public function addmyadress(){
        if(!$_POST){
            return view("addmyadress");
        }else{
            $openid=cookie("openid");
//            print_r(Request::instance()->post());

            $data=[
                "addr_name"=>Request::instance()->post()["contacts"],
                "addr_tel"=>Request::instance()->post()["mobile"],
                "ar_provinves"=>Request::instance()->post()["province"],
                "addr_detailed"=>Request::instance()->post()["content"],
                "openid"=>$openid,

            ];

            $myadress=new MyadressModel();
            $myadress->addmyadress($data);
//            $result=$myadress->selectadress("");
//            if(!$result){
//                $myadress->addmyadress($data);
//            }else{
//                $myadress->updateadress($adressid,$data);
//            }
            echo 0;
        }
    }
    public function deladress(){
        $myadress=new MyadressModel();
        $adressid=Request::instance()->post()["addressid"];
        $myadress->deladress($adressid);
        echo 0;
    }
    public function editadress(){
        $myadress=new MyadressModel();
        $adressid=Request::instance()->post()["addressid"];
        $myadress->editIndex($adressid);
    }
}