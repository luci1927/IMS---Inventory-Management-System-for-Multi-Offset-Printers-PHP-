<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT mop_inventory.item_code AS item_code, 
       mop_inventory.`description` AS descr, 
       mop_stock.qty_system AS qsystem, 
       mop_stock.qty_hand AS qhand, 
       units.`name` AS unit_name, 
       mop_stock.remarks AS remarks 
FROM mop_inventory
INNER JOIN mop_stock 
    ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
INNER JOIN units 
    ON mop_inventory.units_id = units.id
INNER JOIN (
    SELECT mop_inventory_item_code, MAX(id) AS latest_id
    FROM mop_stock
    GROUP BY mop_inventory_item_code
) latest_stock 
    ON mop_stock.id = latest_stock.latest_id
    AND mop_stock.mop_inventory_item_code = latest_stock.mop_inventory_item_code
WHERE mop_inventory.status_status_id = '1' AND mop_inventory.item_code = '".$item_id."';");
    $item_num = $item_rs->num_rows;

    for ($x = 0; $x < $item_num; $x++) { 

        $item_data = $item_rs->fetch_assoc();

?>

<thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Qty in System</th>
                    <th>Qty on Hand</th>
                    <th>Unit</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                    <td><?php echo $item_data['item_code']; ?></td>
                        <td><?php echo $item_data['descr']; ?></td>
                        <td><?php echo $item_data['qsystem']; ?></td>
                        <td><?php echo $item_data['qhand']; ?></td>
                        <td><?php echo $item_data['unit_name']; ?></td>
                        <td><?php echo $item_data['remarks']; ?></td>
                    </tr>
            </tbody>
        
<?php

    }
}

?>