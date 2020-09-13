<?php

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Validate;
use think\Request;
use think\Cookie;
class agents extends Controller
{
    public function index(){
        $request=request();
//        $type=$request->param()['type'];
//        $arr=model('agents')->index();

        //读取所有销售人员
        $data=Db::table("dry_user")
            ->where("ifagent",1)
            ->select();

//        print_r($data);
        return $this->fetch('agents',['arr'=>$data]);
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

        $data=Db::table("dry_user")
            ->where("uid",$id)
            ->update(["ifagent"=>0]);
//        model('agents')->del($id);
        echo true;
    }
    public function etic(){//修改
        $request=request();
        if(empty($request->param())){
            $id=cookie('user_id');
            cookie('user_id', null);

            $arr=model('Member')->etic([],$id);

            return $this->fetch('etic',['id'=>$id,'arr'=>$arr]);
        }else{
            $validate = new Validate([
                'realname'  => 'require|token',
                'utel' => 'require|number|min:11|max:11',
                'uemail' => 'email'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('member')->etic($request->param());
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