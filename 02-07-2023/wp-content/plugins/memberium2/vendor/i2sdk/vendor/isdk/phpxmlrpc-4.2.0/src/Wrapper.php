<?php
/**
 * @author Gaetano Giunta
 * @copyright (C) 2006-2015 G. Giunta
 * @license code licensed under the BSD License: see file license.txt
 */



namespace PhpXmlRpc;



class Wrapper
{
        public static $objHolder = array();

    
    public 
function php2XmlrpcType($phpType)
    {
        switch (strtolower($phpType)) {
            case 'string':
                return Value::$xmlrpcString;
            case 'integer':
            case Value::$xmlrpcInt:             case Value::$xmlrpcI4:
            case Value::$xmlrpcI8:
                return Value::$xmlrpcInt;
            case Value::$xmlrpcDouble:                 return Value::$xmlrpcDouble;
            case 'bool':
            case Value::$xmlrpcBoolean:             case 'false':
            case 'true':
                return Value::$xmlrpcBoolean;
            case Value::$xmlrpcArray:                 return Value::$xmlrpcArray;
            case 'object':
            case Value::$xmlrpcStruct:                 return Value::$xmlrpcStruct;
            case Value::$xmlrpcBase64:
                return Value::$xmlrpcBase64;
            case 'resource':
                return '';
            default:
                if (class_exists($phpType)) {
                    return Value::$xmlrpcStruct;
                } else {
                                        return Value::$xmlrpcValue;
                }
        }
    }

    
    public 
function xmlrpc2PhpType($xmlrpcType)
    {
        switch (strtolower($xmlrpcType)) {
            case 'base64':
            case 'datetime.iso8601':
            case 'string':
                return Value::$xmlrpcString;
            case 'int':
            case 'i4':
            case 'i8':
                return 'integer';
            case 'struct':
            case 'array':
                return 'array';
            case 'double':
                return 'float';
            case 'undefined':
                return 'mixed';
            case 'boolean':
            case 'null':
            default:
                                return strtolower($xmlrpcType);
        }
    }

    
    public 
function wrapPhpFunction($callable, $newFuncName = '', $extraOptions = array())
    {
        $buildIt = isset($extraOptions['return_source']) ? !($extraOptions['return_source']) : true;

        if (is_string($callable) && strpos($callable, '::') !== false) {
            $callable = explode('::', $callable);
        }
        if (is_array($callable)) {
            if (count($callable) < 2 || (!is_string($callable[0]) && !is_object($callable[0]))) {
                error_log('XML-RPC: ' . __METHOD__ . ': syntax for function to be wrapped is wrong');
                return false;
            }
            if (is_string($callable[0])) {
                $plainFuncName = implode('::', $callable);
            } elseif (is_object($callable[0])) {
                $plainFuncName = get_class($callable[0]) . '->' . $callable[1];
            }
            $exists = method_exists($callable[0], $callable[1]);
        } else if ($callable instanceof \Closure) {
                        if (!$buildIt) {
                error_log('XML-RPC: ' . __METHOD__ . ': a closure can not be wrapped in generated source code');
                return false;
            }

            $plainFuncName = 'Closure';
            $exists = true;
        } else {
            $plainFuncName = $callable;
            $exists = function_exists($callable);
        }

        if (!$exists) {
            error_log('XML-RPC: ' . __METHOD__ . ': function to be wrapped is not defined: ' . $plainFuncName);
            return false;
        }

        $funcDesc = $this->introspectFunction($callable, $plainFuncName);
        if (!$funcDesc) {
            return false;
        }

        $funcSigs = $this->buildMethodSignatures($funcDesc);

        if ($buildIt) {
            $callable = $this->buildWrapFunctionClosure($callable, $extraOptions, $plainFuncName, $funcDesc);
        } else {
            $newFuncName = $this->newFunctionName($callable, $newFuncName, $extraOptions);
            $code = $this->buildWrapFunctionSource($callable, $newFuncName, $extraOptions, $plainFuncName, $funcDesc);
        }

        $ret = array(
            'function' => $callable,
            'signature' => $funcSigs['sigs'],
            'docstring' => $funcDesc['desc'],
            'signature_docs' => $funcSigs['sigsDocs'],
        );
        if (!$buildIt) {
            $ret['function'] = $newFuncName;
            $ret['source'] = $code;
        }
        return $ret;
    }

    
    protected 
function introspectFunction($callable, $plainFuncName)
    {
                if (is_array($callable)) {
            $func = new \ReflectionMethod($callable[0], $callable[1]);
            if ($func->isPrivate()) {
                error_log('XML-RPC: ' . __METHOD__ . ': method to be wrapped is private: ' . $plainFuncName);
                return false;
            }
            if ($func->isProtected()) {
                error_log('XML-RPC: ' . __METHOD__ . ': method to be wrapped is protected: ' . $plainFuncName);
                return false;
            }
            if ($func->isConstructor()) {
                error_log('XML-RPC: ' . __METHOD__ . ': method to be wrapped is the constructor: ' . $plainFuncName);
                return false;
            }
            if ($func->isDestructor()) {
                error_log('XML-RPC: ' . __METHOD__ . ': method to be wrapped is the destructor: ' . $plainFuncName);
                return false;
            }
            if ($func->isAbstract()) {
                error_log('XML-RPC: ' . __METHOD__ . ': method to be wrapped is abstract: ' . $plainFuncName);
                return false;
            }
                    } else {
            $func = new \ReflectionFunction($callable);
        }
        if ($func->isInternal()) {
                                    error_log('XML-RPC: ' . __METHOD__ . ': function to be wrapped is internal: ' . $plainFuncName);
            return false;
        }

        
                $desc = '';
                $returns = Value::$xmlrpcValue;
                $returnsDocs = '';
                $paramDocs = array();

        $docs = $func->getDocComment();
        if ($docs != '') {
            $docs = explode("\n", $docs);
            $i = 0;
            foreach ($docs as $doc) {
                $doc = trim($doc, " \r\t/*");
                if (strlen($doc) && strpos($doc, '@') !== 0 && !$i) {
                    if ($desc) {
                        $desc .= "\n";
                    }
                    $desc .= $doc;
                } elseif (strpos($doc, '@param') === 0) {
                                        if (preg_match('/@param\s+(\S+)\s+(\$\S+)\s*(.+)?/', $doc, $matches)) {
                        $name = strtolower(trim($matches[2]));
                                                $paramDocs[$name]['doc'] = isset($matches[3]) ? $matches[3] : '';
                        $paramDocs[$name]['type'] = $matches[1];
                    }
                    $i++;
                } elseif (strpos($doc, '@return') === 0) {
                                        if (preg_match('/@return\s+(\S+)(\s+.+)?/', $doc, $matches)) {
                        $returns = $matches[1];
                        if (isset($matches[2])) {
                            $returnsDocs = trim($matches[2]);
                        }
                    }
                }
            }
        }

                $params = array();
        $i = 0;
        foreach ($func->getParameters() as $paramObj) {
            $params[$i] = array();
            $params[$i]['name'] = '$' . $paramObj->getName();
            $params[$i]['isoptional'] = $paramObj->isOptional();
            $i++;
        }

        return array(
            'desc' => $desc,
            'docs' => $docs,
            'params' => $params,             'paramDocs' => $paramDocs,             'returns' => $returns,
            'returnsDocs' =>$returnsDocs,
        );
    }

    
    protected 
function buildMethodSignatures($funcDesc)
    {
        $i = 0;
        $parsVariations = array();
        $pars = array();
        $pNum = count($funcDesc['params']);
        foreach ($funcDesc['params'] as $param) {
            

            if ($param['isoptional']) {
                                $parsVariations[] = $pars;
            }

            $pars[] = "\$p$i";
            $i++;
            if ($i == $pNum) {
                                $parsVariations[] = $pars;
            }
        }

        if (count($parsVariations) == 0) {
                        $parsVariations[] = array();
        }

        $sigs = array();
        $sigsDocs = array();
        foreach ($parsVariations as $pars) {
                        $sig = array($this->php2XmlrpcType($funcDesc['returns']));
            $pSig = array($funcDesc['returnsDocs']);
            for ($i = 0; $i < count($pars); $i++) {
                $name = strtolower($funcDesc['params'][$i]['name']);
                if (isset($funcDesc['paramDocs'][$name]['type'])) {
                    $sig[] = $this->php2XmlrpcType($funcDesc['paramDocs'][$name]['type']);
                } else {
                    $sig[] = Value::$xmlrpcValue;
                }
                $pSig[] = isset($funcDesc['paramDocs'][$name]['doc']) ? $funcDesc['paramDocs'][$name]['doc'] : '';
            }
            $sigs[] = $sig;
            $sigsDocs[] = $pSig;
        }

        return array(
            'sigs' => $sigs,
            'sigsDocs' => $sigsDocs
        );
    }

    
    protected 
function buildWrapFunctionClosure($callable, $extraOptions, $plainFuncName, $funcDesc)
    {
        $function = function($req) use($callable, $extraOptions, $funcDesc)
        {
            $nameSpace = '\\PhpXmlRpc\\';
            $encoderClass = $nameSpace.'Encoder';
            $responseClass = $nameSpace.'Response';
            $valueClass = $nameSpace.'Value';

                                    $minPars = count($funcDesc['params']);
            $maxPars = $minPars;
            foreach ($funcDesc['params'] as $i => $param) {
                if ($param['isoptional']) {
                                        $minPars = $i;
                    break;
                }
            }
            $numPars = $req->getNumParams();
            if ($numPars < $minPars || $numPars > $maxPars) {
                return new $responseClass(0, 3, 'Incorrect parameters passed to method');
            }

            $encoder = new $encoderClass();
            $options = array();
            if (isset($extraOptions['decode_php_objs']) && $extraOptions['decode_php_objs']) {
                $options[] = 'decode_php_objs';
            }
            $params = $encoder->decode($req, $options);

            $result = call_user_func_array($callable, $params);

            if (! is_a($result, $responseClass)) {
                if ($funcDesc['returns'] == Value::$xmlrpcDateTime || $funcDesc['returns'] == Value::$xmlrpcBase64) {
                    $result = new $valueClass($result, $funcDesc['returns']);
                } else {
                    $options = array();
                    if (isset($extraOptions['encode_php_objs']) && $extraOptions['encode_php_objs']) {
                        $options[] = 'encode_php_objs';
                    }

                    $result = $encoder->encode($result, $options);
                }
                $result = new $responseClass($result);
            }

            return $result;
        };

        return $function;
    }

    
    protected 
function newFunctionName($callable, $newFuncName, $extraOptions)
    {
        
        $prefix = isset($extraOptions['prefix']) ? $extraOptions['prefix'] : 'xmlrpc';

        if ($newFuncName == '') {
            if (is_array($callable)) {
                if (is_string($callable[0])) {
                    $xmlrpcFuncName = "{$prefix}_" . implode('_', $callable);
                } else {
                    $xmlrpcFuncName = "{$prefix}_" . get_class($callable[0]) . '_' . $callable[1];
                }
            } else {
                if ($callable instanceof \Closure) {
                    $xmlrpcFuncName = "{$prefix}_closure";
                } else {
                    $callable = preg_replace(array('/\./', '/[^a-zA-Z0-9_\x7f-\xff]/'),
                        array('_', ''), $callable);
                    $xmlrpcFuncName = "{$prefix}_$callable";
                }
            }
        } else {
            $xmlrpcFuncName = $newFuncName;
        }

        while (function_exists($xmlrpcFuncName)) {
            $xmlrpcFuncName .= 'x';
        }

        return $xmlrpcFuncName;
    }

    
    protected 
function buildWrapFunctionSource($callable, $newFuncName, $extraOptions, $plainFuncName, $funcDesc)
    {
        $namespace = '\\PhpXmlRpc\\';

        $encodePhpObjects = isset($extraOptions['encode_php_objs']) ? (bool)$extraOptions['encode_php_objs'] : false;
        $decodePhpObjects = isset($extraOptions['decode_php_objs']) ? (bool)$extraOptions['decode_php_objs'] : false;
        $catchWarnings = isset($extraOptions['suppress_warnings']) && $extraOptions['suppress_warnings'] ? '@' : '';

        $i = 0;
        $parsVariations = array();
        $pars = array();
        $pNum = count($funcDesc['params']);
        foreach ($funcDesc['params'] as $param) {

            if ($param['isoptional']) {
                                $parsVariations[] = $pars;
            }

            $pars[] = "\$p[$i]";
            $i++;
            if ($i == $pNum) {
                                $parsVariations[] = $pars;
            }
        }

        if (count($parsVariations) == 0) {
                        $parsVariations[] = array();
            $minPars = 0;
            $maxPars = 0;
        } else {
            $minPars = count($parsVariations[0]);
            $maxPars = count($parsVariations[count($parsVariations)-1]);
        }

        
        $innerCode = "\$paramCount = \$req->getNumParams();\n";
        $innerCode .= "if (\$paramCount < $minPars || \$paramCount > $maxPars) return new {$namespace}Response(0, " . PhpXmlRpc::$xmlrpcerr['incorrect_params'] . ", '" . PhpXmlRpc::$xmlrpcstr['incorrect_params'] . "');\n";

        $innerCode .= "\$encoder = new {$namespace}Encoder();\n";
        if ($decodePhpObjects) {
            $innerCode .= "\$p = \$encoder->decode(\$req, array('decode_php_objs'));\n";
        } else {
            $innerCode .= "\$p = \$encoder->decode(\$req);\n";
        }

                        if (is_array($callable) && is_object($callable[0])) {
            self::$objHolder[$newFuncName] = $callable[0];
            $innerCode .= "\$obj = PhpXmlRpc\\Wrapper::\$objHolder['$newFuncName'];\n";
            $realFuncName = '$obj->' . $callable[1];
        } else {
            $realFuncName = $plainFuncName;
        }
        foreach ($parsVariations as $i => $pars) {
            $innerCode .= "if (\$paramCount == " . count($pars) . ") \$retval = {$catchWarnings}$realFuncName(" . implode(',', $pars) . ");\n";
            if ($i < (count($parsVariations) - 1))
                $innerCode .= "else\n";
        }
        $innerCode .= "if (is_a(\$retval, '{$namespace}Response')) return \$retval; else\n";
        if ($funcDesc['returns'] == Value::$xmlrpcDateTime || $funcDesc['returns'] == Value::$xmlrpcBase64) {
            $innerCode .= "return new {$namespace}Response(new {$namespace}Value(\$retval, '{$funcDesc['returns']}'));";
        } else {
            if ($encodePhpObjects) {
                $innerCode .= "return new {$namespace}Response(\$encoder->encode(\$retval, array('encode_php_objs')));\n";
            } else {
                $innerCode .= "return new {$namespace}Response(\$encoder->encode(\$retval));\n";
            }
        }
                        
        $code = "function $newFuncName(\$req) {\n" . $innerCode . "\n}";

        return $code;
    }

    
    public 
function wrapPhpClass($className, $extraOptions = array())
    {
        $methodFilter = isset($extraOptions['method_filter']) ? $extraOptions['method_filter'] : '';
        $methodType = isset($extraOptions['method_type']) ? $extraOptions['method_type'] : 'auto';
        $prefix = isset($extraOptions['prefix']) ? $extraOptions['prefix'] : '';

        $results = array();
        $mList = get_class_methods($className);
        foreach ($mList as $mName) {
            if ($methodFilter == '' || preg_match($methodFilter, $mName)) {
                $func = new \ReflectionMethod($className, $mName);
                if (!$func->isPrivate() && !$func->isProtected() && !$func->isConstructor() && !$func->isDestructor() && !$func->isAbstract()) {
                    if (($func->isStatic() && ($methodType == 'all' || $methodType == 'static' || ($methodType == 'auto' && is_string($className)))) ||
                        (!$func->isStatic() && ($methodType == 'all' || $methodType == 'nonstatic' || ($methodType == 'auto' && is_object($className))))
                    ) {
                        $methodWrap = $this->wrapPhpFunction(array($className, $mName), '', $extraOptions);
                        if ($methodWrap) {
                            if (is_object($className)) {
                                $realClassName = get_class($className);
                            }else {
                                $realClassName = $className;
                            }
                            $results[$prefix."$realClassName.$mName"] = $methodWrap;
                        }
                    }
                }
            }
        }

        return $results;
    }

    
    public 
function wrapXmlrpcMethod($client, $methodName, $extraOptions = array())
    {
        $newFuncName = isset($extraOptions['new_function_name']) ? $extraOptions['new_function_name'] : '';

        $buildIt = isset($extraOptions['return_source']) ? !($extraOptions['return_source']) : true;

        $mSig = $this->retrieveMethodSignature($client, $methodName, $extraOptions);
        if (!$mSig) {
            return false;
        }

        if ($buildIt) {
            return $this->buildWrapMethodClosure($client, $methodName, $extraOptions, $mSig);
        } else {
                                    $mDesc = $this->retrieveMethodHelp($client, $methodName, $extraOptions);

            $newFuncName = $this->newFunctionName($methodName, $newFuncName, $extraOptions);

            $results = $this->buildWrapMethodSource($client, $methodName, $extraOptions, $newFuncName, $mSig, $mDesc);
            

            $results['function'] = $newFuncName;

            return $results;
        }

    }

    
    protected 
function retrieveMethodSignature($client, $methodName, array $extraOptions = array())
    {
        $namespace = '\\PhpXmlRpc\\';
        $reqClass = $namespace . 'Request';
        $valClass = $namespace . 'Value';
        $decoderClass = $namespace . 'Encoder';

        $debug = isset($extraOptions['debug']) ? ($extraOptions['debug']) : 0;
        $timeout = isset($extraOptions['timeout']) ? (int)$extraOptions['timeout'] : 0;
        $protocol = isset($extraOptions['protocol']) ? $extraOptions['protocol'] : '';
        $sigNum = isset($extraOptions['signum']) ? (int)$extraOptions['signum'] : 0;

        $req = new $reqClass('system.methodSignature');
        $req->addparam(new $valClass($methodName));
        $client->setDebug($debug);
        $response = $client->send($req, $timeout, $protocol);
        if ($response->faultCode()) {
            error_log('XML-RPC: ' . __METHOD__ . ': could not retrieve method signature from remote server for method ' . $methodName);
            return false;
        }

        $mSig = $response->value();
        if ($client->return_type != 'phpvals') {
            $decoder = new $decoderClass();
            $mSig = $decoder->decode($mSig);
        }

        if (!is_array($mSig) || count($mSig) <= $sigNum) {
            error_log('XML-RPC: ' . __METHOD__ . ': could not retrieve method signature nr.' . $sigNum . ' from remote server for method ' . $methodName);
            return false;
        }

        return $mSig[$sigNum];
    }

    
    protected 
function retrieveMethodHelp($client, $methodName, array $extraOptions = array())
    {
        $namespace = '\\PhpXmlRpc\\';
        $reqClass = $namespace . 'Request';
        $valClass = $namespace . 'Value';

        $debug = isset($extraOptions['debug']) ? ($extraOptions['debug']) : 0;
        $timeout = isset($extraOptions['timeout']) ? (int)$extraOptions['timeout'] : 0;
        $protocol = isset($extraOptions['protocol']) ? $extraOptions['protocol'] : '';

        $mDesc = '';

        $req = new $reqClass('system.methodHelp');
        $req->addparam(new $valClass($methodName));
        $client->setDebug($debug);
        $response = $client->send($req, $timeout, $protocol);
        if (!$response->faultCode()) {
            $mDesc = $response->value();
            if ($client->return_type != 'phpvals') {
                $mDesc = $mDesc->scalarval();
            }
        }

        return $mDesc;
    }

    
    protected 
function buildWrapMethodClosure($client, $methodName, array $extraOptions, $mSig)
    {
                $clientClone = clone $client;
        $function = function() use($clientClone, $methodName, $extraOptions, $mSig)
        {
            $timeout = isset($extraOptions['timeout']) ? (int)$extraOptions['timeout'] : 0;
            $protocol = isset($extraOptions['protocol']) ? $extraOptions['protocol'] : '';
            $encodePhpObjects = isset($extraOptions['encode_php_objs']) ? (bool)$extraOptions['encode_php_objs'] : false;
            $decodePhpObjects = isset($extraOptions['decode_php_objs']) ? (bool)$extraOptions['decode_php_objs'] : false;
            if (isset($extraOptions['return_on_fault'])) {
                $decodeFault = true;
                $faultResponse = $extraOptions['return_on_fault'];
            } else {
                $decodeFault = false;
            }

            $namespace = '\\PhpXmlRpc\\';
            $reqClass = $namespace . 'Request';
            $encoderClass = $namespace . 'Encoder';
            $valueClass = $namespace . 'Value';

            $encoder = new $encoderClass();
            $encodeOptions = array();
            if ($encodePhpObjects) {
                $encodeOptions[] = 'encode_php_objs';
            }
            $decodeOptions = array();
            if ($decodePhpObjects) {
                $decodeOptions[] = 'decode_php_objs';
            }

            
                        $maxArgs = count($mSig)-1;             $currentArgs = func_get_args();
            if (func_num_args() == ($maxArgs+1)) {
                $debug = array_pop($currentArgs);
                $clientClone->setDebug($debug);
            }

            $xmlrpcArgs = array();
            foreach($currentArgs as $i => $arg) {
                if ($i == $maxArgs) {
                    break;
                }
                $pType = $mSig[$i+1];
                if ($pType == 'i4' || $pType == 'i8' || $pType == 'int' || $pType == 'boolean' || $pType == 'double' ||
                    $pType == 'string' || $pType == 'dateTime.iso8601' || $pType == 'base64' || $pType == 'null'
                ) {
                                                            $xmlrpcArgs[] = new $valueClass($arg, $pType);
                } else {
                    $xmlrpcArgs[] = $encoder->encode($arg, $encodeOptions);
                }
            }

            $req = new $reqClass($methodName, $xmlrpcArgs);
                        $clientClone->return_type = 'xmlrpcvals';
            $resp = $clientClone->send($req, $timeout, $protocol);
            if ($resp->faultcode()) {
                if ($decodeFault) {
                    if (is_string($faultResponse) && ((strpos($faultResponse, '%faultCode%') !== false) ||
                            (strpos($faultResponse, '%faultString%') !== false))) {
                        $faultResponse = str_replace(array('%faultCode%', '%faultString%'),
                            array($resp->faultCode(), $resp->faultString()), $faultResponse);
                    }
                    return $faultResponse;
                } else {
                    return $resp;
                }
            } else {
                return $encoder->decode($resp->value(), $decodeOptions);
            }
        };

        return $function;
    }

    
    public 
function buildWrapMethodSource($client, $methodName, array $extraOptions, $newFuncName, $mSig, $mDesc='')
    {
        $timeout = isset($extraOptions['timeout']) ? (int)$extraOptions['timeout'] : 0;
        $protocol = isset($extraOptions['protocol']) ? $extraOptions['protocol'] : '';
        $encodePhpObjects = isset($extraOptions['encode_php_objs']) ? (bool)$extraOptions['encode_php_objs'] : false;
        $decodePhpObjects = isset($extraOptions['decode_php_objs']) ? (bool)$extraOptions['decode_php_objs'] : false;
        $clientCopyMode = isset($extraOptions['simple_client_copy']) ? (int)($extraOptions['simple_client_copy']) : 0;
        $prefix = isset($extraOptions['prefix']) ? $extraOptions['prefix'] : 'xmlrpc';
        if (isset($extraOptions['return_on_fault'])) {
            $decodeFault = true;
            $faultResponse = $extraOptions['return_on_fault'];
        } else {
            $decodeFault = false;
            $faultResponse = '';
        }

        $namespace = '\\PhpXmlRpc\\';

        $code = "function $newFuncName (";
        if ($clientCopyMode < 2) {
                        $verbatimClientCopy = !$clientCopyMode;
            $innerCode = $this->buildClientWrapperCode($client, $verbatimClientCopy, $prefix, $namespace);
            $innerCode .= "\$client->setDebug(\$debug);\n";
            $this_ = '';
        } else {
                        $innerCode = '';
            $this_ = 'this->';
        }
        $innerCode .= "\$req = new {$namespace}Request('$methodName');\n";

        if ($mDesc != '') {
                        $mDesc = "/**\n* " . str_replace('*/', '* /', $mDesc) . "\n";
        } else {
            $mDesc = "/**\nFunction $newFuncName\n";
        }

                $innerCode .= "\$encoder = new {$namespace}Encoder();\n";
        $plist = array();
        $pCount = count($mSig);
        for ($i = 1; $i < $pCount; $i++) {
            $plist[] = "\$p$i";
            $pType = $mSig[$i];
            if ($pType == 'i4' || $pType == 'i8' || $pType == 'int' || $pType == 'boolean' || $pType == 'double' ||
                $pType == 'string' || $pType == 'dateTime.iso8601' || $pType == 'base64' || $pType == 'null'
            ) {
                                $innerCode .= "\$p$i = new {$namespace}Value(\$p$i, '$pType');\n";
            } else {
                if ($encodePhpObjects) {
                    $innerCode .= "\$p$i = \$encoder->encode(\$p$i, array('encode_php_objs'));\n";
                } else {
                    $innerCode .= "\$p$i = \$encoder->encode(\$p$i);\n";
                }
            }
            $innerCode .= "\$req->addparam(\$p$i);\n";
            $mDesc .= '* @param ' . $this->xmlrpc2PhpType($pType) . " \$p$i\n";
        }
        if ($clientCopyMode < 2) {
            $plist[] = '$debug=0';
            $mDesc .= "* @param int \$debug when 1 (or 2) will enable debugging of the underlying {$prefix} call (defaults to 0)\n";
        }
        $plist = implode(', ', $plist);
        $mDesc .= '* @return ' . $this->xmlrpc2PhpType($mSig[0]) . " (or an {$namespace}Response obj instance if call fails)\n*/\n";

        $innerCode .= "\$res = \${$this_}client->send(\$req, $timeout, '$protocol');\n";
        if ($decodeFault) {
            if (is_string($faultResponse) && ((strpos($faultResponse, '%faultCode%') !== false) || (strpos($faultResponse, '%faultString%') !== false))) {
                $respCode = "str_replace(array('%faultCode%', '%faultString%'), array(\$res->faultCode(), \$res->faultString()), '" . str_replace("'", "''", $faultResponse) . "')";
            } else {
                $respCode = var_export($faultResponse, true);
            }
        } else {
            $respCode = '$res';
        }
        if ($decodePhpObjects) {
            $innerCode .= "if (\$res->faultcode()) return $respCode; else return \$encoder->decode(\$res->value(), array('decode_php_objs'));";
        } else {
            $innerCode .= "if (\$res->faultcode()) return $respCode; else return \$encoder->decode(\$res->value());";
        }

        $code = $code . $plist . ") {\n" . $innerCode . "\n}\n";

        return array('source' => $code, 'docstring' => $mDesc);
    }

    
    public 
function wrapXmlrpcServer($client, $extraOptions = array())
    {
        $methodFilter = isset($extraOptions['method_filter']) ? $extraOptions['method_filter'] : '';
        $timeout = isset($extraOptions['timeout']) ? (int)$extraOptions['timeout'] : 0;
        $protocol = isset($extraOptions['protocol']) ? $extraOptions['protocol'] : '';
        $newClassName = isset($extraOptions['new_class_name']) ? $extraOptions['new_class_name'] : '';
        $encodePhpObjects = isset($extraOptions['encode_php_objs']) ? (bool)$extraOptions['encode_php_objs'] : false;
        $decodePhpObjects = isset($extraOptions['decode_php_objs']) ? (bool)$extraOptions['decode_php_objs'] : false;
        $verbatimClientCopy = isset($extraOptions['simple_client_copy']) ? !($extraOptions['simple_client_copy']) : true;
        $buildIt = isset($extraOptions['return_source']) ? !($extraOptions['return_source']) : true;
        $prefix = isset($extraOptions['prefix']) ? $extraOptions['prefix'] : 'xmlrpc';
        $namespace = '\\PhpXmlRpc\\';

        $reqClass = $namespace . 'Request';
        $decoderClass = $namespace . 'Encoder';

        $req = new $reqClass('system.listMethods');
        $response = $client->send($req, $timeout, $protocol);
        if ($response->faultCode()) {
            error_log('XML-RPC: ' . __METHOD__ . ': could not retrieve method list from remote server');

            return false;
        } else {
            $mList = $response->value();
            if ($client->return_type != 'phpvals') {
                $decoder = new $decoderClass();
                $mList = $decoder->decode($mList);
            }
            if (!is_array($mList) || !count($mList)) {
                error_log('XML-RPC: ' . __METHOD__ . ': could not retrieve meaningful method list from remote server');

                return false;
            } else {
                                if ($newClassName != '') {
                    $xmlrpcClassName = $newClassName;
                } else {
                    $xmlrpcClassName = $prefix . '_' . preg_replace(array('/\./', '/[^a-zA-Z0-9_\x7f-\xff]/'),
                            array('_', ''), $client->server) . '_client';
                }
                while ($buildIt && class_exists($xmlrpcClassName)) {
                    $xmlrpcClassName .= 'x';
                }

                                $source = "class $xmlrpcClassName\n{\npublic \$client;\n\n";
                $source .= "function __construct()\n{\n";
                $source .= $this->buildClientWrapperCode($client, $verbatimClientCopy, $prefix, $namespace);
                $source .= "\$this->client = \$client;\n}\n\n";
                $opts = array(
                    'return_source' => true,
                    'simple_client_copy' => 2,                     'timeout' => $timeout,
                    'protocol' => $protocol,
                    'encode_php_objs' => $encodePhpObjects,
                    'decode_php_objs' => $decodePhpObjects,
                    'prefix' => $prefix,
                );
                                foreach ($mList as $mName) {
                    if ($methodFilter == '' || preg_match($methodFilter, $mName)) {
                                                $opts['new_function_name'] = preg_replace(array('/\./', '/[^a-zA-Z0-9_\x7f-\xff]/'),
                            array('_', ''), $mName);
                        $methodWrap = $this->wrapXmlrpcMethod($client, $mName, $opts);
                        if ($methodWrap) {
                            if (!$buildIt) {
                                $source .= $methodWrap['docstring'];
                            }
                            $source .= $methodWrap['source'] . "\n";
                        } else {
                            error_log('XML-RPC: ' . __METHOD__ . ': will not create class method to wrap remote method ' . $mName);
                        }
                    }
                }
                $source .= "}\n";
                if ($buildIt) {
                    $allOK = 0;
                    eval($source . '$allOK=1;');
                    if ($allOK) {
                        return $xmlrpcClassName;
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': could not create class ' . $xmlrpcClassName . ' to wrap remote server ' . $client->server);
                        return false;
                    }
                } else {
                    return array('class' => $xmlrpcClassName, 'code' => $source, 'docstring' => '');
                }
            }
        }
    }

    
    protected 
function buildClientWrapperCode($client, $verbatimClientCopy, $prefix = 'xmlrpc', $namespace = '\\PhpXmlRpc\\' )
    {
        $code = "\$client = new {$namespace}Client('" . str_replace("'", "\'", $client->path) .
            "', '" . str_replace("'", "\'", $client->server) . "', $client->port);\n";

                        if ($verbatimClientCopy) {
            foreach ($client as $fld => $val) {
                if ($fld != 'debug' && $fld != 'return_type') {
                    $val = var_export($val, true);
                    $code .= "\$client->$fld = $val;\n";
                }
            }
        }
                $code .= "\$client->return_type = '{$prefix}vals';\n";
                return $code;
    }
}
