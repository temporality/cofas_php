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

function getelement($elementid) {
    return dbquery("SELECT * from elements where `id` = " . dbesc($elementid))[0];
}

function getelements() {
    return indexby(dbquery("SELECT * from elements where active = 'Y'"), "id");
}

function getelementname($elementid) {
    return dbquery("SELECT * from elements where `id` = " . dbesc($elementid))[0]["name"];
}

function initElementAmountsArray($elementids) {

    $arr = array();

    foreach ($elementids as $elementid) {
        $arr[$elementid] = 0.0;
    }

    return $arr;
}

function addElementAmountArrays($elemarray1, $elemarray2) {

    $arr = array();
    
    foreach($elemarray1 as $k => $v) {
        $arr[$k] = $elemarray1[$k] + $elemarray2[$k];
    } 

    return $arr;
}

?>
