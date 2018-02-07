<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="props"))
 */
class props
{

    /**
     * @SWG\Property(description="id 后面使用道具的时候用到这个id", example="1")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="用户的id", example="1")
     * @var int
     */
    private $uid;

    /**
     * @SWG\Property(description="【碎片/道具】的编号", example="1")
     * @var int
     */
    private $prop_id;

    /**
     * @SWG\Property(description="【碎片/道具】的名字", example="碎片一")
     * @var int
     */
    private $prop_name;

    /**
     * @SWG\Property(description="类型为碎片的时候找个代表碎片所属道具的编号", example="1")
     * @var int
     */
    private $parent_prop_id;

    /**
     * @SWG\Property(description="表明是碎片或者道具", example="1")
     * @var string
     */
    private $type;

    /**
     * @SWG\Property(description="1代表未被使用；0代表已被使用", example="1", enum={0, 1})
     * @var string
     */
    private $status;

}
