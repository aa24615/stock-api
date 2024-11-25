<?php

namespace Zyan\StockApi\Channels\Xueqiu;

/**
 * Class XueqiuList.
 *
 * @package Zyan\StockApi\Channels\Xueqiu
 *
 * @author 读心印 <aa24615@qq.com>
 */
class XueqiuList extends Xueqiu
{

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