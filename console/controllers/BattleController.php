<?php

namespace console\controllers;

use Yii;
use common\models\Battle;
use common\models\Msg;
use common\models\PtUser;

class BattleController extends \yii\console\Controller
{
    public function actionIndex()
    {
    	//超时未出结果过的列表
        $models = Battle::find()->where(['status'=> Battle::STATUS_ACTIVE, 'status_win'=> Battle::STATUS_NULL])
        						->andWhere(['>', 'created_at', date('Y-m-d H:i:s', time() - Battle::TIME_INACTIVE)])
        						->all();
        foreach($models as $key => $model) {
        	$userInfo = PtUser::findOne(['id'=> $model->opposite_uid]);
        	Msg::addMsg([
                    'uid'=> $model->uid,
                    'battle_id'=> $model->id,
                    'type'=> Msg::TYPE_BATTLE,
                    'detail'=> "抱歉，您的好友".$userInfo->nick_name."超过24小时未响应你的挑战，该挑战已失效。",
                ]);;
        	$model->status = Battle::STATUS_INACTIVE;
        	$model->save();
        }
    }

}
