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
    <style>
        .date-picker-container {
            position: relative;
            display: inline-block;
        }

        #datePicker {
            padding-right: 30px;
            /* Add padding to avoid text overlap with icon */
            width: 200px;
            /* Set a specific width for the input */
        }

        .calendar-icon {
            position: absolute;
            top: 50%;
            left: 190px;
            /* Adjust the position */
            transform: translateY(-50%);
            color: #888;
            /* Icon color */
            pointer-events: none;
            /* Prevent clicks on the icon */
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="fth-index.php">Inventory System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="fth-index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fth-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="fth-reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>



    <!-- Main Content -->
    <main class="container mt-5">
        <h2>Daily Report Updates</h2>
        <p>Here you can view daily reports about your inventory activities.</p>

        <!-- Date Picker -->

        <div class="d-flex justify-content-between align-items-center">
            <div class="form-group row">
                <div class="col-sm-10">
                    <i class="fas fa-calendar-alt calendar-icon"></i>
                    <input type="text" id="datePicker" placeholder="Report Date">
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
                        <button type="button" class="btn btn-success"><i class="fa-solid fa-file-csv"></i> Export
                            Csv</button>
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Export
                            Pdf</button>
                        <button type="button" class="btn btn-secondary"><i class="fa-solid fa-file"></i> Export
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
                    <th scope="col">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2024-10-08 11:11</td>
                    <td>MS0001</td>
                    <td>Bearing 6002</td>
                    <td>10</td>
                    <td>9</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2024-10-08 11:11</td>
                    <td>MS0001</td>
                    <td>Bearing 6002</td>
                    <td>10</td>
                    <td>9</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2024-10-08 11:11</td>
                    <td>MS0001</td>
                    <td>Bearing 6002</td>
                    <td>10</td>
                    <td>9</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            flatpickr("#datePicker", {
                dateFormat: "Y-m-d", // Customize date format here
                minDate: "today",    // Optional: set minimum date to today
                // Other options can be added here
            });
        });
    </script>

</body>

</html>