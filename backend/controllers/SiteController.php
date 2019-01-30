<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Map;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
{
    return ArrayHelper::merge([
        [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS','POST'],
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'x-token'],  
            ],

            'actions' => [
                'login' => [
                    'Access-Control-Allow-Credentials' => true,
                ]
            ]
        ],
    ], parent::behaviors());
}

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $maps = Map::find()->with('chapters')->all();
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionGenSwg()
    {
        $projectRoot = Yii::getAlias('@myapiroot');

        $swagger = \Swagger\scan($projectRoot);
        $json_file = $projectRoot . '/web/swagger-docs/swagger.json';
        $is_write = file_put_contents($json_file, $swagger);
        if ($is_write == true) {
            $this->redirect('/coca/backend/web/swagger-ui-3.9.3/dist/index.html');
        }
    }
     public function actionApi()
    {   
        $this->redirect('/swagger-ui-3.9.3/dist/index.html');
    }

    public function actionTest2()
    { \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $models = \common\models\User::find()->all();
        \moonland\phpexcel\Excel::export([
            'models' => $models,
            'columns' => [
                'created_at:datetime',
                [
                    'attribute' => 'email',
                    'format' => 'text',
                 ], 
            ],
            'headers' => [
                'updated_at' =>'updated_at',
                'email'=>'email',
            ]
        ]);
    }
}
