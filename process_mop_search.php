<?php require "connection.php";

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $selectedDate = $_POST['date'];

    error_log("Received date: " . $selectedDate);

    $query = "SELECT mop_inventory.item_code AS item_code, 
                    mop_stock.date_time AS datetime,
                    mop_inventory.`description` AS descr, 
                    mop_stock.qty_system AS qsystem, 
                    mop_stock.qty_hand AS qhand, 
                    (mop_stock.qty_system - mop_stock.qty_hand) AS diff, 
                    units.`name` AS unit_name, 
                    mop_grn.grn_no AS grn_number,
                    mop_grn.date_time AS grn_date,
                    mop_stock.remarks AS remarks
                    FROM mop_stock
                    INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                    INNER JOIN units ON mop_inventory.units_id = units.id 
                    INNER JOIN mop_grn ON mop_stock.mop_grn_id = mop_grn.id 
                    WHERE mop_inventory.status_status_id = '1' AND DATE(mop_stock.date_time) = '$selectedDate' 
                    ORDER BY mop_stock.date_time DESC;";

    $item_table_rs = Database::search($query);
    $item_table_num = $item_table_rs->num_rows;

    if ($item_table_num > 0) {
        for ($x = 0; $x < $item_table_num; $x++) {
            $item_table_data = $item_table_rs->fetch_assoc();
            echo "<tr>
                    <td>{$item_table_data['datetime']}</td>
                    <td>{$item_table_data['item_code']}</td>
                    <td>{$item_table_data['descr']}</td>
                    <td>{$item_table_data['qsystem']}</td>
                    <td>{$item_table_data['qhand']}</td>
                    <td>{$item_table_data['diff']}</td>
                    <td>{$item_table_data['unit_name']}</td>
                    <td>{$item_table_data['grn_number']}</td>
                    <td>{$item_table_data['grn_date']}</td>
                    <td>{$item_table_data['remarks']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data available for the selected date.</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>Please select a valid date.</td></tr>";
}
