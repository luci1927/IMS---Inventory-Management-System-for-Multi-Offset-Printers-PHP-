<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT * 
    FROM `fth_inventory` 
    INNER JOIN `fth_stock` 
    ON `fth_stock`.`fth_inventory_item_code` = `fth_inventory`.`item_code` 
    INNER JOIN `fth_grn` 
    ON `fth_stock`.`fth_grn_id` = `fth_grn`.`id`
    WHERE `item_code` = '".$item_id."' 
    ORDER BY `fth_stock`.`date_time` DESC 
    LIMIT 1;");
    $item_num = $item_rs->num_rows;

    for ($x = 0; $x < $item_num; $x++) {

        $item_data = $item_rs->fetch_assoc();

        $fth_grn_rs = Database::search("SELECT * FROM `grn_type` WHERE `id`='" . $item_data["grn_type_id"] . "'");

        $fth_grn_data = $fth_grn_rs->fetch_assoc();

?>

        <option value="<?php echo $fth_grn_data["id"]; ?>"><?php echo $fth_grn_data["name"]; ?></option>

<?php

    }
}

?>