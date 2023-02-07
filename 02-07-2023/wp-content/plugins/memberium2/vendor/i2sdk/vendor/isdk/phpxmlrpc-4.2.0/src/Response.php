<?php

namespace PhpXmlRpc;

use PhpXmlRpc\Helper\Charset;



class Response
{
        public $val = 0;
    public $valtyp;
    public $errno = 0;
    public $errstr = '';
    public $payload;
    public $hdrs = array();
    public $_cookies = array();
    public $content_type = 'text/xml';
    public $raw_data = '';

    
    public 
function __construct($val, $fCode = 0, $fString = '', $valType = '')
    {
        if ($fCode != 0) {
                        $this->errno = $fCode;
            $this->errstr = $fString;
        } else {
                        $this->val = $val;
            if ($valType == '') {
                                if (is_object($this->val) && is_a($this->val, 'PhpXmlRpc\Value')) {
                    $this->valtyp = 'xmlrpcvals';
                } elseif (is_string($this->val)) {
                    $this->valtyp = 'xml';
                } else {
                    $this->valtyp = 'phpvals';
                }
            } else {
                                $this->valtyp = $valType;
            }
        }
    }

    
    public 
function faultCode()
    {
        return $this->errno;
    }

    
    public 
function faultString()
    {
        return $this->errstr;
    }

    
    public 
function value()
    {
        return $this->val;
    }

    
    public 
function cookies()
    {
        return $this->_cookies;
    }

    
    public 
function serialize($charsetEncoding = '')
    {
        if ($charsetEncoding != '') {
            $this->content_type = 'text/xml; charset=' . $charsetEncoding;
        } else {
            $this->content_type = 'text/xml';
        }
        if (PhpXmlRpc::$xmlrpc_null_apache_encoding) {
            $result = "<methodResponse xmlns:ex=\"" . PhpXmlRpc::$xmlrpc_null_apache_encoding_ns . "\">\n";
        } else {
            $result = "<methodResponse>\n";
        }
        if ($this->errno) {
                                    $result .= "<fault>\n" .
                "<value>\n<struct><member><name>faultCode</name>\n<value><int>" . $this->errno .
                "</int></value>\n</member>\n<member>\n<name>faultString</name>\n<value><string>" .
                Charset::instance()->encodeEntities($this->errstr, PhpXmlRpc::$xmlrpc_internalencoding, $charsetEncoding) . "</string></value>\n</member>\n" .
                "</struct>\n</value>\n</fault>";
        } else {
            if (!is_object($this->val) || !is_a($this->val, 'PhpXmlRpc\Value')) {
                if (is_string($this->val) && $this->valtyp == 'xml') {
                    $result .= "<params>\n<param>\n" .
                        $this->val .
                        "</param>\n</params>";
                } else {
                                        throw new \Exception('cannot serialize xmlrpc response objects whose content is native php values');
                }
            } else {
                $result .= "<params>\n<param>\n" .
                    $this->val->serialize($charsetEncoding) .
                    "</param>\n</params>";
            }
        }
        $result .= "\n</methodResponse>";
        $this->payload = $result;

        return $result;
    }
}
