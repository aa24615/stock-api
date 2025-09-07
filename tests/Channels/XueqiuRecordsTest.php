<?php

namespace Zyan\Tests\Channels;

use PHPUnit\Framework\TestCase;
use Zyan\StockApi\Channels\Xueqiu\XueqiuList;

/**
 * Class XueqiuRecordsTest.
 *
 * @package Zyan\Tests\Channels
 *
 * @author 读心印 <aa24615@qq.com>
 */
class XueqiuRecordsTest extends TestCase
{
    private $xueqiu;

    protected function setUp(): void
    {
        $this->xueqiu = new XueqiuList();
    }

    /**
     * 测试获取全部历史数据
     */
    public function testGetAllRecords()
    {
        $symbol = 'SZ000651'; // 格力电器
        $data = $this->xueqiu->getRecordsByDate($symbol);

        $this->assertIsArray($data);
        $this->assertGreaterThan(0, count($data));
        
        // 验证数据结构
        if (count($data) > 0) {
            $firstRecord = $data[0];
            $this->assertIsArray($firstRecord);

            // 验证时间字段（第一个字段应该是时间戳）
            $this->assertIsNumeric($firstRecord[0]);
            
            echo "获取到 " . count($data) . " 条历史数据\n";
            echo "最早数据时间: " . date('Y-m-d', $firstRecord[0] / 1000) . "\n";
            echo "最晚数据时间: " . date('Y-m-d', end($data)[0] / 1000) . "\n";
        }
    }

    /**
     * 测试获取指定年份的数据
     */
    public function testGetRecordsByYear()
    {
        $symbol = 'SZ000651';
        $year = '2023';
        $data = $this->xueqiu->getRecordsByDate($symbol, $year . '-01-01', $year . '-12-31');


        $this->assertIsArray($data);
        
        if (count($data) > 0) {
            $firstRecord = $data[0];
            $lastRecord = end($data);


            
            // 验证时间范围
            $firstDate = date('Y', $firstRecord[0] / 1000);
            $lastDate = date('Y', $lastRecord[0] / 1000);
            
            $this->assertEquals($year, $firstDate);
            $this->assertEquals($year, $lastDate);


            echo "获取到 {$year} 年 " . count($data) . " 条数据\n";
            echo "数据范围: " . date('Y-m-d', $firstRecord[0] / 1000) . " 到 " . date('Y-m-d', $lastRecord[0] / 1000) . "\n";
        }
    }

    /**
     * 测试获取指定月份的数据
     */
    public function testGetRecordsByMonth()
    {
        $symbol = 'SZ000651';
        $year = '2023';
        $month = '06';
        $data = $this->xueqiu->getRecordsByDate($symbol, $year . '-' . $month . '-01', $year . '-' . $month . '-30');

        $this->assertIsArray($data);
        
        if (count($data) > 0) {
            $firstRecord = $data[0];
            $lastRecord = end($data);
            
            // 验证月份
            $firstMonth = date('Y-m', $firstRecord[0] / 1000);
            $lastMonth = date('Y-m', $lastRecord[0] / 1000);
            
            $this->assertEquals($year . '-' . $month, $firstMonth);
            $this->assertEquals($year . '-' . $month, $lastMonth);
            
            echo "获取到 {$year} 年 {$month} 月 " . count($data) . " 条数据\n";
        }
    }

    /**
     * 测试获取从指定日期到现在的数据
     */
    public function testGetRecordsFromDate()
    {
        $symbol = 'SZ000651';
        $startDate = '2023-01-01';
        $data = $this->xueqiu->getRecordsByDate($symbol, $startDate);

        $this->assertIsArray($data);
        
        if (count($data) > 0) {
            $firstRecord = $data[0];
            $lastRecord = end($data);
            
            // 验证开始时间
            $firstDate = date('Y-m-d', $firstRecord[0] / 1000);
            $this->assertGreaterThanOrEqual($startDate, $firstDate);
            
            echo "从 {$startDate} 到现在获取到 " . count($data) . " 条数据\n";
            echo "数据范围: " . $firstDate . " 到 " . date('Y-m-d', $lastRecord[0] / 1000) . "\n";
        }
    }

    /**
     * 测试获取最近30天的数据
     */
    public function testGetRecentRecords()
    {
        $symbol = 'SZ000651';
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-30 days'));
        
        $data = $this->xueqiu->getRecordsByDate($symbol, $startDate, $endDate);

        $this->assertIsArray($data);
        
        if (count($data) > 0) {
            $firstRecord = $data[0];
            $lastRecord = end($data);
            
            echo "获取最近30天 " . count($data) . " 条数据\n";
            echo "数据范围: " . date('Y-m-d', $firstRecord[0] / 1000) . " 到 " . date('Y-m-d', $lastRecord[0] / 1000) . "\n";
            
            // 验证数据量合理（30天大约22个交易日）
            $this->assertLessThanOrEqual(30, count($data));
            $this->assertGreaterThan(10, count($data));
        }
    }

    /**
     * 测试不同股票代码
     */
    public function testDifferentSymbols()
    {
        $symbols = [
            'SZ000651', // 格力电器
            'SH600036', // 招商银行
            'SZ000001', // 平安银行
        ];

        foreach ($symbols as $symbol) {
            $data = $this->xueqiu->getRecordsByDate($symbol, '2023-01-01', '2023-01-31');
            
            $this->assertIsArray($data);
            echo "股票 {$symbol} 2023年1月数据: " . count($data) . " 条\n";
        }
    }



    /**
     * 性能测试
     */
    public function testPerformance()
    {
        $symbol = 'SZ000651';
        
        $startTime = microtime(true);
        $data = $this->xueqiu->getRecordsByDate($symbol, '2023-01-01', '2023-12-31');
        $endTime = microtime(true);
        
        $executionTime = $endTime - $startTime;



        
        echo "获取2023年全年数据耗时: " . round($executionTime, 2) . " 秒\n";
        echo "获取数据量: " . count($data) . " 条\n";
        
        $this->assertLessThan(10, $executionTime, '获取数据应该在10秒内完成');
    }
} 