<?php
/**
 * @license MIT
 *
 * Modified by The GravityKit Team on 06-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace GravityKit\GravityImport\Foundation\ThirdParty\Illuminate\Support\Facades;

use GravityKit\GravityImport\Psr\Log\LoggerInterface;

/**
 * @see \Illuminate\Log\Writer
 */
class Log extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LoggerInterface::class;
    }
}
