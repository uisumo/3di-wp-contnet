<?php

namespace PhpXmlRpc;

use PhpXmlRpc\Helper\Logger;



class Client
{
        public $method = 'http';
    public $server;
    public $port = 0;
    public $path;

    public $errno;
    public $errstr;
    public $debug = 0;

    public $username = '';
    public $password = '';
    public $authtype = 1;

    public $cert = '';
    public $certpass = '';
    public $cacert = '';
    public $cacertdir = '';
    public $key = '';
    public $keypass = '';
    public $verifypeer = true;
    public $verifyhost = 2;
    public $sslversion = 0; 
    public $proxy = '';
    public $proxyport = 0;
    public $proxy_user = '';
    public $proxy_pass = '';
    public $proxy_authtype = 1;

    public $cookies = array();
    public $extracurlopts = array();

    
    public $no_multicall = true;

    
    public $accepted_compression = array();

    

    public $request_compression = '';
    
    public $xmlrpc_curl_handle = null;

        public $keepalive = false;

        public $accepted_charset_encodings = array();

    
    public $request_charset_encoding = '';

    
    public $return_type = 'xmlrpcvals';

    
    public $user_agent;

    
    public 
function __construct($path, $server = '', $port = '', $method = '')
    {
                if ($server == '' and $port == '' and $method == '') {
            $parts = parse_url($path);
            $server = $parts['host'];
            $path = isset($parts['path']) ? $parts['path'] : '';
            if (isset($parts['query'])) {
                $path .= '?' . $parts['query'];
            }
            if (isset($parts['fragment'])) {
                $path .= '#' . $parts['fragment'];
            }
            if (isset($parts['port'])) {
                $port = $parts['port'];
            }
            if (isset($parts['scheme'])) {
                $method = $parts['scheme'];
            }
            if (isset($parts['user'])) {
                $this->username = $parts['user'];
            }
            if (isset($parts['pass'])) {
                $this->password = $parts['pass'];
            }
        }
        if ($path == '' || $path[0] != '/') {
            $this->path = '/' . $path;
        } else {
            $this->path = $path;
        }
        $this->server = $server;
        if ($port != '') {
            $this->port = $port;
        }
        if ($method != '') {
            $this->method = $method;
        }

                if (function_exists('gzinflate') || (
                function_exists('curl_init') && (($info = curl_version()) &&
                    ((is_string($info) && strpos($info, 'zlib') !== null) || isset($info['libz_version'])))
            )
        ) {
            $this->accepted_compression = array('gzip', 'deflate');
        }

                $this->keepalive = true;

                $this->accepted_charset_encodings = array('UTF-8', 'ISO-8859-1', 'US-ASCII');

                                

                $this->user_agent = PhpXmlRpc::$xmlrpcName . ' ' . PhpXmlRpc::$xmlrpcVersion;
    }

    
    public 
function setDebug($level)
    {
        $this->debug = $level;
    }

    
    public 
function setCredentials($user, $password, $authType = 1)
    {
        $this->username = $user;
        $this->password = $password;
        $this->authtype = $authType;
    }

    
    public 
function setCertificate($cert, $certPass = '')
    {
        $this->cert = $cert;
        $this->certpass = $certPass;
    }

    
    public 
function setCaCertificate($caCert, $isDir = false)
    {
        if ($isDir) {
            $this->cacertdir = $caCert;
        } else {
            $this->cacert = $caCert;
        }
    }

    
    public 
function setKey($key, $keyPass)
    {
        $this->key = $key;
        $this->keypass = $keyPass;
    }

    
    public 
function setSSLVerifyPeer($i)
    {
        $this->verifypeer = $i;
    }

    
    public 
function setSSLVerifyHost($i)
    {
        $this->verifyhost = $i;
    }

    
    public 
function setSSLVersion($i)
    {
        $this->sslversion = $i;
    }

    
    public 
function setProxy($proxyHost, $proxyPort, $proxyUsername = '', $proxyPassword = '', $proxyAuthType = 1)
    {
        $this->proxy = $proxyHost;
        $this->proxyport = $proxyPort;
        $this->proxy_user = $proxyUsername;
        $this->proxy_pass = $proxyPassword;
        $this->proxy_authtype = $proxyAuthType;
    }

    
    public 
function setAcceptedCompression($compMethod)
    {
        if ($compMethod == 'any') {
            $this->accepted_compression = array('gzip', 'deflate');
        } elseif ($compMethod == false) {
            $this->accepted_compression = array();
        } else {
            $this->accepted_compression = array($compMethod);
        }
    }

    
    public 
function setRequestCompression($compMethod)
    {
        $this->request_compression = $compMethod;
    }

    
    public 
function setCookie($name, $value = '', $path = '', $domain = '', $port = null)
    {
        $this->cookies[$name]['value'] = urlencode($value);
        if ($path || $domain || $port) {
            $this->cookies[$name]['path'] = $path;
            $this->cookies[$name]['domain'] = $domain;
            $this->cookies[$name]['port'] = $port;
            $this->cookies[$name]['version'] = 1;
        } else {
            $this->cookies[$name]['version'] = 0;
        }
    }

    
    public 
function setCurlOptions($options)
    {
        $this->extracurlopts = $options;
    }

    
    public 
function setUserAgent($agentString)
    {
        $this->user_agent = $agentString;
    }

    
    public 
function send($req, $timeout = 0, $method = '')
    {
                        if ($method == '') {
            $method = $this->method;
        }

        if (is_array($req)) {
                        $r = $this->multicall($req, $timeout, $method);

            return $r;
        } elseif (is_string($req)) {
            $n = new Request('');
            $n->payload = $req;
            $req = $n;
        }

                $req->setDebug($this->debug);

        if ($method == 'https') {
            $r = $this->sendPayloadHTTPS(
                $req,
                $this->server,
                $this->port,
                $timeout,
                $this->username,
                $this->password,
                $this->authtype,
                $this->cert,
                $this->certpass,
                $this->cacert,
                $this->cacertdir,
                $this->proxy,
                $this->proxyport,
                $this->proxy_user,
                $this->proxy_pass,
                $this->proxy_authtype,
                $this->keepalive,
                $this->key,
                $this->keypass,
                $this->sslversion
            );
        } elseif ($method == 'http11') {
            $r = $this->sendPayloadCURL(
                $req,
                $this->server,
                $this->port,
                $timeout,
                $this->username,
                $this->password,
                $this->authtype,
                null,
                null,
                null,
                null,
                $this->proxy,
                $this->proxyport,
                $this->proxy_user,
                $this->proxy_pass,
                $this->proxy_authtype,
                'http',
                $this->keepalive
            );
        } else {
            $r = $this->sendPayloadHTTP10(
                $req,
                $this->server,
                $this->port,
                $timeout,
                $this->username,
                $this->password,
                $this->authtype,
                $this->proxy,
                $this->proxyport,
                $this->proxy_user,
                $this->proxy_pass,
                $this->proxy_authtype,
                $method
            );
        }

        return $r;
    }

    
    protected 
function sendPayloadHTTP10($req, $server, $port, $timeout = 0, $username = '', $password = '',
        $authType = 1, $proxyHost = '', $proxyPort = 0, $proxyUsername = '', $proxyPassword = '', $proxyAuthType = 1,
        $method='http')
    {
        if ($port == 0) {
            $port = ( $method === "https" ) ? 443 : 80;
        }

                if (empty($req->payload)) {
            $req->createPayload($this->request_charset_encoding);
        }

        $payload = $req->payload;
                if (function_exists('gzdeflate') && ($this->request_compression == 'gzip' || $this->request_compression == 'deflate')) {
            if ($this->request_compression == 'gzip') {
                $a = @gzencode($payload);
                if ($a) {
                    $payload = $a;
                    $encodingHdr = "Content-Encoding: gzip\r\n";
                }
            } else {
                $a = @gzcompress($payload);
                if ($a) {
                    $payload = $a;
                    $encodingHdr = "Content-Encoding: deflate\r\n";
                }
            }
        } else {
            $encodingHdr = '';
        }

                $credentials = '';
        if ($username != '') {
            $credentials = 'Authorization: Basic ' . base64_encode($username . ':' . $password) . "\r\n";
            if ($authType != 1) {
                error_log('XML-RPC: ' . __METHOD__ . ': warning. Only Basic auth is supported with HTTP 1.0');
            }
        }

        $acceptedEncoding = '';
        if (is_array($this->accepted_compression) && count($this->accepted_compression)) {
            $acceptedEncoding = 'Accept-Encoding: ' . implode(', ', $this->accepted_compression) . "\r\n";
        }

        $proxyCredentials = '';
        if ($proxyHost) {
            if ($proxyPort == 0) {
                $proxyPort = 8080;
            }
            $connectServer = $proxyHost;
            $connectPort = $proxyPort;
            $transport = "tcp";
            $uri = 'http://' . $server . ':' . $port . $this->path;
            if ($proxyUsername != '') {
                if ($proxyAuthType != 1) {
                    error_log('XML-RPC: ' . __METHOD__ . ': warning. Only Basic auth to proxy is supported with HTTP 1.0');
                }
                $proxyCredentials = 'Proxy-Authorization: Basic ' . base64_encode($proxyUsername . ':' . $proxyPassword) . "\r\n";
            }
        } else {
            $connectServer = $server;
            $connectPort = $port;
                        $transport = ( $method === "https" ) ? "tls" : "tcp";
            $uri = $this->path;
        }

                        $cookieHeader = '';
        if (count($this->cookies)) {
            $version = '';
            foreach ($this->cookies as $name => $cookie) {
                if ($cookie['version']) {
                    $version = ' $Version="' . $cookie['version'] . '";';
                    $cookieHeader .= ' ' . $name . '="' . $cookie['value'] . '";';
                    if ($cookie['path']) {
                        $cookieHeader .= ' $Path="' . $cookie['path'] . '";';
                    }
                    if ($cookie['domain']) {
                        $cookieHeader .= ' $Domain="' . $cookie['domain'] . '";';
                    }
                    if ($cookie['port']) {
                        $cookieHeader .= ' $Port="' . $cookie['port'] . '";';
                    }
                } else {
                    $cookieHeader .= ' ' . $name . '=' . $cookie['value'] . ";";
                }
            }
            $cookieHeader = 'Cookie:' . $version . substr($cookieHeader, 0, -1) . "\r\n";
        }

                $port = ($port == 80) ? '' : (':' . $port);

        $op = 'POST ' . $uri . " HTTP/1.0\r\n" .
            'User-Agent: ' . $this->user_agent . "\r\n" .
            'Host: ' . $server . $port . "\r\n" .
            $credentials .
            $proxyCredentials .
            $acceptedEncoding .
            $encodingHdr .
            'Accept-Charset: ' . implode(',', $this->accepted_charset_encodings) . "\r\n" .
            $cookieHeader .
            'Content-Type: ' . $req->content_type . "\r\nContent-Length: " .
            strlen($payload) . "\r\n\r\n" .
            $payload;

        if ($this->debug > 1) {
            Logger::instance()->debugMessage("---SENDING---\n$op\n---END---");
        }

        if ($timeout > 0) {
            $fp = @stream_socket_client("$transport://$connectServer:$connectPort", $this->errno, $this->errstr, $timeout);
        } else {
            $fp = @stream_socket_client("$transport://$connectServer:$connectPort", $this->errno, $this->errstr);
        }
        if ($fp) {
            if ($timeout > 0) {
                stream_set_timeout($fp, $timeout);
            }
        } else {
            $this->errstr = 'Connect error: ' . $this->errstr;
            $r = new Response(0, PhpXmlRpc::$xmlrpcerr['http_error'], $this->errstr . ' (' . $this->errno . ')');

            return $r;
        }

        if (!fputs($fp, $op, strlen($op))) {
            fclose($fp);
            $this->errstr = 'Write error';
            $r = new Response(0, PhpXmlRpc::$xmlrpcerr['http_error'], $this->errstr);

            return $r;
        } else {
                        $this->errstr = '';
        }
                        $ipd = '';
        do {
                                    $ipd .= fread($fp, 32768);
        } while (!feof($fp));
        fclose($fp);
        $r = $req->parseResponse($ipd, false, $this->return_type);

        return $r;
    }

    
    protected 
function sendPayloadHTTPS($req, $server, $port, $timeout = 0, $username = '',  $password = '',
        $authType = 1, $cert = '', $certPass = '', $caCert = '', $caCertDir = '', $proxyHost = '', $proxyPort = 0,
        $proxyUsername = '', $proxyPassword = '', $proxyAuthType = 1, $keepAlive = false, $key = '', $keyPass = '',
        $sslVersion = 0)
    {
        return $this->sendPayloadCURL($req, $server, $port, $timeout, $username,
            $password, $authType, $cert, $certPass, $caCert, $caCertDir, $proxyHost, $proxyPort,
            $proxyUsername, $proxyPassword, $proxyAuthType, 'https', $keepAlive, $key, $keyPass, $sslVersion);
    }

    
    protected 
function sendPayloadCURL($req, $server, $port, $timeout = 0, $username = '', $password = '',
        $authType = 1, $cert = '', $certPass = '', $caCert = '', $caCertDir = '', $proxyHost = '', $proxyPort = 0,
        $proxyUsername = '', $proxyPassword = '', $proxyAuthType = 1, $method = 'https', $keepAlive = false, $key = '',
        $keyPass = '', $sslVersion = 0)
    {
        if (!function_exists('curl_init')) {
            $this->errstr = 'CURL unavailable on this install';
            return new Response(0, PhpXmlRpc::$xmlrpcerr['no_curl'], PhpXmlRpc::$xmlrpcstr['no_curl']);
        }
        if ($method == 'https') {
            if (($info = curl_version()) &&
                ((is_string($info) && strpos($info, 'OpenSSL') === null) || (is_array($info) && !isset($info['ssl_version'])))
            ) {
                $this->errstr = 'SSL unavailable on this install';
                return new Response(0, PhpXmlRpc::$xmlrpcerr['no_ssl'], PhpXmlRpc::$xmlrpcstr['no_ssl']);
            }
        }

        if ($port == 0) {
            if ($method == 'http') {
                $port = 80;
            } else {
                $port = 443;
            }
        }

                if (empty($req->payload)) {
            $req->createPayload($this->request_charset_encoding);
        }

                $payload = $req->payload;
        if (function_exists('gzdeflate') && ($this->request_compression == 'gzip' || $this->request_compression == 'deflate')) {
            if ($this->request_compression == 'gzip') {
                $a = @gzencode($payload);
                if ($a) {
                    $payload = $a;
                    $encodingHdr = 'Content-Encoding: gzip';
                }
            } else {
                $a = @gzcompress($payload);
                if ($a) {
                    $payload = $a;
                    $encodingHdr = 'Content-Encoding: deflate';
                }
            }
        } else {
            $encodingHdr = '';
        }

        if ($this->debug > 1) {
            Logger::instance()->debugMessage("---SENDING---\n$payload\n---END---");
        }

        if (!$keepAlive || !$this->xmlrpc_curl_handle) {
            $curl = curl_init($method . '://' . $server . ':' . $port . $this->path);
            if ($keepAlive) {
                $this->xmlrpc_curl_handle = $curl;
            }
        } else {
            $curl = $this->xmlrpc_curl_handle;
        }

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($this->debug > 1) {
            curl_setopt($curl, CURLOPT_VERBOSE, true);
                    }
        curl_setopt($curl, CURLOPT_USERAGENT, $this->user_agent);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

                curl_setopt($curl, CURLOPT_HEADER, 1);

                                if (is_array($this->accepted_compression) && count($this->accepted_compression)) {
                                    if (count($this->accepted_compression) == 1) {
                curl_setopt($curl, CURLOPT_ENCODING, $this->accepted_compression[0]);
            } else {
                curl_setopt($curl, CURLOPT_ENCODING, '');
            }
        }
                $headers = array('Content-Type: ' . $req->content_type, 'Accept-Charset: ' . implode(',', $this->accepted_charset_encodings));
                if (!$keepAlive) {
            $headers[] = 'Connection: close';
        }
                if ($encodingHdr) {
            $headers[] = $encodingHdr;
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                if ($timeout) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout == 1 ? 1 : $timeout - 1);
        }

