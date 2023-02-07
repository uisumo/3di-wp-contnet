<?php

namespace PhpXmlRpc\Helper;


class Date
{
    
    public static 
function iso8601Encode($timet, $utc = 0)
    {
        if (!$utc) {
            $t = strftime("%Y%m%dT%H:%M:%S", $timet);
        } else {
            if (function_exists('gmstrftime')) {
                                                $t = gmstrftime("%Y%m%dT%H:%M:%S", $timet);
            } else {
                $t = strftime("%Y%m%dT%H:%M:%S", $timet - date('Z'));
            }
        }

        return $t;
    }

    
    public static 
function iso8601Decode($idate, $utc = 0)
    {
        $t = 0;
        if (preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})/', $idate, $regs)) {
            if ($utc) {
                $t = gmmktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]);
            } else {
                $t = mktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]);
            }
        }

        return $t;
    }
}
