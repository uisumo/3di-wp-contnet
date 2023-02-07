<?php

namespace PhpXmlRpc;

use PhpXmlRpc\Helper\Charset;
use PhpXmlRpc\Helper\Http;
use PhpXmlRpc\Helper\Logger;
use PhpXmlRpc\Helper\XMLParser;



class Request
{
        public $payload;
    public $methodname;
    public $params = array();
    public $debug = 0;
    public $content_type = 'text/xml';

        protected $httpResponse = array();

    
    public 
function __construct($methodName, $params = array())
    {
        $this->methodname = $methodName;
        foreach ($params as $param) {
            $this->addParam($param);
        }
    }

    public 
function xml_header($charsetEncoding = '')
    {
        if ($charsetEncoding != '') {
            return "<?xml version=\"1.0\" encoding=\"$charsetEncoding\" ?" . ">\n<methodCall>\n";
        } else {
            return "<?xml version=\"1.0\"?" . ">\n<methodCall>\n";
        }
    }

    public 
function xml_footer()
    {
        return '</methodCall>';
    }

    public 
function createPayload($charsetEncoding = '')
    {
        if ($charsetEncoding != '') {
            $this->content_type = 'text/xml; charset=' . $charsetEncoding;
        } else {
            $this->content_type = 'text/xml';
        }
        $this->payload = $this->xml_header($charsetEncoding);
        $this->payload .= '<methodName>' . Charset::instance()->encodeEntities(
            $this->methodname, PhpXmlRpc::$xmlrpc_internalencoding, $charsetEncoding) . "</methodName>\n";
        $this->payload .= "<params>\n";
        foreach ($this->params as $p) {
            $this->payload .= "<param>\n" . $p->serialize($charsetEncoding) .
                "</param>\n";
        }
        $this->payload .= "</params>\n";
        $this->payload .= $this->xml_footer();
    }

    
    public 
function method($methodName = '')
    {
        if ($methodName != '') {
            $this->methodname = $methodName;
        }

        return $this->methodname;
    }

    
    public 
function serialize($charsetEncoding = '')
    {
        $this->createPayload($charsetEncoding);

        return $this->payload;
    }

    
    public 
function addParam($param)
    {
                if (is_object($param) && is_a($param, 'PhpXmlRpc\Value')) {
            $this->params[] = $param;

            return true;
        } else {
            return false;
        }
    }

    
    public 
function getParam($i)
    {
        return $this->params[$i];
    }

    
    public 
function getNumParams()
    {
        return count($this->params);
    }

    
    public 
function parseResponseFile($fp)
    {
        $ipd = '';
        while ($data = fread($fp, 32768)) {
            $ipd .= $data;
        }
        return $this->parseResponse($ipd);
    }

    
    public 
function parseResponse($data = '', $headersProcessed = false, $returnType = 'xmlrpcvals')
    {
        if ($this->debug) {
            Logger::instance()->debugMessage("---GOT---\n$data\n---END---");
        }

        $this->httpResponse = array('raw_data' => $data, 'headers' => array(), 'cookies' => array());

        if ($data == '') {
            error_log('XML-RPC: ' . __METHOD__ . ': no response received from server.');
            return new Response(0, PhpXmlRpc::$xmlrpcerr['no_data'], PhpXmlRpc::$xmlrpcstr['no_data']);
        }

                if (substr($data, 0, 4) == 'HTTP') {
            $httpParser = new Http();
            try {
                $this->httpResponse = $httpParser->parseResponseHeaders($data, $headersProcessed, $this->debug);
            } catch(\Exception $e) {
                $r = new Response(0, $e->getCode(), $e->getMessage());
                                                $r->raw_data = $data;

                return $r;
            }
        }

                $data = trim($data);

        
                        $pos = strrpos($data, '</methodResponse>');
        if ($pos !== false) {
            $data = substr($data, 0, $pos + 17);
        }

                $respEncoding = XMLParser::guessEncoding(@$this->httpResponse['headers']['content-type'], $data);

        if ($this->debug) {
            $start = strpos($data, '<!-- SERVER DEBUG INFO (BASE64 ENCODED):');
            if ($start) {
                $start += strlen('<!-- SERVER DEBUG INFO (BASE64 ENCODED):');
                $end = strpos($data, '-->', $start);
                $comments = substr($data, $start, $end - $start);
                Logger::instance()->debugMessage("---SERVER DEBUG INFO (DECODED) ---\n\t" .
                    str_replace("\n", "\n\t", base64_decode($comments)) . "\n---END---", $respEncoding);
            }
        }

                if ($returnType == 'xml') {
            $r = new Response($data, 0, '', 'xml');
            $r->hdrs = $this->httpResponse['headers'];
            $r->_cookies = $this->httpResponse['cookies'];
            $r->raw_data = $this->httpResponse['raw_data'];

            return $r;
        }

        if ($respEncoding != '') {

                                                                        if (!in_array($respEncoding, array('UTF-8', 'US-ASCII')) && !XMLParser::hasEncoding($data)) {
                if ($respEncoding == 'ISO-8859-1') {
                    $data = utf8_encode($data);
                } else {
                    if (extension_loaded('mbstring')) {
                        $data = mb_convert_encoding($data, 'UTF-8', $respEncoding);
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': invalid charset encoding of received response: ' . $respEncoding);
                    }
                }
            }
        }

        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, true);
                                                        if (!in_array(PhpXmlRpc::$xmlrpc_internalencoding, array('UTF-8', 'ISO-8859-1', 'US-ASCII'))) {
            xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
        } else {
            xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, PhpXmlRpc::$xmlrpc_internalencoding);
        }

        $xmlRpcParser = new XMLParser();
        xml_set_object($parser, $xmlRpcParser);

        if ($returnType == 'phpvals') {
            xml_set_element_handler($parser, 'xmlrpc_se', 'xmlrpc_ee_fast');
        } else {
            xml_set_element_handler($parser, 'xmlrpc_se', 'xmlrpc_ee');
        }

        xml_set_character_data_handler($parser, 'xmlrpc_cd');
        xml_set_default_handler($parser, 'xmlrpc_dh');

		        if (!xml_parse($parser, $data, ! empty($data) )) { 					            if ((xml_get_current_line_number($parser)) == 1) {
                $errStr = 'XML error at line 1, check URL';
            } else {
                $errStr = sprintf('XML error: %s at line %d, column %d',
                    xml_error_string(xml_get_error_code($parser)),
                    xml_get_current_line_number($parser), xml_get_current_column_number($parser));
            }
            error_log($errStr);
            $r = new Response(0, PhpXmlRpc::$xmlrpcerr['invalid_return'], PhpXmlRpc::$xmlrpcstr['invalid_return'] . ' (' . $errStr . ')');
            xml_parser_free($parser);
            if ($this->debug) {
                print $errStr;
            }
            $r->hdrs = $this->httpResponse['headers'];
            $r->_cookies = $this->httpResponse['cookies'];
            $r->raw_data = $this->httpResponse['raw_data'];

            return $r;
        }
        xml_parser_free($parser);
                if ($xmlRpcParser->_xh['isf'] > 1) {
            if ($this->debug) {
                            }

            $r = new Response(0, PhpXmlRpc::$xmlrpcerr['invalid_return'],
                PhpXmlRpc::$xmlrpcstr['invalid_return'] . ' ' . $xmlRpcParser->_xh['isf_reason']);
        }
                        elseif ($returnType == 'xmlrpcvals' && !is_object($xmlRpcParser->_xh['value'])) {
                                                $r = new Response(0, PhpXmlRpc::$xmlrpcerr['invalid_return'],
                PhpXmlRpc::$xmlrpcstr['invalid_return']);
        } else {
            if ($this->debug > 1) {
                Logger::instance()->debugMessage(
                    "---PARSED---\n".var_export($xmlRpcParser->_xh['value'], true)."\n---END---"
                );
            }

                        $v = &$xmlRpcParser->_xh['value'];

            if ($xmlRpcParser->_xh['isf']) {
                                if ($returnType == 'xmlrpcvals') {
                    $errNo_v = $v['faultCode'];
                    $errStr_v = $v['faultString'];
                    $errNo = $errNo_v->scalarval();
                    $errStr = $errStr_v->scalarval();
                } else {
                    $errNo = $v['faultCode'];
                    $errStr = $v['faultString'];
                }

                if ($errNo == 0) {
                                        $errNo = -1;
                }

                $r = new Response(0, $errNo, $errStr);
            } else {
                $r = new Response($v, 0, '', $returnType);
            }
        }

        $r->hdrs = $this->httpResponse['headers'];
        $r->_cookies = $this->httpResponse['cookies'];
        $r->raw_data = $this->httpResponse['raw_data'];

        return $r;
    }

    
    public 
function kindOf()
    {
        return 'msg';
    }

    
    public 
function setDebug($in)
    {
        $this->debug = $in;
    }
}
