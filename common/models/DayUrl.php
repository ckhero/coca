<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "co_day_url".
 *
 * @property int $id
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class DayUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_day_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function allUrls()
    {
        return Yii::$app->cache->getOrSet('DayUrls', function () {

            return Yii::$app->db->createCommand('SELECT url FROM '.static::tableName())
                            ->queryColumn();
        }, 120);
    }
}