        if ($username && $password) {
            curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
            if (defined('CURLOPT_HTTPAUTH')) {
                curl_setopt($curl, CURLOPT_HTTPAUTH, $authType);
            } elseif ($authType != 1) {
                error_log('XML-RPC: ' . __METHOD__ . ': warning. Only Basic auth is supported by the current PHP/curl install');
            }
        }

        if ($method == 'https') {
                        if ($cert) {
                curl_setopt($curl, CURLOPT_SSLCERT, $cert);
            }
                        if ($certPass) {
                curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $certPass);
            }
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verifypeer);
                        if ($caCert) {
                curl_setopt($curl, CURLOPT_CAINFO, $caCert);
            }
            if ($caCertDir) {
                curl_setopt($curl, CURLOPT_CAPATH, $caCertDir);
            }
                        if ($key) {
                curl_setopt($curl, CURLOPT_SSLKEY, $key);
            }
                        if ($keyPass) {
                curl_setopt($curl, CURLOPT_SSLKEYPASSWD, $keyPass);
            }
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->verifyhost);
                        curl_setopt($curl, CURLOPT_SSLVERSION, $sslVersion);
        }

                if ($proxyHost) {
            if ($proxyPort == 0) {
                $proxyPort = 8080;             }
            curl_setopt($curl, CURLOPT_PROXY, $proxyHost . ':' . $proxyPort);
            if ($proxyUsername) {
                curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxyUsername . ':' . $proxyPassword);
                if (defined('CURLOPT_PROXYAUTH')) {
                    curl_setopt($curl, CURLOPT_PROXYAUTH, $proxyAuthType);
                } elseif ($proxyAuthType != 1) {
                    error_log('XML-RPC: ' . __METHOD__ . ': warning. Only Basic auth to proxy is supported by the current PHP/curl install');
                }
            }
        }

                                if (count($this->cookies)) {
            $cookieHeader = '';
            foreach ($this->cookies as $name => $cookie) {
                $cookieHeader .= $name . '=' . $cookie['value'] . '; ';
            }
            curl_setopt($curl, CURLOPT_COOKIE, substr($cookieHeader, 0, -2));
        }

        foreach ($this->extracurlopts as $opt => $val) {
            curl_setopt($curl, $opt, $val);
        }

        $result = curl_exec($curl);

        if ($this->debug > 1) {
            $message = "---CURL INFO---\n";
            foreach (curl_getinfo($curl) as $name => $val) {
                if (is_array($val)) {
                    $val = implode("\n", $val);
                }
                $message .= $name . ': ' . $val . "\n";
            }
            $message .= "---END---";
            Logger::instance()->debugMessage($message);
        }

        if (!$result) {
            
            $this->errstr = 'no response';
            $resp = new Response(0, PhpXmlRpc::$xmlrpcerr['curl_fail'], PhpXmlRpc::$xmlrpcstr['curl_fail'] . ': ' . curl_error($curl));
            curl_close($curl);
            if ($keepAlive) {
                $this->xmlrpc_curl_handle = null;
            }
        } else {
            if (!$keepAlive) {
                curl_close($curl);
            }
            $resp = $req->parseResponse($result, true, $this->return_type);
                        if ($resp->faultCode() == PhpXmlRpc::$xmlrpcerr['http_error'] && $keepAlive) {
                curl_close($curl);
                $this->xmlrpc_curl_handle = null;
            }
        }

        return $resp;
    }

    
    public 
