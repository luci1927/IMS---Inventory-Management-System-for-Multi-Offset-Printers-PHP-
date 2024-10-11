<?php

require "connection.php";

$item_code = $_POST["i"];
$unit = $_POST["u"];
$qhand = $_POST["q"];
$remarks = $_POST["re"];



$inventory_rs = Database::search("SELECT * FROM `mop_inventory` WHERE `item_code`='" . $item_code . "'");
if ($inventory_rs) {
    $inventory_n = $inventory_rs->num_rows;

    if ($inventory_n > 0) {
        $inventory_data = $inventory_rs->fetch_assoc();
        $description = $inventory_data["description"];
    } else {
        die("No inventory data found for the given item code.");
    }
} else {
    die("Error executing inventory query.");
}

if (empty($qhand)) {
    echo ("Please enter quantity!");
} else {

    $stock_rs = Database::search("SELECT * FROM `mop_stock` 
    WHERE `mop_inventory_item_code` = '" . $item_code . "' ORDER BY `date_time` DESC LIMIT 1;");
    $stock_n = $stock_rs->num_rows;
    $stock_data = $stock_rs->fetch_assoc();

    $qsystem = $stock_data["qty_hand"];
    $grn_id = $stock_data["mop_grn_id"];



    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");


    Database::iud("INSERT INTO `mop_stock` 
    (`mop_inventory_item_code`,`qty_system`,`qty_hand`,`remarks`,`date_time`,`mop_grn_id`)
    VALUES ('" . $item_code . "','" . $qsystem . "','" . $qhand . "','" . $remarks . "','" . $date . "','". $grn_id ."')");


    echo ("success");
}
