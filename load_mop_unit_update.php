<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT * FROM `mop_inventory` WHERE `item_code`='" . $item_id . "'");
    $item_num = $item_rs->num_rows;

    for ($x = 0; $x < $item_num; $x++) { 

        $item_data = $item_rs->fetch_assoc();

        $unit_rs = Database::search("SELECT * FROM `units` WHERE `id`='" . $item_data["units_id"] . "'");

        $unit_data = $unit_rs->fetch_assoc();

?>

        <option value="<?php echo $unit_data["id"]; ?>"><?php echo $unit_data["name"]; ?></option>

<?php

    }
}

?>