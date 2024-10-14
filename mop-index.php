<?php
include 'mop_session_check.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Inventory Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <li class="nav-item active">
                        <a class="nav-link" href="mop-index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mop-inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item">
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

    <!-- Date and Time Display -->
    <div id="dateTimeDisplay" class="fixed-date-time"></div>

    <!-- Main Content -->
    <main class="container mt-5">
        <h1 class="text-center">Welcome to the Inventory Management System</h1>
        <p class="text-center lead">Manage your inventory, track stock, and view daily reports easily.</p>

        <div class="row text-center mt-5">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        require "connection.php";
                        
                        $today_rs = Database::search("SELECT COUNT(*) AS daily_count
                        FROM mop_stock 
                        WHERE DATE(date_time) = CURDATE();");
                        $today_data = $today_rs->fetch_assoc();
                        $today_updated = $today_data['daily_count'];

                        $month_rs = Database::search("SELECT COUNT(*) AS monthly_count 
                        FROM mop_stock 
                        WHERE MONTH(date_time) = MONTH(CURDATE()) 
                        AND YEAR(date_time) = YEAR(CURDATE());");

                        $month_data = $month_rs->fetch_assoc();
                        $this_month_updated = $month_data['monthly_count'];
                        ?>

                        <h3 class="card-title">0<?php echo $today_updated; ?></h3>
                        <p class="card-text" style="font-size: large;">Updated items today</p>
                        <i class="fa-solid fa-calendar-day fa-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">0<?php echo $this_month_updated; ?></h3>
                        <p class="card-text" style="font-size: large;">Updated items this month</p>
                        <i class="fa-solid fa-calendar-week fa-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update Quantity</h5>
                        <p class="card-text">Update item quantity daily to update system stock quantity.</p>
                        <a href="mop-inventory.php" class="btn btn-success">Update Quantity</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add new Item</h5>
                        <p class="card-text">Go with following button to add new items.</p>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#exampleModalCenter">
                            Add New Item
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity"
                                    step="0.001" min="0" max="10000" required />
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" rows="3"></textarea>
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
        <!-- Modal -->

    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>

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