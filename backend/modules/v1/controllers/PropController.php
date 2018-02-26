<?php

namespace backend\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Prop;

class PropController extends \common\base\BaseController
{
	public $modelClass = 'common\models\Prop';

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}
	/**
     * @SWG\Get(path="/v1/props",
     *   tags={"道具管理"},
     *   summary="返回道具列表",
     *   description="返回道具列表",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="第几页",
     *         in="path",
     *         name="query",
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/propsList")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    public function actionIndex()
    {
    	$query = $this->modelClass::find()->where(['pid' => 0]);
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
     * @SWG\Delete(path="/v1/props/{id}",
     *   tags={"道具管理"},
     *   summary="删除道具",
     *   description="删除道具",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="道具id",
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
     *   @SWG\Response(response=404,description="道具不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/v1/props",
     *   tags={"道具管理"},
     *   summary="添加道具",
     *   description="添加道具",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="道具和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/props"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/props"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/props/{id}",
     *   tags={"道具管理"},
     *   summary="更新道具",
     *   description="更新道具",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="道具id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="待更新道具和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/props"
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/props"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="道具不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Get(path="/v1/props/{id}",
     *   tags={"道具管理"},
     *   summary="查看道具",
     *   description="查看道具",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="道具id",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/props"), description="更新成功"),
     *   @SWG\Response(response=404,description="道具不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */

}
