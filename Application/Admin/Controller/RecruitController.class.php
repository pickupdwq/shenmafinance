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
class RecruitController extends ThinkController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function top($id){
	    if(!$id){
	      $this->error('参数错误');
	    }
	    $res = M('recruit_detail')->find($id);
	    $res['if_top'] = 1;
	    $re = M('recruit_detail')->where(array('id'=>$id))->save($res);
	    $this->success('已置顶！');
  	}

  public function untop($id){
    if(!$id){
      $this->error('参数错误');
    }
    $res = M('recruit_detail')->find($id);
    $res['if_top'] = 0;
    $re = M('recruit_detail')->where(array('id'=>$id))->save($res);
    $this->success('已取消置顶！');
  }

  public function deleterecruit($model = null, $ids=null){
        $model = M('Model')->find($model);
        $model || $this->error('模型不存在！');

        $ids = array_unique((array)I('ids',0));

        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }
      if($_GET['delete_all']){
        M('recruit_detail')->where(array('recruit_id' => array('in', $ids) ))->delete();
      }

        $Model = M(get_table_name($model['id']));
        $map = array('id' => array('in', $ids) );
        if($Model->where($map)->delete()){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

  public function get_now($id){
        if(!$id){
            $this->error('参数错误');
        }
        $change['id']=$id;
        $change['status']=1;
        $data=M('recruit_detail')->save($change);
        if($data){
            $this->success('重新招聘成功!');
        }
  }

  public function get_stop($id){
        if(!$id){
            $this->error('参数错误');
        }
        $change['id']=$id;
        $change['status']=0;
        $data=M('recruit_detail')->save($change);
        if($data){
            $this->success('停招成功!');
        }
  }

  public function lists($model = null, $p = 0){
      if($_GET['model']=='recruit_detail'){
          $types=M('recruit_detail')
          ->join('recruit on recruit_detail.recruit_id = recruit.id')
          ->field('recruit.id,type')
          ->group('type')
          ->select();
          $this->assign('types',$types);
      }
      if($_GET['model']=='work_pic'){
          $work=M('work_pic')->count();
          // dump($work);
          // die;
          $this->assign('work',$work);
      }
      parent::lists($model, $p);
  }
}
