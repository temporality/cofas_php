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

function haskey($array, $findkey) {
    return array_key_exists($findkey, $array);
}

function hasvalue($array, $findvalue) {

    if (is_null($array)) {
        return FALSE;
    }

    foreach ($array as $value) {
        if ($findvalue == $value) {
            return TRUE;
        }
    }

    return FALSE;
}

function keepkeys($array, $keyslist) {

    $newarr = array();

    foreach ($array as $k => $v) {
        if (hasvalue($keyslist, $k)) {
            $newarr[$k] = $v;
        }
    }

    return $newarr;

}

function stripkeys($array, $keyslist) {

    $newarr = array();

    foreach ($array as $k => $v) {
        if (!hasvalue($keyslist, $k)) {
            $newarr[$k] = $v;
        }
    }

    return $newarr;
}

function keyfields($arr, $fieldname) {

    $newarr = array();

    foreach ($arr as $k => $v) {
        $newarr[$k] = $arr[$k][$fieldname];
    }

    return $newarr;
}

function commonkeys($arr1, $arr2) {

    $keys = array();

    foreach ($arr1 as $k => $v) {
        if (haskey($arr2, $k)) {
            $keys[] = $k;
        }
    }

    return $keys;
}

function indexby($records, $indexedbyfieldname) {

    if ($records === NULL) {
        return NULL;
    }

    $lookup = array();

    foreach($records as $record) {
        $key = $record[$indexedbyfieldname];
        if (haskey($lookup, $key)) {
            abort("Duplicate key '$key' in record");
        }
        $lookup[$key] = $record;
    }

    return $lookup;
}

function arraytostring($arr, $separator, $delimiter) {

    $str = "";

    foreach ($arr as $k => $v) {
        $str = $str . $delimiter . dbesc($v) . $delimiter . $separator;
    }

    if ($str <> "") {
        $str = left($str, len($str) - 1);
    }

    return $str;
}

function removefromlist($list, $removelist) {

    $newlist = array();

    foreach ($list as $item) {
        if (!in_array($item, $removelist)) {
            $newlist[] = $item;
        }
    }

    return $newlist;
}

function getlistfromcolumn($table, $columnname) {
    $list = array();

    foreach ($table as $rec) {
        $list[] = $rec[$columnname];
    }

    return $list;
}

function getlistofkeys($arr) {

    $keys = array();

    foreach ($arr as $k => $v) {
        $keys[] = $k;
    }

    return $keys;

}
?>