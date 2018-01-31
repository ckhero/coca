<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_questions".
 *
 * @property int $id
 * @property string $desc 问题描述
 * @property string $option 正确答案选项
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc'], 'required'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['option'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => 'Desc',
            'option' => 'Option',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
