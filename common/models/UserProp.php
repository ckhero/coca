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
    const TYPE_PROP = 1;
    const TYPE_PIECE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function attributes ()
    {
        $attributes = parent::attributes();
        $attributes[] = 'num';
        return $attributes;
    }
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
            [['created_at', 'updated_at', 'parent_prop_id', 'num'], 'safe'],
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
            'num' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'parent_prop_id' => 'Updated At',
        ];
    }

    public static function addProp($props = [], $type = self::TYPE_PIECE)
    {
        if (count($props) == 1) {

            $model= new static();
            $model->uid = Yii::$app->user->id;
            $model->prop_id = $props[0]['id'];
            $model->type = $type;
            $model->status = self::STATUS_ACTIVE;
            $model->save();
            return $model;
        }
        foreach ($props as $prop) {
            $insertData[] = [
                'uid'=> Yii::$app->user->id,
                'prop_id'=> $prop['id'],
                'type'=> $type,
                'status'=> self::STATUS_ACTIVE,
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ];
        }
        Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['uid', 'prop_id', 'type', 'status', 'created_at', 'updated_at'], $insertData)->execute(); 
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

    public function fields(){

        $fields = parent::fields();
        unset($fields['created_at'], $fields['updated_at']);
        return array_merge($fields, [
                'num',
                'type'=> function ($model) {
                    return $model->type == self::TYPE_PIECE? '碎片': '道具';
                },
                'prop_name'=> function ($model) {
                    return $model->prop->name;
                },
                'parent_prop_id'=> function ($model) {
                    return $model->prop->pid;
                },
                'img_url'=> function ($model) {
                    return $model->prop->img_url;
                }
            ]);
    }

    public function getProp()
    {
        return $this->hasOne(Prop::className(), ['id'=> 'prop_id']);
    }

    public static function findUserPiecesByIds($pid = 0)
    {
        return static::find()->where(['uid'=> Yii::$app->user->id])
                             ->andWhere(['status'=> UserProp::STATUS_ACTIVE])
                             ->andWhere(['type'=> UserProp::TYPE_PIECE]) 
                             ->andWhere([Prop::tableName().'.pid'=>$pid])
                             ->innerJoinWith('prop')
                             ->groupBy('prop_id')
                             ->all();
    }


}
