<?php

namespace backend\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\DayUrl;

class DayUrlController extends \common\base\BaseController
{
    public $modelClass=  'common\models\DayUrl';

	/**
     * @SWG\Get(path="/v1/day-urls",
     *   tags={"每日任务url管理"},
     *   summary="返回每日任务url列表",
     *   description="返回每日任务url列表",
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/dayUrlList")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    /**
     * @SWG\Delete(path="/v1/day-urls/{id}",
     *   tags={"每日任务url管理"},
     *   summary="删除每日任务url",
     *   description="删除每日任务url",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="每日任务url id",
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
     *   @SWG\Response(response=404,description="每日任务url不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/v1/day-urls",
     *   tags={"每日任务url管理"},
     *   summary="添加每日任务url",
     *   description="添加每日任务url",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="每日任务url和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/dayUrl"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/dayUrl"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/day-urls/{id}",
     *   tags={"每日任务url管理"},
     *   summary="更新每日任务url",
     *   description="更新每日任务url",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="每日任务url id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="待更新每日任务url和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/dayUrl"
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/dayUrl"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="每日任务url不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Get(path="/v1/day-urls/{id}",
     *   tags={"每日任务url管理"},
     *   summary="查看每日任务url",
     *   description="查看每日任务url",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="每日任务urlid",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/dayUrl"), description="更新成功"),
     *   @SWG\Response(response=404,description="每日任务url不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */

}
