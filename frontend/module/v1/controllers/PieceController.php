<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Prop;
use common\models\UserProp;

class PieceController extends \common\base\BaseRestWebController
{
    /**
     * @SWG\Put(path="/v1/pieces/{id}",
     *   tags={"道具"},
     *   summary="碎片合成",
     *   description="碎片合成",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="所属道具的id",
     *         in="path",
     *         name="id",
     *         type="integer",
     *         required=true,
     *     ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="列表接口中获取的数据的ids",
     *     required=true,
     *     @SWG\Schema(
     *       @SWG\Items(ref="#/definitions/ids")
     *     )
     *   ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/responsePiece"),description="请各区城管"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionUpdate()
    {	
    	//道具的碎片列表
    	$pieces = Prop::findPropPiecesById(Yii::$app->request->get('id'));
    	$userPieces = UserProp::findUserPiecesByIds(array_column(Yii::$app->request->bodyParams, 'id'));
    	$isCanComplex = Prop::cTwoPieces($pieces, $userPieces);
    	if ($isCanComplex['code'] != 1) {
    		return $isCanComplex;
    	}
    	$transaction = UserProp::getDb()->beginTransaction();
		try {
			$updateNum  = UserProp::updateAll(['status'=> 0, 'updated_at'=> date('Y-m-d H:i:s')],['in', 'id', array_column(Yii::$app->request->bodyParams, 'id')]);
			if ($updateNum < count($pieces)) {

				throw new \Exception("部分数据没更新到", 1);
			}
			$addProp = UserProp::addProp([['id'=> Yii::$app->request->get('id')]], UserProp::TYPE_PROP);
			if (!$addProp) {
				throw new \Exception("添加失败", 1);
			}
		    $transaction->commit();
		} catch(\Exception $e) {
		    $transaction->rollBack();
		    throw $e;
		} catch(\Throwable $e) {
		    $transaction->rollBack();
		    throw $e;
		}
        $isCanComplex['data'] = $addProp;
    	return $isCanComplex;
    }

}
