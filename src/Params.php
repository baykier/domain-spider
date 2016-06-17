<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com> 
 * Date: 16-6-17
 * Time: 下午11:37
 */
namespace Baykier\DomainSpider;

class Params
{

    protected $Format = 'JSON';

    protected $Version = '2016-05-11';

    protected $AccessKeyId;

    protected $Signature;

    protected $SignatureMethod = 'HMAC-SHA1';

    protected $Timestamp;

    protected $SignatureVersion = '1.0';

    protected $SignatureNonce;

    protected $AccessKeySecret;

    protected $Action = 'CheckDomain';

    protected $DomainName;


    public function __construct($accessKeyId,$accessKeySecret,$domainName)
    {
        $this->AccessKeyId = $accessKeyId;
        $this->AccessKeySecret = $accessKeySecret;
        $this->DomainName = $domainName;
        $this->Timestamp = date('Y-m-d\TH:i:s\Z');
        $this->SignatureNonce = rand();
    }

    public function getParams()
    {
        $params = array(
            'Format' => $this->Format,
            'Version' => $this->Version,
            'AccessKeyId' => $this->AccessKeyId,
            'SignatureMethod' => $this->SignatureMethod,
            'Timestamp' => $this->Timestamp,
            'SignatureVersion' => $this->SignatureVersion,
            'SignatureNonce' => $this->SignatureNonce,
            'Action' => $this->Action,
            'DomainName' => $this->DomainName,
        );
        ksort($params);
        $signStr = http_build_query($params);
        $signStr = urlencode($signStr);
        $signStr = 'GET&%2F&' . $signStr;
        $params['Signature'] = base64_encode(hash_hmac('sha1',$signStr,$this->AccessKeySecret . '&',true));
        return $params;
    }
}