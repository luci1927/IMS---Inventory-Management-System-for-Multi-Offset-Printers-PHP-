<?php

require "connection.php";

$item_code = $_POST["i"];
$quantity = $_POST["q"];
$grn_no = $_POST["g"];
$grn_type_id = $_POST["gt"];
$supplier_id = $_POST["s"];
$remarks = $_POST["re"];
$ref_no = $_POST["ref"];

if ($item_code == "") {
    echo ("Please select an item!");
} else if (empty($grn_no)) {
    echo ("Please enter GRN number!");
} else if ($grn_type_id == "0") {
    echo ("Please select a GRN type!");
} else if ($supplier_id == "0") {
    echo ("Please select a supplier!");
} else {


    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `mop_grn` 
    (`grn_no`,`date_time`,`qty`,`grn_type_id`,`supplier_id`,`ref_no`)
    VALUES ('" . $grn_no . "','" . $date . "','" . $quantity . "','" . $grn_type_id . "','" . $supplier_id . "')");

    $grn_rs = Database::search("SELECT * FROM `mop_grn` WHERE `grn_no`='" . $grn_no . "'");

    $grn_data = $grn_rs->fetch_assoc();

    $grn_id = $grn_data["id"];






    $rs = Database::search("SELECT * FROM `mop_stock` WHERE `mop_inventory_item_code`='" . $item_code . "' ORDER BY `date_time` DESC LIMIT 1");
    $n = $rs->num_rows;

    if ($n >= 1) {

        // $qty_rs = Database::search("SELECT *
        // FROM `mop_stock`
        // WHERE `mop_inventory_item_code` = '" . $item_code . "'
        // ORDER BY `date_time` DESC
        // LIMIT 1");
        $qty_data = $rs->fetch_assoc();
        $qty_in_hand = $qty_data["qty_hand"];

        $qty_in_hand = floatval($qty_data["qty_hand"]);
        $quantity = floatval($quantity);

        $new_qty = $quantity + $qty_in_hand;

        Database::iud("INSERT INTO `mop_stock` 
            (`mop_inventory_item_code`, `qty_hand`, `remarks`, `date_time`, `mop_grn_grn_no`)
            VALUES ('" . $item_code . "', '" . $new_qty . "', '" . $remarks . "', '" . $date . "', '" . $grn_id . "')");

        echo "success";
    } else {


        Database::iud("INSERT INTO `mop_stock` 
            (`mop_inventory_item_code`, `qty_system`, `qty_hand`, `remarks`, `date_time`, `mop_grn_grn_no`)
            VALUES ('" . $item_code . "', '" . $quantity . "', '" . $quantity . "', '" . $remarks . "', '" . $date . "', '" . $grn_id . "')");

        echo "success";
    }
}
