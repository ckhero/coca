<?php

namespace frontend\module\v1\controllers;

use Yii;
use common\models\Questions;
use common\models\PtUser;
use common\models\Prop;
use common\models\UserProp;
use common\models\UserChapterRecord;
use common\models\ChapterChild;
use common\models\GameLog;

class ChapterItemController extends \common\base\BaseController
{
	public $modelClass = 'common\models\ChapterChild';

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['update']);
		return $actions;
	}
	/**
     * @SWG\Get(path="/v1/chapter-items/{id}",
     *   tags={"子关卡"},
     *   summary="查看子关卡",
     *   description="获取子关卡的题目",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="关卡id",
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/chapterChilds"), description="获取成功"),
     *   @SWG\Response(response=404,description="关卡不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */

    /**
     * @SWG\Put(path="/v1/chapter-items/{id}",
     *   tags={"子关卡"},
     *   summary="更新用户答题结果",
     *   description="更新用户答题结果",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="小关卡id",
     *     required=true,
     *     type="integer"
     *   ),
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

    public function actionUpdate($id)
    {
         	$options = \Yii::$app->request->getBodyParams();
          $optionsVerifyRes = Questions::verifyChapterOptions($id, $options);
          if (($optionsVerifyRes['code'] === 1 || (isset($optionsVerifyRes['isClearance']) && $optionsVerifyRes['isClearance']))) {
               //第一次答对
               //答题成功
               $optionsVerifyRes['code'] = 1;
               $optionsVerifyRes['reward'] = [];
               if ( UserChapterRecord::isFirstClearance($id) ) {

										Yii::$app->cache->delete('userTotalDone_'.Yii::$app->user->id);//删除完成已完成关卡的缓存
                    $exp = 100;
                    PtUser::addExp($exp);//发放经验
                    UserChapterRecord::addRecord(array_merge($optionsVerifyRes, ['chapter_child_id'=> $id, 'exp'=> $exp]));//添加过关记录表明关卡已通
                    // $pieces = Prop::randomPieces(); //获取五个碎片
                    // UserProp::addProp($pieces); //将碎片添加给用户
                    // UserChapterRecord::addRecord(array_merge($optionsVerifyRes, ['chapter_child_id'=> $id, 'exp'=> $exp, 'props'=> json_encode(array_column($pieces, 'id'))]));//添加过关记录表明关卡已通
                    // $optionsVerifyRes['reward']['pieces'] = $pieces;
                    $optionsVerifyRes['reward']['exp'] = $exp;
                    Yii::$app->cache->delete("userTotalDone_".Yii::$app->user->id);
               }
               PtUser::addNog(1);//增加一次小游戏机会
               $optionsVerifyRes['reward']['nog'] = 1;
          }
          GameLog::log([
                         'chapter_child_id'=> $id,
                         'detail'=> json_encode($options),
                    ]);
          // $user = new PtUser();
          // return $user->dayMissionStatus;
          // return \Yii::$app->user->dayMissionStatus;
          return $optionsVerifyRes;
         	//验证答案的正确性
    }
		/**
     * @SWG\Get(path="/v1/chapter-item/chapter-info",
     *   tags={"子关卡"},
     *   summary="查看闯关情况",
     *   description="查看闯关情况",
     *   operationId="getInventory",
     *   produces={"application/json"},
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
		public function actionChapterInfo()
		{
				return Yii::$app->user->identity;
		}
}
