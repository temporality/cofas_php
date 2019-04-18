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

function getanalysisitems($analysisid) {

    return dbquery("SELECT * from analysisitems " .
    	           "WHERE  analysisid = '" . dbesc($analysisid) . "' " .
    	           "AND    userid     = "  . getuserid());
}

function addanalysis($name, $description) {

    return createrecord("analysis", array("name"        => $name, 
    	                                  "description" => $description, 
    	                                  "userid"      => getuserid()
    	                                 )
                       );
}

function addanalysisitem($analysisid, $foodid, $amount) {
	
    return createrecord("analysisitems", array("analysisid" => $analysisid, 
    	                                       "foodid"     => $foodid, 
    	                                       "amount"     => $amount, 
                                               "userid"     => getuserid()
                                              )
                       );
}

?>
