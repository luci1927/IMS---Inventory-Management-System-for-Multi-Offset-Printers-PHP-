<?php

require "connection.php";

$id = $_POST["id"];
$name = $_POST["name"];


$grn_type_rs = Database::search("SELECT * FROM `grn_type` WHERE `id`='" . $id . "'");
if ($grn_type_rs) {
    $grn_type_n = $grn_type_rs->num_rows;

    if ($grn_type_n > 0) {

        if (empty($name)) {
            echo ("Please enter grn type name!");
        }else {

            Database::iud("UPDATE `grn_type` SET `name` = '" . $name . "' WHERE `id` = '" . $id . "'");
            echo ("success");
        }
    } else {
        die("No grn type found for the given item code.");
    }
} else {
    die("Error.");
}
