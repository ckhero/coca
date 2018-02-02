<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_chapter".
 *
 * @property int $id
 * @property int $map_id 所属地图id
 * @property string $name 关卡名字
 * @property string $desc 关卡描述
 * @property string $bg_url
 * @property string $guide 课件j，用逗号隔开
 * @property string $created_at
 * @property string $updated_at
 */
class Chapter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_chapter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['map_id'], 'integer'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['bg_url', 'guide'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'map_id' => 'Map ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'bg_url' => 'Bg Url',
            'guide' => 'Guide',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
