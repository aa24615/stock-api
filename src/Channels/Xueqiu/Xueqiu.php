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
                'Cookie' => $cookie,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'zh-CN,zh;q=0.9,en;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
                'Referer' => 'https://xueqiu.com/',
                'Sec-Fetch-Dest' => 'empty',
                'Sec-Fetch-Mode' => 'cors',
                'Sec-Fetch-Site' => 'same-site',
                'X-Requested-With' => 'XMLHttpRequest',
                'Origin' => 'https://xueqiu.com'
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
        ]);

        return $body;
    }

    public function kline($symbol, $begin, $count)
    {
        $url = 'v5/stock/chart/kline.json';

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
        $filename = StockApi::getConfig('cache_path') . '/xueqiu_cookie';

        //从缓存中获取
        if (file_exists($filename)) {
            $data = json_decode(file_get_contents($filename), true);
            if (time() - $data['time'] > 1800) { // 改为30分钟过期
                unlink($filename);
            } else {
                return $data['cookie'];
            }
        }

        // 更新Cookie获取方式
        $user_cookie = $this->getNewCookie();

        //缓存
        $json = json_encode([
            'time' => time(),
            'cookie' => $user_cookie
        ]);

        file_put_contents($filename, $json);

        return $user_cookie;
    }

    /**
     * 获取新的Cookie - 修复版本
     * 
     * @return string
     */
    private function getNewCookie()
    {
        // 第一步：访问雪球主页获取初始Cookie
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://xueqiu.com/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === FALSE || $httpCode !== 200) {
            throw new \Exception('无法访问雪球主页，HTTP状态码: ' . $httpCode);
        }

        // 解析Cookie
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        $cookies = [];
        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        // 第二步：访问股票页面获取更多Cookie
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://xueqiu.com/S/SH000001');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        // 设置Cookie
        $cookieString = '';
        foreach ($cookies as $key => $value) {
            $cookieString .= "$key=$value; ";
        }
        curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === FALSE || $httpCode !== 200) {
            throw new \Exception('无法访问股票页面，HTTP状态码: ' . $httpCode);
        }

        // 解析新的Cookie
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        // 第三步：获取API token
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://stock.xueqiu.com/v5/stock/batch/quote.json?symbol=SH000001');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_REFERER, 'https://xueqiu.com/');
        
        // 设置Cookie
        $cookieString = '';
        foreach ($cookies as $key => $value) {
            $cookieString .= "$key=$value; ";
        }
        curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === FALSE || $httpCode !== 200) {
            throw new \Exception('无法获取API token，HTTP状态码: ' . $httpCode);
        }

        // 解析最终的Cookie
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        $user_cookie = '';
        foreach ($cookies as $key => $value) {
            $user_cookie .= "$key=$value; ";
        }

        return $user_cookie;
    }
}