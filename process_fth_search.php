<?php
require "connection.php"; // Database connection

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $selectedDate = $_POST['date'];

    // Debugging: Log the received date
    error_log("Received date: " . $selectedDate); // Log to PHP error log

    // Your SQL query...
    $query = "SELECT fth_inventory.item_code AS item_code, 
                fth_stock.date_time AS datetime,
                fth_inventory.`description` AS descr, 
                fth_stock.qty_system AS qsystem, 
                fth_stock.qty_hand AS qhand, 
                units.`name` AS unit_name, 
                fth_stock.remarks AS remarks
            FROM fth_stock
            INNER JOIN fth_inventory ON fth_inventory.item_code = fth_stock.fth_inventory_item_code
            INNER JOIN units ON fth_inventory.units_id = units.id
            WHERE status_status_id = '1' AND DATE(fth_stock.date_time) = '$selectedDate'
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
                    <td>{$item_table_data['unit_name']}</td>
                    <td>{$item_table_data['remarks']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data available for the selected date.</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>Please select a valid date.</td></tr>"; // Handle the error for empty date
}
?>
