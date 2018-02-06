<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="responseQuestion"))
 */
class responseQuestion
{

    /**
     * @SWG\Property(description="答题情况，0为验证失败，1为全部答对，2位部分答对", enum={"0","1","2"}, example="0")
     * @var int
     */
    private $code;

    /**
     * pet status in the store
     * @SWG\Property(description="状态码描述", example="全部答错")
     * @var string
     */
    private $message;

}
