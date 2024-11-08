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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
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

        .table-container {
            max-height: 800px;
            /* Set the max height for vertical scroll */
            overflow-y: auto;
            /* Enables vertical scrolling */
            overflow-x: auto;
            /* Enables horizontal scrolling */
        }

        @media (max-width: 768px) {
            .fixed-date-time {
                display: none;
            }
        }

        .vertical-line {
            width: 1px;
            /* Thickness */
            height: 30px;
            /* Height */
            background-color: black;
            /* Color */
            border: none;
            /* Remove default styling */
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
                    <li class="nav-item">
                        <a class="nav-link" href="mop-requests.php">Issue Request</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-other.php">Others</a>
                    </li>
                    <li class="nav-item mt-1">
                        <button id="logoutButton" onclick="confirmLogout()" class="btn btn-danger"
                            style="font-weight: bold; cursor: pointer; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-people-fill"></i>
                        </button>


                        <script>
                            function confirmLogout() {
                                if (confirm("Are you sure you want to logout?")) {
                                    signout();
                                }
                            }
                        </script>
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


        <div class="accordion" id="accordionExample">
            <div class="card shadow">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Stock Update Report
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card card-body">
                        <h2>Stock Update Report</h2>
                        <p>Here you can view daily reports about your inventory activities.</p>

                        <!-- Date Picker -->

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group row align-items-center">
                                <div class="col-auto">
                                    <?php
                                    $yesterday = date('m/d/Y', strtotime('-30 day'));
                                    $today = date('m/d/Y');

                                    $upLastMonth = DateTime::createFromFormat('m/d/Y', $yesterday)->format('Y-m-d');
                                    $upToday = DateTime::createFromFormat('m/d/Y', $today)->format('Y-m-d');

                                    ?>
                                    <input type="text" id="date_range_stock" name="daterange" value="<?php echo $yesterday . ' - ' . $today; ?>" class="form-control" />
                                </div>


                                <hr class="vertical-line" />


                                <div class="col-auto">
                                    <select class="form-control" id="item3" onchange="load_stock_update_report_table();">
                                        <option value="0" disabled selected>Select an Item Group</option>
                                        <?php

                                        require "connection.php";
                                        $item3_rs = Database::search("SELECT * FROM `mop_item_group`");
                                        $item3_num = $item3_rs->num_rows;


                                        for ($x = 0; $x < $item3_num; $x++) {
                                            $item3_data = $item3_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $item3_data['code']; ?>">
                                                <?php echo $item3_data['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <input type="text" id="stock_search" placeholder="Search" class="form-control" onkeyup="stockLiveSearch();" />
                                </div>

                            </div>


                            <div class="col-auto">
                                <button type="button" id="resetButton" class="btn btn-warning btn-sm" onclick="document.getElementById('item3').value='0'; document.getElementById('stock_search').value=''; stockLiveSearch();">
                                    <i class="fa-solid fa-arrows-rotate"></i> Reset
                                </button>

                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter1">
                                    <i class="fa-solid fa-file-export"></i> Export
                                </button>
                            </div>

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
                        <div class="table-responsive table-container mt-3">
                            <table class="table table-hover mt-3" id="reportsTable1">
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
                                        <th scope="col">GRN/Issue No</th>
                                        <th scope="col">GRN/Issue Qty</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <?php

                                $results_per_page = 100;

                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                if ($page <= 0) $page = 1;

                                $offset = ($page - 1) * $results_per_page;

                                $query_total = "SELECT COUNT(*) AS total FROM mop_stock
                                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                                INNER JOIN units ON mop_inventory.units_id = units.id
                                LEFT JOIN mop_grn ON mop_stock.mop_grn_grn_no = mop_grn.grn_no 
                                LEFT JOIN mop_issuing ON mop_issuing.issue_no = mop_stock.mop_issuing_issue_no
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
                                COALESCE(mop_stock.mop_grn_grn_no, mop_issuing.ref_no) AS GrnIssue,
                                COALESCE(mop_grn.qty, mop_issuing.qty) AS qty,
                                mop_stock.remarks AS remarks
                                FROM mop_stock
                                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                                INNER JOIN units ON mop_inventory.units_id = units.id
                                LEFT JOIN mop_grn ON mop_stock.mop_grn_grn_no = mop_grn.grn_no
                                LEFT JOIN mop_issuing ON mop_issuing.issue_no = mop_stock.mop_issuing_issue_no
                                WHERE mop_inventory.status_status_id = '1' 
                                AND DATE(mop_stock.date_time)  BETWEEN '$upLastMonth' AND '$upToday' 
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
                                            <td><?php echo $x + 1; ?></td>
                                            <td><?php echo $item_table_data['datetime']; ?></td>
                                            <td><?php echo $item_table_data['item_code']; ?></td>
                                            <td><?php echo $item_table_data['descr']; ?></td>
                                            <td><?php echo $item_table_data['qsystem']; ?></td>
                                            <td><?php echo $item_table_data['qhand']; ?></td>
                                            <td><?php echo $item_table_data['diff']; ?></td>
                                            <td><?php echo $item_table_data['unit_name']; ?></td>
                                            <td><?php echo $item_table_data['GrnIssue']; ?></td>
                                            <td><?php echo $item_table_data['qty']; ?></td>
                                            <td><?php echo nl2br(htmlspecialchars($item_table_data['remarks'])) . "<br>";  ?></td>
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
                </div>
            </div>
            <div class="card shadow mt-4">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-success collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Issue Update Report
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card card-body">
                        <h2>Issue Update Report</h2>
                        <p>Here you can view daily reports about your inventory activities.</p>

                        <!-- Date Picker -->

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group row align-items-center">
                                <div class="col-auto">

                                    <input type="text" id="date_range_issue" name="daterange" value="<?php echo $yesterday . ' - ' . $today; ?>" class="form-control" />
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <select class="form-control" data-live-search="true" id="item4" onchange="load_issue_update_report_table();">
                                        <option value="0" disabled selected>Select an Item Group</option>
                                        <?php

                                        $item4_rs = Database::search("SELECT * FROM `mop_item_group`");
                                        $item4_num = $item4_rs->num_rows;


                                        for ($x = 0; $x < $item4_num; $x++) {
                                            $item4_data = $item4_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $item4_data['code']; ?>">
                                                <?php echo $item4_data['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <input type="text" id="issue_search" placeholder="Search" class="form-control" onkeyup="issueLiveSearch();" />
                                </div>
                            </div>

                            <div class="col-auto">
                                <button type="button" id="resetButton2" class="btn btn-warning btn-sm" onclick="document.getElementById('item4').value='0'; document.getElementById('issue_search').value=''; issueLiveSearch();">
                                    <i class="fa-solid fa-arrows-rotate"></i> Reset
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter2">
                                    <i class="fa-solid fa-file-export"></i> Export
                                </button>
                            </div>




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
                        <div class="table-responsive table-container mt-3">
                            <table class="table table-hover table-hover mt-3" id="reportsTable2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Issue No</th>
                                        <th scope="col">Reference No</th>
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

                                $results_per_page2 = 100;

                                $page2 = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                if ($page2 <= 0) $page2 = 1;

                                $offset2 = ($page2 - 1) * $results_per_page2;

                                $query_total2 = "SELECT COUNT(*) AS total FROM mop_stock
                                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                                INNER JOIN units ON mop_inventory.units_id = units.id
                                INNER JOIN mop_issuing ON mop_issuing.issue_no = mop_stock.mop_issuing_issue_no
                                WHERE mop_inventory.status_status_id = '1'";
                                $total_result2 = Database::search($query_total2);
                                $total_row2 = $total_result2->fetch_assoc();
                                $total_records2 = $total_row2['total'];

                                $total_pages2 = ceil($total_records2 / $results_per_page2);

                                $query2 = "SELECT mop_inventory.item_code AS item_code, 
                                mop_inventory.`description` AS descr, 
                                mop_stock.qty_hand AS qhand, 
                                units.`name` AS unit_name, 
                                mop_stock.mop_issuing_issue_no AS issue_number, 
                                mop_issuing.ref_no AS reff_no, 
                                mop_issuing.qty AS issue_qty, 
                                mop_issuing.date_time AS issue_date, 
                                mop_stock.remarks AS remarks
                                FROM mop_stock
                                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                                INNER JOIN units ON mop_inventory.units_id = units.id
                                INNER JOIN mop_issuing ON mop_issuing.issue_no = mop_stock.mop_issuing_issue_no
                                WHERE mop_inventory.status_status_id = '1' 
                                AND DATE(mop_stock.date_time)  BETWEEN '$upLastMonth' AND '$upToday' 
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
                                            <td><?php echo $x + 1; ?></td>
                                            <td><?php echo $item_table_data2['issue_number']; ?></td>
                                            <td><?php echo $item_table_data2['reff_no']; ?></td>
                                            <td><?php echo $item_table_data2['issue_date']; ?></td>
                                            <td><?php echo $item_table_data2['item_code']; ?></td>
                                            <td><?php echo $item_table_data2['descr']; ?></td>
                                            <td><?php echo $item_table_data2['issue_qty']; ?></td>
                                            <td><?php echo $item_table_data2['qhand']; ?></td>
                                            <td><?php echo $item_table_data2['unit_name']; ?></td>
                                            <td><?php echo nl2br(htmlspecialchars($item_table_data2['remarks'])) . "<br>";  ?></td>
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
                </div>
            </div>
            <div class="card shadow mt-4">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-success collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            GRN Update Report
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card card-body">
                        <h2>GRN Reports</h2>
                        <p>Here you can view daily reports about your inventory activities.</p>

                        <!-- Date Picker -->

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group row align-items-center">
                                <div class="col-auto">
                                    <input type="text" id="date_range_grn" name="daterange" value="<?php echo $yesterday . ' - ' . $today; ?>" class="form-control" />
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <select class="form-control" data-live-search="true" id="item5" onchange="load_grn_update_report_table();">
                                        <option value="0" disabled selected>Select an Item Group</option>
                                        <?php

                                        $item5_rs = Database::search("SELECT * FROM `mop_item_group`");
                                        $item5_num = $item5_rs->num_rows;


                                        for ($x = 0; $x < $item5_num; $x++) {
                                            $item5_data = $item5_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $item5_data['code']; ?>">
                                                <?php echo $item5_data['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <input type="text" id="grn_search" placeholder="Search" class="form-control" onkeyup="grnLiveSearch();" />
                                </div>

                            </div>
                            <div class="col-auto">
                                <button type="button" id="resetButton3" class="btn btn-warning btn-sm" onclick="document.getElementById('item5').value='0'; document.getElementById('grn_search').value=''; grnLiveSearch();">
                                    <i class="fa-solid fa-arrows-rotate"></i> Reset
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter3">
                                    <i class="fa-solid fa-file-export"></i> Export
                                </button>
                            </div>



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
                        <div class="table-responsive table-container mt-3">
                            <table class="table table-hover table-hover mt-3" id="reportsTable3">
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

                                $results_per_page3 = 100;

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
                                AND DATE(mop_grn.date_time)  BETWEEN '$upLastMonth' AND '$upToday' 
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
                                            <td><?php echo $x + 1; ?></td>
                                            <td><?php echo $item_table_data3['grn_number']; ?></td>
                                            <td><?php echo $item_table_data3['grn_date']; ?></td>
                                            <td><?php echo $item_table_data3['item_code']; ?></td>
                                            <td><?php echo $item_table_data3['descr']; ?></td>
                                            <td><?php echo $item_table_data3['grn_qty']; ?></td>
                                            <td><?php echo $item_table_data3['unit_name']; ?></td>
                                            <td><?php echo nl2br(htmlspecialchars($item_table_data3['remarks'])) . "<br>";  ?></td>
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
                </div>
            </div>

            <div class="card shadow mt-4">
                <div class="card-header" id="headingFour">
                    <h2 class="mb-0">
                        <button class="btn btn-success collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Issue Request Report
                        </button>
                    </h2>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                    <div class="card card-body">
                        <h2>Issue Request Report</h2>
                        <p>Here you can view daily reports about your inventory activities.</p>

                        <!-- Date Picker -->

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group row align-items-center">
                                <div class="col-auto">
                                    <input type="text" id="date_range_issue_req" name="daterange" value="<?php echo $yesterday . ' - ' . $today; ?>" class="form-control" />
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <select class="form-control" data-live-search="true" id="item6" onchange="load_issue_req_report_table();">
                                        <option value="0" disabled selected>Select an User</option>
                                        <?php

                                        $item6_rs = Database::search("SELECT * FROM `request_user`");
                                        $item6_num = $item6_rs->num_rows;


                                        for ($x = 0; $x < $item6_num; $x++) {
                                            $item6_data = $item6_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $item6_data['email']; ?>">
                                                <?php echo $item6_data['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <hr class="vertical-line" />

                                <div class="col-auto">
                                    <input type="text" id="issue_req_search" placeholder="Search" class="form-control" onkeyup="ireqLiveSearch();" />
                                </div>

                            </div>
                            <div class="col-auto">
                                <button type="button" id="resetButton4" class="btn btn-warning btn-sm" onclick="document.getElementById('item6').value='0'; document.getElementById('issue_req_search').value=''; ireqLiveSearch();">
                                    <i class="fa-solid fa-arrows-rotate"></i> Reset
                                </button>
                            </div>
                        </div>

                        <!-- Date Picker -->

                        <!-- Report Table -->
                        <div class="table-responsive table-container mt-3">
                            <table class="table table-hover table-hover mt-3" id="reportsTable4">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Ref No</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Requsted In</th>
                                        <th scope="col">Approved In</th>
                                        <th scope="col">Requester's Name</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <?php

                                $results_per_page4 = 100;

                                $page4 = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                if ($page4 <= 0) $page = 1;

                                $offset4 = ($page4 - 1) * $results_per_page4;

                                $query_total4 = "SELECT COUNT(*) AS total
                                FROM request INNER JOIN request_status ON
                                request.request_status_id = request_status.id INNER JOIN request_user ON 
                                request.request_user_email = request_user.email 
                                WHERE DATE(request.time_requested)  BETWEEN '$upLastMonth' AND '$upToday' ";
                                $total_result4 = Database::search($query_total4);
                                $total_row4 = $total_result4->fetch_assoc();
                                $total_records4 = $total_row4['total'];

                                $total_pages4 = ceil($total_records4 / $results_per_page4);

                                $query4 = "SELECT ref_no, `description` AS descr,time_requested,time_approved, 
                                request_user.`name` AS user_name,request_status.`name` AS `status` 
                                FROM request INNER JOIN request_status ON
                                request.request_status_id = request_status.id INNER JOIN request_user ON 
                                request.request_user_email = request_user.email 
                                WHERE DATE(request.time_requested)  BETWEEN '$upLastMonth' AND '$upToday' 
                                ORDER BY time_requested DESC
                                LIMIT $results_per_page4 OFFSET $offset4";

                                $item_table_rs4 = Database::search($query4);
                                $item_table_num4 = $item_table_rs4->num_rows;
                                ?>



                                <tbody>
                                    <?php
                                    for ($x = 0; $x < $item_table_num4; $x++) {
                                        $item_table_data4 = $item_table_rs4->fetch_assoc();
                                    ?>
                                        <tr>
                                            <td><?php echo $x + 1; ?></td>
                                            <td><?php echo $item_table_data4['ref_no']; ?></td>
                                            <td><?php echo nl2br(htmlspecialchars($item_table_data4['descr'])) . "<br>"; ?></td>
                                            <td><?php echo $item_table_data4['time_requested']; ?></td>
                                            <td><?php echo $item_table_data4['time_approved']; ?></td>
                                            <td><?php echo $item_table_data4['user_name']; ?></td>
                                            <td><?php echo $item_table_data4['status']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <nav>
                                    <ul class="pagination justify-content-center mt-4">
                                        <?php for ($page4 = 1; $page4 <= $total_pages4; $page4++) { ?>
                                            <li class="page-item">
                                                <a class="page-link" href="mop-reports.php?page=<?php echo $page4; ?>">
                                                    <?php echo $page4; ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </nav>


                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </main>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            // Attach event listeners to the collapse elements
            $('#collapseOne, #collapseTwo, #collapseThree').on('show.bs.collapse', function() {
                // Close other collapses when one is opened
                $('#collapseOne, #collapseTwo, #collapseThree').not(this).collapse('hide');
            });
        });

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
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

        $(document).ready(function() {
            $('#date_range_stock').on('change', function() {
                search_mop();
            });

        });

        $(document).ready(function() {
            $('#date_range_grn').on('change', function() {
                search_mop_grn();
            });

        });

        $(document).ready(function() {
            $('#date_range_issue_req').on('change', function() {
                search_mop_issue_req();
            });

        });

        $(document).ready(function() {
            $('#date_range_issue').on('change', function() {
                search_mop_issue();
            });

        });

        $('#exportCSVButton1').click(function() {
            exportTableToCSV('reportsTable1', 'Inventory_Reports');
        });

        $('#exportCSVButton2').click(function() {
            exportTableToCSV('reportsTable2', 'Inventory_Reports');
        });

        $('#exportCSVButton3').click(function() {
            exportTableToCSV('reportsTable3', 'Inventory_Reports');
        });

        $('#exportPDFButton1').click(function() {
            exportTableToPDF('reportsTable1', 'Inventory Data Sheet');
        });

        $('#exportPDFButton2').click(function() {
            exportTableToPDF('reportsTable2', 'Inventory Data Sheet');
        });

        $('#exportPDFButton3').click(function() {
            exportTableToPDF('reportsTable3', 'Inventory Data Sheet');
        });
    </script>

</body>

</html>