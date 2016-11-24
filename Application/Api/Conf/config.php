<?php
return array(
  //'配置项'=>'配置值'
  
    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则
    //注册
    array('user/zhuce', 'user/register', '', array('method' => 'post')),
    //资讯
    array('homepage/zixun', 'homepage/news', '', array('method' => 'GET')),
    //资讯详情，请传资讯id
    array('homepage/xiangqing', 'homepage/specific', '', array('method' => 'GET')),
    //专家简介
    array('homepage/yisheng', 'homepage/doctors', '', array('method' => 'GET')),
    //专家详情，请传专家id
    array('homepage/yi_xiangqing', 'homepage/doctors_detail', '', array('method' => 'GET')),
    //活动
    array('homepage/huodong', 'homepage/activity', '', array('method' => 'GET')),
    //活动详情，请传活动id
    array('homepage/act_xiangqing', 'homepage/activity_detail', '', array('method' => 'GET')),
    //个人信息
    array('user/geren', 'user/personal', '', array('method' => 'GET')),
    //快速入院,需要传$id
    array('apply/kuaisu', 'apply/quick_hospital', '', array('method' => 'POST')),
    //临床研究招募
    array('apply/linchuang', 'apply/clinical', '', array('method' => 'GET')),
     //发送验证码
    array('user/yanzhengma', 'user/send_sms', '', array('method' => 'GET')),
    //修改个人信息
    array('user/xiugaigeren', 'user/edit_personal', '', array('method' => 'POST')),
    //申请记录
    array('user/shenqingjilu', 'user/records', '', array('method' => 'GET')),
    //与会记录
    array('user/loginbbs', 'user/loginBbs', '', array('method' => 'POST')),  
    array('user/checkstatus', 'user/checkstatus', '', array('method' => 'GET')),   

 

    //是否注册，已经注册返回uid
    array('base/is_zhuce', 'base/registertest', '', array('method' => 'GET')),
    //快速入院第一步
    array('apply/diyibu', 'apply/step1', '', array('method' => 'POST')),
    //快速入院第二步,需要接收$id
    array('apply/dierbu', 'apply/step2', '', array('method' => 'POST')),
    //新闻
    array('homepage/xinwen', 'homepage/press', '', array('method' => 'GET')),
    //新闻详情，请传活动id
    array('homepage/xinwen_xiangqing', 'homepage/press_detail', '', array('method' => 'GET')),
    //微信签名
    array('wechat/getSignPackage', 'wechat/getSignPackage', '', array('method' => 'GET')),
     //微信下载头像
    array('wechat/downloadImage', 'wechat/downloadImage', '', array('method' => 'GET')),
    //护士宣教
    array('homepage/hushixuan', 'homepage/nurse_info', '', array('method' => 'GET')),
     //护士宣教详情
    array('homepage/huashixuanjiao', 'homepage/nurse_info_detail', '', array('method' => 'GET')),
     //线上入院
    array('apply/xianshangru', 'apply/online_in', '', array('method' => 'POST')),
     //线上出院
    array('apply/xianshangchu', 'apply/online_out', '', array('method' => 'POST')),

     //发送消息
    array('homepage/xiaoxi', 'homepage/information', '', array('method' => 'GET')),
    //提交
    array('homepage/tijiao', 'homepage/addMessage', '', array('method' => 'POST')),
    //评论详情
    array('homepage/xiangxi', 'homepage/details', '', array('method' => 'GET')),
    //已读状态
     array('homepage/zhuangtai', 'homepage/readstatus', '', array('method' => 'POST')),
     //患者信息
     array('homepage/huanzhe', 'homepage/patient', '', array('method' => 'POST')),
     //满意度
     array('homepage/manyidu', 'homepage/consultation', '', array('method' => 'POST')),
     //满意度问题
     array('homepage/wenti', 'homepage/question', '', array('method' => 'GET')),
     //个人信息
     array('homepage/gerenxinxi', 'homepage/person', '', array('method' => 'GET')),
     //修改个人信息
     array('homepage/xiugaixinx', 'homepage/edit_person', '', array('method' => 'POST')),
     //临床研究项目全部信息
     array('homepage/suoyou', 'homepage/detail', '', array('method' => 'GET')),
     //临床研究项目详情
     array('homepage/xiangq', 'homepage/research', '', array('method' => 'GET')),
     //临床项目申请提交
     array('homepage/subapp', 'homepage/sub_application', '', array('method' => 'POST')),
     //我的申请查询
     array('homepage/myshen', 'homepage/application', '', array('method' => 'GET')),
     //住院出院所有信息
     array('homepage/allxin', 'homepage/hospitalized', '', array('method' => 'GET')),
     //住院详情
     array('homepage/zhuxq', 'homepage/inhospital', '', array('method' => 'GET')),
     //临床项目报名
      array('homepage/baoming', 'homepage/enroll', '', array('method' => 'GET')),
      //医院须知
      array('homepage/xuzhi', 'homepage/must', '', array('method' => 'GET')),
     

     

     
    





 
  ),


    /* 文件上传相关配置 */
    'DOWNLOAD_UPLOAD' => array(
        'mimes'    => '', //允许上传的文件MiMe类型
        'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
        'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //允许上传的文件后缀
        'autoSub'  => true, //自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/Download/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '', //文件保存后缀，空则使用原后缀
        'replace'  => false, //存在同名是否覆盖
        'hash'     => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //下载模型上传配置（文件上传类配置）

  
       /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'onethink_home', //session前缀
    'COOKIE_PREFIX'  => 'onethink_home_', // Cookie前缀 避免冲突

    
    /* 图片上传相关配置 */
   
    
);

