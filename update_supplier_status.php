
<?php

require "connection.php";

if(isset($_GET["id"])){

    $u_id = $_GET["id"];

    $supplier_rs = Database::search("SELECT * FROM `supplier` WHERE `id`='".$u_id."'");
    $supplier_num = $supplier_rs->num_rows;

    if($supplier_num == 1){

        $supplier_data = $supplier_rs->fetch_assoc();

        if($supplier_data["status_status_id"] == 1){
            Database::iud("UPDATE `supplier` SET `status_status_id`= '2' WHERE `id`='".$u_id."'");
            echo ("inactive");
        }else if($supplier_data["status_status_id"] == 2){
            Database::iud("UPDATE `supplier` SET `status_status_id`= '1' WHERE `id`='".$u_id."'");
            echo ("active");
        }

    }else{
        echo ("Cannot find the supplier. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>