<?php

namespace backend\controllers;

use Yii;
use common\models\LoginForm;
use yii\web\Controller;


/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class LoginController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, []);   
    }

    public function actionIndex() {
        $loginModel = new LoginForm();
        $loginModel->username = Yii::$app->request->post('username');
        $loginModel->password = Yii::$app->request->post('password');
        return \Yii::createObject([
                'class' => 'yii\web\Response',
                'format' => \yii\web\Response::FORMAT_JSON,
                'data' => $loginModel->login()
            ]);
    }
}
