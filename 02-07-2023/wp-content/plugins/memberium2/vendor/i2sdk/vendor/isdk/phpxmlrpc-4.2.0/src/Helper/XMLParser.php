<?php

namespace PhpXmlRpc\Helper;

use PhpXmlRpc\PhpXmlRpc;
use PhpXmlRpc\Value;



class XMLParser
{
                                                            public $_xh = array(
        'ac' => '',
        'stack' => array(),
        'valuestack' => array(),
        'isf' => 0,
        'isf_reason' => '',
        'method' => false,         'params' => array(),
        'pt' => array(),
        'rt' => '',
    );

    public $xmlrpc_valid_parents = array(
        'VALUE' => array('MEMBER', 'DATA', 'PARAM', 'FAULT'),
        'BOOLEAN' => array('VALUE'),
        'I4' => array('VALUE'),
        'I8' => array('VALUE'),
        'EX:I8' => array('VALUE'),
        'INT' => array('VALUE'),
        'STRING' => array('VALUE'),
        'DOUBLE' => array('VALUE'),
        'DATETIME.ISO8601' => array('VALUE'),
        'BASE64' => array('VALUE'),
        'MEMBER' => array('STRUCT'),
        'NAME' => array('MEMBER'),
        'DATA' => array('ARRAY'),
        'ARRAY' => array('VALUE'),
        'STRUCT' => array('VALUE'),
        'PARAM' => array('PARAMS'),
        'METHODNAME' => array('METHODCALL'),
        'PARAMS' => array('METHODCALL', 'METHODRESPONSE'),
        'FAULT' => array('METHODRESPONSE'),
        'NIL' => array('VALUE'),         'EX:NIL' => array('VALUE'),     );

    
    public 
function xmlrpc_se($parser, $name, $attrs, $acceptSingleVals = false)
    {
                if ($this->_xh['isf'] < 2) {
                                                            if (count($this->_xh['stack']) == 0) {
                if ($name != 'METHODRESPONSE' && $name != 'METHODCALL' && (
                        $name != 'VALUE' && !$acceptSingleVals)
                ) {
                    $this->_xh['isf'] = 2;
                    $this->_xh['isf_reason'] = 'missing top level xmlrpc element';

                    return;
                } else {
                    $this->_xh['rt'] = strtolower($name);
                }
            } else {
                                $parent = end($this->_xh['stack']);
                if (!array_key_exists($name, $this->xmlrpc_valid_parents) || !in_array($parent, $this->xmlrpc_valid_parents[$name])) {
                    $this->_xh['isf'] = 2;
                    $this->_xh['isf_reason'] = "xmlrpc element $name cannot be child of $parent";

                    return;
                }
            }

            switch ($name) {
                                case 'VALUE':
                                        $this->_xh['vt'] = 'value';                     $this->_xh['ac'] = '';
                    $this->_xh['lv'] = 1;
                    $this->_xh['php_class'] = null;
                    break;
                case 'I8':
                case 'EX:I8':
                    if (PHP_INT_SIZE === 4) {
                                                $this->_xh['isf'] = 2;
                        $this->_xh['isf_reason'] = "Received i8 element but php is compiled in 32 bit mode";

                        return;
                    }
                                case 'I4':
                case 'INT':
                case 'STRING':
                case 'BOOLEAN':
                case 'DOUBLE':
                case 'DATETIME.ISO8601':
                case 'BASE64':
                    if ($this->_xh['vt'] != 'value') {
                                                $this->_xh['isf'] = 2;
                        $this->_xh['isf_reason'] = "$name element following a {$this->_xh['vt']} element inside a single value";

                        return;
                    }
                    $this->_xh['ac'] = '';                     break;
                case 'STRUCT':
                case 'ARRAY':
                    if ($this->_xh['vt'] != 'value') {
                                                $this->_xh['isf'] = 2;
                        $this->_xh['isf_reason'] = "$name element following a {$this->_xh['vt']} element inside a single value";

                        return;
                    }
                                        $curVal = array();
                    $curVal['values'] = array();
                    $curVal['type'] = $name;
                                                            if (@isset($attrs['PHP_CLASS'])) {
                        $curVal['php_class'] = $attrs['PHP_CLASS'];
                    }
                    $this->_xh['valuestack'][] = $curVal;
                    $this->_xh['vt'] = 'data';                     break;
                case 'DATA':
                    if ($this->_xh['vt'] != 'data') {
                                                $this->_xh['isf'] = 2;
                        $this->_xh['isf_reason'] = "found two data elements inside an array element";

                        return;
                    }
                case 'METHODCALL':
                case 'METHODRESPONSE':
                case 'PARAMS':
                                        break;
                case 'METHODNAME':
                case 'NAME':
                                        $this->_xh['ac'] = '';
                    break;
                case 'FAULT':
                    $this->_xh['isf'] = 1;
                    break;
                case 'MEMBER':
                    $this->_xh['valuestack'][count($this->_xh['valuestack']) - 1]['name'] = '';                                                     case 'PARAM':
                                        $this->_xh['vt'] = null;
                    break;
                case 'NIL':
                case 'EX:NIL':
                    if (PhpXmlRpc::$xmlrpc_null_extension) {
                        if ($this->_xh['vt'] != 'value') {
                                                        $this->_xh['isf'] = 2;
                            $this->_xh['isf_reason'] = "$name element following a {$this->_xh['vt']} element inside a single value";

                            return;
                        }
                        $this->_xh['ac'] = '';                         break;
                    }
                                                default:
                                        $this->_xh['isf'] = 2;
                    $this->_xh['isf_reason'] = "found not-xmlrpc xml element $name";
                    break;
            }

                        $this->_xh['stack'][] = $name;

                        if ($name != 'VALUE') {
                $this->_xh['lv'] = 0;
            }
        }
    }

    
    public 
function xmlrpc_se_any($parser, $name, $attrs)
    {
        $this->xmlrpc_se($parser, $name, $attrs, true);
    }

    
    public 
function xmlrpc_ee($parser, $name, $rebuildXmlrpcvals = true)
    {
        if ($this->_xh['isf'] < 2) {
                                                            $currElem = array_pop($this->_xh['stack']);

            switch ($name) {
                case 'VALUE':
                                        if ($this->_xh['vt'] == 'value') {
                        $this->_xh['value'] = $this->_xh['ac'];
                        $this->_xh['vt'] = Value::$xmlrpcString;
                    }

                    if ($rebuildXmlrpcvals) {
                                                $temp = new Value($this->_xh['value'], $this->_xh['vt']);
                                                                        if (isset($this->_xh['php_class'])) {
                            $temp->_php_class = $this->_xh['php_class'];
                        }
                                                                        $vscount = count($this->_xh['valuestack']);
                        if ($vscount && $this->_xh['valuestack'][$vscount - 1]['type'] == 'ARRAY') {
                            $this->_xh['valuestack'][$vscount - 1]['values'][] = $temp;
                        } else {
                            $this->_xh['value'] = $temp;
                        }
                    } else {
                                                                                                if (isset($this->_xh['php_class'])) {
                        }

                                                                        $vscount = count($this->_xh['valuestack']);
                        if ($vscount && $this->_xh['valuestack'][$vscount - 1]['type'] == 'ARRAY') {
                            $this->_xh['valuestack'][$vscount - 1]['values'][] = $this->_xh['value'];
                        }
                    }
                    break;
                case 'BOOLEAN':
                case 'I4':
                case 'I8':
                case 'EX:I8':
                case 'INT':
                case 'STRING':
                case 'DOUBLE':
                case 'DATETIME.ISO8601':
                case 'BASE64':
                    $this->_xh['vt'] = strtolower($name);
                                                            if ($name == 'STRING') {
                        $this->_xh['value'] = $this->_xh['ac'];
                    } elseif ($name == 'DATETIME.ISO8601') {
                        if (!preg_match('/^[0-9]{8}T[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $this->_xh['ac'])) {
                            error_log('XML-RPC: ' . __METHOD__ . ': invalid value received in DATETIME: ' . $this->_xh['ac']);
                        }
                        $this->_xh['vt'] = Value::$xmlrpcDateTime;
                        $this->_xh['value'] = $this->_xh['ac'];
                    } elseif ($name == 'BASE64') {
                                                $this->_xh['value'] = base64_decode($this->_xh['ac']);
                    } elseif ($name == 'BOOLEAN') {
                                                                                                                                                                        if ($this->_xh['ac'] == '1' || strcasecmp($this->_xh['ac'], 'true') == 0) {
                            $this->_xh['value'] = true;
                        } else {
                                                        if ($this->_xh['ac'] != '0' && strcasecmp($this->_xh['ac'], 'false') != 0) {
                                error_log('XML-RPC: ' . __METHOD__ . ': invalid value received in BOOLEAN: ' . $this->_xh['ac']);
                            }
                            $this->_xh['value'] = false;
                        }
                    } elseif ($name == 'DOUBLE') {
                                                                                                if (!preg_match('/^[+-eE0123456789 \t.]+$/', $this->_xh['ac'])) {
                                                        error_log('XML-RPC: ' . __METHOD__ . ': non numeric value received in DOUBLE: ' . $this->_xh['ac']);
                            $this->_xh['value'] = 'ERROR_NON_NUMERIC_FOUND';
                        } else {
                                                        $this->_xh['value'] = (double)$this->_xh['ac'];
                        }
                    } else {
                                                                        if (!preg_match('/^[+-]?[0123456789 \t]+$/', $this->_xh['ac'])) {
                                                        error_log('XML-RPC: ' . __METHOD__ . ': non numeric value received in INT: ' . $this->_xh['ac']);
                            $this->_xh['value'] = 'ERROR_NON_NUMERIC_FOUND';
                        } else {
                                                        $this->_xh['value'] = (int)$this->_xh['ac'];
                        }
                    }
                    $this->_xh['lv'] = 3;                     break;
                case 'NAME':
                    $this->_xh['valuestack'][count($this->_xh['valuestack']) - 1]['name'] = $this->_xh['ac'];
                    break;
                case 'MEMBER':
                                                            if ($this->_xh['vt']) {
                        $vscount = count($this->_xh['valuestack']);
                        $this->_xh['valuestack'][$vscount - 1]['values'][$this->_xh['valuestack'][$vscount - 1]['name']] = $this->_xh['value'];
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': missing VALUE inside STRUCT in received xml');
                    }
                    break;
                case 'DATA':
                    $this->_xh['vt'] = null;                     break;
                case 'STRUCT':
                case 'ARRAY':
                                        $currVal = array_pop($this->_xh['valuestack']);
                    $this->_xh['value'] = $currVal['values'];
                    $this->_xh['vt'] = strtolower($name);
                    if (isset($currVal['php_class'])) {
                        $this->_xh['php_class'] = $currVal['php_class'];
                    }
                    break;
                case 'PARAM':
                                                            if ($this->_xh['vt']) {
                        $this->_xh['params'][] = $this->_xh['value'];
                        $this->_xh['pt'][] = $this->_xh['vt'];
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': missing VALUE inside PARAM in received xml');
                    }
                    break;
                case 'METHODNAME':
                    $this->_xh['method'] = preg_replace('/^[\n\r\t ]+/', '', $this->_xh['ac']);
                    break;
                case 'NIL':
                case 'EX:NIL':
                    if (PhpXmlRpc::$xmlrpc_null_extension) {
                        $this->_xh['vt'] = 'null';
                        $this->_xh['value'] = null;
                        $this->_xh['lv'] = 3;
                        break;
                    }
                                case 'PARAMS':
                case 'FAULT':
                case 'METHODCALL':
                case 'METHORESPONSE':
                    break;
                default:
                                                            break;
            }
        }
    }

    
    public 
