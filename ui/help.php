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
validatesession();

starthtmlpage("Help");

echo startbox("aboutbox");

echo showheading("Menu Options");

echo showsubheading("About");
echo showtext("Information about this software and data, including copyrights and licences.");

echo showsubheading("Nutrients");
echo showtext("Shows the list of nutrients that food data is available for.");

echo showsubheading("Requirements");
echo showtext("Shows recommended daily intakes of vitamins and minerals. This data is from the UK Government's 2016 recommendations.
Only data regarding people categorised under 'Males aged 19 - 64' is currently available. Please see " . embedlink("UK Government Dietary Recommendations", "https://www.gov.uk/government/uploads/system/uploads/attachment_data/file/618167/government_dietary_recommendations.pdf") . " for data for other categories and also other important additional information." );

echo showsubheading("Foods");
echo showtext("Lists all the foods in the database and shows detailed nutrient data for a selected item. When a precise value for the amount of a nutrient is not available one of the following may be shown:");
echo showtext("unknown - No data is available");
echo showtext("significant - A significant amount is present but no exact measurement is available");
echo showtext("trace - Only a trace amount is present");


echo showsubheading("Lists");
echo showtext("A list contains multiple food items and their amounts in grams. Add a new list and then add foods (with the amount in grams) to the list. To search for a food in the drop down type the first few characters. Information about individual nutrients and requirements are summarised in table at the bottom of the page.");

echo showsubheading("Analysis");
echo showtext("Shows detailed breakdown of each nutrient for each food in a list, either by nutrient content or percentage of requirement.");

echo showsubheading("Search");
echo showtext("Lists foods with the highest amounts of a particular nutrient. Select which food groups to search in. Hold down the ctrl/cmd key to select multiple groups. When selecting the nutrient in the drop down type the first few letters to search. Use the 'number of results' field to limit the number of items returned - set to 50 by default.");

echo showsubheading("Ratios");
echo showtext("Shows foods with the highest ratio of one nutrient to another. Some combinations may not be particularly meaningful. The ctrl/cmd key can be used to select multiple groups to search in. The first few letters of a nutrient can be typed into the drop down to quickly find a nutrient. Use the 'Number of results' field to limit the number of items returned, it is set to 50 by default.");

echo showsubheading("Sign out");
echo showtext("Signs the current user out and returns to the sign in page.");

echo showsubheading("Help");
echo showtext("Contains help information for all the menu options and links to UK nutrition related information.");

echo endbox();


echo startbox("aboutbox");

echo showheading("Links");

echo showlink("NHS The Eatwell Guide",            "https://www.nhs.uk/Livewell/Goodfood/Pages/the-eatwell-guide.aspx");
echo showlink("NHS Vitamins and Minerals",        "https://www.nhs.uk/conditions/vitamins-and-minerals/");
echo showlink("NHS Reference intakes",            "https://www.nhs.uk/Livewell/Goodfood/Pages/reference-intakes-RI-guideline-daily-amounts-GDA.aspx");
echo showlink("British Nutrition Foundation",     "https://www.nutrition.org.uk/");
echo showlink("The British Dietetic Association", "https://www.bda.uk.com");
echo showlink("Association for Nutrition",        "http://www.associationfornutrition.org");

echo showlink("UK Government Scientific Advisory Committee on Nutrition (SACN)",  "https://www.gov.uk/government/groups/scientific-advisory-committee-on-nutrition");

/*
echo showlink("", "");
echo showlink("", "");
echo showlink("", "");
echo showlink("", "");
echo showlink("", "");
echo showlink("", "");
echo showlink("", "");
echo showlink("", "");
*/
echo endbox();


endhtmlpage();
dbclose();

?>