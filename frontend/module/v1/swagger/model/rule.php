
<?php

/**
 * @SWG\Definition(required={"score", "name"}, type="object", @SWG\Xml(name="rule"))
 */
class rule
{

     /**
     * @SWG\Property(description="url")
     * @var string
     */
    private $content;

    /**
     * @SWG\Property(description="状态  1为可用 0 为不可用", example="1")
     * @var int
     */
    private $status;


}
