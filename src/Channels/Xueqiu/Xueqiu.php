<?php

namespace Zyan\StockApi\Channels\Xueqiu;

use Zyan\StockApi\HttpClient\HttpClient;
use Zyan\StockApi\StockApi;

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

        $cookie = $this->getCookie();

        $this->setConfig([
            'headers' => [
                'Cookie' => $cookie
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

    public function kline($symbol,$begin,$count){
        $url  = '/v5/stock/chart/kline.json';

        $body = $this->get($url, [
            'symbol' => $symbol,
            'begin' => $begin,
            'period' => 'day',
            'type' => 'before',
            'count' => $count,
            'indicator' => 'kline,pe,pb,ps,pcf,market_capital,agt,ggt,balance',
        ]);

        return $body;
    }

    /**
     * getCookie.
     *
     * @return string
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getCookie()
    {
        $filename = StockApi::getConfig('cache_path').'/xueqiu_cookie';

        //从缓存中获取
        if(file_exists($filename)){
            $data = json_decode(file_get_contents($filename), true);
            if(time()-$data['time']>86400){
                unlink($filename);
            }else{
                return $data['cookie'];
            }
        }

        // 目标网址
        $url = "https://xueqiu.com/?md5__1038=QqGxcDnDyiitnD05o4%2Br%3D8%3DDtmZUS7ubD";

        // 初始化cURL会话
        $ch = curl_init();

        // 设置cURL传输选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回结果而不是直接输出
        curl_setopt($ch, CURLOPT_HEADER, 1); // 包括header在返回内容里
        curl_setopt($ch, CURLOPT_NOBODY, 0); // 返回body内容

        // 如果需要支持HTTPS，请确保以下设置已启用
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过SSL证书验证（生产环境请谨慎使用）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书的域名是否匹配

        // 执行cURL会话
        $response = curl_exec($ch);

        if ($response === FALSE) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        } else {
            // 分离头部信息和主体内容
            list($header, $body) = explode("\r\n\r\n", $response, 2);

            // 解析Set-Cookie行
            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
            $cookies = array();
            foreach ($matches[1] as $item) {
                parse_str($item, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }
            $user_cookie = '';
            foreach ($cookies as $key => $value) {
                $user_cookie .= "$key=$value; ";
            }
        }
        // 关闭cURL资源，并释放系统资源
        curl_close($ch);

        //缓存
        $json = json_encode([
            'time' => time(),
            'cookie' => $user_cookie
        ]);

        file_put_contents($filename, $json);


        return $user_cookie;
    }
}