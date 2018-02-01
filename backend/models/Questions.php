<?php

namespace backend\models;

use Yii;
/**
 * @SWG\Definition(required={"desc", "right_option"}, type="object", @SWG\Xml(name="Questions"))
 */
class Questions extends \yii\db\ActiveRecord
{   
    /**
     * @SWG\Property(description="题目id")
     * @var int
     */
    private $id;
     /**
     * @SWG\Property(description="题目内容")
     * @var string
     */
    private $desc;

    /**
     * pet status in the store
     * @SWG\Property( enum={"A", "B", "C", "..."},description="题目正确选项")
     * @var string
     */
    private $right_option;

    /**
     * @var QuestionOptions[]
     * @SWG\Property(@SWG\Xml())
     */
    private $questionOptions;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_questions';
    }

    public function rules()
    {
        return [
            [['desc', 'right_option'], 'required'],
            [['desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['right_option'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => '题目',
            'right_option' => '选项',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // public function setRightOption($value)
    // {
    //     $this->right_option = chr($this->right_option + 64);
    // }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            $this->right_option = chr($this->right_option + 64);
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

    public function getQuestionOptions()
    {
      
        return $this->hasMany(QuestionOptions::className(), ['q_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'desc',
            'questionOptions',
            'right_option',
            // 'updated_at',
            // 'created_at',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->questionOptions = Yii::$app->request->getBodyParam('questionOptions');
        file_put_contents('test.log', json_encode(Yii::$app->request->getBodyParam('questionOptions')));
    }
}
