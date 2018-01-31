<?php

namespace backend\modules\v1\controllers;

use yii\web\Controller;
use yii\rest\ActiveController;
use common\models\Questions;

/**
 * Default controller for the `v1` module
 */
class QuestionController extends ActiveController
{
	public $modelClass = 'common\models\Questions';
    /**
     * Renders the index view for the module
     * @return string
     */
    // public function actionView()
    // {
    //     return Questions::findOne(1);
    // }
}
