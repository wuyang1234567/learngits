<?php
namespace app\index\model;


use think\Db;

class Rents
{

    public function rents($address,$page,$type="")
    {

        $data = Db::name("room")
            ->alias("r")
            ->join('join j','r.rid = j.rid')
            ->join('image img','j.id = img.fid')
            ->where("img.imagetype",0)//房间用图
            ->where("r.rcity",$address)//定位
            ->where("r.rrentType",$type)//合租   整租
            ->where("j.rstatus",0)//出租状态
            ->field('img.fid,img.imageurl,j.rtitle,j.rareas,j.rprice,r.raddress,r.rnum,r.rrentType')
            ->page($page,5)
            ->select();
        return $data;
    }

    public function rentsNoType($address,$page)
    {
        $data = Db::name("join")
            ->alias("j")
            ->join('agent a','j.gid = a.gid')
            ->join('image img','j.id = img.fid')
            ->where("img.imagetype",0)//房间用图
            ->where("j.rstatus",0)//出租状态
            ->distinct(true)
            ->field('img.Id')
            ->field('img.imageurl,j.*,a.gaccent')
            ->select();


        return $data;
    }



    public function detailTop($fid)
    {
        $data = Db::name("join")
            ->alias("j")
            ->join('agent a','j.gid = a.gid')
            ->join('image img','j.id = img.fid')
            ->where("img.fid",$fid)
            ->field('img.fid,j.rtitle,j.rprice,img.imageurl,j.rareas,j.rtype,j.rdirection,j.content,a.gaccent')
            ->select();
        return $data;
    }

    public function houseAllocation($fid)
    {
        $data = Db::name("image")
            ->alias("img")
            ->join('house_allocation ha','img.rid = ha.rid')
            ->where("img.fid",$fid)
            ->select();
        return $data;
    }

    public function housemate($fid)
    {
        $data = Db::name("image")
            ->alias("img")
            ->join('join j','img.rid = j.rid')
            ->join('room r','r.rid = j.rid')
            ->join('user u','u.uid = j.uid',"left")
            ->where("img.fid",$fid)
            ->field('j.id,r.rrentType,j.rname,j.rstatus,j.rareas,j.rdirection,j.uendTime,j.uenterTime,j.rprice,u.usex,r.raddress,r.renterTime')

            ->select();
        return $data;
    }

}
