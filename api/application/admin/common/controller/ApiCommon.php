<?php
// +----------------------------------------------------------------------
// | Description: Api基础类，验证权限 (将前后台请求分流)
// +----------------------------------------------------------------------
// | Author: dongpeng
// +----------------------------------------------------------------------

namespace app\admin\common\controller;
use app\admin\common\adapter\AuthAdapter;
use think\Db;
use think\Request;
use app\JWT;
use app\Controller;

class ApiCommon extends Controller
{
    /**
     * 接口白名单
     *
     * @var array
     */
    protected  $whiteList = [
        'Configs'     => [                // 配置文件
            'index'
        ],
        'Database'     => [                // 配置文件
            'save'
        ],
        'Counts'     => [                 // 配置文件
            'index'
        ],
        'MembersAgentDefaultJson' =>    [
            'index'
        ]
    ];

    public function _initialize()
    {
        parent::_initialize();
        $ac = request()->action();
        abort_if(property_exists(get_class($this), request()->action()), '方法不存在!', 404);

        // 不需要权限验证
        if($this->noAuth()){
            return;
        }

        /*获取头部信息*/
        $authKey = JWT::get('authKey', $authKey);
        $sessionId = JWT::get('sessionId', $authKey);
        $cache = cache('Auth_' . $authKey);

        abort_if(!empty($sessionId) and !empty($authKey) and !empty($cache), '登录已失效', 101);

        // 检查账号有效性
        $userInfo = $cache['userInfo'];
        $map['id'] = $userInfo['id'];
        $map['status'] = 1;

        abort_if(Db::name('admin_user')->where($map)->value('id'), '账号已被删除或禁用', 102);
    
        // 更新缓存
        cache('Auth_' . $authKey, $cache, config('LOGIN_SESSION_VALID'));
        $authAdapter = new AuthAdapter($authKey);
        $request = Request::instance();
        $ruleName = $request->module() . '-' . $request->controller() . '-' . $request->action();
        abort_if($authAdapter->checkLogin($ruleName, $cache['userInfo']['id']), '权限不足', 103);
    }

    /**
     * 检查白名单
     *
     * @return void
     */
    private function noAuth()
    {
        return true;
        $c = request()->controller();
        $a = request()->action();
        if (array_key_exists($c, $this->whiteList)) {
            if (in_array($a, $this->whiteList[$c])) {
                return true; // 在白名单中不需要验证
            }
        }
        return false;
    }

}
