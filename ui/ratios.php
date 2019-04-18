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
require (UI_DIR  . "ratiosfunc.php");

dbopen();
validatesession();
starthtmlpage("Nutrient Ratios");

$nutrient1id = processpost("nutrient1id", 1);
$nutrient2id = processpost("nutrient2id", 1);
$maxresults = processpost("maxresults", 50);
$foodgroups = processpost("foodgroups", NULL);

if ($foodgroups === NULL) {
    $foodgroups = $cofidfoodgroups[ALL_FOOD_GROUPS];
}

echo startform();

echo startbox("normalbox");

echo startlayout("standardlayout");

echo lcol("Food groups:");
echo rcol(foodgroupselect($foodgroups, "foodgroups"));

echo lcol("Ratio of: ");
echo rcol(nutrientnameselect($nutrient1id, "nutrient1id") . " to " . 
          nutrientnameselect($nutrient2id, "nutrient2id"));

echo lcol("Number of results: ");
echo rcol(inputbox("maxresults", $maxresults));

echo lcol(submitbutton("showratios", "Show ratios", "showratios"));
echo rcol("");

echo endlayout();

echo endbox();

echo endform();

if (clicked("showratios")) {
    echo showfactorratioforallfoods($nutrient1id, $nutrient2id, $foodgroups, $maxresults);
}

endhtmlpage();
dbclose();

?>
