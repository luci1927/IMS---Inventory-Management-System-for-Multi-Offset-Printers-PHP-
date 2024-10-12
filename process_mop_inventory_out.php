<?php

require "connection.php";

$item_code = $_POST["i"];
$issue_no = $_POST["u"];
$qout = $_POST["q"];
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

if (empty($qout)) {
    echo ("Please enter quantity!");
} else {

    $stock_rs = Database::search("SELECT * FROM `mop_stock` 
    WHERE `mop_inventory_item_code` = '" . $item_code . "' ORDER BY `date_time` DESC LIMIT 1;");
    $stock_n = $stock_rs->num_rows;
    $stock_data = $stock_rs->fetch_assoc();

    $qsystem = $stock_data["qty_system"];
    $qhand = floatval($stock_data["qty_hand"]);
    $qout = floatval($qout);
    $avl_qty = $qhand - $qout;

    $grn_id = $stock_data["mop_grn_id"];



    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");


    Database::iud("INSERT INTO `mop_stock` 
    (`mop_inventory_item_code`,`qty_system`,`qty_hand`,`remarks`,`date_time`,`mop_grn_id`)
    VALUES ('" . $item_code . "','" . $qsystem . "','" . $avl_qty . "','" . $remarks . "','" . $date . "','". $grn_id ."')");

$stock2_rs = Database::search("SELECT * FROM `mop_stock` ORDER BY `date_time` DESC LIMIT 1;");
$stock2_n = $stock2_rs->num_rows;
$stock2_data = $stock2_rs->fetch_assoc();

$stock_id = $stock2_data["id"];

Database::iud("INSERT INTO `mop_issuing` 
(`issue_no`,`qty`,`mop_stock_id`,`status_status_id`,`date_time`)
VALUES ('" . $issue_no . "','" . $qout . "','" . $stock_id . "','1','" . $date . "')");


    echo ("success");
}
