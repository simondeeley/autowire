<?php
 declare(strict_types=1);
  
  /**
   * This file is part of Autowire.
   *
   * Copyright (c) 2021 Simon Deeley
   *
   * Permission is hereby granted, free of charge, to any person obtaining a copy
   * of this software and associated documentation files (the "Software"), to deal
   * in the Software without restriction, including without limitation the rights
   * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
   * copies of the Software, and to permit persons to whom the Software is furnished
   * to do so, subject to the following conditions:
   *
   * The above copyright notice and this permission notice shall be included in all
   * copies or substantial portions of the Software.
   *
   * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
   * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
   * THE SOFTWARE.
   */
   
namespace Autowire;

use ArrayAccess;
use Psr\Container\ContainerInterface;

/**
 * The Autowire container.
 *
 * A lightweight dependency injection container implementation that supports
 * auto-wiring of constructor arguments and matching interfaces to
 * concrete implementations.
 *
 * @author Simon Deeley
 */
class Container implements ArrayAccess, ContainerInterface
{
    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
    }
    
    /**
     * {@inheritDoc}
     */
    public function has($id)
    {
    }
    
    public function offsetSet($offset, $value): void
    {
    }

    public function offsetExists($offset): bool
    {
    }

    public function offsetUnset($offset): void
    {
    }

    public function offsetGet($offset): mixed
    {
    }
}
