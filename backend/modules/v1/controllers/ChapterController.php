<?php

namespace backend\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Chapter;

class ChapterController extends \common\base\BaseController
{
	public $modelClass = 'common\models\Chapter';

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}
	/**
     * @SWG\Get(path="/v1/chapters",
     *   tags={"关卡管理"},
     *   summary="返回关卡列表",
     *   description="返回关卡列表",
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
     *    @SWG\Parameter(
     *         description="每页的数量",
     *         in="query",
     *         name="per-page",
     *         required=true,
     *         type="integer",
     *         required=false,
     *     ),
     *      @SWG\Parameter(
     *         description="所属地图id",
     *         in="query",
     *         name="map_id",
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/chaptersList")), description="获取成功"),
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
            'map_id' => \Yii::$app->request->get('map_id'),
        ]);
    	return new ActiveDataProvider([
		    'query' => $query,
		    'pagination' => [
		        'pageSize' => Yii::$app->request->get('per-page', 20),
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
     * @SWG\Delete(path="/v1/chapters/{id}",
     *   tags={"关卡管理"},
     *   summary="删除关卡",
     *   description="删除关卡",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="关卡id",
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
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/v1/chapters",
     *   tags={"关卡管理"},
     *   summary="添加关卡",
     *   description="添加关卡",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="关卡和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/chapterAdd"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/chapters"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/chapters/{id}",
     *   tags={"关卡管理"},
     *   summary="更新关卡",
     *   description="更新关卡",
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
     *     in="body",
     *     name="body",
     *     description="待更新关卡和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/chapterAdd"
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/chapters"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Get(path="/v1/chapters/{id}",
     *   tags={"关卡管理"},
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
