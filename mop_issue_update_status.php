<?php

require "connection.php";

if(isset($_GET["ref_no"])){

    $ref_no = $_GET["ref_no"];

    $request_rs = Database::search("SELECT * FROM `request` WHERE `ref_no`='".$ref_no."'");
    $request_num = $request_rs->num_rows;

    if($request_num == 1){

        $request_data = $request_rs->fetch_assoc();

        if($request_data["request_status_id"] == 2){
            Database::iud("UPDATE `request` SET `request_status_id`= '3' WHERE `ref_no`='".$ref_no."'");
            echo ("viewed");
        }else if($request_data["request_status_id"] == 3){
            Database::iud("UPDATE `request` SET `request_status_id`= '2' WHERE `ref_no`='".$ref_no."'");
            echo ("approved");
        }

    }else{
        echo ("Cannot find the Request. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>