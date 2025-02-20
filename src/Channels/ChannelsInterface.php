<?php
/*
 * This file is part of the zyan/douyin.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\StockApi\Channels;

/**
 * Interface ChannelsInterface
 * @package Zyan\StockApi\HttpClient
 */
interface ChannelsInterface
{
    public function getListAll(string $market, string $type): array;

    public function getSzListAllToA(): array;

    public function getSzListAllToB(): array;

    public function getShListAllToA(): array;

    public function getShListAllToB(): array;

    public function getHkListAll(): array;

    public function getUsListAll(): array;
}
