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

/* Calculate composition for each item */

/* Table generating functions */

function analysisradiobutton($id, $name, $value, $checked, $label) {
    return "<input type='radio' " .
           "class='analysisradiobutton' " .
           "id='"    . $id     . "' " .
           "name='"  . $name   . "' " .
           "value='" . $value  . "' " .
           ($checked == "Y" ? "checked" : "") . " " .
           "onclick='this.form.submit()' />" .
           "<label class='analysisradiobuttonlabel' for='" . $id . "'>" . $label . "</label>";
}

function showitemstable($items) {
 
    $html = starttable("tablestandard");

    $html .= lhead("Food");
    $html .= rhead("Amount");

    if ($items !== NULL) {     
        foreach ($items as $item) {

            $html .= lcol(getfood($item["foodid"])["name"]);
            $html .= rcol($item["amount"] . "g");
        }
    } else {
        $html .= wcol("No foods entered in list", 2);
    }       

    $html .= endtable();

    return $html;
}

function showelementamountsperitemtable($items) {

    $elements = getelements();
    $elementids = getlistofkeys($elements);
    $elementamountsperitem = calcElementAmountPerItem($items, $elementids);  //itemid=>elementid=>value

    $html = startwidetable("tablewide");

    $html .= startrow();
    $html .= theader("Nutrient");
    foreach ($items as $itemid => $item) {
        $html .= theader(foldstring(getfood(getitem($itemid)["foodid"])["name"], 4));
    }
    $html .= endrow();
   
    foreach ($elements as $elementid => $element) {

        $html .= startrow();   
    
        $html .= tdetail($element["name"], "tablewidefirstcol");

        foreach ($items as $itemid => $item) {
            $html .= tdetail($elementamountsperitem[$itemid][$elementid]);
        }

        $html .= endrow();   
    }

    $html .= endwidetable();

    return $html;
}

function showpercentrequirementsperitemtable($items) {

    $elements = getelements();
    $elementids = getlistofkeys($elements);
    $requirements = indexby(getrequirements("UK GOV 2016", "Recommended Daily Intake", "Males 19-64"), "elementid");
    $requirementamounts = keyfields($requirements, "value");
    $percentrequirements = calcPercentRequirementsPerItem($items, $requirementamounts, $elementids); // itedtemid=>elementid=>%amount   

    $html = startwidetable("tablewide");

    $html .= startrow();
    $html .= theader("Nutrient");
    foreach ($items as $itemid => $item) {
        $html .= theader(foldstring(getfood(getitem($itemid)["foodid"])["name"], 4));
    }
    $html .= endrow();
   
    foreach ($requirements as $elementid => $requirement) {

        $html .= startrow();   
    
        $html .= tdetail($requirements[$elementid]["name"], "tablewidefirstcol");

        foreach ($items as $itemid => $item) {
            $percentage = $percentrequirements[$itemid][$elementid];
            if ($percentage < 1.0) {
                $html .= tdetail("<1%");
            } else {
                $html .= tdetail(round($percentrequirements[$itemid][$elementid], 0, PHP_ROUND_HALF_UP) . "%");
            }
        }

        $html .= endrow();   
    }

    $html .= endwidetable();

    return $html;
}

?>