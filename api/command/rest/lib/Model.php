<?php
namespace command\rest\lib;
use think\Db;
use command\rest\Tpl;
use command\rest\Common;
/**
 * 
 */
class Model extends Common implements Tpl
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
        'table'         =>  '{$table}',
        'like'          =>  '{$like}',
        'is'            =>  '{$is}',
        'ranges'        =>  '{$ranges}',
        'dbType'        =>  '{$dbType}',
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
        'table'         =>  '',
        'like'          =>  '',
        'is'            =>  '',
        'ranges'        =>  '',
        'dbType'        =>  'Model'
    ];

    /**
     * 控制器
     *
     * @var string
     */
    protected $typeName = 'model';

    public function _init()
    {
        $this->setTplValues([
            'Description'   =>  trim($this->input->getOption('Description')),
            'Author'        =>  trim($this->input->getOption('Author')),
            'Date'          =>  date('Y-m-d H:i:s'),
            'namespace'     =>  $this->getNamespace(),
            'class'         =>  $this->getClass(),
            'table'         =>  $this->getTable(),
            'like'          =>  $this->like,
            'is'            =>  $this->is,
            'ranges'        =>  $this->ranges
        ]);
    }
}
