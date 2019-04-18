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

function edititemspopupforms($items, $listid) {

    foreach ($items as $item) {
        echo startbox("popupbox", "editfoodpopup" . $item["id"]);
        echo startform();
        echo hiddenpost("listid", $listid);
        echo startlayout("standardlayout");
        echo trow(foodnameselect($item["foodid"], "editfoodid"));
        echo trow(inputbox("editfoodamount", $item["amount"]) . " g" .
                  submitbutton("edititemid", "Edit Food", $item["id"], "popupbutton") .
                  popupbutton("editfoodclose" . $item["id"], 
                              "Cancel", 
                              "document.getElementById('editfoodpopup" . $item["id"] . "').style.display='none'", 
                              "popupbutton"));
        echo endlayout();
        echo endform();
        echo endbox();
    }
}    

function showitemstable($items, $listid) {
 
    $html =  startform();
    $html .= hiddenpost("listid", $listid);
    $html .= starttable("tablestandard");

    $html .= lhead("Name");
    $html .= mhead("Amount");
    $html .= mhead("");
    $html .= rhead("");

    if ($items !== NULL) {    
        foreach ($items as $item) {
            $html .= lcol(getfood($item["foodid"])["name"]);
            $html .= mcol($item["amount"] . "g");
            $html .= mcol(popupbutton("editfoodopen" . $item["foodid"], 
                                      "Edit", 
                                      "document.getElementById('editfoodpopup" . $item["id"] . "').style.display='block'", 
                                      "itemslistbutton"));
            $html .= rcol(submitbutton("removefood", "Remove", $item["id"], "itemslistbutton"));
        }
    } else {
        $html .= wcol("No foods entered in list", 3);
    }

    $html .= endtable();
    $html .= endform();

    return $html;
}

function showelementtotalstable($items) {

    $elements = getelements();
    $elementstotals = calcElementTotalsForItems($items, getlistofkeys($elements));
     
    $html = starttable("tablestandard", "tablenutrienttotalsbox");
    //$html = starttable("tablenutrienttotals");

    $html .= lhead("Nutrient");
    $html .= rhead("Total Amount");
    
    foreach ($elementstotals as $id => $total) {

        $html .= lcol($elements[$id]["name"]);
        $html .= rcol(round($total, 2, PHP_ROUND_HALF_UP) . $elements[$id]["defaultunits"]);
    }

    $html .= endtable();

    return $html;
}

function showrequirementstable($items) {

    $elements = getelements();
    $elementstotals = calcElementTotalsForItems($items, getlistofkeys($elements));

    $requirements = indexby(getrequirements("UK GOV 2016", "Recommended Daily Intake", "Males 19-64"), "elementid");
    $requirementamounts = keyfields($requirements, "value");

    $requirementpercentages = calcElementAmountsAsPercentRequirements($elementstotals, $requirementamounts);

    //$html = starttable("tablerequirementtotals");
    $html = starttable("tablestandard", "tablerequirementtotalsbox");

    $html .= lhead("Nutrient");
    $html .= mhead("Total Amount");
    $html .= mhead("Req");
    $html .= rhead("% of Req", "listpage_reqtbl_prc");
    
    foreach ($requirementpercentages as $id => $percent) {
        if (isset($elementstotals[$id])) {
            $html .= lcol($requirements[$id]["name"]);
            $html .= mcol(round($elementstotals[$id], 2, PHP_ROUND_HALF_UP) . $elements[$id]["defaultunits"]);
            $html .= mcol(round($requirementamounts[$id], 2, PHP_ROUND_HALF_UP) . $requirements[$id]["units"]);
            $html .= rcol(round($percent, 2, PHP_ROUND_HALF_UP) . "%", "listpage_reqtbl_prc");
        }
    }

    $html .= endtable();

    return $html;
}

?>
