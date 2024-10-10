<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <style>
        .fixed-date-time {
            position: fixed;
            top: 60px;
            /* Distance from the top (adjust as necessary) */
            right: 20px;
            /* Distance from the right */
            background-color: rgba(255, 255, 255, 0.8);
            /* Slightly transparent background */
            padding: 10px 15px;
            /* Padding around the text */
            border-radius: 5px;
            /* Rounded corners */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            /* Subtle shadow */
            font-size: 18px;
            /* Increased font size */
            z-index: 1000;
            /* Make sure it is above other content */
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
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="dateTimeDisplay" class="fixed-date-time"></div>


    <!-- Main Content -->
    <main class="container mt-5">
        <h2>Daily Report Updates</h2>
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
                    <button type="button" id="searchButton" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </div>
            </div>

            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fa-solid fa-file-export"></i> Export
            </button>

        </div>

        <!-- Date Picker -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" id="exportCSVButton" class="btn btn-success"><i class="fa-solid fa-file-csv"></i> Export
                            Csv</button>
                        <button type="button" id="exportPDFButton" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Export
                            Pdf</button>
                        <button type="button" id="exportTXTButton" class="btn btn-secondary"><i class="fa-solid fa-file"></i> Export
                            txt</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->



        <!-- Report Table -->
        <table class="table table-bordered table-hover mt-3" id="reportsTable">
            <thead>
                <tr>
                    <th scope="col">Date/Time Updated</th>
                    <th scope="col">Item Code</th>
                    <th scope="col">Item Description</th>
                    <th scope="col">Qty in System</th>
                    <th scope="col">Qty on Hand</th>
                    <th scope="col">Diff</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php

                require "connection.php";

                $query = "SELECT mop_inventory.item_code AS item_code, 
                    mop_stock.date_time AS datetime,
                    mop_inventory.`description` AS descr, 
                    mop_stock.qty_system AS qsystem, 
                    mop_stock.qty_hand AS qhand, 
                    (mop_stock.qty_system - mop_stock.qty_hand) AS diff, 
                    units.`name` AS unit_name, 
                    mop_stock.remarks AS remarks
                FROM mop_stock
                INNER JOIN mop_inventory ON mop_inventory.item_code = mop_stock.mop_inventory_item_code
                INNER JOIN units ON mop_inventory.units_id = units.id
                WHERE mop_inventory.status_status_id = '1'  
                ORDER BY mop_stock.date_time DESC;";

                $item_table_rs = Database::search($query);
                $item_table_num = $item_table_rs->num_rows;


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
                        <td><?php echo $item_table_data['remarks']; ?></td>
                    </tr>

                <?php

                }

                ?>
            </tbody>
        </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>



    <script src="assets/js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                endDate: new Date() // Disable future dates                
            });
        });


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