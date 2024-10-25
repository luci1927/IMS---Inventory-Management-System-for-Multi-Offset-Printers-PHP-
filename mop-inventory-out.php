<?php
include 'mop_session_check.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                        <a class="nav-link" href="mop-other.php">Others</a>
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
                    <select class="selectpicker form-control" data-live-search="true" id="item" onchange=" load_mop_out_table();" title="Choose an Item">
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
                    <input type="text" class="form-control" id="issue_no" placeholder="Enter Issue Number" required />
                </div>
            </div>

            <div class="form-group row">
                <label for="remarks2" class="col-sm-2 col-form-label">Remarks</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="remarks2" rows="3"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block" onclick="mop_inventory_out();">
                Issue Item
            </button>


        </form>

        <h3 class="mt-5">Inventory List</h3>
        <table class="table table-hover table-hover mt-3" id="inventoryTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Item Group</th>
                    <th>Qty in System</th>
                    <th>Qty on Hand</th>
                    <th>Unit</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <?php

            $results_per_page = 10;

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            if ($page <= 0) $page = 1;

            $offset = ($page - 1) * $results_per_page;

            $query_total = "SELECT COUNT(*) AS total FROM mop_inventory
                INNER JOIN mop_stock ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                INNER JOIN units ON mop_inventory.units_id = units.id
                INNER JOIN (
                    SELECT mop_stock.mop_inventory_item_code, MAX(id) AS latest_id
                    FROM mop_stock
                    GROUP BY mop_inventory_item_code
                ) latest_stock ON mop_stock.id = latest_stock.latest_id
                WHERE mop_inventory.status_status_id = '1';";
            $total_result = Database::search($query_total);
            $total_row = $total_result->fetch_assoc();
            $total_records = $total_row['total'];

            $total_pages = ceil($total_records / $results_per_page);

            $query = "SELECT mop_inventory.item_code AS item_code, 
                    mop_inventory.`description` AS descr, 
                    mop_inventory.`mop_item_group_code` AS item_grp, 
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
                WHERE mop_inventory.status_status_id = '1'
                LIMIT $results_per_page OFFSET $offset;";

            $item_table_rs = Database::search($query);
            $item_table_num = $item_table_rs->num_rows;
            ?>

            <tbody>
                <?php
                for ($x = 0; $x < $item_table_num; $x++) {
                    $item_table_data = $item_table_rs->fetch_assoc();
                ?>
                    <tr>
                        <th scope="row"><?php echo $x + 1; ?></th>
                        <td><?php echo $item_table_data['item_code']; ?></td>
                        <td><?php echo $item_table_data['descr']; ?></td>
                        <td><?php echo $item_table_data['item_grp']; ?></td>
                        <td><?php echo $item_table_data['qsystem']; ?></td>
                        <td><?php echo $item_table_data['qhand']; ?></td>
                        <td><?php echo $item_table_data['unit_name']; ?></td>
                        <td><?php echo $item_table_data['remarks']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

        <nav>
            <ul class="pagination justify-content-center mt-4">
                <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>

                <?php if ($page < $total_pages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

    </main>

    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        function updateDateTime() {
            const dateTimeDisplay = document.getElementById('dateTimeDisplay');
            const now = new Date();

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);

            const formattedTime = now.toLocaleTimeString('en-US', {
                hour12: false
            });

            dateTimeDisplay.innerHTML = `Today is ${formattedDate} - ${formattedTime}`;
        }

        setInterval(updateDateTime, 1000);

        updateDateTime();
    </script>
</body>

</html>