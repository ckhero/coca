<?php

namespace frontend\controllers;

use Yii;
use common\models\PtUser;
use common\models\Level;
use common\models\Chapter;
use common\models\ChapterChild;

class CocaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @SWG\Get(path="/coca/login",
     *   tags={"用户"},
     *   summary="登录获取access-token",
     *   description="登录获取access-token，用于接口调用时候的验证",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="用户名",
     *         in="formData",
     *         name="username",
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         description="密码",
     *         in="formData",
     *         name="password",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/loginResult"),description="access-token获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
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
        // var_dump($user);
    	var_dump($user->id,ChapterChild::totalDone($user->id));exit;
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

    /**
     * @SWG\Post(path="/coca/refresh",
     *   tags={"用户"},
     *   summary="刷新access-token",
     *   description="刷新access-token，用于接口调用时候的验证",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="刷新令牌",
     *         in="formData",
     *         name="refresh-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/loginResult"),description="access-token刷新成功"),
     *   @SWG\Response(response=400,description="refresh不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionRefresh()
    {
        $model = PtUser::findIdentityByRefreshToken(Yii::$app->request->post('refresh-token', ''));
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model == null) {
            throw new \yii\web\BadRequestHttpException;
        }
        $acessToken = $model->generateAccessToken();
        $model->save();
        return [
            'access_token'=> $acessToken,
            'access_expired'=> 3600,
        ];
    }

}
