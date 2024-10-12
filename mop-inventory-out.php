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
            right: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            font-size: 18px;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                    <li class="nav-item ">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-inventory-out.php">Inventory Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-reports.php">Reports</a>
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
            <h2>Inventory | Issuing Process</h2>

        </div>


        <form id="inventoryForm">
            <div class="form-group row mt-3">
                <label for="item" class="col-sm-2 col-form-label">Item</label>
                <div class="col-sm-10">
                    <select class="selectpicker" data-live-search="true" id="item" onchange="load_mop_unit(); load_mop_out_table();"  title="Choose an Item">
                        <?php

                        require "connection.php";

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
                <label for="quantity2" class="col-sm-2 col-form-label">Issuing Quantity</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="quantity2" placeholder="Enter quantity" step="0.001"
                        min="0" max="10000" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="issue_no" class="col-sm-2 col-form-label">Issue No</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="issue_no" placeholder="Enter Issue Number" required />
                </div>
            </div>

            <div class="form-group row">
                <label for="remarks2" class="col-sm-2 col-form-label">Remarks</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="remarks2" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block" onclick="mop_update_qty();">
                Issue Item
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