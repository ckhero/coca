<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\UserProp;
use common\models\PtUser;
use yii\data\ActiveDataProvider;

class PropController extends \common\base\BaseRestWebController
{	
	/**
     * @SWG\Get(path="/v1/props",
     *   tags={"道具"},
     *   summary="获取道具和碎片的列表",
     *   description="获取道具和碎片的列表",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/props"),description="道具列表获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
        return new ActiveDataProvider([
        		'query'=> UserProp::find()->innerJoinWith('prop')->where(['status'=> UserProp::STATUS_ACTIVE, 'uid'=> Yii::$app->user->id]),
        		'pagination' => [
		        	'pageSize' => Yii::$app->request->get('per-page', 20),
			    ],
			    'sort' => [
			        'defaultOrder' => [
			            'id' => SORT_DESC,
			        ]
			    ],
        	]);
    }

    /**
     * @SWG\Post(path="/v1/props",
     *   tags={"道具"},
     *   summary="道具使用",
     *   description="道具使用",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="列表接口中获取的数据的id",
     *         in="formData",
     *         name="id",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/response"),description="请各区城管"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionUpdate()
    {
        $model = UserProp::findOne([
        		'uid' => Yii::$app->user->id,
        		'id'=> Yii::$app->request->post('id', 0),
        		'status'=> UserProp::STATUS_ACTIVE,
        		'type'=> UserProp::TYPE_PROP, 
        	]);
        if (is_null($model)) {
        	return ['code'=> 0, 'message'=> '道具没找到，或者已被使用'];
        }
        $model->status = UserProp::STATUS_INACTIVE;
        $model->save();
        PtUser::addDoubleTime();
        return ['code'=> 1, 'message'=> '使用成功'];
    }

}
