<?php

namespace common\models;

use Yii;

class ChapterChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_chapter_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chapter_id', 'sort'], 'integer'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chapter_id' => 'Chapter ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'chapter_id',
            'name',
            'desc',
            'sort',
            'questions'
        ];
    }

    public function getQuestions()
    {
        return $this->hasMany(ChapterChildQuestion::className(), ['chapter_child_id' => 'id']);
    }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {

            // $this->right_option = chr($this->right_option + 64);
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($questions = Yii::$app->request->getBodyParam('questions')) {
            $questions = array_unset_tt($questions, 'id');
            ChapterChildQuestion::deleteAll(['chapter_child_id'=> $this->id]); //先删除
            ChapterChildQuestion::addItems($questions, $this->id); //全部重新添加
        }
    }
}
