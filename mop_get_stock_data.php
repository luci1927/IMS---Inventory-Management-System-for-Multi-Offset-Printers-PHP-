<?php

require "connection2.php";

// Prepare the SQL statement
$sql = "SELECT 
    mop_inventory.description AS item_name, 
    mop_stock.qty_hand AS stock_quantity 
FROM 
    mop_inventory 
INNER JOIN 
    mop_stock 
ON 
    mop_stock.mop_inventory_item_code = mop_inventory.item_code 
WHERE 
    mop_inventory.status_status_id = ? 
AND 
    mop_stock.date_time = (
        SELECT MAX(sub_stock.date_time) 
        FROM mop_stock sub_stock 
        WHERE sub_stock.mop_inventory_item_code = mop_inventory.item_code
    )
ORDER BY 
    mop_stock.date_time DESC;";

// Prepare statement
$stmt = $conn->prepare($sql);
$status_id = 1;
$stmt->bind_param("i", $status_id);

// Execute statement
$stmt->execute();
$result = $stmt->get_result();

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Set the content type to JSON and output the data
header('Content-Type: application/json');
echo json_encode($data);

// Close the statement and connection
$stmt->close();
$conn->close();
