

# zyan/stock-api

股票api

## 要求

1. php >= 8.4
2. composer 2.x

## 安装

```shell
composer require zyan/stock-api -vvv
```
## 用法


#### 实例化

```
$stockApi = new StockApi();
$xueQiuApi = $stockApi->getXueQiuApi(); //获取雪球api
```
目前只有雪球api,后面版本会增加其他api

#### 股票列表

```
//深圳A股
$xueQiuApi->getSzListAllToA();
//深圳B股
$xueQiuApi->getSzListAllToB();
//上海A股
$xueQiuApi->getShListAllToA();
//上海B股
$xueQiuApi->getShListAllToB();
//美股
$xueQiuApi->getUsListAll();
//港股
$xueQiuApi->getHkListAll();
```

return

```
(
    [count] => 2840
    [raw_count] => 2840
    [size] => 100
    [total_page] => 29
    [type] => 'sz'
    [market] => 'CN'
    [list] => Array
    (
        [0] => Array
            (
            [symbol] => SZ300043
            [net_profit_cagr] => -44.773510944738
            [north_net_inflow] =>
            [ps] => 4.4096797096154
            [type] => 11
            [percent] => 20.05
            [has_follow] =>
            [tick_size] => 0.01
            [pb_ttm] => 3.384
            [float_shares] => 1243539501
            [current] => 4.61
            [amplitude] => 24.74
            [pcf] => 38.22815900534
            [current_year_percent] => 24.26
            [float_market_capital] => 5732717100
            [north_net_inflow_time] =>
            [market_capital] => 5735754629
            [dividend_yield] =>
            [lot_size] => 100
            [roe_ttm] => -14.291383768457
            [total_percent] => 94.69
            [percent5m] => 0
            [income_cagr] => -4.5863830118018
            [amount] => 1398782578.23
            [chg] => 0.77
            [issue_date_ts] => 1263916800000
            [eps] => -0.21
            [main_net_inflows] => 148868900
            [volume] => 325274271
            [volume_ratio] => 2.23
            [pb] => 3.384
            [followers] => 29531
            [turnover_rate] => 26.16
            [mapping_quote_current] =>
            [first_percent] => 13.73
            [name] => 星辉娱乐
            [pe_ttm] =>
            [dual_counter_mapping_symbol] =>
            [total_shares] => 1244198401
            [limitup_days] => 1
        )
        ...
    )
)
 
```
注意: 以上方法都是全量的,就是分页获取所有数据,如果只需要部分数据,请自行分页获取

```
$stockApi->list(string $market,string $type,int $currentPage,int $size)
```
return
```
(
    [data] => Array
        (
            [count] => 5000
            [list] => Array
            (
                [0] => Array
                    (
                    [symbol] => SZ300043
                    [net_profit_cagr] => -44.773510944738
                    [north_net_inflow] =>
                    [ps] => 4.4096797096154
                    [type] => 11
                    [percent] => 20.05
                    [has_follow] =>
                    [tick_size] => 0.01
                    [pb_ttm] => 3.384
                    [float_shares] => 1243539501
                    [current] => 4.61
                    [amplitude] => 24.74
                    [pcf] => 38.22815900534
                    [current_year_percent] => 24.26
                    [float_market_capital] => 5732717100
                    [north_net_inflow_time] =>
                    [market_capital] => 5735754629
                    [dividend_yield] =>
                    [lot_size] => 100
                    [roe_ttm] => -14.291383768457
                    [total_percent] => 94.69
                    [percent5m] => 0
                    [income_cagr] => -4.5863830118018
                    [amount] => 1398782578.23
                    [chg] => 0.77
                    [issue_date_ts] => 1263916800000
                    [eps] => -0.21
                    [main_net_inflows] => 148868900
                    [volume] => 325274271
                    [volume_ratio] => 2.23
                    [pb] => 3.384
                    [followers] => 29531
                    [turnover_rate] => 26.16
                    [mapping_quote_current] =>
                    [first_percent] => 13.73
                    [name] => 星辉娱乐
                    [pe_ttm] =>
                    [dual_counter_mapping_symbol] =>
                    [total_shares] => 1244198401
                    [limitup_days] => 1
                )
                ...
            )
        )
    )
    [error_code] => 0
    [error_msg] => 'ok'
)    
```

## 参与贡献

1. fork 当前库到你的名下。
2. 在你的本地修改完成审阅过后提交到你的仓库。
3. 提交 PR 并描述你的修改，等待合并。
## License

[MIT license](https://opensource.org/licenses/MIT)
