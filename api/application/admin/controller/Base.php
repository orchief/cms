<?php
// +----------------------------------------------------------------------
// | Description: 基础类，无需验证权限。
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\model\User;
use app\admin\model\SystemConfig;
use app\Controller;
use com\verify\HonrayVerify;
use think\Request;

/**
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    /**
     * 登录处理
     * @return array
     */
    public function login()
    {
        $model = new User();
        $param = $this->param;
        $username = $param['username'];
        $password = $param['password'];
        $verifyCode = !empty($param['verifyCode']) ? $param['verifyCode'] : '';
        $isRemember = !empty($param['isRemember']) ? $param['isRemember'] : '';
        $resData = $model->login($username, $password, $verifyCode, $isRemember);

        // 检查是否抛出异常
        abort_if($resData, $model->getError());

        // 登录日志记录
        $this->loginRecord($resData);

        // 处理结果
        result($resData, '数据异常');
    }

    /**
     * 登录日志记录
     * @param $resData array
     */
    public function loginRecord($resData)
    {
        $loginData['uid'] = $resData['userInfo']['id'];
        $user_IP = (isset($_SERVER["HTTP_VIA"]) && $_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
        $loginData['ip'] = $user_IP;
        db('admin_signlog')->insert($loginData);
    }

    /**
     * 记住密码之后的重新登录
     */
    public function relogin()
    {
        $model = new User();
        $param = $this->param;
        $data = decrypt($param['rememberKey']);
        $username = $data['username'];
        $password = $data['password'];
        $data = $model->login($username, $password, '', true, true);
        $this->jsonData($data, $model->getError());
    }

    /**
     * 退出
     * @return array
     */
    public function logout()
    {
        $param = $this->param;
        cache('Auth_' . $param['authkey'], null);
        $this->jsonData('退出成功');
    }

    /**
     * 读取并缓存系统配置
     */
    public function getConfigs()
    {
        $systemConfig = cache('DB_CONFIG_DATA');
        if (!$systemConfig) {
            //获取所有系统配置
            $model = new SystemConfig();
            $systemConfig = $model->getDataList();
            // 检查是否抛出异常
            $this->abort($systemConfig, '系统配置获取失败');
            cache('DB_CONFIG_DATA', null);
            cache('DB_CONFIG_DATA', $systemConfig, 36000); //缓存配置
        }
        result($systemConfig, '系统配置获取失败');
    }

    /*
     * 获取验证信息
     */
    public function getVerify()
    {
        $captcha = new HonrayVerify(config('captcha'));
        return $captcha->entry();
    }

    // miss 路由：处理没有匹配到的路由规则
    public function miss()
    {
        if (Request::instance()->isOptions()) {
            return;
        } else {
            return ['code' => 404, 'error' => '接口路径/请求方式 错误'];
        }
    }
}
