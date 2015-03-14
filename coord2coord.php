#!/usr/bin/env php
<?php

class Coord2Coord 
{
    protected $arr;
    protected $size;
    protected $fromZero = false;

    public function __construct()
    {
        $this->arr = range('a', 'z');
        $this->size = count($this->arr);

        $prov = array();

        foreach($this->arr as $k => $v){
            $prov[$k + 1] = $v;
        }

        $this->arr = $prov;
    }


    public function l2d($str)
    {
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

$c2c = new Coord2Coord();

var_dump($c2c->l2d('A')); // 1
var_dump($c2c->l2d('Z')); // 26
var_dump($c2c->l2d('AB')); // 28
var_dump($c2c->l2d('AE')); // 31
var_dump($c2c->l2d('AK')); // 31
var_dump($c2c->l2d('BH')); // 60
var_dump($c2c->l2d('AEN')); // 820

var_dump($c2c->d2l(60)); // BH
var_dump($c2c->d2l(820)); // AEN
