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
    public function test_stock_api()
    {
        $stockApi = new StockApi();

        $xueQiuApi = $stockApi->getXueQiuApi();


        $this->assertInstanceOf($xueQiuApi, XueqiuList::class);
    }
}