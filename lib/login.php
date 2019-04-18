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

function getuserid() {
    $rawuserid = getsessionvar(USER_ID_LABEL);

    if (($userid = filter_var($rawuserid, FILTER_VALIDATE_INT)) === FALSE) {
        abort("Session userid is not integer");        
    }

    if ($userid <= 0) {
        abort("Session userid is less than 1");
    }

    return $userid;
}

function getuseridfromlogin($usernameoremail, $password) {

    $sql = "SELECT `id` FROM `users` " .
           "WHERE (`username` = '"     . dbesc($usernameoremail) . "'  " .
           "       OR `useremail` = '" . dbesc($usernameoremail) . "') " .
           "AND   `userpassword` = '"  . dbesc($password) ."'";

    $recs = dbquery($sql);

    if ($recs === NULL) {
        return NULL;
    }

    return $recs[0]["id"];
}

function initialisesession($userid) {
    
    $sessioncode = bin2hex(random_bytes(SESSION_CODE_LENGTH));

    setsessionvar(USER_ID_LABEL, $userid);
    setsessionvar(SESSION_CODE_LABEL, $sessioncode);

    updaterecord("users", $userid, array("sessioncode" => dbesc($sessioncode)));
}

function clearsessionvars() {

    clearsessionvar(USER_ID_LABEL);
    clearsessionvar(SESSION_CODE_LABEL);
}

function closesession($userid) {
    
    clearsessionvars();
    updaterecord("users", $userid, array("sessioncode" => NULL)); // NULL??
}

function isvalidsession() {

    if ((issetsessionvar(USER_ID_LABEL) === TRUE) AND
        (issetsessionvar(SESSION_CODE_LABEL) === TRUE)) {

        $userid = getsessionvar(USER_ID_LABEL);
        $sessioncode = getsessionvar(SESSION_CODE_LABEL);

        $sql = "SELECT `sessioncode` from `users` where `id` = " . dbesc($userid);

        $recs = dbquery($sql);

        if ($recs !== NULL) {
            if ($recs[0]["sessioncode"] == $sessioncode) {
                return TRUE;
            }
        }
    }

    clearsessionvars();
    return FALSE;
}

function validatesession() {

    if (isvalidsession() === FALSE) {
        httpredirect(LOGIN_PAGE);
    }
}

?>
