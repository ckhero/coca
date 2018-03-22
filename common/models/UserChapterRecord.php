<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_user_chapter_record".
 *
 * @property int $id
 * @property int $uid 用户id
 * @property int $activity_id 属于哪种活动
 * @property int $chapter_child_id 关卡id
 * @property int $total 总答题数
 * @property int $right_num 答对的题目数
 * @property string $created_at
 * @property string $updated_at
 */
class UserChapterRecord extends \yii\db\ActiveRecord
{
    const TYPE_CHAPTER = 1; //关卡
    const TYPE_WORLD = 2; //世界boss
    const TYPE_DAY = 3;//每日任务
    const TYPE_XIAOXIAOLE = 4;//小游戏
    const TYPE_BATTLE = 5;//小游戏

    const STATUS_UNISSUED = 0;//奖励未接发放
    const STATUS_ISSUED = 1;//奖励未接发放
    static $activityNames = [
        '1'=> '关卡',
        '2'=> '世界boss',
        '3'=> '每日任务',
        '4'=> '消消乐',
        '5'=> '对战',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_user_chapter_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'activity_id', 'chapter_child_id', 'total', 'right_num', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'chapter_child_id' => 'Chapter Child ID',
            'total' => 'Total',
            'right_num' => 'Right Num',
            'status' => 'Right Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    public function getCahpterChilds()
    {
        return $this->hasMany(ChapterChild::className(), ['id'=> 'chapter_child_id']);
    }
    /**
     * [getDoneClearance 获取完成的关卡]
     * #Author ckhero
     * #DateTime 2018-02-05
     * @return [type] [description]
     */
    public static function getDoneClearanceByUid($uid = 0)
    {
        $allClearance = static::findAllClearance($uid);
        return $allClearance;
    }

    public static function findAllClearance($uid = 0)
    {
        return static::find()->where(['uid'=> $uid, 'activity_id'=> self::TYPE_CHAPTER])->innerJoinWith('cahpterChilds')->all();
    }

    public static function addRecord($data, $activityId = self::TYPE_CHAPTER)
    {
        $model = new static();
        $model->uid = Yii::$app->user->id;
        $model->activity_id = $activityId;
        $model->chapter_child_id = $data['chapter_child_id']?? 0;
        $model->chapter_child_name = $activityId == self::TYPE_CHAPTER? ChapterChild::getNameById($model->chapter_child_id): ($data['chapter_child_name']?? 0);
        $model->activity_name = $activityId == self::TYPE_CHAPTER? ChapterChild::getNameById($model->chapter_child_id): self::$activityNames[$activityId];
        $model->total = $data['total']?? 0;
        $model->right_num = $data['rightOptionNum']?? 0;
        $model->point = $data['point']?? 0;
        $model->exp = $data['exp']?? 0;
        $model->props = $data['props']?? null;
        $model->status = $data['status']?? 1;
        $model->cost_time = $data['cost_time']?? 0;
        $model->save();
        return $model;
    }

    /**
     * [isDayMissionDone 判断没人任务是否完成]
     * #Author ckhero
     * #DateTime 2018-02-06
     * @return boolean [true 为已完成 false为未完成]
     */
    public static function isDayMissionDone($uid)
    {
        //$uid = Yii::$app->user->id;
        if ($uid > 0) {
            $record = static::find()
                            ->where([
                                'uid'=> $uid, 
                                'activity_id'=> self::TYPE_DAY
                            ])
                            ->andWhere(['date(created_at)'=> date('Y-m-d')])
                            ->one();
            return !is_null($record);
        } else {
            throw new yii\web\UnauthorizedHttpException;
        }
    }

     /**
     * [isFirstClearance 判断是否是第一次通关]
     * @Author   ckhero
     * @DateTime 2018-02-06
     * @param    integer    $id [description]
     * @return   boolean        [description]
     */
    public static function isFirstClearance($id = 0) 
    {
        if (Yii::$app->user->id > 0) {

            $record = static::find()->where([
                'activity_id'=> self::TYPE_CHAPTER,
                'uid'=> Yii::$app->user->id,
                'chapter_child_id'=> $id,
            ])->one();
            return is_null($record);
        }
        throw new \yii\web\NotFoundHttpException();
    }

    /**
     * [updateOrCreateBossRecord 更新用户世界boss的答题状态]
     * #Author ckhero
     * #DateTime 2018-02-23
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public static function updateOrCreateBossRecord ($data = []) 
    {   
        $model = static::findOne(['uid'=> Yii::$app->user->id, 'chapter_child_id'=> $data['id'], 'activity_id'=> static::TYPE_WORLD]);
        if (is_null($model)) {
            $model = static::addRecord(['chapter_child_id'=> $data['id'], 'total'=> 1, 'rightOptionNum'=> $data['right_num'], 'status'=> static::STATUS_UNISSUED], static::TYPE_WORLD);
            Yii::$app->cache->set('Boss_'.Yii::$app->user->id, ['record_id'=> $model->id, 'boss_id'=> $data['id']]);
            return $model;
        }
        $model->updateCounters(['total'=> 1, 'right_num'=> $data['right_num']]);
        return $model;
    }
}
