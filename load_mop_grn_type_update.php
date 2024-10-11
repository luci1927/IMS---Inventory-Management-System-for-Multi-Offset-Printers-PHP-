<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT * 
    FROM `mop_inventory` 
    INNER JOIN `mop_stock` 
    ON `mop_stock`.`mop_inventory_item_code` = `mop_inventory`.`item_code` 
    INNER JOIN `mop_grn` 
    ON `mop_stock`.`mop_grn_id` = `mop_grn`.`id`
    WHERE `item_code` = '".$item_id."' 
    ORDER BY `mop_stock`.`date_time` DESC 
    LIMIT 1;");
    $item_num = $item_rs->num_rows;

    for ($x = 0; $x < $item_num; $x++) {

        $item_data = $item_rs->fetch_assoc();

        $mop_grn_rs = Database::search("SELECT * FROM `grn_type` WHERE `id`='" . $item_data["grn_type_id"] . "'");

        $mop_grn_data = $mop_grn_rs->fetch_assoc();

?>

        <option value="<?php echo $mop_grn_data["id"]; ?>"><?php echo $mop_grn_data["name"]; ?></option>

<?php

    }
}

?>