function xmlrpc_ee_fast($parser, $name)
    {
        $this->xmlrpc_ee($parser, $name, false);
    }

    
    public 
function xmlrpc_cd($parser, $data)
    {
                if ($this->_xh['isf'] < 2) {
                                    if ($this->_xh['lv'] != 3) {
                $this->_xh['ac'] .= $data;
            }
        }
    }

    
    public 
function xmlrpc_dh($parser, $data)
    {
                if ($this->_xh['isf'] < 2) {
            if (substr($data, 0, 1) == '&' && substr($data, -1, 1) == ';') {
                $this->_xh['ac'] .= $data;
            }
        }

        return true;
    }

    
    public static 
function guessEncoding($httpHeader = '', $xmlChunk = '', $encodingPrefs = null)
    {
                
                                                                                
                $matches = array();
        if (preg_match('/;\s*charset\s*=([^;]+)/i', $httpHeader, $matches)) {
            return strtoupper(trim($matches[1], " \t\""));
        }

                                                                if (preg_match('/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\x00\x00\xFF\xFE|\xFE\xFF\x00\x00)/', $xmlChunk)) {
            return 'UCS-4';
        } elseif (preg_match('/^(\xFE\xFF|\xFF\xFE)/', $xmlChunk)) {
            return 'UTF-16';
        } elseif (preg_match('/^(\xEF\xBB\xBF)/', $xmlChunk)) {
            return 'UTF-8';
        }

                                        if (preg_match('/^<\?xml\s+version\s*=\s*' . "((?:\"[a-zA-Z0-9_.:-]+\")|(?:'[a-zA-Z0-9_.:-]+'))" .
            '\s+encoding\s*=\s*' . "((?:\"[A-Za-z][A-Za-z0-9._-]*\")|(?:'[A-Za-z][A-Za-z0-9._-]*'))/",
            $xmlChunk, $matches)) {
            return strtoupper(substr($matches[2], 1, -1));
        }

                if (extension_loaded('mbstring')) {
            if ($encodingPrefs == null && PhpXmlRpc::$xmlrpc_detectencodings != null) {
                $encodingPrefs = PhpXmlRpc::$xmlrpc_detectencodings;
            }
            if ($encodingPrefs) {
                $enc = mb_detect_encoding($xmlChunk, $encodingPrefs);
            } else {
                $enc = mb_detect_encoding($xmlChunk);
            }
                                    if ($enc == 'ASCII') {
                $enc = 'US-' . $enc;
            }

            return $enc;
        } else {
                                                            return PhpXmlRpc::$xmlrpc_defencoding;
        }
    }

    
    public static 
function hasEncoding($xmlChunk)
    {
                        if (preg_match('/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\x00\x00\xFF\xFE|\xFE\xFF\x00\x00)/', $xmlChunk)) {
            return true;
        } elseif (preg_match('/^(\xFE\xFF|\xFF\xFE)/', $xmlChunk)) {
            return true;
        } elseif (preg_match('/^(\xEF\xBB\xBF)/', $xmlChunk)) {
            return true;
        }

                                        if (preg_match('/^<\?xml\s+version\s*=\s*' . "((?:\"[a-zA-Z0-9_.:-]+\")|(?:'[a-zA-Z0-9_.:-]+'))" .
            '\s+encoding\s*=\s*' . "((?:\"[A-Za-z][A-Za-z0-9._-]*\")|(?:'[A-Za-z][A-Za-z0-9._-]*'))/",
            $xmlChunk, $matches)) {
            return true;
        }

        return false;
    }
}
