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

function getitem($itemid) {
    return dbquery("SELECT * FROM `combinationitems` " .
                   "WHERE `id` = '"    . dbesc($itemid) . "' " .
                   "AND   `userid` = " . getuserid()
                  ) [0];
}

function getcombinations() {
    return dbquery("SELECT * FROM combination WHERE `userid` = " . getuserid());
}

function getcombination($id) {
    return dbquery("SELECT * FROM combination " .
                   "WHERE `id` = '"    . dbesc($id) . "' " .
                   "AND   `userid` = " . getuserid())[0];
}

function getcombinationname($id) {
    return dbquery("SELECT name FROM combination " .
                   "WHERE `id` = '"    . dbesc($id) . "' " .
                   "AND   `userid` = " . getuserid())[0]["name"];
}

function getcombinationitems($combinationid) {
    return indexby(dbquery("SELECT * FROM combinationitems " . 
                           "WHERE  `combinationid` = '" . dbesc($combinationid) . "' " .
                           "AND    `userid` = "         . getuserid()
                  ), "id");
}

function addcombination($name, $description) {
    return createrecord("combination", array("name"        => $name, 
                                             "description" => $description,
                                             "userid"      => getuserid()
                                            )
                       );
}

function addcombinationitem($combinationid, $foodid, $amount) {
    return createrecord("combinationitems", array("combinationid" => $combinationid, 
                                                  "foodid"        => $foodid, 
                                                  "amount"        => $amount,
                                                  "userid"        => getuserid()
                                                 )
                       );
}

function editcombinationitem($combinationid, $itemid, $foodid, $amount) {

      dbcommand("UPDATE `combinationitems` " .
                "SET    `foodid` = " .        dbesc($foodid)        . ", " .
                "       `amount` = " .        dbesc($amount)        . " " .
                "WHERE  `id` = "     .        dbesc($itemid)        . " " .
                "AND    `combinationid` = " . dbesc($combinationid) . " " .
                "AND    `userid` = " .        getuserid()
             );

}

function removecombination($id) {
    dbcommand("DELETE FROM `combinationitems` " .
              "WHERE `combinationid` = " . dbesc($id) . " " .
              "AND   `userid` = "        . getuserid()
             );

    dbcommand("DELETE FROM `combination` " .
              "WHERE `id` = "     . dbesc($id) . " " .
              "AND   `userid` = " . getuserid()
             );
}

function removecombinationitem($id) {
    dbcommand("DELETE FROM `combinationitems` " .
              "WHERE `id` = "     . dbesc($id) . " " .
              "AND   `userid` = " . getuserid()
             );
}

function renamecombination($id, $name) {
    dbcommand("UPDATE `combination` " .
              "SET    `name` ='" .   dbesc($name) . "' " .
              "WHERE  `id` = "     . dbesc($id) . " " .
              "AND    `userid` = " . getuserid()
             );
}  

function listselect($listid, $name, $cssclass="") {
  
    $records = dbquery("SELECT   `id`, `name`, `description` from `combination` " .
                       "WHERE    `userid` = " . getuserid() . " " .
                       "ORDER BY `name`");

    $html = "<select name='" . $name . "' class='" . $cssclass . "' onchange='this.form.submit()'>\n";

    foreach ($records as $rec) {
        $html .= "<option " .
                 "value='" . htmlspecialchars($rec['id']) . "' " .
                 (($rec['id'] == $listid) ? "selected" : "") . 
                 ">" .
                 htmlspecialchars($rec["name"]) . 
                 "</option>\n";
    }

    $html .= "</select>\n";

    return $html;
}

/* Calculate combination totals */

function calcElementTotalsForItems($items, $elementids) {

    if ($items == NULL || $elementids == NULL) {
        return NULL;
    }

    $elemtotals = initElementAmountsArray($elementids);
     
    foreach ($items as $itemid => $item) {
        $elemamounts = getElementAmountsForFoodWeight($item["foodid"], $item["amount"], $elementids);
        $elemtotals = addElementAmountArrays($elemtotals, $elemamounts);
    }

    return $elemtotals;
}

/* Analysis functions */

function calcElementAmountPerItem($items, $elementids) {

    if ($items == NULL || $elementids == NULL) {
        return NULL;
    }

    $arr = array();

    foreach ($items as $itemid => $item) {
        $arr[$itemid] = getElementAmountsForFoodWeight($item["foodid"], $item["amount"], $elementids);
    }

    return $arr;
}

function calcPercentRequirementsPerItem($items, $requirementamounts, $elementids) {

    if ($items == NULL || $requirementamounts == NULL || $elementids == NULL) {
        return NULL;
    }

    $arr = array();

    foreach ($items as $itemid => $item) {

        $elementamounts = getElementAmountsForFoodWeight($item["foodid"], $item["amount"], $elementids);
        $arr[$itemid] = calcElementAmountsAsPercentRequirements($elementamounts, $requirementamounts);
    }

    return $arr;
}

function calcElementAmountBreakdownPerFood($items, $elementids) {

    $foods = array();

    foreach ($items as $itemid => $item) {

        $elemamounts = getElementAmountsForFoodWeight($item["foodid"], $item["amount"], $elementids);

        if (haskey($foods, $item["foodid"])) {
            $foods[$item["foodid"]] = addElementAmountArrays($elemamounts, $foods[$item["foodid"]]);
        } else {
            $foods[$item["foodid"]] = $elemamounts;
        }
    }

    return $arr;
}

function calcElementAmountBreakdownPerElement($items, $elementids) {

    if ($items == NULL || $elementids == NULL) {
        return NULL;
    }

    $arr = array();

    foreach ($items as $itemid => $item) {

        $elemamounts = getElementAmountsForFoodWeight($item["foodid"], $item["amount"], $elementids);

        foreach ($elementids as $elementid) {
            $arr[$itemid][$elementid] = $elemamounts[$elementid];
        }
    }

    return $arr;
}

?>
