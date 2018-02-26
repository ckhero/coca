<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Msg;
use common\models\PtUser;
use yii\data\ActiveDataProvider;

class MsgController extends \common\base\BaseRestWebController
{	
    
    /**
     * @SWG\Get(path="/v1/msgs",
     *   tags={"消息管理"},
     *   summary="消息列表",
     *   description="消息列表",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="第几页",
     *         in="query",
     *         name="page",
     *         type="integer",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         description="每页数量",
     *         in="query",
     *         name="per-page",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/msgResponse"),description="道具列表获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
         $provider = new ActiveDataProvider([
        		'query'=> Msg::find()->where(['uid'=> Yii::$app->user->id]),
        		'pagination' => [
		        	'pageSize' => Yii::$app->request->get('per-page', 20),
			    ],
			    'sort' => [
			        'defaultOrder' => [
			            'id' => SORT_DESC,
			        ]
			    ],
        	]);
         return $provider;
    }

    /**
     * @SWG\Get(path="/v1/msg/status",
     *   tags={"消息管理"},
     *   summary="是否有新消息",
     *   description="查看用户是否有新消息",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200,  @SWG\Property(property="id", format="int64", type="boolean"),description="true为有新消息。false为没有新消息，消息状态查询成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionStatus()
    {
    	return Yii::$app->cache->get('NewMsg:'.Yii::$app->user->id) == 1;
    }
}
