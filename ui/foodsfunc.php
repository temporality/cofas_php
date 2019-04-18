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

function getfoods() {
    return indexby(dbquery("SELECT `id`, `name` from `foods` order by `name`"), "id");
}    

function foodselect($foods, $foodid, $name, $cssclass="") {
  
    $html = "<select name='" . $name . "' class='" . $cssclass . "' onchange='this.form.submit()'>\n";

    foreach ($foods as $food) {
        $html .= "<option " .
                 "value='" . htmlspecialchars($food['id']) . "' " .
                 (($food['id'] == $foodid) ? "selected" : "") . 
                 ">" .
                 htmlspecialchars($food["name"]) . 
                 "</option>\n";
    }

    $html .= "</select>\n";

    return $html;
}

function showcomposition($foodid) {

    $food = getfood($foodid);
    $factors = getfactors($foodid);
    $elements = getelements();

    $html = starttable("tablestandard");

    $html .= lhead("Nutrient");
    $html .= rhead("Amount (per 100g)");
    
    foreach ($elements as $element) {
        if (haskey($factors, $element["id"])) {
            $factor = $factors[$element["id"]];
            $content = "";
            switch ($factor["status"]) {
                case "NULL":  $content = "unknown";     break;
                case "SIG":   $content = "significant"; break;
                case "TRACE": $content = "trace";       break;
                default:      $content = ($factor["amount"] . $factor["units"]);
            }
            $html .= lcol($element["name"]) . rcol($content);
        }
    }

    $html .= endtable();

    return $html;
}

?>
