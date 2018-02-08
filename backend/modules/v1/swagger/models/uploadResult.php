<?php

/**
 * @SWG\Definition( type="object", @SWG\Xml(name="uploadResult"))
 */
class uploadResult
{

    

    /**
     * @SWG\Property(description="文件", example="jpg")
     * @var file
     */
    private $type;

    /**
     * @SWG\Property(description="文件名字", example="46b0ba04-ca6c-12e4-b90d-803aaeef5e39.mp4")
     * @var file
     */
    private $name;

    /**
     * @SWG\Property(description="文件访问路径，数据库中保存此地址", example="uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.mp4")
     * @var file
     */
    private $path;

}
