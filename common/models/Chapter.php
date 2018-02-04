<?php

namespace common\models;

use Yii;

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
            [['map_id', 'sort'], 'integer'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['bg_url'], 'string', 'max' => 255],
            [['guide'], 'safe'],
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
            'sort' => 'Sort',
            'guide' => 'Guide',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'map_id',
            'name',
            'desc',
            'bg_url',
            'sort',
            'guide',
            // 'childs' => function ($model) {
            //     return 
            // }
        ];
    }
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
    }
    // public function setGuide($value)
    // {
    //     $this->guide = 222;
    // }
}
