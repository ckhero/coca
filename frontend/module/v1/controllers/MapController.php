<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Map;
use common\models\PtUser;
use yii\data\ActiveDataProvider;

class MapController extends \common\base\BaseController
{
	public $modelClass = "common\models\Map";

     public function actions()
     {
          $actions = parent::actions();
          unset($actions['index']);
          return $actions;
     }
	/**
     * @SWG\Get(path="/v1/maps",
     *   tags={"地图"},
     *   summary="获取关卡信息",
     *   description="用户获取关卡信息",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="登陆令牌",
     *         in="query",
     *         name="access-token",
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/currMap"),description="access-token获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
     $response = Yii::$app->response;
     $response->format = \yii\web\Response::FORMAT_JSON;
     $query = $this->modelClass::find();
     // return Map::currentMapId();
     $currId = Map::currentMapId();
     $mapId = Yii::$app->request->get('mapid', $currId);
     //return $this->modelClass::findNeighbors($currId);
     $query->andFilterWhere([
            'id' =>  $mapId,
        ]);
     return ['map'=> $query->one(), '_meta'=> array_merge($this->modelClass::findNeighbors($mapId), ['curr_pos'=> $currId])];
     // return new ActiveDataProvider([
     //          'query' => $query,
     //          'pagination' => [
     //              'pageSize' => 20,
     //          ],
     //          // 'sort' => [
     //          //     'defaultOrder' => [
     //          //         'created_at' => SORT_DESC,
     //          //         'title' => SORT_ASC,
     //          //     ]
     //          // ],
     //      ]);
    }

    /**
     * @SWG\Get(path="/v1/maps/{id}",
     *   tags={"地图"},
     *   summary="某张地图下的所有关卡",
     *   description="查看关卡",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="地图id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/maps"), description="获取成功"),
     *   @SWG\Response(response=404,description="地图不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
}
