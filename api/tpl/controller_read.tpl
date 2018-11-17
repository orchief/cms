
    /**
    * @SWG\Get({$auth}
    *     path="/{$uri}",
    *     summary="获取全部{$Description}",
    *     tags={"{$Description}"},
    {$params}*     @SWG\Response(
    *     response=200,
    *     description="{$Description}列表",
    *     @SWG\Schema(
    *     type="array",
    *     @SWG\Items(
    {$items}* 
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
    * @SWG\Get({$auth}
    *     path="/{$uri}/{id}",
    *     summary="获取一条{$Description}",
    *     tags={"{$Description}"},
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
    *         description="{$Description}",
    *         @SWG\Schema(
{$items}*     ),
    *     ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $read;

