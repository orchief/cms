<?php
namespace app;

/**
 * 将url根据规定的格式转换成 查询sql
 */
trait Url2Sql{
    private $page = null;
    /**
     * param参数解析器
     *
     * @param [type] $param
     * @return void
     */
    protected function parseParam($param)
    {
        $this->param = $param;
        $this->limit = isset($this->param['limit']) ? $this->param['limit'] : $this->limit;                 // 获取多少条数据
        $this->offset = isset($this->param['offset']) ? $this->param['offset'] : $this->offset;             // 跳过多少条数据
        $this->page = isset($this->param['page']) ? $this->param['page'] : null;                            // 按照页码查询
        
        $this->orderStr = isset($this->param['orderStr']) ? $this->param['orderStr'] : $this->orderStr;     // 排序方式

        if($param){
            $this->multiSearch();
        }

        // 联合查询
        if ($this->leftJoin) {
            foreach ($this->leftJoin as $k => $v) {
                $this->join($v[0], $v[0].'.'.$v[1] . '=' . $this->name . '.' . $v[2], 'LEFT');
            }
        }

        if($this->limit == -1){
            return $this->field($this->returnFields)->select();
        }
        if(null != $this->page){
            return $this->field($this->returnFields)->page($this->page, $this->limit)->select();
        }else{
            return $this->field($this->returnFields)->limit($this->offset, $this->limit)->select();
        }
    }

    /**
     * param参数解析器
     *
     * @param [type] $param
     * @return void
     */
    protected function getTotals($param)
    {
        $this->param = $param;
        if($param){
            $this->multiSearch();
        }

        // 联合查询
        if ($this->leftJoin) {
            foreach ($this->leftJoin as $k => $v) {
                $this->join($v[0], $v[0].'.'.$v[1] . '=' . $this->name . '.' . $v[2], 'LEFT');
            }
        }
        
        return $this->count();
    }

    /**
     * 多条件查询
     *
     * @return void
     */
    protected function multiSearch()
    {
        // 模糊查询
        if ($this->likeCons) {
            foreach ($this->likeCons as $k => $v) {
                if (array_key_exists($v, $this->param) && ($this->param[$v] or $this->param[$v] === "0" or $this->param[$v] === 0)) {
                    if($this->param[$v] && strpos($this->param[$v], '--') === false){
                        $this->where($this->name . '.' . $v, 'like', '%' . $this->param[$v] . '%');
                    }
                }
            }
        }

        // 精确查询
        if ($this->eqCons) {
            foreach ($this->eqCons as $k => $v) {
                if (array_key_exists($v, $this->param) && ($this->param[$v] or $this->param[$v] === "0" or $this->param[$v] === 0)) {
                    if(strpos($this->param[$v], '--') === false){
                        $this->where([$this->name . '.' . $v => $this->param[$v]]);
                    }
                }
            }
        }

        // 范围
        if ($this->ranges) {
            foreach ($this->ranges as $k => $v) {
                if (array_key_exists($v, $this->param) && ($this->param[$v] or $this->param[$v] === "0" or $this->param[$v] === 0)) {
                    // 数组模式
                    if(is_array($this->param[$v])){
                        // 最小值
                        if(isset($this->param[$v][0])){
                            $this->where($this->name . '.' . $v, '>=', $this->param[$v][0]);
                        }
                        // 最大值
                        if(isset($this->param[$v][1])){
                            $this->where($this->name . '.' . $v, '<=', $this->param[$v][1]);
                        }
                    }
                }
            }
        }

        // 排序
        if ($this->orderStr) {
            $orderArr = explode('.', $this->orderStr);
            if($orderArr[1] == 'ascending' or $orderArr[1] == 'asc'){
                $this->order($this->name . '.' . $orderArr[0]);
            }else {
                $this->order($this->name . '.' . $orderArr[0] . ' DESC');
            }
        }

        $this->leftJoinEqQuery();
        $this->leftJoinLikeQuery();
    }

    /**
     * 联合查询 leftjoin表的字段eq查询
     * @return void
     */
    protected function leftJoinEqQuery()
    {
        if(!$this->param){
            return $this;
        }
        foreach ($this->joinEqCon as $k => $v) {
            if((array_key_exists($v, $this->param) && $this->param[$v]) or $this->param[$v] === "0" or $this->param[$v] === 0){
                $this->where($k . '.' . $v, $this->param[$v]);
            }
        }
        return $this;
    }

    /**
     * 联合查询 leftjoin表的字段 like 查询
     * @return void
     */
    protected function leftJoinLikeQuery()
    {
        if(!$this->param){
            return $this;
        }
        foreach ($this->joinLikeCon as $k => $v) {
            if((array_key_exists($v, $this->param) && $this->param[$v]) or $this->param[$v] === "0" or $this->param[$v] === 0){
                $this->where($k . '.' . $v, 'like', '%' . $this->param[$v] . '%');
            }
        }
        return $this;
    }
}