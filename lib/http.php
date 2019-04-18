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


function httpredirect($url) {

    $file = "";
    $line = 0;

    if (headers_sent($file, $line)) {
        abort("Http headers already sent in file: \"". $file . "\" at line: " . $line);
    }

    header("Location: " . $url, TRUE);
    exit(0);
}

function issetsessionvar($name) {

    if (isset($_COOKIE[$name])) {
        return TRUE;
    }

    return FALSE;
}

function setsessionvar($name, $value) {

    $ok = setcookie($name, $value, 0, "/", "", false, false);

    if ($ok === FALSE) {
         abort("Cookie set after headers sent");
    }
}

function getsessionvar($name) {

    if (isset($_COOKIE[$name])) {
        return $_COOKIE[$name];
    } 

    abort("Cookie: \"" . $name . "\" not set");
}

function clearsessionvar($name) {

    $ok = setcookie($name, "", time() - 3600, "/", "", false, false);

    if ($ok === FALSE) {
         abort("Cookie cleared after headers sent");
    }
}

function jsontoarray($json) {
    $arr = json_decode($json, true);
    if ($arr == NULL) {
        abort("Internal data read error: " . json_last_error_msg());
    }

    return $arr;
}

function displayjson($json) {
    $arr = jsontoarray($json);
    echo "<pre>";
    showvar($arr);
    echo "</pre>";
}

?>