<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Cookie;
class Index extends Controller
{
    public function index(){
        if(Cookie::has('admin')){

            $cate=Db::view('cate','*')
                ->select();
//            print_r($cate);

            return $this->fetch('home',["cate"=>$cate]);
        }else{
            $arr=Array ( 'user' => '' ,'pwd' => '' );
            return $this->fetch('login',['arr'=>$arr]);
        }
    }
    public function login(){
        $request=request();
        if(!empty($request->param())){
            $admin=$request->param('user');
            $pwd=model('index')->login($admin);
            if($pwd==md5(sha1($_POST['pwd']))){
                cookie('admin', $admin,10800);
                header("location:index");
            }else{
                return $this->fetch('login',['arr'=>$request->param()]);
            }
        }
    }
    public function home(){
        return $this->fetch('welcome');
    }
    public function quit(){
        cookie('admin',null);
        header("location:index");
    }
}

