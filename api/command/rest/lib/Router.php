<?php
namespace command\rest\lib;
use think\Db;
use command\rest\Tpl;
use command\rest\Common;
/**
 * 路由修改
 */
class Router extends Common implements Tpl
{
        /**
     * 等待替换的
     *
     * @var array
     */
    protected $tplKeys = [
        'router'   =>  '{$router}'
    ];

    /**
     * 对应tplkeys需要替换成的内容
     *
     * @var array
     */
    protected $tplValues = [
        'router'   =>  ''
    ];

    /**
     * 控制器
     *
     * @var string
     */
    protected $typeName = 'router';

    public function _init()
    {
        $router = include ROOT_PATH . '/config/route_rest.php';
        $this->router = '';
        foreach($router['__rest__'] as $k => $v){
            $this->router .= '
        \''.$k.'\' => \''.$v.'\',';
        }

        $pathToClass = trim($this->input->getArgument('name'));

        $arr = explode('/', $pathToClass);

        $arr[1] = ucfirst($arr[1]);

        $pathToClass = implode('/', $arr);

        if(!in_array($pathToClass, $router['__rest__'])){
            $this->router .= '
        \''.strtolower($pathToClass).'\' => \''.$pathToClass.'\',';
        }

        $this->setTplValues([
            'router'   =>  $this->router
        ]);
    }

    /**
     * 获取文件存储路径
     *
     * @param [type] $classname
     * @param [type] $typeName
     * @param [type] $output
     * @return void
     */
    protected function getPath()
    {
        return ROOT_PATH . 'config';
    }

    public function getFullPathName()
    {
        return ROOT_PATH . 'config' . DS . 'route_rest.php';
    }
}
