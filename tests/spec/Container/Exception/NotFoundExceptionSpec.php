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
 
namespace spec\Autowire\Container\Exception;

use Autowire\Container\Exception\NotFoundException;
use PhpSpec\ObjectBehavior;

/**
 * Unit specification tests for NotFoundException
 *
 * @author Simon Deeley
 */
final class NotFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(NotFoundException::class);
    }
    
    public function it_implements_PSR11_interface(): void
    {
        $this->shouldImplement('Psr\Container\ContainerExceptionInterface');
        $this->shouldImplement('Psr\Container\NotFoundExceptionInterface');
    }
    
    public function it_implements_throwable(): void
    {
        $this->shouldImplement('Throwable');
    }
}
