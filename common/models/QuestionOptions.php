<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_question_options".
 *
 * @property int $id
 * @property int $q_id 问题编号
 * @property string $short_name 选项简称A-Z
 * @property string $desc
 * @property string $created_at
 * @property string $updated_at
 */
class QuestionOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_question_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['q_id'], 'integer'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'q_id' => 'Q ID',
            'short_name' => 'Short Name',
            'desc' => 'Desc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    } 

    public function fields()
    {
        return [
            'id',
            'q_id',
            'short_name',
            'desc',
            // 'updated_at',
            // 'created_at',
        ];
    }
}
