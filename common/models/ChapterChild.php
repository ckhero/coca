<?php

namespace common\models;

use Yii;

class ChapterChild extends \yii\db\ActiveRecord
{
    const ACTIVITY_ID = 1;
    const TYPE_CHAPTER = 1; //关卡
    const TYPE_WORLD = 2; //世界boss
    const TYPE_DAY = 3;//每日任务
    const DONE = 'done';
    const DOING = 'doing';
    const UNDO = 'undo';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_chapter_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chapter_id', 'sort'], 'integer'],
            [['desc', 'guide', 'guide_bg_url'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chapter_id' => 'Chapter ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'sort' => 'Sort',
            'guide' => 'Guide',
            'guide_bg_url' => 'guide_bg_url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        if (Yii::$app->controller->action->id === 'view' && Yii::$app->id =='app-frontend') {
            if (Yii::$app->controller->id =='chapter-item') {

                return [
                    'id',
                    'chapter_id',
                    'name',
                    'desc',
                    'sort',
                    'guide',
                    'guide_bg_url',
                    'status',
                    'questions',
                ];

            } else {

                return [
                    'id',
                    'chapter_id',
                    'name',
                    'desc',
                    'sort',
                    'guide',
                    'guide_bg_url',
                    'status'
                ];
            }
        } else {
            return [
                'id',
                'chapter_id',
                'name',
                'desc',
                'sort',
                'guide',
                'guide_bg_url',
                'questions',
                'clearanceChapterChild'
            ];
        }
        
    }

    public function getQuestions()
    {
        return $this->hasMany(ChapterChildQuestion::className(), ['chapter_child_id' => 'id']);
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($questions = Yii::$app->request->getBodyParam('questions')) {
            $questions = array_unset_tt($questions, 'id');
            ChapterChildQuestion::deleteAll(['chapter_child_id'=> $this->id]); //先删除
            ChapterChildQuestion::addItems($questions, $this->id); //全部重新添加
        }
    }

    public function getParents()
    {
        return $this->hasOne(Chapter::className(), ['id'=> 'chapter_id'])->innerJoinWith('map');
    }

    public function getClearanceChapterChild()
    {
        return $this->hasOne(UserChapterRecord::className(), ['chapter_child_id'=> 'id']);
    }
    /**
     * [totalDone 获取用户已经完成的关卡数量]
     * #Author ckhero
     * #DateTime 2018-02-05
     * @param  integer $uid [description]
     * @return [type]       [description]
     */
    public static function totalDone($uid = 0)
    {
        return Yii::$app->cache->getOrSet('userTotalDone_'.$uid, function () use ($uid) {
            $query = new static();
            return $query->find()->innerJoinWith('parents')->innerJoinWith('clearanceChapterChild')->where(['uid'=> $uid, 'activity_id'=> static::TYPE_CHAPTER])->count();
        }, 300);
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
        return static::find()->where(['uid'=> $uid, 'activity_id'=> 1])->innerJoinWith('clearanceChapterChild')->all();
    }

    public function getStatus()
    {
        return $this->clearanceChapterChild == null? self::UNDO: self::DONE;
    }

    public static function getNameById($id = 0) 
    {
        return Yii::$app->cache->getOrSet('ChapterChildName:'.$id, function () use ($id){
            $model = static::findOne(['id'=> $id]);
            return $model->name?? null;
        }, 300);
    }
}
