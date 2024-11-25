<?php

namespace Zyan\StockApi\Channels\Xueqiu;

use Zyan\StockApi\HttpClient\HttpClient;

/**
 * Class Xueqiu.
 *
 * @package Zyan\StockApi\Channels\Xueqiu
 *
 * @author 读心印 <aa24615@qq.com>
 */
class Xueqiu extends HttpClient
{

    /**
     * @var string
     */
    protected $baseUri = 'https://stock.xueqiu.com/';

    /**
     * Xueqiu constructor.
     */
    public function __construct()
    {
        $this->setConfig([
            'headers' => [
                'Cookie' => 'xq_a_token=691d6f0a678b98a172affb89759b9c46fd23b4e2; xqat=691d6f0a678b98a172affb89759b9c46fd23b4e2; xq_r_token=de180625dcdde2e538953eb202d55300cae40fe1; xq_id_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1aWQiOi0xLCJpc3MiOiJ1YyIsImV4cCI6MTczNDM5Njg3MiwiY3RtIjoxNzMyNTE5MzQ2NzgxLCJjaWQiOiJkOWQwbjRBWnVwIn0.RMLtESbf5lBUahBu634GzJFCeKj0QJjzCW-YTgFZV1cGPI8_PTWnNpVSoEGrk41hxYSg9nQCEPINSI0DbAlb1rkAouOXa9cjSOD8GXUPEY8JVjadMwuVZk7bSoNXe2tYJRbE1JHyO6OXHMHWbA2Jc9EMiL-5i_ny6bgICciUwGkhUItBP3l1VmJsidqf74brBMhMJY3pTSuFY-Rq0Nmv535s_4G1nDH7gWhCLZFxWGP8Qrc1iPcXx1zkOnPSJfWlv3GnRv9cPkWfnWoZQxn_6Qstzi6fztelm-ejoStUfpYjIde8PIYaXW12YGNk8LiePv8_vdG5iH-w6n6v6I2fAg; cookiesu=201732519380165; u=201732519380165; device_id=1a12c62833b392f4f9d350cd35036dea; Hm_lvt_1db88642e346389874251b5a1eded6e3=1732122909,1732440714; Hm_lpvt_1db88642e346389874251b5a1eded6e3=1732519383; HMACCOUNT=D8D05E5EB41921A3; ssxmod_itna=YqGxnDciDtG=Axmq0Lx0P+1Qx2DUx7IxeUY0pxq4+Ux3tD/BiIDnqD=GFDK40EECKF0f0Y4YiDTxA3Y8iiIxaRli0qjP3GxpBeDHxY=DUofTwoD4f5GwD0eG+DD4DWSx03DoxGYlAx0bCy6Hs26KDpxGrDlKDRx07KK5DbxDaDGaCG7Px2ro7nrDDB6R3EG4DEevzG2Aht4D1GA55Ce5D9x0CDlP4SRoD06kXeDAzRbME0jI+340OD0FmBoIwFivGlh9Ea7DQEQxrd0=QK024zmPYClW5YQiquBh5IQxYbnGICA/dGyxBDDP5YD5IGxSGDD=; ssxmod_itna2=YqGxnDciDtG=Axmq0Lx0P+1Qx2DUx7IxeUY0pxq4+UhYG9zaDBMkD7pKXkm5+OD6GBK01+4RhDrtKU1eYvhikBCi01DE44W0IDHBmTiECDa1KatCU67cQYyWLaCqpCKApd4CdQsQOC8OpbBD+7DhwbNCc=Pz7egBeHs1wrFxWTF9aCq1m1LOBQ3g5H3EWYum7th+ori/eaigyh2Rx70UmGk4ahH4KW=ZeGP1KWLommYPk05RrjZ+n8wzotYKvo+bentXmwuD+Hr1IxaL9OGiPnfegrKDIBkp3tqi38H5FiySWexE3fmg5qWqYxeq1UpeQNGmkQfoZdXcfE6ioFi+Bvd1Q/YIr7rlPxXl3UBQYork=mroINnmb44pYLuZLMC03KNEno2BpkOpwPjxre1xP+nofa=GKxHFIm2Lf2jLYpH1oq7KGDc/rI+=G1ir020+OGaFQiibpS+U/m479IO3X89oOK349i6Ki6T41IxW6d3NhzKk2y9crqCYaoh1x38OFfcc4k=Pg9n9X9trznGou34VwG854BhHDG2744BHdwuDz5T+T4KZC=1Ci=4f2EYi8b0=+Dzbg8l0jTZiCIxD08DiQ4YD'
            ]
        ]);
    }

    /**
     * 获取最新股票列表.
     *
     * @param string $market
     * @param string $type
     * @param integer $page
     * @param integer $size
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function list(string $market, string $type, int $page = 1, int $size = 100): array
    {
        $url = 'v5/stock/screener/quote/list.json';

        $body = $this->get($url, [
            'page' => $page,
            'size' => $size,
            'order' => 'desc',
            'order_by' => 'percent',
            'market' => $market,
            'type' => $type,
            //'md5__1632' => 'iqRxuD9DcDyAiQeDsD7mNIxYqCG7Y8PH4D',
        ]);

        return $body;
    }

}