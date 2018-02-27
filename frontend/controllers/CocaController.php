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
     * @SWG\Get(path="/coca/login?TimeStamp=1517208547&Nonce=a909d84864f248bb15a22437448f1875&signature=59798734ca1f2d6e1c5d4ab84ac659c93f90d3e7&KOUserId=11111&NickName=test&HeadImgUrl=http://img0.imgtn.bdimg.com/it/u=12867320,655225767&fm=214&gp=0.jpg",
     *   tags={"用户"},
     *   summary="登录获取access-token",
     *   description="登录获取access-token，用于接口调用时候的验证;url中的参数到时可乐那边会传给你，接口调试跳过程中暂时先用这个链接访问",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/loginResult"),description="access-token获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    public function actionLogin()
    {
        \Yii::beginProfile('login');

    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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
    	if (!$coca->checkSign($params)) {
    		return [
    			'Status'=> '003',
    			'Message'=> [
    				'Key'=> '签名验证失败',
    				'Value'=> 'signature error',
    			],
    			'Data'=> null,
    		];
    	}
    	$user = PtUser::loginOrCreate($params);
        \Yii::endProfile('myBenchmark');
        return $user;
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
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/refreshResult"),description="access-token刷新成功"),
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
