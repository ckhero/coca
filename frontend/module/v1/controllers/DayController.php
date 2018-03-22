<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\PtUser;
use common\models\Questions;
use common\models\GameLog;
use common\models\Prop;
use common\models\UserProp;
use common\models\UserChapterRecord;

class DayController extends \common\base\BaseRestWebController
{	

	/**
     * @SWG\Get(path="/v1/days",
     *   tags={"每日任务"},
     *   summary="获取每日任务题目",
     *   description="获取每日任务题目",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/dayResult"), description="获取成功"),
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
        $user = new PtUser();
        if ($user->dayMissionStatus) {
        	return ['code'=> 0, 'message'=> '已完成每日任务'];
        }
        $questions = Questions::dayQuestions();
        return ['code'=> 1, 'message'=> '题目列表获取成功', 'items'=> $questions];
    }

    /**
     * @SWG\Post(path="/v1/days",
     *   tags={"每日任务"},
     *   summary="更新用户每日任务答题结果",
     *   description="更新用户每日任务答题结果",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="用户答题结果",
     *     required=true,
     *     @SWG\Schema(
     *       @SWG\Items(ref="#/definitions/answerSubmitFormat")
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/responseQuestion"), description="提交成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="小关卡不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionUpdate()
    {
    	$user = new PtUser();
        if ($user->dayMissionStatus) {
        	return ['code'=> 0, 'message'=> '已完成每日任务'];
        }
        $options = \Yii::$app->request->getBodyParams();
	    $optionsVerifyRes = Questions::cTwoOptions(Questions::dayQuestions(), $options);
        $extraData = [];
        $optionsVerifyRes['reward'] = [];
	    if ($optionsVerifyRes['code'] === 1 || (isset($optionsVerifyRes['percent']) && $optionsVerifyRes['percent'] >= 0.5)) {
	         //答题成功
	         $pieces = Prop::randomPieces(); //获取1个道具
	         UserProp::addProp($pieces, UserProp::TYPE_PROP); //将碎片添加给用户
             $extraData = ['props'=> json_encode(array_column($pieces, 'id'))];
             $optionsVerifyRes['reward']['pieces'] = $pieces;
	    }
        UserChapterRecord::addRecord(array_merge($optionsVerifyRes, $extraData), UserChapterRecord::TYPE_DAY);//添加过关记录表明关卡已通
	    GameLog::log(['detail'=> json_encode($options)]);
	    return $optionsVerifyRes;

    }

}
