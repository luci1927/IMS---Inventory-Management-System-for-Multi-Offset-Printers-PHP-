<?php
include 'mop_session_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory-out.php">Inventory Out</a>
                    </li>
                    <li class="nav-item active">
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

        <h2>Update Reports</h2>
        <p>Here you can view daily reports about your inventory activities.</p>

        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1">
                Stock Update Report
            </a>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                Issue Update Report
            </a>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                GRN Reports
            </a>
        </p>
        <div class="collapse" id="collapseExample1">
            <div class="card card-body">
                <h2>Stock Update Report</h2>
                <p>Here you can view daily reports about your inventory activities.</p>

                <!-- Date Picker -->

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group row align-items-center">
                        <div class="col-auto">
                            <div class="input-group date" id="datepicker">
                                <input type="text" id="datepicker1" class="form-control" placeholder="YYYY-MM-DD">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button type="button" id="searchButton1" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i> Search
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter1">
                        <i class="fa-solid fa-file-export"></i> Export
                    </button>

                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Export Reports</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer justify-content-center">
                                <button type="button" id="exportCSVButton1" class="btn btn-success"><i class="fa-solid fa-file-csv"></i> Export
                                    Csv</button>
                                <button type="button" id="exportPDFButton1" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Export
                                    Pdf</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->

                <!-- Report Table -->
                <table class="table table-bordered table-hover mt-3" id="reportsTable1">
                    <thead>
                        <tr>
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
                    require "connection.php";

                    $results_per_page = 20;

                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($page <= 0) $page = 1;

                    $offset = ($page - 1) * $results_per_page;

                    $query_total = "SELECT COUNT(*) AS total FROM mop_stock
                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                INNER JOIN units ON mop_inventory.units_id = units.id
                INNER JOIN mop_grn ON mop_stock.mop_grn_id = mop_grn.id
                WHERE mop_inventory.status_status_id = '1'";
                    $total_result = Database::search($query_total);
                    $total_row = $total_result->fetch_assoc();
                    $total_records = $total_row['total'];

                    $total_pages = ceil($total_records / $results_per_page);

                    $query = "SELECT mop_inventory.item_code AS item_code, 
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
                    WHERE mop_inventory.status_status_id = '1'
                    ORDER BY mop_stock.date_time DESC
                    LIMIT $results_per_page OFFSET $offset";

                    $item_table_rs = Database::search($query);
                    $item_table_num = $item_table_rs->num_rows;
                    ?>

                    <tbody>
                        <?php
                        for ($x = 0; $x < $item_table_num; $x++) {
                            $item_table_data = $item_table_rs->fetch_assoc();
                        ?>
                            <tr>
                                <td><?php echo $item_table_data['datetime']; ?></td>
                                <td><?php echo $item_table_data['item_code']; ?></td>
                                <td><?php echo $item_table_data['descr']; ?></td>
                                <td><?php echo $item_table_data['qsystem']; ?></td>
                                <td><?php echo $item_table_data['qhand']; ?></td>
                                <td><?php echo $item_table_data['diff']; ?></td>
                                <td><?php echo $item_table_data['unit_name']; ?></td>
                                <td><?php echo $item_table_data['grn_number']; ?></td>
                                <td><?php echo $item_table_data['grn_date']; ?></td>
                                <td><?php echo $item_table_data['remarks']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <nav>
                        <ul class="pagination justify-content-center mt-4">
                            <?php for ($page = 1; $page <= $total_pages; $page++) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="mop-reports.php?page=<?php echo $page; ?>">
                                        <?php echo $page; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </table>



            </div>
        </div>

        <div class="collapse" id="collapseExample2">
            <div class="card card-body">
                <h2>Issue Update Report</h2>
                <p>Here you can view daily reports about your inventory activities.</p>

                <!-- Date Picker -->

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group row align-items-center">
                        <div class="col-auto">
                            <div class="input-group date" id="datepicker">
                                <input type="text" id="datepicker2" class="form-control" placeholder="YYYY-MM-DD">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button type="button" id="searchButton2" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i> Search
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter2">
                        <i class="fa-solid fa-file-export"></i> Export
                    </button>

                </div>

                <!-- Date Picker -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Export Reports</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer justify-content-center">
                                <button type="button" id="exportCSVButton2" class="btn btn-success"><i class="fa-solid fa-file-csv"></i> Export
                                    Csv</button>
                                <button type="button" id="exportPDFButton2" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Export
                                    Pdf</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->



                <!-- Report Table -->
                <table class="table table-bordered table-hover mt-3" id="reportsTable2">
                    <thead>
                        <tr>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Description</th>
                            <th scope="col">Issue Date/Time</th>
                            <th scope="col">Issue No</th>
                            <th scope="col">Issue Qty</th>
                            <th scope="col">Qty Remaining</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>

                    <?php

                    $results_per_page2 = 20;

                    $page2 = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($page2 <= 0) $page2 = 1;

                    $offset2 = ($page2 - 1) * $results_per_page2;

                    $query_total2 = "SELECT COUNT(*) AS total FROM mop_stock
                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                INNER JOIN units ON mop_inventory.units_id = units.id
                INNER JOIN mop_issuing ON mop_issuing.mop_stock_id = mop_stock.id 
                WHERE mop_inventory.status_status_id = '1'";
                    $total_result2 = Database::search($query_total2);
                    $total_row2 = $total_result2->fetch_assoc();
                    $total_records2 = $total_row2['total'];

                    $total_pages2 = ceil($total_records2 / $results_per_page2);

                    $query2 = "SELECT mop_inventory.item_code AS item_code, 
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
            WHERE mop_inventory.status_status_id = '1'
            ORDER BY mop_stock.date_time DESC
            LIMIT $results_per_page2 OFFSET $offset2";

                    $item_table_rs2 = Database::search($query2);
                    $item_table_num2 = $item_table_rs2->num_rows;
                    ?>

                    <tbody>
                        <?php
                        for ($x = 0; $x < $item_table_num2; $x++) {
                            $item_table_data2 = $item_table_rs2->fetch_assoc();
                        ?>
                            <tr>
                                <td><?php echo $item_table_data2['item_code']; ?></td>
                                <td><?php echo $item_table_data2['descr']; ?></td>
                                <td><?php echo $item_table_data2['issue_date']; ?></td>
                                <td><?php echo $item_table_data2['issue_number']; ?></td>
                                <td><?php echo $item_table_data2['issue_qty']; ?></td>
                                <td><?php echo $item_table_data2['qhand']; ?></td>
                                <td><?php echo $item_table_data2['unit_name']; ?></td>
                                <td><?php echo $item_table_data2['remarks']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                    <nav>
                        <ul class="pagination justify-content-center mt-4">
                            <?php for ($page2 = 1; $page2 <= $total_pages2; $page2++) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="mop-reports.php?page=<?php echo $page2; ?>">
                                        <?php echo $page2; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>

                </table>



            </div>
        </div>

        <div class="collapse" id="collapseExample3">
            <div class="card card-body">
                <h2>GRN Reports</h2>
                <p>Here you can view daily reports about your inventory activities.</p>

                <!-- Date Picker -->

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group row align-items-center">
                        <div class="col-auto">
                            <div class="input-group date" id="datepicker">
                                <input type="text" id="datepicker3" class="form-control" placeholder="YYYY-MM-DD">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button type="button" id="searchButton3" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i> Search
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter3">
                        <i class="fa-solid fa-file-export"></i> Export
                    </button>

                </div>

                <!-- Date Picker -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Export Reports</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer justify-content-center">
                                <button type="button" id="exportCSVButton3" class="btn btn-success"><i class="fa-solid fa-file-csv"></i> Export
                                    Csv</button>
                                <button type="button" id="exportPDFButton3" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Export
                                    Pdf</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->



                <!-- Report Table -->
                <table class="table table-bordered table-hover mt-3" id="reportsTable3">
                    <thead>
                        <tr>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Description</th>
                            <th scope="col">GRN Quantity</th>
                            <th scope="col">Unit</th>
                            <th scope="col">GRN No</th>
                            <th scope="col">GRN Date</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>
                    <?php

                    $results_per_page3 = 20;

                    $page3 = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($page3 <= 0) $page = 1;

                    $offset3 = ($page3 - 1) * $results_per_page3;

                    $query_total3 = "SELECT COUNT(*) AS total
                            FROM mop_grn 
                            INNER JOIN mop_stock ON mop_grn.id = mop_stock.id 
                            INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                            INNER JOIN units ON mop_inventory.units_id = units.id
                            WHERE mop_inventory.status_status_id = '1'";
                    $total_result3 = Database::search($query_total3);
                    $total_row3 = $total_result3->fetch_assoc();
                    $total_records3 = $total_row3['total'];

                    $total_pages3 = ceil($total_records3 / $results_per_page3);

                    $query3 = "SELECT mop_inventory.item_code AS item_code, 
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
                    WHERE mop_inventory.status_status_id = '1'
                    ORDER BY grn_date DESC
                    LIMIT $results_per_page3 OFFSET $offset3";

                    $item_table_rs3 = Database::search($query3);
                    $item_table_num3 = $item_table_rs3->num_rows;
                    ?>



                    <tbody>
                        <?php
                        for ($x = 0; $x < $item_table_num3; $x++) {
                            $item_table_data3 = $item_table_rs3->fetch_assoc();
                        ?>
                            <tr>
                                <td><?php echo $item_table_data3['item_code']; ?></td>
                                <td><?php echo $item_table_data3['descr']; ?></td>
                                <td><?php echo $item_table_data3['grn_qty']; ?></td>
                                <td><?php echo $item_table_data3['unit_name']; ?></td>
                                <td><?php echo $item_table_data3['grn_number']; ?></td>
                                <td><?php echo $item_table_data3['grn_date']; ?></td>
                                <td><?php echo $item_table_data3['remarks']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                    <nav>
                        <ul class="pagination justify-content-center mt-4">
                            <?php for ($page3 = 1; $page3 <= $total_pages3; $page3++) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="mop-reports.php?page=<?php echo $page3; ?>">
                                        <?php echo $page3; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>


                </table>


            </div>
        </div>

        <!-- Add similar blocks for collapseExample2 and collapseExample3 -->

    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update collapse state in localStorage
            function updateCollapseState(id, state) {
                localStorage.setItem(id, state ? 'open' : 'closed');
            }

            // Function to restore collapse state from localStorage
            function restoreCollapseState() {
                $('.collapse').each(function() {
                    var id = $(this).attr('id');
                    var state = localStorage.getItem(id);

                    if (state === 'open') {
                        $(this).collapse('show');
                    } else {
                        $(this).collapse('hide');
                    }
                });
            }

            // Update collapse state when toggled
            $('.collapse').on('shown.bs.collapse', function() {
                var id = $(this).attr('id');
                updateCollapseState(id, true);
            });

            $('.collapse').on('hidden.bs.collapse', function() {
                var id = $(this).attr('id');
                updateCollapseState(id, false);
            });

            // Restore collapse state on page load
            restoreCollapseState();
        });

        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                endDate: new Date()
            });
        });

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