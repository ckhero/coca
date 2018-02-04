<?php

namespace frontend\controllers;

use Yii;
use common\models\PtUser;
use common\models\Level;

class CocaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
    	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$params = Yii::$app->request->get(); 
    	// if ((time() - $params['TimeStamp']) > 500) {
    	// 	return [
    	// 		'Status'=> '002',
    	// 		'Message'=> [
    	// 			'Key'=> '超时',
    	// 			'Value'=> 'TimeOut',
    	// 		],
    	// 		'Data'=> null,
    	// 	];
    	// }

    	// if (!$this->checkSign($params)) {
    	// 	return [
    	// 		'Status'=> '003',
    	// 		'Message'=> [
    	// 			'Key'=> '签名验证失败',
    	// 			'Value'=> 'signature error',
    	// 		],
    	// 		'Data'=> null,
    	// 	];
    	// }

    	$user = PtUser::loginOrCreate($params);
    	var_dump($user->level);exit;
        return [
    			'Status'=> '001',
    			'Message'=> [
    				'Key'=> '成功',
    				'Value'=> 'Success',
    			],
    			'Data'=> null,
    		];
    }

    public function checkSign($params = [])
    {

    	$paramsTmp['token'] = '69a63a93c06a0c52';
    	$paramsTmp['nonce'] = $params['Nonce']?? '';
    	$paramsTmp['timestamp'] = $params['TimeStamp']?? '';
    	ksort($paramsTmp);
    	$str = implode('', $paramsTmp);
    	return sha1($str) == strtolower($params['signature']?? 0);
    }

}
