<?php

require "connection.php";

$item_code = $_POST["i"];
$description = $_POST["d"];
$unit = $_POST["u"];
$item_group = $_POST["ig"];
$item_sub_group = $_POST["isg"];

if (empty($item_code)) {
    echo ("Please enter item code!");
} else if (strlen($item_code) > 20) {
    echo ("Item code must have LESS THAN 20 characters!");
} else if (empty($description)) {
    echo ("Please enter a description!");
} else if (strlen($description) > 100) {
    echo ("Description must have LESS THAN 100 characters!");
} else if ($unit == "0") {
    echo ("Please select a unit measurement!");
} else if ($item_group == "0") {
    echo ("Please select a Item Group!");
} else if ($item_sub_group == "0") {
    echo ("Please select a Item Sub Group!");
}else {

    $rs = Database::search("SELECT * FROM `mop_inventory` WHERE `item_code`='" . $item_code . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("Item with the same item code already exists.");
    } else {

        Database::iud("INSERT INTO `mop_inventory` 
    (`item_code`,`description`,`units_id`,`status_status_id`,`mop_item_group_code`,`mop_item_sub_group_sub_code`)
    VALUES ('" . $item_code . "','" . $description . "','" . $unit . "','1','" . $item_group . "','" . $item_sub_group . "')");

        echo ("success");
    }
}
