<?php

require "connection.php";


$conn = new mysqli($host, $user, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT 
    mop_inventory.description AS item_name, 
    mop_stock.qty_system AS stock_quantity 
FROM 
    mop_inventory 
INNER JOIN 
    mop_stock 
ON 
    mop_stock.mop_inventory_item_code = mop_inventory.item_code 
WHERE 
    mop_inventory.status_status_id = '1' 
AND 
    mop_stock.date_time = (
        SELECT MAX(sub_stock.date_time) 
        FROM mop_stock sub_stock 
        WHERE sub_stock.mop_inventory_item_code = mop_inventory.item_code
    )
ORDER BY 
    mop_stock.date_time DESC;
";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
