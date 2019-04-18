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

require("../env/env.php");
require (LIB_DIR . "cofas.php");
require (UI_DIR  . "foodsfunc.php");

dbopen();
validatesession();
starthtmlpage("Nutrients in Food");

$foodid = processpost("foodid", NULL);

$foods = getfoods();

if ($foods !== NULL && $foodid === NULL) {
    $foodid = $foods[array_keys($foods)[0]]['id'];
} 

echo startform();

echo foodselect($foods, $foodid, "foodid", "foodpageselector");

echo endform();

if ($foodid !== NULL) {
    echo showcomposition($foodid);
}

endhtmlpage();
dbclose();

?>