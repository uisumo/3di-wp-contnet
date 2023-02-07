<?php

namespace PhpXmlRpc;

use PhpXmlRpc\Helper\XMLParser;



class Encoder
{
    
    public 
function decode($xmlrpcVal, $options = array())
    {
        switch ($xmlrpcVal->kindOf()) {
            case 'scalar':
                if (in_array('extension_api', $options)) {
                    reset($xmlrpcVal->me);
                    list($typ, $val) = each($xmlrpcVal->me);
                    switch ($typ) {
                        case 'dateTime.iso8601':
                            $xmlrpcVal->scalar = $val;
                            $xmlrpcVal->type = 'datetime';
                            $xmlrpcVal->timestamp = \PhpXmlRpc\Helper\Date::iso8601Decode($val);

                            return $xmlrpcVal;
                        case 'base64':
                            $xmlrpcVal->scalar = $val;
                            $xmlrpcVal->type = $typ;

                            return $xmlrpcVal;
                        default:
                            return $xmlrpcVal->scalarval();
                    }
                }
                if (in_array('dates_as_objects', $options) && $xmlrpcVal->scalartyp() == 'dateTime.iso8601') {
                                                                                $out = $xmlrpcVal->scalarval();
                    if (is_string($out)) {
                        $out = strtotime($out);
                    }
                    if (is_int($out)) {
                        $result = new \DateTime();
                        $result->setTimestamp($out);

                        return $result;
                    } elseif (is_a($out, 'DateTimeInterface')) {
                        return $out;
                    }
                }

                return $xmlrpcVal->scalarval();
            case 'array':
                $arr = array();
                foreach($xmlrpcVal as $value) {
                    $arr[] = $this->decode($value, $options);
                }

                return $arr;
            case 'struct':
                                                                                if (in_array('decode_php_objs', $options) && $xmlrpcVal->_php_class != ''
                    && class_exists($xmlrpcVal->_php_class)
                ) {
                    $obj = @new $xmlrpcVal->_php_class();
                    foreach ($xmlrpcVal as $key => $value) {
                        $obj->$key = $this->decode($value, $options);
                    }

                    return $obj;
                } else {
                    $arr = array();
                    foreach ($xmlrpcVal as $key => $value) {
                        $arr[$key] = $this->decode($value, $options);
                    }

                    return $arr;
                }
            case 'msg':
                $paramCount = $xmlrpcVal->getNumParams();
                $arr = array();
                for ($i = 0; $i < $paramCount; $i++) {
                    $arr[] = $this->decode($xmlrpcVal->getParam($i), $options);
                }

                return $arr;
        }
    }

    
    public 
function encode($phpVal, $options = array())
    {
        $type = gettype($phpVal);
        switch ($type) {
            case 'string':
                if (in_array('auto_dates', $options) && preg_match('/^[0-9]{8}T[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $phpVal)) {
                    $xmlrpcVal = new Value($phpVal, Value::$xmlrpcDateTime);
                } else {
                    $xmlrpcVal = new Value($phpVal, Value::$xmlrpcString);
                }
                break;
            case 'integer':
                $xmlrpcVal = new Value($phpVal, Value::$xmlrpcInt);
                break;
            case 'double':
                $xmlrpcVal = new Value($phpVal, Value::$xmlrpcDouble);
                break;
                                    case 'boolean':
                $xmlrpcVal = new Value($phpVal, Value::$xmlrpcBoolean);
                break;
                        case 'array':
                                                                                                $j = 0;
                $arr = array();
                $ko = false;
                foreach ($phpVal as $key => $val) {
                    $arr[$key] = $this->encode($val, $options);
                    if (!$ko && $key !== $j) {
                        $ko = true;
                    }
                    $j++;
                }
                if ($ko) {
                    $xmlrpcVal = new Value($arr, Value::$xmlrpcStruct);
                } else {
                    $xmlrpcVal = new Value($arr, Value::$xmlrpcArray);
                }
                break;
            case 'object':
                if (is_a($phpVal, 'PhpXmlRpc\Value')) {
                    $xmlrpcVal = $phpVal;
                } elseif (is_a($phpVal, 'DateTimeInterface')) {
                    $xmlrpcVal = new Value($phpVal->format('Ymd\TH:i:s'), Value::$xmlrpcStruct);
                } else {
                    $arr = array();
                    reset($phpVal);
                    while (list($k, $v) = each($phpVal)) {
                        $arr[$k] = $this->encode($v, $options);
                    }
                    $xmlrpcVal = new Value($arr, Value::$xmlrpcStruct);
                    if (in_array('encode_php_objs', $options)) {
                                                                        $xmlrpcVal->_php_class = get_class($phpVal);
                    }
                }
                break;
            case 'NULL':
                if (in_array('extension_api', $options)) {
                    $xmlrpcVal = new Value('', Value::$xmlrpcString);
                } elseif (in_array('null_extension', $options)) {
                    $xmlrpcVal = new Value('', Value::$xmlrpcNull);
                } else {
                    $xmlrpcVal = new Value();
                }
                break;
            case 'resource':
                if (in_array('extension_api', $options)) {
                    $xmlrpcVal = new Value((int)$phpVal, Value::$xmlrpcInt);
                } else {
                    $xmlrpcVal = new Value();
                }
                        default:
                                                                $xmlrpcVal = new Value();
                break;
        }

        return $xmlrpcVal;
    }

    
    public 
function decodeXml($xmlVal, $options = array())
    {
                $valEncoding = XMLParser::guessEncoding('', $xmlVal);
        if ($valEncoding != '') {

                                                                        if (!in_array($valEncoding, array('UTF-8', 'US-ASCII')) && !XMLParser::hasEncoding($xmlVal)) {
                if ($valEncoding == 'ISO-8859-1') {
                    $xmlVal = utf8_encode($xmlVal);
                } else {
                    if (extension_loaded('mbstring')) {
                        $xmlVal = mb_convert_encoding($xmlVal, 'UTF-8', $valEncoding);
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': invalid charset encoding of xml text: ' . $valEncoding);
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

        xml_set_element_handler($parser, 'xmlrpc_se_any', 'xmlrpc_ee');
        xml_set_character_data_handler($parser, 'xmlrpc_cd');
        xml_set_default_handler($parser, 'xmlrpc_dh');
        if (!xml_parse($parser, $xmlVal, 1)) {
            $errstr = sprintf('XML error: %s at line %d, column %d',
                xml_error_string(xml_get_error_code($parser)),
                xml_get_current_line_number($parser), xml_get_current_column_number($parser));
            error_log($errstr);
            xml_parser_free($parser);

            return false;
        }
        xml_parser_free($parser);
        if ($xmlRpcParser->_xh['isf'] > 1) {
            
            error_log($xmlRpcParser->_xh['isf_reason']);

            return false;
        }
        switch ($xmlRpcParser->_xh['rt']) {
            case 'methodresponse':
                $v = &$xmlRpcParser->_xh['value'];
                if ($xmlRpcParser->_xh['isf'] == 1) {
                    $vc = $v['faultCode'];
                    $vs = $v['faultString'];
                    $r = new Response(0, $vc->scalarval(), $vs->scalarval());
                } else {
                    $r = new Response($v);
                }

                return $r;
            case 'methodcall':
                $req = new Request($xmlRpcParser->_xh['method']);
                for ($i = 0; $i < count($xmlRpcParser->_xh['params']); $i++) {
                    $req->addParam($xmlRpcParser->_xh['params'][$i]);
                }

                return $req;
            case 'value':
                return $xmlRpcParser->_xh['value'];
            default:
                return false;
        }
    }

}
