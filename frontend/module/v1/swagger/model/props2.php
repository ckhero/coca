<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="props2"))
 */
class props2
{

    /**
     * @SWG\Property(description="【碎片/道具】的编号", example="1")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="名字", example="道具/碎片")
     * @var string
     */
    private $name;

    

    /**
     * @SWG\Property(description="【碎片/道具】的图片地址", example="http://fdasfadf.com/1.jpg")
     * @var int
     */
    private $img_url;


    /**
     * @SWG\Property(description="【碎片/道具】的拥有的数量", example="1")
     * @var int
     */
    private $num;


    /**
     * @SWG\Property(description="拥有的属于该道具的碎片", example="1")
     * @var piece[]
     */
    private $pieces;


}