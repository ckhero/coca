<?php

namespace backend\models;

use Yii;

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

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
           
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

    public static function addOptions($options = [], $qId = null)
    {
        foreach($options as $key=> $val) {
            $insertData[] = [
                'q_id'=> $qId,
                'short_name'=> $val['short_name'],
                'desc'=> $val['desc']
            ];
        }

        Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['q_id', 'short_name', 'desc'], $insertData)->execute(); 
    }
}
