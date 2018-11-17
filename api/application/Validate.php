<?php
// +----------------------------------------------------------------------
// 自定义验证规则
// +----------------------------------------------------------------------

namespace app;

use think\Validate as ThinkValidate;

class Validate extends ThinkValidate
{
    /**
     * 手机号
     *
     * @return void
     */
    protected function mobile($value, $rule)
    {
        $this->setTypeMsg('mobile', ':attribute必须为手机号');
        $res = $this->regex($value, '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/u');
        return $res;
    }

    /**
     * 手机号
     *
     * @return void
     */
    protected function phone($value, $rule)
    {
        $this->setTypeMsg('phone', ':attribute必须为手机号');
        $res = $this->regex($value, '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/u');
        return $res;
    }

    /**
     * 金额
     *
     * @return void
     */
    protected function money($value, $rule)
    {
        $this->setTypeMsg('money', ':attribute必须为金额');
        $result = $this->regex($value, '/^d*(?:.d{0,2})?$/');
        return $result;
    }
    /**
     * 
     * 身份证
    */
    protected function IdCart($value,$rule)
    {
        $this->setTypeMsg('IdCart', ':attribute必须为身份证号');
        $result = $this->regex($value,'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/i');
        return $result;
    }
    /**
     * 
     * qq
    */
    protected function qq($value,$rule)
    {
        $this->setTypeMsg('qq', ':attribute必须为qq号');
        $result = $this->regex($value,'/^\d{5,12}$/isu');
        return $result;
    }
   
    /**
     * 
     * 微信
    */
    protected function weChat($value,$rule)
    {
        $this->setTypeMsg('weChat', ':attribute必须为微信号');
        $result = $this->regex($value,'/^[_a-zA-Z0-9]{5,19}+$/isu');
        return $result;
    }
    
    /**
     * 
     * 银行卡
    */
    protected function bankCard($value,$rule)
    {
        $this->setTypeMsg('bankCard', ':attribute必须为银行卡号');
        $result = $this->regex($value,'/^(\d{15}|\d{16}|\d{19})$/isu');
        return $result;
    }

    /**
     * 
     * 密码
    */
    protected function password($value,$rule)
    {
        $this->setTypeMsg('password', ':attribute必须为8-16位,不能为 纯数字或纯字母或纯特殊字符');
        $result = $this->regex($value,'/((?=.*[a-z])(?=.*\d)|(?=[a-z])(?=.*[#@!~%^&*])|(?=.*\d)(?=.*[#@!~%^&*]))[a-z\d#@!~%^&*]{8,16}/isu');
        return $result;
    }

    protected function intGtEqZero($value,$rule)
    {
        $this->setTypeMsg('intGtEqZero', ':attribute必须为大于等于0的整数');
        $result = $this->regex($value,'/^\\d+$/isu');
        return $result;
    }
}
