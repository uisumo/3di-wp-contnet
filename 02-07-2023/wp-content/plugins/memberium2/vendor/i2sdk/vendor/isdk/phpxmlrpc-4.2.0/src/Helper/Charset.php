<?php

namespace PhpXmlRpc\Helper;

use PhpXmlRpc\PhpXmlRpc;


class Charset
{
        protected $xml_iso88591_Entities = array("in" => array(), "out" => array());
    protected $xml_iso88591_utf8 = array("in" => array(), "out" => array());

                

    protected $charset_supersets = array(
        'US-ASCII' => array('ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4',
            'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8',
            'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-11', 'ISO-8859-12',
            'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'UTF-8',
            'EUC-JP', 'EUC-', 'EUC-KR', 'EUC-CN',),
    );

    protected static $instance = null;

    
    public static 
function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private 
function __construct()
    {
        for ($i = 0; $i < 32; $i++) {
            $this->xml_iso88591_Entities["in"][] = chr($i);
            $this->xml_iso88591_Entities["out"][] = "&#{$i};";
        }

        for ($i = 160; $i < 256; $i++) {
            $this->xml_iso88591_Entities["in"][] = chr($i);
            $this->xml_iso88591_Entities["out"][] = "&#{$i};";
        }

        
    }

    
    public 
function encodeEntities($data, $srcEncoding = '', $destEncoding = '')
    {
        if ($srcEncoding == '') {
                        $srcEncoding = PhpXmlRpc::$xmlrpc_internalencoding;
        }

        $conversion = strtoupper($srcEncoding . '_' . $destEncoding);
        switch ($conversion) {
            case 'ISO-8859-1_':
            case 'ISO-8859-1_US-ASCII':
                $escapedData = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&apos;', '&lt;', '&gt;'), $data);
                $escapedData = str_replace($this->xml_iso88591_Entities['in'], $this->xml_iso88591_Entities['out'], $escapedData);
                break;

            case 'ISO-8859-1_UTF-8':
                $escapedData = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&apos;', '&lt;', '&gt;'), $data);
                $escapedData = utf8_encode($escapedData);
                break;

            case 'ISO-8859-1_ISO-8859-1':
            case 'US-ASCII_US-ASCII':
            case 'US-ASCII_UTF-8':
            case 'US-ASCII_':
            case 'US-ASCII_ISO-8859-1':
            case 'UTF-8_UTF-8':
                            $escapedData = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&apos;', '&lt;', '&gt;'), $data);
                break;

            case 'UTF-8_':
            case 'UTF-8_US-ASCII':
            case 'UTF-8_ISO-8859-1':
                                $escapedData = '';
                                $data = (string)$data;
                $ns = strlen($data);
                for ($nn = 0; $nn < $ns; $nn++) {
                    $ch = $data[$nn];
                    $ii = ord($ch);
                                        if ($ii < 128) {
                                                switch ($ii) {
                            case 34:
                                $escapedData .= '&quot;';
                                break;
                            case 38:
                                $escapedData .= '&amp;';
                                break;
                            case 39:
                                $escapedData .= '&apos;';
                                break;
                            case 60:
                                $escapedData .= '&lt;';
                                break;
                            case 62:
                                $escapedData .= '&gt;';
                                break;
                            default:
                                $escapedData .= $ch;
                        }                     }                     elseif ($ii >> 5 == 6) {
                        $b1 = ($ii & 31);
                        $ii = ord($data[$nn + 1]);
                        $b2 = ($ii & 63);
                        $ii = ($b1 * 64) + $b2;
                        $ent = sprintf('&#%d;', $ii);
                        $escapedData .= $ent;
                        $nn += 1;
                    }                     elseif ($ii >> 4 == 14) {
                        $b1 = ($ii & 15);
                        $ii = ord($data[$nn + 1]);
                        $b2 = ($ii & 63);
                        $ii = ord($data[$nn + 2]);
                        $b3 = ($ii & 63);
                        $ii = ((($b1 * 64) + $b2) * 64) + $b3;
                        $ent = sprintf('&#%d;', $ii);
                        $escapedData .= $ent;
                        $nn += 2;
                    }                     elseif ($ii >> 3 == 30) {
                        $b1 = ($ii & 7);
                        $ii = ord($data[$nn + 1]);
                        $b2 = ($ii & 63);
                        $ii = ord($data[$nn + 2]);
                        $b3 = ($ii & 63);
                        $ii = ord($data[$nn + 3]);
                        $b4 = ($ii & 63);
                        $ii = ((((($b1 * 64) + $b2) * 64) + $b3) * 64) + $b4;
                        $ent = sprintf('&#%d;', $ii);
                        $escapedData .= $ent;
                        $nn += 3;
                    }
                }

                                if ($conversion == 'UTF-8_ISO-8859-1') {
                    $escapedData = str_replace(array_slice($this->xml_iso88591_Entities['out'], 32), array_slice($this->xml_iso88591_Entities['in'], 32), $escapedData);
                }
                break;

            

            default:
                $escapedData = '';
                error_log('XML-RPC: ' . __METHOD__ . ": Converting from $srcEncoding to $destEncoding: not supported...");
        }

        return $escapedData;
    }

    
    public 
function isValidCharset($encoding, $validList)
    {
        if (is_string($validList)) {
            $validList = explode(',', $validList);
        }
        if (@in_array(strtoupper($encoding), $validList)) {
            return true;
        } else {
            if (array_key_exists($encoding, $this->charset_supersets)) {
                foreach ($validList as $allowed) {
                    if (in_array($allowed, $this->charset_supersets[$encoding])) {
                        return true;
                    }
                }
            }

            return false;
        }
    }

    
    public 
function getEntities($charset)
    {
        switch ($charset)
        {
            case 'iso88591':
                return $this->xml_iso88591_Entities;
            default:
                throw new \Exception('Unsupported charset: ' . $charset);
        }
    }

}
