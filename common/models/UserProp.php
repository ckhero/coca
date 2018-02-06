<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_user_prop".
 *
 * @property int $id
 * @property int $prop_id
 * @property int $type 0为碎片，1为道具
 * @property int $status 0为已使用，1为未使用
 * @property string $created_at
 * @property string $updated_at
 */
class UserProp extends \yii\db\ActiveRecord
{
    const PROP = 1;
    const PIECE = 0;
    const ACTIVE = 1;
    const USED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_user_prop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'prop_id', 'type', 'status'], 'integer'],
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
            'prop_id' => 'Prop ID',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function addProp($props = [], $type = self::PIECE)
    {
        foreach ($props as $prop) {
            $insertData[] = [
                'uid'=> Yii::$app->user->id,
                'prop_id'=> $prop['id'],
                'type'=> $type,
                'status'=> self::ACTIVE,
            ];
        }
        Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['uid', 'prop_id', 'type', 'status'], $insertData)->execute(); 
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
}
