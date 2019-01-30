<?php

namespace backend\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Rules;

class RuleController extends \common\base\BaseController
{
	public $modelClass=  'common\models\Rules';

	/**
     * @SWG\Get(path="/v1/rules",
     *   tags={"帮助管理"},
     *   summary="返回帮助列表",
     *   description="返回帮助列表",
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/ruleList")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    /**
     * @SWG\Delete(path="/v1/rules/{id}",
     *   tags={"帮助管理"},
     *   summary="删除帮助",
     *   description="删除帮助",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="帮助 id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="integer"
     *     ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=204,description="删除成功"),
     *   @SWG\Response(response=404,description="帮助不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/v1/rules",
     *   tags={"帮助管理"},
     *   summary="添加帮助",
     *   description="添加帮助",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="帮助和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/rule"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/rule"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/rules/{id}",
     *   tags={"帮助管理"},
     *   summary="更新帮助",
     *   description="更新帮助",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="帮助 id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="待更新帮助和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/rule"
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/rule"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="帮助不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Get(path="/v1/rules/{id}",
     *   tags={"帮助管理"},
     *   summary="查看帮助",
     *   description="查看帮助",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="帮助id",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/rule"), description="更新成功"),
     *   @SWG\Response(response=404,description="帮助不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
}
