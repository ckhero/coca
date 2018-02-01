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
}
