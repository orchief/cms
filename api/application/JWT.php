<?php
namespace app;
use \Firebase\JWT\JWT as jwtoken;

/**
 * jwt
 */
class JWT
{
    /**
     * 负载部分
     */
    static $preload = [];

    /**
     * 设置 jwt
     *
     * @param [type] $name
     * @param [type] $value
     * @return void
     */
    public static function set($name, $value = null)
    {
        static::$preload = self::get();
        static::$preload['expire'] = time();    // 秘钥生成时间
        if(is_array($name)){
            foreach($name as $k => $v){
                static::$preload[$k] = $v;
            }
        }else{
            static::$preload[$name] = $value;
        }

        // 生成用户秘钥
        $key = config('jwt.key'); // 签名秘钥
        $encoded = jwtoken::encode(static::$preload, $key);
        header('authorization: ' . $encoded);
    }

    /**
     * 获取jwt
     *
     * @param [type] $name
     * @return void
     */
    public static function get($name = null)
    {
        // 生成用户秘钥
        if(isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION']){
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        }else{
            return null;
        }
        $authorization = str_replace('Bearer ', '', $authorization);
        $key = config('jwt.key'); // 签名秘钥
        try{
            $decoded = jwtoken::decode($authorization, $key, array('HS256'));
        }catch(\Exception $e){
            return null;
        }

        if( null != $name){
            if(array_key_exists($name, $decoded)){
                return $decoded->$name;
            }else{
                return null;
            }
        }else{
            return static::object_array($decoded);
        }
    }

    /**
     * 对象转换为数组
     *
     * @param [type] $array
     * @return void
     */
    private static function object_array($array) {  
        if(is_object($array)) {  
            $array = (array)$array;  
         } if(is_array($array)) {  
             foreach($array as $key=>$value) {  
                 $array[$key] = static::object_array($value);  
                 }  
         }  
         return $array;  
    }  
}
