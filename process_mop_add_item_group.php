<?php

require "connection.php";

$item_group_code = $_POST["c"];
$item_group_name = $_POST["n"];

if (empty($item_group_code)) {
    echo ("Please enter item group code.");
} else if (empty($item_group_name)) {
    echo ("Please enter item group name.");
} else {

    $rs = Database::search("SELECT * FROM `mop_item_group` WHERE `name`='" . $item_group_name . "' OR `code`='" . $item_group_code . "'");
    $n = $rs->num_rows;

    if ($n >= 1) {

        echo ("Item code or Item name already exists.");
    } else {

        Database::iud("INSERT INTO `mop_item_group` 
    (`code`,`name`)
    VALUES ('" . $item_group_code . "','" . $item_group_name . "')");

        echo ("success");
    }
}
