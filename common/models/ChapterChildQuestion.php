<?php

namespace common\models;

use Yii;
use backend\models\Questions;
/**
 * This is the model class for table "co_chapter_child_question".
 *
 * @property int $chapter_child_id
 * @property int $question_id
 */
class ChapterChildQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_chapter_child_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chapter_child_id'], 'required'],
            [['chapter_child_id', 'question_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'chapter_child_id' => 'Chapter Child ID',
            'question_id' => 'Question ID',
        ];
    }
    public function fields()
    {
        return [
            'chapter_child_id',
            'question_id',
            'question_info'
        ];
    }

    public function getQuestions()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id']);
    }
    public function getQuestion_info()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id'])->innerJoinWith('questionOptions');
    }
    public static function addItems($options = [], $qId = null)
    {
        foreach($options as $key=> $val) {
            $insertData[] = [
                'chapter_child_id'=> $qId,
                'question_id'=> $val['id'],
            ];
        }

        Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['chapter_child_id', 'question_id'], $insertData)->execute(); 
    }
}
