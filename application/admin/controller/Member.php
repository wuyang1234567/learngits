<?php
namespace app\admin\controller;
use app\index\model\Weichat;
use think\Controller;
use think\Db;
use think\Validate;
use think\Request;
use think\Cookie;
class Member extends Controller
{
    public function index(){
        //拉去微信用户
//        $model=new Weichat();
//        $list=$model->getUserList()["data"]["openid"];
//
////        print_r($list);
//        //遍历得到每一个用户的基本信息
//        $arr=array();
//        foreach($list as $item){
//            $arr1=$model->getUserInfo($item);
//            $arrnew["ifsubscribe"]=$arr1["subscribe"];
//            $arrnew["uImg"]=$arr1["headimgurl"];
//            $arrnew["openid"]=$arr1["openid"];
//            $arrnew["sex"]=$arr1["sex"];
//            $arrnew["subscribe_time"]=$arr1["subscribe_time"];
//            $arrnew["nickname"]=$arr1["nickname"];
//
//            $arr[]=$arrnew;
//
//        }
//        print_r($arr);
//        Db::table("dry_user")->insertAll($arr);
//
        $request=request();

//        $arr=model('Member')->index();
        $arr=Db::table("dry_user")
            ->join("dry_order","dry_user.openid=dry_order.openid")
            ->where('dry_order.status','1')
            ->field("dry_user.*")
            ->select();
        return $this->fetch('member',['arr'=>$arr]);
    }
    public function add(){//增加
        $request=request();
        if(empty($request->param())){
            return $this->fetch('add');
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
                model('member')->add($request->param());
            }
        }
    }
    public function del(){//删除
        $request=request();
        $id=$request->param('id');
        model('Member')->del($id);
        echo true;
    }
    public function etic(){//修改
        $request=request();
        if(empty($request->param())){
            $id=cookie('user_id');
            cookie('user_id', null);
            $arr=model('Member')->etic([],$id);
//            print_r($arr);
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

    public function cancel(){
        $request=request();
        $id=$request->param("id");
        db('user')->where('uid',$id)->update(["ifagent"=>0]);
    }

    public function pwd(){//修改密码
        $request=request();
        if(empty($request->param())){
            $id=cookie('user_id');
            cookie('user_id', null);
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
                model('member')->pwd($request->param());
            }
        }
    }
    public function type(){//停用、启用
        $request=request();
        $id=$request->param('id');
        $status=$request->param('status');
        model('member')->type($id,$status);
        echo true;
    }

}