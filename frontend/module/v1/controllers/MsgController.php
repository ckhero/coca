<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Msg;
use common\models\PtUser;
use common\models\Battle;
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
         $oldModels = $provider->getModels();
         $newModels = [];
         foreach($oldModels as $key => $model) {
            $model->battleStatus = null;
            if($model->is_battle == Msg::STATUS_BATTLE) {
                $battleInfo = Battle::findOne(['id'=> $model->battle_id]);
                if ($battleInfo['created_at'] < date('Y-m-d H:i:s', time() - Battle::TIME_INACTIVE) && $battleInfo['status_win'] == Battle::STATUS_NULL) {
                    $model->battleStatus = 2;//对战未完成，超时
                } else if ($battleInfo['status_win'] > Battle::STATUS_NULL) {
                    $model->battleStatus = 1;//对战完成
                } else {
                    $isOppositeUser = Battle::isOppositeUser($battleInfo);//是否是发起者
                    if (($isOppositeUser && $battleInfo['opposite_record_id'] > 0) || (!$isOppositeUser && $battleInfo['record_id'] > 0)) {
                        $model->battleStatus = 3;//你已经完成答题，对手 尚未完成
                    }else {
                        $model->battleStatus = 4;//未完成答题，需要进行答题
                    }
                }
            }
            
            $newModels[] = $model;
         }
         $provider->setModels($newModels);
         Yii::$app->cache->delete('NewMsg:'.Yii::$app->user->id); //删除有新消息的z状态
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
