<?php

/**
 * @SWG\Definition(required={"q_id", "short_name", "desc"}, type="object", @SWG\Xml(name="QuestionOptions"))
 */
class QuestionOptions
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
}
