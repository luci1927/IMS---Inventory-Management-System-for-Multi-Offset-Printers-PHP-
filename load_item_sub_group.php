<?php

require "connection.php";

if (isset($_GET["g"])) {

    $item_group_code = $_GET["g"];

    $item_group_rs = Database::search("SELECT * FROM `mop_item_group_has_mop_item_sub_group` WHERE `mop_item_group_code`='" . $item_group_code . "'");
    $item_group_num = $item_group_rs->num_rows;

    for ($x = 0; $x < $item_group_num; $x++) {

        $item_group_data = $item_group_rs->fetch_assoc();

        $item_group_sub_rs = Database::search("SELECT * FROM `mop_item_sub_group` WHERE `sub_code`='" . $item_group_data["mop_item_sub_group_sub_code"] . "'");

        $item_group_sub_data = $item_group_sub_rs->fetch_assoc();

?>

        <option value="<?php echo $item_group_sub_data["sub_code"]; ?>"><?php echo $item_group_sub_data["name"]; ?></option>

<?php

    }
}

?>