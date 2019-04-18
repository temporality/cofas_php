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

function starthtmlpagelogin($pagetitle) {

    echo "<!DOCTYPE html>\n";

    echo "<html>\n";

    echo "<head>\n";
    echo "  <meta charset='UTF-8' />\n";
    echo "  <title>COFAS Login</title>\n";
    echo "  <link rel='stylesheet' type='text/css' href='" . UI_URL . "style.css' />\n";
    echo "  <script type='text/javascript'></script>\n";
    echo "</head>\n";

    echo "<body>\n";

    echo "<header>\n";
    echo "  <div class='apptitleheader'>" . APP_TITLE . "</div>\n";
    echo "</header>\n";

    echo "<main>\n";

    echo "<div class='pagetitle'>\n";
    echo $pagetitle;
    echo "</div>\n";    
}

function starthtmlpage($pagetitle) {

    echo "<!DOCTYPE html>\n";

    echo "<html>\n";

    echo "<head>\n";
    echo "  <meta charset='UTF-8' />\n";
    echo "  <title>" . $pagetitle . "</title>\n";
    echo "  <link rel='stylesheet' type='text/css' href='" . UI_URL . "style.css' />\n";
    echo "  <script type='text/javascript'></script>\n";
    echo "</head>\n";

    echo "<body>\n";

    echo "<header>\n";
    echo "  <nav class='mainnav'>\n";
    echo "    <a href='about.php'>About</a>\n";    
    echo "    <a href='nutrients.php'>Nutrients</a>\n";
    echo "    <a href='requirements.php'>Requirements</a>\n";
    echo "    <a href='foods.php'>Foods</a>\n";
    echo "    <a href='lists.php'>Lists</a>\n";
    echo "    <a href='analysis.php'>Analysis</a>\n";
    echo "    <a href='search.php'>Search</a>\n";
    echo "    <a href='ratios.php'>Ratios</a>\n";
    echo "    <a href='help.php'>Help</a>\n";    
    echo "    <a href='" . LOGIN_PAGE . "'>Sign out</a>\n";
    echo "  </nav>\n";
    echo "</header>\n";

    echo "<main>\n";

    echo "<div class='pagetitle'>\n";
    echo $pagetitle;
    echo "</div>\n";    
}

function endhtmlpage() {
global $g_logoutput;

    echo "</main>\n";

    echo "<footer>\n";
    echo "  <div class='apptitlefooter'>" . APP_TITLE . " - " . APP_FULL_NAME . " (" . APP_VERSION . ")</div>\n";

    if (SHOW_DEBUG === TRUE) {
        echo "<pre class='logging'>";
        echo showvar($_POST);
        echo showvar($_COOKIE);
        echo "</pre>";
    }

    if (LOG_ECHO === TRUE) {
        echo "<pre class='logging'>";
        echo $g_logoutput;
        echo "</pre>";
    }

    echo "</footer>\n";

    echo "</body>\n";
    echo "</html>\n";
}

function showtext($text) {
    return "<div class='text'>" . $text ."</div>";
}

function showheading($text) {
    return "<div class='headingtext'>" . $text ."</div>";
}

function showsubheading($text) {
    return "<div class='subheadingtext'>" . $text ."</div>";
}

function showlink($text, $link) {
    return "<div><a target=\"blank\" class=\"linktext\" href=\"" . $link . "\">" . $text . "</a></div>";
}

function embedlink($text, $link) {
    return "<a target=\"_blank\" class=\"linktext\" href=\"" . $link . "\">" . $text . "</a>";
}

?>