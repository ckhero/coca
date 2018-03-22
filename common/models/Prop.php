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
            [['img_url', 'redirect_url'], 'string', 'max' => 255],
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
        if (Yii::$app->controller->id == 'piece') {

          return [
                'id',
                'name',
                'desc',
                'sort',
                'pid',
                'img_url',
                'redirect_url',
            ];  
        }
        if (Yii::$app->controller->id == 'prop') {

          return [
                'id',
                'name',
                'desc',
                'sort',
                'pid',
                'img_url',
                'redirect_url',
                'pieces',
                'num',
            ];  
        }
        return [
            'id',
            'name',
            'desc',
            'sort',
            'pid',
            'pieces',
            'parentProp',
            'img_url',
            'redirect_url',
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

            if ($insert) {
                $this->addPieces($pieces);
            } else {
                $this->modifyPieces($pieces);
            }
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

    /**
     * [modifyPieces 更新道具信息 粗糙]
     * @Author   ckhero
     * @DateTime 2018-03-03
     * @param    array      $pieces [description]
     * @return   [type]             [description]
     */
    public function modifyPieces($pieces = []) 
    {
        //求出原来的   ??chu
        $oldPieceIds = array_column(static::find()->where(['pid'=> $this->id])->all(), 'id');
        $getPieceIds = array_column($pieces, 'id');
        $deleleIds = array_diff($oldPieceIds,$getPieceIds);
        foreach ($deleleIds as $key=> $val) {
            $deleteModel = static::findOne(['id'=> $val]);
            $deleteModel->delete();
        }
        foreach($pieces as $piece) {
            $model = static::findOne(['id'=> $piece['id']]);
            if (is_null($model)) {
                $insertData[] = [
                    'name'=> $piece['name'],
                    'desc'=> $piece['desc'],
                    'sort'=> $piece['sort'],
                    'img_url'=> $piece['img_url'],
                    'pid'=> $this->id,
                ];
            } else {
                $model->name = $piece['name'];
                $model->desc = $piece['desc'];
                $model->sort = $piece['sort'];
                $model->img_url = $piece['img_url'];
                $model->pid = $piece['pid'];
            }
            
        }
        if (!empty($insertData)) {
            Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['name', 'desc', 'sort', 'img_url', 'pid'], $insertData)->execute(); 
        }
    }

    public static function randomPieces($num = 1)
    {
        //$pieces = static::allPieces();
        $pieces = static::find()->where(['pid'=> 0])->all();
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
    /**
     * [findPropPiecesById 某个道具的碎片列表]
     * #Author ckhero
     * #DateTime 2018-02-07
     * @param  integer $pid [description]
     * @return [type]       [description]
     */
    public static function findPropPiecesById($pid = 0)
    {
        return static::find()->where(['pid'=> $pid])->all();
    }

    /**
     * [cTwoPieces 对比碎片或查看是否可以合成]
     * #Author ckhero
     * #DateTime 2018-02-07
     * @param  array  $pieces     [description]
     * @param  array  $userPieces [description]
     * @return [type]             [description]
     */
    public static function cTwoPieces($pieces = [], $userPieces = []) 
    {
        $ids = array_column($pieces, 'id');
        sort($ids);
        $userIds = array_column($userPieces, 'prop_id');
        sort($userIds);
        if (count($ids) != count($userIds) || empty($pieces)) {
            return ['code'=> 0, 'message'=>'fail'];
        }
        foreach ($ids as $key=> $id) {
            if ($id != $userIds[$key]) {
                return ['code'=> 0, 'message'=> 'fail'];
            }
        }
        return ['code'=> 1, 'message'=>'success']; 
    }

    public function getParentProp()
    {
        return $this->hasOne(static::className(), ['pid'=> 'id']);
    }

    public function getUserProps()
    {
        return $this->hasMany(UserProp::className(), ['prop_id'=> 'id'])
                    ->andWhere(['status'=> UserProp::STATUS_ACTIVE, 'uid'=> Yii::$app->user->id, 'type'=> UserProp::TYPE_PROP]);
    }

    //个数
    public function getNum(){}
    public function setNum($value){
        $this->num = $value;
    }
}
