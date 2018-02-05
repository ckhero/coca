<?php

namespace frontend\module\v1\controllers;

class ChapterController extends \common\base\BaseController
{
	public $modelClass = 'common\models\Chapter';
	/**
     * @SWG\Get(path="/v1/chapters/{id}",
     *   tags={"关卡"},
     *   summary="查看关卡",
     *   description="查看关卡",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="关卡id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/chapters"), description="更新成功"),
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    
}
