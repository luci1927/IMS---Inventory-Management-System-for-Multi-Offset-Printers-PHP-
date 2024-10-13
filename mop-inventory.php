<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <style>
        .selectpicker {
            width: 100%;

        }

        .fixed-date-time {
            position: fixed;
            top: 60px; 
            left: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px; 
            z-index: 9999; 
        }

        @media (max-width: 768px) {  
    .fixed-date-time {
        display: none; 
    }
}
    </style>
</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="mop-index.php">Inventory System | Multi Offset Printers</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mop-index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory-out.php">Inventory Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-reports.php">Stock Update reports</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="mop-issue-reports.php">Issue Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="signout();" style="color: red;" href="index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div id="dateTimeDisplay" class="fixed-date-time"></div>

    <!-- Main Content -->
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Manage Inventory</h2>
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter1">
                    Add Stock
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter2">
                    Add New Item
                </button>
            </div>

        </div>

        <!-- Modal1 -->
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="item3" >Item</label>
                                <div >
                                    <select class="selectpicker" data-live-search="true" id="item3" onchange="load_mop_unit_update(); load_mop_grn_type_update();" title="Choose an Item">
                                        <?php

                                        require "connection.php";
                                        $item3_rs = Database::search("SELECT * FROM `mop_inventory`");
                                        $item3_num = $item3_rs->num_rows;


                                        for ($x = 0; $x < $item3_num; $x++) {
                                            $item3_data = $item3_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $item3_data['item_code']; ?>">
                                                <?php echo $item3_data['description']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unit3">Unit</label>
                                <select class="form-control" id="unit3">
                                    <option value="0" disabled selected>Select a unit</option>
                                    <?php



                                    $unit3_rs = Database::search("SELECT * FROM `units`");
                                    $unit3_num = $unit3_rs->num_rows;

                                    for ($x = 0; $x < $unit3_num; $x++) {
                                        $unit3_data = $unit3_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $unit3_data["id"]; ?>"><?php echo $unit3_data["name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity"
                                    step="0.001" min="0" max="10000" required />
                            </div>
                            <div class="form-group">
                                <label for="grn2">GRN No</label>
                                <input type="text" class="form-control" id="grn2"
                                    placeholder="GRN No">
                            </div>
                            <div class="form-group">
                                <label for="grn_type3">GRN Type</label>
                                <select class="form-control" id="grn_type3">
                                    <option value="0" disabled selected>Select GRN Type</option>
                                    <?php

                                    $grn_type2_rs = Database::search("SELECT * FROM `grn_type`");
                                    $grn_type2_num = $grn_type1_rs->num_rows;

                                    for ($x = 0; $x < $grn_type2_num; $x++) {
                                        $grn_type2_data = $grn_type2_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $grn_type2_data["id"]; ?>"><?php echo $grn_type2_data["name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier2">Supplier</label>
                                <select class="form-control" id="supplier2">
                                    <option value="0" disabled selected>Select supplier</option>
                                    <?php

                                    $supplier2_rs = Database::search("SELECT * FROM `supplier`");
                                    $supplier2_num = $supplier2_rs->num_rows;

                                    for ($x = 0; $x < $supplier2_num; $x++) {
                                        $supplier2_data = $supplier2_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $supplier2_data["id"]; ?>"><?php echo $supplier2_data["name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="mop_new_stock();">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal1 -->

        <!-- Modal2 -->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="item_code">Item Code</label>
                                <input type="text" class="form-control" id="item_code"
                                    placeholder="Item Code">
                            </div>
                            <div class="form-group">
                                <label for="description">Item Description</label>
                                <input type="text" class="form-control" id="description"
                                    placeholder="Item Description">
                            </div>
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <select class="form-control" id="unit">
                                    <option value="0" disabled selected>Select a unit</option>
                                    <?php

                                    $unit_rs = Database::search("SELECT * FROM `units`");
                                    $unit_num = $unit_rs->num_rows;

                                    for ($x = 0; $x < $unit_num; $x++) {
                                        $unit_data = $unit_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $unit_data["id"]; ?>"><?php echo $unit_data["name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity1">Quantity</label>
                                <input type="number" class="form-control" id="quantity1" placeholder="Enter quantity1"
                                    step="0.001" min="0" max="10000" required />
                            </div>
                            <div class="form-group">
                                <label for="grn1">GRN No</label>
                                <input type="text" class="form-control" id="grn1"
                                    placeholder="GRN No">
                            </div>
                            <div class="form-group">
                                <label for="grn_type1">GRN Type</label>
                                <select class="form-control" id="grn_type1">
                                    <option value="0" disabled selected>Select GRN Type</option>
                                    <?php

                                    $grn_type1_rs = Database::search("SELECT * FROM `grn_type`");
                                    $grn_type1_num = $grn_type1_rs->num_rows;

                                    for ($x = 0; $x < $grn_type1_num; $x++) {
                                        $grn_type1_data = $grn_type1_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $grn_type1_data["id"]; ?>"><?php echo $grn_type1_data["name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier1">Supplier</label>
                                <select class="form-control" id="supplier1">
                                    <option value="0" disabled selected>Select supplier</option>
                                    <?php

                                    $supplier1_rs = Database::search("SELECT * FROM `supplier`");
                                    $supplier1_num = $supplier1_rs->num_rows;

                                    for ($x = 0; $x < $supplier1_num; $x++) {
                                        $supplier1_data = $supplier1_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo $supplier1_data["id"]; ?>"><?php echo $supplier1_data["name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="remarks1">Remarks</label>
                                <textarea class="form-control" id="remarks1" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="mop_new_item();">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal2 -->

        <form id="inventoryForm">
            <div class="form-group row mt-3">
                <label for="item" class="col-sm-2 col-form-label">Item</label>
                <div class="col-sm-10">
                    <select class="selectpicker" data-live-search="true" id="item" onchange="load_mop_unit();" title="Choose an Item">
                        <?php

                        $item_rs = Database::search("SELECT * FROM `mop_inventory`");
                        $item_num = $item_rs->num_rows;


                        for ($x = 0; $x < $item_num; $x++) {
                            $item_data = $item_rs->fetch_assoc();
                        ?>
                            <option value="<?php echo $item_data['item_code']; ?>">
                                <?php echo $item_data['description']; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="quantity2" class="col-sm-2 col-form-label">Quantity</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="quantity2" placeholder="Enter quantity" step="0.001"
                        min="0" max="10000" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="unit2" class="col-sm-2 col-form-label">Unit</label>
                <div class="col-sm-10">
                    <select class="form-control" id="unit2">
                        <option value="0" disabled selected>Select a unit</option>
                        <?php

                        $unit_rs = Database::search("SELECT * FROM `units`");
                        $unit_num = $unit_rs->num_rows;

                        for ($x = 0; $x < $unit_num; $x++) {
                            $unit_data = $unit_rs->fetch_assoc();

                        ?>

                            <option value="<?php echo $unit_data["id"]; ?>"><?php echo $unit_data["name"]; ?></option>

                        <?php
                        }

                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="remarks2" class="col-sm-2 col-form-label">Remarks</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="remarks2" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block" onclick="mop_update_qty();">
                Update Quantity
            </button>


        </form>

        <h3 class="mt-5">Inventory List</h3>
        <table class="table table-striped table-hover mt-3" id="inventoryTable">
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
                <?php

                $query = "SELECT mop_inventory.item_code AS item_code, 
                    mop_inventory.`description` AS descr, 
                    mop_stock.qty_system AS qsystem, 
                    mop_stock.qty_hand AS qhand, 
                    units.`name` AS unit_name, 
                    mop_stock.remarks AS remarks 
                FROM mop_inventory
                INNER JOIN mop_stock ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                INNER JOIN units ON mop_inventory.units_id = units.id
                INNER JOIN (
                    SELECT mop_stock.mop_inventory_item_code, MAX(id) AS latest_id
                    FROM mop_stock
                    GROUP BY mop_inventory_item_code
                ) latest_stock ON mop_stock.id = latest_stock.latest_id
                WHERE mop_inventory.status_status_id = '1';";

                $item_table_rs = Database::search($query);
                $item_table_num = $item_table_rs->num_rows;


                for ($x = 0; $x < $item_table_num; $x++) {
                    $item_table_data = $item_table_rs->fetch_assoc();

                ?>
                    <tr>
                        <td><?php echo $item_table_data['item_code']; ?></td>
                        <td><?php echo $item_table_data['descr']; ?></td>
                        <td><?php echo $item_table_data['qsystem']; ?></td>
                        <td><?php echo $item_table_data['qhand']; ?></td>
                        <td><?php echo $item_table_data['unit_name']; ?></td>
                        <td><?php echo $item_table_data['remarks']; ?></td>
                    </tr>

                <?php

                }
                ?>
            </tbody>
        </table>
    </main>

    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        function updateDateTime() {
            const dateTimeDisplay = document.getElementById('dateTimeDisplay');
            const now = new Date();

            // Format date to 'Today is YYYY Month DD'
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);

            // Format time to 'HH:MM:SS'
            const formattedTime = now.toLocaleTimeString('en-US', {
                hour12: false
            });

            dateTimeDisplay.innerHTML = `Today is ${formattedDate} - ${formattedTime}`;
        }

        // Update date and time every second
        setInterval(updateDateTime, 1000);

        // Initial call to display the date and time immediately
        updateDateTime();
    </script>
</body>

</html>