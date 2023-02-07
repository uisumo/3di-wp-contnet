<?php

namespace PhpXmlRpc\Helper;

use PhpXmlRpc\PhpXmlRpc;


class Http
{
    
    public static 
function decodeChunked($buffer)
    {
                $length = 0;
        $new = '';

                        $chunkEnd = strpos($buffer, "\r\n") + 2;
        $temp = substr($buffer, 0, $chunkEnd);
        $chunkSize = hexdec(trim($temp));
        $chunkStart = $chunkEnd;
        while ($chunkSize > 0) {
            $chunkEnd = strpos($buffer, "\r\n", $chunkStart + $chunkSize);

                        if ($chunkEnd == false) {
                $chunk = substr($buffer, $chunkStart);
                                $new .= $chunk;
                $length += strlen($chunk);
                break;
            }

                        $chunk = substr($buffer, $chunkStart, $chunkEnd - $chunkStart);
                        $new .= $chunk;
                        $length += strlen($chunk);
                        $chunkStart = $chunkEnd + 2;

            $chunkEnd = strpos($buffer, "\r\n", $chunkStart) + 2;
            if ($chunkEnd == false) {
                break;             }
            $temp = substr($buffer, $chunkStart, $chunkEnd - $chunkStart);
            $chunkSize = hexdec(trim($temp));
            $chunkStart = $chunkEnd;
        }

        return $new;
    }

    
    public 
function parseResponseHeaders(&$data, $headersProcessed = false, $debug=0)
    {
        $httpResponse = array('raw_data' => $data, 'headers'=> array(), 'cookies' => array());

                if (preg_match('/^HTTP\/1\.[0-1] 200 Connection established/', $data)) {
                                    $pos = strpos($data, "\r\n\r\n");
            if ($pos || is_int($pos)) {
                $bd = $pos + 4;
            } else {
                $pos = strpos($data, "\n\n");
                if ($pos || is_int($pos)) {
                    $bd = $pos + 2;
                } else {
                                        $bd = 0;
                }
            }
            if ($bd) {
                                                $data = substr($data, $bd);
            } else {
                error_log('XML-RPC: ' . __METHOD__ . ': HTTPS via proxy error, tunnel connection possibly failed');
                throw new \Exception(PhpXmlRpc::$xmlrpcstr['http_error'] . ' (HTTPS via proxy error, tunnel connection possibly failed)', PhpXmlRpc::$xmlrpcerr['http_error']);
            }
        }

                while (preg_match('/^HTTP\/1\.1 1[0-9]{2} /', $data)) {
            $pos = strpos($data, 'HTTP', 12);
                                    if (!$pos && !is_int($pos)) {
                
                break;
            }
            $data = substr($data, $pos);
        }
        if (!preg_match('/^HTTP\/[0-9.]+ 200 /', $data)) {
            $errstr = substr($data, 0, strpos($data, "\n") - 1);
            error_log('XML-RPC: ' . __METHOD__ . ': HTTP error, got response: ' . $errstr);
            throw new \Exception(PhpXmlRpc::$xmlrpcstr['http_error'] . ' (' . $errstr . ')', PhpXmlRpc::$xmlrpcerr['http_error']);
        }

                        $pos = strpos($data, "\r\n\r\n");
        if ($pos || is_int($pos)) {
            $bd = $pos + 4;
        } else {
            $pos = strpos($data, "\n\n");
            if ($pos || is_int($pos)) {
                $bd = $pos + 2;
            } else {
                                                $bd = 0;
            }
        }
                $ar = preg_split("/\r?\n/", trim(substr($data, 0, $pos)));
        foreach( $ar as $line ) {                         $arr = explode(':', $line, 2);
            if (count($arr) > 1) {
                $headerName = strtolower(trim($arr[0]));
                                                                                if ($headerName == 'set-cookie' || $headerName == 'set-cookie2') {
                    if ($headerName == 'set-cookie2') {
                                                                        $cookies = explode(',', $arr[1]);
                    } else {
                        $cookies = array($arr[1]);
                    }
                    foreach ($cookies as $cookie) {
                                                                        if (isset($httpResponse['headers'][$headerName])) {
                            $httpResponse['headers'][$headerName] .= ', ' . trim($cookie);
                        } else {
                            $httpResponse['headers'][$headerName] = trim($cookie);
                        }
                                                                                                $cookie = explode(';', $cookie);
                        foreach ($cookie as $pos => $val) {
                            $val = explode('=', $val, 2);
                            $tag = trim($val[0]);
							$val = isset($val[1]) ? trim(@$val[1]) : '';

                                                        if ($pos == 0) {
                                $cookiename = $tag;
                                $httpResponse['cookies'][$tag] = array();
                                $httpResponse['cookies'][$cookiename]['value'] = urldecode($val);
                            } else {
                                if ($tag != 'value') {
                                    $httpResponse['cookies'][$cookiename][$tag] = $val;
                                }
                            }
                        }
                    }
                } else {
                    $httpResponse['headers'][$headerName] = trim($arr[1]);
                }
            } elseif (isset($headerName)) {
                                $httpResponse['headers'][$headerName] .= ' ' . trim($line);
            }
        }

        $data = substr($data, $bd);

        if ($debug && count($httpResponse['headers'])) {
            $msg = '';
            foreach ($httpResponse['headers'] as $header => $value) {
                $msg .= "HEADER: $header: $value\n";
            }
            foreach ($httpResponse['cookies'] as $header => $value) {
                $msg .= "COOKIE: $header={$value['value']}\n";
            }
            Logger::instance()->debugMessage($msg);
        }

                        if (!$headersProcessed) {
                        if (isset($httpResponse['headers']['transfer-encoding']) && $httpResponse['headers']['transfer-encoding'] == 'chunked') {
                if (!$data = Http::decodeChunked($data)) {
                    error_log('XML-RPC: ' . __METHOD__ . ': errors occurred when trying to rebuild the chunked data received from server');
                    throw new \Exception(PhpXmlRpc::$xmlrpcstr['dechunk_fail'], PhpXmlRpc::$xmlrpcerr['dechunk_fail']);
                }
            }

                                    if (isset($httpResponse['headers']['content-encoding'])) {
                $httpResponse['headers']['content-encoding'] = str_replace('x-', '', $httpResponse['headers']['content-encoding']);
                if ($httpResponse['headers']['content-encoding'] == 'deflate' || $httpResponse['headers']['content-encoding'] == 'gzip') {
                                        if (function_exists('gzinflate')) {
                        if ($httpResponse['headers']['content-encoding'] == 'deflate' && $degzdata = @gzuncompress($data)) {
                            $data = $degzdata;
                            if ($debug) {
                                Logger::instance()->debugMessage("---INFLATED RESPONSE---[" . strlen($data) . " chars]---\n$data\n---END---");
                            }
                        } elseif ($httpResponse['headers']['content-encoding'] == 'gzip' && $degzdata = @gzinflate(substr($data, 10))) {
                            $data = $degzdata;
                            if ($debug) {
                                Logger::instance()->debugMessage("---INFLATED RESPONSE---[" . strlen($data) . " chars]---\n$data\n---END---");
                            }
                        } else {
                            error_log('XML-RPC: ' . __METHOD__ . ': errors occurred when trying to decode the deflated data received from server');
                            throw new \Exception(PhpXmlRpc::$xmlrpcstr['decompress_fail'], PhpXmlRpc::$xmlrpcerr['decompress_fail']);
                        }
                    } else {
                        error_log('XML-RPC: ' . __METHOD__ . ': the server sent deflated data. Your php install must have the Zlib extension compiled in to support this.');
                        throw new \Exception(PhpXmlRpc::$xmlrpcstr['cannot_decompress'], PhpXmlRpc::$xmlrpcerr['cannot_decompress']);
                    }
                }
            }
        } 
        return $httpResponse;
    }
}
