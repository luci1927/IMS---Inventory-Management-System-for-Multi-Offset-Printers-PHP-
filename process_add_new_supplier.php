<?php

require "connection.php";

$supplier_name = $_POST["s"];
$company_name = $_POST["c"];
$mobile = $_POST["m"];

if (empty($supplier_name)) {
    echo ("Please enter supplier name!");
} elseif (preg_match('/\d/', $supplier_name)) {
    echo ("Supplier name cannot contain numbers!");
} else if (empty($company_name)) {
    echo ("Please enter company name!");
} else if (empty($mobile)) {
    echo ("Please enter your Mobile Number!");
} else if (strlen($mobile) != 10) {
    echo ("Mobile Number must contain 10 characters");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Mobile Number!");
} else {

    Database::iud("INSERT INTO `supplier` 
    (`name`,`contact`,`sup_name`,`status_status_id`)
    VALUES ('" . $company_name . "','" . $mobile . "','" . $supplier_name . "','1')");

    echo ("success");
}
