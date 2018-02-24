<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_map".
 *
 * @property int $id
 * @property string $name 地图名字
 * @property string $desc
 * @property int $sort 地图排序
 * @property string $bg_url
 * @property string $created_at
 * @property string $updated_at
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['bg_url'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    public function getChapters()
    {
        return $this->hasMany(Chapter::className(), ['map_id'=> 'id'])
                    ->orderBy(Chapter::tableName().'.sort');
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'sort' => 'Sort',
            'bg_url' => 'Bg Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'desc',
            'bg_url',
            'sort',
            'chapters'
        ];
    }

    public function extraFields()
    {
        return [
            'chapters',
        ];
    }

    /**
     * [eachMapChapters 每张地图拥有的关卡数]
     * #Author ckhero
     * #DateTime 2018-02-24
     * @return [type] [description]
     */
    public static function eachMapChapters()
    {
        return Yii::$app->cache->getOrSet('eachMapChapt2ers', function () {
            $model = new static();
            $data = $model->find()->innerJoinWith('chapters')->all();
            foreach($data as $key => $val) {
                $res[$val['id']] = 0;
                foreach ($val['chapters'] as $k => $v) {
                    $res[$val['id']] += count($v['chapterChilds']);
                } 
            }
            return $res;
        }, 1);
    }

    public static function currentMapId() {

        $mapHasChapters = Map::eachMapChapters();
        $done = ChapterChild::totalDone(Yii::$app->user->id);;
        $mapNum = count($mapHasChapters);
        $i = 0;

        $curr = 0;
        $prev = 0;
        $next = 0;
        foreach ($mapHasChapters as $key => $chpatersNum) {
            $i++;
            if ($i == $mapNum) return [$key];
            $done -= $chpatersNum;
            if ($done < 0) {
                return [$key];
            }
        } 
    }
}
