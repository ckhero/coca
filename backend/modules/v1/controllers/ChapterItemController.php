<?php

namespace backend\modules\v1\controllers;


use yii\data\ActiveDataProvider;
use common\models\ChapterChild;

class ChapterItemController extends \common\base\BaseController
{
	public $modelClass = 'common\models\ChapterChild';
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}

	/**
     * @SWG\Get(path="/v1/chapter-items",
     *   tags={"小关卡管理"},
     *   summary="返回小关卡列表",
     *   description="返回小关卡列表",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="第几页",
     *         in="query",
     *         name="page",
     *         required=true,
     *         type="integer",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         description="所属chapter_id",
     *         in="query",
     *         name="chapter_id",
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/chapterChildsList")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
   public function actionIndex()
    {
    	$query = $this->modelClass::find();
    	$query->andFilterWhere([
            'chapter_id' => \Yii::$app->request->get('chapter_id'),
        ]);
    	return new ActiveDataProvider([
		    'query' => $query,
		    'pagination' => [
		        'pageSize' => 20,
		    ],
		    // 'sort' => [
		    //     'defaultOrder' => [
		    //         'created_at' => SORT_DESC,
		    //         'title' => SORT_ASC,
		    //     ]
		    // ],
		]);
    }

    /**
     * @SWG\Delete(path="/v1/chapter-items/{id}",
     *   tags={"小关卡管理"},
     *   summary="删除小关卡",
     *   description="删除小关卡",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="小关卡id",
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
     *   @SWG\Response(response=404,description="小关卡不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/v1/chapter-items",
     *   tags={"小关卡管理"},
     *   summary="添加小关卡",
     *   description="添加小关卡",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="小关卡和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/chapterChildsAdd"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/chapterChilds"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/chapter-items/{id}",
     *   tags={"小关卡管理"},
     *   summary="更新小关卡",
     *   description="更新小关卡",
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
     *     description="待更新小关卡和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/chapterChildsAdd"
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
    
    /**
     * @SWG\Get(path="/v1/chapter-items/{id}",
     *   tags={"小关卡管理"},
     *   summary="查看小关卡",
     *   description="查看小关卡",
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
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/chapterChilds"), description="更新成功"),
     *   @SWG\Response(response=404,description="小关卡不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
}
