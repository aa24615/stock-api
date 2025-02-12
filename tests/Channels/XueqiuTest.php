<?php

namespace Zyan\Tests\Channels;

use PHPUnit\Framework\TestCase;
use Zyan\StockApi\Channels\Xueqiu\Xueqiu;
use Zyan\StockApi\Channels\Xueqiu\XueqiuList;

/***
 * Class XueqiuTest.
 *
 * @package Zyan\Tests\Channels
 *
 * @author 读心印 <aa24615@qq.com>
 */
class XueqiuTest extends TestCase
{

    /**
     * 基接口.
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function test_list()
    {
        $xueqiu = new Xueqiu();
        $data = $xueqiu->list('CN', 'sza');
        $this->assertEquals($data['error_code'], 0);
        $this->assertIsArray($data['data']);
    }

    /**
     * 深市A股.
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function test_sza()
    {
        $xueqiu = new XueqiuList();
        $data = $xueqiu->getSzListAllToA();
        $this->assertEquals($data['raw_count'], $data['count']);
        $this->assertEquals(count($data['list']), $data['count']);
    }

    /**
     * 深市B股.
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function test_szb()
    {
        $xueqiu = new XueqiuList();
        $data = $xueqiu->getSzListAllToB();
        $this->assertEquals($data['raw_count'], $data['count']);
        $this->assertEquals(count($data['list']), $data['count']);
    }

    /**
     * 沪市A股.
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function test_sha()
    {
        $xueqiu = new XueqiuList();
        $data = $xueqiu->getShListAllToA();
        $this->assertEquals($data['raw_count'], $data['count']);
        $this->assertEquals(count($data['list']), $data['count']);
    }

    /**
     * 沪市B股.
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function test_shb()
    {
        $xueqiu = new XueqiuList();
        $data = $xueqiu->getShListAllToB();
        $this->assertEquals($data['raw_count'], $data['count']);
        $this->assertEquals(count($data['list']), $data['count']);
    }

    /**
     * 港股.
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function test_hk()
    {
        $xueqiu = new XueqiuList();
        $data = $xueqiu->getHkListAll();
        $this->assertEquals($data['raw_count'], $data['count']);
        $this->assertEquals(count($data['list']), $data['count']);
    }

    /**
     * 美股.
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function test_us()
    {
        $xueqiu = new XueqiuList();
        $data = $xueqiu->getUsListAll();
        $this->assertEquals($data['raw_count'], $data['count']);
        $this->assertEquals(count($data['list']), $data['count']);
    }

}