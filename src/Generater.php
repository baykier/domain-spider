<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com> 
 * Date: 16-6-17
 * Time: 下午11:08
 */
namespace Baykier\DomainSpider;

use Baykier\DomainSpider\DomainSuffix;
use \Exception;

/**
 * @域名生成器
 * Class Generater
 * @package Baykier\Domain
 */
class Generater
{
    /**
     * @域名长度，不算后缀
     * @var int
     */
    protected $length = 3;

    /**
     * @域名后缀
     * @var
     */
    protected $suffix = DomainSuffix::SUFFIX_WORK;

    /**
     * @域名生成因子
     * @var array
     */
    protected $pool = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q',
        'r','s','t','u','v','w','x','y','z');

    /**
     * @设置生成长度
     * @param $number
     */
    public function setLength($number)
    {
        $this->length = (int) $number;
    }

    /**
     * @设置域名后缀
     * @param $suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * @设置生成因子
     * @param array $pool
     */
    public function setPool(array $pool)
    {
        $this->pool = $pool;
    }

    /**
     * 生成随机域名
     * @return string
     * @throws \Exception
     */
    public function generateDomain()
    {
        if (empty($this->pool) || empty($this->length) || empty($this->suffix))
        {
            throw new \Exception('参数错误!');
        }
        $domain = '';
        $pool = array_values($this->pool);
        while (strlen($domain) < $this->length)
        {
            $offset = rand(0,count($pool) -1);
            $domain .= $pool[$offset];
        }
        unset($pool,$offset);
        return $domain . $this->suffix;
    }
}