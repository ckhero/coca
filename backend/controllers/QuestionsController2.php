<?php

namespace backend\controllers;

use Yii;
use common\models\Questions;
use yii\data\ActiveDataProvider;
use common\models\search\QuestionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\base\BaseController;


/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'create' => ['POST'],
                    // 'update' => ['PUT'],
                ],
            ],
        ]);   
    }

    /**
     * Lists all Questions models.
     * @return mixed
     */
    public function actionIndex()
    {
         return new ActiveDataProvider(
            [
                'query'=> Questions::find()->asArray(),
                'pagination' => [
                    'pageSize'=> 5,
                ],
            ]
        );
    }

    /**
     * Displays a single Questions model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Questions();
        $model->load(\Yii::$app->request->post());
        $code = 0;
        if ($model->validate() && $model->save()) {
            $code = 1;
            $message = '添加成功';
        } else {
            $message = current($model->errors)[0]?? '添加失败';
        }

        return $this->jsonReturn(compact('code', 'message'));
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->load(\Yii::$app->request->post());

        $code = 0;
        if ($model->validate() && $model->save()) {
            $code = 1;
            $message = '更新成功';
        } else {
            $message = current($model->errors)[0]?? '更新失败';
        }
        
        return $this->jsonReturn(compact('code', 'message'));
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $model = Questions::findOne(Yii::$app->request->post('id'));
        if ($model !== null && $model->delete()) {
            $code = 1;
            $message = '删除成功';
        } else {
            $code = 0;
            $message = '删除失败(有可能是数据为空)';
        }
        
        return $this->jsonReturn(compact('code', 'message'));
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
