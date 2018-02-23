<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\PtUser;
use common\models\Battle;
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
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/opponents"), description="挑战成功"),
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/bossResult"), description="获取成功"),
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

}
