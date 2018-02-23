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
    const STATUS_LOSE = 0;
    const STATUS_WIN = 1;
    const STATUS_DOGFALL = 2;
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
        $battleModel = static::find()->where(['uid'=> Yii::$app->user->id, 'opposite_uid'=> $oppositeUid])->andWhere(['>', 'created_at', date('Y-m-d H:i:s', time() - 3600)])->one();
        if (is_null($battleModel)) {

            $battleModel = new static();
            $battleModel->uid = Yii::$app->user->id;
            $battleModel->opposite_uid = $oppositeUid;
            $battleModel->save();
        }
        return $battleModel;
    }
}
