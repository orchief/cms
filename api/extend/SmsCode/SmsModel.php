<?php

/**
 * Class SmsModel
 *  生成短信验证码
 */
namespace SmsCode;
class SmsModel{
    protected $error = '短信服务商错误';
    protected $length = 4;
    protected $code;

    /**
     *  向提供的手机号发送验证码
     * @param $phone string 手机号
     * @return mixed
     *
     */
    public function getCode($phone)
    {
        $this -> RandomCode();
        $res = $this -> sendSms($phone);
        session('code', $this -> code);
        session('CellPhone', $phone);
        return $res;
    }

    /**
     * @param $phone string 手机号
     * @return bool
     * 调用服务商接口 发送短信
     */
    public function sendSms($phone)
    {
        // p($phone);
        header('content-type:text/html;charset=utf-8');
        // $sendUrl = 'http://www.cingreen.cn:8082/MT1.ashx';  //短信接口的URL
        $sendUrl = 'http://v.juhe.cn/sms/send';
        $smsConf['key'] = config('smsConf.key');
        $smsConf['mobile'] = $phone;
        $smsConf['tpl_id'] = config('smsConf.tpl_id');
        $smsConf['tpl_value'] = '#code#='.$this -> code.'&#company#='.config('smsConf.company');

        // $smsConf['src'] = 'qdyd001';
        // $smsConf['pwd'] = 'qdyd456';
        // $smsConf['serviceID'] = 'SEND';
        // $smsConf['msg'] = "尊敬的用户，您的验证码是".$this -> code."，感谢您的惠顾【婴盾母婴商城】";
        // $smsConf['dest'] = $phone;

        $content = $this -> juhecurl($sendUrl,$smsConf,1); //请求发送短信
        if($content == 0){
            return true;
        }else{
            $this -> error = $content;
            return false;
        }
    }

    public function getError()
    {
        return $this -> error;
    }

    /**
     * 生成指定位数的短信验证码
     */
    protected function RandomCode()
    {
        $this -> length = config('smsConf.length');
        $min = (int)'1'.str_repeat('0', $this -> length - 1);
        $max = (int)str_repeat('9', $this -> length);
       $this -> code = mt_rand($min, $max);
    }
 
    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    public function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}