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

function starttable($tablecssclass="", $boxclass="tablebox") {
    return startbox($boxclass) .
           "<table class='" . $tablecssclass . "'>\n";
}

function endtable() {
    return "</table>\n" .
           endbox();
}

function startwidetable($cssclass="") {
    return startbox("widetableoutercontainer") .
           "<div class=\"widetableinnercontainer\">" .
           "<table class='" . $cssclass . "'>\n";
}

function endwidetable() {
    return "</table>\n" .
           "</div>" .
           endbox();
}

function startlayout($cssclass="") {
    return  "<table class='" . $cssclass . "'>\n";
}

function endlayout($cssclass="") {
    return "</table>\n";
}

function startgrid($cssclass="") {
    return  "<table class='" . $cssclass . "'>\n";
}

function endgrid() {
    return "</table>\n"; 
}


function lhead($s, $cssclass="") {
    return "<tr><th class='" . $cssclass . "'>" . $s . "</th>";
}

function mhead($s, $cssclass="") {
    return "<th class='" . $cssclass . "'>" . $s . "</th>";    
}

function rhead($s, $cssclass="") {
    return "<th class='" . $cssclass . "'>" . $s . "</th></tr>\n";
}

function lcol($s, $cssclass="") {
    return "<tr><td class='" . $cssclass . "'>" . $s . "</td>";
}

function mcol($s, $cssclass="") {
    return "<td class='" . $cssclass . "'>" . $s . "</td>";    
}

function wcol($s, $colspan, $cssclass="") {
    return "<td class='" . $cssclass . "' colspan='" . $colspan . "'>" . $s . "</td>";
}

function rcol($s, $cssclass="") {
    return "<td class='" . $cssclass . "'>" . $s . "</td></tr>\n";   
}

function trow($s) {
    return "<tr><td>" . $s . "</td></tr>\n";
}

function startrow() {
    return "<tr>";
}

function theader($s) {
    return "<th>" . $s ."</th>";
}

function tdetail($s, $cssclass="") {
    return "<td class='" . $cssclass . "'>" . $s ."</td>";
}

function endrow() {
    return "</tr>\n";
}


function startbox($cssclass="", $id="") {
    return "<div id=\"" . $id . "\" class=\"" . $cssclass . "\">\n";
}

function endbox() {
    return "</div>\n";
}

function startform() {
    return "<form action='" . $_SERVER["PHP_SELF"] . "' method='post'>\n";
}

function endform() {
    return "</form>\n";
}

function showpageintro($text) {
    return "<div class='pageintrotext'>" . $text ."</div>";
}

function infobox($text) {
    return startbox("infobox") . $text . endbox();
}

?>
