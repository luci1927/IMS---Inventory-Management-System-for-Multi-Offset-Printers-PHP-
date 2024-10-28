<?php

require "connection.php";

$item_code = $_POST["i"];
$issue_no = $_POST["u"];
$qout = $_POST["q"];
$remarks = $_POST["re"];
$ref_no = $_POST["ref"];



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

$stock_rs = Database::search("SELECT * FROM `mop_stock` 
    WHERE `mop_inventory_item_code` = '" . $item_code . "' ORDER BY `date_time` DESC LIMIT 1;");
    $stock_n = $stock_rs->num_rows;
    $stock_data = $stock_rs->fetch_assoc();

    $current_qty = $stock_data["qty_hand"];


    if (empty($qout)) {
        die("Please enter quantity!");
    } else if (empty($ref_no)) {
        die("Please enter reference number!");
    }

    $ref_rs = Database::search("SELECT * FROM `mop_issuing` WHERE `ref_no`='" . $ref_no . "'");
    if ($ref_rs) {
        $ref_n = $ref_rs->num_rows;
        if ($ref_n > 0) {
            die("Reference number already exists!");
        }
    } else {
        die("Error executing reference query.");
    }

    if ($current_qty < $qout) {
        die("Insufficient quantity in stock!");
    }

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `mop_issuing` 
    (`issue_no`,`qty`,`status_status_id`,`date_time`,`ref_no`)
    VALUES ('" . $issue_no . "','" . $qout . "','1','" . $date . "','".$ref_no."')");

    $qsystem = $stock_data["qty_system"];
    $qhand = floatval($stock_data["qty_hand"]);
    $qout = floatval($qout);
    $avl_qty = $qhand - $qout;

    Database::iud("INSERT INTO `mop_stock` 
    (`mop_inventory_item_code`,`qty_system`,`qty_hand`,`remarks`,`date_time`,`mop_issuing_issue_no`)
    VALUES ('" . $item_code . "','" . $qsystem . "','" . $avl_qty . "','" . $remarks . "','" . $date . "','" . $issue_no . "')");

echo ("success");


