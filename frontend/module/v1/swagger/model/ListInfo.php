<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ListInfo"))
 */
class ListInfo
{

    /**
     * @SWG\Property(description="总个数", example="52")
     * @var int
     */
    private $totalCount;

    /**
     * @SWG\Property(description="总页数", example="3")
     * @var int
     */
    private $pageCount;

    /**
     * @SWG\Property(description="当前是第几页", example="1")
     * @var int
     */
    private $currentPage;

    /**
     * @SWG\Property(description="每页多少个", example="20")
     * @var int
     */
    private $perPage;

}
