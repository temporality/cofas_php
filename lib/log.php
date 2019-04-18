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

// allow creation of log file with a) mkdir logs b) chown www-data logs

$g_logoutput = "";

if (LOG_FILE === TRUE) {  

    if (file_exists(LOG_FILE_NAME) === FALSE) {

        $f = fopen(LOG_FILE_NAME, "w");

        if ($f === FALSE) {        
            exit("Error opening log file during creation");
        }

        if (fclose($f) === FALSE) {
            exit("Error closing log file during creation");
        }        
    }
}

function writelog($str, $eol=0) {
global $g_logoutput;

    switch($eol) { 
        case 0:  $eolfile = "";     $eolhtml = "";             break;
        case 1:  $eolfile = "\n";   $eolhtml = "<br />";       break;
        case 2:  $eolfile = "\n\n"; $eolhtml = "<br /><br />"; break;
        default: abort("Invalid eol passed to writelog");      break;
    }

    if ($eol == 0) {
        $str = "[" . date( "Y-m-d H-i-s T", time()) . "] " . $str;
    }

    if (LOG_ECHO === TRUE) {
        $g_logoutput .= $str . $eolhtml;
    }

    if (LOG_FILE === TRUE) {
        if (file_put_contents(LOG_FILE_NAME, $str . $eolfile, FILE_APPEND) === FALSE) {
            exit("Error writing log file");
        }
    }        
}

function writelogln($str) {
    writelog($str, 1);
}

function showvar($v) {
    return "<pre>" . var_export($v, TRUE) . "</pre>";
}

?>