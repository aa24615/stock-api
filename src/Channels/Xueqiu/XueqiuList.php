<?php

namespace Zyan\StockApi\Channels\Xueqiu;

use Zyan\StockApi\Channels\ChannelsInterface;

/**
 * Class XueqiuList.
 *
 * @package Zyan\StockApi\Channels\Xueqiu
 *
 * @author 读心印 <aa24615@qq.com>
 */
class XueqiuList extends Xueqiu implements ChannelsInterface
{


    /**
     * 获取历史K线
     *
     * @param string $symbol 股票代码
     * @param string|null $startDate 开始日期，格式：Y-m-d，如：2023-01-01，null表示不限制
     * @param string|null $endDate 结束日期，格式：Y-m-d，如：2023-12-31，null表示不限制
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getRecordsByDate(string $symbol, ?string $startDate = null, ?string $endDate = null): array
    {
        $list = [];

        // 如果没有指定结束日期，使用当前时间
        $endTime = $endDate ? strtotime($endDate) * 1000 : time() * 1000;
        
        // 如果没有指定开始日期，使用一个很早的时间
        $startTime = $startDate ? strtotime($startDate) * 1000 : 0;

        $time = $endTime;

        while (true) {
            $data = $this->kline($symbol, $time, -200);

            // 检查API响应是否有效
            if (!isset($data['data']['item']) || !is_array($data['data']['item'])) {
                break;
            }

            $count = count($data['data']['item']);

            if ($count < 200) {
                // 最后一次请求，添加所有剩余数据
                foreach ($data['data']['item'] as $item) {
                    if ($startDate && $item[0] < $startTime) {
                        // 如果数据时间早于开始时间，停止添加
                        break 2;
                    }
                    $list[] = $item;
                }
                break;
            }

            // 过滤时间范围内的数据
            $filteredItems = [];
            foreach ($data['data']['item'] as $item) {
                if ($startDate && $item[0] < $startTime) {
                    // 如果数据时间早于开始时间，停止添加
                    break 2;
                }
                $filteredItems[] = $item;
            }

            $list = array_merge($list, $filteredItems);

            // 更新下次请求的时间
            $time = $data['data']['item'][0][0];
            
            // 如果已经到达开始时间，停止请求
            if ($startDate && $time <= $startTime) {
                break;
            }
        }

        // 按时间正序排列（从早到晚）
        usort($list, function($a, $b) {
            return $a[0] - $b[0];
        });

        return $list;
    }



    public function getRecordsAll(string $symbol): array
    {
        // TODO: Implement getRecordsAll() method.

        $list = [];

        $time = time()*1000;

        while (true){
            $data = $this->kline($symbol, $time, -200);

            $count = count($data['data']['item']);

            if($count<200){
                break;
            }


            $list = array_merge($list, $data['data']['item']);

            $time = $data['data']['item'][0][0];

        }



        return $list;

    }
    /**
     * 分页获取所有股票.
     *
     * @param string $market
     * @param string $type
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getListAll(string $market, string $type): array
    {
        $currentPage = 1;
        $totalPage = 2;
        $size = 100;
        $count = 0;
        $list = [];

        while ($currentPage <= $totalPage) {
            $data = $this->list($market, $type, $currentPage, $size);

            if ($data['data']['list']) {
                $list = array_merge($list, $data['data']['list']);
            }

            if ($currentPage == 1) {
                $count = $data['data']['count'];
                $totalPage = ceil($count / $size);
            }

            $currentPage++;
        }

        $result = [
            'raw_count' => $count,
            'count' => count($list),
            'size' => $size,
            'total_page' => $totalPage,
            'market' => $market,
            'type' => $type,
            'list' => $list,
        ];

        return $result;
    }

    /**
     * 获取所有深圳A股.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getSzListAllToA(): array
    {
        return $this->getListAll('CN', 'sza');
    }

    /**
     * 获取所有深圳B股.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getSzListAllToB(): array
    {
        return $this->getListAll('CN', 'szb');
    }

    /**
     * 获取所有上海A股.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getShListAllToA(): array
    {
        return $this->getListAll('CN', 'sha');
    }

    /**
     * 获取所有上海B股.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getShListAllToB(): array
    {
        return $this->getListAll('CN', 'shb');
    }

    /**
     * 获取所美股.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getUsListAll(): array
    {
        return $this->getListAll("US", 'us');
    }

    /**
     * 获取所有港股.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getHkListAll(): array
    {
        return $this->getListAll("HK", 'hk');
    }
}