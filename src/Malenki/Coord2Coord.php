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

class Coord2Coord 
{
    protected $arr;
    protected $size;
    protected $fromZero = false;

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



    public function d2l($int)
    {
        if(!is_integer($int)){
            throw new \InvalidArgumentException(
                'Numeric coordinate must be integer!'
            );
        }

        $test = $this->fromZero ? $int <= 0 : $int < 0;

        if($test){
            throw new \InvalidArgumentException(
                'Negative numeric coordinates are not allowed!'
            );
        }

        $out = '';

        if($this->fromZero){
            $int--;
        }

        while(true){
            $q = $int / $this->size;
            $r = $int % $this->size;

            if(!isset($this->arr[$r])) break;
            $out = $this->arr[$r] . $out;

            $int = $q;

        }

        return strtoupper($out);
    }
}

