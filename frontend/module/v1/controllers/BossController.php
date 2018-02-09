<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Boss;

class BossController extends \common\base\BaseRestWebController
{	/**
     * @SWG\Post(path="/v1/bosses",
     *   tags={"世界boss"},
     *   summary="获得题目",
     *   description="提交答题结果，返回下一个题目，以及boss状态（首次请求无需提交答题结果）",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="答题结果",
     *     @SWG\Schema(
     *       ref="#/definitions/option"
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/dayResult"), description="获取成功"),
     *   @SWG\Response(response=404,description="世界boss还未开始"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionBattle()
    {	
    	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	//判断boss状态
    	$bossModel = Boss::findCurrentBoss();
    	if (is_null($bossModel) || $bossModel->hp <= $bossModel->reduced) {
    		//判断用户是否正在参加，参加的话返回答题情况，分发奖品，没有的话
    	}
    	//判断选项是否正确
        return $this->render('battle');
    }

}
