<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_level".
 *
 * @property int $id
 * @property int $score 分数
 * @property string $name 等级名字
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['score'], 'integer'],
            [['name'], 'string', 'max' => 16],
            ['score', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'score' => 'Score',
            'name' => 'Name',
        ];
    }

    /**
     * [getLevelByScore 根据经验值获取等级名称]
     * @Author   ckhero
     * @DateTime 2018-02-04
     * @param    integer    $score [description]
     * @return   [type]            [description]
     */
    public static function getLevelByScore($score = 0)
    {
        return \Yii::$app->cache->getOrSet('score_'.$score, function () use ($score) {

            $model = new static();
            $info = $model->find()
                      ->where(['<=', 'score', $score])
                      ->orderBy('score desc')
                      ->one();
            return $info->name?? '';
        }, 300);
        
    }
}
