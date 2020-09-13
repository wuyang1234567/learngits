<?php
namespace app\index\model;


use think\Db;

class Index
{
    public function index($address)
    {
        $data = Db::name("room")
                ->alias("r")
                ->join('join j','r.rid = j.rid')
                ->join('agent a','a.gid = j.gid')
                ->join('image img','j.Id = img.fid')
                ->where("img.imagetype",0)
                ->where("r.rcity",$address)
                ->where("j.rstatus",0)
                ->field('r.rid,img.imageurl,j.rtitle,j.rprice,r.raddress,r.rrentType,img.fid')
                ->limit(5)
                ->group("j.rprice")
                ->select();

        return $data;
    }

    public function forget($tel){

    }
}
