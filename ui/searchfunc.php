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

function getfactorforallfoods($elementid, $foodgroups, $maxnum) {

    $sqlfoodgroupswhereclause = "";
    if (!is_null($foodgroups)) {
        if (!hasvalue($foodgroups, ALL_FOOD_GROUPS)) {        
            $sqlfoodgroupswhereclause .= "and (1=0 or `foods`.`group` in (" . arraytostring($foodgroups, ",", "\"") . ")";
            foreach ($foodgroups as $foodgroup) {
                if (len($foodgroup) == 1 or len($foodgroup) == 2) {
                    $sqlfoodgroupswhereclause .= " or `foods`.`group` like ('" . $foodgroup . "%')";
                }
            }
            $sqlfoodgroupswhereclause .= ")";
        }
    }

    $sql =  "select `foods`.`id`          as `id`, " .
            "       `foods`.`name`        as `name`, " .
            "       `foods`.`group`       as `group`, " .
            "       `factors`.`elementid` as `elementid`, " .
            "       `factors`.`amount`    as `amount`, " .
            "       `factors`.`units`     as `units`,  " .
            "       `factors`.`status`    as `status` " .
            "from   `foods`, `factors` " .
            "where  `foods`.`id` = `factors`.`foodid` " .
            "and    `factors`.`elementid` = '" . dbesc($elementid) . "' " .
            $sqlfoodgroupswhereclause . " " .
            "order  by factors.amount desc " .
            "limit  " . dbesc($maxnum) . " ";

    $records = dbquery($sql);

    return $records;
}

function showfoundfoods($elementid, $foodgroups, $maxnum) {

    $foodfactors = getfactorforallfoods($elementid, $foodgroups, $maxnum);

    if ($foodfactors === NULL) {
        return infobox("No results found.");
    }

    $html = starttable("tablestandard");

    $html .= lhead("Name");
    $html .= mhead("Group");
    $html .= mhead("Amount (per 100g)");
    $html .= rhead("Status");        
    
    foreach ($foodfactors as $foodfactor) {
        $html .= lcol($foodfactor["name"]);
        $html .= mcol(getcofidfoodgroupname($foodfactor["group"]) . ((SHOW_GROUP_CODES === TRUE) ? " (" . $foodfactor["group"] . ")" : ""));
        $html .= mcol($foodfactor["amount"]. $foodfactor["units"]);
        $html .= rcol($foodfactor["status"]);
    }

    $html .= endtable();

    return $html;
}

?>