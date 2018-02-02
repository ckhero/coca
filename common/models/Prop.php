<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_prop".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property int $sort 碎片编号
 * @property string $img_url 图片地址
 * @property int $pid 0表示道具，大于0 表示道具碎片
 * @property string $created_at
 */
class Prop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_prop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['sort', 'pid'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['img_url'], 'string', 'max' => 255],
        ];
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
            'img_url' => 'Img Url',
            'pid' => 'Pid',
            'created_at' => 'Created At',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'desc',
            'sort',
            'pid',
            'pieces',
        ];
    }

    //获取道具的碎片
    public function getPieces() 
    {   
        // return $this->pid == 0? static::find()->where(['pid'=> $this->id])->orderBy('sort')->all(): [];
        return $this->hasMany(Prop::className(), ['pid' => 'id']);
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
        if ($pieces = Yii::$app->request->getBodyParam('pieces')) {

            $this->addPieces($pieces);
        }
        
    }

    public function addPieces($pieces = []) 
    {
        static::deleteAll(['pid'=> $this->id]);
        foreach($pieces as $piece) {
            $insertData[] = [
                'name'=> $piece['name'],
                'desc'=> $piece['desc'],
                'sort'=> $piece['sort'],
                'img_url'=> $piece['img_url'],
                'pid'=> $this->id,
            ];
        }
        Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['name', 'desc', 'sort', 'img_url', 'pid'], $insertData)->execute(); 
    }

    public static function randomPieces($num = 5)
    {
        $pieces = static::allPieces();
        $total = count($pieces) - 1;
        for ($i =0; $i < $num; $i++) {
            $piecesList[] = $pieces[mt_rand(0, $total)];
        }
        return $piecesList;
    }

    public static function allPieces()
    {
        $query = (new \yii\db\Query())->from(static::tableName());
        $query->select('b.*');
        $query->join('INNER JOIN', static::tableName().' as b', 'b.pid = '.static::tableName().'.id');

        return $query->all();
    }
}
