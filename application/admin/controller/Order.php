<?php

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Validate;
use think\Request;
use think\Cookie;
class Order extends Controller
{
    public function index(){
        $request=request();
//        print_r($request->param());


//        $begin=$request->param("begin");
//        $end=$request->param("end");
//        $list=Db::table("dry_order")
//            ->join("dry_user","dry_user.openid=dry_order.agentOpenid","left")
//            ->where("agentOpenid","")
//            ->where('time','between',[$begin,$end])
//            ->field("dry_user.realname,dry_order.*")
//            ->select();
        $begin="";
        $end="";
        $id="";
        if($request->param("id")===Null ){
            //获取全部
            $begin=date("Y-m-d");
            $end=date("Y-m-d");

            if($begin==$end){
                $endtime=strtotime($end)+3600*24;
                $end=date("Y/m/d",$endtime);
            }else{
                $endtime=strtotime($end)+3600*24;
                $end=date("Y/m/d",$endtime);
            }

            $begintime=strtotime($begin)-3600*24;
            $begin=date("Y/m/d",$begintime);


            $list=Db::table("dry_order")
                ->join("dry_user","dry_user.openid=dry_order.agentOpenid","left")
                ->where('time','between',[$begin,$end])
                ->where('status','1')
                ->field("dry_user.realname,dry_order.*")
                ->select();
        }else{
            if($request->param("id")==="0"){

                //获取公司
                $begin=$request->param("begin");
                $end=$request->param("end");
                if($request->param("begin")==$request->param("end")){
                    $endtime=strtotime($request->param("end"))+3600*24;
                    $end=date("Y/m/d",$endtime);
                }else{
                    $endtime=strtotime($request->param("end"))+3600*24;
                    $end=date("Y/m/d",$endtime);
                }

                $begintime=strtotime($request->param("begin"))-3600*24;
                $begin=date("Y/m/d",$begintime);
//                echo "获取公司".$begin."--end=".$end;
                $list=Db::table("dry_order")
                    ->join("dry_user","dry_user.openid=dry_order.agentOpenid","left")
                    ->where('time','between',[$begin,$end])
                    ->where("agentOpenid","")
                    ->where('status','1')
                    ->field("dry_user.realname,dry_order.*")
                    ->select();
            }else if($request->param("id")==="-1"){
                //获取全部
                $begin=$request->param("begin");
                $end=$request->param("end");
                if($request->param("begin")==$request->param("end")){
                    $endtime=strtotime($request->param("end"))+3600*24;
                    $end=date("Y/m/d",$endtime);
                }else{
                    $endtime=strtotime($request->param("end"))+3600*24;
                    $end=date("Y/m/d",$endtime);
                }

                $begintime=strtotime($request->param("begin"))-3600*24;
                $begin=date("Y/m/d",$begintime);
//                echo "获取全部".$begin."--end=".$end;
                $list=Db::table("dry_order")
                    ->join("dry_user","dry_user.openid=dry_order.agentOpenid","left")
                    ->where('time','between',[$begin,$end])
                    ->where('status','1')
                    ->field("dry_user.realname,dry_order.*")
                    ->select();
            }
            else{
                //获取指定的销售人员
                $begin=$request->param("begin");
                $end=$request->param("end");
                $id=$request->param("id");

                if($request->param("begin")==$request->param("end")){
                    $endtime=strtotime($request->param("end"))+3600*24;
                    $end=date("Y/m/d",$endtime);
                }else{
                    $endtime=strtotime($request->param("end"))+3600*24;
                    $end=date("Y/m/d",$endtime);
                }
                $begintime=strtotime($request->param("begin"))-3600*24;
                $begin=date("Y/m/d",$begintime);
//                echo "获取人员".$begin."--end=".$end;
                $list=Db::table("dry_order")
                    ->join("dry_user","dry_user.openid=dry_order.agentOpenid","left")
                    ->where('time','between',[$begin,$end])
                    ->where("agentOpenid",$id)
                    ->where('status','1')
                    ->field("dry_user.realname,dry_order.*")
                    ->select();
            }
        }



        //读取所有的订单


        //读取所有的销售人员
        $agentlist=Db::table("dry_user")
            ->where("ifagent",1)
            ->field("realname,openid")
            ->select();



        $this->assign("count",count($list));
        $this->assign("list",$list);
        $this->assign("agentlist",$agentlist);
        $this->assign("id",$request->param("id"));
        $this->assign("begin",$request->param("begin"));
        $this->assign("end",$request->param("end"));
        return $this->fetch();
    }
    public function add(){//增加
        $request=request();
        if(empty($request->param())){
            return $this->fetch('add');
        }else{
            $validate = new Validate([
                'realname'  => 'require',
                'utel' => 'require|number|min:11|max:11',
                'uemail' => 'email',
                 'openid'=>"require"
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $data1=$request->param();
                $data1["ifagent"]=1;
                $data=Db::table("dry_user")
                    ->where("openid",$data1["openid"])
                    ->update($data1);

//                $str=model('agents')->add($request->param());
                echo true;
            }
        }
    }
    public function del(){//删除
        $request=request();
        $id=$request->param('id');
        echo $id;
        $data=Db::table("dry_user")
            ->where("uid",$id)
            ->update(["ifagent"=>0]);
//        model('agents')->del($id);
        echo true;
    }
    public function etic(){//修改
        $request=request();
        if(empty($request->param())){
            $id=cookie('agent_id');
            cookie('agent_id', null);
            $arr=model('agents')->etic([],$id);
//            print_r($arr);
            return $this->fetch('etic',['id'=>$id,'arr'=>$arr]);
        }else{
            $validate = new Validate([
                'user'  => 'require|token',
                'phone' => 'require|number|min:11|max:11',
                'email' => 'email'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $str=model('agents')->etic($request->param());
                echo $str;
            }
        }
    }
    public function pwd(){//修改密码
        $request=request();
        if(empty($request->param())){
            $id=cookie('agent_id');
            cookie('agent_id', null);
//            print_r($arr);
            return $this->fetch('pwd',['id'=>$id]);
        }else{
            $validate = new Validate([
                'password' => 'require|max:20|token',
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('agents')->pwd($request->param());
            }
        }
    }
    public function type(){//停用、启用
        $request=request();
        $id=$request->param('id');
        $status=$request->param('status');
        model('agents')->type($id,$status);
        echo true;
    }
}