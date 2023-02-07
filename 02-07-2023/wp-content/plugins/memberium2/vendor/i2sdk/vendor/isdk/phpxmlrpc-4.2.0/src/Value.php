<?php

namespace PhpXmlRpc;

use PhpXmlRpc\Helper\Charset;



class Value implements \Countable, \IteratorAggregate, \ArrayAccess
{
    public static $xmlrpcI4 = "i4";
    public static $xmlrpcI8 = "i8";
    public static $xmlrpcInt = "int";
    public static $xmlrpcBoolean = "boolean";
    public static $xmlrpcDouble = "double";
    public static $xmlrpcString = "string";
    public static $xmlrpcDateTime = "dateTime.iso8601";
    public static $xmlrpcBase64 = "base64";
    public static $xmlrpcArray = "array";
    public static $xmlrpcStruct = "struct";
    public static $xmlrpcValue = "undefined";
    public static $xmlrpcNull = "null";

    public static $xmlrpcTypes = array(
        "i4" => 1,
        "i8" => 1,
        "int" => 1,
        "boolean" => 1,
        "double" => 1,
        "string" => 1,
        "dateTime.iso8601" => 1,
        "base64" => 1,
        "array" => 2,
        "struct" => 3,
        "null" => 1,
    );

        public $me = array();
    public $mytype = 0;
    public $_php_class = null;

    
    public 
function __construct($val = -1, $type = '')
    {
                        if ($val !== -1 || $type != '') {
            switch ($type) {
                case '':
                    $this->mytype = 1;
                    $this->me['string'] = $val;
                    break;
                case 'i4':
                case 'i8':
                case 'int':
                case 'double':
                case 'string':
                case 'boolean':
                case 'dateTime.iso8601':
                case 'base64':
                case 'null':
                    $this->mytype = 1;
                    $this->me[$type] = $val;
                    break;
                case 'array':
                    $this->mytype = 2;
                    $this->me['array'] = $val;
                    break;
                case 'struct':
                    $this->mytype = 3;
                    $this->me['struct'] = $val;
                    break;
                default:
                    error_log("XML-RPC: " . __METHOD__ . ": not a known type ($type)");
            }
        }
    }

    
    public 
function addScalar($val, $type = 'string')
    {
        $typeOf = null;
        if (isset(static::$xmlrpcTypes[$type])) {
            $typeOf = static::$xmlrpcTypes[$type];
        }

        if ($typeOf !== 1) {
            error_log("XML-RPC: " . __METHOD__ . ": not a scalar type ($type)");
            return 0;
        }

                                if ($type == static::$xmlrpcBoolean) {
            if (strcasecmp($val, 'true') == 0 || $val == 1 || ($val == true && strcasecmp($val, 'false'))) {
                $val = true;
            } else {
                $val = false;
            }
        }

        switch ($this->mytype) {
            case 1:
                error_log('XML-RPC: ' . __METHOD__ . ': scalar xmlrpc value can have only one value');
                return 0;
            case 3:
                error_log('XML-RPC: ' . __METHOD__ . ': cannot add anonymous scalar to struct xmlrpc value');
                return 0;
            case 2:
                                $this->me['array'][] = new Value($val, $type);

                return 1;
            default:
                                $this->me[$type] = $val;
                $this->mytype = $typeOf;

                return 1;
        }
    }

    
    public 
function addArray($values)
    {
        if ($this->mytype == 0) {
            $this->mytype = static::$xmlrpcTypes['array'];
            $this->me['array'] = $values;

            return 1;
        } elseif ($this->mytype == 2) {
                        $this->me['array'] = array_merge($this->me['array'], $values);

            return 1;
        } else {
            error_log('XML-RPC: ' . __METHOD__ . ': already initialized as a [' . $this->kindOf() . ']');
            return 0;
        }
    }

    
    public 
function addStruct($values)
    {
        if ($this->mytype == 0) {
            $this->mytype = static::$xmlrpcTypes['struct'];
            $this->me['struct'] = $values;

            return 1;
        } elseif ($this->mytype == 3) {
                        $this->me['struct'] = array_merge($this->me['struct'], $values);

            return 1;
        } else {
            error_log('XML-RPC: ' . __METHOD__ . ': already initialized as a [' . $this->kindOf() . ']');
            return 0;
        }
    }

    
    public 
function kindOf()
    {
        switch ($this->mytype) {
            case 3:
                return 'struct';
                break;
            case 2:
                return 'array';
                break;
            case 1:
                return 'scalar';
                break;
            default:
                return 'undef';
        }
    }

