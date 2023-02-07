<?php

/** @file
 * A selector.
 */
namespace GFPDF_Vendor\QueryPath\CSS;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
/**
 * A CSS Selector.
 *
 * A CSS selector is made up of one or more Simple Selectors
 * (SimpleSelector).
 *
 * @attention
 * The Selector data structure is a LIFO (Last in, First out). This is
 * because CSS selectors are best processed "bottom up". Thus, when
 * iterating over 'a>b>c', the iterator will produce:
 * - c
 * - b
 * - a
 * It is assumed, therefore, that any suitable querying engine will
 * traverse from the bottom (`c`) back up.
 *
 * @b     Usage
 *
 * This class is an event handler. It can be plugged into an Parser and
 * receive the events the Parser generates.
 *
 * This class is also an iterator. Once the parser has completed, the
 * captured selectors can be iterated over.
 *
 * @code
 * <?php
 * $selectorList = new \QueryPath\CSS\Selector();
 * $parser = new \QueryPath\CSS\Parser($selector, $selectorList);
 *
 * $parser->parse();
 *
 * foreach ($selectorList as $simpleSelector) {
 *   // Do something with the SimpleSelector.
 *   print_r($simpleSelector);
 * }
 * ?>
 * @endode
 *
 *
 * @since QueryPath 3.0.0
 */
class Selector implements \GFPDF_Vendor\QueryPath\CSS\EventHandler, \IteratorAggregate, \Countable
{
    protected $selectors = [];
    protected $currSelector;
    protected $selectorGroups = [];
    protected $groupIndex = 0;
    public function __construct()
    {
        $this->currSelector = new \GFPDF_Vendor\QueryPath\CSS\SimpleSelector();
        $this->selectors[$this->groupIndex][] = $this->currSelector;
    }
    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->selectors);
    }
    /**
     * Get the array of SimpleSelector objects.
     *
     * Normally, one iterates over a Selector. However, if it is
     * necessary to get the selector array and manipulate it, this
     * method can be used.
     */
    public function toArray()
    {
        return $this->selectors;
    }
    public function count() : int
    {
        return \count($this->selectors);
    }
    public function elementID($id)
    {
        $this->currSelector->id = $id;
    }
    public function element($name)
    {
        $this->currSelector->element = $name;
    }
    public function elementNS($name, $namespace = null)
    {
        $this->currSelector->ns = $namespace;
        $this->currSelector->element = $name;
    }
    public function anyElement()
    {
        $this->currSelector->element = '*';
    }
    public function anyElementInNS($ns)
    {
        $this->currSelector->ns = $ns;
        $this->currSelector->element = '*';
    }
    public function elementClass($name)
    {
        $this->currSelector->classes[] = $name;
    }
    public function attribute($name, $value = null, $operation = \GFPDF_Vendor\QueryPath\CSS\EventHandler::IS_EXACTLY)
    {
        $this->currSelector->attributes[] = ['name' => $name, 'value' => $value, 'op' => $operation];
    }
    public function attributeNS($name, $ns, $value = null, $operation = \GFPDF_Vendor\QueryPath\CSS\EventHandler::IS_EXACTLY)
    {
        $this->currSelector->attributes[] = ['name' => $name, 'value' => $value, 'op' => $operation, 'ns' => $ns];
    }
    public function pseudoClass($name, $value = null)
    {
        $this->currSelector->pseudoClasses[] = ['name' => $name, 'value' => $value];
    }
    public function pseudoElement($name)
    {
        $this->currSelector->pseudoElements[] = $name;
    }
    public function combinator($combinatorName)
    {
        $this->currSelector->combinator = $combinatorName;
        $this->currSelector = new \GFPDF_Vendor\QueryPath\CSS\SimpleSelector();
        \array_unshift($this->selectors[$this->groupIndex], $this->currSelector);
        //$this->selectors[]= $this->currSelector;
    }
    public function directDescendant()
    {
        $this->combinator(\GFPDF_Vendor\QueryPath\CSS\SimpleSelector::DIRECT_DESCENDANT);
    }
    public function adjacent()
    {
        $this->combinator(\GFPDF_Vendor\QueryPath\CSS\SimpleSelector::ADJACENT);
    }
    public function anotherSelector()
    {
        $this->groupIndex++;
        $this->currSelector = new \GFPDF_Vendor\QueryPath\CSS\SimpleSelector();
        $this->selectors[$this->groupIndex] = [$this->currSelector];
    }
    public function sibling()
    {
        $this->combinator(\GFPDF_Vendor\QueryPath\CSS\SimpleSelector::SIBLING);
    }
    public function anyDescendant()
    {
        $this->combinator(\GFPDF_Vendor\QueryPath\CSS\SimpleSelector::ANY_DESCENDANT);
    }
}
