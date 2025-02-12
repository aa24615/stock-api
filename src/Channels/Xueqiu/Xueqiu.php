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
                 'Cookie' => 'cookiesu=201732519380165; device_id=1a12c62833b392f4f9d350cd35036dea; .thumbcache_f24b8bbe5a5934237bbc0eda20c1b6e7=; s=ac12ea5vol; acw_tc=2760827f17393540720764649e9be3949bb470800916f60abda77b3fb81a88; xq_a_token=b1d767edc014ddf478005982ba9e053910dad8dc; xqat=b1d767edc014ddf478005982ba9e053910dad8dc; xq_r_token=4ac6dcb5a1bd823260eef986e5e529b07195748d; xq_id_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1aWQiOi0xLCJpc3MiOiJ1YyIsImV4cCI6MTc0MDg3NzAzNywiY3RtIjoxNzM5MzU0MDQ2NzM4LCJjaWQiOiJkOWQwbjRBWnVwIn0.kOirUiXoCpQmA2KNhlQ9ovGt-pHtk7635EKp9UbTlDADwK7o6Q5Jr3ebEWbaqDAUE4Xh8YbMvZcCqiU7knFHrLyJX8XJ7_bCNzRlE71E49gsSezpMRhUgcItu5EvBILFMPyJgf7NAuzCV1UEwVpDgegtC2mrVwIjN0F4Cuw4nlCto0y2p4caeXSxeguh2_c0O_klXxc2RU18iJjJJmGpXVaLTpjTs28LpmCyprXXv24NQTTzLUe4_VEKFNHqbrOLnpYOeH3AO6y8bbrGh8Pl-W4QpbCeZPrepSGJIyrjDZBA10o36AnY9jwTgkewsds9w_lESFFN0qMZ-xs4nCSnuQ; u=201732519380165; Hm_lvt_1db88642e346389874251b5a1eded6e3=1739354073; HMACCOUNT=D8D05E5EB41921A3; is_overseas=0; ssxmod_itna=Qqfx9DyD0iGQq4eq0LK0Pp6=wAxYv4D8+K+D0xOw34GXY+oDZDiqAPGhDC8RFlWrPP=Y0GiL+qfCi2dr+89rx+FN=nfO0=DU4i8DCk03qTDemtD5xGoDPxDeDAAqGaDb4DrcdqGPyn2LvkAxiOD7eDXxGCDQ9GUxGWDiPD7g9DTEGkr9aC3DDz3eSiVnDDEB911pBGd4D1qCHerBKD9x0CDlPxBIoD0pMU3ny103kE6G9h540OD0IwcZc+FeysgaFEaYbd=YRe81+9ah44viGoKeeQ=7DQYGiYTQGYs70ppe25ClZ/3DDWxr14D=; ssxmod_itna2=Qqfx9DyD0iGQq4eq0LK0Pp6=wAxYv4D8+K+D0xOd4A=FPD/7xKdK7=D2WeD=; Hm_lpvt_1db88642e346389874251b5a1eded6e3=1739354132'
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

        // 错误码
        if($body['error_code'] != 400016){

        }

        return $body;
    }


    public function getCookie(string $url, array $data)
    {

    }

}