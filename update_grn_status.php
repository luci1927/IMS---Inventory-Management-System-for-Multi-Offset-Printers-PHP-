
<?php

require "connection.php";

if(isset($_GET["id"])){

    $u_id = $_GET["id"];

    $grn_rs = Database::search("SELECT * FROM `grn_type` WHERE `id`='".$u_id."'");
    $grn_num = $grn_rs->num_rows;

    if($grn_num == 1){

        $grn_data = $grn_rs->fetch_assoc();

        if($grn_data["status_status_id"] == 1){
            Database::iud("UPDATE `grn_type` SET `status_status_id`= '2' WHERE `id`='".$u_id."'");
            echo ("inactive");
        }else if($grn_data["status_status_id"] == 2){
            Database::iud("UPDATE `grn_type` SET `status_status_id`= '1' WHERE `id`='".$u_id."'");
            echo ("active");
        }

    }else{
        echo ("Cannot find the grn. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>