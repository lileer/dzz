<?php
/**
 * Created by PhpStorm.
 * User: biandapeng
 * Date: 17/9/9
 * Time: 上午9:59
 */

namespace Dzz\Http;

use Dzz\Core\Object;

class Uri extends Object
{
    protected $segments = [];
    protected $params = [];

    protected $originUri;

    protected $uriStr = '';

    protected $query = '';

    protected $path = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function parse()
    {
        $uriInfo = parse_url(Request::get()->getRequestUri());
        $this->path = $uriInfo['path'];
        $this->query = !isset($uriInfo['query']) ? '' : $uriInfo['query'];
        $this->explodeUri();
        return $this;
    }

    private function explodeUri()
    {
        $uriInfo = explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->path));
        foreach ($uriInfo as $val) {
            if ($val != '') {
                array_push($this->segments, $val);
            }
        }
    }

    public function getSegments()
    {
        return $this->segments;
    }

}