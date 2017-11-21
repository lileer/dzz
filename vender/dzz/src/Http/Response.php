<?php

namespace Dzz\Http;

use Dzz\Core\Dzz;

class Response extends \Dzz\Core\Object
{

    const FORMAT_HTML = 'html';
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    private $output;
    public $format;

    public function __construct($output)
    {
        $this->output = $output;
    }

    public function output()
    {
        if (!$this->format) {
            $this->format = Dzz::$app->config['format'];
        }
        switch ($this->format) {
            case self::FORMAT_JSON:
                header("Content-type: application/json; charset=utf-8");
                echo json_encode($this->output, JSON_UNESCAPED_UNICODE);
                break;
            case self::FORMAT_XML:
                header("Content-type: application/xml; charset=utf-8");
                //TODO
                break;
            case self::FORMAT_HTML:
                header("Content-type: text/html; charset=utf-8");
                echo $this->output;
                break;
            default:
                throw new \Exception('错误的formt:' . $this->format);
        }
    }

    public function __destruct()
    {

    }

}