<?php

/**
 * @SWG\Definition(required={"desc", "right_option"}, type="object", @SWG\Xml(name="Questions"))
 */
class Questions
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
}
