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
class IndexController extends HomeController {

	//系统首页
    public function index(){
        C('WEB_SITE_TITLE','什马金融首页');
        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页


        //首页banner 以及文字
       	$data=M('indexpage')
       	->where(array('is_show'=>'1'))
       	->join('picture on indexpage.banner = picture.id')
       	->field('indexpage.*,picture.path')
       	->select();
        
        foreach ($data as $key => &$value) {
          $value['mobile_path']=M('picture')->where(array('id'=>$value['mobile_banner']))->field('path')->find();
        }

        // dump($data);
        // die;

        //地图信息
        $map=M('map')
        ->join('picture on map.avatar = picture.id')
        ->field('map.*,picture.path')
        ->select();
        // dump($map);


        //最后一页配置
        $last_info=M('index_last')
        ->join('picture on index_last.last_pic = picture.id')
        ->field('lastinfo,path')
        ->find();


        // dump($last_info);die;
        $this->assign('last_info',$last_info['lastinfo']);
        $this->assign('last_img',$last_info['path']);
          // dump($map);
          // die;
        $this->assign('datas',$data);
        $this->assign('map',$map);
        $this->display();
    }


}
