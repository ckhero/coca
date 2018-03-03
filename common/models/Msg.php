<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_msg".
 *
 * @property int $id
 * @property int $uid
 * @property int $type
 * @property int $battle_id
 * @property string $detail
 * @property int $status 是否已读，0未读
 * @property string $created_at
 * @property string $updated_at
 */
class Msg extends \yii\db\ActiveRecord
{
    const TYPE_CHAPTER = 1; //关卡
    const TYPE_WORLD = 2; //世界boss
    const TYPE_DAY = 3;//每日任务
    const TYPE_XIAOXIAOLE = 4;//小游戏
    const TYPE_BATTLE = 5;//对战

    const STATUS_BATTLE = 1;//需要战斗
    const STATUS_INBATTLE = 0; //不需要战斗

    const STATUS_READ = 0;//奖励未接发放
    const STATUS_UNREAD= 1;//奖励未接发放
    static $activityNames = [
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
        return 'co_msg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'type', 'battle_id', 'status','is_battle'], 'integer'],
            [['detail'], 'string'],
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
            'type' => 'Type',
            'battle_id' => 'Battle ID',
            'detail' => 'Detail',
            'status' => 'Status',
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

    public static function addMsg($data = []) {
        $model = new static();
        $model->uid = $data['uid']?? '';
        $model->battle_id = $data['battle_id']?? 0;
        $model->type = $data['type']?? 0;
        $model->detail = $data['detail']?? '';
        $model->is_battle = $data['is_battle']?? static::STATUS_INBATTLE;
        $model->save();
        Yii::$app->cache->set('NewMsg:'.$data['uid'], 1, 3600 * 24 * 30); //标记用户有新的消息
    }
    /**
     * [getBattleStatus 对战状态]
     * @Author   ckhero
     * @DateTime 2018-03-03
     * @return   [type]     [description]
     */
    public function getBattleStatus()
    {
        return 1;
    }
    public function setBattleStatus($value)
    {
        $this->battleStatus = $value;
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['battleStatus']);
    }
}

// （1）邀请对战：  <用户A>在<时间 xxxx–xx-xx xx：xx：xx>向你发起1v1挑战，快来对战吧~
// （2）对战失效：抱歉，您的好友<用户B>超过24小时未响应你的挑战，该挑战已失效。
// （3）对战结果（给用户A）:  你在<时间 xxxx–xx-xx xx：xx：xx>向<用户B>发起的1v1对战赛中，<赢得了胜利 |  失败了，再接再厉哦>。
// （4）对战结果（给用户B）:  你在 <用户A><时间 xxxx–xx-xx xx：xx：xx>发起的1v1对战赛中，<赢得了胜利 |  失败了，再接再厉哦>。
// （5）平局（给用户A）：你在<时间 xxxx–xx-xx xx：xx：xx>向<用户B>发起的1v1对战赛中，和对方旗鼓相当，不分上下~
// （6）平局（给用户B）：你在 <用户A><时间 xxxx–xx-xx xx：xx：xx>发起的1v1对战赛中，和对方旗鼓相当，不分上下~
