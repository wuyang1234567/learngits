<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Rents as rentsModel;
use think\Db;

class Rents extends Base
{
    public function rents()//商品界面
    {

        if(!empty(request()->param("page"))){
            $page=intval(request()->param("page"));
        }else{//没有page参数
            $page = 1;
        }
        $cateName="商品";
        if(!empty(request()->param("id"))){
            $id=request()->param()["id"];
            $cate=Db::view('cate','*')
                ->where("Id",$id)
                ->find();
            $cateName=$cate["name"];

            $data= Db::table("dry_join")
                ->join("dry_image","dry_join.Id=dry_image.fid")
                ->join("dry_cate","dry_join.cateid=dry_cate.Id")
                ->where("dry_join.cateid",$id)
                ->where("dry_join.count",">",0)
                ->order('beginTime desc')
                ->field("dry_join.*,dry_cate.name,dry_image.imageurl")
                ->select();
        }else{
            if(!empty(request()->param("huodong"))){
                //获取活动记录
                $cateName="活动";
                $data= Db::table("dry_join")
                    ->join("dry_image","dry_join.Id=dry_image.fid")
                    ->join("dry_cate","dry_join.cateid=dry_cate.Id")
                    ->where("dry_cate.name","活动")
                    ->where("dry_join.count",">",0)
                    ->order('beginTime desc')
                    ->field("dry_join.*,dry_cate.name,dry_image.imageurl")
                    ->select();
            }else{
                echo "不存在id";
                $data= Db::table("dry_join")
                    ->join("dry_image","dry_join.Id=dry_image.fid")
                    ->select();
            }

        }

        for($i=0;$i<count($data);$i++){
            $now=date("Y-m-d");
            $endTime=$data[$i]["endTime"];
            if($data[$i]["name"]=="活动"){
                $data[$i]["over"]="";
                if($now>$endTime){
                    $data[$i]["over"]="true";
                }
            }

        }

//        if($page==1){

        $this->assign("title",$cateName);
            $this->assign("dataSources",$data);
            return view("rents");
//        }else{
//            return json_encode($data,true);
//        }

    }

    public function detail()//房源详细信息界面
    {
        $rentsObj = new rentsModel();
        $fid = request()->param("fid");

        //房间详细信息顶部数据源
//        $topData = $rentsObj->detailTop($fid);
//        echo $fid;



        $data= Db::table("dry_join")
            ->join("dry_image","dry_join.Id=dry_image.fid")
            ->join("dry_cate","dry_join.cateid=dry_cate.Id")
            ->field("dry_join.*,dry_cate.name,dry_image.imageurl")
            ->where("dry_join.Id",$fid)
            ->find();



            $now=date("Y-m-d");
            $endTime=$data["endTime"];
            if($data["name"]=="活动"){
                $data["over"]="";
                if($now>$endTime){
                    $data["over"]="true";
                }
            }



        $this->assign("dataSourcesTop",$data);
//        $this->assign("allocationData",$houseAllData);
//        $this->assign("housemates",$housemateData);
        $this->assign("fid",$fid);
//        $this->assign("address",$housemateData[0]["raddress"]);

        return view("detail");
    }
}
