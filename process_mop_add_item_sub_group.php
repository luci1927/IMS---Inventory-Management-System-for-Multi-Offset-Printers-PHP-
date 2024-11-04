<?php

require "connection.php";

$item_group_code = $_POST["g"];
$item_sub_group_code = $_POST["c"];
$item_sub_group_name = $_POST["n"];

if ($item_group_code == "0") {
    echo ("Please select a Item group!");
} else if (empty($item_sub_group_code)) {
    echo ("Please enter item sub group code.");
} else if (empty($item_sub_group_name)) {
    echo ("Please enter item sub group name.");
} else {

    $rs = Database::search("SELECT * FROM `mop_item_sub_group` WHERE `name`='" . $item_sub_group_name . "' OR `sub_code`='" . $item_sub_group_code . "'");
    $n = $rs->num_rows;

    if ($n >= 1) {
        echo ("Item sub code or Item sub name already exists.");
    } else {
        try {
            // Start a transaction
            Database::iud("START TRANSACTION");

            // First insert
            Database::iud("INSERT INTO `mop_item_sub_group` 
                (`sub_code`, `name`, `mop_item_group_code`)
                VALUES ('" . $item_sub_group_code . "', '" . $item_sub_group_name . "', '" . $item_group_code . "')");

            // Second insert
            Database::iud("INSERT INTO `mop_item_group_has_mop_item_sub_group` 
                (`mop_item_group_code`, `mop_item_sub_group_sub_code`) 
                VALUES ('" . $item_group_code . "', '" . $item_sub_group_code . "')");

            // Commit the transaction
            Database::iud("COMMIT");

            echo ("success");
        } catch (Exception $e) {
            // Rollback the transaction if something failed
            Database::iud("ROLLBACK");
            echo ("Error: " . $e->getMessage());
        }
    }
}
?>
