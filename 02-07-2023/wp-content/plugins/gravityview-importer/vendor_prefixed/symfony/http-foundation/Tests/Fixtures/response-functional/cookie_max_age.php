<?php
/**
 * @license MIT
 *
 * Modified by The GravityKit Team on 06-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

use GravityKit\GravityImport\Symfony\Component\HttpFoundation\Cookie;

$r = require __DIR__.'/common.inc';

$r->headers->setCookie(new Cookie('foo', 'bar', 253402310800, '', null, false, false));
$r->sendHeaders();

setcookie('foo2', 'bar', 253402310800, '/');
