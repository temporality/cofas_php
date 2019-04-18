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

define ("COFID_DATA_URL",    "https://www.gov.uk/government/publications/composition-of-foods-integrated-dataset-cofid.");
define ("COFID_LICENCE_URL", "http://www.nationalarchives.gov.uk/doc/open-government-licence/");

dbopen();
validatesession();
starthtmlpage("About " . APP_TITLE . " (" . APP_VERSION . ")");

echo startbox("aboutbox");

echo showheading("<b>Welcome</b>");

echo showtext("This software allows the nutritional content of different diet or food choices to be compared and analysed, using data published by the UK Government.");
echo showtext("<b>Please note:</b> This software and data probably contains errors that give inaccurate information or unreliable results.");

echo endbox();


echo startbox("aboutbox");

echo showheading("<b>Data</b>");

echo showtext("CoFID is a dataset published by the UK Government that is concerned with the nutrient content of the UK food supply. For futher information see " . embedlink("here", COFID_DATA_URL) . ". CoFID is licensed under the " . embedlink("Open Government Licence v3.0", COFID_LICENCE_URL) . ".");
echo showtext("The nutritional requirements data is based on the " . embedlink("UK Government Dietary Recommendations", "https://www.gov.uk/government/uploads/system/uploads/attachment_data/file/618167/government_dietary_recommendations.pdf") . ".");

echo endbox();


echo startbox("aboutbox");

echo showheading("<b>Software</b>");

echo showtext("This software is know as " . APP_TITLE . " ('" . APP_FULL_NAME . "')" . ". Version " . APP_VERSION . ".");
echo showtext("Copyright " . embedlink("Temporality Ltd.", "http://temporality.co.uk") . " For further information please email cofas@temporality.co.uk.");
echo showtext("COFAS is licenced under the GNU AFFERO GENERAL PUBLIC LICENSE Version 3 (19 November 2007).");
echo endbox();

endhtmlpage();
dbclose();

?>