<?php

namespace PhpXmlRpc;

use PhpXmlRpc\Helper\XMLParser;
use PhpXmlRpc\Helper\Charset;



class Server
{
    
    protected $dmap = array();

    
    public $functions_parameters_type = 'xmlrpcvals';

    
    public $phpvals_encoding_options = array('auto_dates');

    
    public $debug = 1;

    
    public $exception_handling = 0;

    
    public $compress_response = false;

    
    public $accepted_compression = array();

        public $allow_system_funcs = true;

    
    public $accepted_charset_encodings = array();

    
    public $response_charset_encoding = '';

    
    protected $debug_info = '';

    
    public $user_data = null;

    protected static $_xmlrpc_debuginfo = '';
    protected static $_xmlrpcs_occurred_errors = '';
    protected static $_xmlrpcs_prev_ehandler = '';

    
    public 
function __construct($dispatchMap = null, $serviceNow = true)
    {
                        if (function_exists('gzinflate')) {
            $this->accepted_compression = array('gzip', 'deflate');
            $this->compress_response = true;
        }

                $this->accepted_charset_encodings = array('UTF-8', 'ISO-8859-1', 'US-ASCII');

                        
        if ($dispatchMap) {
            $this->dmap = $dispatchMap;
            if ($serviceNow) {
                $this->service();
            }
        }
    }

    
    public 
function setDebug($level)
    {
        $this->debug = $level;
    }

    
    public static 
function xmlrpc_debugmsg($msg)
    {
        static::$_xmlrpc_debuginfo .= $msg . "\n";
    }

