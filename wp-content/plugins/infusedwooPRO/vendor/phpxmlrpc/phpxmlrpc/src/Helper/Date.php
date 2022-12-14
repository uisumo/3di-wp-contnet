<?php

namespace IWLib\PhpXmlRpc\Helper;

class Date
{
    /**
     * Given a timestamp, return the corresponding ISO8601 encoded string.
     *
     * Really, timezones ought to be supported
     * but the XML-RPC spec says:
     *
     * "Don't assume a timezone. It should be specified by the server in its
     * documentation what assumptions it makes about timezones."
     *
     * These routines always assume localtime unless
     * $utc is set to 1, in which case UTC is assumed
     * and an adjustment for locale is made when encoding
     *
     * @param int $timet (timestamp)
     * @param int $utc (0 or 1)
     *
     * @return string
     */
    public static function iso8601Encode($timet, $utc = 0)
    {
        if (!$utc) {
            $t = strftime("%Y%m%dT%H:%M:%S", $timet);
        } else {
            if (function_exists('gmstrftime')) {
                // gmstrftime doesn't exist in some versions
                // of PHP
                $t = gmstrftime("%Y%m%dT%H:%M:%S", $timet);
            } else {
                $t = strftime("%Y%m%dT%H:%M:%S", $timet - date('Z'));
            }
        }

        return $t;
    }

    /**
     * Given an ISO8601 date string, return a timet in the localtime, or UTC.
     *
     * @param string $idate
     * @param int $utc either 0 or 1
     *
     * @return int (datetime)
     */
    public static function iso8601Decode($idate, $utc = 0)
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
