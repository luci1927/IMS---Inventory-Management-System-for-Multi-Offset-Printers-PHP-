<?php

require "connection.php";

$item_code = $_POST["i"];
$description = $_POST["d"];
$unit = $_POST["u"];
$quantity = $_POST["q"];
$remarks = $_POST["re"];

if (empty($item_code)) {
    echo ("Please enter item code!");
} else if (strlen($item_code) > 20) {
    echo ("Item code must have LESS THAN 20 characters!");
}else if (empty($description)) {
    echo ("Please enter a description!");
} else if (strlen($description) > 100) {
    echo ("Description must have LESS THAN 100 characters!");
}else if($unit == "0"){
    echo("Please select a unit measurement!");
}else{

$rs = Database::search("SELECT * FROM `mop_inventory` WHERE `mop_i_item_code`='".$item_code."'");
$n = $rs->num_rows;

if($n > 0){
    echo ("Item with the same item code already exists.");
}else{

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `mop_inventory` 
    (`mop_i_item_code`,`mop_i_description`,`mop_i_qty_system`,`mop_measurements_mop_m_id`,`mop_i_remarks`,`mop_i_datetime`,`status_status_id`)
    VALUES ('".$item_code."','".$description."','".$quantity."','".$unit."','".$remarks."',
    '".$date."','1')");

    echo ("success");

}
    
}

?>