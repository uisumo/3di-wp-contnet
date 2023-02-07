<?php

namespace GFPDF_Vendor\Mpdf\Utils;

class NumericString
{
    public static function containsPercentChar($string)
    {
        return \strstr($string, '%');
    }
    public static function removePercentChar($string)
    {
        return \str_replace('%', '', $string);
    }
}
