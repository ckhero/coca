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
     private $option;
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
            [['desc', 'right_option'], 'required'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['right_option'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => '题目',
            'right_option' => '选项',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // public function setRightOption($value)
    // {
    //     $this->right_option = chr($this->right_option + 64);
    // }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            $this->right_option = chr($this->right_option + 64);
            if ($insert) {

                $this->created_at = date('Y-m-d H:i:s');
                $this->updated_at = date('Y-m-d H:i:s');
                
            } else {

                $this->updated_at = date('Y-m-d H:i:s');
            }

            return true;
        }

        return false;
    }

    public function getQuestionOptions()
    {
        return $this->hasMany(QuestionOptions::className(), ['q_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'desc',
            'options'=> function($model) {
                return $model->questionOptions;
            },
            'right_option',
            // 'updated_at',
            // 'created_at',
        ];
    }
}
