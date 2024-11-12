
<?php

require "connection.php";

if(isset($_GET["id"])){

    $u_id = $_GET["id"];

    $unit_rs = Database::search("SELECT * FROM `units` WHERE `id`='".$u_id."'");
    $unit_num = $unit_rs->num_rows;

    if($unit_num == 1){

        $unit_data = $unit_rs->fetch_assoc();

        if($unit_data["status_status_id"] == 1){
            Database::iud("UPDATE `units` SET `status_status_id`= '2' WHERE `id`='".$u_id."'");
            echo ("inactive");
        }else if($unit_data["status_status_id"] == 2){
            Database::iud("UPDATE `units` SET `status_status_id`= '1' WHERE `id`='".$u_id."'");
            echo ("active");
        }

    }else{
        echo ("Cannot find the unit. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>