<?php

namespace Dzz\Http;

use Dzz\Core\Object;

class Request extends Object
{

    public $get;
    public $post;
    public $request;
    public $cookie;
    public $a = 1;

    public function __construct()
    {
        parent::__construct();
    }

    public function getServerPort()
    {
        return isset($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : null;
    }

    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }

    public function getMethod()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
    }


    public function getRemoteHost()
    {
        return isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null;
    }

    public function getUserHost()
    {
        return isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null;
    }

    public function getUserIP()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }

    public function getRequestUri()
    {
        return  $_SERVER['REQUEST_URI'];
    }

    public function getQueryString()
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }

    public function getAuthToken()
    {
        return isset($_SERVER['AUTHORIZATION']) ? $_SERVER['AUTHORIZATION'] : null;
    }

    public function setGet($get)
    {
        $this->get = $get;
        return $this;
    }

    public function getGet()
    {
        return $this->get;
    }

    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setCookie($cookie)
    {
        $this->cookie = Cookie::get()->setData($cookie);
        return $this;
    }

    public function getCookie()
    {
        return Cookie::get()->getData();
    }




}