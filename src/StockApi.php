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
    protected static array $config = [
        'cache_path' => __DIR__ . '/../runtime/'
    ];

    /**
     * @return array | string
     */
    public static function getConfig($name=null)
    {
        if($name){
            return self::$config[$name];
        }

        return self::$config;
    }


    /**
     * @param array $config
     */
    public static function setConfig(array $config): void
    {
        self::$config = $config;
    }

    public static function getXueqiu(){
        return new XueqiuList();
    }
}
