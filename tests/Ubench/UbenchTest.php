<?php

namespace Ubench\Test;

use Ubench\Ubench;

require __DIR__.'/../../src/Ubench/Ubench.php';

class UbenchTest extends \PHPUnit_Framework_TestCase
{
    public function sizeProvider()
    {
        return array(
            array('90B', 90),
            array('1.46Kb', 1500),
            array('9.54Mb', 10000000),
        );
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testreadableSize($expected, $size)
    {
        $this->assertEquals($expected, Ubench::readableSize($size));
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
        $this->assertEquals($expected, Ubench::readableElapsedTime($time));
    }

    public function testGetTime()
    {
        $bench = new Ubench;
        $bench->start();
        $bench->end();

        $this->assertRegExp('/^[0-9]+ms/', $bench->getTime());

        $bench = new Ubench;
        $bench->start();
        sleep(2);
        $bench->end();

        $this->assertRegExp('/^[0-9.]+s/', $bench->getTime());
    }

    public function testGetMemoryPeak()
    {
        $bench = new Ubench;

        $this->assertRegExp('/^[0-9.]+Mb/', $bench->getMemoryPeak());
    }
}
