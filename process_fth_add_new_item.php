<?php

require "connection.php";

$item_code = $_POST["i"];
$description = $_POST["d"];
$unit = $_POST["u"];
$quantity = $_POST["q"];
$grn_no = $_POST["g"];
$grn_type_id = $_POST["gt"];
$supplier_id = $_POST["s"];
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
} else if (empty($grn_no)) {
    echo ("Please enter GRN number!");
} else if ($grn_type_id == "0") {
    echo ("Please select a GRN type!");
} else if ($supplier_id == "0") {
    echo ("Please select a supplier!");
} else {

    $rs = Database::search("SELECT * FROM `fth_inventory` WHERE `item_code`='" . $item_code . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("Item with the same item code already exists.");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `fth_inventory` 
    (`item_code`,`description`,`units_id`,`status_status_id`)
    VALUES ('" . $item_code . "','" . $description . "','" . $unit . "','1')");


        Database::iud("INSERT INTO `fth_grn` 
    (`grn_no`,`date_time`,`qty`,`grn_type_id`,`supplier_id`)
    VALUES ('" . $grn_no . "','" . $date . "','" . $quantity . "','" . $grn_type_id . "','" . $supplier_id . "')");

    $grn_rs = Database::search("SELECT * FROM `fth_grn` WHERE `grn_no`='" . $grn_no . "'");

    $grn_data = $grn_rs->fetch_assoc();

    $grn_id = $grn_data["id"];

        Database::iud("INSERT INTO `fth_stock` 
    (`fth_inventory_item_code`,`qty_system`,`qty_hand`,`remarks`,`date_time`,`fth_grn_id`)
    VALUES ('" . $item_code . "','" . $quantity . "','" . $quantity . "','" . $remarks . "','" . $date . "','".$grn_id."')");



        echo ("success");
    }
}
