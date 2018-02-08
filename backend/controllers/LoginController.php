<?php

namespace backend\controllers;

use Yii;
use common\models\LoginForm;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class LoginController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'verbs' =>  [
                'class' =>  VerbFilter::className(),
                'actions'   =>  [
                    'index'    =>  ['post', 'get'],
                ]
            ]
        ]);   
    }
    /**
     * @SWG\Post(path="/login",
     *   tags={"管理员"},
     *   summary="登录获取access-token",
     *   description="登录获取access-token，用于接口调用时候的验证",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="用户名",
     *         in="formData",
     *         name="username",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Parameter(
     *         description="密码",
     *         in="formData",
     *         name="password",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/LoginResult"),description="access-token获取成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex() {
        $loginModel = new LoginForm();
        $loginModel->username = Yii::$app->request->post('username');
        $loginModel->password = Yii::$app->request->post('password');
        $login = $loginModel->login();

        $response = Yii::$app->getResponse();
        $response->format = \yii\web\Response::FORMAT_JSON;
        if ($login['code'] == 0) {

            $response->setStatusCode(404);
            return [
                'code' => 0,
                'message'=> '没找到对应账号密码的用户',
            ];
        } ;
        $response->setStatusCode(200);
        
        return [
            'access-token' => $login['access-token'],
            'expire-time'=> 3600,
        ];
    }
}
