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

// todo add test for getcolumnnames

// Problem with nulls dbesc, create and update?

define("DB_PRIMARY_KEY_COLUMN_NAME", "id");

define("DB_TYPE_KEY",     1);
define("DB_TYPE_NUMBER",  2);
define("DB_TYPE_STRING",  3);
define("DB_TYPE_DATE",    4);
define("DB_TYPE_TIME",    5);

define("LOG_EXISTANCE_TESTS", FALSE);
define("LOG_RECORD_CREATION", FALSE);

function tableexists($tablename) {
    global $g_db;

    if (LOG_EXISTANCE_TESTS == TRUE) {
        writelog("(Testing for existance of table: '" . $tablename . "':");
    }

    $sql = "SELECT COUNT(*) as num " .
           "FROM   information_schema.tables " .
           "WHERE  table_schema = '" . DB_DATABASENAME . "' " .
           "AND    table_name = '$tablename' ";

    $r = dbquery($sql);

    if (LOG_EXISTANCE_TESTS == TRUE) {
        writelogln((($r[0]["num"] == 1) ? "found" : "not found") . "...ok)");
    }

    return ($r[0]["num"] == 1) ? TRUE : FALSE;
}

function columnexists($tablename, $columnname) {
    global $g_db;

    if (LOG_EXISTANCE_TESTS == TRUE) {
        writelog("(Testing for existance of column '$columnname' in table '$tablename'");
    }

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    $sql = "SELECT COUNT(*) as num " .
           "FROM   information_schema.columns " .
           "WHERE  table_schema = '" . DB_DATABASENAME . "' " .
           "AND    table_name   = '$tablename' " .
           "AND    column_name  = '$columnname' ";

    $r = dbquery($sql);

    if (LOG_EXISTANCE_TESTS == TRUE) {
        writelogln((($r[0]["num"] == 1) ? "found" : "not found") . "...ok)");
    }

    return ($r[0]["num"] == 1) ? TRUE : FALSE;
}

function recordexists($tablename, $primarykey) {
    global $g_db;

    if (LOG_EXISTANCE_TESTS == TRUE) {
        writelog("(Testing for existance of record with primary key '$primarykey' in table '$tablename'");
    }

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    $sql = "SELECT COUNT(*) as num " .
           "FROM   `$tablename` " .
           "WHERE  `" . DB_PRIMARY_KEY_COLUMN_NAME . "` = '$primarykey' ";

    $r = dbquery($sql);

    $n = $r[0]["num"];

    if ($n != 1 && $n != 0) {
        abort("...error: $n records with same primary key");
    }

    if (LOG_EXISTANCE_TESTS == TRUE) {
        writelogln((($n == 1) ? "found" : "not found") . "...ok)");
    }

    return ($n == 1) ? TRUE : FALSE;
}

function createtable($tablename) {
    global $g_db;

    writelog("Creating table: '" . $tablename . "'");

    if (tableexists($tablename) == TRUE) {
        abort("...error: table already exists");
    }

    $sql = "CREATE TABLE `$tablename` " .
           "( " . 
           "`" . DB_PRIMARY_KEY_COLUMN_NAME . "` INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE, " .
           "PRIMARY KEY (`" . DB_PRIMARY_KEY_COLUMN_NAME . "`) " .
           ") " .
           "AUTO_INCREMENT 1 " .
           "ENGINE InnoDB  " .
           "CHARACTER SET " . DB_CHARSET . " " .
           "COLLATE " . DB_COLLATION . " ";

    dbcommand($sql);

    writelogln("...ok");
}

function cleartable($tablename) {
    global $g_db;

    writelog("Clearing table '" . $tablename . "'");

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    $sql = "TRUNCATE TABLE `" . dbesc($tablename) . "`";

    dbcommand($sql);

    writelogln("...ok");
}


function deletetable($tablename) {
    global $g_db;

    writelog("Deleting table '" . $tablename . "'");

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    $sql = "DROP TABLE `" . dbesc($tablename) . "`";

    dbcommand($sql);

    writelogln("...ok");
}

function createcolumn($tablename, $columnname, $columntype) {
    global $g_db;

    switch ($columntype) {
        case DB_TYPE_KEY:      $def  = "INTEGER UNSIGNED NOT NULL";
                               $desc = "Key";
                               break; 
        case DB_TYPE_NUMBER:   $def  = "DOUBLE NULL DEFAULT NULL";
                               $desc = "Number";
                               break;
        case DB_TYPE_STRING:   $def  = "VARCHAR(100) CHARACTER SET " . DB_CHARSET . " " .
                                       "COLLATE " . DB_COLLATION . " NULL DEFAULT NULL";
                               $desc = "String";
                               break; 
        case DB_TYPE_DATE:     $def  = "DATE NULL DEFAULT NULL";
                               $desc = "Date";
                               break; 
        case DB_TYPE_TIME:     $def  = "TIME NULL DEFAULT NULL";
                               $desc = "Time";
                               break; 
        default:               $def = "";
                               $desc = "unknown";
                               break; 
    }

    writelog("Creating column '$columnname' of type '$desc' in table '$tablename'");

    if ($desc == "unknown") {
        abort("...error: unknown column type");
    }

    if (tableexists($tablename) == FALSE) {
        abort("...error: cannot create column in non existant table");
    }

    if (columnexists($tablename, $columnname) == TRUE) {
        abort("...error: cannot create already existing column");
    }

    $sql = "ALTER TABLE `" . dbesc($tablename) . "` ADD `" . dbesc($columnname) . "` " . $def;

    dbcommand($sql);

    writelogln("...ok");
}

