<?php
namespace Com\Tianyi;

class Sms {
  const TOKEN_EXPIRE_TIME = 300;
  const SMS_SEND_DURATION = 60;
  /**
   * 发送短信
   */
  public static function sendSms($appId, $appSecret, $templateId, $phone, $tempParam){
    date_default_timezone_set ( 'Asia/Shanghai' );
    if(!$appId || !$appSecret || !$templateId){
      E("参数为空。");
    }
    if (! $phone) {
      E("phone为空");
    }
    if (strlen ( $phone ) != 11 || substr ( $phone, 0, 1 ) != '1') {
      E("phone格式错误");
    }
    if(is_array($tempParam)){
      $tempParam = json_encode($tempParam);
    }
    $timestamp = date ( 'Y-m-d H:i:s' );
    $grant_type = "client_credentials";
    // 获取Accesss Token
    if (S ( $appId . 'access_token' )) {
      $access_token = S ( $appId . 'access_token' );
    } else {
      $url = "https://oauth.api.189.cn/emp/oauth2/v3/access_token";
      $postdata = 'app_id=' . $appId . '&app_secret=' . $appSecret . '&grant_type=' . $grant_type;
      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt ( $ch, CURLOPT_POST, 1 );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postdata );
      curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
      curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
      $data = curl_exec ( $ch );
      curl_close ( $ch );
      $data = json_decode ( $data, true );
      $access_token = $data ['access_token'];
      if(!$access_token){
        E("获取access_token失败: ".$data['res_message']);
      }
      S ($appId . 'access_token', $access_token,
         array (
          'type'=>'file',
          'expire' => $data ['expires_in']
      ));
    }
    // 发送模板短信
    $url = "http://api.189.cn/v2/emp/templateSms/sendSms";
    $postdata = 'timestamp=' . $timestamp . '&acceptor_tel=' . $phone . '&template_id=' . $templateId . '&template_param=' . $tempParam . '&app_id=' . $appId . '&access_token=' . $access_token;
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postdata );
    $data = curl_exec ( $ch );
    curl_close ( $ch );
    $data = json_decode ( $data, true );
    if ($data ['res_code'] === 0) {
      return "successful";
    } else {
      E( $data ['res_message']);
    }
  }

  public static function sendToken($appId, $appSecret, $templateId, $phone) {
    if (! $phone) {
      E("phonenumber为空");
    }
    if (strlen ( $phone ) != 11 || substr ( $phone, 0, 1 ) != '1') {
      E("phonenumber格式错误");
    }

    $token = self::getCachedToken ($phone, true);
    if (! $token || ! $token ['token'] || $token ['create_time'] + self::TOKEN_EXPIRE_TIME <= time ()) {
      // 产生6位随机数并缓存
      $tmp = ( string ) lcg_value ();
      $token = substr ( $tmp, 2, 6 );
    } else {
      $token = $token ['token'];
    }
    $template_param = json_encode ( array (
        "code" => $token,
        "time" => self::TOKEN_EXPIRE_TIME/60
    ) );
    self::saveCacheToken ( $phone, $token );
    return self::sendSms ($appId, $appSecret, $templateId, $phone, $template_param );
  }
  
  /**
   * 验证验证码和手机号是否匹配
   * @param  $phone 电话号码
   * @param  $token 验证码
   * @return number
   */
  public function randCodeCheck($phone, $token) {
    $cache_prefix = 'token_';
    $last2Digit = substr ( $phone, 9, 2 );
    $map = S ( $cache_prefix . $last2Digit );
    if ($map [$phone]) {
      if ($map [$phone] ['create_time'] + self::TOKEN_EXPIRE_TIME > time ()) {
        if ($map [$phone] ['token'] == $token) {
          return 1;
          // correct
        } else
          return 2;
        // 验证码错误
      } else
        return 0;
      // 验证码过期
    }
    return - 1;
    // 系统错误
  }

  private static function saveCacheToken($phone, $token) {
    $cache_prefix = 'token_';
    $last2Digit = substr ( $phone, 9, 2 );
    $map = S ( $cache_prefix . $last2Digit );
    $map [$phone] = array (
        'token' => $token,
        'create_time' => time () 
    );
    S ( $cache_prefix . $last2Digit, $map, 3600 * 24 );
  }

  private static function getCachedToken($phone) {
    $cache_prefix = 'token_';
    $last2Digit = substr ( $phone, 9, 2 );
    $map = S ( $cache_prefix . $last2Digit );
    if ($map [$phone]) {
      if ($map [$phone] ['create_time'] + self::SMS_SEND_DURATION > time ()) {
        E( "发送验证码时间小于" . self::SMS_SEND_DURATION . '秒' );
      }
      return $map [$phone];
    }
  }

}