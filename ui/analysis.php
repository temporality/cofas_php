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
require (UI_DIR  . "analysisfunc.php");

dbopen();
validatesession();
starthtmlpage("Analysis of Food Lists");

$listid = processpost("listidselector", NULL);
$analysistype = processpost("analysistype", "amount");

if ($listid === NULL) {
	$lists = getcombinations();
    if ($lists !== NULL) {
    	$listid = $lists[array_keys($lists)[0]]['id'];
    }
}    

if ($listid !== NULL) {
    $items = getcombinationitems($listid);
} else {
    $items = NULL;    
}

if ($listid !== NULL) {

	echo startform();

	echo listselect($listid, "listidselector", "listselector");

    echo startbox("normalbox");

	echo startlayout();

	echo lcol(analysisradiobutton("analysistype1", "analysistype", "amount",  (($analysistype == "amount") ? "Y" : "N"), "Amount of nutrient"));

	echo rcol(analysisradiobutton("analysistype2", "analysistype", "percent", (($analysistype == "percent") ? "Y" : "N"), "Percentage of daily requirements"));

	echo endlayout();

    echo endbox();	

	echo endform();
}	

if ($listid !== NULL) {	
    echo showitemstable($items);
}    

if ($items !== NULL) {
	if ($analysistype == "amount") {
	    echo showelementamountsperitemtable($items);
	} else {
	    echo showpercentrequirementsperitemtable($items);
	}
}

if ($listid === NULL) {
    echo infobox("Please create a list to see an analysis.");
} else {
	if ($items === NULL) {
		echo infobox("Please add foods to the list to see an analysis.");
	}
}	

endhtmlpage();
dbclose();

?>