function deletecolumn($tablename, $columnname) {
    global $g_db;

    writelog("Deleting column '$columnname' in table '$tablename'");

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    if (columnexists($tablename, $columnname) == FALSE) {
        abort("...error: column does not exist");
    }

    if ($columnname == DB_PRIMARY_KEY_COLUMN_NAME) {
        abort("...error: cannot delete primary key column");
    }

    $sql = "ALTER TABLE `$tablename` DROP `$columnname`";

    dbcommand($sql);

    writelogln("...ok");
}

function createrecord($tablename, $rec) {
    global $g_db;

    if (LOG_RECORD_CREATION === TRUE) {
        writelog("Creating record in table '$tablename'");
    }

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    $fields = array();
    $values = array();

    foreach ($rec as $k => $v) {

        if ($k != DB_PRIMARY_KEY_COLUMN_NAME) {
            array_push($fields, "`" . dbesc($k) . "`");
            array_push($values, "'" . dbesc($v) . "'");
        }
    }

    $sql = "INSERT `$tablename` (" . implode(",", $fields) . ") VALUES (" . implode(",", $values) . ")";

    dbcommand($sql);

    $newprimarykey = $g_db->insert_id;

    if ($newprimarykey == 0) {
        abort("...error: new primary key has value of zero");
    }

    if (LOG_RECORD_CREATION === TRUE) {
        writelogln("with id of '$newprimarykey'...ok");
    }

    return $newprimarykey;
}

function updaterecord($tablename, $primarykey, $rec) {
    global $g_db;

    writelog("Updating record in table '$tablename' with primary key of '$primarykey'");

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    if (recordexists($tablename, $primarykey) == FALSE) {
        abort("...error: primary key does not exist");
    }

    $statements = array();

    foreach ($rec as $k => $v) {

        if ($k != DB_PRIMARY_KEY_COLUMN_NAME) {
            $s = "`" . dbesc($k) . "` = " . "'" . dbesc($v) . "'";
            array_push($statements, $s);
        }
    }

    $sql = "UPDATE `$tablename` SET " . implode(",", $statements) . " " .
           "WHERE `" . DB_PRIMARY_KEY_COLUMN_NAME . "` = " . $primarykey;

    dbcommand($sql);
    
    if ($g_db->affected_rows == -1) {
        abort("...error: number of affected row is -1");
    }

    if ($g_db->affected_rows == 0) {
        abort("...error: no rows affected");
    }

    if ($g_db->affected_rows > 1) {
        abort("...error: update affected more than one row (" . $g_db->affected_rows . " rows affected)");
    }

    writelogln("...ok");
}

function deleterecord($tablename, $primarykey) {
    global $g_db;

    writelog("Deleting record in table '$tablename' with primary key of '$primarykey'");

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    if (recordexists($tablename, $primarykey) == FALSE) {
        abort("...error: primary key does not exist");
    }

    $sql = "DELETE FROM `$tablename` WHERE `" . DB_PRIMARY_KEY_COLUMN_NAME . "` = " . $primarykey;

    dbcommand($sql);

    writelogln("...ok");
}

function gettablecolumnnames($tablename) {
    global $g_db;

    writelog("Getting column names fortable '$tablename'");

    if (tableexists($tablename) == FALSE) {
        abort("...error: table does not exist");
    }

    $sql = "SELECT column_name " .
           "FROM   information_schema.columns " .
           "WHERE  table_schema = '" . DB_DATABASENAME . "' " .
           "AND    table_name   = '$tablename' ";

    $r = dbquery($sql);

    $cols = array();

    foreach($r as $k => $v) {
        $cols[] = $v["column_name"];
    } 

    writelogln("...ok");

    return $cols;
}

function populatetable($tablename, $rows) {

    writelog("Populating table '" . $tablename . "'");

    foreach ($rows as $row) {
        createrecord($tablename, $row);
    }

    writelogln("...ok");    
}

function gettable($tablename) {
    return dbquery("SELECT * from `" . dbesc($tablename) . "`");
}

// should check for more than 1 etc
function getrecord($tablename, $recordid) {
    $rec = dbquery("SELECT * from `" . dbesc($tablename) . "` where `foodid` = " . dbesc($recordid));

    return $rec[0];
}


function truncatetable($tablename) {
    global $g_db;

    writelog("Truncating table '$tablename'");

    if (tableexists($tablename) === FALSE) {
        abort("...error: table does not exist");
    }

    $sql = "TRUNCATE `$tablename`";

    dbcommand($sql);
    
    if ($g_db->affected_rows == -1) {
        abort("...error: number of affected row is -1");
    }

    writelogln("...(" . $g_db->affected_rows . "rows deleted)...ok");
}
?>
