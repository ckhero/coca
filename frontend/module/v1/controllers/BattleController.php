<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\PtUser;
use common\models\Battle;
use common\models\Msg;
use common\models\Questions;
use common\models\UserChapterRecord;
use Api\Coca;

class BattleController extends \common\base\BaseRestWebController
{	
	public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60,
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->request->get('page'),
                    Yii::$app->request->get('type'),
                    Yii::$app->request->get('per-page'),
                ],
                // 'dependency' => [
                //     'class' => 'yii\caching\DbDependency',
                //     'sql' => 'SELECT COUNT(*) FROM post',
                // ],
            ],
        ]);
    }

    /**
     * @SWG\Post(path="/v1/battles",
     *   tags={"好友对战"},
     *   summary="发起对战",
     *   description="发起对战",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="挑战对手信息",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/opponents"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/battleResponse"), description="挑战成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionCreate()
    {
        $userInfo = PtUser::findOrCreateByCache(Yii::$app->request->getBodyParam('coca_id', 0));
        $battleModel = Battle::findOrCreateBattle($userInfo->id);
        if (!isset($battleModel->record_id)) { //说明是新创建的，一个小时内对同一个人只能发起一次对战
            $ownUserInfo = PtUser::findById(Yii::$app->user->id);
            Msg::addMsg([
                    'uid'=> $userInfo->id,
                    'battle_id'=> $battleModel->id,
                    'type'=> Msg::TYPE_BATTLE,
                    'detail'=> $ownUserInfo->nick_name." 在 ".date('Y-m-d H:i:s')." 向你发起1v1挑战，快来对战吧~",
                ]); 
        }
        return $battleModel;
    }

    /**
     * @SWG\Get(path="/v1/battles",
     *   tags={"好友对战"},
     *   summary="对战列表",
     *   description="获取对战列表",
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
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/battle"), description="获取成功"),
     *   @SWG\Response(response=404,description="没有可供选择的对战列表"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
    	//return Yii::$app->cache->get('COCA_33');
    	$coca = new Coca();
    	$userList = $coca->onlineList(Yii::$app->request->get('page', 1), Yii::$app->request->get('per-page', 20));
    	foreach($userList['items'] as $key=> $user) {
    		Yii::$app->cache->set('COCA_'.$user['coca_id'], $user, 3600);
    	}
    	return $userList;
    }

    /**
     * @SWG\Put(path="/v1/battles/{battle_id}",
     *   tags={"好友对战"},
     *   summary="对战答题提交",
     *   description="对战答题提交",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="挑战的 id",
     *         in="path",
     *         name="battle_id",
     *         required=true,
     *         type="integer"
     *     ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="用户答题结果",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/answerSubmitFormatWithTime"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/battleResult"), description="挑战成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionUpdate($id)
    {
        //return \Yii::$app->request->getBodyParam('options');
        //$battleModel = Battle::find()->where(['id'=> $id])->andWhere(['>', 'created_at', date('Y-m-d H:i:s', time() - 3600)])->one();
        $transaction = Yii::$app->db->beginTransaction(); 
        //$battleModel = Battle::findOne(['id'=> $id]);
        $battleRecord = Yii::$app->db->createCommand('select * from '.Battle::tableName().' where id = :id', [':id'=> $id])->queryOne();

        if (is_null($battleRecord) || $battleRecord['created_at'] < date('Y-m-d H:i:s', time() - 3600 * 24)) {
            return ['code'=> 0, 'message'=> '对战信息不存在或已失效'];
        }
        $isOppositeUser = Battle::isOppositeUser($battleRecord);//是否是发起者

        //对战结果已更新
        if ($battleRecord['status_win'] != Battle::STATUS_NULL) { 
            
            return $this->getStatus($isOppositeUser, $battleRecord['status_win']);
        }
        if (!($battleRecord['record_id'] > 0 && $battleRecord['opposite_record_id'] > 0)) {
            //判断是否是重复答题
            if (($isOppositeUser && $battleRecord['opposite_record_id'] > 0) || (!$isOppositeUser && $battleRecord['record_id'] > 0)) {
                return ['code'=> 2, 'message'=> '您已完成答题,对手尚未完成答题'];
            }

            $battleModel = new Battle();
            $cRes = Questions::cTwoOptions($battleModel->getQuestions($id), \Yii::$app->request->getBodyParam('options'));  //对比结果
            $recordModel = UserChapterRecord::addRecord(array_merge($cRes, ['cost_time'=> \Yii::$app->request->getBodyParam('cost_time')]), 
                UserChapterRecord::TYPE_BATTLE);

            if ($isOppositeUser) {
            //出结果
                $battleRecord['opposite_record_id'] = $recordModel->id;   
            } else {
                $battleRecord['record_id'] = $recordModel->id;
            }
        } 
        $battleResultStatus = -1;
        if ($battleRecord['record_id'] > 0 && $battleRecord['opposite_record_id'] > 0) {
            //战斗结果计算
            $battleResultStatus = Battle::cBattle($battleRecord['record_id'], $battleRecord['opposite_record_id']);  
        }
        //更新操作
        Yii::$app->db->createCommand('update '.Battle::tableName().' set '.($isOppositeUser? 'opposite_record_id': 'record_id').' =  :record_id , status_win = :status_win where id =:id ', [':id'=> $id, ':record_id'=> $isOppositeUser? $battleRecord['opposite_record_id']: $battleRecord['record_id'], ':status_win'=> $battleResultStatus])->execute();
        $transaction->commit();

        if ($battleRecord['opposite_record_id'] > 0 && $battleRecord['record_id'] > 0) {

            $userInfo = PtUser::findOne(['id'=> $battleRecord['uid']]);
            $oppositeUserInfo = PtUser::findOne(['id'=> $battleRecord['opposite_uid']]);

            Msg::addMsg([
                    'uid'=> $userInfo->id,
                    'battle_id'=> $battleRecord['id'],
                    'type'=> Msg::TYPE_BATTLE,
                    'detail'=> "你在".$battleRecord['created_at']."发起的1v1对战赛中，".Battle::$result[$this->getStatus(false, $battleResultStatus)['status_win']],
                ]);
            Msg::addMsg([
                    'uid'=> $oppositeUserInfo->id,
                    'battle_id'=> $battleRecord['id'],
                    'type'=> Msg::TYPE_BATTLE,
                    'detail'=> "你在 ".$userInfo->nick_name.' '.$battleRecord['created_at']."发起的1v1对战赛中，".Battle::$result[$this->getStatus(true, $battleResultStatus)['status_win']],
                ]);
            return array_merge($cRes,$this->getStatus($isOppositeUser, $battleResultStatus));
        }
        return array_merge($cRes, ['code'=> 2, 'message'=> '完成答题,对手尚未完成答题']);
    }

    /**
     * [getStatus 输赢状态吗  0 输了，1为赢啦 2为平均]
     * #Author ckhero
     * #DateTime 2018-02-26
     * @param  [type] $isOppositeUser [description]
     * @param  [type] $statusWin      [description]
     * @return [type]                 [description]
     */
    public function getStatus($isOppositeUser, $statusWin)
    {
        if ($isOppositeUser && $statusWin == Battle::STATUS_WIN) {
            return ['code'=> 1, 'message'=> Battle::$result[Battle::STATUS_LOSE], 'status_win'=> Battle::STATUS_LOSE];
        } else if ($isOppositeUser && $statusWin == Battle::STATUS_LOSE) {
            return ['code'=> 1, 'message'=> Battle::$result[Battle::STATUS_WIN], 'status_win'=> Battle::STATUS_WIN];
        }
        return ['code'=> 1, 'message'=> Battle::$result[$statusWin], 'status_win'=> $statusWin];
    }


    /**
     * @SWG\Get(path="/v1/battles/{battle_id}",
     *   tags={"好友对战"},
     *   summary="获取对战题目",
     *   description="获取对战题目",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="挑战的 id",
     *         in="path",
     *         name="battle_id",
     *         required=true,
     *         type="integer"
     *     ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/battleResponse"), description="挑战成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionView($id) 
    {
        $battleModel = new Battle();
        return ['id'=> $id, 'questions'=> $battleModel->getQuestions($id)];
    }

}
