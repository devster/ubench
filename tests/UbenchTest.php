<?php

require __DIR__.'/../src/Ubench.php';

class UbenchTest extends \PHPUnit_Framework_TestCase
{
    public function sizeProvider()
    {
        return array(
            array('90B', 90),
            array('1.47Kb', 1500),
            array('9.54Mb', 10000000),
        );
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testreadableSize($expected, $size)
    {
        $this->assertEquals($expected, Ubench::readableSize($size, '%.2f%s'));
    }

    public function timeProvider()
    {
        return array(
            array('900ms', 0.9004213),
            array('1.156s', 1.1557845),
        );
    }

    /**
     * @dataProvider timeProvider
     */
    public function testreadableElapsedTime($expected, $time)
    {
        $this->assertEquals($expected, Ubench::readableElapsedTime($time, '%.3f%s'));
    }

    public function testGetTime()
    {
        $bench = new Ubench;
        $bench->start();
        $bench->end();

        $this->assertRegExp('/^[0-9.]+ms/', $bench->getTime());

        $bench = new Ubench;
        $bench->start();
        sleep(2);
        $bench->end();

        $this->assertRegExp('/^[0-9.]+s/', $bench->getTime());
        $this->assertInternalType('float', $bench->getTime(true));
        $this->assertRegExp('/^[0-9]+s/', $bench->getTime(false, '%d%s'));
    }

    public function testGetMemoryUsage()
    {
        $bench = new Ubench;
        $bench->start();
        $bench->end();

        $this->assertRegExp('/^[0-9.]+Mb/', $bench->getMemoryUsage());
        $this->assertInternalType('integer', $bench->getMemoryUsage(true));
        $this->assertRegExp('/^[0-9]+Mb/', $bench->getMemoryUsage(false, '%d%s'));
    }

    public function testGetMemoryPeak()
    {
        $bench = new Ubench;

        $this->assertRegExp('/^[0-9.]+Mb/', $bench->getMemoryPeak());
        $this->assertInternalType('integer', $bench->getMemoryPeak(true));
        $this->assertRegExp('/^[0-9]+Mb/', $bench->getMemoryPeak(false, '%d%s'));
    }

    public function testCallableWithoutArguments()
    {
        $bench = new Ubench();
        $result = $bench->run(function () { return true; });

        $this->assertTrue($result);
        $this->assertNotNull($bench->getTime());
        $this->assertNotNull($bench->getMemoryUsage());
        $this->assertNotNull($bench->getMemoryPeak());
    }

    public function testCallableWithArguments()
    {
        $bench = new Ubench();
        $result = $bench->run(function ($one, $two) { return $one + $two; }, 1, 2);

        $this->assertEquals(3, $result);
        $this->assertNotNull($bench->getTime());
        $this->assertNotNull($bench->getMemoryUsage());
        $this->assertNotNull($bench->getMemoryPeak());
    }
}
