<?php

/**
 * @SWG\Definition(required={"score", "name"}, type="object", @SWG\Xml(name="upload"))
 */
class upload
{

    /**
     * @SWG\Property(description="文件-图片-视频", example="文件")
     * @var file
     */
    private $files;

}
