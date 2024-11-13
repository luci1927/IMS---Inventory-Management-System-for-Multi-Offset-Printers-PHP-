
<?php

require "connection.php";

if(isset($_GET["id"])){

    $u_id = $_GET["id"];

    $item_group_rs = Database::search("SELECT * FROM `mop_item_group` WHERE `code`='".$u_id."'");
    $item_group_num = $item_group_rs->num_rows;

    if($item_group_num == 1){

        $item_group_data = $item_group_rs->fetch_assoc();

        if($item_group_data["status_status_id"] == 1){
            Database::iud("UPDATE `mop_item_group` SET `status_status_id`= '2' WHERE `code`='".$u_id."'");
            Database::iud("UPDATE `mop_item_group_has_mop_item_sub_group` SET `status_status_id`= '2' WHERE `mop_item_group_code`='".$u_id."'");
            echo ("inactive");
        }else if($item_group_data["status_status_id"] == 2){
            Database::iud("UPDATE `mop_item_group` SET `status_status_id`= '1' WHERE `code`='".$u_id."'");
            Database::iud("UPDATE `mop_item_group_has_mop_item_sub_group` SET `status_status_id`= '1' WHERE `mop_item_group_code`='".$u_id."'");
            echo ("active");
        }

    }else{
        echo ("Cannot find the item group. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>