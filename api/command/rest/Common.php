<?php
namespace command\rest;

use think\Db;
use think\Config;

/**
 * 
 */
class Common
{
    protected $config = [];

    protected $database = [];

    public function __construct($config)
    {
        $this->config = array_replace_recursive($this->config, $config);
        $this->input = $this->config['input'];
        $this->output = $this->config['output'];
        $this->getDbColumnComment();
        $this->getSwaggerParams();
        $this->createCommon();
        $this->_init();
    }

    /**
     * 检测并创建公共文件
     */
    public function createCommon()
    {
        // 检查是否已存在
        $name = trim($this->input->getArgument('name'));

        $arr = explode('/', $name);

        $fileList = [ 'ApiCommon' => 'controller', 'Model' => 'model', 'Rest' => 'controller'];
        
        foreach($fileList as $v => $k){
            $tempTpl = ROOT_PATH . '/tpl/common/'.$v.'.tpl';
            $$v = file_get_contents($tempTpl);
            $$v = str_replace(array_values([ 'namespace' =>  '{$namespace}']), array_values(['namespace'     =>  $this->getNamespace()]), $$v);
            $path = ROOT_PATH . DS . 'application' . DS . $arr[0] . DS . 'common' .  DS . $k;
            is_dir($path) OR mkdir($path, 0777, true);
            $filename = $path . DS . $v . ".php";
            if(!is_file($filename)){
                file_put_contents($filename, $$v);
            }
        }
    }

    /**
     * 自定义初始化
     */
    public function _init()
    {

    }

    /**
     * 获取数据库字段注释
     *
     * @param string $this->table 数据表名称(必须，不含前缀)
     * @param string $field 字段名称(默认获取全部字段,单个字段请输入字段名称)
     * @param string $table_schema 数据库名称(可选)
     * @return string
     */
    protected function getDbColumnComment($field = true, $table_schema = ''){
        $database = config('database');
        $table_schema = empty($table_schema) ? $database['database'] : $table_schema;
        
        // 缓存名称
        $fieldName = $field === true ? 'allField' : $field;
        $cacheKeyName = 'db_' . $table_schema . '_' . $this->table . '_' . $fieldName;
        
        // 处理参数
        $param = [
            $this->getTable(),
            $table_schema
        ];
        
        // 字段
        $columeName = '';
        if($field !== true){
            $param[] = $field;
            $columeName = "AND COLUMN_NAME = ?";
        }
        
        // 查询结果
        $result = Db :: query("SELECT *  FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ? AND table_schema = ? $columeName", $param);

        foreach($result as $k => $v){
            if($v['COLUMN_NAME'] == 'userId'){
                unset($result[$k]);
                // 存在userId的表需要进行权限校验
                $this->auth = true;
            }

            if($v['COLUMN_NAME'] == 'id'){
                unset($result[$k]);
            }
        }

        $this->tableInfo = $result;
    }

        /**
     * 生成模板 如果是强制覆盖 需要将覆盖之前的文件缓存 等待是否进行 回滚
     *
     * @return void
     */
    function create(){
        // 缓存之前的文件
        $this->cacheOriginFile();
        $this->build();
    }

    /**
     * 设置替换参数
     */
    protected function setTplValues($name, $value = null)
    {
        if(is_array($name)){
            $this->tplValues = array_replace_recursive($this->tplValues, $name);
        }else if(is_string($name)){
            $this->tplValues = array_replace_recursive($this->tplValues, [$name => $value]);
        }
        return true;
    }

    /**
     * 生成文件
     *
     * @return void
     */
    protected function build()
    {
        $tpl = $this->getTpl();
        
        $tpl = str_replace(array_values($this->tplKeys), array_values($this->tplValues), $tpl);

        $file = $this->getFullPathName();

        $path = $this->getPath();

        is_dir($path) OR mkdir($path, 0777, true);

        file_put_contents($file, $tpl);
    }

    /**
     * 回滚刚才生成的模板 
     * 情况1: 强制更新的话需要还原更新之前的文件
     * 情况2: 新增的文件则直接删除
     *
     * @return void
     */
    protected function rollback()
    {
    }

    protected function cacheOriginFile()
    {

    }

   /**
     * 获取对应的模板文件
     *
     * @return void
     */
    protected function getTpl()
    {
        $getTplFullPath = $this->getTplFullPath();
        return file_get_contents($getTplFullPath);
    }

    /**
     * 获取模板文件的全路径
     *
     * @return void
     */
    protected function getTplFullPath()
    {
        if ($this->input->getOption('plain')) {
            $fullPath = ROOT_PATH . 'tpl' . DS . $this->getTplName($this->typeName) . '.plain.tpl';
        }else {
            $fullPath = ROOT_PATH . 'tpl' . DS . $tplName.'.tpl';
        }
        return  $fullPath;
    }

    /**
     * get tplName 
     *
     * @return string
     */
    protected function getTplName($name)
    {
        return strtolower($name);
    }


