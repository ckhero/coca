<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="battleResponse"))
 */
class battleResponse
{


    /**
     * pet status in the store
     * @SWG\Property(description="battle_id,对战编号", example="1")
     * @var string
     */
    private $id;

    /**
     * pet status in the store
     * @SWG\Property(description="题目列表", example="100")
     * @var Questions[]
     */
    private $questions;

    /**
     * pet status in the store
     * @SWG\Property(description="用户信息")
     * @var user
     */
    private $user;

}
