<?php

namespace frontend\controllers;

use Yii;
use common\models\PtUser;
use common\models\Level;
use common\models\Chapter;
use common\models\ChapterChild;
use Api\Coca;

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
        
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // $arr = json_decode('{"timestamp":1517911177,"nonce":"NPUAMnOlvEmsAMibnEWa4xt3dGeKYtcX","str":"69a63a93c06a0c52NPUAMnOlvEmsAMibnEWa4xt3dGeKYtcX1517911177","signature":"7ecdf946f496f733638a33b2ad56e60ac4ecbc76"}', true);
     //    arsort($arr);
     //    return $arr;
    	$params = Yii::$app->request->get(); 
    	// if ((time() - @$params['TimeStamp']) > 500) {
    	// 	return [
    	// 		'Status'=> '002',
    	// 		'Message'=> [
    	// 			'Key'=> '超时',
    	// 			'Value'=> 'TimeOut',
    	// 		],
    	// 		'Data'=> null,
    	// 	];
    	// }

        $coca = new Coca();
        return $coca->savePoint();
    	// if (!$coca->checkSign($params)) {
    	// 	return [
    	// 		'Status'=> '003',
    	// 		'Message'=> [
    	// 			'Key'=> '签名验证失败',
    	// 			'Value'=> 'signature error',
    	// 		],
    	// 		'Data'=> null,
    	// 	];
    	// }
        return $coca->getSign();exit;
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
