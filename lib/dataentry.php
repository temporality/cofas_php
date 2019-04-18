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

//onchange=\"this.form.submit()\"

function processpost($name, $default) {
    return isset($_POST[$name]) ? $_POST[$name] : $default;
}

function clicked($controlname) {
    return isset($_POST[$controlname]) ? TRUE : FALSE;
}

function submitbutton($name, $label, $value, $cssclass="") {

    $html = "<button class='" . $cssclass . "' " .
            "type=\"submit\" " .
            "name=\"" . $name . "\" " .
            "value=\"" . $value . "\">" .
            $label . 
            "</button>\n";

    return $html;
}

function popupbutton($id, $label, $onclick, $cssclass="") {

    $html = "<button " .
              "type=\"button\" " .
              "id=\"" . $id . "\" " .            
              "class=\"" . $cssclass . "\" " .
              "onclick=\"" . $onclick . "\" " .
              ">" .
            $label . 
            "</button>\n";

    return $html;
}

function singleselect($name, $selectedvalue, $records, $valuefieldname, $textfieldname, $cssclass="", $showvalues=FALSE) {

    $html = "<select name=\"" . $name . "\" class=\"" . $cssclass . "\">\n";

    foreach ($records as $rec) {
        $html .= "<option " .
                 "value=\"" . htmlspecialchars($rec[$valuefieldname]) . "\" " .
                 (($rec[$valuefieldname] == $selectedvalue) ? "selected" : "") . 
                 ">" .
                 htmlspecialchars($rec[$textfieldname]) . 
                (($showvalues === TRUE) ? " (" . $rec[$valuefieldname] . ")" : "") .
                 "</option>\n";
    }

    $html .= "</select>\n";

    return $html;
}

function multiselect($name, $selectedvalues, $records, $valuefieldname, $textfieldname, $cssclass="", $showvalues=FALSE) {

    $html = "<select multiple size='10' name=\"" . $name . "[]\" class=\"" . $cssclass . "\">\n";

    foreach ($records as $rec) {

        $html .= "<option " .
                 "value=\"" . htmlspecialchars($rec[$valuefieldname]) . "\" " .
                 (hasvalue($selectedvalues, $rec[$valuefieldname]) ? "selected" : "") . 
                 ">" .
                 $rec[$textfieldname] . 
                 ( ($showvalues === TRUE) ? " (" . $rec[$valuefieldname] . ")" : "" ) .
                 "</option>\n";
    }

    $html .= "</select>\n";

    return $html;
}

function inputbox($name, $value, $cssclass="") {

   return "<input type=\"text\" name=\"" . $name . "\" value=\"" . $value . "\" class=\"" . $cssclass . "\" />";
}

function passwordbox($name, $value) {

   return  "<input type='password' name='" . $name . "' value='" . $value . "' />";
}

function radiobutton($id, $name, $value, $checked, $label) {
    return "<input type='radio' ".
           "id='"    . $id     . "' " .
           "name='"  . $name   . "' " .
           "value='" . $value  . "' " .
           ($checked == "Y" ? "checked" : "") . ">" .
           "<label for='" . $id . "'>" . $label . "</label>";
}

function hiddenpost($name, $value) {
     return  "<input type='hidden' name='" . $name . "' value='" . $value . "' />";  
}
?>
