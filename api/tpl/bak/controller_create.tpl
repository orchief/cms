
    /**
    * @SWG\Post({$auth}
    *     path="/{$uri}",
    *     summary="{$Description}新增",
    *     tags={"{$Description}"},
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
    public $save;