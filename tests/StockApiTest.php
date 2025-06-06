<?php

namespace Zyan\Tests;

use PHPUnit\Framework\TestCase;
use Zyan\StockApi\Channels\Xueqiu\XueqiuList;
use Zyan\StockApi\StockApi;

/**
 * Class StockApiTest.
 *
 * @package Zyan\Tests
 *
 * @author 读心印 <aa24615@qq.com>
 */
class StockApiTest extends TestCase
{
    public function test_config()
    {
        StockApi::setConfig(['a'=>11]);

        $this->assertEquals(StockApi::getConfig('a'),11);
    }

    
}

