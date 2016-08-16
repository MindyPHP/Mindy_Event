<?php

namespace Mindy\Test;
use Mindy\Event\Handler;

/**
 * Test class for Handler.
 * Generated by PHPUnit on 2011-02-23 at 20:22:43.
 */
class HandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Handler
     */
    protected $handler;

    protected function newHandler($sender)
    {
        $signal = 'mock_signal';
        $callback = function($value) { return $value . '!!!'; };
        return new Handler($sender, $signal, $callback);
    }

    /**
     * @todo Implement testExec().
     */
    public function testExecOnSenderClassAndParent()
    {
        $handler = $this->newHandler('\Exception');
        
        // this should be a match
        $origin = new \Exception;
        $params = $handler($origin, 'mock_signal', ['hello']);
        $this->assertSame('hello!!!', $params['value']);
        $this->assertSame($origin, $params['origin']);
        
        // this should be a match, since it has \Exception as a parent
        $origin = new \UnexpectedValueException;
        $params = $handler($origin, 'mock_signal', ['hello']);
        $this->assertSame('hello!!!', $params['value']);
        $this->assertSame($origin, $params['origin']);
        
        // this should not be a match
        $origin = new \StdClass;
        $params = $handler($origin, 'mock_signal', ['hello']);
        $this->assertNull($params['value']);
    }
    
    public function testExecOnSenderObject()
    {
        $object1 = new \StdClass;
        $handler = $this->newHandler($object1);
        
        // this should be a match
        $params = $handler($object1, 'mock_signal', ['hello']);
        $this->assertSame('hello!!!', $params['value']);
        $this->assertSame($object1, $params['origin']);
        
        // this should not match, even though it's of the same class
        $object2 = new \StdClass;
        $params = $handler($object2, 'mock_signal', ['hello']);
        $this->assertNull($params['value']);
    }
    
    public function testExecOnEveryClass()
    {
        $handler = $this->newHandler('*');
        
        // this should be a match
        $origin = new \Exception;
        $params = $handler($origin, 'mock_signal', ['hello']);
        $this->assertSame('hello!!!', $params['value']);
        $this->assertSame($origin, $params['origin']);
        
        // this should be a match
        $origin = new \StdClass;
        $params = $handler($origin, 'mock_signal', ['hello']);
        $this->assertSame('hello!!!', $params['value']);
        $this->assertSame($origin, $params['origin']);
        
        // this should not be a match (wrong signal)
        $params = $handler($origin, 'wrong_signal', ['hello']);
        $this->assertNull($params['value']);
    }
}
