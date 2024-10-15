<?php

require "connection.php";

$unit_name = $_POST["u"];

if (empty($unit_name)) {
    echo ("Please enter unit name!");
} elseif (preg_match('/\d/', $unit_name)) {
    echo ("Unit name cannot contain numbers!");
} else {

    $rs = Database::search("SELECT * FROM `units` WHERE `name`='" . $unit_name . "'");
    $n = $rs->num_rows;

    if ($n > 1) {

        echo ("Unit already exists.");
    } else {

        Database::iud("INSERT INTO `units` 
    (`name`)
    VALUES ('" . $unit_name . "')");

        echo ("success");
    }
}
