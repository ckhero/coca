<?php

namespace frontend\module\v1\controllers;

use Yii;
use Api\Coca;
use common\models\PtUser;
use yii\data\ActiveDataProvider;

class RankController extends \common\base\BaseRestWebController
{	
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            // [
            //     'class' => 'yii\filters\PageCache',
            //     'only' => ['index'],
            //     'duration' => 60,
            //     'variations' => [
            //         Yii::$app->language,
            //         Yii::$app->request->get('page'),
            //         Yii::$app->request->get('type'),
            //         Yii::$app->request->get('per-page'),
            //     ],
            //     // 'dependency' => [
            //     //     'class' => 'yii\caching\DbDependency',
            //     //     'sql' => 'SELECT COUNT(*) FROM post',
            //     // ],
            // ],
        ]);
    }
	/**
     * @SWG\Get(path="/v1/ranks",
     *   tags={"排行榜"},
     *   summary="返回排行榜",
     *   description="返回排行榜",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="排行榜类型，积分用point，经验用exp",
     *         in="query",
     *         name="type",
     *         type="string",
     *         required=false,
     *     ),
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/rank")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    public function actionIndex($type = 'point')
    {	
    	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($type == 'point') {
        	$coca = new Coca();
        	return $coca->ranks(Yii::$app->request->get('page'));
        }
        $query = PtUser::find();

        $perPage = Yii::$app->request->get('per-page', 20);

    	$provider= new ActiveDataProvider([
		    'query' => $query,
		    'pagination' => [
		        'pageSize' => $perPage,
		    ],
		    'sort' => [
		        'defaultOrder' => [
		            'exp' => SORT_DESC,
		        ]
		    ],
		]);
        $oldModels = $provider->getModels();
        $currentPage = Yii::$app->request->get('page', 1);
        
        foreach($oldModels as $key => $model) {
            $model->rank = $provider->getTotalCount()> $perPage? $perPage * ($currentPage - 1) + $key + 1: $key + 1;
            $newModels[] = $model;
        }
        $provider->setModels($newModels);
        return $provider;
    }

}
