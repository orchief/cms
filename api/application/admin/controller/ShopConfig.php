<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-10-10 14:20:33
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;

class ShopConfig extends Rest
{
    public $modelName = 'ShopConfig';
    /**
    * @SWG\Get(
    *     path="/admin/ShopConfig",
    *     summary="获取全部",
    *     tags={""},
    *     @SWG\Parameter(
    *         name="name",
    *         in="query",
    *         description="参数名称 建议用大写下划线的风格",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="value",
    *         in="query",
    *         description="配置值",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="remark",
    *         in="query",
    *         description="参数注释",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Response(
    *     response=200,
    *     description="列表",
    *     @SWG\Schema(
    *     type="array",
    *     @SWG\Items(
    *                   @SWG\Property(
    *                       property="name",
    *                       description="参数名称 建议用大写下划线的风格",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="value",
    *                       description="配置值",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="remark",
    *                       description="参数注释",
    *                       type="string"
    *               ),
    * 
    *      )
    *      )
    *    ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $index;

    /**
    * @SWG\Get(
    *     path="/admin/ShopConfig/{id}",
    *     summary="获取一条",
    *     tags={""},
    *     @SWG\Parameter(
    *         name="id",
    *         in="path",
    *         description="主键id",
    *         required=true,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Response(
    *         response=200,
    *         description="",
    *         @SWG\Schema(
*                   @SWG\Property(
    *                       property="name",
    *                       description="参数名称 建议用大写下划线的风格",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="value",
    *                       description="配置值",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="remark",
    *                       description="参数注释",
    *                       type="string"
    *               ),
    *     ),
    *     ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $read;


    /**
    * @SWG\Post(
    *     path="/admin/ShopConfig",
    *     summary="新增",
    *     tags={""},
    *     @SWG\Parameter(
    *         name="name",
    *         in="query",
    *         description="参数名称 建议用大写下划线的风格",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="value",
    *         in="query",
    *         description="配置值",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="remark",
    *         in="query",
    *         description="参数注释",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    
    *     @SWG\Response(
    *         response=200,
    *         description="",
    *         @SWG\Header(header="authorization", type="string", description="权限验证")
    *     ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $save;
    /**
    * @SWG\Put(
    *     path="/admin/ShopConfig/{id}",
    *     summary="更新",
    *     tags={""},
    *     @SWG\Parameter(
    *         name="id",
    *         in="path",
    *         description="主键id",
    *         required=true,
    *         type="integer",
    *         format="int64"
    *     ),
    *     @SWG\Parameter(
    *         name="name",
    *         in="query",
    *         description="参数名称 建议用大写下划线的风格",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="value",
    *         in="query",
    *         description="配置值",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="remark",
    *         in="query",
    *         description="参数注释",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    
    *     @SWG\Response(
    *         response=200,
    *         description="",
    *         @SWG\Header(header="authorization", type="string", description="权限验证")
    *     ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $update;
    /**
    * @SWG\Delete(
    *     path="/admin/ShopConfig/{id}",
    *     summary="删除",
    *     tags={""},
    *     @SWG\Parameter(
    *         name="id",
    *         in="path",
    *         description="主键id",
    *         required=true,
    *         type="integer",
    *         format="int64"
    *     ),
    *     @SWG\Response(
    *         response=200,
    *         description="",
    *         @SWG\Header(header="authorization", type="string", description="权限验证")
    *     ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $delete;
}