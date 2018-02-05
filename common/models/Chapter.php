<?php

namespace common\models;

use Yii;

class Chapter extends \yii\db\ActiveRecord
{   
    const DONE = 'done';
    const DOING = 'doing';
    const UNDO = 'undo';
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
        if (Yii::$app->controller->action->id === 'view' && Yii::$app->id =='app-frontend') {

            return [
                'id',
                'map_id',
                'name',
                'desc',
                'bg_url',
                'sort',
                'guide',
                'chapterChilds',
                // 'status',
            ];
        } else {

            return [
                'id',
                'map_id',
                'name',
                'desc',
                'bg_url',
                'sort',
                'guide',
                // 'childs',
                'status',
            ];
        }
        
    }
    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function getChapterChilds()
    {
        return $this->hasMany(ChapterChild::className(), ['chapter_id'=> 'id']);
    }

    public function getMap()
    {
        return $this->hasOne(Map::className(), ['id'=> 'map_id']);
    }
    // public function setGuide($value)
    // {
    //     $this->guide = 222;
    // }
    // 
    
    public static function total()
    {
        return Yii::$app->cache->getOrSet('Chapter_total', function () {
            $query = new static();
            return $query->find()->innerJoinWith('childs')->innerJoinWith('map')->count();
        }, 300);
        
    }

    /**
     * [getStatus 关卡进行状态]
     * #Author ckhero
     * #DateTime 2018-02-05
     * @return [type] [description]
     */
    public function getStatus()
    {
        //子关卡id
        $childsId = array_column($this->childs, 'id');

        //已完成关卡id
        $clearanceChapterChild = ChapterChild::getDoneClearanceByUid(Yii::$app->user->id);
        $diff = array_diff($childsId, array_column(array_column($clearanceChapterChild, 'clearanceChapterChild'), 'chapter_child_id'));
        if (!empty($childsId) && empty($diff)) {
            return self::DONE;
        } else if (!empty($childsId) && count($diff) < count($childsId)){
            return self::DOING;
        }
        return self::UNDO;
    }
}
