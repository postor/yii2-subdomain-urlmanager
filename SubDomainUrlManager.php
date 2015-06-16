<?php
/**
 * SubDomainUrlManager
 * User: postor@gmail.com
 * Date: 2015/6/14
 * Time: 20:51
 */
namespace postor\subdomian;
use yii\web\UrlManager;

class SubDomainUrlManager extends UrlManager {

    

    public $baseDomain = 'local.com';
    public $subDomainKey = 'subDomain';

    //重写创建url
    public function createAbsoluteUrl($params, $scheme = null)
    {
        $subDomain = 'www';
        if(isset($params[$this->subDomainKey])){
            $subDomain = $params[$this->subDomainKey];
            unset($params[$this->subDomainKey]);
            $this->setHostInfo('http://'.$subDomain.'.'.$this->baseDomain);
        }
        return parent::createAbsoluteUrl($params, $scheme);
    }

    //重写创建url
    public function createUrl($params)
    {
        return parent::createUrl($params);
    }


    //重写解析url
    public function parseRequest($request)
    {
        $hostInfo = $request->getHostInfo();

        $arr = explode('://',$hostInfo);
        $host = $arr[1];
        $arr = explode('.'.$this->baseDomain,$host);
        $subDomain = $arr[0];
        $request->setQueryParams(array_merge($request->getQueryParams(),[$this->subDomainKey=>$subDomain,]));
        return parent::parseRequest($request);
    }
}