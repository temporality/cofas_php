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

require ("../lib/cofidgroups.php");

function foodnameselect($selected, $selectname, $cssclass="") {
    $records = dbquery("SELECT `name`, `id` from `foods` order by `name`");
    return singleselect($selectname, $selected, $records, "id", "name", $cssclass, SHOW_FOOD_CODES);
}

function nutrientnameselect($selected, $selectname, $cssclass="") {
    $records = dbquery("SELECT `name`, `id` from `elements` where active = 'Y' order by `name`");
    return singleselect($selectname, $selected, $records, "id", "name", $cssclass="", SHOW_NUTRIENT_CODES);
}

function foodgroupselect($selected, $selectname, $cssclass="") {
    global $cofidfoodgroups;
    return multiselect($selectname, $selected, $cofidfoodgroups, 1, 0, $cssclass="", SHOW_GROUP_CODES);
}

?>
