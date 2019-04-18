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

define("HALT_ON_ERROR", TRUE); // set to false for test/debug only

function errorhandler($errno, $errstr, $errfile, $errline, $errcontext) {

    echo "<pre>";
    echo "HALTED (ERROR): " . $errstr . " (" . $errno . ") in " . $errfile . " (" . $errline . ") <br />";
    //echo showvar($errcontext);
    debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    echo "</pre>";
    flush();
    exit();
}

set_error_handler("errorhandler", E_ALL | E_STRICT);

function exceptionhandler($exception) {

    $message = $exception->getMessage();
    $code    = $exception->getCode();
    $file    = $exception->getFile();
    $line    = $exception->getLine();

    echo "<pre>";
    echo "HALTED (EXCEPTION): " . $message  . " (" . $code . ") in " . $file . " (" . $line . ") <br />";
    echo $exception->getTraceAsString(), "<br />";
    echo "</pre>";
    flush();
    exit();
}

set_exception_handler("exceptionhandler");

function abort($str) {
    global $g_db;

    if ($g_db != NULL) {
        if ($g_db->connect_errno != 0 || $g_db->connect_error != "") {
            writelogln("Mysql connect error: (" . $g_db->connect_errno . ") '" . $g_db->connect_error);
        }

        if ($g_db->errno != 0 || $g_db->error != "") {
            writelogln("Mysql error: (" . $g_db->errno . ") '" . $g_db->error);
        }
    }
    
    writelogln($str);

    if (HALT_ON_ERROR == TRUE) {
        echo "<pre>";
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        echo "</pre>";
        writelogln("HALTED");
        exit("HALTED");
    } else {
        throw new Exception("HALTED");
    }
}

?>