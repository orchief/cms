<?php

// +----------------------------------------------------------------------
// | 公共的自定义函数
// +----------------------------------------------------------------------

/**
 * 抛出异常或者程序继续执行
 *
 * @param boolen $boolen 需要检验的结果 为true 则程序继续运行 否则抛出异常
 * @param array $jsonBody 返回的json
 * @param int $httpCode http code
 * @return void
 */
function abort_if($boolen, $jsonBody, $httpCode = 400)
{
    if(!$boolen){
        abort($jsonBody, $httpCode);
    }
    // 返回验证的数据
    return $boolen;
}

/**
 * 抛出异常
 *
 * @param array $jsonBody 返回的json
 * @param integer $httpCode http code
 * @return void
 */
function abort($jsonBody, $httpCode = 400)
{
    if(is_string($jsonBody)){
        $resJsonBody  = ['msg' => $jsonBody];
    }else{
        $resJsonBody  = $jsonBody;
    }
    json($resJsonBody, $httpCode);
}

/**
 * 抛出异常
 *
 * @param array $jsonBody 返回的json
 * @param integer $httpCode http code
 * @return void
 */
function json($jsonBody, $httpCode = 200)
{
    $Body = [
        'code' => $httpCode,
        'data' => $jsonBody
    ];

    $response = think\Response::create($Body, 'json');
    // $response = think\Response::create($Body, 'json')->code($httpCode);
    throw new think\exception\HttpResponseException($response);
}

/**
 *  检查 $result字段 并返回不同的结果
 *
 * @param mixed $result 程序运行的最后结果 一般为数据集 或者 boolen false
 * @param array $jsonBody  返回的json
 * @param int $httpCode http code
 * @return void
 */
function result($result, $jsonBody = null, $httpCode = 400)
{
    if($result OR is_array($result)){
        json($result, 200);
    }else{
        abort($jsonBody, $httpCode);
    }
}

/**
 * 验证数据 (数据 默认为请求参数)
 *
 * @param array $rules           Rules of inspection
 * @param array $field           field 注释
 * @param array $data            data
 * @return void
 */
function validates($rules, $field, $data = null)
{   
    $param = \think\Request::instance()->param();
    if(!isset($data)){
        $data = $param;
    }
    $validator = new \app\Validate($rules, [], $field);
    abort_if($validator->check($data), ['msg' => $validator->getError()]);
}

/**
 * 用户密码加密方法
 * @param  string $str      加密的字符串
 * @param  [type] $auth_key 加密符
 * @return string           加密后长度为32的字符串
 */
function user_md5($str, $salt = '')
{
    return '' === $str ? '' : md5(sha1($str) . $salt);
}

/**
 * 驼峰转下划线
 *
 * @param string $str 需要转换的字符
 * @return void
 */
function humpToLine($str){
    $str = preg_replace_callback('/([A-Z]{1})/',function($matches){
        return '_'.strtolower($matches[0]);
    },$str);
    return $str;
}

/**
 * 下划线转驼峰
 *
 * @param [type] $str
 * @return void
 */
function convertUnderline($str)
{
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i',function($matches){
        return strtoupper($matches[2]);
    },$str);
    return $str;
}

/**
 * 复制文件到指定目录
 *
 * @param [type] $sourcefile
 * @param [type] $dir
 * @param [type] $filename
 * @return void
 */
function file2dir($sourcefile, $dir,$filename){
    if( ! file_exists($sourcefile)){
        return false;
    }
    return copy($sourcefile, $dir .''. $filename);
}

/**
 * 将数据库主表和从表联查的数据格式化为树形
 *
 * @param array $data 需要进行格式化的数据
 * @param string $primaryKey 唯一键(不一定是主键)
 * @param string $childrenField 子字段名称 (自定义的)
 * @param mixed $childrenValueFields 子字段数据字段 本字段为混合类型 为字符串的时候 子字段为索引数组 为数组是子字段为关联数组
 * @param array $normalFields 核心字段(唯一键已经有了) 
 * @return void
 */
function tree($data, $primaryKey, $childrenField, $childrenValueFields, $normalFields)
{
    $arr = [];
    foreach($data as $k => $v){
        foreach ($normalFields as $key => $value) {
            $arr[$data[$k][$primaryKey]][$value] = $v[$value];
        }
        if(is_array($childrenValueFields)){
            $temp = [];
            foreach($childrenValueFields as $key => $value){
                array_key_exists($value, $v) && $temp[$value] = $v[$value];
            }
            $arr[$data[$k][$primaryKey]][$childrenField][] = $temp;
            $temp == [] && $arr[$data[$k][$primaryKey]][$childrenField] = [];
        }
        if(is_string($childrenValueFields)){
            $arr[$data[$k][$primaryKey]][$childrenField][] = $v[$childrenValueFields];
        }
    }
    return array_values($arr);
}

/**
 * 获取 / 设置配置信息
 *
 * @param string $name
 * @param string $value
 * @return mixed
 */
function setting($name = null, $value = null)
{
    $value = \app\admin\model\Setting::where(['name' => $name])->value('value');
    $arrV = json_decode($value, true);
    foreach($arrV as $k => $v){
        $res[$v['name']] = $v['value'];
    }
    return $res;
}

/**
 * 判断一个字符串是否包含另一个字符串
 */
function in_string($needle, $string)
{
    return strpos($string, $needle) !==false;
}

/**
 * 复制文件夹
 * @param $source
 * @param $dest
 */
function copydir($source, $dest)
{
    if (!file_exists($dest)) mkdir($dest);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) copydir($_source, $_dest);
    }
    closedir($handle);
}