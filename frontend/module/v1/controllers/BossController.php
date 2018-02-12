<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Boss;
use common\models\Questions;
use common\models\GameLog;

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
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $queryParams = [
                ":currTime"=> date('Y-m-d H:i:s'),
            ];
            $bossModel = Yii::$app->db->createCommand('select * from '.Boss::tableName().' where start <= :currTime and end > :currTime and hp > reduced for update', $queryParams)->queryOne();
            if (!empty($bossModel)) {
                //用户选项
                $options = [Questions::findOne(['id'=> Yii::$app->request->getBodyParam('id', 0)])];
                $uerOptions = [Yii::$app->request->bodyParams];
                $isOptionsRight = Questions::cTwoOptions($options, $uerOptions);
                GameLog::log(['detail'=> ';user='], GameLog::TYPE_WORLD);
                // $transaction->commit();
                $nextQuestion = Questions::randomQuestions(1);
                if ($isOptionsRight['code'] == 1) {
                    //答对了
                    return ['code'=> 1, 'message'=> '回答正确', 'nextQuestion'=> $nextQuestion];
                }
                return ['code'=> 0, 'message'=> '题目回答错误', 'nextQuestion'=> $nextQuestion];
            } else {
                //判断用户是否正在参加，参加的话返回答题情况，分发奖品，没有的话
                $battleDetail = Yii::$app->cache->get('Boss_'.date('Ymd').'_'.Yii::$app->user->id);
                if (empty($battleDetail)) {
                    return ['code'=> 0, 'message'=> '世界BOSS还未开始'];
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        sleep(10);
    	return [2];
        //用户选项
        $options = [Questions::findOne(['id'=> Yii::$app->request->getBodyParam('id', 0)])];
        $uerOptions = [Yii::$app->request->bodyParams];
        $isOptionsRight = Questions::cTwoOptions($options, $uerOptions); 
        return ['code'=> 1, 'message'=> $isOptionsRight];
    	//判断选项是否正确
        return $this->render('battle');
    }

}
