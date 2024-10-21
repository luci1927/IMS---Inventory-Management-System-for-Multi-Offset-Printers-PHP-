<?php

require "connection.php";

if (isset($_GET["i"])) {

    $item_id = $_GET["i"];

    $item_rs = Database::search("SELECT mop_inventory.item_code AS item_code, 
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
            WHERE mop_inventory.status_status_id = '1' AND mop_inventory.mop_item_group_code = '" . $item_id . "' 
            ORDER BY mop_stock.date_time DESC;");
    $item_num = $item_rs->num_rows;


?>

    <thead>
        <tr>
            <th>#</th>
            <th scope="col">Issue No</th>
            <th scope="col">Issue Date/Time</th>
            <th scope="col">Item Code</th>
            <th scope="col">Item Description</th>
            <th scope="col">Issue Qty</th>
            <th scope="col">Qty Remaining</th>
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
                <td><?php echo $item_data['issue_number']; ?></td>
                <td><?php echo $item_data['issue_date']; ?></td>
                <td><?php echo $item_data['item_code']; ?></td>
                <td><?php echo $item_data['descr']; ?></td>
                <td><?php echo $item_data['issue_qty']; ?></td>
                <td><?php echo $item_data['qhand']; ?></td>
                <td><?php echo $item_data['unit_name']; ?></td>
                <td><?php echo $item_data['remarks']; ?></td>
            </tr>
        </tbody>

<?php

    }
}

?>