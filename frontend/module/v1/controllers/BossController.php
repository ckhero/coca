<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Boss;
use common\models\Questions;
use common\models\GameLog;
use common\models\UserChapterRecord;
use common\models\Prop;
use common\models\UserProp;

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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/bossResult"), description="获取成功"),
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
        $code = 2;
        $message = '世界BOSS还未开始';
        try {
            $queryParams = [
                ":currTime"=> date('Y-m-d H:i:s'),
            ];
            $bossInfo = Yii::$app->db->createCommand('select * from '.Boss::tableName().' where start <= :currTime and end > :currTime and hp > reduced for update', $queryParams)->queryOne();
            if (!empty($bossInfo)) {
                //用户选项
                $options = [Questions::getBossQuestion()];
                $uerOptions = [Yii::$app->request->bodyParams];
                $isOptionsRight = Questions::cTwoOptions($options, $uerOptions);
                GameLog::log(['detail'=> 'option='.var_export($options[0], true).';userOption='.var_export($uerOptions[0], true)], GameLog::TYPE_WORLD);
               
                $nextQuestion = Questions::getBossQuestion('new');

                $code = $isOptionsRight['code'] == 1? 1: 0; //状态码的值  0为答错题目，1为题目答对，2为boss战还未开始，3为当回答正确，答完该题后boss死亡
                $message = '题目回答错误';
                $bossRecord = UserChapterRecord::updateOrCreateBossRecord(['id'=> $bossInfo['id'], 'right_num'=> $code]);
                
                if ($code == 1) {
                    //答对
                    $message = '回答正确';
                    Yii::$app->db->createCommand('update '.Boss::tableName().' set reduced =  reduced + 1 where id =:id ', [':id'=> $bossInfo['id']])->execute();
                }
                
                if (($bossInfo['hp'] - $bossInfo['reduced']) > 1 || $code != 1) { //答错或者答对的不是最后一题，答对最后一题的话要发放奖励
                    $transaction->commit();
                    return ['code'=> $code, 'message'=> $message, 'total'=> $bossRecord['total'], 'right_num'=> $bossRecord['right_num'], 'nextQuestion'=> $nextQuestion];
                }
                $message = '回答正确,并且boss死亡';
                $code = 3;
            } 
            //判断用户是否正在参加，参加的话返回答题情况，分发奖品，没有的话
            $battleDetail = Yii::$app->cache->get('Boss_'.Yii::$app->user->id);
            $deadBossInfo = Boss::findOne(['id'=> $battleDetail['boss_id']]);
            if ($deadBossInfo['hp'] == $deadBossInfo['reduced']) {
                //boss死亡，发放奖励
                $userRecord = UserChapterRecord::findOne(['id'=> $battleDetail['record_id'], 'status'=> UserChapterRecord::STATUS_UNISSUED]);
                if (!is_null($userRecord)) {
                    //可发放奖励
                    $code = 4;
                    $message = '参与答题,奖励发放成功';
                    
                    $pieces = Prop::randomPieces(); //获取五个碎片
                    UserProp::addProp($pieces); //将碎片添加给用户
                    $userRecord->props = json_encode(array_column($pieces, 'id'));
                    $userRecord->status = UserChapterRecord::STATUS_ISSUED;
                    $userRecord->save();
                }
            }
            $transaction->commit();
            return ['code'=> $code, 'message'=> $message];
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

}