    protected 
function serializedata($typ, $val, $charsetEncoding = '')
    {
        $rs = '';

        if (!isset(static::$xmlrpcTypes[$typ])) {
            return $rs;
        }

        switch (static::$xmlrpcTypes[$typ]) {
            case 1:
                switch ($typ) {
                    case static::$xmlrpcBase64:
                        $rs .= "<${typ}>" . base64_encode($val) . "</${typ}>";
                        break;
                    case static::$xmlrpcBoolean:
                        $rs .= "<${typ}>" . ($val ? '1' : '0') . "</${typ}>";
                        break;
                    case static::$xmlrpcString:
                                                                        $rs .= "<${typ}>" . Charset::instance()->encodeEntities($val, PhpXmlRpc::$xmlrpc_internalencoding, $charsetEncoding) . "</${typ}>";
                        break;
                    case static::$xmlrpcInt:
                    case static::$xmlrpcI4:
                    case static::$xmlrpcI8:
                        $rs .= "<${typ}>" . (int)$val . "</${typ}>";
                        break;
                    case static::$xmlrpcDouble:
                                                                                                                                                $rs .= "<${typ}>" . preg_replace('/\\.?0+$/', '', number_format((double)$val, 128, '.', '')) . "</${typ}>";
                        break;
                    case static::$xmlrpcDateTime:
                        if (is_string($val)) {
                            $rs .= "<${typ}>${val}</${typ}>";
                        } elseif (is_a($val, 'DateTime')) {
                            $rs .= "<${typ}>" . $val->format('Ymd\TH:i:s') . "</${typ}>";
                        } elseif (is_int($val)) {
                            $rs .= "<${typ}>" . strftime("%Y%m%dT%H:%M:%S", $val) . "</${typ}>";
                        } else {
                                                        $rs .= "<${typ}>${val}</${typ}>";
                        }
                        break;
                    case static::$xmlrpcNull:
                        if (PhpXmlRpc::$xmlrpc_null_apache_encoding) {
                            $rs .= "<ex:nil/>";
                        } else {
                            $rs .= "<nil/>";
                        }
                        break;
                    default:
                                                                        $rs .= "<${typ}>${val}</${typ}>";
                }
                break;
            case 3:
                                if ($this->_php_class) {
                    $rs .= '<struct php_class="' . $this->_php_class . "\">\n";
                } else {
                    $rs .= "<struct>\n";
                }
                $charsetEncoder = Charset::instance();
                foreach ($val as $key2 => $val2) {
                    $rs .= '<member><name>' . $charsetEncoder->encodeEntities($key2, PhpXmlRpc::$xmlrpc_internalencoding, $charsetEncoding) . "</name>\n";
                                        $rs .= $val2->serialize($charsetEncoding);
                    $rs .= "</member>\n";
                }
                $rs .= '</struct>';
                break;
            case 2:
                                $rs .= "<array>\n<data>\n";
                foreach ($val as $element) {
                                        $rs .= $element->serialize($charsetEncoding);
                }
                $rs .= "</data>\n</array>";
                break;
            default:
                break;
        }

        return $rs;
    }

    
    public 
function serialize($charsetEncoding = '')
    {
                
		$val = reset($this->me);
		$typ = key($this->me);

        return '<value>' . $this->serializedata($typ, $val, $charsetEncoding) . "</value>\n";
    }

    
    public 
function structmemexists($key)
    {
        return array_key_exists($key, $this->me['struct']);
    }

    
    public 
function structmem($key)
    {
        return $this->me['struct'][$key];
    }

    
    public 
function structreset()
    {
        reset($this->me['struct']);
    }

    
    public 
function structeach()
    {
        return each($this->me['struct']);
    }

    
    public 
function scalarval()
    {
        reset($this->me);
        list(, $b) = each($this->me);

        return $b;
    }

    
    public 
function scalartyp()
    {
        reset($this->me);
        list($a,) = each($this->me);
        if ($a == static::$xmlrpcI4) {
            $a = static::$xmlrpcInt;
        }

        return $a;
    }

    
    public 
function arraymem($key)
    {
        return $this->me['array'][$key];
    }

    
    public 
function arraysize()
    {
        return count($this->me['array']);
    }

    
    public 
function structsize()
    {
        return count($this->me['struct']);
    }

    
    public 
function count()
    {
        switch ($this->mytype) {
            case 3:
                return count($this->me['struct']);
            case 2:
                return count($this->me['array']);
            case 1:
                return 1;
            default:
                return 0;
        }
    }

    
    public 
function getIterator() {
        switch ($this->mytype) {
            case 3:
                return new \ArrayIterator($this->me['struct']);
            case 2:
                return new \ArrayIterator($this->me['array']);
            case 1:
                return new \ArrayIterator($this->me);
            default:
                return new \ArrayIterator();
        }
        return new \ArrayIterator();
    }

