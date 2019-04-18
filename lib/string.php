<?php

/*
    COFAS ('Composition of Foods Analysis Software') (v1.0 Alpha Test)
    Copyright (C) 2019 Temporality Ltd.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

// approved str functions

// ord ($character)     return ascii value of byte
// chr ($ascii)         return character value of int (byte);

function strerr($message) {

    abort($message);
//echo "(" . $message . ") ";
}

function len($str) {

    if (is_null($str)) {
        strerr("error: len() str is null");
    }

    if ($str == "") {
        strerr("error: len() str is blank");
    }

    return strlen($str);
}

function left($str, $num) {

    if (is_null($str)) {
        strerr("error: left() str is null");
    }

    if ($str == "") {
        strerr("error: left() str is blank");
    }

    if ($num < 1) {
        strerr("error: left() num of chars is < 1");
    }

    //if ($num > len($str)) {
    //    strerr("error: left() string not long enough");
    //}

    return substr($str, 0, $num);
}

function right($str, $num) {

    if (is_null($str)) {
        strerr("error: right() str is null");
    }

    if ($str == "") {
        strerr("error: right() str is blank");
    }

    if ($num < 1) {
        strerr("error: right() num of chars is < 1");
    }

    if ($num > len($str)) {
        strerr("error: right() string not long enough");
    }

    return substr($str, -$num);
}

function mid($str, $pos, $num) {

    if (is_null($str)) {
        strerr("error: mid() str is null");
    }

    if ($str == "") {
        strerr("error: mid() str is blank");
    }

    if ($pos < 0) {
        strerr("error: mid() pos < 0");
    }

    if ($num < 1) {
        strerr("error: mid() num is < 1");
    }

    if (($pos + $num) > len($str)) {
        strerr("error: mid() string not long enough");
    }

    return substr($str, $pos, $num);
}

function strdump($str) {
    
    if (is_null($str)) {
        return "null";
    }

    $l = len($str);

    if ($l == 0) {
        return "empty";
    }

    $s = "";

    for ($i = 0; $i < $l; $i++) {
       $s .= $i . ":'" . $str[$i] . "'=" . ord($str[$i]) . " ";
    }

    return $s;
}

function foldstring($str, $m) {

    $l = len($str);

    $s = "";
    $cnt = 0;
    for ($i=0; $i < $l; $i++) {
        $c = mid($str, $i, 1);
        $s .= $c;
        if ($cnt++ > $m && $c == " ") {
            $s .= "<br />";
            $cnt = 0;
        }
    }

    return $s;
}
?>
