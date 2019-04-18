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

function showfactorratioforallfoods($element1id, $element2id, $foodgroups, $maxnum) {

    $elements = getfactorratioforallfoods($element1id, $element2id, $foodgroups, $maxnum);

    $element1name = getelementname($element1id);
    $element2name = getelementname($element2id);    

    $html = starttable("tablestandard");

    $html .= lhead("Food");
    $html .= mhead("Group");
    $html .= mhead("Amount&nbsp;of<br />" . $element1name . "<br />(per&nbsp;100g)");
    $html .= mhead("/");
    $html .= mhead("Amount&nbsp;of<br />" . $element2name . "<br />(per&nbsp;100g)");
    $html .= rhead("Ratio");
    
    foreach ($elements as $element) {

        $html .= lcol($element["name"]);
        $html .= mcol(getcofidfoodgroupname($element["group"]) . ((SHOW_GROUP_CODES === TRUE) ? " (" . $element["group"] . ")" : ""));        
        $html .= mcol($element["amount1"] . $element["units1"]);
        $html .= mcol("");
        $html .= mcol($element["amount2"] . $element["units2"]);                        
        $html .= rcol(round($element["ratio"], 2, PHP_ROUND_HALF_UP));
    }

    $html .= endtable();

    return $html;
}

function getfactorratioforallfoods($element1id, $element2id, $foodgroups, $maxnum) {

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

    $sql =  "select `foods`.`name`        as `name`, " .
            "       `foods`.`group`       as `group`, " .
            "       `fac1`.`amount`       as `amount1`, " .
            "       `fac1`.`units`        as `units1`,  " .
            "       `fac2`.`amount`       as `amount2`, " .
            "       `fac2`.`units`        as `units2`,  " .
            "       (`fac1`.`amount`/`fac2`.`amount`) as `ratio` " .
            "from   `foods`, `factors` as `fac1`, `factors` as `fac2` " .
            "where  `foods`.`id` = `fac1`.`foodid` " .
            "and    `foods`.`id` = `fac2`.`foodid` " .
            "and    `fac1`.`elementid` = '" . dbesc($element1id) . "' " .
            "and    `fac2`.`elementid` = '" . dbesc($element2id) . "' " .
            "and    `fac1`.`status` = 'OK' " .
            "and    `fac2`.`status` = 'OK' " .            
            $sqlfoodgroupswhereclause .  " " .
            "order  by `ratio` desc " .
            "limit  " . dbesc($maxnum) . " ";

    $records = dbquery($sql);

    return $records;
}

?>
