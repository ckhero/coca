<?php

namespace common\base;

use yii\filters\auth\QueryParamAuth;


class BaseWebController extends \yii\web\Controller

{
    
	public function behaviors()
    {


        $behaviors = parent::behaviors();
        return array_merge($behaviors, [

	            'authenticator'=> [
	                'class' => QueryParamAuth::className(),
	            ]
            ]);
    }
}
