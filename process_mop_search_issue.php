<?php require "connection.php";

if (isset($_POST['date']) && !empty($_POST['date'])) {
    $selectedDate = $_POST['date'];

    error_log("Received date: " . $selectedDate);

    $query = "SELECT mop_inventory.item_code AS item_code, 
            mop_inventory.`description` AS descr, 
            mop_stock.qty_hand AS qhand, 
            units.`name` AS unit_name, 
            mop_issuing.issue_no AS issue_number, 
            mop_issuing.qty AS issue_qty, 
            mop_issuing.date_time AS issue_date, 
            mop_stock.remarks AS remarks
            FROM mop_stock
            INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
            INNER JOIN units ON mop_inventory.units_id = units.id
            INNER JOIN mop_issuing ON mop_issuing.mop_stock_id = mop_stock.id 
            WHERE mop_inventory.status_status_id = '1' AND DATE(mop_issuing.date_time) = '$selectedDate'
            ORDER BY mop_stock.date_time DESC;";

    $item_table_rs = Database::search($query);
    $item_table_num = $item_table_rs->num_rows;

    if ($item_table_num > 0) {
        for ($x = 0; $x < $item_table_num; $x++) {
            $item_table_data = $item_table_rs->fetch_assoc();
            echo "<tr>
                    <td>" . ($x + 1) . "</td>
                    <td>{$item_table_data['issue_number']}</td>
                    <td>{$item_table_data['issue_date']}</td>
                    <td>{$item_table_data['item_code']}</td>
                    <td>{$item_table_data['descr']}</td>
                    <td>{$item_table_data['issue_qty']}</td>
                    <td>{$item_table_data['qhand']}</td>
                    <td>{$item_table_data['unit_name']}</td>
                    <td>{$item_table_data['remarks']}</td>
                  </tr>";

        }
    } else {
        echo "<tr><td colspan='7'>No data available for the selected date.</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>Please select a valid date.</td></tr>";
}
