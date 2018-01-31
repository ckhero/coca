<?php

namespace common\base;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use \yii\web\Controller;

class BaseController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [

            'authenticator'=> [
                'class' => QueryParamAuth::className(),
            ]
        ];
    }

	public function jsonReturn($data = [])
	{
		return \Yii::createObject([
                'class' => 'yii\web\Response',
                'format' => \yii\web\Response::FORMAT_JSON,
                'data' => $data
            ]);
	}
}
