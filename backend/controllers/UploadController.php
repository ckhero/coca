<?php

namespace backend\controllers;

use Yii;
use common\models\UploadForm;
use yii\web\UploadedFile;

class UploadController extends \common\base\BaseWebController
{
	/**
     * @SWG\Post(path="/upload",
     *   tags={"文件管理"},
     *   summary="文件上传",
     *   description="文件上传,支持多图上传，支持jpg，png，gif，MP4等上传",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         description="文件",
     *         in="formData",
     *         name="files",
     *         required=true,
     *         type="file",
     *     ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(@SWG\Items(ref="#/definitions/uploadResult")),description="文件上传成功"),
     *   @SWG\Response(response=400,description="账号密码错误"),
     *   @SWG\Response(response=422,description="验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    public function actionIndex()
    {
    	$model = new UploadForm();
        $model->files = UploadedFile::getInstancesByName('files');

        if ($model->validate()) {
        	$response = \Yii::$app->getResponse();
	        $response->setStatusCode(200);
	        $response->format = \yii\web\Response::FORMAT_JSON;
	        return $model->upload();

        } else {
	        $response = \Yii::$app->getResponse();
	        $response->setStatusCode(422);
	        $response->format = \yii\web\Response::FORMAT_JSON;
	        return $model->errors;
        }
        
     //    return \Yii::createObject([
	    //     'class' => 'yii\web\Response',
	    //     'format' => \yii\web\Response::FORMAT_JSON,
	    //     'data' => [
	    //         'code' => 0,
	    //         'attachment' => $model->upload(),
	    //         //'url' => Yii::$app->params['domain'].$attachment,
	    //     ],
	    // ]);

       // return $this->render('upload', ['model' => $model]);
    }

}
