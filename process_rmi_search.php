<?php
require "connection.php"; // Database connection

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $selectedDate = $_POST['date'];

    // Debugging: Log the received date
    error_log("Received date: " . $selectedDate); // Log to PHP error log

    // Your SQL query...
    $query = "SELECT rmi_inventory.item_code AS item_code, 
                rmi_stock.date_time AS datetime,
                rmi_inventory.`description` AS descr, 
                rmi_stock.qty_system AS qsystem, 
                rmi_stock.qty_hand AS qhand, 
                units.`name` AS unit_name, 
                rmi_stock.remarks AS remarks
            FROM rmi_stock
            INNER JOIN rmi_inventory ON rmi_inventory.item_code = rmi_stock.rmi_inventory_item_code
            INNER JOIN units ON rmi_inventory.units_id = units.id
            WHERE status_status_id = '1' AND DATE(rmi_stock.date_time) = '$selectedDate'
            ORDER BY rmi_stock.date_time DESC;";

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
