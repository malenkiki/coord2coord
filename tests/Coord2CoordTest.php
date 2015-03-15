<?php
/*
 * Copyright (c) 2015 Michel Petit <petit.michel@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use Malenki\Coord2Coord;

class Coord2CoordTest extends PHPUnit_Framework_TestCase
{
    public function testConvertingFromLetterShouldReturnInteger()
    {
        $c2c = new Coord2Coord();

        $this->assertInternalType('integer', $c2c->l2d('z'));
        $this->assertInternalType('integer', $c2c->l2d('ze'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConvertingFromNonAsciiLettersShouldFail()
    {
        $c2c = new Coord2Coord();
        $c2c->l2d('C’est Écrit, ça, nul !');
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConvertingFromVoidStringShouldFail()
    {
        $c2c = new Coord2Coord();
        $c2c->l2d('');
    }

    public function testConvertingFromSingleUppercaseLetterShouldSuccess()
    {
        $c2c = new Coord2Coord();

        $this->assertEquals(1, $c2c->l2d('A'));
        $this->assertEquals(26, $c2c->l2d('Z'));
    }

    public function testConvertingFromSingleUppercaseLetterStartingFromZeroShouldSuccess()
    {
        $c2c = new Coord2Coord(true);

        $this->assertEquals(0, $c2c->l2d('A'));
        $this->assertEquals(25, $c2c->l2d('Z'));
    }


    public function testConvertingFromSingleLowercaseLetterShouldSuccess()
    {
        $c2c = new Coord2Coord();

        $this->assertEquals(2, $c2c->l2d('b'));
        $this->assertEquals(25, $c2c->l2d('y'));
    }

    public function testConvertingFromSingleLowercaseLetterStartingFromZeroShouldSuccess()
    {
        $c2c = new Coord2Coord(true);

        $this->assertEquals(1, $c2c->l2d('b'));
        $this->assertEquals(24, $c2c->l2d('y'));
    }


    public function testConvertingFromSeveralUppercaseLettersShouldSuccess()
    {
        $c2c = new Coord2Coord();

        $this->assertEquals(28, $c2c->l2d('AB'));
        $this->assertEquals(31, $c2c->l2d('AE'));
        $this->assertEquals(37, $c2c->l2d('AK'));
        $this->assertEquals(60, $c2c->l2d('BH'));
        $this->assertEquals(820, $c2c->l2d('AEN'));
    }

    public function testConvertingFromSeveralLowercaseLettersShouldSuccess()
    {
        $c2c = new Coord2Coord();

        $this->assertEquals(28, $c2c->l2d('ab'));
        $this->assertEquals(31, $c2c->l2d('ae'));
        $this->assertEquals(37, $c2c->l2d('ak'));
        $this->assertEquals(60, $c2c->l2d('bh'));
        $this->assertEquals(820, $c2c->l2d('aen'));
    }


    public function testConvertingFromSeveralUppercaseLettersStartingFromZeroShouldSuccess()
    {
        $c2c = new Coord2Coord(true);

        $this->assertEquals(27, $c2c->l2d('AB'));
        $this->assertEquals(30, $c2c->l2d('AE'));
        $this->assertEquals(36, $c2c->l2d('AK'));
        $this->assertEquals(59, $c2c->l2d('BH'));
        $this->assertEquals(819, $c2c->l2d('AEN'));
    }


    public function testConvertingFromSeveralLowercaseLettersStartingFromZeroShouldSuccess()
    {
        $c2c = new Coord2Coord(true);

        $this->assertEquals(27, $c2c->l2d('ab'));
        $this->assertEquals(30, $c2c->l2d('ae'));
        $this->assertEquals(36, $c2c->l2d('ak'));
        $this->assertEquals(59, $c2c->l2d('bh'));
        $this->assertEquals(819, $c2c->l2d('aen'));
    }




    public function testConvertingFronIntegerShouldReturnString()
    {
        $c2c = new Coord2Coord();

        $this->assertInternalType('string', $c2c->d2l(3));
        $this->assertInternalType('string', $c2c->d2l(123));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConvertingFromNonIntegerShouldFail()
    {
        $c2c = new Coord2Coord();
        $c2c->d2l(34.56);
    }


    /**
     * @expectedException \OutOfRangeException
     */
    public function testConvertingFromNonPositiveIntegerShouldFail()
    {
        $c2c = new Coord2Coord();
        $c2c->d2l(-34);
    }


    /**
     * @expectedException \OutOfRangeException
     */
    public function testConvertingUsingStartToOneZeroShouldFail()
    {
        $c2c = new Coord2Coord();
        $c2c->d2l(0);
    }


    public function testConvertingFromIntegerShouldSuccess()
    {
        $c2c = new Coord2Coord();

        $this->assertEquals('A', $c2c->d2l(1));
        $this->assertEquals('Z', $c2c->d2l(26));
        $this->assertEquals('AA', $c2c->d2l(27));
        $this->assertEquals('BH', $c2c->d2l(60));
        $this->assertEquals('AEN', $c2c->d2l(820));
    }

    public function testConvertingFromIntegerStartingToZeroShouldSuccess()
    {
        $c2c = new Coord2Coord(true);

        $this->assertEquals('A', $c2c->d2l(0));
        $this->assertEquals('Z', $c2c->d2l(25));
        $this->assertEquals('AA', $c2c->d2l(26));
        $this->assertEquals('BI', $c2c->d2l(60));
        $this->assertEquals('AEO', $c2c->d2l(820));
    }
}
