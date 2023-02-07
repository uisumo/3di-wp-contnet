<?php

/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2020 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */
namespace GFPDF_Vendor\setasign\Fpdi\PdfParser\Type;

use GFPDF_Vendor\setasign\Fpdi\PdfParser\PdfParserException;
/**
 * Exception class for pdf type classes
 */
class PdfTypeException extends \GFPDF_Vendor\setasign\Fpdi\PdfParser\PdfParserException
{
    /**
     * @var int
     */
    const NO_NEWLINE_AFTER_STREAM_KEYWORD = 0x601;
}
