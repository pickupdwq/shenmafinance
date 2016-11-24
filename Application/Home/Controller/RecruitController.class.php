<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class RecruitController extends HomeController {

	//什马金融首页
    public function recruit(){
        C('WEB_SITE_TITLE','什马金融 | 招聘');
        $job=M('recruit')
        ->join('picture on recruit.position_pic = picture.id')
        ->field('type,recruit.id,picture.path')
        ->select();
        foreach ($job as $key => $value) {
            $job[$key]['info']=M('recruit_detail')
            ->where(array('recruit_id'=>$value['id'],'if_top'=>'1'))
            ->field('if_top,position,num,recruit_detail.id,recruit_id')
            ->limit(2)
            ->select();
        }

        $top_banner=M('recruit_pic')
        ->join('picture on recruit_pic.banner = picture.id')
        ->find();

        $pic_array=M('work_pic')->select();
        foreach ($pic_array as $key => &$value) {
            $value=M('picture')->where(array('id'=>$value['picture_id']))->field('path')->find();
        }
        // dump($pic_array);
        // die;
        $this->assign('pic_array',$pic_array);
        $this->assign('banner',$top_banner);
        $this->assign('jobs',$job);
        $this->display();
    }


    public function recruit_detail($id = '',$recruit_id= ''){
        C('WEB_SITE_TITLE','什马金融 | 招聘详情');
        //导航进入判断是否手机版
        if($this->get('php_mobile')){
            $is_mobile=true;
            $this->assign('is_mobile',$is_mobile);
        }

        //招聘也判断是否手机版
        if($_GET['recruit_mobile']){
            $recruit_mobile=true;
            $this->assign('recruit_mobile',$recruit_mobile);
        }


        //显示大类详情
        if($_GET['id']){
            if($_GET['position']){
                $map['recruit_detail.id']=$_GET['position'];
                $recruit_detail=M('recruit_detail')
                ->where($map)
                ->join('recruit on recruit_detail.recruit_id = recruit.id')
                ->join('picture on recruit.position_pic = picture.id')
                ->field('recruit_detail.id as id,recruit_detail.*,picture.path')
                ->select();
                $this->assign('data',$recruit_detail);
            }
            else{
                $map['recruit_id']=$_GET['id'];
                $recruit_detail=M('recruit_detail')
                ->where($map)
                ->select();
                $this->assign('data',$recruit_detail);
            }
        }

        // if($_GET['position']&&$_GET['id']){
        //     $map['recruit_detail.id']=$_GET['position'];
        //     $data=M('recruit_detail')
        //     ->where($map)
        //     ->join('recruit on recruit_detail.recruit_id = recruit.id')
        //     ->join('picture on recruit.position_pic = picture.id')
        //     ->field('recruit_detail.id as id,recruit_detail.*,picture.path')
        //     ->find();
        //     $this->assign('data',$data);
        // }
        //传入参数recruit_id显示详情

        $recruit=M('recruit')
            ->field('type,id,position_pic')
            ->select();


        $recruit_detail=M('recruit_detail')
            ->select();

        foreach ($recruit as $key => &$res) {
            $res['info']=array();
            foreach ($recruit_detail as $key => $value) {
                if($res['id']==$value['recruit_id']){
                    array_push($res['info'],$value);
                }
            }
        }
        foreach ($recruit as $key => &$value) {
            $recruit[$key]['img']=M('picture')->where(array('id'=>$value['position_pic']))->field('picture.path')->find();
        }
        // var_dump($recruit);die;
        // die;

        //banner 头图
        $banner=M('recruit_pic')
        ->join('picture on recruit_pic.banner = picture.id')
        ->field('path')
        ->find();

        // var_dump($recruit);die;
        $this->assign('detail',$recruit);
        $this->assign('banner',$banner);
        $this->display();
    }

    public function detail(){

    }
}
