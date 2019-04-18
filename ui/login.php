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

require("../env/env.php");
require (LIB_DIR . "cofas.php");

dbopen();

$inuserid = isset($_COOKIE["USERID"]) ? $_COOKIE["USERID"] : NULL;
$insessioncode = isset($_COOKIE["SESSIONCODE"]) ? $_COOKIE["SESSIONCODE"] : NULL;

clearsessionvars();

$usernameoremail = "";
$password = "";

if (isset($_POST["usernameoremail"]) && isset($_POST["password"]) && $_POST["login"] == "login") {

    $usernameoremail = $_POST["usernameoremail"];
    $password = $_POST["password"];

    $userid = getuseridfromlogin($usernameoremail, $password);

	if ($userid !== NULL) {
	    initialisesession($userid);
	    dbclose();
	    httpredirect(FIRST_PAGE);
	}
}

dbclose();

starthtmlpagelogin("");

echo startform();

echo startlayout("loginlayout");
echo lcol("Username or email:");
echo rcol(inputbox("usernameoremail", $usernameoremail));
echo lcol("Password:");
echo rcol(passwordbox("password", $password));
echo lcol(submitbutton("login", "Sign In", "login"));
echo rcol("");
echo endlayout();

echo endform();

endhtmlpage();

?>