<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Rules;

class RuleController extends \common\base\BaseRestWebController
{
	/**
     * @SWG\Get(path="/v1/rules",
     *   tags={"帮助"},
     *   summary="获取帮助",
     *   description="获取帮助",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/rule"), description="获取成功"),
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
    	return Yii::$app->cache->getOrSet('rules2', function (){
    		return Rules::find()->where(['status' =>1])->orderBy('id DESC')->one();
    	}, 120);
    }
}
