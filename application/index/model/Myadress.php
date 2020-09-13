<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27
 * Time: 15:56
 */
namespace app\index\model;
use think\Db;
use think\Model;

class Myadress extends Model{
    public function addmyadress($data){
       $count= Db::table("dry_addr")
           ->where("openid",cookie("openid"))
           ->count();

        if($count==0){
            $data["addr_index"]=1;
        }
        Db::table("dry_addr")->insert($data);
    }
    public function selectadress($_id){
        $arr=Db::table("address")->where('Id',$_id)->find();
        return $arr;
    }
    public function updateadress($_id,$data){
        Db::table("address")->where('Id',$_id)->update($data);
    }
    public function deladress($_id){
        Db::table("dry_addr")->where('Id',$_id)->delete();
    }
    public function editIndex($_id){
        Db::startTrans();
        try{
//            Db::table("address")->where('userid',$_userid)->setField('index',1);
            Db::table("dry_addr")
                ->where("openid",cookie("openid"))
                ->where('addr_index',1)
                ->setField("addr_index",0);
            Db::table("dry_addr")->where('Id',$_id)->setField("addr_index",1);
            // 提交事务
            Db::commit();
            echo 0;
        } catch (\Exception $e) {
            echo "失败";
        }
    }
    public function selectmyaddr(){
        $openid=cookie("openid");
        $arr=Db::table("dry_addr")->where("openid",$openid)->select();
        return $arr;
    }
}