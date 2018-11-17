
    /**
    * @SWG\Put({$auth}
    *     path="/{$uri}/{id}",
    *     summary="{$Description}更新",
    *     tags={"{$Description}"},
    *     @SWG\Parameter(
    *         name="id",
    *         in="path",
    *         description="主键id",
    *         required=true,
    *         type="integer",
    *         format="int64"
    *     ),
    {$params}
    *     @SWG\Response(
    *         response=200,
    *         description="{$Description}",
    *         @SWG\Header(header="authorization", type="string", description="权限验证")
    *     ),
    *     @SWG\Response(
    *         response="400",
    *         description="具体错误请看code和msg",
    *     )
    * )
    */
    public $update;