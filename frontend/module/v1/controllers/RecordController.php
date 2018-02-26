<?php

namespace frontend\module\v1\controllers;


use Yii;
use Api\Coca;
use common\models\UserChapterRecord;
use yii\data\ActiveDataProvider;


class RecordController extends \common\base\BaseRestWebController
{
    /**
     * @SWG\Get(path="/v1/records",
     *   tags={"经验积分流水"},
     *   summary="经验积分流水",
     *   description="返回排行榜",
     *   operationId="经验积分流水",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="流水类型，积分用point，经验用exp",
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
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/record")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    public function actionIndex($type = 'point')
    {	
    	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // if ($type == 'point') {
        // 	$coca = new Coca();
        // 	return $coca->onlineList(Yii::$app->request->get('page', 1), Yii::$app->request->get('per-page', 20));
        // }
        $query = UserChapterRecord::find()->where(['uid'=> Yii::$app->user->id])
        								  ->andWhere(['>', $type, 0]);

        $perPage = Yii::$app->request->get('per-page', 20);
        
    	$provider= new ActiveDataProvider([
		    'query' => $query,
		    'pagination' => [
		        'pageSize' => $perPage,
		    ],
		    'sort' => [
		        'defaultOrder' => [
		            'id' => SORT_DESC,
		        ]
		    ],
		]);
        // $oldModels = $provider->getModels();
        // $currentPage = Yii::$app->request->get('page', 1);
        
        // foreach($oldModels as $key => $model) {
        //     $model->rank = $provider->getTotalCount()> $perPage? $perPage * ($currentPage - 1) + $key + 1: $key + 1;
        //     $newModels[] = $model;
        // }
        // $provider->setModels($newModels);
        return $provider;
    }

}
