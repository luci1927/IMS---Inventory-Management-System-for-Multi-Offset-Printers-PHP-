<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT mop_inventory.item_code AS item_code, 
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
                    WHERE mop_inventory.status_status_id = '1' AND mop_inventory.mop_item_group_code = '" . $item_id . "' 
                    ORDER BY mop_stock.date_time DESC;");
    $item_num = $item_rs->num_rows;


?>

    <thead>
        <tr>
            <th>#</th>
            <th scope="col">Date/Time Updated</th>
            <th scope="col">Item Code</th>
            <th scope="col">Item Description</th>
            <th scope="col">Qty in System</th>
            <th scope="col">Qty on Hand</th>
            <th scope="col">Diff</th>
            <th scope="col">Unit</th>
            <th scope="col">GRN No</th>
            <th scope="col">GRN Date</th>
            <th scope="col">Remarks</th>
        </tr>
    </thead>

    <?php
    for ($x = 0; $x < $item_num; $x++) {

        $item_data = $item_rs->fetch_assoc();



    ?>


        <tbody>
            <tr>
                <th scope="row"><?php echo $x + 1; ?></th>
                <td><?php echo $item_data['datetime']; ?></td>
                <td><?php echo $item_data['item_code']; ?></td>
                <td><?php echo $item_data['descr']; ?></td>
                <td><?php echo $item_data['qsystem']; ?></td>
                <td><?php echo $item_data['qhand']; ?></td>
                <td><?php echo $item_data['diff']; ?></td>
                <td><?php echo $item_data['unit_name']; ?></td>
                <td><?php echo $item_data['grn_number']; ?></td>
                <td><?php echo $item_data['grn_date']; ?></td>
                <td><?php echo $item_data['remarks']; ?></td>
            </tr>
        </tbody>

<?php

    }
}

?>