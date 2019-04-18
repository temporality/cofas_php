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

define ("ALL_FOOD_GROUPS", "X");

$cofidfoodgroupsdata = array (
array("All food groups", ALL_FOOD_GROUPS),	
array("Cereals and cereal products", "A"),
array("    Flours, grains and starches", "AA"),
array("    Sandwiches", "AB"),
array("    Rice", "AC"),
array("    Pasta", "AD"),
array("    Pizzas", "AE"),
array("    Breads", "AF"),
array("    Rolls", "AG"),
array("    Breakfast cereals", "AI"),
array("    Infant cereal foods", "AK"),
array("    Biscuits", "AM"),
array("    Cakes", "AN"),
array("    Pastry", "AO"),
array("    Buns and pastries", "AP"),
array("    Puddings", "AS"),
array("    Savouries", "AT"),
array("Milk and milk products", "B"),
array("    Cows milk", "BA"),
array("        Breakfast milk", "BAB"),
array("        Skimmed milk", "BAE"),
array("        Semi-skimmed milk", "BAH"),
array("        Whole milk", "BAK"),
array("        Channel Island milk", "BAN"),
array("        Processed milks", "BAR"),
array("    Other milks", "BC"), 
array("    Infant formulas", "BF"),
array("        Whey-based modified milks", "BFD"),
array("        Non-whey-based modified milks", "BFG"),
array("        Soya-based modified milks", "BFJ"),
array("        Follow-on formulas", "BFP"),
array("        Milk-based drinks", "BFP"),
array("    Creams", "BJ"),
array("        Fresh creams (pasteurised)", "BJC"),
array("        Frozen creams (pasteurised)", "BJF"),
array("        Sterilised creams", "BJL"),
array("        UHT creams", "BJP"),
array("        Imitation creams", "BJS"),
array("    Cheeses", "BL"),
array("    Yogurts", "BN"),
array("        Whole milk yogurts", "BNE"),
array("        Low fat yogurts", "BNH"),
array("        Other yogurts", "BNS"),
array("    Ice creams", "BP"),
array("    Puddings and chilled desserts", "BR"),
array("    Savoury dishes and sauces", "BV"),
array("Eggs", "C"),
array("    Eggs", "CA"), 
array("    Egg dishes", "CD"),
array("        Savoury egg dishes", "CDE"),
array("        Sweet egg dishes", "CDH"),
array("Vegetables", "D"),
array("    Potatoes", "DA"),
array("        Early potatoes", "DAE"),
array("        Main crop potatoes", "DAM"),
array("        Chipped old potatoes", "DAP"),
array("        Potato products", "DAR"),
array("    Beans and lentils", "DB"),
array("    Peas", "DF"),
array("    Vegetables, general", "DG"),
array("    Vegetables, dried", "DI"),
array("    Vegetable dishes", "DR"),
array("Fruit", "F"),
array("    Fruit, general", "FA"),
array("    Fruit juices", "FC"),
array("Nuts and seeds", "G"),
array("    Nuts and seeds, general", "GA"),
array("Herbs and spices", "H"),
array("Baby foods", "IF"),
array("    Baby foods, granulated/powder", "IFB"),
array("    Baby foods, canned/bottled", "IFC"),
array("Fish and fish products", "J"),
array("    White fish", "JA"),
array("    Fatty fish", "JC"),
array("    Crustacea", "JK"),
array("    Molluscs", "JM"),
array("    Fish products and dishes", "JR"),
array("Meat and meat products", "M"),
array("    Meat", "MA"),
array("        Bacon", "MAA"),
array("        Beef", "MAC"),
array("        Lamb", "MAE"),
array("        Pork", "MAG"),
array("        Veal", "MAI"),
array("    Poultry", "MC"),
array("        Chicken", "MCA"),
array("        Duck", "MCC"),
array("        Goose", "MCE"),
array("        Grouse", "MCG"),
array("        Partridge", "MCI"),
array("        Pheasant", "MCK"),
array("        Pigeon", "MCM"),
array("        Turkey", "MCO"),
array("    Game", "ME"),
array("        Hare", "MEA"),
array("        Rabbit", "MEC"),
array("        Venison", "MEE"),
array("    Offal", "MG"),
array("        Burgers and grillsteaks", "MBG"),
array("    Meat products", "MI"),
array("        Other meat products", "MIG"),
array("    Meat dishes", "MR"),
array("Fats and oils", "O"),
array("    Spreading fats", "OA"),
array("    Animal fats", "OB"),
array("    Oils", "OC"),
array("    Non-animal fats", "OE"),
array("    Cooking fats", "OF"),
array("Beverages", "P"),
array("    Powdered drinks, essences and infusions", "PA"),
array("        Powdered drinks and essences", "PAA"),
array("        Infusions", "PAC"),
array("    Soft drinks", "PC"),
array("        Carbonated drinks", "PCA"),
array("        Squash and cordials", "PCC"),
array("    Juices", "PE"),
array("Alcoholic beverages", "Q"),
array("    Beers", "QA"),
array("    Ciders", "QC"),
array("    Wines", "QE"),
array("    Fortified wines", "QF"),
array("    Vermouths", "QG"),
array("    Liqueurs", "QI"),
array("    Spirits", "QK"),
array("Sugars, preserves and snacks", "S"),
array("    Sugars, syrups and preserves", "SC"),
array("    Confectionery", "SE"),
array("        Chocolate confectionery", "SEA"),
array("        Non-chocolate confectionery", "SEC"),
array("    Savoury snacks", "SN"),
array("        Potato-based snacks", "SNA"),
array("        Potato and mixed cereal snacks", "SNB"),
array("        Non-potato snacks", "SNC"),
array("Soups, sauces and miscellaneous foods", "W"),
array("    Soups", "WA"),
array("        Home made soups", "WAA"),
array("        Canned soups", "WAC"),
array("        Packet soups", "WAE"),
array("    Sauces", "WC"),
array("        Dairy sauces", "WCD"),
array("        Salad sauces, dressings and pickles", "WCG"),
array("        Non-salad sauces", "WCN"),
array("    Pickles and chutneys", "WE"),
array("Miscellaneous foods", "ZZ")              // ZZ is not an official code
);

$cofidfoodgroups = array();
foreach ($cofidfoodgroupsdata as $data) {
    $cofidfoodgroups[$data[1]] = array(str_replace(" ", "&nbsp;", $data[0]), $data[1], $data[0]);
}

function getcofidfoodgroupname($foodgroupcode) {
global $cofidfoodgroups;

    if (haskey($cofidfoodgroups, $foodgroupcode)) {
        $str = str_replace("&nbsp;", "", $cofidfoodgroups[$foodgroupcode][2]);
    } else {
        $str = "(" .$foodgroupcode . ")";
    }

	return $str;
}

//echo showvar($cofidfoodgroups);
//echo showvar("S=" . getcofidfoodgroupname("BTM"));
?>