    public static 
function error_occurred($msg)
    {
        static::$_xmlrpcs_occurred_errors .= $msg . "\n";
    }

    
    public 
function serializeDebug($charsetEncoding = '')
    {
                                                $out = '';
        if ($this->debug_info != '') {
            $out .= "<!-- SERVER DEBUG INFO (BASE64 ENCODED):\n" . base64_encode($this->debug_info) . "\n-->\n";
        }
        if (static::$_xmlrpc_debuginfo != '') {
            $out .= "<!-- DEBUG INFO:\n" . Charset::instance()->encodeEntities(str_replace('--', '_-', static::$_xmlrpc_debuginfo), PhpXmlRpc::$xmlrpc_internalencoding, $charsetEncoding) . "\n-->\n";
                                            }

        return $out;
    }

    
    public 
function service($data = null, $returnPayload = false)
    {
        if ($data === null) {
            $data = file_get_contents('php://input');
        }
        $rawData = $data;

                $this->debug_info = '';

                if ($this->debug > 1) {
            $this->debugmsg("+++GOT+++\n" . $data . "\n+++END+++");
        }

        $r = $this->parseRequestHeaders($data, $reqCharset, $respCharset, $respEncoding);
        if (!$r) {
                        $r = $this->parseRequest($data, $reqCharset);
        }

                $r->raw_data = $rawData;

        if ($this->debug > 2 && static::$_xmlrpcs_occurred_errors) {
            $this->debugmsg("+++PROCESSING ERRORS AND WARNINGS+++\n" .
                static::$_xmlrpcs_occurred_errors . "+++END+++");
        }

        $payload = $this->xml_header($respCharset);
        if ($this->debug > 0) {
            $payload = $payload . $this->serializeDebug($respCharset);
        }

                        if (empty($r->payload)) {
            $r->serialize($respCharset);
        }
        $payload = $payload . $r->payload;

        if ($returnPayload) {
            return $payload;
        }

                        if (!headers_sent()) {
            header('Content-Type: ' . $r->content_type);
                                    header("Vary: Accept-Charset");

                                                $phpNoSelfCompress = !ini_get('zlib.output_compression') && (ini_get('output_handler') != 'ob_gzhandler');
            if ($this->compress_response && function_exists('gzencode') && $respEncoding != ''
                && $phpNoSelfCompress
            ) {
                if (strpos($respEncoding, 'gzip') !== false) {
                    $payload = gzencode($payload);
                    header("Content-Encoding: gzip");
                    header("Vary: Accept-Encoding");
                } elseif (strpos($respEncoding, 'deflate') !== false) {
                    $payload = gzcompress($payload);
                    header("Content-Encoding: deflate");
                    header("Vary: Accept-Encoding");
                }
            }

                                    if ($phpNoSelfCompress) {
                header('Content-Length: ' . (int)strlen($payload));
            }
        } else {
            error_log('XML-RPC: ' . __METHOD__ . ': http headers already sent before response is fully generated. Check for php warning or error messages');
        }

        print $payload;

                return $r;
    }

    
    public 
function add_to_map($methodName, $function, $sig = null, $doc = false, $sigDoc = false)
    {
        $this->dmap[$methodName] = array(
            'function' => $function,
            'docstring' => $doc,
        );
        if ($sig) {
            $this->dmap[$methodName]['signature'] = $sig;
        }
        if ($sigDoc) {
            $this->dmap[$methodName]['signature_docs'] = $sigDoc;
        }
    }

    
    protected 
function verifySignature($in, $sigs)
    {
                if (is_object($in)) {
            $numParams = $in->getNumParams();
        } else {
            $numParams = count($in);
        }
        foreach ($sigs as $curSig) {
            if (count($curSig) == $numParams + 1) {
                $itsOK = 1;
                for ($n = 0; $n < $numParams; $n++) {
                    if (is_object($in)) {
                        $p = $in->getParam($n);
                        if ($p->kindOf() == 'scalar') {
                            $pt = $p->scalartyp();
                        } else {
                            $pt = $p->kindOf();
                        }
                    } else {
                        $pt = ($in[$n] == 'i4') ? 'int' : strtolower($in[$n]);                     }

                                        if ($pt != $curSig[$n + 1] && $curSig[$n + 1] != Value::$xmlrpcValue) {
                        $itsOK = 0;
                        $pno = $n + 1;
                        $wanted = $curSig[$n + 1];
                        $got = $pt;
                        break;
                    }
                }
                if ($itsOK) {
                    return array(1, '');
                }
            }
        }
        if (isset($wanted)) {
            return array(0, "Wanted ${wanted}, got ${got} at param ${pno}");
        } else {
            return array(0, "No method signature matches number of parameters");
        }
    }

    
    protected 
function parseRequestHeaders(&$data, &$reqEncoding, &$respEncoding, &$respCompression)
    {
                        if (count($_SERVER) == 0) {
            error_log('XML-RPC: ' . __METHOD__ . ': cannot parse request headers as $_SERVER is not populated');
        }

        if ($this->debug > 1) {
            if (function_exists('getallheaders')) {
                $this->debugmsg('');                 foreach (getallheaders() as $name => $val) {
                    $this->debugmsg("HEADER: $name: $val");
                }
            }
        }

        if (isset($_SERVER['HTTP_CONTENT_ENCODING'])) {
            $contentEncoding = str_replace('x-', '', $_SERVER['HTTP_CONTENT_ENCODING']);
        } else {
            $contentEncoding = '';
        }

                if ($contentEncoding != '' && strlen($data)) {
            if ($contentEncoding == 'deflate' || $contentEncoding == 'gzip') {
                                if (function_exists('gzinflate') && in_array($contentEncoding, $this->accepted_compression)) {
                    if ($contentEncoding == 'deflate' && $degzdata = @gzuncompress($data)) {
                        $data = $degzdata;
                        if ($this->debug > 1) {
                            $this->debugmsg("\n+++INFLATED REQUEST+++[" . strlen($data) . " chars]+++\n" . $data . "\n+++END+++");
                        }
                    } elseif ($contentEncoding == 'gzip' && $degzdata = @gzinflate(substr($data, 10))) {
                        $data = $degzdata;
                        if ($this->debug > 1) {
                            $this->debugmsg("+++INFLATED REQUEST+++[" . strlen($data) . " chars]+++\n" . $data . "\n+++END+++");
                        }
                    } else {
                        $r = new Response(0, PhpXmlRpc::$xmlrpcerr['server_decompress_fail'], PhpXmlRpc::$xmlrpcstr['server_decompress_fail']);

                        return $r;
                    }
                } else {
                    $r = new Response(0, PhpXmlRpc::$xmlrpcerr['server_cannot_decompress'], PhpXmlRpc::$xmlrpcstr['server_cannot_decompress']);

                    return $r;
                }
            }
        }

                        if ($this->response_charset_encoding == 'auto') {
            $respEncoding = '';
            if (isset($_SERVER['HTTP_ACCEPT_CHARSET'])) {
                                                                $clientAcceptedCharsets = explode(',', strtoupper($_SERVER['HTTP_ACCEPT_CHARSET']));
                                $knownCharsets = array(PhpXmlRpc::$xmlrpc_internalencoding, 'UTF-8', 'ISO-8859-1', 'US-ASCII');
                foreach ($knownCharsets as $charset) {
                    foreach ($clientAcceptedCharsets as $accepted) {
                        if (strpos($accepted, $charset) === 0) {
                            $respEncoding = $charset;
                            break;
                        }
                    }
                    if ($respEncoding) {
                        break;
                    }
                }
            }
        } else {
            $respEncoding = $this->response_charset_encoding;
        }

        if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $respCompression = $_SERVER['HTTP_ACCEPT_ENCODING'];
        } else {
            $respCompression = '';
        }

