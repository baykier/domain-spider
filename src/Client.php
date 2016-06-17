<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com> 
 * Date: 16-6-18
 * Time: 上午12:06
 */
namespace Baykier\DomainSpider;

use GuzzleHttp\Client as AbstractClient;
use Baykier\DomainSpider\Params;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Client
{

    protected static $url = 'domain.aliyuncs.com';

    protected static $logPath ;

    protected static $availFile = 'domain-avail.log';

    protected static $unAvivilFIle = 'domain-unavail.log';

    protected static $errorFIle = 'dimain-error.log';

    /**
     * @搜索域名是否可用
     * @param $domain
     */
    public static function search($domain)
    {
        $paramObj = new Params('your AccessKeyID','your AccessKeySecret',$domain);

        $params = $paramObj->getParams();

        //log path
        $path= (substr(static::$logPath,-1) == DIRECTORY_SEPARATOR) ? static::$logPath : static::$logPath . DIRECTORY_SEPARATOR;

        try
        {
            $client = new AbstractClient();
            $res = $client->request('GET',self::$url,['query' => $params]);

            $result = $res->getBody();

            $result = json_decode($result,true);
            echo 'domain:' . $domain . ' avail:' . $result['Avail'] . PHP_EOL;
            if ($result['Avail'])
            {
                $file = $path . static::$availFile;
                static::log('Success search domain:' . $domain . ' avail:' . $result['Avail'],$file);
            }
            else
            {
                $file = $path . static::$unAvivilFIle;
                static::log('Success search domain:' . $domain . ' avail:' . $result['Avail'],$file);
            }

        }
        catch(\Exception $e)
        {
            echo PHP_EOL;
            echo 'something is error';
            $file = $path . self::$errorFIle;
            static::log('Failed search domain:' . $domain,$file);
        }
    }

    /**
     * @设置path
     * @param $logPath
     * @throws \Exception
     */
    public static function setLogPath($logPath)
    {
        if (!realpath($logPath))
        {
            throw new \Exception('the given path ' . $logPath . ' is not exists!');
        }
        static::$logPath = $logPath;
    }

    /**
     * @记录log
     * @param $content
     * @param $file
     */
    public static function log($content,$file)
    {
        $log = new Logger('domain');
        $log->pushHandler(new StreamHandler($file,Logger::DEBUG));
        $log->addDebug($content);
    }
}
