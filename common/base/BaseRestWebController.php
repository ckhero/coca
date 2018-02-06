<?php

namespace common\base;

use yii\filters\auth\QueryParamAuth;


class BaseRestWebController extends \yii\rest\Controller

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
