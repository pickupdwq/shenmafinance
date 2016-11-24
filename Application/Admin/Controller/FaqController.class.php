<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class FaqController extends ThinkController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */

    public function deletefaq($model = null, $ids=null){
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');

        $ids = array_unique((array)I('ids',0));

        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }
    	if($_GET['delete_all']){
    		M('faq_other')->where(array('main_id' => array('in', $ids) ))->delete();
    		M('faq_question')->where(array('main_id' => array('in', $ids) ))->delete();
    	}

        $Model = M(get_table_name($model['id']));
        $map = array('id' => array('in', $ids) );
        if($Model->where($map)->delete()){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    public function deleteother($model = null, $ids=null){
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');

        $ids = array_unique((array)I('ids',0));

        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }
    	if($_GET['delete_all']){
    		M('faq_question')->where(array('other' => array('in', $ids) ))->delete();
    	}

        $Model = M(get_table_name($model['id']));
        $map = array('id' => array('in', $ids) );
        if($Model->where($map)->delete()){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    public function lists($model = null, $p = 0){
        if($_GET['main_id']){
            $other=M('faq_other')->where(array('main_id'=>$_GET['main_id']))->select();
            // dump($other);
            $this->assign('others',$other);
        }

        $cat=M('faq')->select();
        $this->assign('cat',$cat);

        parent::lists($model, $p);
    }

    public function add_faq($id){
        
        if($_POST){
            $data=$_POST;
            if(!$data['question']){
                $this->error('问题不能为空!');
            }
            if(!$data['ask']){
                $this->error('答案不能为空');
            }
            $is_success=M('faq_question')->add($data);
            if($is_success){
                $this->success('新增成功',U('Admin/Faq/lists/model/faq_other/'));
                return;
            }
            else{   
                $this->error('增加失败');
            }
        }

        $infos=M('faq_other')->find($id);

        $infos['main']=M('faq')->where(array('id'=>$infos['main_id']))->find();
        $this->assign('info',$infos);
        $this->display();
  }

    public function edit_question($id){


        if($_POST){
            // dump($_POST);die;
            if(!$_POST['ask']){
                $this->error('答案不能为空!');
                return ;
            }
            if(!$_POST['question']){
                $this->error('问题不能为空!');
                return;
            }
            $data=M('faq_question')->save($_POST);
            if($data){
                $this->success('修改成功');
                return;
            }
            else{
                $this->error('修改失败');
            }
        }

        $infos=M('faq_question')
        ->where(array('faq_question.id'=>$id))
        ->join('faq on faq_question.main_id = faq.id')
        ->join('faq_other on faq_question.other = faq_other.id')
        ->field('faq_question.*,faq.main,faq_other.other as other_info')
        ->find();

        // dump($infos);die;
        $this->assign('info', $infos);
        $this->display();
    }
}
