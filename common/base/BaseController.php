<?php

namespace common\base;

use yii\filters\auth\QueryParamAuth;


class BaseController extends \yii\rest\ActiveController

{
	public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    
	public function behaviors()
    {


        $behaviors = parent::behaviors();
        return array_merge($behaviors, [

	            // 'authenticator'=> [
	            //     'class' => QueryParamAuth::className(),
	            // ]
            ]);
    }
}
