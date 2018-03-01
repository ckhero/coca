<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_battle".
 *
 * @property int $id
 * @property int $uid 发起者id
 * @property int $record_id 发起者答题记录id
 * @property int $opposite_uid 被挑战者id
 * @property int $opposite_record_id 被挑战者记录id
 * @property int $status_accept 0为未应战，1为应战
 * @property int $status_win 0为输，1为胜利
 * @property string $created_at
 * @property string $updated_at
 */
class Battle extends \yii\db\ActiveRecord
{
    const STATUS_ACCEPT = 1;
    const STATUS_UNACCEPT = 0;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUS_LOSE = 0;
    const STATUS_WIN = 1;
    const STATUS_DOGFALL = 2;
    const STATUS_NULL = -1;

    const TIME_INACTIVE = 24 * 3600;
    static $result = [
        '失败了，再接再厉哦',
        '赢得了胜利',      
        '和对方旗鼓相当，不分上下~'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_battle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'record_id', 'opposite_uid', 'opposite_record_id', 'status_accept', 'status_win'], 'integer'],
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
            'record_id' => 'Record ID',
            'opposite_uid' => 'Opposite Uid',
            'opposite_record_id' => 'Opposite Record ID',
            'status_accept' => 'Status Accept',
            'status_win' => 'Status Win',
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

    public static function findOrCreateBattle($oppositeUid = 0)
    {
        $battleModel = static::find()->where(['uid'=> Yii::$app->user->id, 'opposite_uid'=> $oppositeUid, 'status_win'=> static::STATUS_NULL])->andWhere(['>', 'created_at', date('Y-m-d H:i:s', time() - static::TIME_INACTIVE)])->one();
        //$battleModel = static::find()->where(['uid'=> Yii::$app->user->id, 'opposite_uid'=> $oppositeUid])->andWhere('record_id = 0 or opposite_record_id =0')->one();
        if (is_null($battleModel)) {

            $battleModel = new static();
            $battleModel->uid = Yii::$app->user->id;
            $battleModel->opposite_uid = $oppositeUid;
            $battleModel->save();
        }
       // $battleModel->questions = 1;
        return $battleModel;
    }

    public function getQuestions($battle_id = 0)
    {
        return Yii::$app->cache->getOrSet('battle_'.$battle_id, function () {
            return Questions::randomQuestions(10);
        }, 3600 * 2);
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
                'questions' => function($model) {
                    return $model->getQuestions($model->id);
                },
                'user'
            ]);
    }

    /**
     * [isOppositeUser 判断当前用户是否是应战方]
     * #Author ckhero
     * #DateTime 2018-02-26
     * @param  [type]  $model [description]
     * @return boolean        [description]
     */
    public static function isOppositeUser($model) 
    {
        return !($model['uid'] == Yii::$app->user->id);
    }

    /**
     * [cBattle 得出战斗结果]
     * #Author ckhero
     * #DateTime 2018-02-26
     * @param  integer $recordId         [description]
     * @param  integer $oppositeRecordId [description]
     * @return [type]                    [description]
     */
    public static function cBattle($recordId = 0, $oppositeRecordId = 0)
    {
        $record = UserChapterRecord::findOne(['id'=> $recordId]);
        $oppositeRecord = UserChapterRecord::findOne(['id'=> $oppositeRecordId]);
        if ($record['right_num'] < $oppositeRecord['right_num']) {
            return static::STATUS_LOSE;
        } else if ($record['right_num'] > $oppositeRecord['right_num']) {
            return static::STATUS_WIN;
        }
        if ($oppositeRecord['cost_time'] < $record['cost_time']) {
            return static::STATUS_LOSE;
        } else if ($oppositeRecord['cost_time'] > $record['cost_time']) {
            return static::STATUS_WIN;
        }

        return static::STATUS_DOGFALL;
    }

    /**
     * [getUser 对手的信息]
     * #Author ckhero
     * #DateTime 2018-03-01
     * @return [type] [description]
     */
    public function getUser()
    {
        return false;
    }
    public function setUser($value)
    {
        $this->user = $value;
    }
}
