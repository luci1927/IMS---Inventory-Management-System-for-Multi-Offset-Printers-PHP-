<?php

require "connection.php";

$id = $_POST["id"];
$name = $_POST["name"];


$unit_rs = Database::search("SELECT * FROM `units` WHERE `id`='" . $id . "'");
if ($unit_rs) {
    $unit_n = $unit_rs->num_rows;

    if ($unit_n > 0) {

        if (empty($name)) {
            echo ("Please enter unit name!");
        }else {

            Database::iud("UPDATE `units` SET `name` = '" . $name . "' WHERE `id` = '" . $id . "'");
            echo ("success");
        }
    } else {
        die("No unit found for the given item code.");
    }
} else {
    die("Error.");
}
