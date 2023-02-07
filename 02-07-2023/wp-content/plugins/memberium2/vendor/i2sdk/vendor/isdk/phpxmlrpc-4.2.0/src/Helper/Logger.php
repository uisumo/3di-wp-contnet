<?php

namespace PhpXmlRpc\Helper;


class Logger
{
    protected static $instance = null;

    
    public static 
function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    
    public 
function debugMessage($message, $encoding=null)
    {
                if ($encoding == 'US-ASCII') {
            $encoding = 'UTF-8';
        }

        if (PHP_SAPI != 'cli') {
            $flags = ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE;
            if ($encoding != null) {
                print "<PRE>\n".htmlentities($message, $flags, $encoding)."\n</PRE>";
            } else {
                print "<PRE>\n".htmlentities($message, $flags)."\n</PRE>";
            }
        } else {
            print "\n$message\n";
        }

                flush();
    }
}
