<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_game_log".
 *
 * @property int $id 详细的答题记录，每一题对错等等
 * @property string $uid
 * @property int $activity_id
 * @property string $activity_name
 * @property int $chapter_child_id
 * @property string $detail
 * @property string $created_at
 */
class GameLog extends \yii\db\ActiveRecord
{
    const TYPE_CHAPTER = 1; //关卡
    const TYPE_WORLD = 2; //世界boss
    const TYPE_DAY = 3;//每日任务
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_game_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'activity_id', 'chapter_child_id'], 'integer'],
            [['detail'], 'string'],
            [['created_at'], 'safe'],
            [['activity_name'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'activity_id' => 'Activity ID',
            'activity_name' => 'Activity Name',
            'chapter_child_id' => 'Chapter Child ID',
            'detail' => 'Detail',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {

            // $this->right_option = chr($this->right_option + 64);
            if ($insert) {

                $this->created_at = date('Y-m-d H:i:s');   
            }
            return true;
        }

        return false;
    }

    /**
     * [log 把每次答题的详细选项记录下来]
     * #Author ckhero
     * #DateTime 2018-02-06
     * @param  array  $data       [description]
     * @param  [type] $activityId [description]
     * @return [type]             [description]
     */
    public static function log($data = [], $activityId = self::TYPE_CHAPTER)
    {
        $model = new static();
        $model->activity_id = $activityId;
        $model->uid = Yii::$app->user->id;
        $model->chapter_child_id = $data['chapter_child_id']?? 0;
        $model->detail = $data['detail'];
        return $model->save();
    }
}
