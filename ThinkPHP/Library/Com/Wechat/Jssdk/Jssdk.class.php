<?php
namespace Com\Wechat\Jssdk;
use  Com\Wechat\lib\WxPayConfig;

use Com\Wechat\AccessToken;
class Jssdk {
  const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
  const MEDIA_GET_URL = '/media/get?';

  public function getSignPackage($url) {
    $jsapiTicket = $this->getJsApiTicket();

    if(!$url){
      // 注意 URL 一定要动态获取，不能 hardcode.
      $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
      $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => WxPayConfig::APPID,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    $data = S('jsapi_ticket');
    if (!$data) {
      $accessToken = AccessToken::getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
        S('jsapi_ticket',$ticket, 7000 );
      }
    } else {
      $ticket = $data;
    }
    return $ticket;
  }
  
  public function getMedia($media_id,$is_video=false){
    $accessToken = AccessToken::getAccessToken();
    //原先的上传多媒体文件接口使用 self::UPLOAD_MEDIA_URL 前缀
    //如果要获取的素材是视频文件时，不能使用https协议，必须更换成http协议
    $url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
    $result = $this->httpGet($url_prefix.self::MEDIA_GET_URL.'access_token='.$accessToken.'&media_id='.$media_id);
    if ($result)
    {
      if (is_string($result)) {
        $json = json_decode($result,true);
        if (isset($json['errcode'])) {
          $this->errCode = $json['errcode'];
          $this->errMsg = $json['errmsg'];
          return false;
        }
      }
      return $result;
    }
    return false;
  }


  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt ( $curl, CURLOPT_SSLVERSION, 1 );

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
}

