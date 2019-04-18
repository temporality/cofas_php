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

/* Data access */

function getfood($foodid) {
    return dbquery("SELECT * from foods where `id` = " . dbesc($foodid))[0];
}

function getfactor($foodid, $elementid) {
    return indexby(dbquery("SELECT * from factors where `foodid` = " . dbesc($foodid) . " and `elementid` = " . dbesc($elementid)), "elementid");
}

function getfactors($foodid) {
    return indexby(dbquery("SELECT * from factors where `foodid` = " . dbesc($foodid)), "elementid");
}

/* Factor calculations */

function factorstatusstring($amount, $status) {
    switch ($status) {
        case NO_DATA:            return "--";
        case TRACE_AMOUNT:       return "tr";
        case SIGNIFICANT_AMOUNT: return "sig";
        case AMOUNT_SPECIFIED:   return $amount . "*";        
        default:                               abort("Factor status invalid");    
    }
}

function iscalculable($amount) {
    if (!is_numeric($amount)) { return false; };
    if ($amount == 0.0) { return false; };
    return TRUE;
}

function calcfactoramount($foodamount, $factor) {
    if (iscalculable($factor["amount"])) {
        return $foodamount * ($factor["amount"] / 100);
    } else {
        return 0.0;
    }
}

function addfactoramounts($factor1, $factor2) {
    if (iscalculable($factor1["amount"]) && iscalculable($factor2["amount"])) {
        return $factor1["amount"] + $factor2["amount"];
    } else {
        return 0.0;
    }
}

/* Calculate element totals */

function getElementAmountsForFoodWeight($foodid, $foodweight, $elementids) {

    $factors = keepkeys(getfactors($foodid), $elementids);

    $elemamounts = initelementamountsarray($elementids);

    foreach ($factors as $elemid => $factor) {
       $elemamounts[$elemid] = calcfactoramount($foodweight, $factor); 
    }

    return $elemamounts;
}

?>