    /**
     * 获取文件存储路径
     *
     * @param [type] $classname
     * @param [type] $typeName
     * @param [type] $output
     * @return void
     */
    protected function getFullPathName()
    {
        $name = trim($this->input->getArgument('name'));

        $arr = explode('/', $name);

        $temp[0] = $arr[0];
        $temp[1] = $this->typeName;
        $temp[2] = ucfirst($arr[1]);

        $temp = implode('/', $temp);

        $res = ROOT_PATH . 'application' . DS . str_replace( '/', DS, $temp) . '.php';

        return $res;
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
        $name = trim($this->input->getArgument('name'));

        $arr = explode('/', $name);

        $temp[0] = $arr[0];
        $temp[1] = $this->typeName;

        $temp = implode('/', $temp);

        $res = ROOT_PATH . 'application' . DS . str_replace( '/', DS, $temp) . DS;

        return $res;
    }

    /**
     * 获取文件保存 名称
     *
     * @param [type] $classname
     * @param [type] $typeName
     * @param [type] $output
     * @return void
     */
    protected function getFileName($classname, $typeName, $output)
    {
        
    }

    /**
     * 获取 namespace
     */
    protected function getNamespace()
    {
        return Config::get('app_namespace') . '\\' . implode('\\', array_slice(explode('/', $this->input->getArgument('name')), 0, -1));
    }

    /**
     * get class
     */
    protected function getClass()
    {
        return ucfirst(explode('/', $this->input->getArgument('name'))[1]);
    }

    /**
     * 获取swagger注释参数
     */
    protected function getSwaggerParams()
    {
        foreach($this->tableInfo as $k => $v){
            if($this->ifpass($v)){
                continue;
            }
            $this->swaggerParameter .= '*     @SWG\Parameter(
    *         name="'.$v['COLUMN_NAME'].'",
    *         in="query",
    *         description="'.$v['COLUMN_COMMENT'].'",
    *         required=false,
    *         type="'.$this->getFieldType($v['DATA_TYPE']).'",
    *         format="string"
    *     ),
    ';
            $this->swaggerItems .= '*                   @SWG\Property(
    *                       property="'.$v['COLUMN_NAME'].'",
    *                       description="'.$v['COLUMN_COMMENT'].'",
    *                       type="'.$this->getFieldType($v['DATA_TYPE']).'"
    *               ),
    ';
        }
    
        // 
        foreach($this->tableInfo as $k => $v){
            if($this->ifpass($v)){
                continue;
            }

            if($this->getFieldType($v['DATA_TYPE']) == 'integer'){
                if($this->input->hasParameterOption('-a')){
                    $this->is .= '"userId",';   // 和用户相关的模块
                }
                $this->is .= '"'.$v['COLUMN_NAME'].'",';
            }
            if($this->getFieldType($v['DATA_TYPE']) == 'string'){
                $this->like .= '"'.$v['COLUMN_NAME'].'",';
            }
            if($this->getFieldType($v['DATA_TYPE']) == 'date'){
                $this->ranges .= '"'.$v['COLUMN_NAME'].'",';
            }
        }
    }

        /**
     * 过滤掉隐藏字段
     *
     * @return void
     */
    protected function ifpass($fields, $scene = null)
    {
        if($scene == "create" && is_null($fields['COLUMN_DEFAULT']) && $fields['IS_NULLABLE'] == 'NO'){
            return true;
        }

        return strpos($fields['COLUMN_COMMENT'],'hidden') !== false;
    }

    /**
     * 数据量字段类型 装换为php字段类型
     *
     * @param [type] $originType
     * @return void
     */
    protected function getFieldType($originType)
    {
        // return $originType;
        switch($originType){
            case 'bigint':
                return 'integer';
            case 'tinyint':
                return 'integer';
                break;
            case 'smallint':
                return 'integer';
                break;
            case 'mediumint':
                return 'integer';
                break;
            case 'float':
                return 'number';
                break;
            case 'double':
                return 'number';
                break;
            case 'decimal':
                return 'number';
                break;
            case 'timestamp':
                return 'date';
                break;
            case 'datetime':
                return 'date';
                break;
            case 'date':
                return 'date';
                break;
                
        }
        return 'string';
    }

    /**
     * 去除数据库注释中的额外信息
     *
     * @return void
     */
    protected function trimExtraComment($str)
    {
        $str = preg_replace("/\((.*?)\)/","",$str);
        return trim($str);
    }

    /**
     * 获取table名称
     *
     * @return void
     */
    protected function getTable()
    {
        // 初始化
        $table = trim($this->input->getOption('table'));
        $name = trim($this->input->getArgument('name'));
        $arr = explode('/', $name);

        $table2 = $arr[0] . '_' . humpToLine($arr[1]);

        $this->table = $table ? $table : $table2;
        // 接收参数
        $database = config('database');
        $this->table = $database['prefix'] . $this->table;
        return $this->table;
    }
}
