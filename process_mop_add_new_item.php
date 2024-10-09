<?php

require "connection.php";

$item_code = $_POST["i"];
$description = $_POST["d"];
$unit = $_POST["u"];
$quantity = $_POST["q"];
$remarks = $_POST["re"];

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
} else {

    $rs = Database::search("SELECT * FROM `mop_inventory` WHERE `item_code`='" . $item_code . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("Item with the same item code already exists.");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `mop_inventory` 
    (`item_code`,`description`,`units_id`,`status_status_id`)
    VALUES ('" . $item_code . "','" . $description . "','" . $unit . "','1')");

        Database::iud("INSERT INTO `mop_stock` 
    (`mop_inventory_item_code`,`qty_system`,`remarks`,`date_time`)
    VALUES ('" . $item_code . "','" . $quantity . "','".$remarks."','" . $date . "')");

        echo ("success");
    }
}
