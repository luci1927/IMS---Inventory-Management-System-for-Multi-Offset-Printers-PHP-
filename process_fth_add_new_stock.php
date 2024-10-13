<?php

require "connection.php";

$item_code = $_POST["i"];
$quantity = $_POST["q"];
$grn_no = $_POST["g"];
$grn_type_id = $_POST["gt"];
$supplier_id = $_POST["s"];
$remarks = $_POST["re"];

if ($item_code == "") {
    echo ("Please select an item!");
} else if (empty($grn_no)) {
    echo ("Please enter GRN number!");
} else if ($grn_type_id == "0") {
    echo ("Please select a GRN type!");
} else if ($supplier_id == "0") {
    echo ("Please select a supplier!");
} else {

    $rs = Database::search("SELECT * FROM `fth_inventory` WHERE `item_code`='" . $item_code . "'");
    $n = $rs->num_rows;

    if ($n == 1) {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");


        Database::iud("INSERT INTO `fth_grn` 
    (`grn_no`,`date_time`,`qty`,`grn_type_id`,`supplier_id`)
    VALUES ('" . $grn_no . "','" . $date . "','" . $quantity . "','" . $grn_type_id . "','" . $supplier_id . "')");

        $grn_rs = Database::search("SELECT * FROM `fth_grn` WHERE `grn_no`='" . $grn_no . "'");

        $grn_data = $grn_rs->fetch_assoc();

        $grn_id = $grn_data["id"];

        $qty_rs = Database::search("SELECT * 
                            FROM `fth_stock` 
                            WHERE `fth_inventory_item_code` = '" . $item_code . "' 
                            ORDER BY `date_time` DESC 
                            LIMIT 1;");

        $qty_data = $qty_rs->fetch_assoc();

        $qty_in_hand = $qty_data["qty_hand"];

        //$qty_in_hand = (float)$qty_data["qty_hand"];
        //$quantity = (float)$quantity;

        $new_qty = $quantity + $qty_in_hand;

        Database::iud("UPDATE `fth_stock` 
            SET `qty_hand` = '" . $new_qty . "',
                `remarks` = '" . $remarks . "',
                `date_time` = '" . $date . "',
                `fth_grn_id` = '" . $grn_id . "'
            WHERE `fth_inventory_item_code` = '" . $item_code . "'
            ORDER BY `date_time` DESC
            LIMIT 1");

        echo ("success");
    } else {

        echo ("Item with the same item code already exists.");
    }
}
