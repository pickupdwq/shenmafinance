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
class FaqController extends HomeController {

    //什马金融首页
    public function faq(){
        C('WEB_SITE_TITLE','什马金融 | 客服中心');
        if($_GET['id']){
            $map['id']=$_GET['id'];
            $data=M('faq_question')
            ->where($map)
            ->find();
            $data['ask']=nl2br($data['ask']);
            $this->ajaxReturn($data,'',202,'');
        }


        //获取问题以及答案
        $faq=M('faq_question')
        ->select();

        $mains=M('faq')
        ->field('main,id')
        ->select();
        // dump($faq);
        $main_others=M('faq_other')
        ->field('other,main_id,id')
        ->select();


        // /*二级问题循环*/
        // foreach ($main as $key => &$valuemain) {
        //     foreach ($main_other as $key2 => $value) {
        //         if($value['main_id']==$valuemain['id']){
        //             $main[$key]['other'][] = $value['other'];
        //         }
        //     }
        // }

        // dump($main_other);
        /*三级问题循环*/
        $cat_2 = array();
        $cat_1 = array();
        foreach ($faq as $key => $qa) {
          $cat_2[$qa['other']][] = $qa;  
        }
        foreach ($main_others as $key => $main_other) {
            $cat_1[$main_other['main_id']][] = array('qas'=>$cat_2[$main_other['id']],
                'name'=>$main_other['other']);
        }
        foreach ($mains as $key => $main) {
            $mains[$key]['main'] = $main['main'];
            $mains[$key]['other'] = $cat_1[$main['id']];
        }

        $banner=M('faqpic')->join('picture on faqpic.pic_id = picture.id')->field('path')->find();

        $this->assign('banner',$banner['path']);
        $this->assign('mains',$mains);
        $this->display();
    }


    //获取问题详情  传入Id
    public function get_question(){
        if(!I('get.id')){
            $this->ajaxReturn('请输入需要查询的问题id');
        }
        $map['id']=I('get.id');
        $data=M('faq_question')
        ->where($map)
        ->select();

        $this->ajaxReturn($data);
    }

}
