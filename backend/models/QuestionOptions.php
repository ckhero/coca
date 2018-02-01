<?php

namespace backend\models;

use Yii;
/**
 * @SWG\Definition(required={"q_id", "short_name", "desc"}, type="object", @SWG\Xml(name="QuestionOptions"))
 */
class QuestionOptions extends \yii\db\ActiveRecord
{   
    /**
     * @SWG\Property(description="选项id")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="对应题目id")
     * @var int
     */
    private  $q_id;

    /**
     * @SWG\Property( enum={"A", "B", "C", "..."},description="选项名称")
     * @var string
     */
    private  $short_name;

    /**
     * pet status in the store
     * @SWG\Property(description="选项内容")
     * @var string
     */
    private  $desc;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_question_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['q_id'], 'integer'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'q_id' => 'Q ID',
            'short_name' => 'Short Name',
            'desc' => 'Desc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    } 
    public function fields()
    {
        return [
            'id',
            'q_id',
            'short_name',
            'desc',
            // 'updated_at',
            // 'created_at',
        ];
    }
}
