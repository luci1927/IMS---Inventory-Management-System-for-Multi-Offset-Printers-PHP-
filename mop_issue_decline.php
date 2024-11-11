<?php

require "connection.php";

if(isset($_GET["ref_no"])){

    $ref_no = $_GET["ref_no"];

    $request_rs = Database::search("SELECT * FROM `request` WHERE `ref_no`='".$ref_no."'");
    $request_num = $request_rs->num_rows;

    if($request_num == 1){

        $request_data = $request_rs->fetch_assoc();

        if($request_data["request_status_id"] == 2){
            Database::iud("UPDATE `request` SET `request_status_id`= '4' WHERE `ref_no`='".$ref_no."'");
            echo ("declined");
        }else if($request_data["request_status_id"] != 2){
            echo ("Something went wrong. Please try again later.");
        }

    }else{
        echo ("Cannot find the Request. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>