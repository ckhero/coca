<?php

namespace frontend\module\v1\controllers;

class ChapterItemController extends \common\base\BaseController
{
	public $modelClass = 'common\models\ChapterChild';

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['update']);
		return $actions;
	}
	/**
     * @SWG\Get(path="/v1/chapter-items/{id}",
     *   tags={"子关卡"},
     *   summary="查看子关卡",
     *   description="获取子关卡的题目",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/chapterChilds"), description="获取成功"),
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/chapter-items/{id}",
     *   tags={"子关卡"},
     *   summary="更新用户答题结果",
     *   description="更新用户答题结果",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="小关卡id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="用户答题结果",
     *     required=true,
     *     @SWG\Schema(
     *       @SWG\Items(ref="#/definitions/answerSubmitFormat")
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/chapterChilds"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="小关卡不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    public function actionUpdate($id)
    {
    	$answers = \Yii::$app->request->getBodyParams();
    	//验证答案的正确性
    }
}
