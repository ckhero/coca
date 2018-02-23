<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_questions".
 *
 * @property int $id
 * @property string $desc 问题描述
 * @property string $right_option 正确答案选项
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
            'desc' => 'Desc',
            'right_option' => 'Right Option',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getChapterChildOptions()
    {
        return $this->hasOne(ChapterChildQuestion::className(), ['question_id'=> 'id']);
    }
    public static function verifyChapterOptions($chapterChildId = 0, $userOptions = []) 
    {
        $options = static::find()->innerJoinWith('chapterChildOptions')->where(['chapter_child_id'=> $chapterChildId])->all();
        return static::cTwoOptions($options, $userOptions);
    }

    /**
     * [cTwoOptions 对比正确选项得出 用户是答题情况]
     * #Author ckhero
     * #DateTime 2018-02-06
     * @param  array  $options     [description]
     * @param  array  $userOptions [description]
     * @return [type]              [description]
     */
    public static function cTwoOptions($options = [], $userOptions = [])
    {
        $optionNum = count($options);
        $userOptionNum = count($userOptions);
        if ($optionNum == 0) {
            return ['code'=> 0, 'message'=> '关卡没有设置选项'];
        }
        if ($userOptionNum == 0) {
            return ['code'=> 0, 'message'=> '玩家选项为空'];
        }
        $userOptionIds = array_column($userOptions, 'id');
        //对比答案
        $rightOptionNum = 0;
        foreach ($options as $option) 
        {
            $tmpKey = array_search($option['id'], $userOptionIds);
            if ($tmpKey !== false &&  strcasecmp($userOptions[$tmpKey]['option'], $option['right_option']) == 0) {
                $rightOptionNum += 1;
            }
        }
        if ($optionNum == $rightOptionNum) {
            return ['code'=> 1, 'message'=> '全部答对','total'=> $optionNum, 'rightOptionNum'=> $rightOptionNum];
        }else if ($rightOptionNum == 0) {
            return ['code'=> 0, 'message'=> '全部答错', 'total'=> $optionNum, 'rightOptionNum'=> $rightOptionNum];
        } else {
            return ['code'=> 2, 'message'=> '部分答对', 'total'=> $optionNum, 'rightOptionNum'=> $rightOptionNum, 'percent'=> round($rightOptionNum/$optionNum, 4)];
        }
        
    }

    public static function dayQuestions()
    {   
        $uid = Yii::$app->user->id;
        if ($uid > 0) {
            return Yii::$app->cache->getOrSet('UserDayQuestions:'.$uid, function () {

                $questions = static::randomQuestions();
                return $questions;
            });
        }
        throw new \yii\web\NotFoundHttpException();
        
    }

    public static function randomQuestions($num = 2)
    {
        $questions = static::allQuestions();
        $total = count($questions);
        if ($num > $total) {
            return $questions;
        }
        $keys = array_rand($questions, $num);
        if ($num == 1) {
            return $questions[$keys];
        }
        foreach ($keys as $key) {
            $questionList[] = $questions[$key];
        }
        return $questionList;
    }

    public static function allQuestions()
    {
        $model = new static();
        return $model->find()->innerJoinWith('questionOptions')->all();
    }

    public function getQuestionOptions()
    {
      
        return $this->hasMany(QuestionOptions::className(), ['q_id' => 'id'])->orderBy('short_name');
    }

    public function fields()
    {
        return [
            'id',
            'desc',
            'right_option',
            'questionOptions',
        ];
    }

    public static function getBossQuestion($type = null)
    {
        $cacheKey = "BOSS_QUESTION:".Yii::$app->user->id;
        if ($type == 'new') {
            $question = static::randomQuestions(1);
            Yii::$app->cache->set($cacheKey, $question, 3600);
            return $question;
        }
        return Yii::$app->cache->getOrSet($cacheKey, function () {
            return static::randomQuestions(1);
        }, 3600);
    }
}
