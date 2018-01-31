<?php

namespace common\base;

class BaseController extends \yii\web\Controller
{

	public function jsonReturn($data = [])
	{
		return \Yii::createObject([
                'class' => 'yii\web\Response',
                'format' => \yii\web\Response::FORMAT_JSON,
                'data' => $data
            ]);
	}
}
