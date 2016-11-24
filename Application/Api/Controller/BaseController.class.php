<?php
namespace Api\Controller;
use Think\Controller;
use Think\Upload;
use Think\Controller\RestController;
class BaseController extends RestController{
	public function securityTest(){
  	$uid =is_login();//session('user');
    if(!$uid){
      $this->response(array('info'=>'未登录，或者未使用微信浏览器开启页面'),json,401);
    }
	return $uid;
  }

    public function registertest(){
    	$uid=$this->securityTest();
    	$data=M('user')->where("uid=$uid")->find();
    	$uid=$data['uid'];
    	if(empty($uid)){
      $this->response(array('info'=>'未注册'),json,402);
    }
	return $uid;

    }

   




	public function processData(&$data, $model_name){
    $model = M('Model')->getByName($model_name);
    $fields = get_model_attribute($model['id'], false);
    foreach ($fields as $key => $field){
      if($field['type'] =='picture'){
        $data[$field['name']] = $this->get_cover($data[$field['name']], 'path');
      }elseif($field['type'] =='file'){
        $data[$field['name']] = $this->get_cover_audio($data[$field['name']], 'savepath');
      }
    }
  }

	public function getLists($pid){
		$list =M('category')->where(array('pid'=>$pid))->select();
		if($list){
			$this->response(array('info'=>$list),json,200);
		}$this->response(array('info'=>"没找到相关信息"),json,400);
	}
	public function uploadPic(){
		$config  =array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 20*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => './Uploads/Images/', //保存根路径
		'savePath' => '', //保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
		); //图片上传相关配置（文件上传类配置）
		$upload = new \Think\Upload($config);// 实例化上传类// 实例化上传类
		$image = new \Think\Image(); 
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
			$error =$upload->getError();
			$this->response(array('status'=>0,'info'=>$error),json,400);
		}else{// 上传成功 获取上传文件信息
				$file =$info['file'];
				$newname ='new'.$file['savename'];
				$path = substr($config['rootPath'].$file['savepath'].$file['savename'],2);
				$newpath =substr($config['rootPath'].$file['savepath'].$newname,2);
				$source = imagecreatefromjpeg($path);
				$exif = exif_read_data($path);
				if(!empty($exif['Orientation'])) {
				switch($exif['Orientation']) {
					case 8:
					$source = imagerotate($source,90,0);
					break;
					case 3:
					$source = imagerotate($source,180,0);
					break;
					case 6:
					$source = imagerotate($source,-90,0);
					break;
				}
				imagejpeg($source,$path);
				}
				
				$image->open($path);
				$re =$image->thumb(300, 300,\Think\Image::IMAGE_THUMB_FIXED)->save($newpath);
			}
			$data =array('old_path'=>'/'.$path,'new_path'=>'/'.$newpath);
			return $data;
		
	}

	public function array_unique_fb($array2D){
		foreach ($array2D as $k =>$v){
			$v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[] = $v;
		}
		$temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
		foreach ($temp as $k => $v){
			$temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
		}
		return $temp;
}

 




}