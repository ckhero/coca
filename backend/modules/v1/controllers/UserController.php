<?php

namespace backend\modules\v1\controllers;

class UserController extends \common\base\BaseController
{
	public $modelClass=  'common\models\PtUser';

	/**
     * @SWG\Get(path="/v1/users",
     *   tags={"用户管理"},
     *   summary="返回用户列表",
     *   description="返回用户列表",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="第几页",
     *         in="path",
     *         name="page",
     *         required=true,
     *         type="integer",
     *         required=false,
     *     ),
     *    @SWG\Parameter(
     *         description="每页的数量",
     *         in="query",
     *         name="per-page",
     *         required=true,
     *         type="integer",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/userList")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
}
