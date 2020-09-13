<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:58
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Validate;

class Room extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('Room')->index();
        return $this->fetch('room',['arr'=>$arr]);

    }

    /**
     * 商品列表
     * @return mixed
     */
    public function rent(){
        $arr=array();
        $request=request();
        $id=0;
        if(isset($request->param()['id'])){

            $id=$request->param()['id'];
//            echo "存在---id=".$id;
            $arr=Db::view('join','*')
                ->view('dry_cate','name','join.cateid=dry_cate.Id')
                ->where("dry_cate.Id",$id)
                ->select();

//            print_r($arr);
        }else{
//            echo "--不存在";
            $arr=Db::view('join','*')
                ->view('dry_cate','name','join.cateid=dry_cate.Id')
                ->select();
        }
//        $arr=model("Room")->rent();
        return $this->fetch('rent',['arr'=>$arr,"id"=>$id]);
    }

    /**
     * 商品添加
     * @return mixed
     */
    public function rentadd(){//VIP卡添加

        $request=request();
//        print_r($request->param());
        if(count($request->param())<=1){
            //读取商品列表
            $list=Db::table("dry_cate")
                ->select();
            $this->assign("list",$list);
            return $this->fetch('rentadd',["id"=>$request->param()['id']]);
        }else{

//            exit;
            $validate = new Validate([
                'title'  => 'require|min:4|max:40|token',
                'price' => 'require|number'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo 0;
            }else{


                if(empty($_FILES['pic'])){
                    echo 1;
                }else {
//                    print_r($_FILES['pic']);
                    $pic=[];
                    $files = request()->file('pic');
//                    foreach($files as $file){
                        // 移动到框架应用根目录/public/uploads/ 目录下
                        $info = $files->move(ROOT_PATH . 'public' . DS . 'static/dbimg');
                        if($info){
                            // 成功上传后 获取上传信息
                            // 输出 jpg
//                            echo $info->getExtension();
                            // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                            echo $info->getSaveName();
                            $pic[]=$info->getSaveName();
                        }else{
                            // 上传失败获取错误信息
                            echo $files->getError();
                        }

                    $str = model('room')->rentadd($request->param(), $pic);
                    echo $str;
                }
            }
        }
    }

    /**
     * 商品编辑
     * @return mixed
     */
    public function rentetic(){//
        $request=request();
//        print_r($request->param());
        if(!empty($request->param()["shopid"])){
//            $id=cookie('join_id');
//            cookie('join_id',null);
            $id=$request->param()["shopid"];
//            echo $id;
            //商品列表
//            $list=Db::table("dry_cate")
//                ->select();

            $arr=Db::view('join','*')
                ->join("image","image.fid=join.Id")

                ->where('join.Id',$id)
                ->field("join.*,image.imageurl")
                ->find();
//            print_r($arr);
            return $this->fetch('rentetic',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'title'  => 'require|min:4|max:40|token',
                'price' => 'require|number'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo 0;
            }else{

                $data = [
                    'rtitle' => $request->param()['title'],
                    'rprice' => $request->param()['price'],
                    'content' => $request->param()['content'],
                    "count"=> $request->param()['count'],
                ];
                if(isset($request->param()['beginTime'])){
                    $data["beginTime"]=$request->param()['beginTime'];
                    $data["endTime"]=$request->param()['endTime'];
                }
                $id=$request->param("id");
                Db::table('dry_join')
                    ->where("Id",$id)
                    ->update($data);

                if(empty($_FILES['pic'])){
                    echo 1;
                }else {
//                    print_r($_FILES['pic']);
                    $pic="";
                    $files = request()->file('pic');
//                    foreach($files as $file){
                    // 移动到框架应用根目录/public/uploads/ 目录下
                    $info = $files->move(ROOT_PATH . 'public' . DS . 'static/dbimg');
                    if($info){
                        //删除原来的图片
                        $old=Db::table('dry_image')
                            ->where("fid",$id)
                            ->find();
                        $oldimg=$old["imageurl"];
                        unlink(ROOT_PATH."public/static/$oldimg");

                        $pic="dbimg/".$info->getSaveName();

                        Db::table('dry_image')
                            ->where("fid",$id)
                            ->update(["imageurl"=>$pic]);

                        echo 3;
                    }else{
                        // 上传失败获取错误信息
                        echo $files->getError();
                    }

                }
                // 提交事务
                Db::commit();

            }
        }
    }
    public function rentpic(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('join_id');
            cookie('join_id',null);
            $arr=model('room')->rentpic([],[],$id);
            $rid=$arr[0]['rid'];
//            print_r($rid);
//            exit;
            return $this->fetch('rentpic',['id'=>$id,'rid'=>$rid,'arr'=>$arr]);
        }else{
//            print_r($request->param()['imageid']);
//            exit;
            if(empty($_FILES['pic'])){
                echo false;
            }else {
                $pic=[];
                for ($i = 0; $i < count($_FILES['pic']['name']); $i++) {
                    if (($_FILES['pic']['type'][$i] == 'image/jpeg' | 'image/png') && $_FILES['pic']['error'][$i] == 0) {
                        if (is_uploaded_file($_FILES["pic"]["tmp_name"][$i])) {
                            $str = time() . rand(10000, 100000);
                            if (move_uploaded_file($_FILES["pic"]["tmp_name"][$i], "static/dbimg/$str.png")) {
                                $pic[] = $str . ".png";
                            } else {
                                foreach ($pic as $item) {
                                    unlink("static/dbimg/$item");
                                }
                                echo false;
                            }
                        } else {
                            echo false;
                        }
                    }
                }
                if(!empty($pic)){
                    $str = model('room')->rentpic($request->param(), $pic);
                    echo $str;
                }else{
                    echo false;
                }
            }
        }
    }

    public function rentdel(){//商品删除
        $request=request();
        $id=$request->param('id');
        $str=model('room')->rentdel($id);
        echo $str;
    }

    /**
     *设置库存
     */
    public function renttype(){
        $request=request();
        $id=$request->param('id');
        $count=$request->param('count');
//        echo "库存数据=".$count;
        db('join')->where('Id',$id)->update(['count' =>$count]);
        return true;

//        $str=model('room')->renttype($id,$status);
//        echo $str;
    }


}