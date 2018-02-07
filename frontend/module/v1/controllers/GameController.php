<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\UserChapterRecord;
use common\models\PtUser;
use Api\Coca;

class GameController extends \common\base\BaseRestWebController
{	
	/**
     * @SWG\Post(path="/v1/games",
     *   tags={"小游戏"},
     *   summary="小游戏分数提交",
     *   description="小游戏分数提交",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="游戏结果",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/game"
     *     )
     *   ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/response"),description=""),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionUpdate()
    {
        $params = Yii::$app->request->bodyParams;
        if (empty($params['chapter_id']) || $params['point'] <=0) {
        	throw new \Exception("参数有误", 1);
        }
        //检查分数是否翻倍
        $userModel =  PtUser::findById(Yii::$app->user->id);
        if ($userModel->nog < 1) {
        	return ['code'=> 0, 'message'=> '游戏次数不够'];
        }
        $params['point'] = strtotime($userModel->double_end) >= time()? $params['point'] * 2: $params['point'];
        $res = UserChapterRecord::addRecord(['point'=> $params['point'], 'chapter_child_id'=> $params['chapter_id']], UserChapterRecord::TYPE_XIAOXIAOLE);
        $userModel->updateCounters(['nog' => -1]);
        $coca = new Coca();
        $saveRes = $coca->savePoint($res, $userModel->coca_id);
        if ($saveRes['Message'][0]['Value'] == 'Success') {
        	//nog减一
        	
        	return ['code'=> 1, 'message'=> '成功'];
        }
        return ['code'=> 0, 'message'=> '失败'];
    }

}
