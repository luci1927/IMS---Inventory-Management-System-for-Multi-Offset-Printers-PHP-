<?php

require "connection.php";

$grn_type = $_POST["g"];

if (empty($grn_type)) {
    echo ("Please enter GRN type!");
}  elseif (preg_match('/\d/', $grn_type)) {
    echo ("GRN type cannot contain numbers!");
}else {

$rs = Database::search("SELECT * FROM `grn_type` WHERE `name`='" . $grn_type . "'");
$n = $rs->num_rows;

if ($n > 1) {

    echo ("GRN type already exists.");
} else {

    Database::iud("INSERT INTO `grn_type` 
    (`name`)
    VALUES ('" . $grn_type . "')");

    echo ("success");
}
}
