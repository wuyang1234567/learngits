<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:58
 */

namespace app\admin\model;
use think\Db;
class Room
{
    public function index(){

        $data = Db::name("join")
            ->alias("j")
            ->join('agent a','j.gid = a.gid')
            ->field('j.*,a.gname,a.gtel,a.gemail')
            ->select();
        return $data;
    }

    public function roomadd($arr,$agent=''){
        if(empty($arr)){
            $arr=db('agent')
                ->where('gname',$agent)
                ->find();
            return $arr['gid'];
        }else{
            $sarr=db('housers')
                ->where('ssign',4)
                ->where('stel',$arr['tel'])
                ->find();
            if(empty($sarr)){
                return false;
            }else{
                $data = [
                    'roomType' => $arr['type'],
                    'rdecorate' => $arr['decoriate'],
                    'rfloor' => $arr['floor'].'/'.$arr['floors'],
                    'rrentType' => $arr['rtype'],
                    'raddress' => $arr['addr'],
                    'renterTime' => $arr['time'],
                    'sid' => $sarr['Id'],
                    'gid' => $arr['id'],
                ];
                db('room')->insert($data);
                return true;
            }
        }
    }
    public function roometic($arr,$rid=''){
        if(empty($arr)){
            $arr=Db::view('room','*')
                ->view('dry_housers','stel','room.sid=dry_housers.Id')
                ->where('room.rid',$rid)
                ->find();
            return $arr;
        }else{
            $sarr=db('housers')
                ->where('stel',$arr['tel'])
                ->where('ssign',4)
                ->find();
            if(empty($sarr)){
                return false;
            }else{
                $data = [
                    'roomType' => $arr['type'],
                    'rdecorate' => $arr['decoriate'],
                    'rfloor' => $arr['floor'].'/'.$arr['floors'],
                    'rrentType' => $arr['rtype'],
                    'raddress' => $arr['addr'],
                    'renterTime' => $arr['time'],
                    'sid' => $sarr['Id'],
                    'gid' => $arr['gid'],
                ];
                db('room')->where('rid',$arr['rid'])->update($data);
                return true;
            }
        }
    }
    public function roomdel($rid){
        Db::startTrans();
        try{
            Db::table('dry_room')->where('rid',$rid)->delete();
            Db::table('dry_join')->where('rid',$rid)->delete();
            $arr=Db::table('dry_image')->where('rid',$rid)->select();
            Db::table('dry_image')->where('rid',$rid)->delete();
            // 提交事务
            Db::commit();
            foreach($arr as $item){
                unlink("static/$item");
            }
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }
    public function rent(){
        $arr=Db::view('join','*')
            ->view('dry_cate','name','join.cateid=dry_cate.Id')
            ->select();
        return $arr;
    }
    public function rentadd($arr,$pic,$gid=''){

        if(empty($arr)){
            $arr=db('room')
                ->field('rid,raddress')
                ->select();
            return $arr;
        }else{

            $data = [
                'rtitle' => $arr['title'],
                'rprice' => $arr['price'],
                'cateid' => $arr['cateId'],
                'rstatus' => 0,
                'content' => $arr['content'],
                "count"=> $arr['count'],
                "beginTime"=>$arr['beginTime'],
                "endTime"=>$arr['endTime']
            ];
            Db::startTrans();
            try{
                Db::table('dry_join')->insert($data);
                $id = Db::table('dry_join')->getLastInsID();
                $data1 = [];
                foreach($pic as $key=>$value){
                    if($key==0)
                        $data1[]=['imagetype' => 0 ,'imageurl' => "dbimg/".$value , 'fid' => $id ];
                    else
                        $data1[]=['imagetype' => 1 ,'imageurl' => "dbimg/".$value , 'fid' => $id ];
                }
                Db::table('dry_image')->insertAll($data1);
                // 提交事务
                Db::commit();
                return 3;
            } catch (\Exception $e) {
                // 回滚事务
                foreach($pic as $item){
                    unlink("static/dbimg/$item");
                }
                Db::rollback();
                return 2;
            }
//            db('join')->insert($data);
//            return true;
        }
    }
    public function rentetic($arr,$id=''){
        if(empty($arr)){
            $arr=Db::view('join','*')
                ->where('Id',$id)
                ->find();
            $arr1=Db::view('room','rid,raddress')
                ->where('gid',db('room')->where('rid',$arr['rid'])->find()['gid'])
                ->select();
            $arr2=array($arr,$arr1);
            return $arr2;
        }else{
            $data = [
                'rid' => $arr['rid'],
                'rtitle' => $arr['title'].$arr['titles'],
                'rareas' => $arr['area'],
                'rdirection' => $arr['direction'],
                'rprice' => $arr['price'],
                'rtype' => $arr['rtype'],
                'rstatus' => 0,
                'rname' => $arr['titles'],

            ];
            db('join')->where('Id',$arr['id'])->update($data);
            return true;
        }
    }
    public function rentpic($arr,$pic,$id=''){
        if(empty($arr)){
            $arr=db('image')->where('fid',$id)->select();
            return $arr;
        }else{
            Db::startTrans();
            try{
                $del=[];
                if(!empty($arr['imageid'])){
                    foreach($arr['imageid'] as $item){
                        $items=Db::table('dry_image')->where('Id',$item)->field('imageurl')->find();
                        $del[]=$items['imageurl'];
                    }
                    Db::table('dry_image')->delete($arr['imageid']);
//                    print_r($arr['imageid']);
                }
                $data = [];
                foreach($pic as $item){
                    $data[]=['rid' => $arr['rid'], 'imagetype' => 0 ,'imageurl' => "dbimg/".$item , 'fid' => $arr['id'] ];
                }
                Db::table('dry_image')->insertAll($data);
                // 提交事务
                Db::commit();
                foreach($del as $item){
                    unlink("static/$item");
                }
                return true;
            } catch (\Exception $e) {
                // 回滚事务
                foreach($pic as $item){
                    unlink("static/dbimg/$item");
                }
                Db::rollback();
                return false;
            }
        }
    }
    public function rentdel($id){
        Db::startTrans();
        try{
            Db::table('dry_join')->where('Id',$id)->delete();
            $arr=Db::table('dry_image')->where('fid',$id)->select();
            Db::table('dry_image')->where('fid',$id)->delete();
            // 提交事务
            Db::commit();
            foreach($arr as $item){
                unlink("static/$item");
            }
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }
    public function renttype($id,$status){

        db('join')->where('Id',$id)->update(['rstatus' =>$status]);
        return true;
    }
    public function order(){

    }
}