<?php

require "connection.php";

$id = $_POST["id"];
$name = $_POST["name"];


$item_group_rs = Database::search("SELECT * FROM `mop_item_group` WHERE `code`='" . $id . "'");
if ($item_group_rs) {
    $item_group_n = $item_group_rs->num_rows;

    if ($item_group_n > 0) {

        if (empty($name)) {
            echo ("Please enter item group name!");
        }else {

            Database::iud("UPDATE `mop_item_group` SET `name` = '" . $name . "' WHERE `code` = '" . $id . "'");
            echo ("success");
        }
    } else {
        die("No item group found for the given item code.");
    }
} else {
    die("Error.");
}
