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
class FinanceController extends HomeController {

	//什马金融首页
    public function finance(){
        C('WEB_SITE_TITLE','什马金融 | 关于我们');
        //banner
        $data=M('finance')
        ->where(array('is_show'=>'1'))
        ->join('picture on finance.banner = picture.id')
        ->field('finance.*,picture.path')
        ->select();
        // dump($data);


        //获取公司信息
        $company=M('company')
        ->find();
        // dump($company);


        //获取团队成员信息
        $team=M('team')
        ->join('picture on team.avatar = picture.id')
        ->field('team.*,picture.path')
        ->order('team.order asc')
        ->select();
        // dump(count($team));
        // die;


        //获取投资机构信息
        $invest=M('invest')
        ->join('picture on invest.invest_pic = picture.id')
        ->field('invest.*,picture.path')
        ->order('invest.order asc')
        ->select();
        // dump($invest);

        //获取金融机构信息
        $banking=M('banking')
        ->join('picture on banking.banking_pic = picture.id')
        ->field('banking.*,picture.path')
        ->order('banking.order asc')
        ->select();
        // dump($banking);

        //获取媒体信息
        $media=M('media')
        ->order('media.order asc')
        ->select();
        // dump($media);


        //获取公司事件信息
        $event=M('event')
        ->order('date asc')
        ->select();
        // dump($event);

        $this->assign('company',$company);
        $this->assign('invests',$invest);
        // dump($team);die;
        $this->assign('teams',$team);
        $this->assign('banner',$data);
        $this->assign('banking',$banking);
        $this->assign('medias',$media);
        $this->assign('events',$event);
        $this->display();
    }

}