    public 
function offsetSet($offset, $value) {

        switch ($this->mytype) {
            case 3:
                if (!($value instanceof \PhpXmlRpc\Value)) {
                    throw new \Exception('It is only possible to add Value objects to an XML-RPC Struct');
                }
                if (is_null($offset)) {
                                        throw new \Exception('It is not possible to add anonymous members to an XML-RPC Struct');
                } else {
                    $this->me['struct'][$offset] = $value;
                }
                return;
            case 2:
                if (!($value instanceof \PhpXmlRpc\Value)) {
                    throw new \Exception('It is only possible to add Value objects to an XML-RPC Array');
                }
                if (is_null($offset)) {
                    $this->me['array'][] = $value;
                } else {
                                        $this->me['array'][$offset] = $value;
                }
                return;
            case 1:
                reset($this->me);
                list($type,) = each($this->me);
                if ($type != $offset) {
                    throw new \Exception('');
                }
                $this->me[$type] = $value;
                return;
            default:
                                throw new \Exception("XML-RPC Value is of type 'undef' and its value can not be set using array index");
        }
    }

    public 
function offsetExists($offset) {
        switch ($this->mytype) {
            case 3:
                return isset($this->me['struct'][$offset]);
            case 2:
                return isset($this->me['array'][$offset]);
            case 1:
                return $offset == $this->scalartyp();
            default:
                return false;
        }
    }

    public 
function offsetUnset($offset) {
        switch ($this->mytype) {
            case 3:
                unset($this->me['struct'][$offset]);
                return;
            case 2:
                unset($this->me['array'][$offset]);
                return;
            case 1:
                                throw new \Exception("XML-RPC Value is of type 'scalar' and its value can not be unset using array index");
            default:
                throw new \Exception("XML-RPC Value is of type 'undef' and its value can not be unset using array index");
        }
    }

    public 
function offsetGet($offset) {
        switch ($this->mytype) {
            case 3:
                return isset($this->me['struct'][$offset]) ? $this->me['struct'][$offset] : null;
            case 2:
                return isset($this->me['array'][$offset]) ? $this->me['array'][$offset] : null;
            case 1:
                reset($this->me);
                list($type, $value) = each($this->me);
                return $type == $offset ? $value : null;
            default:
                throw new \Exception("XML-RPC Value is of type 'undef' and can not be accessed using array index");
        }
    }
}
