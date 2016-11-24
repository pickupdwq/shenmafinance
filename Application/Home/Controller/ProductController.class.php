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
class ProductController extends HomeController {

	//产品首页
    public function product(){
        C('WEB_SITE_TITLE','什马金融 | 产品');
      $data['top']=M('product')
      ->where(array('type'=>'1'))
      ->join('picture on product.pic = picture.id')
      ->find();

      $data['top']['qrcode']=M('product')
      ->where(array('type'=>'1'))
      ->join('picture on product.qrcode = picture.id')
      ->find();

      $data['bottom']=M('product')
      ->where(array('type'=>'0'))
      ->join('picture on product.pic = picture.id')
      ->find();

      $data['bottom']['qrcode']=M('product')
      ->where(array('type'=>'0'))
      ->join('picture on product.qrcode = picture.id')
      ->find();

      $data['top']['head_3']=nl2br($data['top']['head_3']);
      $data['bottom']['head_3']=nl2br($data['bottom']['head_3']);
      // var_dump($data);
      $this->assign('data',$data);
      $this->display();
    }

}
