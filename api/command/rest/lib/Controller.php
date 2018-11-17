<?php
namespace command\rest\lib;
use think\Db;
use command\rest\Tpl;
use command\rest\Common;
/**
 * 
 */
class Controller extends Common implements Tpl
{
    /**
     * 等待替换的
     *
     * @var array
     */
    protected $tplKeys = [
        'Description'   =>  '{$Description}',
        'Author'        =>  '{$Author}',
        'Date'          =>  '{$Date}',
        'namespace'     =>  '{$namespace}',
        'class'         =>  '{$class}',
        'params'        =>  '{$params}',
        'uri'           =>  '{$uri}',
        'items'         =>  '{$items}',
        'auth'          =>  '{$auth}'
    ];
    /**
     * 对应tplkeys需要替换成的内容
     *
     * @var array
     */
    protected $tplValues = [
        'Description'   =>  '',
        'Author'        =>  '',
        'Date'          =>  '',
        'namespace'     =>  '',
        'class'         =>  '',
        'params'        =>  '',
        'uri'           =>  '',
        'items'         =>  '',
        'auth'          =>  '',
    ];

    /**
     * 控制器
     *
     * @var string
     */
    protected $typeName = 'controller';

    public function _init()
    {
        $this->setTplValues([
            'Description'   =>  trim($this->input->getOption('Description')),
            'Author'        =>  trim($this->input->getOption('Author')),
            'Date'          =>  date('Y-m-d H:i:s'),
            'namespace'     =>  $this->getNamespace(),
            'class'         =>  $this->getClass(),
            'params'        =>  $this->swaggerParameter,
            'uri'           =>  trim($this->input->getArgument('name')),
            'items'         =>  $this->swaggerItems,
            'auth'          =>  $this->auth
        ]);
    }

    /**
     * 获取对应的模板文件
     *
     * @return void
     */
    protected function getTpl()
    {
        $getTplFullPath = $this->getTplFullPath();
        $tpl = file_get_contents($getTplFullPath);

        // 获取控制器夹层
        $create = '';
        $update = '';
        $read = '';
        $delete = '';

        $arr = ['c' => 'create', 'u' => 'update', 'r' => 'read', 'd' => 'delete'];

        foreach($arr as $k => $v){

            if($this->input->getOption($v) or $this->input->hasParameterOption('-'.$k)){
                $$v = file_get_contents(ROOT_PATH . '/tpl/controller_'.$v.'.tpl');
            }

            $str = $this->input->getOption($v);
            // 获取当前组合选项
            foreach($arr as $kk => $vv){
                if($str && strpos($str,$kk) !== false){
                    $$vv = file_get_contents(ROOT_PATH . '/tpl/controller_'.$vv.'.tpl');
                }
            }
        }

        $preTplKeys = ['{$read}', '{$create}', '{$update}', '{$delete}'];
        $preTplValues = [$read, $create, $update, $delete];

        $tpl = str_replace($preTplKeys, $preTplValues, $tpl);
        return $tpl;
    }
}
