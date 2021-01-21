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
use Countable;
use ReflectionClass;
use ReflectionException;
use Psr\Container\ContainerInterface;
use Autowire\Container\Exception\NotFoundException;

/**
 * The Autowire container.
 *
 * A lightweight dependency injection container implementation that supports
 * auto-wiring of constructor arguments and matching interfaces to
 * concrete implementations.
 *
 * @author Simon Deeley
 */
class Container implements ArrayAccess, Countable, ContainerInterface
{
    private array $items = [];
    
    /**
     *
     */
    public function set(string $id, mixed $arg): self
    {
        $this->items[$id] = $arg;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function get(mixed $id): mixed
    {
        $item = $this->resolve($id);
        
        if (false === $item instanceof ReflectionClass) {
            return $item;
        }
        
        return $this->getInstance($item);
    }
    
    /**
     * {@inheritDoc}
     */
    public function has(mixed $id): bool
    {
        try {
            $item = $this->resolve($id);
            return $item->isInstantiable();
        } catch (NotFoundException $e) {
            return array_key_exists($id, $this->items);
        }
        
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $offset): void
    {
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }
    
    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->items);
    }
    
    /**
     * Resolve an object (or one that can be instantiated) from the
     * container by inspecting it through reflection.
     */
    private function resolve($id): object
    {
        try {
            $name = $id;
            
            if (isset($this->items[$id])) {
                $name = $this->items[$id];
                
                if (is_callable($name)) {
                    return $name();
                }
            }
            
            return (new ReflectionClass($name));
        } catch (ReflectionException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
    
    /**
     *
     */
    private function getInstance(ReflectionClass $item): object
    {
        $constructor = $item->getConstructor();
        
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }
        
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }
        
        return $item->newInstanceArgs($params);
    }
}