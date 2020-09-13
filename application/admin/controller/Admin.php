<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\Cookie;
class Admin extends Controller
{
    public function index(){

        $arr=db('admin as a')
            ->field('a.aid,a.aname,a.atime')
            ->select();
        return $this->fetch('admin',['arr'=>$arr]);
    }
    public function adminadd(){//添加管理员
        $request=request();
        if(empty($request->param())){
            return $this->fetch('adminadd');
        }else{
            $validate = new Validate([
                'adminName'  => 'require|token',
                'password' => 'require|max:20',
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $arr=$request->param();
                $data = [
                    'aname' => $arr['adminName'],
                    'apwd' => md5(sha1($arr['password'])),
                    'atime' => date("Y-m-d h:i:s",time()),
                ];
                db('admin')->insert($data);
                return true;

            }
        }
    }
    public function adminetic(){//编辑管理员
        $request=request();
        if(empty($request->param())){
            $aid=cookie('admin_id');
            cookie('admin_id', null);
            $arr=db('admin')->where('aid',$aid)->find();
            return $this->fetch('adminetic',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'adminName'  => 'require|token',
                'password' => 'require|max:20',

            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());


                $arr=$request->param();
                $data = [
                    'aname' => $arr['adminName'],
                    'apwd' => md5(sha1($arr['password'])),

                ];
                $aid=$arr['id'];
                db('admin')->where('aid',$aid)->update($data);

                return true;
            }
        }
    }
    public function adel(){//管理员删除
        $request=request();
        $aid=$request->param('aid');
        model('admin')->adel($aid);
        echo true;
    }
    public function atype(){//管理员停用/开始
        $request=request();
        $aid=$request->param('aid');
        $status=$request->param('astatus');
        model('admin')->atype($aid,$status);
        echo true;
    }
    public function role(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model("admin")->role();
//        print_r($arr);
        return $this->fetch('role',['type'=>$type,'arr'=>$arr]);
    }
    public function radd(){//增加角色
        $request=request();
        if(empty($request->param())){
            return $this->fetch('radd');
        }else{
            $validate = new Validate([
                'role' => 'require',
                'beizhu' => 'require'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
                print_r($request->param());
                model('admin')->radd($request->param());
                echo false;
            }
        }
    }
    public function rcate(){//角色授权
        $request=request();
        if(empty($request->param())){
            $id=cookie('role_id');
            $arr=model('admin')->rcate();
//            print_r($arr);
//            exit;
            return $this->fetch('rcate',['arr'=>$arr,'id'=>$id]);
        }else{
//            print_r($request->param());
            model('admin')->rcate($request->param());

        }
    }
    public function retic(){//编辑角色
        $request=request();
        if(empty($request->param())){
            $id=cookie('role_id');
            $arr=model('admin')->retic([],$id);
            return $this->fetch('retic',['arr'=>$arr,'id'=>$id]);
        }else{
            $validate = new Validate([
                'role' => 'require',
                'beizhu' => 'require'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
                print_r($request->param());
                model('admin')->retic($request->param());
            }
        }
    }
    public function rdel(){//删除角色
        $request=request();
        $id=$request->param('id');
        model('admin')->rdel($id);
        echo true;
    }

}