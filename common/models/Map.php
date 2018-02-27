<?php

namespace common\models;

use Yii;
use Third\Steps;

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
    public $curr;
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
                    ->innerJoinWith('chapterChilds')
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
            'curr',
            'name',
            'desc',
            'bg_url',
            'sort',
            'chapters',
        ];
    }

    public function extraFields()
    {
        return [
            'chapters',
        ];
    }

    public function getCurr(){
        return 1;
    }
    public function getPrev(){}
    public function getNext(){}
    /**
     * [eachMapChapters 每张地图拥有的关卡数]
     * #Author ckhero
     * #DateTime 2018-02-24
     * @return [type] [description]
     */
    public static function eachMapChapters()
    {
        return Yii::$app->cache->getOrSet('eachMapChapters', function () {
            $data = Yii::$app->db->createCommand('SELECT `co_map`.id, count(1) as num FROM `co_map` INNER JOIN `co_chapter` ON `co_map`.`id` = `co_chapter`.`map_id` INNER JOIN `co_chapter_child` ON `co_chapter`.`id` = `co_chapter_child`.`chapter_id` group by co_map.id ORDER BY `co_map`.`id` ')
                                 ->queryAll();
            foreach ($data as $key => $val) {
                $res[$val['id']] = $val['num'];
            }
            return $res;
        }, 1);
    }

    public static function currentMapId() {

        $mapHasChapters = Map::eachMapChapters();
        $done = ChapterChild::totalDone(Yii::$app->user->id);;
        $mapNum = count($mapHasChapters);
        $i = 0;
        ksort($mapHasChapters);

       
        foreach ($mapHasChapters as $key => $chpatersNum) {
            $i++;
  

            if ($i == $mapNum) break;
            $done -= $chpatersNum;
            if ($done < 0) {
                break;
            }
        }
        $steps = new Steps(); 
        $steps->setAll($mapHasChapters);

        $steps->setCurrent($key);//参数为key值  
        $curr = $steps->getCurrent(); 
        $prev = $steps->getPrev()?? $curr; 
        $next = $steps->getNext()?? $curr; 
        return compact('curr', 'prev', 'next');
    }
}
