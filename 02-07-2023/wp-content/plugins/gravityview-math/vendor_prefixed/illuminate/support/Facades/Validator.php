<?php
/**
 * @license MIT
 *
 * Modified by GravityKit on 06-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace GravityKit\GravityMath\Foundation\ThirdParty\Illuminate\Support\Facades;

/**
 * @see \GravityKit\GravityMath\Foundation\ThirdParty\Illuminate\Validation\Factory
 */
class Validator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'validator';
    }
}
