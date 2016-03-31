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

namespace Malenki;

/**
 * Simple class to convert numeric value to spreadsheet column index based on 
 * letter or do the reverse. 
 *
 * Spreadsheet column index can be convert to integer index, starting from zero 
 * or one, as you wish.
 *
 * For example, to convert using origin as zero, do:
 *
 *     $c2c = new Coord2Coord(true);
 *     $c2c->l2d('A'); // gives 0
 *     $c2c->l2d('AEN'); // gives 819
 *
 * And now, to convert using origin set at one, just call constructor with 
 * argument set at `false` or better, just call constructor without argument:
 *
 *     $c2c = new Coord2Coord();
 *     $c2c->l2d('A'); // gives 1
 *     $c2c->l2d('AEN'); // gives 820
 *
 * Simple, is’nt it?
 *
 * You can do reverse too, starting from zero:
 *
 *     $c2c = new Coord2Coord(true);
 *     $c2c->d2l(0); // gives 'A'
 *     $c2c->d2l(819); // gives 'AEN'
 *
 * And now starting from one:
 *
 *     $c2c = new Coord2Coord();
 *     $c2c->d2l(1); // gives 'A'
 *     $c2c->d2l(820); // gives 'AEN'
 *
 * Nothing more! It just doest this two simple actions.
 * 
 * @copyright 2015 Michel PETIT
 * @author Michel Petit <petit.michel@gmail.com> 
 * @license MIT
 */
class Coord2Coord 
{
    protected $arr;
    protected $size;
    protected $fromZero = false;





    /**
     * Build new Coor2Coord object.
     * 
     * @param boolean $fromZero Should it start from zero or not? 
     */
    public function __construct($fromZero = false)
    {
        $this->arr = range('a', 'z');
        $this->size = count($this->arr);

        $prov = array();

        foreach($this->arr as $k => $v){
            $prov[$k + 1] = $v;
        }

        $this->arr = $prov;
        $this->fromZero = $fromZero;
    }






    /**
     * Converts column spreadsheet coordinate to numeric coordinate.
     *
     * Takes coordinate in letters and converts it to numeric coordinate.
     *
     * Example:
     *
     *     $c2c = new Coord2Coord();
     *     var_dump($c2c->l2d('A')); // 1
     *     var_dump($c2c->l2d('B')); // 2
     *
     *     $c2c = new Coord2Coord(true);
     *     var_dump($c2c->l2d('A')); // 0
     *     var_dump($c2c->l2d('B')); // 1
     * 
     * @param string $str Spreadsheet column coordinate du convert
     * @return integer
     * @throws \InvalidArgumentException If given string is void or contain non 
     * ASCII characters
     */
    public function l2d($str)
    {
        if(!preg_match('/^[A-Z]+$/ui', $str)){
            throw new \InvalidArgumentException(
                'Spreadsheet coordinates must be a not null string containing'
                .' ASCII letters.'
            );
        }

        $str = strtolower($str);

        $arr = array_flip($this->arr);

        $out = null;

        if(strlen($str) > 1){
            $prov = str_split($str);
            $prov = array_reverse($prov);

            $cnt = 0;

            foreach($prov as $k => $l){
                $cnt += $arr[$l] * pow($this->size, $k);
            }

            $out = $cnt;

        } else {
            $out = $arr[$str];
        }

        return $this->fromZero ? $out - 1 : $out;
    }






    /**
     * Converts numeric coordinate column to spreadsheet column coordinate. 
     * 
     * Convert given index to spreadsheet type coordinate.
     *
     * Example:
     *
     *     $c2c = new Coord2Coord();
     *     $c2c->d2l(1); // 'A'
     *     $c2c->d2l(2); // 'B'
     *
     *     $c2c = new Coord2Coord(true);
     *     $c2c->d2l(1); // 'B'
     *     $c2c->d2l(2); // 'C'
     *
     * @param integer $int Index of the column to convert
     * @return string
     * @throws \InvalidArgumentException If coordinate is not an integer
     * @throws \OutOfRangeException If coordinate is negative
     * @throws \OutOfRangeException If coordinate is zero when starting point is one.
     */
    public function d2l($int)
    {
        if(!is_integer($int)){
            throw new \InvalidArgumentException(
                'Numeric coordinate must be integer!'
            );
        }

        if($int < 0){
            throw new \OutOfRangeException(
                'Negative numeric coordinate is not allowed!'
            );
        }

        if(!$this->fromZero && $int === 0){
            throw new \OutOfRangeException(
                'Numeric coordinate cannot be zero if starting point is one!'
            );
        }

        $range = range($this->fromZero ? 0 : 1, $int);

        foreach($range as $a){
            if(!isset($out)){
                $out = 'a';
            } else {
                $out++;
            }
        }

        return strtoupper($out);
    }







    /**
     * Converts numeric coordinate or letter coordinate column to spreadsheet
     * column opposite coordinate system. 
     * 
     * Examples:
     *
     *     $c2c = new Coord2Coord();
     *     $c2c->magic(1); // 'A'
     *     $c2c->magic(2); // 'B'
     *     $c2c->magic('A'); // 1
     *     $c2c->magic('B'); // 2
     *
     *     $c2c = new Coord2Coord(true);
     *     $c2c->magic(1); // 'B'
     *     $c2c->magic(2); // 'C'
     *     $c2c->magic('A'); // 0
     *     $c2c->magic('B'); // 1
     *
     * @param integer|string $arg Index of the column to convert, as integer or letters
     * @return string
     * @throws \InvalidArgumentException If coordinate is not an integer or letters group
     */
    public function magic($arg)
    {
        if(!(is_integer($arg) || is_string($arg))){
             throw new \InvalidArgumentException('Magic conversion works only for number or letters group!');
        }

        if(!preg_match('/^([a-z]+|[0-9]+)$/ui', $arg)){
             throw new \InvalidArgumentException('Magic conversion works only for number or letters group!');
        }

        if(is_numeric($arg)){
            return $this->d2l((int) $arg);
        } else {
            return $this->l2d($arg);
        }
    }
}

