<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT mop_inventory.item_code AS item_code, 
                    mop_inventory.`description` AS descr, 
                    mop_grn.qty AS grn_qty,
                    units.`name` AS unit_name, 
                    mop_grn.grn_no AS grn_number,
                    mop_grn.date_time AS grn_date,
                    mop_stock.remarks AS remarks
                    FROM mop_grn
                    INNER JOIN mop_stock ON mop_grn.id = mop_stock.id 
                    INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                    INNER JOIN units ON mop_inventory.units_id = units.id
                    WHERE mop_inventory.status_status_id = '1' AND mop_inventory.mop_item_group_code = '" . $item_id . "' 
                    ORDER BY grn_date DESC;");
                    
    $item_num = $item_rs->num_rows;


?>

    <thead>
        <tr>
            <th>#</th>
            <th scope="col">GRN No</th>
            <th scope="col">GRN Date</th>
            <th scope="col">Item Code</th>
            <th scope="col">Item Description</th>
            <th scope="col">GRN Quantity</th>
            <th scope="col">Unit</th>
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
                <td><?php echo $item_data['grn_number']; ?></td>
                <td><?php echo $item_data['grn_date']; ?></td>
                <td><?php echo $item_data['item_code']; ?></td>
                <td><?php echo $item_data['descr']; ?></td>
                <td><?php echo $item_data['grn_qty']; ?></td>
                <td><?php echo $item_data['unit_name']; ?></td>
                <td><?php echo $item_data['remarks']; ?></td>
            </tr>
        </tbody>

<?php

    }
}

?>