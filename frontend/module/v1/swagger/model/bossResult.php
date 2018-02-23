<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="bossResult"))
 */
class bossResult
{

    /**
     * @SWG\Property(description="答题情况，状态码的值  0为答错题目，1为题目答对，2为boss战还未开始，3为当回答正确，答完该题后boss死亡", enum={"0","1","2","3"}, example="0")
     * @var int
     */
    private $code;

    /**
     * pet status in the store
     * @SWG\Property(description="状态码描述", example="全部答错")
     * @var string
     */
    private $message;

    /**
     * pet status in the store
     * @SWG\Property(description="答题总数", example="100")
     * @var interger
     */
    private $total;

    /**
     * pet status in the store
     * @SWG\Property(description="答对的题目数", example="99")
     * @var interger
     */
    private $right_num;
    /**
     * @SWG\Property(description="小关卡问题列表（添加更新只要传id就行）")
     * @var Questions
     */
    private $nextQuestion;

}
