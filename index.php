<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 16-6-17
 * Time: 下午11:29
 */
require_once __DIR__ . '/vendor/autoload.php';

use Baykier\DomainSpider\Generater;
use Baykier\DomainSpider\Client;

//设置UTC时区
date_default_timezone_set('UTC');

//域名生成器
$generate = new Generater();

//设置log路径
Client::setLogPath(__DIR__);

while(true)
{
    $domain =  $generate->generateDomain();
    Client::search($domain);
    sleep(rand(1,5));
}
