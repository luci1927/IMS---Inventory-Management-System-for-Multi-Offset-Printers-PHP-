<?php require "connection.php";

if (isset($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $searchText = $_POST['search'];

    $startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
    $endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

    error_log("Received date range: " . $startDate . " to " . $endDate );

    $query = "SELECT mop_inventory.item_code AS item_code, 
                    mop_stock.date_time AS datetime,
                    mop_inventory.`description` AS descr, 
                    mop_stock.qty_system AS qsystem, 
                    mop_stock.qty_hand AS qhand, 
                    (mop_stock.qty_system - mop_stock.qty_hand) AS diff, 
                    units.`name` AS unit_name, 
                    COALESCE(mop_stock.mop_grn_grn_no,  mop_issuing.ref_no) AS GrnIssue,
                    COALESCE(mop_grn.qty, mop_issuing.qty) AS qty,
                    mop_stock.remarks AS remarks
                    FROM mop_stock
                    INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                    INNER JOIN units ON mop_inventory.units_id = units.id
                    LEFT JOIN mop_grn ON mop_stock.mop_grn_grn_no = mop_grn.grn_no
                    LEFT JOIN mop_issuing ON mop_issuing.issue_no = mop_stock.mop_issuing_issue_no
                    WHERE mop_inventory.status_status_id = '1'  
                    AND DATE(mop_stock.date_time) BETWEEN '$startDate' AND '$endDate'
                    AND (mop_inventory.item_code LIKE '%$searchText%' 
                         OR mop_inventory.description LIKE '%$searchText%')
                    ORDER BY mop_stock.date_time DESC;";

    $item_table_rs = Database::search($query);
    $item_table_num = $item_table_rs->num_rows;

    if ($item_table_num > 0) {
        for ($x = 0; $x < $item_table_num; $x++) {
            $item_table_data = $item_table_rs->fetch_assoc();
            echo "<tr>
                    <td>" . ($x + 1) . "</td>
                    <td>{$item_table_data['datetime']}</td>
                    <td>{$item_table_data['item_code']}</td>
                    <td>{$item_table_data['descr']}</td>
                    <td>{$item_table_data['qsystem']}</td>
                    <td>{$item_table_data['qhand']}</td>
                    <td>{$item_table_data['diff']}</td>
                    <td>{$item_table_data['unit_name']}</td>
                    <td>{$item_table_data['GrnIssue']}</td>
                    <td>{$item_table_data['qty']}</td>
                    <td>" . nl2br(htmlspecialchars($item_table_data['remarks'])) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No data available for the selected date range.</td></tr>";
    }
} else {
    echo "<tr><td colspan='11'>Please select a valid date range.</td></tr>";
}
?>
