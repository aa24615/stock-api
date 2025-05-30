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