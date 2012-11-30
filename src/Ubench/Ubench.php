<?php

/*
 * Copyright (c) 2012 Jeremy Perret
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
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Ubench;

class Ubench
{
    protected $start_time;

    protected $end_time;

    /**
     * Sets start microtime
     *
     * @return void
     */
    public function start()
    {
        $this->start_time = microtime(true);
    }

    /**
     * Sets end microtime
     *
     * @return void
     */
    public function end()
    {
        $this->end_time = microtime(true);
    }

    /**
     * Returns the elapsed time, readable or not
     *
     * @param  boolean $readable Whether the result must be human readable
     * @param  string  $format   The format to display (printf format)
     * @return string|float
     */
    public function getTime($raw = false, $format = null)
    {
        $elapsed = $this->end_time - $this->start_time;

        $format = $format ?: '%.3f%s';

        return $raw ? $elapsed : self::readableElapsedTime($elapsed, $format);
    }

    /**
     * Returns the memory peak, readable or not
     *
     * @param  boolean $readable Whether the result must be human readable
     * @param  string  $format   The format to display (printf format)
     * @return string|float
     */
    public function getMemoryPeak($raw = false, $format = null)
    {
        $memory = memory_get_peak_usage(true);

        $format = $format ?: '%.2f%s';

        return $raw ? $memory : self::readableSize($memory, $format);
    }

    /**
     * Returns a human readable memory size
     *
     * @author      wesman20 (php.net)
     * @author      Jonas John
     * @version     0.3
     * @link        http://www.jonasjohn.de/snippets/php/readable-filesize.htm
     * @param   int $size
     * @param   string $format   The format to display (printf format)
     * @return  string
     */
    public static function readableSize($size, $format)
    {
        $mod = 1024;

        $units = explode(' ','B Kb Mb Gb Tb');

        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        return sprintf($format, round($size, 3), $units[$i]);
    }

    /**
     * Returns a human readable elapsed time
     *
     * @param  float $microtime
     * @param  string  $format   The format to display (printf format)
     * @return string
     */
    public static function readableElapsedTime($microtime, $format)
    {
        if ($microtime >= 1) {
            $unit = 's';
            $time = round($microtime, 3);
        } else {
            $unit = 'ms';
            $time = round($microtime*1000);
        }

        return sprintf($format, $time, $unit);
    }
}
