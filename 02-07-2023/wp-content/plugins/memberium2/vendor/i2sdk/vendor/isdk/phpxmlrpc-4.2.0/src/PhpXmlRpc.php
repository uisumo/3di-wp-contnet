<?php

namespace PhpXmlRpc;



class PhpXmlRpc
{
    static public $xmlrpcerr = array(
        'unknown_method' => 1,
        'invalid_return' => 2,
        'incorrect_params' => 3,
        'introspect_unknown' => 4,
        'http_error' => 5,
        'no_data' => 6,
        'no_ssl' => 7,
        'curl_fail' => 8,
        'invalid_request' => 15,
        'no_curl' => 16,
        'server_error' => 17,
        'multicall_error' => 18,
        'multicall_notstruct' => 9,
        'multicall_nomethod' => 10,
        'multicall_notstring' => 11,
        'multicall_recursion' => 12,
        'multicall_noparams' => 13,
        'multicall_notarray' => 14,

        'cannot_decompress' => 103,
        'decompress_fail' => 104,
        'dechunk_fail' => 105,
        'server_cannot_decompress' => 106,
        'server_decompress_fail' => 107,
    );

    static public $xmlrpcstr = array(
        'unknown_method' => 'Unknown method',
        'invalid_return' => 'Invalid return payload: enable debugging to examine incoming payload',
        'incorrect_params' => 'Incorrect parameters passed to method',
        'introspect_unknown' => "Can't introspect: method unknown",
        'http_error' => "Didn't receive 200 OK from remote server.",
        'no_data' => 'No data received from server.',
        'no_ssl' => 'No SSL support compiled in.',
        'curl_fail' => 'CURL error',
        'invalid_request' => 'Invalid request payload',
        'no_curl' => 'No CURL support compiled in.',
        'server_error' => 'Internal server error',
        'multicall_error' => 'Received from server invalid multicall response',
        'multicall_notstruct' => 'system.multicall expected struct',
        'multicall_nomethod' => 'missing methodName',
        'multicall_notstring' => 'methodName is not a string',
        'multicall_recursion' => 'recursive system.multicall forbidden',
        'multicall_noparams' => 'missing params',
        'multicall_notarray' => 'params is not an array',

        'cannot_decompress' => 'Received from server compressed HTTP and cannot decompress',
        'decompress_fail' => 'Received from server invalid compressed HTTP',
        'dechunk_fail' => 'Received from server invalid chunked HTTP',
        'server_cannot_decompress' => 'Received from client compressed HTTP request and cannot decompress',
        'server_decompress_fail' => 'Received from client invalid compressed HTTP request',
    );

                public static $xmlrpc_defencoding = "UTF-8";

                    public static $xmlrpc_detectencodings = array();

                    public static $xmlrpc_internalencoding = "UTF-8";

    public static $xmlrpcName = "XML-RPC for PHP";
    public static $xmlrpcVersion = "4.2.0";

        public static $xmlrpcerruser = 800;
        public static $xmlrpcerrxml = 100;

        public static $xmlrpc_null_extension = false;

        public static $xmlrpc_null_apache_encoding = false;

    public static $xmlrpc_null_apache_encoding_ns = "http://ws.apache.org/xmlrpc/namespaces/extensions";

    
    public static 
function exportGlobals()
    {
        $reflection = new \ReflectionClass('PhpXmlRpc\PhpXmlRpc');
        foreach ($reflection->getStaticProperties() as $name => $value) {
            $GLOBALS[$name] = $value;
        }

                
        $reflection = new \ReflectionClass('PhpXmlRpc\Value');
        foreach ($reflection->getStaticProperties() as $name => $value) {
            $GLOBALS[$name] = $value;
        }

        $parser = new Helper\XMLParser();
        $reflection = new \ReflectionClass('PhpXmlRpc\Helper\XMLParser');
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $name => $value) {
            if (in_array($value->getName(), array('xmlrpc_valid_parents')))
            {
                $GLOBALS[$value->getName()] = $value->getValue($parser);
            }
        }

        $charset = Helper\Charset::instance();
        $GLOBALS['xml_iso88591_Entities'] = $charset->getEntities('iso88591');
    }

    
    public static 
function importGlobals()
    {
        $reflection = new \ReflectionClass('PhpXmlRpc\PhpXmlRpc');
        $staticProperties = $reflection->getStaticProperties();
        foreach ($staticProperties as $name => $value) {
            if (isset($GLOBALS[$name])) {
                self::$$name = $GLOBALS[$name];
            }
        }
    }

}
