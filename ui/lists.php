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
require (UI_DIR  . "listsfunc.php");

dbopen();
validatesession();
starthtmlpage("Lists of Foods");

$listid = NULL;

if (clicked("removelist")) {
    $listid = processpost("listid", NULL);
    removecombination($listid);
    $listid = NULL;
}

if (clicked("renamelist")) {
    $listid = processpost("listid", NULL);
    $renamelistname = processpost("renamelistname", "");
    renamecombination($listid, $renamelistname);
}

if (clicked("addlist")) {
    $addlistname = processpost("addlistname", "");
    $addlistdescription = processpost("addlistdescription", "");
    $listid = addcombination($addlistname, $addlistdescription);
}

if (clicked("addfood")) {
    $listid = processpost("listid", NULL);
    $addfoodid = processpost("addfoodid", NULL);
    $addfoodamount = processpost("addfoodamount", 100);
    addcombinationitem($listid, $addfoodid, $addfoodamount);
} else {
    $addfoodid = 1;
    $addfoodamount = 100;
}

if (clicked("removefood")) {
    $listid = processpost("listid", NULL);
    $removefood = processpost("removefood", NULL);
    removecombinationitem($removefood);
}

if (clicked("edititemid")) {
    $listid = processpost("listid", NULL);
    $edititemid = processpost("edititemid", NULL);
    $editfoodid = processpost("editfoodid", NULL);
    $editfoodamount = processpost("editfoodamount", 100);    
    editcombinationitem($listid, $edititemid, $editfoodid, $editfoodamount);
}

if (clicked("listidselector")) {
    $listid = processpost("listidselector", NULL);
}

$lists = getcombinations();

if ($lists !== NULL && $listid === NULL) {
    $listid = $lists[array_keys($lists)[0]]['id'];
}    

if ($listid !== NULL) {
    $listname = getcombinationname($listid);
    $items = getcombinationitems($listid);
} else {
    $items = NULL;    
}

if ($listid !== NULL) {
    echo startform();
    echo listselect($listid, "listidselector", "listselector");
    echo endform();
}

if ($listid !== NULL) {
    echo showitemstable($items, $listid);
}    


echo startbox("normalbox");
if ($listid !== NULL) {
    echo popupbutton("addfoodopen", "Add Food", "document.getElementById('addfoodpopup').style.display='block'", "popupopenbutton");
}    
echo popupbutton("addlistopen", "New List", "document.getElementById('addlistpopup').style.display='block'", "popupopenbutton");
if ($listid !== NULL) {
    echo popupbutton("renamelistopen", "Rename List", "document.getElementById('renamelistpopup').style.display='block'", "popupopenbutton");
    echo popupbutton("removelistopen", "Delete List", "document.getElementById('removelistpopup').style.display='block'", "popupopenbutton");
}
echo endbox();

/* Add food */



if ($listid !== NULL) {
    echo startbox("popupbox", "addfoodpopup");
    echo startform();
    echo hiddenpost("listid", $listid);
    echo startlayout("standardlayout");
    echo trow(foodnameselect($addfoodid, "addfoodid"));
    echo trow(inputbox("addfoodamount", $addfoodamount) . " g" .
              submitbutton("addfood", "Add Food", "addfood", "popupbutton") .
              popupbutton("addfoodclose", "Cancel", "document.getElementById('addfoodpopup').style.display='none'", "popupbutton"));
    echo endlayout();
    echo endform();
    echo endbox();
}
   
/* Add list */

echo startbox("popupbox", "addlistpopup");
echo startform();
echo hiddenpost("listid", $listid);
echo startlayout("standardlayout");
echo lcol(inputbox("addlistname", "", "listnameinputbox"));
echo mcol(submitbutton("addlist", "New List", "addlist", "popupbutton"));
echo rcol(popupbutton("addlistclose", "Cancel", "document.getElementById('addlistpopup').style.display='none'", "popupbutton"));
echo endlayout();
echo endform();
echo endbox();    

/* Rename list */

if ($listid !== NULL) {
    echo startbox("popupbox", "renamelistpopup");
    echo startform();    
    echo hiddenpost("listid", $listid);
    echo startlayout("standardlayout");
    echo lcol(inputbox("renamelistname", $listname, "listnameinputbox"));
    echo mcol(submitbutton("renamelist", "Rename List", "renamelist", "popupbutton"));
    echo rcol(popupbutton("renamelistclose", "Cancel", "document.getElementById('renamelistpopup').style.display='none'", "popupbutton"));
    echo endlayout();
    echo endform();
    echo endbox();      
}

/* Remove list */

if ($listid !== NULL) {
    echo startbox("popupbox", "removelistpopup");
    echo startform();
    echo hiddenpost("listid", $listid);
    echo startlayout("standardlayout");    
    echo lcol(submitbutton("removelist", "Delete List", "removelist", "popupbutton"));
    echo rcol(popupbutton("removelistcancel", "Cancel", "document.getElementById('removelistpopup').style.display='none'", "popupbutton"));
    echo endlayout();        
    echo endform();
    echo endbox();
}

/* Nutrient and requirements summary tables */

if ($listid !== NULL) {
    if ($items !== NULL) {
        echo startlayout("tablelayout");
        echo lcol(showelementtotalstable($items));
        echo rcol(showrequirementstable($items));
        echo endlayout();
    } else {
        echo infobox("Please add foods to the list.");
    }
}

if ($items !== NULL) {
    edititemspopupforms($items, $listid);
}    

endhtmlpage();
dbclose();

?>