<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="responseQuestion"))
 */
class responseQuestion
{

    /**
     * @SWG\Property(description="答题情况，0为验证失败，1闯关成功", enum={"0","1","2"}, example="0")
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
     * @SWG\Property(description="奖励列表")
     * @var reward
     */
    private $reward;

}
