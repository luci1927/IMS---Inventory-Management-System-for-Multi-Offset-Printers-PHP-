<?php

require "connection.php";

$id = $_POST["id"];
$name = $_POST["name"];
$mobile = $_POST["mobile"];
$company = $_POST["company"];


$supplier_rs = Database::search("SELECT * FROM `supplier` WHERE `id`='" . $id . "'");
if ($supplier_rs) {
    $supplier_n = $supplier_rs->num_rows;

    if ($supplier_n > 0) {

        if (empty($name)) {
            echo ("Please enter supplier name!");
        } elseif (preg_match('/\d/', $name)) {
            echo ("Supplier name cannot contain numbers!");
        } else if (empty($company)) {
            echo ("Please enter company name!");
        } else if (empty($mobile)) {
            echo ("Please enter your Mobile Number!");
        } else if (strlen($mobile) != 10) {
            echo ("Mobile Number must contain 10 characters");
        } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
            echo ("Invalid Mobile Number!");
        } else {

            Database::iud("UPDATE `supplier` SET `sup_name` = '" . $name . "', `contact`='".$mobile."', `name` = '".$company."' WHERE `id` = '" . $id . "'");
            echo ("success");
        }
    } else {
        die("No supplier found for the given item code.");
    }
} else {
    die("Error");
}
