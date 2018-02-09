
<?php

/**
 * @SWG\Definition(required={"score", "name"}, type="object", @SWG\Xml(name="boss"))
 */
class boss
{

    /**
     * @SWG\Property(description="世界boss id")
     * @var int
     */
    private $id;
     /**
     * @SWG\Property(description="血量")
     * @var int
     */
    private $hp;

    /**
     * pet status in the store
     * @SWG\Property( description="开始时间",example="2018-02-09 11:41:27")
     * @var date
     */
    private $start;

    /**
     * pet status in the store
     * @SWG\Property( description="结束时间",example="2018-02-09 11:41:27")
     * @var date
     */
    private $end;
}