function multicall($reqs, $timeout = 0, $method = '', $fallback = true)
    {
        if ($method == '') {
            $method = $this->method;
        }
        if (!$this->no_multicall) {
            $results = $this->_try_multicall($reqs, $timeout, $method);
            if (is_array($results)) {
                                return $results;
            } else {
                                                if ($fallback) {
                                        $this->no_multicall = true;
                } else {
                    if (is_a($results, '\PhpXmlRpc\Response')) {
                        $result = $results;
                    } else {
                        $result = new Response(0, PhpXmlRpc::$xmlrpcerr['multicall_error'], PhpXmlRpc::$xmlrpcstr['multicall_error']);
                    }
                }
            }
        } else {
                                    $fallback = true;
        }

        $results = array();
        if ($fallback) {
                                    foreach ($reqs as $req) {
                $results[] = $this->send($req, $timeout, $method);
            }
        } else {
                                                foreach ($reqs as $req) {
                $results[] = $result;
            }
        }

        return $results;
    }

    
    private 
function _try_multicall($reqs, $timeout, $method)
    {
                $calls = array();
        foreach ($reqs as $req) {
            $call['methodName'] = new Value($req->method(), 'string');
            $numParams = $req->getNumParams();
            $params = array();
            for ($i = 0; $i < $numParams; $i++) {
                $params[$i] = $req->getParam($i);
            }
            $call['params'] = new Value($params, 'array');
            $calls[] = new Value($call, 'struct');
        }
        $multiCall = new Request('system.multicall');
        $multiCall->addParam(new Value($calls, 'array'));

                $result = $this->send($multiCall, $timeout, $method);

        if ($result->faultCode() != 0) {
                        return $result;
        }

                $rets = $result->value();

        if ($this->return_type == 'xml') {
            return $rets;
        } elseif ($this->return_type == 'phpvals') {
                        $rets = $result->value();
            if (!is_array($rets)) {
                return false;                   }
            $numRets = count($rets);
            if ($numRets != count($reqs)) {
                return false;                   }

            $response = array();
            for ($i = 0; $i < $numRets; $i++) {
                $val = $rets[$i];
                if (!is_array($val)) {
                    return false;
                }
                switch (count($val)) {
                    case 1:
                        if (!isset($val[0])) {
                            return false;                               }
                                                $response[$i] = new Response($val[0], 0, '', 'phpvals');
                        break;
                    case 2:
                                                $code = @$val['faultCode'];
                        if (!is_int($code)) {
                            return false;
                        }
                        $str = @$val['faultString'];
                        if (!is_string($str)) {
                            return false;
                        }
                        $response[$i] = new Response(0, $code, $str);
                        break;
                    default:
                        return false;
                }
            }

            return $response;
        } else {
            
            $rets = $result->value();
            if ($rets->kindOf() != 'array') {
                return false;                   }
            $numRets = $rets->count();
            if ($numRets != count($reqs)) {
                return false;                   }

            $response = array();
            foreach($rets as $val) {
                switch ($val->kindOf()) {
                    case 'array':
                        if ($val->count() != 1) {
                            return false;                               }
                                                $response[] = new Response($val[0]);
                        break;
                    case 'struct':
                        $code = $val['faultCode'];
                        if ($code->kindOf() != 'scalar' || $code->scalartyp() != 'int') {
                            return false;
                        }
                        $str = $val['faultString'];
                        if ($str->kindOf() != 'scalar' || $str->scalartyp() != 'string') {
                            return false;
                        }
                        $response[] = new Response(0, $code->scalarval(), $str->scalarval());
                        break;
                    default:
                        return false;
                }
            }

            return $response;
        }
    }
}
