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
            // [['guide'], 'safe'],
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
            // 'guide' => 'Guide',
            // 'guide_bg_url' => 'guide_bg_url',
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
                // 'guide',
                // 'guide_bg_url',
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
                // 'guide',
                // 'guide_bg_url',
                'chapterChilds',
                // 'childs',
                'status',
            ];
        }
        
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
    
    /**
     * [total 获取总的关卡数]
     * #Author ckhero
     * #DateTime 2018-02-26
     * @return [type] [description]
     */
    public static function total()
    {
        return Yii::$app->cache->getOrSet('BigChapterTotal', function () {
            $query = new static();
            return $query->find()->innerJoinWith('map')->count();
        }, 300); 
    }

    /**
     * [total 获取总的关卡数]
     * #Author ckhero
     * #DateTime 2018-02-26
     * @return [type] [description]
     */
    public static function totalDone()
    {
        return Yii::$app->cache->getOrSet('BigChapterTotal', function () {
            $query = new static();
            return $query->find()->innerJoinWith('map')->count();
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
        $childsId = array_column($this->chapterChilds, 'id');
        //已完成关卡id
        $clearanceChapterChild = ChapterChild::getDoneClearanceByUid(Yii::$app->user->id, $this->id);
        $diff = array_diff($childsId, array_column(array_column($clearanceChapterChild, 'clearanceChapterChild'), 'chapter_child_id'));
        if ((!empty($childsId) && empty($diff)) || ($this->id == 1 && count($diff) <= 1)) { //全部通关 或者是第一大关 有个过了
            return self::DONE;
        } else if (!empty($childsId) && count($diff) < count($childsId)){
            return self::DOING;
        }
        return self::UNDO;
    }
}
