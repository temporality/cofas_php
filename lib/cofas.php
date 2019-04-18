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

/* Included files */

require(LIB_DIR . "log.php");
require(LIB_DIR . "error.php");
require(LIB_DIR . "string.php");
require(LIB_DIR . "array.php");
require(LIB_DIR . "db.php");
require(LIB_DIR . "table.php");
require(LIB_DIR . "datadisplay.php");
require(LIB_DIR . "dataentry.php");
require(LIB_DIR . "http.php");

require(LIB_DIR . "login.php");
require(LIB_DIR . "page.php");
require(LIB_DIR . "uielements.php");
require(LIB_DIR . "elements.php");
require(LIB_DIR . "requirements.php");
require(LIB_DIR . "foods.php");
require(LIB_DIR . "combinations.php");
require(LIB_DIR . "analysis.php");

/* Login */

define("LOGIN_PAGE", UI_URL . "login.php");
define("FIRST_PAGE", UI_URL . "about.php");

/* Session management */

define("USER_ID_LABEL",       "USERID");
define("SESSION_CODE_LABEL",  "SESSIONCODE");
define("SESSION_CODE_LENGTH", 20);

/* Cofas Application */

define("APP_TITLE",       "COFAS");
define("APP_FULL_NAME",   "Composition of Foods Analysis Software");
define("APP_VERSION",     "v1.0 Alpha Test");

/* CoFID */

define("NO_DATA",            "NULL");
define("TRACE_AMOUNT",       "TRACE");
define("SIGNIFICANT_AMOUNT", "SIG");
define("AMOUNT_SPECIFIED",   "OK");

?>