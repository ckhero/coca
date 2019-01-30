<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/13/013
 * Time: 22:09
 */

namespace console\controllers;


use Api\Coca;
use common\models\PtUser;
use common\models\User;
use common\models\UserChapterRecord;
use yii\console\Controller;

class FixController extends Controller
{
    public function actionFixPoint()
    {
        $list = UserChapterRecord::findAll([
            'chapter_child_id' => 1
        ]);
        $coca = new Coca();
        foreach($list as $item) {
            $user = PtUser::findOne($item->uid);
            $coca->savePoint($item, $user->coca_id);
            echo 'UserId:' . $user->id . ';RecordId:' . $item->id .PHP_EOL;
            break;
        }
        echo 'End';
    }
}