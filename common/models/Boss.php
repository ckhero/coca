<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_boss".
 *
 * @property int $id
 * @property int $hp 总血量
 * @property int $reduced 已经掉的血量
 * @property string $start 开始时间
 * @property string $end
 * @property string $created_at
 * @property string $updated_at
 */
class Boss extends \yii\db\ActiveRecord
{   
    public $start_time;
    public $end_time;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_boss';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hp', 'reduced'], 'integer'],
            [['hp', 'start', 'end'], 'required'],
            [['start'], 'datetime', 'format'=> 'php:Y-m-d H:i:s', 'timestampAttribute'=> 'start_time'],
            [['end'], 'datetime', 'format'=> 'php:Y-m-d H:i:s', 'timestampAttribute'=> 'end_time'],
            ['start', 'compare', 'compareAttribute' => 'end', 'operator' => '<', 'enableClientValidation' => false],
            ['hp', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['start', 'end', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hp' => 'Hp',
            'reduced' => 'Reduced',
            'start' => 'Start',
            'end' => 'End',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['created_at'], $fields['updated_at']);
        if (Yii::$app->id =='app-backend') {
            unset($fields['reduced']);
        }
        return $fields;
    }
    
    /**
     * [findCurrentBoss 找到正在进行的没有死的boss]
     * #Author ckhero
     * #DateTime 2018-02-11
     * @return [type] [null 或者 object]
     */
    public static function findCurrentBoss()
    {
        return static::find()->where(['<=', 'start', date('Y-m-d H:i:s')])
                             ->andWhere(['>', 'end', date('Y-m-d H:i:s')])
                             ->andWhere('hp > reduced')
                             ->forUpdate()
                             ->one();
    }
}
