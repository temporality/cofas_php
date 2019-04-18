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

function showrequirements() {

    $reqs = indexby(getrequirements("UK GOV 2016", "Recommended Daily Intake", "Males 19-64"), "id");

    $html = starttable("tablestandard");

    $html .= lhead("Nutrient");
    $html .= mhead("Amount");
    $html .= mhead("Authority");
    $html .= mhead("Measurement");
    $html .= rhead("Category");
    
    foreach ($reqs as $req) {       
        $html .= lcol($req["name"]);
        $html .= mcol($req["value"] . $req["units"]);
        $html .= mcol($req["authority"]);
        $html .= mcol($req["measurement"]);
        $html .= rcol($req["application"]);
    }

    $html .= endtable();

    return $html;
}

?>