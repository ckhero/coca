<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="option"))
 */
class option
{

    /**
     * @SWG\Property(description="问题id", example="1")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="用户选项", example="A", enum={"A","B","C","D"})
     * @var string
     */
    private $option;

}
