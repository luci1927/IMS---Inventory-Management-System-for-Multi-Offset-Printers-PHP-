<?php

require "connection.php";

$unit_name = $_POST["u"];

if (empty($unit_name)) {
    echo ("Please enter unit name!");
}else {

    $rs = Database::search("SELECT * FROM `units` WHERE `name`='" . $unit_name . "'");
    $n = $rs->num_rows;

    if ($n > 1) {

        echo ("Unit already exists.");
    } else {

        Database::iud("INSERT INTO `units` 
    (`name`, `status_status_id`)
    VALUES ('" . $unit_name . "','1')");

        echo ("success");
    }
}
