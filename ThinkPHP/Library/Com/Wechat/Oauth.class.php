<?php
namespace Com\Wechat;
use Com\Wechat\lib\WxPayConfig;

class Oauth{
	public $REDIRECT_URL="";
 	public $APPID="";
 	public $SECRET="";
 	
 	public $Code="";
 	public $State="";
 	public $Access_token="";
 	
 	public $Openid="";
 	
 	function __construct(){	
 		//默认使用的appid
 		$this->APPID=WxPayConfig::APPID;
 		$this->SECRET=WxPayConfig::APPSECRET;	
 	} 	
    
 	/**
 	 * 初始化参数。(包括微信接口参数$code、$state)
 	 * @param string $APPID
 	 * @param string $SECRET
 	 * @param string $REDIRECT_URL
 	 */
 	function init($REDIRECT_URL){
 		$this->REDIRECT_URL=$REDIRECT_URL;
 	}
 	
 	/**
 	 * 获取Code
 	 * (传递state参数)
 	 */
 	function get_code($state='1'){		
 		$APPID=$this->APPID;
 		$redirect_uri=$this->REDIRECT_URL;
 		$url_get_code="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";
 		header("Location: $url_get_code");//重定向请求微信用户信息
 	}
 	/**
 	 * 获取用户openid
 	 * @param string $redirect_uri
 	 * @param string $state 传参
 	 */
 	function get_openid(){
 		$APPID=$this->APPID;
 		$SECRET=$this->SECRET;
 		$code=$this->Code;
 		
 		$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$SECRET&code=$code&grant_type=authorization_code";
		$content=file_get_contents($url);
		$o=json_decode($content,true);
		$this->Openid=$o['openid'];
		return $o['openid'];
 	}
 	
 	/**
 	 * 授权获取code
 	 */
 	function get_code_by_authorize($state){
 		$APPID=$this->APPID;
 		$redirect_uri=$this->REDIRECT_URL;
 		$url_get_code="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";
 		header("Location: $url_get_code");//重定向请求微信用户信息		
 	}

 	/**
 	 * 授权获取用户信息
 	 */
 	function get_userinfo_by_authorize($code){
 		$APPID=$this->APPID;
 		$SECRET=$this->SECRET;
 		$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$SECRET&code=$code&grant_type=authorization_code";
 		$content=file_get_contents($url);
 		$o=json_decode($content,true);
 		$openid=$o['openid'];
 		$access_token=$o['access_token'];

 		
 		$url2="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
 		$content2=file_get_contents($url2);
 		$o2=json_decode($content2,true);//微信获取用户信息
 		//处理昵称里的特殊字符
 		$str_nickname=substr($content2,strpos($content2,",")+1);
        $str_nickname=substr($str_nickname,12,strpos($str_nickname,",")-13);
        
 		$data=array('nickname'=>'');
 		$data['nickname']=$str_nickname;
 		$data['headimgurl']=$o2['headimgurl'];
 		$data['sex'] = $o2['sex'];
        $data['openid'] = $o2['openid'];
        $data['unionid'] = $o2['unionid'];
 		return $data;
 		 		
 	}

    private function curlGetInfo($url){
        $ch = curl_init();
         
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         
        $info = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);
        }
        
        return $info;
    }
 	
 	
 }
?>