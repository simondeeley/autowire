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
  
namespace spec\Autowire;

use Autowire\Container;
use PhpSpec\ObjectBehavior;

/**
 * Unit specification tests for Container
 *
 * @author Simon Deeley
 */
final class ContainerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Container::class);
    }
    
    public function it_implements_PSR11_interface(): void
    {
        $this->shouldImplement('Psr\Container\ContainerInterface');
    }
    
    public function it_implements_ArrayAccess(): void
    {
        $this->shouldImplement('ArrayAccess');
    }
    
    public function it_implements_Countable(): void
    {
        $this->shouldImplement('Countable');
    }
    
    public function it_should_be_empty_when_new(): void
    {
        $this->count()->shouldBe(0);
    }
        
    public function it_can_resolve_simple_classes(): void
    {
        $this->offsetExists('DateTime')->shouldReturn(true);
        $this->offsetGet('DateTime')->shouldReturnAnInstanceOf('DateTime');
    }
    
    public function it_does_not_have_unknown_classes(): void
    {
        $this->offsetExists('UnknownClass')->shouldReturn(false);
    }

    public function it_returns_not_found_exception_if_class_cannot_be_found(): void
    {
        $this->shouldThrow('Autowire\Container\Exception\NotFoundException')
            ->duringGet('UnknownClass');
    }
    
    public function it_can_register_dependencies(): void
    {
        $foobar = new class {
        };
        
        $this->set('Foo\Bar', $foobar)->shouldReturn($this);
        $this->count()->shouldReturn(1);
    }
    
    public function it_can_resolve_registered_dependencies(): void
    {
        $foobar = new class {
        };
 
        $this->offsetSet('Foo\Bar', $foobar);
        $this->offsetGet('Foo\Bar')->shouldReturnAnInstanceOf($foobar);
    }
    
    public function it_can_resolve_registered_invokables(): void
    {
        $foobar = new class {
            public function __invoke()
            {
                return new \DateTime;
            }
        };
        
        $this->offsetSet('Foo\Bar', $foobar);
        $this->offsetGet('Foo\Bar')->shouldReturnAnInstanceOf('DateTime');
    }
    
    public function it_can_resolve_registered_callable(): void
    {
        $foobar = function () {
            return new \DateTime;
        };
        
        $this->offsetSet('Foo\Bar', $foobar);
        $this->offsetGet('Foo\Bar')->shouldReturnAnInstanceOf('DateTime');
    }
    
    public function it_can_resolve_if_registered_dependencies_instantiable(): void
    {
        $foobar = new class {
        };
        
        $this->offsetSet('Foo\Bar', $foobar);
        $this->offsetExists('Foo\Bar')->shouldReturn(true);
    }
    
    public function it_can_resolve_dependencies_constructors(): void
    {
        $foobar = get_class(new class(new \DateTime) {
            private $datetime;
            public function __construct(\DateTime $datetime)
            {
                $this->datetime = $datetime;
            }
        });
        
        $this->offsetSet('Foo\Bar', $foobar);
        $this->offsetGet('Foo\Bar')->shouldReturnAnInstanceOf($foobar);
    }
}
