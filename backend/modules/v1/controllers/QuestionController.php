<?php

namespace backend\modules\v1\controllers;

use backend\models\Questions;

class QuestionController extends \yii\rest\ActiveController
{
	public $modelClass = 'backend\models\Questions';
	/**
     * @SWG\Get(path="/questions",
     *   tags={"题目管理"},
     *   summary="返回题目列表",
     *   description="返回题目列表",
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
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="path",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/Questions")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    

    /**
     * @SWG\Delete(path="/questions/{id}",
     *   tags={"题目管理"},
     *   summary="删除题目",
     *   description="删除题目",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="题目id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="integer"
     *     ),
     *   @SWG\Response(response=204,description="删除成功"),
     *   @SWG\Response(response=404,description="题目不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/questions",
     *   tags={"题目管理"},
     *   summary="添加题目",
     *   description="添加题目",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="题目和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/Questions"
     *     )
     *   ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/Questions"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/questions/{id}",
     *   tags={"题目管理"},
     *   summary="更新题目",
     *   description="更新题目",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="题目id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="待更新题目和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/Questions"
     *     )
     *   ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/Questions"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="题目不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
}
