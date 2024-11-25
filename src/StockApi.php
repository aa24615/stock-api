<?php

/*
 * This file is part of the zyan/stock-api.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\StockApi;

use Zyan\StockApi\Channels\Xueqiu\XueqiuList;

/**
 * Class StockApi.
 *
 * @package Zyan\StockApi
 *
 * @author 读心印 <aa24615@qq.com>
 */
class StockApi
{
    protected $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getXueQiuApi()
    {
        return new XueqiuList();
    }
}
