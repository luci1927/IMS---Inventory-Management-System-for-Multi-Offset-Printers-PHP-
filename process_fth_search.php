<?php
require "connection.php";

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $selectedDate = $_POST['date'];

    error_log("Received date: " . $selectedDate);


    $query = "SELECT fth_inventory.item_code AS item_code, 
                    fth_stock.date_time AS datetime,
                    fth_inventory.`description` AS descr, 
                    fth_stock.qty_system AS qsystem, 
                    fth_stock.qty_hand AS qhand, 
                    (fth_stock.qty_system - fth_stock.qty_hand) AS diff, 
                    units.`name` AS unit_name, 
                    fth_grn.grn_no AS grn_number,
                    fth_grn.date_time AS grn_date,
                    fth_stock.remarks AS remarks
                    FROM fth_stock
                    INNER JOIN fth_inventory ON fth_inventory.item_code = fth_stock.fth_inventory_item_code
                    INNER JOIN units ON fth_inventory.units_id = units.id 
                    INNER JOIN fth_grn ON fth_stock.fth_grn_id = fth_grn.id 
                    WHERE fth_inventory.status_status_id = '1' AND DATE(fth_stock.date_time) = '$selectedDate' 
                    ORDER BY fth_stock.date_time DESC;";

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
?>