                        $reqEncoding = XMLParser::guessEncoding(isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '',
            $data);

        return;
    }

    
    public 
function parseRequest($data, $reqEncoding = '')
    {
        
        if ($reqEncoding != '') {
                                                                        if (!in_array($reqEncoding, array('UTF-8', 'US-ASCII')) && !XMLParser::hasEncoding($data)) {
                if ($reqEncoding == 'ISO-8859-1') {
                    $data = utf8_encode($data);
                } else {
                    if (extension_loaded('mbstring')) {
                        $data = mb_convert_encoding($data, 'UTF-8', $reqEncoding);
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': invalid charset encoding of received request: ' . $reqEncoding);
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

        if ($this->functions_parameters_type != 'xmlrpcvals') {
            xml_set_element_handler($parser, 'xmlrpc_se', 'xmlrpc_ee_fast');
        } else {
            xml_set_element_handler($parser, 'xmlrpc_se', 'xmlrpc_ee');
        }
        xml_set_character_data_handler($parser, 'xmlrpc_cd');
        xml_set_default_handler($parser, 'xmlrpc_dh');
        if (!xml_parse($parser, $data, 1)) {
                        $r = new Response(0,
                PhpXmlRpc::$xmlrpcerrxml + xml_get_error_code($parser),
                sprintf('XML error: %s at line %d, column %d',
                    xml_error_string(xml_get_error_code($parser)),
                    xml_get_current_line_number($parser), xml_get_current_column_number($parser)));
            xml_parser_free($parser);
        } elseif ($xmlRpcParser->_xh['isf']) {
            xml_parser_free($parser);
            $r = new Response(0,
                PhpXmlRpc::$xmlrpcerr['invalid_request'],
                PhpXmlRpc::$xmlrpcstr['invalid_request'] . ' ' . $xmlRpcParser->_xh['isf_reason']);
        } else {
            xml_parser_free($parser);
                                                            if ($this->functions_parameters_type != 'xmlrpcvals' || (isset($this->dmap[$xmlRpcParser->_xh['method']]['parameters_type']) && ($this->dmap[$xmlRpcParser->_xh['method']]['parameters_type'] == 'phpvals'))) {
                if ($this->debug > 1) {
                    $this->debugmsg("\n+++PARSED+++\n" . var_export($xmlRpcParser->_xh['params'], true) . "\n+++END+++");
                }
                $r = $this->execute($xmlRpcParser->_xh['method'], $xmlRpcParser->_xh['params'], $xmlRpcParser->_xh['pt']);
            } else {
                                $req = new Request($xmlRpcParser->_xh['method']);
                                for ($i = 0; $i < count($xmlRpcParser->_xh['params']); $i++) {
                    $req->addParam($xmlRpcParser->_xh['params'][$i]);
                }

                if ($this->debug > 1) {
                    $this->debugmsg("\n+++PARSED+++\n" . var_export($req, true) . "\n+++END+++");
                }
                $r = $this->execute($req);
            }
        }

        return $r;
    }

    
    protected 
function execute($req, $params = null, $paramTypes = null)
    {
        static::$_xmlrpcs_occurred_errors = '';
        static::$_xmlrpc_debuginfo = '';

        if (is_object($req)) {
            $methName = $req->method();
        } else {
            $methName = $req;
        }
        $sysCall = $this->allow_system_funcs && (strpos($methName, "system.") === 0);
        $dmap = $sysCall ? $this->getSystemDispatchMap() : $this->dmap;

        if (!isset($dmap[$methName]['function'])) {
                        return new Response(0,
                PhpXmlRpc::$xmlrpcerr['unknown_method'],
                PhpXmlRpc::$xmlrpcstr['unknown_method']);
        }

                if (isset($dmap[$methName]['signature'])) {
            $sig = $dmap[$methName]['signature'];
            if (is_object($req)) {
                list($ok, $errStr) = $this->verifySignature($req, $sig);
            } else {
                list($ok, $errStr) = $this->verifySignature($paramTypes, $sig);
            }
            if (!$ok) {
                                return new Response(
                    0,
                    PhpXmlRpc::$xmlrpcerr['incorrect_params'],
                    PhpXmlRpc::$xmlrpcstr['incorrect_params'] . ": ${errStr}"
                );
            }
        }

        $func = $dmap[$methName]['function'];
                if (is_string($func) && strpos($func, '::')) {
            $func = explode('::', $func);
        }

        if (is_array($func)) {
            if (is_object($func[0])) {
                $funcName = get_class($func[0]) . '->' . $func[1];
            } else {
                $funcName = implode('::', $func);
            }
        } else if ($func instanceof \Closure) {
            $funcName = 'Closure';
        } else {
            $funcName = $func;
        }

                if (!is_callable($func)) {
            error_log("XML-RPC: " . __METHOD__ . ": function '$funcName' registered as method handler is not callable");
            return new Response(
                0,
                PhpXmlRpc::$xmlrpcerr['server_error'],
                PhpXmlRpc::$xmlrpcstr['server_error'] . ": no function matches method"
            );
        }

                        if ($this->debug > 2) {
            self::$_xmlrpcs_prev_ehandler = set_error_handler(array('\PhpXmlRpc\Server', '_xmlrpcs_errorHandler'));
        }

        try {
                        if (is_object($req)) {
                if ($sysCall) {
                    $r = call_user_func($func, $this, $req);
                } else {
                    $r = call_user_func($func, $req);
                }
                if (!is_a($r, 'PhpXmlRpc\Response')) {
                    error_log("XML-RPC: " . __METHOD__ . ": function '$funcName' registered as method handler does not return an xmlrpc response object but a " . gettype($r));
                    if (is_a($r, 'PhpXmlRpc\Value')) {
                        $r = new Response($r);
                    } else {
                        $r = new Response(
                            0,
                            PhpXmlRpc::$xmlrpcerr['server_error'],
                            PhpXmlRpc::$xmlrpcstr['server_error'] . ": function does not return xmlrpc response object"
                        );
                    }
                }
            } else {
                                if ($sysCall) {
                    array_unshift($params, $this);
                    $r = call_user_func_array($func, $params);
                } else {
                                        if ($this->functions_parameters_type == 'epivals') {
                        $r = call_user_func_array($func, array($methName, $params, $this->user_data));
                                                                        if (is_array($r) && array_key_exists('faultCode', $r) && array_key_exists('faultString', $r)) {
                            $r = new Response(0, (integer)$r['faultCode'], (string)$r['faultString']);
                        } else {
                                                                                    $encoder = new Encoder();
                            $r = new Response($encoder->encode($r, array('extension_api')));
                        }
                    } else {
                        $r = call_user_func_array($func, $params);
                    }
                }
                                if (!is_a($r, '\PhpXmlRpc\Response')) {
                                                            $encoder = new Encoder();
                    $r = new Response($encoder->encode($r, $this->phpvals_encoding_options));
                }
            }
        } catch (\Exception $e) {
                                    switch ($this->exception_handling) {
                case 2:
                    if ($this->debug > 2) {
                        if (self::$_xmlrpcs_prev_ehandler) {
                            set_error_handler(self::$_xmlrpcs_prev_ehandler);
                        } else {
                            restore_error_handler();
                        }
                    }
                    throw $e;
                    break;
                case 1:
                    $r = new Response(0, $e->getCode(), $e->getMessage());
                    break;
                default:
                    $r = new Response(0, PhpXmlRpc::$xmlrpcerr['server_error'], PhpXmlRpc::$xmlrpcstr['server_error']);
            }
        }
        if ($this->debug > 2) {
                                    if (self::$_xmlrpcs_prev_ehandler) {
                set_error_handler(self::$_xmlrpcs_prev_ehandler);
            } else {
                restore_error_handler();
            }
        }

        return $r;
    }

    
    protected 
function debugmsg($string)
    {
        $this->debug_info .= $string . "\n";
    }

    
    protected 
function xml_header($charsetEncoding = '')
    {
        if ($charsetEncoding != '') {
            return "<?xml version=\"1.0\" encoding=\"$charsetEncoding\"?" . ">\n";
        } else {
            return "<?xml version=\"1.0\"?" . ">\n";
        }
    }

    

    
    public 
function getSystemDispatchMap()
    {
        return array(
            'system.listMethods' => array(
                'function' => 'PhpXmlRpc\Server::_xmlrpcs_listMethods',
                                                'signature' => array(array(Value::$xmlrpcArray)),
                'docstring' => 'This method lists all the methods that the XML-RPC server knows how to dispatch',
                'signature_docs' => array(array('list of method names')),
            ),
            'system.methodHelp' => array(
                'function' => 'PhpXmlRpc\Server::_xmlrpcs_methodHelp',
                'signature' => array(array(Value::$xmlrpcString, Value::$xmlrpcString)),
                'docstring' => 'Returns help text if defined for the method passed, otherwise returns an empty string',
                'signature_docs' => array(array('method description', 'name of the method to be described')),
            ),
            'system.methodSignature' => array(
                'function' => 'PhpXmlRpc\Server::_xmlrpcs_methodSignature',
                'signature' => array(array(Value::$xmlrpcArray, Value::$xmlrpcString)),
                'docstring' => 'Returns an array of known signatures (an array of arrays) for the method name passed. If no signatures are known, returns a none-array (test for type != array to detect missing signature)',
                'signature_docs' => array(array('list of known signatures, each sig being an array of xmlrpc type names', 'name of method to be described')),
            ),
            'system.multicall' => array(
                'function' => 'PhpXmlRpc\Server::_xmlrpcs_multicall',
                'signature' => array(array(Value::$xmlrpcArray, Value::$xmlrpcArray)),
                'docstring' => 'Boxcar multiple RPC calls in one request. See http://www.xmlrpc.com/discuss/msgReader$1208 for details',
                'signature_docs' => array(array('list of response structs, where each struct has the usual members', 'list of calls, with each call being represented as a struct, with members "methodname" and "params"')),
            ),
            'system.getCapabilities' => array(
                'function' => 'PhpXmlRpc\Server::_xmlrpcs_getCapabilities',
                'signature' => array(array(Value::$xmlrpcStruct)),
                'docstring' => 'This method lists all the capabilites that the XML-RPC server has: the (more or less standard) extensions to the xmlrpc spec that it adheres to',
                'signature_docs' => array(array('list of capabilities, described as structs with a version number and url for the spec')),
            ),
        );
    }

    
    public 
function getCapabilities()
    {
        $outAr = array(
                        'xmlrpc' => array(
                'specUrl' => 'http://www.xmlrpc.com/spec',
                'specVersion' => 1
            ),
                                    'system.multicall' => array(
                'specUrl' => 'http://www.xmlrpc.com/discuss/msgReader$1208',
                'specVersion' => 1
            ),
                        'introspection' => array(
                'specUrl' => 'http://phpxmlrpc.sourceforge.net/doc-2/ch10.html',
                'specVersion' => 2,
            ),
        );

                if (PhpXmlRpc::$xmlrpc_null_extension) {
            $outAr['nil'] = array(
                'specUrl' => 'http://www.ontosys.com/xml-rpc/extensions.php',
                'specVersion' => 1
            );
        }

        return $outAr;
    }

    public static 
function _xmlrpcs_getCapabilities($server, $req = null)
    {
        $encoder = new Encoder();
        return new Response($encoder->encode($server->getCapabilities()));
    }

    public static 
function _xmlrpcs_listMethods($server, $req = null)     {
        $outAr = array();
        foreach ($server->dmap as $key => $val) {
            $outAr[] = new Value($key, 'string');
        }
        if ($server->allow_system_funcs) {
            foreach ($server->getSystemDispatchMap() as $key => $val) {
                $outAr[] = new Value($key, 'string');
            }
        }

        return new Response(new Value($outAr, 'array'));
    }

    public static 
function _xmlrpcs_methodSignature($server, $req)
    {
                if (is_object($req)) {
            $methName = $req->getParam(0);
            $methName = $methName->scalarval();
        } else {
            $methName = $req;
        }
        if (strpos($methName, "system.") === 0) {
            $dmap = $server->getSystemDispatchMap();
        } else {
            $dmap = $server->dmap;
        }
        if (isset($dmap[$methName])) {
            if (isset($dmap[$methName]['signature'])) {
                $sigs = array();
                foreach ($dmap[$methName]['signature'] as $inSig) {
                    $curSig = array();
                    foreach ($inSig as $sig) {
                        $curSig[] = new Value($sig, 'string');
                    }
                    $sigs[] = new Value($curSig, 'array');
                }
                $r = new Response(new Value($sigs, 'array'));
            } else {
                                                $r = new Response(new Value('undef', 'string'));
            }
        } else {
            $r = new Response(0, PhpXmlRpc::$xmlrpcerr['introspect_unknown'], PhpXmlRpc::$xmlrpcstr['introspect_unknown']);
        }

        return $r;
    }

    public static 
function _xmlrpcs_methodHelp($server, $req)
    {
                if (is_object($req)) {
            $methName = $req->getParam(0);
            $methName = $methName->scalarval();
        } else {
            $methName = $req;
        }
        if (strpos($methName, "system.") === 0) {
            $dmap = $server->getSystemDispatchMap();
        } else {
            $dmap = $server->dmap;
        }
        if (isset($dmap[$methName])) {
            if (isset($dmap[$methName]['docstring'])) {
                $r = new Response(new Value($dmap[$methName]['docstring']), 'string');
            } else {
                $r = new Response(new Value('', 'string'));
            }
        } else {
            $r = new Response(0, PhpXmlRpc::$xmlrpcerr['introspect_unknown'], PhpXmlRpc::$xmlrpcstr['introspect_unknown']);
        }

        return $r;
    }

    public static 
function _xmlrpcs_multicall_error($err)
    {
        if (is_string($err)) {
            $str = PhpXmlRpc::$xmlrpcstr["multicall_${err}"];
            $code = PhpXmlRpc::$xmlrpcerr["multicall_${err}"];
        } else {
            $code = $err->faultCode();
            $str = $err->faultString();
        }
        $struct = array();
        $struct['faultCode'] = new Value($code, 'int');
        $struct['faultString'] = new Value($str, 'string');

        return new Value($struct, 'struct');
    }

    public static 
function _xmlrpcs_multicall_do_call($server, $call)
    {
        if ($call->kindOf() != 'struct') {
            return static::_xmlrpcs_multicall_error('notstruct');
        }
        $methName = @$call['methodName'];
        if (!$methName) {
            return static::_xmlrpcs_multicall_error('nomethod');
        }
        if ($methName->kindOf() != 'scalar' || $methName->scalartyp() != 'string') {
            return static::_xmlrpcs_multicall_error('notstring');
        }
        if ($methName->scalarval() == 'system.multicall') {
            return static::_xmlrpcs_multicall_error('recursion');
        }

        $params = @$call['params'];
        if (!$params) {
            return static::_xmlrpcs_multicall_error('noparams');
        }
        if ($params->kindOf() != 'array') {
            return static::_xmlrpcs_multicall_error('notarray');
        }

        $req = new Request($methName->scalarval());
        foreach($params as $i => $param) {
            if (!$req->addParam($param)) {
                $i++;                 return static::_xmlrpcs_multicall_error(new Response(0,
                    PhpXmlRpc::$xmlrpcerr['incorrect_params'],
                    PhpXmlRpc::$xmlrpcstr['incorrect_params'] . ": probable xml error in param " . $i));
            }
        }

        $result = $server->execute($req);

        if ($result->faultCode() != 0) {
            return static::_xmlrpcs_multicall_error($result);         }

        return new Value(array($result->value()), 'array');
    }

    public static 
function _xmlrpcs_multicall_do_call_phpvals($server, $call)
    {
        if (!is_array($call)) {
            return static::_xmlrpcs_multicall_error('notstruct');
        }
        if (!array_key_exists('methodName', $call)) {
            return static::_xmlrpcs_multicall_error('nomethod');
        }
        if (!is_string($call['methodName'])) {
            return static::_xmlrpcs_multicall_error('notstring');
        }
        if ($call['methodName'] == 'system.multicall') {
            return static::_xmlrpcs_multicall_error('recursion');
        }
        if (!array_key_exists('params', $call)) {
            return static::_xmlrpcs_multicall_error('noparams');
        }
        if (!is_array($call['params'])) {
            return static::_xmlrpcs_multicall_error('notarray');
        }

                        $numParams = count($call['params']);
        $pt = array();
        $wrapper = new Wrapper();
        foreach ($call['params'] as $val) {
            $pt[] = $wrapper->php2XmlrpcType(gettype($val));
        }

        $result = $server->execute($call['methodName'], $call['params'], $pt);

        if ($result->faultCode() != 0) {
            return static::_xmlrpcs_multicall_error($result);         }

        return new Value(array($result->value()), 'array');
    }

    public static 
function _xmlrpcs_multicall($server, $req)
    {
        $result = array();
                if (is_object($req)) {
            $calls = $req->getParam(0);
            foreach($calls as $call) {
                $result[] = static::_xmlrpcs_multicall_do_call($server, $call);
            }
        } else {
            $numCalls = count($req);
            for ($i = 0; $i < $numCalls; $i++) {
                $result[$i] = static::_xmlrpcs_multicall_do_call_phpvals($server, $req[$i]);
            }
        }

        return new Response(new Value($result, 'array'));
    }

    
    public static 
function _xmlrpcs_errorHandler($errCode, $errString, $filename = null, $lineNo = null, $context = null)
    {
                if (error_reporting() == 0) {
            return;
        }

                if ($errCode != E_STRICT) {
            \PhpXmlRpc\Server::error_occurred($errString);
        }
                        if (self::$_xmlrpcs_prev_ehandler == '') {
                                    if (ini_get('log_errors') && (intval(ini_get('error_reporting')) & $errCode)) {
                error_log($errString);
            }
        } else {
                        if (self::$_xmlrpcs_prev_ehandler != array('\PhpXmlRpc\Server', '_xmlrpcs_errorHandler')) {
                if (is_array(self::$_xmlrpcs_prev_ehandler)) {
                                        call_user_func_array(self::$_xmlrpcs_prev_ehandler, array($errCode, $errString, $filename, $lineNo, $context));
                } else {
                    $method = self::$_xmlrpcs_prev_ehandler;
                    $method($errCode, $errString, $filename, $lineNo, $context);
                }
            }
        }
    }
}
