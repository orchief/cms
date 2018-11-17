<?php
// +----------------------------------------------------------------------
// | Description: 地址接口服务
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------
// | Date: 2018-09-04 16:45:51
// +----------------------------------------------------------------------

namespace app\base\controller;

use app\base\common\controller\Rest;

class Address extends Rest
{
    public $modelName = 'Address';
    /**
    * @SWG\Get(
    *     path="/base/Address",
    *     summary="获取全部地址接口服务",
    *     tags={"地址接口服务"},
    *     @SWG\Parameter(
    *         name="areaId",
    *         in="query",
    *         description="地区Id",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="areaCode",
    *         in="query",
    *         description="地区编码",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="areaName",
    *         in="query",
    *         description="地区名",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="level",
    *         in="query",
    *         description="地区级别（1:省份province,2:市city,3:区县district,4:街道street）",
    *         required=false,
    *         type="integer",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="cityCode",
    *         in="query",
    *         description="城市编码",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="center",
    *         in="query",
    *         description="城市中心点（即：经纬度坐标）",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Parameter(
    *         name="parentId",
    *         in="query",
    *         description="地区父节点",
    *         required=false,
    *         type="string",
    *         format="string"
    *     ),
    *     @SWG\Response(
    *     response=200,
    *     description="地址接口服务列表",
    *     @SWG\Schema(
    *     type="array",
    *     @SWG\Items(
    *                   @SWG\Property(
    *                       property="areaId",
    *                       description="地区Id",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="areaCode",
    *                       description="地区编码",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="areaName",
    *                       description="地区名",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="level",
    *                       description="地区级别（1:省份province,2:市city,3:区县district,4:街道street）",
    *                       type="integer"
    *               ),
    *                   @SWG\Property(
    *                       property="cityCode",
    *                       description="城市编码",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="center",
    *                       description="城市中心点（即：经纬度坐标）",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="parentId",
    *                       description="地区父节点",
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
     * 省市二级
     *
     * @return void
     */

    /**
    * @SWG\Get(
    *     path="/base/Address/{id}",
    *     summary="获取一条地址接口服务",
    *     tags={"地址接口服务"},
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
    *         description="地址接口服务",
    *         @SWG\Schema(
*                   @SWG\Property(
    *                       property="areaId",
    *                       description="地区Id",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="areaCode",
    *                       description="地区编码",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="areaName",
    *                       description="地区名",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="level",
    *                       description="地区级别（1:省份province,2:市city,3:区县district,4:街道street）",
    *                       type="integer"
    *               ),
    *                   @SWG\Property(
    *                       property="cityCode",
    *                       description="城市编码",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="center",
    *                       description="城市中心点（即：经纬度坐标）",
    *                       type="string"
    *               ),
    *                   @SWG\Property(
    *                       property="parentId",
    *                       description="地区父节点",
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
}