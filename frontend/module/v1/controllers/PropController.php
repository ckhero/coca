<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\UserProp;
use common\models\PtUser;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;


class PropController extends \common\base\BaseRestWebController
{	
	/**
     * @SWG\Get(path="/v1/props",
     *   tags={"道具"},
     *   summary="获取道具和碎片的列表",
     *   description="获取道具和碎片的列表",
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
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/props2"),description="道具列表获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
       //  $provider = new ActiveDataProvider([
       //  		'query'=> UserProp::find()->innerJoinWith('prop')->where(['status'=> UserProp::STATUS_ACTIVE, 'uid'=> Yii::$app->user->id]),
       //  		'pagination' => [
		     //    	'pageSize' => Yii::$app->request->get('per-page', 20),
			    // ],
			    // 'sort' => [
			    //     'defaultOrder' => [
			    //         'id' => SORT_DESC,
			    //     ]
			    // ],
       //  	]);
       //  $oldModels = $provider->getModels();
       //  $currentPage = Yii::$app->request->get('page', 1);
        
       //  foreach($oldModels as $key => $model) {
       //      return $model->prop;
       //      if (isset($newModels[$model->prop->pid][$model->prop_id])) {

       //          $newModels[$model->prop->pid][$model->prop_id]->num += 1;
       //          continue;
       //      }

       //      $model->num = 1;
       //      $newModels[$model->prop->pid][$model->prop_id] = $model;
       //  }
       //  $provider->setModels($newModels);
       //  return $provider;
        $count = Yii::$app->db->createCommand("select count(1) from (select co_prop.id, co_prop.name, co_prop.desc, co_prop.img_url, co_user_prop.type, count(1) as num,if (co_prop.pid = 0 ,co_prop.id, co_prop.pid) as pid from co_prop inner join co_user_prop on co_prop.id = co_user_prop.prop_id where co_user_prop.uid = :uid and co_user_prop.status = :status group by co_prop.name order by co_prop.id) as a group by a.pid", [':uid' => Yii::$app->user->id, ':status'=> UserProp::STATUS_ACTIVE])->queryScalar();

        $provider = new SqlDataProvider([
            'sql' => "select co_prop.*, b.num,b.pieces from co_prop inner join (select * ,group_concat(concat_ws(' ',id,name,num, type, img_url)) as pieces from (select co_prop.id, co_prop.name, co_prop.desc, co_prop.img_url, co_user_prop.type, count(1) as num,if (co_prop.pid = 0 ,co_prop.id, co_prop.pid) as pid from co_prop left join co_user_prop on co_prop.id = co_user_prop.prop_id where co_user_prop.uid = :uid and co_user_prop.status = :status group by co_prop.name order by co_prop.id) as a group by a.pid) as b on b.pid=co_prop.id ",
            'params' => [':uid' => Yii::$app->user->id, ':status'=> UserProp::STATUS_ACTIVE],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page', 20),
            ],
            // 'sort' => [
            //     'attributes' => [
            //         'id' => SORT_DESC
            //     ],
            // ],
        ]);

        $oldModels = $provider->getModels();
        $currentPage = Yii::$app->request->get('page', 1);
        $newModels = [];
        foreach($oldModels as $key => $model) {
            $pieces = [];
            $pieces = explode(',', $model['pieces']);
            $model['pieces'] = [];
            $model['num'] = 0;
            foreach ($pieces as $pieceStr) {
                $pieceArr = explode(' ', $pieceStr);

                if ($pieceArr[3] != 1) {
                    $model['pieces'][] = [
                        'id'=> $pieceArr[0],
                        'name'=> $pieceArr[1],
                        'num'=> $pieceArr[2],
                        'type'=> $pieceArr[3],
                        'img_url'=> $pieceArr[4],
                    ];
                } else {
                    $model['num'] = $pieceArr[2];
                }
                
            }
            $newModels[] = $model;
        }
        $provider->setModels($newModels);

        return $provider;

    }

    /**
     * @SWG\Post(path="/v1/props",
     *   tags={"道具"},
     *   summary="道具使用",
     *   description="道具使用",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="要使用的道具id",
     *         in="formData",
     *         name="id",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/response"),description="请各区城管"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionUpdate()
    {
        $model = UserProp::findOne([
        		'uid' => Yii::$app->user->id,
        		'prop_id'=> Yii::$app->request->post('id', 0),
        		'status'=> UserProp::STATUS_ACTIVE,
        		'type'=> UserProp::TYPE_PROP, 
        	]);
        if (is_null($model)) {
        	return ['code'=> 0, 'message'=> '道具没找到，或者已被使用'];
        }
        $model->status = UserProp::STATUS_INACTIVE;
        $model->save();
        PtUser::addDoubleTime();
        return ['code'=> 1, 'message'=> '使用成功'];
    }

}
