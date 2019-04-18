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

/* URLs and Directories */

define("ROOT_URL", "http://" . $_SERVER["SERVER_NAME"] . "/cofas/");
define("ROOT_DIR", $_SERVER["DOCUMENT_ROOT"] . "/cofas/");

define("UI_URL",  ROOT_URL . "ui/");
define("UI_DIR",  ROOT_DIR . "ui/");

define("LIB_DIR", ROOT_DIR . "lib/");

/* Database login for MySQL Server*/

define("DB_HOST",        "localhost");   // ip addr or hostname
define("DB_USERNAME",    "cofas");       // MySQL username
define("DB_USERPW",      "");            // password
define("DB_DATABASENAME","cofas");       // database name

/* Logging */

define("LOG_FILE_NAME", ROOT_DIR . "log/err.log");

define("LOG_FILE", FALSE);       // write log to file
define("LOG_ECHO", FALSE);       // show log in footer

/* Debugging */

define("SHOW_DEBUG", FALSE);       // show POST and COOKIE in footer

define("SHOW_FOOD_CODES",     FALSE);   
define("SHOW_NUTRIENT_CODES", FALSE);  
define("SHOW_GROUP_CODES",    FALSE);

?>