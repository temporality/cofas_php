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

define("DB_CHARSET",     "utf8");
define("DB_COLLATION",   "utf8_general_ci");

$g_dblogging = FALSE;
$g_db = NULL;

function dbloggingon() {
global $g_dblogging;

    $g_dblogging = TRUE;
}

function dbloggingoff() {
global $g_dblogging;

    $g_dblogging = FALSE;    
}

function isdbloggingon() {
global $g_dblogging;

    return $g_dblogging;    
}

function dbopen() {
    global $g_db;

    $g_db = new mysqli(DB_HOST, DB_USERNAME, DB_USERPW, DB_DATABASENAME);

    if ($g_db->connect_errno) {
        abort("Error connecting to database");
    }
 
    if (isdbloggingon() === TRUE) {   
        writelogln("Connected to database");
    }

    if ($g_db->set_charset(DB_CHARSET) === FALSE) {
        abort("Unable to set database character set to '" . DB_CHARSET . "'");
    }

    if (isdbloggingon() === TRUE) {
        writelogln("Set database character set to '" . DB_CHARSET . "'");
    }

}

function dbclose() {
    global $g_db;

    if ($g_db->close() === FALSE) {
        abort("Error closing database");
    }

    if (isdbloggingon() === TRUE) {    
        writelogln("Closed database");
    }    
}

function dbesc($str) {
    global $g_db;

    return $g_db->real_escape_string($str);
}

function dbquery($sql) {
    global $g_db;

    if (isdbloggingon() === TRUE) {
        writelogln($sql);
    }

    if ($g_db->real_query($sql) === FALSE) {
        abort("Unable to execute database query");
    }

    if ($g_db->field_count == 0) {
        abort("Database command sent as query");
    }

    $results = $g_db->store_result();

    if ($g_db->errno != 0) {
        abort("Unable to retrieve database query results");
    }

    if (isdbloggingon() === TRUE) {
        writelogln("Rows returned: " . mysqli_affected_rows($g_db));
    }    

    $numrows = $results->num_rows;

    if ($numrows == 0) {
        return NULL;
    }

    $recs = array();

    while ($rec = $results->fetch_assoc()) {
        $recs[] = $rec;
    }

    $results->close();

    return $recs;
}

function dbcommand($sql) {
    global $g_db;

    if (isdbloggingon() === TRUE) {
        writelogln($sql);
    }

    if ($g_db->real_query($sql) === FALSE) {
        abort("Unable to execute dbcommand");
    }

    if ($g_db->field_count != 0) {
        abort("Database query sent as command");
    }

    if (isdbloggingon() === TRUE) {
        writelogln("Rows affected: " . mysqli_affected_rows($g_db));
    }    
}

?>
